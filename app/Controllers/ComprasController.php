<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ComprasModel;
use App\Models\ListasModel;

class ComprasController extends BaseController
{
    public function __construct()
    {
        $this->model       = new ComprasModel();
        $this->listasModel = new ListasModel();
    }

    public function index()
    {
        $data = [
            'permisoUsuario' => $this->listasModel->getPermisosMenu(),
            'cotizaciones'   => $this->model->getCotizaciones(),
            'remisiones'     => $this->model->getRemisiones(),
            'compras'        => $this->model->getCompras(),
        ];
        return view('administrador/compras', $data);
    }

    /* ── Cotizaciones ── */

    public function guardarCotizacion()
    {
        $j         = $this->request->getJSON(true);
        $proveedor = trim($j['proveedor'] ?? '');
        $items     = $j['items'] ?? [];

        if (!$proveedor || empty($items)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Proveedor e ítems son requeridos'])
                ->setStatusCode(400);
        }

        $total = array_sum(array_column($items, 'subtotal'));

        $cot = [
            'proveedor'   => $proveedor,
            'nit'         => trim($j['nit'] ?? ''),
            'fecha'       => $j['fecha'] ?? date('Y-m-d'),
            'observacion' => trim($j['observacion'] ?? ''),
            'total'       => $total,
            'usuario_id'  => session()->get('documento'),
            'estado'      => 'Pendiente',
        ];

        try {
            $id = $this->model->guardarCotizacion($cot, $items);
            return $this->response->setJSON(['status' => 'success', 'id' => $id]);
        } catch (\Throwable $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()])
                ->setStatusCode(500);
        }
    }

    public function getCotizacion(int $id)
    {
        $data = $this->model->getCotizacionConDetalle($id);
        if (empty($data)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Cotización no encontrada'])
                ->setStatusCode(404);
        }
        return $this->response->setJSON(array_merge(['status' => 'success'], $data));
    }

    public function cambiarEstadoCotizacion()
    {
        $j      = $this->request->getJSON(true);
        $id     = (int)($j['id'] ?? 0);
        $estado = $j['estado'] ?? '';
        $permitidos = ['Aprobada', 'Rechazada', 'Cancelada', 'Pendiente'];

        if (!$id || !in_array($estado, $permitidos)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Datos inválidos'])
                ->setStatusCode(400);
        }
        $this->model->actualizarEstadoCotizacion($id, $estado);
        return $this->response->setJSON(['status' => 'success']);
    }

    /* ── Remisiones ── */

    public function guardarRemision()
    {
        $j         = $this->request->getJSON(true);
        $proveedor = trim($j['proveedor'] ?? '');
        $items     = $j['items'] ?? [];

        if (!$proveedor || empty($items)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Proveedor e ítems son requeridos'])
                ->setStatusCode(400);
        }

        $rem = [
            'cotizacion_id'   => ($j['cotizacion_id'] ?? null) ?: null,
            'numero_remision' => trim($j['numero_remision'] ?? ''),
            'proveedor'       => $proveedor,
            'fecha'           => $j['fecha'] ?? date('Y-m-d'),
            'estado'          => 'Recibida',
            'observacion'     => trim($j['observacion'] ?? ''),
            'usuario_id'      => session()->get('documento'),
        ];

        try {
            $id = $this->model->guardarRemision($rem, $items);
            return $this->response->setJSON(['status' => 'success', 'id' => $id]);
        } catch (\Throwable $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()])
                ->setStatusCode(500);
        }
    }

    public function getRemision(int $id)
    {
        $data = $this->model->getRemisionConDetalle($id);
        if (empty($data)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Remisión no encontrada'])
                ->setStatusCode(404);
        }
        return $this->response->setJSON(array_merge(['status' => 'success'], $data));
    }

    /* ── PDFs Cotización / Remisión ── */

    public function pdfCotizacion(int $id)
    {
        require APPPATH . 'Libraries/fpdf/fpdf.php';

        $data = $this->model->getCotizacionConDetalle($id);
        if (empty($data)) {
            return $this->response->setStatusCode(404)->setBody('Cotización no encontrada');
        }

        $cot     = $data['cotizacion'];
        $detalle = $data['detalle'];

        $pdf = new \FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetMargins(14, 14, 14);
        $pdf->SetAutoPageBreak(true, 18);

        $W = 182; $colL = 105; $colR = $W - $colL;

        // Cabecera
        $pdf->SetFillColor(45, 102, 34); $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->Cell($colL, 10, utf8_decode('TOMFIC S.A.S'), 0, 0, 'L', true);
        $pdf->SetFillColor(74, 138, 55); $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell($colR, 10, utf8_decode('COTIZACIÓN DE COMPRA'), 0, 1, 'C', true);

        $pdf->SetFillColor(240, 247, 236); $pdf->SetTextColor(13, 36, 9);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell($colL, 6, utf8_decode('NIT: 900.XXX.XXX-X   |   Tel: (601) 000-0000'), 0, 0, 'L', true);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($colR, 6, 'No. ' . str_pad($cot->id, 8, '0', STR_PAD_LEFT), 'LR', 1, 'C', true);

        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell($colL, 6, utf8_decode('Dirección: Calle 00 # 00-00, Colombia'), 0, 0, 'L', true);
        $fecha = substr($cot->fecha ?? date('Y-m-d'), 0, 10);
        $pdf->Cell($colR, 6, 'Fecha: ' . date('d/m/Y', strtotime($fecha)), 'LRB', 1, 'C', true);

        $pdf->Ln(4);

        // Proveedor
        $pdf->SetFillColor(45, 102, 34); $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($W, 7, utf8_decode('  DATOS DEL PROVEEDOR'), 0, 1, 'L', true);

        $pdf->SetFillColor(240, 247, 236); $pdf->SetTextColor(13, 36, 9);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 6, 'Proveedor:', 0, 0, 'L', true);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(80, 6, utf8_decode($cot->proveedor), 0, 0, 'L', true);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(22, 6, 'NIT / C.C.:', 0, 0, 'L', true);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(50, 6, utf8_decode($cot->nit ?? '—'), 0, 1, 'L', true);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 6, 'Estado:', 0, 0, 'L', true);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(80, 6, utf8_decode($cot->estado ?? '—'), 0, 1, 'L', true);

        if (!empty($cot->observacion)) {
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(30, 6, utf8_decode('Observación:'), 0, 0, 'L', true);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell($W - 30, 6, utf8_decode($cot->observacion), 0, 1, 'L', true);
        }

        $pdf->Ln(4);

        // Tabla ítems
        $cW = [8, 68, 18, 18, 34, 36]; // # | desc | unidad | cant | precio | subtotal
        $pdf->SetFillColor(45, 102, 34); $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell($cW[0], 8, '#',                       1, 0, 'C', true);
        $pdf->Cell($cW[1], 8, utf8_decode('Descripción'), 1, 0, 'L', true);
        $pdf->Cell($cW[2], 8, 'Unidad',                  1, 0, 'C', true);
        $pdf->Cell($cW[3], 8, 'Cant.',                   1, 0, 'C', true);
        $pdf->Cell($cW[4], 8, 'Precio Unit.',             1, 0, 'C', true);
        $pdf->Cell($cW[5], 8, 'Subtotal',                1, 1, 'C', true);

        $pdf->SetTextColor(13, 36, 9); $pdf->SetFont('Arial', '', 8);
        $subtotal = 0; $fila = 1;
        foreach ($detalle as $item) {
            $cant   = $item->cantidad ?? 0;
            $precio = $item->precio_unitario ?? 0;
            $sub    = $item->subtotal ?? ($cant * $precio);
            $subtotal += $sub;
            $pdf->SetFillColor(...($fila % 2 !== 0 ? [255,255,255] : [240,247,236]));
            $pdf->Cell($cW[0], 7, $fila,          1, 0, 'C', true);
            $pdf->Cell($cW[1], 7, utf8_decode($item->nombre_producto ?? ''), 1, 0, 'L', true);
            $pdf->Cell($cW[2], 7, '—', 1, 0, 'C', true);
            $pdf->Cell($cW[3], 7, $cant,           1, 0, 'C', true);
            $pdf->Cell($cW[4], 7, '$' . number_format($precio, 0, ',', '.'), 1, 0, 'R', true);
            $pdf->Cell($cW[5], 7, '$' . number_format($sub,    0, ',', '.'), 1, 1, 'R', true);
            $fila++;
        }

        // Totales
        $pdf->Ln(1);
        $xR = 14 + $cW[0] + $cW[1] + $cW[2]; $aL = $cW[3]; $aV = $cW[4];
        $pdf->SetFillColor(240, 247, 236); $pdf->SetFont('Arial', '', 8);
        $pdf->SetX($xR); $pdf->Cell($aL, 6, 'Subtotal:', 'LTR', 0, 'R', true);
        $pdf->Cell($aV, 6, '$' . number_format($subtotal, 0, ',', '.'), 'LTR', 1, 'R', true);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(45, 102, 34); $pdf->SetTextColor(255, 255, 255);
        $pdf->SetX($xR); $pdf->Cell($aL, 8, 'TOTAL ESTIMADO:', 'LTBR', 0, 'R', true);
        $pdf->Cell($aV, 8, '$' . number_format($subtotal, 0, ',', '.'), 'LTBR', 1, 'R', true);

        // Pie
        $pdf->Ln(12);
        $pdf->SetTextColor(107, 114, 128); $pdf->SetDrawColor(240, 247, 236);
        $pdf->Line(14, $pdf->GetY(), 196, $pdf->GetY()); $pdf->Ln(3);
        $pdf->SetFont('Arial', 'I', 7);
        $usuario = session()->get('nombre') . ' ' . session()->get('apellido');
        $pdf->Cell($W / 2, 5, 'Generado el: ' . date('d/m/Y H:i'), 0, 0, 'L');
        $pdf->Cell($W / 2, 5, utf8_decode('Autorizado por: ' . $usuario), 0, 1, 'R');
        $pdf->Cell($W, 5, utf8_decode('Documento generado electrónicamente — TOMFIC S.A.S'), 0, 0, 'C');

        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output('I', 'cotizacion_' . str_pad($cot->id, 6, '0', STR_PAD_LEFT) . '.pdf');
    }

    public function pdfRemision(int $id)
    {
        require APPPATH . 'Libraries/fpdf/fpdf.php';

        $data = $this->model->getRemisionConDetalle($id);
        if (empty($data)) {
            return $this->response->setStatusCode(404)->setBody('Remisión no encontrada');
        }

        $rem     = $data['remision'];
        $detalle = $data['detalle'];

        $pdf = new \FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetMargins(14, 14, 14);
        $pdf->SetAutoPageBreak(true, 18);

        $W = 182; $colL = 105; $colR = $W - $colL;

        // Cabecera
        $pdf->SetFillColor(45, 102, 34); $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->Cell($colL, 10, utf8_decode('TOMFIC S.A.S'), 0, 0, 'L', true);
        $pdf->SetFillColor(74, 138, 55); $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell($colR, 10, utf8_decode('REMISIÓN DE COMPRA'), 0, 1, 'C', true);

        $pdf->SetFillColor(240, 247, 236); $pdf->SetTextColor(13, 36, 9);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell($colL, 6, utf8_decode('NIT: 900.XXX.XXX-X   |   Tel: (601) 000-0000'), 0, 0, 'L', true);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($colR, 6, 'No. ' . str_pad($rem->id, 8, '0', STR_PAD_LEFT), 'LR', 1, 'C', true);

        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell($colL, 6, utf8_decode('Dirección: Calle 00 # 00-00, Colombia'), 0, 0, 'L', true);
        $fecha = substr($rem->fecha ?? date('Y-m-d'), 0, 10);
        $pdf->Cell($colR, 6, 'Fecha: ' . date('d/m/Y', strtotime($fecha)), 'LRB', 1, 'C', true);

        $pdf->Ln(4);

        // Proveedor
        $pdf->SetFillColor(45, 102, 34); $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($W, 7, utf8_decode('  DATOS DE LA REMISIÓN'), 0, 1, 'L', true);

        $pdf->SetFillColor(240, 247, 236); $pdf->SetTextColor(13, 36, 9);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 6, 'Proveedor:', 0, 0, 'L', true);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(80, 6, utf8_decode($rem->proveedor), 0, 0, 'L', true);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(22, 6, utf8_decode('N° Remisión:'), 0, 0, 'L', true);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(50, 6, utf8_decode($rem->numero_remision ?: '—'), 0, 1, 'L', true);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 6, utf8_decode('Cot. Vinculada:'), 0, 0, 'L', true);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(80, 6, $rem->cotizacion_id ? '#' . $rem->cotizacion_id : '—', 0, 0, 'L', true);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(22, 6, 'Estado:', 0, 0, 'L', true);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(50, 6, utf8_decode($rem->estado ?? '—'), 0, 1, 'L', true);

        if (!empty($rem->observacion)) {
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(30, 6, utf8_decode('Observación:'), 0, 0, 'L', true);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell($W - 30, 6, utf8_decode($rem->observacion), 0, 1, 'L', true);
        }

        $pdf->Ln(4);

        // Tabla ítems
        $cW = [8, 60, 18, 22, 22, 52]; // # | desc | unidad | cant pedida | cant recibida | precio
        $pdf->SetFillColor(45, 102, 34); $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell($cW[0], 8, '#',                       1, 0, 'C', true);
        $pdf->Cell($cW[1], 8, utf8_decode('Descripción'), 1, 0, 'L', true);
        $pdf->Cell($cW[2], 8, 'Unidad',                  1, 0, 'C', true);
        $pdf->Cell($cW[3], 8, 'Cant. Pedida',            1, 0, 'C', true);
        $pdf->Cell($cW[4], 8, 'Cant. Recibida',          1, 0, 'C', true);
        $pdf->Cell($cW[5], 8, 'Precio Unit.',             1, 1, 'C', true);

        $pdf->SetTextColor(13, 36, 9); $pdf->SetFont('Arial', '', 8);
        $fila = 1;
        foreach ($detalle as $item) {
            $pdf->SetFillColor(...($fila % 2 !== 0 ? [255,255,255] : [240,247,236]));
            $pdf->Cell($cW[0], 7, $fila, 1, 0, 'C', true);
            $pdf->Cell($cW[1], 7, utf8_decode($item->nombre_producto ?? ''), 1, 0, 'L', true);
            $pdf->Cell($cW[2], 7, '—', 1, 0, 'C', true);
            $pdf->Cell($cW[3], 7, $item->cantidad_pedida   ?? 0, 1, 0, 'C', true);
            $pdf->Cell($cW[4], 7, $item->cantidad_recibida ?? 0, 1, 0, 'C', true);
            $pdf->Cell($cW[5], 7, '$' . number_format($item->precio_unitario ?? 0, 0, ',', '.'), 1, 1, 'R', true);
            $fila++;
        }

        // Pie
        $pdf->Ln(12);
        $pdf->SetTextColor(107, 114, 128); $pdf->SetDrawColor(240, 247, 236);
        $pdf->Line(14, $pdf->GetY(), 196, $pdf->GetY()); $pdf->Ln(3);
        $pdf->SetFont('Arial', 'I', 7);
        $usuario = session()->get('nombre') . ' ' . session()->get('apellido');
        $pdf->Cell($W / 2, 5, 'Generado el: ' . date('d/m/Y H:i'), 0, 0, 'L');
        $pdf->Cell($W / 2, 5, utf8_decode('Autorizado por: ' . $usuario), 0, 1, 'R');
        $pdf->Cell($W, 5, utf8_decode('Documento generado electrónicamente — TOMFIC S.A.S'), 0, 0, 'C');

        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output('I', 'remision_' . str_pad($rem->id, 6, '0', STR_PAD_LEFT) . '.pdf');
    }

    /* ── Compras ── */

    public function pdfCompra(int $id)
    {
        require APPPATH . 'Libraries/fpdf/fpdf.php';

        $data = $this->model->getCompraConDetalle($id);
        if (empty($data)) {
            return $this->response->setStatusCode(404)->setBody('Compra no encontrada');
        }

        $compra  = $data['compra'];
        $detalle = $data['detalle'];

        $pdf = new \FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetMargins(14, 14, 14);
        $pdf->SetAutoPageBreak(true, 18);

        $W    = 182;
        $colL = 105;
        $colR = $W - $colL;

        // ── CABECERA ──
        $pdf->SetFillColor(45, 102, 34);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->Cell($colL, 10, utf8_decode('TOMFIC S.A.S'), 0, 0, 'L', true);
        $pdf->SetFillColor(74, 138, 55);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell($colR, 10, 'ORDEN DE COMPRA', 0, 1, 'C', true);

        $pdf->SetFillColor(240, 247, 236);
        $pdf->SetTextColor(13, 36, 9);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell($colL, 6, utf8_decode('NIT: 900.XXX.XXX-X   |   Tel: (601) 000-0000'), 0, 0, 'L', true);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($colR, 6, 'No. ' . str_pad($compra->id, 8, '0', STR_PAD_LEFT), 'LR', 1, 'C', true);

        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell($colL, 6, utf8_decode('Dirección: Calle 00 # 00-00, Colombia'), 0, 0, 'L', true);
        $fecha = substr($compra->fecha ?? date('Y-m-d'), 0, 10);
        $pdf->Cell($colR, 6, 'Fecha: ' . date('d/m/Y', strtotime($fecha)), 'LRB', 1, 'C', true);

        $pdf->Ln(4);

        // ── PROVEEDOR ──
        $pdf->SetFillColor(45, 102, 34);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($W, 7, utf8_decode('  DATOS DEL PROVEEDOR'), 0, 1, 'L', true);

        $pdf->SetFillColor(240, 247, 236);
        $pdf->SetTextColor(13, 36, 9);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 6, 'Proveedor:', 0, 0, 'L', true);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(80, 6, utf8_decode($compra->proveedor), 0, 0, 'L', true);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(22, 6, 'NIT / C.C.:', 0, 0, 'L', true);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(50, 6, utf8_decode($compra->nit ?? '—'), 0, 1, 'L', true);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 6, utf8_decode('N° Factura:'), 0, 0, 'L', true);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(80, 6, utf8_decode($compra->numero_factura ?: '—'), 0, 0, 'L', true);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(22, 6, utf8_decode('Remisión:'), 0, 0, 'L', true);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(50, 6, $compra->remision_id ? '#' . $compra->remision_id : '—', 0, 1, 'L', true);

        if (!empty($compra->observacion)) {
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(30, 6, utf8_decode('Observación:'), 0, 0, 'L', true);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell($W - 30, 6, utf8_decode($compra->observacion), 0, 1, 'L', true);
        }

        $pdf->Ln(4);

        // ── TABLA ÍTEMS ──
        $cW = [8, 68, 18, 18, 34, 36]; // # | desc | unidad | cant | precio | total
        $pdf->SetFillColor(45, 102, 34);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell($cW[0], 8, '#',                        1, 0, 'C', true);
        $pdf->Cell($cW[1], 8, utf8_decode('Descripción'), 1, 0, 'L', true);
        $pdf->Cell($cW[2], 8, 'Unidad',                   1, 0, 'C', true);
        $pdf->Cell($cW[3], 8, 'Cant.',                    1, 0, 'C', true);
        $pdf->Cell($cW[4], 8, 'Precio Unit.',              1, 0, 'C', true);
        $pdf->Cell($cW[5], 8, 'Total',                    1, 1, 'C', true);

        $pdf->SetTextColor(13, 36, 9);
        $pdf->SetFont('Arial', '', 8);
        $subtotal = 0;
        $fila = 1;

        foreach ($detalle as $item) {
            $cant   = $item->cantidad        ?? 0;
            $precio = $item->precio_unitario ?? 0;
            $total  = $item->subtotal        ?? ($cant * $precio);
            $subtotal += $total;

            $impar = ($fila % 2 !== 0);
            $pdf->SetFillColor(...($impar ? [255,255,255] : [240,247,236]));
            $pdf->Cell($cW[0], 7, $fila, 1, 0, 'C', true);
            $pdf->Cell($cW[1], 7, utf8_decode($item->nombre_producto ?? ''), 1, 0, 'L', true);
            $pdf->Cell($cW[2], 7, '—',  1, 0, 'C', true);
            $pdf->Cell($cW[3], 7, $cant,  1, 0, 'C', true);
            $pdf->Cell($cW[4], 7, '$' . number_format($precio, 0, ',', '.'), 1, 0, 'R', true);
            $pdf->Cell($cW[5], 7, '$' . number_format($total,  0, ',', '.'), 1, 1, 'R', true);
            $fila++;
        }

        // ── TOTALES ──
        $pdf->Ln(1);
        $xRight = 14 + $cW[0] + $cW[1] + $cW[2] + $cW[3];
        $aL = $cW[3]; $aV = $cW[4];

        $pdf->SetFillColor(240, 247, 236);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetX($xRight);
        $pdf->Cell($aL, 6, 'Subtotal:', 'LTR', 0, 'R', true);
        $pdf->Cell($aV, 6, '$' . number_format($subtotal, 0, ',', '.'), 'LTR', 1, 'R', true);

        $pdf->SetX($xRight);
        $pdf->Cell($aL, 6, 'IVA (0%):', 'LR', 0, 'R', true);
        $pdf->Cell($aV, 6, '$0', 'LR', 1, 'R', true);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(45, 102, 34);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetX($xRight);
        $pdf->Cell($aL, 8, 'TOTAL:', 'LTBR', 0, 'R', true);
        $pdf->Cell($aV, 8, '$' . number_format($subtotal, 0, ',', '.'), 'LTBR', 1, 'R', true);

        // ── FIRMA / PIE ──
        $pdf->Ln(12);
        $pdf->SetTextColor(107, 114, 128);
        $pdf->SetDrawColor(240, 247, 236);
        $pdf->Line(14, $pdf->GetY(), 196, $pdf->GetY());
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'I', 7);
        $usuario = session()->get('nombre') . ' ' . session()->get('apellido');
        $pdf->Cell($W / 2, 5, 'Generado el: ' . date('d/m/Y H:i'), 0, 0, 'L');
        $pdf->Cell($W / 2, 5, utf8_decode('Autorizado por: ' . $usuario), 0, 1, 'R');
        $pdf->Cell($W, 5, utf8_decode('Documento generado electrónicamente — TOMFIC S.A.S'), 0, 0, 'C');

        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output('I', 'compra_' . str_pad($compra->id, 6, '0', STR_PAD_LEFT) . '.pdf');
    }

    public function guardarCompra()
    {
        $j         = $this->request->getJSON(true);
        $proveedor = trim($j['proveedor'] ?? '');
        $items     = $j['items'] ?? [];

        if (!$proveedor || empty($items)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Proveedor e ítems son requeridos'])
                ->setStatusCode(400);
        }

        $total = array_sum(array_column($items, 'subtotal'));

        $compra = [
            'cotizacion_id'  => ($j['cotizacion_id'] ?? null) ?: null,
            'remision_id'    => ($j['remision_id'] ?? null) ?: null,
            'numero_factura' => trim($j['numero_factura'] ?? ''),
            'proveedor'      => $proveedor,
            'fecha'          => $j['fecha'] ?? date('Y-m-d'),
            'total'          => $total,
            'estado'         => 'Pendiente',
            'observacion'    => trim($j['observacion'] ?? ''),
            'usuario_id'     => session()->get('documento'),
        ];

        try {
            $id = $this->model->guardarCompra($compra, $items);
            return $this->response->setJSON(['status' => 'success', 'id' => $id]);
        } catch (\Throwable $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()])
                ->setStatusCode(500);
        }
    }
}

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

    /* ── Compras ── */

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

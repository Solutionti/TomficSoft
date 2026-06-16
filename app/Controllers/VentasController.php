<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\VentasModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use FPDF;

class VentasController extends BaseController {
    
    public function __construct() {
      $this->ventasModel = new VentasModel();
    }

    public function index() {
      $data = [
        'caja' => $this->ventasModel->getCajaDisponible(),
        'consecutivo' => $this->ventasModel->getNumeroVenta()
      ];
      return view('administrador/ventas', $data); 
    }

    public function getProductoVenta() {
      $codigo = $this->request->getPost('codigo_barras');
      $producto = $this->ventasModel->getProductoVenta($codigo);

      if($producto){
        echo json_encode($producto);
      }
      else {
        echo "error";
      }
    }

    public function crearVenta() {
      $consecutivo = $this->request->getPost('consecutivo');
      $documento = $this->request->getPost('documento');
      $recibio = $this->request->getPost('recibio'); 
      $total = $this->request->getPost('total');
      $tppago = $this->request->getPost('tppago');
      $referencia = $this->request->getPost('referencia');
      $sede = $this->request->getPost('sede');
      $idcaja = $this->request->getPost('idcaja');
      $descuento = $this->request->getPost('descuento');
      $transaccion = $this->request->getPost('transaccion');
      $ventas = $this->request->getPost("ventas");
      $contador = 0;
      
      $validacion = $this->ventasModel->getVentaRepetida($consecutivo);
      for($i=0; $i < sizeof($ventas); $i++) {
        $contador = $contador + $ventas[$i]["cantidad"];
      }
      

      if($validacion == 0) {
        $data = [
          "consecutivo" => $consecutivo,
          "documento" => $documento,
          "sede" => $sede,
          "tipo_pago" => $tppago,
          "referencia" => $referencia,
          "total_recibido" => $recibio,
          "total_venta" => $total,
          "cantidad_productos" => $contador,
          "id_caja" => $idcaja,
          "descuento" => $descuento,
          "transaccion"=> $transaccion,
        ];
        $codigoventa = $this->ventasModel->crearVenta($data);
        
        for($i=0; $i < sizeof($ventas); $i++) {

          $descuenta = $this->ventasModel->getInventarioStock($ventas[$i]["codigo"]);
          $stockact = $descuenta->saldo - $ventas[$i]["cantidad"];
          
          $data2 = [
            "codigo_venta" => $consecutivo,
            "venta" => $ventas[$i]["codigo"],
            "cantidad" => $ventas[$i]["cantidad"],
            "categoria" => $descuenta->categoria,
            "precio" => $descuenta->costo
          ];

          $this->ventasModel->updateInventarioStock($ventas[$i]["codigo"], $stockact);
          $this->ventasModel->CrearDetalleVenta($data2);
        }

      }
      else {
        echo "error";
      }
    }

    public function pdfreciboventa($consecutivo){
      require APPPATH . 'Libraries/fpdf/fpdf.php';
      $venta        = $this->ventasModel->getVentaPdf($consecutivo)->getResult()[0];
      $detalleventa = $this->ventasModel->getDetalleVenta($consecutivo)->getResult();

      // ── Ticket térmico 80 mm ──
      $pdf = new \FPDF('P', 'mm', [80, 297]);
      $pdf->SetMargins(4, 4, 4);
      $pdf->SetAutoPageBreak(true, 4);
      $pdf->AddPage();
      $W = 72; // ancho útil

      // ── ENCABEZADO ──
      $pdf->SetFillColor(23, 58, 16);
      $pdf->Rect(0, 0, 80, 18, 'F');
      $pdf->SetY(3);
      $pdf->SetFont('Arial','B',11);
      $pdf->SetTextColor(255,255,255);
      $pdf->Cell($W, 6, 'VENTAS TOMFIC', 0, 1, 'C');
      $pdf->SetFont('Arial','',7);
      $pdf->SetTextColor(180,220,160);
      $pdf->Cell($W, 5, utf8_decode($venta->sede ?? 'Sede Principal'), 0, 1, 'C');
      $pdf->SetTextColor(30,30,30);

      // ── N° VENTA ──
      $pdf->Ln(3);
      $pdf->SetFont('Arial','B',8);
      $pdf->SetFillColor(240,247,236);
      $pdf->Cell($W, 6, 'Recibo N'.chr(176).' '.$venta->codigo_consecutivo, 0, 1, 'C', true);

      // ── META ──
      $pdf->Ln(1);
      $pdf->SetFont('Arial','',7);
      $lbl = 26;
      $val = $W - $lbl;
      $meta = [
          ['Fecha',    $venta->fecha ?? ''],
          ['Hora',     $venta->hora  ?? ''],
          ['Pago',     $venta->tipo_pago ?? ''],
          ['Vendedor', utf8_decode(session()->get('nombre').' '.session()->get('apellido'))],
      ];
      foreach ($meta as $row) {
          $pdf->SetFont('Arial','B',7); $pdf->SetTextColor(100,100,100);
          $pdf->Cell($lbl, 5, $row[0], 0, 0, 'L');
          $pdf->SetFont('Arial','',7);  $pdf->SetTextColor(30,30,30);
          $pdf->Cell($val, 5, $row[1], 0, 1, 'R');
      }

      // ── SEPARADOR ──
      $pdf->SetDrawColor(200,220,190);
      $pdf->Ln(1);
      $pdf->Line(4, $pdf->GetY(), 76, $pdf->GetY());
      $pdf->Ln(2);

      // ── CABECERA PRODUCTOS ──
      $pdf->SetFillColor(23,58,16);
      $pdf->SetTextColor(255,255,255);
      $pdf->SetFont('Arial','B',7);
      $pdf->Cell(36, 5, 'PRODUCTO',   0, 0, 'L', true);
      $pdf->Cell(8,  5, 'CANT',       0, 0, 'C', true);
      $pdf->Cell(14, 5, 'UNIT',       0, 0, 'R', true);
      $pdf->Cell(14, 5, 'SUBTOTAL',   0, 1, 'R', true);
      $pdf->SetTextColor(30,30,30);

      // ── ITEMS ──
      $pdf->SetFont('Arial','',7);
      $subtotalCalc = 0;
      foreach ($detalleventa as $i => $d) {
          $fill = ($i % 2 === 1);
          if ($fill) $pdf->SetFillColor(246,251,244);
          $qty  = (int)($d->cantidad ?? 1);
          $unit = (float)($d->costo ?? 0);
          $sub  = $qty * $unit;
          $subtotalCalc += $sub;
          $nombre = utf8_decode(mb_strtoupper($d->nombre ?? '', 'UTF-8'));
          // nombre puede ser largo — MultiCell en la primera columna
          $xStart = $pdf->GetX();
          $yStart = $pdf->GetY();
          $pdf->MultiCell(36, 5, $nombre, 0, 'L', $fill);
          $yEnd = $pdf->GetY();
          $pdf->SetXY(40, $yStart);
          $pdf->Cell(8,  ($yEnd - $yStart), $qty,                  0, 0, 'C', $fill);
          $pdf->Cell(14, ($yEnd - $yStart), '$'.number_format($unit,0,'.','.'), 0, 0, 'R', $fill);
          $pdf->Cell(14, ($yEnd - $yStart), '$'.number_format($sub,0,'.','.'),  0, 1, 'R', $fill);
      }

      // ── SEPARADOR ──
      $pdf->Ln(1);
      $pdf->Line(4, $pdf->GetY(), 76, $pdf->GetY());
      $pdf->Ln(2);

      // ── TOTALES ──
      $descPct   = (int)($venta->descuento ?? 0);
      $descAmt   = round($subtotalCalc * $descPct / 100);
      $total     = (float)$venta->total_venta;
      $recibido  = (float)str_replace('.','', $venta->total_recibido ?? 0);
      $cambio    = max(0, $recibido - $total);

      $pdf->SetFont('Arial','',7);
      $tW = 40; $aW = $W - $tW;

      if ($descPct > 0) {
          $pdf->SetTextColor(100,100,100);
          $pdf->Cell($tW, 5, 'Subtotal', 0, 0, 'L');
          $pdf->Cell($aW, 5, '$'.number_format($subtotalCalc,0,'.','.'), 0, 1, 'R');
          $pdf->SetTextColor(180,60,60);
          $pdf->Cell($tW, 5, "Descuento ({$descPct}%)", 0, 0, 'L');
          $pdf->Cell($aW, 5, '-$'.number_format($descAmt,0,'.','.'), 0, 1, 'R');
          $pdf->SetTextColor(30,30,30);
      }

      $pdf->SetFont('Arial','B',9);
      $pdf->SetFillColor(23,58,16);
      $pdf->SetTextColor(255,255,255);
      $pdf->Cell($tW, 7, 'TOTAL', 0, 0, 'L', true);
      $pdf->Cell($aW, 7, '$'.number_format($total,0,'.','.'), 0, 1, 'R', true);
      $pdf->SetTextColor(30,30,30);

      $pdf->SetFont('Arial','',7);
      $pdf->Cell($tW, 5, 'Recibido', 0, 0, 'L');
      $pdf->Cell($aW, 5, '$'.number_format($recibido,0,'.','.'), 0, 1, 'R');
      $pdf->SetFont('Arial','B',7);
      $pdf->SetTextColor(23,102,34);
      $pdf->Cell($tW, 5, 'Cambio', 0, 0, 'L');
      $pdf->Cell($aW, 5, '$'.number_format($cambio,0,'.','.'), 0, 1, 'R');
      $pdf->SetTextColor(30,30,30);

      // ── PIE ──
      $pdf->Ln(4);
      $pdf->SetDrawColor(200,220,190);
      $pdf->Line(4, $pdf->GetY(), 76, $pdf->GetY());
      $pdf->Ln(3);
      $pdf->SetFont('Arial','B',8);
      $pdf->SetTextColor(23,58,16);
      $pdf->Cell($W, 5, utf8_decode('¡GRACIAS POR TU COMPRA!'), 0, 1, 'C');
      $pdf->SetFont('Arial','',6);
      $pdf->SetTextColor(130,130,130);
      $pdf->Cell($W, 4, 'Conserva este recibo como comprobante', 0, 1, 'C');

      $this->response->setHeader('Content-Type', 'application/pdf');
      $pdf->Output('I', 'recibo_'.$consecutivo.'.pdf');
    }  
}
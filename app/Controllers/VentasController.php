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
      $venta = $this->ventasModel->getVentaPdf($consecutivo)->getResult()[0];
      $detalleventa = $this->ventasModel->getDetalleVenta($consecutivo);

      $pdf = new \FPDF();
      $pdf->AddPage();
      
      // $pdf->Image('public/img/theme/logo.jpeg' , 20,5, 20 , 17,'jpeg');
      //$pdf->Image('public/img/theme/zonac.png' , 35 ,5, 15 , 15,'png');
      $pdf->Ln(2);
      $pdf->SetFont('Times','',7);
      $pdf->Cell(2,5,'', '', 0,'L', false );
      $pdf->Cell(1,5,'VENTAS TOMFIC', '', 0,'L', false );
      $pdf->SetFont('Times','',6);
      $pdf->Ln(3);
      $pdf->Cell(5,5,'', '', 0,'L', false );
      $pdf->Cell(7,5,'SEDE PRINCIPAL - 151', '', 0,'L', false );
      $pdf->Ln(2);
      $pdf->Cell(10,5,'_______________________________', '', 0,'L', false );
      $pdf->SetFont('Times','',6);
      $pdf->Ln(5);
      $pdf->Cell(9,5,'FECHA:', '', 0,'L', false );
      $pdf->Cell(18,5,$venta->fecha, '', 0,'L', false );
      $pdf->Ln(4);
      $pdf->SetFont('Times','',6);
      $pdf->Cell(8,5,'HORA:', '', 0,'L', false );
      $pdf->Cell(4,5,$venta->hora, '', 0,'L', false );
      $pdf->Ln(4);
      $pdf->SetFont('Times','',6);
      $pdf->Cell(14,5,'VENDEDOR:', '', 0,'L', false );
      $pdf->Cell(4,5,session()->get('nombre').''. session()->get('apellido'), '', 0,'L', false );
      $pdf->Ln(7);
      $pdf->SetFont('Times','b',8);
      $pdf->Cell(20,5,utf8_decode('Productos'), '', 0,'L', false );
      $pdf->Cell(4,5,"Precio", '', 0,'L', false );
      $pdf->SetFont('Times','',7);
      // ACA VA LOS PRODUCTOS
      foreach($detalleventa->getResult() as $detventa) {
        $pdf->Ln(5);
        $pdf->Cell(20,5,$detventa->nombre, '', 0,'L', false );
        $pdf->Cell(5,5,"$".$detventa->costo, '', 0,'L', false );
      }
      
      //FIN DEL PRODUCTO
      $pdf->Ln(7);
      $pdf->SetFont('Times','b',8);
      $pdf->Cell(10,5,utf8_decode(''), '', 0,'L', false );
      $pdf->Cell(13,5,utf8_decode('TOTAL'), '', 0,'L', false );
      $pdf->Cell(4,5,'$'.$venta->total_venta, '', 0,'L', false );
      $pdf->SetFont('Times','',8);
      $pdf->Ln(6);
      $pdf->Cell(15,5,'Recibido', '', 0,'L', false );
      $pdf->Cell(5,5,'$ '.utf8_decode($venta->total_recibido), '', 0,'L', false );
      $pdf->Ln(8);
      $pdf->SetFont('Times','b',5);
      $pdf->Cell(1,5,'', '', 0,'L', false );
      $pdf->Cell(25,5,' GRACIAS POR TU COMPRA ', '', 0,'L', false );
      $pdf->Ln(10);

      $this->response->setHeader('Content-Type', 'application/pdf');
      $pdf->Output('I', 'productos_sinconteo.pdf');
    }  
}
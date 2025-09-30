<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\ConteosModel;
use App\Models\AsignacionModel;
use App\Models\ListasModel;
use CodeIgniter\HTTP\ResponseInterface;

use FPDF;

class AsignacionController extends BaseController {

    public function __construct() {
      $this->conteosModel = new ConteosModel();
      $this->asignacionModel = new AsignacionModel();
      $this->listasModel = new ListasModel();
    }  

    public function index() {
      $data = [
        "productos" => $this->conteosModel->getProductos(),
        "asignacionInventarios" => $this->asignacionModel->getAsignacion(),
        "subcategorias" => $this->asignacionModel->getSubcategorias(),
        "grupos" => $this->asignacionModel->getGrupo(),
        "subgrupos" => $this->asignacionModel->getSubgrupo(),
        "usuarios" => $this->listasModel->getUsuarios(),
        "reportes" => $this->asignacionModel->getConteosTablaReportes()
      ];

      return view('administrador/asignacioninventarios', $data);
    }

    public function crearInventarios(){
      
      $fecha = $this->request->getPost('fecha');
      $descripcion = $this->request->getPost('descripcion');

      $this->asignacionModel->crearInventarios($descripcion);

    }

    public function buscarProductosAsignar() {
      $subcategoria = $this->request->getPost('subcategoria');
      $grupo = $this->request->getPost('grupo');
      $subgrupo = $this->request->getPost('subgrupo');

      $productos = $this->asignacionModel->buscarProductosAsignar($subcategoria, $grupo, $subgrupo);

      if(!empty($productos)){
        return $this->response->setJSON($productos);
      }
      else {
        echo "error";
      }
    }

    public function asignarProductosInventario() {
      $codigoinventario = $this->request->getPost('codigoinventario');
      $codigoproducto = $this->request->getPost('codigoproducto');

      
      foreach($codigoproducto as $producto) {
        $this->asignacionModel->asignarProductosInventario($codigoinventario,$producto);
      }

      return $this->response->setJSON([
            "status"  => "success",
            "message" => "los productos se han asociado correctamente"
      ]);
    }

    public function asignarUbicacionInventario() {
      $codigoinventario = $this->request->getPost('codigoinventario');
      $ubicacion = $this->request->getPost('ubicacion');
      $localizacion = $this->request->getPost('localizacion');
      $numerolocalizacion = $this->request->getPost('numerolocalizacion');
      $observacion = $this->request->getPost('observacion');

      $datos = [
        "codigoinventario" => $codigoinventario,
        "ubicacion" => $ubicacion,
        "localizacion" => $localizacion,
        "numerolocalizacion" => $numerolocalizacion,
        "observacion" => $observacion
      ];

      $this->asignacionModel->asignarUbicacionInventario($datos);

      return $this->response->setJSON([
        "status"  => "success",
        "message" => "la ubicacion se han asociado correctamente"
      ]);

    }

    public function procesoDatosModal($id) {
      $inventario = $this->asignacionModel->procesoDatosModal($id)->getResult();

      return $this->response->setJSON($inventario);
    }

    public function asignarUsuariosInventario() {
      $codigoinventario = $this->request->getPost('codigo_inventario');
      $usuario1 = $this->request->getPost('usuario1');
      $usuario2 = $this->request->getPost('usuario2');

      $datos = [
        "codigoinventario" => $codigoinventario,
        "usuario1" => $usuario1,
        "usuario2" => $usuario2
      ];

      $this->asignacionModel->asignarUsuariosInventario($datos);

      return $this->response->setJSON([
        "status"  => "success",
        "message" => "los usuarios se han asociado correctamente"
      ]);
    }

    public function generarPdf() {
    
      require APPPATH . 'Libraries/fpdf/fpdf.php';
      
      $reportes = $this->asignacionModel->getpdfReportes();

      $pdf = new \FPDF();
      $pdf->AddPage();
      $pdf->SetFont('Arial', 'B', 16);
      $pdf->Cell(60,5,'', '', 0,'L', false );
      $pdf->Cell(1,5,'REPORTES DEL SISTEMA', '', 0,'L', false );
      $pdf->SetFont('Times','',9);
      $pdf->Ln(5);
      $pdf->Cell(75,5,'', '', 0,'L', false );
      $pdf->Cell(7,5,'Sistema de inventarios Tomfic', '', 0,'L', false );
      $pdf->Ln(2);
      $pdf->Cell(55,5,'', '', 0,'L', false );
      $pdf->Cell(10,5,'____________________________________________________', '', 0,'L', false );
      $pdf->SetFont('Times','',9);
      $pdf->Ln(9);
      $pdf->Cell(36,5,'FECHA DEL REPORTE:', '', 0,'L', false );
      $pdf->Cell(18,5,date("d-m-Y"), '', 0,'L', false );
      $pdf->Ln(5);
      $pdf->SetFont('Times','',8);
      $pdf->Cell(12,5,'HORA:', '', 0,'L', false );
      $pdf->Cell(4,5,date("H: i A"), '', 0,'L', false );
      $pdf->Ln(5);
      $pdf->SetFont('Times','',8);
      $pdf->Cell(24,5,'QUIEN GENERA:', '', 0,'L', false );
      $pdf->Cell(4,5,"jersom", '', 0,'L', false );
      $pdf->Ln(8);
      $pdf->SetFont('Times','b',10);
      $pdf->Cell(18,5,'REPORTE DE CONTEOS DE PRODUCTOS', '', 0,'L', false );
      $pdf->Ln(6);
      $pdf->SetFont('Times','b',9);
      $pdf->Cell(25,5,'CODIGO', 'LTBR', 0,'L', false );
      $pdf->Cell(100,5,'NOMBRE', 'TBR', 0,'L', false );
      $pdf->Cell(20,5,"CONTEO #1", 'TBR', 0,'L', false );
      $pdf->Cell(22,5,"CONTEO #2", 'TBR', 0,'L', false );
      $pdf->Cell(26,5,"DIFERENCIA", 'TBR', 0,'L', false );

      $pdf->SetFont('Times','',8);
      foreach($reportes->getResult() as $reporte) {
        $pdf->Ln(5);
        $pdf->Cell(25,5,$reporte->codigo_producto, 'LTBR', 0,'L', false );
        $pdf->Cell(100,5,utf8_decode($reporte->nombre), 'TBR', 0,'L', false );
        $pdf->Cell(20,5,$reporte->conteo1, 'TBR', 0,'L', false );
        $pdf->Cell(22,5,$reporte->conteo2, 'TBR', 0,'L', false );
        $pdf->Cell(26,5,abs($reporte->conteo1 - $reporte->conteo2), 'TBR', 0,'L', false );
      }
        
      // Salida del PDF al navegador
      $this->response->setHeader('Content-Type', 'application/pdf');
      $pdf->Output('I', 'ejemplo.pdf');
    }
    
}

<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\ConteosModel;
use App\Models\AsignacionModel;
use App\Models\ListasModel;
use CodeIgniter\HTTP\ResponseInterface;

use FPDF;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
          "categorias" => $this->asignacionModel->getcategorias(),
          "subcategorias" => $this->asignacionModel->getSubcategorias(),
          "grupos" => $this->asignacionModel->getGrupo(),
          "subgrupos" => $this->asignacionModel->getSubgrupo(),
          "usuarios" => $this->listasModel->getUsuarios(),
          "reportes" => $this->asignacionModel->getConteosTablaReportes(),
          "permisoUsuario" => $this->listasModel->getPermisosMenu()
        ];
        return view('administrador/asignacioninventarios', $data);
    }

    public function crearInventarios(){
      
      $fecha = $this->request->getPost('fecha');
      $conteos = $this->request->getPost('conteos');
      $descripcion = $this->request->getPost('descripcion');

      $this->asignacionModel->crearInventarios($descripcion, $conteos);

    }

    public function actualizarinventario() {
      $codigo = $this->request->getPost('codigo');
      $fecha = $this->request->getPost('fecha');
      $conteos = $this->request->getPost('conteos');
      $descripcion = $this->request->getPost('descripcion');


      $this->asignacionModel->actualizarinventario($codigo, $fecha, $descripcion, $conteos); ;  
    }

    public function buscarProductosAsignar() {
      $subcategoria = $this->request->getPost('subcategoria');
      $grupo = $this->request->getPost('grupo');
      $subgrupo = $this->request->getPost('subgrupo');
      $categoria = $this->request->getPost('categoria');

      $productos = $this->asignacionModel->buscarProductosAsignar($categoria,$subcategoria, $grupo, $subgrupo);

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

    public function generarPdf($inventario) {
    
      require APPPATH . 'Libraries/fpdf/fpdf.php';
      
      $reportes = $this->asignacionModel->getpdfReportes($inventario);
      $ubicaciones = $this->asignacionModel->getpdfReportes($inventario)->getResult()[0];

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
      $pdf->Ln(9);
      $pdf->SetFont('Times','B',9);
      $pdf->Cell(38,5,'FECHA DEL REPORTE:', '', 0,'L', false );
      $pdf->SetFont('Times','',9);
      $pdf->Cell(50,5,date("d-m-Y"), '', 0,'L', false );
      $pdf->SetFont('Times','B',9);
      $pdf->Cell(23,5,'UBICACION:', '', 0,'L', false );
      $pdf->SetFont('Times','',9);
      $pdf->Cell(38,5,$ubicaciones->ubicacion, '', 0,'L', false );
      
      $pdf->Ln(5);
      $pdf->SetFont('Times','B',8);
      $pdf->Cell(12,5,'HORA:', '', 0,'L', false );
      $pdf->SetFont('Times','',8);
      $pdf->Cell(76,5,date("H: i A"), '', 0,'L', false );
      $pdf->SetFont('Times','B',9);
      $pdf->Cell(29,5,'LOCALIZACION:', '', 0,'L', false );
      $pdf->SetFont('Times','',9);
      $pdf->Cell(38,5,$ubicaciones->localizacion, '', 0,'L', false );
      $pdf->Ln(5);
      $pdf->SetFont('Times','B',8);
      $pdf->Cell(24,5,'QUIEN GENERA:', '', 0,'L', false );
      $pdf->SetFont('Times','',8);
      $pdf->Cell(64,5,session()->get('nombre').' '.session()->get('apellido'), '', 0,'L', false );
      $pdf->SetFont('Times','B',9);
      $pdf->Cell(34,5,utf8_decode('Nº LOCALIZACION:'), '', 0,'L', false );
      $pdf->SetFont('Times','',9);
      $pdf->Cell(38,5,$ubicaciones->num_localizacion, '', 0,'L', false );
      $pdf->Ln(8);
      $pdf->SetFont('Times','b',10);
      $pdf->Cell(18,5,'REPORTE DE CONTEOS DE PRODUCTOS', '', 0,'L', false );
      $pdf->Ln(6);
      $pdf->SetFont('Times','b',9);
      $pdf->Cell(25,5,'CODIGO', 'LTBR', 0,'L', false );
      $pdf->Cell(80,5,'NOMBRE', 'TBR', 0,'L', false );
      $pdf->Cell(20,5,"CONTEO #1", 'TBR', 0,'L', false );
      $pdf->Cell(22,5,"CONTEO #2", 'TBR', 0,'L', false );
      $pdf->Cell(26,5,"DIFERENCIA", 'TBR', 0,'L', false );
      $pdf->Cell(20,5,"CONTEO #3", 'TBR', 0,'L', false );

      $pdf->SetFont('Times','',8);
      foreach($reportes->getResult() as $reporte) {
        $pdf->Ln(5);
        $pdf->Cell(25,5,$reporte->codigo_producto, 'LTBR', 0,'L', false );
        $pdf->Cell(80,5,utf8_decode($reporte->nombre), 'TBR', 0,'L', false );
        $pdf->Cell(20,5,$reporte->conteo1, 'TBR', 0,'L', false );
        $pdf->Cell(22,5,$reporte->conteo2, 'TBR', 0,'L', false );
        $pdf->Cell(26,5,abs($reporte->conteo1 - $reporte->conteo2), 'TBR', 0,'L', false );
        $pdf->Cell(20,5,'', 'TBR', 0,'L', false );
      }
        
      // Salida del PDF al navegador
      $this->response->setHeader('Content-Type', 'application/pdf');
      $pdf->Output('I', 'ejemplo.pdf');
    }

    public function generarExcel($inventario) {

      // Crear nuevo archivo Excel
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();

      // Encabezados
        $sheet->setCellValue('A1', 'CODIGO');
        $sheet->setCellValue('B1', 'EAN13');
        $sheet->setCellValue('C1', 'NOMBRE');
        $sheet->setCellValue('D1', 'REFER');
        $sheet->setCellValue('E1', 'CONTEO1');
        $sheet->setCellValue('F1', 'CONTE02');
        $sheet->setCellValue('G1', 'DIFERENCIA');
        $sheet->setCellValue('H1', 'CONTEO3');
        $sheet->setCellValue('I1', 'ESTADO');
        $sheet->setCellValue('J1', 'UBICACION');
        $sheet->setCellValue('K1', 'LOCALIZACION');
        $sheet->setCellValue('L1', 'N° LOCALIZACION');
        $sheet->setCellValue('M1', 'USUARIOS');

        // Datos de ejemplo
        $data = $this->asignacionModel->getExcelReportes($inventario);

        // Insertar datos en filas
        $row = 2;
        foreach ($data->getResult() as $item) {
            $sheet->setCellValue('A' . $row, ' '.$item->codigo_producto);
            $sheet->setCellValue('B' . $row, ' '.$item->codigo_producto);
            $sheet->setCellValue('C' . $row, $item->nombre);
            $sheet->setCellValue('D' . $row, $item->referencia);
            $sheet->setCellValue('E' . $row, $item->conteo1);
            $sheet->setCellValue('F' . $row, $item->conteo2);
            $sheet->setCellValue('G' . $row, $item->diferencia);
            $sheet->setCellValue('H' . $row, $item->conteo3);
            $sheet->setCellValue('I' . $row, $item->estado);
            $sheet->setCellValue('J' . $row, $item->ubicacion);
            $sheet->setCellValue('K' . $row, $item->localizacion);
            $sheet->setCellValue('L' . $row, $item->num_localizacion);
            $sheet->setCellValue('M' . $row, '');
            $row++;
        }

        // Descargar archivo
        $writer = new Xlsx($spreadsheet);

        $filename = 'usuarios_' . date('Ymd_His') . '.xlsx';

        // Headers para forzar la descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function getNumeroLocalizacion($localizacion) {
      $result = $this->asignacionModel->getNumeroLocalizacion($localizacion);

      return $this->response->setJSON($result);
    }
    
}

<?php

namespace App\Controllers;
use App\Models\ListasModel;
use App\Models\ReportesModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ReportesController extends BaseController {

    public function __construct() {
      $this->listasModel = new ListasModel();
      $this->reportesModel = new ReportesModel();
    }
    
    public function index() {
       $data = [
         'permisoUsuario' => $this->listasModel->getPermisosMenu(),
      ];
      return view('administrador/reportes', $data); 
    
    }

    public function productosSinConteo() {
      
    }

    public function diferenciaConteos($fechaInicio,$fechaFin) {
       
      // Crear nuevo archivo Excel
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();

      // Encabezados
        $sheet->setCellValue('A1', 'CODIGO_BARRAS');
        $sheet->setCellValue('B1', 'CODIGO_INTERNO');
        $sheet->setCellValue('C1', 'NOMBRE PRODUCTO');
        $sheet->setCellValue('D1', 'REFERENCIA');
        $sheet->setCellValue('E1', 'CATEGORIA');
        $sheet->setCellValue('F1', 'SUBCATEGORIA');
        $sheet->setCellValue('G1', 'SUBGRUPO');
        $sheet->setCellValue('H1', 'NIT');
        $sheet->setCellValue('I1', 'PROVEEDOR');
        $sheet->setCellValue('J1', 'STOCK');
        $sheet->setCellValue('K1', 'CANT FISICA');
        $sheet->setCellValue('L1', 'DIFERENCIA');
        $sheet->setCellValue('M1', 'VALOR DIFERENCIA');

        // // Datos de ejemplo
        $data = $this->reportesModel->diferenciaConteos($fechaInicio, $fechaFin);
        
        // Insertar datos en filas
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, ' '.$item->codigo_producto);
            $sheet->setCellValue('B' . $row, ' '.$item->codigo_producto);
            $sheet->setCellValue('C' . $row, $item->nombre);
            $sheet->setCellValue('D' . $row, $item->referencia);
            $sheet->setCellValue('E' . $row, $item->categoria);
            $sheet->setCellValue('F' . $row, $item->subcategoria);
            $sheet->setCellValue('G' . $row, $item->subgrupo);
            $sheet->setCellValue('H' . $row, $item->nit);
            $sheet->setCellValue('I' . $row, $item->proveedor);
            $sheet->setCellValue('J' . $row, $item->saldo);
            $sheet->setCellValue('K' . $row, $item->cantidad_fisica);
            $sheet->setCellValue('L' . $row, $item->diferencias);
            $sheet->setCellValue('M' . $row, $item->valor_diferencia);
            $row++;
        }

        // Descargar archivo
        $writer = new Xlsx($spreadsheet);

        $filename = 'diferenciaconteos_' . date('Ymd_His') . '.xlsx';

        // Headers para forzar la descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function diferenciaInventario() {

    }

    public function gananciaTotal() {

    }

}
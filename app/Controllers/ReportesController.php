<?php

namespace App\Controllers;
use App\Models\ListasModel;
use App\Models\ReportesModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use FPDF;

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

    public function productosSinConteoPdf($fechaInicio,$fechaFin) {
      require APPPATH . 'Libraries/fpdf/fpdf.php';

      $data = $this->reportesModel->productosSinConteo($fechaInicio, $fechaFin);

      $pdf = new \FPDF();
      $pdf = new FPDF('L', 'mm', 'A4'); // L = Horizontal
      $pdf->AddPage();
      $pdf->SetFont('Arial', 'B', 16);
      $pdf->Cell(110,5,'', '', 0,'L', false );
      $pdf->Cell(1,5,'REPORTES DEL SISTEMA', '', 0,'L', false );
      $pdf->SetFont('Times','',9);
      $pdf->Ln(5);
      $pdf->Cell(125,5,'', '', 0,'L', false );
      $pdf->Cell(7,5,'Sistema de inventarios Tomfic', '', 0,'L', false );
      $pdf->Ln(2);
      $pdf->Cell(105,5,'', '', 0,'L', false );
      $pdf->Cell(10,5,'____________________________________________________', '', 0,'L', false );
      $pdf->Ln(9);
      $pdf->SetFont('Times','B',9);
      $pdf->Cell(38,5,'FECHA DEL REPORTE:', '', 0,'L', false );
      $pdf->SetFont('Times','',9);
      $pdf->Cell(50,5,date("d-m-Y"), '', 0,'L', false );
      $pdf->SetFont('Times','',9);
      
      $pdf->Ln(5);
      $pdf->SetFont('Times','B',8);
      $pdf->Cell(12,5,'HORA:', '', 0,'L', false );
      $pdf->SetFont('Times','',8);
      $pdf->Cell(76,5,date("H: i A"), '', 0,'L', false );
     
      $pdf->SetFont('Times','',9);
      $pdf->Ln(5);
      $pdf->SetFont('Times','B',8);
      $pdf->Cell(24,5,'QUIEN GENERA:', '', 0,'L', false );
      $pdf->SetFont('Times','',8);
      $pdf->Cell(64,5,session()->get('nombre').' '.session()->get('apellido'), '', 0,'L', false );
      
      $pdf->SetFont('Times','',9);
      $pdf->Ln(8);
      $pdf->SetFont('Times','b',10);
      $pdf->Cell(18,5,'REPORTE DE PRODUCTOS NO CONTEOS', '', 0,'L', false );
      $pdf->Ln(6);
      $pdf->SetFont('Times','b',9);
      $pdf->Cell(21,5,'INTERNO', 'LTBR', 0,'L', false );
      $pdf->Cell(21,5,'CODIGO', 'LTBR', 0,'L', false );
      $pdf->Cell(90,5,'NOMBRE', 'TBR', 0,'L', false );
      $pdf->Cell(30,5,"REFERENCIA", 'TBR', 0,'L', false );
      $pdf->Cell(22,5,"CATEGORIA", 'TBR', 0,'L', false );
      $pdf->Cell(30,5,"SUBCATEGORIA", 'TBR', 0,'L', false );
      $pdf->Cell(25,5,"GRUPO", 'TBR', 0,'L', false );
      $pdf->Cell(20,5,"SALDO", 'TBR', 0,'L', false );
      $pdf->Cell(20,5,"VALOR", 'TBR', 0,'L', false );

      $pdf->SetFont('Times','',8);
      foreach($data as $reporte) {
        $pdf->Ln(5);
        $pdf->Cell(21,5,$reporte->codigo_interno, 'LTBR', 0,'L', false );
        $pdf->Cell(21,5,$reporte->codigo_producto, 'LTBR', 0,'L', false );
        $pdf->Cell(90,5,utf8_decode($reporte->nombre), 'TBR', 0,'L', false );
        $pdf->Cell(30,5,$reporte->referencia, 'TBR', 0,'L', false );
        $pdf->Cell(22,5,$reporte->categoria, 'TBR', 0,'L', false );
        $pdf->Cell(30,5,$reporte->subcategoria, 'TBR', 0,'L', false );
        $pdf->Cell(25,5,$reporte->grupo, 'TBR', 0,'L', false );
        $pdf->Cell(20,5,$reporte->saldo, 'TBR', 0,'L', false );
        $pdf->Cell(20,5,$reporte->valor, 'TBR', 0,'L', false );
      }
        
      // Salida del PDF al navegador
      $this->response->setHeader('Content-Type', 'application/pdf');
      $pdf->Output('I', 'productos_sinconteo.pdf');
    }

    public function productosSinConteoExcel($fechaInicio, $fechaFin) {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'CODIGO_BARRAS');
        $sheet->setCellValue('B1', 'CODIGO_INTERNO');
        $sheet->setCellValue('C1', 'NOMBRE PRODUCTO');
        $sheet->setCellValue('D1', 'REFERENCIA');
        $sheet->setCellValue('E1', 'CATEGORIA');
        $sheet->setCellValue('F1', 'SUBCATEGORIA');
        $sheet->setCellValue('G1', 'GRUPO');
        $sheet->setCellValue('H1', 'FECHA');
        $sheet->setCellValue('I1', 'SALDO');
        $sheet->setCellValue('J1', 'VALOR');

        $data = $this->reportesModel->productosSinConteo($fechaInicio, $fechaFin);

        // Insertar datos en filas
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, ' '.$item->codigo_producto);
            $sheet->setCellValue('B' . $row, ' '.$item->codigo_interno);
            $sheet->setCellValue('C' . $row, $item->nombre);
            $sheet->setCellValue('D' . $row, $item->referencia);
            $sheet->setCellValue('E' . $row, $item->categoria);
            $sheet->setCellValue('F' . $row, $item->subcategoria);
            $sheet->setCellValue('G' . $row, $item->grupo);
            $sheet->setCellValue('H' . $row, $item->fecha);
            $sheet->setCellValue('I' . $row, $item->saldo);
            $sheet->setCellValue('J' . $row, $item->valor);
            $row++;
        }

        // Descargar archivo
        $writer = new Xlsx($spreadsheet);

        $filename = 'productos_noconteo_' . date('Ymd_His') . '.xlsx';

        // Headers para forzar la descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
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

    public function perdidasPorFechaPdf($fechaInicio, $fechaFin) {
        require APPPATH . 'Libraries/fpdf/fpdf.php';

        $fi   = $fechaInicio ?: '2000-01-01';
        $ff   = $fechaFin    ?: date('Y-m-d');
        $data = $this->reportesModel->perdidasPorFecha($fi, $ff);

        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();

        // ── cabecera ──────────────────────────────────────
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(110, 5, '', '', 0, 'L', false);
        $pdf->Cell(1,   5, 'REPORTES DEL SISTEMA', '', 0, 'L', false);
        $pdf->SetFont('Times', '', 9);
        $pdf->Ln(5);
        $pdf->Cell(125, 5, '', '', 0, 'L', false);
        $pdf->Cell(7,   5, 'Sistema de inventarios Tomfic', '', 0, 'L', false);
        $pdf->Ln(2);
        $pdf->Cell(105, 5, '', '', 0, 'L', false);
        $pdf->Cell(10,  5, '____________________________________________________', '', 0, 'L', false);
        $pdf->Ln(9);
        $pdf->SetFont('Times', 'B', 9);
        $pdf->Cell(38,  5, 'FECHA DEL REPORTE:', '', 0, 'L', false);
        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(50,  5, date("d-m-Y"), '', 0, 'L', false);
        $pdf->Ln(5);
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(12,  5, 'HORA:', '', 0, 'L', false);
        $pdf->SetFont('Times', '', 8);
        $pdf->Cell(76,  5, date("H:i A"), '', 0, 'L', false);
        $pdf->Ln(5);
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(24,  5, 'QUIEN GENERA:', '', 0, 'L', false);
        $pdf->SetFont('Times', '', 8);
        $pdf->Cell(64,  5, session()->get('nombre') . ' ' . session()->get('apellido'), '', 0, 'L', false);
        $pdf->Ln(5);
        $pdf->SetFont('Times', 'B', 9);
        $pdf->Cell(18,  5, 'PERIODO:', '', 0, 'L', false);
        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(80,  5, $fi . ' al ' . $ff, '', 0, 'L', false);
        $pdf->Ln(8);

        // ── título ────────────────────────────────────────
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(0, 5, 'REPORTE DE P' . utf8_decode('É') . 'RDIDAS / DESECHOS POR FECHA', '', 0, 'L', false);
        $pdf->Ln(7);

        // ── encabezado tabla ──────────────────────────────
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(10, 5, '#',           'LTBR', 0, 'C', false);
        $pdf->Cell(90, 5, 'NOMBRE / PRODUCTO', 'TBR', 0, 'L', false);
        $pdf->Cell(22, 5, 'UNIDADES',    'TBR', 0, 'C', false);
        $pdf->Cell(25, 5, 'PESO (kg)',   'TBR', 0, 'C', false);
        $pdf->Cell(27, 5, utf8_decode('DÍA'), 'TBR', 0, 'C', false);
        $pdf->Cell(28, 5, 'FECHA',       'TBR', 0, 'C', false);
        $pdf->Cell(22, 5, 'HORA',        'TBR', 0, 'C', false);

        // ── filas ─────────────────────────────────────────
        $pdf->SetFont('Times', '', 8);
        $i            = 1;
        $totalKg      = 0;
        $totalUnidades = 0;
        foreach ($data as $row) {
            $pdf->Ln(5);
            $pdf->Cell(10, 5, $i++,                              'LTBR', 0, 'C', false);
            $pdf->Cell(90, 5, utf8_decode($row->nombre),         'TBR',  0, 'L', false);
            $pdf->Cell(22, 5, $row->unidades ?? '-',             'TBR',  0, 'C', false);
            $pdf->Cell(25, 5, number_format((float)$row->peso, 2), 'TBR', 0, 'C', false);
            $pdf->Cell(27, 5, utf8_decode($row->dia ?? ''),      'TBR',  0, 'C', false);
            $pdf->Cell(28, 5, $row->fecha,                       'TBR',  0, 'C', false);
            $pdf->Cell(22, 5, $row->hora,                        'TBR',  0, 'C', false);
            $totalKg       += (float)($row->peso ?? 0);
            $totalUnidades += (int)($row->unidades ?? 0);
        }

        // ── fila totales ──────────────────────────────────
        $pdf->Ln(5);
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(10, 5, '',                                  'LTB',  0, 'C', false);
        $pdf->Cell(90, 5, 'TOTALES',                           'TB',   0, 'R', false);
        $pdf->Cell(22, 5, $totalUnidades,                      'TBR',  0, 'C', false);
        $pdf->Cell(25, 5, number_format($totalKg, 2) . ' kg', 'TBR',  0, 'C', false);
        $pdf->Cell(27, 5, '',                                  'TBR',  0, 'C', false);
        $pdf->Cell(28, 5, '',                                  'TBR',  0, 'C', false);
        $pdf->Cell(22, 5, '',                                  'TBR',  0, 'C', false);

        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output('I', 'perdidas_por_fecha.pdf');
    }

    public function perdidasPorFechaExcel($fechaInicio, $fechaFin) {
        $fi   = $fechaInicio ?: '2000-01-01';
        $ff   = $fechaFin    ?: date('Y-m-d');
        $data = $this->reportesModel->perdidasPorFecha($fi, $ff);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Perdidas por Fecha');

        $sheet->setCellValue('A1', '#');
        $sheet->setCellValue('B1', 'NOMBRE / PRODUCTO');
        $sheet->setCellValue('C1', 'UNIDADES');
        $sheet->setCellValue('D1', 'PESO (kg)');
        $sheet->setCellValue('E1', 'DIA');
        $sheet->setCellValue('F1', 'FECHA');
        $sheet->setCellValue('G1', 'HORA');

        $row = 2;
        $i   = 1;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $i++);
            $sheet->setCellValue('B' . $row, $item->nombre);
            $sheet->setCellValue('C' . $row, (int)($item->unidades ?? 0));
            $sheet->setCellValue('D' . $row, round((float)($item->peso ?? 0), 2));
            $sheet->setCellValue('E' . $row, $item->dia);
            $sheet->setCellValue('F' . $row, $item->fecha);
            $sheet->setCellValue('G' . $row, $item->hora);
            $row++;
        }

        $writer   = new Xlsx($spreadsheet);
        $filename = 'perdidas_por_fecha_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function perdidasPorProductoPdf($fechaInicio, $fechaFin) {
        require APPPATH . 'Libraries/fpdf/fpdf.php';

        $fi   = $fechaInicio ?: '2000-01-01';
        $ff   = $fechaFin    ?: date('Y-m-d');
        $data = $this->reportesModel->perdidasPorProducto($fi, $ff);

        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();

        // ── cabecera ──────────────────────────────────────
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(110, 5, '', '', 0, 'L', false);
        $pdf->Cell(1,   5, 'REPORTES DEL SISTEMA', '', 0, 'L', false);
        $pdf->SetFont('Times', '', 9);
        $pdf->Ln(5);
        $pdf->Cell(125, 5, '', '', 0, 'L', false);
        $pdf->Cell(7,   5, 'Sistema de inventarios Tomfic', '', 0, 'L', false);
        $pdf->Ln(2);
        $pdf->Cell(105, 5, '', '', 0, 'L', false);
        $pdf->Cell(10,  5, '____________________________________________________', '', 0, 'L', false);
        $pdf->Ln(9);
        $pdf->SetFont('Times', 'B', 9);
        $pdf->Cell(38,  5, 'FECHA DEL REPORTE:', '', 0, 'L', false);
        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(50,  5, date("d-m-Y"), '', 0, 'L', false);
        $pdf->Ln(5);
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(12,  5, 'HORA:', '', 0, 'L', false);
        $pdf->SetFont('Times', '', 8);
        $pdf->Cell(76,  5, date("H:i A"), '', 0, 'L', false);
        $pdf->Ln(5);
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(24,  5, 'QUIEN GENERA:', '', 0, 'L', false);
        $pdf->SetFont('Times', '', 8);
        $pdf->Cell(64,  5, session()->get('nombre') . ' ' . session()->get('apellido'), '', 0, 'L', false);
        $pdf->Ln(5);
        $pdf->SetFont('Times', 'B', 9);
        $pdf->Cell(18,  5, 'PERIODO:', '', 0, 'L', false);
        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(80,  5, $fi . ' al ' . $ff, '', 0, 'L', false);
        $pdf->Ln(8);

        // ── título ────────────────────────────────────────
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(0, 5, 'REPORTE DE P' . utf8_decode('É') . 'RDIDAS / DESECHOS POR PRODUCTO', '', 0, 'L', false);
        $pdf->Ln(7);

        // ── encabezado tabla ──────────────────────────────
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(90, 5, 'PRODUCTO / NOMBRE',  'LTBR', 0, 'L', false);
        $pdf->Cell(25, 5, 'REGISTROS',           'TBR',  0, 'C', false);
        $pdf->Cell(30, 5, 'TOTAL UNIDADES',      'TBR',  0, 'C', false);
        $pdf->Cell(30, 5, 'TOTAL PESO (kg)',      'TBR',  0, 'C', false);
        $pdf->Cell(35, 5, 'PRIMERA FECHA',        'TBR',  0, 'C', false);
        $pdf->Cell(35, 5, utf8_decode('ÚLTIMA FECHA'), 'TBR', 0, 'C', false);

        // ── filas ─────────────────────────────────────────
        $pdf->SetFont('Times', '', 8);
        $totalRegistros  = 0;
        $totalUnidades   = 0;
        $totalKg         = 0;
        foreach ($data as $row) {
            $pdf->Ln(5);
            $pdf->Cell(90, 5, utf8_decode($row->nombre),                   'LTBR', 0, 'L', false);
            $pdf->Cell(25, 5, (int)$row->registros,                        'TBR',  0, 'C', false);
            $pdf->Cell(30, 5, (int)($row->total_unidades ?? 0),            'TBR',  0, 'C', false);
            $pdf->Cell(30, 5, number_format((float)($row->total_peso ?? 0), 2), 'TBR', 0, 'C', false);
            $pdf->Cell(35, 5, $row->primera_fecha,                         'TBR',  0, 'C', false);
            $pdf->Cell(35, 5, $row->ultima_fecha,                          'TBR',  0, 'C', false);
            $totalRegistros += (int)$row->registros;
            $totalUnidades  += (int)($row->total_unidades ?? 0);
            $totalKg        += (float)($row->total_peso ?? 0);
        }

        // ── fila totales ──────────────────────────────────
        $pdf->Ln(5);
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(90, 5, 'TOTALES',                               'LTBR', 0, 'R', false);
        $pdf->Cell(25, 5, $totalRegistros,                         'TBR',  0, 'C', false);
        $pdf->Cell(30, 5, $totalUnidades,                          'TBR',  0, 'C', false);
        $pdf->Cell(30, 5, number_format($totalKg, 2) . ' kg',     'TBR',  0, 'C', false);
        $pdf->Cell(35, 5, '',                                      'TBR',  0, 'C', false);
        $pdf->Cell(35, 5, '',                                      'TBR',  0, 'C', false);

        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output('I', 'perdidas_por_producto.pdf');
    }

    public function perdidasPorProductoExcel($fechaInicio, $fechaFin) {
        $fi   = $fechaInicio ?: '2000-01-01';
        $ff   = $fechaFin    ?: date('Y-m-d');
        $data = $this->reportesModel->perdidasPorProducto($fi, $ff);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Perdidas por Producto');

        $sheet->setCellValue('A1', 'PRODUCTO / NOMBRE');
        $sheet->setCellValue('B1', 'REGISTROS');
        $sheet->setCellValue('C1', 'TOTAL UNIDADES');
        $sheet->setCellValue('D1', 'TOTAL PESO (kg)');
        $sheet->setCellValue('E1', 'PRIMERA FECHA');
        $sheet->setCellValue('F1', 'ULTIMA FECHA');

        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item->nombre);
            $sheet->setCellValue('B' . $row, (int)$item->registros);
            $sheet->setCellValue('C' . $row, (int)($item->total_unidades ?? 0));
            $sheet->setCellValue('D' . $row, round((float)($item->total_peso ?? 0), 2));
            $sheet->setCellValue('E' . $row, $item->primera_fecha);
            $sheet->setCellValue('F' . $row, $item->ultima_fecha);
            $row++;
        }

        $writer   = new Xlsx($spreadsheet);
        $filename = 'perdidas_por_producto_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

}
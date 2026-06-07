<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class HorariosController extends BaseController {

  public function __construct() {
     $this->listasModel = new \App\Models\ListasModel();
     $this->horariosModel = new \App\Models\HorariosModel();
     $this->db = \Config\Database::connect();
  }

  public function index(){
    $data = [
        'permisoUsuario'  => $this->listasModel->getPermisosMenu(),
        'colaboradores'   => $this->horariosModel->getColaboradores(),
        'horarios'        => $this->horariosModel->getHorarios(),
        'horariosNombres' => $this->horariosModel->getHorariosNombres(),
        'activosHoy'      => $this->horariosModel->getActivosHoy(),
        'salidaHoy'       => $this->horariosModel->getSalidaHoy(),
    ];
    return view('administrador/horarios', $data);
  }

  public function crearColaborador() {
    $j = $this->request->getJSON(true);

    $requeridos = ['documento','nombres','apellidos','cargo'];
    foreach ($requeridos as $campo) {
        if (empty(trim($j[$campo] ?? ''))) {
            return $this->response->setJSON(['status'=>'error','message'=>"El campo $campo es requerido"])
                ->setStatusCode(400);
        }
    }

    // Verificar que el documento no exista
    $existe = $this->db->table('colaboradores')
        ->where('documento', trim($j['documento']))->countAllResults();
    if ($existe) {
        return $this->response->setJSON(['status'=>'error','message'=>'Ya existe un colaborador con ese documento'])
            ->setStatusCode(409);
    }

    $data = [
        'documento'        => trim($j['documento']),
        'nombres'          => trim($j['nombres']),
        'apellidos'        => trim($j['apellidos']),
        'telefono'         => trim($j['telefono']        ?? ''),
        'cargo'            => trim($j['cargo']           ?? ''),
        'sexo'             => trim($j['sexo']            ?? ''),
        'nacimiento' => $j['nacimiento']            ?? null,
        'direccion'        => trim($j['direccion']       ?? ''),
        'barrio'           => trim($j['barrio']          ?? ''),
    ];

    try {
        $this->horariosModel->crearColaborador($data);
        return $this->response->setJSON(['status'=>'success']);
    } catch (\Throwable $e) {
        return $this->response->setJSON(['status'=>'error','message'=>$e->getMessage()])
            ->setStatusCode(500);
    }
  }

  public function eliminarColaborador() {
    $json     = $this->request->getJSON(true);
    $documento = trim($json['documento'] ?? '');

    if (!$documento) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Documento inválido'])
            ->setStatusCode(400);
    }

    try {
        $this->horariosModel->eliminarColaborador($documento);
        return $this->response->setJSON(['status' => 'success']);
    } catch (\Throwable $e) {
        return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()])
            ->setStatusCode(500);
    }
  }

  public function crearHorarioColaborador() {
    $json   = $this->request->getJSON(true);
    $nombre = trim($json['nombre'] ?? '');
    $cargo  = trim($json['cargo']  ?? '');

    if (!$nombre) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Nombre requerido'])
            ->setStatusCode(400);
    }

    $existe = $this->db->table('horarios_colaboradores')
        ->where('nombre', $nombre)->where('estado', 'Activo')->countAllResults();
    if ($existe) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Este colaborador ya tiene horario registrado']);
    }

    $data = [
        'nombre'    => $nombre,
        'cargo'     => $cargo,
        'lunes'     => 'Descanso',
        'martes'    => 'Descanso',
        'miercoles' => 'Descanso',
        'jueves'    => 'Descanso',
        'viernes'   => 'Descanso',
        'sabado'    => 'Descanso',
        'domingo'   => 'Descanso',
        'estado'    => 'Activo',
    ];

    try {
        $this->horariosModel->crearHorarioColaborador($data);
        return $this->response->setJSON(['status' => 'success']);
    } catch (\Throwable $e) {
        return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()])
            ->setStatusCode(500);
    }
  }

  public function reportePdf()
  {
      $tipo     = $this->request->getGet('tipo') ?: 'mensual'; // mensual | quincenal
      $mes      = $this->request->getGet('mes')  ?: date('Y-m');
      [$year, $month] = explode('-', $mes);

      if ($tipo === 'quincenal') {
          $q = $this->request->getGet('q') ?: (date('d') <= 15 ? '1' : '2');
          if ($q === '1') {
              $inicio = "$year-$month-01";
              $fin    = "$year-$month-15";
          } else {
              $inicio = "$year-$month-16";
              $fin    = date('Y-m-t', strtotime("$year-$month-01"));
          }
          $titulo = 'REPORTE QUINCENAL — ' . ($q === '1' ? '1ª' : '2ª') . ' QUINCENA';
      } else {
          $inicio = "$year-$month-01";
          $fin    = date('Y-m-t', strtotime("$year-$month-01"));
          $titulo = 'REPORTE MENSUAL';
      }

      $nombreMes = ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'][(int)$month - 1];

      $registros = $this->horariosModel->getAsistenciaPorRango($inicio, $fin);

      // Agrupar y calcular horas por trabajador
      $trabajadores = [];
      foreach ($registros as $r) {
          $key = $r->documento;
          if (!isset($trabajadores[$key])) {
              $trabajadores[$key] = ['nombre' => $r->nombre, 'dias' => 0, 'horas' => 0.0, 'detalle' => []];
          }
          $entrada = strtotime($r->marcacion_ingreso);
          $salida  = strtotime($r->marcacion_salida);
          $horas   = round(($salida - $entrada) / 3600, 2);
          if ($horas > 0) {
              $trabajadores[$key]['dias']++;
              $trabajadores[$key]['horas'] += $horas;
              $trabajadores[$key]['detalle'][] = ['fecha' => $r->fecha, 'h' => $horas];
          }
      }

      require APPPATH . 'Libraries/fpdf/fpdf.php';
      $pdf = new \FPDF('P', 'mm', 'A4');
      $pdf->AddPage();
      $pdf->SetMargins(14, 14, 14);
      $pdf->SetAutoPageBreak(true, 18);
      $W = 182;

      // Encabezado
      $pdf->SetFillColor(23, 58, 16);
      $pdf->SetTextColor(255, 255, 255);
      $pdf->SetFont('Arial', 'B', 13);
      $pdf->Cell($W * 0.65, 10, utf8_decode($titulo), 0, 0, 'L', true);
      $pdf->SetFillColor(45, 102, 34);
      $pdf->SetFont('Arial', 'B', 10);
      $pdf->Cell($W * 0.35, 10, utf8_decode($nombreMes . ' ' . $year), 0, 1, 'C', true);

      $pdf->SetFillColor(240, 247, 236);
      $pdf->SetTextColor(13, 36, 9);
      $pdf->SetFont('Arial', '', 8);
      $pdf->Cell($W, 6, utf8_decode('Período: ' . date('d/m/Y', strtotime($inicio)) . ' — ' . date('d/m/Y', strtotime($fin)) . '   |   Generado: ' . date('d/m/Y H:i')), 0, 1, 'L', true);
      $pdf->Ln(5);

      // Cabecera tabla
      $cW = [10, 72, 20, 28, 28, 24];
      $pdf->SetFillColor(45, 102, 34);
      $pdf->SetTextColor(255, 255, 255);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell($cW[0], 8, '#',                   1, 0, 'C', true);
      $pdf->Cell($cW[1], 8, 'Colaborador',          1, 0, 'L', true);
      $pdf->Cell($cW[2], 8, utf8_decode('Días'),    1, 0, 'C', true);
      $pdf->Cell($cW[3], 8, 'Horas totales',        1, 0, 'C', true);
      $pdf->Cell($cW[4], 8, utf8_decode('Prom./día'), 1, 0, 'C', true);
      $pdf->Cell($cW[5], 8, 'Estado',               1, 1, 'C', true);

      // Horas esperadas según tipo
      $diasPeriodo = (int)((strtotime($fin) - strtotime($inicio)) / 86400) + 1;
      $diasHabiles = (int)round($diasPeriodo * 5 / 7);
      $horasEsperadas = $diasHabiles * 8;

      $pdf->SetTextColor(13, 36, 9);
      $pdf->SetFont('Arial', '', 8);
      $fila = 1;
      $totalHoras = 0;
      $totalDias  = 0;

      foreach ($trabajadores as $doc => $t) {
          $promedio = $t['dias'] > 0 ? round($t['horas'] / $t['dias'], 1) : 0;
          $cumple   = $t['horas'] >= $horasEsperadas;
          $bg       = $cumple ? [209, 250, 229] : [254, 226, 226];
          $estado   = $cumple ? 'Cumple' : 'Pendiente';

          $pdf->SetFillColor(...$bg);
          $pdf->Cell($cW[0], 7, $fila,                              1, 0, 'C', true);
          $pdf->Cell($cW[1], 7, utf8_decode($t['nombre']),          1, 0, 'L', true);
          $pdf->Cell($cW[2], 7, $t['dias'],                         1, 0, 'C', true);
          $pdf->Cell($cW[3], 7, number_format($t['horas'], 1) . ' h', 1, 0, 'C', true);
          $pdf->Cell($cW[4], 7, $promedio . ' h',                   1, 0, 'C', true);
          $pdf->Cell($cW[5], 7, $estado,                            1, 1, 'C', true);

          $totalHoras += $t['horas'];
          $totalDias  += $t['dias'];
          $fila++;
      }

      if (empty($trabajadores)) {
          $pdf->SetFillColor(248, 248, 248);
          $pdf->Cell(array_sum($cW), 7, utf8_decode('Sin registros de asistencia en este período.'), 1, 1, 'C', true);
      } else {
          // Fila totales
          $pdf->SetFillColor(23, 58, 16);
          $pdf->SetTextColor(255, 255, 255);
          $pdf->SetFont('Arial', 'B', 8);
          $pdf->Cell($cW[0] + $cW[1], 7, utf8_decode('TOTALES'), 1, 0, 'C', true);
          $pdf->Cell($cW[2], 7, $totalDias,                                          1, 0, 'C', true);
          $pdf->Cell($cW[3], 7, number_format($totalHoras, 1) . ' h',                1, 0, 'C', true);
          $pdf->Cell($cW[4] + $cW[5], 7, count($trabajadores) . ' colaboradores',   1, 1, 'C', true);
      }

      // Nota al pie
      $pdf->Ln(8);
      $pdf->SetTextColor(100, 100, 100);
      $pdf->SetFont('Arial', 'I', 7);
      $pdf->Cell($W, 5, utf8_decode('* Horas esperadas por período (' . $diasHabiles . ' días hábiles × 8 h): ' . $horasEsperadas . ' h  |  CristalBusiness'), 0, 1, 'L');

      $this->response->setHeader('Content-Type', 'application/pdf');
      $pdf->Output('I', 'horas_' . $tipo . '_' . $mes . '.pdf');
  }

  public function guardar() {
    $json = $this->request->getJSON(true);
    $id   = (int)($json['id'] ?? 0);

    if (!$id) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'ID inválido'])
            ->setStatusCode(400);
    }

    $campos = ['lunes','martes','miercoles','jueves','viernes','sabado','domingo'];
    $data   = [];
    foreach ($campos as $d) {
        $data[$d] = $json[$d] ?? 'Descanso';
    }
    $data['comentario'] = $json['comentario'] ?? '';

    $this->horariosModel->guardarHorario($id, $data);
    return $this->response->setJSON(['status' => 'success']);
  }
}

?>
    
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
    
<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class HorariosController extends BaseController {

  public function __construct() {
     $this->listasModel = new \App\Models\ListasModel();
     $this->horariosModel = new \App\Models\HorariosModel();
  }

  public function index(){
    $data = [
        'permisoUsuario' => $this->listasModel->getPermisosMenu(),
        'colaboradores'  => $this->horariosModel->getColaboradores(),
        'horarios'       => $this->horariosModel->getHorarios(),
        'activosHoy'     => $this->horariosModel->getActivosHoy(),
        'salidaHoy'      => $this->horariosModel->getSalidaHoy(),
    ];
    return view('administrador/horarios', $data);
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
    
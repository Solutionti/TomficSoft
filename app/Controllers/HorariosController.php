<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class HorariosController extends BaseController {

  public function __construct() {
     $this->listasModel = new \App\Models\ListasModel();
  }

  public function index(){
    $data = [
         'permisoUsuario' => $this->listasModel->getPermisosMenu(),
      ];
    return view('administrador/horarios', $data);
  }

  public function actualizar()
{
    $json = $this->request->getJSON(true);
    
    $model = new HorariosModel();
    $model->where('empleado_id', $json['emp_id'])
          ->where('dia', $json['dia'])
          ->set([
              'tipo_turno'   => $json['tipo'],
              'hora_entrada' => $json['entrada'],
              'hora_salida'  => $json['salida'],
              'horas_extra'  => $json['extra'],
              'observaciones'=> $json['obs']
          ])->update();

    return $this->response->setJSON(['status' => 'ok']);
}
}

?>
    
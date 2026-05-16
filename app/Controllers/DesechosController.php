<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class DesechosController extends BaseController {

  public function __construct() {
     $this->listasModel = new \App\Models\ListasModel();
  }

  public function index(){
    $data = [
         'permisoUsuario' => $this->listasModel->getPermisosMenu(),
      ];
    return view('administrador/desechos', $data);
  }
}

?>
    
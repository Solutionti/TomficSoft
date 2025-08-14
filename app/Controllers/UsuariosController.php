<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsuariosModel;

class UsuariosController extends BaseController {

  public function __construct() {
    $this->usuariosModel = new UsuariosModel();
  }

  public function index() {
     $data = [
      'permisos' => $this->usuariosModel->getPermisos()
     ];
     if(session()->get('logeado') == true) {
      return view('administrador/usuarios', $data); 
    }
    else {
      return view('iniciarsesion');
    }
  }

}

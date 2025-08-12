<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UsuariosController extends BaseController {

  public function index() {
     if(session()->get('logeado') == true) {
      return view('administrador/usuarios'); 
    }
    else {
      return view('iniciarsesion');
    }
  }

}

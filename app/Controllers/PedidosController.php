<?php

namespace App\Controllers;
use App\Models\ListasModel;

class PedidosController extends BaseController {

    public function __construct() {
      $this->listasModel = new ListasModel();
    }

    public function index() {
      if(session()->get('logeado') == true) {
         $data = [
          'permisoUsuario' => $this->listasModel->getPermisosMenu(),
         ];
        return view('administrador/pedidos', $data); 
     }
    else {
        return view('iniciarsesion');
    }
  }
}
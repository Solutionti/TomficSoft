<?php

namespace App\Controllers;
use App\Models\ListasModel;
use App\Models\PedidosModel;

class PedidosController extends BaseController {

    public function __construct() {
      $this->listasModel = new ListasModel();
      $this->pedidosModel = new PedidosModel();
    }

    public function index() {
      $data = [
        'permisoUsuario' => $this->listasModel->getPermisosMenu(),
        'pedidos' => $this->pedidosModel->getPedidos(),
      ];
      return view('administrador/pedidos', $data); 
    
  }
}
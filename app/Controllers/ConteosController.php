<?php

namespace App\Controllers;
use App\Models\ConteosModel;

class ConteosController extends BaseController {


  public function __construct() {
    $this->conteosModel = new ConteosModel();
  }

  public function index(): string {
    if(session()->get('logeado') == true) {
       return view('administrador/conteos');
    }
    else {
      return view('iniciarsesion');
    }
  }

  public function buscarProducto($codigo_producto) {

    $producto = $this->conteosModel->buscarProducto($codigo_producto);

    if(!empty($producto)){
      return $this->response->setJSON($producto);
    }
    else {
      echo "error";
    }
    
  }

  public function guardarConteo() {
    
  }

  public function actualizarConteo() {
    
  }

}

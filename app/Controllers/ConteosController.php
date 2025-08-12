<?php

namespace App\Controllers;

class ConteosController extends BaseController {


  public function index(): string {
    if(session()->get('logeado') == true) {
       return view('administrador/conteos');
    }
    else {
      return view('iniciarsesion');
    }
  }

  public function buscarProducto(): string {
    
  }

  public function guardarConteo(): string {
    
  }

  public function actualizarConteo(): string {
    
  }

}

<?php

namespace App\Controllers;

class InicioController extends BaseController {


  public function index(): string {
    if(session()->get('logeado') == true) {
      return view('administrador/inicio');
    }
    else {
      return view('iniciarsesion');
    }
    
  }

  

}

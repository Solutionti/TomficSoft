<?php

namespace App\Controllers;
use App\Models\ListasModel;

class InicioController extends BaseController {

  public function __construct() {
      $this->listasModel = new ListasModel();
  } 

  public function index(): string {
    
      $data = [
        "permisoUsuario" => $this->listasModel->getPermisosMenu()
      ];
      return view('administrador/inicio', $data);
    
    
  }

  

}

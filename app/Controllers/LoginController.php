<?php

namespace App\Controllers;
use App\Models\LoginModel;

class LoginController extends BaseController {

  public function __construct() {
    $this->loginModel = new LoginModel();
  }

  public function index(): string {

    if(session()->get('logeado') == true) {
      return view('administrador/inicio');
    }
    else {
      return view('iniciarsesion');
    }
    
  }

  public function iniciarSesion() {
    
    $correo = $this->request->getPost('usuario');
    $password = $this->request->getPost('password');

    $respuesta = $this->loginModel->iniciarSesion($correo, $password);

    if($respuesta == false) {
      echo "error";
    }
    else {
      session()->set([
        "codigo" => $respuesta->codigo_usuario,
        "nombre" => $respuesta->nombre,
        "apellido" => $respuesta->apellido,
        "documento" => $respuesta->documento,
        "empresa" => $respuesta->empresa,
        "rol_usuario" => $respuesta->rol_usuario,
        "estado" => $respuesta->estado,
        "logeado" => true
      ]);
    }


  }

  public function cerrarSesion() {
     session()->destroy();
     return redirect()->to('/');
  }

}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsuariosModel;
use App\Models\ListasModel;

class UsuariosController extends BaseController {

  public function __construct() {
    $this->usuariosModel = new UsuariosModel();
    $this->listasModel = new ListasModel();
  }

  public function index() {
     $data = [
      'permisos' => $this->usuariosModel->getPermisos(),
      'empresas' => $this->listasModel->getEmpresas(),
      'usuarios' => $this->listasModel->getUsuarios(),
     ];
     if(session()->get('logeado') == true) {
      return view('administrador/usuarios', $data); 
    }
    else {
      return view('iniciarsesion');
    }
  }

  public function crearUsuario() {

    //definimos las variables que llegan del los campos input 
    $documento = $this->request->getPost('documento');
    $nombre = $this->request->getPost('nombre');
    $apellido = $this->request->getPost('apellido');
    $empresa = $this->request->getPost('empresa');
    $telefono = $this->request->getPost('telefono');
    $estado = $this->request->getPost('estado');
    $rol = $this->request->getPost('rol');
    $fecha = $this->request->getPost('fecha');
    $hora = $this->request->getPost('hora');
    $usuario = $this->request->getPost('usuario');
    $contraseña = $this->request->getPost('contraseña');
    $repetirContraseña = $this->request->getPost('repetirContraseña');

    // crear un array con todos los campos que defini anteriormente

    $data = [
      'documento' => $documento,
      'nombre' => $nombre,
      'apellido' => $apellido,
      'empresa' => $empresa,
      'telefono' => $telefono,
      'estado' => $estado,
      'rol' => $rol,
      'fecha' => $fecha,
      'hora' => $hora,
      'usuario' => $usuario,
      'password' => $contraseña,
    ];

    //llamar el modelo para ejecutar el insert 
    $this->usuariosModel->CrearUsuarios($data);

    
  }

}

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
          'permisoUsuario' => $this->listasModel->getPermisosMenu(),
          'permisos' => $this->usuariosModel->getPermisos(),
          'empresas' => $this->listasModel->getEmpresas(),
          'usuarios' => $this->listasModel->getUsuarios(),
         ];
      return view('administrador/usuarios', $data); 
  }

 public function crearUsuario()
{
    try {
        //definimos las variables que llegan del los campos input 
        $documento = $this->request->getPost('documento');
        $nombre = $this->request->getPost('nombre');
        $apellido = $this->request->getPost('apellido');
        $empresa = $this->request->getPost('empresa');
        $telefono = $this->request->getPost('telefono');
        $estado = $this->request->getPost('estado');
        $correo = $this->request->getPost('correo');
        $rol = $this->request->getPost('rol');
        $fecha = $this->request->getPost('fecha');
        $hora = $this->request->getPost('hora');
        $usuario = $this->request->getPost('usuario');
        $contraseña = $this->request->getPost('contraseña');
        $repetirContraseña = $this->request->getPost('repetirContraseña');
        $permisos = $this->request->getPost('permisos');
        
        

        // crear un array con todos los campos que defini anteriormente
        $data = [
            'documento' => $documento,
            'nombre'    => $nombre,
            'apellido'  => $apellido,
            'empresa'   => $empresa,
            'telefono'  => $telefono,
            'estado'    => $estado,
            'correo'    => $correo,
            'rol'       => $rol,
            'fecha'     => $fecha,
            'hora'      => $hora,
            'usuario'   => $usuario,
            'password'  => $contraseña,
        ];

        // insert usuario
        $this->usuariosModel->CrearUsuarios($data);

        // asignar permisos SOLO si vienen
        if (!empty($permisos) && is_array($permisos)) {
            foreach ($permisos as $permiso) {
                $permisact = $this->usuariosModel->getPermisoAsignar($permiso);
                $data2 = [
                    "nombre"  => $permisact->nombre,
                    "url"     => $permisact->url,
                    "icono"   => $permisact->icono,
                    "orden"   => $permisact->orden,
                    "usuario" => $documento,
                    "estado"  => "Activo"
                ];
                $this->usuariosModel->crearPermisosUsuario($data2);
            }
        }

        // devuelve  JSON cuando todo es éxitoso
        return $this->response->setJSON([
            "status"  => "success",
            "message" => "Usuario creado correctamente"
        ]);

    } catch (\Throwable $e) {
        //atrapar errores y responder
        return $this->response->setJSON([
            "status"  => "error",
            "message" => "Error en el servidor: " . $e->getMessage()
        ])->setStatusCode(500);
    }
}

public function mostrarDatosUsuarioModal($id){
    // $id = $this->request->getPost('id');

    $uuario = $this->usuariosModel->mostrarDatosUsuarioModal($id)->getResult();

    //enviar los datos de tipo JSON al javascriot
    return $this->response->setJSON($uuario);
}

public function actualizarUsuario() {

    try {
        $documento = $this->request->getPost('documento');
        $nombre = $this->request->getPost('nombre');
        $apellido = $this->request->getPost('apellido');
        $empresa = $this->request->getPost('empresa');
        $telefono = $this->request->getPost('telefono');
        $estado = $this->request->getPost('estado');
        $email = $this->request->getPost('email');
        $rol = $this->request->getPost('rol');
        $fecha = $this->request->getPost('fecha');
        $hora = $this->request->getPost('hora');
        $usuario = $this->request->getPost('usuario');
    
        $datos = [
          'documento' => $documento,
          'usuario' => $usuario,
          'email' => $email,
          'nombre' => $nombre,
          'apellido' => $apellido,
          'empresa' => $empresa,
          'telefono' => $telefono,
          'rol_usuario' => $rol,
          'estado' => $estado,
        ];
    
        $this->usuariosModel->actualizarUsuario($datos);

         return $this->response->setJSON([
            "status"  => "success",
            "message" => "Usuario actualizado correctamente"
         ]);

    }catch (\Throwable $e) {
        return $this->response->setJSON([
            "status"  => "error",
            "message" => "Error en el servidor: " . $e->getMessage()
        ])->setStatusCode(500);
    }
}

public function eliminarusuario() {
    try {
      $id = $this->request->getPost('id');
    
      $this->usuariosModel->eliminarUsuiario($id);
      
      return $this->response->setJSON([
            "status"  => "success",
            "message" => "el Usuario se ha eliminado correctamente"
         ]);  
    }
    catch (\Throwable $e) {
        return $this->response->setJSON([
            "status"  => "error",
            "message" => "Error en el servidor: " . $e->getMessage()
        ])->setStatusCode(500);
    }

}
  

}

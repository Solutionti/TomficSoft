<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuariosModel extends Model {
  
    public function getPermisos() {
      $query = $this->db->table('permisos')
             ->select('*')
             ->where('estado', 'Activo')
             ->get();

      return $query;
    }

    public function getPermisoAsignar($codigo) {
      $query = $this->db->table('permisos')
             ->select('*')
             ->where('codigo_permiso', $codigo)
             ->get();

      return $query->getRow();
    }

    public function crearPermisosUsuario($data) {
      $permisos = [
        "nombre" => $data["nombre"],
        "url" => $data["url"],
        "usuario" => $data["usuario"],
        "estado" => $data["estado"],
      ];
      $this->db->table('permiso_usuarios')
               ->insert($permisos);
    }

    public function CrearUsuarios($data) {
      //crear el array de los datos que voy a insertar
      $usuarios = [
        'usuario' => $data["usuario"],
        'password' => password_hash($data["password"], PASSWORD_DEFAULT),
        'email' => $data["correo"],
        'nombre' => $data["nombre"],
        'apellido' => $data["apellido"],
        'documento' => $data["documento"],
        'empresa' => $data["empresa"],
        'telefono' => $data["telefono"],
        'hora' => $data["hora"],
        'fecha' => $data["fecha"],
        'rol_usuario' => $data["rol"],
        'estado' => $data["estado"],
        'usuario_creacion' => session()->get('documento'),
      ];
      //llamar la funcion de codeigniter que me inserta en la base de datos
        $this->db->table('usuarios')
                 ->insert($usuarios);
    }



}

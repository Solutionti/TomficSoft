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
        "icono" =>  $data["icono"],
        "orden" =>  $data["orden"],
        "estado" => $data["estado"],
      ];
      $this->db->table('permiso_usuarios')
               ->insert($permisos);
    }

    public function CrearUsuarios($data) {

      if($data["rol"] == "Administrador") {
        $rolAct = "Experto en Inventarios";
      }
      else if ($data["rol"] == "Capturador") {
        $rolAct = "Auxiliar Capturador";
      }
      
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
        'descripcion_rol' => $rolAct,
        'estado' => $data["estado"],
        'usuario_creacion' => session()->get('documento'),
      ];
      //llamar la funcion de codeigniter que me inserta en la base de datos
        $this->db->table('usuarios')
                 ->insert($usuarios);
    }

    public function mostrarDatosUsuarioModal($id){
      $query = $this->db->table('usuarios')
             ->select('*')
             ->where('codigo_usuario', $id)
             ->get();

      return $query;
    }

    public function eliminarUsuiario($id) {
       $this->db->table('usuarios')
                 ->where('codigo_usuario', $id)
                 ->delete();
    }

    public function actualizarUsuario($data){
       $usuarios = [
        'usuario' => $data["usuario"],
        'email' => $data["email"],
        'nombre' => $data["nombre"],
        'apellido' => $data["apellido"],
        'empresa' => $data["empresa"],
        'telefono' => $data["telefono"],
        'rol_usuario' => $data["rol_usuario"],
        'estado' => $data["estado"],
      ];

      $this->db->table('usuarios')
                ->where('documento', $data["documento"])
                ->update($usuarios);
    }

    

    


}

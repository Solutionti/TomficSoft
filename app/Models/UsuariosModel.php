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
}

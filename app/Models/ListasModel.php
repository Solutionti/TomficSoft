<?php

namespace App\Models;

use CodeIgniter\Model;

class ListasModel extends Model {

    public function getEmpresas() {
      $query = $this->db->table('empresas')
             ->select("*")
             ->get();

      return $query;
    }

    public function getUsuarios(){
      $query = $this->db->table('usuarios')
             ->select('*')
             ->get();

      return $query;
    }
    
}

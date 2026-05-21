<?php

namespace App\Models;

use CodeIgniter\Model;

class HorariosModel extends Model {
  
    public function getColaboradores() {
      $query = $this->db->table('colaboradores')
                    ->select('*')
                    ->get();

        return $query;
    }
}
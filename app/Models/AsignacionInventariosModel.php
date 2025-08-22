<?php

namespace App\Models;

use CodeIgniter\Model;

class AsignacionInventariosModel extends Model
{
   public function getAsignacion(){
    
    $query = $this->db->table('inventarios')
                      ->select('*')
                      ->get();

    return $query;

   }

   
}

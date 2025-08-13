<?php

namespace App\Models;

use CodeIgniter\Model;

class ConteosModel extends Model {

  public function buscarProducto($codigo){
    
    $query = $this->db->table('productos')
           ->select('*')
           ->where('codigo_barras', $codigo)
           ->orWhere('codigo_producto', $codigo)
           ->get();

    return $query->getResult();
    
    

  }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class InventarioModel extends Model
{
    
    public function getProductos()
    {
        $query = $this->db->table('productos')
                ->select('*')
                ->get();

        return $query;
    }

    public function getCategorias()
    {
        $query = $this->db->table('categorias')
                ->select('*')
                ->get();

        return $query;
    }

}

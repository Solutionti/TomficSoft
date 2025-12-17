<?php

namespace App\Models;
use CodeIgniter\Model;

class PedidosModel extends Model {

    public function getPedidos() {
      $pedidos = $this->db->table('pedidos')
                        ->orderBy('estado', 'DESC')
                        ->get();

      return $pedidos;
                         
    }
}
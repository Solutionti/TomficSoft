<?php

namespace App\Models;

use CodeIgniter\Model;

class InicioModel extends Model {
  
  public function countProductos() {
    $productos = $this->db->table("productos")
                          ->selectCount('codigo_producto', 'total_productos')
                          ->get();

    return $productos;
                          
  }

  public function countInventarios() {
    $inventarios = $this->db->table("inventarios")
                          ->selectCount('codigo_inventario', 'total_inventarios')
                          ->get();

    return $inventarios;
  }

  public function countProductosPerdida($estado) {
    $estado = $this->db->table("captura_conteos")
                          ->selectCount('codigo_captura', 'total_estado')
                          ->where('estado', $estado)
                          ->get();

    return $estado;
  }

  public function countEstadoProducto() {
    $estado = $this->db->table("captura_conteos")
                          ->select('estado, COUNT(codigo_captura) AS total_estado')
                          ->where("estado", "Averiado")
                          ->where("estado", "Vencido")
                          ->get();

    return $estado;
  }

  public function countReportados() {
    $inventarios = $this->db->table("asignacion_productos")
                          ->selectCount('codigo_asignacion', 'total_reportados')
                          ->get();

    return $inventarios;
  }
}
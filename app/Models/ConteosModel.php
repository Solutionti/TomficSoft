<?php

namespace App\Models;

use CodeIgniter\Model;

class ConteosModel extends Model {

  public function getProductos() {
    $query = $this->db->table('productos')
           ->select('*')
           ->where('estado', 'Activo')
           ->get();

    return $query;
  }

  public function buscarProducto($codigo){
    
    $query = $this->db->table('productos')
           ->select('*')
           ->where('codigo_barras', $codigo)
           ->orWhere('codigo_interno', $codigo)
           ->get();

    return $query->getResult();

  }

  public function guardarProductoExcel($datos) {
    $productos = [
      "codigo_interno" => $datos['codigo_interno'],
      "codigo_barras" => $datos['codigo_barras'],
      "nombre" => $datos['nombre'],
      "referencia" => $datos['referencia'],
      "nit" => $datos['nit'],
      "proveedor" => $datos['proveedor'],
      "categoria" => $datos['categoria'],
      "subcategoria" => $datos['subcategoria'],
      "grupo" => $datos['grupo'],
      "subgrupo" => $datos['subgrupo'],
      "saldo" => $datos['saldo'],
      "costo" => $datos['costo'],
    ];
    $this->db->table('productos')
    ->insert($productos);
  }
}

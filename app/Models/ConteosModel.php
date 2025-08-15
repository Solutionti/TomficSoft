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

  public function validarExistenciaProductoConteo($codigo) {
    $query = $this->db->table('captura_conteos')
                      ->select('*')
                      ->where('codigo_producto', $codigo)
                      ->get();

    return $query->getResult();
  }

  public function guardarConteo($datos){
    $conteo = [
      "codigo_producto" => $datos["codigo_producto"],
      "nombre" => $datos["nombre_producto"],
      "referencia" => $datos["referencia"],
      "estado" => $datos["estado_producto"],
      "observacion" => $datos["observacion"],
      "ubicacion" => $datos["ubicacion"],
      "localizacion" => $datos["localizacion"],
      "num_localizacion" => $datos["numero_localizacion"],
      "conteo1" => $datos["total"],
      "usuario" => session()->get('documento'),
      "fecha" => date("Y-m-d"),
      "hora" => date("H:i:s"),
      "saldo" => $datos["saldo"],
      "diferencia" => $datos["diferencia"],
    ];
    $this->db->table('captura_conteos')
             ->insert($conteo);
  }

  public function actualizarConteo($datos) {
    $conteo2 = [
      "referencia" => $datos["referencia"],
      "estado" => $datos["estado_producto"],
      "observacion" => $datos["observacion"],
      "ubicacion" => $datos["ubicacion"],
      "localizacion" => $datos["localizacion"],
      "num_localizacion" => $datos["numero_localizacion"],
      "conteo1" => $datos["total"],
      "saldo" => $datos["saldo"],
      "diferencia" => $datos["diferencia"],
    ];
    
    $this->db->table('captura_conteos')
             ->where('codigo_producto', $datos['codigo_producto'])
             ->update($conteo2);
  }
}

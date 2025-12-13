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

  public function getProductosAsignacion() {
    $query = $this->db->table('asignacion_productos as ap')
                      ->select('ap.*, p.*')
                      ->join('productos p', 'ap.codigo_producto = p.codigo_barras')
                      ->where('p.estado', 'Activo')
                      ->where('ap.codigo_inventario', session()->get('inventario'))
                      ->get();

    return $query;
  }

  public function buscarProducto($codigo){
    
    $query = $this->db->table('asignacion_productos as ap')
                      ->select('ap.*,p.*, in.*')
                      ->join('productos p', 'ap.codigo_producto = p.codigo_barras')
                      ->join('inventarios in', 'ap.codigo_inventario = in.codigo_inventario')
                      ->where('ap.codigo_inventario', session()->get('inventario'))
                      ->where('p.codigo_barras', $codigo)
                      ->orWhere('p.codigo_interno', $codigo)
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
      "estado" => "Activo"
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
      "codigo_inventario" => session()->get('inventario'),
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

  public function getInventariosSesion() {
    $query = $this->db->table('inventarios as in')
                      ->select('in.*, us.usuario as usuario1')
                      ->join("usuarios as us", "in.usuarioconteo1 = us.documento")
                      ->where('in.usuarioconteo1', session()->get('documento'))
                      ->orWhere('in.usuarioconteo2', session()->get('documento'))
                      ->get();

    return $query;
   }

   public function cerrarInventario($codigo) {
    $data = [
      "estado" => "Cerrado",
      "fecha_cierre" => date("Y-m-d"),
    ];

    $this->db->table('inventarios')
             ->where('codigo_inventario', $codigo)
             ->update($data);
   }
}

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

    public function getEmpresas(){
        $query = $this->db->table('empresas')
                ->select('*')
                ->get();

        return $query;
    }

    public function agregarProductos($data){
        $productos = [
            'categoria' => $data['categoria'],
            'subcategoria' => $data['subcategoria'],
            'grupo' => $data['grupo'],
            'subgrupo' => $data['subgrupo'],
            'nombre' => $data['nombre'],
            'referencia' => $data['referencia'],
            'codigo_interno' => $data['codigointerno'],
            'codigo_Barras' => $data['codigoBarras'],
            'nit' => $data['nit'],
            'proveedor' => $data['proveedor'],
            'saldo' => $data['saldo'],
            'costo' => $data['costo'],
            'estado' => 'Activo',
        ];
        // insertar en la base de datos
        $this->db->table('productos')
                 ->insert($productos);
    }

    public function mostrarDatosProductosModal($id){
        $query = $this->db->table('productos')
                ->select('*')
                ->where('codigo_producto ', $id)
                ->get();

        return $query;
    }

    public function actualizarProductos($data){
        //codigo para actualizar productos
        $productos = [
            'categoria' => $data['categoria'],
            'subcategoria' => $data['subcategoria'],
            'grupo' => $data['grupo'],
            'subgrupo' => $data['subgrupo'],
            'nombre' => $data['nombre'],
            'referencia' => $data['referencia'],
            'codigo_interno' => $data['codigo_interno'],
            'codigo_barras' => $data['codigo_barras'],
            'nit' => $data['nit'],
            'proveedor' => $data['proveedor'],
            'saldo' => $data['saldo'],
            'costo' => $data['costo'],
        ];
        // actualizar en la base de datos
        $this->db->table('productos')
                 ->where('codigo_interno', $data['codigo_interno'])   
                 ->update($productos);
    }

    public function eliminarProducto($id){
        // eliminar producto de la base de datos
        $this->db->table('productos')
                 ->where('codigo_producto', $id)
                 ->delete();
    }

    public function obtenerstock($codigo) {

      $producto = $this->db->table('productos')
                ->select('*')
                ->where('codigo_barras', $codigo)
                ->get();

      return $producto->getResult();
    
    }

    public function ingresarEntradaProductos($data) {
        $kardex = [
          "id_producto" => $data["producto"],
          "tp_documento" => "ENT",
          "entrada" => $data["cantidad"],
          "salida" => 0,
          "devolucion" => 0,
          "fecha" => date("Y-m-d"),
          "hora" => date("H:i:s"),
          "descripcion" => $data["comentarios"],
          "usuario" => session()->get('documento'),
          "sede" => $data["sede"],
          "motivo" => $data["motivo"],
          "saldo" => 0,
        ];
        $this->db->table('kardex')
                 ->insert($kardex);

        $productos = [
          "saldo" => $data["stock"] + $data["cantidad"],
        ];
        $this->db->table('productos')
                  ->where('codigo_barras', $data["producto"])
                  ->update($productos);
    }

    public function ingresarSalidaProductos($data) {
        $kardex = [
          "id_producto" => $data["producto"],
          "tp_documento" => "SAL",
          "entrada" => 0,
          "salida" => $data["cantidad"],
          "devolucion" => 0,
          "fecha" => date("Y-m-d"),
          "hora" => date("H:i:s"),
          "descripcion" => $data["comentarios"],
          "usuario" => session()->get('documento'),
          "sede" => $data["sede"],
          "motivo" => $data["motivo"],
          "saldo" => 0,
        ];
        $this->db->table('kardex')
                 ->insert($kardex);

        $productos = [
          "saldo" => $data["stock"] - $data["cantidad"],
        ];
        $this->db->table('productos')
                  ->where('codigo_barras', $data["producto"])
                  ->update($productos);
    }


}

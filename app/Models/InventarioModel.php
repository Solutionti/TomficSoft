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


}

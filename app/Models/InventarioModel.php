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

}

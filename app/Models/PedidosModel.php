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

    public function getPedidoId($codigo) {
      $pedido = $this->db->table('pedidos p')
                         ->select("p.*, c.nombre,c.apellido, c.direccion")
                         ->join("clientes c", "p.codigo_cliente = c.celular")
                         ->where('p.codigo_pedido', $codigo)
                         ->get();

      return $pedido->getRow();
    }

    public function getPedidosDetalle($codigo) {
      $detalle = $this->db->table('detalle_pedido d')
                          ->select("d.*, p.nombre as productonom, p.costo")
                          ->join("productos p", "d.codigo_producto = p.codigo_barras")
                          ->where("d.codigo_pedido", $codigo)
                          ->get();

      return $detalle;
    }

    public function actualizarPedido($datos) {
      $this->db->table('pedidos')
               ->where('consecutivo', $datos['codigo_pedido'])
               ->update([
                 'domicilio' => $datos['domicilio'],
                 'estado' => $datos['estado']
               ]);
    }

    public function getPedidosTiempoReal() {

        $pedido = $this->db->table("pedidos")
                ->select("*")
                ->limit('10')
                ->get();

        return $pedido;
    }
}
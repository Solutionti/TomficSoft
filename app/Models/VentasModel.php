<?php

namespace App\Models;

use CodeIgniter\Model;

class VentasModel extends Model  {

    public function getProductoVenta($codigo) {
      $producto = $this->db->table('productos')
                 ->select('*')
                 ->where('codigo_barras', $codigo)
                 ->orWhere('codigo_interno', $codigo)
                 ->get();
                 
      return $producto->getRow();
    }

    public function getVentaRepetida($consecutivo) {
      $venta = $this->db->table('ventas')
               ->select('*')
               ->where('codigo_consecutivo', $consecutivo)
               ->get();

      if( $venta->getNumRows() > 0 ) {
        return 1;
      } 
      else {
        return 0;
      }
    }

    public function crearVenta($data) {
      $datos = [
        "codigo_consecutivo" => $data["consecutivo"],
        "documento" => $data["documento"],
        "sede" => $data["sede"],
        "fecha" => date("Y-m-d"),
        "hora" => date("h: i A"),
        "tipo_pago" => $data["tipo_pago"],
        "ref_pago" => $data["referencia"],
        "total_recibido" => $data["total_recibido"],
        "total_venta" => $data["total_venta"],
        "cantidad_productos" => $data["cantidad_productos"],
        "usuario" => session()->get('documento'),
        "id_caja" => $data["id_caja"],
        "descuento" => $data["descuento"],
        "transaccion" => $data["transaccion"],
        // "dia" => "lunes",
      ];

       $this->db->table('ventas')
               ->insert($datos);

      return $this->db->insertID();
    }

    public function getInventarioStock($codigo) {
        $producto = $this->db->table('productos')
                     ->select('*')
                     ->where('codigo_barras', $codigo)
                     ->orWhere('codigo_interno', $codigo)
                     ->get();
                     
        return $producto->getRow();
    }

    public function updateInventarioStock($codigo, $stockact) {
      $datos = [
        "saldo" => $stockact 
      ];
        $this->db->table('productos')
             ->where('codigo_barras', $codigo)
             ->orWhere('codigo_interno', $codigo)
             ->update($datos);
    }

    public function CrearDetalleVenta($data) {
        $datos = [
         "codigo_venta" => $data["codigo_venta"],
         "codigo_producto" => $data["venta"],
         "cantidad" => $data["cantidad"],
         "fecha" => date("Y-m-d"),
         "hora" => date("h: i A"),
         "usuario" => session()->get('documento'),
         "devolucion" => 0,
         "descontado" => 1,
         "mesa" => 0,
         "estado" => "DESCONTADO",
         "consec_venta" => 1,
         "categoria" => $data["categoria"],
         "valor" => $data["precio"],
        ];
        $this->db->table('detalle_venta')
             ->insert($datos);
    }
}
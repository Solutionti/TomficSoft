<?php

namespace App\Models;
use CodeIgniter\Model;

class ReportesModel extends Model {

  public function productosSinConteo($fechaInicio, $fechaFin) {
     $sql = "
       SELECT 
         ap.codigo_inventario,
         co.codigo_interno,
         ap.codigo_producto,
         co.nombre,
         co.referencia,
         co.categoria,
         co.subcategoria,
         co.grupo,
         ap.fecha,
         co.saldo,
         co.saldo * co.costo AS valor
      FROM asignacion_productos ap
      LEFT JOIN productos co ON co.codigo_barras = ap.codigo_producto
      LEFT JOIN captura_conteos cc ON cc.codigo_producto = ap.codigo_producto 
                                   AND cc.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
      WHERE 
        ap.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
        AND cc.codigo_producto IS NULL
      ";
      
      $query = $this->db->query($sql);  
      $resultado = $query->getResult();

      return $resultado;
  }

  public function diferenciaConteos($fechaInicio, $fechaFin) {
    $sql = "
      WITH conteos AS (
      SELECT 
        ci.codigo_producto,
        ci.nombre,
        ci.referencia,
        ci.conteo1,
        ci.conteo2,
        CASE 
            WHEN ci.conteo1 = ci.conteo2 THEN ci.conteo1
            ELSE ci.conteo2
        END AS cantidad_fisica
      FROM captura_conteos ci
      WHERE fecha BETWEEN '$fechaInicio' AND '$fechaFin'
    )
    SELECT 
      c.codigo_producto,
      c.nombre,
      c.referencia,
      p.categoria,
      p.subcategoria,
      p.subgrupo,
      p.nit,
      p.proveedor,
      p.saldo,
      c.cantidad_fisica,
      (IFNULL(c.cantidad_fisica,0) - IFNULL(p.saldo,0)) AS diferencias,
      (IFNULL(c.cantidad_fisica,0) - IFNULL(p.saldo,0)) * p.costo AS valor_diferencia
    FROM conteos c
    INNER JOIN productos p ON c.codigo_producto = p.codigo_barras
  ";

  $query = $this->db->query($sql);  
  $resultado = $query->getResult();

  return $resultado;
}

}
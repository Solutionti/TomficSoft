<?php

namespace App\Models;
use CodeIgniter\Model;

class ReportesModel extends Model {

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
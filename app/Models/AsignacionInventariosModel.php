<?php

namespace App\Models;

use CodeIgniter\Model;

class AsignacionInventariosModel extends Model
{
   public function getAsignacion(){
    
    $query = $this->db->table('inventarios')
                      ->select('*')
                      ->get();

    return $query;

   }

   public function crearInventarios($fecha, $descripcion){
      
      $inventario = [
        'fecha' => date("Y-m-d"),
        'observacion' => $descripcion,
        'fecha_inicio' => date("Y-m-d"),
        'fecha_cierre' => '',
        'estado' => 'Activo',
        'proceso_final' => 'En ejecucion',
        'usuario' => session()->get('documento'),
      ];

      //llamar la tabla conexion
      $this->db->table('inventarios')
      //insetar los datos
               ->insert($inventario);
   }

   
}

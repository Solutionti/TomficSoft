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
      
      $inventarios = [
        'fecha' => $fecha,
        'observacion' => $descripcion,
        'fecha_inicio' => $fecha,
        'fecha_cierre' => '',
        'estado' => 'Activo',
        'proceso_final' => 'En ejecucion',
        'usuario' => session()->get('documento'),
      ];

      //llamar la tabla conexion
      $this->db->table('inventarios')
      //insetar los datos
               ->insert($inventarios);
      

   }

   
}

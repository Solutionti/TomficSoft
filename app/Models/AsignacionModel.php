<?php

namespace App\Models;

use CodeIgniter\Model;

class AsignacionModel extends Model {

    public function getAsignacion(){
    
    $query = $this->db->table('inventarios')
                      ->select('*')
                      ->get();

    return $query;

   }

   public function procesoDatosModal($codigo){
    
    $query = $this->db->table('inventarios')
                      ->select('*')
                      ->where("codigo_inventario", $codigo)
                      ->get();

    return $query;

   }

   
   public function crearInventarios($descripcion) {
      $query= [
        "fecha" => date("Y-m-d"),
        "observacion" => $descripcion,
        "fecha_inicio" => date("Y-m-d"),
        "fecha_cierre" => "",
        "estado" => "Activo",
        "proceso_final" => "En ejecucion",
        "usuario" => session()->get('documento'),
        "bodega" => 1,
        "btnproducto" => 0,
        "btnubicacion" => 0,
        "btnproceso" => 0,
      ];

      $this->db->table('inventarios')
               ->insert($query);
   }

   public function getSubcategorias() {
    $query = $this->db->table('productos')
                      ->select('subcategoria')
                      ->distinct()
                      ->get();

    return $query;
   }

   public function getGrupo() {
    $query = $this->db->table('productos')
                      ->select('grupo')
                      ->distinct()
                      ->get();

    return $query;
   }

   public function getSubgrupo() {
    $query = $this->db->table('productos')
                      ->select('subgrupo')
                      ->distinct()
                      ->get();
    return $query;
   }

   public function buscarProductosAsignar($subcategoria,$grupo,$subgrupo) {
    
     $query = $this->db->table('productos');
              if($subcategoria != '') {
                $query->where('subcategoria', $subcategoria);
              }
              else if($grupo != '') {
                $query->where('grupo', $grupo);
              }
              else if($subgrupo != '') {
                $query->where('subgrupo', $subgrupo);
              }
                      
      $consulta = $query->get();

      return $consulta->getResult();

   }

   public function asignarProductosInventario($codigoinventario,$codigoproducto) {
     $inventario = [
       "codigo_inventario" => $codigoinventario,
       "codigo_producto" => $codigoproducto,
       "fecha" => date("Y-m-d"),
       "hora" => date("H:i:s"),
       "estado" => "Activo"
     ];
      $this->db->table('asignacion_productos')
                ->insert($inventario);

      $inventarios = [
        "btnproducto" => 1
      ];
      $this->db->table('inventarios')
                ->where("codigo_inventario",$codigoinventario)
                ->update($inventarios);
   }

   public function asignarUbicacionInventario($data) {
    $ubicacion = [
      "ubicacion" => $data["ubicacion"],
      "localizacion" => $data["localizacion"],
      "numerolocalizacion" => $data["numerolocalizacion"],
      "observacion2" => $data["observacion"],
    ];

    $this->db->table('inventarios')
                ->where("codigo_inventario",$data['codigoinventario'])
                ->update($ubicacion);

      $inventarios = [
        "btnubicacion" => 1
      ];
      $this->db->table('inventarios')
                ->where("codigo_inventario",$data['codigoinventario'])
                ->update($inventarios);
   }

   public function asignarUsuariosInventario($data) {
      $inventarios = [
        "usuarioconteo1" => $data['usuario1'],
        "usuarioconteo2" => $data['usuario2'],
        "btnproceso" => 1
      ];

       $this->db->table('inventarios')
                ->where("codigo_inventario",$data['codigoinventario'])
                ->update($inventarios);
   }

}
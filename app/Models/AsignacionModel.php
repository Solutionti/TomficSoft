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

   
   public function crearInventarios($descripcion, $conteos) {
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
        "conteos" => $conteos
      ];

      $this->db->table('inventarios')
               ->insert($query);
   }

   public function actualizarinventario( $codigo, $fecha, $descripcion, $conteos) {
      $datos = [
        "fecha_inicio" => $fecha,
        "observacion" => $descripcion,
        "conteos" => $conteos
      ];

      $this->db->table('inventarios')
               ->where("codigo_inventario", $codigo)
               ->update($datos);

   }

   public function getcategorias() {
    $query = $this->db->table('productos')
                      ->select('categoria')
                      ->distinct()
                      ->get();

    return $query;
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

   public function buscarProductosAsignar($categoria,$subcategoria, $grupo, $subgrupo) {
    
     $query = $this->db->table('productos');
     $query->where('categoria', $categoria);
     $query->where('subcategoria', $subcategoria);
     $query->where('grupo', $grupo);
     $query->where('subgrupo', $subgrupo);
                      
      $consulta = $query->get();

      return $consulta->getResultArray();

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

   public function getConteosTablaReportes() {
    $inventarios = $this->db->table('inventarios as inven')
                        ->select("inven.ubicacion, inven.localizacion, inven.numerolocalizacion, inven.usuarioconteo1,
                        inven.usuarioconteo2,inven.observacion, SUM(cp.conteo1) as conte1, SUM(cp.conteo2) as conte2, SUM(cp.diferencia) as diferencia, inven.codigo_inventario")
                        ->join("captura_conteos as cp", "inven.codigo_inventario = cp.codigo_inventario")
                        ->groupBy([
                          "inven.ubicacion", 
                          "inven.localizacion", 
                          "inven.numerolocalizacion", 
                          "inven.usuarioconteo1",
                          "inven.usuarioconteo2",
                          "inven.observacion",
                          "inven.codigo_inventario"
                        ])
                        ->get();

     return $inventarios;
   }

   public function getpdfReportes($inventario) {
    $reportepdf = $this->db->table('captura_conteos')
                           ->select("*")
                           ->where("codigo_inventario", $inventario)
                           ->get();

    return $reportepdf;
   }

   public function getExcelReportes($inventario) {
    $reporteExcel = $this->db->table('captura_conteos')
                           ->select("*")
                           ->where("codigo_inventario", $inventario)
                           ->get();

    return $reporteExcel;
   }

   public function getNumeroLocalizacion($localizacion) {
     $localizacion = $this->db->table('inventarios')
                              ->select("COUNT(*) as cantidad")
                              ->where("localizacion", $localizacion)
                              ->get();

     return $localizacion->getResult();

   }

   public function cargarExcelProductosInventarios($data) {
      $asignacion = [
        "codigo_producto" => $data['codigo_producto'],
        "codigo_inventario" => $data['codigo_inventario'],
        "estado" => $data['estado'],
        "fecha" => $data['fecha'],
        "hora" => $data['hora'],
        // "usuario" => $data['usuario']
      ];

       $this->db->table('asignacion_productos')
                ->insert($asignacion);

       $inventarios = [
        "btnproducto" => 1
      ];
      $this->db->table('inventarios')
                ->where("codigo_inventario",$data['codigo_inventario'])
                ->update($inventarios);
   }

}
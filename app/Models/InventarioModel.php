<?php

namespace App\Models;

use CodeIgniter\Model;

class InventarioModel extends Model
{
    
    public function getProductos()
    {
        $query = $this->db->table('productos p')
                ->select('p.*, c.nombre as categoria_nombre')
                ->join('categorias c', 'c.codigo_categoria = p.categoria')
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
            'medida' => $data['medida'],
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
            'medida' => $data['medida'],
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

    public function buscarProductosPorNombre($q)
    {
        return $this->db->table('productos')
            ->select('codigo_barras, nombre, saldo, costo, nit, codigo_interno')
            ->groupStart()
                ->like('nombre', $q)
                ->orLike('codigo_barras', $q)
                ->orLike('codigo_interno', $q)
            ->groupEnd()
            ->orderBy('nombre', 'ASC')
            ->limit(10)
            ->get()
            ->getResult();
    }

    public function ingresarEntradaProductos($data) {
        $kardex = [
          "id_producto" => $data["producto"],
          "tp_documento" => "ENT",
          "entrada" => $data["cantidad"],
          "salida" => 0,
          "devolucion" => 0,
          "fecha" => date("Y-m-d"),
          "hora" => date("H:i:s"),
          "descripcion" => $data["comentarios"],
          "usuario" => session()->get('documento'),
          "sede" => $data["sede"],
          "motivo" => $data["motivo"],
          "saldo" => 0,
        ];
        $this->db->table('kardex')
                 ->insert($kardex);

        $productos = [
          "saldo" => $data["stock"] + $data["cantidad"],
        ];
        $this->db->table('productos')
                  ->where('codigo_barras', $data["producto"])
                  ->update($productos);
    }

    public function ingresarSalidaProductos($data) {
        $kardex = [
          "id_producto" => $data["producto"],
          "tp_documento" => "SAL",
          "entrada" => 0,
          "salida" => $data["cantidad"],
          "devolucion" => 0,
          "fecha" => date("Y-m-d"),
          "hora" => date("H:i:s"),
          "descripcion" => $data["comentarios"],
          "usuario" => session()->get('documento'),
          "sede" => $data["sede"],
          "motivo" => $data["motivo"],
          "saldo" => 0,
        ];
        $this->db->table('kardex')
                 ->insert($kardex);

        $productos = [
          "saldo" => $data["stock"] - $data["cantidad"],
        ];
        $this->db->table('productos')
                  ->where('codigo_barras', $data["producto"])
                  ->update($productos);
    }

    public function ajustarInventario($data) {
      $productos = [
        "saldo" => $data["stock"]
      ];
      $this->db->table('productos')
                ->where('codigo_barras', $data["producto"])
                ->update($productos);
    }

    public function getUltimoInventario() {
        $ultimoInventario = $this->db->table('inventarios')
                ->select('*')
                ->orderBy('codigo_inventario', 'DESC')
                ->limit(1)
                ->get();

        return $ultimoInventario;
    }

    public function getCapturaConteos($codigo) {
      $conteos = $this->db->table('captura_conteos')
                ->select('*')
                ->where('codigo_inventario', $codigo)
                ->get();

        return $conteos;    
    }

    //SOLICITUD DE INVENTARIOS

    public function crearSolicitudInventarios($data) {
        $solicitud = [
    "usuario_id"       => session()->get('documento'),
    "fecha_solicitud"  => date("Y-m-d"),
    "estado"           => "Pendiente",
    "observacion"      => $data['observacion'],
    "aprobado_por"     => null,
    "fecha_aprobacion" => null,
];

$builder = $this->db->table('solicitudes');
$builder->insert($solicitud);
$codigo = $this->db->insertID();

return $codigo;
    }

    public function crearDetalleSolicitudInventarios($data) {
        $detalle = [
            "solicitud_id" => $data["solicitud_id"],
            "producto_id" => $data["producto_id"],
            "cantidad_solicitada" => $data["cantidad"],
            "cantidad_aprobada" => null,
            "usuario" => session()->get('documento'),
            "sucursal" => 'Envigado',

        ];
        $this->db->table('detalle_solicitud')
                 ->insert($detalle);
    }

    public function getSolicitudesInventarios() {
        $solicitudes = $this->db->table('solicitudes s')
                ->select('s.*, u.nombre, u.apellido,
                    (SELECT COUNT(*) FROM despachos d WHERE d.solicitud_id = s.codigo_solicitud) as tiene_despacho,
                    (SELECT COUNT(*) FROM devoluciones dv WHERE dv.solicitud_id = s.codigo_solicitud) as tiene_devolucion')
                ->join('usuarios u', 'u.documento = s.usuario_id')
                ->get();

        return $solicitudes;
   }


}

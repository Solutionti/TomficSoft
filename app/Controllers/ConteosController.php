<?php

namespace App\Controllers;
use App\Models\ConteosModel;
use App\Models\ListasModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ConteosController extends BaseController {


  public function __construct() {
    $this->conteosModel = new ConteosModel();
      $this->listasModel = new ListasModel();

  }

  public function index(): string {
      $data = [
        "productos" => $this->conteosModel->getProductosAsignacion(),
        "inventarios" => $this->conteosModel->getInventariosSesion(),
        "permisoUsuario" => $this->listasModel->getPermisosMenu()
      ];
      return view('administrador/conteos', $data);
  }

  public function buscarProducto($codigo_producto) {

    $producto = $this->conteosModel->buscarProducto($codigo_producto);

    if(!empty($producto)){
      return $this->response->setJSON($producto);
    }
    else {
      echo "error";
    }
    
  }

  public function guardarConteo() {
      $codigo_producto = $this->request->getPost("codigo_producto");
      $nombre_producto = $this->request->getPost("nombre_producto");
      $referencia = $this->request->getPost("referencia");
      $saldo = $this->request->getPost("saldo");
      $estado_producto = $this->request->getPost("estado_producto");
      $observacion = $this->request->getPost("observacion");
      $ubicacion = $this->request->getPost("ubicacion");
      $localizacion = $this->request->getPost("localizacion");
      $numero_localizacion = $this->request->getPost("numero_localizacion");
      $total = $this->request->getPost("total");
      $diferencia = $this->request->getPost("diferencia");

      $data = [
        "codigo_producto" => $codigo_producto,
        "nombre_producto" => $nombre_producto,
        "referencia" => $referencia,
        "saldo" => $saldo,
        "estado_producto" => $estado_producto,
        "observacion" => $observacion,
        "ubicacion" => $ubicacion,
        "localizacion" => $localizacion,
        "numero_localizacion" => $numero_localizacion,
        "total" => $total,
        "diferencia" => $diferencia
      ];
      // $exist = $this->conteosModel->validarExistenciaProductoConteo($codigo_producto);
      // if(!empty($exist)){
      //   echo "error";
      // }
      // else {
        $this->conteosModel->guardarConteo($data);
      // }
  }

  public function actualizarConteo() {
    $codigo_producto = $this->request->getPost("codigo_producto");
    $nombre_producto = $this->request->getPost("nombre_producto");
    $referencia = $this->request->getPost("referencia");
    $saldo = $this->request->getPost("saldo");
    $estado_producto = $this->request->getPost("estado_producto");
    $observacion = $this->request->getPost("observacion");
    $ubicacion = $this->request->getPost("ubicacion");
    $localizacion = $this->request->getPost("localizacion");
    $numero_localizacion = $this->request->getPost("numero_localizacion");
    $total = $this->request->getPost("total");
    $diferencia = $this->request->getPost("diferencia");

      $data = [
        "codigo_producto" => $codigo_producto,
        "nombre_producto" => $nombre_producto,
        "referencia" => $referencia,
        "saldo" => $saldo,
        "estado_producto" => $estado_producto,
        "observacion" => $observacion,
        "ubicacion" => $ubicacion,
        "localizacion" => $localizacion,
        "numero_localizacion" => $numero_localizacion,
        "total" => $total,
        "diferencia" => $diferencia
      ];

      $this->conteosModel->actualizarConteo($data);
  }

  public function cargarExcelProducto() {
   $filePath = $_FILES['archivo']['tmp_name'];
   $spreadsheet = IOFactory::load($filePath);
   $hoja = $spreadsheet->getActiveSheet();
   $filas = $hoja->toArray();
   $totalInsertados = 0;
   foreach ($filas as $index => $fila) {
    if ($index == 0) continue;
    $datos = [
      "codigo_interno" => $fila[0],
      "codigo_barras" => $fila[1],
      "nombre" => $fila[2],
      "referencia" => $fila[3],
      "nit" => $fila[4],
      "proveedor" => $fila[5],
      "categoria" => $fila[6],
      "subcategoria" => $fila[7],
      "grupo" => $fila[8],
      "subgrupo" => $fila[9],
      "saldo" => $fila[10],
      "costo" => $fila[11],
      "estado" => "Activo"
    ];
    $this->conteosModel->guardarProductoExcel($datos);
    $totalInsertados++;
   }

   echo $totalInsertados;
  }

  public function CrearVariableSesion() {
    $inventario = $this->request->getPost('codigo');
    session()->set('inventario', $inventario);

    return $this->response->setJSON([
      "status"  => "success",
      "message" => "Se ha asignado el inventario correctamente"
    ]);
  }

}

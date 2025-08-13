<?php

namespace App\Controllers;
use App\Models\ConteosModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ConteosController extends BaseController {


  public function __construct() {
    $this->conteosModel = new ConteosModel();
  }

  public function index(): string {
    if(session()->get('logeado') == true) {
       return view('administrador/conteos');
    }
    else {
      return view('iniciarsesion');
    } 
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
    
  }

  public function actualizarConteo() {
    
  }

  public function cargarExcelProducto() {
   $filePath = $_FILES['archivo']['tmp_name'];
   $spreadsheet = IOFactory::load($filePath);
   $hoja = $spreadsheet->getActiveSheet();
   $filas = $hoja->toArray();
   $totalInsertados = 0;
   foreach ($filas as $index => $fila) {
    //  if ($index == 0) continue;
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
    ];
    $this->conteosModel->guardarProductoExcel($datos);
    $totalInsertados++;
   }

   echo $totalInsertados;
  }

}

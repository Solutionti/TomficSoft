<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\InventarioModel;
use App\Models\ListasModel;


class InventarioController extends BaseController
{
     public function __construct()
     {
        $this->inventarioModel = new InventarioModel();
        $this->listasModel = new ListasModel();
     }
    
    public function index() {
      if(session()->get('logeado') == true) {
          $data = [
            'productos' => $this->inventarioModel->getProductos(),
            'categorias' => $this->inventarioModel->getCategorias(),
            "permisoUsuario" => $this->listasModel->getPermisosMenu(),
            'empresas' => $this->inventarioModel->getEmpresas(),
          ];
  
          return view('administrador/inventarios', $data);
      }
      else {
        return view('iniciarsesion');
      }

    }

    public function agregarProductos() {

        try {

            //definir las variables que vienen del input
            $categoria = $this->request->getPost('categoria');
            $subcategoria = $this->request->getPost('subcategoria');
            $grupo = $this->request->getPost('grupo');
            $subgrupo = $this->request->getPost('subgrupo');
            $nombre = $this->request->getPost('nombre');
            $referencia = $this->request->getPost('referencia');
            $codigointerno = $this->request->getPost('codigointerno');
            $codigoBarras = $this->request->getPost('codigobarras');
            $nit = $this->request->getPost('nit');
            $proveedor = $this->request->getPost('proveedor');
            $saldo = $this->request->getPost('saldo');
            $costo = $this->request->getPost('costo');
            // echo "hola aca ";
            // exit;
            // crear un array con todos los campos que defini anteriormente
            $data = [
                'categoria' => $categoria,
                'subcategoria' => $subcategoria,
                'grupo' => $grupo,
                'subgrupo' => $subgrupo,
                'nombre' => $nombre,
                'referencia' => $referencia,
                'codigointerno' => $codigointerno,
                'codigoBarras' => $codigoBarras,
                'nit' => $nit,
                'proveedor' => $proveedor,
                'saldo' => $saldo,
                'costo' => $costo
            ];
    
            $this->inventarioModel->agregarProductos($data);

            // devuelve  JSON cuando todo es éxitoso
            return $this->response->setJSON([
                "status"  => "success",
                "message" => "Usuario creado correctamente"
            ]);
        } 
        catch (\Throwable $e) {
        //atrapar errores y responder
        return $this->response->setJSON([
            "status"  => "error",
            "message" => "Error en el servidor: " . $e->getMessage()
        ])->setStatusCode(500);
    } 
 }

 public function mostrarDatosProductosModal($id){
  $producto = $this->inventarioModel->mostrarDatosProductosModal($id)->getResult();

  return $this->response->setJSON($producto);
 }

 public function actualizarProductos(){
  // código para actualizar productos
  try{
    //definir las variables que vienen del input
    $categoria = $this->request->getPost('categoria');
    $subcategoria = $this->request->getPost('subcategoria');
    $grupo = $this->request->getPost('grupo');
    $subgrupo = $this->request->getPost('subgrupo');
    $nombre = $this->request->getPost('nombre');
    $referencia = $this->request->getPost('referencia');
    $codigointerno = $this->request->getPost('codigointerno');
    $codigobarras = $this->request->getPost('codigobarras');
    $nit = $this->request->getPost('nit');
    $proveedor = $this->request->getPost('proveedor');
    $saldo = $this->request->getPost('saldo');
    $costo = $this->request->getPost('costo');

    // crear un array con todos los campos que defini anteriormente
    $data = [
      'categoria' => $categoria,
      'subcategoria' => $subcategoria,
      'grupo' => $grupo,
      'subgrupo' => $subgrupo,
      'nombre' => $nombre,
      'referencia' => $referencia,
      'codigo_interno' => $codigointerno,
      'codigo_barras' => $codigobarras,
      'nit' => $nit,
      'proveedor' => $proveedor,
      'saldo' => $saldo,
      'costo' => $costo
    ];

    $this->inventarioModel->actualizarProductos($data);

    return $this->response->setJSON([
            "status"  => "success",
            "message" => "Usuario actualizado correctamente"
         ]);

  }
  catch (\Throwable $e) {
    //atrapar errores y responder
    return $this->response->setJSON([
        "status"  => "error",
        "message" => "Error en el servidor: " . $e->getMessage()
    ])->setStatusCode(500);
  }
 }

 public function eliminarProducto(){

  try{
    //atrapar el id del producto a eliminar
    $id = $this->request->getPost('id');
    // eliminar el producto de la base de datos
    $this->inventarioModel->eliminarProducto($id);

    return $this->response->setJSON([
            "status"  => "success",
            "message" => "el Producto se ha eliminado correctamente"
         ]);  
  }
  catch (\Throwable $e) {
    //atrapar errores y responder
    return $this->response->setJSON([
        "status"  => "error",
        "message" => "Error en el servidor: " . $e->getMessage()
    ])->setStatusCode(500);
  }
 }
  
  public function obtenerstock($codigo) {
    $producto = $this->inventarioModel->obtenerstock($codigo);

    return $this->response->setJSON($producto);
  }
}

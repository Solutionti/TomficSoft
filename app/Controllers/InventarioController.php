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
            "permisoUsuario" => $this->listasModel->getPermisosMenu()
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



}

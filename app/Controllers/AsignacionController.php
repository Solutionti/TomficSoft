<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ConteosModel;
use App\Models\AsignacionModel;
use App\Models\ListasModel;
use CodeIgniter\HTTP\ResponseInterface;

class AsignacionController extends BaseController {

    public function __construct() {
      $this->conteosModel = new ConteosModel();
      $this->asignacionModel = new AsignacionModel();
      $this->listasModel = new ListasModel();
    }  

    public function index() {
      $data = [
        "productos" => $this->conteosModel->getProductos(),
        "asignacionInventarios" => $this->asignacionModel->getAsignacion(),
        "subcategorias" => $this->asignacionModel->getSubcategorias(),
        "grupos" => $this->asignacionModel->getGrupo(),
        "subgrupos" => $this->asignacionModel->getSubgrupo(),
        "usuarios" => $this->listasModel->getUsuarios(),
      ];

      return view('administrador/asignacioninventarios', $data);
    }

    public function crearInventarios(){
      
      $fecha = $this->request->getPost('fecha');
      $descripcion = $this->request->getPost('descripcion');

      $this->asignacionModel->crearInventarios($descripcion);

    }

    public function buscarProductosAsignar() {
      $subcategoria = $this->request->getPost('subcategoria');
      $grupo = $this->request->getPost('grupo');
      $subgrupo = $this->request->getPost('subgrupo');

      $productos = $this->asignacionModel->buscarProductosAsignar($subcategoria, $grupo, $subgrupo);

      if(!empty($productos)){
        return $this->response->setJSON($productos);
      }
      else {
        echo "error";
      }
    }

    public function asignarProductosInventario() {
      $codigoinventario = $this->request->getPost('codigoinventario');
      $codigoproducto = $this->request->getPost('codigoproducto');

      
      foreach($codigoproducto as $producto) {
        $this->asignacionModel->asignarProductosInventario($codigoinventario,$producto);
      }

      return $this->response->setJSON([
            "status"  => "success",
            "message" => "los productos se han asociado correctamente"
      ]);
    }

    public function asignarUbicacionInventario() {
      $codigoinventario = $this->request->getPost('codigoinventario');
      $ubicacion = $this->request->getPost('ubicacion');
      $localizacion = $this->request->getPost('localizacion');
      $numerolocalizacion = $this->request->getPost('numerolocalizacion');
      $observacion = $this->request->getPost('observacion');

      $datos = [
        "codigoinventario" => $codigoinventario,
        "ubicacion" => $ubicacion,
        "localizacion" => $localizacion,
        "numerolocalizacion" => $numerolocalizacion,
        "observacion" => $observacion
      ];

      $this->asignacionModel->asignarUbicacionInventario($datos);

      return $this->response->setJSON([
        "status"  => "success",
        "message" => "la ubicacion se han asociado correctamente"
      ]);

    }

    public function procesoDatosModal($id) {
      $inventario = $this->asignacionModel->procesoDatosModal($id)->getResult();

      return $this->response->setJSON($inventario);
    }

    public function asignarUsuariosInventario() {
      $codigoinventario = $this->request->getPost('codigo_inventario');
      $usuario1 = $this->request->getPost('usuario1');
      $usuario2 = $this->request->getPost('usuario2');

      $datos = [
        "codigoinventario" => $codigoinventario,
        "usuario1" => $usuario1,
        "usuario2" => $usuario2
      ];

      $this->asignacionModel->asignarUsuariosInventario($datos);

      return $this->response->setJSON([
        "status"  => "success",
        "message" => "los usuarios se han asociado correctamente"
      ]);
    }
    
}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ConteosModel;
use App\Models\AsignacionInventariosModel;
use CodeIgniter\HTTP\ResponseInterface;

class AsignacionInventariosController extends BaseController {

    public function __construct() {
      $this->conteosModel = new ConteosModel();
      $this->asignacionInventarios = new AsignacionInventariosModel();
    }  

    public function index() {
      $data = [
        "productos" => $this->conteosModel->getProductos(),
        "asignacionInventarios" => $this->asignacionInventarios->getAsignacion(),
      ];

      return view('administrador/asignacioninventarios', $data);
    }

    public function crearInventarios(){
      
      $fecha = $this->request->getPost('fecha');
      $descripcion = $this->request->getPost('descripcion');

      $this->asignacionInventarios->crearInventarios($fecha,$descripcion);

    }
}

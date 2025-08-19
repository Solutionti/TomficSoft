<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ConteosModel;
use CodeIgniter\HTTP\ResponseInterface;

class AsignacionInventariosController extends BaseController {

    public function __construct() {
      $this->conteosModel = new ConteosModel();
    }  

    public function index() {
      $data = [
        "productos" => $this->conteosModel->getProductos(),
      ];

      return view('administrador/asignacioninventarios', $data);
    }
}

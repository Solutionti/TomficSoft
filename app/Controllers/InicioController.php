<?php

namespace App\Controllers;
use App\Models\ListasModel;
use App\Models\InicioModel;

class InicioController extends BaseController {

  public function __construct() {
      $this->listasModel = new ListasModel();
      $this->inicioModel = new InicioModel();
  } 

  public function index(): string {
      $data = [
        "producto" => $this->inicioModel->countProductos(),
        "inventario" => $this->inicioModel->countInventarios(),
        "bueno" => $this->inicioModel->countProductosPerdida('Bueno'),
        "averiado" => $this->inicioModel->countProductosPerdida('Averiado'),
        "vencido" => $this->inicioModel->countProductosPerdida('Vencido'),
        "perdida" => $this->inicioModel->countEstadoProducto(),
        "reportado" => $this->inicioModel->countReportados(),
        "permisoUsuario" => $this->listasModel->getPermisosMenu()
      ];

      return view('administrador/inicio', $data);
  }


}

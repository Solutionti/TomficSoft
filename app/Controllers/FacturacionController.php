<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ConteosModel;
use App\Models\AsignacionModel;
use App\Models\ListasModel;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use FPDF;

class FacturacionController extends BaseController {
    public function __construct() {
      $this->conteosModel = new ConteosModel();
      $this->asignacionModel = new AsignacionModel();
      $this->listasModel = new ListasModel();
    } 
    public function index(){
        $data = [
          "productos" => $this->conteosModel->getProductos(),
          "asignacionInventarios" => $this->asignacionModel->getAsignacion(),
          "categorias" => $this->asignacionModel->getcategorias(),
          "subcategorias" => $this->asignacionModel->getSubcategorias(),
          "grupos" => $this->asignacionModel->getGrupo(),
          "subgrupos" => $this->asignacionModel->getSubgrupo(),
          "usuarios" => $this->listasModel->getUsuarios(),
          "reportes" => $this->asignacionModel->getConteosTablaReportes(),
          "permisoUsuario" => $this->listasModel->getPermisosMenu(),

          "ubicaciones" => $this->asignacionModel->getUbicaciones(),
          "localizaciones" => $this->asignacionModel->getLocalizaciones()
        ];
        return view('administrador/facturacion', $data);
    }
}
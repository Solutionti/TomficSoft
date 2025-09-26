<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\InventarioModel;

class InventarioController extends BaseController
{
     public function __construct()
     {
        $this->inventarioModel = new InventarioModel();
     }
    
    public function index()
    {
        $data = [
            'productos' => $this->inventarioModel->getProductos()
        ];

        return view('administrador/inventarios', $data);
    }

}

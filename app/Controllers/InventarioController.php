<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class InventarioController extends BaseController
{
    public function __construct()
    {
        
    }
    
    public function index()
    {
        return view('administrador/inventarios');
    }
}

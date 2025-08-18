<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AsignacionInventariosController extends BaseController
{
    public function index()
    {
        //
        return view('administrador/asignacioninventarios');
    }
}

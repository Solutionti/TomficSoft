<?php

namespace App\Controllers;

class Conteos extends BaseController
{
    public function index(): string
    {
        return view('administrador/conteos');
    }
}

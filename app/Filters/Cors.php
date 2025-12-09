<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Cors implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Headers CORS
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

        // Si es OPTIONS, devolver vacío y terminar
        if (strtoupper($_SERVER['REQUEST_METHOD']) === 'OPTIONS') {
            exit(0);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // También agregar aquí por seguridad
        $response->setHeader("Access-Control-Allow-Origin", "*");
        $response->setHeader("Access-Control-Allow-Methods", "GET, POST, OPTIONS, PUT, DELETE");
        $response->setHeader("Access-Control-Allow-Headers", "Content-Type, Authorization, X-Requested-With");
    }
}

<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface {
    
    public function before(RequestInterface $request, $arguments = null) {
      if (!session()->get('logeado')) {
        // Guardar la URL a la que intentaba acceder
        session()->set('redirect_url', current_url());
            
        // Redirigir al login
        return redirect()->to('/')->with('error', 'Debes iniciar sesión para acceder a esta página');
      }
    }

    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        //
    }
}

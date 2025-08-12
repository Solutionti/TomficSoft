<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


//INICIO DE SESION
$routes->get('/', 'Login::index');

// INICIO
$routes->get('/inicio', 'Inicio::index');

// CONTEOS
$routes->get('/conteos', 'Conteos::index');

// USUARIOS

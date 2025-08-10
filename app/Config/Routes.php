<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->get('/inicio', 'Inicio::index');
$routes->get('/conteos', 'Conteos::index');

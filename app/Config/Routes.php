<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


//INICIO DE SESION
$routes->get('/', 'LoginController::index');
$routes->post('/iniciarsesion', 'LoginController::iniciarSesion');
$routes->get('/cerrarsesion', 'LoginController::cerrarSesion');

// INICIO
$routes->get('/inicio', 'InicioController::index');

// CONTEOS
$routes->get('/conteos', 'ConteosController::index');

// USUARIOS
$routes->get('/usuarios', 'UsuariosController::index');

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
$routes->get('/buscarproducto/(:num)', 'ConteosController::buscarProducto/$1');
$routes->post('/cargarexcelproductos', 'ConteosController::cargarExcelProducto');

// USUARIOS
$routes->get('/usuarios', 'UsuariosController::index');
$routes->post('/crearusuario', 'UsuariosController::crearUsuario');

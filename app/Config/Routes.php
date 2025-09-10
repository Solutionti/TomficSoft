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
$routes->post('/guardarconteo', 'ConteosController::guardarConteo');
$routes->post('/modificarconteo', 'ConteosController::actualizarConteo');

// USUARIOS
$routes->get('/usuarios', 'UsuariosController::index');
$routes->post('/crearusuario', 'UsuariosController::crearUsuario');
$routes->post('/actualizarusuario', 'UsuariosController::actualizarUsuario');
$routes->get('/getusuarioid/(:num)', 'UsuariosController::mostrarDatosUsuarioModal/$1');
$routes->post('/eliminarusuario', 'UsuariosController::eliminarusuario');


//Asignacion inventarios
$routes->get('/asignacioninventarios', 'AsignacionInventariosController::index');
$routes->post('/crearinventario', 'AsignacionInventariosController::crearInventarios');

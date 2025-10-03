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
$routes->post('/crearvariablesesion', 'ConteosController::CrearVariableSesion');

// USUARIOS
$routes->get('/usuarios', 'UsuariosController::index');
$routes->post('/crearusuario', 'UsuariosController::crearUsuario');
$routes->post('/actualizarusuario', 'UsuariosController::actualizarUsuario');
$routes->get('/getusuarioid/(:num)', 'UsuariosController::mostrarDatosUsuarioModal/$1');
$routes->post('/eliminarusuario', 'UsuariosController::eliminarusuario');


//Asignacion inventarios
$routes->get('/asignacioninventarios', 'AsignacionController::index');
$routes->post('/crearinventario', 'AsignacionController::crearInventarios');
$routes->post('/buscarproductos', 'AsignacionController::buscarProductosAsignar');
$routes->post('/asinarproductosinventario', 'AsignacionController::asignarProductosInventario');
$routes->post('/asignarubicacioninventario', 'AsignacionController::asignarUbicacionInventario');
$routes->get('/getinventarioid/(:num)', 'AsignacionController::procesoDatosModal/$1');
$routes->post('/asignarusuariosinventario', 'AsignacionController::asignarUsuariosInventario');
$routes->get('/generarpdfreportes', 'AsignacionController::generarPdf');
$routes->get('/generarexcelreportes', 'AsignacionController::generarExcel');

// INVENTARIOS
$routes->get('/inventarios', 'InventarioController::index');
$routes->get('crearproducto', 'InventarioController::crearProducto');

// VENTAS
$routes->get('/ventas', 'VentasController::index');



<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//INICIO DE SESION
$routes->get('/', 'LoginController::index');
$routes->post('/iniciarsesion', 'LoginController::iniciarSesion');
$routes->get('/cerrarsesion', 'LoginController::cerrarSesion');

//RUTAS PROTEGIDAS 

$routes->group('', ['filter' => 'auth'], function($routes) {
// INICIO
$routes->get('/inicio', 'InicioController::index');

// CONTEOS
$routes->get('/conteos', 'ConteosController::index');
$routes->get('/buscarproducto/(:num)', 'ConteosController::buscarProducto/$1');
$routes->post('/cargarexcelproductos', 'ConteosController::cargarExcelProducto');
$routes->post('/guardarconteo', 'ConteosController::guardarConteo');
$routes->post('/modificarconteo', 'ConteosController::actualizarConteo');
$routes->post('/crearvariablesesion', 'ConteosController::CrearVariableSesion');
$routes->get('/cerrarinventario', 'ConteosController::cerrarInventario');


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
$routes->get('/generarpdfreportes/(:num)', 'AsignacionController::generarPdf/$1');
$routes->get('/generarexcelreportes/(:num)', 'AsignacionController::generarExcel/$1');
$routes->get('/getnumerolocalizacion/(:any)', 'AsignacionController::getNumeroLocalizacion/$1');
$routes->post('/actualizarinventario', 'AsignacionController::actualizarinventario');
$routes->post('/cargarexcelproductosinventarios', 'AsignacionController::cargarExcelProductosInventarios');

$routes->post('/crearubicacion', 'AsignacionController::crearUbicaciones');
$routes->post('/crearlocalizacion', 'AsignacionController::crearLocalizaciones');

// INVENTARIOS
$routes->get('/inventarios', 'InventarioController::index');
$routes->get('crearproducto', 'InventarioController::crearProducto');
$routes->get('obtenerdatoproducto/(:num)', 'InventarioController::mostrarDatosProductosModal/$1');
$routes->post('agregarproductos', 'InventarioController::agregarProductos');
$routes->post('actualizarproductos', 'InventarioController::actualizarProductos');
$routes->post('eliminarproducto', 'InventarioController::eliminarProducto');
$routes->get('obtenerstock/(:num)', 'InventarioController::obtenerstock/$1');

$routes->post('ingresarentrada', 'InventarioController::ingresarEntradaProductos');
$routes->post('ingresarsalida', 'InventarioController::ingresarSalidaProductos');

// VENTAS
$routes->get('/ventas', 'VentasController::index');
$routes->post('/getproductoventa', 'VentasController::getProductoVenta');
$routes->post('/crearventa', 'VentasController::crearVenta');
$routes->get('generarpdfventas/(:any)', 'VentasController::pdfreciboventa/$1');

// REPORTES
$routes->get('/reportes', 'ReportesController::index');
$routes->get('/diferenciaconteos/(:any)/(:any)', 'ReportesController::diferenciaConteos/$1/$2');
$routes->get('/productossinconteo/(:any)/(:any)', 'ReportesController::productosSinConteoPdf/$1/$2');
$routes->get('/productossinconteoexcel/(:any)/(:any)', 'ReportesController::productosSinConteoExcel/$1/$2');

// PEDIDOS
$routes->get('/pedidos', 'PedidosController::index');
$routes->get('/getpedidos/(:num)', 'PedidosController::getPedidoId/$1');
$routes->get('/getpeditosdetalle/(:num)', 'PedidosController::getPedidosDetalle/$1');
$routes->post('/actualizarpedido', 'PedidosController::actualizarPedido');
$routes->get('/getpedidoreal', 'PedidosController::getPedidosTiempoReal');

});





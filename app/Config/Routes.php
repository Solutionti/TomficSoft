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
$routes->get('/documentacion/pdf', 'InicioController::documentacionPdf');

// CONTEOS
$routes->get('/conteos', 'ConteosController::index');
$routes->get('/conteos/buscar', 'ConteosController::buscarNombre');
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

$routes->get('/asignacion/solicitudes',         'AsignacionController::getSolicitudes');
$routes->get('/asignacion/solicitudesproductos', 'AsignacionController::getSolicitudesProductos');
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
$routes->get('/inventarios/buscar', 'InventarioController::buscarProductosPorNombre');
$routes->get('/inventarios/exportar-excel', 'InventarioController::exportarExcel');
$routes->post('/ajustarinventario', 'InventarioController::ajustarInventario');


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

// FACTURACION
$routes->get('/facturacion', 'FacturacionController::index');

// ASISTENCIA (requiere auth)
$routes->get('/asistencia',           'AsistenciaController::index');
$routes->get('/asistencia/escanear',  'AsistenciaController::escanear');
$routes->post('/asistencia/registrar','AsistenciaController::registrar');
$routes->get('/asistencia/registros', 'AsistenciaController::getRegistros');

});

// ASISTENCIA (públicas — monitor y token sin auth)
$routes->get('/asistencia/monitor', 'AsistenciaController::monitor');
$routes->get('/asistencia/token',   'AsistenciaController::generarToken');

//HORARIOS
$routes->get('/horarios', 'HorariosController::index');
$routes->post('/horarios/guardar', 'HorariosController::guardar');
$routes->post('/horarios/eliminar', 'HorariosController::eliminarColaborador');
$routes->post('/horarios/crear',        'HorariosController::crearColaborador');
$routes->post('/horarios/crearHorario', 'HorariosController::crearHorarioColaborador');
$routes->get('/horarios/reporte/pdf',   'HorariosController::reportePdf');

//CONSUMOS
$routes->get('/consumos',                        'ConsumosController::index');
$routes->post('/consumos/guardar',               'ConsumosController::guardar');
$routes->get('/consumos/detalle/(:num)',          'ConsumosController::getDetalle/$1');
$routes->get('/consumos/categorias',             'ConsumosController::getCategorias');
$routes->get('/consumos/categoria/(:any)',        'ConsumosController::getProductosPorCategoria/$1');

//COMPRAS
$routes->get('/compras',                        'ComprasController::index');
$routes->post('/compras/cotizacion/guardar',    'ComprasController::guardarCotizacion');
$routes->get('/compras/cotizacion/(:num)',       'ComprasController::getCotizacion/$1');
$routes->post('/compras/cotizacion/estado',     'ComprasController::cambiarEstadoCotizacion');
$routes->post('/compras/remision/guardar',      'ComprasController::guardarRemision');
$routes->get('/compras/remision/(:num)',         'ComprasController::getRemision/$1');
$routes->get('/compras/cotizacion/pdf/(:num)',  'ComprasController::pdfCotizacion/$1');
$routes->get('/compras/remision/pdf/(:num)',    'ComprasController::pdfRemision/$1');
$routes->post('/compras/compra/guardar',        'ComprasController::guardarCompra');
$routes->get('/compras/compra/pdf/(:num)',      'ComprasController::pdfCompra/$1');

//PERDIDAS (desechos reports)
$routes->get('/perdidasfechapdf/(:any)/(:any)',      'ReportesController::perdidasPorFechaPdf/$1/$2');
$routes->get('/perdidasfechaexcel/(:any)/(:any)',    'ReportesController::perdidasPorFechaExcel/$1/$2');
$routes->get('/perdidasproductopdf/(:any)/(:any)',   'ReportesController::perdidasPorProductoPdf/$1/$2');
$routes->get('/perdidasproductoexcel/(:any)/(:any)', 'ReportesController::perdidasPorProductoExcel/$1/$2');

//DESECHOS
$routes->get('/desechos', 'DesechosController::index');
$routes->get('/desechos/buscar', 'DesechosController::buscarProductos');
$routes->post('/desechos/ocr', 'DesechosController::procesarOcr');
$routes->post('/desechos/guardar', 'DesechosController::guardar');

//SOLICITUD DE INVENTARIOS
$routes->get('/solicitudinventario', 'InventarioController::solicitudInventarios');
$routes->post('/crearSolicitudInventarios', 'InventarioController::crearSolicitudInventarios');

$routes->get('/pdfdevoluciones', 'InventarioController::pdfDevolucionInventarios');
$routes->get('/pdfsolicitudes', 'InventarioController::pdfSolicitudInventarios');
$routes->get('/pdfdespachos', 'InventarioController::pdfDespachoInventarios');


//DEVOLUCIONES
$routes->get('/devoluciones/solicitud/(:num)', 'DevolucionesController::getDetalleSolicitud/$1');
$routes->post('/devoluciones/guardar', 'DevolucionesController::guardar');

//DESPACHOS
$routes->get('/despachos/solicitud/(:num)', 'DespachosController::getDetalleSolicitud/$1');
$routes->post('/despachos/guardar', 'DespachosController::guardar');


//FORMATOS — Control de Temperaturas
$routes->get('/formatos',                   'FormatosController::index');
$routes->post('/neveras/crear',             'FormatosController::crearNevera');
$routes->post('/neveras/eliminar',          'FormatosController::eliminarNevera');
$routes->post('/temperatura/registrar',     'FormatosController::registrarTemperatura');
$routes->get('/temperatura/reporte/pdf',    'FormatosController::reportePdf');

//PAGINA WEB
$routes->get('/pimientaexpress', 'WebController::index');







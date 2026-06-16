<?php

namespace App\Controllers;
use App\Models\ListasModel;
use App\Models\InicioModel;

class InicioController extends BaseController {

  public function __construct() {
      $this->listasModel = new ListasModel();
      $this->inicioModel = new InicioModel();
  } 

  public function documentacionPdf()
  {
      require_once APPPATH . 'Libraries/fpdf/FpdfDoc.php';

      $pdf = new \FPDF_Doc('P','mm','A4');
      $pdf->AliasNbPages();
      $pdf->SetMargins(16,16,16);
      $pdf->SetAutoPageBreak(true,18);

      // ── PORTADA ──
      $pdf->AddPage();
      $pdf->SetFillColor(45,102,34);
      $pdf->Rect(0,0,210,60,'F');
      $pdf->SetFillColor(74,138,55);
      $pdf->Rect(0,55,210,12,'F');

      $pdf->SetY(14);
      $pdf->SetFont('Arial','B',26);
      $pdf->SetTextColor(255,255,255);
      $pdf->Cell(0,10,'CristalBusiness',0,1,'C');
      $pdf->SetFont('Arial','',13);
      $pdf->Cell(0,8,'Pimienta Express',0,1,'C');
      $pdf->SetY(58);
      $pdf->SetFont('Arial','B',10);
      $pdf->Cell(0,8,'DOCUMENTACION FUNCIONAL DEL SISTEMA',0,1,'C');

      $pdf->SetY(78);
      $pdf->SetTextColor(13,36,9);
      $pdf->SetFont('Arial','',9);
      $pdf->Cell(0,6,'Fecha de generacion: '.date('d/m/Y H:i'),0,1,'C');
      $pdf->SetFont('Arial','B',9);
      $pdf->Cell(0,6,'Generado por: '.utf8_decode(session()->get('nombre').' '.session()->get('apellido')),0,1,'C');

      $pdf->Ln(10);
      $pdf->SetFillColor(240,247,236);
      $pdf->SetFont('Arial','',8);
      $pdf->SetTextColor(60,60,60);
      $pdf->MultiCell(0,5,utf8_decode('Este documento describe el funcionamiento de cada modulo del sistema TomficSoft, incluyendo flujos de trabajo, acciones disponibles, datos gestionados y automatismos del sistema.'),0,'C');

      // ── INDICE ──
      $pdf->Ln(8);
      $pdf->SeccionTitulo('INDICE DE MODULOS');
      $modulos = [
          '1. Inicio','2. Inventarios','3. Conteos','4. Ventas',
          '5. Compras','6. Consumos','7. Desechos','8. Usuarios',
          '9. Horarios','10. Asistencia','11. Solicitud de Inventarios',
          '12. Asignacion de Inventarios','13. Devoluciones','14. Despachos',
          '15. Reportes',
      ];
      $pdf->SetFont('Arial','',8);
      foreach ($modulos as $i => $m) {
          $pdf->SetFillColor($i%2===0?255:248,252,246);
          $pdf->Cell(0,6,utf8_decode('   '.$m),'B',1,'L');
      }

      // ══════════════════════════════════════════
      // MODULOS
      // ══════════════════════════════════════════
      $pdf->AddPage();
      $pdf->SeccionTitulo('DESCRIPCION DE MODULOS');

      // 1. INICIO
      $pdf->ModuloTitulo('1','INICIO - Dashboard');
      $pdf->SubTitulo('Acceso: Todos los usuarios autenticados');
      $pdf->Parrafo('Pantalla principal que muestra metricas generales del sistema: total de productos, inventarios activos, desechos registrados y estado de solicitudes. Sirve como punto de partida para navegar a los demas modulos.');
      $pdf->Separador();

      // 2. INVENTARIOS
      $pdf->ModuloTitulo('2','INVENTARIOS - Gestion de Productos');
      $pdf->SubTitulo('Acceso: Administrador, Capturador');
      $pdf->Parrafo('Gestiona el catalogo completo de productos e ingredientes con control de stock en tiempo real.');
      $pdf->SubTitulo('Flujo de trabajo:');
      $pdf->Item('Ver lista de productos con stock actual y filtros de busqueda.');
      $pdf->Item('Crear producto: codigo de barras, codigo interno, nombre, categoria, proveedor, costo.');
      $pdf->Item('Registrar Entrada (aumenta saldo) o Salida (disminuye saldo).');
      $pdf->Item('Ajustar inventario: sincroniza stock con el ultimo conteo fisico.');
      $pdf->Item('Exportar Excel: descarga todos los productos con sus datos.');
      $pdf->SubTitulo('Acciones automaticas:');
      $pdf->Item('El saldo se actualiza inmediatamente en cada entrada o salida.');
      $pdf->Item('El ajuste descuenta o suma diferencias del conteo mas reciente.');
      $pdf->Separador();

      // 3. CONTEOS
      $pdf->ModuloTitulo('3','CONTEOS - Conteo Fisico de Inventario');
      $pdf->SubTitulo('Acceso: Capturador, Administrador');
      $pdf->Parrafo('Permite registrar el conteo fisico real de los productos para compararlo contra el sistema y detectar diferencias.');
      $pdf->SubTitulo('Flujo de trabajo:');
      $pdf->Item('Crear sesion de conteo.');
      $pdf->Item('Buscar producto por nombre o codigo y registrar cantidad contada.');
      $pdf->Item('Asignar ubicacion fisica si aplica.');
      $pdf->Item('Cargar productos masivamente por Excel.');
      $pdf->Item('Cerrar inventario: congela el conteo para generar reportes de diferencias.');
      $pdf->Separador();

      // 4. VENTAS
      $pdf->ModuloTitulo('4','VENTAS - Punto de Venta (POS)');
      $pdf->SubTitulo('Acceso: Vendedor, Administrador');
      $pdf->Parrafo('POS moderno de dos paneles: browser de productos (izquierda) y carrito + pago (derecha). Permite agregar productos por busqueda o navegando categorias, con panel de pago siempre visible.');
      $pdf->SubTitulo('Flujo de trabajo:');
      $pdf->Item('Buscar producto por nombre o codigo - resultados aparecen como tarjetas en el grid, igual que las categorias.');
      $pdf->Item('Al buscar, el pill de la categoria del producto se activa automaticamente.');
      $pdf->Item('Navegar por categorias con los pills horizontales (venidas de la tabla categorias).');
      $pdf->Item('"Todos" muestra el catalogo completo de productos.');
      $pdf->Item('Clic en tarjeta o resultado agrega el producto al carrito y regresa a la categoria.');
      $pdf->Item('El carrito soporta varios items con cantidad editable y boton de eliminar.');
      $pdf->Item('Ingresar monto recibido - calcula devuelta automaticamente.');
      $pdf->Item('Confirmar venta con Pagar o Ctrl+Espacio.');
      $pdf->Item('Opcion de imprimir recibo PDF con numero consecutivo.');
      $pdf->SubTitulo('Acciones automaticas:');
      $pdf->Item('El stock se descuenta automaticamente al guardar la venta.');
      $pdf->Item('El pill de categoria del producto buscado se resalta en tiempo real.');
      $pdf->Separador();

      $pdf->AddPage();

      // 5. COMPRAS
      $pdf->ModuloTitulo('5','COMPRAS - Gestion de Compras a Proveedores');
      $pdf->SubTitulo('Acceso: Administrador');
      $pdf->Parrafo('Gestiona el proceso completo de compra en 3 etapas: Cotizacion → Remision → Compra. Cada etapa genera su propio PDF estilo factura colombiana.');
      $pdf->SubTitulo('Etapas del proceso:');
      $pdf->SetFont('Arial','B',8);
      $pdf->SetFillColor(45,102,34);
      $pdf->SetTextColor(255,255,255);
      $pdf->Cell(55,6,'Etapa',1,0,'C',true);
      $pdf->Cell(65,6,'Descripcion',1,0,'C',true);
      $pdf->Cell(62,6,'Estados posibles',1,1,'C',true);
      $pdf->SetTextColor(13,36,9);
      $rows = [
          ['Cotizacion','Solicitar precio al proveedor','Pendiente, Aprobada, Rechazada, Cancelada'],
          ['Remision','Confirmar lo que fisicamente llego','Recibida, Parcial'],
          ['Compra','Registrar la factura definitiva','Pendiente, Pagada, Anulada'],
      ];
      foreach($rows as $i=>$r) {
          $pdf->SetFillColor($i%2===0?255:248);
          $pdf->SetFont('Arial','',$i%2===0?8:8);
          $pdf->Cell(55,6,utf8_decode($r[0]),1,0,'L',$i%2!==0);
          $pdf->Cell(65,6,utf8_decode($r[1]),1,0,'L',$i%2!==0);
          $pdf->Cell(62,6,utf8_decode($r[2]),1,1,'L',$i%2!==0);
      }
      $pdf->Ln(2);
      $pdf->SubTitulo('Acciones automaticas:');
      $pdf->Item('Al registrar la Compra el stock de cada producto aumenta automaticamente.');
      $pdf->Separador();

      // 6. CONSUMOS
      $pdf->ModuloTitulo('6','CONSUMOS - Registro de Consumo (Bufet)');
      $pdf->SubTitulo('Acceso: Capturador, Administrador');
      $pdf->Parrafo('Modulo disenado para el bufet. Permite registrar multiples veces al dia los ingredientes e insumos utilizados en la preparacion, descontando automaticamente del stock. Las categorias de productos se gestionan desde la tabla categorias.');
      $pdf->SubTitulo('Flujo de trabajo:');
      $pdf->Item('Seleccionar fecha y observacion (ej: Almuerzo mediodia).');
      $pdf->Item('Buscar ingrediente por nombre - muestra el stock disponible en tiempo real.');
      $pdf->Item('Agregar al listado y ajustar la cantidad utilizada.');
      $pdf->Item('Repetir para todos los ingredientes del turno.');
      $pdf->Item('Presionar Registrar consumo: descuenta del stock inmediatamente.');
      $pdf->Item('El historial del dia aparece en el panel derecho con boton de detalle.');
      $pdf->SubTitulo('Categorias:');
      $pdf->Item('Gestionadas en tabla categorias (codigo_categoria, nombre).');
      $pdf->Item('El campo productos.categoria almacena el ID numerico (FK a categorias).');
      $pdf->SubTitulo('Acciones automaticas:');
      $pdf->Item('El campo saldo de productos se reduce al guardar cada registro.');
      $pdf->Item('Se puede registrar multiples consumos en el mismo dia.');
      $pdf->Separador();

      // 7. DESECHOS
      $pdf->ModuloTitulo('7','DESECHOS - Control de Merma y Desperdicio');
      $pdf->SubTitulo('Acceso: Capturador, Administrador');
      $pdf->Parrafo('Registra perdidas de productos por dano, vencimiento o desperdicio. Incluye procesamiento OCR automatico de imagenes de balanza para capturar el peso sin digitarlo.');
      $pdf->SubTitulo('Flujo de trabajo:');
      $pdf->Item('Buscar producto afectado.');
      $pdf->Item('Subir foto del producto o balanza.');
      $pdf->Item('El sistema lee el peso de la imagen con OCR automaticamente al soltar el area de seleccion.');
      $pdf->Item('Ajustar el valor manualmente si es necesario.');
      $pdf->Item('Guardar: descuenta del stock y genera registro de perdida.');
      $pdf->Item('Generar reportes de perdidas por fecha o producto (PDF/Excel).');
      $pdf->SubTitulo('Acciones automaticas:');
      $pdf->Item('OCR se activa al terminar de dibujar el recuadro sobre la imagen.');
      $pdf->Item('Stock descontado automaticamente al guardar.');
      $pdf->Separador();

      $pdf->AddPage();

      // 8. USUARIOS
      $pdf->ModuloTitulo('8','USUARIOS - Gestion de Usuarios y Permisos');
      $pdf->SubTitulo('Acceso: Solo Administrador');
      $pdf->Parrafo('Administra las cuentas de usuario y controla que modulos puede ver cada uno segun su rol.');
      $pdf->SubTitulo('Flujo de trabajo:');
      $pdf->Item('Crear usuario: documento, nombre, apellido, contrasena, rol.');
      $pdf->Item('Asignar permisos de menu por usuario (que modulos aparecen en el sidebar).');
      $pdf->Item('Editar o eliminar usuarios existentes.');
      $pdf->SubTitulo('Seguridad:');
      $pdf->Item('Las contrasenas se guardan con hash bcrypt.');
      $pdf->Item('Todas las rutas protegidas requieren autenticacion (filtro auth).');
      $pdf->Item('Cada usuario solo ve en el menu los modulos que le fueron asignados.');
      $pdf->Separador();

      // 9. HORARIOS
      $pdf->ModuloTitulo('9','HORARIOS - Gestion de Turnos del Personal');
      $pdf->SubTitulo('Acceso: Administrador');
      $pdf->Parrafo('Administra los horarios semanales del personal mostrando los turnos asignados por dia de la semana (Lunes a Domingo). Incluye reporte PDF de horas trabajadas quincenal o mensual.');
      $pdf->SubTitulo('Flujo de trabajo:');
      $pdf->Item('Ver tabla semanal de colaboradores.');
      $pdf->Item('Agregar colaborador con nombre y rol.');
      $pdf->Item('Asignar turno por dia (hora inicio y hora fin).');
      $pdf->Item('Editar o eliminar turnos existentes.');
      $pdf->Item('Eliminar colaborador con confirmacion de seguridad.');
      $pdf->SubTitulo('Reporte de Horas PDF:');
      $pdf->Item('Boton "Reporte de Horas" genera PDF del periodo seleccionado.');
      $pdf->Item('Tipo de periodo: Mensual (dia 1 al ultimo) o Quincenal (1-15 o 16-fin).');
      $pdf->Item('Calcula horas trabajadas por colaborador desde la tabla asistencia_real.');
      $pdf->Item('Compara contra horas esperadas (dias habiles x 8h) y marca Cumple o Pendiente.');
      $pdf->Separador();

      // 10. ASISTENCIA
      $pdf->ModuloTitulo('10','ASISTENCIA - Control de Asistencia por QR');
      $pdf->SubTitulo('Acceso: Administrador (gestion), Empleados (escaneo - sin login)');
      $pdf->Parrafo('Sistema de fichaje con codigo QR rotativo. El empleado escanea el QR desde su celular para registrar su entrada o salida sin necesidad de contraseña.');
      $pdf->SubTitulo('Flujo de trabajo:');
      $pdf->Item('/asistencia/monitor: pantalla publica con QR que se renueva cada 30 segundos.');
      $pdf->Item('Empleado escanea el QR con su celular desde cualquier dispositivo.');
      $pdf->Item('Sistema valida el token y registra la asistencia con timestamp exacto.');
      $pdf->Item('/asistencia: Administrador ve los registros del dia con entrada y salida.');
      $pdf->SubTitulo('Nota importante:');
      $pdf->Parrafo('El monitor no requiere login. Esta disenado para colocarse en un televisor o pantalla en la entrada del local.');
      $pdf->Separador();

      // 11. SOLICITUD
      $pdf->ModuloTitulo('11','SOLICITUD DE INVENTARIOS - Pedido Interno de Productos');
      $pdf->SubTitulo('Acceso: Capturador, Administrador');
      $pdf->Parrafo('Permite solicitar formalmente productos del almacen para un area o ubicacion especifica.');
      $pdf->SubTitulo('Flujo de trabajo:');
      $pdf->Item('Buscar productos y agregarlos al carrito de solicitud con la cantidad requerida.');
      $pdf->Item('Ingresar observacion y enviar solicitud: queda en estado Pendiente.');
      $pdf->Item('El administrador la aprueba desde Asignacion de Inventarios.');
      $pdf->Item('Se procesa Despacho (envio de productos) o Devolucion (retorno).');
      $pdf->Item('PDF de despacho disponible solo si la solicitud tiene al menos un despacho registrado.');
      $pdf->Item('PDF de devolucion disponible solo si la solicitud tiene al menos una devolucion registrada.');
      $pdf->Item('El PDF de despachos incluye la columna Cant. Solicitada ademas de Cant. Despachada.');
      $pdf->Separador();

      $pdf->AddPage();

      // 12. ASIGNACION
      $pdf->ModuloTitulo('12','ASIGNACION DE INVENTARIOS - Inventarios Fisicos');
      $pdf->SubTitulo('Acceso: Administrador');
      $pdf->Parrafo('Gestiona inventarios fisicos asignados a ubicaciones y usuarios responsables. Permite asociar productos de solicitudes aprobadas a un inventario especifico.');
      $pdf->SubTitulo('Flujo de trabajo:');
      $pdf->Item('Crear inventario y asignarle una ubicacion fisica.');
      $pdf->Item('Agregar productos manualmente, por Excel, o cargando una solicitud existente.');
      $pdf->Item('Asignar usuarios responsables del inventario.');
      $pdf->Item('Generar reporte PDF o Excel del inventario.');
      $pdf->Separador();

      // 13. DEVOLUCIONES
      $pdf->ModuloTitulo('13','DEVOLUCIONES - Retorno de Productos');
      $pdf->SubTitulo('Acceso: Capturador, Administrador');
      $pdf->Parrafo('Procesa la devolucion de productos asociados a una solicitud. Se registra la cantidad devuelta y el motivo (dano, calidad, error de despacho).');
      $pdf->SubTitulo('Flujo de trabajo:');
      $pdf->Item('Ingresar el codigo de la solicitud de referencia y buscar.');
      $pdf->Item('La tabla muestra: Codigo, Producto, Cant. Solicitada, Cant. Despachada y Cant. a Devolver.');
      $pdf->Item('El input de devolucion inicia en 0. Si ya hay devoluciones previas muestra "Ya devuelto: X".');
      $pdf->Item('Ingresar cantidad a devolver (solo el nuevo incremento) y motivo por cada item.');
      $pdf->Item('Guardar registro de devolucion - no duplica cantidades ya registradas.');
      $pdf->Separador();

      // 14. DESPACHOS
      $pdf->ModuloTitulo('14','DESPACHOS - Envio de Productos');
      $pdf->SubTitulo('Acceso: Capturador, Administrador');
      $pdf->Parrafo('Procesa el despacho de productos de una solicitud aprobada hacia su destino.');
      $pdf->SubTitulo('Flujo de trabajo:');
      $pdf->Item('Ingresar el codigo de la solicitud y buscar.');
      $pdf->Item('La tabla muestra: Codigo, Producto, Cant. Solicitada y Cant. a Despachar.');
      $pdf->Item('El campo Cant. a Despachar se pre-rellena con la cantidad ya despachada anteriormente.');
      $pdf->Item('Ajustar cantidad y agregar comentario por cada item si aplica.');
      $pdf->Item('Guardar despacho.');
      $pdf->SubTitulo('Acciones automaticas:');
      $pdf->Item('Stock del almacen descontado automaticamente al guardar.');
      $pdf->Item('Estado de la solicitud cambia automaticamente a Aprobada.');
      $pdf->Separador();

      // 15. REPORTES
      $pdf->ModuloTitulo('15','REPORTES - Informes PDF y Excel');
      $pdf->SubTitulo('Acceso: Administrador, Capturador');
      $pdf->Parrafo('Genera informes en PDF o Excel para analisis y toma de decisiones gerenciales.');
      $pdf->SubTitulo('Tipos de reportes disponibles:');
      $pdf->SetFont('Arial','B',8);
      $pdf->SetFillColor(45,102,34);
      $pdf->SetTextColor(255,255,255);
      $pdf->Cell(70,6,'Reporte',1,0,'C',true);
      $pdf->Cell(0,6,'Descripcion',1,1,'C',true);
      $pdf->SetTextColor(13,36,9);
      $reportes = [
          ['Diferencia de Conteos','Compara stock del sistema vs conteo fisico por rango de fechas'],
          ['Productos sin conteo','Lista productos no contados en el periodo seleccionado'],
          ['Perdidas por fecha','Agrupa desechos registrados por dia'],
          ['Perdidas por producto','Agrupa desechos por producto en el periodo'],
      ];
      foreach($reportes as $i=>$r){
          $fill = $i%2!==0;
          $pdf->SetFillColor(240,247,236);
          $pdf->SetFont('Arial','',$fill?8:8);
          $pdf->Cell(70,6,utf8_decode($r[0]),1,0,'L',$fill);
          $pdf->Cell(0,6,utf8_decode($r[1]),1,1,'L',$fill);
      }

      // ── RESUMEN AUTOMATISMOS ──
      $pdf->Ln(6);
      $pdf->SeccionTitulo('RESUMEN DE ACCIONES AUTOMATICAS DEL SISTEMA');
      $pdf->SetFont('Arial','B',8);
      $pdf->SetFillColor(45,102,34);
      $pdf->SetTextColor(255,255,255);
      $pdf->Cell(60,6,'Accion',1,0,'C',true);
      $pdf->Cell(0,6,'Modulos que la ejecutan',1,1,'C',true);
      $pdf->SetTextColor(13,36,9);
      $auto = [
          ['Descuenta stock','Ventas, Consumos, Desechos, Despachos'],
          ['Aumenta stock','Compras (al registrar compra definitiva)'],
          ['Genera PDF','Compras, Ventas, Inventarios, Reportes, Horarios (reporte horas)'],
          ['Genera Excel','Inventarios, Reportes, Asignacion'],
          ['OCR automatico','Desechos (al soltar el area de seleccion)'],
          ['QR rotativo (30s)','Asistencia (pantalla monitor)'],
          ['Hash de contrasena','Usuarios (crear o editar usuario)'],
      ];
      foreach($auto as $i=>$a){
          $fill=$i%2!==0;
          $pdf->SetFillColor(240,247,236);
          $pdf->Cell(60,6,utf8_decode($a[0]),1,0,'L',$fill);
          $pdf->Cell(0,6,utf8_decode($a[1]),1,1,'L',$fill);
      }

      $this->response->setHeader('Content-Type','application/pdf');
      $pdf->Output('I','documentacion_tomficsoft_'.date('Ymd').'.pdf');
  }

  public function index(): string {
      $data = [
        "producto" => $this->inicioModel->countProductos(),
        "inventario" => $this->inicioModel->countInventarios(),
        "bueno" => $this->inicioModel->countProductosPerdida('Bueno'),
        "averiado" => $this->inicioModel->countProductosPerdida('Averiado'),
        "vencido" => $this->inicioModel->countProductosPerdida('Vencido'),
        "perdida" => $this->inicioModel->countEstadoProducto(),
        "reportado" => $this->inicioModel->countReportados(),
        "permisoUsuario" => $this->listasModel->getPermisosMenu()
      ];

      return view('administrador/inicio', $data);
  }


}

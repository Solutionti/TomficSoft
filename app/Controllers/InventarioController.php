<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\InventarioModel;
use App\Models\ListasModel;
use App\Models\VentasModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use FPDF;

class InventarioController extends BaseController
{
     public function __construct()
     {
        $this->inventarioModel = new InventarioModel();
        $this->listasModel = new ListasModel();
        $this->ventasModel = new VentasModel();
     }
    
    public function index() {
      
          $data = [
            'productos' => $this->inventarioModel->getProductos(),
            'categorias' => $this->inventarioModel->getCategorias(),
            "permisoUsuario" => $this->listasModel->getPermisosMenu(),
            'empresas' => $this->inventarioModel->getEmpresas(),

          ];
  
          return view('administrador/inventarios', $data);
      

    }

    public function agregarProductos() {

        try {

            //definir las variables que vienen del input
            $categoria = $this->request->getPost('categoria');
            $subcategoria = $this->request->getPost('subcategoria');
            $grupo = $this->request->getPost('grupo');
            $subgrupo = $this->request->getPost('subgrupo');
            $nombre = $this->request->getPost('nombre');
            $referencia = $this->request->getPost('referencia');
            $codigointerno = $this->request->getPost('codigointerno');
            $codigoBarras = $this->request->getPost('codigobarras');
            $nit = $this->request->getPost('nit');
            $proveedor = $this->request->getPost('proveedor');
            $saldo = $this->request->getPost('saldo');
            $costo = $this->request->getPost('costo');
              $medida = $this->request->getPost('medida');

            $data = [
                'categoria' => $categoria,
                'subcategoria' => $subcategoria,
                'grupo' => $grupo,
                'subgrupo' => $subgrupo,
                'nombre' => $nombre,
                'referencia' => $referencia,
                'codigointerno' => $codigointerno,
                'codigoBarras' => $codigoBarras,
                'nit' => $nit,
                'proveedor' => $proveedor,
                'saldo' => $saldo,
                'medida' => $medida,
                'costo' => $costo
            ];
    
            $this->inventarioModel->agregarProductos($data);

            // devuelve  JSON cuando todo es éxitoso
            return $this->response->setJSON([
                "status"  => "success",
                "message" => "Usuario creado correctamente"
            ]);
        } 
        catch (\Throwable $e) {
        //atrapar errores y responder
        return $this->response->setJSON([
            "status"  => "error",
            "message" => "Error en el servidor: " . $e->getMessage()
        ])->setStatusCode(500);
    } 
 }

 public function mostrarDatosProductosModal($id){
  $producto = $this->inventarioModel->mostrarDatosProductosModal($id)->getResult();

  return $this->response->setJSON($producto);
 }

 public function actualizarProductos(){
  // código para actualizar productos
  try{
    //definir las variables que vienen del input
    $categoria = $this->request->getPost('categoria');
    $subcategoria = $this->request->getPost('subcategoria');
    $grupo = $this->request->getPost('grupo');
    $subgrupo = $this->request->getPost('subgrupo');
    $nombre = $this->request->getPost('nombre');
    $referencia = $this->request->getPost('referencia');
    $codigointerno = $this->request->getPost('codigointerno');
    $codigobarras = $this->request->getPost('codigobarras');
    $nit = $this->request->getPost('nit');
    $proveedor = $this->request->getPost('proveedor');
    $saldo = $this->request->getPost('saldo');
    $medida = $this->request->getPost('medida');
    $costo = $this->request->getPost('costo');

    // crear un array con todos los campos que defini anteriormente
    $data = [
      'categoria' => $categoria,
      'subcategoria' => $subcategoria,
      'grupo' => $grupo,
      'subgrupo' => $subgrupo,
      'nombre' => $nombre,
      'referencia' => $referencia,
      'codigo_interno' => $codigointerno,
      'codigo_barras' => $codigobarras,
      'nit' => $nit,
      'proveedor' => $proveedor,
      'saldo' => $saldo,
      'medida' => $medida,
      'costo' => $costo
    ];

    $this->inventarioModel->actualizarProductos($data);

    return $this->response->setJSON([
            "status"  => "success",
            "message" => "Usuario actualizado correctamente"
         ]);

  }
  catch (\Throwable $e) {
    //atrapar errores y responder
    return $this->response->setJSON([
        "status"  => "error",
        "message" => "Error en el servidor: " . $e->getMessage()
    ])->setStatusCode(500);
  }
 }

 public function eliminarProducto(){

  try{
    //atrapar el id del producto a eliminar
    $id = $this->request->getPost('id');
    // eliminar el producto de la base de datos
    $this->inventarioModel->eliminarProducto($id);

    return $this->response->setJSON([
            "status"  => "success",
            "message" => "el Producto se ha eliminado correctamente"
         ]);  
  }
  catch (\Throwable $e) {
    //atrapar errores y responder
    return $this->response->setJSON([
        "status"  => "error",
        "message" => "Error en el servidor: " . $e->getMessage()
    ])->setStatusCode(500);
  }
 }
  
  public function obtenerstock($codigo) {
    $producto = $this->inventarioModel->obtenerstock($codigo);

    return $this->response->setJSON($producto);
  }

  public function buscarProductosPorNombre() {
    $q = trim($this->request->getGet('q') ?? '');
    if (strlen($q) < 2) {
        return $this->response->setJSON([]);
    }
    $productos = $this->inventarioModel->buscarProductosPorNombre($q);
    return $this->response->setJSON($productos);
  }

  public function ingresarEntradaProductos() {

    try{
      $producto = $this->request->getPost('producto');
      $cantidad = $this->request->getPost('cantidad');
      $valor = $this->request->getPost('valor');
      $sede = $this->request->getPost('sede');
      $motivo = $this->request->getPost('motivo');
      $comentarios = $this->request->getPost('comentarios');
      $stock = $this->request->getPost('stock');

      $data = [
        'producto' => $producto,
        'cantidad' => $cantidad,
        'valor' => $valor,
        'sede' => $sede,
        'motivo' => $motivo,
        'comentarios' => $comentarios,
        'stock' => $stock
      ];

      $this->inventarioModel->ingresarEntradaProductos($data);
    }
    catch (\Throwable $e) {
      //atrapar errores y responder
      return $this->response->setJSON([
          "status"  => "error",
          "message" => "Error en el servidor: " . $e->getMessage()
      ])->setStatusCode(500);
    }
  }

  public function ingresarSalidaProductos() { 
    try{
      $producto = $this->request->getPost('producto');
      $cantidad = $this->request->getPost('cantidad');
      $valor = $this->request->getPost('valor');
      $sede = $this->request->getPost('sede');
      $motivo = $this->request->getPost('motivo');
      $comentarios = $this->request->getPost('comentarios');
      $stock = $this->request->getPost('stock');

      $data = [
        'producto' => $producto,
        'cantidad' => $cantidad,
        'valor' => $valor,
        'sede' => $sede,
        'motivo' => $motivo,
        'comentarios' => $comentarios,
        'stock' => $stock
      ];

      $this->inventarioModel->ingresarSalidaProductos($data);
    }
    catch (\Throwable $e) {
      //atrapar errores y responder
      return $this->response->setJSON([
          "status"  => "error",
          "message" => "Error en el servidor: " . $e->getMessage()
      ])->setStatusCode(500);
    }
  }

  //SOLICITUD DE INVENTARIOS
   public function solicitudInventarios() {
      $data = [
        'permisoUsuario' => $this->listasModel->getPermisosMenu(),
        'solicitudes' => $this->inventarioModel->getSolicitudesInventarios(),
      ];
      return view('administrador/solicitudinventarios', $data);
   }

   public function crearSolicitudInventarios() {
     $comentarios = $this->request->getPost('comentarios');
     $carrito = $this->request->getPost('carrito');
     $data = [
       'observacion' => $comentarios,
     ];

     $codigo = $this->inventarioModel->crearSolicitudInventarios($data);

     foreach ($carrito as $item) {
       $detalle = [
        "solicitud_id" => $codigo,
        "producto_id" => $item['codigo'],
        "cantidad" => $item['cantidad'],
       ];

       $this->inventarioModel->crearDetalleSolicitudInventarios($detalle);
     }

   }

   public function pdfSolicitudInventarios() {
      require APPPATH . 'Libraries/fpdf/fpdf.php';

      $db  = \Config\Database::connect();
      $id  = (int) $this->request->getGet('id');

      $builder = $db->table('solicitudes s')
          ->select('s.*, u.nombre, u.apellido')
          ->join('usuarios u', 'u.documento = s.usuario_id', 'left');
      if ($id > 0) $builder->where('s.codigo_solicitud', $id);
      $solicitudes = $builder->orderBy('s.codigo_solicitud', 'DESC')->get()->getResult();

      $pdf = new FPDF('L', 'mm', 'A4');
      $pdf->SetMargins(10, 10, 10);
      $pdf->AddPage();

      $pdf->SetFont('Arial', 'B', 14);
      $pdf->Cell(0, 8, utf8_decode('REPORTE DE SOLICITUDES DE INVENTARIO'), 0, 1, 'C');
      $pdf->SetFont('Times', '', 9);
      $pdf->Cell(0, 5, 'Sistema de inventarios Tomfic   |   Fecha: ' . date('d-m-Y H:i'), 0, 1, 'C');
      $pdf->Cell(0, 5, utf8_decode('Generado por: ') . utf8_decode(session()->get('nombre') . ' ' . session()->get('apellido')), 0, 1, 'C');
      $pdf->Ln(4);

      foreach ($solicitudes as $sol) {
          $pdf->SetFont('Times', 'B', 9);
          $pdf->SetFillColor(230, 245, 225);
          $pdf->Cell(40, 6, utf8_decode('Cód. Solicitud: ') . $sol->codigo_solicitud, 'LTBR', 0, 'L', true);
          $pdf->Cell(50, 6, 'Fecha: ' . substr($sol->fecha_solicitud ?? '', 0, 10), 'TBR', 0, 'L', true);
          $pdf->Cell(40, 6, 'Estado: ' . utf8_decode($sol->estado ?? ''), 'TBR', 0, 'L', true);
          $pdf->Cell(147, 6, utf8_decode('Usuario: ') . utf8_decode($sol->nombre . ' ' . $sol->apellido), 'TBR', 1, 'L', true);

          $detalle = $db->table('detalle_solicitud ds')
              ->select('ds.cantidad_solicitada, p.nombre, p.codigo_interno')
              ->join('productos p', 'p.codigo_barras = ds.producto_id', 'left')
              ->where('ds.solicitud_id', $sol->codigo_solicitud)
              ->get()->getResult();

          if (!empty($detalle)) {
              $pdf->SetFont('Times', 'B', 8);
              $pdf->Cell(10,  5, '#',                      'LTBR', 0, 'C');
              $pdf->Cell(40,  5, utf8_decode('Cód. Interno'), 'TBR', 0, 'L');
              $pdf->Cell(197, 5, 'Producto',               'TBR', 0, 'L');
              $pdf->Cell(30,  5, 'Cantidad',               'TBR', 1, 'C');

              $pdf->SetFont('Times', '', 8);
              foreach ($detalle as $i => $item) {
                  $pdf->Cell(10,  5, $i + 1,                                  'LTBR', 0, 'C');
                  $pdf->Cell(40,  5, utf8_decode($item->codigo_interno ?? '—'), 'TBR', 0, 'L');
                  $pdf->Cell(197, 5, utf8_decode($item->nombre ?? '—'),        'TBR', 0, 'L');
                  $pdf->Cell(30,  5, $item->cantidad_solicitada,              'TBR', 1, 'C');
              }
          }
          $pdf->Ln(4);
      }

      $this->response->setHeader('Content-Type', 'application/pdf');
      $pdf->Output('I', 'solicitudes.pdf');
   }

   public function pdfDevolucionInventarios() {
      require APPPATH . 'Libraries/fpdf/fpdf.php';

      $db = \Config\Database::connect();
      $id = (int) $this->request->getGet('id');

      $builder = $db->table('devoluciones');
      if ($id > 0) $builder->where('solicitud_id', $id);
      $rows = $builder->orderBy('solicitud_id', 'ASC')->get()->getResult();

      $pdf = new FPDF('L', 'mm', 'A4');
      $pdf->SetMargins(10, 10, 10);
      $pdf->AddPage();

      $pdf->SetFont('Arial', 'B', 14);
      $pdf->Cell(0, 8, utf8_decode('REPORTE DE DEVOLUCIONES'), 0, 1, 'C');
      $pdf->SetFont('Times', '', 9);
      $pdf->Cell(0, 5, 'Sistema de inventarios Tomfic   |   Fecha: ' . date('d-m-Y H:i'), 0, 1, 'C');
      $pdf->Cell(0, 5, utf8_decode('Generado por: ') . utf8_decode(session()->get('nombre') . ' ' . session()->get('apellido')), 0, 1, 'C');
      $pdf->Ln(5);

      $pdf->SetFont('Times', 'B', 9);
      $pdf->SetFillColor(230, 245, 225);
      $pdf->Cell(22,  6, utf8_decode('Cód.'),           'LTBR', 0, 'C', true);
      $pdf->Cell(22,  6, 'Solicitud',                   'TBR',  0, 'C', true);
      $pdf->Cell(90,  6, 'Producto',                    'TBR',  0, 'L', true);
      $pdf->Cell(30,  6, utf8_decode('Cant. Devuelta'), 'TBR',  0, 'C', true);
      $pdf->Cell(68,  6, 'Motivo',                      'TBR',  0, 'L', true);
      $pdf->Cell(25,  6, 'Fecha',                       'TBR',  0, 'C', true);
      $pdf->Cell(20,  6, 'Estado',                      'TBR',  1, 'C', true);

      $pdf->SetFont('Times', '', 8);
      foreach ($rows as $row) {
          $pdf->Cell(22,  5, $row->codigo_devolucion,                    'LTBR', 0, 'C');
          $pdf->Cell(22,  5, $row->solicitud_id,                         'TBR',  0, 'C');
          $pdf->Cell(90,  5, utf8_decode($row->nombre_producto ?? '—'),  'TBR',  0, 'L');
          $pdf->Cell(30,  5, $row->cantidad_devuelta,                    'TBR',  0, 'C');
          $pdf->Cell(68,  5, utf8_decode($row->motivo ?? '—'),           'TBR',  0, 'L');
          $pdf->Cell(25,  5, substr($row->fecha ?? '', 0, 10),           'TBR',  0, 'C');
          $pdf->Cell(20,  5, utf8_decode($row->estado ?? ''),            'TBR',  1, 'C');
      }

      $this->response->setHeader('Content-Type', 'application/pdf');
      $pdf->Output('I', 'devoluciones.pdf');
   }

   public function pdfDespachoInventarios() {
      require APPPATH . 'Libraries/fpdf/fpdf.php';

      $db = \Config\Database::connect();
      $id = (int) $this->request->getGet('id');

      $builder = $db->table('despachos');
      if ($id > 0) $builder->where('solicitud_id', $id);
      $rows = $builder->orderBy('solicitud_id', 'ASC')->get()->getResult();

      $pdf = new FPDF('L', 'mm', 'A4');
      $pdf->SetMargins(10, 10, 10);
      $pdf->AddPage();

      $pdf->SetFont('Arial', 'B', 14);
      $pdf->Cell(0, 8, utf8_decode('REPORTE DE DESPACHOS'), 0, 1, 'C');
      $pdf->SetFont('Times', '', 9);
      $pdf->Cell(0, 5, 'Sistema de inventarios Tomfic   |   Fecha: ' . date('d-m-Y H:i'), 0, 1, 'C');
      $pdf->Cell(0, 5, utf8_decode('Generado por: ') . utf8_decode(session()->get('nombre') . ' ' . session()->get('apellido')), 0, 1, 'C');
      $pdf->Ln(5);

      $pdf->SetFont('Times', 'B', 9);
      $pdf->SetFillColor(230, 245, 225);
      $pdf->Cell(22,  6, utf8_decode('Cód.'),              'LTBR', 0, 'C', true);
      $pdf->Cell(22,  6, 'Solicitud',                      'TBR',  0, 'C', true);
      $pdf->Cell(90,  6, 'Producto',                       'TBR',  0, 'L', true);
      $pdf->Cell(30,  6, utf8_decode('Cant. Despachada'),  'TBR',  0, 'C', true);
      $pdf->Cell(68,  6, 'Comentario',                     'TBR',  0, 'L', true);
      $pdf->Cell(25,  6, 'Fecha',                          'TBR',  0, 'C', true);
      $pdf->Cell(20,  6, 'Estado',                         'TBR',  1, 'C', true);

      $pdf->SetFont('Times', '', 8);
      foreach ($rows as $row) {
          $pdf->Cell(22,  5, $row->codigo_despacho,                      'LTBR', 0, 'C');
          $pdf->Cell(22,  5, $row->solicitud_id,                         'TBR',  0, 'C');
          $pdf->Cell(90,  5, utf8_decode($row->nombre_producto ?? '—'),  'TBR',  0, 'L');
          $pdf->Cell(30,  5, $row->cantidad_despachada,                  'TBR',  0, 'C');
          $pdf->Cell(68,  5, utf8_decode($row->comentario ?? '—'),       'TBR',  0, 'L');
          $pdf->Cell(25,  5, substr($row->fecha ?? '', 0, 10),           'TBR',  0, 'C');
          $pdf->Cell(20,  5, utf8_decode($row->estado ?? ''),            'TBR',  1, 'C');
      }

      $this->response->setHeader('Content-Type', 'application/pdf');
      $pdf->Output('I', 'despachos.pdf');
   }
    

   public function ajustarInventario() {
    $ultimoinventario = $this->inventarioModel->getUltimoInventario()->getRow();
     
    $productosconteo = $this->inventarioModel->getCapturaConteos($ultimoinventario->codigo_inventario);

    foreach($productosconteo->getResult() as $producto) {
      $data = [
        'stock' => $producto->conteo1,
        'producto' => $producto->codigo_producto,
      ];
      $this->inventarioModel->ajustarInventario($data);
    }
   }

}

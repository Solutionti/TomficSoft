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

      $pdf = new \FPDF();
      $pdf = new FPDF('L', 'mm', 'A4'); // L = Horizontal
      $pdf->AddPage();

      $this->response->setHeader('Content-Type', 'application/pdf');
      $pdf->Output('I', 'productos_sinconteo.pdf');
   }

   public function pdfDevolucionInventarios() {
        require APPPATH . 'Libraries/fpdf/fpdf.php';

        $pdf = new \FPDF();
        $pdf = new FPDF('L', 'mm', 'A4'); // L = Horizontal
        $pdf->AddPage();

        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output('I', 'productos_sinconteo.pdf');
   }

   public function pdfDespachoInventarios() {
      require APPPATH . 'Libraries/fpdf/fpdf.php';

      $pdf = new \FPDF();
      $pdf = new FPDF('L', 'mm', 'A4'); // L = Horizontal
      $pdf->AddPage();

      $this->response->setHeader('Content-Type', 'application/pdf');
      $pdf->Output('I', 'productos_sinconteo.pdf');
   }
    

   public function ajustarInventario() {
    
   }

}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\VentasModel;

class VentasController extends BaseController {
    
    public function __construct() {
      $this->ventasModel = new VentasModel();
    }

    public function index() {
      return view('administrador/ventas'); 
    }

    public function getProductoVenta() {
      $codigo = $this->request->getPost('codigo_barras');
      $producto = $this->ventasModel->getProductoVenta($codigo);

      if($producto){
        echo json_encode($producto);
      }
      else {
        echo "error";
      }
    }

    public function crearVenta() {
      $consecutivo = $this->request->getPost('consecutivo');
      $documento = $this->request->getPost('documento');
      $recibio = $this->request->getPost('recibio'); 
      $total = $this->request->getPost('total');
      $tppago = $this->request->getPost('tppago');
      $referencia = $this->request->getPost('referencia');
      $sede = $this->request->getPost('sede');
      $idcaja = $this->request->getPost('idcaja');
      $descuento = $this->request->getPost('descuento');
      $transaccion = $this->request->getPost('transaccion');
      $ventas = $this->request->getPost("ventas");
      $contador = 0;
      
      $validacion = $this->ventasModel->getVentaRepetida($consecutivo);
      for($i=0; $i < sizeof($ventas); $i++) {
        $contador = $contador + $ventas[$i]["cantidad"];
      }
      

      if($validacion == 0) {
        $data = [
          "consecutivo" => $consecutivo,
          "documento" => $documento,
          "sede" => $sede,
          "tipo_pago" => $tppago,
          "referencia" => $referencia,
          "total_recibido" => $recibio,
          "total_venta" => $total,
          "cantidad_productos" => $contador,
          "id_caja" => $idcaja,
          "descuento" => $descuento,
          "transaccion"=> $transaccion,
        ];
        $codigoventa = $this->ventasModel->crearVenta($data);
        
        for($i=0; $i < sizeof($ventas); $i++) {

          $descuenta = $this->ventasModel->getInventarioStock($ventas[$i]["codigo"]);
          $stockact = $descuenta->saldo - $ventas[$i]["cantidad"];
          
          $data2 = [
            "codigo_venta" => $consecutivo,
            "venta" => $ventas[$i]["codigo"],
            "cantidad" => $ventas[$i]["cantidad"],
            "categoria" => $descuenta->categoria,
            "precio" => $descuenta->costo
          ];

          $this->ventasModel->updateInventarioStock($ventas[$i]["codigo"], $stockact);
          $this->ventasModel->CrearDetalleVenta($data2);
        }

      }
      else {
        echo "error";
      }


    }
}
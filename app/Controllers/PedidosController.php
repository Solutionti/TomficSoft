<?php

namespace App\Controllers;
use App\Models\ListasModel;
use App\Models\PedidosModel;

class PedidosController extends BaseController {

    public function __construct() {
      $this->listasModel = new ListasModel();
      $this->pedidosModel = new PedidosModel();
    }

    public function index() {
      $data = [
        'permisoUsuario' => $this->listasModel->getPermisosMenu(),
        'pedidos' => $this->pedidosModel->getPedidos(),
      ];
      return view('administrador/pedidos', $data); 
    
    }

    public function getPedidoId($codigo){
      $pedidos = $this->pedidosModel->getPedidoId($codigo);
		   echo json_encode($pedidos);
    }

    public function getPedidosDetalle($codigo){
		  $pedidos = $this->pedidosModel->getPedidosDetalle($codigo);
		
		  echo json_encode($pedidos->getResult());
	  }

    public function actualizarPedido(){
      $domicilio = $this->request->getPost('domicilio');
      $estado = $this->request->getPost('estado');
      $codigo_pedido = $this->request->getPost('codigo_pedido');

      $datos = [
        'domicilio' => $domicilio,
        'estado' => $estado,
        'codigo_pedido' => $codigo_pedido
      ];

      $this->pedidosModel->actualizarPedido($datos);
    }

    public function getPedidosTiempoReal() {
		  $pedido = $this->pedidosModel->getPedidosTiempoReal()->getResult();

		  echo json_encode($pedido);
	  }


}
<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ConsumosModel;
use App\Models\ListasModel;

class ConsumosController extends BaseController
{
    public function __construct()
    {
        $this->model       = new ConsumosModel();
        $this->listasModel = new ListasModel();
    }

    public function index()
    {
        $data = [
            'permisoUsuario' => $this->listasModel->getPermisosMenu(),
            'consumos'       => $this->model->getConsumos(),
        ];
        return view('administrador/consumos', $data);
    }

    public function guardar()
    {
        $j     = $this->request->getJSON(true);
        $items = $j['items'] ?? [];

        if (empty($items)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Agrega al menos un producto.'])
                ->setStatusCode(400);
        }

        $fechaRaw = $j['fecha'] ?? '';
        $fecha    = (strtotime($fechaRaw) !== false && checkdate(
                        (int) date('m', strtotime($fechaRaw)),
                        (int) date('d', strtotime($fechaRaw)),
                        (int) date('Y', strtotime($fechaRaw))
                    ))
                    ? date('Y-m-d', strtotime($fechaRaw))
                    : date('Y-m-d');

        $consumo = [
            'fecha'       => $fecha,
            'observacion' => trim($j['observacion'] ?? ''),
            'usuario_id'  => session()->get('documento'),
        ];

        try {
            $id = $this->model->guardarConsumo($consumo, $items);
            return $this->response->setJSON(['status' => 'success', 'id' => $id]);
        } catch (\Throwable $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()])
                ->setStatusCode(500);
        }
    }

    public function getCategorias()
    {
        return $this->response->setJSON($this->model->getCategorias());
    }

    public function getProductosPorCategoria(string $codigo)
    {
        return $this->response->setJSON($this->model->getProductosPorCategoria($codigo));
    }

    public function getDetalle(int $id)
    {
        $data = $this->model->getConsumoConDetalle($id);
        if (empty($data)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Consumo no encontrado'])
                ->setStatusCode(404);
        }
        return $this->response->setJSON(array_merge(['status' => 'success'], $data));
    }
}

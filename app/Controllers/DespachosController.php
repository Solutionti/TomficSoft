<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DespachosController extends BaseController
{
    public function __construct()
    {
        $this->despachosModel = new \App\Models\DespachosModel();
        $this->session = \Config\Services::session();
    }

    public function getDetalleSolicitud(int $id)
    {
        $solicitud = $this->despachosModel->getSolicitud($id);
        if (!$solicitud) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'No existe una solicitud con ese código',
            ])->setStatusCode(404);
        }

        $detalle = $this->despachosModel->getDetalleSolicitud($id);

        return $this->response->setJSON([
            'status'    => 'success',
            'solicitud' => $solicitud,
            'detalle'   => $detalle,
        ]);
    }

    public function guardar()
    {
        try {
            $json        = $this->request->getJSON(true);
            $solicitudId = (int) ($json['solicitud_id'] ?? 0);
            $items       = $json['items'] ?? [];

            if (!$solicitudId || empty($items)) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Solicitud e ítems son requeridos',
                ])->setStatusCode(400);
            }

            $usuarioId = $this->session->get('id') ?? null;
            $fecha     = date('Y-m-d H:i:s');

            foreach ($items as $item) {
                $cantidad = (int) ($item['cantidad_despachada'] ?? 0);
                if ($cantidad <= 0) continue;

                $this->despachosModel->guardarDespacho([
                    'solicitud_id'       => $solicitudId,
                    'producto_id'        => $item['producto_id'],
                    'nombre_producto'    => $item['nombre_producto'],
                    'cantidad_despachada'=> $cantidad,
                    'comentario'         => trim($item['comentario'] ?? ''),
                    'usuario_id'         => $usuarioId,
                    'fecha'              => $fecha,
                ]);
            }

            return $this->response->setJSON(['status' => 'success']);

        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ])->setStatusCode(500);
        }
    }
}

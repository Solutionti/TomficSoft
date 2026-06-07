<?php

namespace App\Models;

use CodeIgniter\Model;

class DespachosModel extends Model
{
    public function getSolicitud(int $id): ?object
    {
        return $this->db->table('solicitudes')
            ->where('codigo_solicitud', $id)
            ->get()
            ->getRow();
    }

    public function getDetalleSolicitud(int $id): array
    {
        return $this->db->table('detalle_solicitud ds')
            ->select('ds.*, p.nombre, p.codigo_interno,
                COALESCE((SELECT SUM(d.cantidad_despachada) FROM despachos d WHERE d.solicitud_id = ds.solicitud_id AND d.producto_id = ds.producto_id), 0) as cantidad_despachada')
            ->join('productos p', 'p.codigo_barras = ds.producto_id', 'left')
            ->where('ds.solicitud_id', $id)
            ->get()
            ->getResultArray();
    }

    public function guardarDespacho(array $data): void
    {
        $this->db->table('despachos')->insert($data);
    }

    public function descontarStock(int $productoId, int $cantidad): void
    {
        $this->db->table('productos')
            ->where('codigo_barras', $productoId)
            ->set('bodega', "bodega - {$cantidad}", false)
            ->update();
    }

    public function actualizarEstadoSolicitud(int $solicitudId, string $estado): void
    {
        $this->db->table('solicitudes')
            ->where('codigo_solicitud', $solicitudId)
            ->update(['estado' => $estado]);
    }
}

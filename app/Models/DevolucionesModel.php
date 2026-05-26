<?php

namespace App\Models;

use CodeIgniter\Model;

class DevolucionesModel extends Model
{
    public function getDetalleSolicitud(int $id): array
    {
        return $this->db->table('detalle_solicitud ds')
            ->select('ds.*, p.nombre, p.codigo_interno')
            ->join('productos p', 'p.codigo_barras = ds.producto_id', 'left')
            ->where('ds.solicitud_id', $id)
            ->get()
            ->getResultArray();
    }

    public function getSolicitud(int $id): ?object
    {
        return $this->db->table('solicitudes')
            ->where('codigo_solicitud', $id)
            ->get()
            ->getRow();
    }

    public function guardarDevolucion(array $data): void
    {
        $this->db->table('devoluciones')->insert($data);
    }

    public function getDevolucionesPorSolicitud(int $solicitudId): array
    {
        return $this->db->table('devoluciones')
            ->where('solicitud_id', $solicitudId)
            ->get()
            ->getResultArray();
    }
}

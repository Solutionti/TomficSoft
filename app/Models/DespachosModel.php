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
            ->select('ds.*, p.nombre, p.codigo_interno')
            ->join('productos p', 'p.codigo_barras = ds.producto_id', 'left')
            ->where('ds.solicitud_id', $id)
            ->get()
            ->getResultArray();
    }

    public function guardarDespacho(array $data): void
    {
        $this->db->table('despachos')->insert($data);
    }
}

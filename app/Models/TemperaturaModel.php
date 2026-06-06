<?php

namespace App\Models;

use CodeIgniter\Model;

class TemperaturaModel extends Model
{
    public function getNeveras(): array
    {
        return $this->db->table('neveras')
            ->orderBy('nombre', 'ASC')
            ->get()->getResult();
    }

    public function crearNevera(array $data): int
    {
        $this->db->table('neveras')->insert($data);
        return $this->db->insertID();
    }

    public function eliminarNevera(int $id): void
    {
        $this->db->table('neveras')->where('id', $id)->delete();
    }

    public function getRegistrosHoy(string $fecha): array
    {
        return $this->db->table('registros_temperatura r')
            ->select('r.*, n.nombre as nevera_nombre, n.temp_min, n.temp_max')
            ->join('neveras n', 'n.id = r.nevera_id')
            ->where('r.fecha', $fecha)
            ->orderBy('r.hora', 'DESC')
            ->get()->getResult();
    }

    public function getRegistroPorNeveraFecha(int $neveraId, string $fecha): ?object
    {
        return $this->db->table('registros_temperatura')
            ->where('nevera_id', $neveraId)
            ->where('fecha', $fecha)
            ->get()->getRow();
    }

    public function registrarTemperatura(array $data): int
    {
        $this->db->table('registros_temperatura')->insert($data);
        return $this->db->insertID();
    }

    public function getRegistrosPorFecha(string $fecha): array
    {
        return $this->db->table('registros_temperatura r')
            ->select('r.*, n.nombre as nevera_nombre, n.temp_min, n.temp_max')
            ->join('neveras n', 'n.id = r.nevera_id')
            ->where('r.fecha', $fecha)
            ->orderBy('n.nombre', 'ASC')
            ->get()->getResult();
    }

    public function getNeveraById(int $id): ?object
    {
        return $this->db->table('neveras')->where('id', $id)->get()->getRow();
    }
}

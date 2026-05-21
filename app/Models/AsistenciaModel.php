<?php

namespace App\Models;

use CodeIgniter\Model;

class AsistenciaModel extends Model {

    public function generarToken(): string {
        $token = bin2hex(random_bytes(16));
        $this->db->table('qr_tokens')
            ->where('creado_en <', date('Y-m-d H:i:s', strtotime('-30 seconds')))
            ->delete();
        $this->db->table('qr_tokens')->insert([
            'token'     => $token,
            'creado_en' => date('Y-m-d H:i:s'),
        ]);
        return $token;
    }

    public function validarToken(string $token): bool {
        $row = $this->db->table('qr_tokens')
            ->where('token', $token)
            ->where('creado_en >=', date('Y-m-d H:i:s', strtotime('-15 seconds')))
            ->get()->getRow();
        return $row !== null;
    }

    public function getRegistroHoy(string $documento): ?object {
        return $this->db->table('asistencia_real')
            ->where('documento', $documento)
            ->where('fecha', date('Y-m-d'))
            ->get()->getRow();
    }

    public function registrarIngreso(string $documento, string $nombre): void {
        $this->db->table('asistencia_real')->insert([
            'documento'         => $documento,
            'nombre'            => $nombre,
            'fecha'             => date('Y-m-d'),
            'marcacion_ingreso' => date('H:i:s'),
        ]);
    }

    public function registrarSalida(string $documento): void {
        $this->db->table('asistencia_real')
            ->where('documento', $documento)
            ->where('fecha', date('Y-m-d'))
            ->update(['marcacion_salida' => date('H:i:s')]);
    }

    public function getRegistrosHoy(): array {
        return $this->db->table('asistencia_real')
            ->where('fecha', date('Y-m-d'))
            ->orderBy('marcacion_ingreso', 'ASC')
            ->get()->getResult();
    }

    public function getRegistrosFecha(string $fecha): array {
        return $this->db->table('asistencia_real')
            ->where('fecha', $fecha)
            ->orderBy('marcacion_ingreso', 'ASC')
            ->get()->getResult();
    }
}

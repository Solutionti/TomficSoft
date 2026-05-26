<?php

namespace App\Models;

use CodeIgniter\Model;

class HorariosModel extends Model {
  
    public function getColaboradores() {
      $query = $this->db->table('colaboradores')
                    ->select('*')
                    ->get();
        return $query;
    }

    public function getHorarios() {
        return $this->db->table('horarios_colaboradores')
            ->select('*')
            ->where('estado', 'Activo')
            ->orderBy('nombre', 'ASC')
            ->get()
            ->getResult();
    }

    public function crearColaborador($data) {
        return $this->db->table('colaboradores')->insert($data);
    }

    public function eliminarColaborador($documento) {
        $this->db->table('colaboradores')->where('documento', $documento)->delete();
    }

    public function guardarHorario($id, $data) {
        return $this->db->table('horarios_colaboradores')
            ->where('id', $id)
            ->update($data);
    }

    public function getActivosHoy() {
        return $this->db->table('asistencia_real')
            ->where('fecha', date('Y-m-d'))
            ->where('marcacion_ingreso IS NOT NULL', null, false)
            ->where('marcacion_salida IS NULL', null, false)
            ->orderBy('marcacion_ingreso', 'ASC')
            ->get()
            ->getResult();
    }

    public function getSalidaHoy() {
        return $this->db->table('asistencia_real')
            ->where('fecha', date('Y-m-d'))
            ->where('marcacion_ingreso IS NOT NULL', null, false)
            ->where('marcacion_salida IS NOT NULL', null, false)
            ->orderBy('marcacion_salida', 'DESC')
            ->get()
            ->getResult();
    }
}
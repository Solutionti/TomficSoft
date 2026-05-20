<?php

namespace App\Models;

use CodeIgniter\Model;

class DesechosModel extends Model
{
    public function guardarDesecho($data)
    {
        return $this->db->table('desechos_organicos')->insert($data);
    }

    public function getStats()
    {
        $mes = date('Y-m');

        $total = $this->db->table('desechos_organicos')->countAllResults();

        $kg = $this->db->table('desechos_organicos')
            ->selectSum('peso')
            ->get()->getRow()->peso ?? 0;

        $unidades = $this->db->table('desechos_organicos')
            ->selectSum('unidades')
            ->get()->getRow()->unidades ?? 0;

        $mensual = $this->db->table('desechos_organicos')
            ->where("DATE_FORMAT(fecha, '%Y-%m')", $mes)
            ->countAllResults();

        return [
            'total'    => (int) $total,
            'kg'       => round((float) $kg, 2),
            'unidades' => (int) $unidades,
            'mensual'  => (int) $mensual,
        ];
    }
}

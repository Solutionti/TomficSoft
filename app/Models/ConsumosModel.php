<?php

namespace App\Models;

use CodeIgniter\Model;

class ConsumosModel extends Model
{
    public function getConsumos(): array
    {
        return $this->db->table('consumos c')
            ->select('c.*, u.nombre, u.apellido')
            ->join('usuarios u', 'u.documento = c.usuario_id', 'left')
            ->orderBy('c.id', 'DESC')
            ->get()->getResult();
    }

    public function getConsumoConDetalle(int $id): array
    {
        $consumo = $this->db->table('consumos')->where('id', $id)->get()->getRow();
        if (!$consumo) return [];
        $detalle = $this->db->table('detalle_consumo')->where('consumo_id', $id)->get()->getResult();
        return ['consumo' => $consumo, 'detalle' => $detalle];
    }

    public function guardarConsumo(array $consumo, array $items): int
    {
        $this->db->table('consumos')->insert($consumo);
        $id = $this->db->insertID();

        foreach ($items as $item) {
            $this->db->table('detalle_consumo')->insert([
                'consumo_id'      => $id,
                'producto_id'     => $item['producto_id'],
                'nombre_producto' => $item['nombre_producto'],
                'cantidad'        => $item['cantidad'],
            ]);

            $this->db->table('productos')
                ->where('codigo_barras', $item['producto_id'])
                ->set('saldo', 'saldo - ' . (float)$item['cantidad'], false)
                ->update();
        }

        return $id;
    }
}

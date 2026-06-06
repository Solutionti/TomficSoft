<?php

namespace App\Models;

use CodeIgniter\Model;

class ComprasModel extends Model
{
    /* ── Cotizaciones ── */

    public function getCotizaciones(): array
    {
        return $this->db->table('cotizaciones')
            ->orderBy('id', 'DESC')
            ->get()->getResult();
    }

    public function getCotizacionConDetalle(int $id): array
    {
        $cot = $this->db->table('cotizaciones')->where('id', $id)->get()->getRow();
        if (!$cot) return [];
        $detalle = $this->db->table('detalle_cotizacion dc')
            ->select('dc.*, COALESCE(p.medida, "") as medida')
            ->join('productos p', 'p.codigo_barras = dc.producto_id', 'left')
            ->where('dc.cotizacion_id', $id)->get()->getResult();
        return ['cotizacion' => $cot, 'detalle' => $detalle];
    }

    public function guardarCotizacion(array $cot, array $items): int
    {
        $this->db->table('cotizaciones')->insert($cot);
        $id = $this->db->insertID();
        foreach ($items as $item) {
            $item['cotizacion_id'] = $id;
            $this->db->table('detalle_cotizacion')->insert($item);
        }
        return $id;
    }

    public function actualizarEstadoCotizacion(int $id, string $estado): void
    {
        $this->db->table('cotizaciones')->where('id', $id)->update(['estado' => $estado]);
    }

    /* ── Remisiones ── */

    public function getRemisiones(): array
    {
        return $this->db->table('remisiones')
            ->orderBy('id', 'DESC')
            ->get()->getResult();
    }

    public function getRemisionConDetalle(int $id): array
    {
        $rem = $this->db->table('remisiones')->where('id', $id)->get()->getRow();
        if (!$rem) return [];
        $detalle = $this->db->table('detalle_remision dr')
            ->select('dr.*, COALESCE(p.medida, "") as medida')
            ->join('productos p', 'p.codigo_barras = dr.producto_id', 'left')
            ->where('dr.remision_id', $id)->get()->getResult();
        return ['remision' => $rem, 'detalle' => $detalle];
    }

    public function guardarRemision(array $rem, array $items): int
    {
        $this->db->table('remisiones')->insert($rem);
        $id = $this->db->insertID();
        foreach ($items as $item) {
            $item['remision_id'] = $id;
            $this->db->table('detalle_remision')->insert($item);
        }
        return $id;
    }

    /* ── Compras ── */

    public function getCompras(): array
    {
        return $this->db->table('compras')
            ->orderBy('id', 'DESC')
            ->get()->getResult();
    }

    public function getCompraConDetalle(int $id): array
    {
        $compra = $this->db->table('compras')->where('id', $id)->get()->getRow();
        if (!$compra) return [];
        $detalle = $this->db->table('detalle_compra dc')
            ->select('dc.*, COALESCE(p.medida, "") as medida')
            ->join('productos p', 'p.codigo_barras = dc.producto_id', 'left')
            ->where('dc.compra_id', $id)->get()->getResult();
        return ['compra' => $compra, 'detalle' => $detalle];
    }

    public function guardarCompra(array $compra, array $items): int
    {
        $this->db->table('compras')->insert($compra);
        $id = $this->db->insertID();
        foreach ($items as $item) {
            $item['compra_id'] = $id;
            $this->db->table('detalle_compra')->insert($item);
            if (!empty($item['producto_id'])) {
                $this->db->table('productos')
                    ->where('codigo_barras', $item['producto_id'])
                    ->set('bodega', 'bodega + ' . (int)$item['cantidad'], false)
                    ->update();
            }
        }
        return $id;
    }
}

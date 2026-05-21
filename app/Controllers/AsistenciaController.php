<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class AsistenciaController extends BaseController {

    public function __construct() {
        $this->listasModel     = new \App\Models\ListasModel();
        $this->asistenciaModel = new \App\Models\AsistenciaModel();
    }

    public function index() {
        $fecha    = $this->request->getGet('fecha') ?: date('Y-m-d');
        $data = [
            'permisoUsuario' => $this->listasModel->getPermisosMenu(),
            'registros'      => $this->asistenciaModel->getRegistrosFecha($fecha),
            'fechaFiltro'    => $fecha,
        ];
        return view('administrador/asistencia', $data);
    }

    public function monitor() {
        return view('administrador/asistencia_monitor');
    }

    public function generarToken() {
        try {
            $token = $this->asistenciaModel->generarToken();
            return $this->response->setJSON(['token' => $token]);
        } catch (\Throwable $e) {
            return $this->response
                ->setJSON(['error' => $e->getMessage()])
                ->setStatusCode(500);
        }
    }

    public function escanear() {
        return view('administrador/asistencia_escanear');
    }

    public function getRegistros() {
        $fecha    = $this->request->getGet('fecha') ?: date('Y-m-d');
        $registros = $this->asistenciaModel->getRegistrosFecha($fecha);
        $html     = '';
        if (empty($registros)) {
            $html = '<tr><td colspan="5" style="text-align:center;padding:40px;color:#7c6fa0;font-size:13px;">Sin registros para esta fecha.</td></tr>';
        } else {
            foreach ($registros as $i => $r) {
                $tieneI = !empty($r->marcacion_ingreso);
                $tieneS = !empty($r->marcacion_salida);
                if ($tieneI && $tieneS)   { $cls = 'badge-blue-u';    $lbl = 'Completo'; }
                elseif ($tieneI)          { $cls = 'badge-success-u'; $lbl = 'En turno'; }
                else                      { $cls = 'badge-amber-u';   $lbl = 'Sin ingreso'; }
                $inHtml = $tieneI ? '<i class="fas fa-sign-in-alt" style="color:#10b981;font-size:12px"></i> <span class="time-val">'.substr($r->marcacion_ingreso,0,5).'</span>' : '<span class="time-empty">—</span>';
                $outHtml = $tieneS ? '<i class="fas fa-sign-out-alt" style="color:#3b82f6;font-size:12px"></i> <span class="time-val">'.substr($r->marcacion_salida,0,5).'</span>' : '<span class="time-empty">—</span>';
                $html .= "<tr style='--i:".($i+1)."'>
                  <td><div class='user-cell'><div><div class='user-name'>".esc($r->nombre)."</div></div></div></td>
                  <td><span class='user-sub'>".esc($r->documento)."</span></td>
                  <td><div class='time-cell'>$inHtml</div></td>
                  <td><div class='time-cell'>$outHtml</div></td>
                  <td><span class='badge-u $cls'>$lbl</span></td>
                </tr>";
            }
        }
        return $this->response->setJSON(['rows' => $html, 'total' => count($registros)]);
    }

    public function registrar() {
        $json      = $this->request->getJSON(true);
        $token     = trim($json['token'] ?? '');
        $documento = (string) session()->get('documento');
        $nombre    = trim(session()->get('nombre') . ' ' . session()->get('apellido'));

        if (!$token) {
            return $this->response
                ->setJSON(['status' => 'error', 'message' => 'Token inválido'])
                ->setStatusCode(400);
        }

        if (!$this->asistenciaModel->validarToken($token)) {
            return $this->response
                ->setJSON(['status' => 'error', 'message' => 'El QR expiró. Espera el siguiente código.'])
                ->setStatusCode(400);
        }

        $registro = $this->asistenciaModel->getRegistroHoy($documento);

        if (!$registro) {
            $this->asistenciaModel->registrarIngreso($documento, $nombre);
            return $this->response->setJSON([
                'status'  => 'ingreso',
                'message' => "¡Bienvenido, $nombre!",
                'detalle' => 'Ingreso registrado a las ' . date('H:i'),
            ]);
        }

        if ($registro->marcacion_ingreso && !$registro->marcacion_salida) {
            $this->asistenciaModel->registrarSalida($documento);
            return $this->response->setJSON([
                'status'  => 'salida',
                'message' => "¡Hasta luego, $nombre!",
                'detalle' => 'Salida registrada a las ' . date('H:i'),
            ]);
        }

        return $this->response
            ->setJSON([
                'status'  => 'completo',
                'message' => 'Ya tienes ingreso y salida registrados hoy.',
                'detalle' => 'Ingreso: ' . substr($registro->marcacion_ingreso, 0, 5) . ' · Salida: ' . substr($registro->marcacion_salida, 0, 5),
            ])
            ->setStatusCode(409);
    }
}

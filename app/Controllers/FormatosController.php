<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TemperaturaModel;

class FormatosController extends BaseController
{
    public function __construct()
    {
        $this->listasModel   = new \App\Models\ListasModel();
        $this->tempModel     = new TemperaturaModel();
    }

    public function index()
    {
        $hoy      = date('Y-m-d');
        $neveras  = $this->tempModel->getNeveras();
        $registros= $this->tempModel->getRegistrosHoy($hoy);

        $registradosHoy = array_column($registros, null, 'nevera_id');

        $alertas  = 0;
        foreach ($registros as $r) {
            if ($r->temperatura < $r->temp_min || $r->temperatura > $r->temp_max) {
                $alertas++;
            }
        }

        $data = [
            'permisoUsuario' => $this->listasModel->getPermisosMenu(),
            'neveras'        => $neveras,
            'registradosHoy' => $registradosHoy,
            'registrosHoy'   => $registros,
            'totalNeveras'   => count($neveras),
            'registradasHoy' => count($registros),
            'pendientes'     => count($neveras) - count($registros),
            'alertas'        => $alertas,
            'hoy'            => $hoy,
        ];
        return view('administrador/formatos', $data);
    }

    public function crearNevera()
    {
        $j = $this->request->getJSON(true);
        $nombre   = trim($j['nombre'] ?? '');
        $temp_min = (float)($j['temp_min'] ?? 0);
        $temp_max = (float)($j['temp_max'] ?? 10);

        if (!$nombre) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'El nombre es obligatorio.'])->setStatusCode(400);
        }
        if ($temp_min >= $temp_max) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'La temperatura mínima debe ser menor que la máxima.'])->setStatusCode(400);
        }

        $id = $this->tempModel->crearNevera(['nombre' => $nombre, 'temp_min' => $temp_min, 'temp_max' => $temp_max]);
        return $this->response->setJSON(['status' => 'success', 'id' => $id]);
    }

    public function eliminarNevera()
    {
        $j  = $this->request->getJSON(true);
        $id = (int)($j['id'] ?? 0);
        if (!$id) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ID inválido.'])->setStatusCode(400);
        }
        $this->tempModel->eliminarNevera($id);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function registrarTemperatura()
    {
        $j          = $this->request->getJSON(true);
        $nevera_id  = (int)($j['nevera_id'] ?? 0);
        $temperatura= (float)($j['temperatura'] ?? 0);
        $imagen     = $j['imagen'] ?? null;
        $observacion= trim($j['observacion'] ?? '');
        $hoy        = date('Y-m-d');

        if (!$nevera_id) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Nevera inválida.'])->setStatusCode(400);
        }

        $yaRegistrado = $this->tempModel->getRegistroPorNeveraFecha($nevera_id, $hoy);
        if ($yaRegistrado) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Esta nevera ya tiene registro hoy.'])->setStatusCode(400);
        }

        $id = $this->tempModel->registrarTemperatura([
            'nevera_id'   => $nevera_id,
            'temperatura' => $temperatura,
            'imagen'      => $imagen ?: null,
            'fecha'       => $hoy,
            'hora'        => date('H:i:s'),
            'usuario_id'  => session()->get('documento'),
            'observacion' => $observacion,
        ]);

        $nevera = $this->tempModel->getNeveraById($nevera_id);
        $this->enviarWhatsApp($nevera, $temperatura, $imagen, $observacion);

        return $this->response->setJSON(['status' => 'success', 'id' => $id]);
    }

    private function enviarWhatsApp(?object $nevera, float $temp, ?string $imagen, string $obs): void
    {
        $evolutionUrl  = env('EVOLUTION_URL');
        $apiKey        = env('EVOLUTION_API_KEY');
        $instanceName  = env('EVOLUTION_INSTANCE');
        $destino       = env('EVOLUTION_DESTINO');

        if (!$evolutionUrl || !$apiKey || !$instanceName || !$destino) return;

        if (!$nevera) return;

        $enRango = ($temp >= $nevera->temp_min && $temp <= $nevera->temp_max);
        $estado  = $enRango ? '✅ DENTRO DEL RANGO' : '🚨 FUERA DEL RANGO';
        $emoji   = $enRango ? '🟢' : '🔴';

        $mensaje = "{$emoji} *Control de Temperatura*\n"
            . "📅 " . date('d/m/Y H:i') . "\n"
            . "❄️ *Nevera:* {$nevera->nombre}\n"
            . "🌡️ *Temperatura:* {$temp}°C\n"
            . "📊 *Rango:* {$nevera->temp_min}°C — {$nevera->temp_max}°C\n"
            . "Estado: {$estado}"
            . ($obs ? "\n📝 {$obs}" : '');

        try {
            if ($imagen) {
                $base64 = strpos($imagen, 'base64,') !== false
                    ? substr($imagen, strpos($imagen, 'base64,') + 7)
                    : $imagen;

                $payload = json_encode([
                    'number'    => $destino,
                    'mediatype' => 'image',
                    'mimetype'  => 'image/jpeg',
                    'caption'   => $mensaje,
                    'media'     => $base64,
                    'fileName'  => 'temperatura_' . date('Ymd_His') . '.jpg',
                ]);
                $endpoint = "{$evolutionUrl}/message/sendMedia/{$instanceName}";
            } else {
                $payload  = json_encode(['number' => $destino, 'text' => $mensaje]);
                $endpoint = "{$evolutionUrl}/message/sendText/{$instanceName}";
            }

            $ch = curl_init($endpoint);
            curl_setopt_array($ch, [
                CURLOPT_POST           => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 10,
                CURLOPT_HTTPHEADER     => ['Content-Type: application/json', 'apikey: ' . $apiKey],
                CURLOPT_POSTFIELDS     => $payload,
            ]);
            curl_exec($ch);
            curl_close($ch);
        } catch (\Throwable $e) {
            // Silenciar errores de WhatsApp para no bloquear el guardado
        }
    }

    public function reportePdf()
    {
        $fecha    = $this->request->getGet('fecha') ?: date('Y-m-d');
        $registros= $this->tempModel->getRegistrosPorFecha($fecha);
        $neveras  = $this->tempModel->getNeveras();

        require_once APPPATH . 'Libraries/fpdf/fpdf.php';

        $pdf = new \FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetMargins(14, 14, 14);
        $pdf->SetAutoPageBreak(true, 18);

        $W = 182;

        // Cabecera
        $pdf->SetFillColor(45, 102, 34); $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->Cell($W * 0.6, 10, utf8_decode('CONTROL DE TEMPERATURAS'), 0, 0, 'L', true);
        $pdf->SetFillColor(74, 138, 55); $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell($W * 0.4, 10, date('d/m/Y', strtotime($fecha)), 0, 1, 'C', true);

        $pdf->SetFillColor(240, 247, 236); $pdf->SetTextColor(13, 36, 9);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell($W, 6, utf8_decode('Generado: ' . date('d/m/Y H:i') . '  |  Usuario: ' . session()->get('nombre') . ' ' . session()->get('apellido')), 0, 1, 'L', true);
        $pdf->Ln(4);

        // Índice de registradosHoy
        $regIdx = [];
        foreach ($registros as $r) { $regIdx[$r->nevera_id] = $r; }

        // Tabla
        $cW = [8, 60, 22, 22, 22, 26, 22];
        $pdf->SetFillColor(45, 102, 34); $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell($cW[0], 8, '#',             1, 0, 'C', true);
        $pdf->Cell($cW[1], 8, 'Nevera',        1, 0, 'L', true);
        $pdf->Cell($cW[2], 8, 'Temp. Min',     1, 0, 'C', true);
        $pdf->Cell($cW[3], 8, 'Temp. Max',     1, 0, 'C', true);
        $pdf->Cell($cW[4], 8, 'Registrada',    1, 0, 'C', true);
        $pdf->Cell($cW[5], 8, 'Estado',        1, 0, 'C', true);
        $pdf->Cell($cW[6], 8, 'Hora',          1, 1, 'C', true);

        $pdf->SetTextColor(13, 36, 9); $pdf->SetFont('Arial', '', 8);
        $fila = 1;
        foreach ($neveras as $n) {
            $reg   = $regIdx[$n->id] ?? null;
            $temp  = $reg ? $reg->temperatura : null;
            $estado= '—';
            $bg    = [255, 255, 255];

            if ($temp !== null) {
                if ($temp < $n->temp_min || $temp > $n->temp_max) {
                    $estado = 'FUERA'; $bg = [254, 226, 226];
                } elseif ($temp <= $n->temp_min + 1 || $temp >= $n->temp_max - 1) {
                    $estado = 'LIMITE'; $bg = [254, 243, 199];
                } else {
                    $estado = 'OK'; $bg = [209, 250, 229];
                }
            } else {
                $estado = 'Pendiente'; $bg = [248, 248, 248];
            }

            $pdf->SetFillColor(...$bg);
            $pdf->Cell($cW[0], 7, $fila,                  1, 0, 'C', true);
            $pdf->Cell($cW[1], 7, utf8_decode($n->nombre), 1, 0, 'L', true);
            $pdf->Cell($cW[2], 7, $n->temp_min . '°C',    1, 0, 'C', true);
            $pdf->Cell($cW[3], 7, $n->temp_max . '°C',    1, 0, 'C', true);
            $pdf->Cell($cW[4], 7, $temp !== null ? $temp . '°C' : '—', 1, 0, 'C', true);
            $pdf->Cell($cW[5], 7, $estado,                1, 0, 'C', true);
            $pdf->Cell($cW[6], 7, $reg ? substr($reg->hora, 0, 5) : '—', 1, 1, 'C', true);
            $fila++;
        }

        // Fotos (si existen)
        $conFoto = array_filter($registros, fn($r) => !empty($r->imagen));
        if (!empty($conFoto)) {
            $pdf->Ln(6);
            $pdf->SetFillColor(45, 102, 34); $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell($W, 7, utf8_decode('  FOTOS REGISTRADAS'), 0, 1, 'L', true);
            $pdf->SetTextColor(13, 36, 9); $pdf->Ln(3);

            $col = 0; $imgW = 55; $imgH = 42; $perFila = 3;
            foreach ($conFoto as $r) {
                if ($col === $perFila) { $pdf->Ln($imgH + 12); $col = 0; }
                $x = 14 + $col * ($imgW + 6);
                $y = $pdf->GetY();
                try {
                    $b64 = strpos($r->imagen, 'base64,') !== false
                        ? substr($r->imagen, strpos($r->imagen, 'base64,') + 7)
                        : $r->imagen;
                    $tmp = tempnam(sys_get_temp_dir(), 'nevera_') . '.jpg';
                    file_put_contents($tmp, base64_decode($b64));
                    $pdf->Image($tmp, $x, $y, $imgW, $imgH);
                    @unlink($tmp);
                } catch (\Throwable $e) {}
                $pdf->SetXY($x, $y + $imgH + 1);
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell($imgW, 4, utf8_decode($r->nevera_nombre . ' — ' . $r->temperatura . '°C'), 0, 0, 'C');
                $col++;
            }
        }

        $pdf->Ln(14);
        $pdf->SetFont('Arial', 'I', 7);
        $pdf->SetTextColor(150, 150, 150);
        $pdf->Cell($W, 5, utf8_decode('Documento generado electrónicamente — CristalBusiness'), 0, 0, 'C');

        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output('I', 'temperaturas_' . $fecha . '.pdf');
    }
}

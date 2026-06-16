<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class DesechosController extends BaseController {

  public function __construct() {
     $this->listasModel   = new \App\Models\ListasModel();
     $this->desechosModel = new \App\Models\DesechosModel();
  }

  public function buscarProductos()
  {
    $q = trim($this->request->getGet('q') ?? '');
    if (strlen($q) < 1) {
      return $this->response->setJSON([]);
    }

    $db = \Config\Database::connect();
    $resultados = $db->table('productos')
      ->select('codigo_producto, codigo_interno, nombre, referencia')
      ->like('nombre', $q)
      ->orLike('codigo_interno', $q)
      ->where('estado', 'Activo')
      ->limit(8)
      ->get()
      ->getResultArray();

    return $this->response->setJSON($resultados);
  }

  public function guardar()
  {
    try {
      $nombre   = $this->request->getPost('nombre');
      $unidades = $this->request->getPost('unidades');
      $peso     = $this->request->getPost('peso');
      $imagen   = $this->request->getPost('imagen');

      if (!$nombre || $peso === null || $peso === '') {
        return $this->response->setJSON([
          'status'  => 'error',
          'message' => 'Nombre y peso son obligatorios',
        ])->setStatusCode(400);
      }

      $now  = new \DateTime();
      $dias = [
        'Sunday'    => 'Domingo',   'Monday'    => 'Lunes',
        'Tuesday'   => 'Martes',    'Wednesday' => 'Miércoles',
        'Thursday'  => 'Jueves',    'Friday'    => 'Viernes',
        'Saturday'  => 'Sábado',
      ];

      $this->desechosModel->guardarDesecho([
        'nombre'   => $nombre,
        'unidades' => ($unidades !== '' && $unidades !== null) ? (int)$unidades : null,
        'peso'     => $peso,
        'imagen'   => $imagen ?: null,
        'dia'      => $dias[$now->format('l')] ?? $now->format('l'),
        'fecha'    => $now->format('Y-m-d'),
        'hora'     => $now->format('H:i:s'),
      ]);

      return $this->response->setJSON(['status' => 'success']);

    } catch (\Throwable $e) {
      return $this->response->setJSON([
        'status'  => 'error',
        'message' => $e->getMessage(),
      ])->setStatusCode(500);
    }
  }

  public function index(){
    $stats = $this->desechosModel->getStats();
    $data  = [
      'permisoUsuario' => $this->listasModel->getPermisosMenu(),
      'statTotal'      => $stats['total'],
      'statKg'         => $stats['kg'],
      'statUnidades'   => $stats['unidades'],
      'statMensual'    => $stats['mensual'],
      'desechosMensual' => $this->desechosModel->getDesechosMensual(),
    ];
    return view('administrador/desechos', $data);
  }

  public function procesarOcr()
  {
    try {
      $imagen = $this->request->getPost('imagen');

      if (!$imagen) {
        return $this->response->setJSON([
          'status'  => 'error',
          'message' => 'No se recibió imagen',
        ])->setStatusCode(400);
      }

      $apiKey = env('OCR_SPACE_KEY', 'K88888888888888');

      $texto = '';

      // Intentar con Engine 1 y Engine 2; quedarse con el que devuelva texto
      foreach ([1, 2] as $engine) {
        $ch = curl_init();
        curl_setopt_array($ch, [
          CURLOPT_URL            => 'https://api.ocr.space/parse/image',
          CURLOPT_POST           => true,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_TIMEOUT        => 30,
          CURLOPT_HTTPHEADER     => ['apikey: ' . $apiKey],
          CURLOPT_POSTFIELDS     => [
            'base64Image'       => $imagen,
            'language'          => 'eng',
            'OCREngine'         => (string) $engine,
            'scale'             => 'true',
            'isOverlayRequired' => 'false',
          ],
        ]);

        $raw = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) continue;

        $data = json_decode($raw, true);
        if (!empty($data['IsErroredOnProcessing'])) continue;

        $resultado = trim($data['ParsedResults'][0]['ParsedText'] ?? '');
        if ($resultado !== '') {
          $texto = $resultado;
          break;
        }
      }

      return $this->response->setJSON([
        'status' => 'success',
        'texto'  => trim($texto),
      ]);

    } catch (\Throwable $e) {
      return $this->response->setJSON([
        'status'  => 'error',
        'message' => $e->getMessage(),
      ])->setStatusCode(500);
    }
  }
}

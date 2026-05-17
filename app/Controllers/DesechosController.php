<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class DesechosController extends BaseController {

  public function __construct() {
     $this->listasModel = new \App\Models\ListasModel();
  }

  public function index(){
    $data = [
         'permisoUsuario' => $this->listasModel->getPermisosMenu(),
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

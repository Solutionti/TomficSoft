<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>Escanear QR · Asistencia</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
      --purple: #4a8a37;
      --purple-light: #8fba7e;
      --green: #059669;
      --green-bg: #d1fae5;
      --blue: #2563eb;
      --blue-bg: #dbeafe;
      --amber: #d97706;
      --amber-bg: #fef3c7;
      --red: #dc2626;
      --red-bg: #fee2e2;
    }

    html, body {
      height: 100%;
      overflow: hidden;
      background: #050f03;
      font-family: 'Segoe UI', Arial, Helvetica, sans-serif;
    }

    /* ── Top bar ── */
    .scan-topbar {
      position: fixed;
      top: 0; left: 0; right: 0;
      z-index: 30;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 14px 18px;
      background: linear-gradient(180deg, rgba(15,7,32,1) 0%, rgba(15,7,32,0) 100%);
    }
    .scan-back {
      width: 38px; height: 38px;
      border-radius: 50%;
      background: rgba(255,255,255,.12);
      border: none; cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      color: #fff; font-size: 16px;
      text-decoration: none;
      backdrop-filter: blur(6px);
      transition: background .2s;
    }
    .scan-back:hover { background: rgba(255,255,255,.22); }
    .scan-title {
      font-size: .85rem;
      font-weight: 600;
      color: rgba(255,255,255,.85);
      letter-spacing: .05em;
    }
    .scan-user {
      font-size: .75rem;
      color: var(--purple-light);
      font-weight: 600;
      max-width: 120px;
      overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }

    /* ── Camera area ── */
    #reader {
      position: fixed;
      inset: 0;
      z-index: 1;
    }
    /* Override html5-qrcode default styles */
    #reader video {
      width: 100% !important;
      height: 100% !important;
      object-fit: cover !important;
    }
    #reader__scan_region {
      position: fixed !important;
      inset: 0 !important;
      height: 100% !important;
    }
    #reader__dashboard { display: none !important; }
    #reader__camera_selection { display: none !important; }

    /* ── Viewfinder overlay ── */
    .vf-overlay {
      position: fixed;
      inset: 0;
      z-index: 10;
      pointer-events: none;
    }

    /* Dark borders around the scan box */
    .vf-corner {
      position: absolute;
      width: 32px; height: 32px;
      border-color: rgba(143,186,126,.9);
      border-style: solid;
    }
    .vf-tl { top: calc(50% - 110px); left: calc(50% - 110px); border-width: 3px 0 0 3px; border-radius: 4px 0 0 0; }
    .vf-tr { top: calc(50% - 110px); left: calc(50% + 78px);  border-width: 3px 3px 0 0; border-radius: 0 4px 0 0; }
    .vf-bl { top: calc(50% + 78px);  left: calc(50% - 110px); border-width: 0 0 3px 3px; border-radius: 0 0 0 4px; }
    .vf-br { top: calc(50% + 78px);  left: calc(50% + 78px);  border-width: 0 3px 3px 0; border-radius: 0 0 4px 0; }

    /* Scanning line animation */
    .vf-scan-line {
      position: absolute;
      left: calc(50% - 108px);
      width: 216px;
      height: 2px;
      background: linear-gradient(90deg, transparent, rgba(143,186,126,.8), transparent);
      top: calc(50% - 108px);
      animation: scanLine 2s ease-in-out infinite;
    }
    @keyframes scanLine {
      0%   { transform: translateY(0); opacity: 1; }
      50%  { transform: translateY(216px); opacity: .8; }
      100% { transform: translateY(0); opacity: 1; }
    }

    /* ── Bottom instruction pill ── */
    .vf-hint {
      position: fixed;
      bottom: 40px; left: 50%; transform: translateX(-50%);
      z-index: 20;
      background: rgba(0,0,0,.6);
      color: rgba(255,255,255,.8);
      font-size: .78rem;
      font-weight: 500;
      padding: 9px 22px;
      border-radius: 99px;
      backdrop-filter: blur(10px);
      letter-spacing: .04em;
      white-space: nowrap;
      transition: opacity .3s;
    }

    /* ── Result overlay ── */
    .result-overlay {
      position: fixed;
      inset: 0;
      z-index: 50;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 32px;
      opacity: 0;
      transform: scale(.95);
      transition: opacity .25s ease, transform .25s ease;
      pointer-events: none;
    }
    .result-overlay.show {
      opacity: 1;
      transform: scale(1);
      pointer-events: auto;
    }

    .result-overlay.ingreso  { background: rgba(5,150,105,.96); }
    .result-overlay.salida   { background: rgba(37,99,235,.96); }
    .result-overlay.completo { background: rgba(217,119,6,.96); }
    .result-overlay.error    { background: rgba(185,28,28,.96); }

    .result-icon {
      font-size: 5rem;
      margin-bottom: 20px;
      animation: popIn .4s cubic-bezier(.175,.885,.32,1.275) both;
    }
    @keyframes popIn {
      from { transform: scale(0) rotate(-20deg); opacity: 0; }
      to   { transform: scale(1) rotate(0deg); opacity: 1; }
    }

    .result-title {
      font-size: 1.5rem;
      font-weight: 800;
      color: #fff;
      text-align: center;
      line-height: 1.2;
      margin-bottom: 10px;
    }
    .result-detalle {
      font-size: .9rem;
      color: rgba(255,255,255,.8);
      text-align: center;
      line-height: 1.5;
      margin-bottom: 28px;
    }

    .result-progress {
      width: 160px;
      height: 4px;
      background: rgba(255,255,255,.25);
      border-radius: 99px;
      overflow: hidden;
      margin-bottom: 20px;
    }
    .result-progress-bar {
      height: 100%;
      background: #fff;
      border-radius: 99px;
      width: 100%;
      animation: shrink 3s linear forwards;
    }
    @keyframes shrink { from { width: 100%; } to { width: 0%; } }

    .btn-scan-next {
      padding: 12px 32px;
      border-radius: 99px;
      background: rgba(255,255,255,.2);
      color: #fff;
      font-size: .9rem;
      font-weight: 700;
      border: 2px solid rgba(255,255,255,.5);
      cursor: pointer;
      backdrop-filter: blur(6px);
      transition: background .2s;
      letter-spacing: .03em;
    }
    .btn-scan-next:hover { background: rgba(255,255,255,.32); }

    /* ── Processing spinner ── */
    .processing {
      position: fixed;
      inset: 0;
      z-index: 40;
      background: rgba(15,7,32,.8);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 16px;
      opacity: 0;
      pointer-events: none;
      transition: opacity .2s;
    }
    .processing.show { opacity: 1; pointer-events: auto; }
    .proc-ring {
      width: 52px; height: 52px;
      border: 4px solid rgba(143,186,126,.3);
      border-top-color: var(--purple-light);
      border-radius: 50%;
      animation: spin .7s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    .proc-text { color: rgba(255,255,255,.7); font-size: .85rem; letter-spacing: .04em; }
  </style>
</head>
<body>

  <!-- Camera feed -->
  <div id="reader"></div>

  <!-- Viewfinder corners + scan line -->
  <div class="vf-overlay">
    <div class="vf-corner vf-tl"></div>
    <div class="vf-corner vf-tr"></div>
    <div class="vf-corner vf-bl"></div>
    <div class="vf-corner vf-br"></div>
    <div class="vf-scan-line"></div>
  </div>

  <!-- Top bar -->
  <div class="scan-topbar">
    <a href="<?= base_url('asistencia') ?>" class="scan-back">&#8592;</a>
    <div class="scan-title">Registrar Asistencia</div>
    <div class="scan-user"><?= esc(session()->get('nombre')) ?></div>
  </div>

  <!-- Bottom hint -->
  <div class="vf-hint" id="scan-hint">Apunta al código QR del monitor</div>

  <!-- Processing overlay -->
  <div class="processing" id="processing">
    <div class="proc-ring"></div>
    <div class="proc-text">Registrando…</div>
  </div>

  <!-- Result overlay -->
  <div class="result-overlay" id="result-overlay">
    <div class="result-icon" id="result-icon">✅</div>
    <div class="result-title"  id="result-title">—</div>
    <div class="result-detalle" id="result-detalle">—</div>
    <div class="result-progress">
      <div class="result-progress-bar" id="result-bar"></div>
    </div>
    <button class="btn-scan-next" id="btn-scan-next">Escanear otro</button>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"
          crossorigin="anonymous"></script>
  <script>
    const REGISTRAR_URL = '<?= base_url('asistencia/registrar') ?>';
    let scanner       = null;
    let scanning      = true;
    let autoHideTimer = null;

    /* ── Launch camera ── */
    function startScanner() {
      scanning = true;
      scanner  = new Html5Qrcode('reader');
      scanner.start(
        { facingMode: 'environment' },
        { fps: 12, qrbox: { width: 220, height: 220 }, aspectRatio: window.innerHeight / window.innerWidth },
        onScanSuccess
      ).catch(err => {
        console.error('Camera error:', err);
        showResult('error', '📷', 'Sin acceso a la cámara', 'Verifica los permisos del navegador.', false);
      });
    }

    async function onScanSuccess(token) {
      if (!scanning) return;
      scanning = false;

      // Pause camera
      try { await scanner.pause(true); } catch(e) {}

      document.getElementById('processing').classList.add('show');

      try {
        const res  = await fetch(REGISTRAR_URL, {
          method : 'POST',
          headers: { 'Content-Type': 'application/json' },
          body   : JSON.stringify({ token }),
        });
        const data = await res.json();

        document.getElementById('processing').classList.remove('show');

        if (data.status === 'ingreso') {
          showResult('ingreso',  '👋', data.message, data.detalle, true);
        } else if (data.status === 'salida') {
          showResult('salida',   '✌️', data.message, data.detalle, true);
        } else if (data.status === 'completo') {
          showResult('completo', '🔔', data.message, data.detalle, true);
        } else {
          showResult('error',    '❌', data.message || 'Error', data.detalle || '', true);
        }
      } catch(e) {
        document.getElementById('processing').classList.remove('show');
        showResult('error', '📡', 'Error de conexión', 'Comprueba tu internet e inténtalo de nuevo.', true);
      }
    }

    function showResult(type, icon, title, detalle, autoHide) {
      const overlay = document.getElementById('result-overlay');
      overlay.className = `result-overlay ${type}`;

      document.getElementById('result-icon').textContent    = icon;
      document.getElementById('result-title').textContent   = title;
      document.getElementById('result-detalle').textContent = detalle;

      // Reset progress bar animation
      const bar = document.getElementById('result-bar');
      bar.style.animation = 'none';
      bar.offsetHeight; // reflow
      bar.style.animation = '';

      overlay.classList.add('show');

      if (autoHide) {
        clearTimeout(autoHideTimer);
        autoHideTimer = setTimeout(resetScanner, 3200);
      }
    }

    async function resetScanner() {
      clearTimeout(autoHideTimer);
      document.getElementById('result-overlay').classList.remove('show');
      scanning = true;
      try {
        await scanner.resume();
      } catch(e) {
        // If resume fails, restart from scratch
        try { await scanner.stop(); } catch(_) {}
        startScanner();
      }
    }

    document.getElementById('btn-scan-next').addEventListener('click', resetScanner);

    /* ── Init ── */
    startScanner();
  </script>
</body>
</html>

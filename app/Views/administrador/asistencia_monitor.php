<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Control de Asistencia · Monitor</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      background: linear-gradient(160deg, #0f0720 0%, #1a0533 40%, #2d0a55 70%, #1a0533 100%);
      font-family: 'Segoe UI', Arial, Helvetica, sans-serif;
      overflow: hidden;
      user-select: none;
    }

    /* Ambient glow */
    body::before {
      content: '';
      position: fixed;
      top: -200px; left: 50%; transform: translateX(-50%);
      width: 700px; height: 700px;
      background: radial-gradient(circle, rgba(107,33,184,.25) 0%, transparent 70%);
      pointer-events: none;
    }

    /* Clock */
    .mon-clock {
      font-size: clamp(2.5rem, 6vw, 4.5rem);
      font-weight: 200;
      color: rgba(255,255,255,.9);
      letter-spacing: .18em;
      line-height: 1;
      margin-bottom: 6px;
      font-variant-numeric: tabular-nums;
    }
    .mon-date {
      font-size: clamp(.75rem, 1.5vw, 1rem);
      color: rgba(255,255,255,.45);
      letter-spacing: .1em;
      text-transform: uppercase;
      margin-bottom: 36px;
    }

    /* QR Card */
    .qr-card {
      background: #fff;
      border-radius: 28px;
      padding: clamp(20px, 3vw, 36px);
      box-shadow:
        0 40px 100px rgba(0,0,0,.5),
        0 0 0 1px rgba(255,255,255,.08);
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 18px;
      position: relative;
      min-width: 310px;
    }

    /* Brand */
    .qr-brand {
      display: flex;
      align-items: center;
      gap: 12px;
      width: 100%;
      padding-bottom: 14px;
      border-bottom: 1px solid #f0ebfa;
    }
    .qr-brand-icon {
      width: 42px; height: 42px;
      border-radius: 14px;
      background: linear-gradient(135deg, #4a1282, #8b3fd4);
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .qr-brand-icon svg { width: 20px; height: 20px; fill: #fff; }
    .qr-brand-name {
      font-size: 1.05rem;
      font-weight: 800;
      color: #1a0533;
      line-height: 1.1;
    }
    .qr-brand-sub {
      font-size: .72rem;
      color: #a855f7;
      letter-spacing: .04em;
      text-transform: uppercase;
      font-weight: 600;
    }

    /* QR holder */
    #qr-holder {
      width: 256px;
      height: 256px;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }
    #qr-holder img,
    #qr-holder canvas {
      border-radius: 10px;
      display: block;
    }

    /* Spinner shown while loading */
    .qr-spinner {
      position: absolute;
      inset: 0;
      background: rgba(255,255,255,.9);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      transition: opacity .2s;
      pointer-events: none;
    }
    .qr-spinner.show { opacity: 1; }
    .spin-ring {
      width: 44px; height: 44px;
      border: 4px solid #e9d5ff;
      border-top-color: #8b3fd4;
      border-radius: 50%;
      animation: spin .8s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* Progress bar */
    .qr-prog-wrap {
      width: 256px;
      height: 5px;
      background: #f0ebfa;
      border-radius: 99px;
      overflow: hidden;
    }
    .qr-prog-bar {
      height: 100%;
      width: 100%;
      border-radius: 99px;
      background: linear-gradient(90deg, #4a1282, #a855f7);
      transition: width .1s linear;
    }

    /* Instruction */
    .qr-instruction {
      text-align: center;
    }
    .qr-instruction strong {
      display: block;
      font-size: .95rem;
      font-weight: 600;
      color: #1a0533;
    }
    .qr-instruction small {
      font-size: .75rem;
      color: #7c6fa0;
      margin-top: 3px;
      display: block;
    }

    /* Countdown */
    .qr-countdown {
      font-size: .72rem;
      font-weight: 700;
      letter-spacing: .06em;
      color: #a855f7;
      text-transform: uppercase;
    }

    /* Bottom tip */
    .mon-tip {
      margin-top: 28px;
      font-size: clamp(.65rem, 1.2vw, .8rem);
      color: rgba(255,255,255,.22);
      letter-spacing: .06em;
    }

    /* Floating particles (decorative) */
    .particle {
      position: fixed;
      border-radius: 50%;
      pointer-events: none;
      animation: float linear infinite;
      opacity: 0;
    }
    @keyframes float {
      0%   { transform: translateY(100vh) scale(0); opacity: 0; }
      10%  { opacity: .35; }
      90%  { opacity: .1; }
      100% { transform: translateY(-20vh) scale(1); opacity: 0; }
    }
  </style>
</head>
<body>

  <div class="mon-clock" id="mon-clock">00:00:00</div>
  <div class="mon-date"  id="mon-date">—</div>

  <div class="qr-card">
    <div class="qr-brand">
      <div class="qr-brand-icon">
        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/></svg>
      </div>
      <div>
        <div class="qr-brand-name">CristalBusiness</div>
        <div class="qr-brand-sub">Control de Asistencia</div>
      </div>
    </div>

    <div id="qr-holder">
      <div class="qr-spinner show" id="qr-spinner">
        <div class="spin-ring"></div>
      </div>
    </div>

    <div class="qr-prog-wrap">
      <div class="qr-prog-bar" id="qr-prog"></div>
    </div>

    <div class="qr-instruction">
      <strong>Escanea el código con tu teléfono</strong>
      <small>Abre la app TomficSoft &rsaquo; Asistencia &rsaquo; Escanear</small>
    </div>

    <div class="qr-countdown" id="qr-countdown">Cargando…</div>
  </div>

  <div class="mon-tip">Esta pantalla se actualiza automáticamente — no cerrar</div>

  <!-- QRious — genera en <canvas>, CDN verificado -->
  <script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"
          crossorigin="anonymous"></script>
  <script>
    /* ── Clock ── */
    const dias   = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
    const meses  = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
    function tick() {
      const n = new Date();
      const h = String(n.getHours()).padStart(2,'0');
      const m = String(n.getMinutes()).padStart(2,'0');
      const s = String(n.getSeconds()).padStart(2,'0');
      document.getElementById('mon-clock').textContent = `${h}:${m}:${s}`;
      document.getElementById('mon-date').textContent  =
        `${dias[n.getDay()]}, ${n.getDate()} de ${meses[n.getMonth()]} de ${n.getFullYear()}`;
    }
    setInterval(tick, 1000);
    tick();

    /* ── QR rotation ── */
    const INTERVAL = 10;
    let secsLeft   = INTERVAL;
    const spinner  = document.getElementById('qr-spinner');
    const progBar  = document.getElementById('qr-prog');
    const countEl  = document.getElementById('qr-countdown');
    const holder   = document.getElementById('qr-holder');

    let qr = null;

    function makeQR(text) {
      if (qr) {
        qr.value = text;           // QRious actualiza el canvas existente
      } else {
        const canvas = document.createElement('canvas');
        canvas.style.cssText = 'border-radius:10px;display:block;';
        holder.insertBefore(canvas, spinner);
        qr = new QRious({
          element   : canvas,
          value     : text,
          size      : 256,
          foreground: '#1a0533',
          background: '#ffffff',
          level     : 'H',
        });
      }
      spinner.classList.remove('show');
    }

    async function fetchToken() {
      spinner.classList.add('show');
      try {
        const res  = await fetch('<?= base_url('asistencia/token') ?>');
        if (!res.ok) {
          const txt = await res.text();
          throw new Error('HTTP ' + res.status + ' — ¿Creaste las tablas SQL?');
        }
        const data = await res.json();
        if (!data.token) throw new Error('Respuesta sin token');
        makeQR(data.token);
        secsLeft = INTERVAL;
      } catch(e) {
        spinner.classList.remove('show');
        countEl.textContent = '⚠ ' + e.message;
        console.error('fetchToken:', e);
      }
    }

    function countdownTick() {
      secsLeft--;
      const pct = (secsLeft / INTERVAL) * 100;
      progBar.style.width = Math.max(0, pct) + '%';

      if (secsLeft > 0) {
        countEl.textContent = `Nuevo código en ${secsLeft}s`;
      } else {
        countEl.textContent = 'Actualizando…';
        fetchToken();
      }
    }

    /* ── Particles (decorative) ── */
    (function spawnParticles() {
      for (let i = 0; i < 12; i++) {
        const p = document.createElement('div');
        p.className = 'particle';
        const size = Math.random() * 6 + 3;
        p.style.cssText = `
          width:${size}px; height:${size}px;
          left:${Math.random()*100}vw;
          background:rgba(168,85,247,${Math.random()*.4+.1});
          animation-duration:${Math.random()*12+8}s;
          animation-delay:${Math.random()*10}s;
        `;
        document.body.appendChild(p);
      }
    })();

    /* ── Init ── */
    fetchToken();
    setInterval(countdownTick, 1000);
  </script>
</body>
</html>

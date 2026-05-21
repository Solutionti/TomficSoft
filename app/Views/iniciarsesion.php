<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión · CristalBusiness</title>
  <link rel="stylesheet" href="<?= base_url('fontawesome/css/fontawesome.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('fontawesome/css/solid.css') ?>">
  <link rel="stylesheet" href="<?= base_url('fontawesome/css/brands.css') ?>">
  <style>
    :root {
      --p900: #1a0533; --p800: #2d0a55; --p700: #4a1282;
      --p600: #6b21b8; --p500: #8b3fd4; --p400: #a855f7;
      --p300: #c084fc; --p200: #e9d5ff; --p100: #f5f0ff;
      --green: #10b981;
      --border: #e8e0f5;
      --text: #1a0533; --muted: #7c6fa0;
      --surface: #fff; --bg: #fafbff;
      --shadow: 0 24px 64px rgba(26,5,51,.22);
      --radius: 18px; --radius-sm: 10px;
      --tr: all .22s cubic-bezier(.4,0,.2,1);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      min-height: 100vh;
      display: flex;
      font-family: Arial, Helvetica, sans-serif;
      background: var(--bg);
      color: var(--text);
    }

    /* ══════════════════════════════
       LEFT PANEL
    ══════════════════════════════ */
    .login-left {
      width: 42%;
      min-height: 100vh;
      background: linear-gradient(160deg, #0f0720 0%, #1a0533 35%, #2d0a55 65%, #4a1282 100%);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 48px 52px;
      position: relative;
      overflow: hidden;
    }

    /* Glow circles */
    .login-left::before {
      content: '';
      position: absolute;
      top: -120px; left: -80px;
      width: 420px; height: 420px;
      background: radial-gradient(circle, rgba(107,33,184,.35) 0%, transparent 70%);
      pointer-events: none;
    }
    .login-left::after {
      content: '';
      position: absolute;
      bottom: -80px; right: -60px;
      width: 320px; height: 320px;
      background: radial-gradient(circle, rgba(168,85,247,.2) 0%, transparent 70%);
      pointer-events: none;
    }

    .left-content { position: relative; z-index: 1; width: 100%; max-width: 360px; }

    /* Brand */
    .brand-mark {
      display: inline-flex;
      align-items: center;
      gap: 14px;
      margin-bottom: 48px;
    }
    .brand-icon {
      width: 48px; height: 48px; border-radius: 16px;
      background: linear-gradient(135deg, var(--p600), var(--p400));
      display: flex; align-items: center; justify-content: center;
      font-size: 20px; color: #fff;
      box-shadow: 0 8px 24px rgba(107,33,184,.45);
    }
    .brand-name {
      font-size: 1.35rem; font-weight: 800;
      color: #fff; line-height: 1.1;
    }
    .brand-sub {
      font-size: .72rem; color: var(--p300);
      letter-spacing: .08em; text-transform: uppercase;
      margin-top: 2px;
    }

    /* Headline */
    .left-headline {
      font-size: clamp(1.6rem, 2.5vw, 2.1rem);
      font-weight: 250;
      color: #fff;
      line-height: 1.25;
      margin-bottom: 10px;
    }
    .left-headline span { color: var(--p300); }

    .left-desc {
      font-size: .875rem;
      color: rgba(255,255,255,.5);
      line-height: 1.7;
      margin-bottom: 44px;
    }

    /* Feature pills */
    .feature-list { display: flex; flex-direction: column; gap: 14px; }
    .feature-item {
      display: flex; align-items: center; gap: 12px;
    }
    .feature-dot {
      width: 32px; height: 32px; border-radius: 10px; flex-shrink: 0;
      background: rgba(168,85,247,.15);
      border: 1px solid rgba(168,85,247,.3);
      display: flex; align-items: center; justify-content: center;
      font-size: 13px; color: var(--p300);
    }
    .feature-text {
      font-size: .82rem; color: rgba(255,255,255,.65); line-height: 1.4;
    }
    .feature-text strong { color: rgba(255,255,255,.9); font-weight: 600; }

    /* Bottom quote */
    .left-quote {
      margin-top: 20px;
      padding-top: 28px;
      border-top: 1px solid rgba(255,255,255,.1);
    }
    .left-quote p {
      font-size: .82rem; font-style: italic;
      color: rgba(255,255,255,.45); line-height: 1.6; margin-bottom: 10px;
    }
    .left-quote-author {
      font-size: .75rem; font-weight: 700;
      color: var(--p300); letter-spacing: .04em;
      text-transform: uppercase;
    }

    /* Decorative dots */
    .dot-grid {
      position: absolute; bottom: 32px; left: 32px;
      display: grid; grid-template-columns: repeat(6, 8px); gap: 6px;
      opacity: .18; pointer-events: none;
    }
    .dot-grid span {
      width: 4px; height: 4px; border-radius: 50%;
      background: var(--p300); display: block;
    }

    /* ══════════════════════════════
       RIGHT PANEL
    ══════════════════════════════ */
    .login-right {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 24px;
      background: var(--bg);
    }

    .login-card {
      width: 100%;
      max-width: 500px;
      background: var(--surface);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      border: 1px solid var(--border);
      padding: 52px 52px 44px;
      animation: cardIn .4s cubic-bezier(.25,.46,.45,.94) both;
    }
    @keyframes cardIn {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* Card header */
    .card-eyebrow {
      font-size: 10.5px; font-weight: 700; letter-spacing: .1em;
      text-transform: uppercase; color: var(--p400); margin-bottom: 6px;
    }
    .card-title {
      font-size: 1.9rem; font-weight: 800; color: var(--p900);
      margin-bottom: 8px; line-height: 1.15;
    }
    .card-subtitle {
      font-size: .9rem; color: var(--muted); margin-bottom: 32px; line-height: 1.6;
    }

    /* Error alert */
    .messageError { margin-bottom: 0; }
    .messageError:not(:empty) { margin-bottom: 16px; }
    .alert-login {
      background: #fef2f2; border: 1px solid #fecaca;
      color: #991b1b; border-radius: var(--radius-sm);
      padding: 11px 14px; font-size: 12.5px;
      display: flex; align-items: center; gap: 9px;
    }

    /* Form */
    .form-group { margin-bottom: 22px; }
    .form-label {
      display: block; font-size: 11.5px; font-weight: 700;
      text-transform: uppercase; letter-spacing: .07em;
      color: var(--muted); margin-bottom: 6px;
    }

    .fc {
      width: 100%; padding: 13px 16px;
      border: 1.5px solid var(--border); border-radius: var(--radius-sm);
      font-family: Arial, Helvetica; font-size: 15px;
      color: var(--text); background: var(--surface);
      outline: none; transition: var(--tr);
    }
    .fc:focus {
      border-color: var(--p400);
      box-shadow: 0 0 0 3px rgba(168,85,247,.15);
    }
    .fc.is-invalid {
      border-color: #f87171;
      box-shadow: 0 0 0 3px rgba(248,113,113,.15);
    }

    /* Password group */
    .pass-wrap {
      position: relative;
    }
    .pass-wrap .fc { padding-right: 44px; }
    .pass-toggle {
      position: absolute; right: 0; top: 0; bottom: 0;
      width: 42px;
      background: transparent; border: none;
      cursor: pointer; color: var(--muted); font-size: 13px;
      display: flex; align-items: center; justify-content: center;
      transition: color .2s;
      /* keeps JS selector working */
    }
    .pass-toggle:hover { color: var(--p500); }

    /* Submit button */
    .btn-login {
      width: 100%; padding: 15px;
      border: none; border-radius: 50px;
      background: linear-gradient(135deg, var(--p700), var(--p500));
      color: #fff; font-family: Arial, Helvetica;
      font-size: 14px; font-weight: 700;
      cursor: pointer; letter-spacing: .03em;
      box-shadow: 0 6px 20px rgba(107,33,184,.4);
      transition: var(--tr);
      display: flex; align-items: center; justify-content: center; gap: 8px;
      margin-top: 8px;
    }
    .btn-login:hover {
      background: linear-gradient(135deg, var(--p800), var(--p600));
      transform: translateY(-1px);
      box-shadow: 0 10px 28px rgba(107,33,184,.5);
    }
    .btn-login:active { transform: translateY(0); }

    .btn-login .spin { display: none; }
    .btn-login.loading .spin { display: inline-block; animation: spin .7s linear infinite; }
    .btn-login.loading .btn-text { display: none; }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* Footer link */
    .card-footer-note {
      text-align: center; margin-top: 20px;
      font-size: .78rem; color: var(--muted);
    }
    .card-footer-note a {
      color: var(--p500); font-weight: 600; text-decoration: none;
    }
    .card-footer-note a:hover { color: var(--p400); text-decoration: underline; }

    /* Divider */
    .card-divider {
      height: 1px; background: var(--border); margin: 22px 0;
    }

    /* Mobile */
    @media (max-width: 768px) {
      .login-left { display: none; }
      .login-right { background: linear-gradient(160deg, #0f0720, #2d0a55); }
      .login-card {
        box-shadow: 0 32px 80px rgba(0,0,0,.4);
        border-color: rgba(255,255,255,.08);
      }
    }
  </style>
</head>
<body>

  <!-- ═══════════════ LEFT PANEL ═══════════════ -->
  <div class="login-left">
    <div class="left-content">

      <div class="brand-mark">
        
        <div>
          <div class="brand-name">CristalBusiness</div>
        </div>
      </div>

      <h4 class="left-headline">
        Gestiona tu negocio<br><span>de forma inteligente</span>
      </h4>
      <p class="left-desc">
        Inventarios, asistencias, horarios y más — todo en un solo lugar, en tiempo real.
      </p>

      <div class="feature-list">
        <div class="feature-item">
          <div class="feature-dot"><i class="fas fa-truck"></i></div>
          <div class="feature-text"><strong>Control de inventario</strong><br>Seguimiento en tiempo real de entradas y salidas</div>
        </div>
        <div class="feature-item">
          <div class="feature-dot"><i class="fas fa-qrcode"></i></div>
          <div class="feature-text"><strong>Asistencia QR</strong><br>Registro de ingreso y salida con código QR</div>
        </div>
        <div class="feature-item">
          <div class="feature-dot"><i class="fas fa-calendar-week"></i></div>
          <div class="feature-text"><strong>Horarios de equipo</strong><br>Administra turnos y permisos fácilmente</div>
        </div>
      </div>

      <div class="left-quote">
        <p>"Hemos creado un espacio para tus inventarios para que puedas estar al día de cada movimiento."</p>
        <div class="left-quote-author">Jerson Gálvez · Experto en Inventarios</div>
      </div>

    </div>

    <!-- Decorative dots -->
    <div class="dot-grid">
      <?php for($i=0;$i<30;$i++): ?><span></span><?php endfor; ?>
    </div>
  </div>

  <!-- ═══════════════ RIGHT PANEL ═══════════════ -->
  <div class="login-right">
    <div class="login-card">

      <p class="card-eyebrow">Bienvenido</p>
      <h2 class="card-title">Iniciar sesión</h2>
      <p class="card-subtitle">Ingresa tus credenciales para acceder al panel de administración.</p>

      <div class="messageError"></div>

      <form id="FormLOG" novalidate>

        <div class="form-group">
          <label class="form-label" for="usuario">Usuario o Email</label>
          <input
            type="text"
            class="fc"
            id="usuario"
            placeholder="Usuario o email"
            autocomplete="username"
          >
        </div>

        <div class="form-group">
          <label class="form-label" for="password">Contraseña</label>
          <div class="pass-wrap">
            <input
              type="password"
              class="fc js-toggle-password"
              id="password"
              placeholder="••••••••"
              autocomplete="current-password"
            >
            <!-- mantiene selector JS: .input-group-append.input-group-text -->
            <button type="button" class="pass-toggle input-group-append input-group-text" tabindex="-1">
              <i id="changePassIcon" class="fas fa-eye"></i>
            </button>
          </div>
        </div>

        <button type="submit" class="btn-login" id="login">
          <i class="fas fa-spinner spin"></i>
          <span class="btn-text"><i class="fas fa-sign-in-alt" style="margin-right:6px"></i>Iniciar Sesión</span>
        </button>

      </form>

      <div class="card-divider"></div>

      <div class="card-footer-note">
        ¿Olvidaste tu contraseña?
        <a href="#">Recuperar acceso</a>
      </div>

    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script>
    var baseurl = '<?= base_url() ?>';

    /* Spinner en el botón mientras hace login */
    document.getElementById('FormLOG').addEventListener('submit', function () {
      document.getElementById('login').classList.add('loading');
    });

    /* Limpiar spinner y is-invalid al volver */
    window.addEventListener('pageshow', function () {
      document.getElementById('login').classList.remove('loading');
    });
  </script>
  <script src="<?= base_url('js/iniciarsesion.js') ?>"></script>
</body>
</html>

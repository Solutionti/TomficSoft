<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administración · Asistencia</title>
  <?php require_once("componentes/head.php") ?>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --purple-900: #1a0533; --purple-800: #2d0a55; --purple-700: #4a1282;
      --purple-600: #6b21b8; --purple-500: #8b3fd4; --purple-400: #a855f7;
      --purple-300: #c084fc; --purple-200: #e9d5ff; --purple-100: #f5f0ff;
      --accent-green: #10b981; --accent-red: #ef4444; --accent-amber: #f59e0b;
      --accent-blue:  #3b82f6;
      --surface: #ffffff; --surface-alt: #fafbff;
      --border: #e8e0f5; --text-primary: #1a0533; --text-muted: #7c6fa0;
      --shadow-sm: 0 1px 3px rgba(74,18,130,.08);
      --shadow-md: 0 4px 16px rgba(74,18,130,.12);
      --shadow-lg: 0 12px 40px rgba(74,18,130,.18);
      --radius: 14px; --radius-sm: 8px;
      --transition: all .25s cubic-bezier(.4,0,.2,1);
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, Helvetica; background: var(--surface-alt); color: var(--text-primary); }
    h1,h2,h3,h4,h5,h6 { font-family: Arial, Helvetica; }
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: #f5f0ff; }
    ::-webkit-scrollbar-thumb { background: var(--purple-400); border-radius: 99px; }

    /* Wrapper */
    .usr-wrapper { padding: 26px 30px; }
    .usr-topbar {
      display: flex; align-items: center; justify-content: space-between;
      flex-wrap: wrap; gap: 14px; margin-bottom: 26px;
    }
    .usr-breadcrumb { font-size: 11px; font-weight: 600; letter-spacing: .08em;
      text-transform: uppercase; color: var(--purple-400); margin-bottom: 3px; }
    .usr-title { font-size: 25px; font-weight: 800; color: var(--purple-800); }

    /* Buttons */
    .btn-u {
      display: inline-flex; align-items: center; gap: 7px;
      padding: 9px 20px; border-radius: 50px; font-family: Arial, Helvetica;
      font-size: 13px; font-weight: 600; cursor: pointer; border: none;
      transition: var(--transition); white-space: nowrap; text-decoration: none;
    }
    .btn-u-primary {
      background: linear-gradient(135deg, var(--purple-600), var(--purple-500));
      color: #fff; box-shadow: 0 4px 14px rgba(107,33,184,.35);
    }
    .btn-u-primary:hover {
      background: linear-gradient(135deg, var(--purple-700), var(--purple-600));
      transform: translateY(-1px); box-shadow: 0 6px 20px rgba(107,33,184,.45); color: #fff;
    }
    .btn-u-secondary {
      background: var(--surface); color: var(--purple-700);
      border: 1.5px solid var(--purple-200); box-shadow: var(--shadow-sm);
    }
    .btn-u-secondary:hover {
      background: var(--purple-100); border-color: var(--purple-400);
      transform: translateY(-1px); color: var(--purple-700);
    }

    /* Stats strip */
    .stats-strip {
      display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
      gap: 16px; margin-bottom: 22px;
    }
    .stat-card {
      background: var(--surface); border: 1px solid var(--border);
      border-radius: var(--radius); padding: 16px 20px;
      box-shadow: var(--shadow-sm);
      display: flex; align-items: center; gap: 14px;
    }
    .stat-icon {
      width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0;
      display: flex; align-items: center; justify-content: center; font-size: 18px;
    }
    .stat-icon.purple { background: var(--purple-100); color: var(--purple-600); }
    .stat-icon.green  { background: #d1fae5; color: #065f46; }
    .stat-icon.blue   { background: #dbeafe; color: #1d4ed8; }
    .stat-icon.amber  { background: #fef3c7; color: #92400e; }
    .stat-num  { font-size: 1.6rem; font-weight: 800; color: var(--text-primary); line-height: 1; }
    .stat-label { font-size: .72rem; font-weight: 600; color: var(--text-muted);
      text-transform: uppercase; letter-spacing: .06em; margin-top: 3px; }

    /* Table card */
    .usr-table-card {
      background: var(--surface); border: 1px solid var(--border);
      border-radius: var(--radius); overflow: hidden;
      box-shadow: var(--shadow-md); margin-bottom: 22px;
    }
    .usr-table-header {
      display: flex; align-items: center; justify-content: space-between;
      flex-wrap: wrap; gap: 10px;
      padding: 16px 22px; border-bottom: 1px solid var(--border);
    }
    .usr-table-header h5 {
      font-size: 14px; font-weight: 700; color: var(--text-primary);
      display: flex; align-items: center; gap: 8px; margin: 0;
    }
    .count-pill {
      background: var(--purple-100); color: var(--purple-600);
      font-size: 11px; font-weight: 700; padding: 2px 9px;
      border-radius: 99px; letter-spacing: .03em;
    }
    .tbl-search {
      display: flex; align-items: center; gap: 8px;
      background: #fff; border: 1.5px solid var(--border);
      border-radius: 50px; padding: 6px 14px;
      transition: var(--transition);
    }
    .tbl-search:focus-within { border-color: var(--purple-400); box-shadow: 0 0 0 3px rgba(168,85,247,.12); }
    .tbl-search input { border: none; outline: none; font-family: Arial, Helvetica;
      font-size: 13px; color: var(--text-primary); background: transparent; width: 180px; }
    .tbl-search i { color: var(--text-muted); font-size: 13px; }

    /* Table */
    .usr-table { width: 100%; border-collapse: separate; border-spacing: 0; font-size: 13px; }
    .usr-table thead th {
      background: linear-gradient(135deg, var(--purple-800), var(--purple-700));
      color: #fff; padding: 12px 16px; text-align: left;
      font-family: Arial, Helvetica; font-size: 10.5px; font-weight: 700;
      letter-spacing: .06em; text-transform: uppercase; white-space: nowrap;
    }
    .usr-table tbody tr {
      border-bottom: 1px solid #f0ebfa; transition: var(--transition);
      animation: rowIn .35s ease both; opacity: 0;
    }
    @keyframes rowIn {
      from { opacity: 0; transform: translateX(-10px); }
      to   { opacity: 1; transform: translateX(0); }
    }
    .usr-table tbody tr:nth-child(n) { animation-delay: calc(.04s * var(--i, 1)); }
    .usr-table tbody tr:hover { background: linear-gradient(90deg,#f5f0ff,#fdf8ff) !important; }
    .usr-table td { padding: 11px 16px; vertical-align: middle; }

    /* User cell */
    .user-cell { display: flex; align-items: center; gap: 11px; }
    .user-avatar-wrap { position: relative; flex-shrink: 0; }
    .user-avatar { width: 38px; height: 38px; border-radius: 50%; object-fit: cover;
      border: 2px solid var(--purple-200); background: var(--purple-100); }
    .user-name { font-size: 13px; font-weight: 600; color: var(--text-primary); }
    .user-sub  { font-size: 11px; color: var(--text-muted); margin-top: 1px; }

    /* Time badges */
    .time-cell { display: flex; align-items: center; gap: 7px; }
    .time-val { font-size: 14px; font-weight: 700; color: var(--text-primary); font-variant-numeric: tabular-nums; }
    .time-empty { font-size: 12px; color: #cbd5e1; font-weight: 500; }

    /* Status badges */
    .badge-u {
      display: inline-flex; align-items: center; gap: 5px;
      padding: 4px 10px; border-radius: 99px;
      font-size: 11px; font-weight: 700; letter-spacing: .03em;
    }
    .badge-u::before { content: ''; width: 5px; height: 5px; border-radius: 50%;
      background: currentColor; opacity: .75; }
    .badge-success-u { background: #d1fae5; color: #065f46; }
    .badge-danger-u  { background: #fee2e2; color: #991b1b; }
    .badge-amber-u   { background: #fef3c7; color: #92400e; }
    .badge-blue-u    { background: #dbeafe; color: #1d4ed8; }

    /* Animations */
    @keyframes slideUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
    .anim-1 { animation: slideUp .35s ease .04s both; }
    .anim-2 { animation: slideUp .35s ease .10s both; }
    .anim-3 { animation: slideUp .35s ease .18s both; }

    /* Date filter */
    .date-filter-bar {
      display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
    }
    .date-filter-bar input[type=date] {
      padding: 7px 12px; border: 1.5px solid var(--border);
      border-radius: 10px; font-family: Arial, Helvetica; font-size: 13px;
      color: var(--text-primary); outline: none; transition: var(--transition);
      background: var(--surface);
    }
    .date-filter-bar input[type=date]:focus {
      border-color: var(--purple-400); box-shadow: 0 0 0 3px rgba(168,85,247,.15);
    }

    @media(max-width:600px) {
      .usr-wrapper { padding: 16px; }
      .stats-strip { grid-template-columns: 1fr 1fr; }
      .usr-title { font-size: 20px; }
      .tbl-search { display: none; }
    }
  </style>
</head>
<body>
<div class="container-scroller">
  <?php require_once("componentes/navbar.php") ?>
  <div class="container-fluid page-body-wrapper">
    <?php require_once("componentes/lateralderecha.php") ?>
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="usr-wrapper">

          <!-- Top bar -->
          <div class="usr-topbar anim-1">
            <div>
              <p class="usr-breadcrumb">Administración &rsaquo; InventSoft</p>
              <h1 class="usr-title">Control de Asistencia</h1>
            </div>
            <div style="display:flex;gap:10px;flex-wrap:wrap">
              <a href="<?= base_url('asistencia/monitor') ?>" target="_blank" class="btn-u btn-u-secondary">
                <i class="fas fa-tv"></i> Abrir Monitor
              </a>
              <a href="<?= base_url('asistencia/escanear') ?>" class="btn-u btn-u-primary">
                <i class="fas fa-qrcode"></i> Escanear QR
              </a>
            </div>
          </div>

          <?php
            $total    = count($registros);
            $ingreso  = 0; $salida = 0; $pendiente = 0;
            foreach ($registros as $r) {
              if ($r->marcacion_ingreso && $r->marcacion_salida) { $salida++; }
              elseif ($r->marcacion_ingreso) { $ingreso++; }
              else { $pendiente++; }
            }
          ?>

          <!-- Stats -->
          <div class="stats-strip anim-2">
            <div class="stat-card">
              <div class="stat-icon purple"><i class="fas fa-users"></i></div>
              <div>
                <div class="stat-num"><?= $total ?></div>
                <div class="stat-label">Total hoy</div>
              </div>
            </div>
            <div class="stat-card">
              <div class="stat-icon green"><i class="fas fa-sign-in-alt"></i></div>
              <div>
                <div class="stat-num"><?= $ingreso ?></div>
                <div class="stat-label">En turno</div>
              </div>
            </div>
            <div class="stat-card">
              <div class="stat-icon blue"><i class="fas fa-sign-out-alt"></i></div>
              <div>
                <div class="stat-num"><?= $salida ?></div>
                <div class="stat-label">Salida registrada</div>
              </div>
            </div>
            <div class="stat-card">
              <div class="stat-icon amber"><i class="fas fa-clock"></i></div>
              <div>
                <div class="stat-num"><?= date('d/m') ?></div>
                <div class="stat-label"><?= date('l', strtotime('today')) ?></div>
              </div>
            </div>
          </div>

          <!-- Table -->
          <div class="usr-table-card anim-3">
            <div class="usr-table-header">
              <h5>
                <i class="fas fa-calendar-check" style="color:var(--purple-400)"></i>
                Registros de hoy
                <span class="count-pill" id="asist-count"><?= $total ?></span>
              </h5>
              <div class="date-filter-bar">
                <input type="date" id="filtro-fecha" value="<?= esc($fechaFiltro ?? date('Y-m-d')) ?>">
                <button class="btn-u btn-u-secondary" id="btn-filtrar" style="padding:7px 16px">
                  <i class="fas fa-filter"></i> Filtrar
                </button>
              </div>
            </div>
            <div class="table-responsive">
              <table class="usr-table" id="tabla-asistencia">
                <thead>
                  <tr>
                    <th>Colaborador</th>
                    <th>Documento</th>
                    <th>Ingreso</th>
                    <th>Salida</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody id="asist-tbody">
                <?php if (empty($registros)): ?>
                  <tr>
                    <td colspan="5" style="text-align:center;padding:40px;color:#7c6fa0;font-size:13px;">
                      <i class="fas fa-qrcode" style="font-size:2rem;opacity:.3;display:block;margin-bottom:10px"></i>
                      No hay registros para hoy. Los colaboradores deben escanear el QR del monitor.
                    </td>
                  </tr>
                <?php else: foreach ($registros as $i => $r):
                  $tieneIngreso = !empty($r->marcacion_ingreso);
                  $tieneSalida  = !empty($r->marcacion_salida);
                  if ($tieneIngreso && $tieneSalida) { $badgeClass = 'badge-blue-u'; $badgeLabel = 'Completo'; }
                  elseif ($tieneIngreso)              { $badgeClass = 'badge-success-u'; $badgeLabel = 'En turno'; }
                  else                               { $badgeClass = 'badge-amber-u'; $badgeLabel = 'Sin ingreso'; }
                ?>
                  <tr style="--i:<?= $i + 1 ?>">
                    <td>
                      <div class="user-cell">
                        <img src="<?= base_url('img/team-41.jpg') ?>" class="user-avatar" alt="">
                        <div>
                          <div class="user-name"><?= esc($r->nombre) ?></div>
                        </div>
                      </div>
                    </td>
                    <td><span class="user-sub"><?= esc($r->documento) ?></span></td>
                    <td>
                      <?php if ($tieneIngreso): ?>
                        <div class="time-cell">
                          <i class="fas fa-sign-in-alt" style="color:#10b981;font-size:12px"></i>
                          <span class="time-val"><?= substr($r->marcacion_ingreso, 0, 5) ?></span>
                        </div>
                      <?php else: ?>
                        <span class="time-empty">—</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if ($tieneSalida): ?>
                        <div class="time-cell">
                          <i class="fas fa-sign-out-alt" style="color:#3b82f6;font-size:12px"></i>
                          <span class="time-val"><?= substr($r->marcacion_salida, 0, 5) ?></span>
                        </div>
                      <?php else: ?>
                        <span class="time-empty">—</span>
                      <?php endif; ?>
                    </td>
                    <td><span class="badge-u <?= $badgeClass ?>"><?= $badgeLabel ?></span></td>
                  </tr>
                <?php endforeach; endif; ?>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<?php require_once("componentes/scripts.php") ?>
<script>
  /* Live clock in breadcrumb area */
  (function () {
    const days = ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'];
    function pad(n) { return String(n).padStart(2,'0'); }
    function update() {
      const n = new Date();
      const el = document.getElementById('asist-live-time');
      if (el) el.textContent = `${days[n.getDay()]} ${pad(n.getHours())}:${pad(n.getMinutes())}`;
    }
    setInterval(update, 10000);
    update();
  })();

  /* Date filter — reload page with fecha param */
  document.getElementById('btn-filtrar').addEventListener('click', function () {
    const fecha = document.getElementById('filtro-fecha').value;
    if (!fecha) return;
    window.location.href = '<?= base_url('asistencia') ?>?fecha=' + fecha;
  });
  document.getElementById('filtro-fecha').addEventListener('keydown', function (e) {
    if (e.key === 'Enter') document.getElementById('btn-filtrar').click();
  });

  /* Row search */
  const input = document.createElement('input');
  input.type = 'text';
  input.placeholder = 'Buscar colaborador…';
  input.style.cssText = 'border:none;outline:none;font-family:Arial,Helvetica;font-size:13px;color:#1a0533;background:transparent;width:180px;';
  const wrap = document.createElement('div');
  wrap.className = 'tbl-search';
  wrap.innerHTML = '<i class="fas fa-search"></i>';
  wrap.appendChild(input);
  document.querySelector('.usr-table-header').appendChild(wrap);

  input.addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#asist-tbody tr').forEach(tr => {
      const text = tr.textContent.toLowerCase();
      tr.style.display = (!q || text.includes(q)) ? '' : 'none';
    });
  });

  /* Auto-refresh table every 30 seconds */
  setInterval(function () {
    const fecha = document.getElementById('filtro-fecha').value || '<?= date('Y-m-d') ?>';
    fetch('<?= base_url('asistencia/registros') ?>?fecha=' + encodeURIComponent(fecha))
      .then(r => r.json())
      .then(data => {
        if (!data || !data.rows) return;
        const tbody = document.getElementById('asist-tbody');
        tbody.innerHTML = data.rows;
        document.getElementById('asist-count').textContent = data.total;
      })
      .catch(() => {});
  }, 30000);
</script>
</body>
</html>

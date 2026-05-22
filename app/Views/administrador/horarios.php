<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administracion - Horarios</title>
  <?php require_once("componentes/head.php") ?>
  <link
    href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap"
    rel="stylesheet">

  <style>
    /* ══════════════════════════════════════
           DESIGN SYSTEM VARIABLES
        ══════════════════════════════════════ */
    :root {
      --purple-900: #1a0533;
      --purple-800: #2d0a55;
      --purple-700: #4a1282;
      --purple-600: #6b21b8;
      --purple-500: #8b3fd4;
      --purple-400: #a855f7;
      --purple-300: #c084fc;
      --purple-200: #e9d5ff;
      --purple-100: #f5f0ff;
      --accent-green: #10b981;
      --accent-red: #ef4444;
      --accent-amber: #f59e0b;
      --accent-blue: #3b82f6;
      --surface: #ffffff;
      --surface-alt: #fafbff;
      --border: #e8e0f5;
      --text-primary: #1a0533;
      --text-muted: #7c6fa0;
      --shadow-sm: 0 1px 3px rgba(74, 18, 130, .08);
      --shadow-md: 0 4px 16px rgba(74, 18, 130, .12);
      --shadow-lg: 0 12px 40px rgba(74, 18, 130, .18);
      --radius: 14px;
      --radius-sm: 8px;
      --transition: all .25s cubic-bezier(.4, 0, .2, 1);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: Arial, Helvetica;
      background: var(--surface-alt);
      color: var(--text-primary);
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      font-family: Arial, Helvetica;
    }

    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }

    ::-webkit-scrollbar-track {
      background: #f5f0ff;
    }

    ::-webkit-scrollbar-thumb {
      background: var(--purple-400);
      border-radius: 99px;
    }

    /* ══════════════════════════════════════
           WRAPPER & TOP BAR
        ══════════════════════════════════════ */
    .usr-wrapper {
      padding: 26px 30px;
    }

    .usr-topbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 14px;
      margin-bottom: 26px;
    }

    .usr-breadcrumb {
      font-size: 11px;
      font-weight: 600;
      letter-spacing: .08em;
      text-transform: uppercase;
      color: var(--purple-400);
      margin-bottom: 3px;
    }

    .usr-title {
      font-size: 25px;
      font-weight: 800;
      color: var(--purple-800);
    }

    /* ══════════════════════════════════════
           BUTTONS
        ══════════════════════════════════════ */
    .btn-u {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      padding: 9px 20px;
      border-radius: 50px;
      font-family: Arial, Helvetica;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      border: none;
      transition: var(--transition);
      white-space: nowrap;
      text-decoration: none;
    }

    .btn-u-primary {
      background: linear-gradient(135deg, var(--purple-600), var(--purple-500));
      color: #fff;
      box-shadow: 0 4px 14px rgba(107, 33, 184, .35);
    }

    .btn-u-primary:hover {
      background: linear-gradient(135deg, var(--purple-700), var(--purple-600));
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(107, 33, 184, .45);
      color: #fff;
    }

    .btn-u-danger-outline {
      background: transparent;
      border: 1.5px solid var(--accent-red);
      color: var(--accent-red);
    }

    .btn-u-danger-outline:hover {
      background: var(--accent-red);
      color: #fff;
      transform: translateY(-1px);
    }

    .btn-u-success {
      background: linear-gradient(135deg, #059669, var(--accent-green));
      color: #fff;
      box-shadow: 0 4px 14px rgba(16, 185, 129, .3);
    }

    .btn-u-success:hover {
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(16, 185, 129, .4);
      color: #fff;
    }

    /* ══════════════════════════════════════
           STATS STRIP
        ══════════════════════════════════════ */
    .usr-stats {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
      gap: 14px;
      margin-bottom: 24px;
    }

    .stat-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 16px 18px;
      display: flex;
      align-items: center;
      gap: 14px;
      box-shadow: var(--shadow-sm);
      transition: var(--transition);
      animation: slideUp .4s ease both;
    }

    .stat-card:hover {
      border-color: var(--purple-300);
      box-shadow: var(--shadow-md);
      transform: translateY(-3px);
    }

    .stat-card:nth-child(1) {
      animation-delay: .05s;
    }

    .stat-card:nth-child(2) {
      animation-delay: .10s;
    }

    .stat-card:nth-child(3) {
      animation-delay: .15s;
    }

    .stat-card:nth-child(4) {
      animation-delay: .20s;
    }

    .stat-icon {
      width: 44px;
      height: 44px;
      border-radius: 11px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      flex-shrink: 0;
    }

    .stat-icon.purple {
      background: var(--purple-100);
      color: var(--purple-600);
    }

    .stat-icon.green {
      background: #d1fae5;
      color: #065f46;
    }

    .stat-icon.red {
      background: #fee2e2;
      color: #991b1b;
    }

    .stat-icon.blue {
      background: #dbeafe;
      color: #1e40af;
    }

    .stat-info .stat-num {
      font-family: Arial, Helvetica;
      font-size: 22px;
      font-weight: 800;
      color: var(--purple-800);
      line-height: 1;
    }

    .stat-info .stat-label {
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .06em;
      color: var(--text-muted);
      margin-top: 3px;
    }

    /* ══════════════════════════════════════
           TABLE CARD
        ══════════════════════════════════════ */
    .usr-table-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: var(--shadow-sm);
      overflow: hidden;
      animation: slideUp .4s ease .25s both;
    }

    .usr-table-header {
      padding: 15px 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid var(--border);
      background: linear-gradient(90deg, var(--purple-100), #fdf8ff);
      flex-wrap: wrap;
      gap: 10px;
    }

    .usr-table-header h5 {
      font-size: 13.5px;
      font-weight: 700;
      color: var(--purple-800);
      display: flex;
      align-items: center;
      gap: 8px;
      margin: 0;
    }

    .count-pill {
      background: var(--purple-600);
      color: #fff;
      font-size: 11px;
      font-weight: 700;
      padding: 2px 9px;
      border-radius: 50px;
    }

    /* Search box in header */
    .tbl-search {
      display: flex;
      align-items: center;
      gap: 8px;
      background: #fff;
      border: 1.5px solid var(--border);
      border-radius: 50px;
      padding: 6px 14px;
      transition: var(--transition);
    }

    .tbl-search:focus-within {
      border-color: var(--purple-400);
      box-shadow: 0 0 0 3px rgba(168, 85, 247, .12);
    }

    .tbl-search input {
      border: none;
      outline: none;
      font-family: Arial, Helvetica;
      font-size: 13px;
      color: var(--text-primary);
      background: transparent;
      width: 180px;
    }

    .tbl-search i {
      color: var(--text-muted);
      font-size: 13px;
    }

    /* ══════════════════════════════════════
           TABLE
        ══════════════════════════════════════ */
    .usr-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      font-size: 13px;
    }

    .usr-table thead th {
      background: linear-gradient(135deg, var(--purple-800), var(--purple-700));
      color: #fff;
      padding: 12px 16px;
      text-align: left;
      font-family: Arial, Helvetica;
      font-size: 10.5px;
      font-weight: 700;
      letter-spacing: .06em;
      text-transform: uppercase;
      white-space: nowrap;
    }

    .usr-table tbody tr {
      border-bottom: 1px solid #f0ebfa;
      transition: var(--transition);
      animation: rowIn .35s ease both;
      opacity: 0;
    }

    @keyframes rowIn {
      from {
        opacity: 0;
        transform: translateX(-10px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .usr-table tbody tr:nth-child(1) {
      animation-delay: .30s;
    }

    .usr-table tbody tr:nth-child(2) {
      animation-delay: .36s;
    }

    .usr-table tbody tr:nth-child(3) {
      animation-delay: .42s;
    }

    .usr-table tbody tr:nth-child(4) {
      animation-delay: .48s;
    }

    .usr-table tbody tr:nth-child(5) {
      animation-delay: .54s;
    }

    .usr-table tbody tr:nth-child(6) {
      animation-delay: .60s;
    }

    .usr-table tbody tr:nth-child(7) {
      animation-delay: .66s;
    }

    .usr-table tbody tr:nth-child(8) {
      animation-delay: .72s;
    }

    .usr-table tbody tr:nth-child(even) {
      background: #fdfaff;
    }

    .usr-table tbody tr:hover {
      background: linear-gradient(90deg, #f5f0ff, #fdf8ff) !important;
    }

    .usr-table td {
      padding: 12px 16px;
      vertical-align: middle;
    }

    /* ══════════════════════════════════════
           USER AVATAR CELL
        ══════════════════════════════════════ */
    .user-cell {
      display: flex;
      align-items: center;
      gap: 11px;
    }

    .user-avatar-wrap {
      position: relative;
      flex-shrink: 0;
    }

    .user-avatar {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      object-fit: cover;
      border: 2px solid var(--purple-200);
      transition: var(--transition);
    }

    .usr-table tbody tr:hover .user-avatar {
      border-color: var(--purple-400);
      transform: scale(1.08);
    }

    .user-status-dot {
      position: absolute;
      bottom: -2px;
      right: -2px;
      width: 10px;
      height: 10px;
      border-radius: 50%;
      border: 2px solid #fff;
    }

    .dot-active {
      background: var(--accent-green);
    }

    .dot-inactive {
      background: #9ca3af;
    }

    .user-name {
      font-size: 13px;
      font-weight: 700;
      color: var(--text-primary);
      line-height: 1.3;
    }

    .user-sub {
      font-size: 11px;
      color: var(--text-muted);
      margin-top: 1px;
    }

    /* ══════════════════════════════════════
           BADGES
        ══════════════════════════════════════ */
    .badge-u {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 4px 11px;
      border-radius: 50px;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: .03em;
    }

    .badge-u::before {
      content: '';
      width: 5px;
      height: 5px;
      border-radius: 50%;
      background: currentColor;
      opacity: .75;
    }

    .badge-success-u {
      background: #d1fae5;
      color: #065f46;
    }

    .badge-danger-u {
      background: #fee2e2;
      color: #991b1b;
    }

    .badge-primary-u {
      background: var(--purple-100);
      color: var(--purple-700);
    }

    .badge-amber-u {
      background: #fef3c7;
      color: #92400e;
    }

    /* ══════════════════════════════════════
           ACTION BUTTONS
        ══════════════════════════════════════ */
    .action-wrap {
      display: flex;
      gap: 6px;
      align-items: center;
    }

    .btn-action {
      width: 30px;
      height: 30px;
      border-radius: 8px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border: none;
      cursor: pointer;
      font-size: 12px;
      transition: var(--transition);
    }

    .btn-action-edit {
      background: var(--purple-100);
      color: var(--purple-600);
      border: 1.5px solid var(--purple-200);
    }

    .btn-action-edit:hover {
      background: var(--purple-600);
      color: #fff;
      border-color: var(--purple-600);
      transform: rotate(8deg) scale(1.12);
      box-shadow: 0 4px 12px rgba(107, 33, 184, .4);
    }

    .btn-action-del {
      background: #fee2e2;
      color: var(--accent-red);
      border: 1.5px solid #fecaca;
    }

    .btn-action-del:hover {
      background: var(--accent-red);
      color: #fff;
      border-color: var(--accent-red);
      transform: scale(1.12);
      box-shadow: 0 4px 12px rgba(239, 68, 68, .35);
    }

    /* ══════════════════════════════════════
           MODAL SYSTEM
        ══════════════════════════════════════ */
    .modal-content {
      border: none;
      border-radius: var(--radius) !important;
      overflow: hidden;
      box-shadow: var(--shadow-lg);
      font-family: Arial, Helvetica;
    }

    .modal-header-inv {
      background: linear-gradient(135deg, var(--purple-800), var(--purple-600)) !important;
      padding: 17px 24px;
      border-bottom: none;
    }

    .modal-header-inv .modal-title {
      font-family: Arial, Helvetica;
      font-size: 14.5px;
      font-weight: 700;
      color: #fff;
      letter-spacing: .04em;
    }

    .modal-header-inv .btn-close {
      filter: invert(1);
      opacity: .85;
    }

    .modal-body {
      background: var(--surface-alt);
      padding: 24px;
    }

    .modal-footer {
      background: var(--surface);
      border-top: 1px solid var(--border);
      padding: 14px 24px;
    }

    /* ══════════════════════════════════════
           FORM SECTIONS IN MODAL
        ══════════════════════════════════════ */
    .form-section {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 18px 20px;
      margin-bottom: 16px;
      box-shadow: var(--shadow-sm);
    }

    .form-section-title {
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .08em;
      color: var(--purple-600);
      display: flex;
      align-items: center;
      gap: 7px;
      margin-bottom: 16px;
      padding-bottom: 10px;
      border-bottom: 1px solid var(--border);
    }

    .form-section-title i {
      width: 22px;
      height: 22px;
      background: var(--purple-100);
      border-radius: 6px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 10px;
      color: var(--purple-600);
    }

    /* Form labels and inputs */
    .fl {
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .fl label {
      font-size: 10.5px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .06em;
      color: var(--text-muted);
    }

    .fc,
    .fsel {
      width: 100%;
      padding: 8px 12px;
      border: 1.5px solid var(--border);
      border-radius: var(--radius-sm);
      font-family: Arial, Helvetica;
      font-size: 13px;
      color: var(--text-primary);
      background: var(--surface);
      transition: var(--transition);
      outline: none;
      appearance: none;
    }

    .fc:focus,
    .fsel:focus {
      border-color: var(--purple-400);
      box-shadow: 0 0 0 3px rgba(168, 85, 247, .15);
    }

    .fc[readonly] {
      background: var(--purple-100);
      color: var(--purple-700);
    }

    /* Password input group */
    .pass-group {
      display: flex;
      border: 1.5px solid var(--border);
      border-radius: var(--radius-sm);
      overflow: hidden;
      transition: var(--transition);
    }

    .pass-group:focus-within {
      border-color: var(--purple-400);
      box-shadow: 0 0 0 3px rgba(168, 85, 247, .15);
    }

    .pass-group input {
      flex: 1;
      padding: 8px 12px;
      border: none;
      font-family: Arial, Helvetica;
      font-size: 13px;
      color: var(--text-primary);
      background: var(--surface);
      outline: none;
    }

    .pass-group .pass-toggle {
      padding: 0 12px;
      background: var(--purple-100);
      border: none;
      color: var(--purple-600);
      cursor: pointer;
      font-size: 13px;
      transition: var(--transition);
    }

    .pass-group .pass-toggle:hover {
      background: var(--purple-200);
    }

    /* ══════════════════════════════════════
           PERMISSIONS TABLE
        ══════════════════════════════════════ */
    .perm-table-wrap {
      border: 1px solid var(--border);
      border-radius: var(--radius);
      overflow: hidden;
    }

    .perm-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      font-size: 13px;
    }

    .perm-table thead th {
      background: linear-gradient(135deg, var(--purple-800), var(--purple-700));
      color: #fff;
      padding: 11px 14px;
      text-align: left;
      font-family: Arial, Helvetica;
      font-size: 10.5px;
      font-weight: 700;
      letter-spacing: .06em;
      text-transform: uppercase;
      white-space: nowrap;
    }

    .perm-table tbody tr {
      border-bottom: 1px solid #f0ebfa;
      transition: var(--transition);
    }

    .perm-table tbody tr:nth-child(even) {
      background: #fdfaff;
    }

    .perm-table tbody tr:hover {
      background: linear-gradient(90deg, #f5f0ff, #fdf8ff) !important;
    }

    .perm-table td {
      padding: 10px 14px;
      vertical-align: middle;
    }

    .perm-module {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .perm-icon {
      width: 30px;
      height: 30px;
      border-radius: 8px;
      background: var(--purple-100);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--purple-600);
      font-size: 12px;
      flex-shrink: 0;
    }

    .perm-name {
      font-size: 13px;
      font-weight: 600;
      color: var(--text-primary);
    }

    .perm-sub {
      font-size: 11px;
      color: var(--text-muted);
    }

    .chk-perm {
      width: 16px;
      height: 16px;
      accent-color: var(--purple-600);
      cursor: pointer;
    }

    /* ══════════════════════════════════════
           ANIMATIONS
        ══════════════════════════════════════ */
    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(16px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .anim-1 {
      animation: slideUp .35s ease .04s both;
    }

    .anim-2 {
      animation: slideUp .35s ease .10s both;
    }

    .anim-3 {
      animation: slideUp .35s ease .18s both;
    }

    .color-morado {
      background: linear-gradient(135deg, var(--purple-800), var(--purple-700)) !important;
    }

    @media (max-width:768px) {
      .usr-wrapper {
        padding: 14px;
      }

      .usr-title {
        font-size: 20px;
      }

      .tbl-search {
        display: none;
      }
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

            <!-- ══════════ TOP BAR ══════════ -->
            <div class="usr-topbar anim-1">
              <div>
                <p class="usr-breadcrumb">Administración &rsaquo; InventSoft</p>
                <h1 class="">Control de Horarios</h1>
              </div>
              <button class="btn-u btn-u-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="fas fa-user-plus"></i> Agregar Colaborador
              </button>
              
            </div>

            <!-- ══════════ STATS STRIP ══════════ -->
            <!--  -->
          <div class="usr-table-card anim-3">
            <div class="usr-table-header">
              <h5>
                <i class="fas fa-calendar-week" style="color:var(--purple-400)"></i>
                Horarios Semanales
                <span class="count-pill" id="horario-count">5</span>
              </h5>
              <div class="tbl-search">
                <i class="fas fa-search"></i>
                <input type="text" id="horario-search" placeholder="Buscar colaborador…">
              </div>
            </div>
            <div class="table-responsive">
              <table class="usr-table" id="tabla-horarios">
                <thead>
                  <tr>
                    <th>Nombre Colaborador</th>
                    <th style="text-align:center">Lunes</th>
                    <th style="text-align:center">Martes</th>
                    <th style="text-align:center">Miércoles</th>
                    <th style="text-align:center">Jueves</th>
                    <th style="text-align:center">Viernes</th>
                    <th style="text-align:center">Sábado</th>
                    <th style="text-align:center">Domingo</th>
                  </tr>
                </thead>
                <?php
                function horarioBadgeClass(string $v): string {
                    $l = strtolower($v);
                    foreach (['descanso','incapacidad','permiso','vacacion'] as $k) {
                        if (str_contains($l, $k)) return 'badge-danger-u';
                    }
                    if (str_contains($l, 'am') && str_contains($l, 'pm')) {
                        preg_match('/(\d+):\d+\s*pm/i', $v, $m);
                        if (!empty($m) && (int)$m[1] < 2) return 'badge-amber-u';
                        return 'badge-success-u';
                    }
                    if (str_contains($l, 'am') || str_contains($l, 'pm')) return 'badge-amber-u';
                    return 'badge-success-u';
                }
                $diasH = ['lunes','martes','miercoles','jueves','viernes','sabado','domingo'];
                ?>
                <tbody>
                <?php if (empty($horarios)): ?>
                  <tr><td colspan="8" style="text-align:center;padding:30px;color:#7c6fa0;font-size:13px;">No hay colaboradores registrados en la tabla de horarios.</td></tr>
                <?php else: foreach ($horarios as $h): ?>
                  <tr class="horario-row" style="cursor:pointer"
                    data-id="<?= $h->id ?>"
                    data-nombre="<?= esc($h->nombre) ?>"
                    data-cargo="<?= esc($h->cargo ?? '') ?>"
                    data-comentario="<?= esc($h->comentario ?? '') ?>"
                    <?php foreach ($diasH as $d): ?>data-<?= $d ?>="<?= esc($h->$d ?? 'Descanso') ?>" <?php endforeach; ?>>
                    <td>
                      <div class="user-cell">
                        <div>
                          <div class="user-name">
                            <?= esc($h->nombre) ?>
                            <?php if (!empty($h->comentario)): ?>
                              <i class="fas fa-comment-dots" style="color:#a855f7;font-size:11px;margin-left:5px;vertical-align:middle" title="<?= esc($h->comentario) ?>"></i>
                            <?php endif; ?>
                          </div>
                          <div class="user-sub"><?= esc($h->cargo ?? '') ?></div>
                        </div>
                      </div>
                    </td>
                    <?php foreach ($diasH as $d):
                      $val = $h->$d ?? 'Descanso';
                      $cls = horarioBadgeClass($val);
                    ?>
                    <td style="text-align:center"><span class="badge-u <?= $cls ?>"><?= esc($val) ?></span></td>
                    <?php endforeach; ?>
                  </tr>
                <?php endforeach; endif; ?>
                </tbody>
              </table>
            </div>
          </div>
          <!--  -->
          <br>
            <div class="row">
              <div class="col-md-7">
                <div class="usr-table-card anim-3">
                  <div class="container">
                    <div class="col-md-12 mt-3">
                      <div class="table-responsive">
                        <table class="table table-hover usr-table">
                          <thead>
                            <th class="text-white">Colaboradores / Asistencias
                              <a href="<?= base_url('asistencia') ?>">
                                <span class="fas fa-plus mx-1 text-white" title="asistencia de empleados"></span>
                              </a>
                            </th>
                            <th></th>
                          </thead>
                          <tbody>
                            <?php foreach ($colaboradores->getResult() as $colaborador) : ?>
                            <tr>
                              <td>
                              <div class="user-cell">
                                <div class="user-avatar-wrap">
                                  <img src="<?= base_url('img/team-41.jpg') ?>" class="user-avatar">
                                  <span
                                    class="user-status-dot"></span>
                                </div>
                                <div>
                                  <div class="user-name"><?= $colaborador->nombres . ' ' . $colaborador->apellidos ?></div>
                                  <div class="user-sub"><?= $colaborador->documento ?> · <?= $colaborador->cargo ?></div>
                                </div>
                              </div>
                              </td>
                              <td>
                                <div class="text-center">
                                  <div class="action-wrap">
                                    <button class="btn-action btn-action-edit" title="Editar usuario">
                                      <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn-action btn-action-del"  title="Eliminar usuario">
                                      <i class="fas fa-trash"></i>
                                    </button>
                                    <button class="btn-action btn-action-view"  title="Ver usuario">
                                      <i class="fas fa-eye"></i>
                                    </button>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-5">
                <div class="usr-table-card anim-3">
                  <div class="col-md-12 mt-3">
                    <div class="container">

                      <!-- ── Activos hoy (ingresaron, no han salido) ── -->
                      <table class="table table-hover usr-table">
                        <thead>
                          <tr>
                            <th class="text-white">
                              <i class="fas fa-circle" style="color:#10b981;font-size:8px;vertical-align:middle;margin-right:5px"></i>
                              Activos hoy
                              <span style="background:rgba(255,255,255,.2);border-radius:99px;padding:1px 8px;font-size:10px;margin-left:6px"><?= count($activosHoy) ?></span>
                            </th>
                            <th class="text-white" style="text-align:right;font-size:10px;letter-spacing:.05em">INGRESO</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if (empty($activosHoy)): ?>
                            <tr>
                              <td colspan="2" style="text-align:center;padding:20px;color:#7c6fa0;font-size:12px;">
                                <i class="fas fa-qrcode" style="opacity:.3;margin-right:6px"></i>
                                Sin registros de ingreso hoy
                              </td>
                            </tr>
                          <?php else: foreach ($activosHoy as $a): ?>
                            <tr>
                              <td>
                                <div class="user-cell">
                                  <div class="user-avatar-wrap">
                                    <img src="<?= base_url('img/team-41.jpg') ?>" class="user-avatar">
                                    <span class="user-status-dot" style="background:#10b981;box-shadow:0 0 0 2px rgba(16,185,129,.25)"></span>
                                  </div>
                                  <div>
                                    <div class="user-name"><?= esc($a->nombre) ?></div>
                                    <div class="user-sub"><?= esc($a->documento) ?></div>
                                  </div>
                                </div>
                              </td>
                              <td style="text-align:right;vertical-align:middle">
                                <span style="font-size:13px;font-weight:700;color:#065f46;background:#d1fae5;padding:3px 10px;border-radius:99px;">
                                  <?= substr($a->marcacion_ingreso, 0, 5) ?>
                                </span>
                              </td>
                            </tr>
                          <?php endforeach; endif; ?>
                        </tbody>
                      </table>

                      <br>

                      <!-- ── Salida registrada hoy ── -->
                      <table class="table table-hover usr-table">
                        <thead>
                          <tr>
                            <th class="text-white">
                              <i class="fas fa-circle" style="color:#94a3b8;font-size:8px;vertical-align:middle;margin-right:5px"></i>
                              Salida registrada
                              <span style="background:rgba(255,255,255,.2);border-radius:99px;padding:1px 8px;font-size:10px;margin-left:6px"><?= count($salidaHoy) ?></span>
                            </th>
                            <th class="text-white" style="text-align:right;font-size:10px;letter-spacing:.05em">SALIDA</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if (empty($salidaHoy)): ?>
                            <tr>
                              <td colspan="2" style="text-align:center;padding:20px;color:#7c6fa0;font-size:12px;">Sin salidas registradas</td>
                            </tr>
                          <?php else: foreach ($salidaHoy as $s): ?>
                            <tr>
                              <td>
                                <div class="user-cell">
                                  <div class="user-avatar-wrap">
                                    <img src="<?= base_url('img/team-41.jpg') ?>" class="user-avatar">
                                    <span class="user-status-dot" style="background:#94a3b8"></span>
                                  </div>
                                  <div>
                                    <div class="user-name"><?= esc($s->nombre) ?></div>
                                    <div class="user-sub"><?= esc($s->documento) ?></div>
                                  </div>
                                </div>
                              </td>
                              <td style="text-align:right;vertical-align:middle">
                                <span style="font-size:13px;font-weight:700;color:#1d4ed8;background:#dbeafe;padding:3px 10px;border-radius:99px;">
                                  <?= substr($s->marcacion_salida, 0, 5) ?>
                                </span>
                              </td>
                            </tr>
                          <?php endforeach; endif; ?>
                        </tbody>
                      </table>

                    </div>
                  </div>
                </div>
              </div>
            </div>

            <br>
            
          </div>
          </div>
        <br>
        </div>
      </div>
     </div>
    </div>
   </div>
  </div>
  <!-- ══════════════════════════════════════════════
     MODAL: CREAR USUARIO
══════════════════════════════════════════════ -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header modal-header-inv">
          <h1 class="modal-title"><i class="fas fa-user-plus me-2"></i>Colaboradores</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <!-- SECCIÓN: Datos personales -->
          <div class="form-section">
            <div class="form-section-title">
              <i class="fas fa-id-card"></i> Datos del Colaborador
            </div>
            <div class="row g-3">
              <div class="col-md-3">
                <div class="fl">
                  <label>Documento *</label>
                  <input type="number" id="codigo_producto" class="fc" required>
                </div>
              </div>
              <div class="col-md-3">
                <div class="fl">
                  <label>Nombres *</label>
                  <input type="text" id="nombre_producto" class="fc" required>
                </div>
              </div>
              <div class="col-md-3">
                  <div class="fl">
                    <label>Apellidos *</label>
                    <input type="text" id="unidades_producto" class="fc" required>
                  </div>
              </div>
              
              <div class="col-md-3">
                <div class="fl">
                  <label>Telefono *</label>
                  <input type="text" id="unidades_producto" class="fc" required>
                </div>
              </div>
            </div>
            <div class="row g-3 mt-3">
              <div class="col-md-3">
                <div class="fl">
                  <label>Direccion *</label>
                  <select class="fc fsel text-uppercase" id="estado_usuario" required>
                    <option value="Activo">Carrera</option>
                    <option value="Inactivo">Calle</option>
                  </select>
                </div>
              </div>
              <div class="col-md-1">
                <div class="fl">
                  <label>*</label>
                  <input type="text" id="nombre_producto" class="fc" required>
                </div>
              </div>
              
              <div class="col-md-1">
                <div class="fl">
                  <label>*</label>
                  <input type="text" id="nombre_producto" class="fc" required>
                </div>
              </div>
              <div class="col-md-1">
                <div class="fl">
                  <label>*</label>
                  <input type="text" id="nombre_producto" class="fc" required>
                </div>
              </div>
              <div class="col-md-2">
                <div class="fl">
                  <label>*</label>
                  <input type="text" id="nombre_producto" class="fc" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="fl">
                  <label>Barrio *</label>
                  <input type="text" id="unidades_producto" class="fc" required>
                </div>
              </div>
              <div class="col-md-3">
                <div class="fl">
                  <label>Sexo *</label>
                  <select class="fc fsel" id="sexo_usuario" required>
                    <option value="">Seleccione el sexo</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="fl">
                  <label>Fecha de nacimiento *</label>
                  <input type="date" id="fecha_nacimiento_usuario" class="fc" required>
                </div>
                </div>
              <div class="col-md-6">
                <div class="fl">
                  <label>Cargo *</label>
                  <select class="fc fsel" id="estado_usuario" required>
                    <option value="">Seleccione el cargo</option>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-12">
                <div class="fl">
                  <label>Comentarios *</label>
                  <input type="email" id="correo" class="fc">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-u btn-u-danger-outline" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Cerrar
          </button>
          <button type="button" class="btn-u btn-u-primary" onclick="crearUsuarios()">
            <i class="fas fa-save"></i> Guardar
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- ══════════════════════════════════════════════
     MODAL: ACTUALIZAR USUARIO
══════════════════════════════════════════════ -->
  <div class="modal fade" id="actualizarUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header modal-header-inv">
          <h1 class="modal-title"><i class="fas fa-user-edit me-2"></i>Actualizar Usuario y Permisos</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <!-- SECCIÓN: Datos personales -->
          <div class="form-section">
            <div class="form-section-title">
              <i class="fas fa-id-card"></i> Datos personales
            </div>
            <div class="row g-3">
              <div class="col-md-4">
                <div class="fl">
                  <label>Documento *</label>
                  <input type="number" id="documento_usuario_actualizar" class="fc" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="fl">
                  <label>Nombre *</label>
                  <input type="text" id="nombre_usuario_actualizar" class="fc" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="fl">
                  <label>Apellido *</label>
                  <input type="text" id="apellido_usuario_actualizar" class="fc" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="fl">
                  <label>Empresa *</label>
                  
                </div>
              </div>
              <div class="col-md-4">
                <div class="fl">
                  <label>Teléfono *</label>
                  <input type="number" id="telefono_usuario_actualizar" class="fc" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="fl">
                  <label>Estado *</label>
                  <select class="fc fsel" id="estado_usuario_actualizar" required>
                    <option value="">Seleccione estado</option>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="fl">
                  <label>Correo electrónico *</label>
                  <input type="email" id="correo_actualizar" class="fc">
                </div>
              </div>
            </div>
          </div>

          <!-- SECCIÓN: Acceso al sistema -->
          <div class="form-section">
            <div class="form-section-title">
              <i class="fas fa-lock"></i> Acceso al sistema
            </div>
            <div class="row g-3">
              <div class="col-md-4">
                <div class="fl">
                  <label>Rol *</label>
                  <select class="fc fsel" id="rol_usuario_actualizar">
                    <option value="">Seleccione el rol</option>
                    <option value="Administrador">Administrador</option>
                    <option value="Capturador">Auxiliar Capturador</option>
                    <option value="Vendedor">Vendedor</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="fl">
                  <label>Fecha</label>
                  <input type="date" id="fecha_usuario_actualizar" class="fc" value="<?php echo date('Y-m-d') ?>"
                    readonly>
                </div>
              </div>
              <div class="col-md-4">
                <div class="fl">
                  <label>Hora</label>
                  <input type="time" id="hora_usuario_actualizar" class="fc" value="<?= date('H:i') ?>" readonly>
                </div>
              </div>
              <div class="col-md-4">
                <div class="fl">
                  <label>Usuario *</label>
                  <input type="text" id="usuario_usuario_actualizar" class="fc">
                </div>
              </div>
              <div class="col-md-4">
                <div class="fl">
                  <label>Contraseña *</label>
                  <div class="pass-group">
                    <input type="password" id="password_usuario_actualizar" placeholder="Nueva contraseña"
                      class="js-toggle-password">
                    <button type="button" class="pass-toggle"
                      onclick="this.previousElementSibling.type = this.previousElementSibling.type === 'password' ? 'text' : 'password'; this.querySelector('i').classList.toggle('fa-eye'); this.querySelector('i').classList.toggle('fa-eye-slash');">
                      <i class="fas fa-eye"></i>
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="fl">
                  <label>Repetir contraseña *</label>
                  <div class="pass-group">
                    <input type="password" id="repetir_password_usuario_actualizar" placeholder="Confirmar contraseña"
                      class="js-toggle-password">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- SECCIÓN: Permisos -->
          <div class="form-section">
            <div class="form-section-title">
              <i class="fas fa-shield-alt"></i> Permisos de usuario
            </div>
            <div class="perm-table-wrap">
              <!--  -->
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn-u btn-u-danger-outline" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Cerrar
          </button>
          <button type="button" class="btn-u btn-u-primary" onclick="actualizarUsuario()">
            <i class="fas fa-sync-alt"></i> Actualizar usuario
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- ══════════════════════════════════════════════
     MODAL: EDITAR HORARIO
══════════════════════════════════════════════ -->
  <div class="modal fade" id="modalHorario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header modal-header-inv">
          <h5 class="modal-title">
            <i class="fas fa-calendar-pen me-2"></i>
            Editar Horario — <span id="mh-nombre"></span>
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p style="font-size:12px;color:var(--text-muted);margin-bottom:18px;">
            <i class="fas fa-circle-info me-1"></i>
            Edita el horario de cada día. Usa formato <strong>HH:MM - HH:MM</strong> o escribe <strong>Descanso / Incapacidad / Permiso</strong>.
          </p>
          <div class="row g-3" id="mh-dias"></div>

          <!-- ── Comentario / Observación ── -->
          <div class="row g-3 mt-2">
            <div class="col-12">
              <div class="fl">
                <label style="font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--text-muted);display:flex;align-items:center;gap:6px;">
                  <i class="fas fa-comment-dots" style="color:var(--purple-400)"></i>
                  Observaciones / Comentario
                </label>
                <textarea id="mh-comentario" class="fc"
                  rows="3"
                  placeholder="Ej: Permiso médico autorizado por RRHH. Incapacidad del 20/05 al 25/05…"
                  style="resize:vertical;min-height:72px;font-size:13px;padding:9px 12px;line-height:1.5"></textarea>
                <span style="font-size:10.5px;color:var(--text-muted);margin-top:3px;">
                  Este comentario se muestra como indicador en la tabla de horarios.
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-u btn-u-danger-outline" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Cancelar
          </button>
          <button type="button" class="btn-u btn-u-primary" id="mh-btn-guardar">
            <i class="fas fa-save"></i> Guardar horario
          </button>
        </div>
      </div>
    </div>
  </div>

  <?php require_once("componentes/scripts.php") ?>

  <script>
  document.addEventListener('DOMContentLoaded', function () {
  (function () {
    const dias = ['lunes','martes','miercoles','jueves','viernes','sabado','domingo'];
    const diasLabel = ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'];

    const modal     = new bootstrap.Modal(document.getElementById('modalHorario'));
    const mhNombre  = document.getElementById('mh-nombre');
    const mhDias    = document.getElementById('mh-dias');
    let filaActiva  = null;

    /* ── Abrir modal al hacer click en una fila ── */
    document.querySelectorAll('.horario-row').forEach(row => {
      row.addEventListener('click', () => {
        filaActiva = row;
        mhNombre.textContent = row.dataset.nombre;

        /* Construir los campos de cada día */
        mhDias.innerHTML = dias.map((d, i) => {
          const valor = row.dataset[d] || '';
          return `
            <div class="col-md-6 col-lg-3">
              <div class="fl">
                <label style="font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--text-muted);">
                  ${diasLabel[i]}
                </label>
                <input type="text" class="fc mh-dia-input" data-dia="${d}"
                  value="${valor}"
                  placeholder="ej: 8:00 AM - 5:00 PM"
                  style="font-size:12px;padding:7px 10px;">
              </div>
            </div>`;
        }).join('');

        /* Cargar comentario */
        document.getElementById('mh-comentario').value = row.dataset.comentario || '';

        modal.show();
      });
    });

    /* ── Guardar: actualiza DOM + persiste en BD ── */
    document.getElementById('mh-btn-guardar').addEventListener('click', async () => {
      if (!filaActiva) return;

      const btn       = document.getElementById('mh-btn-guardar');
      const comentario = document.getElementById('mh-comentario').value.trim();
      const payload   = { id: parseInt(filaActiva.dataset.id), comentario };

      document.querySelectorAll('.mh-dia-input').forEach(input => {
        const d     = input.dataset.dia;
        const valor = input.value.trim() || 'Descanso';
        filaActiva.dataset[d] = valor;
        payload[d] = valor;

        /* Determinar clase del badge según contenido */
        const lower = valor.toLowerCase();
        let cls = 'badge-success-u';
        if (['descanso', 'incapacidad', 'permiso'].some(k => lower.includes(k))) {
          cls = 'badge-danger-u';
        } else if (lower.includes('am') && lower.includes('pm')) {
          const match = valor.match(/(\d+):(\d+)\s*PM/i);
          if (match && parseInt(match[1]) < 2) cls = 'badge-amber-u';
        } else if (lower.includes('am - ') && !lower.includes('pm')) {
          cls = 'badge-amber-u';
        }

        const idx   = dias.indexOf(d);
        const celda = filaActiva.querySelectorAll('td')[idx + 1];
        if (celda) celda.innerHTML = `<span class="badge-u ${cls}">${valor}</span>`;
      });

      /* Actualizar indicador de comentario en la fila */
      filaActiva.dataset.comentario = comentario;
      const nameDiv = filaActiva.querySelector('.user-name');
      const oldIcon = nameDiv.querySelector('.fa-comment-dots');
      if (comentario) {
        if (oldIcon) {
          oldIcon.title = comentario;
        } else {
          const icon = document.createElement('i');
          icon.className = 'fas fa-comment-dots';
          icon.style.cssText = 'color:#a855f7;font-size:11px;margin-left:5px;vertical-align:middle;';
          icon.title = comentario;
          nameDiv.appendChild(icon);
        }
      } else if (oldIcon) {
        oldIcon.remove();
      }

      /* Guardar en base de datos */
      btn.disabled = true;
      btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando…';
      try {
        const res  = await fetch('/horarios/guardar', {
          method:  'POST',
          headers: { 'Content-Type': 'application/json' },
          body:    JSON.stringify(payload),
        });
        const json = await res.json();
        if (json.status !== 'success') alert('Error al guardar el horario.');
      } catch (e) {
        alert('Error de conexión.');
      } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-save"></i> Guardar horario';
      }

      modal.hide();
    });

    /* ── Búsqueda en tiempo real ── */
    const searchInput = document.getElementById('horario-search');
    if (searchInput) {
      const rows = document.querySelectorAll('.horario-row');
      searchInput.addEventListener('input', function () {
        const q = this.value.toLowerCase();
        rows.forEach(r => {
          r.style.display = r.dataset.nombre.toLowerCase().includes(q) ? '' : 'none';
        });
      });
    }
  })();
  }); // DOMContentLoaded
  </script>
</body>

</html>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administracion - Desechos</title>
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
                <h1 class="">Desechos Organicos</h1>
              </div>
              <button class="btn-u btn-u-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="fas fa-user-plus"></i> Agregar Producto
              </button>
            </div>

            <!-- ══════════ STATS STRIP ══════════ -->
            <div class="usr-stats anim-2">
              <div class="stat-card">
                <div class="stat-icon purple"><i class="fas fa-boxes"></i></div>
                <div class="stat-info">
                  <div class="stat-num"><?= $statTotal ?></div>
                  <div class="stat-label">Total registros</div>
                </div>
              </div>
              <div class="stat-card">
                <div class="stat-icon green"><i class="fas fa-weight"></i></div>
                <div class="stat-info">
                  <div class="stat-num"><?= $statKg ?></div>
                  <div class="stat-label">KG acumulados</div>
                </div>
              </div>
              <div class="stat-card">
                <div class="stat-icon red"><i class="fas fa-cubes"></i></div>
                <div class="stat-info">
                  <div class="stat-num"><?= $statUnidades ?></div>
                  <div class="stat-label">Unidades totales</div>
                </div>
              </div>
              <div class="stat-card">
                <div class="stat-icon blue"><i class="fas fa-calendar-check"></i></div>
                <div class="stat-info">
                  <div class="stat-num"><?= $statMensual ?></div>
                  <div class="stat-label">Registros este mes</div>
                </div>
              </div>
            </div>

            <!-- ══════════ TABLE CARD ══════════ -->
            <div class="usr-table-card anim-3">
              <div class="row">
                <div class="col-md-6 mt-3">
                  <div class="col-md-12">
                    <div class="card">

                      <!-- ── Zona OCR: drop o canvas ── -->
                      <div id="ocr-drop-zone" style="
                          border: 2px dashed #e9d5ff; border-radius: 10px 10px 0 0;
                          padding: 22px; text-align: center; cursor: pointer;
                          position: relative; background: #fafbff; transition: background .2s;">
                        <input type="file" id="ocr-file-input" accept="image/*"
                          style="position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%">
                        <i class="fas fa-cloud-arrow-up" style="font-size:28px;color:#c084fc;"></i>
                        <p style="font-size:12px;color:#7c6fa0;margin-top:6px">
                          <strong style="color:#6b21b8">Arrastra una imagen</strong> o haz clic<br>
                          <span style="font-size:10px">JPG · PNG · WEBP</span>
                        </p>
                      </div>

                      <!-- Canvas con overlay de selección -->
                      <div id="ocr-crop-container" style="display:none;position:relative;background:#000;">
                        <canvas id="ocr-base-canvas" style="display:block;"></canvas>
                        <canvas id="ocr-sel-canvas" style="position:absolute;top:0;left:0;cursor:crosshair;"></canvas>
                        <div id="ocr-crop-hint" style="
                            position:absolute;bottom:8px;left:50%;transform:translateX(-50%);
                            background:rgba(26,5,51,.75);color:#fff;font-size:11px;
                            padding:4px 12px;border-radius:99px;pointer-events:none;white-space:nowrap;">
                          <i class="fas fa-hand-pointer"></i> Arrastra sobre el display
                        </div>
                      </div>

                      <!-- Preview del recorte -->
                      <div id="ocr-preview-wrap" style="display:none;padding:8px;background:#111;">
                        <div style="font-size:10px;color:#a855f7;margin-bottom:4px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;">
                          <i class="fas fa-crop"></i> Zona a procesar
                        </div>
                        <img id="ocr-preview-img" style="width:100%;max-height:70px;object-fit:contain;" alt="">
                      </div>

                      <!-- Resultado OCR raw -->
                      <div id="ocr-result-wrap" style="display:none;padding:8px 12px;background:#f5f0ff;border-top:1px solid #e9d5ff;">
                        <div style="font-size:10px;color:#6b21b8;font-weight:700;text-transform:uppercase;letter-spacing:.06em;margin-bottom:3px;">
                          <i class="fas fa-file-lines"></i> Texto reconocido
                        </div>
                        <div id="ocr-result-text" style="font-size:12px;color:#4a1282;word-break:break-all;line-height:1.5;"></div>
                      </div>

                      <!-- Barra de progreso -->
                      <div id="ocr-progress" style="display:none;padding:8px 12px;background:#f5f0ff;">
                        <div style="background:#e9d5ff;border-radius:99px;height:6px;overflow:hidden;">
                          <div id="ocr-progress-fill" style="height:100%;background:#8b3fd4;width:0%;transition:width .3s;border-radius:99px;"></div>
                        </div>
                        <div id="ocr-progress-label" style="font-size:10px;color:#7c6fa0;text-align:center;margin-top:3px;">Procesando…</div>
                      </div>

                    <div class="card-body">
                      <h5 class="card-title">Captura Inteligente</h5>
                      <div class="row">
                        <div class="col-md-12" style="position:relative;">
                          <input type="text" id="ocr-nombre-input" class="form-control"
                            placeholder="Código o nombre del producto"
                            autocomplete="off">
                          <div id="ocr-nombre-dropdown" style="
                            display:none; position:absolute; top:100%; left:0; right:0; z-index:999;
                            background:#fff; border:1.5px solid #e9d5ff; border-top:none;
                            border-radius:0 0 10px 10px; box-shadow:0 8px 24px rgba(74,18,130,.12);
                            max-height:220px; overflow-y:auto;"></div>
                        </div>
                      </div>
                      <div class="row mt-3">
                        <div class="col-md-7">
                          <input type="text" id="ocr-peso-input" class="form-control" placeholder="Peso en kg">
                        </div>
                        <div class="col-md-5">
                          <input type="text" id="ocr-unidades-input" class="form-control" placeholder="Cantidad unidades">
                        </div>
                      </div>
                      <div class="mt-3 d-flex gap-2 flex-wrap">
                        <button type="button" id="ocr-btn-guardar" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-danger" id="ocr-btn-camara">
                          <span class="fas fa-camera"></span> Cámara
                        </button>
                        <button type="button" class="btn btn-success" id="ocr-btn-procesar" disabled>
                          <i class="fas fa-magnifying-glass"></i> Leer balanza
                        </button>
                      </div>
                    </div>
                  </div>
                  </div>
                </div>

                <!-- Modal cámara -->
                <div class="modal fade" id="ocr-camera-modal" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header modal-header-inv">
                        <h5 class="modal-title"><i class="fas fa-camera me-2"></i>Capturar desde cámara</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body" style="background:#000;padding:12px;">
                        <video id="ocr-camera-video" autoplay playsinline style="width:100%;border-radius:8px;max-height:300px;object-fit:cover;"></video>
                        <canvas id="ocr-camera-canvas" style="display:none;"></canvas>
                      </div>
                      <div class="modal-footer" style="justify-content:center;">
                        <button id="ocr-btn-capturar" class="btn btn-danger px-4">
                          <i class="fas fa-circle-dot me-2"></i>Capturar
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- aca cierra  -->
                <div class="col-md-6 mt-3">
                  <div class="col-md-12">
                    <div class="card" style="width: 30rem;">
                      <div id="captura_manual" style="
                          border: 2px dashed #e9d5ff; border-radius: 10px 10px 0 0;
                          padding: 22px; text-align: center; cursor: pointer;
                          position: relative; background: #fafbff; transition: background .2s;">
                        <input type="file" id="ocr-file-input" accept="image/*"
                          style="position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%">
                        <i class="fas fa-cloud-arrow-up" style="font-size:28px;color:#c084fc;"></i>
                        <p style="font-size:12px;color:#7c6fa0;margin-top:6px">
                          <strong style="color:#6b21b8">Arrastra una imagen</strong> o haz clic<br>
                          <span style="font-size:10px">JPG · PNG · WEBP</span>
                        </p>
                      </div>
                    <div class="card-body">
                      <h5 class="card-title">Captura Manual</h5>
                      <div class="row">
                        <div class="col-md-12" style="position:relative;">
                          <input type="text" id="man-nombre-input" class="form-control"
                            placeholder="Código o nombre del producto"
                            autocomplete="off">
                          <div id="man-nombre-dropdown" style="
                            display:none; position:absolute; top:100%; left:0; right:0; z-index:999;
                            background:#fff; border:1.5px solid #e9d5ff; border-top:none;
                            border-radius:0 0 10px 10px; box-shadow:0 8px 24px rgba(74,18,130,.12);
                            max-height:220px; overflow-y:auto;"></div>
                        </div>
                      </div>
                      <div class="row mt-3">
                        <div class="col-md-7">
                          <input
                            type="text"
                            id="man-peso-input"
                            class="form-control"
                            placeholder="Peso en kg"
                          >
                        </div>
                        <div class="col-md-5">
                          <input
                            type="text"
                            id="man-unidades-input"
                            class="form-control"
                            placeholder="Cantidad unidades"
                          >
                        </div>
                      </div>
                      <button type="button" id="man-btn-guardar" class="btn btn-primary mt-3">Guardar</button>
                    </div>
                  </div>
                  </div>
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
          <h1 class="modal-title"><i class="fas fa-user-plus me-2"></i>Productos organicos</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <!-- SECCIÓN: Datos personales -->
          <div class="form-section">
            <div class="form-section-title">
              <i class="fas fa-id-card"></i> Productos a desechar
            </div>
            <div class="row g-3">
              <div class="col-md-4">
                <div class="fl">
                  <label>Codigo *</label>
                  <input type="number" id="codigo_producto" class="fc" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="fl">
                  <label>Nombre del producto *</label>
                  <input type="text" id="nombre_producto" class="fc" required>
                </div>
              </div>
              <div class="col-md-2">
                <div class="fl">
                  <label>Unidades *</label>
                  <label>Estado *</label>
                  <select class="fc fsel" id="estado_usuario" required>
                    <option value="">Seleccione la unidad</option>
                    <option value="Peso">Peso</option>
                    <option value="Unidades">Unidades</option>
                  </select>
                </div>
              </div>
              
              <div class="col-md-2">
                <div class="fl">
                  <label>Estado *</label>
                  <select class="fc fsel" id="estado_usuario" required>
                    <option value="">Seleccione estado</option>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                  </select>
                </div>
              </div>
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

  <?php require_once("componentes/scripts.php") ?>
  <script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
  <script src="<?= base_url('js/balanza.js') ?>"></script>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const tbody = document.querySelector('#table_usuarios tbody');
      if (!tbody) return;

      const rows = Array.from(tbody.querySelectorAll('tr'));
      const total = rows.length;
      let active = 0, inactive = 0, admins = 0;

      rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        // Estado = last td (index 7), Rol = index 6
        const estadoTxt = row.querySelector('.badge-u') ? row.querySelectorAll('.badge-u') : [];
        const tds = row.querySelectorAll('td');
        if (tds.length >= 8) {
          const estadoCell = tds[7].textContent.trim();
          const rolCell = tds[6].textContent.trim();
          if (estadoCell.toLowerCase().includes('activo')) active++;
          else inactive++;
          if (rolCell.toLowerCase().includes('admin')) admins++;
        }
      });

      document.getElementById('statTotal').textContent = total;
      document.getElementById('statActive').textContent = active;
      document.getElementById('statInactive').textContent = inactive;
      document.getElementById('statAdmin').textContent = admins;
      document.getElementById('countPill').textContent = total;

      /* Live search */
      const searchInput = document.getElementById('searchInput');
      if (searchInput) {
        searchInput.addEventListener('input', function () {
          const q = this.value.toLowerCase();
          rows.forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
          });
        });
      }

      /* Select all checkboxes */
      ['selectAll', 'selectAllUpdate'].forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('change', function () {
          const cls = this.id === 'selectAll' ? 'fila2' : 'fila';
          document.querySelectorAll('.' + cls).forEach(c => c.checked = this.checked);
        });
      });
    });
  </script>
</body>

</html>
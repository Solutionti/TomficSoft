<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion - Reportes</title>
    <link rel="stylesheet" href="<?= base_url('css/estilo.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/material.css') ?>">
    <link rel="stylesheet" href="<?= base_url('fontawesome/css/fontawesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('fontawesome/css/brands.css') ?>">
    <link rel="stylesheet" href="<?= base_url('fontawesome/css/solid.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ══════════════════════════════════════
           DESIGN SYSTEM
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
            --green:      #10b981;
            --green-light:#d1fae5;
            --green-dark: #065f46;
            --red:        #ef4444;
            --red-light:  #fee2e2;
            --red-dark:   #991b1b;
            --amber:      #f59e0b;
            --blue:       #3b82f6;
            --surface:    #ffffff;
            --surface-alt:#fafbff;
            --border:     #e8e0f5;
            --text:       #1a0533;
            --muted:      #7c6fa0;
            --shadow-sm:  0 1px 3px rgba(74,18,130,.08);
            --shadow-md:  0 4px 16px rgba(74,18,130,.12);
            --shadow-lg:  0 12px 40px rgba(74,18,130,.18);
            --radius:     14px;
            --radius-sm:  8px;
            --ease:       cubic-bezier(.4,0,.2,1);
        }

        * { box-sizing:border-box; margin:0; padding:0; }
        body { font-family:'DM Sans',sans-serif; background:var(--surface-alt); color:var(--text); }
        h1,h2,h3,h4,h5,h6 { font-family:'Syne',sans-serif; }
        ::-webkit-scrollbar { width:6px; height:6px; }
        ::-webkit-scrollbar-track { background:#f5f0ff; }
        ::-webkit-scrollbar-thumb { background:var(--purple-400); border-radius:99px; }

        /* ══════════════════════════════════════
           WRAPPER & TOP BAR
        ══════════════════════════════════════ */
        .rpt-wrapper { padding:26px 30px; }

        .rpt-topbar {
            display:flex; align-items:center; justify-content:space-between;
            flex-wrap:wrap; gap:14px; margin-bottom:28px;
        }

        .rpt-breadcrumb {
            font-size:11px; font-weight:600; letter-spacing:.08em;
            text-transform:uppercase; color:var(--purple-400); margin-bottom:3px;
        }

        .rpt-title { font-size:25px; font-weight:800; color:var(--purple-800); }

        /* ══════════════════════════════════════
           BUTTONS
        ══════════════════════════════════════ */
        .btn-r {
            display:inline-flex; align-items:center; gap:7px;
            padding:9px 20px; border-radius:50px;
            font-family:'DM Sans',sans-serif; font-size:13px; font-weight:600;
            cursor:pointer; border:none; transition:all .25s var(--ease);
            white-space:nowrap; text-decoration:none;
        }
        .btn-r-primary { background:linear-gradient(135deg,var(--purple-600),var(--purple-500)); color:#fff; box-shadow:0 4px 14px rgba(107,33,184,.35); }
        .btn-r-primary:hover { background:linear-gradient(135deg,var(--purple-700),var(--purple-600)); transform:translateY(-1px); box-shadow:0 6px 20px rgba(107,33,184,.45); color:#fff; }
        .btn-r-danger-outline { background:transparent; border:1.5px solid var(--red); color:var(--red); }
        .btn-r-danger-outline:hover { background:var(--red); color:#fff; transform:translateY(-1px); }
        .btn-r-outline { background:#fff; border:1.5px solid var(--border); color:var(--purple-700); }
        .btn-r-outline:hover { border-color:var(--purple-400); background:var(--purple-100); transform:translateY(-1px); }

        /* ══════════════════════════════════════
           MODULE CARDS
        ══════════════════════════════════════ */
        .module-card {
            background:var(--surface);
            border:1px solid var(--border);
            border-radius:var(--radius);
            box-shadow:var(--shadow-sm);
            overflow:hidden;
            margin-bottom:20px;
            transition:all .3s var(--ease);
            animation:slideUp .4s ease both;
        }

        .module-card:hover { box-shadow:var(--shadow-md); }
        .module-card:nth-child(1) { animation-delay:.06s; }
        .module-card:nth-child(2) { animation-delay:.14s; }

        .module-card-header {
            padding:18px 24px;
            background:linear-gradient(135deg,var(--purple-800),var(--purple-700));
            display:flex; align-items:center; justify-content:space-between;
            flex-wrap:wrap; gap:12px;
        }

        .module-card-header-left { display:flex; align-items:center; gap:14px; }

        .module-icon-wrap {
            width:48px; height:48px; border-radius:12px;
            background:rgba(255,255,255,.15);
            display:flex; align-items:center; justify-content:center;
            font-size:20px; color:#fff; flex-shrink:0;
            backdrop-filter:blur(4px);
        }

        .module-label {
            font-size:10.5px; font-weight:600; letter-spacing:.08em;
            text-transform:uppercase; color:rgba(255,255,255,.65); margin-bottom:2px;
        }

        .module-name {
            font-family:'Syne',sans-serif; font-size:20px;
            font-weight:800; color:#fff; line-height:1.1;
        }

        .module-desc {
            font-size:12px; color:rgba(255,255,255,.6); margin-top:2px;
        }

        /* ══════════════════════════════════════
           REPORT GRID (inside card)
        ══════════════════════════════════════ */
        .rpt-grid {
            display:grid;
            grid-template-columns:repeat(auto-fill, minmax(220px, 1fr));
            gap:14px;
            padding:20px 22px;
        }

        /* ══════════════════════════════════════
           REPORT ITEM
        ══════════════════════════════════════ */
        .rpt-item {
            background:var(--surface-alt);
            border:1.5px solid var(--border);
            border-radius:var(--radius);
            padding:16px 18px;
            display:flex; flex-direction:column; gap:12px;
            transition:all .25s var(--ease);
            animation:fadeIn .4s ease both;
            position:relative;
            overflow:hidden;
        }

        .rpt-item::before {
            content:'';
            position:absolute; top:0; left:0; right:0;
            height:3px;
            background:linear-gradient(90deg,var(--purple-500),var(--purple-300));
            transform:scaleX(0); transform-origin:left;
            transition:transform .3s var(--ease);
        }

        .rpt-item:hover {
            border-color:var(--purple-300);
            box-shadow:var(--shadow-md);
            transform:translateY(-3px);
            background:var(--surface);
        }

        .rpt-item:hover::before { transform:scaleX(1); }

        .rpt-item-top {
            display:flex; align-items:center; justify-content:space-between;
        }

        .rpt-code-badge {
            font-family:'Syne',sans-serif;
            font-size:22px; font-weight:800;
            color:var(--purple-700);
            line-height:1;
            letter-spacing:-.02em;
        }

        .rpt-type-tag {
            font-size:10px; font-weight:700;
            letter-spacing:.06em; text-transform:uppercase;
            padding:3px 9px; border-radius:50px;
        }

        .tag-pdf  { background:var(--red-light); color:var(--red-dark); }
        .tag-excel{ background:var(--green-light); color:var(--green-dark); }
        .tag-both { background:var(--purple-100); color:var(--purple-700); }

        .rpt-item-name {
            font-size:13px; font-weight:600;
            color:var(--text); line-height:1.4;
        }

        .rpt-actions { display:flex; gap:7px; }

        /* Download buttons */
        .btn-dl {
            display:inline-flex; align-items:center; gap:5px;
            padding:6px 13px; border-radius:50px;
            font-family:'DM Sans',sans-serif;
            font-size:12px; font-weight:600;
            cursor:pointer; border:none;
            transition:all .22s var(--ease);
            white-space:nowrap;
        }

        .btn-dl-pdf {
            background:var(--red-light);
            color:var(--red-dark);
            border:1.5px solid #fca5a5;
        }
        .btn-dl-pdf:hover { background:var(--red); color:#fff; border-color:var(--red); transform:scale(1.05); box-shadow:0 4px 12px rgba(239,68,68,.3); }

        .btn-dl-excel {
            background:var(--green-light);
            color:var(--green-dark);
            border:1.5px solid #6ee7b7;
        }
        .btn-dl-excel:hover { background:var(--green); color:#fff; border-color:var(--green); transform:scale(1.05); box-shadow:0 4px 12px rgba(16,185,129,.3); }

        /* ══════════════════════════════════════
           MODAL
        ══════════════════════════════════════ */
        .modal-content {
            border:none; border-radius:var(--radius) !important;
            overflow:hidden; box-shadow:var(--shadow-lg);
            font-family:'DM Sans',sans-serif;
        }

        .modal-header-inv {
            background:linear-gradient(135deg,var(--purple-800),var(--purple-600)) !important;
            padding:16px 22px; border-bottom:none;
        }

        .modal-header-inv .modal-title {
            font-family:'Syne',sans-serif; font-size:14.5px;
            font-weight:700; color:#fff; letter-spacing:.04em;
        }

        .modal-header-inv .btn-close { filter:invert(1); opacity:.85; }
        .modal-body { background:var(--surface-alt); padding:22px; }
        .modal-footer { background:var(--surface); border-top:1px solid var(--border); padding:12px 22px; }

        .fl { display:flex; flex-direction:column; gap:4px; }
        .fl label { font-size:10.5px; font-weight:600; text-transform:uppercase; letter-spacing:.06em; color:var(--muted); }

        .fc, .fsel {
            width:100%; padding:9px 13px;
            border:1.5px solid var(--border); border-radius:var(--radius-sm);
            font-family:'DM Sans',sans-serif; font-size:13px; color:var(--text);
            background:var(--surface); transition:all .25s var(--ease);
            outline:none; appearance:none;
        }
        .fc:focus, .fsel:focus { border-color:var(--purple-400); box-shadow:0 0 0 3px rgba(168,85,247,.15); }

        /* Filter section divider */
        .filter-section-title {
            font-size:11px; font-weight:700; text-transform:uppercase;
            letter-spacing:.08em; color:var(--purple-600);
            display:flex; align-items:center; gap:7px;
            margin-bottom:12px;
        }

        .filter-section-title::after {
            content:''; flex:1; height:1px; background:var(--border);
        }

        /* ══════════════════════════════════════
           ANIMATIONS
        ══════════════════════════════════════ */
        @keyframes slideUp {
            from { opacity:0; transform:translateY(18px); }
            to   { opacity:1; transform:translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity:0; transform:scale(.97); }
            to   { opacity:1; transform:scale(1); }
        }

        .anim-1 { animation:slideUp .35s ease .04s both; }
        .anim-2 { animation:slideUp .35s ease .10s both; }

        /* Stagger rpt-item entries */
        .rpt-item:nth-child(1) { animation-delay:.08s; }
        .rpt-item:nth-child(2) { animation-delay:.14s; }
        .rpt-item:nth-child(3) { animation-delay:.20s; }
        .rpt-item:nth-child(4) { animation-delay:.26s; }
        .rpt-item:nth-child(5) { animation-delay:.32s; }
        .rpt-item:nth-child(6) { animation-delay:.38s; }

        .color-morado { background:linear-gradient(135deg,var(--purple-800),var(--purple-700)) !important; }

        @media (max-width:768px) {
            .rpt-wrapper { padding:14px; }
            .rpt-title { font-size:20px; }
            .rpt-grid { grid-template-columns:1fr 1fr; gap:10px; }
        }

        @media (max-width:480px) {
            .rpt-grid { grid-template-columns:1fr; }
        }
    </style>
</head>
<body>
<div class="container-scroller">
    <?php require_once("componentes/navbar.php")?>
    <div class="container-fluid page-body-wrapper">
        <?php require_once("componentes/lateralderecha.php")?>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="rpt-wrapper">

                    <!-- ══════════ TOP BAR ══════════ -->
                    <div class="rpt-topbar anim-1">
                        <div>
                            <p class="rpt-breadcrumb">Administración &rsaquo; InventSoft</p>
                            <h1 class="">Centro de Reportes</h1>
                        </div>
                        <button class="btn-r btn-r-primary" data-bs-toggle="modal" data-bs-target="#diferenciaconteo">
                            <i class="fas fa-sliders-h"></i> Filtros de reporte
                        </button>
                    </div>

                    <!-- ══════════ MÓDULO: INVENTARIOS ══════════ -->
                    <div class="module-card anim-2">
                        <div class="module-card-header">
                            <div class="module-card-header-left">
                                <div class="module-icon-wrap"><i class="fas fa-boxes"></i></div>
                                <div>
                                    <div class="module-label">Módulo de reportes</div>
                                    <div class="module-name">Inventarios</div>
                                    <div class="module-desc">Análisis y diferencias de conteos físicos</div>
                                </div>
                            </div>
                        </div>

                        <div class="rpt-grid">

                            <!-- SC: Sin conteo -->
                            <div class="rpt-item">
                                <div class="rpt-item-top">
                                    <span class="rpt-code-badge">SC</span>
                                    <span class="rpt-type-tag tag-both">PDF · Excel</span>
                                </div>
                                <div class="rpt-item-name">Sin Conteo<br><span style="font-size:11px;color:var(--muted);font-weight:400;">Productos sin registro de conteo</span></div>
                                <div class="rpt-actions">
                                    <button class="btn-dl btn-dl-pdf" id="sinconteopdf" title="Descargar PDF">
                                        <i class="fas fa-file-pdf"></i> PDF
                                    </button>
                                    <button class="btn-dl btn-dl-excel" id="sinconteoexcel" title="Descargar Excel">
                                        <i class="fas fa-file-excel"></i> Excel
                                    </button>
                                </div>
                            </div>

                            <!-- DC: Diferencia conteos -->
                            <div class="rpt-item">
                                <div class="rpt-item-top">
                                    <span class="rpt-code-badge">DC</span>
                                    <span class="rpt-type-tag tag-excel">Excel</span>
                                </div>
                                <div class="rpt-item-name">Diferencia de Conteos<br><span style="font-size:11px;color:var(--muted);font-weight:400;">Conteo 1 vs Conteo 2</span></div>
                                <div class="rpt-actions">
                                    <button class="btn-dl btn-dl-excel" id="descargardiferencia" title="Descargar Excel">
                                        <i class="fas fa-file-excel"></i> Excel
                                    </button>
                                </div>
                            </div>

                            <!-- DI: Diferencia inventarios -->
                            <div class="rpt-item">
                                <div class="rpt-item-top">
                                    <span class="rpt-code-badge">DI</span>
                                    <span class="rpt-type-tag tag-excel">Excel</span>
                                </div>
                                <div class="rpt-item-name">Diferencia de Inventarios<br><span style="font-size:11px;color:var(--muted);font-weight:400;">Saldo del sistema vs físico</span></div>
                                <div class="rpt-actions">
                                    <button class="btn-dl btn-dl-excel" title="Descargar Excel">
                                        <i class="fas fa-file-excel"></i> Excel
                                    </button>
                                </div>
                            </div>

                            <!-- GT: Ganancia total -->
                            <div class="rpt-item">
                                <div class="rpt-item-top">
                                    <span class="rpt-code-badge">GT</span>
                                    <span class="rpt-type-tag tag-pdf">PDF</span>
                                </div>
                                <div class="rpt-item-name">Ganancia Total<br><span style="font-size:11px;color:var(--muted);font-weight:400;">Resultado económico del inventario</span></div>
                                <div class="rpt-actions">
                                    <button class="btn-dl btn-dl-pdf" title="Descargar PDF">
                                        <i class="fas fa-file-pdf"></i> PDF
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- ══════════ MÓDULO: VENTAS ══════════ -->
                    <div class="module-card">
                        <div class="module-card-header" style="background:linear-gradient(135deg,#065f46,#059669);">
                            <div class="module-card-header-left">
                                <div class="module-icon-wrap" style="background:rgba(255,255,255,.15);">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div>
                                    <div class="module-label">Módulo de reportes</div>
                                    <div class="module-name">Ventas</div>
                                    <div class="module-desc">Visualiza las ventas día a día de tu negocio</div>
                                </div>
                            </div>
                        </div>

                        <div class="rpt-grid">

                            <!-- VP: Venta de pedidos -->
                            <div class="rpt-item">
                                <div class="rpt-item-top">
                                    <span class="rpt-code-badge">VP</span>
                                    <span class="rpt-type-tag tag-pdf">PDF</span>
                                </div>
                                <div class="rpt-item-name">Venta de Pedidos<br><span style="font-size:11px;color:var(--muted);font-weight:400;">Detalle de pedidos emitidos</span></div>
                                <div class="rpt-actions">
                                    <button class="btn-dl btn-dl-pdf" title="Descargar PDF">
                                        <i class="fas fa-file-pdf"></i> PDF
                                    </button>
                                </div>
                            </div>

                            <!-- VD: Venta diaria -->
                            <div class="rpt-item">
                                <div class="rpt-item-top">
                                    <span class="rpt-code-badge">VD</span>
                                    <span class="rpt-type-tag tag-both">PDF · Excel</span>
                                </div>
                                <div class="rpt-item-name">Venta Diaria<br><span style="font-size:11px;color:var(--muted);font-weight:400;">Resumen de ventas por día</span></div>
                                <div class="rpt-actions">
                                    <button class="btn-dl btn-dl-pdf" title="Descargar PDF">
                                        <i class="fas fa-file-pdf"></i> PDF
                                    </button>
                                    <button class="btn-dl btn-dl-excel" title="Descargar Excel">
                                        <i class="fas fa-file-excel"></i> Excel
                                    </button>
                                </div>
                            </div>

                            <!-- RK: Reporte Kardex -->
                            <div class="rpt-item">
                                <div class="rpt-item-top">
                                    <span class="rpt-code-badge">RK</span>
                                    <span class="rpt-type-tag tag-both">PDF · Excel</span>
                                </div>
                                <div class="rpt-item-name">Reporte de Kardex<br><span style="font-size:11px;color:var(--muted);font-weight:400;">Movimientos de inventario</span></div>
                                <div class="rpt-actions">
                                    <button class="btn-dl btn-dl-pdf" title="Descargar PDF">
                                        <i class="fas fa-file-pdf"></i> PDF
                                    </button>
                                    <button class="btn-dl btn-dl-excel" title="Descargar Excel">
                                        <i class="fas fa-file-excel"></i> Excel
                                    </button>
                                </div>
                            </div>

                            <!-- RC: Reporte ABC -->
                            <div class="rpt-item">
                                <div class="rpt-item-top">
                                    <span class="rpt-code-badge">RC</span>
                                    <span class="rpt-type-tag tag-pdf">PDF</span>
                                </div>
                                <div class="rpt-item-name">Reporte ABC<br><span style="font-size:11px;color:var(--muted);font-weight:400;">Clasificación de productos por rotación</span></div>
                                <div class="rpt-actions">
                                    <button class="btn-dl btn-dl-pdf" title="Descargar PDF">
                                        <i class="fas fa-file-pdf"></i> PDF
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>

                </div><!-- /rpt-wrapper -->
            </div>
        </div>
    </div>
</div>
<!-- ══════════════════════════════════════
     MODAL: FILTROS
══════════════════════════════════════ -->
<div class="modal fade" id="diferenciaconteo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header modal-header-inv">
        <h1 class="modal-title"><i class="fas fa-sliders-h me-2"></i>Filtros para Reportes</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="filter-section-title"><i class="fas fa-user"></i> Filtrar por usuario</div>
        <div class="fl" style="margin-bottom:20px;">
          <label>Usuario</label>
          <select class="fsel">
            <option value="">Todos los usuarios</option>
            <option value="1">Usuario 1</option>
            <option value="2">Usuario 2</option>
          </select>
        </div>

        <div class="filter-section-title"><i class="fas fa-calendar-alt"></i> Rango de fechas</div>
        <div class="row g-3">
          <div class="col-6">
            <div class="fl">
              <label>Fecha inicial</label>
              <input type="date" class="fc" id="fechaInicio" name="fechaInicio">
            </div>
          </div>
          <div class="col-6">
            <div class="fl">
              <label>Fecha final</label>
              <input type="date" class="fc" id="fechaFin" name="fechaFin" value="<?= date('Y-m-d'); ?>">
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn-r btn-r-danger-outline" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Cerrar
        </button>
        <button type="button" class="btn-r btn-r-primary" data-bs-dismiss="modal">
            <i class="fas fa-check"></i> Aplicar filtros
        </button>
      </div>
    </div>
  </div>
</div>

<?php require_once("componentes/scripts.php")?>
<script src="<?= base_url('js/reportes.js') ?>"></script>
</body>
</html>
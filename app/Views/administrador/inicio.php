<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion - Inicio</title>
    <link rel="stylesheet" href="<?= base_url('css/estilo.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/material.css') ?>">
    <link rel="stylesheet" href="<?= base_url('fontawesome/css/fontawesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('fontawesome/css/brands.css') ?>">
    <link rel="stylesheet" href="<?= base_url('fontawesome/css/solid.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            --amber-light:#fef3c7;
            --blue:       #3b82f6;
            --blue-light: #dbeafe;
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
           WRAPPER
        ══════════════════════════════════════ */
        .dash-wrapper { padding:24px 28px; }

        /* ══════════════════════════════════════
           TOPBAR
        ══════════════════════════════════════ */
        .dash-topbar {
            display:flex; align-items:center; justify-content:space-between;
            flex-wrap:wrap; gap:12px; margin-bottom:26px;
        }

        .dash-breadcrumb {
            font-size:11px; font-weight:600; letter-spacing:.08em;
            text-transform:uppercase; color:var(--purple-400); margin-bottom:3px;
        }

        .dash-title { font-size:25px; font-weight:800; color:var(--purple-800); }

        .dash-datebadge {
            display:flex; align-items:center; gap:8px;
            background:var(--surface); border:1px solid var(--border);
            border-radius:50px; padding:7px 16px;
            font-size:12px; font-weight:600; color:var(--muted);
            box-shadow:var(--shadow-sm);
        }
        .dash-datebadge i { color:var(--purple-400); }

        /* ══════════════════════════════════════
           KPI STRIP
        ══════════════════════════════════════ */
        .kpi-strip {
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(160px,1fr));
            gap:14px; margin-bottom:22px;
        }

        .kpi-card {
            background:var(--surface); border:1px solid var(--border);
            border-radius:var(--radius); padding:16px 18px;
            display:flex; align-items:center; gap:14px;
            box-shadow:var(--shadow-sm); transition:all .3s var(--ease);
            animation:slideUp .4s ease both; position:relative; overflow:hidden;
        }

        .kpi-card::after {
            content:''; position:absolute; bottom:0; left:0; right:0;
            height:3px; background:var(--stripe-color,var(--purple-400));
            transform:scaleX(0); transform-origin:left;
            transition:transform .35s var(--ease);
        }
        .kpi-card:hover { border-color:var(--purple-300); box-shadow:var(--shadow-md); transform:translateY(-3px); }
        .kpi-card:hover::after { transform:scaleX(1); }

        .kpi-card:nth-child(1){ animation-delay:.04s; --stripe-color:var(--purple-400); }
        .kpi-card:nth-child(2){ animation-delay:.09s; --stripe-color:var(--green); }
        .kpi-card:nth-child(3){ animation-delay:.14s; --stripe-color:var(--amber); }
        .kpi-card:nth-child(4){ animation-delay:.19s; --stripe-color:var(--blue); }
        .kpi-card:nth-child(5){ animation-delay:.24s; --stripe-color:var(--red); }
        .kpi-card:nth-child(6){ animation-delay:.29s; --stripe-color:var(--purple-300); }

        .kpi-icon {
            width:44px; height:44px; border-radius:11px;
            display:flex; align-items:center; justify-content:center;
            font-size:18px; flex-shrink:0;
        }
        .ki-purple { background:var(--purple-100); color:var(--purple-600); }
        .ki-green  { background:var(--green-light); color:var(--green-dark); }
        .ki-amber  { background:var(--amber-light); color:#92400e; }
        .ki-blue   { background:var(--blue-light);  color:#1e40af; }
        .ki-red    { background:var(--red-light);   color:var(--red-dark); }
        .ki-slate  { background:#f1f5f9; color:#475569; }

        . {
            font-family:'Syne',sans-serif; font-size:21px;
            font-weight:800; color:var(--purple-800); line-height:1;
        }
        .kpi-lbl {
            font-size:10.5px; font-weight:600; text-transform:uppercase;
            letter-spacing:.06em; color:var(--muted); margin-top:3px;
        }

        /* ══════════════════════════════════════
           MAIN GRID (chart + premium + side)
        ══════════════════════════════════════ */
        .dash-main-grid {
            display:grid;
            grid-template-columns:1fr 300px;
            gap:18px;
            margin-bottom:18px;
        }

        @media (max-width:1100px) { .dash-main-grid { grid-template-columns:1fr; } }

        /* ══════════════════════════════════════
           PANEL CARD
        ══════════════════════════════════════ */
        .panel-card {
            background:var(--surface); border:1px solid var(--border);
            border-radius:var(--radius); box-shadow:var(--shadow-sm);
            overflow:hidden; transition:all .3s var(--ease);
            animation:slideUp .4s ease both;
        }
        .panel-card:hover { box-shadow:var(--shadow-md); }

        .panel-header {
            padding:14px 20px; border-bottom:1px solid var(--border);
            background:linear-gradient(90deg,var(--purple-100),#fdf8ff);
            display:flex; align-items:center; justify-content:space-between;
            flex-wrap:wrap; gap:8px;
        }
        .panel-header h5 {
            font-size:13px; font-weight:700; color:var(--purple-800);
            display:flex; align-items:center; gap:8px; margin:0;
        }
        .panel-body { padding:18px 20px; }

        /* Chart wrapper */
        .chart-wrap { position:relative; height:230px; }

        /* Sales header metrics */
        .sales-metrics {
            display:grid; grid-template-columns:1fr 1fr;
            gap:12px; margin-bottom:18px;
        }

        .metric-chip {
            display:flex; align-items:center; gap:11px;
            background:var(--surface-alt); border:1px solid var(--border);
            border-radius:var(--radius-sm); padding:12px 14px;
            transition:all .25s var(--ease);
        }
        .metric-chip:hover { border-color:var(--purple-300); box-shadow:var(--shadow-sm); }

        .metric-chip-icon {
            width:36px; height:36px; border-radius:9px;
            display:flex; align-items:center; justify-content:center;
            font-size:15px; flex-shrink:0;
        }

        . {
            font-family:'Syne',sans-serif; font-size:16px;
            font-weight:800; color:var(--purple-800); line-height:1;
        }
        .metric-chip-lbl {
            font-size:9.5px; font-weight:700; text-transform:uppercase;
            letter-spacing:.06em; color:var(--muted); margin-top:2px;
        }

        /* ══════════════════════════════════════
           PREMIUM CARD
        ══════════════════════════════════════ */
        .premium-card {
            background:linear-gradient(145deg,var(--purple-800),var(--purple-600),#9333ea);
            border-radius:var(--radius); padding:28px 22px;
            display:flex; flex-direction:column; justify-content:space-between;
            box-shadow:0 8px 30px rgba(107,33,184,.4);
            animation:slideUp .4s ease .12s both;
            position:relative; overflow:hidden; height:100%;
        }

        .premium-card::before {
            content:'';
            position:absolute; top:-60px; right:-60px;
            width:200px; height:200px;
            background:rgba(255,255,255,.07);
            border-radius:50%;
        }

        .premium-card::after {
            content:'';
            position:absolute; bottom:-40px; left:-40px;
            width:150px; height:150px;
            background:rgba(255,255,255,.05);
            border-radius:50%;
        }

        .premium-stars {
            display:flex; gap:3px; margin-bottom:16px;
        }
        .premium-stars i { color:var(--amber); font-size:13px; }

        .premium-title {
            font-family:'Syne',sans-serif; font-size:22px;
            font-weight:800; color:#fff; line-height:1.2; margin-bottom:10px;
        }

        .premium-title span { color:#e9d5ff; }

        .premium-desc { font-size:12.5px; color:rgba(255,255,255,.7); margin-bottom:24px; line-height:1.6; }

        .premium-perks { display:flex; flex-direction:column; gap:8px; margin-bottom:24px; }

        .premium-perk {
            display:flex; align-items:center; gap:8px;
            font-size:12px; color:rgba(255,255,255,.85); font-weight:500;
        }
        .premium-perk i { color:#c084fc; font-size:11px; }

        .btn-premium {
            display:inline-flex; align-items:center; gap:8px;
            padding:11px 20px; border-radius:50px;
            background:#fff; color:var(--purple-700);
            font-family:'DM Sans',sans-serif; font-size:13px; font-weight:700;
            border:none; cursor:pointer;
            transition:all .25s var(--ease);
            box-shadow:0 4px 14px rgba(0,0,0,.15);
            position:relative; z-index:1;
            text-decoration:none;
        }
        .btn-premium:hover { transform:translateY(-2px); box-shadow:0 8px 20px rgba(0,0,0,.2); color:var(--purple-800); }

        /* ══════════════════════════════════════
           BOTTOM GRID
        ══════════════════════════════════════ */
        .dash-bottom-grid {
            display:grid;
            grid-template-columns:1fr 1fr 1fr;
            gap:18px;
        }

        @media (max-width:900px) { .dash-bottom-grid { grid-template-columns:1fr 1fr; } }
        @media (max-width:600px) { .dash-bottom-grid { grid-template-columns:1fr; } }

        /* ══════════════════════════════════════
           UPCOMING INVENTORIES
        ══════════════════════════════════════ */
        .event-item {
            display:flex; align-items:flex-start; gap:12px;
            padding:12px 0; border-bottom:1px solid var(--border);
        }
        .event-item:last-child { border-bottom:none; padding-bottom:0; }

        .event-dot {
            width:10px; height:10px; border-radius:50%;
            background:var(--purple-400); flex-shrink:0; margin-top:5px;
        }

        .event-dot.green { background:var(--green); }

        .event-date { font-size:10.5px; color:var(--muted); font-weight:600; }
        .event-name { font-size:13px; font-weight:700; color:var(--text); margin-top:2px; }
        .event-company { font-size:11.5px; color:var(--muted); margin-top:1px; }

        .event-badge {
            display:inline-flex; align-items:center; gap:4px;
            padding:3px 9px; border-radius:50px; font-size:10px; font-weight:700;
            background:var(--purple-100); color:var(--purple-700); margin-left:auto; flex-shrink:0;
        }

        /* ══════════════════════════════════════
           PRODUCT STATES
        ══════════════════════════════════════ */
        .state-row {
            display:flex; align-items:center; justify-content:space-between;
            padding:12px 0; border-bottom:1px solid var(--border);
        }
        .state-row:last-child { border-bottom:none; }

        .state-left { display:flex; align-items:center; gap:12px; }

        .state-hexagon {
            width:40px; height:40px; border-radius:10px;
            display:flex; align-items:center; justify-content:center;
            font-size:16px; flex-shrink:0;
        }
        .sh-green  { background:var(--green-light); color:var(--green-dark); }
        .sh-red    { background:var(--red-light);   color:var(--red-dark); }
        .sh-blue   { background:var(--blue-light);  color:#1e40af; }

        .state-label { font-size:13px; font-weight:600; color:var(--text); }
        .state-sub   { font-size:11px; color:var(--muted); }

        .state-count {
            font-family:'Syne',sans-serif; font-size:22px;
            font-weight:800;
        }
        .sc-green { color:var(--green-dark); }
        .sc-red   { color:var(--red-dark); }
        .sc-blue  { color:#1e40af; }

        /* ══════════════════════════════════════
           COLOR STAT CARDS (4-grid)
        ══════════════════════════════════════ */
        .color-stats-grid {
            display:grid; grid-template-columns:1fr 1fr;
            gap:10px;
        }

        .color-stat {
            border-radius:var(--radius-sm); padding:14px 14px;
            display:flex; flex-direction:column; gap:6px;
            transition:all .25s var(--ease);
        }
        .color-stat:hover { transform:translateY(-2px); filter:brightness(1.04); }

        .color-stat-icon { font-size:18px; }
        . {
            font-family:'Syne',sans-serif; font-size:20px;
            font-weight:800; line-height:1;
        }
        .color-stat-lbl { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; }

        .cs-purple { background:linear-gradient(135deg,var(--purple-100),#ede0ff); }
        .cs-purple .color-stat-icon,.cs-purple .,.cs-purple .color-stat-lbl { color:var(--purple-700); }

        .cs-green { background:linear-gradient(135deg,var(--green-light),#a7f3d0); }
        .cs-green .color-stat-icon,.cs-green .,.cs-green .color-stat-lbl { color:var(--green-dark); }

        .cs-blue { background:linear-gradient(135deg,var(--blue-light),#bfdbfe); }
        .cs-blue .color-stat-icon,.cs-blue .,.cs-blue .color-stat-lbl { color:#1e40af; }

        .cs-red { background:linear-gradient(135deg,var(--red-light),#fecaca); }
        .cs-red .color-stat-icon,.cs-red .,.cs-red .color-stat-lbl { color:var(--red-dark); }

        /* ══════════════════════════════════════
           ANIMATIONS
        ══════════════════════════════════════ */
        @keyframes slideUp {
            from{opacity:0;transform:translateY(18px);}
            to  {opacity:1;transform:translateY(0);}
        }

        @keyframes countUp {
            from { opacity:0; transform:scale(.85); }
            to   { opacity:1; transform:scale(1); }
        }

        .anim-1{animation:slideUp .35s ease .04s both;}
        .anim-2{animation:slideUp .35s ease .10s both;}
        .anim-3{animation:slideUp .35s ease .18s both;}
        .anim-4{animation:slideUp .35s ease .24s both;}
        .anim-5{animation:slideUp .35s ease .30s both;}

        .color-morado{background:linear-gradient(135deg,var(--purple-800),var(--purple-700)) !important;}

        @media (max-width:768px){
            .dash-wrapper{padding:14px;}
            .dash-title{font-size:20px;}
            .sales-metrics{grid-template-columns:1fr 1fr;}
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
                <div class="dash-wrapper">

                    <!-- ══════════ TOPBAR ══════════ -->
                    <div class="dash-topbar anim-1">
                        <div>
                            <p class="dash-breadcrumb">Administración &rsaquo; InventSoft</p>
                            <h1 class="">Panel de Control</h1>
                        </div>
                        <div class="dash-datebadge">
                            <i class="fas fa-calendar-alt"></i>
                            <span id="liveDateLabel">—</span>
                        </div>
                    </div>

                    <!-- ══════════ KPI STRIP ══════════ -->
                    <div class="kpi-strip">
                        <div class="kpi-card">
                            <div class="kpi-icon ki-purple"><i class="fas fa-dollar-sign"></i></div>
                            <div><div class="">$0</div><div class="kpi-lbl">Ingresos hoy</div></div>
                        </div>
                        <div class="kpi-card">
                            <div class="kpi-icon ki-green"><i class="fas fa-chart-line"></i></div>
                            <div><div class="">$0</div><div class="kpi-lbl">Ventas totales</div></div>
                        </div>
                        
                        <div class="kpi-card">
                            <div class="kpi-icon ki-blue"><i class="fas fa-boxes"></i></div>
                            <div>
                                <div class=""><?php echo $producto->getResult()[0]->total_productos; ?></div>
                                <div class="kpi-lbl">Productos</div>
                            </div>
                        </div>
                        <div class="kpi-card">
                            <div class="kpi-icon ki-red"><i class="fas fa-clipboard-list"></i></div>
                            <div>
                                <div class=""><?php echo $inventario->getResult()[0]->total_inventarios; ?></div>
                                <div class="kpi-lbl">Inventarios</div>
                            </div>
                        </div>
                        <div class="kpi-card">
                            <div class="kpi-icon ki-slate"><i class="fas fa-exclamation-circle"></i></div>
                            <div>
                                <div class=""><?php echo $reportado->getResult()[0]->total_reportados; ?></div>
                                <div class="kpi-lbl">Reportados</div>
                            </div>
                        </div>
                    </div>

                    <!-- ══════════ MAIN GRID ══════════ -->
                    <div class="dash-main-grid">

                        <!-- Chart card -->
                        <div class="panel-card anim-2" style="animation-delay:.12s;">
                            <div class="panel-header">
                                <h5><i class="fas fa-chart-bar"></i>Ingresos por ventas — mensual</h5>
                                <span style="font-size:11px;color:var(--muted);font-weight:600;">Año 2026</span>
                            </div>
                            <div class="panel-body">
                                <!-- Metrics -->
                                <div class="sales-metrics">
                                    <div class="metric-chip">
                                        <div class="metric-chip-icon ki-purple"><i class="fas fa-database"></i></div>
                                        <div>
                                            <div class="">$0</div>
                                            <div class="metric-chip-lbl">Ventas totales</div>
                                        </div>
                                    </div>
                                    <div class="metric-chip">
                                        <div class="metric-chip-icon ki-amber"><i class="fas fa-coins"></i></div>
                                        <div>
                                            <div class="">$0</div>
                                            <div class="metric-chip-lbl">Ganancia total</div>
                                        </div>
                                    </div>
                                    <div class="metric-chip">
                                        <div class="metric-chip-icon ki-blue"><i class="fas fa-shopping-cart"></i></div>
                                        <div>
                                            <div class="">$0</div>
                                            <div class="metric-chip-lbl">Ventas mes</div>
                                        </div>
                                    </div>
                                    <div class="metric-chip">
                                        <div class="metric-chip-icon ki-green"><i class="fas fa-arrow-trend-up"></i></div>
                                        <div>
                                            <div class="">0%</div>
                                            <div class="metric-chip-lbl">Crecimiento</div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Chart -->
                                <div class="chart-wrap">
                                    <canvas id="miGrafico"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Premium card -->
                        <div class="premium-card">
                            <div>
                                <div class="premium-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <div class="premium-title">
                                    Consigue tu cuenta<br>
                                    <span>Premium</span> hoy
                                </div>
                                <div class="premium-desc">
                                    Optimiza la gestión de tu inventario y ventas con herramientas avanzadas.
                                </div>
                                <div class="premium-perks">
                                    <div class="premium-perk"><i class="fas fa-check-circle"></i> Reportes ilimitados</div>
                                    <div class="premium-perk"><i class="fas fa-check-circle"></i> Exportación masiva PDF/Excel</div>
                                    <div class="premium-perk"><i class="fas fa-check-circle"></i> Usuarios sin límite</div>
                                    <div class="premium-perk"><i class="fas fa-check-circle"></i> Soporte prioritario 24/7</div>
                                </div>
                            </div>
                            <a href="#" class="btn-premium">
                                <i class="fas fa-crown"></i> Obtener plan premium
                            </a>
                        </div>

                    </div><!-- /dash-main-grid -->

                    <!-- ══════════ BOTTOM GRID ══════════ -->
                    <div class="dash-bottom-grid">

                        <!-- Próximos inventarios -->
                        <div class="panel-card anim-3" style="animation-delay:.20s;">
                            <div class="panel-header">
                                <h5><i class="fas fa-calendar-check"></i>Próximos Inventarios</h5>
                                <span style="background:var(--purple-100);color:var(--purple-600);font-size:10px;font-weight:700;padding:3px 9px;border-radius:50px;">1 pendiente</span>
                            </div>
                            <div class="panel-body">
                                <div class="event-item">
                                    <div class="event-dot green"></div>
                                    <div style="flex:1;">
                                        <div class="event-date"><i class="fas fa-clock"></i>&nbsp;Sábado, 03 de Enero &mdash; 9:30am</div>
                                        <div class="event-name">Inventario General</div>
                                        <div class="event-company"><i class="fas fa-building" style="font-size:10px;color:var(--purple-400);"></i>&nbsp; Empresa: Mercacentro</div>
                                    </div>
                                    <div class="event-badge"><i class="fas fa-dot-circle"></i>Activo</div>
                                </div>
                                
                            </div>
                        </div>

                        <!-- Estado de productos -->
                        <div class="panel-card anim-4" style="animation-delay:.26s;">
                            <div class="panel-header">
                                <h5><i class="fas fa-clipboard-check"></i>Estado de Productos</h5>
                            </div>
                            <div class="panel-body">
                                <div class="state-row">
                                    <div class="state-left">
                                        <div class="state-hexagon sh-green"><i class="fas fa-check-circle"></i></div>
                                        <div>
                                            <div class="state-label">Buenos</div>
                                            <div class="state-sub">En buen estado</div>
                                        </div>
                                    </div>
                                    <div class=" sc-green"><?php echo $bueno->getResult()[0]->total_estado; ?></div>
                                </div>
                                <div class="state-row">
                                    <div class="state-left">
                                        <div class="state-hexagon sh-red"><i class="fas fa-tools"></i></div>
                                        <div>
                                            <div class="state-label">Averiados</div>
                                            <div class="state-sub">Requieren revisión</div>
                                        </div>
                                    </div>
                                    <div class=" sc-red"><?php echo $averiado->getResult()[0]->total_estado; ?></div>
                                </div>
                                <div class="state-row">
                                    <div class="state-left">
                                        <div class="state-hexagon sh-blue"><i class="fas fa-calendar-times"></i></div>
                                        <div>
                                            <div class="state-label">Vencidos</div>
                                            <div class="state-sub">Fuera de fecha</div>
                                        </div>
                                    </div>
                                    <div class=" sc-blue"><?php echo $vencido->getResult()[0]->total_estado; ?></div>
                                </div>
                            </div>
                        </div>

                        <!-- Resumen general -->
                        <div class="panel-card anim-5" style="animation-delay:.32s;">
                            <div class="panel-header">
                                <h5><i class="fas fa-th-large"></i>Resumen General</h5>
                            </div>
                            <div class="panel-body">
                                <div class="color-stats-grid">
                                    <div class="color-stat cs-purple">
                                        <div class="color-stat-icon"><i class="fas fa-box"></i></div>
                                        <div class=""><?php echo $producto->getResult()[0]->total_productos; ?></div>
                                        <div class="color-stat-lbl">Productos</div>
                                    </div>
                                    <div class="color-stat cs-green">
                                        <div class="color-stat-icon"><i class="fas fa-clipboard-list"></i></div>
                                        <div class=""><?php echo $inventario->getResult()[0]->total_inventarios; ?></div>
                                        <div class="color-stat-lbl">Inventarios</div>
                                    </div>
                                    <div class="color-stat cs-blue">
                                        <div class="color-stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
                                        <div class=""><?php echo $perdida->getResult()[0]->total_estado; ?></div>
                                        <div class="color-stat-lbl">Pérdidas</div>
                                    </div>
                                    <div class="color-stat cs-red">
                                        <div class="color-stat-icon"><i class="fas fa-flag"></i></div>
                                        <div class=""><?php echo $reportado->getResult()[0]->total_reportados; ?></div>
                                        <div class="color-stat-lbl">Reportados</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- /dash-bottom-grid -->

                </div><!-- /dash-wrapper -->
            </div>
        </div>
    </div>
</div>

<script>
/* ══ Live date ══ */
(function(){
    const el = document.getElementById('liveDateLabel');
    if (!el) return;
    const days = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
    const months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    const d = new Date();
    el.textContent = `${days[d.getDay()]}, ${d.getDate()} de ${months[d.getMonth()]} ${d.getFullYear()}`;
})();

/* ══ Chart ══ */
(function(){
    const ctx = document.getElementById('miGrafico');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
            datasets: [
                {
                    label: 'Ventas',
                    data: [12, 19, 3, 5, 10, 2, 13, 3, 8, 15, 7, 11],
                    backgroundColor: 'rgba(107,33,184,.18)',
                    borderColor: '#6b21b8',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                },
                {
                    label: 'Ganancia',
                    data: [6, 10, 2, 3, 5, 1, 7, 2, 4, 8, 4, 6],
                    backgroundColor: 'rgba(16,185,129,.18)',
                    borderColor: '#10b981',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                    type: 'line',
                    tension: .4,
                    fill: true,
                    pointBackgroundColor: '#10b981',
                    pointRadius: 4,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode:'index', intersect:false },
            plugins: {
                legend: {
                    labels: {
                        font: { family:'DM Sans', size:12, weight:'600' },
                        color: '#7c6fa0',
                        boxWidth: 12,
                        borderRadius: 4,
                    }
                },
                tooltip: {
                    backgroundColor: '#2d0a55',
                    titleFont: { family:'Syne', size:13, weight:'700' },
                    bodyFont: { family:'DM Sans', size:12 },
                    cornerRadius: 10,
                    padding: 12,
                }
            },
            scales: {
                x: {
                    grid: { display:false },
                    ticks: { font:{ family:'DM Sans', size:11 }, color:'#7c6fa0' },
                    border: { display:false }
                },
                y: {
                    beginAtZero: true,
                    grid: { color:'rgba(168,85,247,.08)' },
                    ticks: { font:{ family:'DM Sans', size:11 }, color:'#7c6fa0' },
                    border: { display:false }
                }
            }
        }
    });
})();
</script>
</body>
</html>
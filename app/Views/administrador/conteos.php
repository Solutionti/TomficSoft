<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion - Inicio</title>
    <?php require_once("componentes/head.php")?>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ══════════════════════════════════════
           VARIABLES
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
            --accent-green:  #10b981;
            --accent-red:    #ef4444;
            --accent-amber:  #f59e0b;
            --accent-blue:   #3b82f6;
            --surface:       #ffffff;
            --surface-alt:   #fafbff;
            --border:        #e8e0f5;
            --text-primary:  #1a0533;
            --text-muted:    #7c6fa0;
            --shadow-sm:     0 1px 3px rgba(74,18,130,.08);
            --shadow-md:     0 4px 16px rgba(74,18,130,.12);
            --shadow-lg:     0 12px 40px rgba(74,18,130,.18);
            --radius:        14px;
            --radius-sm:     8px;
            --transition:    all .25s cubic-bezier(.4,0,.2,1);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--surface-alt);
            color: var(--text-primary);
        }

        h1,h2,h3,h4,h5,h6 { font-family: 'Syne', sans-serif; }

        /* ══════════════════════════════════════
           SCROLLBAR
        ══════════════════════════════════════ */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f5f0ff; }
        ::-webkit-scrollbar-thumb { background: var(--purple-400); border-radius: 99px; }

        /* ══════════════════════════════════════
           WRAPPER
        ══════════════════════════════════════ */
        .cnt-wrapper { padding: 24px 28px; }

        /* ══════════════════════════════════════
           TOP BAR
        ══════════════════════════════════════ */
        .cnt-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 24px;
        }

        .cnt-title-block .cnt-breadcrumb {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--purple-400);
            margin-bottom: 3px;
        }

        .cnt-title-block h1 {
            
        }

        .cnt-topbar-actions { display: flex; gap: 10px; flex-wrap: wrap; }

        /* ══════════════════════════════════════
           BUTTONS
        ══════════════════════════════════════ */
        .btn-c {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 20px;
            border-radius: 50px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: var(--transition);
            white-space: nowrap;
            text-decoration: none;
        }

        .btn-c-primary {
            background: linear-gradient(135deg, var(--purple-600), var(--purple-500));
            color: #fff;
            box-shadow: 0 4px 14px rgba(107,33,184,.35);
        }
        .btn-c-primary:hover { background: linear-gradient(135deg,var(--purple-700),var(--purple-600)); transform:translateY(-1px); box-shadow:0 6px 20px rgba(107,33,184,.45); color:#fff; }

        .btn-c-success {
            background: linear-gradient(135deg,#059669,var(--accent-green));
            color:#fff;
            box-shadow:0 4px 14px rgba(16,185,129,.3);
        }
        .btn-c-success:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(16,185,129,.4); color:#fff; }

        .btn-c-outline {
            background: #fff;
            border: 1.5px solid var(--purple-300);
            color: var(--purple-700);
        }
        .btn-c-outline:hover { background: var(--purple-100); border-color:var(--purple-500); transform:translateY(-1px); }

        .btn-c-danger-outline {
            background: transparent;
            border: 1.5px solid var(--accent-red);
            color: var(--accent-red);
        }
        .btn-c-danger-outline:hover { background:var(--accent-red); color:#fff; transform:translateY(-1px); }

        .btn-c-amber {
            background: linear-gradient(135deg,#d97706,var(--accent-amber));
            color:#fff;
            box-shadow:0 4px 14px rgba(245,158,11,.3);
        }
        .btn-c-amber:hover { transform:translateY(-1px); color:#fff; }

        /* ══════════════════════════════════════
           META STRIP
        ══════════════════════════════════════ */
        .cnt-meta-strip {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
            margin-bottom: 22px;
        }

        .cnt-meta-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .cnt-meta-card:hover { border-color:var(--purple-300); box-shadow:var(--shadow-md); transform:translateY(-2px); }

        .cnt-meta-icon {
            width: 36px; height: 36px;
            border-radius: 9px;
            background: var(--purple-100);
            display: flex; align-items: center; justify-content: center;
            color: var(--purple-600);
            font-size: 15px;
            flex-shrink: 0;
        }

        .cnt-meta-info label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--text-muted);
            display: block;
            margin-bottom: 2px;
        }

        .cnt-meta-info input,
        .cnt-meta-info textarea {
            background: transparent;
            border: none;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            width: 100%;
            outline: none;
            padding: 0;
            resize: none;
            line-height: 1.4;
        }

        /* ══════════════════════════════════════
           MAIN GRID
        ══════════════════════════════════════ */
        .cnt-main-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            margin-bottom: 18px;
        }

        @media (max-width:992px) { .cnt-main-grid { grid-template-columns:1fr; } }

        /* ══════════════════════════════════════
           PANEL CARD
        ══════════════════════════════════════ */
        .panel-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            transition: var(--transition);
        }

        .panel-card:hover { box-shadow: var(--shadow-md); }

        .panel-card-header {
            padding: 13px 18px;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(90deg,var(--purple-100),#fdf8ff);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .panel-card-header h6 {
            font-size: 12px;
            font-weight: 700;
            color: var(--purple-800);
            letter-spacing: .04em;
            text-transform: uppercase;
            margin: 0;
        }

        .panel-card-header .ph-icon {
            width: 28px; height: 28px;
            border-radius: 7px;
            background: var(--purple-200);
            display: flex; align-items: center; justify-content: center;
            color: var(--purple-700);
            font-size: 13px;
        }

        .panel-card-body { padding: 18px; }

        /* ══════════════════════════════════════
           FORM CONTROLS
        ══════════════════════════════════════ */
        .fl { display: flex; flex-direction: column; gap: 4px; }

        .fl label {
            font-size: 10.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--text-muted);
        }

        .fl label.required { color: var(--accent-red); }

        .fc, .fs {
            width: 100%;
            padding: 8px 12px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            color: var(--text-primary);
            background: var(--surface);
            transition: var(--transition);
            outline: none;
            appearance: none;
        }

        .fc:focus, .fs:focus {
            border-color: var(--purple-400);
            box-shadow: 0 0 0 3px rgba(168,85,247,.15);
        }

        .fc[readonly], .fc:disabled {
            background: var(--purple-100);
            color: var(--purple-700);
            cursor: default;
        }

        .fc-highlight {
            border-color: var(--purple-400) !important;
            background: #fff !important;
            color: var(--text-primary) !important;
            font-weight: 700 !important;
            font-size: 14px !important;
        }

        .fc-highlight:focus {
            box-shadow: 0 0 0 4px rgba(168,85,247,.2);
        }

        /* ══════════════════════════════════════
           PRODUCT SEARCH BAR
        ══════════════════════════════════════ */
        .search-bar {
            display: flex;
            gap: 0;
            border: 1.5px solid var(--purple-400);
            border-radius: var(--radius-sm);
            overflow: hidden;
            box-shadow: 0 0 0 3px rgba(168,85,247,.12);
        }

        .search-bar input {
            flex: 1;
            padding: 9px 14px;
            border: none;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: var(--text-primary);
            background: #fff;
            outline: none;
            text-transform: uppercase;
        }

        .search-bar button {
            padding: 0 16px;
            background: var(--purple-600);
            border: none;
            color: #fff;
            cursor: pointer;
            transition: var(--transition);
            font-size: 15px;
        }

        .search-bar button:hover { background: var(--purple-700); }

        /* ══════════════════════════════════════
           COUNTING FIELDS (big number inputs)
        ══════════════════════════════════════ */
        .count-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .count-cell {
            background: var(--surface-alt);
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 12px 14px;
            transition: var(--transition);
        }

        .count-cell:hover { border-color:var(--purple-300); }

        .count-cell label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--text-muted);
            display: block;
            margin-bottom: 4px;
        }

        .count-cell input {
            width: 100%;
            border: none;
            background: transparent;
            font-family: 'Syne', sans-serif;
            font-size: 22px;
            font-weight: 800;
            color: var(--purple-700);
            outline: none;
            padding: 0;
        }

        .count-cell input[readonly] { color: var(--purple-400); }

        .count-cell.total-cell {
            background: linear-gradient(135deg,var(--purple-700),var(--purple-500));
            border-color: transparent;
            grid-column: span 2;
        }

        .count-cell.total-cell label { color: rgba(255,255,255,.75); }
        .count-cell.total-cell input { color: #fff; font-size: 28px; }

        /* ══════════════════════════════════════
           RESULT CHIPS (Saldo / Diferencia)
        ══════════════════════════════════════ */
        .result-chips {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 12px;
        }

        .result-chip {
            border-radius: var(--radius-sm);
            padding: 10px 14px;
            text-align: center;
        }

        .result-chip.saldo { background:#dbeafe; border: 1.5px solid #bfdbfe; }
        .result-chip.diferencia { background:#fee2e2; border: 1.5px solid #fecaca; }

        .result-chip label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            display: block;
            margin-bottom: 3px;
        }

        .result-chip.saldo label { color: #1e40af; }
        .result-chip.diferencia label { color: #991b1b; }

        .result-chip input {
            width: 100%;
            border: none;
            background: transparent;
            font-family: 'Syne', sans-serif;
            font-size: 20px;
            font-weight: 800;
            text-align: center;
            outline: none;
        }

        .result-chip.saldo input { color: #1d4ed8; }
        .result-chip.diferencia input { color: #dc2626; }

        /* ══════════════════════════════════════
           ACTION BUTTONS ROW
        ══════════════════════════════════════ */
        .action-row {
            display: flex;
            gap: 10px;
            margin-top: 16px;
            flex-wrap: wrap;
        }

        /* ══════════════════════════════════════
           LOCATION STRIP
        ══════════════════════════════════════ */
        .location-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 18px;
        }

        @media (max-width:768px) { .location-strip { grid-template-columns:1fr 1fr; } }

        .loc-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 11px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .loc-card:hover { border-color:var(--purple-300); transform:translateY(-2px); box-shadow:var(--shadow-md); }

        .loc-card .loc-icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg,var(--purple-600),var(--purple-400));
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: 13px;
            flex-shrink: 0;
        }

        .loc-card .loc-info label {
            font-size: 9.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--text-muted);
            display: block;
            margin-bottom: 2px;
        }

        .loc-card .loc-info input {
            background: transparent;
            border: none;
            font-family: 'DM Sans', sans-serif;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-primary);
            width: 100%;
            outline: none;
            padding: 0;
            text-transform: uppercase;
        }

        /* ══════════════════════════════════════
           MODAL STYLES
        ══════════════════════════════════════ */
        .modal-content {
            border: none;
            border-radius: var(--radius) !important;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            font-family: 'DM Sans', sans-serif;
        }

        .modal-header-inv {
            background: linear-gradient(135deg, var(--purple-800), var(--purple-600)) !important;
            padding: 16px 22px;
            border-bottom: none;
        }

        .modal-header-inv .modal-title {
            font-family: 'Syne', sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            letter-spacing: .04em;
        }

        .modal-header-inv .btn-close { filter: invert(1); opacity:.8; }
        .modal-body { background: var(--surface-alt); padding: 20px; }
        .modal-footer { background: var(--surface); border-top: 1px solid var(--border); padding: 12px 20px; }

        /* ══════════════════════════════════════
           INVENTORY TABLE (modal)
        ══════════════════════════════════════ */
        .inv-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 13px;
        }

        .inv-table thead th {
            background: linear-gradient(135deg, var(--purple-800), var(--purple-700));
            color: #fff;
            padding: 11px 14px;
            text-align: left;
            font-family: 'Syne', sans-serif;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .inv-table tbody tr {
            border-bottom: 1px solid #f0ebfa;
            transition: var(--transition);
        }

        .inv-table tbody tr:hover { background: linear-gradient(90deg,#f9f5ff,#fdf8ff); }
        .inv-table tbody tr:nth-child(even) { background-color: #fdfaff; }
        .inv-table tbody tr:nth-child(even):hover { background: linear-gradient(90deg,#f9f5ff,#fdf8ff); }

        .inv-table td { padding: 10px 14px; vertical-align: middle; }

        .badge-inv {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-inv::before {
            content:''; width:6px; height:6px;
            border-radius:50%; background:currentColor; opacity:.7;
        }

        .badge-success-inv { background:#d1fae5; color:#065f46; }
        .badge-danger-inv  { background:#fee2e2; color:#991b1b; }

        /* Radio custom */
        .radio-inv {
            width: 16px; height: 16px;
            accent-color: var(--purple-600);
            cursor: pointer;
        }

        /* Highlight row when selected */
        .inv-table tbody tr.selected-row {
            background: linear-gradient(90deg,#ede0ff,#f5f0ff) !important;
            border-left: 3px solid var(--purple-500);
        }

        /* ══════════════════════════════════════
           PRODUCT TABLE
        ══════════════════════════════════════ */
        .product-avatar {
            width: 32px; height: 32px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid var(--purple-200);
        }

        .product-name { font-size: 13px; font-weight: 600; color: var(--text-primary); }
        .product-code { font-size: 11px; color: var(--text-muted); }

        /* ══════════════════════════════════════
           PULSE ANIMATION
        ══════════════════════════════════════ */
        @keyframes pulse-purple {
            0%, 100% { box-shadow: 0 0 0 0 rgba(139,63,212,.4); }
            50%       { box-shadow: 0 0 0 6px rgba(139,63,212,0); }
        }

        .pulse-ring { animation: pulse-purple 2s infinite; }

        /* Entrada animada */
        @keyframes slideUp {
            from { opacity:0; transform:translateY(18px); }
            to   { opacity:1; transform:translateY(0); }
        }

        .anim-1 { animation: slideUp .35s ease .05s both; }
        .anim-2 { animation: slideUp .35s ease .12s both; }
        .anim-3 { animation: slideUp .35s ease .19s both; }
        .anim-4 { animation: slideUp .35s ease .26s both; }
        .anim-5 { animation: slideUp .35s ease .33s both; }

        /* ══════════════════════════════════════
           LEGACY COMPAT
        ══════════════════════════════════════ */
        .color-morado {
            background: linear-gradient(135deg,var(--purple-800),var(--purple-700)) !important;
        }

        @media (max-width:768px) {
            .cnt-wrapper { padding: 14px; }
            .cnt-title-block h1 { font-size: 20px; }
            .count-grid { grid-template-columns: 1fr 1fr; }
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
                <div class="cnt-wrapper">

                    <!-- ═══════════ TOP BAR ═══════════ -->
                    <div class="cnt-topbar anim-1">
                        <div class="cnt-title-block">
                            <p class="cnt-breadcrumb">Administración &rsaquo; InventSoft</p>
                            <h1>Conteo de Inventario</h1>
                        </div>
                        <div class="cnt-topbar-actions">
                            <button class="btn-c btn-c-primary pulse-ring" onclick="finalizarConteo()">
                                <i class="fas fa-flag-checkered"></i> Terminar conteo
                            </button>
                            <button class="btn-c btn-c-outline" data-bs-toggle="modal" data-bs-target="#exportarexcelmodal">
                                <i class="fas fa-clipboard-list"></i> Inventario
                            </button>
                        </div>
                    </div>

                    <!-- ═══════════ META STRIP ═══════════ -->
                    <div class="cnt-meta-strip anim-2">
                        <div class="cnt-meta-card">
                            <div class="cnt-meta-icon"><i class="fas fa-user"></i></div>
                            <div class="cnt-meta-info">
                                <label>Usuario</label>
                                <input type="text" id="usuario" readonly
                                    value="<?php echo session()->get('nombre').' '.session()->get('apellido')?>">
                            </div>
                        </div>
                        <div class="cnt-meta-card">
                            <div class="cnt-meta-icon"><i class="fas fa-calendar-day"></i></div>
                            <div class="cnt-meta-info">
                                <label>Fecha</label>
                                <input type="date" id="fecha" value="<?php echo date('Y-m-d') ?>" readonly>
                            </div>
                        </div>
                        <div class="cnt-meta-card" style="grid-column: span 2;">
                            <div class="cnt-meta-icon"><i class="fas fa-comment-alt"></i></div>
                            <div class="cnt-meta-info" style="flex:1;">
                                <label>Observación</label>
                                <textarea rows="1" id="observacion" readonly class="text-uppercase"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ═══════════ LOCATION STRIP ═══════════ -->
                    <div class="location-strip anim-3">
                        <div class="loc-card">
                            <div class="loc-icon"><i class="fas fa-warehouse"></i></div>
                            <div class="loc-info">
                                <label>Ubicación *</label>
                                <input type="text" id="ubicacion" readonly>
                            </div>
                        </div>
                        <div class="loc-card">
                            <div class="loc-icon"><i class="fas fa-map-pin"></i></div>
                            <div class="loc-info">
                                <label>Localización *</label>
                                <input type="text" id="localizacion" readonly>
                            </div>
                        </div>
                        <div class="loc-card">
                            <div class="loc-icon"><i class="fas fa-hashtag"></i></div>
                            <div class="loc-info">
                                <label>Nº Localización *</label>
                                <input type="text" id="numero_localizacion" readonly>
                            </div>
                        </div>
                        <div class="loc-card">
                            <div class="loc-icon" style="background:linear-gradient(135deg,#059669,#10b981);">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <div class="loc-info">
                                <label>Conteo</label>
                                <input type="number" id="conteo" value="1" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- ═══════════ MAIN GRID ═══════════ -->
                    <div class="cnt-main-grid anim-4">

                        <!-- LEFT: Producto -->
                        <div class="panel-card">
                            <div class="panel-card-header">
                                <div class="ph-icon"><i class="fas fa-barcode"></i></div>
                                <h6>Datos del Producto</h6>
                            </div>
                            <div class="panel-card-body">
                                <!-- Search bar -->
                                <div class="fl" style="margin-bottom:16px;">
                                    <label class="required">Código Producto *</label>
                                    <div class="search-bar">
                                        <input type="text" id="codigo_producto" autofocus
                                            class="text-uppercase" placeholder="Escanea o escribe el código…">
                                        <button type="button" data-bs-toggle="modal"
                                            data-bs-target="#listaproductos" title="Buscar en lista">
                                            <i class="fas fa-store"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Nombre + Ref -->
                                <div style="display:grid;grid-template-columns:2fr 1fr;gap:10px;margin-bottom:12px;">
                                    <div class="fl">
                                        <label>Nombre Producto</label>
                                        <input type="text" class="fc text-uppercase" id="nombre_producto" readonly>
                                    </div>
                                    <div class="fl">
                                        <label>Referencia</label>
                                        <input type="text" class="fc text-uppercase" id="referencia" readonly>
                                    </div>
                                </div>

                                <!-- Proveedor + Costo -->
                                <div style="display:grid;grid-template-columns:3fr 1fr;gap:10px;margin-bottom:12px;">
                                    <div class="fl">
                                        <label>Proveedor</label>
                                        <input type="text" class="fc text-uppercase" id="proveedor" readonly>
                                    </div>
                                    <div class="fl">
                                        <label>Costo</label>
                                        <input type="text" class="fc text-uppercase" id="costo" readonly>
                                    </div>
                                </div>

                                <!-- Linea / Sublinea / Subgrupo -->
                                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;">
                                    <div class="fl">
                                        <label>Línea</label>
                                        <input type="text" class="fc text-uppercase" id="linea" readonly>
                                    </div>
                                    <div class="fl">
                                        <label>Sublínea</label>
                                        <input type="text" class="fc text-uppercase" id="sublinea" readonly>
                                    </div>
                                    <div class="fl">
                                        <label>Subgrupo</label>
                                        <input type="text" class="fc text-uppercase" id="subgrupo" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-card">
                            <div class="panel-card-header">
                                <div class="ph-icon" style="background:linear-gradient(135deg,var(--purple-500),var(--purple-300));color:#fff;">
                                    <i class="fas fa-calculator"></i>
                                </div>
                                <h6>Registro de Cantidades</h6>
                            </div>
                            <div class="panel-card-body">
                                <div class="count-grid" style="margin-bottom:14px;">
                                    <div class="count-cell">
                                        <label>Unidades *</label>
                                        <input type="number" id="unidades" placeholder="0">
                                    </div>
                                    <div class="count-cell">
                                        <label>Embalaje *</label>
                                        <input type="number" id="embalaje" placeholder="0">
                                    </div>
                                    <div class="count-cell">
                                        <label>Cajas *</label>
                                        <input type="number" id="cajas" placeholder="0">
                                    </div>
                                    <div class="count-cell total-cell">
                                        <label>Total calculado</label>
                                        <input type="number" id="total" readonly placeholder="0">
                                    </div>
                                </div>
                                <div class="fl" style="margin-bottom:14px;">
                                    <label>Estado del producto *</label>
                                    <select class="fs" id="estado_producto">
                                        <option value="">Seleccione el estado…</option>
                                        <option value="Bueno">✅ Bueno</option>
                                        <option value="Averiado">⚠️ Averiado</option>
                                        <option value="Vencido">❌ Vencido</option>
                                    </select>
                                </div>
                                <div class="action-row">
                                    <button class="btn-c btn-c-primary" id="btnguardar" onclick="GuardarConteo()">
                                        <i class="fas fa-save"></i> Guardar
                                    </button>
                                    <button class="btn-c btn-c-amber" onclick="modificarConteo()">
                                        <i class="fas fa-pen"></i> Modificar
                                    </button>
                                </div>
                                <div class="result-chips">
                                    <div class="result-chip saldo">
                                        <label>Saldo</label>
                                        <input type="number" id="saldo" readonly placeholder="—">
                                    </div>
                                    <div class="result-chip diferencia">
                                        <label>Diferencia</label>
                                        <input type="number" id="diferencia" readonly placeholder="—">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════
     MODAL: INVENTARIO ASOCIADO AL USUARIO
══════════════════════════════════════ -->
<div class="modal fade" id="exportarexcelmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header modal-header-inv">
        <h1 class="modal-title">
            <i class="fas fa-clipboard-list me-2"></i>Inventario Asociado al Usuario
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div style="overflow-x:auto; border-radius:var(--radius); border:1px solid var(--border);">
          <table class="inv-table">
            <thead>
              <tr>
                <th></th>
                <th>Inventario</th>
                <th>Descripción</th>
                <th>Fecha inicio</th>
                <th>Fecha cierre</th>
                <th>Conteo 1</th>
                <th>Conteo 2</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($inventarios->getResult() as $inventario) { ?>
              <tr>
                <td>
                  <?php if($inventario->estado != "Cerrado"){ ?>
                  <input class="radio-inv" type="radio" name="radioDefault"
                    onclick="crearvariableSesion(<?= $inventario->codigo_inventario; ?>)">
                  <?php } ?>
                </td>
                <td>
                    <span style="font-family:'Syne',sans-serif;font-weight:700;color:var(--purple-600);">
                        #<?= $inventario->codigo_inventario; ?>
                    </span>
                </td>
                <td style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"
                    title="<?= $inventario->observacion; ?>">
                    <?= $inventario->observacion; ?>
                </td>
                <td><?= $inventario->fecha; ?></td>
                <td><?= $inventario->fecha_cierre; ?></td>
                <td>
                  <?php if($inventario->usuarioconteo1 == session()->get('documento')) { ?>
                    <span style="color:var(--purple-600);font-weight:700;"><?= $inventario->usuarioconteo1; ?> <i class="fas fa-star fa-xs"></i></span>
                  <?php } else { ?>
                    <span><?= $inventario->usuarioconteo1; ?></span>
                  <?php } ?>
                </td>
                <td>
                  <?php if($inventario->usuarioconteo2 == session()->get('documento')) { ?>
                    <span style="color:var(--purple-600);font-weight:700;"><?= $inventario->usuarioconteo2; ?> <i class="fas fa-star fa-xs"></i></span>
                  <?php } else { ?>
                    <span><?= $inventario->usuarioconteo2; ?></span>
                  <?php } ?>
                </td>
                <td>
                  <?php if($inventario->estado == "Activo") { ?>
                    <span class="badge-inv badge-success-inv"><?= $inventario->estado; ?></span>
                  <?php } else { ?>
                    <span class="badge-inv badge-danger-inv"><?= $inventario->estado; ?></span>
                  <?php } ?>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-c btn-c-danger-outline" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Cerrar
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════
     MODAL: LISTADO DE PRODUCTOS
══════════════════════════════════════ -->
<div class="modal fade" id="listaproductos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header modal-header-inv">
        <h1 class="modal-title">
            <i class="fas fa-boxes me-2"></i>Listado de Productos
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div style="overflow-x:auto; border-radius:var(--radius); border:1px solid var(--border);">
          <table class="inv-table" id="table-productos">
            <thead>
              <tr>
                <th></th>
                <th>Código</th>
                <th>EAN8</th>
                <th>Nombre</th>
                <th>Proveedor</th>
                <th>Categoría</th>
                <th>Subcategoría</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($productos->getResult() as $producto){ ?>
              <tr>
                <td>
                  <input class="radio-inv" type="radio" name="radioProducto"
                    onclick="VincularProductoModal(<?= $producto->codigo_barras; ?>)">
                </td>
                <td style="font-family:'Syne',sans-serif;font-weight:700;color:var(--purple-600);">
                    <?= $producto->codigo_interno; ?>
                </td>
                <td style="font-size:12px;color:var(--text-muted);"><?= $producto->codigo_barras; ?></td>
                <td>
                  <div style="display:flex;align-items:center;gap:10px;">
                    <img src="<?= base_url('img/team-41.jpg') ?>" class="product-avatar">
                    <div>
                      <div class="product-name"><?= $producto->nombre; ?></div>
                      <div class="product-code"><?= $producto->codigo_barras; ?></div>
                    </div>
                  </div>
                </td>
                <td><?= $producto->proveedor; ?></td>
                <td><?= $producto->categoria; ?></td>
                <td><?= $producto->subcategoria; ?></td>
                <td><span class="badge-inv badge-success-inv"><?= $producto->estado; ?></span></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-c btn-c-danger-outline" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Cerrar
        </button>
      </div>
    </div>
  </div>
</div>

<?php require_once("componentes/scripts.php")?>
<script src="<?= base_url('js/conteos.js') ?>"></script>

<?php if(session()->get('inventario') == 0) { ?>
<script>
    $(document).ready(function () {
        $("#exportarexcelmodal").modal('show');
    });
</script>
<?php } ?>

<script>
/* ── Row highlight on radio select ── */
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.radio-inv').forEach(radio => {
        radio.addEventListener('change', function(){
            const tbody = this.closest('tbody');
            tbody.querySelectorAll('tr').forEach(r => r.classList.remove('selected-row'));
            this.closest('tr').classList.add('selected-row');
        });
    });
});
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion - Facturacion</title>
    <?php require_once("componentes/head.php")?>

    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ============================================================
           VARIABLES & BASE
        ============================================================ */
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
            --accent-red:   #ef4444;
            --accent-amber: #f59e0b;
            --accent-blue:  #3b82f6;
            --surface:      #ffffff;
            --surface-alt:  #fafbff;
            --border:       #e8e0f5;
            --text-primary: #1a0533;
            --text-muted:   #7c6fa0;
            --shadow-sm:    0 1px 3px rgba(74,18,130,.08);
            --shadow-md:    0 4px 16px rgba(74,18,130,.12);
            --shadow-lg:    0 12px 40px rgba(74,18,130,.18);
            --shadow-glow:  0 0 30px rgba(139,63,212,.25);
            --radius:       14px;
            --radius-sm:    8px;
            --transition:   all .25s cubic-bezier(.4,0,.2,1);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--surface-alt);
            color: var(--text-primary);
        }

        h1,h2,h3,h4,h5 { font-family: 'Syne', sans-serif; }

        /* ============================================================
           PAGE WRAPPER
        ============================================================ */
        .inv-wrapper {
            padding: 28px 32px;
            max-width: 100%;
        }

        /* ============================================================
           TOP HEADER BAR
        ============================================================ */
        .inv-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 28px;
        }

        .inv-topbar-left {
            display: flex;
            flex-direction: column;
        }

        .inv-breadcrumb {
            font-size: 11px;
            font-weight: 500;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--purple-400);
            margin-bottom: 4px;
        }

        .inv-title {
            font-size: 26px;
            font-weight: 800;
            color: var(--purple-800);
            line-height: 1.15;
        }

        .inv-topbar-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        /* ============================================================
           BUTTONS
        ============================================================ */
        .btn-inv {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
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

        .btn-inv-primary {
            background: linear-gradient(135deg, var(--purple-600), var(--purple-500));
            color: #fff;
            box-shadow: 0 4px 14px rgba(107,33,184,.35);
        }
        .btn-inv-primary:hover {
            background: linear-gradient(135deg, var(--purple-700), var(--purple-600));
            box-shadow: 0 6px 20px rgba(107,33,184,.45);
            transform: translateY(-1px);
            color:#fff;
        }

        .btn-inv-success {
            background: linear-gradient(135deg, #059669, var(--accent-green));
            color: #fff;
            box-shadow: 0 4px 14px rgba(16,185,129,.3);
        }
        .btn-inv-success:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(16,185,129,.4);
            color:#fff;
        }

        .btn-inv-danger {
            background: linear-gradient(135deg, #ef4444, var(--accent-red));
            color: #fff;
            box-shadow: 0 4px 14px rgba(239,68,68,.3);
        }

        .btn-inv-outline-danger {
            background: transparent;
            border: 1.5px solid var(--accent-red);
            color: var(--accent-red);
        }
        .btn-inv-outline-danger:hover {
            background: var(--accent-red);
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-inv-outline {
            background: #fff;
            border: 1.5px solid var(--border);
            color: var(--purple-700);
        }
        .btn-inv-outline:hover {
            border-color: var(--purple-400);
            background: var(--purple-100);
            transform: translateY(-1px);
        }

        /* ============================================================
           META STRIP (Usuario, Año, Fecha, Bodega)
        ============================================================ */
        .inv-meta-strip {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 14px;
            margin-bottom: 28px;
        }

        .inv-meta-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .inv-meta-card:hover {
            border-color: var(--purple-300);
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .inv-meta-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--purple-100);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--purple-600);
            font-size: 16px;
            flex-shrink: 0;
        }

        .inv-meta-info label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--text-muted);
            display: block;
            margin-bottom: 2px;
        }

        .inv-meta-info input {
            background: transparent;
            border: none;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            width: 100%;
            outline: none;
            padding: 0;
        }

        /* ============================================================
           TABLE CARD
        ============================================================ */
        .inv-table-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .inv-table-card-header {
            padding: 16px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(90deg, var(--purple-100), #fdf8ff);
        }

        .inv-table-card-header h5 {
            font-size: 14px;
            font-weight: 700;
            color: var(--purple-800);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .inv-count-badge {
            background: var(--purple-600);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 9px;
            border-radius: 50px;
        }

        /* ============================================================
           TABLE
        ============================================================ */
        .inv-table-scroll { overflow-x: auto; }

        .inv-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 13px;
        }

        .inv-table thead th {
            background: linear-gradient(135deg, var(--purple-800), var(--purple-700));
            color: #fff;
            padding: 13px 16px;
            text-align: left;
            font-family: 'Syne', sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .inv-table thead th:first-child { border-radius: 0; }

        .inv-table tbody tr {
            border-bottom: 1px solid #f0ebfa;
            transition: var(--transition);
            animation: rowIn .35s ease forwards;
            opacity: 0;
        }

        @keyframes rowIn {
            from { opacity: 0; transform: translateX(-12px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .inv-table tbody tr:nth-child(1)  { animation-delay: .04s; }
        .inv-table tbody tr:nth-child(2)  { animation-delay: .08s; }
        .inv-table tbody tr:nth-child(3)  { animation-delay: .12s; }
        .inv-table tbody tr:nth-child(4)  { animation-delay: .16s; }
        .inv-table tbody tr:nth-child(5)  { animation-delay: .20s; }
        .inv-table tbody tr:nth-child(6)  { animation-delay: .24s; }
        .inv-table tbody tr:nth-child(7)  { animation-delay: .28s; }
        .inv-table tbody tr:nth-child(8)  { animation-delay: .32s; }
        .inv-table tbody tr:nth-child(9)  { animation-delay: .36s; }
        .inv-table tbody tr:nth-child(10) { animation-delay: .40s; }

        .inv-table tbody tr:hover {
            background: linear-gradient(90deg, #f9f5ff, #fdf8ff);
            transform: scale(1.001);
        }

        .inv-table td {
            padding: 13px 16px;
            color: var(--text-primary);
            vertical-align: middle;
        }

        .inv-table tbody tr:nth-child(even) { background-color: #fdfaff; }

        /* ============================================================
           BADGES
        ============================================================ */
        .badge-inv {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 11px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .04em;
        }

        .badge-inv::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: currentColor;
            opacity: .8;
        }

        .badge-success-inv { background: #d1fae5; color: #065f46; }
        .badge-danger-inv  { background: #fee2e2; color: #991b1b; }
        .badge-dark-inv    { background: #e5e7eb; color: #1f2937; }
        .badge-blue-inv    { background: #dbeafe; color: #1e40af; }

        /* ============================================================
           PANEL BTN SMALL
        ============================================================ */
        .btn-panel {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 11.5px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            white-space: nowrap;
        }

        .btn-panel-blue    { background: #dbeafe; color: #1d4ed8; }
        .btn-panel-blue:hover { background: #1d4ed8; color: #fff; transform: scale(1.04); }

        .btn-panel-green   { background: #d1fae5; color: #065f46; }
        .btn-panel-green:hover { background: #065f46; color: #fff; transform: scale(1.04); }

        /* ============================================================
           EDIT BTN
        ============================================================ */
        .btn-edit {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: var(--purple-100);
            border: 1.5px solid var(--purple-200);
            color: var(--purple-600);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-edit:hover {
            background: var(--purple-600);
            color: #fff;
            border-color: var(--purple-600);
            box-shadow: 0 4px 12px rgba(107,33,184,.4);
            transform: rotate(10deg) scale(1.1);
        }

        /* ============================================================
           MODALS
        ============================================================ */
        .modal-content {
            border: none;
            border-radius: var(--radius) !important;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            font-family: 'DM Sans', sans-serif;
        }

        .modal-header-inv {
            background: linear-gradient(135deg, var(--purple-800), var(--purple-600)) !important;
            padding: 18px 24px;
            border-bottom: none;
        }

        .modal-header-inv .modal-title {
            font-family: 'Syne', sans-serif;
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            letter-spacing: .04em;
        }

        .modal-header-inv .btn-close {
            filter: invert(1);
            opacity: .8;
        }

        .modal-body { background: var(--surface-alt); padding: 24px; }
        .modal-footer { background: var(--surface); border-top: 1px solid var(--border); padding: 14px 24px; }

        /* Form Controls */
        .form-label-inv {
            font-size: 11.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--text-muted);
            margin-bottom: 6px;
            display: block;
        }

        .form-control-inv,
        .form-select-inv {
            width: 100%;
            padding: 9px 13px;
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

        .form-control-inv:focus,
        .form-select-inv:focus {
            border-color: var(--purple-400);
            box-shadow: 0 0 0 3px rgba(168,85,247,.15);
        }

        .form-control-inv[readonly] {
            background: var(--purple-100);
            color: var(--purple-700);
        }

        textarea.form-control-inv { resize: vertical; min-height: 120px; }

        /* ============================================================
           TABS (modal ubicaciones)
        ============================================================ */
        .nav-pills-inv .nav-link {
            font-family: 'DM Sans', sans-serif;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-muted);
            border-radius: 50px;
            padding: 7px 18px;
            border: 1.5px solid var(--border);
            transition: var(--transition);
        }

        .nav-pills-inv .nav-link.active {
            background: var(--purple-600);
            border-color: var(--purple-600);
            color: #fff;
        }

        /* ============================================================
           REPORTS TABLE (inside modal)
        ============================================================ */
        .inv-table-sm thead th {
            font-size: 10.5px;
            padding: 10px 13px;
        }

        .inv-table-sm td { padding: 10px 13px; font-size: 12.5px; }

        /* ============================================================
           FILE UPLOAD
        ============================================================ */
        .file-drop-zone {
            border: 2.5px dashed var(--purple-300);
            border-radius: var(--radius);
            background: var(--purple-100);
            text-align: center;
            padding: 36px 20px;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
        }

        .file-drop-zone:hover, .file-drop-zone.dragover {
            background: #ede0ff;
            border-color: var(--purple-500);
            box-shadow: 0 0 0 4px rgba(168,85,247,.12);
        }

        .file-drop-zone input[type="file"] {
            position: absolute; inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%; height: 100%;
        }

        .file-drop-icon {
            font-size: 32px;
            margin-bottom: 10px;
            color: var(--purple-500);
        }

        .file-info-bar {
            display: none;
            background: #d1fae5;
            border: 1.5px solid #6ee7b7;
            border-radius: var(--radius-sm);
            padding: 10px 14px;
            margin-top: 12px;
            align-items: center;
            gap: 10px;
        }

        .file-info-bar.visible { display: flex; }

        /* ============================================================
           PULSE ANIMATION ON ACTIVE BADGE
        ============================================================ */
        @keyframes pulse-green {
            0%, 100% { box-shadow: 0 0 0 0 rgba(16,185,129,.4); }
            50%       { box-shadow: 0 0 0 5px rgba(16,185,129,0); }
        }

        .badge-active-pulse {
            animation: pulse-green 2.2s infinite;
        }

        /* ============================================================
           SCROLLBAR
        ============================================================ */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f5f0ff; }
        ::-webkit-scrollbar-thumb { background: var(--purple-400); border-radius: 99px; }

        /* ============================================================
           RESPONSIVE
        ============================================================ */
        @media (max-width: 768px) {
            .inv-wrapper { padding: 16px; }
            .inv-title { font-size: 20px; }
            .inv-topbar-actions .btn-inv span.label { display: none; }
        }

        /* ============================================================
           LOADING SHIMMER (optional empty state)
        ============================================================ */
        @keyframes shimmer {
            0%   { background-position: -400px 0; }
            100% { background-position: 400px 0; }
        }

        /* ============================================================
           OVERWRITE BOOTSTRAP color-morado for legacy compat
        ============================================================ */
        .color-morado {
            background: linear-gradient(135deg, var(--purple-800), var(--purple-700)) !important;
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
                <div class="inv-wrapper">

                    <!-- ═══════════════════ TOP BAR ═══════════════════ -->
                    <div class="inv-topbar">
                        <div class="inv-topbar-left">
                            <span class="inv-breadcrumb">Administracion &rsaquo; InventSoft</span>
                            <h1 class="">Facturación electronica</h1>
                        </div>
                        <div class="inv-topbar-actions">
                            <button class="btn-inv btn-inv-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                <i class="fas fa-plus-circle"></i>
                                <span class="label">Notas credito</span>
                            </button>
                            <button class="btn-inv btn-inv-success" data-bs-toggle="modal" data-bs-target="#modalasgignacionescrear">
                                <i class="fas fa-plus-circle"></i>
                                <span class="label">Notas debito</span>
                            </button>
                            <button class="btn-inv btn-inv-outline-danger" data-bs-toggle="modal" data-bs-target="#modalProceso">
                                <i class="fas fa-user"></i>
                                <span class="label">Clientes</span>
                            </button>
                            <button class="btn-inv btn-inv-outline" data-bs-toggle="modal" data-bs-target="#exportarexcelmodal">
                                <i class="fas fa-file-import"></i>
                                <span class="label">Importar BD</span>
                            </button>
                        </div>
                    </div>

                    <!-- ═══════════════════ META STRIP ═══════════════════ -->
                    <div class="inv-meta-strip">
                        <div class="inv-meta-card">
                            <div class="inv-meta-icon"><i class="fas fa-user"></i></div>
                            <div class="inv-meta-info">
                                <label>Usuario</label>
                                <input type="text" id="usuario_creacion" name="usuario_creacion"
                                    value="<?php echo session('nombre').' '.session('apellido') ?>" readonly>
                            </div>
                        </div>
                        <div class="inv-meta-card">
                            <div class="inv-meta-icon"><i class="fas fa-calendar-alt"></i></div>
                            <div class="inv-meta-info">
                                <label>Año</label>
                                <input type="text" id="año_creacion" name="año_creacion" value="2025" readonly>
                            </div>
                        </div>
                        <div class="inv-meta-card">
                            <div class="inv-meta-icon"><i class="fas fa-clock"></i></div>
                            <div class="inv-meta-info">
                                <label>Fecha</label>
                                <input type="text" id="fecha_creacion" name="fecha_creacion"
                                    value="<?php echo date('Y-m-d') ?>">
                            </div>
                        </div>
                        <div class="inv-meta-card">
                            <div class="inv-meta-icon"><i class="fas fa-warehouse"></i></div>
                            <div class="inv-meta-info">
                                <label>Bodega</label>
                                <input type="text" id="bodega_creacion" name="bodega_creacion" value="Inventario">
                            </div>
                        </div>
                    </div>

                    <!-- ═══════════════════ TABLE CARD ═══════════════════ -->
                    <div class="inv-table-card">
                        <div class="inv-table-card-header">
                            <h5>
                                <i class="fas fa-boxes"></i>
                                facturas registradas
                                <span class="inv-count-badge" id="totalRows">—</span>
                            </h5>
                            <div style="font-size:12px;color:var(--text-muted);">
                                <i class="fas fa-info-circle"></i>&nbsp;Haz clic en una fila para ver detalles
                            </div>
                        </div>
                        <div class="inv-table-scroll">
                            <table class="inv-table" id="mainInventoryTable">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Fecha</th>
                                        <th>Observación</th>
                                        <th>Conteo</th>
                                        <th>Fecha inicio</th>
                                        <th>Fecha cierre</th>
                                        <th>Estado</th>
                                        <th>Proceso final</th>
                                        <th>Panel de control</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($asignacionInventarios->getResult() as $asignacionInventario) { ?>
                                    <tr>
                                        <td>
                                            <button class="btn-edit" data-bs-toggle="modal" data-bs-target="#actualizarinventario"
                                                onclick="procesoDatosModalActualizar(<?= $asignacionInventario->codigo_inventario; ?>)"
                                                title="Editar inventario">
                                                <i class="fas fa-pen fa-xs"></i>
                                            </button>
                                        </td>
                                        
                                        <td><?= $asignacionInventario->fecha; ?></td>
                                        <td class="text-uppercase" style="max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"
                                            title="<?= $asignacionInventario->observacion; ?>">
                                            <?= $asignacionInventario->observacion; ?>
                                        </td>
                                        <td>
                                            <span class="badge-inv badge-blue-inv"><?= $asignacionInventario->conteos; ?></span>
                                        </td>
                                        <td><?= $asignacionInventario->fecha_inicio; ?></td>
                                        <td><?= $asignacionInventario->fecha_cierre; ?></td>
                                        <td>
                                            <?php if($asignacionInventario->estado == 'Activo') { ?>
                                                <span class="badge-inv badge-success-inv badge-active-pulse">
                                                    <?= $asignacionInventario->estado; ?>
                                                </span>
                                            <?php } else { ?>
                                                <span class="badge-inv badge-danger-inv">
                                                    <?= $asignacionInventario->estado; ?>
                                                </span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <span class="badge-inv badge-success-inv"><?= $asignacionInventario->proceso_final; ?></span>
                                        </td>
                                        <td>
                                            <div style="display:flex;gap:6px;flex-wrap:nowrap;">
                                                <?php if($asignacionInventario->btnproducto == 0) { ?>
                                                    <button class="btn-panel btn-panel-blue"
                                                        onclick="asociarDatosModalProductos(<?= $asignacionInventario->codigo_inventario; ?>)">
                                                        <i class="fas fa-box fa-xs"></i> Productos
                                                    </button>
                                                <?php } else { ?>
                                                    <button class="btn-panel btn-panel-green"
                                                        onclick="asociarDatosModalProductos(<?= $asignacionInventario->codigo_inventario; ?>)">
                                                        <i class="fas fa-box-open fa-xs"></i> Productos
                                                    </button>
                                                <?php } ?>

                                                <?php if($asignacionInventario->btnubicacion == 0) { ?>
                                                    <button class="btn-panel btn-panel-blue"
                                                        onclick="asociarDatosModalConteos(<?= $asignacionInventario->codigo_inventario; ?>)">
                                                        <i class="fas fa-map-pin fa-xs"></i> Ubicación
                                                    </button>
                                                <?php } else { ?>
                                                    <button class="btn-panel btn-panel-green"
                                                        onclick="asociarDatosModalConteos(<?= $asignacionInventario->codigo_inventario; ?>)">
                                                        <i class="fas fa-map-pin fa-xs"></i> Ubicación
                                                    </button>
                                                <?php } ?>

                                                <?php if($asignacionInventario->btnproceso == 0) { ?>
                                                    <button class="btn-panel btn-panel-blue" data-bs-toggle="modal"
                                                        data-bs-target="#modalReportes"
                                                        onclick="procesoDatosModal(<?= $asignacionInventario->codigo_inventario; ?>)">
                                                        <i class="fas fa-tasks fa-xs"></i> Procesos
                                                    </button>
                                                <?php } else { ?>
                                                    <button class="btn-panel btn-panel-green" data-bs-toggle="modal"
                                                        data-bs-target="#modalReportes"
                                                        onclick="procesoDatosModal(<?= $asignacionInventario->codigo_inventario; ?>)">
                                                        <i class="fas fa-tasks fa-xs"></i> Procesos
                                                    </button>
                                                <?php } ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ══════════════════════════════════════════════════
     MODAL: CREAR INVENTARIO
══════════════════════════════════════════════════ -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header modal-header-inv">
        <h1 class="modal-title" id="staticBackdropLabel">
            <i class="fas fa-plus-circle me-2"></i>Creación de Inventario
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row mt-3 g-3">
            <div class="col-md-8">
              <label class="form-label-inv">Fecha inicial *</label>
              <input type="date" id="fecha_agregar_inventario" name="fecha_agregar_inventario"
                class="form-control-inv" value="<?php echo date('Y-m-d') ?>" readonly>
            </div>
            <div class="col-md-4">
              <label class="form-label-inv">¿Cuántos conteos? *</label>
              <select class="form-control-inv form-select-inv" id="conteos_agregar_inventario">
                <option value="">Seleccione...</option>
                <option value="1">1 conteo</option>
                <option value="2">2 conteos</option>
              </select>
            </div>
            <div class="col-md-12">
              <label class="form-label-inv">Observación *</label>
              <textarea id="observacion_agregar_inventario" name="observacion_agregar_inventario"
                class="form-control-inv" rows="15"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-inv btn-inv-outline-danger" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Cerrar
        </button>
        <button type="button" class="btn-inv btn-inv-primary" onclick="crearInventarios()" id="creinventario">
            <span class="spinner-border spinner-border-sm" id="spinnerinventarios" hidden="true"></span>
            <i class="fas fa-save"></i> Guardar
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════════════════
     MODAL: CONTEOS
══════════════════════════════════════════════════ -->
<div class="modal fade" id="modalConteos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header modal-header-inv">
        <h1 class="modal-title">
            <i class="fas fa-layer-group me-2"></i>Programación de Conteos Individuales
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row mt-2 g-3">
            <div class="col-md-1">
              <label class="form-label-inv">Id</label>
              <input type="text" class="form-control-inv" id="id_conteo_modal">
            </div>
            <div class="col-md-3">
              <label class="form-label-inv">Ubicación</label>
              <select class="form-control-inv form-select-inv text-uppercase" id="ubicacion_conteo">
                <option value="">Seleccione ubicación</option>
                <?php foreach ($ubicaciones->getResult() as $ubicacion): ?>
                  <option value="<?= $ubicacion->descripcion ?>"><?= $ubicacion->descripcion ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label-inv">Localización</label>
              <select id="localizacion_conteo" class="form-control-inv form-select-inv text-uppercase"
                onchange="getnumerolocalizacion()">
                <option value="">Seleccione localización</option>
                <?php foreach ($localizaciones->getResult() as $localizacion): ?>
                  <option value="<?= $localizacion->descripcion ?>"><?= $localizacion->descripcion ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label-inv">N. Localización</label>
              <input type="text" id="numero_conteo" class="form-control-inv" readonly>
            </div>
            <div class="col-md-12">
              <label class="form-label-inv">Observación *</label>
              <textarea id="observacion_agregar_inventarios" class="form-control-inv" rows="22"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-inv btn-inv-outline-danger" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Cerrar
        </button>
        <button type="button" class="btn-inv btn-inv-primary" onclick="asignarUbicacionInventario()">
            <i class="fas fa-save"></i> Guardar
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════════════════
     MODAL: TABLERO REPORTES
══════════════════════════════════════════════════ -->
<div class="modal fade" id="modalProceso" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header modal-header-inv">
        <h1 class="modal-title">
            <i class="fas fa-chart-bar me-2"></i>Tablero de Reportes de Conteos
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row mt-3">
            <div class="col-md-12">
              <div class="inv-table-card">
                <div class="inv-table-scroll">
                  <table class="inv-table inv-table-sm">
                    <thead>
                      <tr>
                        <th>Ubicación</th>
                        <th>Localización</th>
                        <th>N.Local</th>
                        <th>Observación</th>
                        <th>Usuarios</th>
                        <th>Conteo #1</th>
                        <th>Conteo #2</th>
                        <th>Diferencia</th>
                        <th>Validador</th>
                        <th>Imprimir reporte</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($reportes->getResult() as $reporte){ ?>
                      <tr>
                        <td class="text-uppercase"><?= $reporte->ubicacion; ?></td>
                        <td class="text-uppercase"><?= $reporte->localizacion; ?></td>
                        <td><?= $reporte->numerolocalizacion; ?></td>
                        <td class="text-uppercase"><?= $reporte->observacion; ?></td>
                        <td style="font-size:12px;"><?= $reporte->usuarioconteo1.' → '.$reporte->usuarioconteo2; ?></td>
                        <td><span class="badge-inv badge-dark-inv"><?= $reporte->conte1; ?></span></td>
                        <td><span class="badge-inv badge-dark-inv"><?= $reporte->conte2; ?></span></td>
                        <td>
                            <?php $diff = $reporte->conte1 - $reporte->conte2; ?>
                            <span class="badge-inv <?= $diff == 0 ? 'badge-success-inv' : 'badge-danger-inv' ?>">
                                <?= $diff; ?>
                            </span>
                        </td>
                        <?php if($diff > 0) { ?>
                          <td><span class="badge-inv badge-danger-inv">Diferencia</span></td>
                        <?php } else { ?>
                          <td><span class="badge-inv badge-success-inv">Completo</span></td>
                        <?php } ?>
                        <td>
                          <div style="display:flex;gap:6px;">
                            <a target="_blank"
                              href="<?php echo base_url(); ?>generarpdfreportes/<?= $reporte->codigo_inventario; ?>"
                              class="btn-panel" style="background:#fee2e2;color:#b91c1c;">
                              <i class="fas fa-file-pdf fa-xs"></i> PDF
                            </a>
                            <a href="<?php echo base_url(); ?>generarexcelreportes/<?= $reporte->codigo_inventario; ?>"
                              class="btn-panel btn-panel-green">
                              <i class="fas fa-file-excel fa-xs"></i> Excel
                            </a>
                          </div>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-inv btn-inv-outline-danger" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Cerrar
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════════════════
     MODAL: ASIGNACION CONTEOS FISICOS
══════════════════════════════════════════════════ -->
<div class="modal fade" id="modalReportes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header modal-header-inv">
        <h1 class="modal-title">
            <i class="fas fa-user-check me-2"></i>Asignación de Conteos Físicos
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row mt-3 g-3">
            <div class="col-md-4">
              <label class="form-label-inv">Fecha</label>
              <input type="date" class="form-control-inv" id="fecha_asignacion" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label-inv">Observación</label>
              <input type="text" class="form-control-inv" id="observacion_asignacion" readonly>
            </div>
            <div class="col-md-2">
              <label class="form-label-inv">Código Inventario</label>
              <input type="text" class="form-control-inv" id="codigo_asignacion" readonly>
            </div>
            <div class="col-md-4">
              <label class="form-label-inv">Ubicación</label>
              <input type="text" class="form-control-inv" id="ubicacion_asignacion" readonly>
            </div>
            <div class="col-md-3">
              <label class="form-label-inv">Localización</label>
              <input type="text" class="form-control-inv" id="localizacion_asignacion" readonly>
            </div>
            <div class="col-md-3">
              <label class="form-label-inv">N° Localización</label>
              <input type="text" class="form-control-inv" id="nlocalizacion_asignacion" readonly>
            </div>
            <div class="col-md-2">
              <label class="form-label-inv"># Conteos</label>
              <input type="text" class="form-control-inv" id="nconteos_asignacion" readonly>
            </div>
          </div>
          <!-- user tables -->
          <div class="row mt-4 g-4">
            <div class="col-md-6">
              <div class="inv-table-card">
                <div class="inv-table-card-header">
                    <h5><i class="fas fa-user-plus"></i> Asignar usuario — Conteo 1</h5>
                </div>
                <div class="inv-table-scroll">
                  <table class="inv-table inv-table-sm" id="tablaconteo1usuario">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Rol</th>
                        <th>Estado</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($usuarios->getResult() as $usuario) { ?>
                      <tr>
                        <td>
                          <input class="form-check-input chk" type="checkbox" value="<?= $usuario->documento; ?>"
                            style="width:16px;height:16px;accent-color:var(--purple-600);cursor:pointer;">
                        </td>
                        <td><?= $usuario->documento; ?></td>
                        <td><?= $usuario->nombre; ?></td>
                        <td><?= $usuario->apellido; ?></td>
                        <td><?= $usuario->rol_usuario; ?></td>
                        <td><?= $usuario->estado; ?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="inv-table-card">
                <div class="inv-table-card-header">
                    <h5><i class="fas fa-user-plus"></i> Asignar usuario — Conteo 2</h5>
                </div>
                <div class="inv-table-scroll">
                  <table class="inv-table inv-table-sm" id="tablaconteo2usuario">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Rol</th>
                        <th>Estado</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($usuarios->getResult() as $usuario) { ?>
                      <tr>
                        <td>
                          <input class="form-check-input fila" type="checkbox" value="<?= $usuario->documento; ?>"
                            style="width:16px;height:16px;accent-color:var(--purple-600);cursor:pointer;">
                        </td>
                        <td><?= $usuario->documento; ?></td>
                        <td><?= $usuario->nombre; ?></td>
                        <td><?= $usuario->apellido; ?></td>
                        <td><?= $usuario->rol_usuario; ?></td>
                        <td><?= $usuario->estado; ?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-inv btn-inv-outline-danger" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Cerrar
        </button>
        <button type="button" class="btn-inv btn-inv-primary" onclick="asignarUsuarioInventario()">
            <i class="fas fa-save"></i> Guardar
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════════════════
     MODAL: PRODUCTOS
══════════════════════════════════════════════════ -->
<div class="modal fade" id="listaproductos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header modal-header-inv">
        <h1 class="modal-title">
            <i class="fas fa-boxes me-2"></i>Asignación de Productos
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row mt-2 g-3">
            <div class="col-md-3">
              <label class="form-label-inv">Código</label>
              <input type="text" class="form-control-inv" id="id_inventario_modal" readonly>
            </div>
            <div class="col-md-3">
              <label class="form-label-inv">Fecha</label>
              <input type="date" class="form-control-inv" id="fecha_inventario_modal"
                value="<?php echo date("Y-m-d") ?>" readonly>
            </div>
            <div class="col-md-3">
              <label class="form-label-inv">Hora</label>
              <input type="time" class="form-control-inv" id="hora_inventario_modal"
                value="<?php echo date('H:i'); ?>" readonly>
            </div>
            <div class="col-md-3">
              <label class="form-label-inv">Usuario</label>
              <input type="text" class="form-control-inv" id="usuario_inventario_modal"
                value="<?php echo session('nombre').' '.session('apellido') ?>" readonly>
            </div>
          </div>
          <div class="row mt-4 g-3">
            <div class="col-md-4">
              <label class="form-label-inv">Subir archivo</label>
              <div class="file-drop-zone" id="fileWrapper">
                <input type="file" id="fileInput" accept=".xlsx,.xls,.xlsm,.xlsb,.xltx,.xltm">
                <div class="file-drop-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                <p style="font-weight:700;color:var(--purple-700);margin-bottom:4px;">Arrastra tu archivo aquí</p>
                <p style="font-size:12px;color:var(--text-muted);">o haz clic para seleccionar</p>
                <small style="font-size:11px;color:var(--text-muted);">XLSX, XLS, XLSM — Máx 30MB</small>
              </div>
              <div class="file-info-bar" id="fileInfo">
                <i class="fas fa-file-excel" style="color:var(--accent-green);font-size:20px;"></i>
                <div style="flex:1;">
                  <strong id="fileName" style="font-size:13px;"></strong>
                  <small id="fileSize" style="display:block;color:var(--text-muted);font-size:11px;"></small>
                </div>
                <button class="btn-edit" id="removeFile" title="Eliminar">
                    <i class="fas fa-trash fa-xs"></i>
                </button>
              </div>
            </div>
            <div class="col-md-8">
              <div class="inv-table-card">
                <div class="inv-table-scroll">
                  <table class="inv-table inv-table-sm" id="resultTable">
                    <thead>
                      <tr>
                        <th>Código</th>
                        <th>Inventario</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Usuario</th>
                        <th>Estado</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-inv btn-inv-outline-danger" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Cerrar
        </button>
        <button type="button" class="btn-inv btn-inv-primary" id="btnObtener">
            <i class="fas fa-save"></i> Guardar
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════════════════
     MODAL: IMPORTAR BD
══════════════════════════════════════════════════ -->
<div class="modal fade" id="exportarexcelmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header modal-header-inv">
        <h1 class="modal-title">
            <i class="fas fa-database me-2"></i>Importar Base de Datos
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <label class="form-label-inv">Seleccione un archivo *</label>
        <form id="formExcel" enctype="multipart/form-data">
          <input type="file" class="form-control-inv" accept=".xls,.xlsx" name="archivo" id="archivo"
            style="cursor:pointer;">
        </form>
      </div>
      <div class="modal-footer">
        <a type="button" class="btn-inv btn-inv-success"
            href="<?= base_url('excel/formato_productos.xlsx') ?>">
            <i class="fas fa-file-excel"></i> Formato Excel
        </a>
        <button type="button" class="btn-inv btn-inv-primary" id="exportardatos">
            <span class="spinner-border spinner-border-sm" id="spinnerexportarproducto" hidden="true"></span>
            <i class="fas fa-file-import"></i> Importar
        </button>
        <button type="button" class="btn-inv btn-inv-outline-danger" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Cerrar
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════════════════
     MODAL: ACTUALIZAR INVENTARIO
══════════════════════════════════════════════════ -->
<div class="modal fade" id="actualizarinventario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header modal-header-inv">
        <h1 class="modal-title">
            <i class="fas fa-edit me-2"></i>Actualizar Inventario
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row mt-3 g-3">
            <div class="col-md-2">
              <label class="form-label-inv">Código inventario *</label>
              <input type="number" id="codigo_actualizar_inventario" class="form-control-inv" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label-inv">Fecha inicial *</label>
              <input type="date" id="fecha_actualizar_inventario" class="form-control-inv">
            </div>
            <div class="col-md-4">
              <label class="form-label-inv">¿Cuántos conteos? *</label>
              <select class="form-control-inv form-select-inv" id="conteos_actualizar_inventario">
                <option value="">Seleccione...</option>
                <option value="1">1 conteo</option>
                <option value="2">2 conteos</option>
              </select>
            </div>
            <div class="col-md-12">
              <label class="form-label-inv">Observación *</label>
              <textarea id="observacion_actualizar_inventario" class="form-control-inv" rows="22"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-inv btn-inv-outline-danger" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Cerrar
        </button>
        <button type="button" class="btn-inv btn-inv-primary" onclick="actualizarInventarios()">
            <i class="fas fa-sync-alt"></i> Actualizar
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════════════════
     MODAL: CREAR UBICACIONES
══════════════════════════════════════════════════ -->
<div class="modal fade" id="modalasgignacionescrear" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header modal-header-inv">
        <h1 class="modal-title">
            <i class="fas fa-map-marker-alt me-2"></i>Creación de Ubicaciones
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-pills nav-pills-inv mb-4 gap-2" id="pills-tab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
              data-bs-target="#pills-home" type="button" role="tab">Ubicación</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
              data-bs-target="#pills-profile" type="button" role="tab">Localización</button>
          </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-home" role="tabpanel">
            <label class="form-label-inv">Descripción</label>
            <input type="text" class="form-control-inv" id="ubicacioncrear" placeholder="Ej: Bodega Principal">
            <button class="btn-inv btn-inv-primary mt-3" onclick="crearUbicacion()">
                <i class="fas fa-save"></i> Guardar
            </button>
          </div>
          <div class="tab-pane fade" id="pills-profile" role="tabpanel">
            <label class="form-label-inv">Descripción</label>
            <input type="text" class="form-control-inv" id="localizacioncrear" placeholder="Ej: Estante A-01">
            <button class="btn-inv btn-inv-success mt-3" onclick="crearLocalizacion()">
                <i class="fas fa-save"></i> Guardar
            </button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-inv btn-inv-outline-danger" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Cerrar
        </button>
      </div>
    </div>
  </div>
</div>

<?php require_once("componentes/scripts.php")?>
<script src="<?= base_url('js/conteos.js') ?>"></script>
<script src="<?= base_url('js/asignacioninventarios.js') ?>"></script>

<script>
/* ── Row counter ── */
document.addEventListener('DOMContentLoaded', () => {
    const tbody = document.querySelector('#mainInventoryTable tbody');
    if(tbody){
        const count = tbody.querySelectorAll('tr').length;
        const badge = document.getElementById('totalRows');
        if(badge) badge.textContent = count;
    }

    /* ── File drag-drop highlight ── */
    const wrapper = document.getElementById('fileWrapper');
    if(wrapper){
        wrapper.addEventListener('dragover', e => { e.preventDefault(); wrapper.classList.add('dragover'); });
        wrapper.addEventListener('dragleave', () => wrapper.classList.remove('dragover'));
        wrapper.addEventListener('drop', e => { e.preventDefault(); wrapper.classList.remove('dragover'); });
    }

    const fileInput = document.getElementById('fileInput');
    const fileInfo  = document.getElementById('fileInfo');
    const fileName  = document.getElementById('fileName');
    const fileSize  = document.getElementById('fileSize');
    const removeBtn = document.getElementById('removeFile');

    if(fileInput && fileInfo){
        fileInput.addEventListener('change', () => {
            const f = fileInput.files[0];
            if(f){
                fileName.textContent = f.name;
                fileSize.textContent = (f.size / 1024 / 1024).toFixed(2) + ' MB';
                fileInfo.classList.add('visible');
            }
        });
        if(removeBtn){
            removeBtn.addEventListener('click', () => {
                fileInput.value = '';
                fileInfo.classList.remove('visible');
            });
        }
    }
});
</script>
</body>
</html>
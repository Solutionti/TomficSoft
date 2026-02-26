<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion - Usuarios</title>
    <?php require_once("componentes/head.php")?>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

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
        body { font-family: 'DM Sans', sans-serif; background: var(--surface-alt); color: var(--text-primary); }
        h1,h2,h3,h4,h5,h6 { font-family: 'Syne', sans-serif; }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f5f0ff; }
        ::-webkit-scrollbar-thumb { background: var(--purple-400); border-radius: 99px; }

        /* ══════════════════════════════════════
           WRAPPER & TOP BAR
        ══════════════════════════════════════ */
        .usr-wrapper { padding: 26px 30px; }

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
            font-family: 'DM Sans', sans-serif;
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
            box-shadow: 0 4px 14px rgba(107,33,184,.35);
        }
        .btn-u-primary:hover { background:linear-gradient(135deg,var(--purple-700),var(--purple-600)); transform:translateY(-1px); box-shadow:0 6px 20px rgba(107,33,184,.45); color:#fff; }

        .btn-u-danger-outline { background:transparent; border:1.5px solid var(--accent-red); color:var(--accent-red); }
        .btn-u-danger-outline:hover { background:var(--accent-red); color:#fff; transform:translateY(-1px); }

        .btn-u-success { background:linear-gradient(135deg,#059669,var(--accent-green)); color:#fff; box-shadow:0 4px 14px rgba(16,185,129,.3); }
        .btn-u-success:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(16,185,129,.4); color:#fff; }

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

        .stat-card:hover { border-color:var(--purple-300); box-shadow:var(--shadow-md); transform:translateY(-3px); }
        .stat-card:nth-child(1) { animation-delay:.05s; }
        .stat-card:nth-child(2) { animation-delay:.10s; }
        .stat-card:nth-child(3) { animation-delay:.15s; }
        .stat-card:nth-child(4) { animation-delay:.20s; }

        .stat-icon {
            width: 44px; height: 44px;
            border-radius: 11px;
            display: flex; align-items:center; justify-content:center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .stat-icon.purple { background:var(--purple-100); color:var(--purple-600); }
        .stat-icon.green  { background:#d1fae5; color:#065f46; }
        .stat-icon.red    { background:#fee2e2; color:#991b1b; }
        .stat-icon.blue   { background:#dbeafe; color:#1e40af; }

        .stat-info .stat-num {
            font-family: 'Syne', sans-serif;
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

        .tbl-search:focus-within { border-color:var(--purple-400); box-shadow:0 0 0 3px rgba(168,85,247,.12); }

        .tbl-search input {
            border: none;
            outline: none;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            color: var(--text-primary);
            background: transparent;
            width: 180px;
        }

        .tbl-search i { color:var(--text-muted); font-size:13px; }

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
            font-family: 'Syne', sans-serif;
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
            from { opacity:0; transform:translateX(-10px); }
            to   { opacity:1; transform:translateX(0); }
        }

        .usr-table tbody tr:nth-child(1)  { animation-delay:.30s; }
        .usr-table tbody tr:nth-child(2)  { animation-delay:.36s; }
        .usr-table tbody tr:nth-child(3)  { animation-delay:.42s; }
        .usr-table tbody tr:nth-child(4)  { animation-delay:.48s; }
        .usr-table tbody tr:nth-child(5)  { animation-delay:.54s; }
        .usr-table tbody tr:nth-child(6)  { animation-delay:.60s; }
        .usr-table tbody tr:nth-child(7)  { animation-delay:.66s; }
        .usr-table tbody tr:nth-child(8)  { animation-delay:.72s; }

        .usr-table tbody tr:nth-child(even) { background:#fdfaff; }
        .usr-table tbody tr:hover { background: linear-gradient(90deg,#f5f0ff,#fdf8ff) !important; }

        .usr-table td { padding: 12px 16px; vertical-align: middle; }

        /* ══════════════════════════════════════
           USER AVATAR CELL
        ══════════════════════════════════════ */
        .user-cell { display:flex; align-items:center; gap:11px; }

        .user-avatar-wrap { position:relative; flex-shrink:0; }

        .user-avatar {
            width: 38px; height: 38px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid var(--purple-200);
            transition: var(--transition);
        }

        .usr-table tbody tr:hover .user-avatar { border-color:var(--purple-400); transform:scale(1.08); }

        .user-status-dot {
            position: absolute;
            bottom: -2px; right: -2px;
            width: 10px; height: 10px;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        .dot-active   { background: var(--accent-green); }
        .dot-inactive { background: #9ca3af; }

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
            content:''; width:5px; height:5px;
            border-radius:50%; background:currentColor; opacity:.75;
        }

        .badge-success-u { background:#d1fae5; color:#065f46; }
        .badge-danger-u  { background:#fee2e2; color:#991b1b; }
        .badge-primary-u { background:var(--purple-100); color:var(--purple-700); }
        .badge-amber-u   { background:#fef3c7; color:#92400e; }

        /* ══════════════════════════════════════
           ACTION BUTTONS
        ══════════════════════════════════════ */
        .action-wrap { display:flex; gap:6px; align-items:center; }

        .btn-action {
            width: 30px; height: 30px;
            border-radius: 8px;
            display: inline-flex; align-items:center; justify-content:center;
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
        .btn-action-edit:hover { background:var(--purple-600); color:#fff; border-color:var(--purple-600); transform:rotate(8deg) scale(1.12); box-shadow:0 4px 12px rgba(107,33,184,.4); }

        .btn-action-del {
            background: #fee2e2;
            color: var(--accent-red);
            border: 1.5px solid #fecaca;
        }
        .btn-action-del:hover { background:var(--accent-red); color:#fff; border-color:var(--accent-red); transform:scale(1.12); box-shadow:0 4px 12px rgba(239,68,68,.35); }

        /* ══════════════════════════════════════
           MODAL SYSTEM
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
            padding: 17px 24px;
            border-bottom: none;
        }

        .modal-header-inv .modal-title {
            font-family: 'Syne', sans-serif;
            font-size: 14.5px;
            font-weight: 700;
            color: #fff;
            letter-spacing: .04em;
        }

        .modal-header-inv .btn-close { filter:invert(1); opacity:.85; }
        .modal-body { background:var(--surface-alt); padding:24px; }
        .modal-footer { background:var(--surface); border-top:1px solid var(--border); padding:14px 24px; }

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
            width: 22px; height: 22px;
            background: var(--purple-100);
            border-radius: 6px;
            display: inline-flex; align-items:center; justify-content:center;
            font-size: 10px;
            color: var(--purple-600);
        }

        /* Form labels and inputs */
        .fl { display:flex; flex-direction:column; gap:4px; }

        .fl label {
            font-size: 10.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--text-muted);
        }

        .fc, .fsel {
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

        .fc:focus, .fsel:focus { border-color:var(--purple-400); box-shadow:0 0 0 3px rgba(168,85,247,.15); }
        .fc[readonly] { background:var(--purple-100); color:var(--purple-700); }

        /* Password input group */
        .pass-group {
            display: flex;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            overflow: hidden;
            transition: var(--transition);
        }

        .pass-group:focus-within { border-color:var(--purple-400); box-shadow:0 0 0 3px rgba(168,85,247,.15); }

        .pass-group input {
            flex: 1;
            padding: 8px 12px;
            border: none;
            font-family: 'DM Sans', sans-serif;
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

        .pass-group .pass-toggle:hover { background:var(--purple-200); }

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
            background: linear-gradient(135deg,var(--purple-800),var(--purple-700));
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

        .perm-table tbody tr { border-bottom:1px solid #f0ebfa; transition:var(--transition); }
        .perm-table tbody tr:nth-child(even) { background:#fdfaff; }
        .perm-table tbody tr:hover { background:linear-gradient(90deg,#f5f0ff,#fdf8ff) !important; }
        .perm-table td { padding:10px 14px; vertical-align:middle; }

        .perm-module {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .perm-icon {
            width: 30px; height: 30px;
            border-radius: 8px;
            background: var(--purple-100);
            display: flex; align-items:center; justify-content:center;
            color: var(--purple-600);
            font-size: 12px;
            flex-shrink: 0;
        }

        .perm-name { font-size:13px; font-weight:600; color:var(--text-primary); }
        .perm-sub  { font-size:11px; color:var(--text-muted); }

        .chk-perm {
            width: 16px; height: 16px;
            accent-color: var(--purple-600);
            cursor: pointer;
        }

        /* ══════════════════════════════════════
           ANIMATIONS
        ══════════════════════════════════════ */
        @keyframes slideUp {
            from { opacity:0; transform:translateY(16px); }
            to   { opacity:1; transform:translateY(0); }
        }

        .anim-1 { animation: slideUp .35s ease .04s both; }
        .anim-2 { animation: slideUp .35s ease .10s both; }
        .anim-3 { animation: slideUp .35s ease .18s both; }

        .color-morado { background:linear-gradient(135deg,var(--purple-800),var(--purple-700)) !important; }

        @media (max-width:768px) {
            .usr-wrapper { padding:14px; }
            .usr-title { font-size:20px; }
            .tbl-search { display:none; }
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
                <div class="usr-wrapper">

                    <!-- ══════════ TOP BAR ══════════ -->
                    <div class="usr-topbar anim-1">
                        <div>
                            <p class="usr-breadcrumb">Administración &rsaquo; InventSoft</p>
                            <h1 class="">Gestión de Usuarios</h1>
                        </div>
                        <button class="btn-u btn-u-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            <i class="fas fa-user-plus"></i> Agregar Usuario
                        </button>
                    </div>

                    <!-- ══════════ STATS STRIP ══════════ -->
                    <div class="usr-stats anim-2">
                        <div class="stat-card">
                            <div class="stat-icon purple"><i class="fas fa-users"></i></div>
                            <div class="stat-info">
                                <div class="stat-num" id="statTotal">0</div>
                                <div class="stat-label">Total usuarios</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon green"><i class="fas fa-user-check"></i></div>
                            <div class="stat-info">
                                <div class="stat-num" id="statActive">0</div>
                                <div class="stat-label">Activos</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon red"><i class="fas fa-user-times"></i></div>
                            <div class="stat-info">
                                <div class="stat-num" id="statInactive">0</div>
                                <div class="stat-label">Inactivos</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon blue"><i class="fas fa-user-shield"></i></div>
                            <div class="stat-info">
                                <div class="stat-num" id="statAdmin">0</div>
                                <div class="stat-label">Administradores</div>
                            </div>
                        </div>
                    </div>

                    <!-- ══════════ TABLE CARD ══════════ -->
                    <div class="usr-table-card anim-3">
                        <div class="usr-table-header">
                            <h5>
                                <i class="fas fa-list-ul"></i>
                                Usuarios registrados
                                <span class="count-pill" id="countPill">—</span>
                            </h5>
                            <div class="tbl-search">
                                <i class="fas fa-search"></i>
                                <input type="text" id="searchInput" placeholder="Buscar usuario…">
                            </div>
                        </div>
                        <div style="overflow-x:auto;">
                            <table class="usr-table" id="table_usuarios">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Nombre completo</th>
                                        <th>Empresa</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Rol</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($usuarios->getResult() as $usuario) { ?>
                                    <tr>
                                        <td>
                                            <div class="action-wrap">
                                                <button class="btn-action btn-action-edit"
                                                    onclick="mostrarDatosUsuarioModal(<?= $usuario->codigo_usuario; ?>)"
                                                    title="Editar usuario">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                                <button class="btn-action btn-action-del"
                                                    onclick="eliminarUsuario('<?= $usuario->codigo_usuario; ?>')"
                                                    title="Eliminar usuario">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="user-cell">
                                                <div class="user-avatar-wrap">
                                                    <img src="<?= base_url('img/team-41.jpg') ?>" class="user-avatar">
                                                    <span class="user-status-dot <?= $usuario->estado == 'Activo' ? 'dot-active' : 'dot-inactive' ?>"></span>
                                                </div>
                                                <div>
                                                    <div class="user-name"><?= $usuario->nombre.' '.$usuario->apellido; ?></div>
                                                    <div class="user-sub"><?= $usuario->documento.' · '.$usuario->usuario; ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= $usuario->empresa; ?></td>
                                        <td style="font-size:12px;"><?= $usuario->email; ?></td>
                                        <td><?= $usuario->telefono; ?></td>
                                        <td>
                                            <?php
                                                $rol = $usuario->rol_usuario;
                                                $rolClass = 'badge-primary-u';
                                                if($rol == 'Administrador') $rolClass = 'badge-amber-u';
                                                elseif($rol == 'Vendedor') $rolClass = 'badge-success-u';
                                            ?>
                                            <span class="badge-u <?= $rolClass ?>"><?= $rol; ?></span>
                                        </td>
                                        <td>
                                            <?php if($usuario->estado == 'Activo') { ?>
                                                <span class="badge-u badge-success-u"><?= $usuario->estado; ?></span>
                                            <?php } else { ?>
                                                <span class="badge-u badge-danger-u"><?= $usuario->estado; ?></span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div><!-- /usr-wrapper -->
            </div>
        </div>
    </div>
</div>

<?php require_once("componentes/footer.php")?>

<!-- ══════════════════════════════════════════════
     MODAL: CREAR USUARIO
══════════════════════════════════════════════ -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header modal-header-inv">
        <h1 class="modal-title"><i class="fas fa-user-plus me-2"></i>Crear Usuario y Permisos</h1>
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
                <input type="number" id="documento_usuario" class="fc" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="fl">
                <label>Nombre *</label>
                <input type="text" id="nombre_usuario" class="fc" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="fl">
                <label>Apellido *</label>
                <input type="text" id="apellido_usuario" class="fc" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="fl">
                <label>Empresa *</label>
                <select class="fc fsel text-uppercase" id="empresa_usuario" required>
                  <option value="">Seleccione la empresa</option>
                  <?php foreach($empresas->getResult() as $empresa) { ?>
                    <option value="<?= $empresa->nit ?>"><?= $empresa->nombre; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="fl">
                <label>Teléfono *</label>
                <input type="number" id="telefono_usuario" class="fc" required>
              </div>
            </div>
            <div class="col-md-4">
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
                <label>Correo electrónico *</label>
                <input type="email" id="correo" class="fc">
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
                <select class="fc fsel" id="rol_usuario">
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
                <input type="date" id="fecha_usuario" class="fc" value="<?php echo date('Y-m-d') ?>" readonly>
              </div>
            </div>
            <div class="col-md-4">
              <div class="fl">
                <label>Hora</label>
                <input type="time" id="hora_usuario" class="fc" value="<?= date('H:i') ?>" readonly>
              </div>
            </div>
            <div class="col-md-4">
              <div class="fl">
                <label>Usuario *</label>
                <input type="text" id="usuario_usuario" class="fc">
              </div>
            </div>
            <div class="col-md-4">
              <div class="fl">
                <label>Contraseña *</label>
                <div class="pass-group">
                  <input type="password" id="password_usuario" placeholder="Ingresa contraseña"
                    class="js-toggle-password">
                  <button type="button" class="pass-toggle" id="changePassIcon"
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
                  <input type="password" id="repetir_password_usuario" placeholder="Confirma contraseña"
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
            <table class="perm-table">
              <thead>
                <tr>
                  <th>
                    <input class="chk-perm" type="checkbox" id="selectAll" title="Seleccionar todos">
                  </th>
                  <th>Código</th>
                  <th>Módulo</th>
                  <th>Link</th>
                  <th>Estado</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($permisos->getResult() as $permiso){ ?>
                <tr>
                  <td>
                    <input class="chk-perm fila2" type="checkbox" value="<?= $permiso->codigo_permiso; ?>">
                  </td>
                  <td>
                    <span style="font-family:'Syne',sans-serif;font-weight:700;color:var(--purple-600);">
                        #<?= $permiso->codigo_permiso; ?>
                    </span>
                  </td>
                  <td>
                    <div class="perm-module">
                      <div class="perm-icon"><i class="fas fa-puzzle-piece"></i></div>
                      <div>
                        <div class="perm-name">Módulo de <?= $permiso->nombre; ?></div>
                        <div class="perm-sub">Permiso de usuario</div>
                      </div>
                    </div>
                  </td>
                  <td style="font-size:12px;color:var(--text-muted);"><?= $permiso->url; ?></td>
                  <td><span class="badge-u badge-success-u"><?= $permiso->estado; ?></span></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn-u btn-u-danger-outline" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Cerrar
        </button>
        <button type="button" class="btn-u btn-u-primary" onclick="crearUsuarios()">
            <i class="fas fa-save"></i> Guardar usuario
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════════════
     MODAL: ACTUALIZAR USUARIO
══════════════════════════════════════════════ -->
<div class="modal fade" id="actualizarUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
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
                <select class="fc fsel text-uppercase" id="empresa_usuario_actualizar" required>
                  <option value="">Seleccione la empresa</option>
                  <?php foreach($empresas->getResult() as $empresa) { ?>
                    <option value="<?= $empresa->nit ?>"><?= $empresa->nombre; ?></option>
                  <?php } ?>
                </select>
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
                <input type="date" id="fecha_usuario_actualizar" class="fc" value="<?php echo date('Y-m-d') ?>" readonly>
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
            <table class="perm-table">
              <thead>
                <tr>
                  <th>
                    <input class="chk-perm" type="checkbox" id="selectAllUpdate" title="Seleccionar todos">
                  </th>
                  <th>Código</th>
                  <th>Módulo</th>
                  <th>Link</th>
                  <th>Estado</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($permisos->getResult() as $permiso){ ?>
                <tr>
                  <td>
                    <input class="chk-perm fila" type="checkbox" value="<?= $permiso->codigo_permiso; ?>">
                  </td>
                  <td>
                    <span style="font-family:'Syne',sans-serif;font-weight:700;color:var(--purple-600);">
                        #<?= $permiso->codigo_permiso; ?>
                    </span>
                  </td>
                  <td>
                    <div class="perm-module">
                      <div class="perm-icon"><i class="fas fa-puzzle-piece"></i></div>
                      <div>
                        <div class="perm-name">Módulo de <?= $permiso->nombre; ?></div>
                        <div class="perm-sub">Permiso de usuario</div>
                      </div>
                    </div>
                  </td>
                  <td style="font-size:12px;color:var(--text-muted);"><?= $permiso->url; ?></td>
                  <td><span class="badge-u badge-success-u"><?= $permiso->estado; ?></span></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
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

<?php require_once("componentes/scripts.php")?>
<script src="<?= base_url('js/usuarios.js') ?>"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tbody = document.querySelector('#table_usuarios tbody');
    if (!tbody) return;

    const rows = Array.from(tbody.querySelectorAll('tr'));
    const total    = rows.length;
    let active = 0, inactive = 0, admins = 0;

    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        // Estado = last td (index 7), Rol = index 6
        const estadoTxt = row.querySelector('.badge-u') ? row.querySelectorAll('.badge-u') : [];
        const tds = row.querySelectorAll('td');
        if (tds.length >= 8) {
            const estadoCell = tds[7].textContent.trim();
            const rolCell    = tds[6].textContent.trim();
            if (estadoCell.toLowerCase().includes('activo')) active++;
            else inactive++;
            if (rolCell.toLowerCase().includes('admin')) admins++;
        }
    });

    document.getElementById('statTotal').textContent    = total;
    document.getElementById('statActive').textContent   = active;
    document.getElementById('statInactive').textContent = inactive;
    document.getElementById('statAdmin').textContent    = admins;
    document.getElementById('countPill').textContent    = total;

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
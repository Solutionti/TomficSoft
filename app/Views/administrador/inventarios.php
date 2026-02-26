<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion - Inventarios</title>
    <?php require_once("componentes/head.php")?>
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
           WRAPPER & TOPBAR
        ══════════════════════════════════════ */
        .inv-wrapper { padding:26px 30px; }

        .inv-topbar {
            display:flex; align-items:center; justify-content:space-between;
            flex-wrap:wrap; gap:14px; margin-bottom:24px;
        }

        .inv-breadcrumb {
            font-size:11px; font-weight:600; letter-spacing:.08em;
            text-transform:uppercase; color:var(--purple-400); margin-bottom:3px;
        }

        .inv-title { font-size:25px; font-weight:800; color:var(--purple-800); }

        .inv-actions { display:flex; gap:9px; flex-wrap:wrap; }

        /* ══════════════════════════════════════
           BUTTONS
        ══════════════════════════════════════ */
        .btn-i {
            display:inline-flex; align-items:center; gap:7px;
            padding:9px 18px; border-radius:50px;
            font-family:'DM Sans',sans-serif; font-size:13px; font-weight:600;
            cursor:pointer; border:none;
            transition:all .25s var(--ease); white-space:nowrap; text-decoration:none;
        }

        .btn-i-primary {
            background:linear-gradient(135deg,var(--purple-600),var(--purple-500));
            color:#fff; box-shadow:0 4px 14px rgba(107,33,184,.35);
        }
        .btn-i-primary:hover { background:linear-gradient(135deg,var(--purple-700),var(--purple-600)); transform:translateY(-1px); box-shadow:0 6px 20px rgba(107,33,184,.45); color:#fff; }

        .btn-i-outline {
            background:#fff; border:1.5px solid var(--purple-300); color:var(--purple-700);
        }
        .btn-i-outline:hover { background:var(--purple-100); border-color:var(--purple-500); transform:translateY(-1px); }

        .btn-i-success-outline {
            background:#fff; border:1.5px solid #6ee7b7; color:var(--green-dark);
        }
        .btn-i-success-outline:hover { background:var(--green-light); border-color:var(--green); transform:translateY(-1px); }

        .btn-i-danger-outline {
            background:#fff; border:1.5px solid #fca5a5; color:var(--red-dark);
        }
        .btn-i-danger-outline:hover { background:var(--red-light); border-color:var(--red); transform:translateY(-1px); }

        .btn-i-danger { background:var(--red); color:#fff; }
        .btn-i-danger:hover { background:#dc2626; transform:translateY(-1px); color:#fff; }

        /* ══════════════════════════════════════
           STATS STRIP
        ══════════════════════════════════════ */
        .inv-stats {
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(160px,1fr));
            gap:13px; margin-bottom:22px;
        }

        .stat-card {
            background:var(--surface); border:1px solid var(--border);
            border-radius:var(--radius); padding:15px 18px;
            display:flex; align-items:center; gap:13px;
            box-shadow:var(--shadow-sm); transition:all .3s var(--ease);
            animation:slideUp .4s ease both;
        }
        .stat-card:hover { border-color:var(--purple-300); box-shadow:var(--shadow-md); transform:translateY(-3px); }
        .stat-card:nth-child(1){animation-delay:.05s;}
        .stat-card:nth-child(2){animation-delay:.10s;}
        .stat-card:nth-child(3){animation-delay:.15s;}
        .stat-card:nth-child(4){animation-delay:.20s;}

        .stat-icon {
            width:42px; height:42px; border-radius:10px;
            display:flex; align-items:center; justify-content:center;
            font-size:17px; flex-shrink:0;
        }
        .si-purple{background:var(--purple-100);color:var(--purple-600);}
        .si-green {background:var(--green-light);color:var(--green-dark);}
        .si-amber {background:#fef3c7;color:#92400e;}
        .si-blue  {background:#dbeafe;color:#1e40af;}

        . {
            font-family:'Syne',sans-serif; font-size:22px;
            font-weight:800; color:var(--purple-800); line-height:1;
        }
        .stat-lbl {
            font-size:10.5px; font-weight:600; text-transform:uppercase;
            letter-spacing:.06em; color:var(--muted); margin-top:3px;
        }

        /* ══════════════════════════════════════
           TABLE CARD
        ══════════════════════════════════════ */
        .inv-table-card {
            background:var(--surface); border:1px solid var(--border);
            border-radius:var(--radius); box-shadow:var(--shadow-sm);
            overflow:hidden; animation:slideUp .4s ease .24s both;
        }

        .inv-table-header {
            padding:14px 20px; border-bottom:1px solid var(--border);
            background:linear-gradient(90deg,var(--purple-100),#fdf8ff);
            display:flex; align-items:center; justify-content:space-between;
            flex-wrap:wrap; gap:10px;
        }

        .inv-table-header h5 {
            font-size:13.5px; font-weight:700; color:var(--purple-800);
            display:flex; align-items:center; gap:8px; margin:0;
        }

        .count-pill {
            background:var(--purple-600); color:#fff;
            font-size:11px; font-weight:700;
            padding:2px 9px; border-radius:50px;
        }

        .tbl-search {
            display:flex; align-items:center; gap:8px;
            background:#fff; border:1.5px solid var(--border);
            border-radius:50px; padding:6px 14px;
            transition:all .25s var(--ease);
        }
        .tbl-search:focus-within { border-color:var(--purple-400); box-shadow:0 0 0 3px rgba(168,85,247,.12); }
        .tbl-search input { border:none; outline:none; font-family:'DM Sans',sans-serif; font-size:13px; color:var(--text); background:transparent; width:180px; }
        .tbl-search i { color:var(--muted); font-size:13px; }

        /* ══════════════════════════════════════
           TABLE
        ══════════════════════════════════════ */
        .inv-table {
            width:100%; border-collapse:separate; border-spacing:0; font-size:13px;
        }

        .inv-table thead th {
            background:linear-gradient(135deg,var(--purple-800),var(--purple-700));
            color:#fff; padding:12px 16px; text-align:left;
            font-family:'Syne',sans-serif; font-size:10.5px; font-weight:700;
            letter-spacing:.06em; text-transform:uppercase; white-space:nowrap;
        }

        .inv-table tbody tr {
            border-bottom:1px solid #f0ebfa;
            transition:all .25s var(--ease);
            animation:rowIn .35s ease both; opacity:0;
        }

        @keyframes rowIn {
            from{opacity:0;transform:translateX(-10px);}
            to  {opacity:1;transform:translateX(0);}
        }

        .inv-table tbody tr:nth-child(1){animation-delay:.28s;}
        .inv-table tbody tr:nth-child(2){animation-delay:.34s;}
        .inv-table tbody tr:nth-child(3){animation-delay:.40s;}
        .inv-table tbody tr:nth-child(4){animation-delay:.46s;}
        .inv-table tbody tr:nth-child(5){animation-delay:.52s;}
        .inv-table tbody tr:nth-child(6){animation-delay:.58s;}
        .inv-table tbody tr:nth-child(7){animation-delay:.64s;}
        .inv-table tbody tr:nth-child(8){animation-delay:.70s;}

        .inv-table tbody tr:nth-child(even){background:#fdfaff;}
        .inv-table tbody tr:hover{background:linear-gradient(90deg,#f5f0ff,#fdf8ff) !important;}
        .inv-table td { padding:11px 16px; vertical-align:middle; }

        /* Stock pill */
        .stock-pill {
            display:inline-flex; align-items:center; gap:5px;
            padding:4px 11px; border-radius:50px;
            font-family:'Syne',sans-serif; font-size:12px; font-weight:700;
        }
        .stock-ok   {background:var(--green-light);color:var(--green-dark);}
        .stock-low  {background:#fef3c7;color:#92400e;}
        .stock-zero {background:var(--red-light);color:var(--red-dark);}

        /* Cost cell */
        .cost-cell {
            font-family:'Syne',sans-serif; font-size:13px;
            font-weight:700; color:var(--purple-600);
        }

        /* Barcode cell */
        .barcode-cell {
            font-size:11.5px; color:var(--muted);
            font-family:monospace; letter-spacing:.04em;
        }

        /* Action buttons */
        .action-wrap { display:flex; gap:6px; }
        .btn-act {
            width:30px; height:30px; border-radius:8px;
            display:inline-flex; align-items:center; justify-content:center;
            border:none; cursor:pointer; font-size:12px;
            transition:all .22s var(--ease);
        }
        .btn-act-edit {background:var(--purple-100);color:var(--purple-600);border:1.5px solid var(--purple-200);}
        .btn-act-edit:hover {background:var(--purple-600);color:#fff;border-color:var(--purple-600);transform:rotate(8deg) scale(1.12);box-shadow:0 4px 12px rgba(107,33,184,.4);}
        .btn-act-del  {background:var(--red-light);color:var(--red-dark);border:1.5px solid #fca5a5;}
        .btn-act-del:hover  {background:var(--red);color:#fff;border-color:var(--red);transform:scale(1.12);box-shadow:0 4px 12px rgba(239,68,68,.35);}

        /* ══════════════════════════════════════
           MODAL SYSTEM
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
        .modal-header-inv.green-header { background:linear-gradient(135deg,#065f46,#059669) !important; }
        .modal-header-inv.red-header   { background:linear-gradient(135deg,#991b1b,var(--red)) !important; }

        .modal-header-inv .modal-title {
            font-family:'Syne',sans-serif; font-size:14.5px;
            font-weight:700; color:#fff; letter-spacing:.04em;
        }
        .modal-header-inv .btn-close { filter:invert(1); opacity:.85; }
        .modal-body { background:var(--surface-alt); padding:22px; }
        .modal-footer { background:var(--surface); border-top:1px solid var(--border); padding:12px 22px; }

        /* Form section */
        .form-section {
            background:var(--surface); border:1px solid var(--border);
            border-radius:var(--radius); padding:18px 20px;
            margin-bottom:16px; box-shadow:var(--shadow-sm);
        }

        .form-section-title {
            font-size:11px; font-weight:700; text-transform:uppercase;
            letter-spacing:.08em; color:var(--purple-600);
            display:flex; align-items:center; gap:7px;
            margin-bottom:14px; padding-bottom:10px;
            border-bottom:1px solid var(--border);
        }
        .form-section-title i {
            width:22px; height:22px; background:var(--purple-100);
            border-radius:6px; display:inline-flex; align-items:center;
            justify-content:center; font-size:10px; color:var(--purple-600);
        }
        .form-section-title.green-title { color:var(--green-dark); }
        .form-section-title.green-title i { background:var(--green-light); color:var(--green-dark); }
        .form-section-title.red-title   { color:var(--red-dark); }
        .form-section-title.red-title i { background:var(--red-light); color:var(--red-dark); }

        .fl { display:flex; flex-direction:column; gap:4px; }
        .fl label {
            font-size:10.5px; font-weight:600; text-transform:uppercase;
            letter-spacing:.06em; color:var(--muted);
        }
        .fl label.req { color:var(--red-dark); }

        .fc, .fsel {
            width:100%; padding:8px 12px;
            border:1.5px solid var(--border); border-radius:var(--radius-sm);
            font-family:'DM Sans',sans-serif; font-size:13px; color:var(--text);
            background:var(--surface); transition:all .25s var(--ease);
            outline:none; appearance:none;
        }
        .fc:focus,.fsel:focus { border-color:var(--purple-400); box-shadow:0 0 0 3px rgba(168,85,247,.15); }
        .fc[readonly] { background:var(--purple-100); color:var(--purple-700); cursor:default; }

        textarea.fc { resize:vertical; min-height:100px; }

        /* Entry/exit indicator bar */
        .movement-indicator {
            display:flex; align-items:center; gap:10px;
            padding:11px 16px; border-radius:var(--radius-sm);
            margin-bottom:16px; font-size:13px; font-weight:600;
        }
        .mi-entry { background:var(--green-light); color:var(--green-dark); border:1.5px solid #6ee7b7; }
        .mi-exit  { background:var(--red-light);   color:var(--red-dark);   border:1.5px solid #fca5a5; }

        /* ══════════════════════════════════════
           ANIMATIONS
        ══════════════════════════════════════ */
        @keyframes slideUp {
            from{opacity:0;transform:translateY(16px);}
            to  {opacity:1;transform:translateY(0);}
        }

        .anim-1{animation:slideUp .35s ease .04s both;}
        .anim-2{animation:slideUp .35s ease .10s both;}
        .anim-3{animation:slideUp .35s ease .18s both;}

        .color-morado{background:linear-gradient(135deg,var(--purple-800),var(--purple-700)) !important;}

        @media (max-width:768px){
            .inv-wrapper{padding:14px;}
            .inv-title{font-size:20px;}
            .tbl-search{display:none;}
            .inv-actions .btn-i span.label{display:none;}
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

                    <!-- ══════════ TOP BAR ══════════ -->
                    <div class="inv-topbar anim-1">
                        <div>
                            <p class="inv-breadcrumb">Administración &rsaquo; InventSoft</p>
                            <h1 class="">Gestión de Productos</h1>
                        </div>
                        <div class="inv-actions">
                            <button class="btn-i btn-i-outline" onclick="ajustarInventario()">
                                <i class="fas fa-balance-scale"></i>
                                <span class="label">Ajustar</span>
                            </button>
                            <button class="btn-i btn-i-primary" data-bs-toggle="modal" data-bs-target="#agregarProducto">
                                <i class="fas fa-plus-circle"></i>
                                <span class="label">Agregar Producto</span>
                            </button>
                            <button class="btn-i btn-i-success-outline" data-bs-toggle="modal" data-bs-target="#ingresoProducto">
                                <i class="fas fa-arrow-down"></i>
                                <span class="label">Entrada</span>
                            </button>
                            <button class="btn-i btn-i-danger-outline" data-bs-toggle="modal" data-bs-target="#salidaProducto">
                                <i class="fas fa-arrow-up"></i>
                                <span class="label">Salida</span>
                            </button>
                        </div>
                    </div>

                    <!-- ══════════ STATS STRIP ══════════ -->
                    <div class="inv-stats anim-2">
                        <div class="stat-card">
                            <div class="stat-icon si-purple"><i class="fas fa-boxes"></i></div>
                            <div>
                                <div class="" id="statTotal">0</div>
                                <div class="stat-lbl">Total productos</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon si-green"><i class="fas fa-check-circle"></i></div>
                            <div>
                                <div class="" id="statStock">0</div>
                                <div class="stat-lbl">Con stock</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon si-amber"><i class="fas fa-exclamation-triangle"></i></div>
                            <div>
                                <div class="" id="statLow">0</div>
                                <div class="stat-lbl">Stock bajo</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon si-blue"><i class="fas fa-tag"></i></div>
                            <div>
                                <div class="" id="statZero">0</div>
                                <div class="stat-lbl">Sin stock</div>
                            </div>
                        </div>
                    </div>

                    <!-- ══════════ TABLE CARD ══════════ -->
                    <div class="inv-table-card anim-3">
                        <div class="inv-table-header">
                            <h5>
                                <i class="fas fa-list-ul"></i>
                                Productos en inventario
                                <span class="count-pill" id="countPill">—</span>
                            </h5>
                            <div class="tbl-search">
                                <i class="fas fa-search"></i>
                                <input type="text" id="searchInput" placeholder="Buscar producto, proveedor…">
                            </div>
                        </div>
                        <div style="overflow-x:auto;">
                            <table class="inv-table" id="tabla_inventarios">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Código de barras</th>
                                        <th>Nombre</th>
                                        <th>Proveedor</th>
                                        <th>Categoría</th>
                                        <th>Subcategoría</th>
                                        <th>Stock</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($productos->getResult() as $producto) { ?>
                                    <tr>
                                        <td>
                                            <div class="action-wrap">
                                                <button class="btn-act btn-act-edit"
                                                    onclick="mostrarDatosProductosModal(<?= $producto->codigo_producto; ?>)"
                                                    title="Editar producto">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                                <button class="btn-act btn-act-del"
                                                    onclick="eliminarProducto(<?= $producto->codigo_producto; ?>)"
                                                    title="Eliminar producto">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="barcode-cell"><?= $producto->codigo_barras; ?></td>
                                        <td>
                                            <span style="font-weight:600;color:var(--text);"><?= $producto->nombre; ?></span>
                                        </td>
                                        <td style="font-size:12px;color:var(--muted);"><?= $producto->proveedor; ?></td>
                                        <td>
                                            <span style="font-size:12px;background:var(--purple-100);color:var(--purple-700);padding:3px 10px;border-radius:50px;font-weight:600;font-size:11px;">
                                                <?= $producto->categoria; ?>
                                            </span>
                                        </td>
                                        <td style="font-size:12px;color:var(--muted);"><?= $producto->subcategoria; ?></td>
                                        <td>
                                            <?php
                                                $s = (int)$producto->saldo;
                                                $cls = $s > 10 ? 'stock-ok' : ($s > 0 ? 'stock-low' : 'stock-zero');
                                            ?>
                                            <span class="stock-pill <?= $cls ?>"><?= $producto->saldo; ?></span>
                                        </td>
                                        <td class="cost-cell">$<?= number_format($producto->costo, 0, ',', '.'); ?></td>
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
<!-- ══════════════════════════════════════
     MODAL: AGREGAR PRODUCTO
══════════════════════════════════════ -->
<div class="modal fade" id="agregarProducto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header modal-header-inv">
        <h1 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Agregar Producto</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <!-- Clasificación -->
        <div class="form-section">
          <div class="form-section-title"><i class="fas fa-tags"></i>Clasificación del producto</div>
          <div class="row g-3">
            <div class="col-md-3">
              <div class="fl"><label class="req">Categoría *</label>
                <select class="fc fsel text-uppercase" id="categoria_inventario" required>
                  <option value="">Seleccione categoría</option>
                  <?php foreach($categorias->getResult() as $categoria) { ?>
                    <option value="<?= $categoria->codigo_categoria ?>"><?= $categoria->nombre; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="fl"><label>Subcategoría *</label><input type="text" id="subcategoria_inventario" class="fc" required></div>
            </div>
            <div class="col-md-2">
              <div class="fl"><label>Grupo *</label><input type="text" id="grupo_inventario" class="fc" required></div>
            </div>
            <div class="col-md-2">
              <div class="fl"><label>Subgrupo *</label><input type="text" id="subgrupo_inventario" class="fc" required></div>
            </div>
            <div class="col-md-2">
              <div class="fl"><label>Merma *</label><input type="text" id="merma_inventario" class="fc" required></div>
            </div>
          </div>
        </div>

        <!-- Identificación -->
        <div class="form-section">
          <div class="form-section-title"><i class="fas fa-barcode"></i>Identificación del producto</div>
          <div class="row g-3">
            <div class="col-md-3">
              <div class="fl"><label>Nombre *</label><input type="text" id="nombre_inventario" class="fc" required></div>
            </div>
            <div class="col-md-3">
              <div class="fl"><label>Referencia *</label><input type="text" id="referencia_inventario" class="fc" required></div>
            </div>
            <div class="col-md-3">
              <div class="fl"><label>Código interno *</label><input type="number" id="codigo_inventario" class="fc" required></div>
            </div>
            <div class="col-md-3">
              <div class="fl"><label>Código de barras *</label><input type="number" id="barras_inventario" class="fc"></div>
            </div>
          </div>
        </div>

        <!-- Proveedor y valores -->
        <div class="form-section">
          <div class="form-section-title"><i class="fas fa-truck"></i>Proveedor y valores</div>
          <div class="row g-3">
            <div class="col-md-3">
              <div class="fl"><label>NIT *</label><input type="number" id="nit_inventario" class="fc"></div>
            </div>
            <div class="col-md-3">
              <div class="fl"><label>Proveedor *</label><input type="text" id="proveedor_inventario" class="fc" required></div>
            </div>
            <div class="col-md-3">
              <div class="fl"><label>Saldo</label><input type="number" id="saldo_inventario" class="fc"></div>
            </div>
            <div class="col-md-3">
              <div class="fl"><label>Costo</label><input type="number" id="costo_inventario" class="fc"></div>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn-i btn-i-danger-outline" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
        <button type="button" class="btn-i btn-i-primary" onclick="agregarProductos()" data-bs-dismiss="modal"><i class="fas fa-save"></i> Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════
     MODAL: INGRESO DE PRODUCTOS (ENTRADA)
══════════════════════════════════════ -->
<div class="modal fade" id="ingresoProducto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header modal-header-inv green-header">
        <h1 class="modal-title"><i class="fas fa-arrow-down me-2"></i>Ingreso de Productos — Entrada</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="movement-indicator mi-entry">
            <i class="fas fa-arrow-circle-down"></i>
            Estás registrando una <strong>&nbsp;ENTRADA&nbsp;</strong> de productos al inventario
        </div>

        <!-- Búsqueda del producto -->
        <div class="form-section">
          <div class="form-section-title green-title"><i class="fas fa-search"></i>Búsqueda del producto</div>
          <div class="row g-3">
            <div class="col-md-5">
              <div class="fl"><label class="req">Código / Nombre del producto *</label>
                <input type="text" class="fc" id="producto_ingreso" required>
              </div>
            </div>
            <div class="col-md-2">
              <div class="fl"><label>Cantidad *</label><input type="number" class="fc" id="cantidad_ingreso" required></div>
            </div>
            <div class="col-md-3">
              <div class="fl"><label>Precio producto</label><input type="number" class="fc" id="precio_ingreso" readonly></div>
            </div>
            <div class="col-md-2">
              <div class="fl"><label>Stock actual</label><input type="number" class="fc" id="stock_ingreso" readonly></div>
            </div>
          </div>
        </div>

        <!-- Detalle del producto -->
        <div class="form-section">
          <div class="form-section-title green-title"><i class="fas fa-box"></i>Detalle del producto</div>
          <div class="row g-3">
            <div class="col-md-8">
              <div class="fl"><label>Nombre producto</label><input type="text" class="fc" id="nombre_ingreso" readonly></div>
            </div>
            <div class="col-md-4">
              <div class="fl"><label>Valor compra</label><input type="number" class="fc" id="valor_ingreso" readonly></div>
            </div>
            <div class="col-md-6">
              <div class="fl"><label>Sede principal *</label>
                <select class="fc fsel text-uppercase" id="sede_ingreso">
                  <option value="">Seleccione sede</option>
                  <?php foreach($empresas->getResult() as $empresa) { ?>
                    <option value="<?= $empresa->nit ?>"><?= $empresa->nombre; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="fl"><label>Motivo de ingreso *</label>
                <select class="fc fsel" id="motivo_ingreso">
                  <option value="">Seleccione motivo</option>
                  <option value="Compra de insumos">Compra de insumos</option>
                  <option value="Regalo empresarial">Regalo empresarial</option>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="fl"><label>Comentarios</label>
                <textarea class="fc" id="comentarios_ingreso" rows="5" placeholder="Descripción adicional…"></textarea>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn-i btn-i-danger-outline" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
        <button type="button" class="btn-i btn-i-primary" onclick="ingresarEntradaProductos()" style="background:linear-gradient(135deg,#065f46,var(--green));box-shadow:0 4px 14px rgba(16,185,129,.35);">
            <i class="fas fa-save"></i> Registrar entrada
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════
     MODAL: SALIDA DE PRODUCTOS
══════════════════════════════════════ -->
<div class="modal fade" id="salidaProducto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header modal-header-inv red-header">
        <h1 class="modal-title"><i class="fas fa-arrow-up me-2"></i>Salida de Productos</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="movement-indicator mi-exit">
            <i class="fas fa-arrow-circle-up"></i>
            Estás registrando una <strong>&nbsp;SALIDA&nbsp;</strong> de productos del inventario
        </div>

        <!-- Búsqueda del producto -->
        <div class="form-section">
          <div class="form-section-title red-title"><i class="fas fa-search"></i>Búsqueda del producto</div>
          <div class="row g-3">
            <div class="col-md-5">
              <div class="fl"><label class="req">Código / Nombre del producto *</label>
                <input type="text" class="fc" id="producto_salida" required>
              </div>
            </div>
            <div class="col-md-2">
              <div class="fl"><label>Cantidad *</label><input type="number" class="fc" id="cantidad_salida" required></div>
            </div>
            <div class="col-md-3">
              <div class="fl"><label>Precio producto *</label><input type="number" class="fc" id="precio_salida" required></div>
            </div>
            <div class="col-md-2">
              <div class="fl"><label>Stock *</label><input type="number" class="fc" id="stock_salida" required></div>
            </div>
          </div>
        </div>

        <!-- Detalle -->
        <div class="form-section">
          <div class="form-section-title red-title"><i class="fas fa-box-open"></i>Detalle del movimiento</div>
          <div class="row g-3">
            <div class="col-md-8">
              <div class="fl"><label>Nombre producto</label><input type="text" class="fc" id="nombre_salida"></div>
            </div>
            <div class="col-md-4">
              <div class="fl"><label>Valor compra</label><input type="number" class="fc" id="valor_salida"></div>
            </div>
            <div class="col-md-6">
              <div class="fl"><label>Sede principal</label>
                <select class="fc fsel text-uppercase" id="sede_salida" required>
                  <option value="">Seleccione sede</option>
                  <?php foreach($empresas->getResult() as $empresa) { ?>
                    <option value="<?= $empresa->nit ?>"><?= $empresa->nombre; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="fl"><label>Motivo de salida</label>
                <select class="fc fsel" id="motivo_salida">
                  <option value="">Seleccione motivo</option>
                  <option value="Consumo interno">Consumo interno</option>
                  <option value="Producto en mal estado (vencido)">Producto en mal estado (vencido)</option>
                  <option value="Prestamo a otras sedes">Préstamo a otras sedes</option>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="fl"><label>Comentarios</label>
                <textarea class="fc" id="comentarios_salida" rows="5" placeholder="Descripción adicional…"></textarea>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn-i btn-i-danger-outline" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
        <button type="button" class="btn-i btn-i-danger" onclick="ingresarSalidaProductos()">
            <i class="fas fa-save"></i> Registrar salida
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════
     MODAL: ACTUALIZAR PRODUCTO
══════════════════════════════════════ -->
<div class="modal fade" id="actualizarProducto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header modal-header-inv">
        <h1 class="modal-title"><i class="fas fa-pen me-2"></i>Actualizar Producto</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <!-- Clasificación -->
        <div class="form-section">
          <div class="form-section-title"><i class="fas fa-tags"></i>Clasificación del producto</div>
          <div class="row g-3">
            <div class="col-md-3">
              <div class="fl"><label>Categoría *</label>
                <select class="fc fsel text-uppercase" id="categoria_editar" required>
                  <option value="">Seleccione categoría</option>
                  <?php foreach($categorias->getResult() as $categoria) { ?>
                    <option value="<?= $categoria->codigo_categoria ?>"><?= $categoria->nombre; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-3"><div class="fl"><label>Subcategoría *</label><input type="text" id="subcategoria_editar" class="fc" required></div></div>
            <div class="col-md-2"><div class="fl"><label>Grupo *</label><input type="text" id="grupo_editar" class="fc" required></div></div>
            <div class="col-md-2"><div class="fl"><label>Subgrupo *</label><input type="text" id="subgrupo_editar" class="fc" required></div></div>
            <div class="col-md-2"><div class="fl"><label>Merma *</label><input type="text" id="merma_editar" class="fc" required></div></div>
          </div>
        </div>

        <!-- Identificación -->
        <div class="form-section">
          <div class="form-section-title"><i class="fas fa-barcode"></i>Identificación del producto</div>
          <div class="row g-3">
            <div class="col-md-3"><div class="fl"><label>Nombre *</label><input type="text" id="nombre_editar" class="fc" required></div></div>
            <div class="col-md-3"><div class="fl"><label>Referencia *</label><input type="text" id="referencia_editar" class="fc" required></div></div>
            <div class="col-md-3"><div class="fl"><label>Código interno *</label><input type="number" id="codigo_editar" class="fc" required></div></div>
            <div class="col-md-3"><div class="fl"><label>Código de barras *</label><input type="number" id="barras_editar" class="fc"></div></div>
          </div>
        </div>

        <!-- Proveedor y valores -->
        <div class="form-section">
          <div class="form-section-title"><i class="fas fa-truck"></i>Proveedor y valores</div>
          <div class="row g-3">
            <div class="col-md-3"><div class="fl"><label>NIT *</label><input type="number" id="nit_editar" class="fc"></div></div>
            <div class="col-md-3"><div class="fl"><label>Proveedor *</label><input type="text" id="proveedor_editar" class="fc" required></div></div>
            <div class="col-md-3"><div class="fl"><label>Saldo</label><input type="number" id="saldo_editar" class="fc"></div></div>
            <div class="col-md-3"><div class="fl"><label>Costo</label><input type="number" id="costo_editar" class="fc"></div></div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn-i btn-i-danger-outline" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
        <button type="button" class="btn-i btn-i-primary" onclick="actualizarProductos()" data-bs-dismiss="modal"><i class="fas fa-sync-alt"></i> Actualizar</button>
      </div>
    </div>
  </div>
</div>

<?php require_once("componentes/scripts.php")?>
<script src="<?= base_url('js/inventarios.js') ?>"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tbody = document.querySelector('#tabla_inventarios tbody');
    if (!tbody) return;

    const rows = Array.from(tbody.querySelectorAll('tr'));
    let total = rows.length, withStock = 0, low = 0, zero = 0;

    rows.forEach(row => {
        const stockCell = row.querySelectorAll('td')[6];
        if (stockCell) {
            const v = parseInt(stockCell.textContent.trim()) || 0;
            if (v > 10)      withStock++;
            else if (v > 0)  low++;
            else             zero++;
        }
    });

    document.getElementById('statTotal').textContent  = total;
    document.getElementById('statStock').textContent  = withStock;
    document.getElementById('statLow').textContent    = low;
    document.getElementById('statZero').textContent   = zero;
    document.getElementById('countPill').textContent  = total;

    /* Live search */
    const si = document.getElementById('searchInput');
    if (si) {
        si.addEventListener('input', function () {
            const q = this.value.toLowerCase();
            rows.forEach(r => {
                r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    }
});
</script>
</body>
</html>
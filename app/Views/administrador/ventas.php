<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion - Ventas</title>
    <link rel="stylesheet" href="<?= base_url('css/estilo.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/material.css') ?>">
    <link rel="stylesheet" href="<?= base_url('fontawesome/css/fontawesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('fontawesome/css/brands.css') ?>">
    <link rel="stylesheet" href="<?= base_url('fontawesome/css/solid.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/argon-dashboard.css?v=2.0.2') ?>">
    <link rel="stylesheet" href="<?= base_url('css/overhang.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/datatable.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

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
           FULL LAYOUT — sidebar-less POS
        ══════════════════════════════════════ */
        .pos-root {
            display:grid;
            grid-template-columns:300px 1fr;
            min-height:100vh;
            gap:0;
        }

        @media (max-width:1024px) { .pos-root { grid-template-columns:1fr; } }

        /* ══════════════════════════════════════
           LEFT PANEL — TOTALS
        ══════════════════════════════════════ */
        .pos-left {
            background:linear-gradient(165deg, var(--purple-900), var(--purple-700), #7c3aed);
            display:flex; flex-direction:column;
            position:sticky; top:0; height:100vh;
            padding:0; overflow:hidden;
        }

        /* Decorative circles */
        .pos-left::before {
            content:'';
            position:absolute; top:-80px; right:-80px;
            width:260px; height:260px;
            background:rgba(255,255,255,.05);
            border-radius:50%;
        }
        .pos-left::after {
            content:'';
            position:absolute; bottom:-60px; left:-60px;
            width:200px; height:200px;
            background:rgba(255,255,255,.04);
            border-radius:50%;
        }

        .pos-left-inner {
            position:relative; z-index:1;
            display:flex; flex-direction:column;
            height:100%; padding:28px 22px;
        }

        /* Brand row */
        .pos-brand {
            display:flex; align-items:center; gap:10px;
            margin-bottom:32px;
        }
        .pos-brand-icon {
            width:38px; height:38px; border-radius:10px;
            background:rgba(255,255,255,.15);
            display:flex; align-items:center; justify-content:center;
            font-size:16px; color:#fff;
        }
        .pos-brand-name {
            font-family:'Syne',sans-serif; font-size:16px;
            font-weight:800; color:#fff; letter-spacing:-.01em;
        }
        .pos-brand-sub { font-size:10px; color:rgba(255,255,255,.55); margin-top:1px; }

        /* Sale number */
        .pos-sale-num {
            background:rgba(255,255,255,.1);
            border:1px solid rgba(255,255,255,.15);
            border-radius:var(--radius-sm);
            padding:10px 14px;
            margin-bottom:22px;
            display:flex; align-items:center; justify-content:space-between;
        }
        .pos-sale-num label { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:rgba(255,255,255,.6); }
        .pos-sale-num .sale-id {
            font-family:'JetBrains Mono',monospace;
            font-size:14px; font-weight:700; color:#e9d5ff;
        }

        /* Big total display */
        .pos-total-section { text-align:center; margin-bottom:28px; }

        .pos-total-label {
            font-size:10.5px; font-weight:700; text-transform:uppercase;
            letter-spacing:.1em; color:rgba(255,255,255,.6); margin-bottom:8px;
        }

        .pos-total-amount {
            font-family:'Syne',sans-serif; font-size:44px;
            font-weight:800; color:#fff; line-height:1;
            transition:all .3s var(--ease);
        }

        .pos-total-amount.zero { color:rgba(255,255,255,.4); }

        /* Divider line */
        .pos-divider {
            height:1px; background:rgba(255,255,255,.12);
            margin:20px 0;
        }

        /* Return section */
        .pos-return-section { text-align:center; margin-bottom:28px; }

        .pos-return-label {
            font-size:10px; font-weight:700; text-transform:uppercase;
            letter-spacing:.08em; color:rgba(255,255,255,.5); margin-bottom:6px;
        }

        .pos-return-amount {
            font-family:'Syne',sans-serif; font-size:28px;
            font-weight:800; color:#a7f3d0; line-height:1;
        }

        /* Cash input */
        .pos-cash-section { margin-bottom:22px; }
        .pos-cash-label {
            font-size:10px; font-weight:700; text-transform:uppercase;
            letter-spacing:.08em; color:rgba(255,255,255,.6); margin-bottom:7px;
        }
        .pos-cash-input {
            width:100%; padding:11px 14px;
            background:rgba(255,255,255,.12);
            border:1.5px solid rgba(255,255,255,.2);
            border-radius:var(--radius-sm);
            font-family:'JetBrains Mono',monospace;
            font-size:16px; font-weight:700; color:#fff;
            outline:none; transition:all .25s var(--ease);
            text-align:center;
        }
        .pos-cash-input::placeholder { color:rgba(255,255,255,.3); }
        .pos-cash-input:focus { border-color:rgba(255,255,255,.5); background:rgba(255,255,255,.18); }

        /* Meta info strip */
        .pos-meta {
            display:flex; flex-direction:column; gap:8px;
            margin-bottom:auto; padding-bottom:20px;
        }
        .pos-meta-row {
            display:flex; align-items:center; justify-content:space-between;
            font-size:12px;
        }
        .pos-meta-row .k { color:rgba(255,255,255,.5); font-weight:500; }
        .pos-meta-row .v { color:rgba(255,255,255,.9); font-weight:600; }

        /* Print checkbox */
        .pos-print-check {
            display:flex; align-items:center; gap:9px;
            padding:10px 14px;
            background:rgba(255,255,255,.08);
            border:1px solid rgba(255,255,255,.12);
            border-radius:var(--radius-sm);
            cursor:pointer; margin-bottom:16px;
            transition:all .25s var(--ease);
        }
        .pos-print-check:hover { background:rgba(255,255,255,.13); }
        .pos-print-check input { width:15px; height:15px; accent-color:#a855f7; cursor:pointer; }
        .pos-print-check span { font-size:12px; color:rgba(255,255,255,.8); font-weight:600; }

        /* Wave SVG */
        .pos-wave { position:absolute; bottom:0; left:0; right:0; opacity:.12; }

        /* ══════════════════════════════════════
           RIGHT PANEL — FORM + TABLE
        ══════════════════════════════════════ */
        .pos-right {
            display:flex; flex-direction:column;
            padding:24px 26px;
            overflow-y:auto;
        }

        /* Topbar breadcrumb */
        .pos-topbar {
            display:flex; align-items:center; justify-content:space-between;
            flex-wrap:wrap; gap:10px; margin-bottom:22px;
        }
        .pos-breadcrumb { font-size:11px; font-weight:600; letter-spacing:.08em; text-transform:uppercase; color:var(--purple-400); margin-bottom:2px; }
        .pos-title { font-size:22px; font-weight:800; color:var(--purple-800); }

        .pos-time-badge {
            display:flex; align-items:center; gap:7px;
            background:var(--surface); border:1px solid var(--border);
            border-radius:50px; padding:6px 14px;
            font-size:12px; font-weight:600; color:var(--muted);
            box-shadow:var(--shadow-sm);
        }
        .pos-time-badge i { color:var(--purple-400); }

        /* ══════════════════════════════════════
           FORM SECTIONS
        ══════════════════════════════════════ */
        .form-section {
            background:var(--surface); border:1px solid var(--border);
            border-radius:var(--radius); padding:16px 18px;
            margin-bottom:14px; box-shadow:var(--shadow-sm);
            animation:slideUp .35s ease both;
        }
        .form-section:nth-child(1){animation-delay:.06s;}
        .form-section:nth-child(2){animation-delay:.12s;}
        .form-section:nth-child(3){animation-delay:.18s;}

        .section-title {
            font-size:11px; font-weight:700; text-transform:uppercase;
            letter-spacing:.08em; color:var(--purple-600);
            display:flex; align-items:center; gap:7px;
            margin-bottom:14px; padding-bottom:10px;
            border-bottom:1px solid var(--border);
        }
        .section-title i {
            width:22px; height:22px; background:var(--purple-100);
            border-radius:6px; display:inline-flex; align-items:center;
            justify-content:center; font-size:10px;
        }

        /* Form fields */
        .fl { display:flex; flex-direction:column; gap:4px; }
        .fl label {
            font-size:10.5px; font-weight:600; text-transform:uppercase;
            letter-spacing:.06em; color:var(--muted);
        }

        .fc, .fsel {
            width:100%; padding:8px 12px;
            border:1.5px solid var(--border); border-radius:var(--radius-sm);
            font-family:'DM Sans',sans-serif; font-size:13px; color:var(--text);
            background:var(--surface); transition:all .25s var(--ease);
            outline:none; appearance:none;
        }
        .fc:focus, .fsel:focus { border-color:var(--purple-400); box-shadow:0 0 0 3px rgba(168,85,247,.15); }
        .fc[readonly], .fsel[readonly] { background:var(--purple-100); color:var(--purple-700); cursor:default; }

        /* Product search bar */
        .search-bar {
            display:flex; border:1.5px solid var(--purple-400);
            border-radius:var(--radius-sm); overflow:hidden;
            box-shadow:0 0 0 3px rgba(168,85,247,.12);
        }
        .search-bar input {
            flex:1; padding:9px 14px; border:none;
            font-family:'DM Sans',sans-serif; font-size:14px;
            font-weight:700; color:var(--text); background:#fff; outline:none;
        }
        .search-bar button {
            padding:0 16px; background:var(--purple-600);
            border:none; color:#fff; cursor:pointer;
            font-size:15px; transition:all .25s var(--ease);
        }
        .search-bar button:hover { background:var(--purple-700); }

        /* Percentage badge */
        .pct-badge {
            display:inline-flex; align-items:center; justify-content:center;
            background:var(--amber-light); border:1.5px solid #fde68a;
            border-radius:var(--radius-sm); height:38px;
            font-family:'Syne',sans-serif; font-size:15px;
            font-weight:800; color:#92400e; width:100%;
        }

        /* Day select (read-only styled) */
        .day-display {
            background:linear-gradient(135deg,var(--purple-100),#ede0ff);
            border:1.5px solid var(--purple-200);
            border-radius:var(--radius-sm);
            padding:8px 12px;
            font-family:'Syne',sans-serif;
            font-size:13px; font-weight:700;
            color:var(--purple-700);
            text-align:center;
        }

        /* ══════════════════════════════════════
           CART TABLE
        ══════════════════════════════════════ */
        .cart-card {
            background:var(--surface); border:1px solid var(--border);
            border-radius:var(--radius); box-shadow:var(--shadow-sm);
            overflow:hidden; animation:slideUp .35s ease .22s both;
            flex:1;
        }

        .cart-header {
            padding:12px 18px; border-bottom:1px solid var(--border);
            background:linear-gradient(90deg,var(--purple-100),#fdf8ff);
            display:flex; align-items:center; justify-content:space-between;
        }
        .cart-header h5 {
            font-size:13px; font-weight:700; color:var(--purple-800);
            display:flex; align-items:center; gap:8px; margin:0;
        }
        .cart-count {
            background:var(--purple-600); color:#fff;
            font-size:10px; font-weight:700;
            padding:2px 8px; border-radius:50px;
        }

        .cart-table {
            width:100%; border-collapse:separate; border-spacing:0; font-size:13px;
        }
        .cart-table thead th {
            background:linear-gradient(135deg,var(--purple-800),var(--purple-700));
            color:#fff; padding:11px 16px;
            font-family:'Syne',sans-serif; font-size:10.5px;
            font-weight:700; letter-spacing:.06em; text-transform:uppercase;
            text-align:left; white-space:nowrap;
        }
        .cart-table tbody tr {
            border-bottom:1px solid #f0ebfa;
            transition:all .25s var(--ease);
        }
        .cart-table tbody tr:nth-child(even){background:#fdfaff;}
        .cart-table tbody tr:hover{background:linear-gradient(90deg,#f5f0ff,#fdf8ff) !important;}
        .cart-table td { padding:11px 16px; vertical-align:middle; }

        .cart-empty {
            text-align:center; padding:40px 20px;
            color:var(--muted); font-size:13px; font-weight:500;
        }
        .cart-empty i { font-size:36px; color:var(--purple-200); display:block; margin-bottom:10px; }

        /* Row action btn */
        .btn-row-del {
            width:28px; height:28px; border-radius:7px;
            background:var(--red-light); color:var(--red-dark);
            border:1.5px solid #fca5a5; cursor:pointer; font-size:11px;
            display:inline-flex; align-items:center; justify-content:center;
            transition:all .22s var(--ease);
        }
        .btn-row-del:hover { background:var(--red); color:#fff; transform:scale(1.12); }

        /* Inline editable qty */
        .qty-input {
            width:60px; padding:5px 8px; text-align:center;
            border:1.5px solid var(--border); border-radius:6px;
            font-family:'Syne',sans-serif; font-size:13px; font-weight:700;
            color:var(--purple-700); outline:none;
            transition:all .2s var(--ease);
        }
        .qty-input:focus { border-color:var(--purple-400); box-shadow:0 0 0 3px rgba(168,85,247,.15); }

        .price-cell {
            font-family:'Syne',sans-serif; font-size:13px;
            font-weight:700; color:var(--purple-700);
        }

        /* ══════════════════════════════════════
           ANIMATIONS
        ══════════════════════════════════════ */
        @keyframes slideUp {
            from{opacity:0;transform:translateY(16px);}
            to  {opacity:1;transform:translateY(0);}
        }

        @keyframes totalPop {
            0%  {transform:scale(1);}
            50% {transform:scale(1.06);}
            100%{transform:scale(1);}
        }

        .pop-anim { animation:totalPop .3s var(--ease); }

        .color-morado{background:linear-gradient(135deg,var(--purple-800),var(--purple-700)) !important;}

        @media (max-width:1024px) {
            .pos-left { position:relative; height:auto; min-height:220px; }
            .pos-right { padding:16px; }
        }
    </style>
</head>
<body>

<div class="pos-root">
<!-- ══════════════════════════════════════
  LEFT PANEL — TOTALS & PAYMENT
══════════════════════════════════════ -->
    <div class="pos-left">
        <div class="pos-left-inner">
            <div class="pos-brand">
                <div class="pos-brand-icon"><i class="fas fa-cash-register"></i></div>
                <div>
                    <div class="pos-brand-name">InventSoft</div>
                    <div class="pos-brand-sub">Punto de venta</div>
                </div>
            </div>
            <div class="pos-sale-num">
                <label>N° de venta</label>
                <span class="text-white" id="consecutivo">
                    VNT00<?= $consecutivo->getRow()->consecutivo + 1 ?>
                </span>
            </div>
            <div class="pos-total-section">
                <div class="pos-total-label"><i class="fas fa-receipt"></i>&nbsp; Total de venta</div>
                <div class="pos-total-amount zero" id="ventaa">
                    <small id="compracero">$0</small>
                    <small class="total-compra" id="total-compra" hidden></small>
                </div>
            </div>
            <div class="pos-divider"></div>
            <div class="pos-return-section" id="volver">
                <div class="pos-return-label"><i class="fas fa-undo-alt"></i>&nbsp; A devolver</div>
                <div class="pos-return-amount" id="devolver">$0</div>
            </div>
            <div class="pos-cash-section">
                <div class="pos-cash-label"><i class="fas fa-money-bill-wave"></i>&nbsp; Recibo de efectivo</div>
                <input type="text" class="pos-cash-input" id="recibio"
                    placeholder="$0" oninput="formatearMiles(this)">
            </div>
            <div class="pos-meta">
                <div class="pos-meta-row">
                    <span class="k"><i class="fas fa-user"></i>&nbsp; Vendedor</span>
                    <span class="v"><?= session()->get('nombre').' '.session()->get('apellido') ?></span>
                </div>
                <div class="pos-meta-row">
                    <span class="k"><i class="fas fa-calendar-day"></i>&nbsp; Fecha</span>
                    <span class="v"><?= strftime('%d/%m/%Y') ?></span>
                </div>
                <div class="pos-meta-row">
                    <span class="k"><i class="fas fa-desktop"></i>&nbsp; Caja</span>
                    <?php $cajas = $caja->getResult()[0]; ?>
                    <span class="v">Caja #<?= $cajas->codigo_caja ?></span>
                </div>
            </div>
            <label class="pos-print-check">
                <input type="checkbox" name="checkrecibocaja" id="checkrecibocaja" checked>
                <i class="fas fa-print" style="color:rgba(255,255,255,.6);"></i>
                <span>Imprimir recibo</span>
            </label>
            <select id="dia" hidden>
                <?php if(strftime('%A') == 'Monday') { ?><option value="1" selected>LUNES</option><?php } ?>
                <?php if(strftime('%A') == 'Tuesday') { ?><option value="2" selected>MARTES</option><?php } ?>
                <?php if(strftime('%A') == 'Wednesday') { ?><option value="3" selected>MIERCOLES</option><?php } ?>
                <?php if(strftime('%A') == 'Thursday') { ?><option value="4" selected>JUEVES</option><?php } ?>
                <?php if(strftime('%A') == 'Friday') { ?><option value="5" selected>VIERNES</option><?php } ?>
                <?php if(strftime('%A') == 'Saturday') { ?><option value="6" selected>SABADO</option><?php } ?>
                <?php if(strftime('%A') == 'Sunday') { ?><option value="7" selected>DOMINGO</option><?php } ?>
            </select>
            <input type="text" id="total" hidden readonly>
        </div>
        <svg class="pos-wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" preserveAspectRatio="none">
            <path d="M0,40 C240,80 480,0 720,40 C960,80 1200,0 1440,40 L1440,80 L0,80 Z" fill="white"/>
        </svg>
    </div>
    <!-- ══════════════════════════════════════
         RIGHT PANEL
    ══════════════════════════════════════ -->
    <div class="pos-right">

        <!-- Topbar -->
        <div class="pos-topbar">
            <div>
                <p class="pos-breadcrumb">Administración &rsaquo; InventSoft</p>
                <h4 class="">Registro de Ventas</h4>
            </div>
            <div class="pos-time-badge">
                <i class="fas fa-clock"></i>
                <span id="liveClock">12:00:PM</span>
            </div>
        </div>

        <!-- SECTION 1: Product search -->
        <div class="form-section">
            <div class="section-title"><i class="fas fa-barcode"></i>Búsqueda de producto</div>
            <div class="row g-3 align-items-end">
                <div class="col-md-6">
                    <div class="fl">
                        <label class="req">Código de producto</label>
                        <div class="search-bar">
                            <input type="text" id="codigo_barras" placeholder="Escanea o escribe el código…" autofocus>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#listaproductos" title="Buscar en lista">
                                <i class="fas fa-store"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="fl">
                        <label>Descuento %</label>
                        <div class="pct-badge">0%</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="fl">
                        <label>Precio</label>
                        <input type="text" class="fc" id="precio" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="fl">
                        <label>Cantidad</label>
                        <input type="text" class="fc" id="cantidad" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: Product info -->
        <div class="form-section">
            <div class="section-title"><i class="fas fa-box"></i>Detalle del producto</div>
            <div class="row g-3">
                <div class="col-md-8">
                    <div class="fl">
                        <label>Nombre producto</label>
                        <input type="text" class="fc" id="producto" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fl">
                        <label>Vendedor</label>
                        <input type="text" class="fc"
                            value="<?= session()->get('nombre').' '.session()->get('apellido') ?>" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- CART TABLE -->
        <div class="cart-card">
            <div class="cart-header">
                <h5>
                    <i class="fas fa-shopping-cart"></i>
                    Carrito de venta
                    <span class="cart-count" id="cartCount">0 Productos</span>
                </h5>
                <span style="font-size:11px;color:var(--muted);">
                    <i class="fas fa-info-circle"></i>&nbsp;Los productos se agregan automáticamente
                </span>
            </div>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Código</th>
                        <th>Nombre producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="tbody">
                    <!-- JS populated -->
                    <tr id="emptyCartRow">
                        <td colspan="6" class="cart-empty">
                            <i class="fas fa-shopping-basket"></i>
                            Aún no hay productos en la venta.<br>
                            <span style="font-size:12px;color:var(--purple-300);">Escanea un código para comenzar</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div><!-- /pos-right -->

</div><!-- /pos-root -->

<!-- <?php require_once("componentes/footer.php")?> -->

<?php require_once("componentes/scripts.php")?>
<script src="<?= base_url('js/ventas.js') ?>"></script>

<script>
/* ══ Live clock ══ */
(function tick(){
    const el = document.getElementById('liveClock');
    if (el) {
        const now = new Date();
        const pad = n => String(n).padStart(2,'0');
        el.textContent = `${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
    }
    setTimeout(tick, 1000);
})();

/* ══ Cart counter ══ */
const tbody = document.querySelector('.tbody');
if (tbody) {
    const observer = new MutationObserver(() => {
        const rows = tbody.querySelectorAll('tr:not(#emptyCartRow)');
        const count = rows.length;
        const countEl = document.getElementById('cartCount');
        if (countEl) countEl.textContent = count + (count === 1 ? ' ítem' : ' ítems');

        // Show/hide empty state
        const emptyRow = document.getElementById('emptyCartRow');
        if (emptyRow) emptyRow.style.display = count > 0 ? 'none' : '';

        // Pop animation on total
        const totalEl = document.getElementById('ventaa');
        if (totalEl) {
            totalEl.classList.remove('pop-anim');
            void totalEl.offsetWidth; // reflow
            totalEl.classList.add('pop-anim');
            totalEl.classList.toggle('zero', count === 0);
        }
    });
    observer.observe(tbody, { childList:true });
}
</script>
</body>
</html>
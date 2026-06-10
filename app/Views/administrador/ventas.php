<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas — POS</title>
    <link rel="stylesheet" href="<?= base_url('css/estilo.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/material.css') ?>">
    <link rel="stylesheet" href="<?= base_url('fontawesome/css/fontawesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('fontawesome/css/brands.css') ?>">
    <link rel="stylesheet" href="<?= base_url('fontawesome/css/solid.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/overhang.min.css') ?>">
    <style>
        :root {
            --g900:#0d2409; --g800:#173a10; --g700:#2d6622;
            --g600:#4a8a37; --g500:#7fac6e; --g400:#8fba7e;
            --g300:#abd49b; --g200:#d4eacc; --g100:#f0f7ec;
            --red:#ef4444; --red-l:#fee2e2; --red-d:#991b1b;
            --amber:#f59e0b; --amber-l:#fef3c7;
            --surface:#fff; --border:#e2e8f0;
            --text:#0d2409; --muted:#64748b;
            --r:12px; --r-sm:8px;
            --ease:cubic-bezier(.4,0,.2,1);
        }
        *{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:Arial,Helvetica;background:#f1f5f9;color:var(--text);overflow:hidden;}
        ::-webkit-scrollbar{width:5px;height:5px;}
        ::-webkit-scrollbar-thumb{background:var(--g300);border-radius:99px;}

        /* ── ROOT GRID ── */
        .pos-root{
            display:grid;
            grid-template-columns:1fr 360px;
            height:100vh;
        }

        /* ══════════════════════════════════
           LEFT — PRODUCT BROWSER
        ══════════════════════════════════ */
        .pos-browser{
            display:flex;flex-direction:column;
            background:#f1f5f9;overflow:hidden;
        }

        /* Top bar */
        .browser-topbar{
            display:flex;align-items:center;gap:10px;
            padding:12px 16px;background:#fff;
            border-bottom:1px solid var(--border);
            flex-shrink:0;
        }
        .browser-title{
            font-size:15px;font-weight:800;color:var(--g800);
            display:flex;align-items:center;gap:8px;
        }
        .browser-title i{color:var(--g600);}

        /* Search */
        .browser-search{position:relative;flex:1;max-width:380px;}
        .browser-search-bar{
            display:flex;border:1.5px solid var(--g400);
            border-radius:var(--r-sm);overflow:hidden;
            background:#fff;
        }
        .browser-search-bar input{
            flex:1;padding:8px 12px;border:none;
            font-family:Arial,Helvetica;font-size:13px;
            font-weight:600;color:var(--text);outline:none;
        }
        .browser-search-bar button{
            padding:0 14px;background:var(--g600);
            border:none;color:#fff;cursor:pointer;font-size:14px;
            transition:background .2s;
        }
        .browser-search-bar button:hover{background:var(--g700);}
        #ventas-drop{
            display:none!important;
            border-radius:0 0 10px 10px;
            box-shadow:0 8px 24px rgba(45,102,34,.15);
            max-height:260px;overflow-y:auto;list-style:none;padding:0;margin:0;
        }
        #ventas-drop li{
            padding:10px 14px;cursor:pointer;font-size:13px;
            display:flex;justify-content:space-between;align-items:center;
            border-bottom:1px solid var(--g100);
        }
        #ventas-drop li:hover{background:var(--g100);}
        #ventas-drop .vd-nombre{font-weight:700;}
        #ventas-drop .vd-meta{font-size:11px;color:var(--muted);text-align:right;}
        #ventas-drop .vd-stock-ok{color:#065f46;}
        #ventas-drop .vd-stock-low{color:#92400e;}
        #ventas-drop .vd-stock-zero{color:var(--red-d);}

        /* Category pills */
        .cat-strip{
            display:flex;align-items:center;gap:8px;
            padding:10px 16px;background:#fff;
            border-bottom:1px solid var(--border);
            overflow-x:auto;flex-shrink:0;
        }
        .cat-strip::-webkit-scrollbar{height:3px;}
        .cat-pill{
            flex-shrink:0;padding:6px 16px;border-radius:50px;
            border:1.5px solid var(--border);background:#fff;
            font-size:12px;font-weight:700;color:var(--muted);
            cursor:pointer;transition:all .2s var(--ease);white-space:nowrap;
        }
        .cat-pill:hover{border-color:var(--g500);color:var(--g700);}
        .cat-pill.active{
            background:var(--g700);border-color:var(--g700);color:#fff;
        }

        /* Product grid */
        .prod-grid-wrap{
            flex:1;overflow-y:auto;padding:14px 16px;
        }
        .prod-grid{
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(140px,1fr));
            gap:12px;
        }
        .prod-card{
            background:#fff;border:1.5px solid var(--border);border-radius:var(--r);
            padding:14px 10px;text-align:center;cursor:pointer;
            transition:all .2s var(--ease);
            display:flex;flex-direction:column;align-items:center;gap:8px;
            position:relative;overflow:hidden;
        }
        .prod-card:hover{
            border-color:var(--g500);box-shadow:0 4px 16px rgba(74,138,55,.18);
            transform:translateY(-2px);
        }
        .prod-card:active{transform:scale(.97);}
        .prod-card-icon{
            width:52px;height:52px;border-radius:12px;
            background:linear-gradient(135deg,var(--g100),var(--g200));
            display:flex;align-items:center;justify-content:center;
            font-size:22px;color:var(--g600);flex-shrink:0;
        }
        .prod-card-name{
            font-size:12px;font-weight:700;color:var(--text);
            line-height:1.3;word-break:break-word;
        }
        .prod-card-price{
            font-size:14px;font-weight:800;color:var(--g700);
            margin-top:auto;
        }
        .prod-card-medida{
            font-size:10px;color:var(--muted);
            background:var(--g100);padding:2px 8px;border-radius:50px;
        }
        .prod-card-add{
            position:absolute;top:6px;right:6px;
            width:22px;height:22px;border-radius:50%;
            background:var(--g600);color:#fff;
            font-size:11px;display:flex;align-items:center;justify-content:center;
            opacity:0;transition:opacity .2s;
        }
        .prod-card:hover .prod-card-add{opacity:1;}

        .prod-empty{
            grid-column:1/-1;text-align:center;padding:60px 20px;
            color:var(--muted);font-size:13px;
        }
        .prod-empty i{font-size:40px;opacity:.2;display:block;margin-bottom:12px;}

        /* ══════════════════════════════════
           RIGHT PANEL — CART + PAYMENT
        ══════════════════════════════════ */
        .pos-right{
            display:flex;flex-direction:column;
            height:100vh;border-left:1px solid var(--border);
        }

        /* Cart section */
        .cart-section{
            flex:1;overflow-y:auto;
            background:#fff;
        }
        .cart-header{
            padding:12px 16px;border-bottom:1px solid var(--border);
            background:linear-gradient(135deg,var(--g800),var(--g700));
            display:flex;align-items:center;justify-content:space-between;
            flex-shrink:0;position:sticky;top:0;z-index:10;
        }
        .cart-header h5{
            font-size:13px;font-weight:700;color:#fff;
            display:flex;align-items:center;gap:8px;margin:0;
        }
        .cart-count{
            background:rgba(255,255,255,.2);color:#fff;
            font-size:10px;font-weight:700;
            padding:2px 8px;border-radius:50px;
        }
        .cart-table{width:100%;border-collapse:collapse;font-size:12px;}
        .cart-table thead th{
            background:var(--g100);color:var(--g800);
            padding:9px 12px;font-size:10px;font-weight:700;
            letter-spacing:.05em;text-transform:uppercase;text-align:left;
            border-bottom:1px solid var(--border);white-space:nowrap;
        }
        .cart-table tbody tr{border-bottom:1px solid #f1f5f9;transition:background .15s;}
        .cart-table tbody tr:hover{background:var(--g100);}
        .cart-table td{padding:9px 12px;vertical-align:middle;}
        .cart-empty{
            text-align:center;padding:32px 16px;
            color:var(--muted);font-size:12px;
        }
        .cart-empty i{font-size:28px;color:var(--g200);display:block;margin-bottom:8px;}
        .qty-input{
            width:52px;padding:4px 6px;text-align:center;
            border:1.5px solid var(--border);border-radius:6px;
            font-family:Arial,Helvetica;font-size:12px;font-weight:700;
            color:var(--g700);outline:none;
        }
        .qty-input:focus{border-color:var(--g500);}
        .price-cell{font-weight:700;color:var(--g700);}
        .btn-row-del{
            width:26px;height:26px;border-radius:6px;
            background:var(--red-l);color:var(--red-d);
            border:1px solid #fca5a5;cursor:pointer;font-size:10px;
            display:inline-flex;align-items:center;justify-content:center;
            transition:all .2s;
        }
        .btn-row-del:hover{background:var(--red);color:#fff;}

        /* ══════════════════════════════════
           PAYMENT PANEL (second image)
        ══════════════════════════════════ */
        .pos-payment{
            flex-shrink:0;
            background:linear-gradient(165deg,var(--g900),var(--g700),#7c3aed);
            padding:18px 18px 14px;
            position:relative;overflow:hidden;
        }
        .pos-payment::before{
            content:'';position:absolute;top:-60px;right:-60px;
            width:180px;height:180px;background:rgba(255,255,255,.05);border-radius:50%;
        }
        .pos-payment::after{
            content:'';position:absolute;bottom:-40px;left:-40px;
            width:140px;height:140px;background:rgba(255,255,255,.04);border-radius:50%;
        }
        .pp-inner{position:relative;z-index:1;}

        .pp-brand{display:flex;align-items:center;gap:9px;margin-bottom:12px;}
        .pp-brand-icon{
            width:32px;height:32px;border-radius:9px;
            background:rgba(255,255,255,.15);
            display:flex;align-items:center;justify-content:center;
            font-size:14px;color:#fff;flex-shrink:0;
        }
        .pp-brand-name{font-size:14px;font-weight:800;color:#fff;}
        .pp-brand-sub{font-size:9px;color:rgba(255,255,255,.55);margin-top:1px;}

        .pp-sale-num{
            background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);
            border-radius:8px;padding:8px 12px;margin-bottom:10px;
            display:flex;align-items:center;justify-content:space-between;
        }
        .pp-sale-num label{font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(255,255,255,.6);}

        .pp-total-section{text-align:center;margin-bottom:10px;}
        .pp-total-label{font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.6);margin-bottom:4px;}
        .pp-total-amount{font-size:36px;font-weight:800;color:#fff;line-height:1;transition:all .3s;}
        .pp-total-amount.zero{color:rgba(255,255,255,.35);}

        .pp-divider{height:1px;background:rgba(255,255,255,.12);margin:8px 0;}

        .pp-return-label{font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(255,255,255,.5);margin-bottom:3px;}
        .pp-return-amount{font-size:22px;font-weight:800;color:#a7f3d0;line-height:1;}

        .pp-cash-label{font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(255,255,255,.6);margin-bottom:5px;margin-top:10px;}
        .pp-cash-input{
            width:100%;padding:9px 12px;
            background:rgba(255,255,255,.12);border:1.5px solid rgba(255,255,255,.2);
            border-radius:8px;font-family:Arial,Helvetica;
            font-size:15px;font-weight:700;color:#fff;
            outline:none;text-align:center;transition:all .25s;
        }
        .pp-cash-input::placeholder{color:rgba(255,255,255,.3);}
        .pp-cash-input:focus{border-color:rgba(255,255,255,.5);background:rgba(255,255,255,.18);}

        .pp-meta{display:flex;flex-direction:column;gap:5px;margin-top:10px;}
        .pp-meta-row{display:flex;align-items:center;justify-content:space-between;font-size:11px;}
        .pp-meta-row .k{color:rgba(255,255,255,.5);font-weight:500;}
        .pp-meta-row .v{color:rgba(255,255,255,.9);font-weight:600;}

        .pp-print{
            display:flex;align-items:center;gap:8px;
            padding:8px 12px;margin-top:10px;
            background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);
            border-radius:8px;cursor:pointer;transition:all .2s;
        }
        .pp-print:hover{background:rgba(255,255,255,.13);}
        .pp-print input{width:14px;height:14px;accent-color:#8fba7e;cursor:pointer;}
        .pp-print span{font-size:12px;color:rgba(255,255,255,.85);font-weight:600;}

        /* ── Pay button ── */
        .btn-pay{
            width:100%;margin-top:10px;padding:12px;
            background:linear-gradient(135deg,#10b981,#059669);
            border:none;border-radius:10px;
            font-family:Arial,Helvetica;font-size:14px;font-weight:800;
            color:#fff;cursor:pointer;letter-spacing:.02em;
            display:flex;align-items:center;justify-content:center;gap:8px;
            transition:all .25s;box-shadow:0 4px 14px rgba(16,185,129,.4);
        }
        .btn-pay:hover{background:linear-gradient(135deg,#059669,#047857);transform:translateY(-1px);}
        .btn-pay:disabled{opacity:.45;cursor:not-allowed;transform:none;}

        @keyframes slideUp{from{opacity:0;transform:translateY(12px);}to{opacity:1;transform:translateY(0);}}
        @keyframes totalPop{0%{transform:scale(1);}50%{transform:scale(1.06);}100%{transform:scale(1);}}
        .pop-anim{animation:totalPop .3s var(--ease);}
    </style>
</head>
<body>

<div class="pos-root">

<!-- ══════════════════════════════════
     LEFT — PRODUCT BROWSER
══════════════════════════════════ -->
<div class="pos-browser">

    <!-- Top bar -->
    <div class="browser-topbar">
        <div class="browser-title"><i class="fas fa-cash-register"></i> Punto de Venta</div>
        <div class="browser-search">
            <div class="browser-search-bar">
                <input type="text" id="codigo_barras" placeholder="Buscar producto…" autofocus autocomplete="off">
                <button type="button" id="btn-limpiar-busqueda" title="Limpiar"><i class="fas fa-times"></i></button>
            </div>
            <ul id="ventas-drop"></ul>
        </div>
        <div style="margin-left:auto;font-size:12px;color:var(--muted);display:flex;align-items:center;gap:6px;">
            <i class="fas fa-clock" style="color:var(--g500);"></i>
            <span id="contador">—</span>
        </div>
    </div>

    <!-- Category pills -->
    <div class="cat-strip" id="cat-strip">
        <div class="cat-pill active" data-cat="todos">Todos</div>
        <!-- JS populated -->
    </div>

    <!-- Product grid -->
    <div class="prod-grid-wrap">
        <div class="prod-grid" id="prod-grid">
            <div class="prod-empty"><i class="fas fa-spinner fa-spin"></i> Cargando…</div>
        </div>
    </div>

</div><!-- /pos-browser -->

<!-- ══════════════════════════════════
     RIGHT — CART + PAYMENT
══════════════════════════════════ -->
<div class="pos-right">

    <!-- CART -->
    <div class="cart-section">
        <div class="cart-header">
            <h5>
                <i class="fas fa-shopping-cart"></i>
                Carrito
                <span class="cart-count" id="cartCount">0 ítems</span>
            </h5>
            <span style="font-size:10px;color:rgba(255,255,255,.6);">Se agrega al seleccionar</span>
        </div>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Und.</th>
                    <th>Cant.</th>
                    <th>Precio</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="tbody">
                <tr id="emptyCartRow">
                    <td colspan="5" class="cart-empty">
                        <i class="fas fa-shopping-basket"></i>
                        Sin productos aún.<br>
                        <span style="font-size:11px;">Selecciona una tarjeta o busca</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- PAYMENT PANEL -->
    <div class="pos-payment">
        <div class="pp-inner">
            <div class="pp-brand">
                <div class="pp-brand-icon"><i class="fas fa-cash-register"></i></div>
                <div>
                    <div class="pp-brand-name">InventSoft</div>
                    <div class="pp-brand-sub">Punto de venta</div>
                </div>
            </div>

            <div class="pp-sale-num">
                <label>N° de venta</label>
                <span class="text-white" id="consecutivo" style="font-size:13px;font-weight:700;color:#d4eacc;">
                    VNT00<?= $consecutivo->getRow()->consecutivo + 1 ?>
                </span>
            </div>

            <div class="pp-total-section">
                <div class="pp-total-label"><i class="fas fa-receipt"></i>&nbsp; Total de venta</div>
                <div class="pp-total-amount zero" id="ventaa">
                    <small id="compracero" class="text-white">$0</small>
                    <small class="total-compra text-white" id="total-compra" hidden></small>
                </div>
            </div>

            <div class="pp-divider"></div>

            <div id="volver" style="text-align:center;margin-bottom:6px;">
                <div class="pp-return-label"><i class="fas fa-undo-alt"></i>&nbsp; A devolver</div>
                <div class="pp-return-amount text-white" id="devolver">$0</div>
            </div>

            <div class="pp-cash-label"><i class="fas fa-money-bill-wave"></i>&nbsp; Recibo de efectivo</div>
            <input type="text" class="pp-cash-input" id="recibio" placeholder="$0" oninput="formatearMiles(this)">

            <div class="pp-meta">
                <div class="pp-meta-row">
                    <span class="k"><i class="fas fa-user"></i>&nbsp; Vendedor</span>
                    <span class="v"><?= session()->get('nombre').' '.session()->get('apellido') ?></span>
                </div>
                <div class="pp-meta-row">
                    <span class="k"><i class="fas fa-calendar-day"></i>&nbsp; Fecha</span>
                    <span class="v"><?= date('d/m/Y') ?></span>
                </div>
                <div class="pp-meta-row">
                    <span class="k"><i class="fas fa-desktop"></i>&nbsp; Caja</span>
                    <?php $cajas = $caja->getResult(); $cajas = !empty($cajas) ? $cajas[0] : null; ?>
                    <span class="v">Caja #<?= $cajas->codigo_caja ?? '—' ?></span>
                </div>
            </div>

            <label class="pp-print">
                <input type="checkbox" name="checkrecibocaja" id="checkrecibocaja" checked>
                <i class="fas fa-print" style="color:rgba(255,255,255,.6);"></i>
                <span>Imprimir recibo</span>
            </label>

            <button class="btn-pay" id="btn-pagar" onclick="crearVenta()">
                <i class="fas fa-check-circle"></i> Pagar
            </button>
        </div>

        <!-- Hidden elements needed by JS -->
        <select id="dia" hidden>
            <?php if(date('N')==1){?><option value="1" selected>LUNES</option><?php }?>
            <?php if(date('N')==2){?><option value="2" selected>MARTES</option><?php }?>
            <?php if(date('N')==3){?><option value="3" selected>MIERCOLES</option><?php }?>
            <?php if(date('N')==4){?><option value="4" selected>JUEVES</option><?php }?>
            <?php if(date('N')==5){?><option value="5" selected>VIERNES</option><?php }?>
            <?php if(date('N')==6){?><option value="6" selected>SABADO</option><?php }?>
            <?php if(date('N')==7){?><option value="7" selected>DOMINGO</option><?php }?>
        </select>
        <input type="text" id="total"    hidden readonly>
        <input type="text" id="producto" hidden>
        <input type="text" id="precio"   hidden>
        <input type="text" id="cantidad" hidden>
    </div><!-- /pos-payment -->

</div><!-- /pos-right -->

</div><!-- /pos-root -->

<?php require_once("componentes/scripts.php")?>
<script src="<?= base_url('js/ventas.js') ?>"></script>

<script>
/* ── Reloj ── */
(function tick(){
    const el = document.getElementById('contador');
    if (!el) return;
    const days   = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
    const months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    const d = new Date();
    el.textContent = days[d.getDay()] + ', ' + d.getDate() + ' ' + months[d.getMonth()];
})();

/* ── Cart counter observer ── */
(function(){
    const tbody = document.querySelector('.tbody');
    if (!tbody) return;
    const observer = new MutationObserver(function(){
        const rows   = tbody.querySelectorAll('tr:not(#emptyCartRow)');
        const count  = rows.length;
        const countEl = document.getElementById('cartCount');
        if (countEl) countEl.textContent = count + (count === 1 ? ' ítem' : ' ítems');
        const emptyRow = document.getElementById('emptyCartRow');
        if (emptyRow) emptyRow.style.display = count > 0 ? 'none' : '';
        const totalEl = document.getElementById('ventaa');
        if (totalEl){
            totalEl.classList.remove('pop-anim');
            void totalEl.offsetWidth;
            totalEl.classList.add('pop-anim');
            totalEl.classList.toggle('zero', count === 0);
        }
    });
    observer.observe(tbody, { childList:true });
})();

/* ══════════════════════════════════
   PRODUCT BROWSER
══════════════════════════════════ */
var allProducts = [];
var currentCat  = 'todos';

function renderGrid(products){
    var grid = document.getElementById('prod-grid');
    if (!products.length){
        grid.innerHTML = '<div class="prod-empty"><i class="fas fa-box-open"></i>Sin productos en esta categoría.</div>';
        return;
    }
    grid.innerHTML = products.map(function(p){
        var precio = parseFloat(p.costo || p.precio || 0);
        var nombre = (p.nombre || '').toUpperCase();
        var medida = p.medida || '';
        return '<div class="prod-card" onclick="addFromCard(' + encodeCard(p) + ')">' +
            '<div class="prod-card-icon"><i class="fas fa-tag"></i></div>' +
            '<div class="prod-card-add"><i class="fas fa-plus"></i></div>' +
            '<div class="prod-card-name">' + nombre + '</div>' +
            (medida ? '<div class="prod-card-medida">' + medida + '</div>' : '') +
            '<div class="prod-card-price">$' + precio.toLocaleString() + '</div>' +
        '</div>';
    }).join('');
}

function encodeCard(p){
    return "'" + btoa(JSON.stringify(p)).replace(/'/g,"\'") + "'";
}

function addFromCard(b64){
    var p = JSON.parse(atob(b64));
    seleccionarProducto({
        nombre:        p.nombre  || '',
        costo:         p.costo   || p.precio || 0,
        saldo:         p.saldo   || p.stock  || 999,
        codigo_barras: p.codigo_barras || p.codigo || '',
        medida:        p.medida  || '',
    });

    /* If coming from search, jump to the product's category */
    if (isSearchMode) {
        searchInput.value = '';
        isSearchMode = false;
        var cat = p.categoria || null;
        var pill = cat ? document.querySelector('.cat-pill[data-cat="' + cat + '"]') : null;
        if (pill) {
            selectCat(cat, pill);
        } else {
            loadCat(currentCat);
        }
    }
}

/* Load categories then load all products */
fetch(baseurl + 'consumos/categorias')
    .then(function(r){ return r.json(); })
    .then(function(cats){
        var strip = document.getElementById('cat-strip');
        cats.forEach(function(c){
            var pill = document.createElement('div');
            pill.className = 'cat-pill';
            pill.dataset.cat = c.codigo_categoria;
            pill.textContent = c.nombre;
            pill.addEventListener('click', function(){ selectCat(c.codigo_categoria, pill); });
            strip.appendChild(pill);
        });
        loadCat('todos');
    });

function highlightPill(cat){
    document.querySelectorAll('.cat-pill').forEach(function(p){ p.classList.remove('active'); });
    var pill = cat ? document.querySelector('.cat-pill[data-cat="' + cat + '"]') : null;
    if (pill) pill.classList.add('active');
}

function selectCat(cat, el){
    document.querySelectorAll('.cat-pill').forEach(function(p){ p.classList.remove('active'); });
    el.classList.add('active');
    currentCat = cat;
    loadCat(cat);
}

document.querySelector('.cat-pill[data-cat="todos"]').addEventListener('click', function(){
    selectCat('todos', this);
});

function loadCat(cat){
    var grid = document.getElementById('prod-grid');
    grid.innerHTML = '<div class="prod-empty"><i class="fas fa-spinner fa-spin"></i> Cargando…</div>';
    fetch(baseurl + 'consumos/categoria/' + encodeURIComponent(cat))
        .then(function(r){ return r.json(); })
        .then(function(data){ renderGrid(data); });
}
</script>
</body>
</html>

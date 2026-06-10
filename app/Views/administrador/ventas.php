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
            --surface:#fff; --border:#e2e8f0;
            --text:#0d2409; --muted:#64748b;
            --r:14px; --r-sm:9px;
            --ease:cubic-bezier(.4,0,.2,1);
            --trans:.22s var(--ease);
            --cart-h:260px;
        }

        *{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'Segoe UI',Arial,Helvetica,sans-serif;background:#eef2f7;color:var(--text);overflow:hidden;}
        ::-webkit-scrollbar{width:5px;height:5px;}
        ::-webkit-scrollbar-thumb{background:var(--g300);border-radius:99px;}
        ::-webkit-scrollbar-track{background:transparent;}

        /* ══════════════════════════════════
           ROOT: 2 columnas
           [izquierda (productos+carrito)] [derecha (pago)]
        ══════════════════════════════════ */
        .pos-root{
            display:grid;
            grid-template-columns:1fr 360px;
            height:100vh;
        }

        /* ══════════════════════════════════
           IZQUIERDA: productos arriba, carrito abajo
        ══════════════════════════════════ */
        .pos-browser{
            display:flex;
            flex-direction:column;
            height:100vh;
            overflow:hidden;
            background:#eef2f7;
        }

        /* ── Top bar ── */
        .browser-topbar{
            display:flex;align-items:center;gap:12px;
            padding:12px 16px;
            background:var(--g800);
            flex-shrink:0;
            position:relative;
        }
        .browser-topbar::after{
            content:'';position:absolute;bottom:0;left:0;right:0;height:3px;
            background:linear-gradient(90deg,var(--g500),var(--g300),transparent);
        }
        .browser-title{
            font-size:14px;font-weight:800;color:#fff;
            display:flex;align-items:center;gap:9px;white-space:nowrap;
        }
        .browser-title-icon{
            width:28px;height:28px;border-radius:8px;
            background:rgba(255,255,255,.12);
            display:flex;align-items:center;justify-content:center;
            font-size:13px;color:#a5d6a7;flex-shrink:0;
        }
        .browser-search{position:relative;flex:1;max-width:400px;}
        .browser-search-bar{
            display:flex;border:1.5px solid rgba(255,255,255,.18);
            border-radius:9px;overflow:hidden;
            background:rgba(255,255,255,.1);
            transition:border-color var(--trans),background var(--trans);
        }
        .browser-search-bar:focus-within{border-color:var(--g300);background:rgba(255,255,255,.18);}
        .browser-search-bar input{
            flex:1;padding:8px 12px;border:none;
            font-family:inherit;font-size:13px;font-weight:600;
            color:#fff;outline:none;background:transparent;
        }
        .browser-search-bar input::placeholder{color:rgba(255,255,255,.4);}
        .browser-search-bar button{
            padding:0 13px;background:transparent;
            border:none;border-left:1px solid rgba(255,255,255,.12);
            color:rgba(255,255,255,.55);cursor:pointer;font-size:13px;
            transition:color var(--trans);
        }
        .browser-search-bar button:hover{color:#fff;}

        #ventas-drop{
            display:none!important;
            position:absolute;top:100%;left:0;right:0;z-index:50;
            border-radius:0 0 12px 12px;
            box-shadow:0 12px 32px rgba(13,36,9,.22);
            max-height:260px;overflow-y:auto;
            list-style:none;padding:0;margin:0;
            background:#fff;border:1.5px solid var(--g200);border-top:none;
        }
        #ventas-drop li{
            padding:10px 14px;cursor:pointer;font-size:13px;
            display:flex;justify-content:space-between;align-items:center;
            border-bottom:1px solid var(--g100);transition:background var(--trans);
        }
        #ventas-drop li:hover{background:var(--g100);}
        #ventas-drop .vd-nombre{font-weight:700;}
        #ventas-drop .vd-meta{font-size:11px;color:var(--muted);text-align:right;}
        #ventas-drop .vd-stock-ok{color:#065f46;}
        #ventas-drop .vd-stock-low{color:#92400e;}
        #ventas-drop .vd-stock-zero{color:var(--red-d);}

        .topbar-clock{
            margin-left:auto;
            display:flex;align-items:center;gap:6px;
            background:rgba(255,255,255,.09);border:1px solid rgba(255,255,255,.12);
            border-radius:7px;padding:5px 11px;white-space:nowrap;
        }
        .topbar-clock i{color:var(--g300);font-size:11px;}
        .topbar-clock span{font-size:11px;color:rgba(255,255,255,.7);font-weight:600;}

        /* ── Category pills ── */
        .cat-strip{
            display:flex;align-items:center;gap:7px;
            padding:9px 14px;background:#fff;
            border-bottom:1px solid var(--border);
            overflow-x:auto;flex-shrink:0;
        }
        .cat-strip::-webkit-scrollbar{height:3px;}
        .cat-label{
            font-size:10px;font-weight:700;color:var(--muted);
            text-transform:uppercase;letter-spacing:.06em;white-space:nowrap;margin-right:3px;
        }
        .cat-pill{
            flex-shrink:0;padding:5px 15px;border-radius:50px;
            border:1.5px solid var(--border);background:#fff;
            font-size:12px;font-weight:700;color:var(--muted);
            cursor:pointer;transition:all var(--trans);white-space:nowrap;user-select:none;
        }
        .cat-pill:hover{border-color:var(--g400);color:var(--g700);background:var(--g100);}
        .cat-pill.active{background:var(--g700);border-color:var(--g700);color:#fff;box-shadow:0 2px 8px rgba(45,102,34,.26);}

        /* ── Product grid — ocupa el espacio disponible ── */
        .prod-grid-wrap{
            flex:1;
            overflow-y:auto;
            padding:14px;
            min-height:0; /* clave para que flex funcione */
        }
        .prod-grid{
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(130px,1fr));
            gap:10px;
        }
        .prod-card{
            background:#fff;border:1.5px solid var(--border);border-radius:var(--r);
            padding:14px 10px 12px;text-align:center;cursor:pointer;
            transition:transform var(--trans),box-shadow var(--trans),border-color var(--trans);
            display:flex;flex-direction:column;align-items:center;gap:7px;
            position:relative;overflow:hidden;
        }
        .prod-card::before{
            content:'';position:absolute;top:0;left:0;right:0;height:3px;
            background:linear-gradient(90deg,var(--g400),var(--g300));
            transform:scaleX(0);transform-origin:left;transition:transform var(--trans);
        }
        .prod-card:hover{border-color:var(--g400);box-shadow:0 6px 18px rgba(74,138,55,.15);transform:translateY(-3px);}
        .prod-card:hover::before{transform:scaleX(1);}
        .prod-card:active{transform:scale(.96);}
        .prod-card-icon{
            width:46px;height:46px;border-radius:11px;
            background:linear-gradient(145deg,var(--g100),var(--g200));
            display:flex;align-items:center;justify-content:center;
            font-size:19px;color:var(--g600);flex-shrink:0;
            transition:background var(--trans);
        }
        .prod-card:hover .prod-card-icon{background:linear-gradient(145deg,var(--g200),var(--g300));color:var(--g700);}
        .prod-card-name{font-size:11px;font-weight:700;color:var(--text);line-height:1.3;word-break:break-word;}
        .prod-card-price{font-size:13px;font-weight:800;color:var(--g700);margin-top:auto;}
        .prod-card-medida{font-size:10px;color:var(--muted);background:var(--g100);padding:2px 8px;border-radius:50px;}
        .prod-card-add{
            position:absolute;top:6px;right:6px;width:22px;height:22px;border-radius:50%;
            background:var(--g600);color:#fff;font-size:11px;
            display:flex;align-items:center;justify-content:center;
            opacity:0;transform:scale(.7);
            transition:opacity var(--trans),transform var(--trans);
            box-shadow:0 2px 8px rgba(74,138,55,.4);
        }
        .prod-card:hover .prod-card-add{opacity:1;transform:scale(1);}
        .prod-empty{grid-column:1/-1;text-align:center;padding:60px 20px;color:var(--muted);font-size:13px;}
        .prod-empty i{font-size:40px;opacity:.18;display:block;margin-bottom:12px;}
        @keyframes cardIn{from{opacity:0;transform:translateY(10px) scale(.97);}to{opacity:1;transform:none;}}
        .prod-card{animation:cardIn .22s var(--ease) both;}

        /* ══════════════════════════════════
           CARRITO — parte inferior izquierda
           altura fija, redimensionable con el handle
        ══════════════════════════════════ */
        .pos-cart{
            flex-shrink:0;
            height:var(--cart-h);
            min-height:160px;
            max-height:55vh;
            display:flex;flex-direction:column;
            background:#fff;
            border-top:2px solid var(--g200);
            position:relative;
        }

        /* Handle de resize */
        .cart-resize-handle{
            position:absolute;top:-4px;left:0;right:0;
            height:8px;cursor:ns-resize;z-index:20;
            display:flex;align-items:center;justify-content:center;
        }
        .cart-resize-handle::after{
            content:'';width:36px;height:3px;
            border-radius:99px;background:var(--g300);
            transition:background var(--trans);
        }
        .cart-resize-handle:hover::after{background:var(--g600);}

        /* Header carrito */
        .cart-header{
            display:flex;align-items:center;justify-content:space-between;
            padding:9px 14px;
            background:var(--g800);
            flex-shrink:0;
        }
        .cart-header-left{display:flex;align-items:center;gap:8px;}
        .cart-header-icon{
            width:26px;height:26px;border-radius:7px;
            background:rgba(255,255,255,.12);
            display:flex;align-items:center;justify-content:center;
            font-size:11px;color:#a5d6a7;
        }
        .cart-header h5{font-size:12.5px;font-weight:800;color:#fff;margin:0;}
        .cart-count{
            background:rgba(255,255,255,.18);color:#fff;
            font-size:10px;font-weight:700;padding:2px 9px;border-radius:50px;
        }
        .cart-header-right{
            display:flex;align-items:center;gap:10px;
        }
        .cart-subtotal-inline{
            font-size:15px;font-weight:800;color:#c6f6d5;
        }

        /* Tabla */
        .cart-scroll{flex:1;overflow-y:auto;min-height:0;}
        .cart-table{width:100%;border-collapse:collapse;font-size:12px;}
        .cart-table thead th{
            background:var(--g100);color:var(--g800);
            padding:7px 11px;font-size:10px;font-weight:700;
            letter-spacing:.06em;text-transform:uppercase;
            text-align:left;border-bottom:1.5px solid var(--g200);
            white-space:nowrap;position:sticky;top:0;z-index:5;
        }
        .cart-table tbody tr{border-bottom:1px solid #f1f5f9;transition:background var(--trans);}
        @keyframes rowIn{from{opacity:0;transform:translateX(-8px);}to{opacity:1;transform:none;}}
        .cart-table tbody tr:not(#emptyCartRow){animation:rowIn .18s var(--ease) both;}
        .cart-table tbody tr:hover{background:var(--g100);}
        .cart-table td{padding:7px 11px;vertical-align:middle;}
        .cart-empty{text-align:center;padding:22px 16px;color:var(--muted);font-size:12px;}
        .cart-empty i{font-size:26px;color:var(--g200);display:block;margin-bottom:8px;}
        .qty-input{
            width:50px;padding:4px 6px;text-align:center;
            border:1.5px solid var(--border);border-radius:7px;
            font-family:inherit;font-size:12px;font-weight:700;
            color:var(--g700);outline:none;transition:border-color var(--trans);
        }
        .qty-input:focus{border-color:var(--g500);}
        .price-cell{font-weight:700;color:var(--g700);}
        .btn-row-del{
            width:25px;height:25px;border-radius:7px;
            background:var(--red-l);color:var(--red-d);
            border:1px solid #fca5a5;cursor:pointer;font-size:10px;
            display:inline-flex;align-items:center;justify-content:center;
            transition:all var(--trans);
        }
        .btn-row-del:hover{background:var(--red);color:#fff;border-color:var(--red);}

        /* ══════════════════════════════════
           DERECHA — PANEL DE PAGO
        ══════════════════════════════════ */
        .pos-right{
            height:100vh;overflow-y:auto;
            border-left:1px solid var(--border);
        }
        .pos-payment{
            min-height:100vh;
            background:linear-gradient(160deg,var(--g900) 0%,#1a4d14 55%,#3a1878 100%);
            padding:20px 18px 18px;
            position:relative;overflow:hidden;
        }
        .pp-orb{position:absolute;border-radius:50%;pointer-events:none;}
        .pp-orb-1{
            width:220px;height:220px;top:-80px;right:-80px;
            background:radial-gradient(circle,rgba(143,186,126,.14),transparent 70%);
            animation:orbFloat 7s ease-in-out infinite;
        }
        .pp-orb-2{
            width:160px;height:160px;bottom:-50px;left:-50px;
            background:radial-gradient(circle,rgba(120,60,220,.12),transparent 70%);
            animation:orbFloat 9s ease-in-out infinite reverse;
        }
        @keyframes orbFloat{0%,100%{transform:translate(0,0);}50%{transform:translate(10px,10px);}}
        .pp-inner{position:relative;z-index:1;}

        .pp-brand{display:flex;align-items:center;gap:10px;margin-bottom:16px;}
        .pp-brand-icon{
            width:34px;height:34px;border-radius:10px;
            background:rgba(255,255,255,.13);border:1px solid rgba(255,255,255,.12);
            display:flex;align-items:center;justify-content:center;
            font-size:14px;color:#a5d6a7;flex-shrink:0;
        }
        .pp-brand-name{font-size:15px;font-weight:800;color:#fff;}
        .pp-brand-sub{font-size:9.5px;color:rgba(255,255,255,.5);margin-top:1px;text-transform:uppercase;letter-spacing:.04em;}

        .pp-sale-chip{
            display:flex;align-items:center;
            background:rgba(255,255,255,.09);border:1px solid rgba(255,255,255,.13);
            border-radius:9px;padding:8px 13px;margin-bottom:14px;
        }
        .pp-sale-chip label{font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.5);flex:1;}
        .pp-sale-chip-num{font-size:13px;font-weight:800;color:#c6f6d5;letter-spacing:.03em;}

        .pp-total-section{
            text-align:center;margin-bottom:14px;
            padding:16px;
            background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);border-radius:13px;
        }
        .pp-total-label{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:rgba(255,255,255,.5);margin-bottom:8px;}
        .pp-total-amount{font-size:38px;font-weight:800;color:#fff;line-height:1;transition:all .3s var(--ease);}
        .pp-total-amount.zero{color:rgba(255,255,255,.28);}

        .pp-divider{height:1px;background:rgba(255,255,255,.1);margin:12px 0;position:relative;}
        .pp-divider::after{content:'';position:absolute;left:0;top:0;width:35%;height:1px;background:linear-gradient(90deg,var(--g400),transparent);}

        .pp-return-row{
            display:flex;align-items:center;justify-content:space-between;
            background:rgba(167,243,208,.07);border:1px solid rgba(167,243,208,.15);
            border-radius:10px;padding:10px 13px;margin-bottom:14px;
        }
        .pp-return-label{font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:.09em;color:rgba(255,255,255,.5);}
        .pp-return-amount{font-size:24px;font-weight:800;color:#a7f3d0;line-height:1;transition:all .3s;}

        .pp-cash-label{font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:.09em;color:rgba(255,255,255,.55);margin-bottom:6px;}
        .pp-cash-input{
            width:100%;padding:11px 14px;
            background:rgba(255,255,255,.1);border:1.5px solid rgba(255,255,255,.18);
            border-radius:10px;font-family:inherit;font-size:17px;font-weight:700;
            color:#fff;outline:none;text-align:center;
            transition:border-color var(--trans),background var(--trans);
        }
        .pp-cash-input::placeholder{color:rgba(255,255,255,.27);}
        .pp-cash-input:focus{border-color:var(--g300);background:rgba(255,255,255,.16);}

        .pp-meta{
            display:flex;flex-direction:column;gap:6px;margin-top:14px;
            background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08);
            border-radius:11px;padding:11px 13px;
        }
        .pp-meta-row{display:flex;align-items:center;justify-content:space-between;font-size:11.5px;}
        .pp-meta-row .k{color:rgba(255,255,255,.45);font-weight:500;display:flex;align-items:center;gap:6px;}
        .pp-meta-row .v{color:rgba(255,255,255,.88);font-weight:600;}

        .pp-print{
            display:flex;align-items:center;gap:9px;
            padding:9px 13px;margin-top:12px;
            background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);
            border-radius:9px;cursor:pointer;transition:background var(--trans);
        }
        .pp-print:hover{background:rgba(255,255,255,.13);}
        .pp-print input{width:14px;height:14px;accent-color:#8fba7e;cursor:pointer;}
        .pp-print span{font-size:12px;color:rgba(255,255,255,.8);font-weight:600;}

        .btn-pay{
            width:100%;margin-top:12px;padding:14px;
            background:linear-gradient(135deg,#10b981,#059669);
            border:none;border-radius:12px;
            font-family:inherit;font-size:15px;font-weight:800;
            color:#fff;cursor:pointer;letter-spacing:.03em;
            display:flex;align-items:center;justify-content:center;gap:9px;
            transition:all var(--trans);
            box-shadow:0 4px 18px rgba(16,185,129,.38);
            position:relative;overflow:hidden;
        }
        .btn-pay::after{
            content:'';position:absolute;inset:0;
            background:linear-gradient(135deg,transparent,rgba(255,255,255,.12),transparent);
            transform:translateX(-100%);transition:transform .5s var(--ease);
        }
        .btn-pay:hover::after{transform:translateX(100%);}
        .btn-pay:hover{background:linear-gradient(135deg,#059669,#047857);transform:translateY(-2px);box-shadow:0 7px 22px rgba(16,185,129,.45);}
        .btn-pay:active{transform:scale(.98);}
        .btn-pay:disabled{opacity:.45;cursor:not-allowed;transform:none;box-shadow:none;}

        @keyframes totalPop{0%{transform:scale(1);}50%{transform:scale(1.06);}100%{transform:scale(1);}}
        .pop-anim{animation:totalPop .3s var(--ease);}
    </style>
</head>
<body>

<div class="pos-root">

<!-- ══════════════════════════════════
     IZQUIERDA: productos (arriba) + carrito (abajo)
══════════════════════════════════ -->
<div class="pos-browser">

    <!-- Top bar -->
    <div class="browser-topbar">
        <div class="browser-title">
            <div class="browser-title-icon"><i class="fas fa-cash-register"></i></div>
            Punto de Venta
        </div>
        <div class="browser-search">
            <div class="browser-search-bar">
                <input type="text" id="codigo_barras" placeholder="Buscar producto o código…" autofocus autocomplete="off">
                <button type="button" id="btn-limpiar-busqueda" title="Limpiar"><i class="fas fa-times"></i></button>
            </div>
            <ul id="ventas-drop"></ul>
        </div>
        <div class="topbar-clock">
            <i class="fas fa-clock"></i>
            <span id="contador">—</span>
        </div>
    </div>

    <!-- Category pills -->
    <div class="cat-strip" id="cat-strip">
        <span class="cat-label">Cat.</span>
        <div class="cat-pill active" data-cat="todos">Todos</div>
    </div>

    <!-- Product grid -->
    <div class="prod-grid-wrap">
        <div class="prod-grid" id="prod-grid">
            <div class="prod-empty"><i class="fas fa-spinner fa-spin"></i> Cargando…</div>
        </div>
    </div>

    <!-- ══ CARRITO — parte inferior ══ -->
    <div class="pos-cart" id="pos-cart">

        <!-- Handle de resize -->
        <div class="cart-resize-handle" id="cart-handle" title="Arrastra para redimensionar"></div>

        <!-- Header -->
        <div class="cart-header">
            <div class="cart-header-left">
                <div class="cart-header-icon"><i class="fas fa-shopping-cart"></i></div>
                <h5>Carrito</h5>
                <span class="cart-count" id="cartCount">0 ítems</span>
            </div>
            <div class="cart-header-right">
                <span class="cart-subtotal-inline" id="cart-subtotal">$0</span>
            </div>
        </div>

        <!-- Tabla scroll -->
        <div class="cart-scroll">
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
                            Carrito vacío — selecciona un producto
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div><!-- /pos-cart -->

</div><!-- /pos-browser -->

<!-- ══════════════════════════════════
     DERECHA — PANEL DE PAGO
══════════════════════════════════ -->
<div class="pos-right">
    <div class="pos-payment">
        <div class="pp-orb pp-orb-1"></div>
        <div class="pp-orb pp-orb-2"></div>
        <div class="pp-inner">

            <div class="pp-brand">
                <div class="pp-brand-icon"><i class="fas fa-leaf"></i></div>
                <div>
                    <div class="pp-brand-name">Cristal Business</div>
                    <div class="pp-brand-sub">Punto de venta</div>
                </div>
            </div>

            <div class="pp-sale-chip">
                <label><i class="fas fa-hashtag" style="margin-right:4px;opacity:.6;"></i>N° de venta</label>
                <span class="pp-sale-chip-num" id="consecutivo">VNT00<?= $consecutivo->getRow()->consecutivo + 1 ?></span>
            </div>

            <div class="pp-total-section">
                <div class="pp-total-label"><i class="fas fa-receipt" style="margin-right:4px;"></i>Total de venta</div>
                <div class="pp-total-amount zero" id="ventaa">
                    <small id="compracero">$0</small>
                    <small class="total-compra" id="total-compra" hidden></small>
                </div>
            </div>

            <div class="pp-divider"></div>

            <div class="pp-return-row" id="volver">
                <div>
                    <div class="pp-return-label"><i class="fas fa-undo-alt" style="margin-right:4px;"></i>A devolver</div>
                </div>
                <div class="pp-return-amount" id="devolver">$0</div>
            </div>

            <div class="pp-cash-label"><i class="fas fa-money-bill-wave" style="margin-right:4px;"></i>Recibo de efectivo</div>
            <input type="text" class="pp-cash-input" id="recibio" placeholder="$0" oninput="formatearMiles(this)">

            <div class="pp-meta">
                <div class="pp-meta-row">
                    <span class="k"><i class="fas fa-user"></i>Vendedor</span>
                    <span class="v"><?= session()->get('nombre').' '.session()->get('apellido') ?></span>
                </div>
                <div class="pp-meta-row">
                    <span class="k"><i class="fas fa-calendar-day"></i>Fecha</span>
                    <span class="v"><?= date('d/m/Y') ?></span>
                </div>
                <div class="pp-meta-row">
                    <span class="k"><i class="fas fa-desktop"></i>Caja</span>
                    <?php $cajas = $caja->getResult(); $cajas = !empty($cajas) ? $cajas[0] : null; ?>
                    <span class="v">Caja #<?= $cajas->codigo_caja ?? '—' ?></span>
                </div>
            </div>

            <label class="pp-print">
                <input type="checkbox" name="checkrecibocaja" id="checkrecibocaja" checked>
                <i class="fas fa-print" style="color:rgba(255,255,255,.5);font-size:13px;"></i>
                <span>Imprimir recibo al cobrar</span>
            </label>

            <button class="btn-pay" id="btn-pagar" onclick="crearVenta()">
                <i class="fas fa-check-circle"></i> Cobrar ahora
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
    </div>
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
    const months = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
    const d = new Date();
    el.textContent = days[d.getDay()] + ' ' + d.getDate() + ' ' + months[d.getMonth()];
    setTimeout(tick, 60000);
})();

/* ── Resize del carrito (drag handle) ── */
(function(){
    const handle  = document.getElementById('cart-handle');
    const cart    = document.getElementById('pos-cart');
    const browser = document.querySelector('.pos-browser');
    if (!handle || !cart) return;

    let startY, startH;

    handle.addEventListener('mousedown', function(e){
        startY = e.clientY;
        startH = cart.offsetHeight;
        document.body.style.userSelect = 'none';
        document.body.style.cursor = 'ns-resize';

        function onMove(e){
            const delta = startY - e.clientY;      /* arrastrar hacia arriba = más alto */
            const newH  = Math.min(Math.max(startH + delta, 160), window.innerHeight * 0.55);
            cart.style.height = newH + 'px';
            document.documentElement.style.setProperty('--cart-h', newH + 'px');
        }
        function onUp(){
            document.body.style.userSelect = '';
            document.body.style.cursor = '';
            document.removeEventListener('mousemove', onMove);
            document.removeEventListener('mouseup', onUp);
        }
        document.addEventListener('mousemove', onMove);
        document.addEventListener('mouseup', onUp);
    });
})();

/* ── Cart observer ── */
(function(){
    const tbody = document.querySelector('.tbody');
    if (!tbody) return;

    function update(){
        const rows = tbody.querySelectorAll('tr:not(#emptyCartRow)');
        const count = rows.length;

        const countEl = document.getElementById('cartCount');
        if (countEl) countEl.textContent = count + (count === 1 ? ' ítem' : ' ítems');

        const emptyRow = document.getElementById('emptyCartRow');
        if (emptyRow) emptyRow.style.display = count > 0 ? 'none' : '';

        /* subtotal en el header del carrito */
        let sub = 0;
        rows.forEach(function(tr){
            const q = tr.querySelector('.qty-input');
            const p = tr.querySelector('.price-cell');
            if (q && p){
                sub += (parseFloat(q.value) || 0) * (parseFloat((p.textContent||'0').replace(/[^0-9.]/g,'')) || 0);
            }
        });
        const subEl = document.getElementById('cart-subtotal');
        if (subEl) subEl.textContent = '$' + sub.toLocaleString();

        const totalEl = document.getElementById('ventaa');
        if (totalEl){
            totalEl.classList.remove('pop-anim');
            void totalEl.offsetWidth;
            totalEl.classList.add('pop-anim');
            totalEl.classList.toggle('zero', count === 0);
        }
    }

    new MutationObserver(update).observe(tbody, { childList:true, subtree:true });
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
    grid.innerHTML = products.map(function(p, i){
        var precio = parseFloat(p.costo || p.precio || 0);
        var nombre = (p.nombre || '').toUpperCase();
        var medida = p.medida || '';
        return '<div class="prod-card" style="animation-delay:' + (i * 0.028) + 's" onclick="addFromCard(\'' + encodeCard(p) + '\')">' +
            '<div class="prod-card-icon"><i class="fas fa-tag"></i></div>' +
            '<div class="prod-card-add"><i class="fas fa-plus"></i></div>' +
            '<div class="prod-card-name">' + nombre + '</div>' +
            (medida ? '<div class="prod-card-medida">' + medida + '</div>' : '') +
            '<div class="prod-card-price">$' + precio.toLocaleString() + '</div>' +
        '</div>';
    }).join('');
}

function encodeCard(p){
    return btoa(JSON.stringify(p)).replace(/'/g,"\'");
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
    if (isSearchMode) {
        searchInput.value = '';
        isSearchMode = false;
        var catId = resolveCatId(p.categoria || null);
        var pill  = catId ? document.querySelector('.cat-pill[data-cat="' + catId + '"]') : null;
        if (pill) { selectCat(catId, pill); } else { loadCat(currentCat); }
    }
}

var catNameToId = {};

fetch(baseurl + 'consumos/categorias')
    .then(function(r){ return r.json(); })
    .then(function(cats){
        var strip = document.getElementById('cat-strip');
        cats.forEach(function(c){
            catNameToId[c.nombre.toLowerCase()] = c.codigo_categoria;
            var pill = document.createElement('div');
            pill.className = 'cat-pill';
            pill.dataset.cat = c.codigo_categoria;
            pill.textContent = c.nombre;
            pill.addEventListener('click', function(){ selectCat(c.codigo_categoria, pill); });
            strip.appendChild(pill);
        });
        loadCat('todos');
    });

function resolveCatId(cat){
    if (!cat) return null;
    if (document.querySelector('.cat-pill[data-cat="' + cat + '"]')) return cat;
    return catNameToId[cat.toLowerCase()] || null;
}

function highlightPill(cat){
    document.querySelectorAll('.cat-pill').forEach(function(p){ p.classList.remove('active'); });
    var id = resolveCatId(cat);
    var pill = id ? document.querySelector('.cat-pill[data-cat="' + id + '"]') : null;
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
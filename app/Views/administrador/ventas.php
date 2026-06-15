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
            --spring:cubic-bezier(.34,1.56,.64,1);
            --trans:.22s var(--ease);
            --cart-h:260px;
            --shadow-sm:0 1px 3px rgba(13,36,9,.08),0 1px 2px rgba(13,36,9,.06);
            --shadow-md:0 4px 12px rgba(13,36,9,.10),0 2px 4px rgba(13,36,9,.06);
            --shadow-lg:0 10px 30px rgba(13,36,9,.12),0 4px 8px rgba(13,36,9,.06);
            --shadow-green:0 4px 18px rgba(74,138,55,.28);
        }
        *{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'Segoe UI',system-ui,Arial,sans-serif;background:#e8eef5;color:var(--text);overflow:hidden;}
        ::-webkit-scrollbar{width:4px;height:4px;}
        ::-webkit-scrollbar-thumb{background:var(--g300);border-radius:99px;}
        ::-webkit-scrollbar-track{background:transparent;}

        /* ── ROOT LAYOUT ── */
        .pos-root{
            display:grid;
            grid-template-columns:1fr 430px;
            height:100vh;
        }

        /* ══════════════════════════════
           IZQUIERDA
        ══════════════════════════════ */
        .pos-browser{
            display:flex;flex-direction:column;
            height:100vh;overflow:hidden;
            background:#e8eef5;
        }

        /* ── TOP BAR ── */
        .browser-topbar{
            display:flex;align-items:center;gap:12px;
            padding:10px 16px;
            background:var(--g800);
            flex-shrink:0;
            position:relative;
        }
        .browser-topbar::after{
            content:'';position:absolute;bottom:0;left:0;right:0;height:2px;
            background:linear-gradient(90deg,var(--g400) 0%,var(--g300) 40%,transparent 100%);
        }

        .browser-title{
            font-size:13px;font-weight:800;color:#fff;
            display:flex;align-items:center;gap:9px;white-space:nowrap;
        }
        .browser-title-icon{
            width:32px;height:32px;border-radius:9px;
            background:linear-gradient(135deg,var(--g600),var(--g500));
            display:flex;align-items:center;justify-content:center;
            font-size:14px;color:#fff;flex-shrink:0;
            box-shadow:var(--shadow-green);
        }

        /* ── SEARCH ── */
        .browser-search{position:relative;flex:1;max-width:420px;}
        .browser-search-bar{
            display:flex;
            border:1.5px solid rgba(255,255,255,.14);
            border-radius:10px;overflow:hidden;
            background:rgba(255,255,255,.09);
            transition:border-color .2s,background .2s,box-shadow .2s;
        }
        .browser-search-bar:focus-within{
            border-color:var(--g300);
            background:rgba(255,255,255,.15);
            box-shadow:0 0 0 3px rgba(171,212,155,.18);
        }
        .browser-search-bar input{
            flex:1;padding:8px 13px;border:none;
            font-family:inherit;font-size:13px;font-weight:600;
            color:#fff;outline:none;background:transparent;
            letter-spacing:.01em;
        }
        .browser-search-bar input::placeholder{color:rgba(255,255,255,.35);}
        .browser-search-bar button{
            padding:0 13px;background:transparent;
            border:none;border-left:1px solid rgba(255,255,255,.1);
            color:rgba(255,255,255,.45);cursor:pointer;font-size:12px;
            transition:color .2s,background .2s;
        }
        .browser-search-bar button:hover{color:#fff;background:rgba(255,255,255,.08);}

        /* ── DROPDOWN ── */
        #ventas-drop{
            display:none!important;
            position:absolute;top:calc(100% + 4px);left:0;right:0;z-index:50;
            border-radius:12px;
            box-shadow:var(--shadow-lg),0 0 0 1px rgba(13,36,9,.06);
            max-height:270px;overflow-y:auto;
            list-style:none;padding:4px;margin:0;
            background:#fff;
        }
        #ventas-drop li{
            padding:9px 12px;cursor:pointer;font-size:12.5px;
            display:flex;justify-content:space-between;align-items:center;
            border-radius:8px;transition:background .15s;
            gap:8px;
        }
        #ventas-drop li:hover{background:var(--g100);}
        #ventas-drop .vd-nombre{font-weight:700;color:var(--text);}
        #ventas-drop .vd-meta{font-size:11px;color:var(--muted);text-align:right;line-height:1.4;}
        #ventas-drop .vd-stock-ok{color:#065f46;}
        #ventas-drop .vd-stock-low{color:#92400e;}
        #ventas-drop .vd-stock-zero{color:var(--red-d);}

        /* ── CLOCK ── */
        .topbar-clock{
            margin-left:auto;
            display:flex;align-items:center;gap:6px;
            background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.1);
            border-radius:8px;padding:5px 11px;white-space:nowrap;
            cursor:default;
        }
        .topbar-clock i{color:var(--g300);font-size:10px;}
        .topbar-clock span{font-size:11px;color:rgba(255,255,255,.72);font-weight:600;}

        /* ── CATEGORY PILLS ── */
        .cat-strip{
            display:flex;align-items:center;gap:6px;
            padding:8px 14px;
            background:#fff;
            border-bottom:1px solid var(--border);
            overflow-x:auto;flex-shrink:0;
        }
        .cat-strip::-webkit-scrollbar{height:2px;}
        .cat-label{
            font-size:9.5px;font-weight:700;color:var(--muted);
            text-transform:uppercase;letter-spacing:.08em;white-space:nowrap;
            margin-right:2px;flex-shrink:0;
        }
        .cat-pill{
            flex-shrink:0;padding:5px 16px;border-radius:50px;
            border:1.5px solid var(--border);background:#fff;
            font-size:11.5px;font-weight:700;color:var(--muted);
            cursor:pointer;transition:all .2s var(--spring);
            white-space:nowrap;user-select:none;
            position:relative;overflow:hidden;
        }
        .cat-pill::before{
            content:'';position:absolute;inset:0;
            background:radial-gradient(circle at center,var(--g200),transparent 70%);
            opacity:0;transition:opacity .2s;
        }
        .cat-pill:hover{border-color:var(--g400);color:var(--g700);background:var(--g100);}
        .cat-pill:hover::before{opacity:1;}
        .cat-pill:active{transform:scale(.94);}
        .cat-pill.active{
            background:var(--g700);border-color:var(--g700);color:#fff;
            box-shadow:var(--shadow-green);
            transform:scale(1.04);
        }
        .cat-pill.active::before{opacity:0;}

        /* ── PRODUCT GRID ── */
        .prod-grid-wrap{
            flex:1;overflow-y:auto;
            padding:14px;min-height:0;
        }
        .prod-grid{
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(128px,1fr));
            gap:10px;
        }

        .prod-card{
            background:#fff;
            border:1.5px solid var(--border);
            border-radius:var(--r);
            padding:16px 10px 13px;
            text-align:center;cursor:pointer;
            transition:transform .2s var(--spring),box-shadow .2s,border-color .2s;
            display:flex;flex-direction:column;align-items:center;gap:6px;
            position:relative;overflow:hidden;
        }
        .prod-card::after{
            content:'';position:absolute;
            inset:0;border-radius:inherit;
            background:linear-gradient(160deg,rgba(255,255,255,0) 50%,rgba(171,212,155,.12));
            opacity:0;transition:opacity .2s;pointer-events:none;
        }
        .prod-card:hover{
            border-color:var(--g400);
            box-shadow:var(--shadow-md),0 0 0 1px var(--g300);
            transform:translateY(-4px) scale(1.01);
        }
        .prod-card:hover::after{opacity:1;}
        .prod-card:active{transform:scale(.95);}

        .prod-card-icon{
            width:50px;height:50px;border-radius:13px;
            background:linear-gradient(145deg,var(--g100),var(--g200));
            display:flex;align-items:center;justify-content:center;
            font-size:20px;color:var(--g600);flex-shrink:0;
            transition:background .2s,transform .2s var(--spring);
            box-shadow:var(--shadow-sm);
        }
        .prod-card:hover .prod-card-icon{
            background:linear-gradient(145deg,var(--g200),var(--g300));
            color:var(--g800);
            transform:scale(1.1) rotate(-4deg);
        }
        .prod-card-name{font-size:11px;font-weight:700;color:var(--text);line-height:1.3;word-break:break-word;}
        .prod-card-price{
            font-size:14px;font-weight:800;color:var(--g700);
            margin-top:auto;
            background:var(--g100);
            padding:3px 10px;border-radius:50px;
            transition:background .2s;
        }
        .prod-card:hover .prod-card-price{background:var(--g200);}
        .prod-card-medida{font-size:10px;color:var(--muted);}

        /* Add badge */
        .prod-card-add{
            position:absolute;top:7px;right:7px;
            width:22px;height:22px;border-radius:50%;
            background:var(--g600);color:#fff;font-size:10px;
            display:flex;align-items:center;justify-content:center;
            opacity:0;transform:scale(.6) rotate(-90deg);
            transition:opacity .2s,transform .25s var(--spring);
            box-shadow:var(--shadow-green);
        }
        .prod-card:hover .prod-card-add{opacity:1;transform:scale(1) rotate(0deg);}

        /* Stock badge */
        .prod-card-stock{
            position:absolute;top:7px;left:7px;
            font-size:9px;font-weight:700;
            padding:2px 6px;border-radius:50px;
            opacity:0;transform:translateX(-4px);
            transition:opacity .2s,transform .2s;
        }
        .prod-card:hover .prod-card-stock{opacity:1;transform:translateX(0);}
        .stock-ok{background:#dcfce7;color:#166534;}
        .stock-low{background:#fef9c3;color:#854d0e;}
        .stock-zero{background:var(--red-l);color:var(--red-d);}

        .prod-empty{grid-column:1/-1;text-align:center;padding:60px 20px;color:var(--muted);font-size:13px;}
        .prod-empty i{font-size:42px;opacity:.15;display:block;margin-bottom:14px;}

        @keyframes cardIn{
            from{opacity:0;transform:translateY(12px) scale(.96);}
            to{opacity:1;transform:none;}
        }
        .prod-card{animation:cardIn .2s var(--ease) both;}

        /* ══════════════════════════════
           CARRITO
        ══════════════════════════════ */
        .pos-cart{
            flex-shrink:0;
            height:var(--cart-h);
            min-height:180px;
            max-height:35vh;
            display:flex;flex-direction:column;
            background:#fff;
            border-top:2px solid var(--g200);
            position:relative;
            box-shadow:0 -4px 16px rgba(13,36,9,.06);
        }

        .cart-resize-handle{
            position:absolute;top:-5px;left:0;right:0;
            height:10px;cursor:ns-resize;z-index:20;
            display:flex;align-items:center;justify-content:center;
        }
        .cart-resize-handle::after{
            content:'';width:40px;height:3px;
            border-radius:99px;background:var(--g200);
            transition:background .2s,width .2s;
        }
        .cart-resize-handle:hover::after{background:var(--g500);width:52px;}

        .cart-header{
            display:flex;align-items:center;justify-content:space-between;
            padding:8px 14px;
            background:var(--g800);
            flex-shrink:0;
        }
        .cart-header-left{display:flex;align-items:center;gap:8px;}
        .cart-header-icon{
            width:26px;height:26px;border-radius:7px;
            background:rgba(255,255,255,.1);
            display:flex;align-items:center;justify-content:center;
            font-size:11px;color:var(--g300);
        }
        .cart-header h5{font-size:12px;font-weight:800;color:#fff;margin:0;}
        .cart-count{
            background:rgba(255,255,255,.14);color:rgba(255,255,255,.85);
            font-size:10px;font-weight:700;padding:2px 9px;border-radius:50px;
            transition:background .2s;
        }
        .cart-count.has-items{background:var(--g600);color:#fff;}
        .cart-subtotal-inline{
            font-size:16px;font-weight:800;color:#c6f6d5;
            transition:transform .2s var(--spring);
        }

        .cart-scroll{flex:1;overflow-y:auto;min-height:0;}
        .cart-table{width:100%;border-collapse:collapse;font-size:12px;}
        .cart-table thead th{
            background:var(--g100);color:var(--g800);
            padding:6px 11px;font-size:9.5px;font-weight:700;
            letter-spacing:.07em;text-transform:uppercase;
            text-align:left;border-bottom:1.5px solid var(--g200);
            white-space:nowrap;position:sticky;top:0;z-index:5;
        }
        .cart-table tbody tr{
            border-bottom:1px solid #f1f5f9;
            transition:background .15s;
        }
        @keyframes rowIn{
            from{opacity:0;background:var(--g100);transform:translateX(-6px);}
            to{opacity:1;background:transparent;transform:none;}
        }
        .cart-table tbody tr:not(#emptyCartRow){animation:rowIn .2s var(--ease) both;}
        .cart-table tbody tr:hover{background:var(--g100);}
        .cart-table td{padding:7px 11px;vertical-align:middle;}

        .cart-empty{text-align:center;padding:22px 16px;color:var(--muted);font-size:12px;}
        .cart-empty i{font-size:24px;color:var(--g200);display:block;margin-bottom:8px;}

        .qty-wrap{display:flex;align-items:center;gap:4px;}
        .qty-btn{
            width:20px;height:20px;border-radius:5px;
            background:var(--g100);border:1px solid var(--g200);
            color:var(--g700);font-size:11px;font-weight:700;
            cursor:pointer;display:flex;align-items:center;justify-content:center;
            transition:all .15s;padding:0;line-height:1;
        }
        .qty-btn:hover{background:var(--g200);border-color:var(--g400);}
        .qty-btn:active{transform:scale(.88);}
        .qty-input{
            width:42px;padding:4px 4px;text-align:center;
            border:1.5px solid var(--border);border-radius:6px;
            font-family:inherit;font-size:12px;font-weight:700;
            color:var(--g700);outline:none;
            transition:border-color .15s,box-shadow .15s;
        }
        .qty-input:focus{border-color:var(--g500);box-shadow:0 0 0 3px rgba(127,172,110,.15);}
        .price-cell{font-weight:700;color:var(--g700);}
        .btn-row-del{
            width:24px;height:24px;border-radius:6px;
            background:var(--red-l);color:var(--red-d);
            border:1px solid #fca5a5;cursor:pointer;font-size:9px;
            display:inline-flex;align-items:center;justify-content:center;
            transition:all .15s;
        }
        .btn-row-del:hover{background:var(--red);color:#fff;border-color:var(--red);transform:scale(1.12);}
        .btn-row-del:active{transform:scale(.9);}

        /* ══════════════════════════════
           PANEL DE PAGO (derecha)
        ══════════════════════════════ */
        .pos-right{
            height:200vh;overflow-y:auto;
            border-left:1px solid rgba(13,36,9,.12);
        }
        .pos-payment{
            min-height:100vh;
            background:linear-gradient(170deg,var(--g900) 0%,#1c521a 50%,#2d1a6e 100%);
            padding:18px 16px 20px;
            position:relative;overflow:hidden;
        }

        /* Ambient orbs */
        .pp-orb{position:absolute;border-radius:50%;pointer-events:none;}
        .pp-orb-1{
            width:260px;height:260px;top:-90px;right:-90px;
            background:radial-gradient(circle,rgba(143,186,126,.13),transparent 65%);
            animation:orbFloat 8s ease-in-out infinite;
        }
        .pp-orb-2{
            width:180px;height:180px;bottom:-60px;left:-60px;
            background:radial-gradient(circle,rgba(120,60,220,.1),transparent 65%);
            animation:orbFloat 11s ease-in-out infinite reverse;
        }
        .pp-orb-3{
            width:120px;height:120px;top:45%;right:-30px;
            background:radial-gradient(circle,rgba(74,138,55,.12),transparent 65%);
            animation:orbFloat 6s ease-in-out infinite 2s;
        }
        @keyframes orbFloat{
            0%,100%{transform:translate(0,0) scale(1);}
            50%{transform:translate(8px,12px) scale(1.04);}
        }
        .pp-inner{position:relative;z-index:1;}

        /* Brand */
        .pp-brand{display:flex;align-items:center;gap:10px;margin-bottom:14px;}
        .pp-brand-icon{
            width:36px;height:36px;border-radius:11px;
            background:linear-gradient(135deg,var(--g600),var(--g500));
            border:1px solid rgba(255,255,255,.15);
            display:flex;align-items:center;justify-content:center;
            font-size:15px;color:#fff;flex-shrink:0;
            box-shadow:var(--shadow-green);
        }
        .pp-brand-name{font-size:15px;font-weight:800;color:#fff;letter-spacing:.01em;}
        .pp-brand-sub{font-size:9px;color:rgba(255,255,255,.45);margin-top:1px;text-transform:uppercase;letter-spacing:.08em;}

        /* Sale chip */
        .pp-sale-chip{
            display:flex;align-items:center;
            background:rgba(255,255,255,.07);
            border:1px solid rgba(255,255,255,.11);
            border-radius:9px;padding:7px 12px;margin-bottom:12px;
        }
        .pp-sale-chip label{font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.4);flex:1;}
        .pp-sale-chip-num{font-size:13px;font-weight:800;color:#c6f6d5;font-variant-numeric:tabular-nums;}

        /* Total */
        .pp-total-section{
            text-align:center;margin-bottom:12px;
            padding:14px;
            background:rgba(255,255,255,.06);
            border:1px solid rgba(255,255,255,.09);
            border-radius:14px;
            position:relative;overflow:hidden;
        }
        .pp-total-section::before{
            content:'';position:absolute;
            bottom:0;left:50%;transform:translateX(-50%);
            width:60%;height:1px;
            background:linear-gradient(90deg,transparent,var(--g400),transparent);
        }
        .pp-total-label{
            font-size:9.5px;font-weight:700;text-transform:uppercase;
            letter-spacing:.12em;color:rgba(255,255,255,.4);margin-bottom:10px;
            display:flex;align-items:center;justify-content:center;gap:5px;
        }
        .pp-total-amount{
            font-size:40px;font-weight:800;color:#fff;line-height:1;
            transition:all .3s var(--spring);
            font-variant-numeric:tabular-nums;
        }
        .pp-total-amount.zero{color:rgba(255,255,255,.25);}

        .pp-divider{height:1px;background:rgba(255,255,255,.08);margin:11px 0;position:relative;}
        .pp-divider::after{
            content:'';position:absolute;left:0;top:0;width:30%;height:1px;
            background:linear-gradient(90deg,var(--g400),transparent);
        }

        /* Devolver */
        .pp-return-row{
            display:flex;align-items:center;justify-content:space-between;
            background:rgba(167,243,208,.06);
            border:1px solid rgba(167,243,208,.13);
            border-radius:10px;padding:9px 13px;margin-bottom:12px;
        }
        .pp-return-label{font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.09em;color:rgba(255,255,255,.4);}
        .pp-return-amount{
            font-size:26px;font-weight:800;color:#a7f3d0;line-height:1;
            transition:all .3s var(--spring);
            font-variant-numeric:tabular-nums;
        }

        /* Cash input */
        .pp-cash-label{
            font-size:9px;font-weight:700;text-transform:uppercase;
            letter-spacing:.09em;color:rgba(255,255,255,.5);margin-bottom:5px;
            display:flex;align-items:center;gap:5px;
        }
        .pp-cash-input{
            width:100%;padding:12px 14px;
            background:rgba(255,255,255,.08);
            border:1.5px solid rgba(255,255,255,.14);
            border-radius:11px;font-family:inherit;font-size:19px;font-weight:700;
            color:#fff;outline:none;text-align:center;
            transition:border-color .2s,background .2s,box-shadow .2s;
            caret-color:var(--g300);
        }
        .pp-cash-input::placeholder{color:rgba(255,255,255,.2);}
        .pp-cash-input:focus{
            border-color:var(--g300);
            background:rgba(255,255,255,.12);
            box-shadow:0 0 0 3px rgba(171,212,155,.12);
        }

        /* Quick amounts */
        .pp-quick-amounts{
            display:grid;grid-template-columns:repeat(4,1fr);gap:5px;
            margin-top:7px;margin-bottom:12px;
        }
        .pp-qa-btn{
            padding:6px 4px;background:rgba(255,255,255,.07);
            border:1px solid rgba(255,255,255,.1);border-radius:8px;
            font-family:inherit;font-size:11px;font-weight:700;
            color:rgba(255,255,255,.7);cursor:pointer;
            transition:all .15s;text-align:center;
        }
        .pp-qa-btn:hover{background:rgba(255,255,255,.15);color:#fff;border-color:rgba(255,255,255,.2);}
        .pp-qa-btn:active{transform:scale(.92);}

        /* Meta info */
        .pp-meta{
            display:flex;flex-direction:column;gap:5px;
            background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.07);
            border-radius:11px;padding:10px 12px;margin-top:0;
        }
        .pp-meta-row{display:flex;align-items:center;justify-content:space-between;font-size:11px;}
        .pp-meta-row .k{color:rgba(255,255,255,.4);font-weight:500;display:flex;align-items:center;gap:6px;}
        .pp-meta-row .v{color:rgba(255,255,255,.82);font-weight:600;}

        /* Print toggle */
        .pp-print{
            display:flex;align-items:center;gap:9px;
            padding:8px 12px;margin-top:10px;
            background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.09);
            border-radius:9px;cursor:pointer;transition:background .15s;
        }
        .pp-print:hover{background:rgba(255,255,255,.11);}
        .pp-print input{width:14px;height:14px;accent-color:#8fba7e;cursor:pointer;}
        .pp-print span{font-size:11.5px;color:rgba(255,255,255,.75);font-weight:600;}

        /* Pay button */
        .btn-pay{
            width:100%;margin-top:11px;padding:14px;
            background:linear-gradient(135deg,#10b981 0%,#059669 50%,#047857 100%);
            background-size:200% 100%;background-position:0% 0%;
            border:none;border-radius:13px;
            font-family:inherit;font-size:15px;font-weight:800;
            color:#fff;cursor:pointer;letter-spacing:.04em;
            display:flex;align-items:center;justify-content:center;gap:10px;
            transition:all .25s var(--ease);
            box-shadow:0 4px 20px rgba(16,185,129,.4);
            position:relative;overflow:hidden;
        }
        .btn-pay .btn-pay-shimmer{
            position:absolute;inset:0;
            background:linear-gradient(105deg,transparent 35%,rgba(255,255,255,.18) 50%,transparent 65%);
            transform:translateX(-100%);
            transition:transform .6s var(--ease);
        }
        .btn-pay:hover .btn-pay-shimmer{transform:translateX(100%);}
        .btn-pay:hover{
            background-position:100% 0%;
            transform:translateY(-2px);
            box-shadow:0 8px 28px rgba(16,185,129,.5);
        }
        .btn-pay:active{transform:scale(.97);box-shadow:0 2px 12px rgba(16,185,129,.3);}
        .btn-pay:disabled{opacity:.4;cursor:not-allowed;transform:none;box-shadow:none;}

        /* Animations */
        @keyframes totalPop{
            0%{transform:scale(1);}
            40%{transform:scale(1.07);}
            100%{transform:scale(1);}
        }
        .pop-anim{animation:totalPop .28s var(--spring);}

        @keyframes pulse-green{
            0%,100%{box-shadow:0 4px 20px rgba(16,185,129,.4);}
            50%{box-shadow:0 4px 28px rgba(16,185,129,.7);}
        }
        .btn-pay:not(:disabled){animation:pulse-green 3s ease-in-out infinite;}

        /* Toast de añadido */
        @keyframes toastIn{
            from{opacity:0;transform:translateY(8px) scale(.94);}
            to{opacity:1;transform:none;}
        }
        @keyframes toastOut{
            from{opacity:1;transform:none;}
            to{opacity:0;transform:translateY(-6px) scale(.94);}
        }
        .add-toast{
            position:fixed;bottom:24px;left:50%;transform:translateX(-50%);
            background:var(--g700);color:#fff;
            padding:8px 18px;border-radius:50px;
            font-size:12px;font-weight:700;
            box-shadow:var(--shadow-lg);
            pointer-events:none;z-index:9999;
            animation:toastIn .2s var(--spring);
        }
    </style>
</head>
<body>

<div class="pos-root">

<!-- ══════════════════════════════
     IZQUIERDA
══════════════════════════════ -->
<div class="pos-browser">

    <!-- Top bar -->
    <div class="browser-topbar">
        <div class="browser-title text-uppercase">
            <div class="browser-title-icon "><i class="fas fa-cash-register"></i></div>
            Punto de Venta
        </div>
        <div class="browser-search">
            <div class="browser-search-bar">
                <input type="text" id="codigo_barras" placeholder="Buscar producto…" autofocus autocomplete="off">
                <button type="button" id="btn-limpiar-busqueda" title="Limpiar"><i class="fas fa-times"></i></button>
            </div>
            <ul id="ventas-drop"></ul>
        </div>
        <div class="topbar-clock">
            <i class="fas fa-circle" style="font-size:7px;color:#4ade80;animation:pulse-green 2s infinite;"></i>
            <span id="contador" class="text-uppercase">—</span>
        </div>
    </div>

    <!-- Category pills -->
    <div class="cat-strip" id="cat-strip">
        <span class="cat-label"><i class="fas fa-th-large" style="font-size:9px;"></i></span>
        <div class="cat-pill active" data-cat="todos">Todos</div>
    </div>

    <!-- Product grid -->
    <div class="prod-grid-wrap">
        <div class="prod-grid" id="prod-grid">
            <div class="prod-empty"><i class="fas fa-spinner fa-spin"></i> Cargando…</div>
        </div>
    </div>

    <!-- ══ CARRITO ══ -->
    <div class="pos-cart" id="pos-cart">
        <div class="cart-resize-handle" id="cart-handle" title="Arrastra para redimensionar"></div>

        <div class="cart-header">
            <div class="cart-header-left">
                <div class="cart-header-icon"><i class="fas fa-shopping-cart"></i></div>
                <h5>CARRITO</h5>
                <span class="cart-count" id="cartCount">0 ítems</span>
            </div>
            
        </div>

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
                <tbody class="tbody ">
                    <tr id="emptyCartRow" class="mt-5">
                        <td colspan="5" class="cart-empty">
                            <i class="fas fa-shopping-basket"></i>
                            Venta vacía — selecciona un producto a vender
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div><!-- /pos-browser -->

<!-- ══════════════════════════════
     DERECHA — PAGO
══════════════════════════════ -->
<div class="pos-right">
    <div class="pos-payment">
        <div class="pp-orb pp-orb-1"></div>
        <div class="pp-orb pp-orb-2"></div>
        <div class="pp-orb pp-orb-3"></div>
        <div class="pp-inner">

            <div class="pp-brand">
                <div class="pp-brand-icon"><i class="fas fa-leaf"></i></div>
                <div>
                    <div class="pp-brand-name">Cristal Business</div>
                    <div class="pp-brand-sub text-white">Punto de venta</div>
                </div>
            </div>

            <div class="pp-sale-chip">
                <label class="text-white"><i class="fas fa-hashtag" style="margin-right:4px;opacity:.5;"></i>N° de venta</label>
                <span class="pp-sale-chip-num" id="consecutivo">VNT00<?= $consecutivo->getRow()->consecutivo + 1 ?></span>
            </div>

            <div class="pp-total-section">
                <div class="pp-total-label text-white">
                    <i class="fas fa-receipt" style="font-size:9px;"></i>
                    Total de venta
                </div>
                <div class="pp-total-amount zero" id="ventaa">
                    <small id="compracero" class="text-white">$0</small>
                    <small class="total-compra" id="total-compra" hidden></small>
                </div>
            </div>

            <div class="pp-divider"></div>

            <div class="pp-return-row" id="volver">
                <div>
                    <div class="pp-return-label text-white"><i class="fas fa-undo-alt" style="margin-right:4px;"></i>A devolver</div>
                </div>
                <div class="pp-return-amount text-white" id="devolver">$0</div>
            </div>

            <div class="pp-cash-label text-white">
                <i class="fas fa-money-bill-wave"></i>Recibo de efectivo
            </div>
            <input type="text" class="pp-cash-input text-white" id="recibio" placeholder="$0" oninput="formatearMiles(this)">

            <!-- Quick amounts -->
            <div class="pp-quick-amounts" id="pp-quick-amounts">
                <button class="pp-qa-btn text-white" onclick="setQuickAmount(5000)">EFECTIVO</button>
                <button class="pp-qa-btn text-white" onclick="setQuickAmount(10000)">TRANSFERENCIA</button>
                <button class="pp-qa-btn text-white" id="pp-qa-exact" onclick="setExactAmount()">DEBITO</button>
                <button class="pp-qa-btn text-white" onclick="setQuickAmount(20000)">CREDITO</button>
            </div>

            <div class="pp-meta">
                <div class="pp-meta-row">
                    <span class="k text-white"><i class="fas fa-user"></i>Vendedor</span>
                    <span class="v text-white"><?= session()->get('nombre').' '.session()->get('apellido') ?></span>
                </div>
                <div class="pp-meta-row">
                    <span class="k text-white"><i class="fas fa-calendar-day"></i>Fecha</span>
                    <span class="v text-white"><?= date('d/m/Y') ?></span>
                </div>
                <div class="pp-meta-row">
                    <span class="k text-white"><i class="fas fa-desktop"></i>Caja</span>
                    <?php $cajas = $caja->getResult(); $cajas = !empty($cajas) ? $cajas[0] : null; ?>
                    <span class="v text-white">Caja #<?= $cajas->codigo_caja ?? '—' ?></span>
                </div>
            </div>

            <label class="pp-print">
                <input type="checkbox" name="checkrecibocaja" id="checkrecibocaja" checked>
                <i class="fas fa-print" style="color:rgba(255,255,255,.4);font-size:12px;"></i>
                <span>Imprimir recibo al cobrar</span>
            </label>

            <button class="btn-pay" id="btn-pagar" onclick="crearVenta()">
                <div class="btn-pay-shimmer"></div>
                <i class="fas fa-check-circle"></i> VENDER
            </button>

        </div>

        <!-- Hidden elements for JS -->
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
</div>

</div><!-- /pos-root -->

<?php require_once("componentes/scripts.php")?>
<script src="<?= base_url('js/ventas.js') ?>"></script>

<script>
/* ── Reloj ── */
(function tick(){
    const el = document.getElementById('contador');
    if (!el) return;
    const days   = ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'];
    const months = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
    const d = new Date();
    const h = d.getHours().toString().padStart(2,'0');
    const m = d.getMinutes().toString().padStart(2,'0');
    el.textContent = days[d.getDay()] + ' ' + d.getDate() + ' ' + months[d.getMonth()] + '  ' + h + ':' + m;
    setTimeout(tick, 10000);
})();

/* ── Resize carrito ── */
(function(){
    const handle = document.getElementById('cart-handle');
    const cart   = document.getElementById('pos-cart');
    if (!handle || !cart) return;
    let startY, startH;
    handle.addEventListener('mousedown', function(e){
        startY = e.clientY; startH = cart.offsetHeight;
        document.body.style.userSelect = 'none';
        document.body.style.cursor = 'ns-resize';
        function onMove(e){
            const newH = Math.min(Math.max(startH + (startY - e.clientY), 160), window.innerHeight * 0.55);
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
        const rows  = tbody.querySelectorAll('tr:not(#emptyCartRow)');
        const count = rows.length;
        const countEl = document.getElementById('cartCount');
        if (countEl){
            countEl.textContent = count + (count === 1 ? ' ítem' : ' ítems');
            countEl.classList.toggle('has-items', count > 0);
        }
        const emptyRow = document.getElementById('emptyCartRow');
        if (emptyRow) emptyRow.style.display = count > 0 ? 'none' : '';

        let sub = 0;
        rows.forEach(function(tr){
            const q = tr.querySelector('.qty-input');
            const p = tr.querySelector('.price-cell');
            if (q && p) sub += (parseFloat(q.value) || 0) * (parseFloat((p.textContent||'0').replace(/[^0-9.]/g,'')) || 0);
        });
        const subEl = document.getElementById('cart-subtotal');
        if (subEl){
            const prev = subEl.textContent;
            subEl.textContent = '$' + sub.toLocaleString();
            if (prev !== subEl.textContent){
                subEl.style.transform = 'scale(1.15)';
                setTimeout(() => subEl.style.transform = '', 200);
            }
        }

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

/* ── Quick amounts ── */
function setQuickAmount(val){
    const inp = document.getElementById('recibio');
    if (!inp) return;
    inp.value = '$' + val.toLocaleString();
    inp.dispatchEvent(new Event('input'));
    inp.focus();
}
function setExactAmount(){
    const totalEl = document.getElementById('total');
    if (!totalEl) return;
    const v = parseFloat((totalEl.value||'0').replace(/[^0-9.]/g,'')) || 0;
    const inp = document.getElementById('recibio');
    if (!inp) return;
    inp.value = '$' + v.toLocaleString();
    inp.dispatchEvent(new Event('input'));
}

/* ── Toast al agregar producto ── */
var _toastTimer;
function showAddToast(nombre){
    const existing = document.querySelector('.add-toast');
    if (existing) existing.remove();
    if (_toastTimer) clearTimeout(_toastTimer);
    const t = document.createElement('div');
    t.className = 'add-toast';
    t.innerHTML = '<i class="fas fa-check" style="margin-right:6px;font-size:10px;"></i>' + nombre + ' añadido';
    document.body.appendChild(t);
    _toastTimer = setTimeout(function(){
        t.style.animation = 'toastOut .2s ease forwards';
        setTimeout(function(){ t.remove(); }, 200);
    }, 1600);
}

/* ══════════════════════════════
   PRODUCT BROWSER
══════════════════════════════ */
var allProducts = [];
var currentCat  = 'todos';

function getStockClass(s){
    if (s <= 0) return 'stock-zero';
    if (s <= 5) return 'stock-low';
    return 'stock-ok';
}
function getStockLabel(s){
    if (s <= 0) return 'Sin stock';
    if (s <= 5) return s + ' restantes';
    return 'Stock: ' + s;
}

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
        var stock  = parseInt(p.saldo || p.stock || 999);
        var sc     = getStockClass(stock);
        var sl     = getStockLabel(stock);
        return '<div class="prod-card" style="animation-delay:' + (i * 0.025) + 's" onclick="addFromCard(\'' + encodeCard(p) + '\')">' +
            '<div class="prod-card-icon"><i class="fas fa-tag"></i></div>' +
            '<div class="prod-card-add"><i class="fas fa-plus"></i></div>' +
            '<div class="prod-card-stock ' + sc + '">' + sl + '</div>' +
            '<div class="prod-card-name">' + nombre + '</div>' +
            (medida ? '<div class="prod-card-medida">' + medida + '</div>' : '') +
            '<div class="prod-card-price">$' + precio.toLocaleString() + '</div>' +
        '</div>';
    }).join('');
}

function encodeCard(p){
    return btoa(unescape(encodeURIComponent(JSON.stringify(p)))).replace(/'/g,"\'");
}
function addFromCard(b64){
    var p = JSON.parse(decodeURIComponent(escape(atob(b64))));
    seleccionarProducto({
        nombre:        p.nombre  || '',
        costo:         p.costo   || p.precio || 0,
        saldo:         p.saldo   || p.stock  || 999,
        codigo_barras: p.codigo_barras || p.codigo || '',
        medida:        p.medida  || '',
    });
    showAddToast((p.nombre || 'Producto').toUpperCase());
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
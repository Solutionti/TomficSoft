<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administracion - Horarios</title>
  <?php require_once("componentes/head.php") ?>
  <link
    href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap"
    rel="stylesheet">
<style>
        /* ══════════════════════════════════════
           DESIGN SYSTEM
        ══════════════════════════════════════ */
        :root {
            --purple-900: #0d2409;
            --purple-800: #173a10;
            --purple-700: #2d6622;
            --purple-600: #4a8a37;
            --purple-500: #7fac6e;
            --purple-400: #8fba7e;
            --purple-300: #abd49b;
            --purple-200: #d4eacc;
            --purple-100: #f0f7ec;
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
            --text:       #0d2409;
            --muted:      #7c6fa0;
            --shadow-sm:  0 1px 3px rgba(45,102,34,.08);
            --shadow-md:  0 4px 16px rgba(45,102,34,.12);
            --shadow-lg:  0 12px 40px rgba(45,102,34,.18);
            --radius:     14px;
            --radius-sm:  8px;
            --ease:       cubic-bezier(.4,0,.2,1);
        }

        * { box-sizing:border-box; margin:0; padding:0; }
        body { font-family:Arial, Helvetica; background:var(--surface-alt); color:var(--text); }
        h1,h2,h3,h4,h5,h6 { font-family:Arial, Helvetica; }
        ::-webkit-scrollbar { width:6px; height:6px; }
        ::-webkit-scrollbar-track { background:#f0f7ec; }
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
            font-family:Arial, Helvetica; font-size:16px;
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
            font-family: Arial, Helvetica, sans-serif;
            font-size:14px; font-weight:700; color:#d4eacc;
        }
        body {
            font-family: Arial, Helvetica;
            background: var(--surface-alt);
            color: var(--text-primary);
        }

        h1,h2,h3,h4,h5 { font-family: Arial, Helvetica, sans-serif; }

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
            font-family: Arial, Helvetica;
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
            box-shadow: 0 4px 14px rgba(74,138,55,.35);
        }
        .btn-inv-primary:hover {
            background: linear-gradient(135deg, var(--purple-700), var(--purple-600));
            box-shadow: 0 6px 20px rgba(74,138,55,.45);
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
            font-family: Arial, Helvetica;
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
            font-family: Arial, Helvetica, sans-serif;
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
            box-shadow: 0 4px 12px rgba(74,138,55,.4);
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
            font-family: Arial, Helvetica;
        }

        .modal-header-inv {
            background: linear-gradient(135deg, var(--purple-800), var(--purple-600)) !important;
            padding: 18px 24px;
            border-bottom: none;
        }

        .modal-header-inv .modal-title {
            font-family: Arial, Helvetica, sans-serif;
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
            font-family: Arial, Helvetica;
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
            box-shadow: 0 0 0 3px rgba(143,186,126,.15);
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
            font-family: Arial, Helvetica;
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
            box-shadow: 0 0 0 4px rgba(143,186,126,.12);
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
        ::-webkit-scrollbar-track { background: #f0f7ec; }
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

        /* Big total display */
        .pos-total-section { text-align:center; margin-bottom:28px; }

        .pos-total-label {
            font-size:10.5px; font-weight:700; text-transform:uppercase;
            letter-spacing:.1em; color:rgba(255,255,255,.6); margin-bottom:8px;
        }

        .pos-total-amount {
            font-family: Arial, Helvetica; 
            font-size:44px;
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
            font-family: Arial, Helvetica; font-size:28px;
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
            font-family: Arial, Helvetica;
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
        .pos-print-check input { width:15px; height:15px; accent-color:#8fba7e; cursor:pointer; }
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
            font-family:Arial, Helvetica; font-size:13px; color:var(--text);
            background:var(--surface); transition:all .25s var(--ease);
            outline:none; appearance:none;
        }
        .fc:focus, .fsel:focus { border-color:var(--purple-400); box-shadow:0 0 0 3px rgba(143,186,126,.15); }
        .fc[readonly], .fsel[readonly] { background:var(--purple-100); color:var(--purple-700); cursor:default; }

        /* Product search bar */
        .search-bar {
            display:flex; border:1.5px solid var(--purple-400);
            border-radius:var(--radius-sm); overflow:hidden;
            box-shadow:0 0 0 3px rgba(143,186,126,.12);
        }
        .search-bar input {
            flex:1; padding:9px 14px; border:none;
            font-family:Arial, Helvetica; font-size:14px;
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
            font-family:Arial, Helvetica; font-size:15px;
            font-weight:800; color:#92400e; width:100%;
        }

        /* Day select (read-only styled) */
        .day-display {
            background:linear-gradient(135deg,var(--purple-100),#ede0ff);
            border:1.5px solid var(--purple-200);
            border-radius:var(--radius-sm);
            padding:8px 12px;
            font-family:Arial, Helvetica;
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
            z-index:-1;
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
            font-family:Arial, Helvetica; font-size:10.5px;
            font-weight:700; letter-spacing:.06em; text-transform:uppercase;
            text-align:left; white-space:nowrap;
        }
        .cart-table tbody tr {
            border-bottom:1px solid #f0ebfa;
            transition:all .25s var(--ease);
        }
        .cart-table tbody tr:nth-child(even){background:#fdfaff;}
        .cart-table tbody tr:hover{background:linear-gradient(90deg,#f0f7ec,#fdf8ff) !important;}
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
            font-family:Arial, Helvetica; font-size:13px; font-weight:700;
            color:var(--purple-700); outline:none;
            transition:all .2s var(--ease);
        }
        .qty-input:focus { border-color:var(--purple-400); box-shadow:0 0 0 3px rgba(143,186,126,.15); }

        .price-cell {
            font-family:Arial, Helvetica; font-size:13px;
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
  <style>
    /* ══════════════════════════════════════
           DESIGN SYSTEM VARIABLES
        ══════════════════════════════════════ */
    :root {
      --purple-900: #0d2409;
      --purple-800: #173a10;
      --purple-700: #2d6622;
      --purple-600: #4a8a37;
      --purple-500: #7fac6e;
      --purple-400: #8fba7e;
      --purple-300: #abd49b;
      --purple-200: #d4eacc;
      --purple-100: #f0f7ec;
      --accent-green: #10b981;
      --accent-red: #ef4444;
      --accent-amber: #f59e0b;
      --accent-blue: #3b82f6;
      --surface: #ffffff;
      --surface-alt: #fafbff;
      --border: #e8e0f5;
      --text-primary: #0d2409;
      --text-muted: #7c6fa0;
      --shadow-sm: 0 1px 3px rgba(45, 102, 34, .08);
      --shadow-md: 0 4px 16px rgba(45, 102, 34, .12);
      --shadow-lg: 0 12px 40px rgba(45, 102, 34, .18);
      --radius: 14px;
      --radius-sm: 8px;
      --transition: all .25s cubic-bezier(.4, 0, .2, 1);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: Arial, Helvetica;
      background: var(--surface-alt);
      color: var(--text-primary);
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      font-family: Arial, Helvetica;
    }

    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }

    ::-webkit-scrollbar-track {
      background: #f0f7ec;
    }

    ::-webkit-scrollbar-thumb {
      background: var(--purple-400);
      border-radius: 99px;
    }

    /* ══════════════════════════════════════
           WRAPPER & TOP BAR
        ══════════════════════════════════════ */
    .usr-wrapper {
      padding: 26px 30px;
    }

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
      font-family: Arial, Helvetica;
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
      box-shadow: 0 4px 14px rgba(74, 138, 55, .35);
    }

    .btn-u-primary:hover {
      background: linear-gradient(135deg, var(--purple-700), var(--purple-600));
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(74, 138, 55, .45);
      color: #fff;
    }

    .btn-u-danger-outline {
      background: transparent;
      border: 1.5px solid var(--accent-red);
      color: var(--accent-red);
    }

    .btn-u-danger-outline:hover {
      background: var(--accent-red);
      color: #fff;
      transform: translateY(-1px);
    }

    .btn-u-success {
      background: linear-gradient(135deg, #059669, var(--accent-green));
      color: #fff;
      box-shadow: 0 4px 14px rgba(16, 185, 129, .3);
    }

    .btn-u-success:hover {
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(16, 185, 129, .4);
      color: #fff;
    }

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

    .stat-card:hover {
      border-color: var(--purple-300);
      box-shadow: var(--shadow-md);
      transform: translateY(-3px);
    }

    .stat-card:nth-child(1) {
      animation-delay: .05s;
    }

    .stat-card:nth-child(2) {
      animation-delay: .10s;
    }

    .stat-card:nth-child(3) {
      animation-delay: .15s;
    }

    .stat-card:nth-child(4) {
      animation-delay: .20s;
    }

    .stat-icon {
      width: 44px;
      height: 44px;
      border-radius: 11px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      flex-shrink: 0;
    }

    .stat-icon.purple {
      background: var(--purple-100);
      color: var(--purple-600);
    }

    .stat-icon.green {
      background: #d1fae5;
      color: #065f46;
    }

    .stat-icon.red {
      background: #fee2e2;
      color: #991b1b;
    }

    .stat-icon.blue {
      background: #dbeafe;
      color: #1e40af;
    }

    .stat-info .stat-num {
      font-family: Arial, Helvetica;
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

    .tbl-search:focus-within {
      border-color: var(--purple-400);
      box-shadow: 0 0 0 3px rgba(143, 186, 126, .12);
    }

    .tbl-search input {
      border: none;
      outline: none;
      font-family: Arial, Helvetica;
      font-size: 13px;
      color: var(--text-primary);
      background: transparent;
      width: 180px;
    }

    .tbl-search i {
      color: var(--text-muted);
      font-size: 13px;
    }

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
      font-family: Arial, Helvetica;
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
      from {
        opacity: 0;
        transform: translateX(-10px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .usr-table tbody tr:nth-child(1) {
      animation-delay: .30s;
    }

    .usr-table tbody tr:nth-child(2) {
      animation-delay: .36s;
    }

    .usr-table tbody tr:nth-child(3) {
      animation-delay: .42s;
    }

    .usr-table tbody tr:nth-child(4) {
      animation-delay: .48s;
    }

    .usr-table tbody tr:nth-child(5) {
      animation-delay: .54s;
    }

    .usr-table tbody tr:nth-child(6) {
      animation-delay: .60s;
    }

    .usr-table tbody tr:nth-child(7) {
      animation-delay: .66s;
    }

    .usr-table tbody tr:nth-child(8) {
      animation-delay: .72s;
    }

    .usr-table tbody tr:nth-child(even) {
      background: #fdfaff;
    }

    .usr-table tbody tr:hover {
      background: linear-gradient(90deg, #f0f7ec, #fdf8ff) !important;
    }

    .usr-table td {
      padding: 12px 16px;
      vertical-align: middle;
    }

    /* ══════════════════════════════════════
           USER AVATAR CELL
        ══════════════════════════════════════ */
    .user-cell {
      display: flex;
      align-items: center;
      gap: 11px;
    }

    .user-avatar-wrap {
      position: relative;
      flex-shrink: 0;
    }

    .user-avatar {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      object-fit: cover;
      border: 2px solid var(--purple-200);
      transition: var(--transition);
    }

    .usr-table tbody tr:hover .user-avatar {
      border-color: var(--purple-400);
      transform: scale(1.08);
    }

    .user-status-dot {
      position: absolute;
      bottom: -2px;
      right: -2px;
      width: 10px;
      height: 10px;
      border-radius: 50%;
      border: 2px solid #fff;
    }

    .dot-active {
      background: var(--accent-green);
    }

    .dot-inactive {
      background: #9ca3af;
    }

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
      content: '';
      width: 5px;
      height: 5px;
      border-radius: 50%;
      background: currentColor;
      opacity: .75;
    }

    .badge-success-u {
      background: #d1fae5;
      color: #065f46;
    }

    .badge-danger-u {
      background: #fee2e2;
      color: #991b1b;
    }

    .badge-primary-u {
      background: var(--purple-100);
      color: var(--purple-700);
    }

    .badge-amber-u {
      background: #fef3c7;
      color: #92400e;
    }

    /* ══════════════════════════════════════
           ACTION BUTTONS
        ══════════════════════════════════════ */
    .action-wrap {
      display: flex;
      gap: 6px;
      align-items: center;
    }

    .btn-action {
      width: 30px;
      height: 30px;
      border-radius: 8px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
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

    .btn-action-edit:hover {
      background: var(--purple-600);
      color: #fff;
      border-color: var(--purple-600);
      transform: rotate(8deg) scale(1.12);
      box-shadow: 0 4px 12px rgba(74, 138, 55, .4);
    }

    .btn-action-del {
      background: #fee2e2;
      color: var(--accent-red);
      border: 1.5px solid #fecaca;
    }

    .btn-action-del:hover {
      background: var(--accent-red);
      color: #fff;
      border-color: var(--accent-red);
      transform: scale(1.12);
      box-shadow: 0 4px 12px rgba(239, 68, 68, .35);
    }

    /* ══════════════════════════════════════
           MODAL SYSTEM
        ══════════════════════════════════════ */
    .modal-content {
      border: none;
      border-radius: var(--radius) !important;
      overflow: hidden;
      box-shadow: var(--shadow-lg);
      font-family: Arial, Helvetica;
    }

    .modal-header-inv {
      background: linear-gradient(135deg, var(--purple-800), var(--purple-600)) !important;
      padding: 17px 24px;
      border-bottom: none;
    }

    .modal-header-inv .modal-title {
      font-family: Arial, Helvetica;
      font-size: 14.5px;
      font-weight: 700;
      color: #fff;
      letter-spacing: .04em;
    }

    .modal-header-inv .btn-close {
      filter: invert(1);
      opacity: .85;
    }

    .modal-body {
      background: var(--surface-alt);
      padding: 24px;
    }

    .modal-footer {
      background: var(--surface);
      border-top: 1px solid var(--border);
      padding: 14px 24px;
    }

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
      width: 22px;
      height: 22px;
      background: var(--purple-100);
      border-radius: 6px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 10px;
      color: var(--purple-600);
    }

    /* Form labels and inputs */
    .fl {
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .fl label {
      font-size: 10.5px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .06em;
      color: var(--text-muted);
    }

    .fc,
    .fsel {
      width: 100%;
      padding: 8px 12px;
      border: 1.5px solid var(--border);
      border-radius: var(--radius-sm);
      font-family: Arial, Helvetica;
      font-size: 13px;
      color: var(--text-primary);
      background: var(--surface);
      transition: var(--transition);
      outline: none;
      appearance: none;
    }

    .fc:focus,
    .fsel:focus {
      border-color: var(--purple-400);
      box-shadow: 0 0 0 3px rgba(143, 186, 126, .15);
    }

    .fc[readonly] {
      background: var(--purple-100);
      color: var(--purple-700);
    }

    /* Password input group */
    .pass-group {
      display: flex;
      border: 1.5px solid var(--border);
      border-radius: var(--radius-sm);
      overflow: hidden;
      transition: var(--transition);
    }

    .pass-group:focus-within {
      border-color: var(--purple-400);
      box-shadow: 0 0 0 3px rgba(143, 186, 126, .15);
    }

    .pass-group input {
      flex: 1;
      padding: 8px 12px;
      border: none;
      font-family: Arial, Helvetica;
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

    .pass-group .pass-toggle:hover {
      background: var(--purple-200);
    }

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
      background: linear-gradient(135deg, var(--purple-800), var(--purple-700));
      color: #fff;
      padding: 11px 14px;
      text-align: left;
      font-family: Arial, Helvetica;
      font-size: 10.5px;
      font-weight: 700;
      letter-spacing: .06em;
      text-transform: uppercase;
      white-space: nowrap;
    }

    .perm-table tbody tr {
      border-bottom: 1px solid #f0ebfa;
      transition: var(--transition);
    }

    .perm-table tbody tr:nth-child(even) {
      background: #fdfaff;
    }

    .perm-table tbody tr:hover {
      background: linear-gradient(90deg, #f0f7ec, #fdf8ff) !important;
    }

    .perm-table td {
      padding: 10px 14px;
      vertical-align: middle;
    }

    .perm-module {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .perm-icon {
      width: 30px;
      height: 30px;
      border-radius: 8px;
      background: var(--purple-100);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--purple-600);
      font-size: 12px;
      flex-shrink: 0;
    }

    .perm-name {
      font-size: 13px;
      font-weight: 600;
      color: var(--text-primary);
    }

    .perm-sub {
      font-size: 11px;
      color: var(--text-muted);
    }

    .chk-perm {
      width: 16px;
      height: 16px;
      accent-color: var(--purple-600);
      cursor: pointer;
    }

    /* ══════════════════════════════════════
           ANIMATIONS
        ══════════════════════════════════════ */
    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(16px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .anim-1 {
      animation: slideUp .35s ease .04s both;
    }

    .anim-2 {
      animation: slideUp .35s ease .10s both;
    }

    .anim-3 {
      animation: slideUp .35s ease .18s both;
    }

    .color-morado {
      background: linear-gradient(135deg, var(--purple-800), var(--purple-700)) !important;
    }

    @media (max-width:768px) {
      .usr-wrapper {
        padding: 14px;
      }

      .usr-title {
        font-size: 20px;
      }

      .tbl-search {
        display: none;
      }
    }

    .form-section {
    position: relative;
    z-index: 10; /* Mayor que cualquier elemento debajo */
}

.cart-card {
    position: relative;
    z-index: 1; /* Menor que .form-section */
}
  </style>
</head>
<body>
  <div class="container-scroller">
    <?php require_once("componentes/navbar.php") ?>
    <div class="container-fluid page-body-wrapper">
      <?php require_once("componentes/lateralderecha.php") ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="usr-wrapper">

            <!-- ══════════ TOP BAR ══════════ -->
            <div class="usr-topbar anim-1">
              <div>
                <p class="usr-breadcrumb">Administración &rsaquo; CristalBusiness</p>
                <h1 class="">Solicitud de Inventarios</h1>
              </div>
              <div class="inv-topbar-actions">
                            <button class="btn-inv btn-inv-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                <i class="fas fa-minus-circle"></i>
                                <span class="label">Devoluciones</span>
                            </button>
                            <!-- este es para la persona que acepta el inventario -->
                            <button class="btn-inv btn-inv-outline-danger" data-bs-toggle="modal" data-bs-target="#modaldespachos">
                                <i class="fas fa-store"></i>
                                <span class="label">Despachos</span>
                            </button>
                            <!-- esta es para la persona que hace la solicitud -->
                            <button class="btn-inv btn-inv-success" data-bs-toggle="modal" data-bs-target="#modalsolicitudes">
                                <i class="fas fa-truck"></i>
                                <span class="label">Solicitudes</span>
                            </button>
                            
                        </div>
            </div>
            <!-- ══════════ TABLE CARD ══════════ -->
            <div class="usr-table-card anim-3">
                <div class="container">

                    <div class="row">
                        <div class="col-md-12 mt-3">
                         <!--  -->
                        <div class="form-section">
                  <div class="section-title" style="justify-content:space-between;">
                    <span><i class="fas fa-barcode"></i>Búsqueda de producto</span>
                    <button type="button" id="sol-btn-categorias" class="btn-inv btn-inv-primary" style="padding:6px 14px;font-size:12px;">
                      <i class="fas fa-th-large"></i> Por categoría
                    </button>
                  </div>
                  <div class="row g-3 align-items-end">
                      <div class="col-md-10">
                          <div class="fl" style="position:relative;">
                              <label class="req">Producto a solicitar</label>
                              <div class="search-bar">
                                  <input type="text" id="codigo_barras"
                                      placeholder="Escribe el nombre o código del producto…"
                                      autofocus autocomplete="off">
                                  <button type="button" data-bs-toggle="modal" data-bs-target="#modaldescripcion" title="Buscar en lista">
                                      <i class="fas fa-comments"></i>
                                  </button>
                              </div>
                              <div id="sol-producto-dropdown" style="
                                  display:none; position:absolute; top:100%; left:0; right:0; z-index:1050;
                                  background:#fff; border:1.5px solid #d4eacc; border-top:none;
                                  border-radius:0 0 10px 10px;
                                  box-shadow:0 8px 24px rgba(45,102,34,.12);
                                  max-height:220px; overflow-y:auto;"></div>
                          </div>
                      </div>
                      <div class="col-md-2">
                          <button
                            type="button"
                            class="btn btn-success w-100 btn-rounded" 
                            id="addToCartBtn">
                             <span class="fas fa-save"></span> Guardar
                          </button>
                      </div>    
                  </div>
              </div>
              
              <div class="cart-card ">
                  <div class="cart-header">
                      <h5>
                          <i class="fas fa-shopping-cart"></i>
                          Listado de solicitud
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
                              <th>Sucursal</th>
                              <th>Nombre producto</th>
                              <th>Unidad</th>
                              <th>Cantidad</th>
                              <th>Acciones</th>
                          </tr>
                      </thead>
                      <tbody class="tbody">
                          <!-- JS populated -->
                          <tr id="emptyCartRow">
                              <td colspan="7" class="cart-empty">
                                  <i class="fas fa-shopping-basket"></i>
                                  Aún no hay productos en el inventario.<br>
                                  <span style="font-size:12px;color:var(--purple-300);">Agrega un producto para comenzar</span>
                              </td>
                          </tr>
                      </tbody>
                  </table>
              </div>
                </div>
                  <!--  -->

                  </div>
                </div>
                <!-- aca cierra  -->
                  </div>
                </div>
              </div>
              <br>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ══════════════════════════════════════════════
     MODAL: DEVOLUCIONES
══════════════════════════════════════════════ -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header modal-header-inv">
          <h1 class="modal-title"><i class="fas fa-undo me-2"></i>Devoluciones</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <!-- Alerta -->
          <div id="dev-alerta" style="display:none;margin-bottom:14px;" class="alert alert-danger py-2 px-3"></div>

          <!-- Buscar solicitud -->
          <div class="form-section">
            <div class="form-section-title">
              <i class="fas fa-search"></i> Cargar solicitud a devolver
            </div>
            <div class="row g-3 align-items-end">
              <div class="col-md-4">
                <div class="fl">
                  <label>Código de solicitud *</label>
                  <input type="number" id="dev-cod-solicitud" class="fc" placeholder="Ingrese el numero de la solicitud" min="1">
                </div>
              </div>
              <div class="col-md-3">
                <button type="button" id="dev-btn-cargar" class="btn btn-primary btn-sm btn-rounded">
                  <span class="fas fa-download"></span> Buscar
                </button>
              </div>
              <div class="col-md-5">
                <div id="dev-solicitud-info" style="display:none;background:var(--purple-100);border:1.5px solid var(--purple-200);border-radius:8px;padding:8px 14px;font-size:12px;">
                  <strong>Solicitud #<span id="dev-info-codigo"></span></strong> &nbsp;·&nbsp;
                  Estado: <span id="dev-info-estado"></span> &nbsp;·&nbsp;
                  Fecha: <span id="dev-info-fecha"></span>
                </div>
              </div>
            </div>
          </div>

          <!-- Tabla de ítems -->
          <div class="cart-card">
            <div class="cart-header">
              <h5>
                <i class="fas fa-undo"></i>
                Productos a devolver
                <span class="cart-count" id="dev-count">0 productos</span>
              </h5>
              <div class="fl" style="flex-direction:row;align-items:center;gap:8px;">
                <label style="font-size:11px;color:var(--muted);margin:0;">Motivo general:</label>
                <input type="text" id="dev-motivo-global" placeholder="Ej: Producto dañado"
                  style="padding:5px 10px;border:1.5px solid var(--border);border-radius:6px;font-size:12px;width:220px;outline:none;">
              </div>
            </div>
            <table class="cart-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Código</th>
                  <th>Producto</th>
                  <th>Cant. solicitada</th>
                  <th>Cant. a devolver</th>
                  <th>Motivo específico</th>
                </tr>
              </thead>
              <tbody id="dev-tbody">
                <tr id="dev-empty-row">
                  <td colspan="6" class="cart-empty">
                    <i class="fas fa-box-open"></i>
                    Carga una solicitud para ver sus productos.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn-u btn-u-danger-outline" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Cerrar
          </button>
          <button type="button" id="dev-btn-guardar" class="btn-u btn-u-primary" disabled>
            <i class="fas fa-save"></i> Registrar devolución
          </button>
        </div>
      </div>
    </div>
  </div>

    <!-- ══════════════════════════════════════════════
     MODAL: SOLICITUDES
══════════════════════════════════════════════ -->
  <div class="modal fade" id="modalsolicitudes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header modal-header-inv">
          <h1 class="modal-title"><i class="fas fa-user-plus me-2"></i>Solicitudes</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <!-- SECCIÓN: Datos personales -->
          <div class="form-section">
            <div class="form-section-title">
              <i class="fas fa-id-card"></i> Solicitudes realizadas para aprobación
            </div>
            <div class="row g-3">
              <div class="col-md-12">
                <div class="cart-card ">
                  <div class="cart-header">
                      <h5>
                          <i class="fas fa-shopping-cart"></i>
                          Listado de solicitudes
                          <span class="cart-count" id="cartCount">0 Solicitudes</span>
                      </h5>
                      <span style="font-size:11px;color:var(--muted);">
                          <i class="fas fa-info-circle"></i>&nbsp;Las solicitudes se agregan automáticamente
                      </span>
                  </div>
                  <table class="cart-table">
                      <thead>
                          <tr>
                            <th>Código</th>
                            <th>Sucursal</th>
                              <th>Fecha</th>
                              <th>Hora</th>
                              <th>Estado</th>
                              <th>Usuario pidio</th>
                              <th>Usuario Acepto</th>
                              <th>Soli</th>
                              <th>Desp</th>
                              <th>Devol</th>
                              <th></th>
                          </tr>
                      </thead>
                      <tbody class="tbody">
                          <!-- <tr id="emptyCartRow">
                            <td colspan="6" class="cart-empty">
                              <i class="fas fa-shopping-basket"></i>
                                Aún no hay solicitudes en el inventario.<br>
                              <span style="font-size:12px;color:var(--purple-300);">Agrega una solicitud para comenzar</span>
                            </td>
                          </tr> -->
                           <?php foreach ($solicitudes->getResult() as $solicitud) : ?>
                          <tr class="text-uppercase">
                            <td><?= $solicitud->codigo_solicitud ?></td>
                            <td>Envigado</td>
                            <td><?= $solicitud->fecha_solicitud ?></td>
                            <td></td>
                            <td><?= $solicitud->estado ?></td>
                            <td><?= $solicitud->nombre.' '.$solicitud->apellido ?></td>
                            <td>aprobado por</td>
                            <td>
                              <button class="btn-action btn-action-edit"
                              title="PDF Solicitud"
                              onclick="window.open('/pdfsolicitudes?id=<?= $solicitud->codigo_solicitud ?>', '_blank')">
                              <i class="fas fa-file-pdf text-primary"></i>
                              </button>
                            </td>
                            <td><button class="btn-action btn-action-edit"
                              title="PDF Despacho"
                              onclick="window.open('/pdfdespachos?id=<?= $solicitud->codigo_solicitud ?>', '_blank')">
                              <i class="fas fa-file-pdf"></i>
                            </button></td>
                            <td><button class="btn-action btn-action-edit"
                              title="PDF Devolucion"
                              onclick="window.open('/pdfdevoluciones?id=<?= $solicitud->codigo_solicitud ?>', '_blank')">
                              <i class="fas fa-file-pdf text-danger"></i>
                            </button></td>
                            <td>
                          <div class="action-wrap">
                            <button class="btn-action btn-action-del"
                              title="Imprimir solicitud">
                              <i class="fas fa-trash"></i>
                            </button>
                          </div>
                        </td>
                          </tr>
                         <?php endforeach; ?>
                      </tbody>
                  </table>
              </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-u btn-u-danger-outline" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Cerrar
          </button>
          <button type="button" class="btn-u btn-u-primary" onclick="crearUsuarios()">
            <i class="fas fa-save"></i> Guardar
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- ══════════════════════════════════════════════
     MODAL: DESPACHOS
══════════════════════════════════════════════ -->
  <div class="modal fade" id="modaldespachos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header modal-header-inv">
          <h1 class="modal-title"><i class="fas fa-store me-2"></i>Despachos</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <!-- Alerta -->
          <div id="des-alerta" style="display:none;margin-bottom:14px;" class="alert alert-danger py-2 px-3"></div>

          <!-- Buscar solicitud -->
          <div class="form-section">
            <div class="form-section-title">
              <i class="fas fa-search"></i> Cargar solicitud a despachar
            </div>
            <div class="row g-3 align-items-end">
              <div class="col-md-4">
                <div class="fl">
                  <label>Código de solicitud *</label>
                  <input type="number" id="des-cod-solicitud" class="fc" placeholder="Ingrese el numero de la solicitud" min="1">
                </div>
              </div>
              <div class="col-md-3">
                <button type="button" id="des-btn-cargar" class="btn btn-primary btn-sm btn-rounded">
                  <span class="fas fa-download"></span> Buscar
                </button>
              </div>
              <div class="col-md-5">
                <div id="des-solicitud-info" style="display:none;background:var(--purple-100);border:1.5px solid var(--purple-200);border-radius:8px;padding:8px 14px;font-size:12px;">
                  <strong>Solicitud #<span id="des-info-codigo"></span></strong> &nbsp;·&nbsp;
                  Estado: <span id="des-info-estado"></span> &nbsp;·&nbsp;
                  Fecha: <span id="des-info-fecha"></span>
                </div>
              </div>
            </div>
          </div>

          <!-- Tabla de ítems -->
          <div class="cart-card">
            <div class="cart-header">
              <h5>
                <i class="fas fa-store"></i>
                Productos a despachar
                <span class="cart-count" id="des-count">0 productos</span>
              </h5>
              <div class="fl" style="flex-direction:row;align-items:center;gap:8px;">
                <label style="font-size:11px;color:var(--muted);margin:0;">Comentario general:</label>
                <input type="text" id="des-comentario-global" placeholder="Ej: Despacho urgente"
                  style="padding:5px 10px;border:1.5px solid var(--border);border-radius:6px;font-size:12px;width:220px;outline:none;">
              </div>
            </div>
            <table class="cart-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Código</th>
                  <th>Producto</th>
                  <th>Cant. solicitada</th>
                  <th>Cant. a despachar</th>
                  <th>Comentario</th>
                </tr>
              </thead>
              <tbody id="des-tbody">
                <tr id="des-empty-row">
                  <td colspan="6" class="cart-empty">
                    <i class="fas fa-box-open"></i>
                    Carga una solicitud para ver sus productos.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn-u btn-u-danger-outline" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Cerrar
          </button>
          <button type="button" id="des-btn-guardar" class="btn-u btn-u-primary" disabled>
            <i class="fas fa-save"></i> Registrar despacho
          </button>
        </div>
      </div>
    </div>
  </div>


  
  <!-- ══════════════════════════════════════════════
     MODAL: DESPACHOS
══════════════════════════════════════════════ -->
  <div class="modal fade" id="modaldescripcion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header modal-header-inv">
          <h1 class="modal-title"><i class="fas fa-user-plus me-2"></i>Comentarios</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <!-- SECCIÓN: Datos personales -->
          <div class="form-section">
            <div class="form-section-title">
              <i class="fas fa-id-card"></i> Adicional de la solicitud
            </div>
            <div class="row g-3">
              <div class="col-md-12">
                <div class="fl">
                  <label>Comentarios *</label>
                  <textarea  id="comentarios_solicitud" class="fc" rows="5"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-u btn-u-danger-outline" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Cerrar
          </button>
          <button type="button" class="btn-u btn-u-primary" data-bs-dismiss="modal">
             Aceptar
          </button>
        </div>
      </div>
    </div>
  </div>

<!-- ══ MODAL CATEGORÍAS SOLICITUD ══ -->
<div class="modal fade" id="solModalCategorias" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content" style="border:none;border-radius:14px;overflow:hidden;">
      <div class="modal-header modal-header-inv">
        <h5 class="modal-title" style="color:#fff;font-weight:700;font-size:15px;"><i class="fas fa-th-large me-2"></i>Agregar por categoría</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter:invert(1);"></button>
      </div>
      <div class="modal-body" style="padding:0;display:grid;grid-template-columns:220px 1fr;min-height:440px;">

        <!-- Categorías -->
        <div id="sol-cat-lista" style="border-right:1.5px solid var(--border);background:var(--surface-alt);overflow-y:auto;max-height:540px;padding:10px 8px;">
          <p style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--muted);padding:4px 8px 8px;">Categorías</p>
          <div id="sol-cat-loading" style="padding:16px;text-align:center;color:var(--muted);font-size:13px;">
            <i class="fas fa-spinner fa-spin"></i> Cargando…
          </div>
        </div>

        <!-- Productos -->
        <div style="display:flex;flex-direction:column;">
          <div style="padding:10px 14px;border-bottom:1.5px solid var(--border);background:var(--purple-100);display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <span style="font-size:13px;font-weight:700;color:var(--purple-800);display:flex;align-items:center;gap:6px;">
              <i class="fas fa-boxes"></i>
              <span id="sol-cat-nombre">Selecciona una categoría</span>
            </span>
            <div style="margin-left:auto;display:flex;align-items:center;gap:0;border:1.5px solid var(--border);border-radius:8px;overflow:hidden;background:#fff;min-width:200px;">
              <input type="text" id="sol-cat-buscador" placeholder="Buscar producto…" autocomplete="off"
                style="flex:1;padding:7px 11px;border:none;font-size:13px;font-family:Arial,Helvetica;outline:none;color:var(--text);">
              <span style="padding:0 10px;color:var(--muted);font-size:13px;"><i class="fas fa-search"></i></span>
            </div>
          </div>
          <div style="flex:1;overflow-y:auto;max-height:490px;">
            <table style="width:100%;border-collapse:collapse;font-size:13px;">
              <thead>
                <tr style="background:var(--purple-100);position:sticky;top:0;">
                  <th style="padding:9px 14px;text-align:left;font-size:11px;font-weight:700;text-transform:uppercase;color:var(--purple-800);">Producto</th>
                  <th style="padding:9px 14px;text-align:left;font-size:11px;font-weight:700;text-transform:uppercase;color:var(--purple-800);">Cód. Interno</th>
                  <th style="padding:9px 14px;text-align:center;font-size:11px;font-weight:700;text-transform:uppercase;color:var(--purple-800);">Stock</th>
                  <th style="padding:9px 14px;text-align:center;">
                    <label style="display:inline-flex;align-items:center;gap:5px;cursor:pointer;font-size:11px;font-weight:700;text-transform:uppercase;color:var(--purple-800);white-space:nowrap;">
                      <input type="checkbox" id="sol-check-all" style="width:16px;height:16px;accent-color:var(--purple-600);cursor:pointer;"> Todo
                    </label>
                  </th>
                </tr>
              </thead>
              <tbody id="sol-cat-tbody">
                <tr><td colspan="4" style="text-align:center;padding:40px 20px;color:var(--muted);font-size:13px;">
                  <i class="fas fa-hand-point-left" style="font-size:22px;opacity:.3;display:block;margin-bottom:8px;"></i>Elige una categoría
                </td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <span id="sol-sel-count" style="font-size:12px;color:var(--muted);margin-right:auto;">0 productos seleccionados</span>
        <button type="button" class="btn-u btn-u-danger-outline" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" id="sol-btn-agregar-sel" class="btn-u btn-u-primary" disabled>
          <i class="fas fa-plus"></i> Agregar seleccionados
        </button>
      </div>
    </div>
  </div>
</div>

  <?php require_once("componentes/scripts.php") ?>
  <script src="<?= base_url('js/solicitud_inventarios.js') ?>"></script>
  <script src="<?= base_url('js/devoluciones.js') ?>"></script>
  <script src="<?= base_url('js/despachos.js') ?>"></script>

  <script>
    let carrito = [];
    document.addEventListener('DOMContentLoaded', () => {
      const tbody = document.querySelector('#table_usuarios tbody');
      if (!tbody) return;

      const rows = Array.from(tbody.querySelectorAll('tr'));
      const total = rows.length;
      let active = 0, inactive = 0, admins = 0;

      rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        // Estado = last td (index 7), Rol = index 6
        const estadoTxt = row.querySelector('.badge-u') ? row.querySelectorAll('.badge-u') : [];
        const tds = row.querySelectorAll('td');
        if (tds.length >= 8) {
          const estadoCell = tds[7].textContent.trim();
          const rolCell = tds[6].textContent.trim();
          if (estadoCell.toLowerCase().includes('activo')) active++;
          else inactive++;
          if (rolCell.toLowerCase().includes('admin')) admins++;
        }
      });

      document.getElementById('statTotal').textContent = total;
      document.getElementById('statActive').textContent = active;
      document.getElementById('statInactive').textContent = inactive;
      document.getElementById('statAdmin').textContent = admins;
      document.getElementById('countPill').textContent = total;

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

  <script>
  (function () {
    var input    = document.getElementById('codigo_barras');
    var dropdown = document.getElementById('sol-producto-dropdown');
    if (!input || !dropdown) return;

    var timer = null;

    /* ── Autocomplete ── */
    input.addEventListener('input', function () {
      clearTimeout(timer);
      var q = input.value.trim();
      if (q.length < 2) { dropdown.style.display = 'none'; return; }

      timer = setTimeout(function () {
        fetch('/desechos/buscar?q=' + encodeURIComponent(q))
          .then(function (r) { return r.json(); })
          .then(function (data) {
            if (!data.length) { dropdown.style.display = 'none'; return; }

            dropdown.innerHTML = data.map(function (p) {
              return '<div class="sol-ac-item"' +
                ' data-codigo="' + (p.codigo_interno || '') + '"' +
                ' data-nombre="' + p.nombre.replace(/"/g, '&quot;') + '"' +
                ' data-ref="'   + (p.referencia || '') + '"' +
                ' data-medida="' + (p.medida || '') + '"' +
                ' style="padding:9px 14px;cursor:pointer;border-bottom:1px solid #f0f7ec;font-size:13px;">' +
                '<div style="font-weight:600;color:#0d2409;">' + p.nombre + '</div>' +
                '<div style="font-size:11px;color:#7c6fa0;">Cód: ' + (p.codigo_interno || '—') +
                (p.referencia ? ' · ' + p.referencia : '') +
                (p.medida ? ' · <strong>' + p.medida + '</strong>' : '') + '</div>' +
                '</div>';
            }).join('');

            dropdown.style.display = 'block';

            dropdown.querySelectorAll('.sol-ac-item').forEach(function (item) {
              item.addEventListener('mouseenter', function () { item.style.background = '#f0f7ec'; });
              item.addEventListener('mouseleave', function () { item.style.background = ''; });
              item.addEventListener('mousedown', function (e) {
                e.preventDefault();
                agregarAlCarrito(item.dataset.codigo, item.dataset.nombre, item.dataset.ref, item.dataset.medida);
                input.value = '';
                dropdown.style.display = 'none';
                input.focus();
              });
            });
          })
          .catch(function () { dropdown.style.display = 'none'; });
      }, 250);
    });

    /* Cerrar al hacer clic fuera */
    document.addEventListener('click', function (e) {
      if (!input.contains(e.target) && !dropdown.contains(e.target))
        dropdown.style.display = 'none';
    });

    /* Navegación con teclado */
    input.addEventListener('keydown', function (e) {
      var items  = Array.from(dropdown.querySelectorAll('.sol-ac-item'));
      if (!items.length || dropdown.style.display === 'none') return;
      var active = dropdown.querySelector('.sol-ac-active');
      var idx    = items.indexOf(active);

      if (e.key === 'ArrowDown') {
        e.preventDefault();
        if (active) { active.classList.remove('sol-ac-active'); active.style.background = ''; }
        idx = (idx + 1) % items.length;
        items[idx].classList.add('sol-ac-active'); items[idx].style.background = '#f0f7ec';
      } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        if (active) { active.classList.remove('sol-ac-active'); active.style.background = ''; }
        idx = (idx - 1 + items.length) % items.length;
        items[idx].classList.add('sol-ac-active'); items[idx].style.background = '#f0f7ec';
      } else if (e.key === 'Enter' && active) {
        e.preventDefault();
        agregarAlCarrito(active.dataset.codigo, active.dataset.nombre, active.dataset.ref, active.dataset.medida);
        input.value = '';
        dropdown.style.display = 'none';
        input.focus();
      } else if (e.key === 'Escape') {
        dropdown.style.display = 'none';
      }
    });

    /* ── Carrito ── */
    function agregarAlCarrito(codigo, nombre, referencia, medida) {
      var tbody    = document.querySelector('.tbody');
      var emptyRow = document.getElementById('emptyCartRow');
      if (!tbody) return;

      /* Evitar duplicados */
      if (tbody.querySelector('[data-sol-codigo="' + codigo + '"]')) {
        return;
      }

      if (emptyRow) emptyRow.style.display = 'none';

      var rowNum = tbody.querySelectorAll('tr:not(#emptyCartRow)').length + 1;
      var tr     = document.createElement('tr');
      tr.dataset.solCodigo = codigo;
      tr.innerHTML =
        '<td style="color:var(--muted);font-size:12px;text-align:center;">' + rowNum + '</td>' +
        '<td><code style="font-size:12px;">' + (codigo || '—') + '</code></td>' +
        '<td style="font-size:12px;color:var(--muted);">ENVIGADO</td>' +
        '<td style="font-weight:600;">' + nombre + '</td>' +
        '<td><span style="display:inline-block;padding:2px 9px;border-radius:99px;font-size:11px;font-weight:700;background:var(--purple-100);color:var(--purple-700);">' + (medida || '—') + '</span></td>' +
        '<td><input type="number" min="1" value="1" style="width:65px;padding:4px 8px;' +
          'border:1.5px solid #d4eacc;border-radius:6px;font-size:13px;text-align:center;"></td>' +
        '<td><button type="button" onclick="this.closest(\'tr\').remove();actualizarContador();"' +
          ' style="background:#fee2e2;color:#991b1b;border:none;border-radius:6px;' +
          'padding:4px 10px;cursor:pointer;font-size:12px;">' +
          '<i class="fas fa-trash"></i></button></td>';
      tbody.appendChild(tr);
      actualizarContador();

      carrito.push({
        codigo: codigo,
        nombre: nombre,
        referencia: referencia,
        medida: medida || '',
        cantidad: 1
      });
    }

    window.agregarAlCarrito = agregarAlCarrito;

    window.actualizarContador = function () {
      var total    = document.querySelectorAll('.tbody tr:not(#emptyCartRow)').length;
      var badge    = document.getElementById('cartCount');
      var emptyRow = document.getElementById('emptyCartRow');
      if (badge)    badge.textContent = total + ' Producto' + (total !== 1 ? 's' : '');
      if (emptyRow) emptyRow.style.display = total === 0 ? '' : 'none';
    };
  })();
  </script>

  <script>
  /* ══════════════════════════════════════
     MODAL CATEGORÍAS — SOLICITUD
  ══════════════════════════════════════ */
  (function () {
    var modalEl   = document.getElementById('solModalCategorias');
    var modal     = null;
    var seleccionados = {}; // codigo_interno -> producto

    document.getElementById('sol-btn-categorias').addEventListener('click', function () {
      seleccionados = {};
      actualizarSelCount();
      if (!modal) modal = new bootstrap.Modal(modalEl);
      modal.show();
      cargarCategorias();
    });

    function cargarCategorias() {
      var lista   = document.getElementById('sol-cat-lista');
      var loading = document.getElementById('sol-cat-loading');
      loading.style.display = 'block';

      fetch(baseurl + 'consumos/categorias')
        .then(function (r) { return r.json(); })
        .then(function (cats) {
          loading.style.display = 'none';
          cats.forEach(function (cat) {
            var div = document.createElement('div');
            div.style.cssText = 'padding:9px 12px;border-radius:8px;cursor:pointer;font-size:13px;font-weight:500;color:var(--text);transition:all .2s;margin-bottom:3px;display:flex;align-items:center;gap:8px;';
            div.innerHTML = '<span style="width:8px;height:8px;border-radius:50%;background:var(--purple-400);flex-shrink:0;display:inline-block;"></span>' + cat.nombre;
            div.addEventListener('mouseenter', function () { if (!div.classList.contains('sol-cat-active')) div.style.background = 'var(--purple-200)'; });
            div.addEventListener('mouseleave', function () { if (!div.classList.contains('sol-cat-active')) div.style.background = ''; });
            div.addEventListener('click', function () {
              lista.querySelectorAll('.sol-cat-active').forEach(function (el) {
                el.classList.remove('sol-cat-active');
                el.style.background = '';
                el.style.color = 'var(--text)';
              });
              div.classList.add('sol-cat-active');
              div.style.background = 'linear-gradient(135deg,var(--purple-600),var(--purple-500))';
              div.style.color = '#fff';
              document.getElementById('sol-cat-nombre').textContent = cat.nombre;
              document.getElementById('sol-cat-buscador').value = '';
              cargarProductos(cat.codigo_categoria);
            });
            lista.appendChild(div);
          });
        });
    }

    function cargarProductos(codigo) {
      var tbody = document.getElementById('sol-cat-tbody');
      tbody.innerHTML = '<tr><td colspan="4" style="text-align:center;padding:30px;color:var(--muted);"><i class="fas fa-spinner fa-spin"></i> Cargando…</td></tr>';
      document.getElementById('sol-check-all').checked = false;
      document.getElementById('sol-check-all').indeterminate = false;

      fetch(baseurl + 'consumos/categoria/' + encodeURIComponent(codigo))
        .then(function (r) { return r.json(); })
        .then(function (prods) {
          tbody.innerHTML = '';
          if (!prods.length) {
            tbody.innerHTML = '<tr><td colspan="4" style="text-align:center;padding:30px;color:var(--muted);">Sin productos en esta categoría.</td></tr>';
            return;
          }
          prods.forEach(function (p) {
            var yaEnCarrito = !!document.querySelector('.tbody [data-sol-codigo="' + p.codigo_interno + '"]');
            var seleccionado = !!seleccionados[p.codigo_interno];
            var saldo = parseFloat(p.saldo) || 0;
            var badgeColor = saldo > 10 ? '#065f46' : saldo > 0 ? '#92400e' : '#991b1b';
            var badgeBg    = saldo > 10 ? '#d1fae5' : saldo > 0 ? '#fef3c7' : '#fee2e2';

            var tr = document.createElement('tr');
            tr.style.borderBottom = '1px solid var(--purple-100)';
            tr.dataset.nombre = p.nombre.toLowerCase();
            tr.dataset.codigo = (p.codigo_interno || '').toLowerCase();

            tr.innerHTML =
              '<td style="padding:10px 14px;font-weight:600;">' + p.nombre + '</td>' +
              '<td style="padding:10px 14px;color:var(--muted);font-size:12px;">' + (p.codigo_interno || '—') + '</td>' +
              '<td style="padding:10px 14px;text-align:center;">' +
                '<span style="display:inline-block;padding:2px 8px;border-radius:99px;font-size:11px;font-weight:700;background:' + badgeBg + ';color:' + badgeColor + ';">' + saldo + '</span>' +
              '</td>' +
              '<td style="padding:10px 14px;text-align:center;">' +
                (yaEnCarrito
                  ? '<span style="font-size:11px;color:var(--purple-500);font-weight:600;">Ya agregado</span>'
                  : '<input type="checkbox" class="sol-cat-check" style="width:16px;height:16px;accent-color:var(--purple-600);cursor:pointer;"' +
                    ' data-codigo="' + (p.codigo_interno || '') + '"' +
                    ' data-nombre="' + p.nombre.replace(/"/g, '&quot;') + '"' +
                    ' data-medida="' + (p.medida || '') + '"' +
                    (seleccionado ? ' checked' : '') + '>'
                ) +
              '</td>';

            var chk = tr.querySelector('.sol-cat-check');
            if (chk) {
              chk.addEventListener('change', function () {
                if (this.checked) seleccionados[this.dataset.codigo] = { codigo: this.dataset.codigo, nombre: this.dataset.nombre, medida: this.dataset.medida || '' };
                else delete seleccionados[this.dataset.codigo];
                sincronizarCheckAll();
                actualizarSelCount();
              });
            }
            tbody.appendChild(tr);
          });
          sincronizarCheckAll();
        });
    }

    /* Buscador interno */
    document.getElementById('sol-cat-buscador').addEventListener('input', function () {
      var q = this.value.trim().toLowerCase();
      document.querySelectorAll('#sol-cat-tbody tr').forEach(function (tr) {
        var n = tr.dataset.nombre || '';
        var c = tr.dataset.codigo || '';
        tr.style.display = (n.includes(q) || c.includes(q)) ? '' : 'none';
      });
    });

    /* Check-all */
    document.getElementById('sol-check-all').addEventListener('change', function () {
      var marcar = this.checked;
      document.querySelectorAll('#sol-cat-tbody .sol-cat-check').forEach(function (chk) {
        chk.checked = marcar;
        if (marcar) seleccionados[chk.dataset.codigo] = { codigo: chk.dataset.codigo, nombre: chk.dataset.nombre, medida: chk.dataset.medida || '' };
        else delete seleccionados[chk.dataset.codigo];
      });
      actualizarSelCount();
    });

    function sincronizarCheckAll() {
      var all  = document.querySelectorAll('#sol-cat-tbody .sol-cat-check');
      var marc = Array.from(all).filter(function (c) { return c.checked; }).length;
      var ca   = document.getElementById('sol-check-all');
      if (!all.length) { ca.checked = false; ca.indeterminate = false; return; }
      if (marc === 0)           { ca.checked = false; ca.indeterminate = false; }
      else if (marc === all.length) { ca.checked = true;  ca.indeterminate = false; }
      else                      { ca.checked = false; ca.indeterminate = true; }
    }

    function actualizarSelCount() {
      var n = Object.keys(seleccionados).length;
      document.getElementById('sol-sel-count').textContent = n + (n === 1 ? ' producto seleccionado' : ' productos seleccionados');
      document.getElementById('sol-btn-agregar-sel').disabled = n === 0;
    }

    /* Agregar al carrito */
    document.getElementById('sol-btn-agregar-sel').addEventListener('click', function () {
      var agregados = 0;
      Object.values(seleccionados).forEach(function (p) {
        if (!document.querySelector('.tbody [data-sol-codigo="' + p.codigo + '"]')) {
          agregarAlCarrito(p.codigo, p.nombre, '', p.medida || '');
          agregados++;
        }
      });
      if (modal) modal.hide();
      if (agregados > 0) {
        $("body").overhang({ type: "success", message: agregados + (agregados === 1 ? ' producto agregado' : ' productos agregados') + ' a la solicitud.' });
      }
    });

    /* Limpiar al cerrar */
    modalEl.addEventListener('hidden.bs.modal', function () {
      seleccionados = {};
      actualizarSelCount();
      document.getElementById('sol-cat-loading').style.display = 'block';
      document.getElementById('sol-cat-loading').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cargando…';
      document.getElementById('sol-cat-lista').querySelectorAll('.sol-cat-active, div[style]').forEach(function (el) {
        if (el.id !== 'sol-cat-loading') el.remove();
      });
      document.getElementById('sol-cat-tbody').innerHTML =
        '<tr><td colspan="4" style="text-align:center;padding:40px 20px;color:var(--muted);">Elige una categoría</td></tr>';
      document.getElementById('sol-cat-nombre').textContent = 'Selecciona una categoría';
      document.getElementById('sol-cat-buscador').value = '';
    });
  })();
  </script>
</body>

</html>
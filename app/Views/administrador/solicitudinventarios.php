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
                <p class="usr-breadcrumb">Administración &rsaquo; InventSoft</p>
                <h1 class="">Solicitud de Inventarios</h1>
              </div>
              <div class="inv-topbar-actions">
                            <button class="btn-inv btn-inv-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                <i class="fas fa-plus-circle"></i>
                                <span class="label">Devoluciones</span>
                            </button>
                            <button class="btn-inv btn-inv-success" data-bs-toggle="modal" data-bs-target="#modalasgignacionescrear">
                                <i class="fas fa-map-marker-alt"></i>
                                <span class="label">Historial</span>
                            </button>
                            <button class="btn-inv btn-inv-outline-danger" data-bs-toggle="modal" data-bs-target="#modalProceso">
                                <i class="fas fa-chart-bar"></i>
                                <span class="label">Despachos</span>
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
                  <div class="section-title"><i class="fas fa-barcode"></i>Búsqueda de producto</div>
                  <div class="row g-3 align-items-end">
                      <div class="col-md-12">
                          <div class="fl" style="position:relative;">
                              <label class="req">Producto a solicitar</label>
                              <div class="search-bar">
                                  <input type="text" id="codigo_barras"
                                      placeholder="Escribe el nombre o código del producto…"
                                      autofocus autocomplete="off">
                                  <button type="button" data-bs-toggle="modal" data-bs-target="#listaproductos" title="Buscar en lista">
                                      <i class="fas fa-store"></i>
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
                  </div>
              </div>
              <div class="cart-card">
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
                              <th>Cantidad</th>
                              <th>Acciones</th>
                          </tr>
                      </thead>
                      <tbody class="tbody">
                          <!-- JS populated -->
                          <tr id="emptyCartRow">
                              <td colspan="6" class="cart-empty">
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
     MODAL: CREAR USUARIO
══════════════════════════════════════════════ -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header modal-header-inv">
          <h1 class="modal-title"><i class="fas fa-user-plus me-2"></i>Productos organicos</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <!-- SECCIÓN: Datos personales -->
          <div class="form-section">
            <div class="form-section-title">
              <i class="fas fa-id-card"></i> Productos a desechar
            </div>
            <div class="row g-3">
              <div class="col-md-4">
                <div class="fl">
                  <label>Codigo *</label>
                  <input type="number" id="codigo_producto" class="fc" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="fl">
                  <label>Nombre del producto *</label>
                  <input type="text" id="nombre_producto" class="fc" required>
                </div>
              </div>
              <div class="col-md-2">
                <div class="fl">
                  <label>Unidades *</label>
                  <input type="text" id="unidades_producto" class="fc" required>
                </div>
              </div>
              
              <div class="col-md-2">
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
                  <label>Comentarios *</label>
                  <input type="email" id="correo" class="fc">
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
     MODAL: ACTUALIZAR USUARIO
══════════════════════════════════════════════ -->
  <div class="modal fade" id="actualizarUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
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
                  <input type="date" id="fecha_usuario_actualizar" class="fc" value="<?php echo date('Y-m-d') ?>"
                    readonly>
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
              <!--  -->
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

  <?php require_once("componentes/scripts.php") ?>
  <script src="<?= base_url('js/usuarios.js') ?>"></script>

  <script>
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
                ' style="padding:9px 14px;cursor:pointer;border-bottom:1px solid #f0f7ec;font-size:13px;">' +
                '<div style="font-weight:600;color:#0d2409;">' + p.nombre + '</div>' +
                '<div style="font-size:11px;color:#7c6fa0;">Cód: ' + (p.codigo_interno || '—') +
                (p.referencia ? ' · ' + p.referencia : '') + '</div>' +
                '</div>';
            }).join('');

            dropdown.style.display = 'block';

            dropdown.querySelectorAll('.sol-ac-item').forEach(function (item) {
              item.addEventListener('mouseenter', function () { item.style.background = '#f0f7ec'; });
              item.addEventListener('mouseleave', function () { item.style.background = ''; });
              item.addEventListener('mousedown', function (e) {
                e.preventDefault();
                agregarAlCarrito(item.dataset.codigo, item.dataset.nombre, item.dataset.ref);
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
        agregarAlCarrito(active.dataset.codigo, active.dataset.nombre, active.dataset.ref);
        input.value = '';
        dropdown.style.display = 'none';
        input.focus();
      } else if (e.key === 'Escape') {
        dropdown.style.display = 'none';
      }
    });

    /* ── Carrito ── */
    function agregarAlCarrito(codigo, nombre, referencia) {
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
        '<td><input type="number" min="1" value="1" style="width:65px;padding:4px 8px;' +
          'border:1.5px solid #d4eacc;border-radius:6px;font-size:13px;text-align:center;"></td>' +
        '<td><button type="button" onclick="this.closest(\'tr\').remove();actualizarContador();"' +
          ' style="background:#fee2e2;color:#991b1b;border:none;border-radius:6px;' +
          'padding:4px 10px;cursor:pointer;font-size:12px;">' +
          '<i class="fas fa-trash"></i></button></td>';
      tbody.appendChild(tr);
      actualizarContador();
    }

    window.actualizarContador = function () {
      var total    = document.querySelectorAll('.tbody tr:not(#emptyCartRow)').length;
      var badge    = document.getElementById('cartCount');
      var emptyRow = document.getElementById('emptyCartRow');
      if (badge)    badge.textContent = total + ' Producto' + (total !== 1 ? 's' : '');
      if (emptyRow) emptyRow.style.display = total === 0 ? '' : 'none';
    };
  })();
  </script>
</body>

</html>
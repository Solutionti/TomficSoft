<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>InventSoft – Pedidos</title>
  <?php require_once("componentes/head.php")?>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
  <style>

  /* ╔══════════════════════════════════════════════════════╗
     ║  VARIABLES & BASE                                    ║
     ╚══════════════════════════════════════════════════════╝ */
  :root {
    --v:          #5b2fc9;
    --v2:         #3d1d8a;
    --v3:         #7c55e0;
    --v-glow:     rgba(91,47,201,.18);
    --v-soft:     rgba(91,47,201,.08);
    --v-mid:      rgba(91,47,201,.14);
    --green:      #0fa968;
    --green-s:    rgba(15,169,104,.12);
    --amber:      #c97c0f;
    --amber-s:    rgba(201,124,15,.1);
    --blue:       #1a7fd4;
    --blue-s:     rgba(26,127,212,.1);
    --red:        #d03350;
    --red-s:      rgba(208,51,80,.1);
    --teal:       #0abfa3;

    --bg:         #f5f3fc;
    --surface:    #ffffff;
    --surface2:   #faf8ff;
    --border:     rgba(91,47,201,.12);
    --border2:    rgba(91,47,201,.2);

    --ink:        #1a1040;
    --ink2:       #4a3d72;
    --ink3:       #8b7db5;

    --r:  12px;
    --r2: 8px;
    --r3: 6px;
  }

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    background: var(--bg);
    color: var(--ink);
    font-family: 'Outfit', sans-serif;
    font-size: 14px;
    min-height: 100vh;
  }

  /* subtle mesh bg */
  body::before {
    content: '';
    position: fixed; inset: 0; z-index: 0; pointer-events: none;
    background:
      radial-gradient(ellipse 55% 45% at 5%  0%,  rgba(91,47,201,.09) 0%, transparent 65%),
      radial-gradient(ellipse 35% 35% at 95% 100%, rgba(10,191,163,.06) 0%, transparent 60%),
      radial-gradient(ellipse 40% 30% at 50% 50%,  rgba(91,47,201,.03) 0%, transparent 80%);
  }

  /* ╔══════════════════════════════════════════════════════╗
     ║  PAGE WRAPPER & ANIMATIONS                           ║
     ╚══════════════════════════════════════════════════════╝ */
  .pw {
    position: relative; z-index: 1;
    padding: 24px 28px;
  }

  @keyframes up {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0);    }
  }
  @keyframes scale-in {
    from { opacity: 0; transform: scale(.96); }
    to   { opacity: 1; transform: scale(1);   }
  }
  @keyframes slide-right {
    from { opacity: 0; transform: translateX(-12px); }
    to   { opacity: 1; transform: translateX(0);     }
  }
  @keyframes pulse-ring {
    0%   { box-shadow: 0 0 0 0 rgba(91,47,201,.35); }
    70%  { box-shadow: 0 0 0 8px rgba(91,47,201,0); }
    100% { box-shadow: 0 0 0 0 rgba(91,47,201,0); }
  }
  @keyframes blink {
    0%,100% { opacity: 1; }
    50%     { opacity: .35; }
  }
  @keyframes spin {
    to { transform: rotate(360deg); }
  }

  /* ╔══════════════════════════════════════════════════════╗
     ║  HEADER                                              ║
     ╚══════════════════════════════════════════════════════╝ */
  .hdr {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 14px;
    animation: up .5s ease both;
  }

  .hdr-left { display: flex; align-items: center; gap: 14px; }

  .hdr-badge {
    width: 44px; height: 44px;
    background: linear-gradient(140deg, var(--v), var(--v2));
    border-radius: 13px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; color: #fff;
    box-shadow: 0 6px 20px var(--v-glow);
    position: relative; flex-shrink: 0;
  }
  .hdr-badge::after {
    content: '';
    position: absolute; inset: -1px;
    border-radius: 14px;
    background: linear-gradient(140deg, rgba(255,255,255,.3), transparent);
    pointer-events: none;
  }

  .hdr-info { line-height: 1.2; }
  .hdr-info h1 {
    font-size: 20px; font-weight: 800;
    color: var(--ink); letter-spacing: -.02em;
  }
  .hdr-info p {
    font-size: 11.5px; font-weight: 400;
    color: var(--ink3); letter-spacing: .02em;
    margin-top: 2px;
  }

  .hdr-crumb {
    display: flex; align-items: center; gap: 7px;
    font-size: 12px; color: var(--ink3);
  }
  .hdr-crumb a {
    color: var(--v3); text-decoration: none;
    transition: color .2s;
  }
  .hdr-crumb a:hover { color: var(--v); }
  .hdr-crumb-sep { color: var(--border2); font-size: 14px; }

  /* ╔══════════════════════════════════════════════════════╗
     ║  STAT CARDS                                          ║
     ╚══════════════════════════════════════════════════════╝ */
  .stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 22px;
  }
  @media (max-width: 900px) { .stats { grid-template-columns: repeat(2,1fr); } }
  @media (max-width: 480px) { .stats { grid-template-columns: 1fr; } }

  .stat {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r);
    padding: 16px 18px;
    display: flex; align-items: center; gap: 13px;
    position: relative; overflow: hidden;
    cursor: default;
    transition: border-color .25s, box-shadow .25s, transform .2s;
    animation: up .5s ease both;
  }
  .stat:nth-child(1) { animation-delay: .0s }
  .stat:nth-child(2) { animation-delay: .05s }
  .stat:nth-child(3) { animation-delay: .10s }
  .stat:nth-child(4) { animation-delay: .15s }

  .stat::before {
    content: '';
    position: absolute; left: 0; top: 0; bottom: 0;
    width: 3px;
    border-radius: 99px 0 0 99px;
    background: var(--stat-color, var(--v));
    opacity: 0;
    transition: opacity .25s;
  }
  .stat:hover {
    border-color: var(--stat-color, var(--v));
    box-shadow: 0 0 0 3px rgba(91,47,201,.08), 0 4px 20px rgba(0,0,0,.05);
    transform: translateY(-2px);
  }
  .stat:hover::before { opacity: 1; }

  .stat-icon {
    width: 42px; height: 42px; border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; flex-shrink: 0;
    background: var(--stat-bg, var(--v-soft));
    color: var(--stat-color, var(--v));
    transition: transform .2s;
  }
  .stat:hover .stat-icon { transform: scale(1.08) rotate(-4deg); }

  .stat-body { min-width: 0; }
  .stat-val {
    font-size: 26px; font-weight: 800;
    color: var(--ink); letter-spacing: -.03em;
    line-height: 1;
    font-variant-numeric: tabular-nums;
  }
  .stat-lbl {
    font-size: 11px; font-weight: 500;
    color: var(--ink3); letter-spacing: .03em;
    margin-top: 3px; text-transform: uppercase;
  }

  .stat-trend {
    position: absolute; top: 14px; right: 14px;
    font-size: 10px; font-weight: 600;
    color: var(--stat-color, var(--v));
    background: var(--stat-bg, var(--v-soft));
    padding: 2px 7px; border-radius: 99px;
  }

  /* ╔══════════════════════════════════════════════════════╗
     ║  MAIN GRID                                           ║
     ╚══════════════════════════════════════════════════════╝ */
  .main-grid {
    display: grid;
    grid-template-columns: 1fr 292px;
    gap: 16px;
    align-items: start;
  }
  @media (max-width: 980px) { .main-grid { grid-template-columns: 1fr; } }

  /* ╔══════════════════════════════════════════════════════╗
     ║  TABLE CARD                                          ║
     ╚══════════════════════════════════════════════════════╝ */
  .tcard {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r);
    overflow: hidden;
    animation: up .5s .08s ease both;
  }

  .tcard-top {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
    gap: 12px; flex-wrap: wrap;
  }

  .tcard-title {
    display: flex; align-items: center; gap: 9px;
    font-size: 13px; font-weight: 700;
    color: var(--ink); letter-spacing: .01em;
  }
  .tcard-title-icon {
    width: 30px; height: 30px; border-radius: 8px;
    background: var(--v-soft);
    display: flex; align-items: center; justify-content: center;
    color: var(--v); font-size: 12px;
  }

  .tcard-actions { display: flex; align-items: center; gap: 8px; }

  .search-box {
    position: relative;
  }
  .search-box input {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: var(--r2);
    color: var(--ink);
    padding: 7px 13px 7px 32px;
    font-size: 12.5px;
    width: 190px;
    outline: none;
    font-family: 'Outfit', sans-serif;
    transition: border-color .2s, box-shadow .2s, width .3s;
  }
  .search-box input:focus {
    border-color: var(--v);
    box-shadow: 0 0 0 3px var(--v-glow);
    width: 220px;
  }
  .search-box input::placeholder { color: var(--ink3); }
  .search-box i {
    position: absolute; left: 10px; top: 50%; transform: translateY(-50%);
    color: var(--ink3); font-size: 11px; pointer-events: none;
  }

  /* ── Table ── */
  .tbl-wrap { overflow-x: auto; }

  table.tbl {
    width: 100%; border-collapse: collapse;
  }

  table.tbl thead th {
    padding: 11px 16px;
    font-size: 10.5px; font-weight: 700;
    letter-spacing: .08em; text-transform: uppercase;
    color: var(--ink3);
    background: var(--surface2);
    border-bottom: 1px solid var(--border);
    white-space: nowrap;
    user-select: none;
  }
  table.tbl thead th:first-child { border-radius: 0; }

  table.tbl tbody tr {
    border-bottom: 1px solid rgba(91,47,201,.055);
    transition: background .15s;
    animation: slide-right .3s ease both;
  }
  /* stagger rows */
  table.tbl tbody tr:nth-child(1)  { animation-delay: .05s }
  table.tbl tbody tr:nth-child(2)  { animation-delay: .08s }
  table.tbl tbody tr:nth-child(3)  { animation-delay: .11s }
  table.tbl tbody tr:nth-child(4)  { animation-delay: .14s }
  table.tbl tbody tr:nth-child(5)  { animation-delay: .17s }
  table.tbl tbody tr:nth-child(6)  { animation-delay: .20s }
  table.tbl tbody tr:nth-child(7)  { animation-delay: .23s }
  table.tbl tbody tr:nth-child(8)  { animation-delay: .26s }
  table.tbl tbody tr:nth-child(9)  { animation-delay: .29s }
  table.tbl tbody tr:nth-child(10) { animation-delay: .32s }

  table.tbl tbody tr:hover { background: rgba(91,47,201,.035); }
  table.tbl tbody tr:last-child { border-bottom: none; }

  table.tbl tbody td {
    padding: 12px 16px;
    color: var(--ink);
    font-size: 13px;
    vertical-align: middle;
    white-space: nowrap;
  }

  /* ── Consecutive ── */
  .consec {
    font-family: 'JetBrains Mono', monospace;
    font-size: 12px; font-weight: 500;
    color: var(--v);
    background: var(--v-soft);
    padding: 3px 8px; border-radius: 5px;
    letter-spacing: .02em;
  }

  /* ── Amount ── */
  .amount {
    font-family: 'JetBrains Mono', monospace;
    font-size: 12.5px; font-weight: 500;
    color: var(--green);
  }

  /* ── Date/Time ── */
  .dt {
    font-family: 'JetBrains Mono', monospace;
    font-size: 11.5px; color: var(--ink3);
  }

  /* ── Badges ── */
  .badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 9px; border-radius: 99px;
    font-size: 10.5px; font-weight: 600; letter-spacing: .04em;
    text-transform: uppercase; white-space: nowrap;
  }
  .badge i { font-size: 9px; }
  .badge.v  { background: var(--v-soft);    color: var(--v);     border: 1px solid rgba(91,47,201,.2); }
  .badge.g  { background: var(--green-s);   color: var(--green); border: 1px solid rgba(15,169,104,.22); }
  .badge.a  { background: var(--amber-s);   color: var(--amber); border: 1px solid rgba(201,124,15,.22); }
  .badge.b  { background: var(--blue-s);    color: var(--blue);  border: 1px solid rgba(26,127,212,.2); }
  .badge.r  { background: var(--red-s);     color: var(--red);   border: 1px solid rgba(208,51,80,.2); }

  /* status dot inside badge */
  .badge .bdot {
    width: 5px; height: 5px; border-radius: 50%;
    background: currentColor;
  }
  .badge.a .bdot { animation: blink 1.6s infinite; }

  /* ── Action buttons ── */
  .acts { display: flex; gap: 5px; align-items: center; }

  .act-btn {
    width: 29px; height: 29px;
    display: inline-flex; align-items: center; justify-content: center;
    border-radius: var(--r3); border: none; cursor: pointer;
    font-size: 11.5px;
    transition: transform .15s, box-shadow .15s, background .15s;
    text-decoration: none;
    position: relative;
  }
  .act-btn:hover { transform: translateY(-2px); }

  .act-btn.pdf { background: rgba(91,47,201,.1); color: var(--v); }
  .act-btn.pdf:hover { background: rgba(91,47,201,.18); box-shadow: 0 4px 12px var(--v-glow); }

  .act-btn.eye { background: rgba(26,127,212,.1); color: var(--blue); }
  .act-btn.eye:hover { background: rgba(26,127,212,.18); box-shadow: 0 4px 12px var(--blue-s); }

  .act-btn.wa { background: rgba(37,211,102,.12); color: #1aad5d; }
  .act-btn.wa:hover { background: rgba(37,211,102,.22); box-shadow: 0 4px 12px rgba(37,211,102,.25); }

  /* tooltip */
  .act-btn::before {
    content: attr(title);
    position: absolute; bottom: calc(100% + 6px); left: 50%; transform: translateX(-50%);
    background: var(--ink); color: #fff;
    font-size: 10px; font-weight: 500; padding: 3px 7px;
    border-radius: 5px; white-space: nowrap;
    opacity: 0; pointer-events: none;
    transition: opacity .15s;
  }
  .act-btn:hover::before { opacity: 1; }

  /* ── Checkbox CxC ── */
  .cxc-dot {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 11.5px; font-weight: 600; color: var(--blue);
    font-family: 'JetBrains Mono', monospace;
  }
  .cxc-dot i { font-size: 10px; }

  /* ╔══════════════════════════════════════════════════════╗
     ║  RIGHT PANEL                                         ║
     ╚══════════════════════════════════════════════════════╝ */
  .rpanel {
    display: flex; flex-direction: column; gap: 14px;
    animation: up .5s .15s ease both;
  }

  /* ── Clock card ── */
  .clock-card {
    background: linear-gradient(140deg, var(--v2) 0%, var(--v) 55%, #9066f5 100%);
    border-radius: var(--r);
    padding: 20px 20px 16px;
    position: relative; overflow: hidden;
    box-shadow: 0 10px 36px rgba(91,47,201,.32), 0 2px 8px rgba(0,0,0,.08);
  }

  /* decorative circles */
  .clock-card::before,
  .clock-card::after {
    content: ''; position: absolute; border-radius: 50%;
    border: 1px solid rgba(255,255,255,.1);
  }
  .clock-card::before { width: 180px; height: 180px; top: -70px; right: -50px; }
  .clock-card::after  { width: 110px; height: 110px; bottom: -40px; right: 16px; }

  .clock-top {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 12px;
  }

  .live-pill {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.22);
    border-radius: 99px;
    padding: 3px 10px;
    font-size: 9.5px; font-weight: 700;
    letter-spacing: .12em; color: #fff;
    backdrop-filter: blur(6px);
  }

  .live-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: #7fffca;
    animation: pulse-ring 2s infinite;
  }

  .clock-date {
    font-size: 11px; color: rgba(255,255,255,.65);
    letter-spacing: .03em;
  }

  .clock-time {
    font-family: 'JetBrains Mono', monospace;
    font-size: 38px; font-weight: 500;
    color: #fff;
    letter-spacing: .04em;
    line-height: 1;
    margin-bottom: 6px;
    position: relative; z-index: 1;
    text-shadow: 0 2px 12px rgba(0,0,0,.15);
  }

  /* blinking colon */
  .clock-time .colon { animation: blink 1s step-end infinite; }

  .clock-sub {
    font-size: 10.5px; color: rgba(255,255,255,.45);
    letter-spacing: .03em;
  }

  /* ══════════════════════════════════════════
     ACTIVITY FEED — redesign
  ══════════════════════════════════════════ */
  .feed-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r);
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(91,47,201,.05);
  }

  /* ── Header ── */
  .feed-hdr {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 16px 13px;
    background: linear-gradient(105deg, rgba(91,47,201,.06) 0%, rgba(91,47,201,.02) 100%);
    border-bottom: 1px solid var(--border);
  }

  .feed-hdr-left { display: flex; align-items: center; gap: 10px; }

  /* icon pill in header */
  .feed-hdr-icon {
    width: 28px; height: 28px; border-radius: 8px;
    background: linear-gradient(135deg, var(--v), var(--v2));
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; color: #fff;
    box-shadow: 0 3px 10px var(--v-glow);
    flex-shrink: 0;
  }

  .feed-hdr-text { }
  .feed-title {
    font-size: 12px; font-weight: 700;
    color: var(--ink); letter-spacing: .01em;
    line-height: 1.1;
  }
  .feed-subtitle {
    font-size: 10px; color: var(--ink3);
    margin-top: 1px; letter-spacing: .02em;
  }

  .feed-hdr-right { display: flex; align-items: center; gap: 6px; }

  .feed-badge {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 20px; height: 20px; padding: 0 6px;
    border-radius: 99px;
    background: var(--v);
    color: #fff;
    font-size: 9px; font-weight: 700;
    font-family: 'JetBrains Mono', monospace;
    letter-spacing: .03em;
    box-shadow: 0 2px 8px var(--v-glow);
    transition: transform .15s;
  }
  .feed-badge.bump { animation: scale-in .25s ease both; }

  .feed-refresh {
    width: 28px; height: 28px;
    border: 1px solid var(--border);
    background: var(--surface);
    border-radius: var(--r3);
    color: var(--ink3); cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px;
    transition: color .2s, background .2s, border-color .2s, transform .4s;
  }
  .feed-refresh:hover {
    color: var(--v); background: var(--v-soft);
    border-color: rgba(91,47,201,.3);
  }
  .feed-refresh.spinning i { animation: spin .45s cubic-bezier(.5,0,.5,1); }

  /* ── Body / timeline ── */
  .feed-body {
    padding: 8px 0 8px;
    max-height: 308px;
    overflow-y: auto;
    position: relative;
  }

  /* dashed vertical rail */
  .feed-body::before {
    content: '';
    position: absolute;
    left: 34px; top: 0; bottom: 0; width: 1px;
    background: repeating-linear-gradient(
      to bottom,
      rgba(91,47,201,.14) 0px,
      rgba(91,47,201,.14) 4px,
      transparent 4px,
      transparent 9px
    );
    pointer-events: none;
  }

  /* ── Empty state ── */
  .feed-empty {
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    padding: 38px 20px; gap: 10px;
  }
  .feed-empty-icon {
    width: 44px; height: 44px; border-radius: 12px;
    background: var(--v-soft);
    display: flex; align-items: center; justify-content: center;
    color: var(--v); font-size: 17px; opacity: .5;
  }
  .feed-empty span {
    font-size: 11.5px; color: var(--ink3);
    letter-spacing: .02em; text-align: center; line-height: 1.5;
  }

  /* ── Feed item ── */
  .fi {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 7px 14px 7px 14px;
    position: relative;
    transition: background .15s;
    animation: fi-in .25s cubic-bezier(.22,.61,.36,1) both;
    cursor: default;
  }
  .fi:hover { background: rgba(91,47,201,.03); }

  @keyframes fi-in {
    from { opacity: 0; transform: translateX(10px); }
    to   { opacity: 1; transform: translateX(0);    }
  }

  /* ── Icon pill (replaces bare dot) ── */
  .fi-icon {
    width: 28px; height: 28px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; flex-shrink: 0;
    background: var(--fi-bg, var(--v-soft));
    color: var(--fi-c, var(--v));
    position: relative; z-index: 1;
    transition: transform .2s;
    margin-top: 1px;
    box-shadow: 0 1px 4px rgba(0,0,0,.06);
  }
  .fi:hover .fi-icon { transform: scale(1.08); }

  /* ── Content ── */
  .fi-body { flex: 1; min-width: 0; }

  .fi-status {
    font-size: 9px; font-weight: 700;
    letter-spacing: .09em; text-transform: uppercase;
    color: var(--fi-c, var(--v));
    line-height: 1; margin-bottom: 2px;
  }
  .fi-name {
    font-size: 12.5px; font-weight: 500;
    color: var(--ink);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    line-height: 1.3;
  }

  /* ── Timestamp chip ── */
  .fi-time {
    flex-shrink: 0; margin-top: 2px;
    display: inline-flex; align-items: center;
    gap: 3px;
    font-family: 'JetBrains Mono', monospace;
    font-size: 9.5px; color: var(--ink3);
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 5px;
    padding: 2px 6px;
    white-space: nowrap;
  }
  .fi-time i { font-size: 8px; opacity: .6; }

  /* ── Thin separator between consecutive items ── */
  .fi + .fi::before {
    content: '';
    position: absolute;
    top: 0; left: 52px; right: 0;
    height: 1px;
    background: rgba(91,47,201,.05);
  }

  /* ── Status bars card ── */
  .status-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r);
    padding: 16px 18px;
  }

  .status-card-title {
    font-size: 11px; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase;
    color: var(--ink3);
    margin-bottom: 14px;
    display: flex; align-items: center; gap: 8px;
  }

  .sb-list { display: flex; flex-direction: column; gap: 11px; }

  .sb-row {}
  .sb-meta {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 5px;
  }
  .sb-name {
    display: flex; align-items: center; gap: 6px;
    font-size: 12px; font-weight: 500; color: var(--ink2);
  }
  .sb-pip {
    width: 7px; height: 7px; border-radius: 50%;
    background: var(--pip, var(--v));
  }
  .sb-count {
    font-family: 'JetBrains Mono', monospace;
    font-size: 11.5px; font-weight: 500;
    color: var(--pip, var(--v));
  }
  .sb-track {
    height: 5px;
    background: rgba(91,47,201,.07);
    border-radius: 99px; overflow: hidden;
  }
  .sb-fill {
    height: 100%; border-radius: 99px;
    background: var(--pip, var(--v));
    width: 0;
    transition: width .9s cubic-bezier(.22,.61,.36,1);
    position: relative;
  }
  /* shimmer on bar */
  .sb-fill::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,.35) 50%, transparent 100%);
    animation: shimmer 2.5s infinite;
    background-size: 200% 100%;
  }
  @keyframes shimmer {
    0%   { background-position: -200% 0; }
    100% { background-position:  200% 0; }
  }

  /* ╔══════════════════════════════════════════════════════╗
     ║  SCROLLBAR                                           ║
     ╚══════════════════════════════════════════════════════╝ */
  ::-webkit-scrollbar { width: 5px; height: 5px; }
  ::-webkit-scrollbar-track { background: transparent; }
  ::-webkit-scrollbar-thumb { background: rgba(91,47,201,.18); border-radius: 99px; }
  ::-webkit-scrollbar-thumb:hover { background: rgba(91,47,201,.32); }

  /* ╔══════════════════════════════════════════════════════╗
     ║  MODAL                                               ║
     ╚══════════════════════════════════════════════════════╝ */
  .modal-content {
    background: var(--surface2) !important;
    border: 1px solid var(--border) !important;
    border-radius: var(--r) !important;
    color: var(--ink) !important;
    box-shadow: 0 32px 80px rgba(0,0,0,.14), 0 0 0 1px rgba(91,47,201,.08) !important;
  }

  .modal-header {
    background: linear-gradient(110deg, var(--v2), var(--v)) !important;
    border-bottom: none !important;
    border-radius: var(--r) var(--r) 0 0 !important;
    padding: 18px 22px !important;
  }
  .modal-header .modal-title {
    font-family: 'Outfit', sans-serif !important;
    font-size: 14px !important; font-weight: 700 !important;
    letter-spacing: .04em !important;
    display: flex; align-items: center; gap: 9px;
    color: #fff !important;
  }
  .modal-header .modal-title i { opacity: .8; font-size: 15px; }

  .modal-body { padding: 22px !important; }
  .modal-footer {
    border-top: 1px solid var(--border) !important;
    padding: 14px 22px !important; gap: 8px;
  }

  .msec {
    border: 1px solid var(--border);
    border-radius: var(--r2);
    padding: 14px;
    margin-bottom: 12px;
    background: rgba(91,47,201,.025);
  }
  .msec-label {
    font-size: 10px; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase;
    color: var(--v3);
    margin-bottom: 12px;
    display: flex; align-items: center; gap: 6px;
  }
  .msec-label i { font-size: 11px; }

  .modal label {
    font-size: 10.5px; font-weight: 600;
    letter-spacing: .05em; text-transform: uppercase;
    color: var(--ink3); margin-bottom: 4px; display: block;
  }

  .modal .form-control,
  .modal select {
    background: #fff !important;
    border: 1px solid rgba(91,47,201,.18) !important;
    border-radius: var(--r2) !important;
    color: var(--ink) !important;
    font-size: 13px !important; padding: 8px 11px !important;
    font-family: 'Outfit', sans-serif !important;
    transition: border-color .2s, box-shadow .2s;
    width: 100%;
  }
  .modal .form-control:focus,
  .modal select:focus {
    border-color: var(--v) !important;
    box-shadow: 0 0 0 3px var(--v-glow) !important;
    outline: none !important;
  }
  .modal .form-control[readonly],
  .modal select[readonly] {
    background: #f7f5fd !important; opacity: .85; cursor: default;
  }
  .modal select option { background: #fff; }

  .modal .form-check-input {
    background: #fff !important;
    border-color: rgba(91,47,201,.3) !important;
    width: 15px; height: 15px;
  }
  .modal .form-check-input:checked {
    background-color: var(--v) !important;
    border-color: var(--v) !important;
  }
  .modal .form-check-label {
    color: var(--ink) !important; font-size: 13px !important;
    text-transform: none !important; letter-spacing: 0 !important;
  }

  .modal-table thead th {
    background: rgba(91,47,201,.07);
    color: var(--v);
    font-size: 10.5px; letter-spacing: .07em; text-transform: uppercase;
    font-family: 'Outfit', sans-serif; font-weight: 700;
    padding: 9px 13px;
  }
  .modal-table tbody td { padding: 9px 13px; font-size: 13px; color: var(--ink); }
  .modal-table tbody tr { border-bottom: 1px solid rgba(91,47,201,.06); }

  .btn-cancel {
    background: var(--bg);
    border: 1px solid var(--border);
    color: var(--ink2);
    padding: 8px 18px; border-radius: var(--r2);
    font-size: 13px; font-weight: 500;
    cursor: pointer; font-family: 'Outfit', sans-serif;
    transition: background .2s, border-color .2s;
    display: flex; align-items: center; gap: 6px;
  }
  .btn-cancel:hover { background: #ece8f8; border-color: var(--v3); }

  .btn-save {
    background: linear-gradient(135deg, var(--v), var(--v2));
    border: none; color: #fff;
    padding: 8px 20px; border-radius: var(--r2);
    font-size: 13px; font-weight: 600;
    cursor: pointer; font-family: 'Outfit', sans-serif;
    box-shadow: 0 4px 16px var(--v-glow);
    transition: box-shadow .2s, transform .15s;
    display: flex; align-items: center; gap: 6px;
  }
  .btn-save:hover { box-shadow: 0 6px 24px rgba(91,47,201,.35); transform: translateY(-1px); }

  /* ╔══════════════════════════════════════════════════════╗
     ║  RESPONSIVE                                          ║
     ╚══════════════════════════════════════════════════════╝ */
  @media (max-width: 600px) {
    .pw { padding: 14px; }
    .search-box input { width: 140px; }
    .clock-time { font-size: 30px; }
  }

  </style>
</head>
<body>
<div class="container-scroller">
  <?php require_once("componentes/navbar.php")?>
  <div class="container-fluid page-body-wrapper">
    <?php require_once("componentes/lateralderecha.php")?>

    <div class="main-panel">
      <div class="pw">

        <!-- ══ HEADER ══ -->
        <div class="hdr">
          <div class="hdr-left">
            <div class="hdr-badge"><i class="fas fa-shopping-bag"></i></div>
            <div class="hdr-info">
              <h1>Pedidos</h1>
              <p>InventSoft · Panel de administración</p>
            </div>
          </div>
          <nav class="hdr-crumb">
            <a href="#">Administración</a>
            <span class="hdr-crumb-sep">›</span>
            <a href="#">InventSoft</a>
            <span class="hdr-crumb-sep">›</span>
            <span>Pedidos</span>
          </nav>
        </div>

        <!-- ══ STATS ══ -->
        <div class="stats" id="statsGrid">
          <div class="stat" style="--stat-color:var(--v); --stat-bg:var(--v-soft)">
            <div class="stat-icon"><i class="fas fa-inbox"></i></div>
            <div class="stat-body">
              <div class="stat-val" id="s-total">—</div>
              <div class="stat-lbl">Total pedidos</div>
            </div>
          </div>
          <div class="stat" style="--stat-color:var(--green); --stat-bg:var(--green-s)">
            <div class="stat-icon"><i class="fas fa-circle-check"></i></div>
            <div class="stat-body">
              <div class="stat-val" id="s-entregados">—</div>
              <div class="stat-lbl">Entregados</div>
            </div>
          </div>
          <div class="stat" style="--stat-color:var(--blue); --stat-bg:var(--blue-s)">
            <div class="stat-icon"><i class="fas fa-motorcycle"></i></div>
            <div class="stat-body">
              <div class="stat-val" id="s-camino">—</div>
              <div class="stat-lbl">En camino</div>
            </div>
          </div>
          <div class="stat" style="--stat-color:var(--amber); --stat-bg:var(--amber-s)">
            <div class="stat-icon"><i class="fas fa-fire-burner"></i></div>
            <div class="stat-body">
              <div class="stat-val" id="s-prep">—</div>
              <div class="stat-lbl">Preparación</div>
            </div>
          </div>
        </div>

        <!-- ══ MAIN GRID ══ -->
        <div class="main-grid">

          <!-- ── TABLE CARD ── -->
          <div class="tcard">
            <div class="tcard-top">
              <div class="tcard-title">
                <div class="tcard-title-icon"><i class="fas fa-list-ul"></i></div>
                Listado de pedidos
              </div>
              <div class="tcard-actions">
                <div class="search-box">
                  <i class="fas fa-magnifying-glass"></i>
                  <input type="text" id="buscar" placeholder="Buscar pedido…">
                </div>
              </div>
            </div>

            <div class="tbl-wrap">
              <table class="tbl" id="table-pedidos">
                <thead>
                  <tr>
                    <th>Opciones</th>
                    <th>Consec.</th>
                    <th>Tipo pago</th>
                    <th>Total</th>
                    <th>C×C</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($pedidos->getResult() as $pedido): ?>
                    <?php
                      $estado = strtoupper($pedido->estado);
                      $bCls = match($estado) {
                        'PEDIDO'      => 'v',
                        'PREPARACION' => 'a',
                        'EN CAMINO'   => 'b',
                        'CANCELADO'   => 'r',
                        default       => 'v'
                      };
                      $bIcon = match($estado) {
                        'PEDIDO'      => 'fa-circle-dot',
                        'PREPARACION' => 'fa-fire-burner',
                        'EN CAMINO'   => 'fa-motorcycle',
                        'CANCELADO'   => 'fa-xmark',
                        default       => 'fa-circle'
                      };
                    ?>
                    <tr>
                      <td>
                        <div class="acts">
                          <button class="act-btn pdf" title="Generar PDF">
                            <i class="fas fa-file-pdf"></i>
                          </button>
                          <button
                            class="act-btn eye"
                            onclick="verPedido('<?= $pedido->codigo_pedido ?>')"
                            title="Ver detalle"
                          ><i class="fas fa-eye"></i></button>
                          <a
                            class="act-btn wa"
                            target="_blank"
                            href="https://wa.me/+57<?= $pedido->codigo_cliente ?>?text=Hola hemos recibido tu pedido. Revisa el detalle del pedido en el siguiente link <?= $pedido->link ?> opcion *Rastrear Pedido,* Con su numero de celular podra conocer el estado en tiempo real de su pedido.gracias por su compra."
                            title="Enviar WhatsApp"
                          ><i class="fab fa-whatsapp"></i></a>
                        </div>
                      </td>
                      <td><span class="consec">#<?= $pedido->consecutivo ?></span></td>
                      <td><span class="badge g"><span class="bdot"></span><?= $pedido->tppago ?></span></td>
                      <td><span class="amount">$<?= number_format($pedido->total, 0, ',', '.') ?></span></td>
                      <td><span class="cxc-dot"><i class="fas fa-check-circle"></i> SÍ</span></td>
                      <td><span class="dt"><?= $pedido->fecha ?></span></td>
                      <td><span class="dt"><?= $pedido->hora ?></span></td>
                      <td>
                        <span class="badge <?= $bCls ?>">
                          <span class="bdot"></span>
                          <i class="fas <?= $bIcon ?>"></i>
                          <?= $pedido->estado ?>
                        </span>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div><!-- /.tcard -->

          <!-- ── RIGHT PANEL ── -->
          <div class="rpanel">

            <!-- Clock -->
            <div class="clock-card">
              <div class="clock-top">
                <div class="live-pill">
                  <span class="live-dot"></span>
                  EN VIVO
                </div>
                <span class="clock-date" id="rt-fecha"></span>
              </div>
              <div class="clock-time" id="rt-hora">
                <span class="hh">--</span><span class="colon">:</span><span class="mm">--</span><span class="colon">:</span><span class="ss">--</span>
              </div>
              <div class="clock-sub">Actualización automática cada segundo</div>
            </div>

            <!-- Activity feed -->
            <div class="feed-card">
              <div class="feed-hdr">
                <div class="feed-hdr-left">
                  <div class="feed-hdr-icon">
                    <i class="fas fa-bolt"></i>
                  </div>
                  <div class="feed-hdr-text">
                    <div class="feed-title">Actividad reciente</div>
                    <div class="feed-subtitle">Últimos eventos del sistema</div>
                  </div>
                </div>
                <div class="feed-hdr-right">
                  <span class="feed-badge" id="feed-count">0</span>
                  <button class="feed-refresh" id="feed-refresh" title="Limpiar">
                    <i class="fas fa-rotate-right"></i>
                  </button>
                </div>
              </div>
              <div class="feed-body" id="contenidotiemporeal">
                <div class="feed-empty">
                  <div class="feed-empty-icon">
                    <i class="fas fa-satellite-dish"></i>
                  </div>
                  <span>Sin actividad reciente.<br>Los eventos aparecerán aquí.</span>
                </div>
              </div>
            </div>

            <!-- Status bars -->
            <div class="status-card">
              <div class="status-card-title">
                <i class="fas fa-chart-bar"></i>
                Distribución de estados
              </div>
              <div class="sb-list" id="sb-list"></div>
            </div>

          </div><!-- /.rpanel -->

        </div><!-- /.main-grid -->
      </div><!-- /.pw -->
    </div><!-- /.main-panel -->
  </div>
</div>

<!-- ══════════════════════════════════════
     MODAL DETALLE PEDIDO
══════════════════════════════════════ -->
<div class="modal fade" id="verpedido" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mpLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="mpLabel">
          <i class="fas fa-receipt"></i>
          Detalle del Pedido
        </h5>
      </div>

      <div class="modal-body">

        <!-- Sección info -->
        <div class="msec">
          <div class="msec-label"><i class="fas fa-info-circle"></i>Información general</div>
          <div class="row g-3">
            <div class="col-md-3">
              <label>Código pedido</label>
              <input type="text" class="form-control" id="codigo_pedido" readonly>
            </div>
            <div class="col-md-5">
              <label>Sede</label>
              <select class="form-control" id="sede_pedido" readonly>
                <option value="SEDE PRINCIPAL" selected>SEDE PRINCIPAL (BARRIO AMBALA)</option>
              </select>
            </div>
            <div class="col-md-2">
              <label>Fecha</label>
              <input type="date" class="form-control" id="fecha_pedido" readonly>
            </div>
            <div class="col-md-2">
              <label>Hora</label>
              <input type="text" class="form-control" id="hora_pedido" readonly>
            </div>
          </div>
        </div>

        <!-- Sección pago -->
        <div class="msec">
          <div class="msec-label"><i class="fas fa-credit-card"></i>Pago &amp; Cliente</div>
          <div class="row g-3 align-items-end">
            <div class="col-md-3">
              <label>Tipo pago</label>
              <select class="form-control" id="tppago_pedido" readonly>
                <option value="CONSIGNACION">CONSIGNACIÓN</option>
                <option value="NEQUI">NEQUI</option>
                <option value="BANCARIA">TRANSFERENCIA BANCARIA</option>
                <option value="CONTRAENTREGA">CONTRAENTREGA</option>
              </select>
            </div>
            <div class="col-md-4">
              <label>Celular cliente</label>
              <input type="number" class="form-control" id="celular_pedido" readonly>
            </div>
            <div class="col-md-3">
              <label>Total pedido</label>
              <input type="text" class="form-control" id="total_pedido" readonly>
            </div>
            <div class="col-md-2">
              <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" id="porpagar">
                <label class="form-check-label" for="porpagar">C×C</label>
              </div>
            </div>
          </div>
        </div>

        <!-- Sección entrega -->
        <div class="msec">
          <div class="msec-label"><i class="fas fa-map-marker-alt"></i>Entrega &amp; Estado</div>
          <div class="row g-3">
            <div class="col-md-4">
              <label>Nombre cliente</label>
              <input type="text" class="form-control" id="nombre_pedido" readonly>
            </div>
            <div class="col-md-4">
              <label>Dirección</label>
              <input type="text" class="form-control" id="direccion_pedido" readonly>
            </div>
            <div class="col-md-2">
              <label>Domicilio</label>
              <input type="text" class="form-control" id="domicilio_pedido">
            </div>
            <div class="col-md-2">
              <label>Estado</label>
              <select class="form-control" id="estado_pedido">
                <option value="PEDIDO">Pedido</option>
                <option value="PREPARACION">Preparación</option>
                <option value="EN CAMINO">En camino</option>
                <option value="CANCELADO">Cancelado</option>
                <option value="ELIMINAR">Eliminar</option>
              </select>
            </div>
            <div class="col-12">
              <label>Comentarios</label>
              <textarea class="form-control" id="comentarios_pedido" rows="2" readonly></textarea>
            </div>
          </div>
        </div>

        <!-- Productos -->
        <div class="msec" style="margin-bottom:0">
          <div class="msec-label"><i class="fas fa-box-open"></i>Productos del pedido</div>
          <div class="table-responsive">
            <table class="table modal-table mb-0">
              <thead>
                <tr>
                  <th>#</th><th>Pedido</th><th>Producto</th><th>Cantidad</th>
                </tr>
              </thead>
              <tbody class="detalle_productos_pedido"></tbody>
            </table>
          </div>
        </div>

      </div><!-- /.modal-body -->

      <div class="modal-footer">
        <button type="button" class="btn-cancel" data-bs-dismiss="modal">
          <i class="fas fa-times"></i> Cancelar
        </button>
        <button type="button" class="btn-save" id="Actualizarpedido">
          <i class="fas fa-floppy-disk"></i> Guardar cambios
        </button>
      </div>

    </div>
  </div>
</div>

<?php require_once("componentes/footer.php")?>
<?php require_once("componentes/scripts.php")?>
<script src="<?= base_url('js/pedidos.js') ?>"></script>

<script>
/* ════════════════════════════════════════
   BOOTSTRAP
════════════════════════════════════════ */
const SC = { total:0, entregados:0, camino:0, prep:0 };

document.addEventListener('DOMContentLoaded', () => {
  const rows = [...document.querySelectorAll('#table-pedidos tbody tr')];
  SC.total = rows.length;

  rows.forEach(r => {
    const t = r.querySelector('td:last-child .badge')?.textContent?.toUpperCase() ?? '';
    if (t.includes('EN CAMINO'))   SC.camino++;
    if (t.includes('PREPARACION')) SC.prep++;
    if (t.includes('ENTREGADO'))   SC.entregados++;
  });

  countUp('s-total',      SC.total);
  countUp('s-entregados', SC.entregados);
  countUp('s-camino',     SC.camino);
  countUp('s-prep',       SC.prep);

  startClock();
  buildBars();
  initFeed(rows);
});

/* ════════════════════════════════════════
   COUNT-UP
════════════════════════════════════════ */
function countUp(id, target) {
  const el = document.getElementById(id);
  if (!el) return;
  const dur = 900, t0 = performance.now();
  (function f(now) {
    const p = Math.min((now - t0) / dur, 1);
    el.textContent = Math.round((1 - Math.pow(1 - p, 4)) * target);
    if (p < 1) requestAnimationFrame(f);
  })(performance.now());
}

/* ════════════════════════════════════════
   LIVE CLOCK
════════════════════════════════════════ */
function startClock() {
  const DIAS  = ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'];
  const MESES = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
  const hEl = document.getElementById('rt-hora');
  const fEl = document.getElementById('rt-fecha');

  function tick() {
    const d  = new Date();
    const hh = String(d.getHours()).padStart(2,'0');
    const mm = String(d.getMinutes()).padStart(2,'0');
    const ss = String(d.getSeconds()).padStart(2,'0');
    if (hEl) hEl.innerHTML =
      `<span class="hh">${hh}</span><span class="colon">:</span>` +
      `<span class="mm">${mm}</span><span class="colon">:</span>` +
      `<span class="ss">${ss}</span>`;
    if (fEl) fEl.textContent =
      `${DIAS[d.getDay()]} ${d.getDate()} ${MESES[d.getMonth()]} ${d.getFullYear()}`;
  }
  tick(); setInterval(tick, 1000);
}

/* ════════════════════════════════════════
   STATUS BARS
════════════════════════════════════════ */
function buildBars() {
  const total  = SC.total || 1;
  const pedido = Math.max(total - SC.camino - SC.prep - SC.entregados, 0);
  const data   = [
    { label:'Pedido',      count: pedido,        color:'#5b2fc9' },
    { label:'Preparación', count: SC.prep,        color:'#c97c0f' },
    { label:'En camino',   count: SC.camino,      color:'#1a7fd4' },
    { label:'Entregado',   count: SC.entregados,  color:'#0fa968' },
  ];
  const c = document.getElementById('sb-list');
  if (!c) return;
  c.innerHTML = '';
  data.forEach(d => {
    const pct = Math.round((d.count / total) * 100);
    const row = document.createElement('div');
    row.className = 'sb-row';
    row.innerHTML = `
      <div class="sb-meta">
        <span class="sb-name" style="--pip:${d.color}">
          <span class="sb-pip"></span>${d.label}
        </span>
        <span class="sb-count" style="--pip:${d.color}">${d.count}</span>
      </div>
      <div class="sb-track">
        <div class="sb-fill" data-w="${pct}" style="--pip:${d.color}"></div>
      </div>`;
    c.appendChild(row);
  });
  requestAnimationFrame(() => requestAnimationFrame(() => {
    document.querySelectorAll('.sb-fill').forEach(b => {
      b.style.width = b.dataset.w + '%';
    });
  }));
}

/* ════════════════════════════════════════
   ACTIVITY FEED
════════════════════════════════════════ */
const FI_MAP = {
  PEDIDO:      { icon:'fa-circle-dot',   bg:'var(--v-soft)',    c:'var(--v)',     label:'Nuevo pedido'     },
  PREPARACION: { icon:'fa-fire-burner',  bg:'var(--amber-s)',   c:'var(--amber)', label:'En preparación'   },
  'EN CAMINO': { icon:'fa-motorcycle',   bg:'var(--blue-s)',    c:'var(--blue)',  label:'En camino'        },
  ENTREGADO:   { icon:'fa-circle-check', bg:'var(--green-s)',   c:'var(--green)', label:'Entregado'        },
  CANCELADO:   { icon:'fa-circle-xmark', bg:'var(--red-s)',     c:'var(--red)',   label:'Cancelado'        },
};

let fiItems = [];

function initFeed(rows) {
  rows.slice(0, 7).forEach((r, i) => {
    const consec = r.querySelector('td:nth-child(2)')?.textContent?.trim() ?? '—';
    const estado = r.querySelector('td:last-child .badge')?.textContent?.trim().toUpperCase() ?? 'PEDIDO';
    const hora   = r.querySelector('td:nth-child(7)')?.textContent?.trim() ?? '--:--';
    setTimeout(() => pushFeed(consec, estado, hora), i * 70);
  });

  document.getElementById('feed-refresh')?.addEventListener('click', function() {
    fiItems = [];
    const body = document.getElementById('contenidotiemporeal');
    if (body) body.innerHTML = `
      <div class="feed-empty">
        <div class="feed-empty-icon"><i class="fas fa-satellite-dish"></i></div>
        <span>Sin actividad reciente.<br>Los eventos aparecerán aquí.</span>
      </div>`;
    const cnt = document.getElementById('feed-count');
    if (cnt) cnt.textContent = '0';
    this.classList.add('spinning');
    setTimeout(() => this.classList.remove('spinning'), 520);
    // Notifica a pedidos.js para resetear su tracking de duplicados
    window.onFeedReset?.();
  });
}

function pushFeed(consecutivo, estado, hora) {
  const meta = FI_MAP[estado] ?? FI_MAP['PEDIDO'];
  const body = document.getElementById('contenidotiemporeal');
  if (!body) return;
  body.querySelector('.feed-empty')?.remove();

  const el = document.createElement('div');
  el.className = 'fi';
  el.innerHTML = `
    <div class="fi-icon" style="--fi-bg:${meta.bg}; --fi-c:${meta.c}; background:${meta.bg}; color:${meta.c}">
      <i class="fas ${meta.icon}"></i>
    </div>
    <div class="fi-body">
      <div class="fi-status" style="color:${meta.c}">${meta.label}</div>
      <div class="fi-name">Pedido ${consecutivo}</div>
    </div>
    <div class="fi-time"><i class="fas fa-clock"></i>${hora}</div>`;

  body.prepend(el);
  fiItems.unshift(el);

  const cnt = document.getElementById('feed-count');
  if (cnt) {
    cnt.textContent = Math.min(fiItems.length, 10);
    cnt.classList.remove('bump');
    void cnt.offsetWidth;
    cnt.classList.add('bump');
  }

  if (fiItems.length > 10) fiItems.pop()?.remove();
}

window.rtPushEvento = pushFeed;
window.pushFeed     = pushFeed;   // alias para pedidos.js

/* ════════════════════════════════════════
   LIVE SEARCH
════════════════════════════════════════ */
document.getElementById('buscar')?.addEventListener('input', function() {
  const q = this.value.toLowerCase();
  document.querySelectorAll('#table-pedidos tbody tr').forEach(r => {
    r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
  });
});
</script>
</body>
</html>

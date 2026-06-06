<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administración - Preparaciones</title>
  <?php require_once("componentes/head.php") ?>
<style>
:root {
  --purple-900:#0d2409; --purple-800:#173a10; --purple-700:#2d6622;
  --purple-600:#4a8a37; --purple-500:#7fac6e; --purple-400:#8fba7e;
  --purple-300:#abd49b; --purple-200:#d4eacc; --purple-100:#f0f7ec;
  --green:#10b981; --green-light:#d1fae5; --green-dark:#065f46;
  --red:#ef4444; --red-light:#fee2e2; --red-dark:#991b1b;
  --amber:#f59e0b; --amber-light:#fef3c7;
  --surface:#fff; --surface-alt:#fafbff;
  --border:#e8e0f5; --text:#0d2409; --muted:#7c6fa0;
  --shadow-sm:0 1px 3px rgba(45,102,34,.08);
  --shadow-md:0 4px 16px rgba(45,102,34,.12);
  --radius:14px; --radius-sm:8px;
  --transition:all .25s cubic-bezier(.4,0,.2,1);
}
*{box-sizing:border-box;margin:0;padding:0;}
body{font-family:Arial,Helvetica;background:var(--surface-alt);color:var(--text);}
::-webkit-scrollbar{width:6px;} ::-webkit-scrollbar-track{background:#f0f7ec;}
::-webkit-scrollbar-thumb{background:var(--purple-400);border-radius:99px;}

.usr-wrapper{padding:24px 28px;max-width:100%;}
.usr-topbar{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:14px;margin-bottom:24px;}
.usr-breadcrumb{font-size:11px;font-weight:500;letter-spacing:.08em;text-transform:uppercase;color:var(--purple-400);margin-bottom:4px;}
.usr-title{font-size:26px;font-weight:800;color:var(--purple-800);line-height:1.15;}

.btn-inv{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:50px;font-family:Arial,Helvetica;font-size:13px;font-weight:600;cursor:pointer;border:none;transition:var(--transition);white-space:nowrap;text-decoration:none;}
.btn-inv-primary{background:linear-gradient(135deg,var(--purple-600),var(--purple-500));color:#fff;box-shadow:0 4px 14px rgba(74,138,55,.35);}
.btn-inv-primary:hover{background:linear-gradient(135deg,var(--purple-700),var(--purple-600));transform:translateY(-1px);color:#fff;}

.layout{display:grid;grid-template-columns:1fr 380px;gap:20px;align-items:start;}
@media(max-width:900px){.layout{grid-template-columns:1fr;}}

.card{background:var(--surface);border:1.5px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow-sm);overflow:hidden;}
.card-header{padding:14px 18px;border-bottom:1px solid var(--border);background:linear-gradient(135deg,var(--purple-800),var(--purple-700));color:#fff;display:flex;align-items:center;gap:8px;font-size:14px;font-weight:700;}

.form-section{background:var(--purple-100);border:1.5px solid var(--purple-200);border-radius:var(--radius);padding:16px 18px;margin-bottom:14px;}
.fl{display:flex;flex-direction:column;gap:4px;}
.fl label{font-size:11px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.05em;}
.fc{width:100%;padding:9px 13px;border:1.5px solid var(--border);border-radius:var(--radius-sm);font-family:Arial,Helvetica;font-size:13px;color:var(--text);background:#fff;outline:none;transition:border-color .2s;}
.fc:focus{border-color:var(--purple-500);}

.search-bar{display:flex;gap:0;border:1.5px solid var(--border);border-radius:var(--radius-sm);overflow:hidden;background:#fff;}
.search-bar input{flex:1;padding:9px 13px;border:none;font-family:Arial,Helvetica;font-size:13px;outline:none;}
.search-bar button{padding:0 14px;background:var(--purple-600);color:#fff;border:none;cursor:pointer;font-size:14px;}
.search-bar button:hover{background:var(--purple-700);}

/* Autocomplete dropdown */
.ac-drop{display:none;position:absolute;top:100%;left:0;right:0;z-index:1050;
  background:#fff;border:1.5px solid var(--purple-200);border-top:none;
  border-radius:0 0 10px 10px;box-shadow:0 8px 24px rgba(45,102,34,.12);
  max-height:220px;overflow-y:auto;}
.ac-drop li{padding:9px 14px;cursor:pointer;font-size:13px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--purple-100);}
.ac-drop li:hover{background:var(--purple-100);}
.ac-drop li:last-child{border-bottom:none;}
.ac-nombre{font-weight:600;color:var(--text);}
.ac-stock{font-size:11px;color:var(--muted);}

/* Cart */
.cart-table{width:100%;border-collapse:collapse;font-size:13px;}
.cart-table thead tr{background:linear-gradient(135deg,var(--purple-800),var(--purple-700));}
.cart-table thead th{padding:10px 14px;color:#fff;font-size:11px;font-weight:600;letter-spacing:.04em;text-transform:uppercase;}
.cart-table tbody tr{border-bottom:1px solid var(--purple-100);}
.cart-table tbody td{padding:10px 14px;vertical-align:middle;}
.cart-table tbody tr:hover{background:var(--purple-100);}
.cart-empty{text-align:center;padding:30px 20px;color:var(--muted);font-size:13px;}
.cart-empty i{font-size:28px;opacity:.3;display:block;margin-bottom:8px;}

.qty-input{width:80px;padding:5px 8px;border:1.5px solid var(--border);border-radius:6px;font-size:13px;text-align:center;}
.qty-input:focus{outline:none;border-color:var(--purple-500);}

.btn-del-row{background:var(--red-light);color:var(--red-dark);border:none;border-radius:6px;width:28px;height:28px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;font-size:11px;transition:var(--transition);}
.btn-del-row:hover{background:var(--red);color:#fff;}

.btn-save{width:100%;padding:12px;background:linear-gradient(135deg,var(--purple-600),var(--purple-500));color:#fff;border:none;border-radius:50px;font-size:14px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:var(--transition);}
.btn-save:hover{background:linear-gradient(135deg,var(--purple-700),var(--purple-600));transform:translateY(-1px);}
.btn-save:disabled{opacity:.6;cursor:not-allowed;transform:none;}

/* Historial table */
.hist-table{width:100%;border-collapse:collapse;font-size:13px;}
.hist-table thead tr{background:linear-gradient(135deg,var(--purple-800),var(--purple-700));}
.hist-table thead th{padding:10px 14px;color:#fff;font-size:11px;font-weight:600;letter-spacing:.04em;text-transform:uppercase;white-space:nowrap;}
.hist-table tbody tr{border-bottom:1px solid var(--border);transition:background .15s;}
.hist-table tbody tr:hover{background:var(--purple-100);}
.hist-table tbody td{padding:10px 14px;vertical-align:middle;}

.btn-view{background:var(--purple-100);color:var(--purple-700);border:1.5px solid var(--purple-200);border-radius:7px;width:28px;height:28px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;font-size:11px;transition:var(--transition);}
.btn-view:hover{background:var(--purple-600);color:#fff;}

/* Modal detalle */
.det-table{width:100%;border-collapse:collapse;font-size:13px;}
.det-table thead tr{background:var(--purple-100);}
.det-table thead th{padding:8px 12px;color:var(--purple-800);font-size:11px;font-weight:700;text-transform:uppercase;}
.det-table tbody td{padding:8px 12px;border-bottom:1px solid var(--purple-100);}

/* Modal categorías */
.cat-item{padding:9px 12px;border-radius:8px;cursor:pointer;font-size:13px;font-weight:500;color:var(--text);transition:var(--transition);margin-bottom:3px;display:flex;align-items:center;gap:8px;}
.cat-item:hover{background:var(--purple-200);}
.cat-item.active{background:linear-gradient(135deg,var(--purple-600),var(--purple-500));color:#fff;}
.cat-item .cat-dot{width:8px;height:8px;border-radius:50%;background:var(--purple-400);flex-shrink:0;}
.cat-item.active .cat-dot{background:#fff;}
.cat-prod-row{border-bottom:1px solid var(--purple-100);transition:background .15s;}
.cat-prod-row:hover{background:var(--purple-100);}
.cat-prod-row td{padding:10px 14px;vertical-align:middle;}
.cat-prod-row.ya-agregado{opacity:.5;}
.btn-cat-add{background:var(--purple-100);color:var(--purple-700);border:1.5px solid var(--purple-200);border-radius:7px;padding:4px 10px;font-size:12px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:5px;transition:var(--transition);}
.btn-cat-add:hover:not(:disabled){background:var(--purple-600);color:#fff;border-color:var(--purple-600);}
.btn-cat-add:disabled{opacity:.45;cursor:not-allowed;}
.cat-check{width:16px;height:16px;accent-color:var(--purple-600);cursor:pointer;}
.stock-badge{display:inline-block;padding:2px 8px;border-radius:99px;font-size:11px;font-weight:700;}
.stock-ok{background:var(--green-light);color:var(--green-dark);}
.stock-low{background:var(--amber-light);color:#92400e;}
.stock-zero{background:var(--red-light);color:var(--red-dark);}
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

          <div class="usr-topbar">
            <div>
              <p class="usr-breadcrumb">Administración &rsaquo; CristalBusiness</p>
              <h1 class="usr-title">Registro de Preparaciones</h1>
            </div>
          </div>

          <div class="layout">

            <!-- ══ PANEL IZQUIERDO: Formulario ══ -->
            <div>
              <!-- Fecha y observación -->
              <div class="form-section">
                <div class="row g-3">
                  <div class="col-md-4">
                    <div class="fl">
                      <label>Fecha</label>
                      <input type="date" id="cons-fecha" class="fc" value="<?= date('Y-m-d') ?>">
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="fl">
                      <label>Observación (opcional)</label>
                      <input type="text" id="cons-obs" class="fc" placeholder="Ej: Almuerzo del mediodía">
                    </div>
                  </div>
                </div>
              </div>

              <!-- Búsqueda de producto -->
              <div class="form-section">
                <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--purple-700);margin-bottom:10px;display:flex;align-items:center;justify-content:space-between;">
                  <span><i class="fas fa-search"></i> Buscar ingrediente / insumo</span>
                  <button type="button" id="btn-abrir-categorias" class="btn-inv btn-inv-primary" style="padding:6px 14px;font-size:12px;">
                    <i class="fas fa-th-large"></i> Por categoría
                  </button>
                </div>
                <div style="position:relative;">
                  <div class="search-bar">
                    <input type="text" id="cons-search" placeholder="Nombre o código del producto…" autocomplete="off">
                    <button type="button"><i class="fas fa-search"></i></button>
                  </div>
                  <ul id="cons-drop" class="ac-drop"></ul>
                </div>
              </div>

              <!-- Carrito -->
              <div class="card">
                <div class="card-header">
                  <i class="fas fa-list"></i> Productos a descontar
                  <span style="margin-left:auto;background:rgba(255,255,255,.2);border-radius:99px;padding:2px 10px;font-size:11px;" id="cons-count">0 items</span>
                </div>
                <div class="table-responsive">
                  <table class="cart-table">
                    <thead>
                      <tr>
                        <th>Producto</th>
                        <th style="text-align:center;">Unidad</th>
                        <th style="text-align:center;">Stock actual</th>
                        <th style="text-align:center;">Cantidad usada</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody id="cons-tbody">
                      <tr id="cons-empty">
                        <td colspan="5" class="cart-empty">
                          <i class="fas fa-utensils"></i>
                          Busca y agrega los ingredientes usados.
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div style="padding:14px 18px;border-top:1px solid var(--border);">
                  <button id="cons-btn-guardar" class="btn-save" disabled>
                    <i class="fas fa-save"></i> Registrar consumo y descontar stock
                  </button>
                </div>
              </div>
            </div>

            <!-- ══ PANEL DERECHO: Historial ══ -->
            <div class="card">
              <div class="card-header">
                <i class="fas fa-history"></i> Historial de hoy
              </div>
              <div class="table-responsive">
                <table class="hist-table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Hora</th>
                      <th>Usuario</th>
                      <th>Obs.</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $hoy = date('Y-m-d');
                    $consumosHoy = array_filter($consumos, fn($c) => substr($c->created_at, 0, 10) === $hoy);
                    if (empty($consumosHoy)):
                    ?>
                    <tr><td colspan="5" class="cart-empty"><i class="fas fa-clock"></i>Sin registros hoy.</td></tr>
                    <?php else: foreach ($consumosHoy as $c): ?>
                    <tr>
                      <td style="font-weight:700;color:var(--muted);">#<?= $c->id ?></td>
                      <td><?= substr($c->created_at, 11, 5) ?></td>
                      <td style="font-size:12px;"><?= esc($c->nombre ?? '—') ?></td>
                      <td style="font-size:12px;color:var(--muted);"><?= esc($c->observacion ?: '—') ?></td>
                      <td>
                        <button class="btn-view btn-ver-consumo" data-id="<?= $c->id ?>" title="Ver detalle">
                          <i class="fas fa-eye"></i>
                        </button>
                      </td>
                    </tr>
                    <?php endforeach; endif; ?>
                  </tbody>
                </table>
              </div>

              <!-- Historial completo colapsable -->
              <div style="border-top:1px solid var(--border);">
                <button id="btn-toggle-hist" style="width:100%;padding:10px 18px;background:none;border:none;cursor:pointer;font-size:12px;color:var(--purple-600);font-weight:600;display:flex;align-items:center;gap:6px;">
                  <i class="fas fa-chevron-down" id="hist-icon"></i> Ver historial completo
                </button>
                <div id="hist-completo" style="display:none;max-height:320px;overflow-y:auto;">
                  <table class="hist-table">
                    <tbody>
                      <?php foreach ($consumos as $c):
                        if (substr($c->created_at, 0, 10) === $hoy) continue; ?>
                      <tr>
                        <td style="font-weight:700;color:var(--muted);">#<?= $c->id ?></td>
                        <td style="font-size:12px;"><?= substr($c->fecha, 0, 10) ?></td>
                        <td style="font-size:12px;"><?= esc($c->nombre ?? '—') ?></td>
                        <td style="font-size:12px;color:var(--muted);"><?= esc($c->observacion ?: '—') ?></td>
                        <td>
                          <button class="btn-view btn-ver-consumo" data-id="<?= $c->id ?>" title="Ver detalle">
                            <i class="fas fa-eye"></i>
                          </button>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div><!-- /layout -->
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal categorías -->
<div class="modal fade" id="modalCategorias" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content" style="border:none;border-radius:14px;overflow:hidden;">
      <div class="modal-header" style="background:linear-gradient(135deg,var(--purple-800),var(--purple-700));color:#fff;padding:14px 20px;">
        <h5 class="modal-title" style="color:#fff;font-weight:700;font-size:15px;"><i class="fas fa-th-large me-2"></i>Agregar por categoría</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter:invert(1);"></button>
      </div>
      <div class="modal-body" style="padding:0;display:grid;grid-template-columns:220px 1fr;min-height:440px;">

        <!-- Lista de categorías -->
        <div id="cat-lista" style="border-right:1.5px solid var(--border);background:var(--surface-alt);overflow-y:auto;max-height:540px;padding:10px 8px;">
          <p style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--muted);padding:4px 8px 8px;">Categorías</p>
          <div id="cat-loading" style="padding:16px;text-align:center;color:var(--muted);font-size:13px;">
            <i class="fas fa-spinner fa-spin"></i> Cargando…
          </div>
        </div>

        <!-- Productos de la categoría -->
        <div style="display:flex;flex-direction:column;">
          <div id="cat-prod-header" style="padding:10px 14px;border-bottom:1.5px solid var(--border);background:var(--purple-100);display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <span style="font-size:13px;font-weight:700;color:var(--purple-800);display:flex;align-items:center;gap:6px;">
              <i class="fas fa-boxes"></i>
              <span id="cat-nombre-activo">Selecciona una categoría</span>
            </span>
            <div style="margin-left:auto;display:flex;align-items:center;gap:0;border:1.5px solid var(--border);border-radius:8px;overflow:hidden;background:#fff;min-width:200px;">
              <input type="text" id="cat-buscador" placeholder="Buscar producto…" autocomplete="off"
                style="flex:1;padding:7px 11px;border:none;font-size:13px;font-family:Arial,Helvetica;outline:none;color:var(--text);">
              <span style="padding:0 10px;color:var(--muted);font-size:13px;"><i class="fas fa-search"></i></span>
            </div>
          </div>
          <div style="flex:1;overflow-y:auto;max-height:490px;">
            <table style="width:100%;border-collapse:collapse;font-size:13px;" id="cat-prod-table">
              <thead>
                <tr style="background:var(--purple-100);position:sticky;top:0;">
                  <th style="padding:9px 14px;text-align:left;font-size:11px;font-weight:700;text-transform:uppercase;color:var(--purple-800);">Producto</th>
                  <th style="padding:9px 14px;text-align:left;font-size:11px;font-weight:700;text-transform:uppercase;color:var(--purple-800);">Cód. Interno</th>
                  <th style="padding:9px 14px;text-align:center;font-size:11px;font-weight:700;text-transform:uppercase;color:var(--purple-800);">Stock</th>
                  <th style="padding:9px 14px;text-align:center;">
                    <label style="display:inline-flex;align-items:center;gap:5px;cursor:pointer;font-size:11px;font-weight:700;text-transform:uppercase;color:var(--purple-800);white-space:nowrap;">
                      <input type="checkbox" id="cat-check-all" class="cat-check" title="Seleccionar todos"> Todo
                    </label>
                  </th>
                </tr>
              </thead>
              <tbody id="cat-prod-tbody">
                <tr>
                  <td colspan="4" style="text-align:center;padding:40px 20px;color:var(--muted);font-size:13px;">
                    <i class="fas fa-hand-point-left" style="font-size:22px;opacity:.3;display:block;margin-bottom:8px;"></i>
                    Elige una categoría
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="border-top:1.5px solid var(--border);padding:10px 18px;">
        <span id="cat-sel-count" style="font-size:12px;color:var(--muted);margin-right:auto;">0 productos seleccionados</span>
        <button type="button" class="btn-inv" data-bs-dismiss="modal" style="background:var(--border);color:var(--text);border-radius:50px;padding:8px 18px;font-size:13px;border:none;cursor:pointer;">Cancelar</button>
        <button type="button" id="btn-agregar-seleccion" class="btn-inv btn-inv-primary" disabled>
          <i class="fas fa-plus"></i> Agregar seleccionados al consumo
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal detalle consumo -->
<div class="modal fade" id="modalDetalle" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background:linear-gradient(135deg,var(--purple-800),var(--purple-700));color:#fff;">
        <h5 class="modal-title" style="color:#fff;font-weight:700;"><i class="fas fa-utensils me-2"></i>Detalle de consumo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter:invert(1);"></button>
      </div>
      <div class="modal-body" id="modal-det-body">
        <p class="text-center text-muted">Cargando…</p>
      </div>
    </div>
  </div>
</div>

<?php require_once("componentes/scripts.php") ?>
<script>
(function () {
  'use strict';

  /* ── Estado ── */
  var items = [];

  /* ── Elementos ── */
  var searchInput = document.getElementById('cons-search');
  var drop        = document.getElementById('cons-drop');
  var tbody       = document.getElementById('cons-tbody');
  var emptyRow    = document.getElementById('cons-empty');
  var countEl     = document.getElementById('cons-count');
  var btnGuardar  = document.getElementById('cons-btn-guardar');
  var searchTimer = null;

  /* ── Autocomplete ── */
  searchInput.addEventListener('input', function () {
    var q = this.value.trim();
    clearTimeout(searchTimer);
    if (q.length < 2) { drop.style.display = 'none'; drop.innerHTML = ''; return; }

    searchTimer = setTimeout(function () {
      fetch(baseurl + 'inventarios/buscar?q=' + encodeURIComponent(q))
        .then(function (r) { return r.json(); })
        .then(function (data) {
          drop.innerHTML = '';
          if (!data.length) { drop.style.display = 'none'; return; }
          data.forEach(function (p) {
            var li = document.createElement('li');
            li.innerHTML = '<span class="ac-nombre">' + p.nombre + '</span><span class="ac-stock">Stock: ' + p.saldo + '</span>';
            li.addEventListener('mousedown', function (e) {
              e.preventDefault();
              agregarItem(p);
              searchInput.value = '';
              drop.style.display = 'none';
              drop.innerHTML = '';
            });
            drop.appendChild(li);
          });
          drop.style.display = 'block';
        });
    }, 250);
  });

  searchInput.addEventListener('blur', function () {
    setTimeout(function () { drop.style.display = 'none'; }, 180);
  });

  /* ── Agregar item al carrito ── */
  function agregarItem(p) {
    var existe = items.find(function (i) { return i.producto_id === p.codigo_barras; });
    if (existe) {
      $("body").overhang({ type: "warning", message: "El producto ya está en la lista." });
      return;
    }
    items.push({ producto_id: p.codigo_barras, nombre_producto: p.nombre, saldo: p.saldo, medida: p.medida || '', cantidad: 1 });
    renderTabla();
  }

  function renderTabla() {
    tbody.querySelectorAll('tr:not(#cons-empty)').forEach(function (r) { r.remove(); });

    if (!items.length) {
      emptyRow.style.display = '';
      countEl.textContent = '0 items';
      btnGuardar.disabled = true;
      return;
    }

    emptyRow.style.display = 'none';
    countEl.textContent = items.length + (items.length === 1 ? ' item' : ' items');
    btnGuardar.disabled = false;

    items.forEach(function (item, idx) {
      var tr = document.createElement('tr');
      tr.innerHTML =
        '<td style="font-weight:600;">' + item.nombre_producto + '</td>' +
        '<td style="text-align:center;"><span style="display:inline-block;padding:2px 9px;border-radius:99px;font-size:11px;font-weight:700;background:var(--purple-100);color:var(--purple-700);">' + (item.medida || '—') + '</span></td>' +
        '<td style="text-align:center;color:var(--muted);">' + item.saldo + '</td>' +
        '<td style="text-align:center;">' +
          '<input type="number" class="qty-input" min="0.01" step="0.01" value="' + item.cantidad + '" data-idx="' + idx + '">' +
        '</td>' +
        '<td style="text-align:center;">' +
          '<button class="btn-del-row" data-idx="' + idx + '"><i class="fas fa-trash"></i></button>' +
        '</td>';
      tbody.appendChild(tr);
    });

    tbody.querySelectorAll('.qty-input').forEach(function (inp) {
      inp.addEventListener('change', function () {
        var idx = parseInt(this.dataset.idx);
        items[idx].cantidad = parseFloat(this.value) || 1;
      });
    });

    tbody.querySelectorAll('.btn-del-row').forEach(function (btn) {
      btn.addEventListener('click', function () {
        items.splice(parseInt(this.dataset.idx), 1);
        renderTabla();
      });
    });
  }

  /* ── Guardar ── */
  btnGuardar.addEventListener('click', function () {
    if (!items.length) return;
    btnGuardar.disabled = true;
    btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando…';

    fetch(baseurl + 'consumos/guardar', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        fecha:       document.getElementById('cons-fecha').value,
        observacion: document.getElementById('cons-obs').value,
        items:       items,
      }),
    })
    .then(function (r) { return r.json(); })
    .then(function (data) {
      if (data.status === 'success') {
        $("body").overhang({ type: "success", message: "Consumo registrado. Stock actualizado correctamente." });
        setTimeout(function () { location.reload(); }, 2000);
      } else {
        $("body").overhang({ type: "error", message: data.message || 'Error al guardar.' });
        btnGuardar.disabled = false;
        btnGuardar.innerHTML = '<i class="fas fa-save"></i> Registrar consumo y descontar stock';
      }
    })
    .catch(function () {
      $("body").overhang({ type: "error", message: "Error de conexión." });
      btnGuardar.disabled = false;
      btnGuardar.innerHTML = '<i class="fas fa-save"></i> Registrar consumo y descontar stock';
    });
  });

  /* ── Ver detalle ── */
  document.querySelectorAll('.btn-ver-consumo').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var id = this.dataset.id;
      var body = document.getElementById('modal-det-body');
      body.innerHTML = '<p class="text-center text-muted"><i class="fas fa-spinner fa-spin"></i> Cargando…</p>';
      new bootstrap.Modal(document.getElementById('modalDetalle')).show();

      fetch(baseurl + 'consumos/detalle/' + id)
        .then(function (r) { return r.json(); })
        .then(function (data) {
          if (data.status !== 'success') { body.innerHTML = '<p class="text-danger">No encontrado.</p>'; return; }
          var c = data.consumo;
          var d = data.detalle;
          var html = '<p style="font-size:13px;margin-bottom:14px;color:var(--muted);">' +
            '<strong>Fecha:</strong> ' + c.fecha + ' &nbsp;|&nbsp; <strong>Obs:</strong> ' + (c.observacion || '—') + '</p>' +
            '<table class="det-table"><thead><tr><th>#</th><th>Producto</th><th style="text-align:right;">Cantidad</th></tr></thead><tbody>';
          d.forEach(function (item, i) {
            html += '<tr><td>' + (i+1) + '</td><td>' + item.nombre_producto + '</td><td style="text-align:right;font-weight:700;">' + item.cantidad + '</td></tr>';
          });
          html += '</tbody></table>';
          body.innerHTML = html;
        });
    });
  });

  /* ── Historial completo toggle ── */
  document.getElementById('btn-toggle-hist').addEventListener('click', function () {
    var hist = document.getElementById('hist-completo');
    var icon = document.getElementById('hist-icon');
    var visible = hist.style.display !== 'none';
    hist.style.display = visible ? 'none' : 'block';
    icon.className = visible ? 'fas fa-chevron-down' : 'fas fa-chevron-up';
  });

  /* ══════════════════════════════════════
     MODAL CATEGORÍAS
  ══════════════════════════════════════ */
  var modalCat       = null;
  var catActivo      = null;
  var catSeleccionados = {}; // codigo_barras -> producto

  document.getElementById('btn-abrir-categorias').addEventListener('click', function () {
    catSeleccionados = {};
    actualizarContadorSel();
    if (!modalCat) modalCat = new bootstrap.Modal(document.getElementById('modalCategorias'));
    modalCat.show();
    cargarCategorias();
  });

  function cargarCategorias() {
    var lista = document.getElementById('cat-lista');
    var loading = document.getElementById('cat-loading');
    loading.style.display = 'block';

    fetch(baseurl + 'consumos/categorias')
      .then(function (r) { return r.json(); })
      .then(function (cats) {
        loading.style.display = 'none';
        cats.forEach(function (cat) {
          var div = document.createElement('div');
          div.className = 'cat-item';
          div.dataset.codigo = cat.codigo_categoria;
          div.dataset.nombre = cat.nombre;
          div.innerHTML = '<span class="cat-dot"></span>' + cat.nombre;
          div.addEventListener('click', function () {
            lista.querySelectorAll('.cat-item').forEach(function (el) { el.classList.remove('active'); });
            div.classList.add('active');
            catActivo = cat.codigo_categoria;
            document.getElementById('cat-nombre-activo').textContent = cat.nombre;
            cargarProductosCategoria(cat.codigo_categoria);
          });
          lista.appendChild(div);
        });
      })
      .catch(function () {
        loading.innerHTML = '<span style="color:var(--red);">Error al cargar categorías.</span>';
      });
  }

  function cargarProductosCategoria(codigo) {
    var tbody = document.getElementById('cat-prod-tbody');
    tbody.innerHTML = '<tr><td colspan="4" style="text-align:center;padding:30px;color:var(--muted);"><i class="fas fa-spinner fa-spin"></i> Cargando productos…</td></tr>';

    fetch(baseurl + 'consumos/categoria/' + encodeURIComponent(codigo))
      .then(function (r) { return r.json(); })
      .then(function (prods) {
        tbody.innerHTML = '';
        if (!prods.length) {
          tbody.innerHTML = '<tr><td colspan="4" style="text-align:center;padding:30px;color:var(--muted);font-size:13px;"><i class="fas fa-box-open" style="font-size:22px;opacity:.3;display:block;margin-bottom:8px;"></i>Sin productos en esta categoría.</td></tr>';
          return;
        }
        prods.forEach(function (p) {
          var estaEnCarrito = !!items.find(function (i) { return i.producto_id === p.codigo_barras; });
          var seleccionado  = !!catSeleccionados[p.codigo_barras];

          var saldoNum  = parseFloat(p.saldo) || 0;
          var badgeCls  = saldoNum > 10 ? 'stock-ok' : saldoNum > 0 ? 'stock-low' : 'stock-zero';

          var tr = document.createElement('tr');
          tr.className = 'cat-prod-row' + (estaEnCarrito ? ' ya-agregado' : '');
          tr.dataset.codigo = p.codigo_barras;

          var checkDisabled = estaEnCarrito ? 'disabled' : '';
          var checkChecked  = (seleccionado || estaEnCarrito) ? 'checked' : '';

          tr.innerHTML =
            '<td style="font-weight:600;">' + p.nombre + '</td>' +
            '<td style="color:var(--muted);font-size:12px;">' + (p.codigo_interno || '—') + '</td>' +
            '<td style="text-align:center;"><span class="stock-badge ' + badgeCls + '">' + saldoNum + '</span></td>' +
            '<td style="text-align:center;">' +
              (estaEnCarrito
                ? '<span style="font-size:11px;color:var(--purple-500);font-weight:600;">Ya agregado</span>'
                : '<input type="checkbox" class="cat-check" data-codigo="' + p.codigo_barras + '" data-nombre="' + p.nombre.replace(/"/g,'&quot;') + '" data-saldo="' + saldoNum + '" data-medida="' + (p.medida || '') + '" ' + checkChecked + '>'
              ) +
            '</td>';

          var chk = tr.querySelector('.cat-check');
          if (chk) {
            chk.addEventListener('change', function () {
              if (this.checked) {
                catSeleccionados[this.dataset.codigo] = {
                  producto_id:    this.dataset.codigo,
                  nombre_producto: this.dataset.nombre,
                  saldo:           parseFloat(this.dataset.saldo),
                  medida:          this.dataset.medida || '',
                  cantidad:        1,
                };
              } else {
                delete catSeleccionados[this.dataset.codigo];
              }
              sincronizarCheckAll();
              actualizarContadorSel();
            });
            if (seleccionado) chk.checked = true;
          }
          tbody.appendChild(tr);
        });

        /* Sincronizar estado inicial del check-all */
        sincronizarCheckAll();
      })
      .catch(function () {
        tbody.innerHTML = '<tr><td colspan="4" style="text-align:center;padding:20px;color:var(--red);">Error al cargar productos.</td></tr>';
      });
  }

  /* Marca/desmarca el check-all según el estado de las filas */
  function sincronizarCheckAll() {
    var checkAll = document.getElementById('cat-check-all');
    if (!checkAll) return;
    var checks = document.querySelectorAll('#cat-prod-tbody .cat-check');
    if (!checks.length) { checkAll.checked = false; checkAll.indeterminate = false; return; }
    var marcados = Array.from(checks).filter(function (c) { return c.checked; }).length;
    if (marcados === 0) { checkAll.checked = false; checkAll.indeterminate = false; }
    else if (marcados === checks.length) { checkAll.checked = true; checkAll.indeterminate = false; }
    else { checkAll.checked = false; checkAll.indeterminate = true; }
  }

  /* Seleccionar / deseleccionar todos al hacer clic en el header */
  document.getElementById('cat-check-all').addEventListener('change', function () {
    var marcar = this.checked;
    document.querySelectorAll('#cat-prod-tbody .cat-check').forEach(function (chk) {
      if (chk.disabled) return;
      chk.checked = marcar;
      if (marcar) {
        catSeleccionados[chk.dataset.codigo] = {
          producto_id:     chk.dataset.codigo,
          nombre_producto: chk.dataset.nombre,
          saldo:           parseFloat(chk.dataset.saldo),
          medida:          chk.dataset.medida || '',
          cantidad:        1,
        };
      } else {
        delete catSeleccionados[chk.dataset.codigo];
      }
    });
    actualizarContadorSel();
  });

  function actualizarContadorSel() {
    var n = Object.keys(catSeleccionados).length;
    document.getElementById('cat-sel-count').textContent = n + (n === 1 ? ' producto seleccionado' : ' productos seleccionados');
    document.getElementById('btn-agregar-seleccion').disabled = n === 0;
  }

  document.getElementById('btn-agregar-seleccion').addEventListener('click', function () {
    var agregados = 0;
    Object.values(catSeleccionados).forEach(function (p) {
      var existe = items.find(function (i) { return i.producto_id === p.producto_id; });
      if (!existe) { items.push(p); agregados++; }
    });
    renderTabla();
    if (modalCat) modalCat.hide();
    if (agregados > 0) {
      $("body").overhang({ type: "success", message: agregados + (agregados === 1 ? ' producto agregado' : ' productos agregados') + ' al consumo.' });
    }
  });

  /* ── Buscador dentro del modal ── */
  document.getElementById('cat-buscador').addEventListener('input', function () {
    var q = this.value.trim().toLowerCase();
    document.querySelectorAll('#cat-prod-tbody .cat-prod-row').forEach(function (tr) {
      var nombre = (tr.querySelector('td:first-child') || {}).textContent || '';
      var codigo = (tr.querySelector('td:nth-child(2)') || {}).textContent || '';
      tr.style.display = (nombre.toLowerCase().includes(q) || codigo.toLowerCase().includes(q)) ? '' : 'none';
    });
  });

  /* Limpiar estado al cerrar el modal */
  document.getElementById('modalCategorias').addEventListener('hidden.bs.modal', function () {
    catActivo = null;
    catSeleccionados = {};
    actualizarContadorSel();
    document.getElementById('cat-loading').style.display = 'block';
    document.getElementById('cat-loading').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cargando…';
    document.getElementById('cat-lista').querySelectorAll('.cat-item').forEach(function (el) { el.remove(); });
    document.getElementById('cat-prod-tbody').innerHTML =
      '<tr><td colspan="4" style="text-align:center;padding:40px 20px;color:var(--muted);font-size:13px;"><i class="fas fa-hand-point-left" style="font-size:22px;opacity:.3;display:block;margin-bottom:8px;"></i>Elige una categoría</td></tr>';
    document.getElementById('cat-nombre-activo').textContent = 'Selecciona una categoría';
    document.getElementById('cat-buscador').value = '';
  });

})();
</script>
</body>
</html>

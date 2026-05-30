<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administración - Consumo</title>
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
              <p class="usr-breadcrumb">Administración &rsaquo; Bufet</p>
              <h1 class="usr-title">Registro de Consumo</h1>
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
                <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--purple-700);margin-bottom:10px;">
                  <i class="fas fa-search"></i> Buscar ingrediente / insumo
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
                        <th style="text-align:center;">Stock actual</th>
                        <th style="text-align:center;">Cantidad usada</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody id="cons-tbody">
                      <tr id="cons-empty">
                        <td colspan="4" class="cart-empty">
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
    items.push({ producto_id: p.codigo_barras, nombre_producto: p.nombre, saldo: p.saldo, cantidad: 1 });
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

})();
</script>
</body>
</html>

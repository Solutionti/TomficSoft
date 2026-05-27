<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administración - Compras</title>
  <?php require_once("componentes/head.php") ?>
<style>
:root {
  --purple-900:#0d2409; --purple-800:#173a10; --purple-700:#2d6622;
  --purple-600:#4a8a37; --purple-500:#7fac6e; --purple-400:#8fba7e;
  --purple-300:#abd49b; --purple-200:#d4eacc; --purple-100:#f0f7ec;
  --green:#10b981; --green-light:#d1fae5; --green-dark:#065f46;
  --red:#ef4444;   --red-light:#fee2e2;   --red-dark:#991b1b;
  --amber:#f59e0b; --amber-light:#fef3c7;
  --blue:#3b82f6;  --blue-light:#dbeafe;
  --surface:#fff;  --surface-alt:#fafbff;
  --border:#e8e0f5; --text:#0d2409; --muted:#7c6fa0;
  --shadow-sm:0 1px 3px rgba(45,102,34,.08);
  --shadow-md:0 4px 16px rgba(45,102,34,.12);
  --radius:14px; --radius-sm:8px;
  --transition:all .25s cubic-bezier(.4,0,.2,1);
}
*{box-sizing:border-box;margin:0;padding:0;}
body{font-family:Arial,Helvetica;background:var(--surface-alt);color:var(--text);}
h1,h2,h3,h4,h5,h6{font-family:Arial,Helvetica;}
::-webkit-scrollbar{width:6px;height:6px;}
::-webkit-scrollbar-track{background:#f0f7ec;}
::-webkit-scrollbar-thumb{background:var(--purple-400);border-radius:99px;}

/* ── Layout ── */
.usr-wrapper{padding:24px 28px;max-width:100%;}
.usr-topbar{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:14px;margin-bottom:24px;}
.usr-breadcrumb{font-size:11px;font-weight:500;letter-spacing:.08em;text-transform:uppercase;color:var(--purple-400);margin-bottom:4px;}
.usr-title{font-size:26px;font-weight:800;color:var(--purple-800);line-height:1.15;}

/* ── Tabs ── */
.cmp-tabs{display:flex;gap:8px;margin-bottom:20px;border-bottom:2px solid var(--purple-200);padding-bottom:0;}
.cmp-tab-btn{
  display:inline-flex;align-items:center;gap:7px;
  padding:10px 20px;border:none;border-radius:10px 10px 0 0;
  font-family:Arial,Helvetica;font-size:13px;font-weight:600;
  cursor:pointer;background:var(--purple-100);color:var(--muted);
  border-bottom:2px solid transparent;margin-bottom:-2px;
  transition:var(--transition);
}
.cmp-tab-btn.active{background:#fff;color:var(--purple-700);border-color:var(--purple-600);box-shadow:0 -2px 8px rgba(45,102,34,.08);}
.cmp-tab-btn:hover:not(.active){background:var(--purple-200);color:var(--purple-700);}

/* ── Action buttons ── */
.btn-inv{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:50px;font-family:Arial,Helvetica;font-size:13px;font-weight:600;cursor:pointer;border:none;transition:var(--transition);white-space:nowrap;text-decoration:none;}
.btn-inv-primary{background:linear-gradient(135deg,var(--purple-600),var(--purple-500));color:#fff;box-shadow:0 4px 14px rgba(74,138,55,.35);}
.btn-inv-primary:hover{background:linear-gradient(135deg,var(--purple-700),var(--purple-600));transform:translateY(-1px);color:#fff;}
.btn-inv-success{background:linear-gradient(135deg,#059669,var(--green));color:#fff;box-shadow:0 4px 14px rgba(16,185,129,.35);}
.btn-inv-success:hover{background:linear-gradient(135deg,#047857,#059669);transform:translateY(-1px);color:#fff;}
.btn-inv-amber{background:linear-gradient(135deg,#d97706,var(--amber));color:#fff;box-shadow:0 4px 14px rgba(245,158,11,.35);}
.btn-inv-amber:hover{background:linear-gradient(135deg,#b45309,#d97706);transform:translateY(-1px);color:#fff;}

/* ── Table card ── */
.usr-table-card{background:var(--surface);border:1.5px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow-sm);overflow:hidden;}
.tbl-header{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;padding:16px 20px;border-bottom:1px solid var(--border);}
.tbl-title{font-size:15px;font-weight:700;color:var(--purple-800);display:flex;align-items:center;gap:8px;}
.tbl-count{background:var(--purple-100);color:var(--purple-700);border-radius:99px;padding:2px 10px;font-size:11px;font-weight:700;}
.cmp-table{width:100%;border-collapse:collapse;font-size:13px;}
.cmp-table thead tr{background:linear-gradient(135deg,var(--purple-800),var(--purple-700));}
.cmp-table thead th{padding:11px 14px;color:#fff;font-weight:600;font-size:11px;letter-spacing:.05em;text-transform:uppercase;white-space:nowrap;}
.cmp-table tbody tr{border-bottom:1px solid var(--border);transition:background .15s;}
.cmp-table tbody tr:hover{background:var(--purple-100);}
.cmp-table tbody td{padding:11px 14px;vertical-align:middle;}
.cmp-table tbody tr:last-child{border-bottom:none;}

/* ── Badges ── */
.badge-cmp{display:inline-block;padding:3px 10px;border-radius:99px;font-size:11px;font-weight:700;white-space:nowrap;}
.badge-pendiente{background:var(--amber-light);color:#92400e;}
.badge-aprobada{background:var(--green-light);color:var(--green-dark);}
.badge-rechazada{background:var(--red-light);color:var(--red-dark);}
.badge-cancelada{background:#f3f4f6;color:#6b7280;}
.badge-recibida{background:var(--green-light);color:var(--green-dark);}
.badge-parcial{background:var(--amber-light);color:#92400e;}
.badge-pagada{background:var(--green-light);color:var(--green-dark);}
.badge-anulada{background:var(--red-light);color:var(--red-dark);}

/* ── Row actions ── */
.btn-action{display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:8px;border:none;cursor:pointer;transition:var(--transition);}
.btn-action-edit{background:var(--purple-100);color:var(--purple-600);border:1.5px solid var(--purple-200);}
.btn-action-edit:hover{background:var(--purple-600);color:#fff;border-color:var(--purple-600);}
.btn-action-success{background:var(--green-light);color:var(--green-dark);border:1.5px solid #6ee7b7;}
.btn-action-success:hover{background:var(--green-dark);color:#fff;}
.btn-action-del{background:#fee2e2;color:var(--red);border:1.5px solid #fecaca;}
.btn-action-del:hover{background:var(--red);color:#fff;}
.btn-action-amber{background:var(--amber-light);color:#92400e;border:1.5px solid #fde68a;}
.btn-action-amber:hover{background:#d97706;color:#fff;}
.action-wrap{display:flex;align-items:center;gap:6px;}

/* ── Modal styles ── */
.modal-header-inv{background:linear-gradient(135deg,var(--purple-800),var(--purple-700));color:#fff;}
.modal-header-inv .modal-title{color:#fff;font-size:18px;font-weight:700;}
.modal-header-inv .btn-close{filter:invert(1);}

/* ── Form section ── */
.form-section{background:var(--purple-100);border:1.5px solid var(--purple-200);border-radius:var(--radius);padding:18px 20px;margin-bottom:16px;position:relative;z-index:10;}
.form-section-title{font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--purple-700);margin-bottom:12px;display:flex;align-items:center;gap:7px;}

/* ── Field controls ── */
.fl{display:flex;flex-direction:column;gap:4px;}
.fl label{font-size:11px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.05em;}
.fc{width:100%;padding:9px 13px;border:1.5px solid var(--border);border-radius:var(--radius-sm);font-family:Arial,Helvetica;font-size:13px;color:var(--text);background:#fff;outline:none;transition:border-color .2s;}
.fc:focus{border-color:var(--purple-500);}

/* ── Cart ── */
.cart-card{background:var(--surface);border:1.5px solid var(--border);border-radius:var(--radius);overflow:hidden;position:relative;z-index:1;}
.cart-header{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;padding:14px 18px;border-bottom:1px solid var(--border);background:var(--surface-alt);}
.cart-header h5{font-size:14px;font-weight:700;color:var(--purple-800);display:flex;align-items:center;gap:8px;margin:0;}
.cart-count{background:var(--purple-200);color:var(--purple-800);border-radius:99px;padding:2px 10px;font-size:11px;font-weight:700;}
.cart-table{width:100%;border-collapse:collapse;font-size:13px;}
.cart-table thead tr{background:linear-gradient(135deg,var(--purple-800),var(--purple-700));}
.cart-table thead th{padding:10px 14px;color:#fff;font-size:11px;font-weight:600;letter-spacing:.04em;text-transform:uppercase;}
.cart-table tbody tr{border-bottom:1px solid #f0f7ec;}
.cart-table tbody tr:last-child{border-bottom:none;}
.cart-table tbody td{padding:10px 14px;vertical-align:middle;}
.cart-table tbody tr:hover{background:var(--purple-100);}
.cart-empty{text-align:center;padding:30px 20px;color:var(--muted);font-size:13px;}
.cart-empty i{font-size:28px;opacity:.3;display:block;margin-bottom:8px;}

/* ── Total ── */
.total-bar{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:12px 18px;background:var(--purple-100);border-top:1.5px solid var(--purple-200);font-size:14px;font-weight:700;color:var(--purple-800);}

/* ── Search bar ── */
.search-bar{display:flex;gap:0;border:1.5px solid var(--border);border-radius:var(--radius-sm);overflow:hidden;background:#fff;}
.search-bar input{flex:1;padding:9px 13px;border:none;font-family:Arial,Helvetica;font-size:13px;outline:none;}
.search-bar button{padding:0 14px;background:var(--purple-600);color:#fff;border:none;cursor:pointer;font-size:14px;transition:background .2s;}
.search-bar button:hover{background:var(--purple-700);}

/* ── Info strip ── */
.info-strip{display:none;background:var(--purple-100);border:1.5px solid var(--purple-200);border-radius:var(--radius-sm);padding:8px 14px;font-size:12px;color:var(--purple-700);font-weight:600;}

/* ── Modal buttons ── */
.btn-u{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:50px;font-family:Arial,Helvetica;font-size:13px;font-weight:600;cursor:pointer;border:none;transition:var(--transition);}
.btn-u-primary{background:linear-gradient(135deg,var(--purple-600),var(--purple-500));color:#fff;box-shadow:0 4px 14px rgba(74,138,55,.35);}
.btn-u-primary:hover{background:linear-gradient(135deg,var(--purple-700),var(--purple-600));transform:translateY(-1px);}
.btn-u-primary:disabled{opacity:.6;cursor:not-allowed;transform:none;}
.btn-u-success{background:linear-gradient(135deg,#059669,var(--green));color:#fff;box-shadow:0 4px 14px rgba(16,185,129,.3);}
.btn-u-success:hover{background:linear-gradient(135deg,#047857,#059669);transform:translateY(-1px);}
.btn-u-success:disabled{opacity:.6;cursor:not-allowed;transform:none;}
.btn-u-danger-outline{background:transparent;color:var(--red);border:1.5px solid var(--red);}
.btn-u-danger-outline:hover{background:var(--red);color:#fff;}
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

          <!-- ══ TOP BAR ══ -->
          <div class="usr-topbar">
            <div>
              <p class="usr-breadcrumb">Administración &rsaquo; ComprasSoft</p>
              <h1 class="usr-title">Módulo de Compras</h1>
            </div>
            <div style="display:flex;gap:10px;flex-wrap:wrap;">
              <button class="btn-inv btn-inv-primary" data-bs-toggle="modal" data-bs-target="#modalCotizacion">
                <i class="fas fa-file-alt"></i> Nueva Cotización
              </button>
              <button class="btn-inv btn-inv-amber" data-bs-toggle="modal" data-bs-target="#modalRemision">
                <i class="fas fa-truck-loading"></i> Nueva Remisión
              </button>
              <button class="btn-inv btn-inv-success" data-bs-toggle="modal" data-bs-target="#modalCompra">
                <i class="fas fa-shopping-cart"></i> Registrar Compra
              </button>
            </div>
          </div>

          <!-- ══ TABS ══ -->
          <div class="cmp-tabs">
            <button class="cmp-tab-btn active" data-cmp-tab="cotizaciones">
              <i class="fas fa-file-alt"></i> Cotizaciones
              <span class="tbl-count"><?= count($cotizaciones) ?></span>
            </button>
            <button class="cmp-tab-btn" data-cmp-tab="remisiones">
              <i class="fas fa-truck-loading"></i> Remisiones
              <span class="tbl-count"><?= count($remisiones) ?></span>
            </button>
            <button class="cmp-tab-btn" data-cmp-tab="compras">
              <i class="fas fa-shopping-cart"></i> Compras
              <span class="tbl-count"><?= count($compras) ?></span>
            </button>
          </div>

          <!-- ══ TAB: COTIZACIONES ══ -->
          <div data-cmp-pane="cotizaciones">
            <div class="usr-table-card">
              <div class="tbl-header">
                <span class="tbl-title"><i class="fas fa-file-alt"></i> Cotizaciones de compra</span>
              </div>
              <div class="table-responsive">
                <table class="cmp-table" id="tbl-cotizaciones" data-paginate="10">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Proveedor</th>
                      <th>NIT</th>
                      <th>Fecha</th>
                      <th>Estado</th>
                      <th>Total</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (empty($cotizaciones)): ?>
                    <tr><td colspan="7" class="cart-empty"><i class="fas fa-file-alt"></i>No hay cotizaciones registradas.</td></tr>
                    <?php else: foreach ($cotizaciones as $c): ?>
                    <?php
                      $estadoCls = match($c->estado) {
                        'Aprobada'  => 'badge-aprobada',
                        'Rechazada' => 'badge-rechazada',
                        'Cancelada' => 'badge-cancelada',
                        default     => 'badge-pendiente',
                      };
                    ?>
                    <tr>
                      <td style="font-weight:700;color:var(--muted);">#<?= $c->id ?></td>
                      <td style="font-weight:600;"><?= esc($c->proveedor) ?></td>
                      <td style="color:var(--muted);"><?= esc($c->nit ?? '—') ?></td>
                      <td><?= substr($c->fecha ?? '', 0, 10) ?></td>
                      <td><span class="badge-cmp <?= $estadoCls ?>"><?= esc($c->estado) ?></span></td>
                      <td style="font-weight:700;">$<?= number_format($c->total, 0, ',', '.') ?></td>
                      <td>
                        <div class="action-wrap">
                          <?php if ($c->estado === 'Pendiente'): ?>
                          <button class="btn-action btn-action-success" title="Aprobar"
                            data-cot-estado="Aprobada" data-cot-id="<?= $c->id ?>">
                            <i class="fas fa-check" style="font-size:11px;"></i>
                          </button>
                          <button class="btn-action btn-action-del" title="Rechazar"
                            data-cot-estado="Rechazada" data-cot-id="<?= $c->id ?>">
                            <i class="fas fa-times" style="font-size:11px;"></i>
                          </button>
                          <?php endif; ?>
                          <?php if ($c->estado === 'Aprobada'): ?>
                          <button class="btn-action btn-action-amber" title="Crear remisión desde esta cotización"
                            data-abrir-remision="<?= $c->id ?>">
                            <i class="fas fa-truck-loading" style="font-size:11px;"></i>
                          </button>
                          <?php endif; ?>
                        </div>
                      </td>
                    </tr>
                    <?php endforeach; endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- ══ TAB: REMISIONES ══ -->
          <div data-cmp-pane="remisiones" style="display:none;">
            <div class="usr-table-card">
              <div class="tbl-header">
                <span class="tbl-title"><i class="fas fa-truck-loading"></i> Remisiones de proveedor</span>
              </div>
              <div class="table-responsive">
                <table class="cmp-table" id="tbl-remisiones" data-paginate="10">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>N° Remisión</th>
                      <th>Proveedor</th>
                      <th>Cot. vinculada</th>
                      <th>Fecha</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (empty($remisiones)): ?>
                    <tr><td colspan="7" class="cart-empty"><i class="fas fa-truck"></i>No hay remisiones registradas.</td></tr>
                    <?php else: foreach ($remisiones as $r): ?>
                    <?php
                      $estadoCls = match($r->estado) {
                        'Recibida' => 'badge-recibida',
                        'Parcial'  => 'badge-parcial',
                        default    => 'badge-pendiente',
                      };
                    ?>
                    <tr>
                      <td style="font-weight:700;color:var(--muted);">#<?= $r->id ?></td>
                      <td style="font-weight:600;"><?= esc($r->numero_remision ?: '—') ?></td>
                      <td><?= esc($r->proveedor) ?></td>
                      <td style="color:var(--muted);"><?= $r->cotizacion_id ? '#' . $r->cotizacion_id : '—' ?></td>
                      <td><?= substr($r->fecha ?? '', 0, 10) ?></td>
                      <td><span class="badge-cmp <?= $estadoCls ?>"><?= esc($r->estado) ?></span></td>
                      <td>
                        <div class="action-wrap">
                          <button class="btn-action btn-action-success" title="Crear compra desde esta remisión"
                            data-abrir-compra="<?= $r->id ?>">
                            <i class="fas fa-shopping-cart" style="font-size:11px;"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                    <?php endforeach; endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- ══ TAB: COMPRAS ══ -->
          <div data-cmp-pane="compras" style="display:none;">
            <div class="usr-table-card">
              <div class="tbl-header">
                <span class="tbl-title"><i class="fas fa-shopping-cart"></i> Compras registradas</span>
              </div>
              <div class="table-responsive">
                <table class="cmp-table" id="tbl-compras" data-paginate="10">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>N° Factura</th>
                      <th>Proveedor</th>
                      <th>Cot.</th>
                      <th>Rem.</th>
                      <th>Fecha</th>
                      <th>Total</th>
                      <th>Estado</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (empty($compras)): ?>
                    <tr><td colspan="8" class="cart-empty"><i class="fas fa-shopping-bag"></i>No hay compras registradas.</td></tr>
                    <?php else: foreach ($compras as $cp): ?>
                    <?php
                      $estadoCls = match($cp->estado) {
                        'Pagada'  => 'badge-pagada',
                        'Anulada' => 'badge-anulada',
                        default   => 'badge-pendiente',
                      };
                    ?>
                    <tr>
                      <td style="font-weight:700;color:var(--muted);">#<?= $cp->id ?></td>
                      <td style="font-weight:600;"><?= esc($cp->numero_factura ?: '—') ?></td>
                      <td><?= esc($cp->proveedor) ?></td>
                      <td style="color:var(--muted);"><?= $cp->cotizacion_id ? '#' . $cp->cotizacion_id : '—' ?></td>
                      <td style="color:var(--muted);"><?= $cp->remision_id ? '#' . $cp->remision_id : '—' ?></td>
                      <td><?= substr($cp->fecha ?? '', 0, 10) ?></td>
                      <td style="font-weight:700;">$<?= number_format($cp->total, 0, ',', '.') ?></td>
                      <td><span class="badge-cmp <?= $estadoCls ?>"><?= esc($cp->estado) ?></span></td>
                    </tr>
                    <?php endforeach; endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div><!-- /usr-wrapper -->
      </div><!-- /content-wrapper -->
    </div><!-- /main-panel -->
  </div><!-- /page-body-wrapper -->
</div><!-- /container-scroller -->


<!-- ══════════════════════════════════════════════
     MODAL: NUEVA COTIZACIÓN
══════════════════════════════════════════════ -->
<div class="modal fade" id="modalCotizacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header modal-header-inv">
        <h1 class="modal-title"><i class="fas fa-file-alt me-2"></i>Nueva Cotización de Compra</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" style="padding:20px;">

        <div id="cot-alerta" class="alert alert-danger py-2 px-3" style="display:none;margin-bottom:14px;"></div>

        <!-- Proveedor -->
        <div class="form-section">
          <div class="form-section-title"><i class="fas fa-store"></i> Datos del proveedor</div>
          <div class="row g-3">
            <div class="col-md-5">
              <div class="fl">
                <label>Proveedor *</label>
                <input type="text" id="cot-proveedor" class="fc" placeholder="Nombre del proveedor">
              </div>
            </div>
            <div class="col-md-3">
              <div class="fl">
                <label>NIT</label>
                <input type="text" id="cot-nit" class="fc" placeholder="NIT o cédula">
              </div>
            </div>
            <div class="col-md-2">
              <div class="fl">
                <label>Fecha *</label>
                <input type="date" id="cot-fecha" class="fc">
              </div>
            </div>
            <div class="col-md-2">
              <div class="fl">
                <label>Observación</label>
                <input type="text" id="cot-obs" class="fc" placeholder="Opcional">
              </div>
            </div>
          </div>
        </div>

        <!-- Búsqueda producto -->
        <div class="form-section">
          <div class="form-section-title"><i class="fas fa-barcode"></i> Agregar productos</div>
          <div id="cot-search-wrap" style="position:relative;max-width:600px;">
            <div class="search-bar">
              <input type="text" id="cot-search" placeholder="Escribe el nombre o código del producto…" autocomplete="off">
              <button type="button"><i class="fas fa-search"></i></button>
            </div>
            <div id="cot-dropdown" style="display:none;position:absolute;top:100%;left:0;right:0;z-index:1050;
              background:#fff;border:1.5px solid var(--purple-200);border-top:none;
              border-radius:0 0 10px 10px;box-shadow:0 8px 24px rgba(45,102,34,.12);
              max-height:240px;overflow-y:auto;"></div>
          </div>
        </div>

        <!-- Carrito -->
        <div class="cart-card">
          <div class="cart-header">
            <h5><i class="fas fa-list"></i> Productos en cotización <span class="cart-count" id="cot-count">0 items</span></h5>
          </div>
          <div class="table-responsive">
            <table class="cart-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Código</th>
                  <th>Producto</th>
                  <th style="text-align:center;">Cantidad</th>
                  <th style="text-align:center;">Precio Unit.</th>
                  <th style="text-align:right;">Subtotal</th>
                  <th style="text-align:center;"></th>
                </tr>
              </thead>
              <tbody id="cot-tbody">
                <tr id="cot-empty-row">
                  <td colspan="7" class="cart-empty">
                    <i class="fas fa-search"></i>Busca y agrega productos para cotizar.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="total-bar">
            <span>Total estimado:</span>
            <span id="cot-total" style="font-size:18px;color:var(--purple-700);">$0</span>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn-u btn-u-danger-outline" data-bs-dismiss="modal">
          <i class="fas fa-times"></i> Cerrar
        </button>
        <button type="button" id="cot-btn-guardar" class="btn-u btn-u-primary" disabled>
          <i class="fas fa-save"></i> Guardar cotización
        </button>
      </div>
    </div>
  </div>
</div>


<!-- ══════════════════════════════════════════════
     MODAL: NUEVA REMISIÓN
══════════════════════════════════════════════ -->
<div class="modal fade" id="modalRemision" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header modal-header-inv">
        <h1 class="modal-title"><i class="fas fa-truck-loading me-2"></i>Registrar Remisión de Compra</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" style="padding:20px;">

        <div id="rem-alerta" class="alert alert-danger py-2 px-3" style="display:none;margin-bottom:14px;"></div>

        <!-- Cargar desde cotización -->
        <div class="form-section">
          <div class="form-section-title"><i class="fas fa-link"></i> Vincular a cotización (opcional)</div>
          <div class="row g-3 align-items-end">
            <div class="col-md-3">
              <div class="fl">
                <label>ID de cotización aprobada</label>
                <input type="number" id="rem-cot-id" class="fc" placeholder="Ej: 1" min="1">
              </div>
            </div>
            <div class="col-md-2">
              <button type="button" id="rem-btn-cargar" class="btn btn-primary btn-sm btn-rounded w-100">
                <i class="fas fa-download"></i> Cargar cotización
              </button>
            </div>
            <div class="col-md-7">
              <div id="rem-cot-info-wrap" class="info-strip">
                <i class="fas fa-check-circle" style="color:var(--green);"></i>
                <span id="rem-cot-info"></span>
              </div>
            </div>
          </div>
        </div>

        <!-- Datos remisión -->
        <div class="form-section">
          <div class="form-section-title"><i class="fas fa-store"></i> Datos de la remisión</div>
          <div class="row g-3">
            <div class="col-md-4">
              <div class="fl">
                <label>Proveedor *</label>
                <input type="text" id="rem-proveedor" class="fc" placeholder="Nombre del proveedor">
              </div>
            </div>
            <div class="col-md-3">
              <div class="fl">
                <label>N° Remisión / Guía</label>
                <input type="text" id="rem-numero" class="fc" placeholder="Ej: REM-2024-001">
              </div>
            </div>
            <div class="col-md-2">
              <div class="fl">
                <label>Fecha *</label>
                <input type="date" id="rem-fecha" class="fc">
              </div>
            </div>
            <div class="col-md-3">
              <div class="fl">
                <label>Observación</label>
                <input type="text" id="rem-obs" class="fc" placeholder="Opcional">
              </div>
            </div>
          </div>
        </div>

        <!-- Tabla productos recibidos -->
        <div class="cart-card">
          <div class="cart-header">
            <h5><i class="fas fa-boxes"></i> Productos recibidos</h5>
            <span style="font-size:11px;color:var(--muted);">Ajusta la cantidad realmente recibida de cada ítem</span>
          </div>
          <div class="table-responsive">
            <table class="cart-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Producto</th>
                  <th style="text-align:center;">Cant. Pedida</th>
                  <th style="text-align:center;">Cant. Recibida</th>
                  <th style="text-align:center;">Precio Unit.</th>
                </tr>
              </thead>
              <tbody id="rem-tbody">
                <tr id="rem-empty-row">
                  <td colspan="5" class="cart-empty">
                    <i class="fas fa-truck"></i>Carga una cotización o agrega los productos manualmente.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn-u btn-u-danger-outline" data-bs-dismiss="modal">
          <i class="fas fa-times"></i> Cerrar
        </button>
        <button type="button" id="rem-btn-guardar" class="btn-u btn-u-primary" disabled>
          <i class="fas fa-save"></i> Registrar remisión
        </button>
      </div>
    </div>
  </div>
</div>


<!-- ══════════════════════════════════════════════
     MODAL: REGISTRAR COMPRA
══════════════════════════════════════════════ -->
<div class="modal fade" id="modalCompra" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header modal-header-inv">
        <h1 class="modal-title"><i class="fas fa-shopping-cart me-2"></i>Registrar Compra</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" style="padding:20px;">

        <div id="cmp-alerta" class="alert alert-danger py-2 px-3" style="display:none;margin-bottom:14px;"></div>

        <!-- Cargar desde remisión -->
        <div class="form-section">
          <div class="form-section-title"><i class="fas fa-link"></i> Cargar desde remisión</div>
          <div class="row g-3 align-items-end">
            <div class="col-md-3">
              <div class="fl">
                <label>ID de remisión</label>
                <input type="number" id="cmp-rem-id" class="fc" placeholder="Ej: 1" min="1">
              </div>
            </div>
            <div class="col-md-2">
              <button type="button" id="cmp-btn-cargar" class="btn btn-primary btn-sm btn-rounded w-100">
                <i class="fas fa-download"></i> Cargar remisión
              </button>
            </div>
            <div class="col-md-7">
              <div id="cmp-rem-info-wrap" class="info-strip">
                <i class="fas fa-check-circle" style="color:var(--green);"></i>
                <span id="cmp-rem-info"></span>
              </div>
            </div>
          </div>
        </div>

        <!-- Datos compra -->
        <div class="form-section">
          <div class="form-section-title"><i class="fas fa-file-invoice-dollar"></i> Datos de la compra</div>
          <div class="row g-3">
            <div class="col-md-4">
              <div class="fl">
                <label>Proveedor *</label>
                <input type="text" id="cmp-proveedor" class="fc" placeholder="Nombre del proveedor">
              </div>
            </div>
            <div class="col-md-3">
              <div class="fl">
                <label>N° Factura</label>
                <input type="text" id="cmp-factura" class="fc" placeholder="Ej: FAC-2024-001">
              </div>
            </div>
            <div class="col-md-2">
              <div class="fl">
                <label>Fecha *</label>
                <input type="date" id="cmp-fecha" class="fc">
              </div>
            </div>
            <div class="col-md-3">
              <div class="fl">
                <label>Observación</label>
                <input type="text" id="cmp-obs" class="fc" placeholder="Opcional">
              </div>
            </div>
          </div>
        </div>

        <!-- Tabla ítems compra -->
        <div class="cart-card">
          <div class="cart-header">
            <h5><i class="fas fa-box-open"></i> Ítems a comprar</h5>
            <span style="font-size:11px;color:var(--muted);"><i class="fas fa-info-circle"></i> Al guardar, el stock de cada producto se actualizará automáticamente</span>
          </div>
          <div class="table-responsive">
            <table class="cart-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Producto</th>
                  <th style="text-align:center;">Cantidad</th>
                  <th style="text-align:center;">Precio Unit.</th>
                  <th style="text-align:right;">Subtotal</th>
                </tr>
              </thead>
              <tbody id="cmp-tbody">
                <tr id="cmp-empty-row">
                  <td colspan="5" class="cart-empty">
                    <i class="fas fa-boxes"></i>Carga una remisión para ver los productos.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="total-bar">
            <span>Total de la compra:</span>
            <span id="cmp-total" style="font-size:18px;color:var(--purple-700);">$0</span>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn-u btn-u-danger-outline" data-bs-dismiss="modal">
          <i class="fas fa-times"></i> Cerrar
        </button>
        <button type="button" id="cmp-btn-guardar" class="btn-u btn-u-success" disabled>
          <i class="fas fa-shopping-cart"></i> Registrar compra
        </button>
      </div>
    </div>
  </div>
</div>


<?php require_once("componentes/scripts.php") ?>
<script src="<?= base_url('js/compras.js') ?>"></script>
</body>
</html>

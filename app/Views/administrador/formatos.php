<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Control de Temperaturas</title>
  <?php require_once("componentes/head.php") ?>
<style>
:root {
  --g900:#0d2409;--g800:#173a10;--g700:#2d6622;--g600:#4a8a37;
  --g500:#7fac6e;--g400:#8fba7e;--g300:#abd49b;--g200:#d4eacc;--g100:#f0f7ec;
  --red:#ef4444;--red-l:#fee2e2;--red-d:#991b1b;
  --amber:#f59e0b;--amber-l:#fef3c7;--amber-d:#92400e;
  --green:#10b981;--green-l:#d1fae5;--green-d:#065f46;
  --surface:#fff;--surface-alt:#fafbff;--border:#e8e0f5;
  --text:#0d2409;--muted:#7c6fa0;
  --sh-sm:0 1px 3px rgba(45,102,34,.08);--sh-md:0 4px 16px rgba(45,102,34,.12);
  --radius:14px;--radius-sm:8px;--ease:cubic-bezier(.4,0,.2,1);
}
*{box-sizing:border-box;margin:0;padding:0;}
body{font-family:Arial,Helvetica;background:var(--surface-alt);color:var(--text);}
::-webkit-scrollbar{width:6px;}::-webkit-scrollbar-track{background:#f0f7ec;}
::-webkit-scrollbar-thumb{background:var(--g400);border-radius:99px;}

.wrap{padding:26px 30px;}
.topbar{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:14px;margin-bottom:26px;}
.breadcrumb-lbl{font-size:11px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--g400);margin-bottom:3px;}
.page-title{font-size:25px;font-weight:800;color:var(--g800);}

.btn{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:50px;font-family:Arial,Helvetica;font-size:13px;font-weight:600;cursor:pointer;border:none;transition:all .25s var(--ease);white-space:nowrap;text-decoration:none;}
.btn-primary{background:linear-gradient(135deg,var(--g600),var(--g500));color:#fff;box-shadow:0 4px 14px rgba(74,138,55,.35);}
.btn-primary:hover{background:linear-gradient(135deg,var(--g700),var(--g600));transform:translateY(-1px);color:#fff;}
.btn-cancel{background:transparent;border:1.5px solid var(--red);color:var(--red);border-radius:50px;padding:9px 18px;font-family:Arial,Helvetica;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:7px;transition:all .25s var(--ease);}
.btn-cancel:hover{background:var(--red);color:#fff;transform:translateY(-1px);}
.btn-pdf{background:linear-gradient(135deg,#dc2626,#ef4444);color:#fff;box-shadow:0 4px 14px rgba(220,38,38,.3);}
.btn-pdf:hover{background:linear-gradient(135deg,#b91c1c,#dc2626);transform:translateY(-1px);color:#fff;}

/* Stats */
.stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:14px;margin-bottom:26px;}
.stat{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 18px;display:flex;align-items:center;gap:14px;box-shadow:var(--sh-sm);animation:slideUp .4s ease both;}
.stat:nth-child(1){animation-delay:.05s;} .stat:nth-child(2){animation-delay:.1s;} .stat:nth-child(3){animation-delay:.15s;} .stat:nth-child(4){animation-delay:.2s;}
.stat-icon{width:44px;height:44px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;}
.si-blue{background:#dbeafe;color:#1e40af;} .si-green{background:var(--green-l);color:var(--green-d);}
.si-amber{background:var(--amber-l);color:var(--amber-d);} .si-red{background:var(--red-l);color:var(--red-d);}
.stat-num{font-size:22px;font-weight:800;color:var(--g800);line-height:1;}
.stat-lbl{font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-top:3px;}

/* Neveras grid */
.neveras-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:18px;margin-bottom:28px;}
.nevera-card{background:var(--surface);border:1.5px solid var(--border);border-radius:var(--radius);box-shadow:var(--sh-sm);overflow:hidden;transition:all .25s var(--ease);animation:slideUp .4s ease both;}
.nevera-card:hover{box-shadow:var(--sh-md);transform:translateY(-2px);}
.nc-top{padding:16px 18px 12px;}
.nc-name{font-size:15px;font-weight:800;color:var(--g800);margin-bottom:4px;}
.nc-range{font-size:12px;color:var(--muted);display:flex;align-items:center;gap:5px;}
.nc-range i{color:var(--g500);}

.nc-status{margin:10px 18px;padding:10px 14px;border-radius:10px;display:flex;align-items:center;gap:10px;}
.nc-status.ok{background:var(--green-l);border:1.5px solid #6ee7b7;}
.nc-status.alerta{background:var(--red-l);border:1.5px solid #fca5a5;}
.nc-status.limite{background:var(--amber-l);border:1.5px solid #fcd34d;}
.nc-status.pendiente{background:var(--g100);border:1.5px solid var(--g200);}

.nc-semaforo{width:32px;height:32px;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:14px;}
.sem-ok{background:var(--green);color:#fff;}
.sem-alerta{background:var(--red);color:#fff;}
.sem-limite{background:var(--amber);color:#fff;}
.sem-pendiente{background:var(--g300);color:var(--g800);}

.nc-temp-val{font-size:20px;font-weight:800;line-height:1;}
.nc-temp-lbl{font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.05em;margin-top:2px;}
.ok .nc-temp-val,.ok .nc-temp-lbl{color:var(--green-d);}
.alerta .nc-temp-val,.alerta .nc-temp-lbl{color:var(--red-d);}
.limite .nc-temp-val,.limite .nc-temp-lbl{color:var(--amber-d);}
.pendiente .nc-temp-val,.pendiente .nc-temp-lbl{color:var(--muted);}

.nc-hora{font-size:11px;color:var(--muted);margin-left:auto;}

.nc-actions{padding:12px 18px;border-top:1px solid var(--border);display:flex;gap:8px;background:var(--g100);}
.btn-reg{flex:1;padding:8px 12px;border-radius:50px;background:linear-gradient(135deg,var(--g600),var(--g500));color:#fff;border:none;font-family:Arial,Helvetica;font-size:12px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;transition:all .25s var(--ease);}
.btn-reg:hover:not(:disabled){background:linear-gradient(135deg,var(--g700),var(--g600));transform:translateY(-1px);}
.btn-reg:disabled{opacity:.45;cursor:not-allowed;transform:none;}
.btn-del-nev{width:34px;height:34px;border-radius:50%;background:var(--red-l);color:var(--red-d);border:1.5px solid #fca5a5;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:12px;transition:all .25s var(--ease);}
.btn-del-nev:hover{background:var(--red);color:#fff;}

/* Historial */
.hist-card{background:var(--surface);border:1.5px solid var(--border);border-radius:var(--radius);box-shadow:var(--sh-sm);overflow:hidden;}
.hist-header{padding:14px 20px;border-bottom:1px solid var(--border);background:linear-gradient(90deg,var(--g100),#fdf8ff);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;}
.hist-header h5{font-size:14px;font-weight:700;color:var(--g800);display:flex;align-items:center;gap:8px;margin:0;}

.hist-table{width:100%;border-collapse:collapse;font-size:13px;}
.hist-table thead tr{background:linear-gradient(135deg,var(--g800),var(--g700));}
.hist-table thead th{padding:11px 16px;color:#fff;font-size:10.5px;font-weight:700;letter-spacing:.05em;text-transform:uppercase;white-space:nowrap;}
.hist-table tbody tr{border-bottom:1px solid var(--border);transition:background .15s;}
.hist-table tbody tr:hover{background:var(--g100);}
.hist-table tbody td{padding:11px 16px;vertical-align:middle;}

.badge-ok{background:var(--green-l);color:var(--green-d);padding:3px 10px;border-radius:50px;font-size:11px;font-weight:700;}
.badge-alerta{background:var(--red-l);color:var(--red-d);padding:3px 10px;border-radius:50px;font-size:11px;font-weight:700;}
.badge-limite{background:var(--amber-l);color:var(--amber-d);padding:3px 10px;border-radius:50px;font-size:11px;font-weight:700;}

/* Form in modal */
.fl{display:flex;flex-direction:column;gap:4px;}
.fl label{font-size:10.5px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);}
.fc{width:100%;padding:9px 13px;border:1.5px solid var(--border);border-radius:var(--radius-sm);font-family:Arial,Helvetica;font-size:13px;color:var(--text);background:var(--surface);outline:none;transition:border-color .2s;}
.fc:focus{border-color:var(--g500);}

/* OCR drop zone */
.ocr-zone{border:2px dashed var(--g200);border-radius:10px;padding:20px;text-align:center;cursor:pointer;background:var(--g100);transition:all .2s;position:relative;}
.ocr-zone:hover{border-color:var(--g500);background:var(--g200);}
.ocr-zone input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;}

/* Temp display */
.temp-big{text-align:center;padding:16px 0;}
.temp-big .val{font-size:48px;font-weight:800;color:var(--g800);line-height:1;}
.temp-big .lbl{font-size:11px;text-transform:uppercase;letter-spacing:.08em;color:var(--muted);margin-top:4px;}

.modal-header-inv{background:linear-gradient(135deg,var(--g800),var(--g600))!important;padding:17px 24px;border-bottom:none;}
.modal-header-inv .modal-title{font-family:Arial,Helvetica;font-size:14.5px;font-weight:700;color:#fff;}
.modal-header-inv .btn-close{filter:invert(1);opacity:.85;}
.modal-content{border:none!important;border-radius:var(--radius)!important;overflow:hidden;box-shadow:0 12px 40px rgba(45,102,34,.18);}
.modal-body{background:var(--surface-alt);padding:22px;}
.modal-footer{background:var(--surface);border-top:1px solid var(--border);padding:13px 22px;}

/* Empty state */
.empty-state{text-align:center;padding:60px 20px;color:var(--muted);}
.empty-state i{font-size:48px;opacity:.2;display:block;margin-bottom:14px;}

@keyframes slideUp{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}
</style>
</head>
<body>
<div class="container-scroller">
  <?php require_once("componentes/navbar.php") ?>
  <div class="container-fluid page-body-wrapper">
    <?php require_once("componentes/lateralderecha.php") ?>
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="wrap">

          <!-- TOP BAR -->
          <div class="topbar">
            <div>
              <p class="breadcrumb-lbl">Administración &rsaquo; Calidad</p>
              <h1 class="page-title">Control de Temperaturas</h1>
            </div>
            <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
              <a href="<?= base_url('temperatura/reporte/pdf?fecha=' . $hoy) ?>" target="_blank" class="btn btn-pdf">
                <i class="fas fa-file-pdf"></i> Reporte PDF hoy
              </a>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearNevera">
                <i class="fas fa-plus"></i> Nueva nevera
              </button>
            </div>
          </div>

          <!-- STATS -->
          <div class="stats">
            <div class="stat">
              <div class="stat-icon si-blue"><i class="fas fa-snowflake"></i></div>
              <div><div class="stat-num"><?= $totalNeveras ?></div><div class="stat-lbl">Total neveras</div></div>
            </div>
            <div class="stat">
              <div class="stat-icon si-green"><i class="fas fa-check-circle"></i></div>
              <div><div class="stat-num"><?= $registradasHoy ?></div><div class="stat-lbl">Registradas hoy</div></div>
            </div>
            <div class="stat">
              <div class="stat-icon si-amber"><i class="fas fa-clock"></i></div>
              <div><div class="stat-num"><?= $pendientes ?></div><div class="stat-lbl">Pendientes</div></div>
            </div>
            <div class="stat">
              <div class="stat-icon si-red"><i class="fas fa-exclamation-triangle"></i></div>
              <div><div class="stat-num"><?= $alertas ?></div><div class="stat-lbl">Alertas</div></div>
            </div>
          </div>

          <!-- NEVERAS GRID -->
          <?php if (empty($neveras)): ?>
          <div class="empty-state">
            <i class="fas fa-snowflake"></i>
            <p style="font-size:16px;font-weight:700;color:var(--g700);">No hay neveras registradas</p>
            <p style="font-size:13px;margin-top:6px;">Crea la primera nevera con el botón "Nueva nevera"</p>
          </div>
          <?php else: ?>
          <div class="neveras-grid">
            <?php foreach ($neveras as $n):
              $reg     = $registradosHoy[$n->id] ?? null;
              $clase   = 'pendiente';
              $semCls  = 'sem-pendiente';
              $semIcon = 'fa-question';
              $tempMostrar = '—';
              $estadoLbl   = 'Sin registro';

              if ($reg) {
                $t = (float)$reg->temperatura;
                $tempMostrar = $t . '°C';
                if ($t < $n->temp_min || $t > $n->temp_max) {
                  $clase='alerta'; $semCls='sem-alerta'; $semIcon='fa-times'; $estadoLbl='Fuera de rango';
                } elseif ($t <= $n->temp_min + 1 || $t >= $n->temp_max - 1) {
                  $clase='limite'; $semCls='sem-limite'; $semIcon='fa-exclamation'; $estadoLbl='En el límite';
                } else {
                  $clase='ok'; $semCls='sem-ok'; $semIcon='fa-check'; $estadoLbl='Dentro del rango';
                }
              }
            ?>
            <div class="nevera-card">
              <div class="nc-top">
                <div class="nc-name"><i class="fas fa-snowflake" style="color:var(--g500);margin-right:6px;"></i><?= esc($n->nombre) ?></div>
                <div class="nc-range"><i class="fas fa-thermometer-half"></i> Rango: <?= $n->temp_min ?>°C — <?= $n->temp_max ?>°C</div>
              </div>
              <div class="nc-status <?= $clase ?>">
                <div class="nc-semaforo <?= $semCls ?>"><i class="fas <?= $semIcon ?>"></i></div>
                <div style="flex:1;">
                  <div class="nc-temp-val"><?= $tempMostrar ?></div>
                  <div class="nc-temp-lbl"><?= $estadoLbl ?></div>
                </div>
                <?php if ($reg): ?>
                <div class="nc-hora"><?= substr($reg->hora, 0, 5) ?></div>
                <?php endif; ?>
              </div>
              <div class="nc-actions">
                <button class="btn-reg btn-registrar-temp"
                  data-id="<?= $n->id ?>"
                  data-nombre="<?= esc($n->nombre) ?>"
                  data-min="<?= $n->temp_min ?>"
                  data-max="<?= $n->temp_max ?>"
                  <?= $reg ? 'disabled' : '' ?>>
                  <i class="fas <?= $reg ? 'fa-check' : 'fa-thermometer-half' ?>"></i>
                  <?= $reg ? 'Registrado' : 'Registrar temperatura' ?>
                </button>
                <button class="btn-del-nev btn-eliminar-nevera" data-id="<?= $n->id ?>" data-nombre="<?= esc($n->nombre) ?>" title="Eliminar nevera">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>

          <!-- HISTORIAL HOY -->
          <?php if (!empty($registrosHoy)): ?>
          <div class="hist-card">
            <div class="hist-header">
              <h5><i class="fas fa-history" style="color:var(--g600);"></i> Registros de hoy — <?= date('d/m/Y') ?></h5>
              <span style="background:var(--g600);color:#fff;font-size:11px;font-weight:700;padding:2px 10px;border-radius:50px;"><?= count($registrosHoy) ?> registros</span>
            </div>
            <div class="table-responsive">
              <table class="hist-table">
                <thead>
                  <tr>
                    <th>Nevera</th>
                    <th style="text-align:center;">Temperatura</th>
                    <th style="text-align:center;">Rango</th>
                    <th style="text-align:center;">Estado</th>
                    <th style="text-align:center;">Hora</th>
                    <th>Usuario</th>
                    <th>Observación</th>
                    <th style="text-align:center;">Foto</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($registrosHoy as $r):
                    $t = (float)$r->temperatura;
                    if ($t < $r->temp_min || $t > $r->temp_max) {
                      $badgeCls = 'badge-alerta'; $badgeTxt = 'Fuera de rango';
                    } elseif ($t <= $r->temp_min + 1 || $t >= $r->temp_max - 1) {
                      $badgeCls = 'badge-limite'; $badgeTxt = 'En el límite';
                    } else {
                      $badgeCls = 'badge-ok'; $badgeTxt = 'OK';
                    }
                  ?>
                  <tr>
                    <td style="font-weight:700;"><?= esc($r->nevera_nombre) ?></td>
                    <td style="text-align:center;font-weight:800;font-size:15px;"><?= $r->temperatura ?>°C</td>
                    <td style="text-align:center;font-size:12px;color:var(--muted);"><?= $r->temp_min ?>° — <?= $r->temp_max ?>°</td>
                    <td style="text-align:center;"><span class="<?= $badgeCls ?>"><?= $badgeTxt ?></span></td>
                    <td style="text-align:center;font-weight:600;"><?= substr($r->hora, 0, 5) ?></td>
                    <td style="font-size:12px;color:var(--muted);"><?= esc($r->usuario_id ?? '—') ?></td>
                    <td style="font-size:12px;color:var(--muted);"><?= esc($r->observacion ?: '—') ?></td>
                    <td style="text-align:center;">
                      <?php if ($r->imagen): ?>
                      <button onclick="verFoto(this)" data-img="<?= htmlspecialchars($r->imagen) ?>"
                        style="background:var(--g100);color:var(--g700);border:1.5px solid var(--g200);border-radius:7px;width:30px;height:30px;cursor:pointer;font-size:12px;display:inline-flex;align-items:center;justify-content:center;">
                        <i class="fas fa-eye"></i>
                      </button>
                      <?php else: ?>
                      <span style="color:var(--muted);font-size:12px;">—</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
          <?php endif; ?>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL: Crear nevera -->
<div class="modal fade" id="modalCrearNevera" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header modal-header-inv">
        <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Nueva nevera</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-12">
            <div class="fl"><label>Nombre de la nevera *</label>
              <input type="text" id="nev-nombre" class="fc" placeholder="Ej: Nevera carnes, Nevera lácteos…">
            </div>
          </div>
          <div class="col-6">
            <div class="fl"><label>Temperatura mínima (°C) *</label>
              <input type="number" id="nev-min" class="fc" step="0.5" placeholder="Ej: 2">
            </div>
          </div>
          <div class="col-6">
            <div class="fl"><label>Temperatura máxima (°C) *</label>
              <input type="number" id="nev-max" class="fc" step="0.5" placeholder="Ej: 8">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" id="btn-guardar-nevera" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL: Registrar temperatura -->
<div class="modal fade" id="modalRegistrar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header modal-header-inv">
        <h5 class="modal-title"><i class="fas fa-thermometer-half me-2"></i>Registrar temperatura — <span id="mod-nev-nombre"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="mod-nevera-id">
        <div class="row g-3">
          <!-- Izquierda: imagen OCR -->
          <div class="col-md-6">
            <div class="fl" style="margin-bottom:12px;"><label>Foto del termómetro (opcional)</label></div>
            <div class="ocr-zone" id="reg-drop-zone">
              <input type="file" id="reg-file-input" accept="image/*">
              <i class="fas fa-camera" style="font-size:28px;color:var(--g400);display:block;margin-bottom:8px;"></i>
              <p style="font-size:12px;color:var(--muted);"><strong style="color:var(--g600);">Arrastra o haz clic</strong><br><span style="font-size:10px;">JPG · PNG · WEBP</span></p>
            </div>
            <div id="reg-preview-wrap" style="display:none;margin-top:10px;text-align:center;">
              <img id="reg-preview-img" style="max-height:160px;border-radius:10px;object-fit:contain;" alt="">
              <p style="font-size:11px;color:var(--g600);margin-top:4px;"><i class="fas fa-check-circle"></i> Imagen cargada</p>
            </div>
            <!-- OCR progress -->
            <div id="reg-ocr-progress" style="display:none;margin-top:10px;background:var(--g100);border-radius:8px;padding:8px 12px;">
              <div style="background:var(--g200);border-radius:99px;height:5px;overflow:hidden;margin-bottom:4px;">
                <div id="reg-ocr-fill" style="height:100%;background:var(--g500);width:0%;transition:width .3s;border-radius:99px;"></div>
              </div>
              <div id="reg-ocr-lbl" style="font-size:10px;color:var(--muted);text-align:center;">Procesando OCR…</div>
            </div>
          </div>
          <!-- Derecha: datos -->
          <div class="col-md-6">
            <div style="background:var(--g100);border:1.5px solid var(--g200);border-radius:12px;padding:14px;margin-bottom:14px;font-size:12px;color:var(--g700);">
              <i class="fas fa-info-circle"></i> Rango permitido: <strong id="mod-rango"></strong>
            </div>
            <div class="temp-big">
              <div class="val" id="mod-temp-display">—</div>
              <div class="lbl">°C registrados</div>
            </div>
            <div class="fl" style="margin-bottom:12px;">
              <label>Temperatura medida (°C) *</label>
              <input type="number" id="reg-temp" class="fc" step="0.1" placeholder="Ej: 4.5" style="font-size:18px;font-weight:700;text-align:center;">
            </div>
            <div class="fl">
              <label>Observación (opcional)</label>
              <input type="text" id="reg-obs" class="fc" placeholder="Ej: Temperatura estable, sin variaciones">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" id="btn-guardar-temp" class="btn btn-primary"><i class="fas fa-save"></i> Registrar y enviar WhatsApp</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL: Ver foto -->
<div class="modal fade" id="modalFoto" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background:#000;border:none;">
      <div class="modal-body" style="padding:8px;text-align:center;">
        <img id="foto-modal-img" style="max-width:100%;max-height:80vh;border-radius:8px;" alt="">
      </div>
      <div class="modal-footer" style="background:#111;border:none;justify-content:center;">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<?php require_once("componentes/scripts.php") ?>
<script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
<script>
(function () {
  'use strict';

  var regImagen = null;

  /* ── Crear nevera ── */
  document.getElementById('btn-guardar-nevera').addEventListener('click', function () {
    var nombre = document.getElementById('nev-nombre').value.trim();
    var min    = document.getElementById('nev-min').value;
    var max    = document.getElementById('nev-max').value;

    if (!nombre || min === '' || max === '') {
      $("body").overhang({ type: "error", message: "Completa todos los campos." }); return;
    }
    if (parseFloat(min) >= parseFloat(max)) {
      $("body").overhang({ type: "error", message: "La mínima debe ser menor que la máxima." }); return;
    }

    fetch(baseurl + 'neveras/crear', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ nombre: nombre, temp_min: parseFloat(min), temp_max: parseFloat(max) })
    })
    .then(function (r) { return r.json(); })
    .then(function (d) {
      if (d.status === 'success') {
        $("body").overhang({ type: "success", message: "Nevera creada correctamente." });
        setTimeout(function () { location.reload(); }, 1800);
      } else {
        $("body").overhang({ type: "error", message: d.message || 'Error al crear.' });
      }
    });
  });

  /* ── Eliminar nevera ── */
  document.querySelectorAll('.btn-eliminar-nevera').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var id     = this.dataset.id;
      var nombre = this.dataset.nombre;
      $("body").overhang({
        type: "confirm", primary: "#173a10", accent: "#4a8a37",
        yesColor: "#ef4444", yesMessage: "Sí, eliminar", noMessage: "Cancelar",
        message: "¿Eliminar la nevera <strong>" + nombre + "</strong>? Se borrarán todos sus registros.",
        overlay: true,
        callback: function (val) {
          if (!val) return;
          fetch(baseurl + 'neveras/eliminar', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: parseInt(id) })
          })
          .then(function (r) { return r.json(); })
          .then(function (d) {
            if (d.status === 'success') {
              $("body").overhang({ type: "success", message: "Nevera eliminada." });
              setTimeout(function () { location.reload(); }, 1800);
            } else {
              $("body").overhang({ type: "error", message: "Error al eliminar." });
            }
          });
        }
      });
    });
  });

  /* ── Abrir modal registrar ── */
  document.querySelectorAll('.btn-registrar-temp').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var id     = this.dataset.id;
      var nombre = this.dataset.nombre;
      var min    = this.dataset.min;
      var max    = this.dataset.max;

      document.getElementById('mod-nevera-id').value = id;
      document.getElementById('mod-nev-nombre').textContent = nombre;
      document.getElementById('mod-rango').textContent = min + '°C — ' + max + '°C';
      document.getElementById('reg-temp').value = '';
      document.getElementById('reg-obs').value = '';
      document.getElementById('mod-temp-display').textContent = '—';
      document.getElementById('mod-temp-display').style.color = '';
      document.getElementById('reg-preview-wrap').style.display = 'none';
      document.getElementById('reg-preview-img').src = '';
      regImagen = null;

      new bootstrap.Modal(document.getElementById('modalRegistrar')).show();
    });
  });

  /* ── Actualizar display de temperatura en tiempo real ── */
  document.getElementById('reg-temp').addEventListener('input', function () {
    var v = this.value;
    var display = document.getElementById('mod-temp-display');
    display.textContent = v !== '' ? v + '°C' : '—';
  });

  /* ── OCR imagen ── */
  document.getElementById('reg-file-input').addEventListener('change', function () {
    var file = this.files[0];
    if (!file) return;
    var reader = new FileReader();
    reader.onload = function (e) {
      regImagen = e.target.result;
      var preview = document.getElementById('reg-preview-img');
      preview.src = regImagen;
      document.getElementById('reg-preview-wrap').style.display = 'block';
      document.getElementById('reg-drop-zone').style.display = 'none';
      procesarOCR(regImagen);
    };
    reader.readAsDataURL(file);
  });

  function procesarOCR(dataUrl) {
    var progress = document.getElementById('reg-ocr-progress');
    var fill     = document.getElementById('reg-ocr-fill');
    var lbl      = document.getElementById('reg-ocr-lbl');
    progress.style.display = 'block';
    fill.style.width = '10%';
    lbl.textContent = 'Iniciando OCR…';

    Tesseract.recognize(dataUrl, 'eng', {
      logger: function (m) {
        if (m.status === 'recognizing text') {
          var pct = Math.round((m.progress || 0) * 100);
          fill.style.width = pct + '%';
          lbl.textContent = 'Procesando… ' + pct + '%';
        }
      }
    }).then(function (result) {
      fill.style.width = '100%';
      lbl.textContent = 'Completado';
      setTimeout(function () { progress.style.display = 'none'; }, 1200);

      var texto = result.data.text;
      var match = texto.match(/-?\d+[.,]\d+|-?\d+/);
      if (match) {
        var valor = match[0].replace(',', '.');
        document.getElementById('reg-temp').value = valor;
        document.getElementById('mod-temp-display').textContent = valor + '°C';
        $("body").overhang({ type: "success", message: "OCR detectó: " + valor + "°C — revisa y confirma." });
      } else {
        $("body").overhang({ type: "warning", message: "No se detectó un número. Ingresa la temperatura manualmente." });
      }
    }).catch(function () {
      progress.style.display = 'none';
      $("body").overhang({ type: "error", message: "Error en OCR. Ingresa la temperatura manualmente." });
    });
  }

  /* ── Guardar temperatura ── */
  document.getElementById('btn-guardar-temp').addEventListener('click', function () {
    var nevera_id   = document.getElementById('mod-nevera-id').value;
    var temperatura = document.getElementById('reg-temp').value;
    var obs         = document.getElementById('reg-obs').value;

    if (!temperatura) {
      $("body").overhang({ type: "error", message: "Ingresa la temperatura medida." }); return;
    }

    var btn = this;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando…';

    fetch(baseurl + 'temperatura/registrar', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        nevera_id:   parseInt(nevera_id),
        temperatura: parseFloat(temperatura),
        imagen:      regImagen || null,
        observacion: obs,
      })
    })
    .then(function (r) { return r.json(); })
    .then(function (d) {
      if (d.status === 'success') {
        $("body").overhang({ type: "success", message: "Temperatura registrada y enviada por WhatsApp." });
        setTimeout(function () { location.reload(); }, 2000);
      } else {
        $("body").overhang({ type: "error", message: d.message || 'Error al registrar.' });
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-save"></i> Registrar y enviar WhatsApp';
      }
    })
    .catch(function () {
      $("body").overhang({ type: "error", message: "Error de conexión." });
      btn.disabled = false;
      btn.innerHTML = '<i class="fas fa-save"></i> Registrar y enviar WhatsApp';
    });
  });

  /* ── Ver foto ── */
  window.verFoto = function (btn) {
    document.getElementById('foto-modal-img').src = btn.dataset.img;
    new bootstrap.Modal(document.getElementById('modalFoto')).show();
  };

})();
</script>
</body>
</html>

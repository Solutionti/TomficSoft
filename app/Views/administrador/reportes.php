<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion - Reportes</title>
    <link rel="stylesheet" href="<?= base_url('css/estilo.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/material.css') ?>">
    <link rel="stylesheet" href="<?= base_url('fontawesome/css/fontawesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('fontawesome/css/brands.css') ?>">
    <link rel="stylesheet" href="<?= base_url('fontawesome/css/solid.css') ?>">
</head>
<body>
  <div class="container-scroller">
      <?php require_once("componentes/navbar.php")?>
      <div class="container-fluid page-body-wrapper ">
        <?php require_once("componentes/lateralderecha.php")?>
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header flex-wrap">
              <div class="header-left">
                <button class="btn btn-primary mb-2 mb-md-0 me-2 btn-rounded" data-bs-toggle="modal" data-bs-target="#diferenciaconteo">FILTROS DE REPORTE</button>
                <!-- <button class="btn btn-outline-primary bg-white mb-2 mb-md-0">Exportar base de datos</button> -->
              </div>
              <div class="header-right d-flex flex-wrap mt-2 mt-sm-0">
                <div class="d-flex align-items-center">
                  <a href="#">
                    <p class="m-0 pe-3">ADMINISTRACIÒN</p>
                  </a>
                  <a class="ps-3 me-4" href="#">
                    <p class="m-0">INV - USUARIOS</p>
                  </a>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-12 stretch-card grid-margin">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between flex-wrap">
                      <div>
                        <div class="card-title mb-0">Reportes para el modulo de </div>
                          <h3 class="fw-bold mb-0">Inventarios</h3>
                        </div>
                      <div>
                        <div class="d-flex flex-wrap pt-2 justify-content-between sales-header-right">
                          <div class="d-flex me-5">
                            <button type="button" class="btn btn-social-icon btn-outline-sales" id="sinconteopdf" title="Descargar Pdf"><i class="fas fa-file-pdf text-danger"></i></button>
                            <button type="button" class="btn btn-social-icon btn-outline-sales mx-2" id="sinconteoexcel"  title="Descargar Excel"><i class="fas fa-file-excel text-success"></i></button>
                            <div class="ps-2">
                              <h4 class="mb-0 fw-semibold head-count">SC</h4>
                              <span class="font-10 fw-semibold text-muted">SIN CONTEO</span>
                            </div>
                          </div>
                          <div class="d-flex me-3 mt-2 mt-sm-0">
                            <button type="button" class="btn btn-social-icon btn-outline-sales profit" id="descargardiferencia"><i class="fas fa-file-excel text-success"></i></button>
                            <div class="ps-2">
                              <h4 class="mb-0 fw-semibold head-count">DC</h4>
                              <span class="font-10 fw-semibold text-muted">DIFERE CONTEOS</span>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex flex-wrap pt-4 justify-content-between sales-header-right">
                          <div class="d-flex me-5">
                            <button type="button" class="btn btn-social-icon btn-outline-sales"><i class="fas fa-database"></i></button>
                            <div class="ps-2">
                              <h4 class="mb-0 fw-semibold head-count">DI</h4>
                              <span class="font-10 fw-semibold text-muted">DIFE INVENTARIOS</span>
                            </div>
                          </div>
                          <div class="d-flex me-3 mt-2 mt-sm-0">
                            <button type="button" class="btn btn-social-icon btn-outline-sales profit"><i class="fas fa-coins text-info"></i></button>
                            <div class="ps-2">
                              <h4 class="mb-0 fw-semibold head-count">GT</h4>
                              <span class="font-10 fw-semibold text-muted">GANANCIA TOTAL</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- <p class="text-muted font-13 mt-2 mt-sm-0">Plantilla para tu panel de control de ventas. Más información.<a class="text-muted font-13" href="#"><u> Leer mas</u></a></p> -->
                    <!-- <div class="flot-chart-wrapper">
                      <div id="flotChart" class="flot-chart">
                        <canvas class="flot-base" id="miGrafico"  width="850" height="200"></canvas>
                      </div>
                    </div> -->
                  </div>
                </div>
              </div>
              <!--  -->
              <div class="col-xl-12 stretch-card grid-margin">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between flex-wrap">
                      <div>
                        <div class="card-title mb-0">Reportes para el modulo de </div>
                          <h3 class="fw-bold mb-0">Ventas</h3>
                        </div>
                      <div>
                        <div class="d-flex flex-wrap pt-2 justify-content-between sales-header-right">
                          <div class="d-flex me-5">
                            <button type="button" class="btn btn-social-icon btn-outline-sales"><i class="fas fa-database"></i></button>
                            <div class="ps-2">
                              <h4 class="mb-0 fw-semibold head-count">VP</h4>
                              <span class="font-10 fw-semibold text-muted">VENTA DE PEDIDOS</span>
                            </div>
                          </div>
                          <div class="d-flex me-3 mt-2 mt-sm-0">
                            <button type="button" class="btn btn-social-icon btn-outline-sales profit"><i class="fas fa-coins text-info"></i></button>
                            <div class="ps-2">
                              <h4 class="mb-0 fw-semibold head-count">VD</h4>
                              <span class="font-10 fw-semibold text-muted">VENTA DIARIA</span>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex flex-wrap pt-4 justify-content-between sales-header-right">
                          <div class="d-flex me-5">
                            <button type="button" class="btn btn-social-icon btn-outline-sales"><i class="fas fa-database"></i></button>
                            <div class="ps-2">
                              <h4 class="mb-0 fw-semibold head-count">RK</h4>
                              <span class="font-10 fw-semibold text-muted">REPORTE DE KARDEX</span>
                            </div>
                          </div>
                          <div class="d-flex me-3 mt-2 mt-sm-0">
                            <button type="button" class="btn btn-social-icon btn-outline-sales profit"><i class="fas fa-coins text-info"></i></button>
                            <div class="ps-2">
                              <h4 class="mb-0 fw-semibold head-count">RC</h4>
                              <span class="font-10 fw-semibold text-muted">REPORTE ABC</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <p class="text-muted font-13 mt-2 mt-sm-0">En esta seccion podras visualizar las ventas dia a dia de tu negocio.</a></p>
                    <!-- <div class="flot-chart-wrapper">
                      <div id="flotChart" class="flot-chart">
                        <canvas class="flot-base" id="miGrafico"  width="850" height="200"></canvas>
                      </div>
                    </div> -->
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once("componentes/footer.php")?>   <!-- se usa para reutilizar codigo  -->
</div>
<!-- FILTRO DE REPORTES  -->
 <div class="modal fade" id="diferenciaconteo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="diferenciaconteoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header color-morado">
        <h1 class="modal-title fs-5 text-white" id="diferenciaconteoLabel">FILTROS PARA REPORTES</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="fechaInicio" class="form-label">Fecha Inicial</label>
                <input
                  type="date"
                  class="form-control"
                  id="fechaInicio"
                  name="fechaInicio"
                >
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="fechaFin" class="form-label">Fecha Final</label>
                <input
                  type="date"
                  class="form-control"
                  id="fechaFin"
                  name="fechaFin"
                  value="<?= date('Y-m-d'); ?>"
                >
              </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-rounded" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary btn-rounded" data-bs-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<?php require_once("componentes/scripts.php")?>
<script src="<?= base_url('js/reportes.js') ?>"></script>
</body>
</html>
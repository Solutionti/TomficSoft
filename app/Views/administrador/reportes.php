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
                <button class="btn btn-primary mb-2 mb-md-0 me-2 btn-rounded">FILTROS DE REPORTE</button>
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
                            <button type="button" class="btn btn-social-icon btn-outline-sales"><i class="fas fa-database"></i></button>
                            <div class="ps-2">
                              <h4 class="mb-0 fw-semibold head-count">$8,217</h4>
                              <span class="font-10 fw-semibold text-muted">SIN CONTEO</span>
                            </div>
                          </div>
                          <div class="d-flex me-3 mt-2 mt-sm-0">
                            <button type="button" class="btn btn-social-icon btn-outline-sales profit"><i class="fas fa-coins text-info"></i></button>
                            <div class="ps-2">
                              <h4 class="mb-0 fw-semibold head-count">2,804</h4>
                              <span class="font-10 fw-semibold text-muted">DIFERE CONTEOS</span>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex flex-wrap pt-4 justify-content-between sales-header-right">
                          <div class="d-flex me-5">
                            <button type="button" class="btn btn-social-icon btn-outline-sales"><i class="fas fa-database"></i></button>
                            <div class="ps-2">
                              <h4 class="mb-0 fw-semibold head-count">$8,217</h4>
                              <span class="font-10 fw-semibold text-muted">DIFE INVENTARIOS</span>
                            </div>
                          </div>
                          <div class="d-flex me-3 mt-2 mt-sm-0">
                            <button type="button" class="btn btn-social-icon btn-outline-sales profit"><i class="fas fa-coins text-info"></i></button>
                            <div class="ps-2">
                              <h4 class="mb-0 fw-semibold head-count">2,804</h4>
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
                              <h4 class="mb-0 fw-semibold head-count">$8,217</h4>
                              <span class="font-10 fw-semibold text-muted">VENTA DE PEDIDOS</span>
                            </div>
                          </div>
                          <div class="d-flex me-3 mt-2 mt-sm-0">
                            <button type="button" class="btn btn-social-icon btn-outline-sales profit"><i class="fas fa-coins text-info"></i></button>
                            <div class="ps-2">
                              <h4 class="mb-0 fw-semibold head-count">2,804</h4>
                              <span class="font-10 fw-semibold text-muted">VENTA DIARIA</span>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex flex-wrap pt-4 justify-content-between sales-header-right">
                          <div class="d-flex me-5">
                            <button type="button" class="btn btn-social-icon btn-outline-sales"><i class="fas fa-database"></i></button>
                            <div class="ps-2">
                              <h4 class="mb-0 fw-semibold head-count">$8,217</h4>
                              <span class="font-10 fw-semibold text-muted">REPORTE DE KARDEX</span>
                            </div>
                          </div>
                          <div class="d-flex me-3 mt-2 mt-sm-0">
                            <button type="button" class="btn btn-social-icon btn-outline-sales profit"><i class="fas fa-coins text-info"></i></button>
                            <div class="ps-2">
                              <h4 class="mb-0 fw-semibold head-count">2,804</h4>
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
</body>
</html>
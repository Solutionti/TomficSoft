<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion - Inicio</title>
    <link rel="stylesheet" href="<?= base_url('css/estilo.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/material.css') ?>">
    <link rel="stylesheet" href="<?= base_url('fontawesome/css/fontawesome.min.css') ?>">
    <!-- <link rel="stylesheet" href="<?= base_url('fontawesome/css/fontawesome.css') ?>"> -->
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
                <button class="btn btn-primary mb-2 mb-md-0 me-2 btn-rounded">Crear nuevo Documento</button>
                <button class="btn btn-outline-primary bg-white mb-2 mb-md-0 btn-rounded">Importar documentos</button>
              </div>
              <div class="header-right d-flex flex-wrap mt-2 mt-sm-0">
                <div class="d-flex align-items-center">
                  <a href="#">
                    <p class="m-0 pe-3">ADMINISTRACIÒN</p>
                  </a>
                  <a class="ps-3 me-4" href="#">
                    <p class="m-0">INV - INICIO</p>
                    
                  </a>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-9 stretch-card grid-margin">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between flex-wrap">
                      <div>
                        <div class="card-title mb-0">Ingresos por ventas</div>
                        <h3 class="fw-bold mb-0">$32,409</h3>
                      </div>
                      <div>
                        <div class="d-flex flex-wrap pt-2 justify-content-between sales-header-right">
                          <div class="d-flex me-5">
                            <button type="button" class="btn btn-social-icon btn-outline-sales"><i class="fas fa-database"></i></button>
                            <div class="ps-2">
                              <h4 class="mb-0 fw-semibold head-count">$8,217</h4>
                              <span class="font-10 fw-semibold text-muted">VENTAS TOTALES</span>
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
                    <p class="text-muted font-13 mt-2 mt-sm-0">Plantilla para tu panel de control de ventas. Más información.<a class="text-muted font-13" href="#"><u> Leer mas</u></a></p>
                    <div class="flot-chart-wrapper">
                      <div id="flotChart" class="flot-chart">
                        <canvas class="flot-base"></canvas>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 stretch-card grid-margin ">
                <div class="card card-img color-morado ">
                  <div class="card-body d-flex align-items-center">
                    <div class="text-white">
                      <h1 class="font-20 fw-semibold mb-0">Consigue una cuenta</h1>
                      <h1 class="font-20 fw-semibold"> premium!</h1>
                      <p>Para optimizar la venta de su producto</p>
                      <p class="font-10 fw-semibold">Disfrute de la ventaja de ser premium.</p>
                      <button class="btn bg-white text-dark font-12">Obtener plan</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6 col-xl-4 stretch-card grid-margin">
                <div class="card">
                  <div class="card-body">
                    <div class="card-title mb-2"> Upcoming events (3) </div>
                    <h3 class="mb-3">23 september 2019</h3>
                    <div class="d-flex border-bottom border-top py-3">
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" checked></label>
                      </div>
                      <div class="ps-2">
                        <span class="font-12 text-muted">Tue, Mar 5, 9.30am</span>
                        <p class="m-0 text-black">Hey I attached some new PSD files…</p>
                      </div>
                    </div>
                    <div class="d-flex border-bottom py-3">
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input"></label>
                      </div>
                      <div class="ps-2">
                        <span class="font-12 text-muted">Mon, Mar 11, 4.30 PM</span>
                        <p class="m-0 text-black">Discuss performance with manager</p>
                      </div>
                    </div>
                    <div class="d-flex border-bottom py-3">
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input"></label>
                      </div>
                      <div class="ps-2">
                        <span class="font-12 text-muted">Tue, Mar 5, 9.30am</span>
                        <p class="m-0 text-black">Meeting with Alisa </p>
                      </div>
                    </div>
                    <div class="d-flex pt-3">
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input"></label>
                      </div>
                      <div class="ps-2">
                        <span class="font-12 text-muted">Mon, Mar 11, 4.30 PM</span>
                        <p class="m-0 text-black">Hey I attached some new PSD files…</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-xl-4 stretch-card grid-margin">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex border-bottom mb-4 pb-2">
                      <div class="hexagon">
                        <div class="hex-mid hexagon-success">
                          <i class="mdi mdi-clock-outline"></i>
                        </div>
                      </div>
                      <div class="ps-4">
                        <h4 class="fw-bold text-success mb-0">12.45</h4>
                        <h6 class="text-muted">Bueno</h6>
                      </div>
                    </div>
                    <div class="d-flex border-bottom mb-4 pb-2">
                      <div class="hexagon">
                        <div class="hex-mid hexagon-danger">
                          <i class="mdi mdi-account-outline"></i>
                        </div>
                      </div>
                      <div class="ps-4">
                        <h4 class="fw-bold text-danger mb-0">34.568</h4>
                        <h6 class="text-muted">Averiado</h6>
                      </div>
                    </div>
                    <div class="d-flex border-bottom mb-4 pb-2">
                      <div class="hexagon">
                        <div class="hex-mid hexagon-primary">
                          <i class="mdi mdi-laptop"></i>
                        </div>
                      </div>
                      <div class="ps-4">
                        <h4 class="fw-bold text-primary mb-0">33.50%</h4>
                        <h6 class="text-muted">Vencido</h6>
                      </div>
                    </div>
                    
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-xl-4 stretch-card grid-margin">
                <div class="card color-card-wrapper">
                  <div class="card-body">
                    <img class="img-fluid card-top-img w-100" src="https://themewagon.github.io/plus-admin/assets/images/dashboard/img_5.jpg" alt="">
                    <div class="d-flex flex-wrap justify-content-around color-card-outer">
                      <div class="col-6 p-0 mb-4">
                        <div class="color-card primary m-auto">
                          <i class="mdi mdi-clock-outline"></i>
                          <p class="fw-semibold mb-0">Productos</p>
                          <span class="small">15 Packages</span>
                        </div>
                      </div>
                      <div class="col-6 p-0 mb-4">
                        <div class="color-card bg-success  m-auto">
                          <i class="mdi mdi-tshirt-crew"></i>
                          <p class="fw-semibold mb-0">Inventarios</p>
                          <span class="small">72 Items</span>
                        </div>
                      </div>
                      <div class="col-6 p-0">
                        <div class="color-card bg-info m-auto">
                          <i class="mdi mdi-trophy-outline"></i>
                          <p class="fw-semibold mb-0">Perdidas</p>
                          <span class="small">34 Upgraded</span>
                        </div>
                      </div>
                      <div class="col-6 p-0">
                        <div class="color-card bg-danger m-auto">
                          <i class="mdi mdi-presentation"></i>
                          <p class="fw-semibold mb-0">Reportado</p>
                          <span class="small">72 Support</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </div>
        </div>
    </div>
    <footer class="footer">
      <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2023 <a href="https://www.bootstrapdash.com/" target="_blank">BootstrapDash</a>. All rights reserved. Distributed by <a href="https://themewagon.com" target="_blank">ThemeWagon</a></span>
        <span class="float-none float-sm-end d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
      </div>
    </footer>
    </div>
  </body>
</html>
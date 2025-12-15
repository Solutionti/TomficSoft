<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion - Usuarios</title>
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
                <!-- <button class="btn btn-primary mb-2 mb-md-0 me-2">Terminar el conteo</button>
                <button class="btn btn-outline-primary bg-white mb-2 mb-md-0">Exportar base de datos</button> -->
              </div>
              <div class="header-right d-flex flex-wrap mt-2 mt-sm-0">
                <div class="d-flex align-items-center">
                  <a href="#">
                    <p class="m-0 pe-3">ADMINISTRACIÒN</p>
                  </a>
                  <a class="ps-3 me-4" href="#">
                    <p class="m-0">TOMFIC - PEDIDOS</p>
                  </a>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-9">
              <table class="table table-striped table-borderless" id="tabla_inventarios">
                        <thead >
                          <tr >
                            <th class="color-morado text-white text-uppercase">
                                
                            </th>
                            <th class="color-morado text-white text-uppercase"> CONSECUTIVO</th>
                            <th class="color-morado text-white text-uppercase"> TIPO PAGO</th>
                            <th class="color-morado text-white text-uppercase"> TOTAL </th>
                            <th class="color-morado text-white text-uppercase"> C*C </th>
                            <th class="color-morado text-white text-uppercase"> HORA </th>
                            <th class="color-morado text-white text-uppercase"> FECHA </th>
                            <th class="color-morado text-white text-uppercase"> ESTADO </th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                              <td width="100">
                                <button
                                  class="badge badge-dark "
                                >
                                  <i class="fas fa-file-pdf fa-1x "></i>
                                </button>
                                <button
                                  class="badge badge-primary "
                                >
                                  <i class="fas fa-eye fa-1x "></i>
                                </button>
                                <button
                                  class="badge badge-success "
                                >
                                  <i class="fab fa-whatsapp fa-1x "></i>
                                </button>
                                </td>
                                <td>12345</td>
                                <td><label class="badge badge-success">CONTRAENTREGA</label></td>
                                <td>90.000</td>
                                <td>NO</td>
                                <td>12:30</td>
                                <td>26-12-2025</td>
                                <td><label class="badge badge-primary">PEDIDO</label></td>
                            </tr>
                        </tbody>
                      </table>
              </div>
              <div class="col-md-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex border-bottom mb-4 pb-2">
                      <div class="hexagon">
                    <div class="d-flex border-bottom mb-4 pb-2">
                      <div class="hexagon">
                        <div class="hex-mid hexagon-danger ">
                          <i class="fas fa-times"></i>
                        </div>
                      </div>
                      <div class="ps-4">
                        <h4 class="fw-bold text-danger mb-0">#5452 - 90.000</h4>
                        <h6 class="text-muted">Cancelado</h6>
                      </div>
                    </div>
                    <div class="d-flex border-bottom mb-4 pb-2">
                      <div class="hexagon">
                        <div class="hex-mid hexagon-primary hexagon-xs fa-1x">
                          <i class="fas fa-clock"></i>
                        </div>
                      </div>
                      <div class="ps-4">
                        <h4 class="fw-bold text-primary mb-0">#5452 - 90.000</h4>
                        <h6 class="text-muted">Pedido</h6>
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
    <!-- <footer class="footer">
      <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2023 <a href="https://www.bootstrapdash.com/" target="_blank">BootstrapDash</a>. All rights reserved. Distributed by <a href="https://themewagon.com" target="_blank">ThemeWagon</a></span>
        <span class="float-none float-sm-end d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
      </div>
    </footer> -->
</div>
</body>
</html>
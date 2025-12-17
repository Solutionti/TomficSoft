<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion - Ventas</title>
    <link rel="stylesheet" href="<?= base_url('css/estilo.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/material.css') ?>">
    <link rel="stylesheet" href="<?= base_url('fontawesome/css/fontawesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('fontawesome/css/brands.css') ?>">
    <link rel="stylesheet" href="<?= base_url('fontawesome/css/solid.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/argon-dashboard.css?v=2.0.2') ?>">
    <link rel="stylesheet" href="<?= base_url('css/overhang.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/datatable.css') ?>">
</head>
<body>
  <div class="container-fluid">
      <div class="container-fluid">
        <div class="">
          <div class="content-wrapper">
            <div class="page-header flex-wrap">
              <div class="header-left">
                <!--  -->
               <!-- <h4 class="text-danger">SUPER MERCADO MERCACENTRO</h4> -->
              </div>
              <div class="header-right d-flex flex-wrap  mt-sm-0">
                <div class="d-flex align-items-center">
                  <a href="#">
                    <p class="m-0 pe-3">ADMINISTRACIÒN</p>
                  </a>
                  <a class="ps-3 me-4" href="#">
                    <p class="m-0">TOMFIC - VENTAS</p>
                  </a>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="card card-pricing">
                    <div
                      class="card-header color-morado text-center pt-4 pb-5 position-relative"
                    >
                      <div class="z-index-1 position-relative">
                        <h6 class="text-white">TOTAL DE  VENTA </h6> 
                        <h3 class="text-white mt-2 mb-0" id="ventaa">
                        <small id="compracero">$0 </small>
                        <small class="total-compra" id="total-compra" hidden></small>
                        </h3>
                        <h6 class="text-white">A DEVOLVER</h6>
                        <div id="volver">
                          <h3 class="text-white" id="devolver">
                           <small>$0</small> 
                          </h3>
                        </div>
                      </div>
                    </div>
                  <div class="position-relative mt-n5" style="height: 50px;">
                  <div class="position-absolute w-100">
                    <svg class="waves waves-sm" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 40" preserveAspectRatio="none" shape-rendering="auto">
                  <defs>
                    <path id="card-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
                  </defs>
                  <g class="moving-waves">
                    <use xlink:href="#card-wave" x="48" y="-1" fill="rgba(255,255,255,0.30"></use>
                    <use xlink:href="#card-wave" x="48" y="3" fill="rgba(255,255,255,0.35)"></use>
                    <use xlink:href="#card-wave" x="48" y="5" fill="rgba(255,255,255,0.25)"></use>
                    <use xlink:href="#card-wave" x="48" y="8" fill="rgba(255,255,255,0.20)"></use>
                    <use xlink:href="#card-wave" x="48" y="13" fill="rgba(255,255,255,0.15)"></use>
                    <use xlink:href="#card-wave" x="48" y="16" fill="rgba(255,255,255,0.99)"></use>
                  </g>
                </svg>
              </div>
            </div>
            <div class="card-body">
              <!-- <div class="row">
                <div class="col-md-6">
                 
                </div>
                <div class="col-md-6">
                  
                </div>
              </div> -->
            </div>
          </div>
        </div>
        <div class="col-md-7">
          <div class="row">
                    <div class="col-md-6" hidden>
                      <label>Total</label>
                      <input
                        type="text"
                        class="form-control form-control-sm"
                        id="total"
                        readonly
                      >
                    </div>
                  </div>
          <div class="row">
            <div class="col-md-7">
              <label>Codigo del Producto</label>
              <div class="input-group">
                <input
                  type="text"
                  class="js-toggle-password form-control form-control-sm"
                  id="codigo_barras"
                >
                <a
                  class="input-group-append input-group-text"
                  data-bs-toggle="modal"
                  data-bs-target="#listaproductos"
                >
                  <i id="changePassIcon" class="fas fa-store text-morado"></i>
                </a>
              </div>
            </div>
            <!--  -->
            <div class="col-md-2">
              <label>%</label>
              <input
                type="text"
                class="form-control form-control-sm"
              >
            </div>
            <!--  -->
            <div class="col-md-3">
              <label>Recibo de efectivo</label>
              <input
                type="text"
                class="form-control form-control-sm"
                id="recibio"
                oninput="formatearMiles(this)"
              >
            </div>
          </div>
          <!--  -->
          <div class="row mt-3">
           <div class="col-md-6">
              <label>Nombre producto</label>
              <input
                type="text"
                class="form-control form-control-sm"
                id="producto"
              >
            </div>
            <div class="col-md-3">
              <label>Precio</label>
              <input
                type="text"
                class="form-control form-control-sm"
                id="precio"
              >
            </div>
            <div class="col-md-3">
              <label>Cantidad</label>
              <input
                type="text"
                class="form-control form-control-sm"
                id="cantidad"
              >
            </div>
          </div>
          <!--  -->
          <div class="row mt-2">
            <div class="col-md-6">
              <label>Usuario vendedor</label>
              <input
                type="text"
                class="form-control form-control-sm"
                value="<?=  session()->get('nombre').' '.session()->get('apellido') ?>"
              >
            </div>
            <div class="col-md-4">
              <label>Dia</label>
              <select
                class="form-control form-control-lg disabled"
                id="dia"
                readonly
              >
                <?php if(strftime('%A') == 'Monday') { ?>
                  <option value="1" selected>LUNES </option>
                <?php } ?>
                <?php if(strftime('%A') == 'Tuesday') { ?>
                  <option value="2" selected>MARTES </option>
                <?php } ?>
                <?php if(strftime('%A') == 'Wednesday') { ?>
                  <option value="3" selected>MIERCOLES </option>
                <?php } ?>
                <?php if(strftime('%A') == 'Thursday') { ?>
                  <option value="4" selected>JUEVES </option>
                <?php } ?>
                <?php if(strftime('%A') == 'Friday') { ?>
                  <option value="5" selected>VIERNES </option>
                <?php } ?>
                <?php if(strftime('%A') == 'Saturday') { ?>
                  <option value="6" selected>SABADO </option>
                <?php } ?>
                <?php if(strftime('%A') == 'Sunday') { ?>
                  <option value="7" selected>DOMINGO </option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-2">
              <label>Numero de caja</label>
              <input
                type="text"
                class="form-control form-control-sm"
              >
            </div>
          </div>
          <!--  -->
          <!--  -->
        </div>
        <div class="col-md-2 mt-2">
          <div class="form-group">
            <label>N° de venta</label>
            <input
              type="text"
              class="form-control form-control-sm"
              value="VNT001916"
              id="consecutivo"
              readonly
            >
          </div>
          <!--  -->
          <div class="form-group">
            <label>Fecha</label>
            <input
              type="text"
              class="form-control form-control-sm"
              value="<?= strftime('%d/%m/%Y'); ?>"
              readonly
            >
          </div>
          <!--  -->
          <div class="form-group">
            <label>Usuario</label>
            <input
              type="text"
              class="form-control form-control-sm"
              value="<?=  session()->get('nombre').' '.session()->get('apellido') ?>"
              readonly
            >
          </div>
          <!--  -->
          <div class="form-group">
            <div class="form-check">
             <input
               class="form-check-input"
               type="checkbox"
               name="checkrecibocaja"
               id="checkrecibocaja"
               checked
             >
             <label class="custom-control-label mt-2" for="customCheck1" >Imprimir recibo?</label>
           </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <table class="table table-striped table-hover">
            <thead>
                <th class="color-morado text-white text-uppercase"></th>
                <th class="color-morado text-white text-uppercase">CODIGO</th>
                <th class="color-morado text-white text-uppercase">NOMBRE PRODUCTO</th>
                <th class="color-morado text-white text-uppercase">CANTIDAD</th>
                <th class="color-morado text-white text-uppercase">PRECIO</th>
                <th class="color-morado text-white text-uppercase">ACCIONES</th>
            </thead>
            <tbody class="tbody">
             
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<br>
<br>
  <?php require_once("componentes/footer.php")?>
</div>
</div>
<?php require_once("componentes/scripts.php")?>
<script src="<?= base_url('js/ventas.js') ?>"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion - Inicio</title>
    <link rel="stylesheet" href="<?= base_url('css/estilo.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/material.css') ?>">
    <link rel="stylesheet" href="<?= base_url('fontawesome/css/fontawesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('fontawesome/css/brands.css') ?>">
    <link rel="stylesheet" href="<?= base_url('fontawesome/css/solid.css') ?>">
</head>
<body>
    <div class="container-scroller">
      <!-- partial:../../partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile border-bottom">
            <a href="#" class="nav-link flex-column">
              <div class="nav-profile-image">
                <img src="https://themewagon.github.io/plus-admin/assets/images/faces/face1.jpg" alt="profile">
                <!--change to offline or busy as needed-->
              </div>
              <div class="nav-profile-text d-flex ms-0 mb-3 flex-column">
                <span class="fw-semibold mb-1 mt-2 text-center">Edwin Carbonel</span>
                <span class="text-secondary icon-sm text-center">Experto en inventarios</span>
              </div>
            </a>
          </li>
          <li class="nav-item pt-3">
            <a class="nav-link d-block" href="../../index.html">
              <img class="sidebar-brand-logo" src="https://themewagon.github.io/plus-admin/assets/images/logo.svg" alt="">
              <img class="sidebar-brand-logomini" src="../../assets/images/logo-mini.svg" alt="">
              <div class="small fw-light pt-1">Panel responsivo </div>
            </a>
            <br>
            <form class="d-flex align-items-center" action="#">
              <div class="input-group">
                <div class="input-group-prepend">
                  <i class="input-group-text border-0 mdi mdi-magnify"></i>
                </div>
                <input type="text" class="form-control border-0" placeholder="Buscar">
              </div>
            </form>
          </li>
          <li class="pt-2 pb-1">
            <span class="nav-item-head">Modulos</span>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../index.html">
              <i class="mdi mdi-compass-outline menu-icon"></i>
              <span class="menu-title">Inicio</span>
            </a>
          </li>
          <li class="pt-2 pb-1">
            <span class="nav-item-head">Funcionales</span>
          </li>
          <li class="nav-item pt-1">
            <a class="nav-link" href="../../docs/documentation.html" target="_blank">
              <i class="mdi mdi-file-document-box menu-icon"></i>
              <span class="menu-title">Conteos</span>
            </a>
          </li>
        </ul>
      </nav>
      <div class="container-fluid page-body-wrapper ">
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
          <div class="navbar-menu-wrapper d-flex align-items-stretch color-morado">
            <button class="navbar-toggler navbar-toggler align-self-center color-morado" type="button" data-toggle="minimize">
              <span class="fas fa-chevron-left"></span>
            </button>
            <div class="text-center  d-flex align-items-center justify-content-center">
              <a class="navbar-brand brand-logo-mini" ><img src="https://static.vecteezy.com/system/resources/thumbnails/012/986/755/small_2x/abstract-circle-logo-icon-free-png.png" width="70px" alt="logo" /></a>
            </div>
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item nav-logout d-none d-md-block me-3">
                <a class="nav-link" href="#">Perfil</a>
              </li>
              <li class="nav-item nav-logout d-none d-md-block">
                <button class="btn btn-sm btn-danger">Cerrar Sesiòn</button>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-menu"></span>
            </button>
          </div>
        </nav>
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header flex-wrap">
              <div class="header-left">
                <button class="btn btn-primary mb-2 mb-md-0 me-2">Terminar el conteo</button>
                <button class="btn btn-outline-primary bg-white mb-2 mb-md-0">Exportar base de datos</button>
              </div>
              <div class="header-right d-flex flex-wrap mt-2 mt-sm-0">
                <div class="d-flex align-items-center">
                  <a href="#">
                    <p class="m-0 pe-3">ADMINISTRACIÒN</p>
                  </a>
                  <a class="ps-3 me-4" href="#">
                    <p class="m-0">INV - CONTEOS</p>
                  </a>
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-3">
                    <label class="mb-1">Usuario</label>
                    <input
                      type="text"
                      class="form-control form-control-sm borde"
                      readonly
                    >
                  </div>
                  <div class="col-md-3">
                    <label class="mb-1">Fecha</label>
                    <input
                      type="date"
                      class="form-control form-control-sm borde"
                      readonly
                    >
                  </div>
                  <div class="col-md-6">
                    <label class="mb-1">Observaciòn</label>
                    <textarea rows="1" class="form-control form-control-sm borde"></textarea>
                  </div>
                </div>
                <!--  -->
                <div class="row mt-3">
                  <div class="col-md-3">
                    <label class="mb-1">Ubicaciòn</label>
                    <input
                      type="number"
                      class="form-control form-control-sm borde"
                    >
                  </div>
                   <div class="col-md-3">
                    <label class="mb-1">Localizacion</label>
                    <input
                      type="number"
                      class="form-control form-control-sm borde"
                    >
                  </div>
                   <div class="col-md-3">
                    <label class="mb-1">Nº Localizacion</label>
                    <input
                      type="number"
                      class="form-control form-control-sm borde"
                    >
                  </div>
                  <div class="col-md-3">
                    <label class="mb-1">Conteo</label>
                    <input
                      type="number"
                      class="form-control form-control-sm borde"
                      readonly
                    >
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-7">
                    <label class="mb-1 text-danger">Codigo Producto (*)</label>
                    <input
                      type="text"
                      class="form-control form-control-sm borde"
                      autofocus
                    >
                    <br>
                    <div class="row">
                      <div class="col-md-8">
                        <label class="mb-1">Nombre Producto</label>
                        <input
                          type="text"
                          class="form-control form-control-sm borde"
                          readonly
                        >
                      </div>
                      <div class="col-md-4">
                        <label class="mb-1">Referencia</label>
                        <input
                          type="text"
                          class="form-control form-control-sm borde"
                          readonly
                        >
                      </div>
                    </div>
                    <br>
                     <label class="mb-1">Proveedor</label>
                     <input
                       type="text"
                       class="form-control form-control-sm borde"
                       readonly
                     >
                  </div>
                  <div class="col-md-5">
                    <label class="mb-1">Linea</label>
                     <input
                       type="text"
                       class="form-control form-control-sm borde"
                       readonly
                     >
                     <br>
                     <label class="mb-1">Sublinea</label>
                     <input
                       type="text"
                       class="form-control form-control-sm borde"
                       readonly
                     >
                     <br>
                     <label class="mb-1">Subgrupo</label>
                     <input
                       type="text"
                       class="form-control form-control-sm borde"
                       readonly
                     >
                  </div>
                </div>
                <!--  -->
                <div class="row mt-3">
                  <div class="col-md-3">
                    <label class="mb-1">Unidades</label>
                    <input
                      type="number"
                      class="form-control form-control-sm borde"
                    >
                    <br>
                    <label class="mb-1">Embalaje</label>
                    <input
                      type="number"
                      class="form-control form-control-sm borde"
                    >
                    <br>
                    <label class="mb-1">Cajas</label>
                    <input
                      type="number"
                      class="form-control form-control-sm borde"
                    >
                    <br>
                    <label class="mb-1">Total</label>
                    <input
                      type="number"
                      class="form-control form-control-sm borde"
                    >
                  </div>
                  <!--  -->
                  <div class="col-md-9">
                    <label class="mb-1">Estado del producto</label>
                    <select
                      class="form-control form-control-sm borde"
                    >
                      <option value="">Seleccione el estado del producto</option>
                      <option value="">Bueno</option>
                      <option value="">Averiado</option>
                      <option value="">Vencido</option>
                    </select>
                    <br>
                    <div class="row">
                      <div class="col-md-12">
                        <button class="btn btn-primary mb-2 mb-md-0 me-3 mt-4">Guardar</button>
                        <button class="btn btn-success mb-2 mb-md-0 me-3 mt-4">Modificar</button>
                        <button class="btn btn-danger mb-2 mb-md-0 me-3 mt-4">Salir</button>
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion - Inicio</title>
    <?php require_once("componentes/head.php")?>
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
                <button class="btn btn-primary mb-2 mb-md-0 me-2 btn-rounded">Terminar el conteo</button>
                <button class="btn btn-outline-primary bg-white mb-2 mb-md-0 btn-rounded">Exportar base de datos</button>
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
                    <label class="mb-1 small">Usuario</label>
                    <input
                      type="text"
                      class="form-control form-control-sm borde text-uppercase"
                      id="usuario"
                      readonly
                      value="<?php echo session()->get('nombre'). ' ' .session()->get('apellido')?>"
                    >
                  </div>
                  <div class="col-md-3">
                    <label class="mb-1 small">Fecha</label>
                    <input
                      type="date"
                      class="form-control form-control-sm borde text-uppercase"
                      id="fecha"
                      value="<?php echo date('Y-m-d') ?>"
                      readonly
                    >
                  </div>
                  <div class="col-md-6">
                    <label class="mb-1 small">Observaciòn</label>
                    <textarea rows="1" class="form-control form-control-sm borde text-uppercase" id="observacion"></textarea>
                  </div>
                </div>
                <!--  -->
                <div class="row mt-3">
                  <div class="col-md-3">
                    <label class="mb-1 small">Ubicaciòn</label>
                    <input
                      type="number"
                      class="form-control form-control-sm borde text-uppercase"
                      id="ubicacion"
                    >
                  </div>
                   <div class="col-md-3">
                    <label class="mb-1 small">Localizacion</label>
                    <input
                      type="number"
                      class="form-control form-control-sm borde text-uppercase"
                      id="localizacion"
                    >
                  </div>
                   <div class="col-md-3">
                    <label class="mb-1 small">Nº Localizacion</label>
                    <input
                      type="number"
                      class="form-control form-control-sm borde text-uppercase"
                      id="numero_localizacion"
                    >
                  </div>
                  <div class="col-md-3">
                    <label class="mb-1 small">Conteo</label>
                    <input
                      type="number"
                      class="form-control form-control-sm borde text-uppercase"
                      id="conteo"
                      value="1"
                      readonly
                    >
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-7">
                    <label class="mb-1 small text-danger">Codigo Producto (*)</label>
                    <input
                      type="text"
                      class="form-control form-control-sm borde text-uppercase"
                      id="codigo_producto"
                      autofocus
                    >
                    <br>
                    <div class="row">
                      <div class="col-md-8">
                        <label class="mb-1 small">Nombre Producto</label>
                        <input
                          type="text"
                          class="form-control form-control-sm borde text-uppercase"
                          id="nombre_producto"
                          readonly
                        >
                      </div>
                      <div class="col-md-4">
                        <label class="mb-1 small">Referencia</label>
                        <input
                          type="text"
                          class="form-control form-control-sm borde text-uppercase"
                          id="referencia"
                          readonly
                        >
                      </div>
                    </div>
                    <br>
                     <label class="mb-1 small">Proveedor</label>
                     <input
                       type="text"
                       class="form-control form-control-sm borde text-uppercase"
                       id="proveedor"
                       readonly
                     >
                  </div>
                  <div class="col-md-5">
                    <label class="mb-1 small">Linea</label>
                     <input
                       type="text"
                       class="form-control form-control-sm borde text-uppercase"
                       id="linea"
                       readonly
                     >
                     <br>
                     <label class="mb-1 small">Sublinea</label>
                     <input
                       type="text"
                       class="form-control form-control-sm borde text-uppercase"
                       id="sublinea"
                       readonly
                     >
                     <br>
                     <label class="mb-1 small">Subgrupo</label>
                     <input
                       type="text"
                       class="form-control form-control-sm borde text-uppercase"
                       id="subgrupo"
                       readonly
                     >
                  </div>
                </div>
                <!--  -->
                <div class="row mt-3">
                  <div class="col-md-3">
                    <label class="mb-1 small">Unidades</label>
                    <input
                      type="number"
                      class="form-control form-control-sm borde text-uppercase"
                      id="unidades"
                    >
                    <br>
                    <label class="mb-1 small">Embalaje</label>
                    <input
                      type="number"
                      class="form-control form-control-sm borde text-uppercase"
                      id="embalaje"
                    >
                    
                  </div>
                  <!--  -->
                  <div class="col-md-3">
                    <label class="mb-1 small ">Cajas</label>
                    <input
                      type="number"
                      class="form-control form-control-sm borde text-uppercase"
                      id="cajas"
                    >
                    <br>
                    <label class="mb-1 small"><strong>TOTAL</strong> </label>
                    <input
                      type="number"
                      class="form-control form-control-sm borde text-uppercase"
                      id="total"
                      readonly
                    >
                  </div>
                  <!--  -->
                  <div class="col-md-6">
                    <label class="mb-1 small ">Estado del producto</label>
                    <select
                      class="form-control form-control-sm borde text-uppercase"
                      id="estado_producto"
                    >
                      <option value="">Seleccione el estado del producto</option>
                      <option value="">Bueno</option>
                      <option value="">Averiado</option>
                      <option value="">Vencido</option>
                    </select>
                    <br>
                    <div class="row">
                      <div class="col-md-8">
                        <button class="btn btn-primary mb-2 mb-md-0 me-3 mt-4 btn-rounded">Guardar</button>
                        <button class="btn btn-success mb-2 mb-md-0 me-3 mt-4 btn-rounded">Modificar</button>
                        <button class="btn btn-danger mb-2 mb-md-0 me-3 mt-4 btn-rounded">Salir</button>
                      </div>
                      <div class="col-md-4">
                        <label class="mb-1 small"><strong>Diferencia</strong> </label>
                        <input
                          type="number"
                          class="form-control form-control-sm borde text-uppercase"
                          id="diferencia"
                          readonly
                        >
                      </div>
                    </div>
                    <br>
                    <br>
                  </div>
                </div>
            </div>
        </div>
    </div>
          </div>
        </div>
    </div>
    <?php require_once("componentes/footer.php")?>
</div>
  <?php require_once("componentes/scripts.php")?>
  <script src="<?= base_url('js/conteos.js') ?>"></script>
  </body>
</html>
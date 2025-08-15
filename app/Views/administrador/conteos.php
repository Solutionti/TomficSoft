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
                <button
                  class="btn btn-primary mb-2 mb-md-0 me-2 btn-rounded"
                  onclick="finalizarConteo()"
                >
                Terminar el conteo
                </button>
                <button
                  class="btn btn-outline-primary bg-white mb-2 mb-md-0 btn-rounded"
                  data-bs-toggle="modal"
                  data-bs-target="#exportarexcelmodal"
                >
                  Exportar base de datos
                </button>
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
                    <label class="mb-1 small">Observaciòn *</label>
                    <textarea rows="1" class="form-control form-control-sm borde text-uppercase" id="observacion"></textarea>
                  </div>
                </div>
                <!--  -->
                <div class="row mt-3">
                  <div class="col-md-7">
                    <label class="mb-1 small text-danger">Codigo Producto *</label>
                    <div class="input-group">
                      <input
                        type="text"
                        class="js-toggle-password form-control form-control-sm borde text-uppercase"
                        id="codigo_producto"
                        autofocus
                      >
                      <a
                        class="input-group-append input-group-text"
                        data-bs-toggle="modal"
                        data-bs-target="#listaproductos"
                      >
                        <i id="changePassIcon" class="fas fa-store text-morado"></i>
                      </a>
                    </div>
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
                    <label class="mb-1 small">Ubicaciòn *</label>
                    <input
                      type="text"
                      class="form-control form-control-sm borde text-uppercase"
                      id="ubicacion"
                    >
                  </div>
                   <div class="col-md-3">
                    <label class="mb-1 small">Localizacion *</label>
                    <input
                      type="text"
                      class="form-control form-control-sm borde text-uppercase"
                      id="localizacion"
                    >
                  </div>
                   <div class="col-md-3">
                    <label class="mb-1 small">Nº Localizacion *</label>
                    <input
                      type="text"
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
                <!--  -->
                <div class="row mt-3">
                  <div class="col-md-3">
                    <label class="mb-1 small">Unidades *</label>
                    <input
                      type="number"
                      class="form-control form-control-sm borde text-uppercase"
                      id="unidades"
                    >
                    <br>
                    <label class="mb-1 small">Embalaje *</label>
                    <input
                      type="number"
                      class="form-control form-control-sm borde text-uppercase"
                      id="embalaje"
                    >
                    
                  </div>
                  <!--  -->
                  <div class="col-md-3">
                    <label class="mb-1 small ">Cajas *</label>
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
                    <label class="mb-1 small ">Estado del producto *</label>
                    <select
                      class="form-control form-control-sm borde text-uppercase"
                      id="estado_producto"
                    >
                      <option value="">Seleccione el estado del producto</option>
                      <option value="Bueno">Bueno</option>
                      <option value="Averiado">Averiado</option>
                      <option value="Vencido">Vencido</option>
                    </select>
                    <br>
                    <div class="row">
                      <div class="col-md-8">
                        <button class="btn btn-primary mb-2 mb-md-0 me-3 mt-4 btn-rounded" onclick="GuardarConteo()">Guardar</button>
                        <button class="btn btn-success mb-2 mb-md-0 me-3 mt-4 btn-rounded" onclick="modificarConteo()">Modificar</button>
                        <button class="btn btn-danger mb-2 mb-md-0 me-3 mt-4 btn-rounded" onclick="limpiar()">Limpiar</button>
                      </div>
                      <div class="col-md-2">
                        <label class="mb-1 small"><strong>Saldo</strong> </label>
                        <input
                          type="number"
                          class="form-control form-control-sm borde text-uppercase"
                          id="saldo"
                          readonly
                        >
                      </div>
                      <div class="col-md-2">
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

<!-- EXPORTAR EXCEL -->
<div class="modal fade" id="exportarexcelmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exportarexcelmodalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ">
      <div class="modal-header color-morado">
        <h1 class="modal-title fs-5 text-white" id="exportarexcelmodalLabel">EXPORTAR BASE DE DATOS</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <label class="mb-3 small">Seleccione un archivo a cargar *</label>
            <form id="formExcel" enctype="multipart/form-data">
              <input
                type="file"
                class="form-control form-control-sm"
                accept=".xls,.xlsx"
                name="archivo"
                id="archivo"
              >
            </form>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-rounded" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary btn-rounded" id="exportardatos">Exportar</button>
      </div>
    </div>
  </div>
</div>

<!-- LISTADO DE PRODUCTOS -->
<div class="modal fade" id="listaproductos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="listaproductosLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header color-morado">
        <h1 class="modal-title fs-5 text-white" id="listaproductosLabel">LISTADO DE PRODUCTOS</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-striped table-hover table-borderless" id="table-productos">
              <thead >
                <tr>
                  <th class="color-morado text-white text-uppercase"> </th>
                  <th class="color-morado text-white text-uppercase"> Codigo</th>
                  <th class="color-morado text-white text-uppercase"> EAN8 </th>
                  <th class="color-morado text-white text-uppercase"> Nombre </th>
                  <th class="color-morado text-white text-uppercase"> proveedor </th>
                  <th class="color-morado text-white text-uppercase"> Categoria </th>
                  <th class="color-morado text-white text-uppercase"> subCategoria </th>
                  <th class="color-morado text-white text-uppercase"> estado </th>
                </tr>
              </thead>
                        <tbody>
                          <?php foreach($productos->getResult() as $producto){ ?>
                          <tr>
                            <td>
                              <div class="form-check">
                                <input
                                  class="form-check-input mx-3 borde"
                                  type="radio"
                                  name="radioDefault"
                                  id="radioDefault1"
                                  onclick="VincularProductoModal(<?= $producto->codigo_barras; ?>)"
                                >
                              </div>
                            </td>
                            <td> <?= $producto->codigo_interno; ?></td>
                            <td> <?= $producto->codigo_barras; ?></td>
                            <td>
                              <div class="row">
                               <div class="d-flex px-2 py-1">
                                 <div>
                                    <img src="https://themewagon.github.io/plus-admin/assets/images/faces-clipart/pic-1.png" class="avatar avatar-sm me-3">
                                 </div>
                                 <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-xs"><?= $producto->nombre; ?></h6>
                                    <p class="text-xs text-dark mb-0"><?= $producto->codigo_barras; ?></p>
                                 </div>
                              </div>
                              </div>
                            </td>
                            <td><?= $producto->proveedor; ?></td>
                            <td><?= $producto->categoria; ?></td>
                            <td><?= $producto->subcategoria; ?></td>
                            <td><label class="badge badge-success"><?= $producto->estado; ?></label></td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-rounded" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

  <?php require_once("componentes/scripts.php")?>
  <script src="<?= base_url('js/conteos.js') ?>"></script>
  </body>
</html>
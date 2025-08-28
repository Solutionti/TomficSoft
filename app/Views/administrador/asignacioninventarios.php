<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion - Asignacion de inventarios</title>
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
                <button class="btn btn-primary mb-2 mb-md-0 me-2 btn-rounded" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Agregar inventario</button>
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
                    <p class="m-0">INV - ASIGNACION</p>
                  </a>
                </div>
              </div>
            </div>
       <!-- aca va el contenido  -->
                 <div class="row">
                  <div class="col-md-3">
                    <label class="mb-1 small">Usuario</label>
                    <input 
                      type="text"
                      id="usuario_creacion"
                      name="usuario_creacion"
                      class="form-control form-control-sm borde"
                      value="<?php echo session('nombre'). ' ' .session('apellido') ?>"
                      readonly
                    >
                  </div>
                  <div class="col-md-3">
                    <label class="mb-1 small">Año</label>
                    <input 
                      type="text"
                      id="año_creacion"
                      name="año_creacion"
                      class="form-control form-control-sm borde"
                      value="2025"
                      readonly
                    >
                  </div>
                  <div class="col-md-3">
                    <label class="mb-1 small">Fecha</label>
                    <input 
                      type="text"
                      id="fecha_creacion"
                      name="fecha_creacion"
                      class="form-control form-control-sm borde"
                      value="<?php echo date('Y-m-d') ?>"
                    >
                  </div>
                  <div class="col-md-3">
                    <label class="mb-1 small">Bodega</label>
                    <input 
                      type="text"
                      id="bodega_creacion"
                      name="bodega_creacion"
                      class="form-control form-control-sm borde"
                    >
                  </div>
                 </div>
                 <div class="row mt-3">
                <div class="col-md-12">
                  <div class="table-responsive">
                        <table class="table table-striped">
                            <thead >
                              <tr >
                                <th class="color-morado text-white text-uppercase"> </th>
                                <th class="color-morado text-white text-uppercase">ID</th>
                                <th class="color-morado text-white text-uppercase">Fecha</th>
                                <th class="color-morado text-white text-uppercase">Observacion</th>
                                <th class="color-morado text-white text-uppercase">Fecha inicio</th>
                                <th class="color-morado text-white text-uppercase">Fecha cierre</th>
                                <th class="color-morado text-white text-uppercase">Estado</th>
                                <th class="color-morado text-white text-uppercase">Proceso final</th>
                                <th class="color-morado text-white text-uppercase">Panel de control</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach($asignacionInventarios->getResult() as $asignacionInventario) { ?>
                              <tr>
                                <td></td>
                                <td><?= $asignacionInventario->codigo_inventario; ?></td>
                                <td><?= $asignacionInventario->fecha; ?></td>
                                <td><?= $asignacionInventario->observacion; ?></td>
                                <td><?= $asignacionInventario->fecha_inicio; ?></td>
                                <td><?= $asignacionInventario->fecha_cierre; ?></td>
                                <td><label class="badge badge-success "><?= $asignacionInventario->estado; ?></label></td>
                                <td><label class="badge badge-success "><?= $asignacionInventario->proceso_final; ?></label></td>
                                <td>
                                  <button class="btn btn-primary btn-xs btn-rounded mx-1" data-bs-toggle="modal" data-bs-target="#listaproductos">Productos</button>
                                  <button class="btn btn-primary btn-xs btn-rounded mx-1" data-bs-toggle="modal" data-bs-target="#modalConteos">Conteos</button>
                                  <button class="btn btn-primary btn-xs btn-rounded mx-1" data-bs-toggle="modal" data-bs-target="#modalProceso">Procesos</button>
                                  <button class="btn btn-primary btn-xs btn-rounded mx-1" data-bs-toggle="modal" data-bs-target="#modalReportes">Reportes</button>
                                </td>
                              </tr>  
                              <?php } ?>
                            </tbody>
                          </table>

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

<!-- MODAL PARA CREAR EL FORMULARIO -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header color-morado">
        <h1 class="modal-title fs-5  text-white" id="staticBackdropLabel">CREACION DE INVENTARIO</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mt-3">
          <div class="col-md-12">
            <label class="mb-1 small">Fecha inicial *</label>
            <input 
              type="date"
              id="fecha_agregar_inventario"
              name="fecha_agregar_inventario"
              class="form-control form-control-sm borde"
              value="<?php echo date('Y-m-d') ?>"
              readonly
            >
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-12">
            <label class="mb-1 small ">Observaciòn *</label>
            <textarea 
              type="text"
              id="observacion_agregar_inventario"
              name="observacion_agregar_inventario"
              class="form-control form-control-md borde"
              rows="27"
              ></textarea>
          </div>
        </div>
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-rounded" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary btn-rounded" onclick="crearInventarios()">Guardar</button>
        </div>
      </div>
    </div>
  </div>

<!-- MODAL FORMULARIO CONTEOS -->
<div class="modal fade" id="modalConteos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalConteosLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header color-morado">
        <h1 class="modal-title fs-5  text-white" id="modalConteosLabel">PROGRAMACION Y CREACION DE CONTEOS INDIVIDUALES</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<!-- aca va el formulario -->
        <div class="row mt-2">
          <div class="col-md-4">
            <label class="mb-1 small">Ubicacion</label>
            <select
                class="form-control form-control-sm borde text-uppercase"
                id="ubicacion_conteo"
              >
                <option value="">Seleccione Ubicacion</option>
                <option value="Piso de venta">Piso de venta</option>
                <option value="Bodega">Bodega</option>    
               </select>
          </div>
          <div class="col-md-4">
            <label class="mb-1 small">Localizacion</label>
            <input 
              type="text"
              id="localizacion_conteo"
              name="localizacion_conteo"
              class="form-control form-control-sm borde"
            >
          </div>
          
          <div class="col-md-4">
            <label class="mb-1 small">N. Localizacion</label>
            <input 
              type="text"
              id="numero_conteo"
              name="numero_conteo"
              class="form-control form-control-sm borde"
            >
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-12">
            <label class="mb-1 small ">Observaciòn *</label>
            <textarea 
              type="text"
              id="observacion_agregar_inventario"
              name="observacion_agregar_inventario"
              class="form-control form-control-md borde"
              rows="27"
              ></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-rounded" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary btn-rounded">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- MODAL FORMULARIO PROCESOS -->
<div class="modal fade" id="modalProceso" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalProcesoLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header color-morado">
        <h1 class="modal-title fs-5  text-white" id="modalProcesoLabel">VISTA DE PROCESOS - TIPO DE VISTA</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<!-- aca va el formulario -->
        <div class="row mt-2">
          <div class="col-md-6">
            <label class="mb-1 small">Ubicacion</label>
            <select
                class="form-control form-control-sm borde text-uppercase"
                id="ubicacion_procesos"
              >
                <option value="">Seleccione Ubicacion</option>
                <option value="Piso de venta">Piso de venta</option>
                <option value="Bodega">Bodega</option>    
               </select>
          </div>
          <div class="col-md-6">
            <label class="mb-1 small">Productos</label>
            <select
                class="form-control form-control-sm borde text-uppercase"
                id="productos_procesos"
              >
                <option value="">Seleccione Ubicacion</option>
                <option value="producto 1">Producto 1</option>
                <option value="producto 2">producto 2</option>    
               </select>
          </div>
        </div>
        <div class="row mt-3">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead >
                          <tr >
                            <th class="color-morado text-white text-uppercase"> </th>
                            <th class="color-morado text-white text-uppercase">Ubicacion</th>
                            <th class="color-morado text-white text-uppercase">Localizacion</th>
                            <th class="color-morado text-white text-uppercase">N. Localizacion</th>
                            <th class="color-morado text-white text-uppercase">Observacion</th>
                            <th class="color-morado text-white text-uppercase">Usuario</th>
                            <th class="color-morado text-white text-uppercase">Conteo #1</th>
                            <th class="color-morado text-white text-uppercase">Obs #1</th>
                            <th class="color-morado text-white text-uppercase">Conteo #2</th>
                            <th class="color-morado text-white text-uppercase">Obs #2</th>
                            <th class="color-morado text-white text-uppercase">Diferencia</th>
                            <!-- <th class="color-morado text-white text-uppercase">Conteo #3</th>
                            <th class="color-morado text-white text-uppercase">Obs #3</th> -->
                            <th class="color-morado text-white text-uppercase">Validador</th>
                            <th class="color-morado text-white text-uppercase">Imprimir reporte</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td></td>
                            <td>Bodega</td>
                            <td>Mueble</td>
                            <td>Detergente</td>
                            <td>2</td>
                            <td>10</td>
                            <td><label class="badge badge-success ">Ok</label></td>
                            <td>20</td>
                            <td><label class="badge badge-success ">Ok</label></td>
                            <td>10</td>
                            <td><label class="badge badge-success ">COINCIDE</label></td>
                            <!-- <td></td>
                            <td></td> -->
                            <td><label class="badge badge-success ">Finalizado</label></td>
                            <td>
                              <div class="col-md-4">
                                <button class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target="#modalReportes">Imprimir</button>
                              </div>
                            </td>
                          </tr>  
                        </tbody>
                      </table>  
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-rounded" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary btn-rounded">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- MODAL FORMULARIO REPORTES -->
<div class="modal fade" id="modalReportes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalReportesLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header color-morado">
        <h1 class="modal-title fs-5  text-white" id="modalReportesLabel">PROGRAMACION DE CONTEOS FISICOS</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<!-- aca va el formulario -->
        <div class="row mt-3">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead >
                          <tr >
                            <th class="color-morado text-white text-uppercase"> </th>
                            <th class="color-morado text-white text-uppercase">Ubicacion</th>
                            <th class="color-morado text-white text-uppercase">Localizacion</th>
                            <th class="color-morado text-white text-uppercase">N. Localizacion</th>
                            <th class="color-morado text-white text-uppercase">Observacion</th>
                            <th class="color-morado text-white text-uppercase">Usuario</th>
                            <th class="color-morado text-white text-uppercase">Estado</th>
                            <th class="color-morado text-white text-uppercase"></th>
    
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td></td>
                            <td>Bodega</td>
                            <td>Mueble</td>
                            <td>Mueble 1</td>
                            <td>Detergentes</td>
                            <td>2</td>
                            <td>
                              <label class="badge badge-success mx-1">Ok</label>
                              <label class="badge badge-success mx-1">Ok</label>
                              <label class="badge badge-success mx-1">Ok</label>
                            </td>
                            <td>
                              <div class="col-md-4">
                                <button class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target="#modalAsignarConteos">Asignar conteos</button>
                              </div>
                            </td>
                          </tr>  
                        </tbody>
                      </table>  
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-rounded" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary btn-rounded">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- PRODUCTOS -->
<div class="modal fade" id="listaproductos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="listaproductosLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header color-morado">
        <h1 class="modal-title fs-5 text-white" id="listaproductosLabel">LISTADO DE PRODUCTOS</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mt-2">
          <div class="col-md-1">
            <label class="mb-1 small">Id</label>
            <input 
              type="text"
              class="form-control form-control-sm borde"
            >
          </div>
          <div class="col-md-3">
            <label class="mb-1 small">Linea</label>
            <select 
              name="" 
              id="" 
              class="form-control form-control-sm borde text-uppercase"
            >
              <option value="">Seleccione una opcion</option>
              <option value="">1</option>
              <option value="">2</option>
              <option value="">3</option>
              <option value="">4</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="mb-1 small">Sub linea</label>
            <select 
              name="" 
              id="" 
              class="form-control form-control-sm borde text-uppercase"
            >
              <option value="">Seleccione una opcion</option>
              <option value="">1</option>
              <option value="">2</option>
              <option value="">3</option>
              <option value="">4</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="mb-1 small">Sub grupo</label>
            <select 
              name="" 
              id="" 
              class="form-control form-control-sm borde text-uppercase"
            >
              <option value="">Seleccione una opcion</option>
              <option value="">1</option>
              <option value="">2</option>
              <option value="">3</option>
              <option value="">4</option>
            </select>
          </div>
          <div class="col-md-2">
            <br>
            <button class="btn btn-primary btn-rounded">Consultar</button>
          </div>
        </div>


        <div class="row mt-4">
          <div class="col-md-12">
            <table class="table table-striped table-hover table-borderless" id="table-productos">
              <thead >
                <tr>
                  <th class="color-morado text-white text-uppercase">
                    <div class="form-check">
                      <input
                        class="form-check-input mx-3 borde"
                        type="checkbox"
                        id="selectAll"
                      >
                    </div>
                  </th>
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
                                 class="form-check-input mx-4 borde fila"
                                 type="checkbox"
                                 value="<?= $producto->codigo_barras; ?>"
                              >
                              </div>
                            </td>
                            <td> <?= $producto->codigo_interno; ?></td>
                            <td> <?= $producto->codigo_barras; ?></td>
                            <td>
                              <div class="row">
                               <div class="d-flex px-2 py-1">
                                 <div>
                                    <img src="<?= base_url('img/team-41.jpg') ?>" class="avatar avatar-sm me-3">
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

<?php require_once("componentes/scripts.php")?>
<script src="<?= base_url('js/conteos.js') ?>"></script>
<script src="<?= base_url('js/asignacioninventarios.js') ?>"></script>

</body>
</html>
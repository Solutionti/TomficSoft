<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion - Usuarios</title>
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
                    >
                  </div>
                  <div class="col-md-3">
                    <label class="mb-1 small">Año</label>
                    <input 
                      type="text"
                      id="año_creacion"
                      name="año_creacion"
                      class="form-control form-control-sm borde"
                      value="<?= date('H:i') ?>"
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
                    <table class="table table-striped">
                        <thead >
                          <tr >
                            <th class="color-morado text-white text-uppercase"> </th>
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
                          <tr>
                            <td></td>
                            <td>12-03-2025</td>
                            <td><p>lpepito peres es el mejor del mundoo, mundial</p></td>
                            <td>12-04-2025</td>
                            <td>12-05-2025</td>
                            <td><label class="badge badge-success ">Activo</label></td>
                            <td><label class="badge badge-success ">Finalizado</label></td>
                            <td>
                              <div class="row">
                                <div class="col-md-4">
                                  <button class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target="#modalConteos">Conteos</button>
                                </div>
                                <div class="col-md-4">
                                  <button class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target="#modalProceso">Procesos</button>
                                </div>
                                <div class="col-md-4">
                                  <button class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target="#modalReportes">Reportes</button>
                                </div>

                              </div>
                            </td>
                          </tr>  
                        </tbody>
                      </table>  
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
          <div class="col-md-6">
            <label class="mb-1 small">Fecha inicial *</label>
            <input 
              type="date"
              id="fecha_agregar_inventario"
              name="fecha_agregar_inventario"
              class="form-control form-control-sm borde"
            >
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-6">
            <label class="mb-1 small ">OBSERVACION *</label>
            <textarea 
              type="text"
              id="observacion_agregar_inventario"
              name="observacion_agregar_inventario"
              class="form-control form-control-md borde"
              >
            </textarea>
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
        <div class="row mt-3">
          <div class="col-md-3">
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
          <div class="col-md-3">
            <label class="mb-1 small">Localizacion</label>
            <input 
              type="text"
              id="localizacion_conteo"
              name="localizacion_conteo"
              class="form-control form-control-sm borde"
            >
          </div>
          <div class="col-md-3">
            <label class="mb-1 small">Nevera</label>
            <input 
              type="text"
              id="nevera_conteo"
              name="nevera_conteo"
              class="form-control form-control-sm borde"
            >
          </div>
          <div class="col-md-3">
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
          <div class="col-md-6">
            <label class="mb-1 small ">OBSERVACION *</label>
            <textarea 
              type="text"
              id="observacion_agregar_inventario"
              name="observacion_agregar_inventario"
              class="form-control form-control-md borde"
              >
            </textarea>
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
        <div class="row mt-3">
          <div class="col-md-4">
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
          <div class="col-md-4">
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
                            <th class="color-morado text-white text-uppercase">Conteo #3</th>
                            <th class="color-morado text-white text-uppercase">Obs #3</th>
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
                            <td></td>
                            <td></td>
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
                            <td><label class="badge badge-success ">Ok Ok Ok</label></td>
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
        

<?php require_once("componentes/scripts.php")?>
</body>
</html>
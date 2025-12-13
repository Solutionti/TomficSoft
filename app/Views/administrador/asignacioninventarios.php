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
                <button class="btn btn-success mb-2 mb-md-0 me-2 btn-rounded" data-bs-toggle="modal" data-bs-target="#modalasgignacionescrear" >Agregar ubicaciones</button>
                <button class="btn btn-outline-danger mb-2 mb-md-0 me-2 btn-rounded" data-bs-toggle="modal" data-bs-target="#modalProceso">Reportes</button>
                <button
                  class="btn btn-outline-primary bg-white mb-2 mb-md-0 btn-rounded"
                  data-bs-toggle="modal"
                  data-bs-target="#exportarexcelmodal"
                >
                  Importar base de datos
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
                                <th class="color-morado text-white text-uppercase">Conteo?</th>
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
                                <td>
                                  <button
                                    class="badge badge-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#actualizarinventario"
                                    onclick="procesoDatosModalActualizar(<?= $asignacionInventario->codigo_inventario; ?>)"
                                  >
                                    <i class="fas fa-edit fa-1x "></i>
                                  </button>
                                </td>
                                <td><?= $asignacionInventario->codigo_inventario; ?></td>
                                <td><?= $asignacionInventario->fecha; ?></td>
                                <td class="text-uppercase"><?= $asignacionInventario->observacion; ?></td>
                                <td class="text-uppercase"><?= $asignacionInventario->conteos; ?></td>
                                <td><?= $asignacionInventario->fecha_inicio; ?></td>
                                <td><?= $asignacionInventario->fecha_cierre; ?></td>
                                  <?php if($asignacionInventario->estado == 'Activo') { ?>
                                    <td><label class="badge badge-success "><?= $asignacionInventario->estado; ?></label></td>
                                    <?php } else { ?>
                                      <td><label class="badge badge-danger "><?= $asignacionInventario->estado; ?></label></td>
                                  <?php } ?>
                                <td><label class="badge badge-success "><?= $asignacionInventario->proceso_final; ?></label></td>
                                <td>
                                    <?php if($asignacionInventario->btnproducto == 0) {?>
                                      <button class="btn btn-primary btn-xs btn-rounded mx-1" onclick="asociarDatosModalProductos(<?= $asignacionInventario->codigo_inventario; ?>)">Productos</button>
                                    <?php } else {?>
                                      <button class="btn btn-success btn-xs btn-rounded mx-1" onclick="asociarDatosModalProductos(<?= $asignacionInventario->codigo_inventario; ?>)">Productos</button>
                                    <?php }?>

                                    <?php if($asignacionInventario->btnubicacion == 0) {?>
                                      <button class="btn btn-primary btn-xs btn-rounded mx-1" onclick="asociarDatosModalConteos(<?= $asignacionInventario->codigo_inventario; ?>)">Ubicacion</button>
                                    <?php } else {?>
                                      <button class="btn btn-success btn-xs btn-rounded mx-1" onclick="asociarDatosModalConteos(<?= $asignacionInventario->codigo_inventario; ?>)">Ubicacion</button>
                                    <?php }?>

                                    <?php if($asignacionInventario->btnproceso == 0) {?>
                                      <button
                                        class="btn btn-primary btn-xs btn-rounded mx-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalReportes"
                                        onclick="procesoDatosModal(<?= $asignacionInventario->codigo_inventario; ?>)"
                                      >
                                        Procesos
                                      </button>
                                    <?php } else {?>
                                      <button
                                        class="btn btn-success btn-xs btn-rounded mx-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalReportes"
                                        onclick="procesoDatosModal(<?= $asignacionInventario->codigo_inventario; ?>)"
                                      >
                                        Procesos
                                      </button>
                                    <?php }?>
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
        <div class="container-fluid">

          <div class="row mt-3">
            <div class="col-md-8">
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
             <div class="col-md-4">
              <label class="mb-1 small">Cuantos conteos? *</label>
              <select
                class="form-control form-control-sm borde"
                id="conteos_agregar_inventario"
              >
                <option value="">Seleccione a cuantos conteos </option>
                <option value="1">1 </option>
                <option value="2">2</option>
              </select>
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
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-rounded" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary btn-rounded" onclick="crearInventarios()" id="creinventario">
            <span class="spinner-border spinner-border-sm" id="spinnerinventarios" hidden="true"></span>  
            Guardar
          </button>
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
        <div class="container-fluid">

          <div class="row mt-2">
            <div class="col-md-1">
              <label class="mb-1 small">Id</label>
              <input 
                type="text"
                class="form-control form-control-sm borde"
                id="id_conteo_modal"
              >
            </div>
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
            <div class="col-md-4">
              <label class="mb-1 small">Localizacion</label>
              <select
                id="localizacion_conteo"
                class="form-control form-control-sm borde text-uppercase"
                onchange="getnumerolocalizacion()"
              >
                <option value="">Seleccione Localizacion</option>
                <option value="GONDOLA">GONDOLA</option>
                <option value="NEVERAS">NEVERAS</option>
                <option value="VITRINAS">VITRINAS</option>
              </select>
            </div>
            
            <div class="col-md-4">
              <label class="mb-1 small">N. Localizacion</label>
              <input 
                type="text"
                id="numero_conteo"
                class="form-control form-control-sm borde"
                readonly
              >
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-12">
              <label class="mb-1 small ">Observaciòn *</label>
              <textarea 
                type="text"
                id="observacion_agregar_inventarios"
                class="form-control form-control-md borde"
                rows="27"
                ></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-rounded" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary btn-rounded" onclick="asignarUbicacionInventario()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- MODAL FORMULARIO PROCESOS -->
<div class="modal fade" id="modalProceso" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalProcesoLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header color-morado">
        <h1 class="modal-title fs-5  text-white" id="modalProcesoLabel">VISTA DE PROCESOS - TABLERO DE REPORTES DE CONTEOS</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row mt-3">
            <div class="col-md-12">
              <div class="table-responsive">

                <table class="table table-striped">
                  <thead >
                    <tr>
                      <!-- <th class="color-morado text-white text-uppercase"> </th> -->
                      <th class="color-morado text-white text-uppercase">Ubicacion</th>
                      <th class="color-morado text-white text-uppercase">Localizacion</th>
                      <th class="color-morado text-white text-uppercase">N.Local</th>
                      <th class="color-morado text-white text-uppercase">Observacion</th>
                      <th class="color-morado text-white text-uppercase">Usuarios</th>
                      <th class="color-morado text-white text-uppercase">Conteo #1</th>
                      <!-- <th class="color-morado text-white text-uppercase">Obs #1</th> -->
                      <th class="color-morado text-white text-uppercase">Conteo #2</th>
                      <!-- <th class="color-morado text-white text-uppercase">Obs #2</th> -->
                      <th class="color-morado text-white text-uppercase">Diferencia</th>
                      <th class="color-morado text-white text-uppercase">Validador</th>
                      <th class="color-morado text-white text-uppercase">Imprimir reporte</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php foreach($reportes->getResult() as $reporte){ ?>
                    <tr>
                      <td class="text-uppercase"><?= $reporte->ubicacion; ?></td>
                      <td class="text-uppercase"><?= $reporte->localizacion; ?></td>
                      <td><?= $reporte->numerolocalizacion; ?></td>
                      <td class="text-uppercase"><?= $reporte->observacion; ?></td>
                      <td><?= $reporte->usuarioconteo1.' --> '.$reporte->usuarioconteo2; ?></td>
                      <td><label class="badge badge-dark"><?= $reporte->conte1; ?></label></td>
                      <!-- <td><label class="badge badge-success ">Proceso</label></td> -->
                      <td><label class="badge badge-dark "><?= $reporte->conte2; ?></label></td>
                      <!-- <td><label class="badge badge-success ">No conteo</label></td> -->
                      <td><label class="badge badge-danger "><?= ($reporte->conte1 - $reporte->conte2); ?></label></td>
                      <?php
                        $total = $reporte->conte1 - $reporte->conte2;
                        if($total > 0){
                      ?>
                        <td><label class="badge badge-danger ">Diferencia</label></td>
                        <?php } else { ?>
                        <td><label class="badge badge-success">Completo</label></td>
                      <?php } ?>
                      <td>
                        <div class="col-md-4">
                          <a
                            target="_blank"
                            href="<?php echo base_url(); ?>generarpdfreportes/<?= $reporte->codigo_inventario; ?>"
                            class="btn btn-danger btn-sm btn-rounded mx-2"
                          >
                            Pdf
                          </a>
                          <a
                            class="btn btn-success btn-sm btn-rounded"
                            href="<?php echo base_url(); ?>generarexcelreportes/<?= $reporte->codigo_inventario; ?>"
                          >
                            Excel
                          </a>
                        </div>
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
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-rounded mx-3" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- MODAL FORMULARIO REPORTES -->
<div class="modal fade" id="modalReportes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalReportesLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header color-morado">
        <h1 class="modal-title fs-5  text-white" id="modalReportesLabel">ASIGNACION DE CONTEOS FISICOS</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">

          <div class="row mt-3">
            <div class="col-md-4 ">
              <label class="mb-1 small">Fecha</label>
              <input
                type="date"
                class="form-control form-control-sm borde"
                id="fecha_asignacion"
                readonly
              >
            </div>
            <!--  -->
            <div class="col-md-6">
              <label class="mb-1 small">Observación</label>
              <input
                type="text"
                 class="form-control form-control-sm borde"
                 id="observacion_asignacion"
                  readonly
              >
            </div>
            <!--  -->
            <div class="col-md-2">
              <label class="mb-1 small">Codigo Inventario</label>
              <input
                type="text"
                 class="form-control form-control-sm borde"
                 id="codigo_asignacion"
                  readonly
              >
            </div>
          </div>
          <!--  -->
          <div class="row mt-4">
            <div class="col-md-4 ">
              <label class="mb-1 small">Ubicación</label>
              <input
                type="text"
                 class="form-control form-control-sm borde"
                 id="ubicacion_asignacion"
                  readonly
              >
            </div>
            <!--  -->
            <div class="col-md-3">
              <label class="mb-1 small">Localización</label>
              <input
                type="text"
                 class="form-control form-control-sm borde"
                 id="localizacion_asignacion"
                  readonly
              >
            </div>
            <!--  -->
            <div class="col-md-3">
              <label class="mb-1 small">N° Localización</label>
              <input
                type="text"
                 class="form-control form-control-sm borde"
                 id="nlocalizacion_asignacion"
                  readonly
              >
            </div>
             <div class="col-md-2">
              <label class="mb-1 small"># conteos</label>
              <input
                type="text"
                 class="form-control form-control-sm borde"
                 id="nconteos_asignacion"
                 readonly
              >
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-md-6">
               <h5>Asignar usuario conteo 1</h5>
               <br>
              <table class="table table-striped" id="tablaconteo1usuario">
                <thead >
                  <tr>
                    <th class="color-morado text-white text-uppercase"> </th>
                    <th class="color-morado text-white text-uppercase">Codigo</th>
                    <th class="color-morado text-white text-uppercase">Nombre</th>
                    <th class="color-morado text-white text-uppercase">Apellido</th>
                    <th class="color-morado text-white text-uppercase">Rol</th>
                    <th class="color-morado text-white text-uppercase">Estado</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($usuarios->getResult() as $usuario) { ?>
                  <tr>
                    <td>
                      <div class="form-check">
                        <input
                          class="form-check-input mx-3 borde chk"
                          type="checkbox"
                          value="<?= $usuario->documento; ?>"
                        >
                      </div>
                    </td>
                    <td><?= $usuario->documento; ?></td>
                    <td><?= $usuario->nombre; ?></td>
                    <td><?= $usuario->apellido; ?></td>
                    <td><?= $usuario->rol_usuario; ?></td>
                    <td><?= $usuario->estado; ?></td>
                  </tr> 
                  <?php } ?> 
                </tbody>
              </table>  
            </div>
            <div class="col-md-6">
              <h5>Asignar usuario conteo 2</h5>
              <br>
              <table class="table table-striped" id="tablaconteo2usuario">
                <thead >
                  <tr>
                    <th class="color-morado text-white text-uppercase"> </th>
                    <th class="color-morado text-white text-uppercase">Codigo</th>
                    <th class="color-morado text-white text-uppercase">Nombre</th>
                    <th class="color-morado text-white text-uppercase">Apellido</th>
                    <th class="color-morado text-white text-uppercase">Rol</th>
                    <th class="color-morado text-white text-uppercase">Estado</th>
                  </tr> 
                </thead>
                <tbody>
                  <?php foreach($usuarios->getResult() as $usuario) { ?>
                  <tr>
                    <td>
                      <div class="form-check">
                        <input
                          class="form-check-input mx-3 borde fila"
                          type="checkbox"
                          value="<?= $usuario->documento; ?>"
                        >
                      </div>
                    </td>
                    <td><?= $usuario->documento; ?></td>
                    <td><?= $usuario->nombre; ?></td>
                    <td><?= $usuario->apellido; ?></td>
                    <td><?= $usuario->rol_usuario; ?></td>
                    <td><?= $usuario->estado; ?></td>
                  </tr> 
                  <?php } ?>  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-rounded" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary btn-rounded" onclick="asignarUsuarioInventario()">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- PRODUCTOS -->
<div class="modal fade" id="listaproductos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="listaproductosLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header color-morado">
        <h1 class="modal-title fs-5 text-white" id="listaproductosLabel">ASIGNACION DE PRODUCTOS</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
            <div class="row mt-2">
              <div class="col-md-3">
                <label class="mb-1 small">Codigo</label>
                <input 
                  type="text"
                  class="form-control form-control-sm borde"
                  id="id_inventario_modal"
                  readonly
                >
              </div>
              <div class="col-md-3">
                <label class="mb-1 small">Fecha</label>
                <input 
                  type="date"
                  class="form-control form-control-sm borde"
                  id="fecha_inventario_modal"
                  value="<?php echo date("Y-m-d") ?>"
                  readonly
                >
              </div>
              <div class="col-md-3">
                <label class="mb-1 small">Hora</label>
                <input 
                  type="time"
                  class="form-control form-control-sm borde"
                  id="hora_inventario_modal"
                  value="<?php echo date('H:i'); ?>"
                  readonly
                >
              </div>
              <div class="col-md-3">
                <label class="mb-1 small">Usuario</label>
                <input 
                  type="text"
                  class="form-control form-control-sm borde"
                  id="usuario_inventario_modal"
                  value="<?php echo session('nombre'). ' ' .session('apellido') ?>"
                  readonly
                >
              </div>
          </div>
          <div class="row mt-4">
            <div class="col-md-4">
              <div class="upload-card">
                <h3 class="text-center mb-4">
                  <i class="bi bi-cloud-upload"></i> Subir Archivo
                </h3>
                <div class="file-input-wrapper" id="fileWrapper">
                  <input
                    type="file"
                    id="fileInput"
                    class="form-control"
                    accept=".xlsx,.xls,.xlsm,.xlsb,.xltx,.xltm"
                  >
                  <div class="file-icon">
                    <i class="bi bi-file-earmark-arrow-up"></i>
                  </div>
                    <h5 >Arrastra y suelta tu archivo aquí</h5>
                    <p class="text-muted mb-0">o haz clic para seleccionar</p>
                   <small class="text-muted d-block mt-2">Formatos permitidos: XLSX, XLS, XLSM (Max 30MB)</small>
                </div>
                <div class="file-info" id="fileInfo">
                  <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                      <i class="bi bi-file-earmark-check text-success fs-3 me-3"></i>
                      <div>
                        <strong id="fileName">archivo.pdf</strong>
                        <small class="text-muted d-block" id="fileSize">2.5 MB</small>
                      </div>
                    </div>
                    <button class="btn btn-sm btn-danger" id="removeFile">
                      <i class="bi bi-trash"></i>
                    </button>
                </div>
                <div class="progress mt-3" style="height: 6px;">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                </div>
              </div>
             </div>
            </div>
            <div class="col-md-8">
              <table class="table table-striped table-hover table-borderless" id="resultTable">
                <thead >
                  <tr>
                    <th class="color-morado text-white text-uppercase"> Codigo</th>
                    <th class="color-morado text-white text-uppercase"> Inventario</th>
                    <th class="color-morado text-white text-uppercase"> Fecha </th>
                    <th class="color-morado text-white text-uppercase"> Hora </th>
                    <th class="color-morado text-white text-uppercase"> Usuario </th>
                    <th class="color-morado text-white text-uppercase"> Estado </th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-rounded" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary btn-rounded" id="btnObtener">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- EXPORTAR EXCEL -->
<div class="modal fade" id="exportarexcelmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exportarexcelmodalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ">
      <div class="modal-header color-morado">
        <h1 class="modal-title fs-5 text-white" id="exportarexcelmodalLabel">IMPORTAR BASE DE DATOS</h1>
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
        <a type="button" class="btn btn-success btn-rounded" href="<?= base_url('excel/formato_productos.xlsx') ?>">
          Formato Excel
        </a>
        <button type="button" class="btn btn-primary btn-rounded" id="exportardatos">
          <span class="spinner-border spinner-border-sm" id="spinnerexportarproducto" hidden="true"></span>
          Importar
        </button>
        <button type="button" class="btn btn-danger btn-rounded" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- ACTUALIZAR EL INVENTARIO  -->
 <div class="modal fade" id="actualizarinventario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="actualizarinventarioLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header color-morado">
        <h1 class="modal-title fs-5  text-white" id="actualizarinventarioLabel">ACTUALIZAR  INVENTARIO</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">

          <div class="row mt-3">
            <div class="col-md-2">
              <label class="mb-1 small">Codigo inventario *</label>
              <input 
                type="number"
                id="codigo_actualizar_inventario"
                class="form-control form-control-sm borde"
                readonly
              >
            </div>
            <div class="col-md-6">
              <label class="mb-1 small">Fecha inicial *</label>
              <input 
                type="date"
                id="fecha_actualizar_inventario"
                class="form-control form-control-sm borde"
              >
            </div>
             <div class="col-md-4">
              <label class="mb-1 small">Cuantos conteos? *</label>
              <select
                class="form-control form-control-sm borde"
                id="conteos_actualizar_inventario"
              >
                <option value="">Seleccione a cuantos conteos </option>
                <option value="1">1 </option>
                <option value="2">2</option>
              </select>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-12">
              <label class="mb-1 small ">Observaciòn *</label>
              <textarea 
                type="text"
                id="observacion_actualizar_inventario"
                class="form-control form-control-md borde"
                rows="27"
                ></textarea>
            </div>
          </div>
        </div>
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-rounded" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary btn-rounded" onclick="actualizarInventarios()">
            Actualizar
          </button>
        </div>
      </div>
    </div>
  </div>

<!-- MODAL DE ASIGNACIONES -->
<div class="modal fade" id="modalasgignacionescrear" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalasgignacionescrearLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header color-morado">
        <h1 class="modal-title fs-5 text-white" id="modalasgignacionescrearLabel">CREACION DE UBICACIONES</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
          <li class="nav-item" role="presentation">
           <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">UBICACIÓN</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">LOCALIZACIÓN</button>
          </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
          
          <label class="mb-1 small ">Descripcion</label>
          <input type="text" class="form-control form-control-sm borde" placeholder="Ubicación">
            <button class="btn btn-primary mt-2 btn-rounded">Guardar</button>        
          </div>
          <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
           <label class="mb-1 small ">Descripcion</label>
           <input type="text" class="form-control form-control-sm borde" placeholder="Localizacion">
           <button class="btn btn-success mt-2 btn-rounded">Guardar</button>
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
<script src="<?= base_url('js/asignacioninventarios.js') ?>"></script>

</body>
</html>
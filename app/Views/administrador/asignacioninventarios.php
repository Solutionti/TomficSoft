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
                <button class="btn btn-outline-danger mb-2 mb-md-0 me-2 btn-rounded" data-bs-toggle="modal" data-bs-target="#modalProceso">Reportes</button>
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
                                <td class="text-uppercase"><?= $asignacionInventario->observacion; ?></td>
                                <td><?= $asignacionInventario->fecha_inicio; ?></td>
                                <td><?= $asignacionInventario->fecha_cierre; ?></td>
                                <td><label class="badge badge-success "><?= $asignacionInventario->estado; ?></label></td>
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
            <input 
              type="text"
              id="localizacion_conteo"
              class="form-control form-control-sm borde"
            >
          </div>
          
          <div class="col-md-4">
            <label class="mb-1 small">N. Localizacion</label>
            <input 
              type="text"
              id="numero_conteo"
              class="form-control form-control-sm borde"
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
        <div class="row mt-3">
          <div class="col-md-12">
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
                  <th class="color-morado text-white text-uppercase">Obs #1</th>
                  <th class="color-morado text-white text-uppercase">Conteo #2</th>
                  <th class="color-morado text-white text-uppercase">Obs #2</th>
                  <th class="color-morado text-white text-uppercase">Diferencia</th>
                  <th class="color-morado text-white text-uppercase">Validador</th>
                  <th class="color-morado text-white text-uppercase">Imprimir reporte</th>
                </tr>
              </thead>
              <tbody>
                 <?php foreach($reportes->getResult() as $reporte){ ?>
                <tr>
                  <!-- <td>
                    <button
                      class="badge badge-primary"
                    >
                      <i class="fas fa-eye fa-1x "></i>
                    </button>
                  </td> -->
                  <td class="text-uppercase"><?= $reporte->ubicacion; ?></td>
                  <td class="text-uppercase"><?= $reporte->localizacion; ?></td>
                  <td><?= $reporte->numerolocalizacion; ?></td>
                  <td class="text-uppercase"><?= $reporte->observacion; ?></td>
                  <td><?= $reporte->usuarioconteo1.' - '.$reporte->usuarioconteo2; ?></td>
                  <td><label class="badge badge-dark"><?= $reporte->conte1; ?></label></td>
                  <td><label class="badge badge-success ">Ok</label></td>
                  <td><label class="badge badge-dark "><?= $reporte->conte2; ?></label></td>
                  <td><label class="badge badge-success ">Ok</label></td>
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
                        href="<?php echo base_url(); ?>generarpdfreportes"
                        class="btn btn-danger btn-sm btn-rounded mx-2"
                      >
                        Pdf
                      </a>
                      <button class="btn btn-success btn-sm btn-rounded">Excel</button>
                    </div>
                  </td>
                 </tr>
                 <?php } ?>
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
        <h1 class="modal-title fs-5  text-white" id="modalReportesLabel">ASIGNACION DE CONTEOS FISICOS</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
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
          <div class="col-md-4">
            <label class="mb-1 small">Localización</label>
            <input
              type="text"
               class="form-control form-control-sm borde"
               id="localizacion_asignacion"
                readonly
            >
          </div>
          <!--  -->
          <div class="col-md-4">
            <label class="mb-1 small">N° Localización</label>
            <input
              type="text"
               class="form-control form-control-sm borde"
               id="nlocalizacion_asignacion"
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
        <h1 class="modal-title fs-5 text-white" id="listaproductosLabel">LISTADO DE PRODUCTOS</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mt-2">
          <div class="col-md-2">
            <label class="mb-1 small">Id</label>
            <input 
              type="text"
              class="form-control form-control-sm borde"
              id="id_inventario_modal"
              readonly
            >
          </div>
          <div class="col-md-3">
            <label class="mb-1 small">Subcategoria</label>
            <select 
              id="subcategoria_filtro" 
              class="form-control form-control-sm borde text-uppercase"
            >
              <option value="">SELECCIONE UNA SUBCATEGORIA</option>
              <?php foreach($subcategorias->getResult() as $subcategoria) { ?>
              <option value="<?= $subcategoria->subcategoria ?>"><?= $subcategoria->subcategoria ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="col-md-3">
            <label class="mb-1 small">Grupo</label>
            <select 
              id="grupo_filtro" 
              class="form-control form-control-sm borde text-uppercase"
            >
              <option value="">SELECCIONE UN GRUPO</option>
              <?php foreach($grupos->getResult() as $grupo) { ?>
              <option value="<?= $grupo->grupo ?>"><?= $grupo->grupo ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="col-md-3">
            <label class="mb-1 small">Subgrupo</label>
            <select 
              id="subgrupo_filtro" 
              class="form-control form-control-sm borde text-uppercase"
            >
              <option value="">SELECCIONE UN SUBGRUPO</option>
              <?php foreach($subgrupos->getResult() as $subgrupo) { ?>
              <option value="<?= $subgrupo->subgrupo ?>"><?= $subgrupo->subgrupo ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="col-md-1 mt-2">
            <br>
            <button
              class="btn btn-primary btn-rounded btn-sm"
              onclick="buscarProductosAsignar()"
              id="btnconsultaproductos"
            >
            <span class="spinner-border spinner-border-sm" id="spinnerproducto" hidden="true"></span>
            <span role="status">Buscar</span> 
            </button>
          </div>
        </div>


        <div class="row mt-4">
          <div class="col-md-12">
            <table class="table table-striped table-hover table-borderless">
              <thead >
                <tr>
                  <th class="color-morado text-white text-uppercase">
                    <div class="form-check">
                      <input
                        class="form-check-input mx-4 borde"
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
              <tbody id="tabla_productos_asignar">
                         
              </tbody>
            </table>
            
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
        <button type="button" class="btn btn-primary btn-rounded" id="exportardatos">
          <span class="spinner-border spinner-border-sm" id="spinnerexportarproducto" hidden="true"></span>
          Exportar
        </button>
      </div>
    </div>
  </div>
</div>

<?php require_once("componentes/scripts.php")?>
<script src="<?= base_url('js/conteos.js') ?>"></script>
<script src="<?= base_url('js/asignacioninventarios.js') ?>"></script>

</body>
</html>
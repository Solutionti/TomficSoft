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
              <table class="table table-striped table-borderless" id="table-pedidos">
                        <thead >
                          <tr >
                            <th class="color-morado text-white text-uppercase">
                                
                            </th>
                            <th class="color-morado text-white text-uppercase"> CONSECUTIVO</th>
                            <th class="color-morado text-white text-uppercase"> TIPO PAGO</th>
                            <th class="color-morado text-white text-uppercase"> TOTAL </th>
                            <th class="color-morado text-white text-uppercase"> C*C </th>
                            <th class="color-morado text-white text-uppercase"> FECHA </th>
                            <th class="color-morado text-white text-uppercase"> HORA </th>
                            <th class="color-morado text-white text-uppercase"> ESTADO </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($pedidos->getResult() as $pedido): ?>
                            <tr>
                              <td width="100">
                                <button
                                  class="badge badge-dark "
                                >
                                  <i class="fas fa-file-pdf fa-1x "></i>
                                </button>
                                <button
                                  class="badge badge-primary"
                                  onclick="verPedido('<?= $pedido->codigo_pedido; ?>')"
                                >
                                  <i class="fas fa-eye fa-1x "></i>
                                </button>
                                <a
                                  class="badge badge-success"
                                  target="_blank"
                                  href="https://wa.me/+57<?php echo $pedido->codigo_cliente; ?>?text=Hola hemos recibido tu pedido. Revisa el detalle del pedido en el siguiente link <?php echo $pedido->link; ?> opcion *Rastrear Pedido,* Con su numero de celular podra conocer el estado en tiempo real de su pedido.gracias por su compra."
                                >
                                  <i class="fab fa-whatsapp fa-1x "></i>
                                </a>
                                </td>
                                <td><?= $pedido->consecutivo; ?></td>
                                <td><label class="badge badge-success text-uppercase"><?= $pedido->tppago; ?></label></td>
                                <td><?= $pedido->total; ?></td>
                                <td>SI</td>
                                <td><?= $pedido->fecha; ?></td>
                                <td><?= $pedido->hora; ?></td>
                                <td><label class="badge badge-primary text-uppercase"><?= $pedido->estado; ?></label></td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
              </div>
              <div class="col-md-3">
                <div class="card">
                  <div class="card-body">
                    <div id="contenidotiemporeal">
                      
                      <!--  -->
                      
                    <!--  -->
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
  <?php require_once("componentes/footer.php")?>
<!-- MODAL VER PEDIDO  -->
 <div class="modal fade" id="verpedido" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header color-morado">
        <h5 class="modal-title text-uppercase text-white" id="exampleModalLabel">Detalle del pedido</h5>
        <!-- <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>  -->
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group input-group-sm">
            <label>Codigo pedido</label>
            <input
                type="text"
                class="form-control"
                id="codigo_pedido"
                readonly
              >
            </div>
          </div>
          <div class="col-md-5">
            <div class="form-group">
              <label>Sede</label>
              <select 
                class="form-control form-control-sm"
                id="sede_pedido"
                readonly
              >
                <option value="SEDE PRINCIPAL (BARRIO AMBALA)">SEDE PRINCIPAL (BARRIO AMBALA)</option>
              </select>
            </div>              
          </div>
          <div class="col-md-2">
            <div class="form-group input-group-sm">
              <label>Fecha</label>
              <input
                type="date"
                class="form-control"
                id="fecha_pedido"
                readonly
              >
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group input-group-sm">
              <label>Hora</label>
              <input
                type="text"
                class="form-control"
                id="hora_pedido"
                readonly
              >
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="form-group input-group-sm">
              <label>Tipo pago</label>
              <select 
                class="form-control form-control-sm"
                id="tppago_pedido"
                readonly
              >
                <option value="NEQUI">NEQUI</option>
                <option value="BANCARIA">BANCARIA</option>
                <option value="CONTRAENTREGA">CONTRAENTREGA</option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group input-group-sm">
              <label>Celular cliente</label>
              <input
                type="number"
                class="form-control"
                id="celular_pedido"
                readonly
              >
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group input-group-sm">
              <label>Total pedido</label>
              <input
                type="text"
                class="form-control"
                id="total_pedido"
                readonly
              >
            </div>
          </div>
          <div class="col-md-2 mt-4">            
            <div class="form-check">
              <input class="form-check-input mt-1" type="checkbox"  id="porpagar">
              <label >
                Cuentas por cobrar
              </label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group input-group-sm">
              <label>Nombre</label>
              <input
                type="text"
                class="form-control"
                id="nombre_pedido"
                readonly
              >
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group input-group-sm">
              <label>Dirección</label>
              <input
                type="text"
                class="form-control"
                id="direccion_pedido"
                readonly
              >
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group input-group-sm">
              <label>Domicilio</label>
              <input
                type="text"
                class="form-control"
                id="domicilio_pedido"
              >
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label>Estado</label>
              <select 
                class="form-control form-control-sm"
                id="estado_pedido"
              >
                <option value="PEDIDO">PEDIDO</option>
                <option value="PREPARACION">PREPARACION</option>
                <option value="EN CAMINO">EN CAMINO</option>
                <option value="CANCELADO">CANCELADO</option>
                <option value="ELIMINAR">ELIMINAR</option>

              </select>
            </div>              
          </div>
        </div>
        <div class="form-group input-group-sm">
            <label>Comentarios</label>
            <textarea
              class="form-control"
              id="comentarios_pedido"
              readonly
            ></textarea>
        </div>
        <div class="row">
          <div class="table-responsive">
            <table class="table table-striped" >
              <thead>
                <tr>
                  <th class="text-uppercase text-xs font-weight-bolder text-white color-morado">#</th>
                  <th class="text-uppercase text-xs font-weight-bolder text-white color-morado">Pedido</th>
                  <th class="text-uppercase text-xs font-weight-bolder text-white color-morado">Producto</th>
                  <th class="text-uppercase text-xs font-weight-bolder text-white color-morado">Cantidad</th>
                </tr>
              </thead>
              <tbody class="detalle_productos_pedido">
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button
          type="button"
          class="btn btn-primary text-white btn-rounded"
          data-bs-dismiss="modal"
        >
          Cancelar
        </button>
        <button
          type="button"
          class="btn btn-dark text-white btn-rounded"
          id="Actualizarpedido"
        >
          Actualizar
        </button>
      </div>
    </div>
  </div>
</div>

<?php require_once("componentes/scripts.php")?>
<script src="<?= base_url('js/pedidos.js') ?>"></script>
</body>
</html>
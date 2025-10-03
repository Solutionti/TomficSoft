<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion - Inventarios</title>
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
                <button class="btn btn-primary mb-2 mb-md-0 me-2 btn-rounded" data-bs-toggle="modal" data-bs-target="#agregarProducto">Agregar Producto</button>
                <button class="btn btn-outline-success mb-2 mb-md-0 me-2 btn-rounded" data-bs-toggle="modal" data-bs-target="#ingresoProducto">Entrada</button>
                <button class="btn btn-outline-danger mb-2 mb-md-0 me-2 btn-rounded" data-bs-toggle="modal" data-bs-target="#salidaProducto">Salida</button>
              </div>
              <div class="header-right d-flex flex-wrap mt-2 mt-sm-0">
                <div class="d-flex align-items-center">
                  <a href="#">
                    <p class="m-0 pe-3">ADMINISTRACIÒN</p>
                  </a>
                  <a class="ps-3 me-4" href="#">
                    <p class="m-0">INV - INVENTARIOS</p>
                  </a>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <!-- aca va el contenido  -->
                 <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">

                    <table class="table table-striped table-borderless" id="tabla_inventarios">
                        <thead >
                          <tr >
                            <th class="color-morado text-white text-uppercase"> </th>
                            <th class="color-morado text-white text-uppercase"> codigo de barras </th>
                            <th class="color-morado text-white text-uppercase"> nombre </th>
                            <th class="color-morado text-white text-uppercase"> proveedor </th>
                            <th class="color-morado text-white text-uppercase"> Categoria </th>
                            <th class="color-morado text-white text-uppercase"> sub categoria </th>
                            <th class="color-morado text-white text-uppercase"> valor </th>
                          </tr>
                        </thead>
                        <tbody>

                        <?php foreach($productos->getResult() as $producto) { ?>
                          <tr>
                            <td>
                              <button
                                class="badge badge-danger"
                                onclick="eliminarProducto(<?= $producto->codigo_barras; ?>)"
                              >
                                <i class="fas fa-trash fa-1x "></i>
                              </button>
                              <button
                                class="badge badge-primary"
                              >
                                <i class="fas fa-edit fa-1x "></i>
                              </button>
                            </td>
                            <td><?= $producto->codigo_barras; ?></td>
                            <td><?= $producto->nombre; ?></td>
                            <td><?= $producto->proveedor; ?></td>
                            <td><?= $producto->categoria; ?></td>
                            <td><?= $producto->subcategoria; ?></td>
                            <td><?= $producto->costo; ?></td>
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
        </div>
    </div>
    <?php require_once("componentes/footer.php")?>
</div>

<!-- MODAL PARA AGREGAR PRODUCTO -->
<div class="modal fade" id="agregarProducto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="agregarProductoLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header color-morado">
        <h1 class="modal-title fs-5  text-white" id="agregarProductoLabel">AGREGAR PRODUCTO</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mt-3">
          <div class="col-md-3">
            <label class="mb-1 small ">Categoria *</label>
            <select
              class="form-control form-control-sm borde text-uppercase"
              id="categoria_inventario"
              required
            >
            <option value="">Seleccione una categoria</option>
            <?php foreach($categorias->getResult() as $categoria) { ?>
              <option value="<?= $categoria->codigo_categoria  ?>"><?= $categoria->nombre; ?></option>  
            <?php } ?>    
            </select>
          </div>
          <div class="col-md-3">
            <label class="mb-1 small ">Sub categoria *</label>
            <input 
              type="text"
              id="subcategoria_inventario"
              name="subcategoria_inventario"
              class="form-control form-control-sm borde"
              required
            >
          </div>
          <div class="col-md-3">
            <label class="mb-1 small ">Grupo *</label>
            <input 
              type="text"
              id="grupo_inventario"
              name="grupo_inventario"
              class="form-control form-control-sm borde"
              required
            >
          </div>
          <div class="col-md-3">
            <label class="mb-1 small ">Sub grupo *</label>
            <input 
              type="text"
              id="subgrupo_inventario"
              name="subgrupo_inventario"
              class="form-control form-control-sm borde"
              required
            >
          </div>
      </div>

        <div class="row mt-3">
          <div class="col-md-3">
            <label class="mb-1 small ">Nombre *</label>
            <input 
              type="text"
              id="nombre_inventario"
              name="nombre_inventario"
              class="form-control form-control-sm borde"
              required
            >
          </div>
          <div class="col-md-3">
            <label class="mb-1 small ">Referencia *</label>
            <input 
              type="text"
              id="referencia_inventario"
              name="referencia_inventario"
              class="form-control form-control-sm borde"
              required
            >
          </div>
          <div class="col-md-3">
            <label class="mb-1 small ">Codigo interno *</label>
              <input
                class="form-control form-control-sm borde text-uppercase"
                id="codigo_inventario"
                name="codigo_inventario"
                type="number"
                required
              >
              </input>
          </div>
            <div class="col-md-3">
              <label class="mb-1 small ">Codigo de barras *</label>
                <input 
                  type="number"
                  id="barras_inventario"
                  name="barras_inventario"
                  class="form-control form-control-sm borde"
                >
            </div>
            
        </div>
        <div class="row mt-3">
          <div class="col-md-2">
              <label class="mb-1 small ">Nit *</label>
                <input 
                  type="number"
                  id="nit_inventario"
                  name="nit_inventario"
                  class="form-control form-control-sm borde"
                >
            </div>
          <div class="col-md-3">
            <label class="mb-1 small ">Proveedor *</label>
            <input 
              type="text"
              id="proveedor_inventario"
              name="proveedor_inventario"
              class="form-control form-control-sm borde"
              required>
          </div>
          <div class="col-md-2">
            <label class="mb-1 small ">Saldo </label>
            <input 
              type="number"
              id="saldo_inventario"
              name="saldo_inventario"
              class="form-control form-control-sm borde"
            >
          </div>
          <div class="col-md-2">
            <label class="mb-1 small ">Costo </label>
            <input 
              type="number"
              id="costo_inventario"
              name="costo_inventario"
              class="form-control form-control-sm borde"
            > 
          </div>
        </div>
        
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-rounded" data-bs-dismiss="modal" onclick="agregarProductos()">Guardar</button>
        </div>
    </div>
  </div>
</div>

<!-- MODAL INGRESO PRODUCTO -->
<div class="modal fade" id="ingresoProducto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ingresoProductoLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header color-morado">
        <h1 class="modal-title fs-5  text-white" id="ingresoProductoLabel">INGRESO DE PRODUCTOS</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<!-- ACA VA EL CONTENIDO DE LA MODAL-->
        <div class="row mt-3">
          <div class="col-md-5">
            <label class="mb-1 small ">Producto *</label>
            <input 
              type="text" 
              class="form-control form-control-sm borde" 
              id="producto_ingreso" 
              name="producto_ingreso" 
              required>
          </div>
          <div class="col-md-2">
            <label class="mb-1 small ">Cantidad *</label>
            <input 
              type="number" 
              class="form-control form-control-sm borde" 
              id="cantidad_ingreso" 
              name="cantidad_ingreso" 
              required>
        </div>
          <div class="col-md-3">
            <label class="mb-1 small ">Precio producto *</label>
            <input 
              type="number" 
              class="form-control form-control-sm borde" 
              id="precio_ingreso" 
              name="precio_ingreso" 
              required
            >
          </div>
          <div class="col-md-2">
            <label class="mb-1 small ">Stock *</label>
            <input 
              type="number" 
              class="form-control form-control-sm borde" 
              id="stock_ingreso" 
              name="stock_ingreso" 
              required
            >
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-8">
            <label class="mb-1 small ">Nombre producto</label>
            <input 
              type="text" 
              class="form-control form-control-sm borde" 
              id="nombre_ingreso" 
              name="nombre_ingreso"
            >
          </div>
          <div class="col-md-4">
            <label class="mb-1 small ">Valor compra</label>
            <input type="number" 
              class="form-control form-control-sm borde" 
              id="valor_ingreso" 
              name="valor_ingreso"
            >
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-6">
            <label class="mb-1 small ">Sede principal</label>
            <select 
              name="sede_ingreso" 
              id="sede_ingreso" 
              class="form-control form-control-sm borde text-uppercase" 
              required
            >
              <option value="">Seleccione sede</option>
              <option value="">1</option>
              <option value="">2</option>
              <option value="">3</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="mb-1 small ">Motivo de ingreso</label>
            <select 
              name="motivo_ingreso" 
              id="motivo_ingreso" 
              class="form-control form-control-sm borde text-uppercase"
              >
              <option value="">Seleccione el motivo de ingreso</option>
              <option value="">1</option>
              <option value="">2</option>
              <option value="">3</option>
            </select>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-12">
            <label class="mb-1 small ">Comentarios </label>
            <textarea 
              class="form-control form-control-sm borde" 
              placeholder="Descripcion" 
              id="floatingTextarea2 comentarios_ingreso" 
              style="height: 100px"
            ></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-rounded" data-bs-dismiss="modal">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL SALIDA PRODUCTO -->
<div class="modal fade" id="salidaProducto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="salidaProductoLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header color-morado">
        <h1 class="modal-title fs-5  text-white" id="salidaProductoLabel">SALIDA DE PRODUCTOS</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<!-- ACA VA EL CONTENIDO DE LA MODAL-->
        <div class="row mt-3">
          <div class="col-md-5">
            <label class="mb-1 small ">Producto *</label>
            <input 
              type="text" 
              class="form-control form-control-sm borde" 
              id="producto_salida" 
              name="producto_salida" 
              required>
          </div>
          <div class="col-md-2">
            <label class="mb-1 small ">Cantidad *</label>
            <input 
              type="number" 
              class="form-control form-control-sm borde" 
              id="cantidad_salida" 
              name="cantidad_salida" 
              required>
        </div>
          <div class="col-md-3">
            <label class="mb-1 small ">Precio producto *</label>
            <input 
              type="number" 
              class="form-control form-control-sm borde" 
              id="precio_salida" 
              name="precio_salida" 
              required
            >
          </div>
          <div class="col-md-2">
            <label class="mb-1 small ">Stock *</label>
            <input 
              type="number" 
              class="form-control form-control-sm borde" 
              id="stock_salida" 
              name="stock_salida" 
              required
            >
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-8">
            <label class="mb-1 small ">Nombre producto</label>
            <input 
              type="text" 
              class="form-control form-control-sm borde" 
              id="nombre_salida" 
              name="nombre_salida"
            >
          </div>
          <div class="col-md-4">
            <label class="mb-1 small ">Valor compra</label>
            <input type="number" 
              class="form-control form-control-sm borde" 
              id="valor_salida" 
              name="valor_salida"
            >
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-6">
            <label class="mb-1 small ">Sede principal</label>
            <select 
              name="sede_salida" 
              id="sede_salida" 
              class="form-control form-control-sm borde text-uppercase" 
              required
            >
              <option value="">Seleccione sede</option>
              <option value="">1</option>
              <option value="">2</option>
              <option value="">3</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="mb-1 small ">Motivo de salida</label>
            <select 
              name="motivo_salida" 
              id="motivo_salida" 
              class="form-control form-control-sm borde text-uppercase"
              >
              <option value="">Seleccione el motivo de salida</option>
              <option value="">1</option>
              <option value="">2</option>
              <option value="">3</option>
            </select>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-12">
            <label class="mb-1 small ">Comentarios </label>
            <textarea 
              class="form-control form-control-sm borde" 
              placeholder="Descripcion" 
              id="floatingTextarea2 comentarios_salida" 
              style="height: 100px"
            ></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-rounded" data-bs-dismiss="modal">Guardar</button>
      </div>
    </div>
  </div>
</div>

<?php require_once("componentes/scripts.php")?>
<script src="<?= base_url('js/inventarios.js') ?>"></script>
</body>
</html>
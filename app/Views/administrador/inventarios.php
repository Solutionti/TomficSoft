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
                <button class="btn btn-primary mb-2 mb-md-0 me-2" data-bs-toggle="modal" data-bs-target="#agregarProducto">Agregar Producto</button>
                <button class="btn btn-outline-primary bg-white mb-2 mb-md-0 me-2">Consulta</button>
                <button class="btn btn-success mb-2 mb-md-0 me-2">Entrada</button>
                <button class="btn btn-danger mb-2 mb-md-0 me-2">Salida</button>
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
                    <table class="table table-striped">
                        <thead >
                          <tr >
                            <th class="color-morado text-white text-uppercase"> </th>
                            <th class="color-morado text-white text-uppercase"> opciones</th>
                            <th class="color-morado text-white text-uppercase"> imagen</th>
                            <th class="color-morado text-white text-uppercase"> Codigo </th>
                            <th class="color-morado text-white text-uppercase"> Nombre </th>
                            <th class="color-morado text-white text-uppercase"> Categoria </th>
                            <th class="color-morado text-white text-uppercase"> Valor </th>
                            <th class="color-morado text-white text-uppercase"> Stock </th>
                          </tr>
                        </thead>
                        <tbody>
                          
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
          <div class="col-md-4">
            <label class="mb-1 small ">Categoria *</label>
            <select
              class="form-control form-control-sm borde text-uppercase"
              id="categoria_inventario"
              required
            >
              <option value="">Seleccione una categoria</option>
              <option value="">1</option>
              <option value="">2</option>
              <option value="">3</option>
                
            </select>
          </div>
          <div class="col-md-4">
            <label class="mb-1 small ">Nombre *</label>
            <input 
              type="text"
              id="nombre_inventario"
              name="nombre_inventario"
              class="form-control form-control-sm borde"
              required
            >
          </div>
          <div class="col-md-2">
            <label class="mb-1 small ">Codigo *</label>
            <input 
              type="number"
              id="codigo_inventario"
              name="codigo_inventario"
              class="form-control form-control-sm borde"
              required
            >
          </div>
          <div class="col-md-2">
            <label class="mb-1 small ">Codigo de barras *</label>
            <input 
              type="text"
              id="barras_inventario"
              name="barras_inventario"
              class="form-control form-control-sm borde"
              required
            >
          </div>
      </div>

        <div class="row mt-3">
          <div class="col-md-3">
            <label class="mb-1 small ">Unidad medida *</label>
            <select
              class="form-control form-control-sm borde text-uppercase"
              id="unidad_inventario"
              required
            >
              <option value="">Seleccione unidad</option>
              <option value="">1</option>
              <option value="">2</option>
              <option value="">3</option>
                
            </select>
          </div>
          <div class="col-md-3">
            <label class="mb-1 small ">Merma *</label>
            <input 
              type="text"
              id="merma_inventario"
              name="merma_inventario"
              class="form-control form-control-sm borde"
              required
            >
          </div>
          <div class="col-md-2">
            <label class="mb-1 small ">Cantidad *</label>
              <input
                class="form-control form-control-sm borde text-uppercase"
                id="cantidad_inventario"
                name="cantidad_inventario"
                type="number"
                required
              >
              </input>
          </div>
            <div class="col-md-2">
              <label class="mb-1 small ">Precio de venta *</label>
                <input 
                  type="number"
                  id="precio_inventario"
                  name="precio_inventario"
                  class="form-control form-control-sm borde"
                >
            </div>
            <div class="col-md-2">
              <label class="mb-1 small ">Moneda *</label>
                <select
              class="form-control form-control-sm borde text-uppercase"
              id="moneda_inventario"
              required
            >
              <option value="">Seleccione Moneda</option>
              <option value="">1</option>
              <option value="">2</option>
              <option value="">3</option>
                
            </select>
            </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-4">
            <label class="mb-1 small ">Precio proveedor *</label>
            <input 
              type="number"
              id="proveedor_inventario"
              name="proveedor_inventario"
              class="form-control form-control-sm borde"
              required>
          </div>
          <div class="col-md-5">
            <label class="mb-1 small ">Imagen </label>
            <input 
              type="file"
              id="imagen_inventario"
              name="imagen_inventario"
              class="form-control form-control-sm borde"
            >
          </div>
          <div class="col-md-3">
            <div class="form-check form-switch">
              <br>
              <input class="form-check-input mx-2 " type="checkbox" role="switch" id="switchCheckChecked venta_inventario" checked>
              <label class="form-check-label " for="switchCheckChecked">Producto de venta</label>
            </div> 
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-12">
            <label class="mb-1 small ">Descripcion *</label>
            <textarea class="form-control form-control-sm borde" placeholder="Descripcion" id="floatingTextarea2" style="height: 100px"></textarea>
          </div>
          </div>
        </div>
<?php require_once("componentes/scripts.php")?>
</body>
</html>
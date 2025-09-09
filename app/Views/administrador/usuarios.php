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
                <button class="btn btn-primary mb-2 mb-md-0 me-2 btn-rounded" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Agregar Usuarios</button>
                <!-- <button class="btn btn-outline-primary bg-white mb-2 mb-md-0">Exportar base de datos</button> -->
              </div>
              <div class="header-right d-flex flex-wrap mt-2 mt-sm-0">
                <div class="d-flex align-items-center">
                  <a href="#">
                    <p class="m-0 pe-3">ADMINISTRACIÒN</p>
                  </a>
                  <a class="ps-3 me-4" href="#">
                    <p class="m-0">INV - USUARIOS</p>
                  </a>
                </div>
              </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead >
                          <tr >
                            <th class="color-morado text-white text-uppercase"> </th>
                            <th class="color-morado text-white text-uppercase"> Codigo</th>
                            <th class="color-morado text-white text-uppercase"> Nombre completo </th>
                            <th class="color-morado text-white text-uppercase"> Empresa </th>
                            <th class="color-morado text-white text-uppercase"> Email </th>
                            <th class="color-morado text-white text-uppercase"> Telefono </th>
                            <th class="color-morado text-white text-uppercase"> Rol </th>
                            <th class="color-morado text-white text-uppercase"> Estado </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach($usuarios->getResult() as $usuario) { ?>
                          <tr>
                            <td>
                              <button
                                class="badge badge-danger"
                                onclick="eliminarUsuario('<?= $usuario->codigo_usuario; ?>')"
                              >
                                <i class="fas fa-trash fa-1x "></i>
                              </button>
                              <button
                                class="badge badge-primary"
                                onclick="mostrarDatosUsuarioModal(<?= $usuario->codigo_usuario; ?>)"
                              >
                                <i class="fas fa-edit fa-1x "></i>
                              </button>
                            </td>
                            <td><?= $usuario->codigo_usuario; ?></td>
                            <td>
                              <div class="row">
                               <div class="d-flex px-2 py-1">
                                 <div>
                                    <img src="<?= base_url('img/team-41.jpg') ?>" class="avatar avatar-sm me-3">
                                 </div>
                                 <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-xs"><?= $usuario->nombre.' '.$usuario->apellido; ?></h6>
                                    <p class="text-xs text-dark mb-0"><?= $usuario->documento.' - '.$usuario->usuario; ?></p>
                                 </div>
                              </div>
                              </div>
                            </td>
                            <td><?= $usuario->empresa; ?></td>
                            <td><?= $usuario->email; ?></td>
                            <td><?= $usuario->telefono; ?></td>
                            <td><label class="badge badge-primary"><?= $usuario->rol_usuario; ?></label></td>
                            <td><label class="badge badge-success"><?= $usuario->estado; ?></label></td>
                          </tr>
                          <!-- <tr>
                            <td></td>
                            <td>02</td>
                            <td>
                              <div class="row">
                               <div class="d-flex px-2 py-1">
                                 <div>
                                    <img src="https://themewagon.github.io/plus-admin/assets/images/faces-clipart/pic-2.png" class="avatar avatar-sm me-3">
                                 </div>
                                 <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-xs">Mabel Andrea Guerra</h6>
                                    <p class="text-xs text-dark mb-0">56868539</p>
                                 </div>
                              </div>
                              </div>
                            </td>
                            <td>GO Future</td>
                            <td>jerson_galvez@hotmail.com</td>
                            <td><label class="badge badge-primary ">Capturador</label></td>
                            <td><label class="badge badge-success ">Activo</label></td>
                          </tr> -->
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
    <!--  -->
    <?php require_once("componentes/footer.php")?>
</div>

<!-- MODAL PARA CREAR EL FORMULARIO -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header color-morado">
        <h1 class="modal-title fs-5  text-white" id="staticBackdropLabel">CREAR USUARIOS Y PERMISOS DE USUARIO</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mt-3">
          <div class="col-md-4">
            <label class="mb-1 small ">Documento *</label>
            <input 
              type="number"
              id="documento_usuario"
              name="documento_usuario"
              class="form-control form-control-sm borde"
              required
            >
          </div>
          <div class="col-md-4">
            <label class="mb-1 small ">Nombre *</label>
            <input 
              type="text"
              id="nombre_usuario"
              name="nombre_usuario"
              class="form-control form-control-sm borde"
              required
            >
          </div>
          <div class="col-md-4">
            <label class="mb-1 small ">Apellido *</label>
            <input 
              type="text"
              id="apellido_usuario"
              name="apellido_usuario"
              class="form-control form-control-sm borde"
              required
            >
          </div>
      </div>

        <div class="row mt-3">
          <div class="col-md-4">
            <label class="mb-1 small ">Empresa *</label>
            <select
                class="form-control form-control-sm borde text-uppercase"
                id="empresa_usuario"
                required
              >
                <option value="">Seleccione la empresa</option>
                <?php foreach($empresas->getResult() as $empresa) {  ?>
                  <option value="<?= $empresa->nit ?>"><?= $empresa->nombre; ?></option>
                <?php } ?>
               </select>
          </div>
          <div class="col-md-4">
            <label class="mb-1 small ">Telefono *</label>
            <input 
              type="number"
              id="telefono_usuario"
              name="telefono_usuario"
              class="form-control form-control-sm borde"
              required
            >
          </div>
          <div class="col-md-4">
            <label class="mb-1 small ">Estado *</label>
              <select
                class="form-control form-control-sm borde text-uppercase"
                id="estado_usuario"
                required
              >
                <option value="">Seleccione el estado del usuario</option>
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>    
               </select>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-12">
            <label class="mb-1 small ">Correo Electronico *</label>
              <input 
                type="email"
                id="correo"
                name="correo"
                class="form-control form-control-sm borde"
              >
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-4">
            <label class="mb-1 small ">Rol *</label>
            <select
                class="form-control form-control-sm borde text-uppercase"
                id="rol_usuario"
              >
                <option value="">Seleccione el rol del usuario</option>
                <option value="Administrador">Administrador</option>
                <option value="Capturador">Auxiliar Capturador</option>    
               </select>
          </div>
          <div class="col-md-4">
            <label class="mb-1 small ">Fecha</label>
            <input 
              type="date"
              id="fecha_usuario"
              name="fecha_usuario"
              class="form-control form-control-sm borde"
              value="<?php echo date('Y-m-d') ?>"
              readonly
            >
          </div>
          <div class="col-md-4">
            <label class="mb-1 small ">Hora</label>
            <input 
              type="time"
              id="hora_usuario"
              name="hora_usuario"
              class="form-control form-control-sm borde"
              value="<?= date('H:i') ?>"
              readonly
            >
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-4">
            <label class="mb-1 small ">Usuario *</label>
            <input 
              type="text"
              id="usuario_usuario"
              name="usuario_usuario"
              class="form-control form-control-sm borde"
            >
          </div>
          <div class="col-md-4">
            <div class="d-flex justify-content-between align-items-center">
                  <label class="form-label" for="signupModalFormLoginPassword">Contraseña *</label>
                </div>
                <div class="input-group">
                  <input
                    type="password"
                    class="js-toggle-password form-control form-control-sm borde"
                    placeholder="Contraseña"
                    id="password_usuario"
                  >
                  <a
                    class="input-group-append input-group-text"
                  >
                    <i id="changePassIcon" class="fas fa-eye text-primary"></i>
                  </a>
                </div>
          </div>
          <div class="col-md-4">
             <div class="d-flex justify-content-between align-items-center">
                  <label class="form-label" for="signupModalFormLoginPassword">Repetir Contraseña *</label>
                </div>
                <div class="input-group">
                  <input
                    type="password"
                    class="js-toggle-password form-control form-control-sm borde"
                    placeholder="Contraseña"
                    id="repetir_password_usuario"
                  >
                </div>
          </div>
        </div>
        <div class="row mt-3">
          <h5>PERMISOS DE USUARIO</h5>

          <div class="col-md-12 mt-2">
            <table class="table table-striped">
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
                  <th class="color-morado text-white text-uppercase"> Nombre </th>
                  <th class="color-morado text-white text-uppercase"> link </th>
                  <th class="color-morado text-white text-uppercase"> Estado </th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($permisos->getResult() as $permiso){ ?>
                <tr>
                  <td>
                    <div class="form-check">
                      <input
                        class="form-check-input mx-3 borde fila"
                        type="checkbox"
                        value="<?= $permiso->codigo_permiso; ?>"
                      >
                    </div>
                  </td>
                  <td><?= $permiso->codigo_permiso;  ?></td>
                  <td>
                    <div class="row">
                      <div class="d-flex px-2 py-1">
                        <div>
                          <img src="<?= base_url('img/team-41.jpg') ?>" class="avatar avatar-sm me-3">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-xs">Modulo de <?= $permiso->nombre;  ?></h6>
                          <p class="text-xs text-dark mb-0">Permiso de usuario</p>
                        </div>
                      </div>
                    </div>
                   </td>
                   <td><?= $permiso->url;  ?></td>
                   <td><label class="badge badge-success"><?= $permiso->estado;  ?></label></td>
                </tr>
              <?php }?>
             </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-rounded" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary btn-rounded"  onclick=" crearUsuarios()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- MODAL PARA ACTUALIZAR EL FORMULARIO -->
<div class="modal fade" id="actualizarUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="actualizarUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header color-morado">
        <h1 class="modal-title fs-5  text-white" id="actualizarUsuarioLabel">ACTUALIZAR USUARIOS Y PERMISOS DE USUARIO</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mt-3">
          <div class="col-md-4">
            <label class="mb-1 small ">Documento *</label>
            <input 
              type="number"
              id="documento_usuario_actualizar"
              name="documento_usuario_actualizar"
              class="form-control form-control-sm borde"
              required
            >
          </div>
          <div class="col-md-4">
            <label class="mb-1 small ">Nombre *</label>
            <input 
              type="text"
              id="nombre_usuario_actualizar"
              name="nombre_usuario_actualizar"
              class="form-control form-control-sm borde"
              required
            >
          </div>
          <div class="col-md-4">
            <label class="mb-1 small ">Apellido *</label>
            <input 
              type="text"
              id="apellido_usuario_actualizar"
              name="apellido_usuario_actualizar"
              class="form-control form-control-sm borde"
              required
            >
          </div>
      </div>

        <div class="row mt-3">
          <div class="col-md-4">
            <label class="mb-1 small ">Empresa *</label>
            <select
                class="form-control form-control-sm borde text-uppercase"
                id="empresa_usuario_actualizar"
                required
              >
                <option value="">Seleccione la empresa</option>
                <?php foreach($empresas->getResult() as $empresa) {  ?>
                  <option value="<?= $empresa->nit ?>"><?= $empresa->nombre; ?></option>
                <?php } ?>
               </select>
          </div>
          <div class="col-md-4">
            <label class="mb-1 small ">Telefono *</label>
            <input 
              type="number"
              id="telefono_usuario_actualizar"
              name="telefono_usuario"
              class="form-control form-control-sm borde"
              required
            >
          </div>
          <div class="col-md-4">
            <label class="mb-1 small ">Estado *</label>
              <select
                class="form-control form-control-sm borde text-uppercase"
                id="estado_usuario_actualizar"
                required
              >
                <option value="">Seleccione el estado del usuario</option>
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>    
               </select>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-12">
            <label class="mb-1 small ">Correo Electronico *</label>
              <input 
                type="email"
                id="correo_actualizar"
                name="correo"
                class="form-control form-control-sm borde"
              >
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-4">
            <label class="mb-1 small ">Rol *</label>
            <select
                class="form-control form-control-sm borde text-uppercase"
                id="rol_usuario_actualizar"
              >
                <option value="">Seleccione el rol del usuario</option>
                <option value="Administrador">Administrador</option>
                <option value="Capturador">Auxiliar Capturador</option>    
               </select>
          </div>
          <div class="col-md-4">
            <label class="mb-1 small ">Fecha</label>
            <input 
              type="date"
              id="fecha_usuario_actualizar"
              name="fecha_usuario"
              class="form-control form-control-sm borde"
              value="<?php echo date('Y-m-d') ?>"
              readonly
            >
          </div>
          <div class="col-md-4">
            <label class="mb-1 small ">Hora</label>
            <input 
              type="time"
              id="hora_usuario_actualizar"
              name="hora_usuario"
              class="form-control form-control-sm borde"
              value="<?= date('H:i') ?>"
              readonly
            >
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-4">
            <label class="mb-1 small ">Usuario *</label>
            <input 
              type="text"
              id="usuario_usuario_actualizar"
              name="usuario_usuario"
              class="form-control form-control-sm borde"
            >
          </div>
          <div class="col-md-4">
            <div class="d-flex justify-content-between align-items-center">
                  <label class="form-label" for="signupModalFormLoginPassword">Contraseña *</label>
                </div>
                <div class="input-group">
                  <input
                    type="password"
                    class="js-toggle-password form-control form-control-sm borde"
                    placeholder="Contraseña"
                    id="password_usuario_actualizar"
                  >
                  <a
                    class="input-group-append input-group-text"
                  >
                    <i id="changePassIcon" class="fas fa-eye text-primary"></i>
                  </a>
                </div>
          </div>
          <div class="col-md-4">
             <div class="d-flex justify-content-between align-items-center">
                  <label class="form-label" for="signupModalFormLoginPassword">Repetir Contraseña *</label>
                </div>
                <div class="input-group">
                  <input
                    type="password"
                    class="js-toggle-password form-control form-control-sm borde"
                    placeholder="Contraseña"
                    id="repetir_password_usuario_actualizar"
                  >
                </div>
          </div>
        </div>
        <div class="row mt-3">
          <h5>PERMISOS DE USUARIO</h5>

          <div class="col-md-12 mt-2">
            <table class="table table-striped">
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
                  <th class="color-morado text-white text-uppercase"> Nombre </th>
                  <th class="color-morado text-white text-uppercase"> link </th>
                  <th class="color-morado text-white text-uppercase"> Estado </th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($permisos->getResult() as $permiso){ ?>
                <tr>
                  <td>
                    <div class="form-check">
                      <input
                        class="form-check-input mx-3 borde fila"
                        type="checkbox"
                        value="<?= $permiso->codigo_permiso; ?>"
                      >
                    </div>
                  </td>
                  <td><?= $permiso->codigo_permiso;  ?></td>
                  <td>
                    <div class="row">
                      <div class="d-flex px-2 py-1">
                        <div>
                          <img src="<?= base_url('img/team-41.jpg') ?>" class="avatar avatar-sm me-3">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-xs">Modulo de <?= $permiso->nombre;  ?></h6>
                          <p class="text-xs text-dark mb-0">Permiso de usuario</p>
                        </div>
                      </div>
                    </div>
                   </td>
                   <td><?= $permiso->url;  ?></td>
                   <td><label class="badge badge-success"><?= $permiso->estado;  ?></label></td>
                </tr>
              <?php }?>
             </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-rounded" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary btn-rounded"  onclick=" crearUsuarios()">Guardar</button>
      </div>
    </div>
  </div>
</div>

<?php require_once("componentes/scripts.php")?>
<script src="<?= base_url('js/usuarios.js') ?>"></script>
</body>
</html>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile border-bottom">
            <a href="#" class="nav-link flex-column">
              <div class="nav-profile-image">
                <img src="<?= base_url('img/team-41.jpg') ?>" alt="profile">
              </div>
              <div class="nav-profile-text d-flex ms-0 mb-3 flex-column">
                <span class="fw-semibold mb-1 small mt-2 text-center text-capitalize"><?php echo session()->get('nombre'). ' ' .session()->get('apellido') ?></span>
                <span class="text-secondary icon-sm text-center"> <i class="fas fa-circle text-success"></i> <?php echo session()->get('descripcion_rol');?> </span>
              </div>
            </a>
          </li>
          <li class="nav-item pt-3">
            <!-- <a class="nav-link d-block" href="#">
              <img class="sidebar-brand-logo" src="https://themewagon.github.io/plus-admin/assets/images/logo.svg" alt="">
              <div class="small fw-light pt-1">Panel responsivo </div>
            </a> -->
            <br>
            <form class="d-flex align-items-center" action="#">
              <div class="input-group">
                <div class="input-group-prepend">
                  <i class="input-group-text border-0 mdi mdi-magnify"></i>
                </div>
                <input type="text" class="form-control border-0" placeholder="Buscar">
              </div>
            </form>
          </li>
          <li class="pt-2 pb-1">
            <span class="nav-item-head">Inventarios</span>
          </li>
          <?php foreach($permisoUsuario->getResult() as $permiso) { ?>
           <li class="nav-item">
             <a class="nav-link" href="<?= base_url($permiso->url) ?>">
              <span class="menu-title"> <i class="<?=  $permiso->icono; ?> text-morado"></i> <?=  $permiso->nombre; ?> </span>
             </a>
           </li>
          <?php } ?>
          
          <li class="pt-2 pb-1">
            <span class="nav-item-head">Ventas</span>
          </li>
          <li class="nav-item pt-1">
            <a class="nav-link" href="<?= base_url('inventarios') ?>">
              <span class="menu-title"> <i class="fas fa-truck-moving text-morado"></i> Kardex</span>
            </a>
          </li>
          <li class="nav-item pt-1">
            <a class="nav-link" href="<?= base_url('ventas') ?>" target="_blank">
              <span class="menu-title"><i class="fas fa-cash-register text-morado"></i> Ventas</span>
            </a>
          </li>
          
          <li class="nav-item pt-1">
            <a class="nav-link" href="<?= base_url('pedidos') ?>">
              
              <span class="menu-title"><i class="fas fa-motorcycle text-morado"></i> Pedidos</span>
            </a>
          </li>
          <li class="nav-item pt-1">
            <a class="nav-link" href="http://localhost/CODEIGNITER/InventSoft/ecommerce/inicio" target="_blank">
              <span class="menu-title"><i class="fas fa-shopping-cart text-morado"></i> Ecommerce</span>
            </a>
          </li>
        </ul>
      </nav>
      
      
<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile border-bottom">
            <a href="#" class="nav-link flex-column">
              <div class="nav-profile-image">
                <img src="<?= base_url('img/team-41.jpg') ?>" alt="profile">
              </div>
              <div class="nav-profile-text d-flex ms-0 mb-3 flex-column">
                <span class="fw-semibold mb-1 small mt-2 text-center text-capitalize"><?php echo session()->get('nombre'). ' ' .session()->get('apellido') ?></span>
                <span class="text-secondary icon-sm text-center"> <i class="fas fa-circle text-success"></i> Experto en inventarios</span>
              </div>
            </a>
          </li>
          <li class="nav-item pt-3">
            <a class="nav-link d-block" href="#">
              <img class="sidebar-brand-logo" src="https://themewagon.github.io/plus-admin/assets/images/logo.svg" alt="">
              <!-- <div class="small fw-light pt-1">Panel responsivo </div> -->
            </a>
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
            <span class="nav-item-head">General</span>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('inicio') ?>">
              <span class="menu-title"> <i class="fas fa-home text-morado"></i> Inicio</span>
            </a>
          </li>
          <li class="pt-2 pb-1">
            <span class="nav-item-head">inventarios</span>
          </li>
          <li class="nav-item pt-1">
            <a class="nav-link" href="#">
              <span class="menu-title"><i class="fas fa-chart-line text-morado"></i> Panel de inventarios</span>
            </a>
          </li>
          <li class="nav-item pt-1">
            <a class="nav-link" href="<?= base_url('asignacioninventarios') ?>"> 
              
              <span class="menu-title"><i class="fas fa-truck-moving text-morado"></i>  Asignación de inventario</span>
            </a>
          </li>
          <li class="nav-item pt-1">
            <a class="nav-link" href="<?= base_url('conteos') ?>">
              
              <span class="menu-title"><i class="fas fa-barcode text-morado"></i> Captura de conteos</span>
            </a>
          </li>
           <li class="nav-item pt-1">
            <a class="nav-link" href="<?= base_url('usuarios') ?>">
              
              <span class="menu-title"> <i class="fas fa-users text-morado"></i> Usuarios</span>
            </a>
          </li>
          <li class="nav-item pt-1">
            <a class="nav-link" href="<?= base_url('conteos') ?>">
              
              <span class="menu-title"> <i class="fas fa-wifi text-danger"></i> Modo offline</span>
            </a>
          </li>
          <!-- <li class="nav-item pt-1">
            <a class="nav-link" href="#">
              
              <span class="menu-title"><i class="fas fa-chart-pie text-morado"></i> Reportes</span>
            </a>
          </li> -->
        </ul>
      </nav>
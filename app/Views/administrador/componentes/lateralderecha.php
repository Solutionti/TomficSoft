<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
          <div class="navbar-menu-wrapper d-flex align-items-stretch color-morado">
            <button class="navbar-toggler navbar-toggler align-self-center color-morado" type="button" data-toggle="minimize">
              <span class="fas fa-chevron-left"></span>
            </button>
            <div class="text-center  d-flex align-items-center justify-content-center">
              <!-- <a class="navbar-brand brand-logo-mini" ><img src="" width="30px" alt="logo" /></a> -->
            </div>
            <ul class="navbar-nav navbar-nav-right">
              <!-- <li class="nav-item nav-logout d-none d-md-block me-3">
                <a class="nav-link" href="#">Perfil</a>
              </li> -->
              <li class="nav-item nav-logout d-none d-md-block">
                <i class="fas fa-user mx-2"></i>
                <a
                  class="btn btn-sm btn-primary text-small btn-rounded"
                  href="<?php echo base_url(); ?>cerrarsesion"
                >
                  Cerrar Sesiòn
                </a>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-menu"></span>
            </button>
          </div>
        </nav>
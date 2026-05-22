<style>
  /* ── Hamburger button ── */
  .sb-open-btn {
    display: none;
    width: 38px; height: 38px;
    border-radius: 9px;
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    margin-left: auto;
    margin-right: 12px;
    margin-top: 10px;
    flex-shrink: 0;
    transition: background .2s;
  }
  .sb-open-btn:hover { background: rgba(255,255,255,.28); }
  @media (max-width: 991px) {
    .sb-open-btn { display: flex; }
  }
</style>

<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
          <div class="navbar-menu-wrapper d-flex align-items-stretch color-morado">
            <button class="navbar-toggler navbar-toggler align-self-center color-morado" type="button" data-toggle="minimize">
              <span class="fas fa-chevron-left"></span>
            </button>
            <div class="text-center  d-flex align-items-center justify-content-center">
              <!-- <a class="navbar-brand brand-logo-mini" ><img src="" width="30px" alt="logo" /></a> -->
            </div>
            <ul class="navbar-nav navbar-nav-right">
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
            <!-- Hamburger visible en móvil — lado derecho -->
            <button class="sb-open-btn" type="button" id="sb-open-btn" aria-label="Abrir menú">
              <i class="fas fa-bars"></i>
            </button>
          </div>
        </nav>
<script>
/* Mobile sidebar offcanvas toggle */
(function () {
  var btn     = document.getElementById('sb-open-btn');
  var sidebar = document.getElementById('sidebar');
  if (!btn || !sidebar) return;

  var backdrop = document.createElement('div');
  backdrop.className = 'sb-backdrop';
  document.body.appendChild(backdrop);

  btn.addEventListener('click', function () {
    sidebar.classList.toggle('active');
    backdrop.classList.toggle('visible');
  });
  backdrop.addEventListener('click', function () {
    sidebar.classList.remove('active');
    backdrop.classList.remove('visible');
  });
  /* Close on resize to desktop */
  window.addEventListener('resize', function () {
    if (window.innerWidth > 991) {
      sidebar.classList.remove('active');
      backdrop.classList.remove('visible');
    }
  });
})();
</script>
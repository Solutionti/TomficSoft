<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesiòn</title>
  <link rel="stylesheet" href="<?= base_url('css/estilo.css') ?>">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
  <link rel="stylesheet" href="https://htmlstream.com/preview/front-v4.2/html/assets/css/vendor.min.css">
  <link rel="stylesheet" href="https://htmlstream.com/preview/front-v4.2/html/assets/css/theme.min.css?v=1.0">

</head>
<body>
   <header id="header" class="navbar navbar-expand navbar-light navbar-absolute-top">
    <div class="container-fluid">
      <nav class="navbar-nav-wrap">
        
        <a class="navbar-brand d-flex d-lg-none" href="./index.html" aria-label="Front">
          <img class="navbar-brand-logo" src="https://htmlstream.com/preview/front-v4.2/html/assets/svg/logos/logo.svg" alt="Logo">
        </a>
        <div class="ms-auto">
          <a class="link link-sm link-secondary" routerLink="/">
            <i class="bi-chevron-left small ms-1"></i> Volver a la pagina principal
          </a>
        </div>
      </nav>
    </div>
  </header>
  <main id="content" role="main" class="flex-grow-1">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-5 col-xl-4 d-none d-lg-flex justify-content-center align-items-center min-vh-lg-100 position-relative  color-morado" style="background-image: url(./assets/svg/components/wave-pattern-light.svg);">
          <div class="flex-grow-1 p-5">
            <figure class="text-center">
              <div class="mb-4">
                <img class="avatar avatar-xl avatar-4x3" src="https://static.vecteezy.com/system/resources/thumbnails/012/986/755/small_2x/abstract-circle-logo-icon-free-png.png" alt="Logo">
              </div>
              <blockquote class="blockquote blockquote-light">“ Hemos creado un espacio para tus inventarios para que puedas estar al dia de tus pasos. bienvenido. ”</blockquote>
              <figcaption class="blockquote-footer blockquote-light">
                <!-- <div class="mb-3">
                  <img class="avatar avatar-circle" src="https://www.sport.es/bicio/wp-content/uploads/2022/05/requisitos-buen-ciclista.jpg" alt="Image Description">
                </div> -->

                TOMFIC
                <span class="blockquote-footer-source"> Edwin Carbonel - experto en inventarios</span>
              </figcaption>
            </figure>
            <div class="position-absolute start-0 end-0 bottom-0 text-center p-5">
            </div>
          </div>
        </div>
        <div class="col-lg-7 col-xl-8 d-flex justify-content-center content-space-3 align-items-center min-vh-lg-100">
          <div class="flex-grow-1 mx-auto" style="max-width: 28rem;">
            <div class="text-center mb-5 mb-md-7">
              <h1 class="h2">Bienvenido a TOMFIC</h1>
              <p>Inicie sesión para administrar su cuenta.</p>
            </div>
            <form class="js-validate needs-validation" [formGroup]="iniciarSesionForm">
              <div class="mb-4">
                <label class="form-label" for="signupModalFormLoginEmail">Correo electronico</label>
                <input
                  type="email"
                  class="form-control form-control-lg"
                  placeholder="Correo electronico"
                  formControlName="correo_iniciar"
                >
              </div>
              <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center">
                  <label class="form-label" for="signupModalFormLoginPassword">Contraseña</label>
                  <!-- <a class="form-label-link" href="#">Olvido su contraseña?</a> -->
                </div>
                <div class="input-group input-group-merge" data-hs-validation-validate-class>
                  <input
                    [type]="typepassword"
                    class="js-toggle-password form-control form-control-lg"
                    placeholder="Contraseña"
                    formControlName="contrasena_iniciar"
                  >
                  <a
          class="input-group-append input-group-text"
          (click)="verContrasena()"
        >
          <i id="changePassIcon" class="fas fa-eye"></i>
        </a>
        <a
          class="input-group-append input-group-text"
         
        >
          <i id="changePassIcon" class="fas fa-eye-slash"></i>
        </a>
                </div>
              </div>
              <div class="d-grid mb-3">
                <button
                  type="submit"
                  class="btn  btn-lg color-morado text-white"
                >
                  Iniciar Sesion
                </button>
              </div>
              <div class="text-center">
                <p>¿Olvidaste tu contraseña?  <a type="button" class="link" routerLink="/zonasport">Recuperar</a></p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>




  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/countdown@2.6.0/countdown.min.js"></script>
</body>
</html>
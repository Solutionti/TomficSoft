document.addEventListener("DOMContentLoaded", function () {
  var togglePassword = document.querySelector(".input-group-append.input-group-text");
  var passwordField = document.getElementById("password");
  var icon = document.getElementById("changePassIcon");

  if (togglePassword) {
      togglePassword.addEventListener("click", function (event) {
          event.preventDefault();
          if (passwordField.type === "password") {
              passwordField.type = "text";
              icon.classList.remove("fa-eye");
              icon.classList.add("fa-eye-slash");
          } else {
              passwordField.type = "password";
              icon.classList.remove("fa-eye-slash");
              icon.classList.add("fa-eye");
          }
      });
  }
});

$("#FormLOG").submit(function (event) {
	event.preventDefault();
  iniciarSesion();
});

function iniciarSesion() {
  
  var usuario = $('#usuario').val(),
      password = $('#password').val();
  var url = baseurl + '/iniciarsesion';

  $.ajax({
    url: url,
    method: 'POST',
    data: {
      usuario: usuario,
      password: password
    },
    success: function(response) {
     if(response === "error") {
        $(".messageError").html('<div class="alert-login"><i class="fas fa-triangle-exclamation"></i> Usuario o contraseña incorrectos. Inténtalo de nuevo.</div>');
        $("#password").addClass("is-invalid");
        $("#usuario").addClass("is-invalid");
        $("#login").removeClass("loading");
     }
     else {
         window.location.href = baseurl + 'inicio';
     }
    },
    error: function() {
      $(".messageError").html('<div class="alert-login"><i class="fas fa-wifi"></i> Error de conexión. Verifica tu red e inténtalo de nuevo.</div>');
      $("#login").removeClass("loading");
    }
  });
}

function cerrarSesion() {
  var url = baseurl + '/cerrarsesion';
}
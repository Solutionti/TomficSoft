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
        $(".messageError").html('<div class="alert text-white color-morado">Alerta !! El usuario y contraseña ingresado son invalidos.</div>');
        $("#password").addClass("is-invalid");
        $("#usuario").addClass("is-invalid");
        
     }  
     else {
         window.location.href = baseurl + '/inicio';
     } 
    }
  });
}

function cerrarSesion() {
  var url = baseurl + '/cerrarsesion';
}
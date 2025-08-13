document.addEventListener("DOMContentLoaded", function () {
  var togglePassword = document.querySelector(".input-group-append.input-group-text");
  var passwordField = document.getElementById("repetir_password_usuario");
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


function crearUsuarios() {
 var documento = $("#documento_usuario").val(),
    nombre = $("nombre_usuario").val(),
    apellido = $("apellido_usuario").val(),
    empresa = $("empresa_usuario").val(),
    telefono = $("telefono_usuario").val(),
    estado = $("estado_usuario").val(),
    rol = $("rol_usuario").val(),
    fecha = $("fecha_usuario").val(),
    hora = $("hora_usuario").val(),
    usuario = $("usuario_usuario").val(),
    contraseña = $("password_usuario").val(),
    repetirContraseña = $("repetir_password_usuario").val();  
}


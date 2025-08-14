document.addEventListener("DOMContentLoaded", function () {
  var togglePassword = document.querySelector(".input-group-append.input-group-text");
  var passwordField = document.getElementById("password_usuario");
  var passwordField2 = document.getElementById("repetir_password_usuario");
  var icon = document.getElementById("changePassIcon");

  if (togglePassword) {
      togglePassword.addEventListener("click", function (event) {
          event.preventDefault();
          if (passwordField.type === "password") {
              passwordField.type = "text";
              passwordField2.type = "text";
              icon.classList.remove("fa-eye");
              icon.classList.add("fa-eye-slash");
          } else {
              passwordField.type = "password";
              passwordField2.type = "password";
              icon.classList.remove("fa-eye-slash");
              icon.classList.add("fa-eye");
          }
      });
  }
});

//
function crearUsuarios() {
  
 //definir las variables que vienen del input 
 var documento = $("#documento_usuario").val(),
    nombre = $("#nombre_usuario").val(),
    apellido = $("#apellido_usuario").val(),
    empresa = $("#empresa_usuario").val(),
    telefono = $("#telefono_usuario").val(),
    estado = $("#estado_usuario").val(),
    rol = $("#rol_usuario").val(),
    fecha = $("#fecha_usuario").val(),
    hora = $("#hora_usuario").val(),
    usuario = $("#usuario_usuario").val(),
    contraseña = $("#password_usuario").val(),
    repetirContraseña = $("#repetir_password_usuario").val();

//   // valirdar las contraseñas que coincidan
//   if(contraseña == repetirContraseña) {

//   }
//   else {

//   }
  //definir una variable url para el ajax
  var url = baseurl + '/crearusuario';

  //hacer el llamado de nuestra funcion ajax que es la encargada de llamar el controllador
  $.ajax({
    url: url,
    method: "POST",
    data: {
      documento: documento,
      nombre: nombre,
      apellido: apellido,
      empresa: empresa,
      telefono: telefono,
      estado: estado,
      rol: rol,
      fecha: fecha,
      hora: hora,
      usuario: usuario,
      contraseña: contraseña,
      repetirContraseña: repetirContraseña,
    },
    success: function(response) {
       $("body").overhang({
          type: "success",
          message: "El usuario se ha creado correctamente en la base de datos. " 
        });
      location.reload();
    },
    error: function(error, ext) {
      $("body").overhang({
        type: "error",
        message: "Alerta ! Tenemos un problema al conectar con la base de datos verifica tu red.",
      });
    }
  });
    
}


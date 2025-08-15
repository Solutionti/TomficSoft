document.addEventListener("DOMContentLoaded", function () {
  var togglePassword = document.querySelector(".input-group-append.input-group-text");
  var passwordField = document.getElementById("password_usuario");
  var passwordField2 = document.getElementById("repetir_password_usuario");
  var icon = document.getElementById("changePassIcon");
  var permisosarray = [];

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
// Seleccionar todo
document.getElementById('selectAll').addEventListener('change', function() {
    let checkboxes = document.querySelectorAll('.fila');
    checkboxes.forEach(cb => cb.checked = this.checked);
});

// Obtener los seleccionados en un array
document.getElementById('btnObtener').addEventListener('click', function() {
    let seleccionados = [];
    let checkboxes = document.querySelectorAll('.fila:checked');
    
    checkboxes.forEach(cb => {
        seleccionados.push(cb.value);
    });
    
    console.log(seleccionados);
});

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



    if (contraseña.trim() === "" || repetirContraseña.trim() === "") {
        $("body").overhang({
            type: "error",
            message: "⚠️ Los campos de contraseña no pueden estar vacíos."
        });
        return; // Detiene la ejecución
    }

    if (contraseña !== repetirContraseña) {
        $("body").overhang({
            type: "error",
            message: "⚠️ Las contraseñas no coinciden."
        });
        return; // Detiene la  ejecución
    }


  //definir una variable url para el ajax
  var url = baseurl + '/crearusuario';

  //permisos de los usuarios
  let seleccionados = [];
  let checkboxes = document.querySelectorAll('.fila:checked');
    
  checkboxes.forEach(cb => {
    seleccionados.push(cb.value);
  });
    
  console.log(seleccionados); 

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


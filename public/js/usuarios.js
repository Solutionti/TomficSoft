
$("#table_usuarios").DataTable({
  "lengthMenu": [5, 50, 100, 200],
  "language":{
  "processing": "Procesando",
  "search": "Buscar:",
  "lengthMenu": "Ver _MENU_ Usuarios",
  "info": "Viendo _START_ a _END_ de _TOTAL_ Usuarios",
  "zeroRecords": "No encontraron resultados",
  "paginate": {
    "first":      "Primera",
    "last":       "Ultima",
    "next":       "Siguiente",
    "previous":   "Anterior"
  }
 }
});
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
    correo = $("#correo").val(),
    rol = $("#rol_usuario").val(),
    fecha = $("#fecha_usuario").val(),
    hora = $("#hora_usuario").val(),
    usuario = $("#usuario_usuario").val(),
    contraseña = $("#password_usuario").val(),
    repetirContraseña = $("#repetir_password_usuario").val();

    //validacion campo input con icono de requerido
if(documento === "") {
  $("#documento_usuario").addClass("is-invalid");
}
else if (nombre === "") {
  $("#nombre_usuario").addClass("is-invalid");
}
else if (apellido === "") {
  $("#apellido_usuario").addClass("is-invalid");
}
else if (empresa === "") {
  $("#empresa_usuario").addClass("is-invalid");
}
else if (telefono === "") {
  $("#telefono_usuario").addClass("is-invalid");
}
else if (estado === "") {
  $("#estado_usuario").addClass("is-invalid");
}
else if (correo === "") {
  $("#correo").addClass("is-invalid");
}
else if (rol === "") {
  $("#rol_usuario").addClass("is-invalid");
}
else if (usuario === "") {
  $("#usuario_usuario").addClass("is-invalid");
}
else if (contraseña === "") {
  $("#password_usuario").addClass("is-invalid");
}
else if (repetirContraseña === "") {
  $("#repetir_password_usuario").addClass("is-invalid");
}
    

// Validación  de campos requeridos con mensaje
let campos = [
  { id: "documento_usuario", valor: documento, nombre: "Documento" },
  { id: "nombre_usuario", valor: nombre, nombre: "Nombre" },
  { id: "apellido_usuario", valor: apellido, nombre: "Apellido" },
  { id: "empresa_usuario", valor: empresa, nombre: "Empresa" },
  { id: "telefono_usuario", valor: telefono, nombre: "Teléfono" },
  { id: "estado_usuario", valor: estado, nombre: "Estado" },
  { id: "correo", valor: correo, nombre: "Correo" },
  { id: "rol_usuario", valor: rol, nombre: "Rol" },
  { id: "usuario_usuario", valor: usuario, nombre: "Usuario" },
  { id: "password_usuario", valor: contraseña, nombre: "Contraseña" },
  { id: "repetir_password_usuario", valor: repetirContraseña, nombre: "RepetirContraseña" },
];

for (let campo of campos) {
  if (campo.valor.trim() === "") {
    $("#" + campo.id).focus();
    $("body").overhang({
    type: "error",
    message: "⚠️ El campo " + campo.nombre + " es obligatorio."
  });
  return; // detiene la ejecución
  }
};


// validacion contraseña, que sean iguales
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
      correo: correo,
      rol: rol,
      fecha: fecha,
      hora: hora,
      usuario: usuario,
      contraseña: contraseña,
      repetirContraseña: repetirContraseña,
      permisos: seleccionados
    },
    success: function(response) {
       $("body").overhang({
          type: "success",
          message: "El usuario se ha creado correctamente en la base de datos. " 
        });

        setTimeout(reloadPage, 3000);
    },
    error: function(error, ext) {
      $("body").overhang({
        type: "error",
        message: "Alerta ! Tenemos un problema al conectar con la base de datos verifica tu red.",
      });
    }
  });
}

function eliminarUsuario(id) {
  let url = baseurl + "eliminarusuario";
   $("body").overhang({
     type: "confirm",
     primary: "#9a3de0",
     accent: "#c5b8da",
     yesColor: "#0033c4",
     yesMessage: "Sí",
     noMessage: "No",
     message: "¿Desea eliminar el usuario?",
     overlay: true,
     callback: function (value) {
      if (value) {
        $.ajax({
          url: url,
          method: "POST",
          data: {
            id: id
          },
          success: function(response) {
            $("body").overhang({
             type: "success",
             message: response.message
            });

            setTimeout(reloadPage, 3000);
          },
          error: function() {
$("body").overhang({
        type: "error",
        message: "Alerta ! Tenemos un problema al conectar con la base de datos verifica tu red.",
      });
            
          }
        });
      }
      else {

      }
   }
  });
}

function mostrarDatosUsuarioModal(id){
  
  let url = baseurl + "getusuarioid/" + id;
  
  $.ajax({
    url: url,
    method: 'GET',
    success: function (response){
      $("#actualizarUsuario").modal('show');
      console.log(response);
      $('#documento_usuario_actualizar').val(response[0].documento);
      $('#nombre_usuario_actualizar').val(response[0].nombre);
      $('#apellido_usuario_actualizar').val(response[0].apellido);
      $('#empresa_usuario_actualizar').val(response[0].empresa);
      $('#telefono_usuario_actualizar').val(response[0].telefono);
      $('#estado_usuario_actualizar').val(response[0].estado);
      $('#correo_actualizar').val(response[0].email);
      $('#rol_usuario_actualizar').val(response[0].rol_usuario);
      $('#fecha_usuario_actualizar').val(response[0].fecha);
      $('#hora_usuario_actualizar').val(response[0].hora);
      $('#usuario_usuario_actualizar').val(response[0].usuario_creacion);
    },
    error: function (response){
      $("body").overhang({
        type: "error",
        message: "Alerta ! Tenemos un problema al conectar con la base de datos verifica tu red.",
      });
    }
      
  });
}

function actualizarUsuario() {
  var url = baseurl + "/actualizarusuario";
  var documento =  $('#documento_usuario_actualizar').val(),
      nombre = $('#nombre_usuario_actualizar').val(),
      apellido = $('#apellido_usuario_actualizar').val(),
      empresa = $('#empresa_usuario_actualizar').val(),
      telefono = $('#telefono_usuario_actualizar').val(),
      estado = $('#estado_usuario_actualizar').val(),
      email = $('#correo_actualizar').val(),
      rol = $('#rol_usuario_actualizar').val(),
      fecha =$('#fecha_usuario_actualizar').val(),
      hora = $('#hora_usuario_actualizar').val(),
      usuario = $('#usuario_usuario_actualizar').val();

      $.ajax({
        url: url,
        method: 'POST',
        data: {
          documento: documento,
          nombre: nombre,
          apellido: apellido,
          empresa: empresa,
          telefono: telefono,
          estado: estado,
          email: email,
          rol: rol,
          fecha: fecha,
          hora: hora,
          usuario: usuario
        },
        success: function(response){
          $("body").overhang({
          type: "success",
          message: "El usuario se ha actualizado correctamente en la base de datos. " 
        });

        setTimeout(reloadPage, 3000);
        },
        error: function(responde){
          $("body").overhang({
          type: "error",
          message: "El usuario no se ha actualizado correctamente en la base de datos. " 
        });
        }
      });


}

function reloadPage() {
  location.reload();
}

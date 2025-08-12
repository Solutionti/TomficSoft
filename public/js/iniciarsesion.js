
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
       alert("no inicio");   
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
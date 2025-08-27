function crearInventarios(){
    //asignar la ruta de el controlador
    var url = baseurl + 'crearinventario';
    
    // recuper los  valores de los input del formulario
    var fecha = $('#fecha_agregar_inventario').val(),
    descripcion = $('#observacion_agregar_inventario').val();
    
    // hacer la validacion de los campos del imput
    
    // llamar la funcion ajax que me ejecuta el controlador
   
        $.ajax({
          //url
          url: url,
          //metodo
          method:'POST',
          //data
          data: {
            //definicion : valor
            fecha: fecha,
            descripcion: descripcion
          },
          //success
          success: function(response) {

          },
          //error
          error: function() {

          }
        });
}








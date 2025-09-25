function crearInventarios(){
    //asignar la ruta de el controlador
    var url = baseurl + 'crearinventarios';
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
            $("body").overhang({
              type: "success",
              message: "El inventario se ha creado en la base de datos correctamente." 
            });
          },
          //error
          error: function() {
            $("body").overhang({
              type: "error",
              message: "Alerta ! Tenemos un problema al conectar con la base de datos verifica tu red.",
            });
          }
        });
}

function asociarDatosModalProductos(id){
  var id = $("#id_inventario_modal").val(id);
  $("#listaproductos").modal('show');
}

function asociarDatosModalConteos(id){
  var id = $("#id_conteo_modal").val(id);
  $("#modalConteos").modal('show');
}

function asociarDatosModalProcesos(id){
  var id = $("#id_procesos_modal").val(id);
  $("#modalProceso").modal('show');
}






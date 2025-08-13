
$("#codigo_producto").on("blur", function() {
    var codigo_producto = $('#codigo_producto').val();
    var url = baseurl + '/buscarproducto/' + codigo_producto;
    
    $.ajax({
      url: url,
      method: 'GET',
      success: function(response) {
        if(response === "error") {
          alert("El producto no existe o no se encuentra registrado.");
          $("#nombre_producto").val("");
          $("#referencia").val("");
          $("#proveedor").val("");
          $("#linea").val("");
          $("#sublinea").val("");
          $("#subgrupo").val("");
        }
        else {
          $("#nombre_producto").val(response[0].nombre);
          $("#referencia").val(response[0].referencia);
          $("#proveedor").val(response[0].proveedor);
          $("#linea").val(response[0].categoria);
          $("#sublinea").val(response[0].subcategoria);
          $("#subgrupo").val(response[0].subgrupo);
        }
      },
      error: function(xhr, status, error) {
      
      }
    });
});

$("#cajas").on("keyup", function() {
  var unidades = $("#unidades").val(),
      cajas = $("#cajas").val(),
      total = parseInt(unidades) * parseInt(cajas);

  $("#total").val(total);
});



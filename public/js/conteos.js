
$("#codigo_producto").on("blur", function() {
    var codigo_producto = $('#codigo_producto').val();
    var url = baseurl + '/buscarproducto/' + codigo_producto;
    
    $.ajax({
      url: url,
      method: 'GET',
      success: function(response) {
        if(response === "error") {
          $("body").overhang({
            type: "error",
            message: "Alerta ! El producto no existe o no se encuentra registrado.",
          });
          
          $("#nombre_producto").val("");
          $("#referencia").val("");
          $("#proveedor").val("");
          $("#linea").val("");
          $("#sublinea").val("");
          $("#subgrupo").val("");
          $("#saldo").val("");
        }
        else {
          $("#nombre_producto").val(response[0].nombre);
          $("#referencia").val(response[0].referencia);
          $("#proveedor").val(response[0].proveedor);
          $("#linea").val(response[0].categoria);
          $("#sublinea").val(response[0].subcategoria);
          $("#subgrupo").val(response[0].subgrupo);
          $("#saldo").val(response[0].saldo);
          
        }
      },
      error: function(xhr, status, error) {
      
      }
    });
});

$("#cajas").on("keyup", function() {
  var unidades = $("#unidades").val(),
      cajas = $("#cajas").val(),
      embalaje = $("#embalaje").val(),
      total = parseInt(embalaje) * parseInt(cajas) + parseInt(unidades),
      saldo = parseInt($("#saldo").val()) - parseInt(total) ;

  $("#total").val(total);
  $("#diferencia").val(saldo);
});

$("#unidades").on("keyup", function() {
  var unidades = $("#unidades").val(),
      cajas = $("#cajas").val(),
      embalaje = $("#embalaje").val(),
      total = parseInt(embalaje) * parseInt(cajas) + parseInt(unidades),
      saldo = parseInt($("#saldo").val()) - parseInt(total) ;

  $("#total").val(total);
  $("#diferencia").val(saldo);
});

$("#embalaje").on("keyup", function() {
  var unidades = $("#unidades").val(),
      cajas = $("#cajas").val(),
      embalaje = $("#embalaje").val(),
      total = parseInt(embalaje) * parseInt(cajas) + parseInt(unidades),
      saldo = parseInt($("#saldo").val()) - parseInt(total);
      
  $("#total").val(total);
  $("#diferencia").val(saldo);
});

$("#exportardatos").on("click", function(e) {
  e.preventDefault();
  let url = baseurl + 'cargarexcelproductos';
  let formData = new FormData();
  formData.append("archivo", document.getElementById("archivo").files[0]);

  $("body").overhang({
  type: "confirm",
  primary: "#9a3de0",
  accent: "#c5b8da",
  yesColor: "#0033c4",
  yesMessage: "Sí",
  noMessage: "No",
  message: "¿Desea cargar la base de datos al sistema?",
  overlay: true,
  callback: function (value) {
    if (value) {
    $.ajax({
    url:url,
    method: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function(response) {
      $("body").overhang({
        type: "success",
        message: "La base de datos se ha exportado correctamente. total registro " + response
      });
      $("#archivo").val("");
    },
    error: function(xhr, status, error) {
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
});



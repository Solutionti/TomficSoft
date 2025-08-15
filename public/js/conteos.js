
$("#table-productos").DataTable({
  "lengthMenu": [5, 50, 100, 200],
  "language":{
  "processing": "Procesando",
  "search": "Buscar:",
  "lengthMenu": "Ver _MENU_ Productos",
  "info": "Viendo _START_ a _END_ de _TOTAL_ Productos",
  "zeroRecords": "No encontraron resultados",
  "paginate": {
    "first":      "Primera",
    "last":       "Ultima",
    "next":       "Siguiente",
    "previous":   "Anterior"
  }
 }
});

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

function VincularProductoModal(codigo) {
  var url = baseurl + '/buscarproducto/' + codigo;
    
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
          $("#codigo_producto").val(response[0].codigo_barras);
          $("#nombre_producto").val(response[0].nombre);
          $("#referencia").val(response[0].referencia);
          $("#proveedor").val(response[0].proveedor);
          $("#linea").val(response[0].categoria);
          $("#sublinea").val(response[0].subcategoria);
          $("#subgrupo").val(response[0].subgrupo);
          $("#saldo").val(response[0].saldo);
          $("#listaproductos").modal('hide');
        }
      },
      error: function(xhr, status, error) {
      
      }
    });
}

function GuardarConteo() {
  var url = baseurl + 'guardarconteo';
  var codigo_producto = $("#codigo_producto").val(),
      nombre_producto = $("#nombre_producto").val(),
      referencia = $("#referencia").val(),
      saldo = $("#saldo").val(),
      estado_producto = $("#estado_producto").val(),
      observacion = $("#observacion").val(),
      ubicacion = $("#ubicacion").val(),
      localizacion = $("#localizacion").val(),
      numero_localizacion = $("#numero_localizacion").val(),
      total = $("#total").val(),
      saldo = $("#saldo").val(),
      diferencia = $("#diferencia").val();


  $.ajax({
    url: url,
    method: 'POST',
    data: {
      codigo_producto: codigo_producto,
      nombre_producto: nombre_producto,
      referencia: referencia,
      saldo: saldo,
      estado_producto: estado_producto,
      observacion: observacion,
      ubicacion: ubicacion,
      localizacion: localizacion,
      numero_localizacion: numero_localizacion,
      total: total,
      diferencia: diferencia
    },
    success: function(response) {
      $("body").overhang({
        type: "success",
        message: "El conteo se ha registrado en la base de datos correctamente." 
      });
    },
    error: function() {
      $("body").overhang({
        type: "error",
        message: "Alerta ! Tenemos un problema al conectar con la base de datos verifica tu red.",
      });
    }
  });
}

function modificarConteo() {
  
}

function finalizarConteo() {
 $("body").overhang({
  type: "confirm",
  primary: "#9a3de0",
  accent: "#c5b8da",
  yesColor: "#0033c4",
  yesMessage: "Sí",
  noMessage: "No",
  message: "¿Desea terminar el proceso de conteo?",
  overlay: true,
  callback: function (value) {
    if (value) {

    }
    else {

    }
  }
 });        
}



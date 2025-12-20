$("#tabla_inventarios").DataTable({
  "lengthMenu": [11, 50, 100, 200],
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

function eliminarProducto(id) {
    let url = baseurl + "eliminarproducto" ;
   $("body").overhang({
     type: "confirm",
     primary: "#9a3de0",
     accent: "#c5b8da",
     yesColor: "#0033c4",
     yesMessage: "Sí",
     noMessage: "No",
     message: "¿Desea eliminar el producto?",
     overlay: true,
     callback: function (value) {
      if (value) {
        //si
        $.ajax({
          url: url,
          method: "POST",
          data: {id: id},
          success: function(response){
            $("body").overhang({
             type: "success",
             message: response.message
            });

            setTimeout(reloadPage, 3000);
          },
          error: function(response){
            $("body").overhang({
            type: "error",
            message: "Alerta ! Tenemos un problema al conectar con la base de datos verifica tu red.",
          });
          }
        });
      }
      else {
        //no
      }
   }
  });
}

   function agregarProductos() {
    //definir las variables que vienen del input
    var categoria = $("#categoria_inventario").val(),
    subcategoria = $("#subcategoria_inventario").val(),
    grupo = $("#grupo_inventario").val(),
    subgrupo = $("#subgrupo_inventario").val(),
    nombre = $("#nombre_inventario").val(),
    referencia = $("#referencia_inventario").val(),
    codigointerno = $("#codigo_inventario").val(),
    codigobarras = $("#barras_inventario").val(),
    nit = $("#nit_inventario").val(),
    proveedor = $("#proveedor_inventario").val(),
    saldo = $("#saldo_inventario").val(),
    costo = $("#costo_inventario").val();

    // creamos variable url

    var url = baseurl + "agregarproductos";

    //hacemos la peticion por ajax
    $.ajax({
      url: url,
      method: "POST",
      data: {
        categoria: categoria,
        subcategoria: subcategoria,
        grupo: grupo,
        subgrupo: subgrupo,
        nombre: nombre,
        referencia: referencia,
        codigointerno: codigointerno,
        codigobarras: codigobarras,
        nit: nit,
        proveedor: proveedor,
        saldo: saldo,
        costo: costo
      },
      success: function (response) {
        $("body").overhang({
          type: "success",
          message: "El Producto se ha creado correctamente en la base de datos."
        });

        setTimeout(reloadPage, 3000);
      },
      error: function (error) {
        $("body").overhang({
          type: "error",
          message: "Ha ocurrido un error al crear el producto."
        });
      }
    });    
  }

  function mostrarDatosProductosModal(id) {
    //creamos la ruta
    let url = baseurl + "obtenerdatoproducto/" + id;

    $.ajax({
      url: url,
      method: "GET",
      success: function(response){
        $("#actualizarProducto").modal('show');
        console.log(response);

        $("#categoria_editar").val(response[0].categoria);
        $("#subcategoria_editar").val(response[0].subcategoria);
        $("#grupo_editar").val(response[0].grupo);
        $("#subgrupo_editar").val(response[0].subgrupo);
        $("#nombre_editar").val(response[0].nombre);
        $("#referencia_editar").val(response[0].referencia);
        $("#codigo_editar").val(response[0].codigo_interno);
        $("#barras_editar").val(response[0].codigo_barras);
        $("#nit_editar").val(response[0].nit);
        $("#proveedor_editar").val(response[0].proveedor);
        $("#saldo_editar").val(response[0].saldo);
        $("#costo_editar").val(response[0].costo);
      },
      error: function(response){
        $("body").overhang({
        type: "error",
        message: "Alerta ! Tenemos un problema al conectar con la base de datos verifica tu red.",
        });
      }
    });
  }
  function actualizarProductos(){
    var categoria = $("#categoria_editar").val(),
    subcategoria = $("#subcategoria_editar").val(),
    grupo = $("#grupo_editar").val(),
    subgrupo = $("#subgrupo_editar").val(),
    nombre = $("#nombre_editar").val(),
    referencia = $("#referencia_editar").val(),
    codigointerno = $("#codigo_editar").val(),
    codigobarras = $("#barras_editar").val(),
    nit = $("#nit_editar").val(),
    proveedor = $("#proveedor_editar").val(),
    saldo = $("#saldo_editar").val(),
    costo = $("#costo_editar").val();

    let url = baseurl + "actualizarproductos";

    $.ajax({
      url: url,
      method: 'POST',
      data: {
        categoria: categoria,
        subcategoria: subcategoria,
        grupo: grupo,
        subgrupo: subgrupo,
        nombre: nombre,
        referencia: referencia,
        codigointerno: codigointerno,
        codigobarras: codigobarras,
        nit: nit,
        proveedor: proveedor,
        saldo: saldo,
        costo: costo
      },
      success: function (response){
        $("body").overhang({
          type: "success",
          message: "El producto se ha actualizado correctamente en la base de datos."
        });
        setTimeout(reloadPage, 3000);
      },
      error: function (response){
        $("body").overhang({
          type: "error",
          message: "Ha ocurrido un error al actualizar el producto."
        });
      }
    });
  }

  //ENTRADA DE PRODUCTOS 
    $("#producto_ingreso").on("blur", function(){
      //definir lo que  necesitamos
      var codigo = $("#producto_ingreso").val(); 
      var url = baseurl + "obtenerstock/" + codigo;
  
      //llamamos al controlador
      $.ajax({
        url: url,
        method: "GET",
        success: function(response){
          //obtener lo que me trae el conttrolador verificar 
           // console.log(response); 
          // respuesta de lo que necesitamos
           $("#stock_ingreso").val(response[0].saldo);
           $("#nombre_ingreso").val(response[0].nombre);
           $("#precio_ingreso").val(response[0].costo);
           $("#sede_ingreso").val(response[0].nit);
          //  $("#valor_ingreso").val(response[0].costo);
           
        },
        error: function(response){
          $("body").overhang({
            type: "error",
            message: "Alerta ! Tenemos un problema al conectar con la base de datos verifica tu red.",
          });
        }
      });
    });

    function ingresarEntradaProductos(){
      let url = baseurl + "ingresarentrada";
      var producto = $("#producto_ingreso").val(),
      cantidad = $("#cantidad_ingreso").val(),
      valor = $("#valor_ingreso").val(),
      sede = $("#sede_ingreso").val(),
      motivo = $("#motivo_ingreso").val(),
      stock = $("#stock_ingreso").val(),
      comentarios = $("#comentarios_ingreso").val();

      $.ajax({
        url: url,
        method: "POST",
        data: {
          producto: producto,
          cantidad: cantidad,
          valor: valor,
          sede: sede,
          motivo: motivo,
          comentarios: comentarios,
          stock: stock
        },
        success: function (response){
          $("body").overhang({
            type: "success",
            message: "La entrada de productos se ha registrado correctamente."
          });
          setTimeout(reloadPage, 3000);
        },
        error: function (response){
          $("body").overhang({    
            type: "error",
            message: "Ha ocurrido un error al registrar la entrada de productos."
          });
        }
      });
    }

    //SALIDA DE PRODUCTOS
    $("#producto_salida").on("blur", function(){
      //definir lo que  necesitamos
      var codigo = $("#producto_salida").val(); 
      var url = baseurl + "obtenerstock/" + codigo;
  
      //llamamos al controlador
      $.ajax({
        url: url,
        method: "GET",
        success: function(response){
          // respuesta de lo que necesitamos
           $("#stock_salida").val(response[0].saldo);
           $("#nombre_salida").val(response[0].nombre);
           $("#precio_salida").val(response[0].costo);
           $("#sede_salida").val(response[0].nit);
          //  $("#valor_salida").val(response[0].costo);
           
        },
        error: function(response){
          $("body").overhang({
            type: "error",
            message: "Alerta ! Tenemos un problema al conectar con la base de datos verifica tu red.",
          });
        }
      });
    });

    function ingresarSalidaProductos(){
      let url = baseurl + "ingresarsalida";
      var producto = $("#producto_salida").val(),
      cantidad = $("#cantidad_salida").val(),
      valor = $("#valor_salida").val(),
      sede = $("#sede_salida").val(),
      motivo = $("#motivo_salida").val(),
      stock = $("#stock_salida").val(),
      comentarios = $("#comentarios_salida").val();

      $.ajax({
        url: url,
        method: "POST",
        data: {
          producto: producto,
          cantidad: cantidad,
          valor: valor,
          sede: sede,
          motivo: motivo,
          comentarios: comentarios,
          stock: stock
        },
        success: function (response){
          $("body").overhang({
            type: "success",
            message: "La salida de productos se ha registrado correctamente."
          });
          setTimeout(reloadPage, 3000);
        },
        error: function (response){
          $("body").overhang({    
            type: "error",
            message: "Ha ocurrido un error al registrar la entrada de productos."
          });
        }
      });
    }

    function ajustarInventario() {
      $("body").overhang({
        type: "confirm",
        primary: "#9a3de0",
        accent: "#c5b8da",
        yesColor: "#0033c4",
        yesMessage: "Sí",
        noMessage: "No",
        message: "¿Desea ajustar el stock del inventario?",
        overlay: true,
        callback: function (value) {
          if (value) {
            //si
          }
          else {
            //no
          }
        }
     });
    }

  function reloadPage() {
  location.reload();
}






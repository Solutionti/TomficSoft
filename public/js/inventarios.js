$("#tabla_inventarios").DataTable({
  "lengthMenu": [13, 50, 100, 200],
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
     message: "¿Desea eliminar el usuario?",
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







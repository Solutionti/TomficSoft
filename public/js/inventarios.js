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
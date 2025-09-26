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
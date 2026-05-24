$("#addToCartBtn").on("click", function () {
    let comentarios = $('#comentarios_solicitud').val();
    
    $("body").overhang({
        type: "confirm",
        primary: "#9a3de0",
        accent: "#c5b8da",
        yesColor: "#0033c4",
        yesMessage: "Sí",
        noMessage: "No",
        message: "¿Desea realizar la solicitud de inventarios?",
        overlay: true,
        callback: function (value) {
          if (value) {
            $.ajax({
        url: baseurl + 'crearSolicitudInventarios',
        method: 'POST',
        data: {carrito: carrito, comentarios: comentarios},
        success: function (response) {
            // alert('Solicitud de inventarios creada exitosamente');
            // Limpiar el carrito y la tabla
            carrito = [];
            $('#table_usuarios tbody').empty();
            actualizarContador();
        },
        error: function (xhr, status, error) {
            alert('Error al crear la solicitud de inventarios: ' + error);
        }
    });
          }
          else {
            //no
          }
        }
     });

    
});
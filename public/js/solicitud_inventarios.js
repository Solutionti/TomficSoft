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
            if (carrito.length === 0) {
                $("body").overhang({
                 type: "error",
                 message: "El carrito está vacío. Agregue productos antes de realizar la solicitud.",
                }, 4000);
                return;
            }
            /* Leer cantidades actuales del DOM antes de enviar */
            document.querySelectorAll('.tbody tr[data-sol-codigo]').forEach(function (tr) {
              var codigo = tr.dataset.solCodigo;
              var input  = tr.querySelector('input[type="number"]');
              var qty    = input ? (parseInt(input.value, 10) || 1) : 1;
              var item   = carrito.find(function (c) { return String(c.codigo) === String(codigo); });
              if (item) item.cantidad = qty;
            });

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

             $("body").overhang({
                 type: "success",
                 message: "Solicitud de inventarios creada exitosamente. y en espera de autorizacion",
                }, 4000);
              setTimeout(actualizarPagina, 3000);
        },
        error: function (xhr, status, error) {
            $("body").overhang({ type: "error", message: "Error al crear la solicitud de inventarios." });
        }
    });
          }
          else {
            //no
          }
        }
     });
});

function actualizarPagina() {
    location.reload();
}
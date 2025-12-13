
$('#descargardiferencia').click(function() {
    var url = baseurl + 'diferenciaconteos/' + $("#fechaInicio").val() + '/' + $("#fechaFin").val(); // URL de tu Excel
    var nombreArchivo = 'diferenciaconteos.xlsx';

    $.ajax({
        url: url,
        method: 'GET',
        xhrFields: {
            responseType: 'blob' // importante para archivos binarios
        },
        success: function(data) {
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(data);
            link.download = nombreArchivo;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },
        error: function(err) {
            console.error('Error al descargar el archivo', err);
        }
    });
});
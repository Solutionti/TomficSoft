
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

$("#sinconteopdf").on("click", function() {
    let url  = baseurl + 'productossinconteo/' + $("#fechaInicio").val() + '/' + $("#fechaFin").val();
    
    window.open(url, "_blank", " width=900, height=900");
});

$("#sinconteoexcel").on("click", function() {
    var url = baseurl + 'productossinconteoexcel/' + $("#fechaInicio").val() + '/' + $("#fechaFin").val(); // URL de tu Excel
    var nombreArchivo = 'productos_noconteo.xlsx';

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

// ── Helpers pérdidas ─────────────────────────────────────────────────────────
function getPerdFI() { return $('#perdFechaInicio').val() || '2000-01-01'; }
function getPerdFF() { return $('#perdFechaFin').val()    || new Date().toISOString().slice(0,10); }

// PF – Pérdidas por Fecha – PDF
$('#perdidasFechaPdf').on('click', function() {
    window.open(baseurl + 'perdidasfechapdf/' + getPerdFI() + '/' + getPerdFF(), '_blank');
});

// PF – Pérdidas por Fecha – Excel
$('#perdidasFechaExcel').on('click', function() {
    var url = baseurl + 'perdidasfechaexcel/' + getPerdFI() + '/' + getPerdFF();
    $.ajax({
        url: url, method: 'GET',
        xhrFields: { responseType: 'blob' },
        success: function(data) {
            var a = document.createElement('a');
            a.href = window.URL.createObjectURL(data);
            a.download = 'perdidas_por_fecha.xlsx';
            document.body.appendChild(a); a.click(); document.body.removeChild(a);
        },
        error: function(err) { console.error('Error al descargar', err); }
    });
});

// PP – Pérdidas por Producto – PDF
$('#perdidasProductoPdf').on('click', function() {
    window.open(baseurl + 'perdidasproductopdf/' + getPerdFI() + '/' + getPerdFF(), '_blank');
});

// PP – Pérdidas por Producto – Excel
$('#perdidasProductoExcel').on('click', function() {
    var url = baseurl + 'perdidasproductoexcel/' + getPerdFI() + '/' + getPerdFF();
    $.ajax({
        url: url, method: 'GET',
        xhrFields: { responseType: 'blob' },
        success: function(data) {
            var a = document.createElement('a');
            a.href = window.URL.createObjectURL(data);
            a.download = 'perdidas_por_producto.xlsx';
            document.body.appendChild(a); a.click(); document.body.removeChild(a);
        },
        error: function(err) { console.error('Error al descargar', err); }
    });
});


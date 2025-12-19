$(document).ready( function () {
  $('#table-pedidos').DataTable({
    "lengthMenu": [10, 50, 100, 200],
    "language":{
    "processing": "Procesando",
    "search": "Buscar:",
    "lengthMenu": "Ver _MENU_ Pedidos",
    "info": "Mirando _START_ a _END_ de _TOTAL_ Pedidos",
    "zeroRecords": "No encontraron resultados",
    "paginate": {
      "first":      "Primera",
      "last":       "Ultima",
      "next":       "Siguiente",
      "previous":   "Anterior"
    }
  }
  });
});

function verPedido(codigo){
  $("#verpedido").modal("show");
  var url = baseurl + "getpedidos/" + codigo ;

  $.ajax({
    url: url,
    method: "GET",
    success: function(data){
      data = JSON.parse(data);
       $("#codigo_pedido").val(data.consecutivo),
       $("#sede_pedido").val(data.sede),
       $("#fecha_pedido").val(data.fecha),
       $("#hora_pedido").val(data.hora),
       $("#tppago_pedido").val(data.tppago),
       $("#celular_pedido").val(data.codigo_cliente),
       $("#total_pedido").val(data.total),
       $("#nombre_pedido").val(data.nombre + ' ' + data.apellido),
       $("#direccion_pedido").val(data.direccion),
       $("#estado_pedido").val(data.estado),
       $("#domicilio_pedido").val(data.domicilio),
       $("#comentarios_pedido").val(data.comentario);
        tableDetallePedido(data.consecutivo);
      }
  })
}

function tableDetallePedido(codigo) {
  var url = baseurl + "getpeditosdetalle/" + codigo;
  const tbody = document.querySelector('.detalle_productos_pedido');
  tbody.innerHTML = '';
  $.ajax({
    url: url,
    method: "GET",
    success: function(data) {
      data = JSON.parse(data);
      data.map((item, index) => {
        const tr = document.createElement('tr');
        const Content = `<td>${index + 1}</td><td>${item.codigo_pedido}</td><td>${item.productonom}</td><td class="text-center">${item.cantidad}</td>`;
        tr.innerHTML = Content;
        tbody.append(tr);
      });
    }
  })
}

$("#Actualizarpedido").on("click", function(){
  var url = baseurl + "actualizarpedido";
  var domicilio = $("#domicilio_pedido").val(),
      codigo_pedido = $("#codigo_pedido").val(),
      estado = $("#estado_pedido").val();
  
  $.ajax({
    url: url,
    method: "POST",
    data: {
      domicilio:domicilio,
      estado: estado,
      codigo_pedido: codigo_pedido
    },
    success: function(){
      $("body").overhang({
        type: "success",
        message: "El pedido se  ha actualizado correctamente"
      });
      setTimeout(reloadPage, 2000);
    },
    error: function (){
      $("body").overhang({
        type: "error",
        message: "Alerta ! Tenemos un problema al conectar con la base de datos verifica tu red.",
      });
    }
  })
});

let intervalo = setInterval(() => {
  pedidoRealTiempo();
}, 2000);

function pedidoRealTiempo() {
  let url = baseurl + "getpedidoreal";
  let contenido = "";
  $.ajax({
    url: url,
    method: "GET",
    success: function(response){
      response = JSON.parse(response);

      response.forEach(item=> {
        var totalact = item.total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        if(item.estado == 'PEDIDO') {
          contenido += '<div class="d-flex border-bottom mb-4 pb-2"><div class="hexagon"><div class="hex-mid hexagon-primary hexagon-xs fa-1x"><i class="fas fa-clock"></i></div></div><div class="ps-4"><h4 class="fw-bold text-primary mb-0">#'+item.consecutivo+' - '+ item.total.toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 0}) +'</h4><h6 class="text-muted">Pedido</h6></div></div>';
        }
        else if(item.estado == 'CANCELADO') {
          contenido = '<div class="d-flex border-bottom mb-4 pb-2"><div class="hexagon"><div class="hex-mid hexagon-danger "><i class="fas fa-times"></i></div></div><div class="ps-4"><h4 class="fw-bold text-danger mb-0">#'+item.consecutivo+' - '+ item.total.toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 0}) +'</h4><h6 class="text-muted">Cancelado</h6></div></div>';
        }
      });

      document.getElementById('contenidotiemporeal').innerHTML = contenido;
      
    },
    error: function (){
      $("body").overhang({
        type: "error",
        message: "Alerta ! Tenemos un problema al conectar con la base de datos verifica tu red.",
      });
    }
  })
}

function reloadPage() {
  location.reload();
}
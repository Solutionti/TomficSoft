const tbody = document.querySelector('.tbody');
let carrito = [];
$("#codigo_barras").focus();

$("#codigo_barras").on("blur", function(){
    var url1 = baseurl + "getproductoventa",
        codigo_barras = $("#codigo_barras").val();
    
    $.ajax({
      url: url1,
      method: "POST",
      data: {
        codigo_barras: codigo_barras
      },
      success: function(data) {
        data = JSON.parse(data);
        
        $("#producto").val(data.nombre);
        $("#precio").val(data.costo);
        $("#cantidad").val(data.saldo);

        const nombre = data.nombre;
        const codigo = data.codigo_barras;
        const precio = data.costo;
        if(data.saldo <= 0){
          $("body").overhang({
            type: "error",
            message: "Alerta! esta apunto de vender un producto sin stock en inventario. ",
          });
        }
        const newItem = {
            nombre: nombre,
            codigo: codigo,
            precio: precio,
            cantidad: 1
        }
        addItemCarrito(newItem);
        $("#codigo_barras").val("");
        $("#codigo_barras").focus();
      }
    });  
});

$("#recibio").on("keyup", function () {
    var recibio = $("#recibio").val().replace(/\./g, "");

    $("#devolver").attr("hidden", true);
    document.getElementById("volver").innerHTML = '<h2 class="text-white text-uppercase">'+ (recibio - totalPedido).toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 0})+'</h2>';
 });

function addItemCarrito(newItem){
    var  inputelemento = tbody.getElementsByClassName('cantidad_products');
    for(let i= 0; i < carrito.length; i++ ){
        if(carrito[i].nombre.trim() === newItem.nombre.trim()){
          carrito[i].cantidad ++;
          const inputValue = inputelemento[i];
          inputValue.value ++;
          carritoTotal();
          return null;
        }
    }
    carrito.push(newItem);
    renderCarrito();
    // $("body").overhang({
    //   type: "success",
    //   message: "Se ha agregado un producto a la venta"
    // });   
}

function renderCarrito(){
    tbody.innerHTML = '';
    carrito.map(item => {
      const tr = document.createElement('tr');
      tr.classList.add('ItemCarrito');
      const Content = `<td></td></td><td>${item.codigo}</td><td class="title">${item.nombre}</td><td><input type="text" value=${item.cantidad}  class="form-control form-control-sm cantidad_products" style="width: 100px"></td><td>$${item.precio.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</td><td><button type="button" class="btn btn-sm btn-danger mt-1 mx-3 delete" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fas fa-trash"></i></button></td>`;
      tr.innerHTML = Content;
      tbody.append(tr);
      tr.querySelector(".delete").addEventListener('click', removeItemCarrito);
      tr.querySelector(".cantidad_products").addEventListener('keyup', sumaCantidad);
  
    })
    carritoTotal()
}

function sumaCantidad(e){
  const sumaInput = e.target;
  const tr = sumaInput.closest(".ItemCarrito");
  const title = tr.querySelector('.title').textContent;
    carrito.forEach(item => {
      if(item.nombre.trim() === title.trim()){
        sumaInput.value < 1 ? (sumaInput.value = ''): sumaInput.value;
        item.cantidad = sumaInput.value;
        carritoTotal();
      }
    });
}

function carritoTotal(){
    let total = 0;
    const itemCartTotal  = document.querySelector('.total-compra');
    carrito.forEach((item) => {
      const precio = Number(item.precio.replace("$", ''));
      total = total + precio*item.cantidad
    });
    $("#compracero").attr("hidden", true);
    $("#total-compra").attr("hidden", false);
    itemCartTotal.innerHTML = '$' + total.toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 0});
    totalPedido = total;
    $("#total").val(totalPedido);
}

function removeItemCarrito(e){
    const buttonDelete = e.target;
    const tr = buttonDelete.closest(".ItemCarrito");
    const title = tr.querySelector('.title').textContent;
    
    for(let i = 0; i < carrito.length; i++){
      if(carrito[i].nombre.trim() === title.trim()){
        carrito.splice(i, 1);
      }
    }
    carritoTotal();
    tr.remove();
  }

function formatearMiles(input) {
  let valor = input.value;
      valor = valor.replace(/\D/g, '');
      valor = valor.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  
  input.value = valor;
}

document.addEventListener("keydown", function(event) {
  
  if(event.ctrlKey && event.keyCode === 32){
    var url = baseurl + "crearventa",
      consecutivo = $("#consecutivo").val(),
      documento = 'FACTURA',
      recibio = $("#recibio").val(),
      total = $("#total").val(),
      tp_pago = "EFECTIVO",
      referencia = '101010',
      sede = "MERCACENTRO N1",
      id_caja = 1,
      descuento = 0,
      transaccion = 0;

      let ventas = [];

      for (let i = 0; i < carrito.length; i++) {
        ventas [i] = carrito[i];
      }

      if(recibio == "") {
        $("#recibio").addClass("is-invalid");
        $("#recibio").focus();
      }
      else if (ventas.length === 0){
        $("body").overhang({
          type: "error",
          message: "Alerta ! Debe ingresar al menos 1 producto a la venta",
        });
      }
      else {
        $.ajax({
          url: url,
          method: "POST",
          data: {
            consecutivo: consecutivo,
            documento: documento,
            recibio: recibio,
            ventas: ventas,
            total: total,
            tppago: tp_pago,
            referencia: referencia,
            sede: sede,
            idcaja: id_caja,
            descuento: descuento,
            transaccion: transaccion
          },
          success: function(data) {
            if (data === "error") {
              $("body").overhang({
                type: "error",
                message: "Usted ya registro una venta con el codigo consecutivo. " + consecutivo ,
              });
            }
            else {
              $("body").overhang({
                type: "success",
                message: "La venta se ha creado correctamente"
              });
            //   if( $('#checkrecibocaja').is(':checked') ) {
            //     facturaVenta(consecutivo);
            //   }
              setTimeout(reloadPage, 3000);
            }
          },
          error: function () {
            $("body").overhang({
              type: "error",
              message: "Alerta ! Tenemos un problema al conectar con la base de datos verifica tu red.",
            });
          }
        });
      }
  }
});

function reloadPage() {
  location.reload();
}

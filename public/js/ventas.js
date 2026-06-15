const tbody = document.querySelector('.tbody');
let carrito = [];

/* ── Search → prod-grid ── */
var searchInput  = document.getElementById('codigo_barras');
var drop         = document.getElementById('ventas-drop');
var searchTimer  = null;
var isSearchMode = false;

searchInput.addEventListener('input', function () {
    var q = this.value.trim();
    clearTimeout(searchTimer);
    if (q.length < 2) {
        if (isSearchMode) {
            isSearchMode = false;
            /* Restore the active pill and category grid */
            var prevCat = typeof currentCat !== 'undefined' ? currentCat : 'todos';
            if (typeof highlightPill === 'function') highlightPill(prevCat === 'todos' ? null : prevCat);
            if (prevCat === 'todos') document.querySelector('.cat-pill[data-cat="todos"]').classList.add('active');
            if (typeof loadCat === 'function') loadCat(prevCat);
        }
        return;
    }

    searchTimer = setTimeout(function () {
        var grid = document.getElementById('prod-grid');
        grid.innerHTML = '<div class="prod-empty"><i class="fas fa-spinner fa-spin"></i> Buscando…</div>';
        isSearchMode = true;

        fetch(baseurl + 'inventarios/buscar?q=' + encodeURIComponent(q))
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (!data.length) {
                    grid.innerHTML = '<div class="prod-empty"><i class="fas fa-search"></i> Sin resultados para "' + q + '".</div>';
                    if (typeof highlightPill === 'function') highlightPill(null);
                    return;
                }
                renderGrid(data);
                /* Highlight the category of the first result */
                if (typeof highlightPill === 'function') highlightPill(data[0].categoria || null);
            });
    }, 250);
});

searchInput.focus();

document.getElementById('btn-limpiar-busqueda').addEventListener('click', function () {
    searchInput.value = '';
    isSearchMode = false;
    var prevCat = typeof currentCat !== 'undefined' ? currentCat : 'todos';
    if (typeof highlightPill === 'function') highlightPill(prevCat === 'todos' ? null : prevCat);
    if (prevCat === 'todos') document.querySelector('.cat-pill[data-cat="todos"]').classList.add('active');
    if (typeof loadCat === 'function') loadCat(prevCat);
    $("#producto").val('');
    $("#precio").val('');
    $("#cantidad").val('');
    searchInput.focus();
});

function seleccionarProducto(p) {
    var saldo = parseFloat(p.saldo) || 0;
    $("#producto").val(p.nombre);
    $("#precio").val(p.costo);
    $("#cantidad").val(saldo);

    if (saldo <= 0) {
        $("body").overhang({ type: "error", message: "Alerta: estás a punto de vender un producto sin stock en inventario." });
    }
    addItemCarrito({ nombre: p.nombre, codigo: p.codigo_barras, precio: p.costo, medida: p.medida || '', cantidad: 1 });
    searchInput.focus();
}

$("#recibio").on("keyup", function () {
    var recibio = $("#recibio").val().replace(/\./g, "");

    $("#devolver").attr("hidden", true);
    document.getElementById("volver").innerHTML = '<h2 class="text-white text-uppercase">$'+ (recibio - totalPedido).toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 0})+'</h2>';
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
      const medidaBadge = item.medida
        ? `<span style="background:#f0f7ec;color:#2d6622;padding:2px 7px;border-radius:50px;font-size:10px;font-weight:700;">${item.medida}</span>`
        : '—';
      tr.innerHTML =
        `<td class="title" style="font-weight:600;font-size:12px;">${item.nombre}</td>` +
        `<td style="text-align:center;">${medidaBadge}</td>` +
        `<td><input type="text" value="${item.cantidad}" class="qty-input cantidad_products"></td>` +
        `<td class="price-cell">$${item.precio.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</td>` +
        `<td><button type="button" class="btn-row-del delete" title="Eliminar"><i class="fas fa-trash"></i></button></td>`;
      tbody.append(tr);
      tr.querySelector(".delete").addEventListener('click', removeItemCarrito);
      tr.querySelector(".cantidad_products").addEventListener('keyup', sumaCantidad);
    });
    carritoTotal();
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

function crearVenta() {
    var url = baseurl + "crearventa",
      consecutivo = $("#consecutivo").text(),
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
              if( $('#checkrecibocaja').is(':checked') ) {
                facturaVenta(consecutivo);
              }
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

document.addEventListener("keydown", function(event) {
  if(event.ctrlKey && event.keyCode === 32){ crearVenta(); }
});

function facturaVenta(consecutivo) {
  url = baseurl  + "generarpdfventas/" + consecutivo;
  window.open(url, "_blank", " width=500, height=400");
}

function reloadPage() {
  location.reload();
}

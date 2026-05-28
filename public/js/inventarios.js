// $("#tabla_inventarios").DataTable({
//   "lengthMenu": [11, 50, 100, 200],
//   "language":{
//   "processing": "Procesando",
//   "search": "Buscar:",
//   "lengthMenu": "Ver _MENU_ Productos",
//   "info": "Viendo _START_ a _END_ de _TOTAL_ Productos",
//   "zeroRecords": "No encontraron resultados",
//   "paginate": {
//     "first":      "Primera",
//     "last":       "Ultima",
//     "next":       "Siguiente",
//     "previous":   "Anterior"
//   }
//  }
// });

function eliminarProducto(id) {
    let url = baseurl + "eliminarproducto" ;
   $("body").overhang({
     type: "confirm",
     primary: "#9a3de0",
     accent: "#c5b8da",
     yesColor: "#0033c4",
     yesMessage: "Sí",
     noMessage: "No",
     message: "¿Desea eliminar el producto?",
     overlay: true,
     callback: function (value) {
      if (value) {
        //si
        $.ajax({
          url: url,
          method: "POST",
          data: {id: id},
          success: function(response){
            $("body").overhang({
             type: "success",
             message: response.message
            });

            setTimeout(reloadPage, 3000);
          },
          error: function(response){
            $("body").overhang({
            type: "error",
            message: "Alerta ! Tenemos un problema al conectar con la base de datos verifica tu red.",
          });
          }
        });
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
    medida = $("#medida_inventario").val(),
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
        medida: medida,
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

  function mostrarDatosProductosModal(id) {
    //creamos la ruta
    let url = baseurl + "obtenerdatoproducto/" + id;

    $.ajax({
      url: url,
      method: "GET",
      success: function(response){
        $("#actualizarProducto").modal('show');
        console.log(response);

        $("#categoria_editar").val(response[0].categoria);
        $("#subcategoria_editar").val(response[0].subcategoria);
        $("#grupo_editar").val(response[0].grupo);
        $("#subgrupo_editar").val(response[0].subgrupo);
        $("#nombre_editar").val(response[0].nombre);
        $("#referencia_editar").val(response[0].referencia);
        $("#codigo_editar").val(response[0].codigo_interno);
        $("#barras_editar").val(response[0].codigo_barras);
        $("#nit_editar").val(response[0].nit);
        $("#proveedor_editar").val(response[0].proveedor);
        $("#saldo_editar").val(response[0].saldo);
        $("#costo_editar").val(response[0].costo);
        $("#medida_editar").val(response[0].medida);
      },
      error: function(response){
        $("body").overhang({
        type: "error",
        message: "Alerta ! Tenemos un problema al conectar con la base de datos verifica tu red.",
        });
      }
    });
  }
  function actualizarProductos(){
    var categoria = $("#categoria_editar").val(),
    subcategoria = $("#subcategoria_editar").val(),
    grupo = $("#grupo_editar").val(),
    subgrupo = $("#subgrupo_editar").val(),
    nombre = $("#nombre_editar").val(),
    referencia = $("#referencia_editar").val(),
    codigointerno = $("#codigo_editar").val(),
    codigobarras = $("#barras_editar").val(),
    nit = $("#nit_editar").val(),
    proveedor = $("#proveedor_editar").val(),
    saldo = $("#saldo_editar").val(),
    medida = $("#medida_editar").val(),
    costo = $("#costo_editar").val();

    let url = baseurl + "actualizarproductos";

    $.ajax({
      url: url,
      method: 'POST',
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
        medida: medida,
        costo: costo
      },
      success: function (response){
        $("body").overhang({
          type: "success",
          message: "El producto se ha actualizado correctamente en la base de datos."
        });
        setTimeout(reloadPage, 3000);
      },
      error: function (response){
        $("body").overhang({
          type: "error",
          message: "Ha ocurrido un error al actualizar el producto."
        });
      }
    });
  }

  /* ── Autocomplete de productos (entrada y salida) ── */
  function initProductoAC(inputId, fillFn) {
    var $input = $(inputId);
    if (!$input.length) return;

    $input.attr('autocomplete', 'off');

    // Dropdown container
    var $drop = $('<ul class="producto-ac-list"></ul>');
    $input.after($drop);

    var timer = null;
    var activeIdx = -1;

    function cerrar() { $drop.hide().empty(); activeIdx = -1; }

    function seleccionar(p) {
      $input.val(p.codigo_barras);
      cerrar();
      fillFn(p);
    }

    $input.on('input', function () {
      var q = $.trim($(this).val());
      clearTimeout(timer);
      activeIdx = -1;
      if (q.length < 2) { cerrar(); return; }

      timer = setTimeout(function () {
        $.getJSON(baseurl + 'inventarios/buscar', { q: q })
          .done(function (data) {
            $drop.empty();
            if (!data.length) { cerrar(); return; }
            $.each(data, function (i, p) {
              $('<li>')
                .html(
                  '<span class="ac-nombre">' + p.nombre + '</span>' +
                  '<span class="ac-cod">' + p.codigo_barras + '</span>'
                )
                .data('p', p)
                .on('mousedown', function (e) {
                  e.preventDefault();
                  seleccionar($(this).data('p'));
                })
                .appendTo($drop);
            });
            $drop.show();
          });
      }, 260);
    });

    $input.on('keydown', function (e) {
      var $items = $drop.find('li');
      if (!$items.length) return;
      if (e.key === 'ArrowDown') {
        activeIdx = Math.min(activeIdx + 1, $items.length - 1);
        $items.removeClass('ac-active').eq(activeIdx).addClass('ac-active');
        e.preventDefault();
      } else if (e.key === 'ArrowUp') {
        activeIdx = Math.max(activeIdx - 1, 0);
        $items.removeClass('ac-active').eq(activeIdx).addClass('ac-active');
        e.preventDefault();
      } else if (e.key === 'Enter' && activeIdx >= 0) {
        e.preventDefault();
        seleccionar($items.eq(activeIdx).data('p'));
      } else if (e.key === 'Escape') {
        cerrar();
      }
    });

    $input.on('blur', function () {
      setTimeout(cerrar, 180);
    });
  }

  /* Función de relleno para ENTRADA */
  function rellenarIngreso(p) {
    $("#stock_ingreso").val(p.saldo);
    $("#nombre_ingreso").val(p.nombre);
    $("#precio_ingreso").val(p.costo);
    $("#sede_ingreso").val(p.nit);
  }

  /* Función de relleno para SALIDA */
  function rellenarSalida(p) {
    $("#stock_salida").val(p.saldo);
    $("#nombre_salida").val(p.nombre);
    $("#precio_salida").val(p.costo);
    $("#sede_salida").val(p.nit);
  }

  initProductoAC('#producto_ingreso', rellenarIngreso);
  initProductoAC('#producto_salida',  rellenarSalida);

    function ingresarEntradaProductos(){
      let url = baseurl + "ingresarentrada";
      var producto = $("#producto_ingreso").val(),
      cantidad = $("#cantidad_ingreso").val(),
      valor = $("#valor_ingreso").val(),
      sede = $("#sede_ingreso").val(),
      motivo = $("#motivo_ingreso").val(),
      stock = $("#stock_ingreso").val(),
      comentarios = $("#comentarios_ingreso").val();

      $.ajax({
        url: url,
        method: "POST",
        data: {
          producto: producto,
          cantidad: cantidad,
          valor: valor,
          sede: sede,
          motivo: motivo,
          comentarios: comentarios,
          stock: stock
        },
        success: function (response){
          $("body").overhang({
            type: "success",
            message: "La entrada de productos se ha registrado correctamente."
          });
          setTimeout(reloadPage, 3000);
        },
        error: function (response){
          $("body").overhang({    
            type: "error",
            message: "Ha ocurrido un error al registrar la entrada de productos."
          });
        }
      });
    }

    //SALIDA DE PRODUCTOS — relleno vía autocomplete (initProductoAC arriba)

    function ingresarSalidaProductos(){
      let url = baseurl + "ingresarsalida";
      var producto = $("#producto_salida").val(),
      cantidad = $("#cantidad_salida").val(),
      valor = $("#valor_salida").val(),
      sede = $("#sede_salida").val(),
      motivo = $("#motivo_salida").val(),
      stock = $("#stock_salida").val(),
      comentarios = $("#comentarios_salida").val();

      $.ajax({
        url: url,
        method: "POST",
        data: {
          producto: producto,
          cantidad: cantidad,
          valor: valor,
          sede: sede,
          motivo: motivo,
          comentarios: comentarios,
          stock: stock
        },
        success: function (response){
          $("body").overhang({
            type: "success",
            message: "La salida de productos se ha registrado correctamente."
          });
          setTimeout(reloadPage, 3000);
        },
        error: function (response){
          $("body").overhang({    
            type: "error",
            message: "Ha ocurrido un error al registrar la entrada de productos."
          });
        }
      });
    }

    function ajustarInventario() {
      $("body").overhang({
        type: "confirm",
        primary: "#9a3de0",
        accent: "#c5b8da",
        yesColor: "#0033c4",
        yesMessage: "Sí",
        noMessage: "No",
        message: "¿Desea ajustar el inventario con el último conteo realizado?",
        overlay: true,
        callback: function (value) {
          if (!value) return;

          var overlay = document.getElementById('ajuste-overlay');
          var bar     = document.getElementById('ajuste-bar');
          var pct     = document.getElementById('ajuste-pct');
          var label   = document.getElementById('ajuste-label');

          /* Mostrar overlay */
          overlay.style.display = 'flex';
          bar.style.width = '0%';
          pct.textContent = '0%';
          label.textContent = 'Iniciando ajuste…';

          /* Animación de progreso simulada hasta 85% */
          var progress = 0;
          var messages = [
            [15, 'Leyendo conteos…'],
            [35, 'Comparando diferencias…'],
            [55, 'Actualizando saldos…'],
            [75, 'Guardando cambios…'],
          ];
          var timer = setInterval(function () {
            var inc = progress < 30 ? 7 : progress < 60 ? 4 : progress < 80 ? 1.5 : 0.3;
            progress = Math.min(progress + inc, 85);
            bar.style.width = progress + '%';
            pct.textContent = Math.round(progress) + '%';
            messages.forEach(function (m) {
              if (progress >= m[0]) label.textContent = m[1];
            });
          }, 180);

          $.ajax({
            url: baseurl + "ajustarinventario",
            method: "POST",
            success: function (response) {
              clearInterval(timer);
              bar.style.transition = 'width .4s ease';
              bar.style.width = '100%';
              pct.textContent = '100%';
              label.textContent = '¡Ajuste completado!';
              setTimeout(function () {
                overlay.style.display = 'none';
                $("body").overhang({ type: "success", message: response.message });
                setTimeout(reloadPage, 3000);
              }, 700);
            },
            error: function () {
              clearInterval(timer);
              overlay.style.display = 'none';
              $("body").overhang({
                type: "error",
                message: "Alerta! Tenemos un problema al conectar con la base de datos.",
              });
            }
          });
        }
      });
    }

  function reloadPage() {
  location.reload();
}






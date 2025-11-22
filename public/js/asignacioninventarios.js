
$("#table-productos").DataTable({
  "lengthMenu": [5, 50, 100, 200],
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

document.getElementById('selectAll').addEventListener('change', function() {
    let checkboxes = document.querySelectorAll('.fila');
    checkboxes.forEach(cb => cb.checked = this.checked);
});

document.getElementById('btnObtener').addEventListener('click', function() {
    let seleccionados = [];
    let checkboxes = document.querySelectorAll('.fila:checked');
    
    checkboxes.forEach(cb => {
        seleccionados.push(cb.value);
    });
    var url = baseurl + '/asinarproductosinventario',
        id_inventario = $('#id_inventario_modal').val();

    if(seleccionados.length == 0) {
      $("body").overhang({
          type: "error",
          message: "Alerta ! Por favor seleccione al menos 1 producto asociar al inventario",
      });
    }
    else {
      $.ajax({
        url: url,
        method: "POST",
        data: {
          codigoinventario: id_inventario,
          codigoproducto: seleccionados
        },
        success: function(response) {
          if(response.status == 'success'){
            $("body").overhang({
              type: "success",
              message:  response.message
            });
            setTimeout(reloadPage, 3000);
          }
        },
        error: function() {
          $("body").overhang({
            type: "error",
            message: "Alerta ! Tenemos un problema al conectar con la base de datos verifica tu red.",
          });
        }
      });
    }
});

function crearInventarios(){
    //asignar la ruta de el controlador
    var url = baseurl + '/crearinventario';
    // recuper los  valores de los input del formulario
    var fecha = $('#fecha_agregar_inventario').val(),
        conteos = $('#conteos_agregar_inventario').val(),
        descripcion = $('#observacion_agregar_inventario').val();
    // hacer la validacion de los campos del imput
    // llamar la funcion ajax que me ejecuta el controlador
     $("#creinventario").prop("disabled", true);
     $("#spinnerinventarios").prop("hidden", false);
        $.ajax({
          //url
          url: url,
          //metodo
          method:"POST",
          //data
          data: {
            //definicion : valor
            fecha: fecha,
            conteos: conteos,
            descripcion: descripcion
          },
          //success
          success: function(response) {
            $("body").overhang({
              type: "success",
              message: "El inventario se ha creado en la base de datos correctamente." 
            });
            $("#creinventario").prop("disabled", false);
            $("#spinnerinventarios").prop("hidden", true);
            setTimeout(reloadPage, 3000);
          },
          //error
          error: function() {
            $("body").overhang({
              type: "error",
              message: "Alerta ! Tenemos un problema al conectar con la base de datos verifica tu red.",
            });
            $("#creinventario").prop("disabled", false);
            $("#spinnerinventarios").prop("hidden", true);
          }
        });
}

function asociarDatosModalProductos(id){
  var id = $("#id_inventario_modal").val(id);
  $("#listaproductos").modal('show');
}

function asociarDatosModalConteos(id){
  var id = $("#id_conteo_modal").val(id);
  $("#modalConteos").modal('show');
}

function asociarDatosModalProcesos(){
  $("#modalProceso").modal('show');
}

function buscarProductosAsignar() {
  var url = baseurl + 'buscarproductos';
  var grupo = $('#grupo_filtro').val(),
      subgrupo = $('#subgrupo_filtro').val(),
      subcategoria = $('#subcategoria_filtro').val(),
      categoria = $('#categoria_filtro').val();

  $("#btnconsultaproductos").prop("disabled", true);
  $("#spinnerproducto").prop("hidden", false);
  
  $.ajax({
    url: url,
    method: "POST",
    data: {
      grupo: grupo,
      subgrupo: subgrupo,
      subcategoria: subcategoria,
      categoria: categoria
    },
    success: function(response) {
      console.log(response);
      const tbody = document.querySelector("#tabla_productos_asignar");
      tbody.innerHTML = "";
      response.forEach(element => {
        let contenido = `<tr><td><div class="form-check"><input class="form-check-input mx-4 borde fila" type="checkbox" value="${element.codigo_barras}"></div></td><td>${element.codigo_interno}</td><td>${element.codigo_barras}</td><td><div class="row"><div class="d-flex px-2 py-1"><div><img src="https://png.pngtree.com/png-clipart/20190613/original/pngtree-shopping-bag-with-goods-retail-logo-design-template-vector-png-image_3555851.jpg" class="avatar avatar-sm me-3"></div><div class="d-flex flex-column justify-content-center"><h6 class="mb-0 text-xs">${element.nombre}</h6><p class="text-xs text-dark mb-0">${element.codigo_barras}</p></div></div></div></td><td>${element.proveedor}</td><td>${element.categoria}</td><td>${element.subcategoria}</td><td><label class="badge badge-success">${element.estado}</label></td></tr>`;
        tbody.innerHTML += contenido;
      });

      $("#btnconsultaproductos").prop("disabled", false);
      $("#spinnerproducto").prop("hidden", true);
    },
    error: function() {
      $("body").overhang({
        type: "error",
        message: "Alerta ! Tenemos un problema al conectar con la base de datos verifica tu red.",
      });

      $("#btnconsultaproductos").prop("disabled", false);
      $("#spinnerproducto").prop("hidden", true);
    }

  });
}

function asignarUbicacionInventario() {
  var url = baseurl + '/asignarubicacioninventario',
      id_conteo_modal = $('#id_conteo_modal').val(),
      ubicacion = $('#ubicacion_conteo').val(),
      localizacion = $('#localizacion_conteo').val(),
      numerolocalizacion = $('#numero_conteo').val(),
      observacion = $('#observacion_agregar_inventarios').val();

  $.ajax({
    url: url,
    method: "POST",
    data: {
      codigoinventario: id_conteo_modal,
      ubicacion: ubicacion,
      localizacion: localizacion,
      numerolocalizacion: numerolocalizacion,
      observacion: observacion
    },
    success: function(response) {
      if(response.status == 'success'){
          $("body").overhang({
            type: "success",
            message:  response.message
          });
          setTimeout(reloadPage, 3000);
        }
    },
    error: function() {
      $("body").overhang({
        type: "error",
        message: "Alerta ! Tenemos un problema al conectar con la base de datos verifica tu red.",
     });
    }
  });
}

function procesoDatosModal(id) {
  var url = baseurl + 'getinventarioid/' + id;

  $.ajax({
    url: url,
    method: "GET",
    success: function(response) {
      $("#nlocalizacion_asignacion").val(response[0].numerolocalizacion);
      $("#localizacion_asignacion").val(response[0].localizacion);
      $("#ubicacion_asignacion").val(response[0].ubicacion);
      $("#codigo_asignacion").val(response[0].codigo_inventario);
      $("#observacion_asignacion").val(response[0].observacion);
      $("#fecha_asignacion").val(response[0].fecha);
      $("#nconteos_asignacion").val(response[0].conteos);
    },
    error: function() {
      $("body").overhang({
        type: "error",
        message: "Alerta ! Tenemos un problema al conectar con la base de datos verifica tu red.",
      });
    }
  });
}


function asignarUsuarioInventario() {
  
    let usuario1 = [];
    let usuario2 = [];
    let checkboxes1 = document.querySelectorAll('#tablaconteo1usuario .chk:checked');
    let checkboxes2 = document.querySelectorAll('#tablaconteo2usuario .fila:checked');
    let conteos = $("#nconteos_asignacion").val();
    let usuarioo2 = '';

    checkboxes1.forEach(chk => {
        let id = chk.value;
        usuario1.push({ id });
    });

    checkboxes2.forEach(fila => {
        let id = fila.value;
        usuario2.push({ id });
    });

     if (checkboxes2.length == 0) {
      usuarioo2 = 0;
    }
    else {
      usuarioo2 = usuario2[0].id
    }

    if(conteos == 2 && checkboxes2.length == 0) {
      $("body").overhang({
          type: "error",
          message: "Alerta ! Por favor seleccione el usuario hacer el conteo #2",
      });
    }

    else if (conteos == 1 && checkboxes2.length > 0) {
      $("body").overhang({
          type: "error",
          message: "Alerta ! el conteo es de 1 solo usuario",
      });
    }

    else if(checkboxes1.length == 0) {
      $("body").overhang({
          type: "error",
          message: "Alerta ! Por favor seleccione el usuario hacer el conteo #1",
      });
    }
    else {
      $.ajax({
        url: baseurl + 'asignarusuariosinventario',
        method: "POST",
        data: {
          usuario1: usuario1[0].id,
          usuario2: usuarioo2,
          codigo_inventario: $('#codigo_asignacion').val()
        },
        success: function(response) {
          if(response.status == 'success'){
            $("body").overhang({
              type: "success",
              message:  response.message
            });
            setTimeout(reloadPage, 3000);
          }
        },
        error: function() {
          $("body").overhang({
            type: "error",
            message: "Alerta ! Tenemos un problema al conectar con la base de datos verifica tu red.",
          });
        }
      });
    }
  }

function getnumerolocalizacion() {
  var localizacion = $("#localizacion_conteo").val();
  var url = baseurl + 'getnumerolocalizacion/' + localizacion;

  $.ajax({
        url: url,
        method: "GET",
        success: function(response) {
         $("#numero_conteo").val(parseInt(response[0].cantidad) + 1);
        },
        error: function() {
          $("body").overhang({
            type: "error",
            message: "Alerta ! Tenemos un problema al conectar con la base de datos verifica tu red.",
          });
        }
      });
}

function procesoDatosModalActualizar(codigo) {
  var url = baseurl + 'getinventarioid/' + codigo;

  $.ajax({
    url: url,
    method: "GET",
    success: function(response) {
      
      $("#codigo_actualizar_inventario").val(response[0].codigo_inventario);
      $("#fecha_actualizar_inventario").val(response[0].fecha_inicio);
      $("#conteos_actualizar_inventario").val(response[0].conteos);
      $("#observacion_actualizar_inventario").val(response[0].observacion);
    },
    error: function() {
      $("body").overhang({
        type: "error",
        message: "Alerta ! Tenemos un problema al conectar con la base de datos verifica tu red.",
      });
    }
  });
}

function actualizarInventarios() {
    var url = baseurl + '/actualizarinventario';
    var codigo = $('#codigo_actualizar_inventario').val(),
        fecha = $('#fecha_actualizar_inventario').val(),
        conteos = $('#conteos_actualizar_inventario').val(),
        descripcion = $('#observacion_actualizar_inventario').val();
     
        $.ajax({
          url: url,
          method:"POST",
          data: {
            codigo: codigo,
            fecha: fecha,
            conteos: conteos,
            descripcion: descripcion
          },
          success: function(response) {
            $("body").overhang({
              type: "success",
              message: "El inventario se ha actualizado en la base de datos correctamente."
            });
           
            setTimeout(reloadPage, 3000);
          },
          error: function() {
            $("body").overhang({
              type: "error",
              message: "Alerta ! Tenemos un problema al conectar con la base de datos verifica tu red.",
            });
          }
        });
}

function reloadPage() {
  location.reload();
}






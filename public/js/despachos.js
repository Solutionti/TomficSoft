(function () {
  'use strict';

  var solicitudCargadaId = null;

  var btnCargar   = document.getElementById('des-btn-cargar');
  var btnGuardar  = document.getElementById('des-btn-guardar');
  var inputCod    = document.getElementById('des-cod-solicitud');
  var tbody       = document.getElementById('des-tbody');
  var emptyRow    = document.getElementById('des-empty-row');
  var countBadge  = document.getElementById('des-count');
  var infoWrap    = document.getElementById('des-solicitud-info');
  var infoEstado  = document.getElementById('des-info-estado');
  var infoFecha   = document.getElementById('des-info-fecha');
  var infoCodigo  = document.getElementById('des-info-codigo');
  var alerta      = document.getElementById('des-alerta');

  if (!btnCargar) return;

  function mostrarAlerta(msg) {
    alerta.textContent = msg;
    alerta.style.display = 'block';
    setTimeout(function () { alerta.style.display = 'none'; }, 4000);
  }

  function limpiarTabla() {
    tbody.querySelectorAll('tr:not(#des-empty-row)').forEach(function (f) { f.remove(); });
    emptyRow.style.display = '';
    countBadge.textContent = '0 productos';
    solicitudCargadaId = null;
    btnGuardar.disabled = true;
    infoWrap.style.display = 'none';
  }

  /* ── Cargar solicitud ── */
  btnCargar.addEventListener('click', function () {
    var cod = parseInt(inputCod.value, 10);
    if (!cod || cod <= 0) { mostrarAlerta('Ingresa un código de solicitud válido.'); return; }

    btnCargar.disabled = true;
    btnCargar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cargando…';
    limpiarTabla();

    fetch('/despachos/solicitud/' + cod)
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data.status !== 'success') {
          mostrarAlerta(data.message || 'No se encontró la solicitud.');
          return;
        }

        solicitudCargadaId = data.solicitud.codigo_solicitud;

        infoCodigo.textContent = data.solicitud.codigo_solicitud;
        infoEstado.textContent = data.solicitud.estado;
        infoFecha.textContent  = (data.solicitud.fecha_solicitud || '').slice(0, 10);
        infoWrap.style.display = 'block';

        if (!data.detalle || !data.detalle.length) {
          mostrarAlerta('La solicitud no tiene productos en el detalle.');
          return;
        }

        emptyRow.style.display = 'none';
        data.detalle.forEach(function (item, i) {
          var tr = document.createElement('tr');
          tr.dataset.productoId     = item.producto_id;
          tr.dataset.nombreProducto = item.nombre || ('Producto ' + item.producto_id);
          tr.innerHTML =
            '<td style="color:var(--muted);font-size:12px;text-align:center;">' + (i + 1) + '</td>' +
            '<td><code style="font-size:12px;">' + (item.codigo_interno || item.producto_id) + '</code></td>' +
            '<td style="font-weight:600;">' + (item.nombre || '—') + '</td>' +
            '<td style="text-align:center;font-weight:700;color:var(--purple-700);">' + item.cantidad_solicitada + '</td>' +
            '<td style="text-align:center;">' +
              '<input type="number" class="des-qty" min="0" max="' + item.cantidad_solicitada + '" value="0"' +
              ' style="width:70px;padding:5px 8px;text-align:center;border:1.5px solid var(--border);border-radius:6px;font-size:13px;font-weight:700;color:var(--purple-700);outline:none;">' +
            '</td>' +
            '<td>' +
              '<input type="text" class="des-comentario-item" placeholder="Opcional"' +
              ' style="width:100%;padding:5px 10px;border:1.5px solid var(--border);border-radius:6px;font-size:12px;outline:none;">' +
            '</td>';
          tbody.appendChild(tr);
        });

        countBadge.textContent = data.detalle.length + ' producto' + (data.detalle.length !== 1 ? 's' : '');

        if (data.solicitud.estado === 'Aprobada') {
          tbody.querySelectorAll('.des-qty, .des-comentario-item').forEach(function (inp) {
            inp.disabled = true;
            inp.style.background = '#f3f4f6';
            inp.style.cursor = 'not-allowed';
          });
          mostrarAlerta('Esta solicitud ya fue despachada (estado: Aprobada). No se puede modificar.');
        } else {
          btnGuardar.disabled = false;
        }
      })
      .catch(function () { mostrarAlerta('Error de conexión al cargar la solicitud.'); })
      .finally(function () {
        btnCargar.disabled = false;
        btnCargar.innerHTML = '<i class="fas fa-download"></i> Buscar';
      });
  });

  inputCod.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') btnCargar.click();
  });

  /* ── Guardar despacho ── */
  btnGuardar.addEventListener('click', function () {
    if (!solicitudCargadaId) return;

    var comentarioGlobal = (document.getElementById('des-comentario-global').value || '').trim();
    var items = [];

    tbody.querySelectorAll('tr:not(#des-empty-row)').forEach(function (tr) {
      var qty = parseInt(tr.querySelector('.des-qty').value, 10) || 0;
      if (qty <= 0) return;
      var comentario = (tr.querySelector('.des-comentario-item').value || '').trim() || comentarioGlobal;
      items.push({
        producto_id:        tr.dataset.productoId,
        nombre_producto:    tr.dataset.nombreProducto,
        cantidad_despachada: qty,
        comentario:         comentario,
      });
    });

    if (!items.length) {
      mostrarAlerta('Ingresa al menos una cantidad mayor a 0 para despachar.');
      return;
    }

    btnGuardar.disabled = true;
    btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando…';

    fetch('/despachos/guardar', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ solicitud_id: solicitudCargadaId, items: items }),
    })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data.status === 'success') {
          var modal = bootstrap.Modal.getInstance(document.getElementById('modaldespachos'));
          if (modal) modal.hide();
          limpiarTabla();
          inputCod.value = '';
          if (typeof showToast === 'function') showToast('Despacho registrado correctamente.', 'success');
          else alert('Despacho registrado correctamente.');
        } else {
          mostrarAlerta(data.message || 'No se pudo guardar el despacho.');
        }
      })
      .catch(function () { mostrarAlerta('Error de conexión al guardar.'); })
      .finally(function () {
        btnGuardar.disabled = false;
        btnGuardar.innerHTML = '<i class="fas fa-save"></i> Registrar despacho';
      });
  });

  /* Limpiar al cerrar el modal */
  var modal = document.getElementById('modaldespachos');
  if (modal) {
    modal.addEventListener('hidden.bs.modal', function () {
      limpiarTabla();
      inputCod.value = '';
      alerta.style.display = 'none';
    });
  }
})();

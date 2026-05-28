(function () {
  'use strict';

  function fmt(n) {
    return '$' + parseFloat(n || 0).toLocaleString('es-CO', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
  }

  function toast(msg, type) {
    if (typeof showToast === 'function') showToast(msg, type || 'success');
    else alert(msg);
  }

  /* ══════════════════════════════════════
     TABS
  ══════════════════════════════════════ */
  var tabBtns  = document.querySelectorAll('[data-cmp-tab]');
  var tabPanes = document.querySelectorAll('[data-cmp-pane]');

  tabBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      var target = this.dataset.cmpTab;
      tabBtns.forEach(function (b)  { b.classList.remove('active'); });
      tabPanes.forEach(function (p) { p.style.display = 'none'; });
      this.classList.add('active');
      document.querySelector('[data-cmp-pane="' + target + '"]').style.display = '';
    });
  });

  /* ══════════════════════════════════════
     MODAL COTIZACIÓN
  ══════════════════════════════════════ */
  (function () {
    var searchInput = document.getElementById('cot-search');
    var searchWrap  = document.getElementById('cot-search-wrap');
    var dropdown    = document.getElementById('cot-dropdown');
    var tbody       = document.getElementById('cot-tbody');
    var emptyRow    = document.getElementById('cot-empty-row');
    var totalEl     = document.getElementById('cot-total');
    var btnGuardar  = document.getElementById('cot-btn-guardar');
    var alerta      = document.getElementById('cot-alerta');

    if (!searchInput) return;

    var items = [];
    var searchTimeout = null;

    function mostrarAlerta(msg) {
      alerta.textContent = msg;
      alerta.style.display = 'block';
      setTimeout(function () { alerta.style.display = 'none'; }, 4000);
    }

    function renderTabla() {
      tbody.querySelectorAll('tr:not(#cot-empty-row)').forEach(function (r) { r.remove(); });

      if (!items.length) {
        emptyRow.style.display = '';
        totalEl.textContent = '$0';
        btnGuardar.disabled = true;
        return;
      }

      emptyRow.style.display = 'none';
      var total = 0;

      items.forEach(function (item, i) {
        var sub = item.cantidad * item.precio;
        total += sub;
        var tr = document.createElement('tr');
        tr.dataset.idx = i;
        tr.innerHTML =
          '<td style="color:#7c6fa0;font-size:12px;text-align:center;">' + (i + 1) + '</td>' +
          '<td><code style="font-size:12px;">' + (item.codigo || '—') + '</code></td>' +
          '<td style="font-weight:600;">' + item.nombre + '</td>' +
          '<td style="text-align:center;">' +
            '<input type="number" min="1" value="' + item.cantidad + '" data-field="cantidad" data-idx="' + i + '" class="cot-inp" style="width:65px;text-align:center;padding:4px 6px;border:1.5px solid var(--border);border-radius:6px;font-size:13px;outline:none;">' +
          '</td>' +
          '<td style="text-align:center;">' +
            '<input type="number" min="0" step="100" value="' + item.precio + '" data-field="precio" data-idx="' + i + '" class="cot-inp" style="width:100px;text-align:center;padding:4px 6px;border:1.5px solid var(--border);border-radius:6px;font-size:13px;outline:none;">' +
          '</td>' +
          '<td style="text-align:right;font-weight:700;color:var(--purple-700);">' + fmt(sub) + '</td>' +
          '<td style="text-align:center;">' +
            '<button class="btn-action btn-action-del cot-btn-del" data-idx="' + i + '" title="Quitar" style="width:26px;height:26px;border-radius:6px;">' +
              '<i class="fas fa-times" style="font-size:11px;"></i>' +
            '</button>' +
          '</td>';
        tbody.appendChild(tr);
      });

      totalEl.textContent = fmt(total);
      btnGuardar.disabled = false;

      tbody.querySelectorAll('.cot-inp').forEach(function (inp) {
        inp.addEventListener('change', function () {
          var idx = +this.dataset.idx;
          items[idx][this.dataset.field] = parseFloat(this.value) || (this.dataset.field === 'cantidad' ? 1 : 0);
          renderTabla();
        });
      });

      tbody.querySelectorAll('.cot-btn-del').forEach(function (btn) {
        btn.addEventListener('click', function () {
          items.splice(+this.dataset.idx, 1);
          renderTabla();
        });
      });
    }

    /* Autocomplete */
    searchInput.addEventListener('input', function () {
      clearTimeout(searchTimeout);
      var q = this.value.trim();
      if (q.length < 2) { dropdown.style.display = 'none'; return; }

      searchTimeout = setTimeout(function () {
        fetch('/inventarios/buscar?q=' + encodeURIComponent(q))
          .then(function (r) { return r.json(); })
          .then(function (data) {
            dropdown.innerHTML = '';
            if (!data.length) {
              dropdown.innerHTML = '<div style="padding:10px 14px;color:#7c6fa0;font-size:12px;">Sin resultados</div>';
            } else {
              data.forEach(function (p) {
                var d = document.createElement('div');
                d.style.cssText = 'padding:9px 14px;cursor:pointer;font-size:13px;border-bottom:1px solid #f0f7ec;display:flex;justify-content:space-between;align-items:center;transition:background .15s;';
                d.innerHTML =
                  '<div><strong>' + p.nombre + '</strong><br>' +
                  '<span style="font-size:11px;color:#7c6fa0;">' + (p.codigo_interno || p.codigo_barras) + '</span></div>' +
                  '<span style="font-size:12px;color:var(--purple-600);font-weight:600;">' + fmt(p.costo) + '</span>';
                d.addEventListener('mouseenter', function () { this.style.background = '#f0f7ec'; });
                d.addEventListener('mouseleave', function () { this.style.background = ''; });
                d.addEventListener('click', function () {
                  var existing = items.find(function (x) { return x.productoId === p.codigo_barras; });
                  if (existing) {
                    existing.cantidad++;
                  } else {
                    items.push({
                      productoId: p.codigo_barras,
                      codigo:     p.codigo_interno || p.codigo_barras,
                      nombre:     p.nombre,
                      cantidad:   1,
                      precio:     parseFloat(p.costo) || 0,
                    });
                  }
                  searchInput.value = '';
                  dropdown.style.display = 'none';
                  renderTabla();
                });
                dropdown.appendChild(d);
              });
            }
            dropdown.style.display = 'block';
          })
          .catch(function () { dropdown.style.display = 'none'; });
      }, 280);
    });

    document.addEventListener('click', function (e) {
      if (searchWrap && !searchWrap.contains(e.target)) dropdown.style.display = 'none';
    });

    /* Guardar */
    btnGuardar.addEventListener('click', function () {
      var proveedor = document.getElementById('cot-proveedor').value.trim();
      var fecha     = document.getElementById('cot-fecha').value;
      if (!proveedor) { mostrarAlerta('Ingresa el nombre del proveedor.'); return; }
      if (!fecha)     { mostrarAlerta('Selecciona la fecha.'); return; }
      if (!items.length) { mostrarAlerta('Agrega al menos un producto.'); return; }

      btnGuardar.disabled = true;
      btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando…';

      var payload = {
        proveedor:   proveedor,
        nit:         document.getElementById('cot-nit').value.trim(),
        fecha:       fecha,
        observacion: document.getElementById('cot-obs').value.trim(),
        items: items.map(function (it) {
          return {
            producto_id:     it.productoId,
            nombre_producto: it.nombre,
            cantidad:        it.cantidad,
            precio_unitario: it.precio,
            subtotal:        it.cantidad * it.precio,
          };
        }),
      };

      fetch('/compras/cotizacion/guardar', {
        method:  'POST',
        headers: { 'Content-Type': 'application/json' },
        body:    JSON.stringify(payload),
      })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data.status === 'success') {
          var modal = bootstrap.Modal.getInstance(document.getElementById('modalCotizacion'));
          if (modal) modal.hide();
          toast('Cotización #' + data.id + ' creada correctamente.', 'success');
          setTimeout(function () { location.reload(); }, 800);
        } else {
          mostrarAlerta(data.message || 'Error al guardar.');
          btnGuardar.disabled = false;
          btnGuardar.innerHTML = '<i class="fas fa-save"></i> Guardar cotización';
        }
      })
      .catch(function () {
        mostrarAlerta('Error de conexión.');
        btnGuardar.disabled = false;
        btnGuardar.innerHTML = '<i class="fas fa-save"></i> Guardar cotización';
      });
    });

    document.getElementById('modalCotizacion').addEventListener('hidden.bs.modal', function () {
      items = [];
      renderTabla();
      ['cot-proveedor','cot-nit','cot-obs'].forEach(function (id) {
        var el = document.getElementById(id);
        if (el) el.value = '';
      });
      document.getElementById('cot-fecha').value = new Date().toISOString().slice(0, 10);
      alerta.style.display = 'none';
      btnGuardar.innerHTML = '<i class="fas fa-save"></i> Guardar cotización';
    });

    renderTabla();
    document.getElementById('cot-fecha').value = new Date().toISOString().slice(0, 10);
  })();

  /* ══════════════════════════════════════
     MODAL REMISIÓN
  ══════════════════════════════════════ */
  (function () {
    var btnCargar  = document.getElementById('rem-btn-cargar');
    var inputCotId = document.getElementById('rem-cot-id');
    var tbody      = document.getElementById('rem-tbody');
    var emptyRow   = document.getElementById('rem-empty-row');
    var alerta     = document.getElementById('rem-alerta');
    var btnGuardar = document.getElementById('rem-btn-guardar');
    var infoWrap   = document.getElementById('rem-cot-info-wrap');
    var infoText   = document.getElementById('rem-cot-info');

    if (!btnCargar) return;

    var cotizacionCargadaId = null;
    var items = [];

    function mostrarAlerta(msg) {
      alerta.textContent = msg;
      alerta.style.display = 'block';
      setTimeout(function () { alerta.style.display = 'none'; }, 4000);
    }

    function limpiarTabla() {
      tbody.querySelectorAll('tr:not(#rem-empty-row)').forEach(function (r) { r.remove(); });
      emptyRow.style.display = '';
      cotizacionCargadaId = null;
      items = [];
      btnGuardar.disabled = true;
      infoWrap.style.display = 'none';
    }

    btnCargar.addEventListener('click', function () {
      var cotId = parseInt(inputCotId.value, 10);
      if (!cotId || cotId <= 0) { mostrarAlerta('Ingresa un ID de cotización válido.'); return; }

      btnCargar.disabled = true;
      btnCargar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cargando…';
      limpiarTabla();

      fetch('/compras/cotizacion/' + cotId)
        .then(function (r) { return r.json(); })
        .then(function (data) {
          if (data.status !== 'success') { mostrarAlerta(data.message || 'Cotización no encontrada.'); return; }
          cotizacionCargadaId = data.cotizacion.id;
          document.getElementById('rem-proveedor').value = data.cotizacion.proveedor;
          infoText.textContent = 'Cot. #' + cotizacionCargadaId + ' — ' + data.cotizacion.proveedor + ' — Estado: ' + data.cotizacion.estado;
          infoWrap.style.display = 'block';

          if (!data.detalle || !data.detalle.length) { mostrarAlerta('La cotización no tiene ítems.'); return; }

          emptyRow.style.display = 'none';
          items = [];

          data.detalle.forEach(function (item, i) {
            items.push({
              productoId:    item.producto_id,
              nombre:        item.nombre_producto,
              cantPedida:    item.cantidad,
              cantRecibida:  item.cantidad,
              precio:        parseFloat(item.precio_unitario) || 0,
            });
            var tr = document.createElement('tr');
            tr.dataset.idx = i;
            tr.innerHTML =
              '<td style="color:#7c6fa0;font-size:12px;text-align:center;">' + (i + 1) + '</td>' +
              '<td style="font-weight:600;">' + item.nombre_producto + '</td>' +
              '<td style="text-align:center;font-weight:700;color:var(--purple-700);">' + item.cantidad + '</td>' +
              '<td style="text-align:center;">' +
                '<input type="number" min="0" max="' + item.cantidad + '" value="' + item.cantidad + '" class="rem-inp-rec" data-idx="' + i + '"' +
                ' style="width:70px;text-align:center;padding:4px 6px;border:1.5px solid var(--border);border-radius:6px;font-size:13px;outline:none;">' +
              '</td>' +
              '<td style="text-align:center;">' +
                '<input type="number" min="0" step="100" value="' + item.precio_unitario + '" class="rem-inp-precio" data-idx="' + i + '"' +
                ' style="width:100px;text-align:center;padding:4px 6px;border:1.5px solid var(--border);border-radius:6px;font-size:13px;outline:none;">' +
              '</td>';
            tbody.appendChild(tr);
          });

          btnGuardar.disabled = false;
          bindRemInputs();
        })
        .catch(function () { mostrarAlerta('Error de conexión.'); })
        .finally(function () {
          btnCargar.disabled = false;
          btnCargar.innerHTML = '<i class="fas fa-download"></i> Cargar cotización';
        });
    });

    inputCotId.addEventListener('keydown', function (e) { if (e.key === 'Enter') btnCargar.click(); });

    function bindRemInputs() {
      tbody.querySelectorAll('.rem-inp-rec').forEach(function (inp) {
        inp.addEventListener('change', function () { items[+this.dataset.idx].cantRecibida = parseInt(this.value) || 0; });
      });
      tbody.querySelectorAll('.rem-inp-precio').forEach(function (inp) {
        inp.addEventListener('change', function () { items[+this.dataset.idx].precio = parseFloat(this.value) || 0; });
      });
    }

    btnGuardar.addEventListener('click', function () {
      var proveedor = document.getElementById('rem-proveedor').value.trim();
      var fecha     = document.getElementById('rem-fecha').value;
      if (!proveedor) { mostrarAlerta('Ingresa el proveedor.'); return; }
      if (!fecha)     { mostrarAlerta('Selecciona la fecha.'); return; }

      var itemsToSave = items.map(function (it) {
        return {
          producto_id:       it.productoId,
          nombre_producto:   it.nombre,
          cantidad_pedida:   it.cantPedida,
          cantidad_recibida: it.cantRecibida,
          precio_unitario:   it.precio,
        };
      });

      btnGuardar.disabled = true;
      btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando…';

      fetch('/compras/remision/guardar', {
        method:  'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          cotizacion_id:   cotizacionCargadaId,
          numero_remision: document.getElementById('rem-numero').value.trim(),
          proveedor:       proveedor,
          fecha:           fecha,
          observacion:     document.getElementById('rem-obs').value.trim(),
          items:           itemsToSave,
        }),
      })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data.status === 'success') {
          var modal = bootstrap.Modal.getInstance(document.getElementById('modalRemision'));
          if (modal) modal.hide();
          toast('Remisión #' + data.id + ' registrada correctamente.', 'success');
          setTimeout(function () { location.reload(); }, 800);
        } else {
          mostrarAlerta(data.message || 'Error al guardar.');
          btnGuardar.disabled = false;
          btnGuardar.innerHTML = '<i class="fas fa-save"></i> Registrar remisión';
        }
      })
      .catch(function () {
        mostrarAlerta('Error de conexión.');
        btnGuardar.disabled = false;
        btnGuardar.innerHTML = '<i class="fas fa-save"></i> Registrar remisión';
      });
    });

    document.getElementById('modalRemision').addEventListener('hidden.bs.modal', function () {
      limpiarTabla();
      inputCotId.value = '';
      ['rem-proveedor','rem-numero','rem-obs'].forEach(function (id) {
        var el = document.getElementById(id); if (el) el.value = '';
      });
      document.getElementById('rem-fecha').value = new Date().toISOString().slice(0, 10);
      alerta.style.display = 'none';
      btnGuardar.innerHTML = '<i class="fas fa-save"></i> Registrar remisión';
    });

    document.getElementById('rem-fecha').value = new Date().toISOString().slice(0, 10);
  })();

  /* ══════════════════════════════════════
     MODAL COMPRA
  ══════════════════════════════════════ */
  (function () {
    var btnCargar  = document.getElementById('cmp-btn-cargar');
    var inputRemId = document.getElementById('cmp-rem-id');
    var tbody      = document.getElementById('cmp-tbody');
    var emptyRow   = document.getElementById('cmp-empty-row');
    var alerta     = document.getElementById('cmp-alerta');
    var btnGuardar = document.getElementById('cmp-btn-guardar');
    var totalEl    = document.getElementById('cmp-total');
    var infoWrap   = document.getElementById('cmp-rem-info-wrap');
    var infoText   = document.getElementById('cmp-rem-info');

    if (!btnCargar) return;

    var remisionCargadaId = null;
    var cotizacionId      = null;
    var items = [];

    function mostrarAlerta(msg) {
      alerta.textContent = msg;
      alerta.style.display = 'block';
      setTimeout(function () { alerta.style.display = 'none'; }, 4000);
    }

    function calcTotal() {
      var total = items.reduce(function (s, it) { return s + (it.cantidad * it.precio); }, 0);
      totalEl.textContent = fmt(total);
    }

    function limpiarTabla() {
      tbody.querySelectorAll('tr:not(#cmp-empty-row)').forEach(function (r) { r.remove(); });
      emptyRow.style.display = '';
      remisionCargadaId = null;
      cotizacionId = null;
      items = [];
      btnGuardar.disabled = true;
      totalEl.textContent = '$0';
      infoWrap.style.display = 'none';
    }

    btnCargar.addEventListener('click', function () {
      var remId = parseInt(inputRemId.value, 10);
      if (!remId || remId <= 0) { mostrarAlerta('Ingresa un ID de remisión válido.'); return; }

      btnCargar.disabled = true;
      btnCargar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cargando…';
      limpiarTabla();

      fetch('/compras/remision/' + remId)
        .then(function (r) { return r.json(); })
        .then(function (data) {
          if (data.status !== 'success') { mostrarAlerta(data.message || 'Remisión no encontrada.'); return; }
          remisionCargadaId = data.remision.id;
          cotizacionId      = data.remision.cotizacion_id;
          document.getElementById('cmp-proveedor').value = data.remision.proveedor;
          infoText.textContent = 'Rem. #' + remisionCargadaId + ' — ' + data.remision.proveedor;
          infoWrap.style.display = 'block';

          if (!data.detalle || !data.detalle.length) { mostrarAlerta('La remisión no tiene ítems.'); return; }

          emptyRow.style.display = 'none';
          items = [];

          data.detalle.forEach(function (item, i) {
            var qty = item.cantidad_recibida || item.cantidad_pedida || 1;
            items.push({
              productoId: item.producto_id,
              nombre:     item.nombre_producto,
              cantidad:   qty,
              precio:     parseFloat(item.precio_unitario) || 0,
            });
            var tr = document.createElement('tr');
            tr.dataset.idx = i;
            tr.innerHTML =
              '<td style="color:#7c6fa0;font-size:12px;text-align:center;">' + (i + 1) + '</td>' +
              '<td style="font-weight:600;">' + item.nombre_producto + '</td>' +
              '<td style="text-align:center;">' +
                '<input type="number" min="1" value="' + qty + '" class="cmp-inp-qty" data-idx="' + i + '"' +
                ' style="width:70px;text-align:center;padding:4px 6px;border:1.5px solid var(--border);border-radius:6px;font-size:13px;outline:none;">' +
              '</td>' +
              '<td style="text-align:center;">' +
                '<input type="number" min="0" step="100" value="' + item.precio_unitario + '" class="cmp-inp-precio" data-idx="' + i + '"' +
                ' style="width:100px;text-align:center;padding:4px 6px;border:1.5px solid var(--border);border-radius:6px;font-size:13px;outline:none;">' +
              '</td>' +
              '<td style="text-align:right;font-weight:700;color:var(--purple-700);" class="cmp-sub">' + fmt(qty * item.precio_unitario) + '</td>';
            tbody.appendChild(tr);
          });

          calcTotal();
          btnGuardar.disabled = false;
          bindCmpInputs();
        })
        .catch(function () { mostrarAlerta('Error de conexión.'); })
        .finally(function () {
          btnCargar.disabled = false;
          btnCargar.innerHTML = '<i class="fas fa-download"></i> Cargar remisión';
        });
    });

    inputRemId.addEventListener('keydown', function (e) { if (e.key === 'Enter') btnCargar.click(); });

    function bindCmpInputs() {
      tbody.querySelectorAll('.cmp-inp-qty, .cmp-inp-precio').forEach(function (inp) {
        inp.addEventListener('change', function () {
          var idx = +this.dataset.idx;
          if (this.classList.contains('cmp-inp-qty')) {
            items[idx].cantidad = parseInt(this.value) || 1;
          } else {
            items[idx].precio = parseFloat(this.value) || 0;
          }
          var sub = items[idx].cantidad * items[idx].precio;
          this.closest('tr').querySelector('.cmp-sub').textContent = fmt(sub);
          calcTotal();
        });
      });
    }

    btnGuardar.addEventListener('click', function () {
      var proveedor = document.getElementById('cmp-proveedor').value.trim();
      var fecha     = document.getElementById('cmp-fecha').value;
      if (!proveedor) { mostrarAlerta('Ingresa el proveedor.'); return; }
      if (!fecha)     { mostrarAlerta('Selecciona la fecha.'); return; }
      if (!items.length) { mostrarAlerta('No hay ítems cargados.'); return; }

      btnGuardar.disabled = true;
      btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Registrando…';

      var payload = {
        cotizacion_id:   cotizacionId,
        remision_id:     remisionCargadaId,
        numero_factura:  document.getElementById('cmp-factura').value.trim(),
        proveedor:       proveedor,
        fecha:           fecha,
        observacion:     document.getElementById('cmp-obs').value.trim(),
        items: items.map(function (it) {
          return {
            producto_id:     it.productoId,
            nombre_producto: it.nombre,
            cantidad:        it.cantidad,
            precio_unitario: it.precio,
            subtotal:        it.cantidad * it.precio,
          };
        }),
      };

      fetch('/compras/compra/guardar', {
        method:  'POST',
        headers: { 'Content-Type': 'application/json' },
        body:    JSON.stringify(payload),
      })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data.status === 'success') {
          var modal = bootstrap.Modal.getInstance(document.getElementById('modalCompra'));
          if (modal) modal.hide();
          toast('Compra #' + data.id + ' registrada. Stock actualizado.', 'success');
          setTimeout(function () { location.reload(); }, 800);
        } else {
          mostrarAlerta(data.message || 'Error al registrar.');
          btnGuardar.disabled = false;
          btnGuardar.innerHTML = '<i class="fas fa-shopping-cart"></i> Registrar compra';
        }
      })
      .catch(function () {
        mostrarAlerta('Error de conexión.');
        btnGuardar.disabled = false;
        btnGuardar.innerHTML = '<i class="fas fa-shopping-cart"></i> Registrar compra';
      });
    });

    document.getElementById('modalCompra').addEventListener('hidden.bs.modal', function () {
      limpiarTabla();
      inputRemId.value = '';
      ['cmp-proveedor','cmp-factura','cmp-obs'].forEach(function (id) {
        var el = document.getElementById(id); if (el) el.value = '';
      });
      document.getElementById('cmp-fecha').value = new Date().toISOString().slice(0, 10);
      alerta.style.display = 'none';
      btnGuardar.innerHTML = '<i class="fas fa-shopping-cart"></i> Registrar compra';
    });

    document.getElementById('cmp-fecha').value = new Date().toISOString().slice(0, 10);
  })();

  /* ── Botones de estado en tabla cotizaciones ── */
  document.querySelectorAll('[data-cot-estado]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var id     = +this.dataset.cotId;
      var estado = this.dataset.cotEstado;
      if (!confirm('¿Cambiar estado de la cotización #' + id + ' a "' + estado + '"?')) return;

      fetch('/compras/cotizacion/estado', {
        method:  'POST',
        headers: { 'Content-Type': 'application/json' },
        body:    JSON.stringify({ id: id, estado: estado }),
      })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data.status === 'success') location.reload();
        else alert(data.message || 'Error');
      });
    });
  });

  /* ── Abrir modal remisión pre-cargada con una cotización ── */
  document.querySelectorAll('[data-abrir-remision]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var cotId  = this.dataset.abrirRemision;
      var modalEl = document.getElementById('modalRemision');
      if (!modalEl) return;
      document.getElementById('rem-cot-id').value = cotId;
      var modal = new bootstrap.Modal(modalEl);
      modal.show();
      modalEl.addEventListener('shown.bs.modal', function handler() {
        document.getElementById('rem-btn-cargar').click();
        modalEl.removeEventListener('shown.bs.modal', handler);
      });
    });
  });

  /* ── Abrir modal compra pre-cargada con una remisión ── */
  document.querySelectorAll('[data-abrir-compra]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var remId  = this.dataset.abrirCompra;
      var modalEl = document.getElementById('modalCompra');
      if (!modalEl) return;
      document.getElementById('cmp-rem-id').value = remId;
      var modal = new bootstrap.Modal(modalEl);
      modal.show();
      modalEl.addEventListener('shown.bs.modal', function handler() {
        document.getElementById('cmp-btn-cargar').click();
        modalEl.removeEventListener('shown.bs.modal', handler);
      });
    });
  });

})();

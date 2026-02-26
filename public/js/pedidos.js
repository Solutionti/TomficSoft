/* ════════════════════════════════════════════════════════════════
   pedidos.js  —  InventSoft  |  Adaptado al diseño pedidos_final
   ════════════════════════════════════════════════════════════════

   DEPENDENCIAS (ya cargadas en el PHP):
     · jQuery
     · DataTables
     · Bootstrap modal
     · overhang.js  (toast; si no está disponible usa fallback)
   ════════════════════════════════════════════════════════════════ */

'use strict';

/* ────────────────────────────────────────────────────────────────
   ESTADO GLOBAL DEL FEED EN TIEMPO REAL
   ─────────────────────────────────────────────────────────────── */
let _feedVistos       = new Set();   // consecutivos ya mostrados
let _feedEstados      = {};          // último estado por consecutivo
let _feedIntervalo    = null;        // handle del setInterval
let _feedPrimeraCarga = true;        // flag para la carga silenciosa


/* ════════════════════════════════════════════════════════════════
   1. DATATABLE
   ════════════════════════════════════════════════════════════════ */
$(document).ready(function () {

  // const dt = $('#table-pedidos').DataTable({
  //   lengthMenu : [10, 50, 100, 200],
  //   pageLength : 10,
  //   dom        : '<"dt-top"lp>t<"dt-bot"ip>',   // oculta search nativo
  //   language: {
  //     processing : 'Procesando…',
  //     lengthMenu : 'Ver _MENU_ pedidos',
  //     info       : 'Mostrando _START_–_END_ de _TOTAL_ pedidos',
  //     infoEmpty  : 'Sin pedidos disponibles',
  //     zeroRecords: 'No se encontraron resultados',
  //     paginate   : { first: '«', last: '»', next: '›', previous: '‹' },
  //   },
  // });

  /* Conecta #buscar con el filtro de DataTables */
  document.getElementById('buscar')?.addEventListener('input', function () {
    dt.search(this.value).draw();
  });

  /* Inicia el polling de tiempo real */
  _iniciarPolling();

  /*
     Hook de reset: el PHP llama window.onFeedReset() cuando el
     usuario presiona el botón "limpiar" del feed card.
     Reseteamos nuestros sets para que el próximo poll
     vuelva a mostrar los items desde cero.
  */
  window.onFeedReset = function () {
    _feedVistos       = new Set();
    _feedEstados      = {};
    _feedPrimeraCarga = true;
  };

});


/* ════════════════════════════════════════════════════════════════
   2. VER DETALLE DEL PEDIDO  (modal)
   ════════════════════════════════════════════════════════════════ */
function verPedido(codigo) {
  $('#verpedido').modal('show');

  const tbody = document.querySelector('.detalle_productos_pedido');
  if (tbody) {
    tbody.innerHTML = `
      <tr>
        <td colspan="4" class="text-center py-3"
            style="color:var(--ink3);font-size:12px">
          <i class="fas fa-spinner fa-spin me-2"></i>Cargando productos…
        </td>
      </tr>`;
  }

  $.ajax({
    url   : baseurl + 'getpedidos/' + codigo,
    method: 'GET',
    success(raw) {
      const data = JSON.parse(raw);

      $('#codigo_pedido').val(data.consecutivo);
      // $('#sede_pedido').val(data.sede);
      $('#fecha_pedido').val(data.fecha);
      $('#hora_pedido').val(data.hora);
      $('#tppago_pedido').val(data.tppago);
      $('#celular_pedido').val(data.codigo_cliente);
      $('#total_pedido').val(
        '$' + Number(data.total).toLocaleString('es-CO', {
          minimumFractionDigits: 0,
          maximumFractionDigits: 0,
        })
      );
      $('#nombre_pedido').val(data.nombre + ' ' + data.apellido);
      $('#direccion_pedido').val(data.direccion);
      $('#estado_pedido').val(data.estado);
      $('#domicilio_pedido').val(data.domicilio);
      $('#comentarios_pedido').val(data.comentario);

      _cargarDetallePedido(data.consecutivo);
    },
    error() {
      _toast('error', 'No se pudo obtener el detalle del pedido.');
    },
  });
}


/* ════════════════════════════════════════════════════════════════
   3. TABLA DE PRODUCTOS DEL PEDIDO
   ════════════════════════════════════════════════════════════════ */
function _cargarDetallePedido(codigo) {
  const tbody = document.querySelector('.detalle_productos_pedido');
  if (!tbody) return;

  $.ajax({
    url   : baseurl + 'getpeditosdetalle/' + codigo,
    method: 'GET',
    success(raw) {
      const items = JSON.parse(raw);
      tbody.innerHTML = '';

      if (!items.length) {
        tbody.innerHTML = `
          <tr>
            <td colspan="4" class="text-center py-3"
                style="color:var(--ink3);font-size:12px">
              Sin productos registrados
            </td>
          </tr>`;
        return;
      }

      items.forEach((item, i) => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${i + 1}</td>
          <td>${item.codigo_pedido}</td>
          <td>${item.productonom}</td>
          <td class="text-center">${item.cantidad}</td>`;
        tbody.appendChild(tr);
      });
    },
    error() {
      tbody.innerHTML = `
        <tr>
          <td colspan="4" class="text-center py-3"
              style="color:var(--red);font-size:12px">
            <i class="fas fa-triangle-exclamation me-1"></i>
            Error cargando productos
          </td>
        </tr>`;
    },
  });
}

/* Alias global por si el PHP lo llama directamente */
window.tableDetallePedido = _cargarDetallePedido;


/* ════════════════════════════════════════════════════════════════
   4. GUARDAR / ACTUALIZAR PEDIDO
   ════════════════════════════════════════════════════════════════ */
$('#Actualizarpedido').on('click', function () {
  const $btn      = $(this);
  const codigo    = $('#codigo_pedido').val();
  const domicilio = $('#domicilio_pedido').val();
  const estado    = $('#estado_pedido').val();

  if (!codigo) {
    _toast('error', 'No hay ningún pedido seleccionado.');
    return;
  }

  $btn.prop('disabled', true)
      .html('<i class="fas fa-spinner fa-spin"></i> Guardando…');

  $.ajax({
    url   : baseurl + 'actualizarpedido',
    method: 'POST',
    data  : { domicilio, estado, codigo_pedido: codigo },
    success() {
      _toast('success', `Pedido #${codigo} actualizado correctamente.`);

      /*
         Empuja el cambio al feed inmediatamente sin esperar
         al siguiente poll de 2 s, y actualiza el estado conocido
         para que el polling no lo duplique.
      */
      const ahora    = new Date().toTimeString().slice(0, 5);
      const estadoUp = estado.toUpperCase();
      _feedEstados[String(codigo)] = estadoUp;
      _pushFeedSafe(codigo, estadoUp, ahora);

      setTimeout(reloadPage, 2200);
    },
    error() {
      _toast('error', 'No se pudo conectar con la base de datos. Verifica tu red.');
      $btn.prop('disabled', false)
          .html('<i class="fas fa-floppy-disk"></i> Guardar cambios');
    },
  });
});


/* ════════════════════════════════════════════════════════════════
   5. POLLING — TIEMPO REAL  (cada 2 s)

   Flujo:
   ┌─ Primera ejecución ─────────────────────────────────────────┐
   │  Registra todos los consecutivos en _feedVistos sin         │
   │  mostrarlos (base silenciosa para evitar ruido al cargar).  │
   └─────────────────────────────────────────────────────────────┘
   ┌─ Siguientes ejecuciones ────────────────────────────────────┐
   │  · Consecutivo NUEVO   → muestra en feed + recalcula stats  │
   │  · Estado CAMBIADO     → muestra con nuevo estado           │
   │  · Sin cambios         → nada (0 renders innecesarios)      │
   └─────────────────────────────────────────────────────────────┘
   ════════════════════════════════════════════════════════════════ */
function _iniciarPolling() {
  _pollTick();                                // disparo inmediato
  _feedIntervalo = setInterval(_pollTick, 2000);
}

function _pollTick() {
  $.ajax({
    url   : baseurl + 'getpedidoreal',
    method: 'GET',
    success(raw) {
      let items;
      try { items = JSON.parse(raw); }
      catch (e) { return; }
      if (!Array.isArray(items)) return;

      /* ── Primera carga: establece base silenciosa ── */
      if (_feedPrimeraCarga) {
        items.forEach(item => {
          const id = String(item.consecutivo);
          _feedVistos.add(id);
          _feedEstados[id] = String(item.estado).toUpperCase();
        });
        _feedPrimeraCarga = false;
        _recalcStats(items);
        return;
      }

      /* ── Cargas siguientes: detecta y muestra novedades ── */
      let hayNovedad = false;

      items.forEach(item => {
        const id     = String(item.consecutivo);
        const estado = String(item.estado).toUpperCase();
        /* Prefiere item.hora; si no existe usa la hora actual */
        const hora   = (item.hora && item.hora.trim())
          ? item.hora.trim().slice(0, 5)
          : new Date().toTimeString().slice(0, 5);

        if (!_feedVistos.has(id)) {
          /* Nuevo pedido */
          _feedVistos.add(id);
          _feedEstados[id] = estado;
          _pushFeedSafe(id, estado, hora);
          hayNovedad = true;

        } else if (_feedEstados[id] !== estado) {
          /* Pedido con estado cambiado */
          _feedEstados[id] = estado;
          _pushFeedSafe(id, estado, hora);
          hayNovedad = true;
        }
      });

      if (hayNovedad) _recalcStats(items);
    },
    /* Silencia errores del polling para no saturar con toasts */
    error() {},
  });
}

/* Llama a la función del feed con fallback de alias */
function _pushFeedSafe(consecutivo, estado, hora) {
  if (typeof window.pushFeed === 'function') {
    window.pushFeed(consecutivo, estado, hora);
  } else if (typeof window.rtPushEvento === 'function') {
    window.rtPushEvento(consecutivo, estado, hora);
  }
}


/* ════════════════════════════════════════════════════════════════
   6. RECALCULAR STATS CARDS Y BARRAS
   ════════════════════════════════════════════════════════════════ */
function _recalcStats(items) {
  const c = { total: items.length, entregados: 0, camino: 0, prep: 0 };

  items.forEach(it => {
    const e = String(it.estado).toUpperCase();
    if (e === 'ENTREGADO')   c.entregados++;
    if (e === 'EN CAMINO')   c.camino++;
    if (e === 'PREPARACION') c.prep++;
  });

  _animNum('s-total',      c.total);
  _animNum('s-entregados', c.entregados);
  _animNum('s-camino',     c.camino);
  _animNum('s-prep',       c.prep);

  /* ── Barras ── */
  const pedido = Math.max(c.total - c.camino - c.prep - c.entregados, 0);
  const data   = [
    { label: 'Pedido',      count: pedido,       color: '#5b2fc9' },
    { label: 'Preparación', count: c.prep,        color: '#c97c0f' },
    { label: 'En camino',   count: c.camino,      color: '#1a7fd4' },
    { label: 'Entregado',   count: c.entregados,  color: '#0fa968' },
  ];

  const sbList = document.getElementById('sb-list');
  if (!sbList) return;
  sbList.innerHTML = '';

  const total = c.total || 1;
  data.forEach(d => {
    const pct = Math.round((d.count / total) * 100);
    const row = document.createElement('div');
    row.className = 'sb-row';
    row.innerHTML = `
      <div class="sb-meta">
        <span class="sb-name" style="--pip:${d.color}">
          <span class="sb-pip"></span>${d.label}
        </span>
        <span class="sb-count" style="--pip:${d.color}">${d.count}</span>
      </div>
      <div class="sb-track">
        <div class="sb-fill" data-w="${pct}" style="--pip:${d.color}"></div>
      </div>`;
    sbList.appendChild(row);
  });

  /* Anima las barras tras el repintado del DOM */
  requestAnimationFrame(() => requestAnimationFrame(() => {
    document.querySelectorAll('.sb-fill').forEach(b => {
      b.style.width = b.dataset.w + '%';
    });
  }));
}


/* ════════════════════════════════════════════════════════════════
   7. HELPERS
   ════════════════════════════════════════════════════════════════ */

/** Animación numérica del valor actual → target */
function _animNum(id, target) {
  const el = document.getElementById(id);
  if (!el) return;
  const from = parseInt(el.textContent) || 0;
  if (from === target) return;
  const dur = 450, t0 = performance.now();
  (function f(now) {
    const p = Math.min((now - t0) / dur, 1);
    el.textContent = Math.round(from + (target - from) * (1 - Math.pow(1 - p, 3)));
    if (p < 1) requestAnimationFrame(f);
  })(performance.now());
}

/** Toast — usa overhang si está, si no usa fallback visual del diseño */
function _toast(type, message) {
  if (typeof $.fn.overhang !== 'undefined') {
    $('body').overhang({ type, message });
    return;
  }

  const COLOR = {
    success: '#0fa968', error: '#d03350',
    info   : '#1a7fd4', warning: '#c97c0f',
  };
  const ICON = {
    success: 'fa-circle-check', error : 'fa-circle-xmark',
    info   : 'fa-circle-info',  warning: 'fa-triangle-exclamation',
  };

  const el = document.createElement('div');
  Object.assign(el.style, {
    position    : 'fixed',
    bottom      : '24px',
    right       : '24px',
    zIndex      : '9999',
    background  : COLOR[type] ?? '#5b2fc9',
    color       : '#fff',
    padding     : '12px 16px',
    borderRadius: '10px',
    fontSize    : '13px',
    fontFamily  : 'Outfit, sans-serif',
    fontWeight  : '500',
    display     : 'flex',
    alignItems  : 'center',
    gap         : '9px',
    boxShadow   : '0 8px 28px rgba(0,0,0,.2)',
    maxWidth    : '320px',
    lineHeight  : '1.45',
    animation   : 'fi-in .25s ease both',
  });
  el.innerHTML = `<i class="fas ${ICON[type] ?? 'fa-bell'}"
    style="font-size:15px;flex-shrink:0"></i>${message}`;
  document.body.appendChild(el);

  setTimeout(() => {
    el.style.transition = 'opacity .3s, transform .3s';
    el.style.opacity    = '0';
    el.style.transform  = 'translateY(6px)';
    setTimeout(() => el.remove(), 320);
  }, 3200);
}

function reloadPage() {
  location.reload();
}

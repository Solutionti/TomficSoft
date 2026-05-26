/* ═══════════════════════════════════════════
   paginacion.js — Paginación universal
   Uso: añadir data-paginate="10" a cualquier <table>
        data-search-id="idDelInput" (opcional)
═══════════════════════════════════════════ */
(function () {
  'use strict';

  /* ── CSS ── */
  var css = [
    '.pg-bar{display:flex;align-items:center;justify-content:space-between;',
    'padding:11px 20px;border-top:1px solid #e8e0f5;background:#fafbff;',
    'flex-wrap:wrap;gap:8px;}',
    '.pg-info{font-size:12px;color:#7c6fa0;font-weight:500;}',
    '.pg-btns{display:flex;gap:4px;align-items:center;flex-wrap:wrap;}',
    '.pg-btn{min-width:32px;height:32px;padding:0 8px;border-radius:7px;',
    'font-size:12px;font-weight:600;border:1.5px solid #e8e0f5;',
    'background:#fff;color:#0d2409;cursor:pointer;transition:all .2s;line-height:1;}',
    '.pg-btn:hover:not(.pg-off):not(.pg-active){background:#f0f7ec;border-color:#8fba7e;}',
    '.pg-btn.pg-active{background:linear-gradient(135deg,#2d6622,#4a8a37);',
    'border-color:#4a8a37;color:#fff;}',
    '.pg-btn.pg-off{opacity:.45;cursor:default;}',
    '.pg-dots{padding:0 4px;color:#7c6fa0;font-size:12px;}'
  ].join('');
  var st = document.createElement('style');
  st.textContent = css;
  document.head.appendChild(st);

  var instances = {};

  function Paginator(tabla, opts) {
    var self    = this;
    var perPage = opts.perPage || 10;
    var current = 1;

    /* Barra de paginación — se inserta después del table-responsive o la tabla */
    var anchor = tabla.closest('.table-responsive') || tabla;
    var bar    = document.createElement('div');
    bar.className = 'pg-bar';
    anchor.parentNode.insertBefore(bar, anchor.nextSibling);

    function allRows()  { return Array.from(tabla.querySelectorAll('tbody > tr')); }
    function visRows()  { return allRows().filter(function (r) { return !r.classList.contains('pg-out'); }); }

    /* Filtrar filas por predicado */
    self.setFilter = function (query) {
      var q = (query || '').toLowerCase().trim();
      allRows().forEach(function (r) {
        var match = !q || r.textContent.toLowerCase().indexOf(q) !== -1;
        r.classList.toggle('pg-out', !match);
      });
      self.go(1);
    };

    /* Ir a página */
    self.go = function (page) {
      var rows  = visRows();
      var total = rows.length;
      var pages = Math.max(1, Math.ceil(total / perPage));
      current   = Math.min(Math.max(1, page), pages);

      var from = (current - 1) * perPage;
      var to   = from + perPage;

      allRows().forEach(function (r) { r.style.display = 'none'; });
      rows.forEach(function (r, i) {
        r.style.display = (i >= from && i < to) ? '' : 'none';
      });

      render(total, pages, from, Math.min(to, total));
    };

    /* Renderizar barra */
    function render(total, pages, from, to) {
      bar.innerHTML = '';

      var info = document.createElement('span');
      info.className = 'pg-info';
      info.textContent = total === 0
        ? 'Sin registros'
        : 'Mostrando ' + (from + 1) + '–' + to + ' de ' + total;
      bar.appendChild(info);

      if (pages <= 1) return;

      var wrap = document.createElement('div');
      wrap.className = 'pg-btns';

      function btn(html, pg, active, off) {
        var b = document.createElement('button');
        b.type = 'button';
        b.innerHTML = html;
        b.className = 'pg-btn' + (active ? ' pg-active' : '') + (off ? ' pg-off' : '');
        if (!off) b.addEventListener('click', function () { self.go(pg); });
        return b;
      }

      wrap.appendChild(btn('&#8592;', current - 1, false, current === 1));

      var nums = [];
      if (pages <= 7) {
        for (var i = 1; i <= pages; i++) nums.push(i);
      } else {
        nums.push(1);
        if (current > 3) nums.push('…');
        var lo = Math.max(2, current - 1), hi = Math.min(pages - 1, current + 1);
        for (var i = lo; i <= hi; i++) nums.push(i);
        if (current < pages - 2) nums.push('…');
        nums.push(pages);
      }

      nums.forEach(function (n) {
        if (n === '…') {
          var d = document.createElement('span');
          d.className = 'pg-dots'; d.textContent = '…';
          wrap.appendChild(d);
        } else {
          wrap.appendChild(btn(n, n, n === current, false));
        }
      });

      wrap.appendChild(btn('&#8594;', current + 1, false, current === pages));
      bar.appendChild(wrap);
    }

    self.go(1);
  }

  /* ── Auto-init ── */
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('table[data-paginate]').forEach(function (t) {
      var inst = new Paginator(t, {
        perPage: parseInt(t.getAttribute('data-paginate'), 10) || 10
      });
      if (t.id) instances[t.id] = inst;
    });
  });

  /* ── API global ── */
  window.paginacion = {
    get:    function (id) { return instances[id]; },
    ir:     function (id, pg) { if (instances[id]) instances[id].go(pg); },
    filtrar: function (id, q) { if (instances[id]) instances[id].setFilter(q); }
  };
})();

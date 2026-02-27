<!-- ═══════════════════════════════════════════════════════════════
     lateralderecha.php  —  Sidebar rediseñado  |  InventSoft
     Usa el mismo sistema de diseño que pedidos_final.php
     ════════════════════════════════════════════════════════════ -->

<style>
/* ──────────────────────────────────────────────────────────────
   Variables (alineadas con pedidos_final)
─────────────────────────────────────────────────────────────── */
:root {
  --v:         #5b2fc9;
  --v2:        #3d1d8a;
  --v3:        #7c55e0;
  --v-glow:    rgba(91,47,201,.2);
  --v-soft:    rgba(91,47,201,.08);
  --v-mid:     rgba(91,47,201,.14);
  --green:     #0fa968;
  --ink:       #1a1040;
  --ink2:      #4a3d72;
  --ink3:      #8b7db5;
  --bg:        #f5f3fc;
  --surface:   #ffffff;
  --border:    rgba(91,47,201,.12);
  --border2:   rgba(91,47,201,.22);
  --r:         12px;
  --r2:        8px;
}

/* ──────────────────────────────────────────────────────────────
   Sidebar base
─────────────────────────────────────────────────────────────── */
.sidebar {
  width: 240px !important;
  min-height: 100vh;
  background: var(--surface);
  border-right: 1px solid var(--border);
  display: flex;
  flex-direction: column;
  font-family: 'Outfit', sans-serif;
  position: relative;
  overflow: hidden;
  transition: width .3s cubic-bezier(.4,0,.2,1);
  box-shadow: 2px 0 20px rgba(91,47,201,.06);
}

/* Gradiente sutil de fondo */
.sidebar::before {
  content: '';
  position: absolute;
  inset: 0; z-index: 0; pointer-events: none;
  background:
    radial-gradient(ellipse 80% 30% at 50% 0%,   rgba(91,47,201,.07) 0%, transparent 70%),
    radial-gradient(ellipse 50% 20% at 50% 100%,  rgba(91,47,201,.04) 0%, transparent 70%);
}

.sidebar .nav {
  position: relative; z-index: 1;
  padding: 0;
  list-style: none;
  margin: 0;
  flex: 1;
  display: flex;
  flex-direction: column;
}

/* ──────────────────────────────────────────────────────────────
   Branding / Logo top strip
─────────────────────────────────────────────────────────────── */
.sb-brand {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 18px 18px 14px;
  border-bottom: 1px solid var(--border);
  text-decoration: none;
}

.sb-brand-icon {
  width: 34px; height: 34px; border-radius: 10px;
  background: linear-gradient(135deg, var(--v), var(--v2));
  display: flex; align-items: center; justify-content: center;
  font-size: 14px; color: #fff; flex-shrink: 0;
  box-shadow: 0 4px 14px var(--v-glow);
}

.sb-brand-text { line-height: 1.15; }
.sb-brand-name {
  font-size: 13px; font-weight: 800;
  color: var(--ink); letter-spacing: -.01em;
}
.sb-brand-sub {
  font-size: 10px; color: var(--ink3);
  letter-spacing: .03em;
}

/* ──────────────────────────────────────────────────────────────
   Perfil de usuario
─────────────────────────────────────────────────────────────── */
.sb-profile {
  display: flex;
  align-items: center;
  gap: 11px;
  padding: 14px 16px;
  border-bottom: 1px solid var(--border);
  background: rgba(91,47,201,.03);
  text-decoration: none;
  transition: background .2s;
}
.sb-profile:hover { background: var(--v-soft); }

.sb-avatar {
  width: 38px; height: 38px; border-radius: 50%;
  object-fit: cover; flex-shrink: 0;
  border: 2px solid var(--border2);
  box-shadow: 0 0 0 3px var(--v-soft);
  transition: box-shadow .2s;
}
.sb-profile:hover .sb-avatar {
  box-shadow: 0 0 0 3px rgba(91,47,201,.18);
}

.sb-profile-info { min-width: 0; flex: 1; }
.sb-profile-name {
  font-size: 12.5px; font-weight: 600;
  color: var(--ink);
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  text-transform: capitalize;
  line-height: 1.2;
}
.sb-profile-role {
  display: flex; align-items: center; gap: 5px;
  font-size: 10.5px; color: var(--ink3);
  margin-top: 2px; letter-spacing: .02em;
}
.sb-profile-role .online-dot {
  width: 6px; height: 6px; border-radius: 50%;
  background: var(--green);
  box-shadow: 0 0 0 2px rgba(15,169,104,.2);
  flex-shrink: 0;
  animation: sb-pulse 2.5s infinite;
}
@keyframes sb-pulse {
  0%,100% { box-shadow: 0 0 0 2px rgba(15,169,104,.2); }
  50%     { box-shadow: 0 0 0 4px rgba(15,169,104,.1); }
}

.sb-profile-arrow {
  color: var(--ink3); font-size: 10px; flex-shrink: 0;
  transition: transform .2s, color .2s;
}
.sb-profile:hover .sb-profile-arrow {
  transform: translateX(2px); color: var(--v);
}

/* ──────────────────────────────────────────────────────────────
   Buscador
─────────────────────────────────────────────────────────────── */
.sb-search-wrap {
  padding: 12px 14px 8px;
}

.sb-search {
  display: flex; align-items: center; gap: 8px;
  background: var(--bg);
  border: 1px solid var(--border);
  border-radius: var(--r2);
  padding: 7px 11px;
  transition: border-color .2s, box-shadow .2s;
}
.sb-search:focus-within {
  border-color: var(--v);
  box-shadow: 0 0 0 3px var(--v-glow);
  background: #fff;
}

.sb-search i {
  color: var(--ink3); font-size: 11px; flex-shrink: 0;
  transition: color .2s;
}
.sb-search:focus-within i { color: var(--v); }

.sb-search input {
  border: none; outline: none; background: transparent;
  font-family: 'Outfit', sans-serif;
  font-size: 12.5px; color: var(--ink);
  width: 100%;
}
.sb-search input::placeholder { color: var(--ink3); }

/* ──────────────────────────────────────────────────────────────
   Separadores de sección
─────────────────────────────────────────────────────────────── */
.sb-section-label {
  display: flex; align-items: center; gap: 8px;
  padding: 14px 16px 6px;
}

.sb-section-label span {
  font-size: 9.5px; font-weight: 700;
  letter-spacing: .12em; text-transform: uppercase;
  color: var(--ink3);
  white-space: nowrap;
}

.sb-section-label::after {
  content: '';
  flex: 1; height: 1px;
  background: linear-gradient(to right, var(--border), transparent);
}

/* ──────────────────────────────────────────────────────────────
   Items de navegación
─────────────────────────────────────────────────────────────── */
.sb-item {
  padding: 2px 10px;
  list-style: none;
}

.sb-link {
  display: flex; align-items: center; gap: 10px;
  padding: 9px 10px;
  border-radius: var(--r2);
  text-decoration: none;
  color: var(--ink2);
  font-size: 13px; font-weight: 500;
  letter-spacing: .01em;
  position: relative;
  transition: background .18s, color .18s, transform .15s;
  white-space: nowrap;
  overflow: hidden;
}

/* ripple pseudo */
.sb-link::before {
  content: '';
  position: absolute; inset: 0;
  border-radius: var(--r2);
  background: var(--v);
  opacity: 0;
  transition: opacity .18s;
}

.sb-link:hover {
  background: var(--v-soft);
  color: var(--v);
  transform: translateX(3px);
}

/* Estado activo: detectado por JS o clase PHP */
.sb-link.active,
.sb-link[aria-current="page"] {
  background: var(--v-mid);
  color: var(--v);
  font-weight: 600;
}
.sb-link.active .sb-link-icon,
.sb-link[aria-current="page"] .sb-link-icon {
  background: var(--v);
  color: #fff;
  box-shadow: 0 3px 10px var(--v-glow);
}

/* Barra lateral indicadora del item activo */
.sb-link.active::after,
.sb-link[aria-current="page"]::after {
  content: '';
  position: absolute;
  left: -10px; top: 20%; bottom: 20%;
  width: 3px; border-radius: 0 3px 3px 0;
  background: var(--v);
}

/* Ícono */
.sb-link-icon {
  width: 28px; height: 28px; border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  font-size: 12px; flex-shrink: 0;
  background: transparent;
  color: var(--ink3);
  transition: background .18s, color .18s, box-shadow .18s, transform .18s;
}
.sb-link:hover .sb-link-icon {
  background: var(--v-soft);
  color: var(--v);
  transform: scale(1.08);
}

.sb-link-text { flex: 1; }

/* Badge de notificación */
.sb-badge {
  display: inline-flex; align-items: center; justify-content: center;
  min-width: 18px; height: 18px; padding: 0 5px;
  border-radius: 99px;
  background: var(--v);
  color: #fff;
  font-size: 9px; font-weight: 700;
  font-family: 'JetBrains Mono', monospace;
  box-shadow: 0 2px 8px var(--v-glow);
  animation: sb-bump .3s ease;
}
@keyframes sb-bump {
  0%   { transform: scale(.7); opacity: 0; }
  70%  { transform: scale(1.15); }
  100% { transform: scale(1); opacity: 1; }
}

/* ──────────────────────────────────────────────────────────────
   Footer del sidebar (versión / logout)
─────────────────────────────────────────────────────────────── */
.sb-footer {
  margin-top: auto;
  border-top: 1px solid var(--border);
  padding: 12px 14px;
  display: flex; align-items: center; justify-content: space-between;
  background: rgba(91,47,201,.02);
}

.sb-version {
  font-size: 10px; color: var(--ink3);
  font-family: 'JetBrains Mono', monospace;
  letter-spacing: .04em;
}

.sb-logout {
  width: 30px; height: 30px; border-radius: 8px;
  border: 1px solid var(--border);
  background: transparent; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  color: var(--ink3); font-size: 12px;
  text-decoration: none;
  transition: background .2s, color .2s, border-color .2s;
}
.sb-logout:hover {
  background: rgba(208,51,80,.08);
  color: #d03350;
  border-color: rgba(208,51,80,.25);
}

/* ──────────────────────────────────────────────────────────────
   Animaciones de entrada escalonada
─────────────────────────────────────────────────────────────── */
@keyframes sb-in {
  from { opacity: 0; transform: translateX(-10px); }
  to   { opacity: 1; transform: translateX(0); }
}

.sb-item { animation: sb-in .35s ease both; }
.sb-item:nth-child(1)  { animation-delay: .04s }
.sb-item:nth-child(2)  { animation-delay: .07s }
.sb-item:nth-child(3)  { animation-delay: .10s }
.sb-item:nth-child(4)  { animation-delay: .13s }
.sb-item:nth-child(5)  { animation-delay: .16s }
.sb-item:nth-child(6)  { animation-delay: .19s }
.sb-item:nth-child(7)  { animation-delay: .22s }
.sb-item:nth-child(8)  { animation-delay: .25s }
.sb-item:nth-child(9)  { animation-delay: .28s }
.sb-item:nth-child(10) { animation-delay: .31s }

/* ──────────────────────────────────────────────────────────────
   Scrollbar del sidebar
─────────────────────────────────────────────────────────────── */
.sidebar::-webkit-scrollbar { width: 4px; }
.sidebar::-webkit-scrollbar-track { background: transparent; }
.sidebar::-webkit-scrollbar-thumb {
  background: rgba(91,47,201,.15); border-radius: 99px;
}
</style>


<!-- ════════════════════════ SIDEBAR HTML ════════════════════════ -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    <!-- ── Branding ── -->
    <li>
      <a href="#" class="sb-brand">
        <div class="sb-brand-icon"><i class="fas fa-user"></i></div>
        <div class="sb-brand-text">
          <div class="sb-brand-name">InventSoft</div>
          <div class="sb-brand-sub">Panel de control</div>
        </div>
      </a>
    </li>

    <!-- ── Perfil ── -->
    <li>
      <a href="#" class="sb-profile">
        <img
          src="<?= base_url('img/team-41.jpg') ?>"
          alt="Foto de perfil"
          class="sb-avatar"
        >
        <div class="sb-profile-info">
          <div class="sb-profile-name">
            <?= session()->get('nombre') . ' ' . session()->get('apellido') ?>
          </div>
          <div class="sb-profile-role">
            <span class="online-dot"></span>
            <?= session()->get('descripcion_rol') ?>
          </div>
        </div>
        <i class="fas fa-chevron-right sb-profile-arrow"></i>
      </a>
    </li>

    <!-- ── Buscador ── -->
    <li>
      <div class="sb-search-wrap">
        <div class="sb-search">
          <i class="fas fa-magnifying-glass"></i>
          <input type="text" id="sb-buscar" placeholder="Buscar módulo…">
        </div>
      </div>
    </li>

    <!-- ══════════════ SECCIÓN: INVENTARIOS ══════════════ -->
    <li>
      <div class="sb-section-label">
        <span>Inventarios</span>
      </div>
    </li>

    <?php foreach ($permisoUsuario->getResult() as $permiso): ?>
      <li class="sb-item">
        <a
          class="sb-link <?= str_contains(current_url(), $permiso->url) ? 'active' : '' ?>"
          href="<?= base_url($permiso->url) ?>"
        >
          <span class="sb-link-icon">
            <i class="<?= $permiso->icono ?>"></i>
          </span>
          <span class="sb-link-text"><?= $permiso->nombre ?></span>
        </a>
      </li>
    <?php endforeach; ?>

    <!-- ══════════════ SECCIÓN: VENTAS ══════════════ -->
    <li>
      <div class="sb-section-label">
        <span>Ventas</span>
      </div>
    </li>

    <li class="sb-item">
      <a
        class="sb-link <?= str_contains(current_url(), 'inventarios') ? 'active' : '' ?>"
        href="<?= base_url('inventarios') ?>"
      >
        <span class="sb-link-icon"><i class="fas fa-truck-moving"></i></span>
        <span class="sb-link-text">Kardex</span>
      </a>
    </li>

    <li class="sb-item">
      <a
        class="sb-link"
        href="<?= base_url('ventas') ?>"
        target="_blank"
      >
        <span class="sb-link-icon"><i class="fas fa-cash-register"></i></span>
        <span class="sb-link-text">Ventas</span>
        <!-- Indicador de pestaña externa -->
        <i class="fas fa-arrow-up-right-from-square"
           style="font-size:9px;color:var(--ink3);margin-left:auto;flex-shrink:0"></i>
      </a>
    </li>
    <li class="sb-item">
      <a
        class="sb-link <?= str_contains(current_url(), 'pedidos') ? 'active' : '' ?>"
        href="<?= base_url('pedidos') ?>"
      >
        <span class="sb-link-icon"><i class="fas fa-motorcycle"></i></span>
        <span class="sb-link-text">Pedidos</span>
        <span class="sb-badge" id="sb-pedidos-badge" style="display:none">0</span>
      </a>
    </li>
    <li class="sb-item">
      <a
        class="sb-link <?= str_contains(current_url(), 'facturacion') ? 'active' : '' ?>"
        href="<?= base_url('facturacion') ?>"
      >
        <span class="sb-link-icon"><i class="fas fa-file-invoice"></i></span>
        <span class="sb-link-text">Facturaciòn</span>
        <span class="sb-badge" id="sb-facturacion-badge" style="display:none">0</span>
      </a>
    </li>
    <li class="sb-item">
      <a
        class="sb-link"
        href="http://localhost/CODEIGNITER/EcommerceSoft_/ecommerce/inicio"
        target="_blank"
      >
        <span class="sb-link-icon"><i class="fas fa-shopping-cart"></i></span>
        <span class="sb-link-text">Ecommerce</span>
        <i class="fas fa-arrow-up-right-from-square"
           style="font-size:9px;color:var(--ink3);margin-left:auto;flex-shrink:0"></i>
      </a>
    </li>

    <!-- ══════════════ FOOTER ══════════════ -->
    <li style="margin-top:auto; padding-top:8px">
      <div class="sb-footer">
        <span class="sb-version">v2.0.0</span>
        <a href="<?= base_url('logout') ?>" class="sb-logout" title="Cerrar sesión">
          <i class="fas fa-right-from-bracket"></i>
        </a>
      </div>
    </li>

  </ul>
</nav>


<script>
/* ── Marcar item activo según la URL actual ── */
(function () {
  const current = window.location.pathname;
  document.querySelectorAll('.sb-link').forEach(link => {
    const href = link.getAttribute('href') ?? '';
    if (href && href !== '#' && current.includes(href.split('/').pop())) {
      link.classList.add('active');
    }
  });
})();

/* ── Filtro de búsqueda del sidebar ── */
document.getElementById('sb-buscar')?.addEventListener('input', function () {
  const q = this.value.toLowerCase().trim();
  document.querySelectorAll('.sb-item').forEach(item => {
    const text = item.querySelector('.sb-link-text')?.textContent?.toLowerCase() ?? '';
    item.style.display = (!q || text.includes(q)) ? '' : 'none';
  });
  /* Muestra / oculta los separadores de sección si no hay items visibles */
  document.querySelectorAll('.sb-section-label')?.forEach(sec => {
    const li      = sec.closest('li');
    if (!li) return;
    let next      = li.nextElementSibling;
    let hayItems  = false;
    while (next && !next.querySelector('.sb-section-label')) {
      if (next.querySelector('.sb-item') && next.style.display !== 'none') hayItems = true;
      next = next.nextElementSibling;
    }
    li.style.display = (!q || hayItems) ? '' : 'none';
  });
});

/* ── Badge de pedidos pendientes (conecta con el polling de pedidos.js) ──
   Si el poll de pedidoRealTiempo detecta pedidos en estado PEDIDO,
   actualiza este badge.                                                   */
window.sbUpdatePedidosBadge = function (count) {
  const badge = document.getElementById('sb-pedidos-badge');
  if (!badge) return;
  if (count > 0) {
    badge.textContent = count > 99 ? '99+' : count;
    badge.style.display = 'inline-flex';
  } else {
    badge.style.display = 'none';
  }
};
</script>
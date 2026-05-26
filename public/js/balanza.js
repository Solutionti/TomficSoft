/**
 * balanza.js — OCR de display de balanza integrado en módulo Desechos
 * Flujo: cargar imagen → arrastrar para recortar el display → OCR → llena campo peso
 */

(function () {
  'use strict';

  /* ── Guard: salir si el módulo no está en esta página ── */
  if (!document.getElementById('ocr-drop-zone')) return;

  /* ── Referencias DOM ── */
  const dropZone        = document.getElementById('ocr-drop-zone');
  const fileInput       = document.getElementById('ocr-file-input');
  const cropContainer   = document.getElementById('ocr-crop-container');
  const baseCanvas      = document.getElementById('ocr-base-canvas');
  const selCanvas       = document.getElementById('ocr-sel-canvas');
  const cropHint        = document.getElementById('ocr-crop-hint');
  const btnProcesar     = document.getElementById('ocr-btn-procesar');
  const progressWrap    = document.getElementById('ocr-progress');
  const progressFill    = document.getElementById('ocr-progress-fill');
  const progressLabel   = document.getElementById('ocr-progress-label');
  const pesoInput       = document.getElementById('ocr-peso-input');
  const btnAbrirCam     = document.getElementById('ocr-btn-camara');
  const cameraVideo     = document.getElementById('ocr-camera-video');
  const cameraCanvas    = document.getElementById('ocr-camera-canvas');
  const btnCapturar     = document.getElementById('ocr-btn-capturar');
  const cropPreview     = document.getElementById('ocr-preview-img');
  const cropPreviewWrap = document.getElementById('ocr-preview-wrap');
  const resultWrap      = document.getElementById('ocr-result-wrap');
  const resultText      = document.getElementById('ocr-result-text');
  const nombreInput       = document.getElementById('ocr-nombre-input');
  const nombreDropdown    = document.getElementById('ocr-nombre-dropdown');
  const unidadesInput     = document.getElementById('ocr-unidades-input');
  const btnGuardar        = document.getElementById('ocr-btn-guardar');

  /* cameraModal se crea solo cuando se abre (evita error si Bootstrap aún no cargó) */
  let cameraModal = null;
  function getCameraModal() {
    if (!cameraModal) cameraModal = new bootstrap.Modal(document.getElementById('ocr-camera-modal'));
    return cameraModal;
  }

  const baseCtx = baseCanvas.getContext('2d');
  const selCtx  = selCanvas.getContext('2d');

  /* ── Estado de la imagen y selección ── */
  let originalImage = null;   // HTMLImageElement con la imagen cargada
  let imgScale      = 1;      // escala de renderizado (imagen vs canvas CSS)
  let selection     = null;   // { x, y, w, h } en coordenadas del canvas visual
  let dragging      = false;
  let startX = 0, startY = 0;
  let cameraStream   = null;
  let lastCropBase64 = null;
  let originalBase64 = null;

  /* ══════════════════════════════════════
     Carga de imagen (file / drag-drop)
  ══════════════════════════════════════ */
  dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('dragover'); });
  dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));
  dropZone.addEventListener('drop', e => {
    e.preventDefault();
    dropZone.classList.remove('dragover');
    const f = e.dataTransfer.files[0];
    if (f && f.type.startsWith('image/')) loadFile(f);
  });
  fileInput.addEventListener('change', () => { if (fileInput.files[0]) loadFile(fileInput.files[0]); });

  function loadFile(file) {
    const reader = new FileReader();
    reader.onload = e => {
      originalBase64 = e.target.result;
      loadImageFromUrl(e.target.result);
    };
    reader.readAsDataURL(file);
  }

  function loadImageFromUrl(url) {
    const img = new Image();
    img.onload = () => {
      originalImage = img;
      renderBase();
      resetSelection();
      cropContainer.style.display = 'block';
      cropHint.style.display = 'block';
      cropPreviewWrap.style.display = 'none';
      btnProcesar.disabled = true;
      pesoInput.value = '';
      dropZone.style.display = 'none';
    };
    img.src = url;
  }

  /* ── Renderiza la imagen al tamaño del contenedor, buffer = CSS (sin ratio) ── */
  function renderBase() {
    const maxW = cropContainer.clientWidth || 500;
    const maxH = 360;
    const ratio = Math.min(maxW / originalImage.width, maxH / originalImage.height, 1);
    imgScale = ratio;

    const w = Math.round(originalImage.width  * ratio);
    const h = Math.round(originalImage.height * ratio);

    /* Buffer y CSS idénticos → coordenadas 1:1, sin conversión */
    baseCanvas.width        = w;
    baseCanvas.height       = h;
    baseCanvas.style.width  = w + 'px';
    baseCanvas.style.height = h + 'px';

    selCanvas.width        = w;
    selCanvas.height       = h;
    selCanvas.style.width  = w + 'px';
    selCanvas.style.height = h + 'px';

    baseCtx.drawImage(originalImage, 0, 0, w, h);
    selCtx.clearRect(0, 0, w, h);
  }

  function resetSelection() {
    selection = null;
    selCtx.clearRect(0, 0, selCanvas.width, selCanvas.height);
  }

  /* Coordenadas del mouse relativas al canvas (buffer = CSS → sin factor de escala) */
  function canvasPos(clientX, clientY) {
    const r = selCanvas.getBoundingClientRect();
    return {
      x: clientX - r.left,
      y: clientY - r.top,
    };
  }

  /* ══════════════════════════════════════
     Selección de región con mouse
  ══════════════════════════════════════ */
  selCanvas.addEventListener('mousedown', e => {
    const p = canvasPos(e.clientX, e.clientY);
    startX   = p.x;
    startY   = p.y;
    dragging = true;
    selection = null;
    btnProcesar.disabled = true;
  });

  selCanvas.addEventListener('mousemove', e => {
    if (!dragging) return;
    const p = canvasPos(e.clientX, e.clientY);
    drawSelection(startX, startY, p.x - startX, p.y - startY);
  });

  selCanvas.addEventListener('mouseup', e => {
    if (!dragging) return;
    dragging = false;
    const p = canvasPos(e.clientX, e.clientY);
    const w = p.x - startX;
    const h = p.y - startY;

    if (Math.abs(w) < 10 || Math.abs(h) < 10) {
      resetSelection();
      return;
    }

    selection = normalizeRect(startX, startY, w, h);
    drawSelection(startX, startY, w, h);
    showCropPreview();
    btnProcesar.disabled = false;
    cropHint.style.display = 'none';
  });

  /* Touch support (móvil) */
  selCanvas.addEventListener('touchstart', e => {
    e.preventDefault();
    const t = e.touches[0];
    const p = canvasPos(t.clientX, t.clientY);
    startX   = p.x;
    startY   = p.y;
    dragging = true;
    selection = null;
    btnProcesar.disabled = true;
  }, { passive: false });

  selCanvas.addEventListener('touchmove', e => {
    e.preventDefault();
    if (!dragging) return;
    const t = e.touches[0];
    const p = canvasPos(t.clientX, t.clientY);
    drawSelection(startX, startY, p.x - startX, p.y - startY);
  }, { passive: false });

  selCanvas.addEventListener('touchend', e => {
    e.preventDefault();
    if (!dragging) return;
    dragging = false;
    const t = e.changedTouches[0];
    const p = canvasPos(t.clientX, t.clientY);
    const w = p.x - startX;
    const h = p.y - startY;

    if (Math.abs(w) < 10 || Math.abs(h) < 10) { resetSelection(); return; }
    selection = normalizeRect(startX, startY, w, h);
    drawSelection(startX, startY, w, h);
    showCropPreview();
    btnProcesar.disabled = false;
    cropHint.style.display = 'none';
  }, { passive: false });

  /* Dibuja el rectángulo de selección con overlay oscuro */
  function drawSelection(x, y, w, h) {
    selCtx.clearRect(0, 0, selCanvas.width, selCanvas.height);

    /* overlay semitransparente sobre todo */
    selCtx.fillStyle = 'rgba(0,0,0,0.42)';
    selCtx.fillRect(0, 0, selCanvas.width, selCanvas.height);

    /* recorte: "agujero" transparente donde está la selección */
    const rect = normalizeRect(x, y, w, h);
    selCtx.clearRect(rect.x, rect.y, rect.w, rect.h);

    /* borde de la selección */
    selCtx.strokeStyle = '#a855f7';
    selCtx.lineWidth   = 2;
    selCtx.strokeRect(rect.x, rect.y, rect.w, rect.h);

    /* esquinas decorativas */
    const cs = 10;
    selCtx.strokeStyle = '#fff';
    selCtx.lineWidth   = 3;
    [[rect.x, rect.y], [rect.x + rect.w, rect.y],
     [rect.x, rect.y + rect.h], [rect.x + rect.w, rect.y + rect.h]].forEach(([cx2, cy2]) => {
      const sx = cx2 === rect.x ? 1 : -1;
      const sy = cy2 === rect.y ? 1 : -1;
      selCtx.beginPath();
      selCtx.moveTo(cx2 + sx * cs, cy2);
      selCtx.lineTo(cx2, cy2);
      selCtx.lineTo(cx2, cy2 + sy * cs);
      selCtx.stroke();
    });
  }

  /* Rectángulo normalizado (asegura w y h positivos) */
  function normalizeRect(x, y, w, h) {
    return {
      x: w < 0 ? x + w : x,
      y: h < 0 ? y + h : y,
      w: Math.abs(w),
      h: Math.abs(h),
    };
  }

  /* Previsualización de la zona recortada */
  function showCropPreview() {
    if (!selection || !originalImage) return;

    const offscreen = document.createElement('canvas');
    offscreen.width  = selection.w;
    offscreen.height = selection.h;
    const ctx = offscreen.getContext('2d');

    /* Dibujar la zona seleccionada desde la imagen original escalada */
    ctx.drawImage(
      baseCanvas,
      selection.x, selection.y, selection.w, selection.h,
      0, 0, selection.w, selection.h
    );

    cropPreview.src = offscreen.toDataURL();
    cropPreviewWrap.style.display = 'block';
  }

  /* ══════════════════════════════════════
     Cámara
  ══════════════════════════════════════ */
  btnAbrirCam.addEventListener('click', async () => {
    try {
      cameraStream = await navigator.mediaDevices.getUserMedia({
        video: { facingMode: { ideal: 'environment' } }
      });
      cameraVideo.srcObject = cameraStream;
      getCameraModal().show();
    } catch {
      showToast('No se pudo acceder a la cámara. Verifica los permisos.');
    }
  });

  document.getElementById('ocr-camera-modal').addEventListener('hidden.bs.modal', () => {
    if (cameraStream) { cameraStream.getTracks().forEach(t => t.stop()); cameraStream = null; }
  });

  btnCapturar.addEventListener('click', () => {
    cameraCanvas.width  = cameraVideo.videoWidth;
    cameraCanvas.height = cameraVideo.videoHeight;
    cameraCanvas.getContext('2d').drawImage(cameraVideo, 0, 0);
    const dataUrl = cameraCanvas.toDataURL('image/jpeg', 0.95);
    originalBase64 = dataUrl;
    loadImageFromUrl(dataUrl);
    getCameraModal().hide();
  });

  /* ══════════════════════════════════════
     Procesamiento OCR via OCR.space (backend)
  ══════════════════════════════════════ */
  btnProcesar.addEventListener('click', async () => {
    console.log('[OCR] click en Leer balanza. selection=', selection, 'image=', !!originalImage);

    if (!selection) {
      showToast('Primero arrastra sobre el display de la balanza para seleccionarlo.');
      return;
    }
    if (!originalImage) {
      showToast('Carga una imagen primero.');
      return;
    }

    /* Recortar desde la imagen original (coordenadas reales, sin escala de display) */
    const realX = selection.x / imgScale;
    const realY = selection.y / imgScale;
    const realW = selection.w / imgScale;
    const realH = selection.h / imgScale;

    console.log('[OCR] recorte real:', { realX, realY, realW, realH });

    /* Upscale 2x y preprocesar para display LED */
    const UP = 3;
    const offscreen = document.createElement('canvas');
    offscreen.width  = Math.round(realW * UP);
    offscreen.height = Math.round(realH * UP);
    const octx = offscreen.getContext('2d');
    octx.imageSmoothingEnabled = true;
    octx.imageSmoothingQuality = 'high';
    octx.drawImage(originalImage, realX, realY, realW, realH, 0, 0, offscreen.width, offscreen.height);

    /* Preprocesar para display LED:
       1. Extraer canal máximo (captura rojo/naranja independientemente del color del LED)
       2. Contraste fuerte sin binarizar (preserva más información para Tesseract)
       3. Invertir: dígito claro → negro sobre fondo blanco */
    const id = octx.getImageData(0, 0, offscreen.width, offscreen.height);
    const d  = id.data;
    for (let i = 0; i < d.length; i += 4) {
      // Canal máximo amplifica cualquier color de LED (rojo, verde, naranja, azul)
      const v = Math.max(d[i], d[i+1], d[i+2]);
      // Curva de contraste: oscuro se hace más oscuro, claro más claro
      const c = Math.min(255, Math.pow(v / 255, 0.4) * 255);
      // Invertir: fondo oscuro → blanco, dígito brillante → negro
      const inv = 255 - c;
      d[i] = d[i+1] = d[i+2] = inv;
    }
    octx.putImageData(id, 0, 0);

    /* Guardar base64 del recorte procesado para enviarlo al guardar */
    lastCropBase64 = offscreen.toDataURL('image/png');
    cropPreview.src = lastCropBase64;
    cropPreviewWrap.style.display = 'block';

    console.log('[OCR] base64 length:', offscreen.toDataURL('image/png').length);

    btnProcesar.disabled = true;
    btnProcesar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando…';
    progressWrap.style.display = 'block';
    progressFill.style.width = '20%';
    progressLabel.textContent = 'Iniciando OCR…';
    resultWrap.style.display = 'none';
    pesoInput.value = '';

    try {
      progressFill.style.width = '50%';
      progressLabel.textContent = 'Reconociendo texto…';

      const result = await Tesseract.recognize(offscreen, 'eng', {
        tessedit_pageseg_mode:   '7',           // línea de texto única
        tessedit_char_whitelist: '0123456789.',
      });

      progressFill.style.width = '100%';
      const rawText = result.data.text.trim();
      console.log('[OCR] Tesseract raw:', rawText);

      resultText.textContent = rawText || '(sin texto)';
      resultWrap.style.display = 'block';

      const valor = extraerValor(rawText);
      if (valor !== null) {
        pesoInput.value = valor;
        pesoInput.focus();
        showToast('Peso extraído: ' + valor + ' kg');
      } else {
        showToast('No se detectó número. Edita el campo manualmente.');
      }
    } catch (err) {
      resultText.textContent = 'Error: ' + err.message;
      resultWrap.style.display = 'block';
      showToast('Error: ' + err.message);
    } finally {
      btnProcesar.disabled = false;
      btnProcesar.innerHTML = '<i class="fas fa-magnifying-glass"></i> Leer balanza';
      progressWrap.style.display = 'none';
    }
  });

  /* Extrae el valor numérico del texto OCR de una balanza */
  function extraerValor(texto) {
    if (!texto) return null;
    const norm = texto.replace(/,/g, '.');

    // 1. Ya tiene punto decimal → devolverlo directo
    const conPunto = norm.match(/\d{1,5}\.\d{1,3}/);
    if (conPunto) return conPunto[0];

    // 2. Solo dígitos (el punto del display se perdió en el OCR)
    //    Las balanzas siempre muestran X decimal: 4980 → 498.0, 12345 → 1234.5
    const soloDigitos = norm.match(/\d{2,6}/);
    if (soloDigitos) {
      const s = soloDigitos[0];
      return s.slice(0, -1) + '.' + s.slice(-1);
    }

    return null;
  }

  /* ══════════════════════════════════════
     Autocomplete de productos (reutilizable)
  ══════════════════════════════════════ */
  function initAutocomplete(input, dropdown) {
    if (!input || !dropdown) return;
    let timer = null;

    input.addEventListener('input', () => {
      clearTimeout(timer);
      const q = input.value.trim();
      if (q.length < 1) { dropdown.style.display = 'none'; return; }

      timer = setTimeout(async () => {
        try {
          const res  = await fetch('/desechos/buscar?q=' + encodeURIComponent(q));
          const data = await res.json();
          if (!data.length) { dropdown.style.display = 'none'; return; }

          dropdown.innerHTML = data.map(p => `
            <div class="ac-item" data-nombre="${p.nombre}"
              style="padding:9px 14px;cursor:pointer;border-bottom:1px solid #f5f0ff;
                     font-size:13px;transition:background .15s;">
              <div style="font-weight:600;color:#1a0533;">${p.nombre}</div>
              <div style="font-size:11px;color:#7c6fa0;">
                Cód: ${p.codigo_interno || '—'} · ${p.referencia || ''}
              </div>
            </div>`).join('');
          dropdown.style.display = 'block';

          dropdown.querySelectorAll('.ac-item').forEach(item => {
            item.addEventListener('mouseenter', () => item.style.background = '#f5f0ff');
            item.addEventListener('mouseleave', () => item.style.background = '');
            item.addEventListener('mousedown', e => {
              e.preventDefault();
              input.value = item.dataset.nombre;
              dropdown.style.display = 'none';
            });
          });
        } catch { dropdown.style.display = 'none'; }
      }, 250);
    });

    document.addEventListener('click', e => {
      if (!input.contains(e.target) && !dropdown.contains(e.target))
        dropdown.style.display = 'none';
    });

    input.addEventListener('keydown', e => {
      const items = [...dropdown.querySelectorAll('.ac-item')];
      if (!items.length) return;
      const active = dropdown.querySelector('.ac-active');
      let idx = items.indexOf(active);

      if (e.key === 'ArrowDown') {
        e.preventDefault();
        if (active) { active.classList.remove('ac-active'); active.style.background = ''; }
        idx = (idx + 1) % items.length;
        items[idx].classList.add('ac-active'); items[idx].style.background = '#f5f0ff';
      } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        if (active) { active.classList.remove('ac-active'); active.style.background = ''; }
        idx = (idx - 1 + items.length) % items.length;
        items[idx].classList.add('ac-active'); items[idx].style.background = '#f5f0ff';
      } else if (e.key === 'Enter' && active) {
        e.preventDefault();
        input.value = active.dataset.nombre;
        dropdown.style.display = 'none';
      } else if (e.key === 'Escape') {
        dropdown.style.display = 'none';
      }
    });
  }

  /* Aplicar a Captura Inteligente y Captura Manual */
  initAutocomplete(nombreInput, nombreDropdown);
  initAutocomplete(
    document.getElementById('man-nombre-input'),
    document.getElementById('man-nombre-dropdown')
  );

  /* ── Imagen captura manual ── */
  let manOriginalBase64 = null;
  const manFileInput    = document.getElementById('man-file-input');
  const manDropZone     = document.getElementById('captura_manual');
  const manDropHint     = document.getElementById('man-drop-hint');
  const manPreviewWrap  = document.getElementById('man-preview-wrap');
  const manPreviewImg   = document.getElementById('man-preview-img');

  function loadManImage(file) {
    if (!file || !file.type.startsWith('image/')) return;
    const reader = new FileReader();
    reader.onload = e => {
      manOriginalBase64 = e.target.result;
      manPreviewImg.src = e.target.result;
      manDropHint.style.display  = 'none';
      manPreviewWrap.style.display = 'block';
    };
    reader.readAsDataURL(file);
  }

  if (manFileInput) {
    manFileInput.addEventListener('change', () => {
      if (manFileInput.files[0]) loadManImage(manFileInput.files[0]);
    });
  }
  if (manDropZone) {
    manDropZone.addEventListener('dragover', e => { e.preventDefault(); manDropZone.style.borderColor = '#4a8a37'; });
    manDropZone.addEventListener('dragleave', () => { manDropZone.style.borderColor = '#d4eacc'; });
    manDropZone.addEventListener('drop', e => {
      e.preventDefault();
      manDropZone.style.borderColor = '#d4eacc';
      const f = e.dataTransfer.files[0];
      if (f) loadManImage(f);
    });
  }

  /* ══════════════════════════════════════
     Guardar en base de datos
  ══════════════════════════════════════ */
  btnGuardar.addEventListener('click', async () => {
    const nombre   = nombreInput   ? nombreInput.value.trim()   : '';
    const peso     = pesoInput     ? pesoInput.value.trim()     : '';
    const unidades = unidadesInput ? unidadesInput.value.trim() : '';

    if (!nombre) {
      showToast('Ingresa el nombre o código del producto.');
      nombreInput && nombreInput.focus();
      return;
    }
    if (!peso) {
      showToast('El peso está vacío. Usa el OCR o ingrésalo manualmente.');
      pesoInput && pesoInput.focus();
      return;
    }

    const textoOriginal = btnGuardar.innerHTML;
    btnGuardar.disabled  = true;
    btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando…';

    try {
      const body = new FormData();
      body.append('nombre',   nombre);
      body.append('unidades', unidades);
      body.append('peso',     peso);
      body.append('imagen',   originalBase64 || '');

      const res  = await fetch('/desechos/guardar', { method: 'POST', body });
      const json = await res.json();

      if (json.status === 'success') {
        showToast('Registro guardado correctamente.', 'success');
        setTimeout(() => location.reload(), 1600);
      } else {
        showToast('Error: ' + (json.message || 'No se pudo guardar.'));
      }
    } catch (err) {
      showToast('Error de red: ' + err.message);
    } finally {
      btnGuardar.disabled  = false;
      btnGuardar.innerHTML = textoOriginal;
    }
  });

  /* ══════════════════════════════════════
     Guardar — Captura Manual
  ══════════════════════════════════════ */
  const manBtnGuardar   = document.getElementById('man-btn-guardar');
  const manNombreInput  = document.getElementById('man-nombre-input');
  const manPesoInput    = document.getElementById('man-peso-input');
  const manUnidadesInput = document.getElementById('man-unidades-input');

  if (manBtnGuardar) {
    manBtnGuardar.addEventListener('click', async () => {
      const nombre   = manNombreInput   ? manNombreInput.value.trim()   : '';
      const peso     = manPesoInput     ? manPesoInput.value.trim()     : '';
      const unidades = manUnidadesInput ? manUnidadesInput.value.trim() : '';

      if (!nombre) {
        showToast('Ingresa el nombre o código del producto.');
        manNombreInput && manNombreInput.focus();
        return;
      }
      if (!peso) {
        showToast('Ingresa el peso en kg.');
        manPesoInput && manPesoInput.focus();
        return;
      }

      const textoOriginal = manBtnGuardar.innerHTML;
      manBtnGuardar.disabled  = true;
      manBtnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando…';

      try {
        const body = new FormData();
        body.append('nombre',   nombre);
        body.append('unidades', unidades);
        body.append('peso',     peso);
        body.append('imagen',   manOriginalBase64 || '');

        const res  = await fetch('/desechos/guardar', { method: 'POST', body });
        const json = await res.json();

        if (json.status === 'success') {
          showToast('Registro guardado correctamente.', 'success');
          setTimeout(() => location.reload(), 1600);
        } else {
          showToast('Error: ' + (json.message || 'No se pudo guardar.'));
        }
      } catch (err) {
        showToast('Error de red: ' + err.message);
      } finally {
        manBtnGuardar.disabled  = false;
        manBtnGuardar.innerHTML = textoOriginal;
      }
    });
  }

  /* ══════════════════════════════════════
     Toast (notificación flotante simple)
  ══════════════════════════════════════ */
  let toastTimer = null;
  function showToast(msg, tipo) {
    let t = document.getElementById('ocr-toast');
    if (!t) {
      t = document.createElement('div');
      t.id = 'ocr-toast';
      t.style.cssText = 'position:fixed;bottom:26px;right:26px;padding:12px 20px;border-radius:10px;font-size:13px;font-weight:600;z-index:9999;box-shadow:0 8px 30px rgba(0,0,0,.25);display:none;transition:opacity .3s;';
      document.body.appendChild(t);
    }
    t.textContent = (tipo === 'success' ? '✓  ' : '') + msg;
    t.style.background = tipo === 'success' ? '#065f46' : '#1a0533';
    t.style.color = '#fff';
    t.style.display = 'block';
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => { t.style.display = 'none'; }, tipo === 'success' ? 2000 : 3500);
  }

})();

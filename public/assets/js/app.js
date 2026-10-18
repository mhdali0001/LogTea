// ============================================================
// LogTea — shared front-end behaviour (company site + tools)
// ============================================================

function initNavScroll() {
  const nb = document.getElementById('navbar');
  const btt = document.getElementById('backToTop');
  if (!nb) return;
  const update = () => {
    nb.classList.toggle('scrolled', window.scrollY > 40);
    if (btt) btt.classList.toggle('visible', window.scrollY > 400);
  };
  window.addEventListener('scroll', update, { passive: true });
  update();
}

function initHamburger() {
  const btn = document.getElementById('hamburger');
  const nav = document.getElementById('navLinks');
  if (!btn || !nav) return;
  btn.addEventListener('click', () => {
    nav.classList.toggle('open');
    btn.classList.toggle('active');
  });
  document.addEventListener('click', (e) => {
    if (!btn.contains(e.target) && !nav.contains(e.target)) {
      nav.classList.remove('open');
      btn.classList.remove('active');
    }
  });
}

function initBackToTop() {
  const el = document.getElementById('backToTop');
  if (!el) return;
  el.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

function initHeroParticles() {
  const wrap = document.querySelector('.hero-bg .particles');
  if (!wrap) return;
  const count = window.innerWidth < 760 ? 12 : 24;
  for (let i = 0; i < count; i++) {
    const p = document.createElement('span');
    p.className = 'particle';
    const size = 2 + Math.random() * 3;
    p.style.width = size + 'px';
    p.style.height = size + 'px';
    p.style.left = Math.random() * 100 + '%';
    p.style.top = Math.random() * 100 + '%';
    p.style.opacity = (0.2 + Math.random() * 0.4).toFixed(2);
    p.style.animationDuration = (6 + Math.random() * 6).toFixed(1) + 's';
    p.style.animationDelay = (Math.random() * 6).toFixed(1) + 's';
    wrap.appendChild(p);
  }
}

function initFAQ() {
  document.querySelectorAll('.faq-item').forEach((item) => {
    const btn = item.querySelector('.faq-question');
    if (!btn) return;
    btn.addEventListener('click', () => {
      const isOpen = item.classList.contains('open');
      document.querySelectorAll('.faq-item').forEach((i) => i.classList.remove('open'));
      if (!isOpen) item.classList.add('open');
    });
  });
}

function initCategoryTabs() {
  const tabs = document.querySelectorAll('.cat-tab');
  const cards = document.querySelectorAll('.tool-card');
  const empty = document.querySelector('.tool-empty');
  if (!tabs.length) return;

  tabs.forEach((tab) => {
    tab.addEventListener('click', () => {
      tabs.forEach((t) => t.classList.remove('active'));
      tab.classList.add('active');
      const cat = tab.getAttribute('data-cat');
      let visible = 0;
      cards.forEach((card) => {
        const show = cat === 'all' || card.getAttribute('data-cat') === cat;
        card.style.display = show ? '' : 'none';
        if (show) visible++;
      });
      if (empty) empty.style.display = visible ? 'none' : 'block';
    });
  });
}

function initToolSearch() {
  const input = document.getElementById('toolSearch');
  const cards = document.querySelectorAll('.tool-card');
  const empty = document.querySelector('.tool-empty');
  if (!input) return;

  input.addEventListener('input', () => {
    const q = input.value.trim().toLowerCase();
    document.querySelectorAll('.cat-tab').forEach((t) => t.classList.remove('active'));
    document.querySelector('.cat-tab[data-cat="all"]')?.classList.add('active');
    let visible = 0;
    cards.forEach((card) => {
      const hay = (card.getAttribute('data-name') || '') + ' ' + (card.getAttribute('data-desc') || '');
      const show = q === '' || hay.includes(q);
      card.style.display = show ? '' : 'none';
      if (show) visible++;
    });
    if (empty) empty.style.display = visible ? 'none' : 'block';
  });
}

// ============================================================
// Company pages: scroll reveal, counters, portfolio filter
// ============================================================

function initReveal() {
  const els = document.querySelectorAll('[data-reveal]');
  if (!els.length) return;
  if (!('IntersectionObserver' in window)) {
    els.forEach((el) => el.classList.add('is-visible'));
    return;
  }
  const obs = new IntersectionObserver((entries) => {
    entries.forEach((en) => {
      if (!en.isIntersecting) return;
      en.target.classList.add('is-visible');
      obs.unobserve(en.target);
    });
  }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
  els.forEach((el) => obs.observe(el));
}

function initCounters() {
  const els = document.querySelectorAll('[data-count]');
  if (!els.length || !('IntersectionObserver' in window)) return;
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  const obs = new IntersectionObserver((entries) => {
    entries.forEach((en) => {
      if (!en.isIntersecting) return;
      obs.unobserve(en.target);
      const el = en.target;
      const target = +el.getAttribute('data-count');
      // The final number stays in the markup until the first frame, so the
      // stat never sits at 0 if animation frames are throttled.
      let start = null;
      const tick = (now) => {
        if (start === null) start = now;
        const t = Math.min((now - start) / 1400, 1);
        el.textContent = Math.round(target * (1 - Math.pow(1 - t, 3)));
        if (t < 1) requestAnimationFrame(tick);
      };
      requestAnimationFrame(tick);
    });
  }, { threshold: 0.5 });
  els.forEach((el) => obs.observe(el));
}

function initPortfolioFilter() {
  const btns = document.querySelectorAll('.pf-btn');
  const cards = document.querySelectorAll('.port-card[data-category]');
  if (!btns.length) return;
  btns.forEach((btn) => {
    btn.addEventListener('click', () => {
      btns.forEach((b) => b.classList.remove('active'));
      btn.classList.add('active');
      const filter = btn.getAttribute('data-filter');
      cards.forEach((card) => {
        const cats = (card.getAttribute('data-category') || '').split(' ');
        card.style.display = filter === 'all' || cats.includes(filter) ? '' : 'none';
      });
    });
  });
}

function initTodayHours() {
  const today = String(new Date().getDay());
  document.querySelectorAll('.hours-item[data-days]').forEach((item) => {
    if (item.getAttribute('data-days').split(',').includes(today)) item.classList.add('is-today');
  });
}

// ============================================================
// Tool page: dropzone, file list, options, AJAX processing
// ============================================================

function formatBytes(bytes) {
  if (bytes < 1024) return bytes + ' B';
  if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
  return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
}

function initToolPage() {
  const root = document.querySelector('[data-tool-app]');
  if (!root) return;

  const config = JSON.parse(root.getAttribute('data-tool-app'));
  const dropzone = root.querySelector('.dropzone');
  const fileInput = root.querySelector('.dropzone input[type=file]');
  const fileListEl = root.querySelector('.file-list');
  const submitBtn = root.querySelector('.tool-submit');
  const progressEl = root.querySelector('.tool-progress');
  const progressFill = root.querySelector('.progress-bar-fill');
  const progressLabel = root.querySelector('.progress-label');
  const resultEl = root.querySelector('.tool-result');
  const errorEl = root.querySelector('.tool-error');
  const resetBtn = root.querySelector('.tool-reset');

  let files = [];

  function renderFiles() {
    fileListEl.innerHTML = '';
    files.forEach((file, i) => {
      const row = document.createElement('div');
      row.className = 'file-row';
      row.innerHTML = `
        <span class="fr-name">${file.name}</span>
        <span class="fr-size">${formatBytes(file.size)}</span>
        ${config.multiple && files.length > 1 ? `
          <button type="button" class="fr-up" ${i === 0 ? 'disabled style="opacity:.3"' : ''}>↑</button>
          <button type="button" class="fr-down" ${i === files.length - 1 ? 'disabled style="opacity:.3"' : ''}>↓</button>
        ` : ''}
        <button type="button" class="fr-remove" title="إزالة">×</button>
      `;
      row.querySelector('.fr-remove').addEventListener('click', () => {
        files.splice(i, 1);
        renderFiles();
      });
      row.querySelector('.fr-up')?.addEventListener('click', () => {
        [files[i - 1], files[i]] = [files[i], files[i - 1]];
        renderFiles();
      });
      row.querySelector('.fr-down')?.addEventListener('click', () => {
        [files[i + 1], files[i]] = [files[i], files[i + 1]];
        renderFiles();
      });
      fileListEl.appendChild(row);
    });
    updateSubmitState();
  }

  function addFiles(list) {
    const accepted = Array.from(list).filter((f) => {
      const ext = f.name.split('.').pop().toLowerCase();
      return config.accept.includes(ext);
    });
    if (!config.multiple) {
      files = accepted.slice(0, 1);
    } else {
      files = files.concat(accepted);
    }
    renderFiles();
  }

  function updateSubmitState() {
    const min = config.minFiles || 1;
    submitBtn.disabled = files.length < min;
  }

  dropzone.addEventListener('click', () => fileInput.click());
  dropzone.addEventListener('dragover', (e) => { e.preventDefault(); dropzone.classList.add('dragover'); });
  dropzone.addEventListener('dragleave', () => dropzone.classList.remove('dragover'));
  dropzone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzone.classList.remove('dragover');
    addFiles(e.dataTransfer.files);
  });
  fileInput.addEventListener('change', () => {
    addFiles(fileInput.files);
    fileInput.value = '';
  });

  function collectOptions() {
    const options = {};
    root.querySelectorAll('[data-opt]').forEach((el) => {
      const name = el.getAttribute('data-opt');
      const wrapper = el.closest('.opt-field');
      if (wrapper && wrapper.style.display === 'none') return;
      options[name] = el.value;
    });
    return options;
  }

  function showError(message) {
    errorEl.textContent = message;
    errorEl.classList.add('active');
    progressEl.classList.remove('active');
    submitBtn.disabled = false;
    submitBtn.textContent = config.submitLabel;
  }

  submitBtn.addEventListener('click', () => {
    errorEl.classList.remove('active');
    if (files.length < (config.minFiles || 1)) return;

    const formData = new FormData();
    files.forEach((f) => formData.append('files[]', f));
    const options = collectOptions();
    Object.keys(options).forEach((k) => formData.append(k, options[k]));

    submitBtn.disabled = true;
    submitBtn.textContent = 'جارِ المعالجة...';
    progressEl.classList.add('active');
    progressFill.style.width = '0%';
    progressLabel.textContent = 'جارِ رفع الملف...';

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/api/process.php?slug=' + encodeURIComponent(config.slug));

    xhr.upload.addEventListener('progress', (e) => {
      if (!e.lengthComputable) return;
      const pct = Math.round((e.loaded / e.total) * 100);
      progressFill.style.width = pct + '%';
      progressLabel.textContent = pct < 100 ? `جارِ الرفع... ${pct}%` : 'جارِ المعالجة على الخادم...';
    });

    xhr.onload = () => {
      let data;
      try {
        data = JSON.parse(xhr.responseText);
      } catch (e) {
        showError('حدث خطأ غير متوقع أثناء المعالجة.');
        return;
      }
      if (!xhr.status || xhr.status >= 400 || !data.ok) {
        showError(data.error || 'تعذرت معالجة الملف.');
        return;
      }
      progressEl.classList.remove('active');
      root.querySelector('.tool-upload-area').style.display = 'none';
      resultEl.classList.add('active');
      const link = resultEl.querySelector('.result-download');
      link.href = data.downloadUrl;
      link.setAttribute('download', data.filename);
      resultEl.querySelector('.result-filename').textContent = data.filename + ' — ' + formatBytes(data.size);
    };

    xhr.onerror = () => showError('تعذر الاتصال بالخادم. حاول مرة أخرى.');
    xhr.send(formData);
  });

  resetBtn?.addEventListener('click', () => {
    files = [];
    renderFiles();
    resultEl.classList.remove('active');
    errorEl.classList.remove('active');
    root.querySelector('.tool-upload-area').style.display = '';
    submitBtn.textContent = config.submitLabel;
    submitBtn.disabled = true;
  });

  // conditional option fields (data-depends-on="mode:range")
  root.querySelectorAll('[data-depends-on]').forEach((wrapper) => {
    const [depName, depValue] = wrapper.getAttribute('data-depends-on').split(':');
    const controller = root.querySelector(`[data-opt="${depName}"]`);
    if (!controller) return;
    const sync = () => { wrapper.style.display = controller.value === depValue ? '' : 'none'; };
    controller.addEventListener('change', sync);
    sync();
  });

  // range inputs: show live value
  root.querySelectorAll('input[type=range][data-opt]').forEach((range) => {
    const out = range.parentElement.querySelector('.opt-range-value');
    if (!out) return;
    const sync = () => { out.textContent = range.value; };
    range.addEventListener('input', sync);
    sync();
  });

  updateSubmitState();
}

document.addEventListener('DOMContentLoaded', () => {
  initNavScroll();
  initHamburger();
  initBackToTop();
  initHeroParticles();
  initFAQ();
  initReveal();
  initCounters();
  initPortfolioFilter();
  initTodayHours();
  initCategoryTabs();
  initToolSearch();
  initToolPage();
});

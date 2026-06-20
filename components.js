// ============================================================
// LogTea — Shared Components (Navbar + Footer + Common Init)
// ============================================================

const NAVBAR = `
<header class="navbar" id="navbar">
  <div class="container nav-inner">
    <a href="index.html" class="logo">
      <img src="image/Logo.jpeg" alt="LogTea" class="nav-logo-img" />
    </a>
    <nav class="nav-links" id="navLinks">
      <a href="index.html"     class="nav-link" data-page="index"     data-i18n="nav.home">الرئيسية</a>
      <a href="about.html"     class="nav-link" data-page="about"     data-i18n="nav.about">من نحن</a>
      <a href="services.html"  class="nav-link" data-page="services"  data-i18n="nav.services">الخدمات</a>
      <a href="portfolio.html" class="nav-link" data-page="portfolio" data-i18n="nav.portfolio">أعمالنا</a>
      <a href="blog.html"      class="nav-link" data-page="blog"      data-i18n="nav.blog">المدونة</a>
      <a href="contact.html"   class="nav-link" data-page="contact"   data-i18n="nav.contact">تواصل معنا</a>
    </nav>
    <button class="lang-toggle" id="langToggle" onclick="window.LangManager && window.LangManager.toggle()">
      <span class="lt-flag">🌐</span> EN
    </button>
    <a href="contact.html" class="btn btn-primary nav-cta" data-i18n="nav.cta">ابدأ الآن ↗</a>
    <button class="hamburger" id="hamburger" aria-label="Toggle menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</header>`;

const FOOTER = `
<footer class="footer">
  <div class="footer-glow"></div>
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a href="index.html" class="logo" style="margin-bottom:16px;display:flex;">
          <img src="image/Logo.jpeg" alt="LogTea" class="nav-logo-img" />
        </a>
        <p data-i18n="footer.desc">شركة برمجية متخصصة تحوّل أفكارك إلى حلول رقمية ذكية باستخدام أحدث التقنيات وأفضل الممارسات.</p>
        <div class="footer-social">
          <a href="#" aria-label="LinkedIn" class="social-link">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
          </a>
          <a href="#" aria-label="Twitter" class="social-link">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
          </a>
          <a href="#" aria-label="GitHub" class="social-link">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg>
          </a>
          <a href="#" aria-label="Instagram" class="social-link">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
          </a>
        </div>
      </div>
      <div class="footer-col">
        <h4 data-i18n="footer.col1">الخدمات</h4>
        <ul>
          <li><a href="services.html">AI Solutions</a></li>
          <li><a href="services.html">Web Development</a></li>
          <li><a href="services.html">Cyber Security</a></li>
          <li><a href="services.html">Cloud Services</a></li>
          <li><a href="services.html">APIs &amp; Integrations</a></li>
          <li><a href="services.html">Database Solutions</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4 data-i18n="footer.col2">الشركة</h4>
        <ul>
          <li><a href="about.html"     data-i18n="nav.about">من نحن</a></li>
          <li><a href="portfolio.html" data-i18n="nav.portfolio">أعمالنا</a></li>
          <li><a href="blog.html"      data-i18n="nav.blog">المدونة</a></li>
          <li><a href="contact.html"   data-i18n="nav.contact">تواصل معنا</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4 data-i18n="footer.col3">النشرة البريدية</h4>
        <p data-i18n="footer.nl.desc">اشترك للحصول على أحدث المقالات والأخبار التقنية</p>
        <form class="footer-newsletter" onsubmit="return false;">
          <input type="email" data-i18n-ph="footer.nl.ph" placeholder="بريدك الإلكتروني" />
          <button type="submit" class="btn btn-primary" style="padding:12px 18px;" data-i18n="footer.nl.btn">→</button>
        </form>
        <div class="footer-badges">
          <span data-i18n="footer.badge1">✓ بدون سبام</span>
          <span data-i18n="footer.badge2">✓ إلغاء الاشتراك بسهولة</span>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© 2024 LogTea Software Solutions. جميع الحقوق محفوظة.</p>
      <div class="footer-bottom-links">
        <a href="#">سياسة الخصوصية</a>
        <a href="#">الشروط والأحكام</a>
      </div>
    </div>
  </div>
</footer>`;

// ── Inject ──────────────────────────────────────────────────
function injectComponents() {
  const navEl = document.getElementById('nav-placeholder');
  const footEl = document.getElementById('footer-placeholder');
  if (navEl)  navEl.innerHTML  = NAVBAR;
  if (footEl) footEl.innerHTML = FOOTER;

  // active link
  const page = document.body.getAttribute('data-page') || 'index';
  document.querySelectorAll('.nav-link[data-page]').forEach(a => {
    if (a.getAttribute('data-page') === page) a.classList.add('active');
  });
}

// ── Navbar scroll ────────────────────────────────────────────
function initNavScroll() {
  const nb = document.getElementById('navbar');
  const btt = document.getElementById('backToTop');
  if (!nb) return;

  window.addEventListener('scroll', () => {
    nb.classList.toggle('scrolled', window.scrollY > 60);
    if (btt) btt.classList.toggle('visible', window.scrollY > 400);
  }, { passive: true });
}

// ── Hamburger ────────────────────────────────────────────────
function initHamburger() {
  const btn = document.getElementById('hamburger');
  const nav = document.getElementById('navLinks');
  if (!btn || !nav) return;

  btn.addEventListener('click', () => {
    nav.classList.toggle('open');
    btn.classList.toggle('active');
  });
  document.addEventListener('click', e => {
    if (!btn.contains(e.target) && !nav.contains(e.target)) {
      nav.classList.remove('open');
      btn.classList.remove('active');
    }
  });
  nav.querySelectorAll('.nav-link').forEach(a => {
    a.addEventListener('click', () => {
      nav.classList.remove('open');
      btn.classList.remove('active');
    });
  });
}

// ── AOS ──────────────────────────────────────────────────────
function initAOS() {
  const els = document.querySelectorAll('[data-aos]');
  const obs = new IntersectionObserver(entries => {
    entries.forEach(en => {
      if (en.isIntersecting) {
        const delay = parseInt(en.target.getAttribute('data-aos-delay') || 0);
        setTimeout(() => en.target.classList.add('aos-animate'), delay);
      }
    });
  }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
  els.forEach(el => obs.observe(el));
}

// ── Stats Counter ─────────────────────────────────────────────
function initCounters() {
  const obs = new IntersectionObserver(entries => {
    entries.forEach(en => {
      if (!en.isIntersecting) return;
      const el = en.target.querySelector('[data-count]');
      if (!el || el.classList.contains('counted')) return;
      el.classList.add('counted');
      const target = +el.getAttribute('data-count');
      let n = 0;
      const step = target / 80;
      const t = setInterval(() => {
        n = Math.min(n + step, target);
        el.textContent = Math.floor(n);
        if (n >= target) clearInterval(t);
      }, 20);
    });
  }, { threshold: 0.5 });
  document.querySelectorAll('.stats-item').forEach(el => obs.observe(el));
}

// ── Back to top ───────────────────────────────────────────────
function initBackToTop() {
  const el = document.getElementById('backToTop');
  if (el) el.addEventListener('click', e => {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

// ── Smooth scroll ─────────────────────────────────────────────
function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const t = document.querySelector(a.getAttribute('href'));
      if (t) { e.preventDefault(); t.scrollIntoView({ behavior: 'smooth' }); }
    });
  });
}

// ── Contact Form ──────────────────────────────────────────────
function initForms() {
  document.querySelectorAll('.contact-form, .page-contact-form').forEach(form => {
    form.addEventListener('submit', e => {
      e.preventDefault();
      const btn = form.querySelector('button[type="submit"]');
      const orig = btn.innerHTML;
      btn.innerHTML = '<span>جاري الإرسال...</span>';
      btn.disabled = true;
      setTimeout(() => {
        btn.innerHTML = '<span>✓ تم الإرسال بنجاح</span>';
        btn.style.background = 'linear-gradient(135deg,#22c55e,#16a34a)';
        setTimeout(() => {
          btn.innerHTML = orig;
          btn.disabled = false;
          btn.style.background = '';
          form.reset();
        }, 3000);
      }, 1500);
    });
  });
}

// ── FAQ Accordion ─────────────────────────────────────────────
function initFAQ() {
  document.querySelectorAll('.faq-item').forEach(item => {
    const btn = item.querySelector('.faq-question');
    if (!btn) return;
    btn.addEventListener('click', () => {
      const isOpen = item.classList.contains('open');
      document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
      if (!isOpen) item.classList.add('open');
    });
  });
}

// ── Portfolio Filter ──────────────────────────────────────────
function initPortfolioFilter() {
  const btns  = document.querySelectorAll('.pf-btn');
  const cards = document.querySelectorAll('.portfolio-card, .port-card');
  if (!btns.length) return;

  btns.forEach(btn => {
    btn.addEventListener('click', () => {
      btns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const filter = btn.getAttribute('data-filter');
      cards.forEach(card => {
        const cats = card.getAttribute('data-category') || '';
        const show = filter === 'all' || cats.includes(filter);
        card.style.transition = 'opacity .35s, transform .35s';
        if (show) {
          card.style.opacity = '1';
          card.style.transform = 'scale(1)';
          card.style.display = '';
        } else {
          card.style.opacity = '0';
          card.style.transform = 'scale(0.95)';
          setTimeout(() => { if (!cats.includes(document.querySelector('.pf-btn.active')?.getAttribute('data-filter') || '')) card.style.display = 'none'; }, 350);
        }
      });
    });
  });
}

// ── Init ──────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  injectComponents();
  initNavScroll();
  initHamburger();
  initAOS();
  initCounters();
  initBackToTop();
  initSmoothScroll();
  initForms();
  initFAQ();
  initPortfolioFilter();
  // Apply language after all components are injected
  if (window.LangManager) window.LangManager.apply();
});

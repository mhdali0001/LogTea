// ===========================
// LogTea - Main JavaScript
// ===========================

// ===== NAVBAR SCROLL =====
const navbar = document.getElementById('navbar');
const backToTop = document.getElementById('backToTop');

window.addEventListener('scroll', () => {
  if (window.scrollY > 60) {
    navbar.classList.add('scrolled');
  } else {
    navbar.classList.remove('scrolled');
  }

  if (window.scrollY > 400) {
    backToTop.classList.add('visible');
  } else {
    backToTop.classList.remove('visible');
  }

  updateActiveNavLink();
});

// ===== HAMBURGER MENU =====
const hamburger = document.getElementById('hamburger');
const navLinks = document.getElementById('navLinks');

hamburger.addEventListener('click', () => {
  navLinks.classList.toggle('open');
  hamburger.classList.toggle('active');
});

document.addEventListener('click', (e) => {
  if (!hamburger.contains(e.target) && !navLinks.contains(e.target)) {
    navLinks.classList.remove('open');
    hamburger.classList.remove('active');
  }
});

navLinks.querySelectorAll('.nav-link').forEach(link => {
  link.addEventListener('click', () => {
    navLinks.classList.remove('open');
    hamburger.classList.remove('active');
  });
});

// ===== ACTIVE NAV LINK =====
function updateActiveNavLink() {
  const sections = document.querySelectorAll('section[id]');
  const links = document.querySelectorAll('.nav-link');
  let current = '';

  sections.forEach(section => {
    const sectionTop = section.offsetTop - 100;
    if (window.scrollY >= sectionTop) {
      current = section.getAttribute('id');
    }
  });

  links.forEach(link => {
    link.classList.remove('active');
    if (link.getAttribute('href') === `#${current}`) {
      link.classList.add('active');
    }
  });
}

// ===== PARTICLES =====
function createParticles() {
  const container = document.getElementById('particles');
  if (!container) return;

  for (let i = 0; i < 50; i++) {
    const particle = document.createElement('div');
    particle.className = 'particle';

    const size = Math.random() * 3 + 1;
    const left = Math.random() * 100;
    const duration = Math.random() * 15 + 10;
    const delay = Math.random() * 10;

    particle.style.cssText = `
      width: ${size}px;
      height: ${size}px;
      left: ${left}%;
      animation-duration: ${duration}s;
      animation-delay: ${delay}s;
      opacity: ${Math.random() * 0.4 + 0.1};
    `;

    container.appendChild(particle);
  }
}
createParticles();

// ===== AOS (Animate on Scroll) =====
function initAOS() {
  const elements = document.querySelectorAll('[data-aos]');

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const delay = entry.target.getAttribute('data-aos-delay') || 0;
        setTimeout(() => {
          entry.target.classList.add('aos-animate');
        }, parseInt(delay));
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

  elements.forEach(el => observer.observe(el));
}
initAOS();

// ===== STATS COUNTER =====
function animateCounter(el, target, duration = 2000) {
  let start = 0;
  const step = target / (duration / 16);

  const timer = setInterval(() => {
    start += step;
    if (start >= target) {
      el.textContent = target;
      clearInterval(timer);
    } else {
      el.textContent = Math.floor(start);
    }
  }, 16);
}

const statsObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      const numEl = entry.target.querySelector('.stats-num[data-count]');
      if (numEl && !numEl.classList.contains('counted')) {
        numEl.classList.add('counted');
        const target = parseInt(numEl.getAttribute('data-count'));
        animateCounter(numEl, target);
      }
    }
  });
}, { threshold: 0.5 });

document.querySelectorAll('.stats-item').forEach(el => statsObserver.observe(el));

// ===== PORTFOLIO FILTER =====
const filterBtns = document.querySelectorAll('.pf-btn');
const portfolioCards = document.querySelectorAll('.portfolio-card');

filterBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    filterBtns.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const filter = btn.getAttribute('data-filter');

    portfolioCards.forEach(card => {
      const categories = card.getAttribute('data-category') || '';

      if (filter === 'all' || categories.includes(filter)) {
        card.style.display = '';
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        requestAnimationFrame(() => {
          card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
          card.style.opacity = '1';
          card.style.transform = 'translateY(0)';
        });
      } else {
        card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => { card.style.display = 'none'; }, 300);
      }
    });
  });
});

// ===== CONTACT FORM =====
const contactForm = document.getElementById('contactForm');
if (contactForm) {
  contactForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const btn = contactForm.querySelector('button[type="submit"]');
    const originalHTML = btn.innerHTML;

    btn.innerHTML = '<span>جاري الإرسال...</span>';
    btn.disabled = true;
    btn.style.opacity = '0.7';

    setTimeout(() => {
      btn.innerHTML = '<span>تم الإرسال بنجاح ✓</span>';
      btn.style.background = 'linear-gradient(135deg, #22c55e, #16a34a)';

      setTimeout(() => {
        btn.innerHTML = originalHTML;
        btn.disabled = false;
        btn.style.opacity = '';
        btn.style.background = '';
        contactForm.reset();
      }, 3000);
    }, 1500);
  });
}

// ===== SMOOTH SCROLL =====
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', (e) => {
    e.preventDefault();
    const target = document.querySelector(anchor.getAttribute('href'));
    if (target) {
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
});

// ===== BACK TO TOP =====
if (backToTop) {
  backToTop.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

// ===== TYPING EFFECT FOR HERO =====
function typeEffect() {
  const codeLines = document.querySelectorAll('.code-line');
  codeLines.forEach((line, i) => {
    line.style.opacity = '0';
    setTimeout(() => {
      line.style.transition = 'opacity 0.3s ease';
      line.style.opacity = '1';
    }, i * 150 + 500);
  });
}
typeEffect();

// ===== NAVBAR LOGO FALLBACK =====
const logoImg = document.querySelector('.navbar .logo img');
if (logoImg) {
  logoImg.addEventListener('error', function() {
    this.style.display = 'none';
  });
}

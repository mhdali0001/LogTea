<?php
/** @var string $activePage */
$activePage = $activePage ?? '';
?>
<header class="navbar" id="navbar">
  <div class="container nav-inner">
    <a href="/" class="logo">
      <span class="logo-badge"><img src="/assets/img/logo.png" alt="LogTea" class="nav-logo-img" /></span>
    </a>
    <nav class="nav-links" id="navLinks">
      <a href="/" class="nav-link<?= $activePage === 'home' ? ' active' : '' ?>">الرئيسية</a>
      <a href="/#tools" class="nav-link<?= $activePage === 'tools' ? ' active' : '' ?>">الأدوات</a>
      <a href="/about.php" class="nav-link<?= $activePage === 'about' ? ' active' : '' ?>">عن المنصة</a>
      <a href="/contact.php" class="nav-link<?= $activePage === 'contact' ? ' active' : '' ?>">تواصل معنا</a>
    </nav>
    <a href="/support.php" class="btn btn-primary nav-cta">ادعم المشروع 💛</a>
    <button class="hamburger" id="hamburger" aria-label="فتح القائمة">
      <span></span><span></span><span></span>
    </button>
  </div>
</header>

<?php
/** @var string $activePage */
$activePage = $activePage ?? '';
$navItems = [
    'home'      => ['/', 'الرئيسية'],
    'about'     => ['/about.php', 'من نحن'],
    'services'  => ['/services.php', 'الخدمات'],
    'portfolio' => ['/portfolio.php', 'أعمالنا'],
    'tools'     => ['/tools.php', 'الأدوات المجانية'],
    'contact'   => ['/contact.php', 'تواصل معنا'],
];
?>
<header class="navbar" id="navbar">
  <div class="container nav-inner">
    <a href="/" class="logo">
      <span class="logo-badge"><img src="/assets/img/logo.png" alt="LogTea" class="nav-logo-img" /></span>
    </a>
    <nav class="nav-links" id="navLinks">
      <?php foreach ($navItems as $key => [$href, $label]): ?>
        <a href="<?= $href ?>" class="nav-link<?= $activePage === $key ? ' active' : '' ?>"><?= $label ?></a>
      <?php endforeach; ?>
    </nav>
    <a href="/contact.php" class="btn btn-primary nav-cta">ابدأ مشروعك ↗</a>
    <button class="hamburger" id="hamburger" aria-label="فتح القائمة">
      <span></span><span></span><span></span>
    </button>
  </div>
</header>

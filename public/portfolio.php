<?php

require __DIR__ . '/../src/bootstrap.php';

use LogTea\ProjectRegistry;
use LogTea\Support\Seo;
use LogTea\Support\TempCleanup;

TempCleanup::run();

$pageTitle = 'أعمالنا | LogTea';
$pageDescription = 'نماذج من مشاريع LogTea: مواقع شركات، متاجر إلكترونية، أنظمة إدارة ومنصات SaaS صممناها وطورناها لعملائنا.';
$activePage = 'portfolio';
$canonicalPath = '/portfolio.php';

$projects = ProjectRegistry::all();
$spotlight = ProjectRegistry::featured();

ob_start();
?>
<section class="page-banner">
  <div class="page-banner-grid"></div>
  <div class="container">
    <div class="breadcrumb"><a href="/">الرئيسية</a><span class="breadcrumb-sep">/</span><span>أعمالنا</span></div>
    <h1>مشاريع <span class="text-teal">نفتخر بها</span></h1>
    <p>120+ مشروع ناجح عبر مختلف القطاعات — من المواقع التعريفية إلى المتاجر والأنظمة المتكاملة</p>
    <div class="banner-stat-row">
      <div class="banner-stat"><strong>120+</strong><span>مشروع مكتمل</span></div>
      <div class="banner-stat"><strong>50+</strong><span>عميل سعيد</span></div>
      <div class="banner-stat"><strong>6</strong><span>دول في المنطقة</span></div>
      <div class="banner-stat"><strong>98%</strong><span>رضا العملاء</span></div>
    </div>
  </div>
</section>

<?php if ($spotlight): ?>
<section class="section" style="padding-top:24px;">
  <div class="container">
    <div class="section-header" data-reveal>
      <div class="section-tag">دراسة حالة مميزة</div>
      <h2 class="section-title">مشروع <span class="text-teal">يستحق التسليط</span></h2>
    </div>
    <div class="case-spotlight" data-reveal>
      <div class="cs-visual">
        <img src="<?= htmlspecialchars($spotlight['image']) ?>" alt="<?= htmlspecialchars($spotlight['title']) ?>" />
      </div>
      <div class="cs-content">
        <span class="cs-label">EdTech · SaaS · Global</span>
        <h2><?= htmlspecialchars($spotlight['title']) ?></h2>
        <p>منصة SaaS عالمية تُمكّن المدارس والجامعات حول العالم من بناء جداولها الدراسية وإدارتها بكفاءة عالية. خوارزميات ذكية تلغي التعارضات تلقائياً وتُقلّص وقت التخطيط بنسبة 70%.</p>
        <div class="cs-stats">
          <div class="cs-stat"><strong>100+</strong><span>مدرسة مشتركة</span></div>
          <div class="cs-stat"><strong>3</strong><span>لغات مدعومة</span></div>
          <div class="cs-stat"><strong>🌍</strong><span>متاح عالمياً</span></div>
        </div>
        <div class="sd-tags" style="margin-bottom:24px;">
          <?php foreach (['Vue.js', 'Python / Django', 'PostgreSQL', 'AWS'] as $tag): ?><span><?= $tag ?></span><?php endforeach; ?>
        </div>
        <a href="/contact.php" class="btn btn-primary">أريد مشروعاً مشابهاً</a>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="section section-dark">
  <div class="container">
    <div class="section-header" data-reveal>
      <div class="section-tag">جميع المشاريع</div>
      <h2 class="section-title">استعرض <span class="text-teal">أعمالنا</span></h2>
    </div>
    <div class="portfolio-filters">
      <button type="button" class="pf-btn active" data-filter="all">الكل</button>
      <?php foreach (ProjectRegistry::categories() as $key => $label): ?>
        <button type="button" class="pf-btn" data-filter="<?= $key ?>"><?= htmlspecialchars($label) ?></button>
      <?php endforeach; ?>
    </div>
    <div class="port-grid">
      <?php foreach ($projects as $project): ?>
        <?php require __DIR__ . '/../templates/partials/project-card.php'; ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-header" data-reveal>
      <div class="section-tag">عملاؤنا</div>
      <h2 class="section-title">شركاء <span class="text-teal">نفتخر بهم</span></h2>
      <p class="section-desc">من الناشئات إلى المؤسسات — نخدم جميع الأحجام والقطاعات</p>
    </div>
    <div class="clients-grid" data-reveal>
      <?php foreach ($projects as $project): ?>
        <?php if ($project['image']): ?>
          <div class="client-logo"><img src="<?= htmlspecialchars($project['image']) ?>" alt="<?= htmlspecialchars($project['title']) ?>" loading="lazy" /></div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="cta-banner">
  <div class="container" data-reveal>
    <h2>مشروعك <span class="text-teal">التالي</span> هنا</h2>
    <p>انضم إلى قائمة عملائنا وحوّل فكرتك إلى موقع أو متجر أو نظام متقن</p>
    <div class="cta-banner-btns">
      <a href="/contact.php" class="btn btn-primary btn-lg">ابدأ مشروعك الآن</a>
      <a href="/services.php" class="btn btn-ghost btn-lg">استعرض خدماتنا</a>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();

$extraHead = Seo::jsonLd([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'الرئيسية', 'item' => Seo::url('/')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'أعمالنا', 'item' => Seo::url('/portfolio.php')],
    ],
]);

require __DIR__ . '/../templates/layout.php';

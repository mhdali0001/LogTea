<?php

require __DIR__ . '/../src/bootstrap.php';

use LogTea\PageSeo;
use LogTea\ProjectRegistry;
use LogTea\ServiceRegistry;
use LogTea\Support\Icons;
use LogTea\Support\TempCleanup;
use LogTea\ToolRegistry;

TempCleanup::run();

['title' => $pageTitle, 'description' => $pageDescription, 'keywords' => $metaKeywords, 'image' => $ogImage] = PageSeo::for('home');
$activePage = 'home';
$canonicalPath = '/';

$services = ServiceRegistry::all();
$projects = array_slice(ProjectRegistry::all(), 0, 6, true);
$tools = ToolRegistry::all();
$showcaseTools = array_intersect_key($tools, array_flip([
    'merge-pdf', 'compress-pdf', 'pdf-to-word', 'word-to-pdf',
    'image-to-pdf', 'split-pdf', 'compress-image', 'excel-to-pdf',
]));

ob_start();
?>
<section class="hero">
  <div class="hero-bg"><div class="grid-lines"></div><div class="particles"></div></div>
  <div class="container hero-inner">
    <div class="hero-content">
      <div class="hero-badge"><span class="badge-dot"></span> شركة برمجة وتصميم مواقع في سوريا منذ 2019</div>
      <h1 class="hero-title">نكتب <span class="text-teal">الشيفرة</span><br/>نصنع <span class="text-teal">الحلول</span></h1>
      <p class="hero-desc">نبرمج ونصمم مواقع ومتاجر إلكترونية وأنظمة إدارة تعكس هوية علامتك وتنمو مع أعمالك — من دمشق لعملائنا في سوريا والمنطقة العربية، بأحدث التقنيات وأفضل الممارسات.</p>
      <div class="hero-actions">
        <a href="/contact.php" class="btn btn-primary btn-lg">ابدأ مشروعك ←</a>
        <a href="/portfolio.php" class="btn btn-ghost btn-lg">شاهد أعمالنا</a>
      </div>
      <div class="hero-stats">
        <div class="stat-item"><span class="stat-num">50+</span><span class="stat-label">عميل سعيد</span></div>
        <div class="stat-divider"></div>
        <div class="stat-item"><span class="stat-num">120+</span><span class="stat-label">مشروع مكتمل</span></div>
        <div class="stat-divider"></div>
        <div class="stat-item"><span class="stat-num">5+</span><span class="stat-label">سنوات خبرة</span></div>
      </div>
    </div>
    <div class="hero-visual">
      <div class="hero-visual-glow"></div>
      <div class="tech-card">
        <div class="card-header">
          <div class="dots"><span></span><span></span><span></span></div>
          <span class="card-title-bar">logtea_solution.py</span>
        </div>
        <div class="code-block" dir="ltr">
          <div class="code-line" style="--i:0"><span class="c-purple">class</span> <span class="c-teal">LogTea</span>:</div>
          <div class="code-line indent" style="--i:1"><span class="c-blue">def</span> <span class="c-yellow">build</span>(self, idea):</div>
          <div class="code-line indent2" style="--i:2"><span class="c-gray">"""نصمم .. نطوّر .. نطلق"""</span></div>
          <div class="code-line indent2" style="--i:3"><span class="c-purple">return</span> {</div>
          <div class="code-line indent3" style="--i:4"><span class="c-teal">"design"</span>: self.ui_ux(idea),</div>
          <div class="code-line indent3" style="--i:5"><span class="c-teal">"web"</span>: self.develop(idea),</div>
          <div class="code-line indent3" style="--i:6"><span class="c-teal">"store"</span>: self.ecommerce(idea),</div>
          <div class="code-line indent3" style="--i:7"><span class="c-teal">"tools"</span>: self.free_tools(),</div>
          <div class="code-line indent2" style="--i:8">}</div>
        </div>
        <div class="terminal-line" dir="ltr"><span class="t-green">✓</span> Building your vision... <span class="cursor-blink">|</span></div>
      </div>
    </div>
  </div>
  <div class="services-bar">
    <div class="container services-bar-inner">
      <?php foreach ($services as $key => $service): ?>
        <a href="<?= $service['url'] ?>" class="service-bar-item">
          <?= Icons::svg($service['icon']) ?>
          <div><strong><?= htmlspecialchars($service['name_en']) ?></strong><span><?= htmlspecialchars($service['name_ar']) ?></span></div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section" id="syria">
  <div class="container">
    <div class="syria-grid">
      <div data-reveal>
        <div class="section-tag">برمجة مواقع في سوريا</div>
        <h2 class="section-title">هل تبحث عن <span class="text-teal">برمجة موقع في سوريا؟</span></h2>
        <p class="syria-lead">LogTea شركة برمجة وتصميم مواقع مقرها دمشق. نبرمج مواقع الشركات والمتاجر الإلكترونية وأنظمة الإدارة، ونخدم العملاء في كل المدن السورية — من دمشق إلى حلب وحمص واللاذقية — ونرافقك في كل مرحلة من الفكرة حتى الإطلاق.</p>
        <ul class="syria-points">
          <li><?= Icons::svg('check') ?>مقرنا في دمشق — نفهم السوق السوري ونتحدث لغتك</li>
          <li><?= Icons::svg('check') ?>مواقع عربية متجاوبة مع الجوال وسريعة التحميل</li>
          <li><?= Icons::svg('check') ?>تحسين الظهور في Google (SEO) من اليوم الأول</li>
          <li><?= Icons::svg('check') ?>استضافة ونشر ودعم فني بعد الإطلاق</li>
        </ul>
        <div class="btn-row">
          <a href="/contact.php" class="btn btn-primary">احصل على استشارة مجانية</a>
          <a href="/portfolio.php" class="btn btn-ghost">شاهد أعمالنا</a>
        </div>
      </div>
      <div class="syria-card" data-reveal>
        <div class="syria-card-head">
          <span class="office-icon"><?= Icons::svg('pin') ?></span>
          <div>
            <span class="syria-card-label">مقرنا الرئيسي</span>
            <strong>دمشق — المالكي، سوريا</strong>
          </div>
        </div>
        <h3 class="syria-card-title">ماذا نبرمج لك؟</h3>
        <div class="syria-services">
          <a href="/services.php#web-development"><?= Icons::svg('code') ?>مواقع الشركات</a>
          <a href="/services.php#ecommerce"><?= Icons::svg('cart') ?>المتاجر الإلكترونية</a>
          <a href="/services.php#systems"><?= Icons::svg('dashboard') ?>أنظمة الإدارة</a>
          <a href="/services.php#web-design"><?= Icons::svg('design') ?>تصميم UI/UX</a>
        </div>
        <h3 class="syria-card-title">نخدم العملاء في</h3>
        <div class="syria-cities">
          <?php foreach (['دمشق', 'حلب', 'حمص', 'اللاذقية', 'حماة', 'طرطوس', 'وكل المحافظات'] as $city): ?>
            <span><?= $city ?></span>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section section-dark">
  <div class="container">
    <div class="section-header" data-reveal>
      <div class="section-tag">خدماتنا</div>
      <h2 class="section-title">كل ما يحتاجه <span class="text-teal">حضورك الرقمي</span></h2>
      <p class="section-desc">من التصميم إلى الإطلاق — ومعها أدوات مجانية تسهّل عملك اليومي</p>
    </div>
    <div class="services-grid">
      <?php foreach ($services as $key => $service): ?>
        <div class="service-card<?= !empty($service['featured']) ? ' sc-featured' : '' ?><?= !empty($service['free']) ? ' sc-free' : '' ?>" data-reveal>
          <?php if (!empty($service['featured'])): ?><div class="sc-badge">الأكثر طلباً</div><?php endif; ?>
          <?php if (!empty($service['free'])): ?><div class="sc-badge sc-badge-free">مجاناً</div><?php endif; ?>
          <div class="sc-icon sc-tone-<?= (int) $service['tone'] ?>"><?= Icons::svg($service['icon']) ?></div>
          <h3><?= htmlspecialchars($service['name_en']) ?></h3>
          <p class="sc-ar"><?= htmlspecialchars($service['name_ar']) ?></p>
          <p class="sc-desc"><?= htmlspecialchars($service['summary']) ?></p>
          <div class="sc-tags"><?php foreach ($service['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
          <a href="<?= $service['url'] ?>" class="sc-link"><?= !empty($service['free']) ? 'جرّب الأدوات الآن ←' : 'اعرف أكثر ←' ?></a>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="section-more" data-reveal>
      <a href="/services.php" class="btn btn-ghost">عرض تفاصيل الخدمات →</a>
    </div>
  </div>
</section>

<section class="stats-section">
  <div class="container">
    <div class="stats-grid">
      <div class="stats-item"><div class="stats-value"><span class="stats-num" data-count="50">50</span><span class="stats-plus">+</span></div><div class="stats-label">عميل سعيد</div></div>
      <div class="stats-item"><div class="stats-value"><span class="stats-num" data-count="120">120</span><span class="stats-plus">+</span></div><div class="stats-label">مشروع مكتمل</div></div>
      <div class="stats-item"><div class="stats-value"><span class="stats-num" data-count="5">5</span><span class="stats-plus">+</span></div><div class="stats-label">سنوات خبرة</div></div>
      <div class="stats-item"><div class="stats-value"><span class="stats-num" data-count="<?= count($tools) ?>"><?= count($tools) ?></span></div><div class="stats-label">أداة ملفات مجانية</div></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="about-grid">
      <div class="about-visual" data-reveal>
        <div class="about-pattern"></div>
        <div class="about-card-float">
          <div class="acf-icon"><?= Icons::svg('bolt') ?></div>
          <div><div class="acf-title">سرعة التنفيذ</div><div class="acf-sub">من الفكرة إلى الإطلاق</div></div>
        </div>
        <div class="about-logo-box">
          <div class="alb-icon">LT</div>
          <div class="alb-ring ring1"></div><div class="alb-ring ring2"></div><div class="alb-ring ring3"></div>
          <div class="tech-dots">
            <span class="td td1">Design</span><span class="td td2">Web</span>
            <span class="td td3">Store</span><span class="td td4">Tools</span>
          </div>
        </div>
      </div>
      <div class="about-content" data-reveal>
        <div class="section-tag">من نحن</div>
        <h2 class="section-title">نصنع <span class="text-teal">المستقبل الرقمي</span></h2>
        <p class="section-desc">LogTea شركة تصميم وتطوير مواقع تجمع الإبداع التقني بالفهم العميق لاحتياجات عملائها. نؤمن بأن كل فكرة تستحق أن تتحول إلى موقع متقن يُحدث فرقاً حقيقياً في أعمالك.</p>
        <div class="about-values">
          <div class="value-item"><div class="value-icon"><?= Icons::svg('bulb') ?></div><div><strong>ابتكار</strong><span>أحدث التقنيات</span></div></div>
          <div class="value-item"><div class="value-icon"><?= Icons::svg('check') ?></div><div><strong>جودة</strong><span>كود نظيف وموثوق</span></div></div>
          <div class="value-item"><div class="value-icon"><?= Icons::svg('shield') ?></div><div><strong>أمان</strong><span>بياناتك في أمان</span></div></div>
          <div class="value-item"><div class="value-icon"><?= Icons::svg('bolt') ?></div><div><strong>سرعة</strong><span>نلتزم بالمواعيد</span></div></div>
        </div>
        <a href="/about.php" class="btn btn-primary">تعرّف علينا أكثر</a>
      </div>
    </div>
  </div>
</section>

<section class="section section-dark">
  <div class="container">
    <div class="section-header" data-reveal>
      <div class="section-tag">أعمالنا</div>
      <h2 class="section-title">مشاريع <span class="text-teal">نفتخر بها</span></h2>
      <p class="section-desc">نماذج من مواقع ومتاجر وأنظمة أطلقناها لعملائنا</p>
    </div>
    <div class="port-grid">
      <?php foreach ($projects as $project): ?>
        <?php require __DIR__ . '/../templates/partials/project-card.php'; ?>
      <?php endforeach; ?>
    </div>
    <div class="section-more" data-reveal>
      <a href="/portfolio.php" class="btn btn-primary">عرض جميع المشاريع →</a>
    </div>
  </div>
</section>

<section class="section" id="tools">
  <div class="container">
    <div class="section-header" data-reveal>
      <div class="section-tag">خدمة مجانية من LogTea</div>
      <h2 class="section-title">أدوات ملفات <span class="text-teal">مجانية</span> للجميع</h2>
      <p class="section-desc">ادمج، اضغط، وحوّل ملفات PDF والصور والمستندات في ثوانٍ — بدون تسجيل، وتُحذف ملفاتك تلقائياً من خوادمنا.</p>
    </div>
    <div class="tool-grid">
      <?php foreach ($showcaseTools as $slug => $tool): ?>
        <?php require __DIR__ . '/../templates/partials/tool-card.php'; ?>
      <?php endforeach; ?>
    </div>
    <div class="section-more" data-reveal>
      <a href="/tools.php" class="btn btn-ghost">تصفح كل الأدوات (<?= count($tools) ?>) →</a>
    </div>
  </div>
</section>

<section class="cta-banner">
  <div class="container" data-reveal>
    <h2>هل لديك فكرة مشروع؟ <span class="text-teal">لنبدأ معاً</span></h2>
    <p>فريقنا مستعد للاستماع وتحويل رؤيتك إلى موقع متقن — الاستشارة الأولى مجانية</p>
    <div class="cta-banner-btns">
      <a href="/contact.php" class="btn btn-primary btn-lg">تواصل معنا الآن</a>
      <a href="/services.php" class="btn btn-ghost btn-lg">استعرض الخدمات</a>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();

$schema = [ServiceRegistry::schema()];

require __DIR__ . '/../templates/layout.php';

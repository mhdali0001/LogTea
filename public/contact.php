<?php

require __DIR__ . '/../src/bootstrap.php';

use LogTea\Company;
use LogTea\PageSeo;
use LogTea\Support\Icons;
use LogTea\Support\TempCleanup;

TempCleanup::run();

['title' => $pageTitle, 'description' => $pageDescription, 'keywords' => $metaKeywords, 'image' => $ogImage] = PageSeo::for('contact');
$activePage = 'contact';
$canonicalPath = '/contact.php';
$pageType = 'ContactPage';
$breadcrumbs = [['تواصل معنا', '/contact.php']];

// Team, offices and hours also feed the site-wide organization schema, so they live in Company.
$team = Company::team();
$offices = Company::offices();
$hours = Company::hours();

$faqs = [
    ['هل يمكنني طلب برمجة موقع وأنا خارج دمشق؟', 'نعم، نعمل عن بُعد مع العملاء في كل المدن السورية وخارج سوريا، ونتابع معك كل مرحلة عبر اجتماعات أونلاين حتى إطلاق موقعك.'],
    ['ما هي مدة الرد على رسالتي؟', 'نرد على رسائل LinkedIn خلال 24 ساعة عمل، ونتفق معك على موعد استشارة أونلاين مجانية.'],
    ['هل الاستشارة الأولى مجانية حقاً؟', 'نعم، الاستشارة الأولى مجانية تماماً وبدون أي التزام. خلالها نفهم احتياجاتك ونقدم رأينا الصريح، حتى لو لم تكمل المشروع معنا.'],
    ['كيف يتم حماية سرية مشروعي؟', 'نوقّع اتفاقية عدم إفصاح (NDA) مع العميل عند الحاجة قبل البدء في أي نقاش تقني. سرية مشروعك جزء من التزامنا.'],
    ['واجهت مشكلة في إحدى الأدوات المجانية، أين أبلغ؟', 'راسل أحد أعضاء فريقنا على LinkedIn واذكر اسم الأداة ونوع الملف — وسنتابعها.'],
];

ob_start();
?>
<section class="page-banner">
  <div class="page-banner-grid"></div>
  <div class="container">
    <div class="breadcrumb"><a href="/">الرئيسية</a><span class="breadcrumb-sep">/</span><span>تواصل معنا</span></div>
    <h1>لنبدأ <span class="text-teal">معاً</span></h1>
    <p>هل تبحث عن برمجة موقع في سوريا؟ تواصل مع فريقنا مباشرة عبر LinkedIn — استشارتك الأولى مجانية تماماً</p>
    <div class="banner-stat-row">
      <div class="banner-stat"><strong>&lt;24h</strong><span>وقت الرد</span></div>
      <div class="banner-stat"><strong>مجانية</strong><span>الاستشارة الأولى</span></div>
      <div class="banner-stat"><strong>100%</strong><span>سرية تامة</span></div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:24px;">
  <div class="container">
    <div class="section-header" data-reveal>
      <div class="section-tag">فريقنا</div>
      <h2 class="section-title">تواصل معنا عبر <span class="text-teal">LinkedIn</span></h2>
      <p class="section-desc">راسل أي عضو من فريقنا مباشرة — نسعد بسماع فكرتك، سواء كانت مشروعاً واضحاً أو مجرد فكرة خام.</p>
    </div>
    <div class="team-grid">
      <?php foreach ($team as $member): ?>
        <?php
          $initials = implode('', array_map(static fn (string $w): string => mb_substr($w, 0, 1), array_slice(explode(' ', $member['name']), 0, 2)));
          $handle = 'linkedin.com' . rtrim((string) parse_url($member['url'], PHP_URL_PATH), '/');
        ?>
        <article class="team-card" data-reveal>
          <div class="team-avatar" aria-hidden="true">
            <?php if ($member['photo'] !== ''): ?>
              <img src="<?= htmlspecialchars($member['photo']) ?>" alt="" width="88" height="88" loading="lazy">
            <?php else: ?>
              <?= htmlspecialchars($initials) ?>
            <?php endif; ?>
          </div>
          <h3 class="team-name" dir="ltr"><?= htmlspecialchars($member['name']) ?></h3>
          <?php if ($member['role'] !== ''): ?><p class="team-role"><?= htmlspecialchars($member['role']) ?></p><?php endif; ?>
          <span class="team-handle" dir="ltr"><?= htmlspecialchars($handle) ?></span>
          <a class="btn btn-linkedin btn-full" href="<?= htmlspecialchars($member['url']) ?>" target="_blank" rel="noopener">
            <?= Icons::brand('linkedin') ?> تواصل عبر LinkedIn
          </a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section-dark">
  <div class="container">
    <div class="section-header" data-reveal>
      <div class="section-tag">أين نحن</div>
      <h2 class="section-title">مكاتبنا <span class="text-teal">وساعات العمل</span></h2>
      <p class="section-desc">فريق موزّع على ثلاث دول، يخدم عملاءنا في المنطقة العربية وتركيا وأوروبا</p>
    </div>
    <div class="offices-grid">
      <?php foreach ($offices as $i => $office): ?>
        <article class="office-card<?= $office['hq'] ? ' is-hq' : '' ?>" data-reveal>
          <span class="office-num" aria-hidden="true"><?= sprintf('%02d', $i + 1) ?></span>
          <div class="office-top">
            <span class="office-icon"><?= Icons::svg('pin') ?></span>
            <span class="office-badge"><?= htmlspecialchars($office['badge']) ?></span>
          </div>
          <h3 class="office-city"><?= htmlspecialchars($office['city']) ?></h3>
          <p class="office-address"><?= htmlspecialchars($office['address']) ?></p>
          <p class="office-note"><?= Icons::svg('globe') ?><?= htmlspecialchars($office['note']) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
    <div class="hours-card" data-reveal>
      <div class="hours-head">
        <span class="office-icon"><?= Icons::svg('clock') ?></span>
        <div>
          <h3>ساعات العمل</h3>
          <p>راسلنا في أي وقت — نرد خلال ساعات العمل</p>
        </div>
      </div>
      <div class="hours-list">
        <?php foreach ($hours as $slot): ?>
          <div class="hours-item" data-days="<?= implode(',', $slot['days']) ?>">
            <span class="hours-day"><?= htmlspecialchars($slot['label']) ?><span class="hours-today">اليوم</span></span>
            <strong class="hours-time"><?= htmlspecialchars($slot['time']) ?></strong>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-header" data-reveal>
      <div class="section-tag">الأسئلة الشائعة</div>
      <h2 class="section-title">أسئلة <span class="text-teal">نسمعها كثيراً</span></h2>
    </div>
    <div class="faq-list">
      <?php foreach ($faqs as [$q, $a]): ?>
        <div class="faq-item">
          <button class="faq-question"><?= htmlspecialchars($q) ?></button>
          <div class="faq-answer"><div class="faq-answer-inner"><?= htmlspecialchars($a) ?></div></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();

// The team, offices and hours are published through the site-wide organization node (Company::schema()).
require __DIR__ . '/../templates/layout.php';

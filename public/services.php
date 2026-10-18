<?php

require __DIR__ . '/../src/bootstrap.php';

use LogTea\ServiceRegistry;
use LogTea\Support\Icons;
use LogTea\Support\Seo;
use LogTea\Support\TempCleanup;
use LogTea\ToolRegistry;

TempCleanup::run();

$pageTitle = 'الخدمات | LogTea';
$pageDescription = 'خدمات LogTea: تصميم المواقع، تطوير المواقع والتطبيقات، المتاجر الإلكترونية، أنظمة الإدارة، حلول الذكاء الاصطناعي، وأدوات ملفات مجانية.';
$activePage = 'services';
$canonicalPath = '/services.php';

$services = ServiceRegistry::all();
$toolCount = count(ToolRegistry::all());

$faqs = [
    ['كم يستغرق تصميم وتطوير موقع احترافي؟', 'يعتمد الوقت على حجم المشروع. موقع تعريفي بسيط يستغرق 2-3 أسابيع، بينما المتاجر والمنصات المعقدة قد تحتاج 2-6 أشهر. نضع جدولاً زمنياً تفصيلياً في بداية كل مشروع ونلتزم به.'],
    ['هل تقدمون ضماناً بعد التسليم؟', 'نعم، نقدم ضمان صيانة لمدة 3 أشهر مجاناً بعد الإطلاق لإصلاح أي مشاكل قد تظهر، إلى جانب خطط دعم مستمر شهرية وسنوية.'],
    ['كيف يتم تسعير المشاريع؟', 'نقدم نظامين للتسعير: سعر ثابت للمشاريع محددة المتطلبات، أو سعر بالساعة للمشاريع المرنة والمستمرة. يبدأ التسعير بعد فهم متطلباتك الكاملة وتحديد نطاق العمل.'],
    ['هل يمكنني إدارة محتوى موقعي بنفسي؟', 'بالتأكيد. نسلّمك لوحة تحكم سهلة لتعديل النصوص والصور والمنتجات، مع شرح عملي لطريقة استخدامها.'],
    ['هل أدوات الملفات المجانية جزء من خدماتكم المدفوعة؟', 'لا — أدوات الملفات متاحة مجاناً للجميع بدون تسجيل. وإن احتجت أداة أو نظاماً مخصصاً لشركتك يمكننا بناؤه لك كمشروع مستقل.'],
];

ob_start();
?>
<section class="page-banner">
  <div class="page-banner-grid"></div>
  <div class="container">
    <div class="breadcrumb"><a href="/">الرئيسية</a><span class="breadcrumb-sep">/</span><span>الخدمات</span></div>
    <h1>حلول رقمية <span class="text-teal">متكاملة</span></h1>
    <p>من تصميم الواجهة إلى إطلاق الموقع ودعمه — نقدم كل ما يحتاجه حضورك الرقمي، ومعها أدوات ملفات مجانية للجميع</p>
    <div class="page-banner-actions">
      <a href="/contact.php" class="btn btn-primary">احصل على استشارة مجانية</a>
      <a href="#services-list" class="btn btn-ghost">استعرض الخدمات</a>
    </div>
  </div>
</section>

<div id="services-list" class="container">
  <?php $i = 0; foreach ($services as $key => $service): $i++; ?>
    <div class="service-detail<?= $i % 2 === 0 ? ' reverse' : '' ?>" id="<?= $key ?>" data-reveal>
      <div class="sd-visual">
        <div class="sd-visual-icon sc-tone-<?= (int) $service['tone'] ?>"><?= Icons::svg($service['icon']) ?></div>
        <span class="sd-badge"><?= htmlspecialchars($service['badge']) ?></span>
      </div>
      <div class="sd-content">
        <div class="sd-icon-sm sc-tone-<?= (int) $service['tone'] ?>"><?= Icons::svg($service['icon']) ?></div>
        <h2><?= htmlspecialchars($service['name_ar']) ?></h2>
        <span class="sd-en"><?= htmlspecialchars($service['name_en']) ?></span>
        <p><?= htmlspecialchars($service['desc']) ?></p>
        <div class="sd-features">
          <?php foreach ($service['features'] as $feature): ?>
            <div class="sd-feature"><?= htmlspecialchars($feature) ?></div>
          <?php endforeach; ?>
        </div>
        <div class="sd-tags"><?php foreach ($service['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
        <?php if (!empty($service['free'])): ?>
          <a href="/tools.php" class="btn btn-primary sd-cta">جرّب الأدوات الآن (<?= $toolCount ?> أداة) ←</a>
        <?php else: ?>
          <a href="/contact.php" class="btn btn-ghost sd-cta">اطلب هذه الخدمة ←</a>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<section class="section section-dark">
  <div class="container">
    <div class="section-header" data-reveal>
      <div class="section-tag">كيف نعمل</div>
      <h2 class="section-title">من الفكرة إلى <span class="text-teal">الإطلاق</span></h2>
    </div>
    <div class="process-steps">
      <div class="process-step" data-reveal><div class="ps-num">01</div><div class="ps-icon"><?= Icons::svg('bulb') ?></div><h3>الاستشارة</h3><p>نفهم احتياجاتك وأهدافك وجمهورك</p></div>
      <div class="process-step" data-reveal><div class="ps-num">02</div><div class="ps-icon"><?= Icons::svg('design') ?></div><h3>التصميم</h3><p>نماذج وواجهات توافق عليها قبل التطوير</p></div>
      <div class="process-step" data-reveal><div class="ps-num">03</div><div class="ps-icon"><?= Icons::svg('code') ?></div><h3>التطوير</h3><p>بناء بأعلى معايير الجودة والأداء</p></div>
      <div class="process-step" data-reveal><div class="ps-num">04</div><div class="ps-icon"><?= Icons::svg('bolt') ?></div><h3>الإطلاق والدعم</h3><p>نطلق موقعك ونواصل الدعم والتحسين</p></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-header" data-reveal>
      <div class="section-tag">الأسئلة الشائعة</div>
      <h2 class="section-title">إجابات على <span class="text-teal">أسئلتك</span></h2>
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

<section class="cta-banner">
  <div class="container" data-reveal>
    <h2>جاهز للبدء؟ <span class="text-teal">استشارتك مجانية</span></h2>
    <p>تحدث مع فريقنا واحصل على تقييم مجاني لمشروعك</p>
    <div class="cta-banner-btns">
      <a href="/contact.php" class="btn btn-primary btn-lg">احجز استشارة مجانية</a>
      <a href="/portfolio.php" class="btn btn-ghost btn-lg">شاهد أعمالنا أولاً</a>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();

$faqSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array_map(static fn (array $f): array => [
        '@type' => 'Question',
        'name' => $f[0],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]],
    ], $faqs),
];

$breadcrumbSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'الرئيسية', 'item' => Seo::url('/')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'الخدمات', 'item' => Seo::url('/services.php')],
    ],
];

$extraHead = Seo::jsonLd($faqSchema) . Seo::jsonLd($breadcrumbSchema);

require __DIR__ . '/../templates/layout.php';

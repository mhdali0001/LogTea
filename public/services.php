<?php

require __DIR__ . '/../src/bootstrap.php';

use LogTea\PageSeo;
use LogTea\ServiceRegistry;
use LogTea\Support\Icons;
use LogTea\Support\TempCleanup;
use LogTea\ToolRegistry;

TempCleanup::run();

['title' => $pageTitle, 'description' => $pageDescription, 'keywords' => $metaKeywords, 'image' => $ogImage] = PageSeo::for('services');
$activePage = 'services';
$canonicalPath = '/services.php';
$breadcrumbs = [['الخدمات', '/services.php']];

$services = ServiceRegistry::all();
$toolCount = count(ToolRegistry::all());

$faqs = [
    ['هل تبرمجون مواقع لعملاء داخل سوريا؟', 'نعم، مقرنا الرئيسي في دمشق — المالكي، ونخدم العملاء في كل المدن السورية، إلى جانب عملائنا في تركيا والخليج العربي.'],
    ['كم تكلفة برمجة موقع في سوريا؟', 'تختلف التكلفة حسب نوع الموقع وحجمه — موقع تعريفي أو متجر إلكتروني أو نظام إدارة. نحدد السعر بعد استشارة مجانية نفهم فيها متطلباتك، ونقدم سعراً ثابتاً للمشاريع محددة المتطلبات أو سعراً بالساعة للمشاريع المرنة والمستمرة.'],
    ['كم يستغرق تصميم وبرمجة موقع احترافي؟', 'يعتمد الوقت على حجم المشروع. موقع تعريفي بسيط يستغرق من 2 إلى 3 أسابيع، بينما المتاجر والمنصات المعقدة قد تحتاج من 2 إلى 6 أشهر. نضع جدولاً زمنياً تفصيلياً في بداية كل مشروع ونلتزم به.'],
    ['هل تقدمون ضماناً بعد التسليم؟', 'نعم، نقدم ضمان صيانة لمدة 3 أشهر مجاناً بعد الإطلاق لإصلاح أي مشاكل قد تظهر، إلى جانب خطط دعم مستمر شهرية وسنوية.'],
    ['هل يمكنني إدارة محتوى موقعي بنفسي؟', 'بالتأكيد. نسلّمك لوحة تحكم سهلة لتعديل النصوص والصور والمنتجات، مع شرح عملي لطريقة استخدامها.'],
    ['هل أدوات الملفات المجانية جزء من خدماتكم المدفوعة؟', 'لا — أدوات الملفات متاحة مجاناً للجميع بدون تسجيل. وإن احتجت أداة أو نظاماً مخصصاً لشركتك يمكننا بناؤه لك كمشروع مستقل.'],
];

ob_start();
?>
<section class="page-banner">
  <div class="page-banner-grid"></div>
  <div class="container">
    <div class="breadcrumb"><a href="/">الرئيسية</a><span class="breadcrumb-sep">/</span><span>الخدمات</span></div>
    <h1>خدمات برمجة وتصميم <span class="text-teal">المواقع</span></h1>
    <p>من تصميم الواجهة إلى إطلاق الموقع ودعمه — نقدم لعملائنا في سوريا والمنطقة العربية كل ما يحتاجه حضورك الرقمي، ومعها أدوات ملفات مجانية للجميع</p>
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

// The layout publishes $faqs and $breadcrumbs as structured data.
$schema = [ServiceRegistry::schema()];

require __DIR__ . '/../templates/layout.php';

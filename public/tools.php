<?php

require __DIR__ . '/../src/bootstrap.php';

use LogTea\Support\Seo;
use LogTea\Support\TempCleanup;
use LogTea\ToolRegistry;

TempCleanup::run();

$pageTitle = 'أدوات ملفات مجانية | LogTea';
$pageDescription = 'ادمج، اضغط، حوّل وعدّل ملفات PDF والصور والمستندات مجاناً — خدمة مجانية من LogTea بدون تسجيل، معالجة سريعة وآمنة.';
$activePage = 'tools';
$canonicalPath = '/tools.php';

$tools = ToolRegistry::all();
$categories = ['all' => 'الكل', 'pdf' => 'أدوات PDF', 'image' => 'أدوات الصور', 'convert' => 'تحويل الملفات'];

$faqs = [
    ['هل الأدوات مجانية فعلاً؟', 'نعم، جميع الأدوات مجانية بالكامل وبدون أي اشتراكات أو حدود مخفية. نقدّمها كخدمة مجانية من LogTea إلى جانب خدماتنا في تصميم وتطوير المواقع.'],
    ['هل ملفاتي آمنة؟', 'نعم — لا نطلب تسجيل دخول، ولا نحتفظ بملفاتك؛ يتم حذفها تلقائياً من الخادم خلال ساعة من رفعها.'],
    ['لماذا بعض الأدوات موسومة بـ"نطاق محدود"؟', 'بعض العمليات (مثل تحويل PDF إلى صورة كاملة) تتطلب برامج خادم إضافية لا تعمل بها المنصة حالياً. الأداة نفسها تعمل ضمن الحدود الموضحة في صفحتها.'],
    ['هل يمكنكم بناء أداة مخصصة لشركتي؟', 'بالتأكيد. نطوّر أدوات وأنظمة داخلية مخصصة لسير عمل شركتك — تواصل معنا وأخبرنا بما تحتاجه.'],
];

ob_start();
?>
<section class="page-banner">
  <div class="page-banner-grid"></div>
  <div class="container">
    <div class="breadcrumb"><a href="/">الرئيسية</a><span class="breadcrumb-sep">/</span><span>الأدوات المجانية</span></div>
    <div class="hero-badge">✨ خدمة مجانية من LogTea — بدون تسجيل</div>
    <h1>كل أدوات <span class="text-teal">PDF والملفات</span> في مكان واحد</h1>
    <p>ادمج، اضغط، حوّل، واحمِ ملفاتك في ثوانٍ. معالجة سريعة، وملفاتك تُحذف تلقائياً من خوادمنا خلال ساعة.</p>
    <div class="hero-search banner-search">
      <span style="color:var(--text-muted);">🔍</span>
      <input type="text" id="toolSearch" placeholder="ابحث عن أداة… مثال: دمج، ضغط، Word" />
    </div>
    <div class="banner-stat-row">
      <div class="banner-stat"><strong><?= count($tools) ?></strong><span>أداة مجانية</span></div>
      <div class="banner-stat"><strong>100%</strong><span>بدون تسجيل</span></div>
      <div class="banner-stat"><strong>1h</strong><span>حذف تلقائي</span></div>
    </div>
  </div>
</section>

<section class="section" id="tools" style="padding-top:8px;">
  <div class="container">
    <div class="cat-tabs">
      <?php foreach ($categories as $key => $label): ?>
        <button type="button" class="cat-tab<?= $key === 'all' ? ' active' : '' ?>" data-cat="<?= $key ?>"><?= $label ?></button>
      <?php endforeach; ?>
    </div>
    <div class="tool-grid">
      <?php foreach ($tools as $slug => $tool): ?>
        <?php require __DIR__ . '/../templates/partials/tool-card.php'; ?>
      <?php endforeach; ?>
      <p class="tool-empty" style="display:none;">لا توجد أدوات مطابقة لبحثك.</p>
    </div>
  </div>
</section>

<section class="section section-dark">
  <div class="container">
    <div class="section-header">
      <div class="section-tag">كيف تعمل الأدوات</div>
      <h2 class="section-title">ثلاث خطوات <span class="text-teal">فقط</span></h2>
    </div>
    <div class="steps">
      <div class="step"><div class="step-num">1</div><h3>ارفع ملفك</h3><p>اسحب الملف أو اختره من جهازك — بدون تسجيل دخول.</p></div>
      <div class="step"><div class="step-num">2</div><h3>اختر الإعدادات</h3><p>حدد الخيارات المناسبة للأداة، إن وجدت.</p></div>
      <div class="step"><div class="step-num">3</div><h3>نزّل النتيجة</h3><p>يتم تجهيز ملفك خلال ثوانٍ وتنزيله مباشرة.</p></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-header">
      <div class="section-tag">أسئلة شائعة</div>
      <h2 class="section-title">كل ما تحتاج <span class="text-teal">معرفته</span></h2>
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
  <div class="container">
    <h2>تحتاج موقعاً أو نظاماً <span class="text-teal">مخصصاً لعملك؟</span></h2>
    <p>هذه الأدوات مثال صغير على ما نبنيه — دعنا نصمم لك حلاً رقمياً على مقاسك</p>
    <div class="cta-banner-btns">
      <a href="/contact.php" class="btn btn-primary btn-lg">ابدأ مشروعك</a>
      <a href="/services.php" class="btn btn-ghost btn-lg">استعرض خدماتنا</a>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();

$webAppSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'WebApplication',
    'name' => 'LogTea Tools',
    'url' => Seo::url('/tools.php'),
    'description' => $pageDescription,
    'applicationCategory' => 'UtilitiesApplication',
    'operatingSystem' => 'Any',
    'inLanguage' => 'ar',
    'isAccessibleForFree' => true,
    'provider' => ['@type' => 'Organization', 'name' => 'LogTea', 'url' => Seo::url('/')],
    'offers' => [
        '@type' => 'Offer',
        'price' => '0',
        'priceCurrency' => 'USD',
    ],
];

$toolListSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'ItemList',
    'itemListElement' => [],
];
$position = 1;
foreach ($tools as $slug => $tool) {
    $toolListSchema['itemListElement'][] = [
        '@type' => 'ListItem',
        'position' => $position++,
        'name' => $tool['name_ar'],
        'url' => Seo::url('/tools/' . $slug),
    ];
}

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
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'الأدوات المجانية', 'item' => Seo::url('/tools.php')],
    ],
];

$extraHead = Seo::jsonLd($webAppSchema) . Seo::jsonLd($toolListSchema) . Seo::jsonLd($faqSchema) . Seo::jsonLd($breadcrumbSchema);

require __DIR__ . '/../templates/layout.php';

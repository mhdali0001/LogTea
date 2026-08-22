<?php

require __DIR__ . '/../src/bootstrap.php';

use LogTea\Support\Icons;
use LogTea\Support\TempCleanup;
use LogTea\ToolRegistry;

TempCleanup::run();

$pageTitle = 'LogTea | أدوات مجانية لملفات PDF والصور والمستندات';
$pageDescription = 'ادمج، اضغط، حوّل وعدّل ملفات PDF والصور والمستندات مجاناً بالكامل — بدون تسجيل، معالجة سريعة وآمنة.';
$activePage = 'home';

$tools = ToolRegistry::all();
$categories = ['all' => 'الكل', 'pdf' => 'أدوات PDF', 'image' => 'أدوات الصور', 'convert' => 'تحويل الملفات'];

ob_start();
?>
<section class="hero">
  <div class="container hero-inner">
    <div class="hero-badge"><span>✨</span> مجاني بالكامل — بدون تسجيل</div>
    <h1 class="hero-title">كل أدوات <span class="text-teal">PDF والملفات</span><br/>في مكان واحد</h1>
    <p class="hero-desc">ادمج، اضغط، حوّل، واحمِ ملفاتك في ثوانٍ. معالجة سريعة، وملفاتك تُحذف تلقائياً من خوادمنا خلال ساعة.</p>
    <div class="hero-search">
      <span style="color:var(--text-muted);">🔍</span>
      <input type="text" id="toolSearch" placeholder="ابحث عن أداة… مثال: دمج، ضغط، Word" />
    </div>
    <div class="hero-trust">
      <span>🔒 معالجة آمنة</span>
      <span>🗑️ حذف تلقائي خلال ساعة</span>
      <span>💯 بدون اشتراكات</span>
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
        <a href="/tools/<?= htmlspecialchars($slug) ?>" class="tool-card" data-cat="<?= $tool['category'] ?>"
           data-name="<?= htmlspecialchars(mb_strtolower($tool['name_ar'])) ?>"
           data-desc="<?= htmlspecialchars(mb_strtolower($tool['desc_ar'])) ?>">
          <div class="tool-icon"><?= Icons::svg($tool['icon']) ?></div>
          <?php if (isset($tool['note_ar'])): ?><span class="tc-badge">نطاق محدود</span><?php endif; ?>
          <h3><?= htmlspecialchars($tool['name_ar']) ?></h3>
          <p><?= htmlspecialchars($tool['desc_ar']) ?></p>
        </a>
      <?php endforeach; ?>
      <p class="tool-empty" style="display:none;">لا توجد أدوات مطابقة لبحثك.</p>
    </div>
  </div>
</section>

<section class="section section-dark">
  <div class="container">
    <div class="section-header">
      <div class="section-tag">كيف تعمل المنصة</div>
      <h2 class="section-title">ثلاث خطوات <span class="text-teal">فقط</span></h2>
    </div>
    <div class="steps">
      <div class="step"><div class="step-num">1</div><h3>ارفع ملفك</h3><p>اسحب الملف أو اخترته من جهازك — بدون تسجيل دخول.</p></div>
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
      <div class="faq-item">
        <button class="faq-question">هل المنصة مجانية فعلاً؟</button>
        <div class="faq-answer"><div class="faq-answer-inner">نعم، جميع الأدوات مجانية بالكامل وبدون أي اشتراكات أو حدود مخفية. إن أعجبتك المنصة يمكنك دعمها اختيارياً من صفحة الدعم.</div></div>
      </div>
      <div class="faq-item">
        <button class="faq-question">هل ملفاتي آمنة؟</button>
        <div class="faq-answer"><div class="faq-answer-inner">نعم — لا نطلب تسجيل دخول، ولا نحتفظ بملفاتك؛ يتم حذفها تلقائياً من الخادم خلال ساعة من رفعها.</div></div>
      </div>
      <div class="faq-item">
        <button class="faq-question">لماذا بعض الأدوات موسومة بـ"نطاق محدود"؟</button>
        <div class="faq-answer"><div class="faq-answer-inner">بعض العمليات (مثل تحويل PDF إلى صورة كاملة، أو إزالة تشفير AES الحديث) تتطلب برامج خادم إضافية لا تعمل بها المنصة حالياً. الأداة نفسها تعمل ضمن الحدود الموضحة في صفحتها.</div></div>
      </div>
    </div>
  </div>
</section>

<section class="cta-banner">
  <div class="container">
    <h2>أعجبتك المنصة؟ <span class="text-teal">ادعم استمرارها</span></h2>
    <p>LogTea مشروع مجاني بالكامل يعمل بدعم من مستخدميه</p>
    <a href="/support.php" class="btn btn-primary btn-lg">ادعم المشروع 💛</a>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../templates/layout.php';

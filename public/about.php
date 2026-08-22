<?php

require __DIR__ . '/../src/bootstrap.php';

use LogTea\Support\Icons;
use LogTea\Support\TempCleanup;

TempCleanup::run();

$pageTitle = 'عن المنصة | LogTea';
$pageDescription = 'LogTea منصة أدوات مجانية لمعالجة ملفات PDF والصور والمستندات، بدون تسجيل وبخصوصية كاملة.';
$activePage = 'about';

ob_start();
?>
<section class="page-banner">
  <div class="container">
    <div class="breadcrumb"><a href="/">الرئيسية</a><span class="breadcrumb-sep">/</span><span>عن المنصة</span></div>
    <h1>أدوات بسيطة، <span class="text-teal">بلا تعقيد</span></h1>
    <p>LogTea منصة مجانية لمعالجة ملفات PDF والصور والمستندات — بُنيت لتكون سريعة، واضحة، ومحترمة لخصوصيتك.</p>
  </div>
</section>

<section class="section prose">
  <div class="container prose">
    <p>بدأت LogTea كمشروع برمجي بسيط: كل مرة نحتاج فيها لدمج ملفين PDF أو تحويل صورة، كنا نجد أنفسنا في مواقع مزدحمة بالإعلانات تطلب التسجيل مقابل عمليات بسيطة. قررنا بناء بديل مختلف — أدوات تعمل مباشرة، بدون حساب، وبدون رسوم.</p>
    <p>المنصة مبنية بالكامل بلغة PHP، وتعالج ملفاتك على الخادم لحظة رفعها ثم تحذفها تلقائياً — لا نحتفظ بنسخ، ولا نستخدم ملفاتك لأي غرض آخر.</p>
    <p>بعض الأدوات (مثل تحويل PDF الممسوح ضوئياً إلى صورة، أو إزالة تشفير AES الحديث) لا تزال محدودة النطاق تقنياً وموضّحة بوضوح على صفحة كل أداة — نفضّل أن نخبرك بالحدود الحقيقية بدل الادعاء بأن كل شيء يعمل بشكل مثالي.</p>

    <div class="value-grid">
      <div class="value-card">
        <div class="vc-icon"><?= Icons::svg('lock') ?></div>
        <h3>خصوصية أولاً</h3>
        <p>بدون تسجيل، وحذف تلقائي للملفات خلال ساعة من معالجتها.</p>
      </div>
      <div class="value-card">
        <div class="vc-icon"><?= Icons::svg('compress') ?></div>
        <h3>سرعة</h3>
        <p>معالجة مباشرة على الخادم دون انتظار طوابير أو إعلانات.</p>
      </div>
      <div class="value-card">
        <div class="vc-icon"><?= Icons::svg('unlock') ?></div>
        <h3>مجاني بصدق</h3>
        <p>لا اشتراكات مخفية — الدعم المالي اختياري بالكامل.</p>
      </div>
    </div>
  </div>
</section>

<section class="cta-banner">
  <div class="container">
    <h2>جرّب أدواتنا <span class="text-teal">الآن</span></h2>
    <p>16 أداة جاهزة لمساعدتك في ثوانٍ</p>
    <a href="/#tools" class="btn btn-primary btn-lg">تصفح الأدوات</a>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../templates/layout.php';

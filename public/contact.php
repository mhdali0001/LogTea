<?php

require __DIR__ . '/../src/bootstrap.php';

use LogTea\Support\Icons;
use LogTea\Support\TempCleanup;

TempCleanup::run();

$pageTitle = 'تواصل معنا | LogTea';
$pageDescription = 'لديك سؤال أو اقتراح حول أدوات LogTea؟ تواصل معنا مباشرة.';
$activePage = 'contact';

// TODO(owner): replace with your real support email/social links before launch.
$contactEmail = 'support@logtea.app';

ob_start();
?>
<section class="page-banner">
  <div class="container">
    <div class="breadcrumb"><a href="/">الرئيسية</a><span class="breadcrumb-sep">/</span><span>تواصل معنا</span></div>
    <h1>نسمعك <span class="text-teal">مباشرة</span></h1>
    <p>واجهت مشكلة في إحدى الأدوات؟ عندك اقتراح لأداة جديدة؟ راسلنا.</p>
  </div>
</section>

<section class="section" style="padding-top:0;">
  <div class="container">
    <div class="contact-grid">
      <div class="contact-card">
        <div class="contact-info-list">
          <div class="contact-info-item">
            <div class="cii-icon"><?= Icons::svg('unlock') ?></div>
            <div><strong>البريد الإلكتروني</strong><span><a href="mailto:<?= htmlspecialchars($contactEmail) ?>"><?= htmlspecialchars($contactEmail) ?></a></span></div>
          </div>
          <div class="contact-info-item">
            <div class="cii-icon"><?= Icons::svg('compress') ?></div>
            <div><strong>وقت الرد المتوقع</strong><span>خلال 24-48 ساعة عمل</span></div>
          </div>
          <div class="contact-info-item">
            <div class="cii-icon"><?= Icons::svg('lock') ?></div>
            <div><strong>الإبلاغ عن مشكلة أمنية</strong><span>راسلنا مباشرة ولن نشارك التفاصيل مع أي طرف ثالث</span></div>
          </div>
        </div>
      </div>
      <div class="contact-card">
        <h3 style="margin-bottom:16px;">أرسل رسالة عبر البريد</h3>
        <p style="color:var(--text-secondary);font-size:14px;margin-bottom:20px;">اضغط الزر أدناه لفتح برنامج البريد الخاص بك برسالة جاهزة موجّهة إلينا.</p>
        <a class="btn btn-primary btn-full" href="mailto:<?= htmlspecialchars($contactEmail) ?>?subject=<?= rawurlencode('استفسار من موقع LogTea') ?>">
          ✉️ راسلنا الآن
        </a>
      </div>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../templates/layout.php';

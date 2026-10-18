<?php

require __DIR__ . '/../src/bootstrap.php';

use LogTea\Support\TempCleanup;

TempCleanup::run();

$pageTitle = 'ادعم المشروع | LogTea';
$pageDescription = 'LogTea مجاني بالكامل ولا يعتمد على اشتراكات. إن أعجبك المشروع يمكنك دعمه اختيارياً.';
$activePage = 'support';
$canonicalPath = '/support.php';
// Left over from the free-tools-only site: no longer linked or in the sitemap, so keep it out of search results.
$robotsContent = 'noindex, follow';

// TODO(owner): replace these with your real donation links before launch.
$links = [
    ['label' => 'Buy Me a Coffee', 'icon' => '☕', 'url' => 'https://www.buymeacoffee.com/logtea', 'desc' => 'ادعم بمبلغ بسيط لمرة واحدة'],
    ['label' => 'PayPal', 'icon' => '💳', 'url' => 'https://paypal.me/logtea', 'desc' => 'تبرع مباشر عبر PayPal'],
];

ob_start();
?>
<section class="page-banner">
  <div class="container">
    <div class="breadcrumb"><a href="/">الرئيسية</a><span class="breadcrumb-sep">/</span><span>ادعم المشروع</span></div>
    <h1>LogTea مجاني، <span class="text-teal">ويبقى كذلك</span></h1>
    <p>لا اشتراكات ولا إعلانات مزعجة. إن وفّرت عليك المنصة وقتاً، يسعدنا دعمك الاختياري لتغطية تكاليف الخوادم.</p>
  </div>
</section>

<section class="section" style="padding-top:0;">
  <div class="container">
    <div class="support-methods">
      <?php foreach ($links as $link): ?>
        <div class="support-card">
          <div class="sc-icon"><?= $link['icon'] ?></div>
          <h3><?= htmlspecialchars($link['label']) ?></h3>
          <p><?= htmlspecialchars($link['desc']) ?></p>
          <a class="btn btn-primary" href="<?= htmlspecialchars($link['url']) ?>" target="_blank" rel="noopener">دعم عبر <?= htmlspecialchars($link['label']) ?></a>
        </div>
      <?php endforeach; ?>
    </div>
    <p style="text-align:center;color:var(--text-muted);font-size:13.5px;margin-top:32px;">الدعم اختياري بالكامل ولا يمنحك أي مزايا إضافية — كل الأدوات متاحة للجميع بنفس الشكل.</p>
  </div>
</section>
<?php
$content = ob_get_clean();

require __DIR__ . '/../templates/layout.php';

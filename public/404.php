<?php

require __DIR__ . '/../src/bootstrap.php';

// Served by Apache's ErrorDocument (see .htaccess) — keep the real 404 status so search engines drop the URL.
http_response_code(404);

$pageTitle = 'الصفحة غير موجودة | LogTea';
$pageDescription = 'الصفحة التي تبحث عنها غير موجودة أو تم نقلها.';
$robotsContent = 'noindex, follow';

ob_start();
?>
<section class="page-banner">
  <div class="page-banner-grid"></div>
  <div class="container">
    <span class="error-code" dir="ltr">404</span>
    <h1>الصفحة <span class="text-teal">غير موجودة</span></h1>
    <p>ربما تغيّر الرابط أو حُذفت الصفحة. يمكنك المتابعة من هنا:</p>
    <div class="page-banner-actions">
      <a href="/" class="btn btn-primary">الصفحة الرئيسية</a>
      <a href="/services.php" class="btn btn-ghost">خدماتنا</a>
      <a href="/tools.php" class="btn btn-ghost">الأدوات المجانية</a>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();

require __DIR__ . '/../templates/layout.php';

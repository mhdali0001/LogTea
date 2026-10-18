<?php

use LogTea\ServiceRegistry;
use LogTea\ToolRegistry;

$footerTools = array_intersect_key(
    ToolRegistry::all(),
    array_flip(['merge-pdf', 'compress-pdf', 'pdf-to-word', 'word-to-pdf', 'image-to-pdf'])
);
?>
<footer class="footer">
  <div class="footer-glow"></div>
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a href="/" class="logo" style="margin-bottom:16px;">
          <span class="logo-badge"><img src="/assets/img/logo.png" alt="LogTea" class="nav-logo-img" /></span>
        </a>
        <p>LogTea شركة برمجة وتصميم مواقع في سوريا، مقرها دمشق، تحوّل أفكارك إلى مواقع ومتاجر وأنظمة رقمية متقنة — ونقدّم إلى جانب ذلك أدوات ملفات مجانية للجميع.</p>
        <div class="footer-trust">
          <span>✓ استشارة أولى مجانية</span>
          <span>✓ دعم فني بعد الإطلاق</span>
          <span>✓ <?= count(ToolRegistry::all()) ?> أداة ملفات مجانية</span>
        </div>
      </div>
      <div class="footer-col">
        <h4>خدماتنا</h4>
        <ul>
          <?php foreach (ServiceRegistry::all() as $service): ?>
            <li><a href="<?= $service['url'] ?>"><?= htmlspecialchars($service['name_ar']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="footer-col">
        <h4>أدوات مجانية</h4>
        <ul>
          <?php foreach ($footerTools as $slug => $tool): ?>
            <li><a href="/tools/<?= htmlspecialchars($slug) ?>"><?= htmlspecialchars($tool['name_ar']) ?></a></li>
          <?php endforeach; ?>
          <li><a href="/tools.php" class="text-teal">كل الأدوات ←</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>الشركة</h4>
        <ul>
          <li><a href="/about.php">من نحن</a></li>
          <li><a href="/portfolio.php">أعمالنا</a></li>
          <li><a href="/services.php">الخدمات</a></li>
          <li><a href="/contact.php">تواصل معنا</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© <?= date('Y') ?> LogTea Software Solutions. جميع الحقوق محفوظة.</p>
    </div>
  </div>
</footer>

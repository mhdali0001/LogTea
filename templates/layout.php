<?php
/**
 * Wraps $content (already-rendered HTML string) in the site shell.
 * Expected variables: $pageTitle, $pageDescription, $activePage, $content.
 * Optional: $bodyClass, $extraHead (raw HTML appended to <head>).
 */
$pageTitle = $pageTitle ?? 'LogTea';
$pageDescription = $pageDescription ?? 'أدوات مجانية لمعالجة ملفات PDF والصور والمستندات.';
$activePage = $activePage ?? '';
$bodyClass = $bodyClass ?? '';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
  <meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8') ?>" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="/assets/css/app.css" />
  <?= $extraHead ?? '' ?>
</head>
<body class="<?= htmlspecialchars($bodyClass, ENT_QUOTES, 'UTF-8') ?>">
  <?php require __DIR__ . '/header.php'; ?>
  <?= $content ?>
  <?php require __DIR__ . '/footer.php'; ?>
  <a href="#" class="back-to-top" id="backToTop">↑</a>
  <script src="/assets/js/app.js"></script>
</body>
</html>

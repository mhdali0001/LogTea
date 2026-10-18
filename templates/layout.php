<?php

use LogTea\Support\Seo;

/**
 * Wraps $content (already-rendered HTML string) in the site shell.
 * Expected variables: $pageTitle, $pageDescription, $activePage, $content.
 * Optional: $bodyClass, $extraHead (raw HTML appended to <head>),
 *           $canonicalPath (site-root-relative, e.g. "/tools/merge-pdf"; defaults to the current request path),
 *           $ogImage (site-root-relative; defaults to the shared social-preview card), $ogImageAlt,
 *           $metaKeywords (comma-separated), $robotsContent (defaults to "index, follow").
 */
$pageTitle = $pageTitle ?? 'LogTea';
$pageDescription = $pageDescription ?? 'LogTea شركة تصميم وتطوير مواقع ومتاجر إلكترونية وأنظمة إدارة، وتقدّم أدوات ملفات مجانية.';
$activePage = $activePage ?? '';
$bodyClass = $bodyClass ?? '';
$canonicalPath = $canonicalPath ?? strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
$ogImage = $ogImage ?? '/assets/img/og-image.png';
$ogImageAlt = $ogImageAlt ?? $pageTitle;
$ogImageSize = @getimagesize(dirname(__DIR__) . '/public' . $ogImage) ?: null;
$metaKeywords = $metaKeywords ?? '';
$robotsContent = $robotsContent ?? 'index, follow';
$canonicalUrl = Seo::url($canonicalPath);

$organizationSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    'name' => 'LogTea',
    'alternateName' => 'LogTea Software Solutions',
    'slogan' => 'نكتب الشيفرة .. نصنع الحلول',
    'description' => 'شركة تصميم وتطوير مواقع ومتاجر إلكترونية وأنظمة إدارة.',
    'url' => Seo::url('/'),
    'logo' => Seo::url('/assets/img/logo.png'),
];
$websiteSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    'name' => 'LogTea',
    'url' => Seo::url('/'),
    'inLanguage' => 'ar',
];
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
  <meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8') ?>" />
  <?php if ($metaKeywords !== ''): ?>
  <meta name="keywords" content="<?= htmlspecialchars($metaKeywords, ENT_QUOTES, 'UTF-8') ?>" />
  <?php endif; ?>
  <meta name="robots" content="<?= htmlspecialchars($robotsContent, ENT_QUOTES, 'UTF-8') ?>" />
  <meta name="theme-color" content="#0B1620" />
  <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8') ?>" />
  <script>document.documentElement.classList.add('js');</script>

  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="LogTea" />
  <meta property="og:locale" content="ar_AR" />
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>" />
  <meta property="og:description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8') ?>" />
  <meta property="og:url" content="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8') ?>" />
  <meta property="og:image" content="<?= htmlspecialchars(Seo::url($ogImage), ENT_QUOTES, 'UTF-8') ?>" />
  <?php if ($ogImageSize): ?>
  <meta property="og:image:width" content="<?= (int) $ogImageSize[0] ?>" />
  <meta property="og:image:height" content="<?= (int) $ogImageSize[1] ?>" />
  <?php endif; ?>
  <meta property="og:image:alt" content="<?= htmlspecialchars($ogImageAlt, ENT_QUOTES, 'UTF-8') ?>" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>" />
  <meta name="twitter:description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8') ?>" />
  <meta name="twitter:image" content="<?= htmlspecialchars(Seo::url($ogImage), ENT_QUOTES, 'UTF-8') ?>" />
  <meta name="twitter:image:alt" content="<?= htmlspecialchars($ogImageAlt, ENT_QUOTES, 'UTF-8') ?>" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="/assets/css/app.css" />
  <?= Seo::jsonLd($organizationSchema) ?>
  <?= Seo::jsonLd($websiteSchema) ?>
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

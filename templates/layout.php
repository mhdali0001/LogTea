<?php

use LogTea\Company;
use LogTea\Support\Seo;

/**
 * Wraps $content (already-rendered HTML string) in the site shell.
 * Expected variables: $pageTitle, $pageDescription, $activePage, $content.
 * Optional: $bodyClass, $extraHead (raw HTML appended to <head>),
 *           $canonicalPath (site-root-relative, e.g. "/tools/merge-pdf"; defaults to the current request path),
 *           $ogImage (site-root-relative; defaults to the shared social-preview card), $ogImageAlt,
 *           $metaKeywords (comma-separated), $robotsContent (defaults to "index, follow"),
 *           and for the JSON-LD graph:
 *           $pageType (schema.org WebPage subtype, e.g. "AboutPage"; defaults to "WebPage"),
 *           $breadcrumbs (list of [name, path] after the home page),
 *           $faqs (list of [question, answer] shown on the page — makes it an FAQPage),
 *           $schema (list of extra page-specific nodes, without @context).
 */
$pageTitle = $pageTitle ?? 'LogTea';
$pageDescription = $pageDescription ?? 'LogTea شركة برمجة وتصميم مواقع ومتاجر إلكترونية وأنظمة إدارة في سوريا، وتقدّم أدوات ملفات مجانية.';
$activePage = $activePage ?? '';
$bodyClass = $bodyClass ?? '';
$canonicalPath = $canonicalPath ?? strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
$ogImage = $ogImage ?? '/assets/img/og-image.png';
$ogImageAlt = $ogImageAlt ?? $pageTitle;
$ogImageSize = @getimagesize(dirname(__DIR__) . '/public' . $ogImage) ?: null;
$metaKeywords = $metaKeywords ?? '';
$robotsContent = $robotsContent ?? 'index, follow';
$canonicalUrl = Seo::url($canonicalPath);
$breadcrumbs = $breadcrumbs ?? [];
$faqs = $faqs ?? [];

// One connected graph per page: organization → website → this page (+ breadcrumb, FAQ, page nodes).
$orgId = Seo::url('/#organization');
$websiteId = Seo::url('/#website');
$pageTypes = (array) ($pageType ?? 'WebPage');
if ($faqs !== []) {
    $pageTypes[] = 'FAQPage';
}
$webPage = [
    '@type' => count($pageTypes) === 1 ? $pageTypes[0] : $pageTypes,
    '@id' => $canonicalUrl . '#webpage',
    'url' => $canonicalUrl,
    'name' => $pageTitle,
    'description' => $pageDescription,
    'inLanguage' => 'ar',
    'isPartOf' => ['@id' => $websiteId],
    'about' => ['@id' => $orgId],
    'primaryImageOfPage' => ['@type' => 'ImageObject', 'url' => Seo::url($ogImage)],
];
if ($metaKeywords !== '') {
    $webPage['keywords'] = $metaKeywords;
}
$graph = [
    Company::schema(),
    ['@type' => 'WebSite', '@id' => $websiteId, 'url' => Seo::url('/'), 'name' => 'LogTea', 'inLanguage' => 'ar', 'publisher' => ['@id' => $orgId]],
];
if ($breadcrumbs !== []) {
    $trail = array_merge([['الرئيسية', '/']], $breadcrumbs);
    $webPage['breadcrumb'] = ['@id' => $canonicalUrl . '#breadcrumb'];
    $graph[] = [
        '@type' => 'BreadcrumbList',
        '@id' => $canonicalUrl . '#breadcrumb',
        'itemListElement' => array_map(static fn (int $i, array $crumb): array => [
            '@type' => 'ListItem',
            'position' => $i + 1,
            'name' => $crumb[0],
            'item' => Seo::url($crumb[1]),
        ], array_keys($trail), $trail),
    ];
}
if ($faqs !== []) {
    $webPage['mainEntity'] = array_map(static fn (array $faq): array => [
        '@type' => 'Question',
        'name' => $faq[0],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq[1]],
    ], $faqs);
}
$graph[] = $webPage;
array_push($graph, ...($schema ?? []));

$e = static fn (string $value): string => htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $e($pageTitle) ?></title>
  <meta name="description" content="<?= $e($pageDescription) ?>" />
  <?php if ($metaKeywords !== ''): ?>
  <meta name="keywords" content="<?= $e($metaKeywords) ?>" />
  <?php endif; ?>
  <meta name="robots" content="<?= $e($robotsContent) ?>" />
  <meta name="author" content="LogTea" />
  <meta name="application-name" content="LogTea" />
  <meta name="theme-color" content="#0B1620" />
  <link rel="canonical" href="<?= $e($canonicalUrl) ?>" />
  <link rel="icon" href="/favicon.ico" />
  <link rel="icon" type="image/png" sizes="192x192" href="/assets/img/icons/icon-192.png" />
  <link rel="apple-touch-icon" href="/assets/img/icons/apple-touch-icon.png" />
  <script>document.documentElement.classList.add('js');</script>

  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="LogTea" />
  <meta property="og:locale" content="ar_AR" />
  <meta property="og:title" content="<?= $e($pageTitle) ?>" />
  <meta property="og:description" content="<?= $e($pageDescription) ?>" />
  <meta property="og:url" content="<?= $e($canonicalUrl) ?>" />
  <meta property="og:image" content="<?= $e(Seo::url($ogImage)) ?>" />
  <?php if ($ogImageSize): ?>
  <meta property="og:image:width" content="<?= (int) $ogImageSize[0] ?>" />
  <meta property="og:image:height" content="<?= (int) $ogImageSize[1] ?>" />
  <?php endif; ?>
  <meta property="og:image:alt" content="<?= $e($ogImageAlt) ?>" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="<?= $e($pageTitle) ?>" />
  <meta name="twitter:description" content="<?= $e($pageDescription) ?>" />
  <meta name="twitter:image" content="<?= $e(Seo::url($ogImage)) ?>" />
  <meta name="twitter:image:alt" content="<?= $e($ogImageAlt) ?>" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="/assets/css/app.css" />
  <?= Seo::jsonLd(['@context' => 'https://schema.org', '@graph' => $graph]) ?>
  <?= $extraHead ?? '' ?>
</head>
<body class="<?= $e($bodyClass) ?>">
  <?php require __DIR__ . '/header.php'; ?>
  <?= $content ?>
  <?php require __DIR__ . '/footer.php'; ?>
  <a href="#" class="back-to-top" id="backToTop">↑</a>
  <script src="/assets/js/app.js"></script>
</body>
</html>

<?php

declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';

use LogTea\ProjectRegistry;
use LogTea\Support\Seo;
use LogTea\ToolRegistry;

header('Content-Type: application/xml; charset=UTF-8');

// `sources` are the files a page's content comes from — the newest one dates <lastmod>.
$src = LOGTEA_ROOT . '/src';
$entries = [
    ['path' => '/', 'priority' => '1.0', 'sources' => [__DIR__ . '/index.php', "{$src}/PageSeo.php", "{$src}/ServiceRegistry.php", "{$src}/ProjectRegistry.php"]],
    ['path' => '/services.php', 'priority' => '0.9', 'sources' => [__DIR__ . '/services.php', "{$src}/PageSeo.php", "{$src}/ServiceRegistry.php"]],
    ['path' => '/portfolio.php', 'priority' => '0.8', 'sources' => [__DIR__ . '/portfolio.php', "{$src}/PageSeo.php", "{$src}/ProjectRegistry.php"],
        'images' => array_values(array_filter(array_column(ProjectRegistry::all(), 'image')))],
    ['path' => '/tools.php', 'priority' => '0.9', 'sources' => [__DIR__ . '/tools.php', "{$src}/PageSeo.php", "{$src}/ToolRegistry.php"]],
    ['path' => '/about.php', 'priority' => '0.6', 'sources' => [__DIR__ . '/about.php', "{$src}/PageSeo.php"],
        'images' => ['/assets/img/brand-identity.jpg']],
    ['path' => '/contact.php', 'priority' => '0.7', 'sources' => [__DIR__ . '/contact.php', "{$src}/PageSeo.php", "{$src}/Company.php"]],
];
foreach (array_keys(ToolRegistry::all()) as $slug) {
    $entries[] = ['path' => '/tools/' . $slug, 'priority' => '0.8', 'sources' => [__DIR__ . '/tool.php', "{$src}/ToolSeo.php", "{$src}/ToolRegistry.php"]];
}

$xml = static fn (string $value): string => htmlspecialchars($value, ENT_QUOTES | ENT_XML1, 'UTF-8');

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
<?php foreach ($entries as $entry): ?>
  <url>
    <loc><?= $xml(Seo::url($entry['path'])) ?></loc>
    <lastmod><?= date('Y-m-d', max(array_map('filemtime', $entry['sources']))) ?></lastmod>
    <priority><?= $entry['priority'] ?></priority>
<?php foreach ($entry['images'] ?? [] as $image): ?>
    <image:image><image:loc><?= $xml(Seo::url($image)) ?></image:loc></image:image>
<?php endforeach; ?>
  </url>
<?php endforeach; ?>
</urlset>

<?php

declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';

use LogTea\Support\Seo;
use LogTea\ToolRegistry;

header('Content-Type: application/xml; charset=UTF-8');

$staticPages = [
    ['path' => '/', 'priority' => '1.0'],
    ['path' => '/about.php', 'priority' => '0.6'],
    ['path' => '/contact.php', 'priority' => '0.5'],
    ['path' => '/support.php', 'priority' => '0.4'],
];

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($staticPages as $page): ?>
  <url>
    <loc><?= htmlspecialchars(Seo::url($page['path']), ENT_QUOTES | ENT_XML1, 'UTF-8') ?></loc>
    <priority><?= $page['priority'] ?></priority>
  </url>
<?php endforeach; ?>
<?php foreach (array_keys(ToolRegistry::all()) as $slug): ?>
  <url>
    <loc><?= htmlspecialchars(Seo::url('/tools/' . $slug), ENT_QUOTES | ENT_XML1, 'UTF-8') ?></loc>
    <priority>0.8</priority>
  </url>
<?php endforeach; ?>
</urlset>

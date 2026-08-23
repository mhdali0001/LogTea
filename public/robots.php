<?php

declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';

use LogTea\Support\Seo;

header('Content-Type: text/plain; charset=UTF-8');
?>
User-agent: *
Allow: /
Disallow: /api/
Disallow: /download.php

Sitemap: <?= Seo::url('/sitemap.xml') ?>

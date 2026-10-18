<?php

declare(strict_types=1);

/**
 * Builds the 1200×630 social-preview card (Open Graph / Twitter) for every
 * tool into public/assets/img/og/tools/{slug}.jpg — tool.php picks it up
 * automatically and falls back to the site-wide card when it is missing.
 *
 * Rendering goes through headless Chrome because GD cannot shape Arabic text.
 * Run it again whenever a tool is added or renamed:
 *
 *   php scripts/og-images.php ["C:\path\to\chrome.exe"]
 *
 * The browser path can also come from the CHROME_BIN environment variable.
 */

require __DIR__ . '/../src/bootstrap.php';

use LogTea\Support\Icons;
use LogTea\ToolRegistry;

$chrome = $argv[1] ?? (getenv('CHROME_BIN') ?: null);
if ($chrome === null) {
    foreach ([
        'C:\Program Files\Google\Chrome\Application\chrome.exe',
        'C:\Program Files (x86)\Google\Chrome\Application\chrome.exe',
        'C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe',
        '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome',
        '/usr/bin/google-chrome',
        '/usr/bin/chromium',
        '/usr/bin/chromium-browser',
    ] as $candidate) {
        if (is_file($candidate)) {
            $chrome = $candidate;
            break;
        }
    }
}
if ($chrome === null || !is_file($chrome)) {
    fwrite(STDERR, "Chrome/Chromium not found. Pass its path as the first argument or set CHROME_BIN.\n");
    exit(1);
}

$outDir = LOGTEA_ROOT . '/public/assets/img/og/tools';
$workDir = sys_get_temp_dir() . '/logtea-og';
foreach ([$outDir, $workDir] as $dir) {
    if (!is_dir($dir) && !mkdir($dir, 0775, true)) {
        fwrite(STDERR, "Cannot create {$dir}\n");
        exit(1);
    }
}

$logo = trimmedLogoDataUri(LOGTEA_ROOT . '/public/assets/img/logo.png');

$failed = 0;
foreach (ToolRegistry::all() as $slug => $tool) {
    $htmlPath = $workDir . '/' . $slug . '.html';
    $pngPath = $workDir . '/' . $slug . '.png';
    file_put_contents($htmlPath, cardHtml($tool, $logo));
    @unlink($pngPath);

    $command = implode(' ', [
        escapeshellarg($chrome),
        '--headless=new',
        '--disable-gpu',
        '--hide-scrollbars',
        '--user-data-dir=' . escapeshellarg($workDir . '/profile'),
        '--window-size=1200,630',
        // Gives the web fonts time to load before the capture.
        '--virtual-time-budget=4000',
        '--screenshot=' . escapeshellarg($pngPath),
        escapeshellarg('file:///' . ltrim(str_replace('\\', '/', $htmlPath), '/')),
    ]);
    exec($command . ' 2>&1');

    $image = is_file($pngPath) ? @imagecreatefrompng($pngPath) : false;
    if ($image === false) {
        echo "FAIL  {$slug}\n";
        $failed++;
        continue;
    }
    imagejpeg($image, $outDir . '/' . $slug . '.jpg', 86);
    echo "OK    {$slug}\n";
}

exit($failed > 0 ? 1 : 0);

/** The logo PNG has wide transparent margins; trim them so it aligns with the text. */
function trimmedLogoDataUri(string $path): string
{
    $image = imagecreatefrompng($path);
    imagesavealpha($image, true);
    $cropped = imagecropauto($image, IMG_CROP_TRANSPARENT);
    if ($cropped !== false) {
        imagesavealpha($cropped, true);
        $image = $cropped;
    }
    ob_start();
    imagepng($image);

    return 'data:image/png;base64,' . base64_encode((string) ob_get_clean());
}

/** @param array<string,mixed> $tool */
function cardHtml(array $tool, string $logo): string
{
    $name = htmlspecialchars($tool['name_ar'], ENT_QUOTES, 'UTF-8');
    $nameEn = htmlspecialchars($tool['name_en'], ENT_QUOTES, 'UTF-8');
    $icon = Icons::svg($tool['icon']);

    return <<<HTML
<!doctype html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@700;900&family=Poppins:wght@600&display=block" rel="stylesheet">
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  html, body { width: 1200px; height: 630px; overflow: hidden; }
  body { position: relative; font-family: 'Cairo', sans-serif; background: #0B1620; color: #E7EEF3; }
  .grid {
    position: absolute; inset: 0;
    background-image: linear-gradient(rgba(0,194,184,.08) 1px, transparent 1px), linear-gradient(90deg, rgba(0,194,184,.08) 1px, transparent 1px);
    background-size: 48px 48px;
    -webkit-mask-image: radial-gradient(ellipse 75% 85% at 25% 50%, #000 25%, transparent 100%);
  }
  .glow { position: absolute; left: -140px; top: -40px; width: 720px; height: 720px; background: radial-gradient(closest-side, rgba(0,194,184,.3), transparent 72%); }
  .bar { position: absolute; left: 0; right: 0; bottom: 0; height: 8px; background: linear-gradient(90deg, #3DB7E9, #00C2B8); }
  .wrap { position: relative; display: flex; align-items: center; gap: 70px; height: 100%; padding: 0 84px; }
  .text { flex: 1; min-width: 0; }
  .logo { display: block; height: 54px; margin-bottom: 34px; }
  h1 { font-size: 68px; font-weight: 900; line-height: 1.25; color: #fff; }
  .en { margin-top: 10px; font-family: 'Poppins', sans-serif; font-size: 32px; font-weight: 600; color: #00C2B8; direction: ltr; text-align: right; }
  .tags { display: flex; gap: 12px; margin-top: 36px; }
  .tags span {
    padding: 8px 20px; border-radius: 12px; font-size: 22px; font-weight: 700; color: #B5C6D3;
    background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.12);
  }
  .icon {
    flex-shrink: 0; width: 290px; height: 290px; border-radius: 70px;
    display: flex; align-items: center; justify-content: center;
    color: #04211F; background: linear-gradient(135deg, #00C2B8, #3DB7E9); box-shadow: 0 30px 90px rgba(0,194,184,.35);
  }
  .icon svg { width: 150px; height: 150px; }
</style>
</head>
<body>
  <div class="grid"></div>
  <div class="glow"></div>
  <div class="wrap">
    <div class="text">
      <img class="logo" src="{$logo}" alt="">
      <h1>{$name}</h1>
      <div class="en">{$nameEn}</div>
      <div class="tags"><span>مجاناً</span><span>بدون تسجيل</span><span>حذف تلقائي للملفات</span></div>
    </div>
    <div class="icon">{$icon}</div>
  </div>
  <div class="bar"></div>
</body>
</html>
HTML;
}

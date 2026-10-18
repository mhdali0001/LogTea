<?php

declare(strict_types=1);

/**
 * Builds the site icons from the mark at the left of public/assets/img/logo.png:
 * public/favicon.ico (16/32/48), assets/img/icons/icon-192.png and
 * assets/img/icons/apple-touch-icon.png (180). Pure GD — run it again if the
 * logo changes:
 *
 *   php scripts/favicon.php
 */

require __DIR__ . '/../src/bootstrap.php';

$mark = cropMark(imagecreatefrompng(LOGTEA_ROOT . '/public/assets/img/logo.png'));

$iconDir = LOGTEA_ROOT . '/public/assets/img/icons';
if (!is_dir($iconDir) && !mkdir($iconDir, 0775, true)) {
    fwrite(STDERR, "Cannot create {$iconDir}\n");
    exit(1);
}

imagepng(renderIcon($mark, 192), $iconDir . '/icon-192.png');
imagepng(renderIcon($mark, 180), $iconDir . '/apple-touch-icon.png');

$pngs = [];
foreach ([16, 32, 48] as $size) {
    ob_start();
    imagepng(renderIcon($mark, $size));
    $pngs[$size] = (string) ob_get_clean();
}
file_put_contents(LOGTEA_ROOT . '/public/favicon.ico', icoFile($pngs));

echo "OK    favicon.ico, icon-192.png, apple-touch-icon.png\n";

/** The mark is the first group of opaque columns, separated from the wordmark by a transparent gap. */
function cropMark(GdImage $logo): GdImage
{
    $width = imagesx($logo);
    $height = imagesy($logo);
    $opaque = static fn (int $x, int $y): bool => ((imagecolorat($logo, $x, $y) >> 24) & 0x7F) < 100;

    $start = $end = null;
    $gap = 0;
    for ($x = 0; $x < $width; $x++) {
        $hit = false;
        for ($y = 0; $y < $height && !$hit; $y++) {
            $hit = $opaque($x, $y);
        }
        if ($hit) {
            $start ??= $x;
            $end = $x;
            $gap = 0;
        } elseif ($start !== null && ++$gap >= 12) {
            break;
        }
    }

    $top = $height;
    $bottom = 0;
    for ($x = $start; $x <= $end; $x++) {
        for ($y = 0; $y < $height; $y++) {
            if ($opaque($x, $y)) {
                $top = min($top, $y);
                $bottom = max($bottom, $y);
            }
        }
    }

    $mark = imagecreatetruecolor($end - $start + 1, $bottom - $top + 1);
    imagealphablending($mark, false);
    imagesavealpha($mark, true);
    imagecopy($mark, $logo, 0, 0, $start, $top, $end - $start + 1, $bottom - $top + 1);

    return $mark;
}

/** Brand-navy square with the mark centred at 70% of its size. */
function renderIcon(GdImage $mark, int $size): GdImage
{
    $icon = imagecreatetruecolor($size, $size);
    imagefill($icon, 0, 0, imagecolorallocate($icon, 11, 22, 32));
    imagealphablending($icon, true);

    $markW = imagesx($mark);
    $markH = imagesy($mark);
    $scale = min($size * 0.7 / $markW, $size * 0.7 / $markH);
    $drawW = (int) round($markW * $scale);
    $drawH = (int) round($markH * $scale);
    imagecopyresampled($icon, $mark, intdiv($size - $drawW, 2), intdiv($size - $drawH, 2), 0, 0, $drawW, $drawH, $markW, $markH);

    return $icon;
}

/**
 * ICO container holding PNG images, which every current browser accepts.
 *
 * @param array<int,string> $pngs size => PNG bytes
 */
function icoFile(array $pngs): string
{
    $directory = '';
    $images = '';
    $offset = 6 + 16 * count($pngs);
    foreach ($pngs as $size => $png) {
        $directory .= pack('CCCCvvVV', $size, $size, 0, 0, 1, 32, strlen($png), $offset);
        $images .= $png;
        $offset += strlen($png);
    }

    return pack('vvv', 0, 1, count($pngs)) . $directory . $images;
}

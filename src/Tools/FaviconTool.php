<?php

declare(strict_types=1);

namespace LogTea\Tools;

use GdImage;
use LogTea\Support\Uploads;
use LogTea\Tools\Concerns\ProcessesImages;
use RuntimeException;
use ZipArchive;

/**
 * Builds a complete favicon set from one image: a multi-size favicon.ico
 * (PNG-compressed entries, supported by every current browser), the PNG
 * sizes browsers and phones ask for, a web manifest and the <link> tags.
 */
final class FaviconTool implements ToolInterface
{
    use ProcessesImages;

    public function run(array $files, array $options): array
    {
        $file = $files[0] ?? null;
        if ($file === null) {
            throw new RuntimeException('لم يتم رفع أي صورة.');
        }

        [$image] = $this->loadImage($file);
        $square = $this->toSquare($image, ($options['fit'] ?? 'contain') === 'cover');

        $zipPath = Uploads::newOutputPath('zip');
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new RuntimeException('تعذر إنشاء ملف ZIP.');
        }

        $zip->addFromString('favicon.ico', $this->ico([
            16 => $this->png($this->scaled($square, 16)),
            32 => $this->png($this->scaled($square, 32)),
            48 => $this->png($this->scaled($square, 48)),
        ]));
        $zip->addFromString('favicon-16x16.png', $this->png($this->scaled($square, 16)));
        $zip->addFromString('favicon-32x32.png', $this->png($this->scaled($square, 32)));
        // iOS renders transparent touch icons on black, so this one gets a white background.
        $zip->addFromString('apple-touch-icon.png', $this->png($this->flattenOnWhite($this->scaled($square, 180))));
        $zip->addFromString('android-chrome-192x192.png', $this->png($this->scaled($square, 192)));
        $zip->addFromString('android-chrome-512x512.png', $this->png($this->scaled($square, 512)));
        $zip->addFromString('site.webmanifest', (string) json_encode([
            'name' => '',
            'short_name' => '',
            'icons' => [
                ['src' => '/android-chrome-192x192.png', 'sizes' => '192x192', 'type' => 'image/png'],
                ['src' => '/android-chrome-512x512.png', 'sizes' => '512x512', 'type' => 'image/png'],
            ],
            'theme_color' => '#ffffff',
            'background_color' => '#ffffff',
            'display' => 'standalone',
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $zip->addFromString('README.txt', implode("\r\n", [
            'ارفع كل الملفات إلى المجلد الرئيسي لموقعك، ثم أضف هذه الأسطر داخل وسم <head> في صفحاتك:',
            'Upload every file to your site root, then add these lines inside the <head> of your pages:',
            '',
            '<link rel="icon" href="/favicon.ico" sizes="any">',
            '<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">',
            '<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">',
            '<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">',
            '<link rel="manifest" href="/site.webmanifest">',
            '',
        ]));
        $zip->close();

        return ['path' => $zipPath, 'filename' => 'favicon.zip', 'mime' => 'application/zip'];
    }

    /** Fits the whole image on a transparent square, or crops its center ($cover). */
    private function toSquare(GdImage $image, bool $cover): GdImage
    {
        $w = imagesx($image);
        $h = imagesy($image);
        $side = $cover ? min($w, $h) : max($w, $h);

        $square = $this->newCanvas($side, $side);
        if ($cover) {
            imagecopy($square, $image, 0, 0, intdiv($w - $side, 2), intdiv($h - $side, 2), $side, $side);
        } else {
            imagecopy($square, $image, intdiv($side - $w, 2), intdiv($side - $h, 2), 0, 0, $w, $h);
        }

        return $square;
    }

    private function scaled(GdImage $square, int $size): GdImage
    {
        $canvas = $this->newCanvas($size, $size);
        imagecopyresampled($canvas, $square, 0, 0, 0, 0, $size, $size, imagesx($square), imagesy($square));

        return $canvas;
    }

    private function png(GdImage $image): string
    {
        imagesavealpha($image, true);
        ob_start();
        imagepng($image, null, 9);

        return (string) ob_get_clean();
    }

    /** @param array<int,string> $pngs PNG bytes keyed by pixel size */
    private function ico(array $pngs): string
    {
        $directory = pack('vvv', 0, 1, count($pngs));
        $data = '';
        $offset = 6 + 16 * count($pngs);
        foreach ($pngs as $size => $png) {
            // width, height, palette size, reserved, color planes, bits per pixel, byte size, offset
            $directory .= pack('CCCCvvVV', $size, $size, 0, 0, 1, 32, strlen($png), $offset + strlen($data));
            $data .= $png;
        }

        return $directory . $data;
    }
}

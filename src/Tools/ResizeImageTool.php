<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Tools\Concerns\ProcessesImages;
use RuntimeException;

/**
 * Scales by a percentage, or to a width and/or height in pixels. With both
 * dimensions the image fits inside that box: the aspect ratio is always kept.
 */
final class ResizeImageTool implements ToolInterface
{
    use ProcessesImages;

    private const MAX_SIDE = 10000;

    public function run(array $files, array $options): array
    {
        $bySize = ($options['mode'] ?? 'percent') === 'size';
        $percent = max(1, min(500, (int) ($options['percent'] ?? 50)));
        $width = max(0, (int) ($options['width'] ?? 0));
        $height = max(0, (int) ($options['height'] ?? 0));

        if ($bySize && $width === 0 && $height === 0) {
            throw new RuntimeException('اكتب العرض أو الارتفاع المطلوب بالبكسل.');
        }

        return $this->eachImage($files, 'resized-images.zip', function (string $file) use ($bySize, $percent, $width, $height): array {
            [$image, $format] = $this->loadImage($file);
            $srcW = imagesx($image);
            $srcH = imagesy($image);

            if ($bySize) {
                $scales = array_filter([$width > 0 ? $width / $srcW : null, $height > 0 ? $height / $srcH : null]);
                $scale = min($scales);
            } else {
                $scale = $percent / 100;
            }

            $newW = max(1, (int) round($srcW * $scale));
            $newH = max(1, (int) round($srcH * $scale));
            if ($newW > self::MAX_SIDE || $newH > self::MAX_SIDE) {
                throw new RuntimeException('الأبعاد المطلوبة كبيرة جداً (الحد الأقصى ' . self::MAX_SIDE . ' بكسل لكل جهة).');
            }

            $canvas = $this->newCanvas($newW, $newH);
            imagecopyresampled($canvas, $image, 0, 0, 0, 0, $newW, $newH, $srcW, $srcH);

            return $this->saveImage($canvas, $this->sameFormat($format), "resized-{$newW}x{$newH}");
        });
    }
}

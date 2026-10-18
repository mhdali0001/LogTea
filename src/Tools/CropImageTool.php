<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Tools\Concerns\ProcessesImages;

/** Cuts the largest centered area with the chosen aspect ratio. */
final class CropImageTool implements ToolInterface
{
    use ProcessesImages;

    private const RATIOS = ['1:1', '4:5', '3:4', '2:3', '9:16', '4:3', '3:2', '16:9'];

    public function run(array $files, array $options): array
    {
        $ratioKey = in_array($options['ratio'] ?? '', self::RATIOS, true) ? $options['ratio'] : '1:1';
        [$rw, $rh] = array_map('intval', explode(':', $ratioKey));
        $ratio = $rw / $rh;

        return $this->eachImage($files, 'cropped-images.zip', function (string $file) use ($ratio, $rw, $rh): array {
            [$image, $format] = $this->loadImage($file);
            $srcW = imagesx($image);
            $srcH = imagesy($image);

            if ($srcW / $srcH > $ratio) {
                $cropH = $srcH;
                $cropW = max(1, (int) round($srcH * $ratio));
            } else {
                $cropW = $srcW;
                $cropH = max(1, (int) round($srcW / $ratio));
            }

            $canvas = $this->newCanvas($cropW, $cropH);
            imagecopy($canvas, $image, 0, 0, intdiv($srcW - $cropW, 2), intdiv($srcH - $cropH, 2), $cropW, $cropH);

            return $this->saveImage($canvas, $this->sameFormat($format), "cropped-{$rw}x{$rh}");
        });
    }
}

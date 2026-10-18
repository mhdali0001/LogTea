<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Tools\Concerns\ProcessesImages;
use RuntimeException;

final class RotateImageTool implements ToolInterface
{
    use ProcessesImages;

    public function run(array $files, array $options): array
    {
        $action = $options['action'] ?? 'right';

        return $this->eachImage($files, 'rotated-images.zip', function (string $file) use ($action): array {
            [$image, $format] = $this->loadImage($file);

            if ($action === 'flip-h' || $action === 'flip-v') {
                imageflip($image, $action === 'flip-h' ? IMG_FLIP_HORIZONTAL : IMG_FLIP_VERTICAL);
            } else {
                // imagerotate() turns counter-clockwise.
                $angle = ['left' => 90, '180' => 180][$action] ?? -90;
                $rotated = imagerotate($image, $angle, imagecolorallocatealpha($image, 0, 0, 0, 127));
                if ($rotated === false) {
                    throw new RuntimeException('تعذر تدوير الصورة.');
                }
                imagesavealpha($rotated, true);
                $image = $rotated;
            }

            return $this->saveImage($image, $this->sameFormat($format), 'rotated');
        });
    }
}

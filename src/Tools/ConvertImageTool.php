<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Tools\Concerns\ProcessesImages;

final class ConvertImageTool implements ToolInterface
{
    use ProcessesImages;

    public function run(array $files, array $options): array
    {
        $format = in_array($options['format'] ?? '', ['jpg', 'png', 'webp'], true) ? $options['format'] : 'jpg';

        return $this->eachImage($files, 'converted-images.zip', function (string $file) use ($format): array {
            [$image] = $this->loadImage($file);

            return $this->saveImage($image, $format, 'converted', 92);
        });
    }
}

<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Support\Uploads;
use RuntimeException;
use ZipArchive;

final class CompressImageTool implements ToolInterface
{
    public function run(array $files, array $options): array
    {
        if ($files === []) {
            throw new RuntimeException('لم يتم رفع أي صورة.');
        }

        $quality = max(10, min(95, (int) ($options['quality'] ?? 75)));

        if (count($files) === 1) {
            return $this->compressOne($files[0], $quality);
        }

        $zipPath = Uploads::newOutputPath('zip');
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new RuntimeException('تعذر إنشاء ملف ZIP.');
        }

        $tmpOutputs = [];
        foreach ($files as $i => $file) {
            $result = $this->compressOne($file, $quality);
            $tmpOutputs[] = $result['path'];
            $zip->addFile($result['path'], sprintf('compressed-%02d-%s', $i + 1, $result['filename']));
        }
        $zip->close();

        foreach ($tmpOutputs as $path) {
            @unlink($path);
        }

        return ['path' => $zipPath, 'filename' => 'compressed-images.zip', 'mime' => 'application/zip'];
    }

    private function compressOne(string $file, int $quality): array
    {
        $info = @getimagesize($file);
        if ($info === false) {
            throw new RuntimeException('الملف ليس صورة صالحة.');
        }

        $image = match ($info['mime']) {
            'image/jpeg' => imagecreatefromjpeg($file),
            'image/png'  => imagecreatefrompng($file),
            'image/webp' => function_exists('imagecreatefromwebp') ? imagecreatefromwebp($file) : false,
            default      => false,
        };

        if ($image === false) {
            throw new RuntimeException('صيغة الصورة غير مدعومة.');
        }

        [$ext, $mime, $saved] = match ($info['mime']) {
            'image/png' => ['png', 'image/png', fn (string $path) => imagepng($image, $path, (int) round((100 - $quality) * 9 / 100))],
            'image/webp' => function_exists('imagewebp')
                ? ['webp', 'image/webp', fn (string $path) => imagewebp($image, $path, $quality)]
                : ['jpg', 'image/jpeg', fn (string $path) => imagejpeg($image, $path, $quality)],
            default => ['jpg', 'image/jpeg', fn (string $path) => imagejpeg($image, $path, $quality)],
        };

        $outPath = Uploads::newOutputPath($ext);
        $saved($outPath);

        return ['path' => $outPath, 'filename' => 'compressed.' . $ext, 'mime' => $mime];
    }
}

<?php

declare(strict_types=1);

namespace LogTea\Tools\Concerns;

use GdImage;
use LogTea\Support\Uploads;
use RuntimeException;
use ZipArchive;

/**
 * Shared GD plumbing for the image tools: loading any supported upload (with
 * the camera's EXIF rotation applied, which GD otherwise ignores), saving in
 * a given format while keeping transparency where the format allows, and
 * returning one result directly or several bundled in a ZIP.
 */
trait ProcessesImages
{
    /**
     * Runs $transform over every uploaded image; one result is returned as is,
     * several are bundled into a ZIP called $zipName.
     *
     * @param string[] $files
     * @param callable(string):array{path:string,filename:string,mime:string} $transform
     * @return array{path:string,filename:string,mime:string}
     */
    private function eachImage(array $files, string $zipName, callable $transform): array
    {
        if ($files === []) {
            throw new RuntimeException('لم يتم رفع أي صورة.');
        }
        if (count($files) === 1) {
            return $transform($files[0]);
        }

        $zipPath = Uploads::newOutputPath('zip');
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new RuntimeException('تعذر إنشاء ملف ZIP.');
        }

        $outputs = [];
        foreach ($files as $i => $file) {
            $result = $transform($file);
            $outputs[] = $result['path'];
            $zip->addFile($result['path'], sprintf('%02d-%s', $i + 1, $result['filename']));
        }
        $zip->close();

        foreach ($outputs as $path) {
            @unlink($path);
        }

        return ['path' => $zipPath, 'filename' => $zipName, 'mime' => 'application/zip'];
    }

    /** @return array{0:GdImage,1:string} the truecolor image and its source format: jpg, png, webp, gif or bmp */
    private function loadImage(string $file): array
    {
        $info = @getimagesize($file);
        $format = $info === false ? null : ([
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif',
            'image/bmp' => 'bmp',
            'image/x-ms-bmp' => 'bmp',
        ][$info['mime']] ?? null);

        if ($format === null) {
            throw new RuntimeException('الملف ليس صورة صالحة أو أن صيغته غير مدعومة.');
        }
        // GD needs ~4 bytes per pixel in memory; refuse what would exhaust the server.
        if ($info[0] * $info[1] > 40_000_000) {
            throw new RuntimeException('أبعاد الصورة كبيرة جداً (الحد الأقصى 40 ميغابكسل).');
        }

        $image = match ($format) {
            'jpg' => @imagecreatefromjpeg($file),
            'png' => @imagecreatefrompng($file),
            'webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($file) : false,
            'gif' => @imagecreatefromgif($file),
            'bmp' => function_exists('imagecreatefrombmp') ? @imagecreatefrombmp($file) : false,
        };
        if ($image === false) {
            throw new RuntimeException('تعذرت قراءة الصورة — قد يكون الملف تالفاً.');
        }

        // Palette images (GIF, 8-bit PNG) can't hold alpha or be resampled cleanly.
        if (!imageistruecolor($image)) {
            imagepalettetotruecolor($image);
        }
        imagesavealpha($image, true);

        if ($format === 'jpg' && function_exists('exif_read_data')) {
            $exif = @exif_read_data($file);
            $image = $this->applyExifOrientation($image, (int) (is_array($exif) ? ($exif['Orientation'] ?? 1) : 1));
        }

        return [$image, $format];
    }

    /** Turns the stored pixels upright, the way photo viewers display them. */
    private function applyExifOrientation(GdImage $image, int $orientation): GdImage
    {
        $rotated = match ($orientation) {
            3 => imagerotate($image, 180, 0),
            5, 6 => imagerotate($image, -90, 0),
            7, 8 => imagerotate($image, 90, 0),
            default => $image,
        };
        if ($rotated === false) {
            return $image;
        }
        if (in_array($orientation, [2, 5, 7], true)) {
            imageflip($rotated, IMG_FLIP_HORIZONTAL);
        } elseif ($orientation === 4) {
            imageflip($rotated, IMG_FLIP_VERTICAL);
        }

        return $rotated;
    }

    /** A fully transparent truecolor canvas that copies alpha through instead of blending it. */
    private function newCanvas(int $width, int $height): GdImage
    {
        $canvas = imagecreatetruecolor(max(1, $width), max(1, $height));
        imagealphablending($canvas, false);
        imagefill($canvas, 0, 0, imagecolorallocatealpha($canvas, 0, 0, 0, 127));
        imagesavealpha($canvas, true);

        return $canvas;
    }

    /** Lossy formats are kept; GIF and BMP sources are saved as PNG so nothing is lost. */
    private function sameFormat(string $sourceFormat): string
    {
        return in_array($sourceFormat, ['jpg', 'png', 'webp'], true) ? $sourceFormat : 'png';
    }

    /**
     * @param string $format jpg, png or webp
     * @return array{path:string,filename:string,mime:string}
     */
    private function saveImage(GdImage $image, string $format, string $baseName, int $quality = 90): array
    {
        if ($format === 'webp' && !function_exists('imagewebp')) {
            throw new RuntimeException('صيغة WebP غير مدعومة على الخادم حالياً.');
        }

        $path = Uploads::newOutputPath($format);
        $saved = match ($format) {
            'jpg' => imagejpeg($this->flattenOnWhite($image), $path, $quality),
            'webp' => imagewebp($image, $path, $quality),
            default => imagepng($image, $path, 9),
        };
        if ($saved === false) {
            throw new RuntimeException('تعذر حفظ الصورة الناتجة.');
        }

        $mime = ['jpg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp'][$format] ?? 'image/png';

        return ['path' => $path, 'filename' => $baseName . '.' . $format, 'mime' => $mime];
    }

    /** JPEG has no transparency: composite onto white instead of letting it turn black. */
    private function flattenOnWhite(GdImage $image): GdImage
    {
        $flat = imagecreatetruecolor(imagesx($image), imagesy($image));
        imagefill($flat, 0, 0, imagecolorallocate($flat, 255, 255, 255));
        imagecopy($flat, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));

        return $flat;
    }
}

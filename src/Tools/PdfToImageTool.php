<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Support\Uploads;
use RuntimeException;
use Smalot\PdfParser\Parser;
use Smalot\PdfParser\XObject\Image;
use ZipArchive;

/**
 * There is no pure-PHP PDF page rasterizer (that needs Ghostscript/Imagick),
 * so this tool covers the common "scanned document" case: each page is a
 * single embedded raster image, which we extract directly from the PDF's
 * XObjects instead of re-rendering the page.
 */
final class PdfToImageTool implements ToolInterface
{
    public function run(array $files, array $options): array
    {
        $file = $files[0] ?? null;
        if ($file === null) {
            throw new RuntimeException('لم يتم رفع أي ملف.');
        }

        $document = (new Parser())->parseFile($file);

        $images = [];
        $index = 0;
        foreach ($document->getPages() as $page) {
            foreach ($page->getXObjects() as $xobject) {
                if (!$xobject instanceof Image) {
                    continue;
                }
                $content = $xobject->getContent();
                if ($content === null || $content === '') {
                    continue;
                }
                $info = @getimagesizefromstring($content);
                if ($info === false) {
                    continue;
                }
                $ext = $info['mime'] === 'image/png' ? 'png' : 'jpg';
                $images[] = ['content' => $content, 'ext' => $ext, 'index' => ++$index];
            }
        }

        if ($images === []) {
            throw new RuntimeException('لم يتم العثور على صور ممسوحة ضوئياً داخل هذا الملف — على الأرجح أنه PDF نصي/رسومي، وهذا غير مدعوم حالياً بدون Ghostscript.');
        }

        if (count($images) === 1) {
            $img = $images[0];
            $outPath = Uploads::newOutputPath($img['ext']);
            file_put_contents($outPath, $img['content']);
            $mime = $img['ext'] === 'png' ? 'image/png' : 'image/jpeg';

            return ['path' => $outPath, 'filename' => 'image.' . $img['ext'], 'mime' => $mime];
        }

        $zipPath = Uploads::newOutputPath('zip');
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new RuntimeException('تعذر إنشاء ملف ZIP.');
        }
        foreach ($images as $img) {
            $zip->addFromString(sprintf('image-%02d.%s', $img['index'], $img['ext']), $img['content']);
        }
        $zip->close();

        return ['path' => $zipPath, 'filename' => 'images.zip', 'mime' => 'application/zip'];
    }
}

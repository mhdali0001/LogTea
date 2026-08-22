<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Support\Uploads;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\PhpPresentation;
use RuntimeException;
use Smalot\PdfParser\Parser;

/**
 * Each PDF page becomes one slide containing its extracted text — not a
 * pixel-exact reproduction of the original page layout.
 */
final class PdfToPptTool implements ToolInterface
{
    public function run(array $files, array $options): array
    {
        $file = $files[0] ?? null;
        if ($file === null) {
            throw new RuntimeException('لم يتم رفع أي ملف.');
        }

        $pages = (new Parser())->parseFile($file)->getPages();
        if ($pages === []) {
            throw new RuntimeException('تعذرت قراءة أي محتوى من هذا الملف.');
        }

        $presentation = new PhpPresentation();
        $presentation->removeSlideByIndex(0);

        foreach ($pages as $page) {
            $slide = $presentation->createSlide();
            $text = trim($page->getText());

            $richText = $slide->createRichTextShape()
                ->setHeight(660)
                ->setWidth(920)
                ->setOffsetX(20)
                ->setOffsetY(20);
            $richText->createTextRun($text !== '' ? $text : ' ')->getFont()->setSize(14);
        }

        $outPath = Uploads::newOutputPath('pptx');
        IOFactory::createWriter($presentation, 'PowerPoint2007')->save($outPath);

        return [
            'path' => $outPath,
            'filename' => 'converted.pptx',
            'mime' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        ];
    }
}

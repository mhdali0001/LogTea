<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Support\Uploads;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use RuntimeException;
use Smalot\PdfParser\Parser;

/**
 * Text-extraction based conversion (via smalot/pdfparser). There is no
 * layout-preserving PDF->DOCX engine in pure PHP, so tables, columns and
 * exact formatting from the original file are not reproduced.
 */
final class PdfToWordTool implements ToolInterface
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

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $lastIndex = count($pages) - 1;

        foreach ($pages as $i => $page) {
            $text = trim($page->getText());
            $lines = $text === '' ? [] : preg_split('/\r\n|\r|\n/', $text);

            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '') {
                    $section->addTextBreak();
                    continue;
                }
                $section->addText($line);
            }

            if ($i !== $lastIndex) {
                $section->addPageBreak();
            }
        }

        $outPath = Uploads::newOutputPath('docx');
        IOFactory::createWriter($phpWord, 'Word2007')->save($outPath);

        return [
            'path' => $outPath,
            'filename' => 'converted.docx',
            'mime' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];
    }
}

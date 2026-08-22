<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Support\Uploads;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use RuntimeException;
use Smalot\PdfParser\Parser;

/**
 * Text-extraction based conversion: columns are guessed from runs of 2+
 * spaces / tabs between words, which works for simple, clearly-aligned
 * tables but not for complex or borderless layouts.
 */
final class PdfToExcelTool implements ToolInterface
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

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('PDF');
        $sheet->setRightToLeft(true);

        $row = 1;
        foreach ($pages as $page) {
            $text = trim($page->getText());
            if ($text === '') {
                continue;
            }

            foreach (preg_split('/\r\n|\r|\n/', $text) as $line) {
                $line = rtrim($line);
                if ($line === '') {
                    ++$row;
                    continue;
                }
                $cells = preg_split('/\s{2,}|\t+/', trim($line)) ?: [];
                foreach ($cells as $col => $value) {
                    $sheet->setCellValue([$col + 1, $row], $value);
                }
                ++$row;
            }
            ++$row;
        }

        $outPath = Uploads::newOutputPath('xlsx');
        IOFactory::createWriter($spreadsheet, 'Xlsx')->save($outPath);

        return [
            'path' => $outPath,
            'filename' => 'converted.xlsx',
            'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];
    }
}

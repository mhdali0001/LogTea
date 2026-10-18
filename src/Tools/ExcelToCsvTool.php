<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Support\Uploads;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use RuntimeException;
use ZipArchive;

/** One CSV per worksheet (a ZIP when there are several), UTF-8 with a BOM so Excel keeps Arabic intact. */
final class ExcelToCsvTool implements ToolInterface
{
    private const DELIMITERS = ['comma' => ',', 'semicolon' => ';', 'tab' => "\t"];

    public function run(array $files, array $options): array
    {
        $file = $files[0] ?? null;
        if ($file === null) {
            throw new RuntimeException('لم يتم رفع أي ملف.');
        }

        $delimiter = self::DELIMITERS[$options['delimiter'] ?? ''] ?? ',';
        $spreadsheet = IOFactory::load($file);
        $count = $spreadsheet->getSheetCount();

        $writeSheet = static function (int $index) use ($spreadsheet, $delimiter): string {
            $writer = new Csv($spreadsheet);
            $writer->setSheetIndex($index);
            $writer->setDelimiter($delimiter);
            $writer->setUseBOM(true);
            $path = Uploads::newOutputPath('csv');
            $writer->save($path);

            return $path;
        };

        if ($count === 1) {
            return ['path' => $writeSheet(0), 'filename' => 'converted.csv', 'mime' => 'text/csv'];
        }

        $zipPath = Uploads::newOutputPath('zip');
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new RuntimeException('تعذر إنشاء ملف ZIP.');
        }

        $sheetPaths = [];
        for ($i = 0; $i < $count; $i++) {
            $title = preg_replace('/[\\\\\/:*?"<>|\x00-\x1F]+/u', '-', $spreadsheet->getSheet($i)->getTitle());
            $sheetPaths[] = $writeSheet($i);
            $zip->addFile(end($sheetPaths), sprintf('%02d-%s.csv', $i + 1, $title));
        }
        $zip->close();

        foreach ($sheetPaths as $path) {
            @unlink($path);
        }

        return ['path' => $zipPath, 'filename' => 'sheets-csv.zip', 'mime' => 'application/zip'];
    }
}

<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Support\Uploads;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use RuntimeException;

/**
 * The separator (comma, semicolon, tab…) is detected from the file. Files
 * that aren't UTF-8 are read as Windows-1256, the usual encoding of Arabic
 * CSVs saved by Excel.
 */
final class CsvToExcelTool implements ToolInterface
{
    public function run(array $files, array $options): array
    {
        $file = $files[0] ?? null;
        if ($file === null) {
            throw new RuntimeException('لم يتم رفع أي ملف.');
        }

        $reader = new Csv();
        $reader->setInputEncoding(Csv::guessEncoding($file, 'CP1256'));
        $spreadsheet = $reader->load($file);

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('CSV');
        $lastColumn = Coordinate::columnIndexFromString($sheet->getHighestDataColumn());
        foreach (range(1, min($lastColumn, 50)) as $col) {
            $sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
        }

        $sample = '';
        foreach ($sheet->getRowIterator(1, min(20, $sheet->getHighestDataRow())) as $row) {
            foreach ($row->getCellIterator() as $cell) {
                $sample .= (string) $cell->getValue();
            }
        }
        if (preg_match('/\p{Arabic}/u', $sample)) {
            $sheet->setRightToLeft(true);
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

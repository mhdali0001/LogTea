<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Support\Uploads;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Tcpdf as PdfWriter;
use RuntimeException;

final class ExcelToPdfTool implements ToolInterface
{
    public function run(array $files, array $options): array
    {
        $file = $files[0] ?? null;
        if ($file === null) {
            throw new RuntimeException('لم يتم رفع أي ملف.');
        }

        $spreadsheet = IOFactory::load($file);

        /** @var PdfWriter $writer */
        $writer = IOFactory::createWriter($spreadsheet, 'Tcpdf');
        $writer->writeAllSheets();

        $outPath = Uploads::newOutputPath('pdf');
        $writer->save($outPath);

        return ['path' => $outPath, 'filename' => 'converted.pdf', 'mime' => 'application/pdf'];
    }
}

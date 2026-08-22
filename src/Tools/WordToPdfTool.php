<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Support\Uploads;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use RuntimeException;

final class WordToPdfTool implements ToolInterface
{
    public function run(array $files, array $options): array
    {
        $file = $files[0] ?? null;
        if ($file === null) {
            throw new RuntimeException('لم يتم رفع أي ملف.');
        }

        Settings::setPdfRendererName(Settings::PDF_RENDERER_TCPDF);
        Settings::setPdfRendererPath(LOGTEA_ROOT . '/vendor/tecnickcom/tcpdf');

        $phpWord = IOFactory::load($file, 'Word2007');
        $writer = IOFactory::createWriter($phpWord, 'PDF');

        $outPath = Uploads::newOutputPath('pdf');
        $writer->save($outPath);

        return ['path' => $outPath, 'filename' => 'converted.pdf', 'mime' => 'application/pdf'];
    }
}

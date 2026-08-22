<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Support\Uploads;
use RuntimeException;
use TCPDF;

final class ImageToPdfTool implements ToolInterface
{
    public function run(array $files, array $options): array
    {
        if ($files === []) {
            throw new RuntimeException('لم يتم رفع أي صورة.');
        }

        $orientationOption = $options['orientation'] ?? 'auto';

        $pdf = new TCPDF();
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(0, 0, 0);
        $pdf->SetAutoPageBreak(false, 0);

        foreach ($files as $file) {
            $info = @getimagesize($file);
            if ($info === false) {
                throw new RuntimeException('أحد الملفات ليس صورة صالحة.');
            }
            [$imgW, $imgH] = $info;

            $orientation = $orientationOption === 'auto'
                ? ($imgW > $imgH ? 'L' : 'P')
                : $orientationOption;

            $pdf->AddPage($orientation, 'A4');
            $pageW = $pdf->getPageWidth();
            $pageH = $pdf->getPageHeight();

            $scale = min($pageW / $imgW, $pageH / $imgH);
            $drawW = $imgW * $scale;
            $drawH = $imgH * $scale;
            $x = ($pageW - $drawW) / 2;
            $y = ($pageH - $drawH) / 2;

            $pdf->Image($file, $x, $y, $drawW, $drawH, '', '', '', true, 300);
        }

        $outPath = Uploads::newOutputPath('pdf');
        $pdf->Output($outPath, 'F');

        return ['path' => $outPath, 'filename' => 'images.pdf', 'mime' => 'application/pdf'];
    }
}

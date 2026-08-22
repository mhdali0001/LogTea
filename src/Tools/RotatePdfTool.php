<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Support\PageRange;
use LogTea\Support\Uploads;
use LogTea\Tools\Concerns\BuildsFpdi;
use RuntimeException;

final class RotatePdfTool implements ToolInterface
{
    use BuildsFpdi;

    public function run(array $files, array $options): array
    {
        $file = $files[0] ?? null;
        if ($file === null) {
            throw new RuntimeException('لم يتم رفع أي ملف.');
        }

        $angle = (int) ($options['angle'] ?? 90);
        if (!in_array($angle, [90, 180, 270], true)) {
            $angle = 90;
        }

        $pdf = $this->newFpdi();
        $total = $pdf->setSourceFile($file);
        $targetPages = PageRange::parse((string) ($options['pages'] ?? ''), $total);

        for ($i = 1; $i <= $total; $i++) {
            $tplId = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($tplId);
            $origW = $size['width'];
            $origH = $size['height'];
            $rotateThis = in_array($i, $targetPages, true);

            if ($rotateThis && $angle !== 180) {
                $newW = $origH;
                $newH = $origW;
            } else {
                $newW = $origW;
                $newH = $origH;
            }

            $pdf->AddPage($newW > $newH ? 'L' : 'P', [$newW, $newH]);

            if ($rotateThis) {
                $cx = $newW / 2;
                $cy = $newH / 2;
                $pdf->StartTransform();
                $pdf->Rotate($angle, $cx, $cy);
                $pdf->useTemplate($tplId, $cx - $origW / 2, $cy - $origH / 2, $origW, $origH);
                $pdf->StopTransform();
            } else {
                $pdf->useTemplate($tplId, 0, 0, $origW, $origH);
            }
        }

        $outPath = Uploads::newOutputPath('pdf');
        $pdf->Output($outPath, 'F');

        return ['path' => $outPath, 'filename' => 'rotated.pdf', 'mime' => 'application/pdf'];
    }
}

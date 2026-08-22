<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Support\Uploads;
use LogTea\Tools\Concerns\BuildsFpdi;
use RuntimeException;

final class PageNumbersTool implements ToolInterface
{
    use BuildsFpdi;

    public function run(array $files, array $options): array
    {
        $file = $files[0] ?? null;
        if ($file === null) {
            throw new RuntimeException('لم يتم رفع أي ملف.');
        }

        $position = $options['position'] ?? 'bottom-center';
        $start = max(1, (int) ($options['start'] ?? 1));

        $pdf = $this->newFpdi();
        $total = $pdf->setSourceFile($file);

        for ($i = 1; $i <= $total; $i++) {
            $tplId = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($tplId);
            $pdf->AddPage($size['width'] > $size['height'] ? 'L' : 'P', [$size['width'], $size['height']]);
            $pdf->useTemplate($tplId);

            $label = (string) ($start + $i - 1);
            $pdf->SetFont('helvetica', '', 10);
            $textW = $pdf->GetStringWidth($label) + 4;
            $y = $size['height'] - 12;

            $x = match ($position) {
                'bottom-right' => $size['width'] - $textW - 8,
                'bottom-left'  => 8,
                default        => ($size['width'] - $textW) / 2,
            };

            $pdf->SetXY($x, $y);
            $pdf->SetTextColor(60, 60, 60);
            $pdf->Cell($textW, 8, $label, 0, 0, 'C');
        }

        $outPath = Uploads::newOutputPath('pdf');
        $pdf->Output($outPath, 'F');

        return ['path' => $outPath, 'filename' => 'numbered.pdf', 'mime' => 'application/pdf'];
    }
}

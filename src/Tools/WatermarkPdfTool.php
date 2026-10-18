<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Support\Uploads;
use LogTea\Tools\Concerns\BuildsFpdi;
use RuntimeException;

/**
 * Stamps a semi-transparent text across every page, sized to the page so it
 * reads the same on A4, letter or slides. DejaVu Sans covers Arabic and Latin,
 * and TCPDF shapes and orders Arabic text on its own.
 */
final class WatermarkPdfTool implements ToolInterface
{
    use BuildsFpdi;

    public function run(array $files, array $options): array
    {
        $file = $files[0] ?? null;
        if ($file === null) {
            throw new RuntimeException('لم يتم رفع أي ملف.');
        }

        $text = trim((string) ($options['text'] ?? ''));
        if ($text === '') {
            throw new RuntimeException('اكتب نص العلامة المائية.');
        }
        $opacity = max(5, min(100, (int) ($options['opacity'] ?? 25))) / 100;
        $diagonal = ($options['layout'] ?? 'diagonal') !== 'horizontal';

        $pdf = $this->newFpdi();
        $total = $pdf->setSourceFile($file);

        for ($i = 1; $i <= $total; $i++) {
            $tplId = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($tplId);
            $w = $size['width'];
            $h = $size['height'];
            $pdf->AddPage($w > $h ? 'L' : 'P', [$w, $h]);
            $pdf->useTemplate($tplId);

            // Size the text to ~60% of the line it runs along (the diagonal or the width).
            $pdf->SetFont('dejavusans', 'B', 10);
            $span = $diagonal ? hypot($w, $h) : $w;
            $pdf->SetFontSize(max(12, min(120, 10 * 0.6 * $span / max(1, $pdf->GetStringWidth($text)))));
            $boxW = $pdf->GetStringWidth($text) + 4;
            $boxH = $pdf->getCellHeight($pdf->getFontSize());

            $cx = $w / 2;
            $cy = $h / 2;
            $pdf->SetAlpha($opacity);
            $pdf->SetTextColor(128, 128, 128);
            $pdf->StartTransform();
            $pdf->Rotate($diagonal ? rad2deg(atan2($h, $w)) : 0, $cx, $cy);
            // On portrait pages the text is wider than the page, so its left edge
            // falls below 0 — and TCPDF reads a negative x as "from the right edge".
            // Draw at x=0 and shift into place instead.
            $pdf->Translate($cx - $boxW / 2, 0);
            $pdf->SetXY(0, $cy - $boxH / 2);
            $pdf->Cell($boxW, $boxH, $text, 0, 0, 'C');
            $pdf->StopTransform();
            $pdf->SetAlpha(1);
        }

        $outPath = Uploads::newOutputPath('pdf');
        $pdf->Output($outPath, 'F');

        return ['path' => $outPath, 'filename' => 'watermarked.pdf', 'mime' => 'application/pdf'];
    }
}

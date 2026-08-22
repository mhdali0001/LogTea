<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Support\Uploads;
use LogTea\Tools\Concerns\BuildsFpdi;
use RuntimeException;

/**
 * Best-effort compression: re-serializes the PDF through FPDI/TCPDF, which
 * re-applies Flate stream compression and drops redundant structure. Real
 * image down-sampling (the main win a tool like Ghostscript gives you) is
 * not available without a system binary, so gains vary a lot by file.
 * We never return a result larger than the original.
 */
final class CompressPdfTool implements ToolInterface
{
    use BuildsFpdi;

    public function run(array $files, array $options): array
    {
        $file = $files[0] ?? null;
        if ($file === null) {
            throw new RuntimeException('لم يتم رفع أي ملف.');
        }

        $pdf = $this->newFpdi();
        $pdf->setCompression(true);
        $this->appendAllPages($pdf, $file);

        $outPath = Uploads::newOutputPath('pdf');
        $pdf->Output($outPath, 'F');

        if (filesize($outPath) >= filesize($file)) {
            @unlink($outPath);
            $outPath = Uploads::newOutputPath('pdf');
            copy($file, $outPath);
        }

        return ['path' => $outPath, 'filename' => 'compressed.pdf', 'mime' => 'application/pdf'];
    }
}

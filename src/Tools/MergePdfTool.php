<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Support\Uploads;
use LogTea\Tools\Concerns\BuildsFpdi;
use RuntimeException;

final class MergePdfTool implements ToolInterface
{
    use BuildsFpdi;

    public function run(array $files, array $options): array
    {
        if (count($files) < 2) {
            throw new RuntimeException('يجب رفع ملفين على الأقل لدمجهما.');
        }

        $pdf = $this->newFpdi();

        foreach ($files as $file) {
            $this->appendAllPages($pdf, $file);
        }

        $outPath = Uploads::newOutputPath('pdf');
        $pdf->Output($outPath, 'F');

        return ['path' => $outPath, 'filename' => 'merged.pdf', 'mime' => 'application/pdf'];
    }
}

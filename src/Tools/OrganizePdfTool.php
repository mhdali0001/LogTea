<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Support\PageRange;
use LogTea\Support\Uploads;
use LogTea\Tools\Concerns\BuildsFpdi;
use RuntimeException;

/** Rebuilds the document in a typed page order (pages left out are dropped), or reversed. */
final class OrganizePdfTool implements ToolInterface
{
    use BuildsFpdi;

    public function run(array $files, array $options): array
    {
        $file = $files[0] ?? null;
        if ($file === null) {
            throw new RuntimeException('لم يتم رفع أي ملف.');
        }

        $reverse = ($options['mode'] ?? 'custom') === 'reverse';
        $order = trim((string) ($options['order'] ?? ''));
        if (!$reverse && $order === '') {
            throw new RuntimeException('اكتب الترتيب الجديد للصفحات، مثال: 3,1,2');
        }

        $pdf = $this->newFpdi();
        $total = $pdf->setSourceFile($file);
        $pages = $reverse ? range($total, 1) : PageRange::sequence($order, $total);

        foreach ($pages as $pageNo) {
            $tplId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($tplId);
            $pdf->AddPage($size['width'] > $size['height'] ? 'L' : 'P', [$size['width'], $size['height']]);
            $pdf->useTemplate($tplId);
        }

        $outPath = Uploads::newOutputPath('pdf');
        $pdf->Output($outPath, 'F');

        return ['path' => $outPath, 'filename' => 'organized.pdf', 'mime' => 'application/pdf'];
    }
}

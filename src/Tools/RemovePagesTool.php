<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Support\PageRange;
use LogTea\Support\Uploads;
use LogTea\Tools\Concerns\BuildsFpdi;
use RuntimeException;

final class RemovePagesTool implements ToolInterface
{
    use BuildsFpdi;

    public function run(array $files, array $options): array
    {
        $file = $files[0] ?? null;
        if ($file === null) {
            throw new RuntimeException('لم يتم رفع أي ملف.');
        }

        $range = trim((string) ($options['pages'] ?? ''));
        if ($range === '') {
            throw new RuntimeException('اكتب أرقام الصفحات التي تريد حذفها.');
        }

        $pdf = $this->newFpdi();
        $total = $pdf->setSourceFile($file);
        $keep = array_diff(range(1, $total), PageRange::parse($range, $total));
        if ($keep === []) {
            throw new RuntimeException('لا يمكن حذف كل صفحات الملف — يجب أن تبقى صفحة واحدة على الأقل.');
        }

        foreach ($keep as $pageNo) {
            $tplId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($tplId);
            $pdf->AddPage($size['width'] > $size['height'] ? 'L' : 'P', [$size['width'], $size['height']]);
            $pdf->useTemplate($tplId);
        }

        $outPath = Uploads::newOutputPath('pdf');
        $pdf->Output($outPath, 'F');

        return ['path' => $outPath, 'filename' => 'pages-removed.pdf', 'mime' => 'application/pdf'];
    }
}

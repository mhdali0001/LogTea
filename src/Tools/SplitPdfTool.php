<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Support\PageRange;
use LogTea\Support\Uploads;
use LogTea\Tools\Concerns\BuildsFpdi;
use RuntimeException;
use ZipArchive;

final class SplitPdfTool implements ToolInterface
{
    use BuildsFpdi;

    public function run(array $files, array $options): array
    {
        $file = $files[0] ?? null;
        if ($file === null) {
            throw new RuntimeException('لم يتم رفع أي ملف.');
        }

        $mode = $options['mode'] ?? 'range';

        $probe = $this->newFpdi();
        $total = $probe->setSourceFile($file);

        if ($mode === 'all') {
            return $this->splitEveryPage($file, $total);
        }

        $pages = PageRange::parse((string) ($options['range'] ?? ''), $total);

        $pdf = $this->newFpdi();
        $pdf->setSourceFile($file);
        foreach ($pages as $pageNo) {
            $tplId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($tplId);
            $pdf->AddPage($size['width'] > $size['height'] ? 'L' : 'P', [$size['width'], $size['height']]);
            $pdf->useTemplate($tplId);
        }

        $outPath = Uploads::newOutputPath('pdf');
        $pdf->Output($outPath, 'F');

        return ['path' => $outPath, 'filename' => 'split.pdf', 'mime' => 'application/pdf'];
    }

    private function splitEveryPage(string $file, int $total): array
    {
        $zipPath = Uploads::newOutputPath('zip');
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new RuntimeException('تعذر إنشاء ملف ZIP.');
        }

        $pagePaths = [];
        for ($i = 1; $i <= $total; $i++) {
            $pdf = $this->newFpdi();
            $pdf->setSourceFile($file);
            $tplId = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($tplId);
            $pdf->AddPage($size['width'] > $size['height'] ? 'L' : 'P', [$size['width'], $size['height']]);
            $pdf->useTemplate($tplId);

            $pagePath = Uploads::newOutputPath('pdf');
            $pdf->Output($pagePath, 'F');
            $pagePaths[] = $pagePath;
            $zip->addFile($pagePath, sprintf('page-%02d.pdf', $i));
        }

        $zip->close();

        foreach ($pagePaths as $pagePath) {
            @unlink($pagePath);
        }

        return ['path' => $zipPath, 'filename' => 'pages.zip', 'mime' => 'application/zip'];
    }
}

<?php

declare(strict_types=1);

namespace LogTea\Tools\Concerns;

use setasign\Fpdi\Tcpdf\Fpdi;

trait BuildsFpdi
{
    private function newFpdi(): Fpdi
    {
        // TCPDF's constructor forces a hidden "Powered by TCPDF" link onto the
        // last page; users get their document back with nothing of ours added.
        $pdf = new class () extends Fpdi {
            public function __construct()
            {
                parent::__construct();
                $this->tcpdflink = false;
            }
        };
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(0, 0, 0);
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->setImageScale(1);

        return $pdf;
    }

    /** Copies every page of $file into $pdf unchanged (no rotation/overlay). */
    private function appendAllPages(Fpdi $pdf, string $file): void
    {
        $count = $pdf->setSourceFile($file);
        for ($i = 1; $i <= $count; $i++) {
            $tplId = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($tplId);
            $pdf->AddPage($size['width'] > $size['height'] ? 'L' : 'P', [$size['width'], $size['height']]);
            $pdf->useTemplate($tplId);
        }
    }
}

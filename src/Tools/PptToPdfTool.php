<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Support\Uploads;
use PhpOffice\PhpPresentation\DocumentLayout;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Shape\Drawing\AbstractDrawingAdapter;
use PhpOffice\PhpPresentation\Shape\RichText;
use RuntimeException;
use TCPDF;

/**
 * Best-effort PPTX -> PDF conversion: PhpPresentation has no real PDF writer,
 * so each slide becomes one PDF page and we redraw its text boxes and images
 * at their original position/size. Slide backgrounds, precise typography,
 * charts, tables and animations are not reproduced (see the "note" shown on
 * the tool page).
 */
final class PptToPdfTool implements ToolInterface
{
    private const PX_TO_MM = 25.4 / 96;

    public function run(array $files, array $options): array
    {
        $file = $files[0] ?? null;
        if ($file === null) {
            throw new RuntimeException('لم يتم رفع أي ملف.');
        }

        $presentation = IOFactory::load($file, 'PowerPoint2007');
        $layout = $presentation->getLayout();
        $pageW = $layout->getCX(DocumentLayout::UNIT_MILLIMETER);
        $pageH = $layout->getCY(DocumentLayout::UNIT_MILLIMETER);

        $pdf = new TCPDF($pageW > $pageH ? 'L' : 'P', 'mm', [$pageW, $pageH]);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(0, 0, 0);
        $pdf->SetAutoPageBreak(false, 0);

        foreach ($presentation->getAllSlides() as $slide) {
            $pdf->AddPage($pageW > $pageH ? 'L' : 'P', [$pageW, $pageH]);

            foreach ($slide->getShapeCollection() as $shape) {
                $x = $shape->getOffsetX() * self::PX_TO_MM;
                $y = $shape->getOffsetY() * self::PX_TO_MM;
                $w = $shape->getWidth() * self::PX_TO_MM;
                $h = $shape->getHeight() * self::PX_TO_MM;

                if ($shape instanceof RichText) {
                    $text = $this->extractText($shape);
                    if ($text !== '') {
                        $pdf->SetFont('helvetica', '', 14);
                        $pdf->SetTextColor(20, 20, 20);
                        $pdf->SetXY($x, $y);
                        $pdf->MultiCell($w > 0 ? $w : $pageW, $h > 0 ? $h : 10, $text, 0, 'R', false, 1, null, null, true);
                    }
                } elseif ($shape instanceof AbstractDrawingAdapter && $w > 0 && $h > 0) {
                    try {
                        $pdf->Image('@' . $shape->getContents(), $x, $y, $w, $h);
                    } catch (\Throwable) {
                        // skip images PhpPresentation could not decode
                    }
                }
            }
        }

        $outPath = Uploads::newOutputPath('pdf');
        $pdf->Output($outPath, 'F');

        return ['path' => $outPath, 'filename' => 'converted.pdf', 'mime' => 'application/pdf'];
    }

    private function extractText(RichText $shape): string
    {
        $lines = [];
        foreach ($shape->getParagraphs() as $paragraph) {
            $line = '';
            foreach ($paragraph->getRichTextElements() as $element) {
                $line .= $element->getText();
            }
            $lines[] = $line;
        }

        return trim(implode("\n", $lines));
    }
}

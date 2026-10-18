<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Support\Uploads;
use RuntimeException;
use Smalot\PdfParser\Parser;

final class PdfToTextTool implements ToolInterface
{
    public function run(array $files, array $options): array
    {
        $file = $files[0] ?? null;
        if ($file === null) {
            throw new RuntimeException('لم يتم رفع أي ملف.');
        }

        $sections = [];
        foreach ((new Parser())->parseFile($file)->getPages() as $i => $page) {
            $text = trim($page->getText());
            if ($text !== '') {
                $sections[] = '----- صفحة ' . ($i + 1) . " -----\n\n" . $text;
            }
        }
        if ($sections === []) {
            throw new RuntimeException('لم يتم العثور على نص في هذا الملف — قد يكون ممسوحاً ضوئياً (صوراً فقط).');
        }

        $outPath = Uploads::newOutputPath('txt');
        // The BOM makes Windows editors pick UTF-8, so Arabic text opens correctly.
        file_put_contents($outPath, "\u{FEFF}" . implode("\n\n", $sections) . "\n");

        return ['path' => $outPath, 'filename' => 'extracted-text.txt', 'mime' => 'text/plain'];
    }
}

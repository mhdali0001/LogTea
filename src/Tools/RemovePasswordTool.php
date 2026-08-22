<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Support\PdfRc4Decryptor;
use LogTea\Support\Uploads;
use RuntimeException;
use setasign\Fpdi\Tcpdf\Fpdi;

final class RemovePasswordTool implements ToolInterface
{
    public function run(array $files, array $options): array
    {
        $file = $files[0] ?? null;
        $password = (string) ($options['password'] ?? '');
        if ($file === null) {
            throw new RuntimeException('لم يتم رفع أي ملف.');
        }

        $decrypted = PdfRc4Decryptor::decrypt($file, $password);

        $outPath = Uploads::newOutputPath('pdf');
        file_put_contents($outPath, $decrypted);

        try {
            (new Fpdi())->setSourceFile($outPath);
        } catch (\Throwable) {
            @unlink($outPath);
            throw new RuntimeException('تعذر التحقق من الملف الناتج — قد يكون التشفير من نوع غير مدعوم.');
        }

        return ['path' => $outPath, 'filename' => 'unlocked.pdf', 'mime' => 'application/pdf'];
    }
}

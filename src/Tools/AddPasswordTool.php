<?php

declare(strict_types=1);

namespace LogTea\Tools;

use LogTea\Support\Uploads;
use LogTea\Tools\Concerns\BuildsFpdi;
use RuntimeException;

final class AddPasswordTool implements ToolInterface
{
    use BuildsFpdi;

    public function run(array $files, array $options): array
    {
        $file = $files[0] ?? null;
        $password = (string) ($options['password'] ?? '');
        if ($file === null || $password === '') {
            throw new RuntimeException('يرجى رفع الملف وإدخال كلمة المرور.');
        }

        $pdf = $this->newFpdi();
        $ownerPassword = bin2hex(random_bytes(8));
        // mode 2 = AES-128, a real modern encryption standard (not the legacy RC4).
        $pdf->SetProtection(['print', 'copy'], $password, $ownerPassword, 2, null);

        $this->appendAllPages($pdf, $file);

        $outPath = Uploads::newOutputPath('pdf');
        $pdf->Output($outPath, 'F');

        return ['path' => $outPath, 'filename' => 'protected.pdf', 'mime' => 'application/pdf'];
    }
}

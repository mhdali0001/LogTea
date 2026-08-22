<?php

declare(strict_types=1);

namespace LogTea\Support;

use RuntimeException;

final class Uploads
{
    /**
     * @param array<string,mixed> $file  a single entry from $_FILES
     * @param string[] $allowedExt  lower-case extensions without the dot
     */
    public static function store(array $file, array $allowedExt): string
    {
        if (!isset($file['tmp_name'], $file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException('فشل رفع الملف، حاول مرة أخرى.');
        }
        if (!is_uploaded_file($file['tmp_name'])) {
            throw new RuntimeException('رفع الملف غير صالح.');
        }

        $ext = strtolower((string) pathinfo((string) $file['name'], PATHINFO_EXTENSION));
        if ($ext === '' || !in_array($ext, $allowedExt, true)) {
            throw new RuntimeException('امتداد الملف غير مدعوم لهذه الأداة (.' . $ext . ')');
        }

        if (!is_dir(LOGTEA_UPLOADS) && !mkdir(LOGTEA_UPLOADS, 0775, true) && !is_dir(LOGTEA_UPLOADS)) {
            throw new RuntimeException('تعذر تجهيز مجلد التخزين المؤقت.');
        }

        $token = bin2hex(random_bytes(16));
        $dest = LOGTEA_UPLOADS . '/' . $token . '.' . $ext;

        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            throw new RuntimeException('تعذر حفظ الملف المرفوع.');
        }

        return $dest;
    }

    /**
     * Handles a $_FILES['field'] entry uploaded with the `multiple` attribute
     * (name/tmp_name/error/size/type are parallel arrays).
     *
     * @param array<string,array<int,mixed>> $files
     * @param string[] $allowedExt
     * @return string[] stored file paths, in the original order
     */
    public static function storeMultiple(array $files, array $allowedExt): array
    {
        $stored = [];
        $count = is_array($files['name'] ?? null) ? count($files['name']) : 0;

        for ($i = 0; $i < $count; $i++) {
            $stored[] = self::store([
                'name'     => $files['name'][$i],
                'type'     => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error'    => $files['error'][$i],
                'size'     => $files['size'][$i],
            ], $allowedExt);
        }

        return $stored;
    }

    public static function newOutputPath(string $ext): string
    {
        if (!is_dir(LOGTEA_OUTPUTS) && !mkdir(LOGTEA_OUTPUTS, 0775, true) && !is_dir(LOGTEA_OUTPUTS)) {
            throw new RuntimeException('تعذر تجهيز مجلد الإخراج.');
        }

        return LOGTEA_OUTPUTS . '/' . bin2hex(random_bytes(16)) . '.' . $ext;
    }
}

<?php

declare(strict_types=1);

require __DIR__ . '/../../src/bootstrap.php';

use LogTea\Support\TempCleanup;
use LogTea\Support\Uploads;
use LogTea\ToolRegistry;

TempCleanup::run();

header('Content-Type: application/json; charset=utf-8');

function respondError(string $message, int $status = 400): void
{
    http_response_code($status);
    echo json_encode(['ok' => false, 'error' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

function bytesFromIni(string $value): int
{
    $value = trim($value);
    $unit = strtolower(substr($value, -1));
    $num = (int) $value;

    return match ($unit) {
        'g' => $num * 1024 * 1024 * 1024,
        'm' => $num * 1024 * 1024,
        'k' => $num * 1024,
        default => $num,
    };
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respondError('يجب إرسال الطلب عبر POST.', 405);
}

if (empty($_FILES) && empty($_POST)) {
    $contentLength = (int) ($_SERVER['CONTENT_LENGTH'] ?? 0);
    $limit = bytesFromIni((string) ini_get('post_max_size'));
    if ($contentLength > 0 && $limit > 0 && $contentLength > $limit) {
        respondError('حجم الملف أكبر من الحد المسموح به على الخادم (' . (string) ini_get('post_max_size') . ').', 413);
    }
    respondError('لم يتم استلام أي ملف.');
}

$slug = $_GET['slug'] ?? '';
$tool = ToolRegistry::find($slug);
if ($tool === null) {
    respondError('أداة غير معروفة.', 404);
}

if (!isset($_FILES['files']) || !is_array($_FILES['files']['name'] ?? null) || $_FILES['files']['name'] === []) {
    respondError('يرجى رفع ملف واحد على الأقل.');
}

try {
    $stored = Uploads::storeMultiple($_FILES['files'], $tool['accept']);

    if (!($tool['multiple'] ?? false)) {
        $stored = array_slice($stored, 0, 1);
    }

    $minFiles = $tool['min_files'] ?? 1;
    if (count($stored) < $minFiles) {
        respondError("هذه الأداة تتطلب رفع {$minFiles} ملفات على الأقل.");
    }

    $options = [];
    foreach ($tool['options'] as $optDef) {
        $name = $optDef['name'];
        $raw = $_POST[$name] ?? $optDef['default'] ?? '';
        $raw = is_string($raw) ? substr(trim($raw), 0, 255) : '';
        $options[$name] = $raw;
    }

    /** @var \LogTea\Tools\ToolInterface $toolInstance */
    $toolInstance = new $tool['class']();
    $result = $toolInstance->run($stored, $options);

    foreach ($stored as $path) {
        @unlink($path);
    }

    $size = filesize($result['path']);
    $token = basename($result['path']);

    echo json_encode([
        'ok' => true,
        'downloadUrl' => '/download.php?token=' . rawurlencode($token) . '&name=' . rawurlencode($result['filename']),
        'filename' => $result['filename'],
        'size' => $size,
    ], JSON_UNESCAPED_UNICODE);
} catch (\RuntimeException $e) {
    respondError($e->getMessage() !== '' ? $e->getMessage() : 'حدث خطأ أثناء معالجة الملف.');
} catch (\Throwable $e) {
    error_log('[LogTea process] ' . $e->getMessage());
    respondError('تعذرت معالجة هذا الملف — تأكد أنه غير تالف ويطابق نوع الأداة.');
}

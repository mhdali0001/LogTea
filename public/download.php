<?php

declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';

$mimeByExt = [
    'pdf'  => 'application/pdf',
    'zip'  => 'application/zip',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    'jpg'  => 'image/jpeg',
    'png'  => 'image/png',
    'webp' => 'image/webp',
];

$token = $_GET['token'] ?? '';
if (!preg_match('/^[a-f0-9]{32}\.([a-z0-9]{2,5})$/', $token, $m)) {
    http_response_code(400);
    exit('رابط تنزيل غير صالح.');
}

$path = realpath(LOGTEA_OUTPUTS . '/' . $token);
if ($path === false || dirname($path) !== realpath(LOGTEA_OUTPUTS) || !is_file($path)) {
    http_response_code(404);
    exit('انتهت صلاحية هذا الملف أو تم تنزيله مسبقاً. عد إلى الأداة وحاول مجدداً.');
}

$ext = strtolower($m[1]);
$mime = $mimeByExt[$ext] ?? 'application/octet-stream';

$displayName = $_GET['name'] ?? ('download.' . $ext);
$displayName = preg_replace('/[\\\\\/:*?"<>|\x00-\x1F]/', '_', $displayName);
if ($displayName === '' || $displayName === null) {
    $displayName = 'download.' . $ext;
}

header('Content-Type: ' . $mime);
header('Content-Length: ' . filesize($path));
header('Content-Disposition: attachment; filename="' . $displayName . '"');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store');

readfile($path);
@unlink($path);

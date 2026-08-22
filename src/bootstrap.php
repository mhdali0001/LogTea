<?php

declare(strict_types=1);

define('LOGTEA_ROOT', dirname(__DIR__));

require LOGTEA_ROOT . '/vendor/autoload.php';

define('LOGTEA_STORAGE', LOGTEA_ROOT . '/storage');
define('LOGTEA_UPLOADS', LOGTEA_STORAGE . '/uploads');
define('LOGTEA_OUTPUTS', LOGTEA_STORAGE . '/outputs');

date_default_timezone_set('UTC');

// Deprecation/notice-level noise from vendor libraries must never leak into
// a binary file download or a JSON API response. Keep real errors logged,
// but never printed inline.
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

<?php

declare(strict_types=1);

namespace LogTea\Support;

/**
 * Opportunistic garbage collector for the stateless upload/output pipeline.
 * Runs at the top of the front-facing entry points (no cron needed) and
 * deletes anything older than the max age so shared-hosting disk quotas
 * and user privacy are both protected.
 */
final class TempCleanup
{
    public static function run(int $maxAgeSeconds = 1800): void
    {
        foreach ([LOGTEA_UPLOADS, LOGTEA_OUTPUTS] as $dir) {
            if (!is_dir($dir)) {
                continue;
            }
            foreach (glob($dir . '/*') ?: [] as $file) {
                if (is_file($file) && (time() - (int) filemtime($file)) > $maxAgeSeconds) {
                    @unlink($file);
                }
            }
        }
    }
}

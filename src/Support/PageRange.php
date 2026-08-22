<?php

declare(strict_types=1);

namespace LogTea\Support;

use RuntimeException;

final class PageRange
{
    /**
     * Parses strings like "1-3,5,8-9" into a sorted, deduped list of 1-based
     * page numbers clamped to $total. An empty string means "all pages".
     *
     * @return int[]
     */
    public static function parse(string $range, int $total): array
    {
        $range = trim($range);
        if ($range === '') {
            return range(1, $total);
        }

        $pages = [];
        foreach (explode(',', $range) as $part) {
            $part = trim($part);
            if ($part === '') {
                continue;
            }
            if (str_contains($part, '-')) {
                [$start, $end] = array_pad(array_map('trim', explode('-', $part, 2)), 2, '');
                $start = max(1, (int) $start);
                $end = min($total, (int) $end);
                for ($p = $start; $p <= $end; $p++) {
                    $pages[] = $p;
                }
            } else {
                $p = (int) $part;
                if ($p >= 1 && $p <= $total) {
                    $pages[] = $p;
                }
            }
        }

        $pages = array_values(array_unique($pages));
        sort($pages);

        if ($pages === []) {
            throw new RuntimeException('نطاق الصفحات المُدخل غير صالح.');
        }

        return $pages;
    }
}

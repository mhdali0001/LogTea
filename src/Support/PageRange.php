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

    /**
     * Like parse(), but keeps pages in the order typed, repeats included: "3,1-2"
     * means 3, 1, 2 and a descending range like "5-3" runs backwards.
     *
     * @return int[]
     */
    public static function sequence(string $range, int $total): array
    {
        $pages = [];
        foreach (explode(',', $range) as $part) {
            $part = trim($part);
            if ($part === '') {
                continue;
            }
            if (str_contains($part, '-')) {
                [$start, $end] = array_map(static fn (string $n): int => max(1, min($total, (int) trim($n))), explode('-', $part, 2));
                array_push($pages, ...range($start, $end));
            } else {
                $p = (int) $part;
                if ($p >= 1 && $p <= $total) {
                    $pages[] = $p;
                }
            }
        }

        if ($pages === []) {
            throw new RuntimeException('ترتيب الصفحات المُدخل غير صالح.');
        }

        return $pages;
    }
}

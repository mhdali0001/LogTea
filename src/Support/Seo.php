<?php

declare(strict_types=1);

namespace LogTea\Support;

/**
 * Absolute-URL and JSON-LD helpers shared by the layout and every page that
 * emits structured data. Kept host-agnostic so the same code produces
 * correct URLs on local dev (logtea.test) and on the production domain.
 */
final class Seo
{
    public static function baseUrl(): string
    {
        $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || ($_SERVER['SERVER_PORT'] ?? null) === '443';
        $scheme = $isHttps ? 'https' : 'http';

        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $host = preg_replace('/[^a-zA-Z0-9.\-:]/', '', $host) ?? 'localhost';

        return $scheme . '://' . $host;
    }

    /** Builds an absolute URL from a site-root-relative path, e.g. "/tools/merge-pdf". */
    public static function url(string $path = '/'): string
    {
        return self::baseUrl() . '/' . ltrim($path, '/');
    }

    /** Renders a JSON-LD <script> block. Slashes stay escaped so "</script>" can't break out of the tag. */
    public static function jsonLd(array $data): string
    {
        return '<script type="application/ld+json">'
            . json_encode($data, JSON_UNESCAPED_UNICODE)
            . '</script>' . "\n";
    }
}

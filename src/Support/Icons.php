<?php

declare(strict_types=1);

namespace LogTea\Support;

final class Icons
{
    private const PATHS = [
        'merge'   => 'M8 7V5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 01-2 2h-2M4 9h10a2 2 0 012 2v8a2 2 0 01-2 2H6a2 2 0 01-2-2v-8a2 2 0 012-2z',
        'split'   => 'M6 3v18M18 3v18M6 8h4M14 16h4M6 16l4-4-4-4M18 8l-4 4 4 4',
        'rotate'  => 'M4.5 12a7.5 7.5 0 0113-5.196M19.5 12a7.5 7.5 0 01-13 5.196M16 3v4h-4M8 21v-4h4',
        'pagenum' => 'M6 3h9l4.5 4.5V21H6V3z M15 3v4.5H19.5 M9 13h6 M9 17h4',
        'lock'    => 'M7.5 10.5V7.5a4.5 4.5 0 019 0v3M5.25 10.5h13.5A1.5 1.5 0 0120.25 12v7.5a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V12a1.5 1.5 0 011.5-1.5z',
        'unlock'  => 'M7.5 10.5V7.5a4.5 4.5 0 018.284-2.443M5.25 10.5h13.5A1.5 1.5 0 0120.25 12v7.5a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V12a1.5 1.5 0 011.5-1.5z',
        'compress'=> 'M9 3.75V8.25H4.5M15 3.75V8.25H19.5M9 20.25V15.75H4.5M15 20.25V15.75H19.5',
        'word'    => 'M6 3h8l5 5v13a1 1 0 01-1 1H6a1 1 0 01-1-1V4a1 1 0 011-1z M14 3v5h5 M8 13l1.5 6 1.5-4.5L12.5 19 14 13',
        'excel'   => 'M6 3h8l5 5v13a1 1 0 01-1 1H6a1 1 0 01-1-1V4a1 1 0 011-1z M14 3v5h5 M8.5 13l3 6 M11.5 13l-3 6',
        'ppt'     => 'M6 3h8l5 5v13a1 1 0 01-1 1H6a1 1 0 01-1-1V4a1 1 0 011-1z M14 3v5h5 M8.5 19v-6h2.2a1.9 1.9 0 010 3.8H8.5',
        'pdf'     => 'M6 3h8l5 5v13a1 1 0 01-1 1H6a1 1 0 01-1-1V4a1 1 0 011-1z M14 3v5h5 M8 19v-6h1.6a1.7 1.7 0 010 3.4H8 M12.5 19v-6h1.8a1.6 1.6 0 011.6 1.6v2.8a1.6 1.6 0 01-1.6 1.6h-1.8z',
        'image'   => 'M3.75 5.25h16.5v13.5H3.75z M3.75 15l4.5-4.5 3 3 4.5-5.25 4.5 6.75 M8.25 9a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25z',
    ];

    public static function svg(string $key, string $class = ''): string
    {
        $path = self::PATHS[$key] ?? self::PATHS['pdf'];
        $classAttr = $class !== '' ? ' class="' . htmlspecialchars($class, ENT_QUOTES, 'UTF-8') . '"' : '';

        return '<svg' . $classAttr . ' viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">'
            . '<path d="' . $path . '"/></svg>';
    }
}

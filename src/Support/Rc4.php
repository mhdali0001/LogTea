<?php

declare(strict_types=1);

namespace LogTea\Support;

final class Rc4
{
    /** RC4 is symmetric: the same call encrypts and decrypts. */
    public static function crypt(string $key, string $data): string
    {
        $keyLen = strlen($key);
        if ($keyLen === 0) {
            return $data;
        }

        $s = range(0, 255);
        $j = 0;
        for ($i = 0; $i < 256; $i++) {
            $j = ($j + $s[$i] + ord($key[$i % $keyLen])) & 0xFF;
            [$s[$i], $s[$j]] = [$s[$j], $s[$i]];
        }

        $out = '';
        $i = 0;
        $j = 0;
        $len = strlen($data);
        for ($n = 0; $n < $len; $n++) {
            $i = ($i + 1) & 0xFF;
            $j = ($j + $s[$i]) & 0xFF;
            [$s[$i], $s[$j]] = [$s[$j], $s[$i]];
            $out .= chr(ord($data[$n]) ^ $s[($s[$i] + $s[$j]) & 0xFF]);
        }

        return $out;
    }
}

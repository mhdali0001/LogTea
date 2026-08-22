<?php

declare(strict_types=1);

namespace LogTea\Support;

use RuntimeException;

/**
 * Minimal, self-contained decryptor for PDFs protected with the classic
 * "Standard Security Handler" using RC4 (V1/V2, revision R2/R3 — the
 * 40/128-bit scheme used by older Acrobat versions). It does NOT support
 * AES (V4/V5, R4-R6) or cross-reference-stream ("compressed") PDFs, which
 * covers most modern (Acrobat DC+) password-protected files — see the
 * "remove-password-pdf" tool note.
 *
 * RC4 is a stream cipher, so decrypting in place never changes any byte's
 * length: every object/stream can be patched at its original offset without
 * having to rebuild the file's cross-reference table.
 */
final class PdfRc4Decryptor
{
    private const PAD = "\x28\xBF\x4E\x5E\x4E\x75\x8A\x41\x64\x00\x4E\x56\xFF\xFA\x01\x08"
        . "\x2E\x2E\x00\xB6\xD0\x68\x3E\x80\x2F\x0C\xA9\xFE\x64\x53\x69\x7A";

    public static function decrypt(string $inputPath, string $password): string
    {
        $data = file_get_contents($inputPath);
        if ($data === false) {
            throw new RuntimeException('تعذرت قراءة الملف.');
        }

        if (!preg_match_all('/trailer\s*<<(.*?)>>/s', $data, $tm)) {
            throw new RuntimeException('لم يتم العثور على ملف PDF بتركيب قياسي (trailer) — هذا النوع غير مدعوم.');
        }
        $trailerDict = end($tm[1]);

        if (!preg_match('/\/Encrypt\s+(\d+)\s+(\d+)\s+R/', $trailerDict, $em)) {
            throw new RuntimeException('لم يتم العثور على تشفير قياسي في هذا الملف.');
        }
        [, $encNum, $encGen] = $em;

        if (!preg_match('/\/ID\s*\[\s*([<(].*?[>)])/s', $trailerDict, $idm)) {
            throw new RuntimeException('لم يتم العثور على معرّف الملف (ID) اللازم لفك التشفير.');
        }
        $id0 = self::parsePdfString($idm[1]);

        if (!preg_match('/\b' . $encNum . '\s+' . $encGen . '\s+obj\b(.*?)>>/s', $data, $om)) {
            throw new RuntimeException('تعذر قراءة قاموس التشفير.');
        }
        $encDict = $om[1];

        if (preg_match('/\/Filter\s*\/(\w+)/', $encDict, $fm) && $fm[1] !== 'Standard') {
            throw new RuntimeException('طريقة الحماية غير مدعومة (' . $fm[1] . ').');
        }

        $v = (int) (self::matchOr($encDict, '/\/V\s+(\d+)/', '1'));
        $r = (int) (self::matchOr($encDict, '/\/R\s+(\d+)/', '2'));
        $lengthBits = (int) (self::matchOr($encDict, '/\/Length\s+(\d+)/', '40'));

        if ($v > 2 || $r > 3) {
            throw new RuntimeException('هذا الملف مشفّر بمعيار حديث (AES) غير مدعوم حالياً — يلزم Ghostscript/qpdf.');
        }

        if (!preg_match('/\/O\s*([<(].*?[>)])/s', $encDict, $om2)) {
            throw new RuntimeException('تعذر قراءة قاموس التشفير (O).');
        }
        $O = self::parsePdfString($om2[1]);

        if (!preg_match('/\/U\s*([<(].*?[>)])/s', $encDict, $um)) {
            throw new RuntimeException('تعذر قراءة قاموس التشفير (U).');
        }
        $U = self::parsePdfString($um[1]);

        $p = (int) self::matchOr($encDict, '/\/P\s+(-?\d+)/', '0');
        $keyLen = intdiv($lengthBits, 8);

        $fileKey = self::computeFileKey($password, $O, $p, $id0, $r, $keyLen);

        if (!self::passwordIsValid($fileKey, $U, $id0, $r, $keyLen)) {
            throw new RuntimeException('كلمة المرور غير صحيحة، أو نوع التشفير غير مدعوم.');
        }

        $decrypted = self::decryptObjects($data, $fileKey, $keyLen, (int) $encNum);
        $decrypted = preg_replace('/\/Encrypt\s+\d+\s+\d+\s+R/', '', $decrypted, 1) ?? $decrypted;

        return $decrypted;
    }

    private static function matchOr(string $subject, string $pattern, string $default): string
    {
        return preg_match($pattern, $subject, $m) ? $m[1] : $default;
    }

    /** Decodes a PDF string token: either "(literal)" or "<hex>". */
    private static function parsePdfString(string $token): string
    {
        $token = trim($token);
        if ($token === '') {
            return '';
        }

        if ($token[0] === '<') {
            $hex = preg_replace('/[^0-9A-Fa-f]/', '', $token);
            if (strlen($hex) % 2 !== 0) {
                $hex .= '0';
            }

            return hex2bin($hex) ?: '';
        }

        // Literal string: strip the outer parens, unescape.
        $inner = substr($token, 1, -1);
        $out = '';
        $len = strlen($inner);
        for ($i = 0; $i < $len; $i++) {
            $ch = $inner[$i];
            if ($ch !== '\\') {
                $out .= $ch;
                continue;
            }
            $next = $inner[$i + 1] ?? '';
            switch ($next) {
                case 'n': $out .= "\n"; $i++; break;
                case 'r': $out .= "\r"; $i++; break;
                case 't': $out .= "\t"; $i++; break;
                case 'b': $out .= "\x08"; $i++; break;
                case 'f': $out .= "\x0C"; $i++; break;
                case '(': $out .= '('; $i++; break;
                case ')': $out .= ')'; $i++; break;
                case '\\': $out .= '\\'; $i++; break;
                default:
                    if (ctype_digit($next)) {
                        $oct = substr($inner, $i + 1, 3);
                        preg_match('/^[0-7]{1,3}/', $oct, $om);
                        $digits = $om[0] ?? '0';
                        $out .= chr(intval($digits, 8) & 0xFF);
                        $i += strlen($digits);
                    } else {
                        $out .= $next;
                        $i++;
                    }
            }
        }

        return $out;
    }

    private static function padPassword(string $password): string
    {
        $password = substr($password, 0, 32);

        return $password . substr(self::PAD, 0, 32 - strlen($password));
    }

    private static function computeFileKey(string $password, string $o, int $p, string $id0, int $r, int $keyLen): string
    {
        $input = self::padPassword($password) . $o . pack('V', $p & 0xFFFFFFFF) . $id0;
        $hash = md5($input, true);

        if ($r >= 3) {
            for ($i = 0; $i < 50; $i++) {
                $hash = md5(substr($hash, 0, $keyLen), true);
            }
        }

        return substr($hash, 0, $keyLen);
    }

    private static function passwordIsValid(string $fileKey, string $u, string $id0, int $r, int $keyLen): bool
    {
        if ($r === 2) {
            $computed = Rc4::crypt($fileKey, self::PAD);

            return $computed === $u;
        }

        $hash = md5(self::PAD . $id0, true);
        $computed = Rc4::crypt($fileKey, $hash);
        for ($i = 1; $i <= 19; $i++) {
            $roundKey = '';
            for ($b = 0; $b < $keyLen; $b++) {
                $roundKey .= chr(ord($fileKey[$b]) ^ $i);
            }
            $computed = Rc4::crypt($roundKey, $computed);
        }

        return substr($computed, 0, 16) === substr($u, 0, 16);
    }

    private static function decryptObjects(string $data, string $fileKey, int $keyLen, int $encObjNum): string
    {
        if (!preg_match_all('/(\d+)[ \t]+(\d+)[ \t]+obj\b/', $data, $matches, PREG_OFFSET_CAPTURE)) {
            throw new RuntimeException('لم يتم العثور على أي كائنات داخل الملف.');
        }

        $count = count($matches[0]);
        for ($n = 0; $n < $count; $n++) {
            $objNum = (int) $matches[1][$n][0];
            if ($objNum === $encObjNum) {
                continue;
            }
            $genNum = (int) $matches[2][$n][0];
            $headerEnd = $matches[0][$n][1] + strlen($matches[0][$n][0]);
            $bodyEnd = strlen($data);
            if (isset($matches[0][$n + 1])) {
                $bodyEnd = $matches[0][$n + 1][1];
            }
            $endobjPos = strpos($data, 'endobj', $headerEnd);
            if ($endobjPos !== false && $endobjPos < $bodyEnd) {
                $bodyEnd = $endobjPos;
            }

            $body = substr($data, $headerEnd, $bodyEnd - $headerEnd);
            if (str_contains($body, '/Type') && preg_match('/\/Type\s*\/XRef\b/', $body)) {
                continue;
            }

            $streamPos = strpos($body, 'stream');
            if ($streamPos === false) {
                continue;
            }

            $dataStart = $streamPos + 6;
            if (substr($body, $dataStart, 2) === "\r\n") {
                $dataStart += 2;
            } elseif (($body[$dataStart] ?? '') === "\n") {
                $dataStart += 1;
            }

            $endStreamPos = strpos($body, 'endstream', $dataStart);
            if ($endStreamPos === false) {
                continue;
            }
            $streamLen = $endStreamPos - $dataStart;
            if (substr($body, $endStreamPos - 2, 2) === "\r\n") {
                $streamLen -= 2;
            } elseif (($body[$endStreamPos - 1] ?? '') === "\n") {
                $streamLen -= 1;
            }
            if ($streamLen <= 0) {
                continue;
            }

            $objKey = self::objectKey($fileKey, $keyLen, $objNum, $genNum);
            $plain = Rc4::crypt($objKey, substr($body, $dataStart, $streamLen));

            $data = substr_replace($data, $plain, $headerEnd + $dataStart, $streamLen);
        }

        return $data;
    }

    private static function objectKey(string $fileKey, int $keyLen, int $objNum, int $genNum): string
    {
        $input = $fileKey
            . substr(pack('V', $objNum), 0, 3)
            . substr(pack('V', $genNum), 0, 2);
        $hash = md5($input, true);

        return substr($hash, 0, min($keyLen + 5, 16));
    }
}

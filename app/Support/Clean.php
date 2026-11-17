<?php

namespace App\Support;

/**
 * Server-side twin of the browser's Guard: strips invisible and control characters and markup.
 */
class Clean
{
    public static function text(mixed $value, bool $multiline = false): string
    {
        $s = \Normalizer::normalize((string) $value, \Normalizer::FORM_KC) ?: (string) $value;
        $s = preg_replace('/[\x{200B}-\x{200F}\x{202A}-\x{202E}\x{2060}-\x{206F}\x{FEFF}]/u', '', $s) ?? $s;
        $s = preg_replace($multiline ? '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F-\x9F]/u' : '/[\x00-\x1F\x7F-\x9F]/u', '', $s) ?? $s;
        $s = strip_tags($s);
        $s = preg_replace($multiline ? '/[ \t]{2,}/' : '/\s{2,}/', ' ', $s) ?? $s;

        return trim($s);
    }

    public static function phone(mixed $value): string
    {
        return trim(preg_replace('/[^\d+\s()-]/', '', (string) $value) ?? '');
    }
}

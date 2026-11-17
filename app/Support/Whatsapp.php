<?php

namespace App\Support;

class Whatsapp
{
    /**
     * Digits-only number for wa.me links. A bare 10-digit number is treated as Indian (+91).
     */
    public static function number(string $phone): string
    {
        $digits = preg_replace('/\D/', '', $phone) ?? '';

        if (strlen($digits) === 11 && str_starts_with($digits, '0')) {
            $digits = substr($digits, 1);
        }

        return strlen($digits) === 10 ? '91'.$digits : $digits;
    }

    public static function link(string $phone, string $message): string
    {
        return 'https://wa.me/'.self::number($phone).'?text='.rawurlencode($message);
    }
}

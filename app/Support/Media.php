<?php

namespace App\Support;

/**
 * Turns a stored image path into a public URL.
 * Files shipped with the site live in public/images; uploads live on the public disk.
 */
class Media
{
    public static function url(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (str_starts_with($path, 'http') || str_starts_with($path, '/')) {
            return $path;
        }

        if (! is_file(public_path('storage/'.$path)) && is_file(public_path('images/'.$path))) {
            return '/images/'.$path;
        }

        return '/storage/'.ltrim($path, '/');
    }
}

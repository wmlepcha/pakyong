<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Saves an uploaded photo as a resized WebP on the public disk (GD, no extra package).
 */
class ImageStore
{
    public static function store(UploadedFile $file, string $directory, int $maxEdge = 1600, int $quality = 76): string
    {
        $source = @imagecreatefromstring((string) file_get_contents($file->getRealPath()));

        if ($source === false) {
            throw new RuntimeException('That file is not a readable image.');
        }

        $source = self::orient($source, $file->getRealPath());
        [$width, $height] = [imagesx($source), imagesy($source)];
        $scale = min(1, $maxEdge / max($width, $height));

        if ($scale < 1) {
            $source = imagescale($source, (int) round($width * $scale), (int) round($height * $scale), IMG_BICUBIC_FIXED) ?: $source;
        }

        imagepalettetotruecolor($source);
        imagealphablending($source, false);
        imagesavealpha($source, true);

        ob_start();
        imagewebp($source, null, $quality);
        $data = (string) ob_get_clean();

        $path = trim($directory, '/').'/'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) ?: 'image').'-'.Str::lower(Str::random(6)).'.webp';
        Storage::disk('public')->put($path, $data);

        return $path;
    }

    private static function orient(\GdImage $image, string $path): \GdImage
    {
        if (! function_exists('exif_read_data')) {
            return $image;
        }

        $orientation = @exif_read_data($path)['Orientation'] ?? 1;
        $rotated = match ($orientation) {
            3 => imagerotate($image, 180, 0),
            6 => imagerotate($image, -90, 0),
            8 => imagerotate($image, 90, 0),
            default => $image,
        };

        return $rotated ?: $image;
    }
}

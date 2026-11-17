<?php

namespace App\Filament\Support;

use App\Support\ImageStore;
use Filament\Forms\Components\FileUpload;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

/**
 * Photo upload used across the admin: JPG, PNG or WebP in, a resized WebP out.
 */
class ImageUpload
{
    public static function make(string $name, string $directory = 'uploads', int $maxEdge = 1600): FileUpload
    {
        return FileUpload::make($name)
            ->disk('public')
            ->directory($directory)
            ->visibility('public')
            ->image()
            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->maxSize(10240)
            ->imageEditor()
            ->saveUploadedFileUsing(fn (TemporaryUploadedFile $file): string => ImageStore::store($file, $directory, $maxEdge))
            ->helperText('JPG, PNG or WebP up to 10 MB. It is resized and saved as WebP automatically.');
    }
}

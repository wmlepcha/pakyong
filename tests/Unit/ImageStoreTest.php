<?php

namespace Tests\Unit;

use App\Support\ImageStore;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageStoreTest extends TestCase
{
    public function test_uploads_become_resized_webp_files(): void
    {
        Storage::fake('public');

        $path = ImageStore::store(UploadedFile::fake()->image('My Hero Photo.png', 3000, 1500), 'home', 1200);

        Storage::disk('public')->assertExists($path);
        $this->assertStringEndsWith('.webp', $path);
        $this->assertStringStartsWith('home/my-hero-photo-', $path);

        [$width, $height, $type] = getimagesizefromstring(Storage::disk('public')->get($path));
        $this->assertSame(IMAGETYPE_WEBP, $type);
        $this->assertSame(1200, $width);
        $this->assertSame(600, $height);
    }

    public function test_small_images_are_not_enlarged(): void
    {
        Storage::fake('public');

        $path = ImageStore::store(UploadedFile::fake()->image('small.jpg', 400, 300), 'blog', 1600);

        [$width] = getimagesizefromstring(Storage::disk('public')->get($path));
        $this->assertSame(400, $width);
    }

    public function test_files_that_are_not_images_are_refused(): void
    {
        $this->expectException(\RuntimeException::class);

        ImageStore::store(UploadedFile::fake()->createWithContent('notes.png', 'not an image'), 'blog');
    }
}

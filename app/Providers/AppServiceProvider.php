<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('dims', fn (string $path): string => "<?php echo \\App\\Providers\\AppServiceProvider::imageDimensions({$path}); ?>");
    }

    /**
     * Width and height attributes for a public image, so the browser can reserve its space.
     */
    public static function imageDimensions(string $path): string
    {
        $file = public_path(ltrim($path, '/'));
        $size = is_file($file) ? @getimagesize($file) : false;

        return $size ? 'width="'.$size[0].'" height="'.$size[1].'"' : '';
    }
}

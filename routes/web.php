<?php

use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\EnquiryController;
use App\Support\ContentRepository;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', function () {
    $fallback = now()->toDateString();
    $pages = collect(['home', 'destinations', 'guide', 'blog', 'faq', 'contact', 'terms', 'privacy'])->map(fn ($r) => [route($r), $fallback])
        ->merge(ContentRepository::destinations()->keys()->map(fn ($s) => [route('destination', $s), $fallback]))
        ->merge(ContentRepository::posts()->map(fn ($p) => [route('post', $p['slug']), $p['updated'] ?? $p['date'] ?? $fallback])->values());

    $entries = $pages->map(fn ($p) => '<url><loc>'.e($p[0]).'</loc><lastmod>'.$p[1].'</lastmod></url>')->implode("\n");

    return response('<?xml version="1.0" encoding="UTF-8"?>'."\n".'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n".$entries."\n</urlset>\n", 200, ['Content-Type' => 'application/xml']);
});
Route::get('/robots.txt', fn () => response("User-agent: *\nDisallow:\n\nSitemap: ".url('/sitemap.xml')."\n", 200, ['Content-Type' => 'text/plain']));
Route::view('/', 'pages.home')->name('home');
Route::view('/destinations', 'pages.destinations')->name('destinations');
Route::get('/destinations/{slug}', fn (string $slug) => view('pages.destination', [
    'slug' => $slug,
    'd' => ContentRepository::destination($slug) ?? abort(404),
]))->name('destination');
Route::view('/travel-guide', 'pages.guide')->name('guide');
Route::view('/blog', 'pages.blog')->name('blog');
Route::get('/blog/{slug}', fn (string $slug) => view('pages.post', [
    'post' => ContentRepository::post($slug) ?? abort(404),
]))->name('post');
Route::view('/faq', 'pages.faq')->name('faq');
Route::view('/contact', 'pages.contact')->name('contact');
Route::post('/enquiries', [EnquiryController::class, 'store'])->middleware('throttle:8,1')->name('enquiries.store');
Route::post('/contact-messages', [ContactMessageController::class, 'store'])->middleware('throttle:8,1')->name('contact-messages.store');
Route::view('/terms', 'pages.legal', ['doc' => 'terms'])->name('terms');
Route::view('/privacy', 'pages.legal', ['doc' => 'privacy'])->name('privacy');

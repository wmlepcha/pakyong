<?php

use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', function () {
    $urls = collect(['home', 'destinations', 'guide', 'blog', 'faq', 'contact'])->map(fn ($r) => route($r))
        ->merge(collect(array_keys(config('destinations')))->map(fn ($s) => route('destination', $s)))
        ->merge(collect(config('blog.posts'))->map(fn ($p) => route('post', $p['slug'])));

    $lastmod = config('blog.published');
    $entries = $urls->map(fn ($u) => '<url><loc>'.e($u).'</loc><lastmod>'.$lastmod.'</lastmod></url>')->implode("\n");

    return response('<?xml version="1.0" encoding="UTF-8"?>'."\n".'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n".$entries."\n</urlset>\n", 200, ['Content-Type' => 'application/xml']);
});
Route::view('/', 'pages.home')->name('home');
Route::view('/destinations', 'pages.destinations')->name('destinations');
Route::get('/destinations/{slug}', fn (string $slug) => view('pages.destination', [
    'slug' => $slug,
    'd' => config("destinations.$slug") ?? abort(404),
]))->name('destination');
Route::view('/travel-guide', 'pages.guide')->name('guide');
Route::view('/blog', 'pages.blog')->name('blog');
Route::get('/blog/{slug}', fn (string $slug) => view('pages.post', [
    'post' => collect(config('blog.posts'))->firstWhere('slug', $slug) ?? abort(404),
]))->name('post');
Route::view('/faq', 'pages.faq')->name('faq');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/terms', 'pages.legal', ['doc' => 'terms'])->name('terms');
Route::view('/privacy', 'pages.legal', ['doc' => 'privacy'])->name('privacy');

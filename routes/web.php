<?php

use Illuminate\Support\Facades\Route;

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

@extends('layouts.app')
@section('title', $post['title'].' - '.config('site.brand'))
@section('og_type', 'article')
@section('og_image', url($post['img_url']))
@section('description', $post['excerpt'])
@php
    $published = $post['date'];
    $modified = $post['updated'] ?? $published;
@endphp
@push('head')
<script type="application/ld+json">{!! json_encode([
    '@@context' => 'https://schema.org', '@@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
        ['@@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => route('blog')],
        ['@@type' => 'ListItem', 'position' => 3, 'name' => $post['title'], 'item' => url()->current()],
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>
<script type="application/ld+json">{!! json_encode([
    '@@context' => 'https://schema.org', '@@type' => 'BlogPosting',
    'headline' => $post['title'], 'description' => $post['excerpt'],
    'image' => url($post['img_url']), 'mainEntityOfPage' => url()->current(),
    'datePublished' => $published, 'dateModified' => $modified,
    'author' => ['@@type' => 'Organization', 'name' => config('site.brand'), 'url' => url('/')],
    'publisher' => ['@@type' => 'Organization', 'name' => config('site.brand'), 'logo' => ['@@type' => 'ImageObject', 'url' => url('/apple-touch-icon.png')]],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>
@endpush
@section('content')
@php
    $others = \App\Support\ContentRepository::posts()->except($post['slug'])->take(3);
    $anchor = fn ($h) => \Illuminate\Support\Str::slug($h);
@endphp
<article class="px-5 sm:px-8 pt-2 sm:pt-8 pb-12 sm:pb-20">
    <a href="{{ route('blog') }}" class="inline-flex items-center gap-1 -ml-1 min-h-11 text-[15px] font-semibold text-royal"><x-glyph name="left" class="size-5"/> All posts</a>
    <p class="mt-2 sm:mt-8 text-[13px] sm:text-sm text-ink/60"><span class="font-semibold text-royal">{{ $post['cat'] }}</span> · {{ $post['mins'] }} min read</p>
    <p class="mt-1 text-[13px] sm:text-sm text-ink/60">By <a href="{{ route('home') }}" rel="author" class="font-semibold text-ink/80 underline underline-offset-2">{{ config('site.brand') }}</a> · Published <time datetime="{{ $published }}">{{ \Illuminate\Support\Carbon::parse($published)->format('j F Y') }}</time>@if ($modified !== $published) · Updated <time datetime="{{ $modified }}">{{ \Illuminate\Support\Carbon::parse($modified)->format('j F Y') }}</time>@endif</p>
    <h1 class="mt-2 sm:mt-3 font-display ios-title sm:text-6xl text-balance max-w-4xl">{{ $post['title'] }}</h1>
    <img src="{{ $post['img_url'] }}" @dims($post['img_url']) alt="{{ $post['img_alt'] ?? $post['title'] }}" class="mt-5 sm:mt-10 w-full aspect-[16/10] sm:aspect-[16/8] object-cover r-ios-lg" fetchpriority="high">

    <nav aria-label="In this story" class="lg:hidden ios-bar sticky top-20 z-30 -mx-5 sm:-mx-8 px-5 sm:px-8 py-2 mt-5">
        <ul class="flex gap-2 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
            @foreach ($post['sections'] as [$h])<li class="shrink-0"><a href="#{{ $anchor($h) }}" class="chip bg-mist text-ink/80 text-sm font-semibold">{{ $h }}</a></li>@endforeach
        </ul>
    </nav>

    <div class="mt-8 lg:mt-12 grid lg:grid-cols-[13rem_minmax(0,1fr)] gap-x-16 gap-y-8">
        <nav aria-label="In this story" class="hidden lg:block self-start sticky top-28">
            <p class="text-xs font-semibold text-ink/55 mb-3">In this story</p>
            <ul class="space-y-1 text-sm">
                @foreach ($post['sections'] as [$h])<li><a href="#{{ $anchor($h) }}" class="block py-1.5 text-ink/70 hover:text-royal">{{ $h }}</a></li>@endforeach
            </ul>
        </nav>
        <div class="max-w-2xl">
            <p class="font-display text-[1.125rem] sm:text-2xl leading-snug text-balance">{{ $post['intro'] }}</p>
            @foreach ($post['sections'] as [$h, $paras])
                <section id="{{ $anchor($h) }}" class="mt-10 sm:mt-12 scroll-mt-36 lg:scroll-mt-28">
                    <h2 class="font-display text-[1.375rem] sm:text-3xl text-balance">{{ $h }}</h2>
                    <div class="mt-4 space-y-4 text-[1.0625rem] sm:text-lg text-ink/80 leading-relaxed">@foreach ($paras as $para)<p>{{ $para }}</p>@endforeach</div>
                </section>
            @endforeach

            <aside class="mt-12 sm:mt-16 r-ios-lg bg-royal text-white p-5 sm:p-9">
                <h2 class="font-display text-[1.375rem] sm:text-2xl text-balance">Planning this trip?</h2>
                <p class="mt-2 text-white/80">Tell us your dates and we'll send a tailored itinerary within a day.</p>
                <button type="button" @click="pick('')" class="btn btn-light mt-5 max-sm:w-full">Plan my trip <x-glyph name="arrow" class="size-4 max-sm:hidden"/></button>
            </aside>
        </div>
    </div>
</article>

<section class="px-5 sm:px-8 pb-12 sm:pb-24">
    <h2 class="font-display text-[1.375rem] sm:text-[1.75rem]">Keep reading</h2>
    <div class="mt-5 sm:mt-8 -mx-5 px-5 flex gap-3 overflow-x-auto snap-x snap-mandatory scroll-px-5 pb-2 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden sm:mx-0 sm:px-0 sm:grid sm:grid-cols-2 lg:grid-cols-3 sm:gap-6 sm:overflow-visible">
        @foreach ($others as $p)
            <a href="{{ route('post', $p['slug']) }}" class="group block shrink-0 w-[72%] snap-start sm:w-auto">
                <span class="block overflow-hidden r-ios-lg"><img src="{{ $p['img_url'] }}" @dims($p['img_url']) alt="{{ $p['img_alt'] ?? '' }}" loading="lazy" class="w-full aspect-[4/3] object-cover group-hover:scale-105 transition duration-700"></span>
                <span class="mt-3 sm:mt-4 block text-[13px] sm:text-sm text-ink/60"><span class="font-semibold text-royal">{{ $p['cat'] }}</span> · {{ $p['mins'] }} min read</span>
                <span class="mt-1.5 sm:mt-2 block font-display text-lg sm:text-xl leading-snug text-balance group-hover:text-royal transition-colors">{{ $p['title'] }}</span>
            </a>
        @endforeach
    </div>
</section>
@endsection

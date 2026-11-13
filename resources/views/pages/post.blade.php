@extends('layouts.app')
@section('title', $post['title'].' – '.config('site.brand'))
@section('content')
@php
    $others = collect(config('blog.posts'))->where('slug', '!=', $post['slug'])->take(3);
    $anchor = fn ($h) => \Illuminate\Support\Str::slug($h);
@endphp
<article class="px-5 sm:px-8 pt-8 pb-20">
    <a href="{{ route('blog') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-ink/70 hover:text-royal"><x-icon name="left" class="size-4"/> All posts</a>
    <p class="mt-5 sm:mt-8 text-sm text-ink/60"><span class="font-semibold text-royal">{{ $post['cat'] }}</span> · {{ $post['mins'] }} min read · By the {{ config('site.brand') }} team</p>
    <h1 class="mt-3 font-display font-bold text-[2rem] sm:text-6xl leading-[1.1] text-balance max-w-4xl">{{ $post['title'] }}</h1>
    <img src="/images/{{ $post['img'] }}" alt="" class="mt-6 sm:mt-10 w-full aspect-[4/3] sm:aspect-[16/8] object-cover rounded-3xl sm:rounded-[2rem]" fetchpriority="high">

    <div class="mt-12 grid lg:grid-cols-[13rem_minmax(0,1fr)] gap-x-16 gap-y-8">
        <nav aria-label="In this story" class="hidden lg:block self-start sticky top-28">
            <p class="text-xs font-semibold text-ink/55 mb-3">In this story</p>
            <ul class="space-y-1 text-sm">
                @foreach ($post['sections'] as [$h])<li><a href="#{{ $anchor($h) }}" class="block py-1.5 text-ink/70 hover:text-royal">{{ $h }}</a></li>@endforeach
            </ul>
        </nav>
        <div class="max-w-2xl">
            <p class="font-display text-xl sm:text-2xl leading-snug text-balance">{{ $post['intro'] }}</p>
            @foreach ($post['sections'] as [$h, $paras])
                <section id="{{ $anchor($h) }}" class="mt-12 scroll-mt-28">
                    <h2 class="font-display font-bold text-2xl sm:text-3xl text-balance">{{ $h }}</h2>
                    <div class="mt-4 space-y-4 text-lg text-ink/80 leading-relaxed">@foreach ($paras as $para)<p>{{ $para }}</p>@endforeach</div>
                </section>
            @endforeach

            <aside class="mt-16 rounded-3xl bg-royal text-white p-5 sm:p-9">
                <h2 class="font-display font-bold text-2xl text-balance">Planning this trip?</h2>
                <p class="mt-2 text-white/80">Tell us your dates and we'll send a tailored itinerary within a day.</p>
                <button type="button" @click="pick('')" class="mt-5 inline-flex items-center gap-3 rounded-full bg-white text-ink font-semibold pl-6 pr-5 py-3.5 hover:bg-mist transition-colors">Plan my trip <x-icon name="arrow" class="size-4"/></button>
            </aside>
        </div>
    </div>
</article>

<section class="px-5 sm:px-8 pb-16 sm:pb-24">
    <h2 class="font-display font-bold text-3xl">Keep reading</h2>
    <div class="mt-8 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($others as $p)
            <a href="{{ route('post', $p['slug']) }}" class="group block">
                <span class="block overflow-hidden rounded-3xl"><img src="/images/{{ $p['img'] }}" alt="" loading="lazy" class="w-full aspect-[4/3] object-cover group-hover:scale-105 transition duration-700"></span>
                <span class="mt-4 block text-sm text-ink/60"><span class="font-semibold text-royal">{{ $p['cat'] }}</span> · {{ $p['mins'] }} min read</span>
                <span class="mt-2 block font-display font-bold text-xl leading-snug text-balance group-hover:text-royal transition-colors">{{ $p['title'] }}</span>
            </a>
        @endforeach
    </div>
</section>
@endsection

@extends('layouts.app')
@section('title', 'Blog – '.config('site.brand'))
@section('content')
@php
    $posts = config('blog.posts');
    $cats = config('blog.categories');
    $chip = 'rounded-full px-4 py-2 text-sm font-semibold whitespace-nowrap transition-colors';
@endphp
<section class="px-5 sm:px-8 pt-4 sm:pt-10 pb-16 sm:pb-24" x-data="{ cat: 'All' }">
    <h1 class="font-display font-bold text-[2rem] leading-[1.1] sm:text-6xl text-balance max-w-3xl">Stories and guides from the hills</h1>
    <p class="mt-2 sm:mt-5 text-base sm:text-lg text-ink/70 max-w-2xl">Practical advice and first-hand notes for planning a trip to Sikkim, written by the team that runs the tours.</p>

    <div role="tablist" aria-label="Category" class="mt-10 flex gap-2 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden pb-1">
        @foreach (array_merge(['All'], $cats) as $c)
            <button role="tab" type="button" @click="cat = '{{ $c }}'" :aria-selected="cat === '{{ $c }}'" class="{{ $chip }}"
                    :class="cat === '{{ $c }}' ? 'bg-ink text-white' : 'bg-mist text-ink/75 hover:text-ink'">{{ $c }}</button>
        @endforeach
    </div>

    {{-- Featured: only on All --}}
    @php $f = $posts[0]; @endphp
    <a x-show="cat === 'All'" href="{{ route('post', $f['slug']) }}" class="group mt-6 sm:mt-8 grid lg:grid-cols-[1.25fr_1fr] gap-0 bg-white rounded-[2rem] border border-ink/5 overflow-hidden hover:shadow-xl transition-shadow">
        <span class="block overflow-hidden"><img src="/images/{{ $f['img'] }}" alt="" fetchpriority="high" class="size-full min-h-72 max-h-[26rem] lg:max-h-none object-cover group-hover:scale-105 transition duration-700"></span>
        <span class="flex flex-col justify-center p-5 sm:p-12">
            <span class="text-sm text-royal font-semibold">{{ $f['cat'] }} · {{ $f['mins'] }} min read</span>
            <span class="mt-3 font-display font-bold text-3xl sm:text-4xl leading-tight text-balance group-hover:text-royal transition-colors">{{ $f['title'] }}</span>
            <span class="mt-4 text-ink/70">{{ $f['intro'] }}</span>
            <span class="mt-6 inline-flex items-center gap-2 font-semibold">Read the story <x-icon name="arrow" class="size-4 group-hover:translate-x-1 transition-transform"/></span>
        </span>
    </a>

    <div class="mt-8 sm:mt-12 grid sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-5 sm:gap-y-12">
        @foreach ($posts as $i => $p)
            <a href="{{ route('post', $p['slug']) }}" class="group flex items-center gap-4 sm:block" x-show="cat === 'All' ? {{ $i }} > 0 : cat === '{{ $p['cat'] }}'" @if ($i === 0) x-cloak @endif>
                <span class="block shrink-0 overflow-hidden rounded-2xl sm:rounded-3xl size-24 sm:size-auto sm:w-full"><img src="/images/{{ $p['img'] }}" alt="" loading="lazy" class="size-full sm:size-auto sm:w-full sm:aspect-[4/3] object-cover group-hover:scale-105 transition duration-700"></span>
                <span class="min-w-0 sm:block">
                    <span class="block text-xs sm:text-sm text-ink/60 sm:mt-4"><span class="font-semibold text-royal">{{ $p['cat'] }}</span> · {{ $p['mins'] }} min read</span>
                    <span class="mt-1 sm:mt-2 block font-display font-bold text-base sm:text-xl leading-snug text-balance group-hover:text-royal transition-colors">{{ $p['title'] }}</span>
                    <span class="hidden sm:block mt-2 text-sm text-ink/70">{{ $p['excerpt'] }}</span>
                </span>
            </a>
        @endforeach
    </div>
</section>
@include('partials.cta')
@endsection

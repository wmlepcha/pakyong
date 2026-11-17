@extends('layouts.app')
@section('title', 'Sikkim travel blog and guides - '.config('site.brand'))
@section('description', 'Sikkim travel articles on permits, altitude, winter trips, food and itineraries, written by a local team in Sikkim.')
@section('content')
@php
    $posts = config('blog.posts');
    $cats = config('blog.categories');
    $chip = 'chip rounded-full px-4 py-2 text-sm font-semibold whitespace-nowrap transition-colors';
@endphp
<section class="px-5 sm:px-8 pt-4 sm:pt-10 pb-12 sm:pb-24" x-data="{ cat: 'All' }">
    <h1 class="font-display ios-title sm:text-6xl text-balance max-w-3xl">Stories and guides from the hills</h1>
    <p class="mt-2 sm:mt-5 text-base sm:text-lg text-ink/70 max-w-2xl">Practical advice and first-hand notes for planning a trip to Sikkim, written by the team that runs the tours.</p>

    <div role="tablist" aria-label="Category" class="ios-bar sticky top-20 z-30 mt-5 sm:mt-10 -mx-5 sm:-mx-8 px-5 sm:px-8 py-2 lg:static lg:mx-0 lg:px-0 lg:py-0 lg:pb-1 flex gap-2 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
        @foreach (array_merge(['All'], $cats) as $c)
            <button role="tab" type="button" @click="cat = '{{ $c }}'" :aria-selected="cat === '{{ $c }}'" class="{{ $chip }}"
                    :class="cat === '{{ $c }}' ? 'bg-ink text-white' : 'bg-mist text-ink/75 hover:text-ink'">{{ $c }}</button>
        @endforeach
    </div>

    {{-- Featured: only on All --}}
    @php $f = $posts[0]; @endphp
    <a x-show="cat === 'All'" href="{{ route('post', $f['slug']) }}" x-transition.opacity.duration.200ms class="group mt-4 sm:mt-8 grid lg:grid-cols-[1.25fr_1fr] gap-0 bg-white border border-ink/10 r-ios-lg overflow-hidden lg:hover:shadow-xl transition-shadow">
        <span class="block overflow-hidden"><img src="/images/{{ $f['img'] }}" @dims('/images/'.$f['img']) alt="" fetchpriority="high" class="size-full aspect-[16/10] lg:aspect-auto lg:min-h-72 object-cover lg:group-hover:scale-105 transition duration-700"></span>
        <span class="flex flex-col justify-center p-4 sm:p-12">
            <span class="text-sm text-royal font-semibold">{{ $f['cat'] }} · {{ $f['mins'] }} min read</span>
            <time datetime="{{ $f['date'] }}" class="mt-1 text-[13px] sm:text-sm text-ink/60">{{ \Illuminate\Support\Carbon::parse($f['date'])->format('j F Y') }}</time>
            <span class="mt-2 sm:mt-3 font-display text-[1.375rem] sm:text-4xl leading-tight text-balance group-hover:text-royal transition-colors">{{ $f['title'] }}</span>
            <span class="mt-3 sm:mt-4 text-[15px] sm:text-base text-ink/70">{{ $f['intro'] }}</span>
            <span class="mt-6 inline-flex items-center gap-2 font-semibold">Read the story <x-icon name="arrow" class="size-4 group-hover:translate-x-1 transition-transform"/></span>
        </span>
    </a>

    <div class="mt-6 sm:mt-12 ios-group-sm grid sm:grid-cols-2 lg:grid-cols-3 gap-x-6 sm:gap-y-12">
        @foreach ($posts as $i => $p)
            <a href="{{ route('post', $p['slug']) }}" x-transition.opacity.duration.200ms class="group ios-row-sm flex items-center gap-4 sm:block sm:p-0" x-show="cat === 'All' ? {{ $i }} > 0 : cat === '{{ $p['cat'] }}'" @if ($i === 0) x-cloak @endif>
                <span class="block shrink-0 overflow-hidden r-ios size-20 sm:size-auto sm:w-full"><img src="/images/{{ $p['img'] }}" @dims('/images/'.$p['img']) alt="" loading="lazy" class="size-full sm:size-auto sm:w-full sm:aspect-[4/3] object-cover lg:group-hover:scale-105 transition duration-700"></span>
                <span class="min-w-0 sm:block">
                    <span class="block text-xs sm:text-sm text-ink/60 sm:mt-4"><span class="font-semibold text-royal">{{ $p['cat'] }}</span> · {{ $p['mins'] }} min read · <time datetime="{{ $p['date'] }}">{{ \Illuminate\Support\Carbon::parse($p['date'])->format('j M Y') }}</time></span>
                    <span class="mt-1 sm:mt-2 block font-display text-[15px] sm:text-xl leading-snug text-balance group-hover:text-royal transition-colors">{{ $p['title'] }}</span>
                    <span class="hidden sm:block mt-2 text-sm text-ink/70">{{ $p['excerpt'] }}</span>
                </span>
            </a>
        @endforeach
    </div>
    <p x-cloak x-show="cat !== 'All' && !@json(array_column($posts, 'cat')).includes(cat)" class="mt-8 text-center text-ink/60">No stories in this category yet.</p>
</section>
@include('partials.cta')
@endsection

@extends('layouts.app')
@section('title', 'Sikkim, Darjeeling and Kalimpong destinations - '.config('site.brand'))
@section('description', 'Explore Sikkim, Darjeeling and Kalimpong: best time to visit, places to see, how to get there and sample day plans.')
@section('content')
@php
    $items = \App\Support\ContentRepository::destinations()->values()->map(fn ($d) => $d + ['group' => $d['region'] ?? 'Sikkim']);
    $groups = $items->pluck('group')->unique()->values();
    $chip = 'chip rounded-full px-4 py-2 text-sm font-semibold whitespace-nowrap transition-colors';
@endphp
<section class="px-5 sm:px-8 pt-4 sm:pt-10 pb-6 md:pb-10" x-data="{ g: 'All' }">
    <h1 class="font-display ios-title sm:text-6xl">Destinations</h1>
    <p class="mt-2 sm:mt-5 text-base sm:text-lg text-ink/70 max-w-xl">Sikkim, Darjeeling and Kalimpong. Pick a place to start planning.</p>

    <div role="tablist" aria-label="Region" class="ios-bar sticky top-20 z-30 mt-5 sm:mt-8 -mx-5 sm:-mx-8 px-5 sm:px-8 py-2 lg:static lg:mx-0 lg:px-0 lg:py-0 flex gap-2 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
        @foreach ($groups->prepend('All') as $c)
            <button role="tab" type="button" @click="g = '{{ $c }}'" :aria-selected="g === '{{ $c }}'" class="{{ $chip }}"
                    :class="g === '{{ $c }}' ? 'bg-ink text-white' : 'bg-mist text-ink/75 hover:text-ink'">{{ $c }}</button>
        @endforeach
    </div>

    {{-- Phones and tablets: compact cards --}}
    <ul class="md:hidden mt-4 grid grid-cols-[minmax(0,1fr)] sm:grid-cols-2 gap-4">
        @foreach ($items as $it)
            <li x-show="g === 'All' || g === '{{ $it['group'] }}'">
                <a href="{{ route('destination', $it['slug']) }}" class="block ios-group active:bg-mist transition-colors">
                    <span class="relative block aspect-[16/10] overflow-hidden bg-mist">
                        <img src="{{ $it['img_url'] }}" @dims($it['img_url']) alt="{{ $it['name'] }}" @if ($loop->first) fetchpriority="high" @else loading="lazy" @endif class="absolute inset-0 size-full object-cover">
                    </span>
                    <span class="ios-row flex items-center justify-between gap-3">
                        <span class="min-w-0">
                            <span class="block font-display text-xl leading-tight">{{ $it['name'] }}</span>
                            <span class="block mt-0.5 text-[13px] text-ink/60 truncate">{{ $it['days'] }} · High point {{ $it['high'] }}</span>
                        </span>
                        <span class="flex items-center gap-2 shrink-0 text-ink/40">
                            <x-glyph name="right" class="size-5"/>
                        </span>
                    </span>
                </a>
            </li>
        @endforeach
    </ul>

    {{-- Desktop --}}
    <div class="hidden md:grid mt-10 lg:grid-cols-3 gap-5">
        @foreach ($items as $it)
            <a x-show="g === 'All' || g === '{{ $it['group'] }}'" href="{{ route('destination', $it['slug']) }}" class="group block text-left bg-white p-2 border border-ink/10 hover:shadow-lg transition">
                <span class="block overflow-hidden"><img src="{{ $it['img_url'] }}" @dims($it['img_url']) alt="{{ $it['name'] }}" loading="lazy" class="h-48 w-full object-cover group-hover:scale-105 transition duration-500"></span>
                <span class="block px-3 pt-4 pb-3">
                    <span class="block font-display text-lg">{{ $it['name'] }}</span>
                    <span class="block text-sm text-ink/60 mt-1">{{ $it['places_line'] ?: $it['tagline'] }}</span>
                </span>
            </a>
        @endforeach
    </div>
</section>

@include('partials.why')
@include('partials.cta')
@endsection

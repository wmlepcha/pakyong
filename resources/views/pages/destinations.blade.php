@extends('layouts.app')
@section('title', 'Destinations - '.config('site.brand'))
@section('description', 'Explore East, North, West and South Sikkim: best time to visit, places to see, permits, how to get there and sample day plans.')
@section('content')
@php
    $regions = config('guide.regions');
    $prices = collect(config('site.destinations'))->mapWithKeys(fn ($d) => [$d[0] => $d[3]]);
    $slug = fn ($n) => \Illuminate\Support\Str::slug($n);
@endphp
<section class="px-5 sm:px-8 pt-4 pb-6 md:pb-10 sm:pt-10">
    <h1 class="font-display font-bold text-[2rem] leading-[1.1] sm:text-6xl">Destinations</h1>
    <p class="mt-2 sm:mt-5 text-base sm:text-lg text-ink/70 max-w-xl">Four regions, four very different Sikkims. Pick one to start planning.</p>
    <div class="hidden md:block mt-10">@include('partials.destinations')</div>
</section>

{{-- ============ Phone app layout: one full guide card per region ============ --}}
<div class="md:hidden" x-data="{ active: '{{ $slug($regions[0]['name']) }}' }"
     x-init="const io = new IntersectionObserver(es => es.forEach(e => { if (e.isIntersecting) active = e.target.id }), { rootMargin: '-20% 0px -70% 0px' });
             $root.querySelectorAll('[data-region]').forEach(el => io.observe(el));
             $watch('active', () => { const c = $refs.chips, el = c.querySelector('[aria-current]'); if (el) c.scrollTo({ left: el.offsetLeft - 20, behavior: 'smooth' }) })">
    <nav aria-label="Regions" class="sticky top-20 z-30 bg-paper py-3">
        <ul x-ref="chips" class="flex gap-2 overflow-x-auto px-5 sm:px-8 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
            @foreach ($regions as $rg)
                <li class="shrink-0"><a href="#{{ $slug($rg['name']) }}" :aria-current="active === '{{ $slug($rg['name']) }}' ? 'true' : null"
                       :class="active === '{{ $slug($rg['name']) }}' ? 'bg-ink text-white' : 'bg-mist text-ink/75'"
                       class="block rounded-full px-4 py-2 text-sm font-semibold whitespace-nowrap transition-colors">{{ \Illuminate\Support\Str::before($rg['name'], ' ') }}</a></li>
            @endforeach
        </ul>
    </nav>

    <div class="px-5 sm:px-8 space-y-14 pt-3 pb-4">
        @foreach ($regions as $rg)
            <article id="{{ $slug($rg['name']) }}" data-region class="scroll-mt-40 sm:grid sm:grid-cols-[1fr_1.1fr] sm:gap-6 sm:items-stretch">
                <div class="relative aspect-[4/5] sm:aspect-auto sm:h-full sm:min-h-[26rem] rounded-[2rem] overflow-hidden bg-mist">
                    <img src="/images/{{ $rg['img'] }}" @dims('/images/'.$rg['img']) alt="{{ $rg['name'] }}" @if ($loop->first) fetchpriority="high" @else loading="lazy" @endif class="absolute inset-0 size-full object-cover">
                    <span class="absolute inset-0 bg-gradient-to-t from-ink/90 via-ink/30 to-transparent"></span>
                    <a href="{{ route('destination', $slug($rg['name'])) }}" class="absolute inset-0 z-10" aria-label="Explore {{ $rg['name'] }}"></a>
                    <div class="absolute inset-x-0 bottom-0 p-5 text-white">
                        <h2 class="font-display font-bold text-3xl">{{ $rg['name'] }}</h2>
                        <p class="mt-1 text-sm text-white/85">Base: {{ $rg['base'] }}</p>
                        @if ($prices->has($rg['name']))<span class="mt-3 inline-block rounded-full bg-white text-ink px-3 py-1.5 text-xs font-semibold">from {{ $prices[$rg['name']] }}</span>@endif
                    </div>
                </div>

                <div>
                <dl class="mt-4 sm:mt-0 grid grid-cols-2 divide-x divide-ink/10 rounded-2xl bg-white border border-ink/5 text-sm">
                    <div class="px-4 py-3"><dt class="text-xs text-ink/55">Plan</dt><dd class="font-semibold mt-0.5">{{ $rg['days'] }}</dd></div>
                    <div class="px-4 py-3"><dt class="text-xs text-ink/55">High point</dt><dd class="font-semibold mt-0.5">{{ $rg['high'] }}</dd></div>
                </dl>

                <p class="mt-4 text-ink/75 leading-relaxed">{{ $rg['about'] }}</p>

                <p class="mt-5 text-xs font-semibold text-ink/55 px-1">Highlights</p>
                <ul class="mt-2 rounded-2xl bg-white border border-ink/5 divide-y divide-ink/10 overflow-hidden">
                    @foreach (array_slice($rg['highlights'], 0, 4) as $pt)
                        <li class="flex items-center gap-3 px-4 py-3.5 text-sm"><span class="size-1.5 rounded-full bg-royal shrink-0"></span>{{ $pt }}</li>
                    @endforeach
                </ul>

                <div class="mt-5 grid grid-cols-2 gap-2.5">
                    <button type="button" @click="pick('{{ $rg['name'] }}')" class="w-full rounded-full bg-royal text-white text-sm font-semibold py-3.5 px-3 whitespace-nowrap">Plan this trip</button>
                    <a href="{{ route('destination', $slug($rg['name'])) }}" class="w-full inline-flex items-center justify-center gap-1.5 rounded-full bg-mist text-ink text-sm font-semibold py-3.5 px-3 whitespace-nowrap">Explore {{ $rg['short'] ?? \Illuminate\Support\Str::before($rg['name'], ' ') }} <x-icon name="arrow" class="size-4"/></a>
                </div>
                </div>
            </article>
        @endforeach
    </div>
</div>

@include('partials.why')
@include('partials.cta')
@endsection

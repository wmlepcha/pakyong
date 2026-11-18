@extends('layouts.app')
@push('head')
<script type="application/ld+json">{!! json_encode([
    '@@context' => 'https://schema.org', '@@type' => 'ItemList',
    'itemListElement' => \App\Support\ContentRepository::packages()->values()->map(fn ($p, $i) => [
        '@@type' => 'ListItem', 'position' => $i + 1,
        'item' => ['@@type' => 'TouristTrip', 'name' => $p['title'], 'description' => implode('. ', $p['bullets']).'.', 'image' => url($p['img_url'] ?? '/images/all-sikkim.webp'), 'touristType' => 'Leisure'],
    ])->all(),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>
@endpush
@section('content')
@php
    $wa = preg_replace('/\D/', '', config('site.phone'));
    $home = \App\Support\ContentRepository::home();
    $tiles = \App\Support\ContentRepository::homeTiles();
@endphp

{{-- Hero: one full-bleed photograph, text on the left --}}
<section class="bleed relative isolate min-h-[30rem] md:min-h-[40rem] flex items-center overflow-hidden bg-ink">
    <img src="{{ $home['hero_url'] }}" @dims($home['hero_url']) alt="{{ $home['hero_alt'] }}" fetchpriority="high" class="absolute inset-0 -z-10 size-full object-cover">
    <span class="absolute inset-0 -z-10 bg-gradient-to-r from-ink/85 via-ink/45 to-ink/5"></span>
    <div class="mx-auto w-full max-w-[1240px] px-5 sm:px-8 py-14 sm:py-20 text-paper">
        <p class="kicker text-paper/80">Your journey begins in the Eastern Himalayas</p>
        <h1 class="mt-5 font-display text-[2.25rem] sm:text-6xl xl:text-7xl leading-[1.08] max-w-3xl text-balance">Sikkim, planned by people who live here.</h1>
        <p class="mt-5 sm:mt-6 max-w-lg text-base sm:text-lg text-paper/85">Monasteries, mountain passes and misty tea gardens. Permits, drivers and stays sorted by our team in Sikkim.</p>
        <div class="mt-7 sm:mt-9 flex flex-wrap gap-2 sm:gap-3">
            <a href="{{ route('destinations') }}" class="btn btn-light max-sm:flex-1 max-sm:!px-3 max-sm:!py-3.5 max-sm:!gap-2 max-sm:!text-[10px] max-sm:!tracking-[.1em]">Explore Sikkim</a>
            <button type="button" @click="pick('')" class="btn btn-line max-sm:flex-1 max-sm:!px-3 max-sm:!py-3.5 max-sm:!gap-2 max-sm:!text-[10px] max-sm:!tracking-[.1em]">Plan a custom trip</button>
        </div>
    </div>
</section>

{{-- Trust strip --}}
<section class="bleed bg-mist">
    <dl class="mx-auto max-w-[1240px] px-5 sm:px-8 py-8 grid grid-cols-2 lg:grid-cols-4 gap-y-8 lg:divide-x divide-ink/15">
        @foreach (config('site.why') as [$t, $d])
            <div class="lg:px-8 first:lg:pl-0 text-center lg:text-left"><dt class="font-display text-xl text-royal">{{ $t }}</dt><dd class="mt-1.5 text-sm text-ink/65 max-w-[16rem] mx-auto lg:mx-0">{{ $d }}</dd></div>
        @endforeach
    </dl>
</section>

{{-- Four directions: exactly four tiles, North tall, South wide --}}
<section class="px-5 sm:px-8 pt-12 sm:pt-24">
    <div class="text-center max-w-2xl mx-auto">
        <h2 class="font-display text-[1.75rem] sm:text-5xl text-royal text-balance leading-tight">Four directions. Countless ways to feel alive.</h2>
        <p class="mt-4 text-ink/65">From high-altitude lakes to quiet village stays, discover the side of Sikkim that speaks to you.</p>
    </div>
    <div class="mt-10 sm:mt-14 grid grid-cols-2 lg:grid-cols-3 lg:grid-rows-2 gap-3 sm:gap-4 lg:h-[44rem]">
        @foreach ($tiles as $i => $t)
            <a href="{{ route('destination', $t['slug']) }}" class="group relative isolate overflow-hidden bg-ink {{ ['col-span-2 lg:col-span-1 lg:row-span-2 aspect-[4/3] lg:aspect-auto', 'aspect-[4/5] lg:aspect-auto', 'aspect-[4/5] lg:aspect-auto', 'col-span-2 aspect-[16/9] lg:aspect-auto'][$i] ?? 'aspect-[4/5]' }}">
                <img src="{{ $t['img_url'] }}" @dims($t['img_url']) alt="{{ $t['name'] }}" loading="lazy" class="absolute inset-0 -z-10 size-full object-cover transition-transform duration-700 ease-out group-hover:scale-105">
                <span class="absolute inset-0 -z-10 bg-gradient-to-t from-ink/85 via-ink/15 to-transparent"></span>
                <span class="absolute inset-x-0 bottom-0 p-5 sm:p-7 text-paper">
                    <span class="block font-display text-2xl sm:text-3xl">{{ $t['name'] }}</span>
                    <span class="block mt-1.5 text-sm text-paper/80">{{ $t['places_line'] }}</span>
                </span>
            </a>
        @endforeach
    </div>
</section>

{{-- A sense of place --}}
<section class="bleed bg-mist mt-12 sm:mt-24">
    <div class="mx-auto max-w-[1240px] px-5 sm:px-8 py-14 sm:py-20 grid lg:grid-cols-[1fr_1fr] gap-10 lg:gap-20 items-center">
        <img src="{{ $home['place_url'] }}" @dims($home['place_url']) alt="{{ $home['place_alt'] }}" loading="lazy" class="w-full aspect-[4/3] object-cover">
        <div>
            <h2 class="font-display text-[1.75rem] sm:text-5xl text-royal leading-tight">Travel with a sense of place.</h2>
            <p class="mt-6 text-ink/70 max-w-md">The best journeys are not rushed. They leave room for a quiet viewpoint, a conversation with a local, a warm cup of tea and the unexpected moments that become your favourite memories.</p>
            <p class="mt-4 text-ink/70 max-w-md">Our drivers and guides were born in Sikkim. They know which monastery is quiet at prayer time and which road is closed after rain.</p>
            <a href="{{ route('guide') }}" class="btn btn-solid mt-8">Read the travel guide</a>
        </div>
    </div>
</section>

{{-- Packages --}}
<section class="px-5 sm:px-8 pt-12 sm:pt-20" x-data="{ start: true, end: false,
        move(d) { const t = this.$refs.track; const c = t.firstElementChild; t.scrollBy({ left: d * (c.offsetWidth + parseFloat(getComputedStyle(t).columnGap)), behavior: 'smooth' }); },
        sync() { const t = this.$refs.track; this.start = t.scrollLeft < 8; this.end = t.scrollLeft + t.clientWidth >= t.scrollWidth - 8; } }" x-init="sync()">
    <div class="flex items-end justify-between gap-6">
        <h2 class="font-display text-[1.75rem] sm:text-4xl max-w-2xl text-balance text-royal">Handpicked trips, ready to customise</h2>
        <div class="flex gap-2 shrink-0">
            <button type="button" @click="move(-1)" :disabled="start" aria-label="Previous trips" class="grid place-items-center size-12 border border-royal/40 text-royal hover:bg-royal hover:text-white transition-colors disabled:opacity-30 disabled:pointer-events-none"><x-glyph name="left"/></button>
            <button type="button" @click="move(1)" :disabled="end" aria-label="Next trips" class="grid place-items-center size-12 border border-royal/40 text-royal hover:bg-royal hover:text-white transition-colors disabled:opacity-30 disabled:pointer-events-none"><x-glyph name="right"/></button>
        </div>
    </div>
    <div x-ref="track" @scroll.passive="sync()" class="mt-8 flex gap-6 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-2 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
        @foreach (\App\Support\ContentRepository::packages() as $pk)
            @php [$name, $dur, $img, $points] = [$pk['title'], $pk['duration'], $pk['img_url'], $pk['bullets']]; @endphp
            <article class="snap-start shrink-0 w-[85%] sm:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)] bg-white overflow-hidden border border-ink/10 flex flex-col">
                <div class="relative">
                    <img src="{{ $img }}" @dims($img) alt="{{ $name }}" loading="lazy" class="h-56 w-full object-cover">
                    <span class="absolute top-0 left-0 bg-royal text-white text-[11px] tracking-[.14em] uppercase px-3 py-2">{{ $dur }}</span>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <h3 class="font-display text-xl">{{ $name }}</h3>
                    <ul class="mt-3 space-y-1.5 text-sm text-ink/70">
                        @foreach ($points as $pt)<li class="flex items-center gap-3"><span class="h-px w-4 bg-royal shrink-0"></span>{{ $pt }}</li>@endforeach
                    </ul>
                    <div class="mt-auto pt-6">
                        <button @click="pick('{{ $name }}', true)" class="btn btn-solid !px-4 !py-2.5">Enquire</button>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</section>


{{-- Experiences: pills and one photo card on small screens, photo and hover list on desktop --}}
@php $exp = \App\Support\ContentRepository::experiences()->map(fn ($e) => [$e['title'], $e['description'], $e['img_url']])->values()->all(); @endphp
<section class="px-5 sm:px-8 pt-12 sm:pt-24" x-data="{ a: 0, tx: 0, n: {{ count($exp) }},
        go(k) { this.a = (k + this.n) % this.n; $nextTick(() => this.$refs.pills?.children[this.a]?.scrollIntoView({ inline: 'center', block: 'nearest', behavior: 'smooth' })); },
        start(e) { this.tx = e.touches[0].clientX; }, end(e) { const d = e.changedTouches[0].clientX - this.tx; if (Math.abs(d) > 40) this.go(this.a + (d < 0 ? 1 : -1)); } }">
    {{-- Small screens --}}
    <div class="md:hidden">
        <p class="font-display text-[1.75rem] text-royal text-balance leading-tight">Experiences to add to your trip</p>
        <p class="mt-3 text-ink/65">Add something unforgettable to any itinerary.</p>
        <div x-ref="pills" role="tablist" aria-label="Experiences" class="mt-6 -mx-5 px-5 flex gap-2 overflow-x-auto snap-x scroll-px-5 pb-1 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
            @foreach ($exp as $k => [$t])
                <button type="button" role="tab" @click="go({{ $k }})" :aria-selected="a === {{ $k }}" class="snap-start shrink-0 px-4 py-2.5 text-sm font-medium border transition-colors" :class="a === {{ $k }} ? 'bg-royal border-royal text-white' : 'bg-white border-ink/25 text-ink/75'">{{ $t }}</button>
            @endforeach
        </div>
        <div class="relative isolate mt-4 aspect-[4/5] overflow-hidden bg-ink text-paper" @touchstart.passive="start($event)" @touchend.passive="end($event)">
            @foreach ($exp as $k => [$t, $d, $img])
                <img src="{{ $img }}" @dims($img) alt="" loading="lazy" class="absolute inset-0 -z-10 size-full object-cover transition-all duration-700 ease-out" :class="a === {{ $k }} ? 'opacity-100 scale-100' : 'opacity-0 scale-105'">
            @endforeach
            <span class="absolute inset-0 -z-10 bg-gradient-to-t from-ink/90 via-ink/25 to-transparent"></span>
            <div class="absolute inset-x-0 bottom-0 p-5">
                @foreach ($exp as $k => [$t, $d])
                    <div x-show="a === {{ $k }}" x-transition.opacity.duration.300ms @if ($k) x-cloak @endif>
                        <h3 class="font-display text-2xl">{{ $t }}</h3>
                        <p class="mt-1.5 text-sm text-paper/85 max-w-xs">{{ $d }}</p>
                    </div>
                @endforeach
                <div class="mt-4 flex items-center justify-between gap-3">
                    <button type="button" @click="pick('')" class="btn btn-light">Add to my trip</button>
                    <p class="text-xs text-paper/70 tabular-nums" x-text="(a + 1) + ' / ' + n" aria-hidden="true"></p>
                </div>
            </div>
        </div>
    </div>

    {{-- Desktop --}}
    <div class="max-md:hidden grid lg:grid-cols-2 gap-10 lg:gap-16 items-center">
        <div class="relative aspect-[4/3] lg:aspect-[4/4.4] overflow-hidden bg-mist">
            @foreach ($exp as $k => [$t, $d, $img])
                <img src="{{ $img }}" @dims($img) alt="{{ $t }}" loading="lazy" class="absolute inset-0 size-full object-cover transition-all duration-700 ease-out" :class="a === {{ $k }} ? 'opacity-100 scale-100' : 'opacity-0 scale-105'">
            @endforeach
        </div>
        <div>
            <h2 class="font-display text-[1.75rem] sm:text-5xl text-royal text-balance leading-tight">Experiences to add to your trip</h2>
            <p class="mt-4 text-ink/65 max-w-sm">Add something unforgettable to any itinerary.</p>
            <ul class="mt-8 border-t border-ink/15">
                @foreach ($exp as $k => [$t, $d])
                    <li class="border-b border-ink/15">
                        <button type="button" @mouseenter="a = {{ $k }}" @focus="a = {{ $k }}" @click="a = {{ $k }}" class="w-full text-left py-5 flex items-start justify-between gap-4 group" :aria-expanded="a === {{ $k }}">
                            <span>
                                <span class="block font-display text-2xl transition-colors" :class="a === {{ $k }} ? 'text-royal' : 'text-ink/55 group-hover:text-ink'">{{ $t }}</span>
                                <span class="grid transition-all duration-500 ease-out" :class="a === {{ $k }} ? 'grid-rows-[1fr] opacity-100 mt-2' : 'grid-rows-[0fr] opacity-0'"><span class="overflow-hidden text-ink/70">{{ $d }}</span></span>
                            </span>
                            <x-glyph name="arrow" class="mt-2 size-4 shrink-0 transition-colors" ::class="a === {{ $k }} ? 'text-royal' : 'text-ink/30'"/>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

{{-- When to go: swipeable cards on small screens, four cards on desktop. Each season has its own colour and weather. --}}
@php $seasons = config('site.seasons'); @endphp
<section class="px-5 sm:px-8 pt-12 sm:pt-24">
    <h2 class="font-display text-[1.75rem] sm:text-5xl text-royal">When to go</h2>

    <div class="md:hidden mt-6 -mx-5 px-5 flex gap-3 overflow-x-auto snap-x snap-mandatory scroll-px-5 pb-2 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
        @foreach ($seasons as [$months, $name, $d, $bg, $bd])
            <article class="{{ $bg }} {{ $bd }} season-card fx-on relative isolate snap-start shrink-0 w-[78%] min-h-56 p-6 border-t-4">
                @include('partials.season-fx', ['season' => $name])
                <div class="relative">
                    <h3 class="font-display text-[1.75rem]">{{ $name }}</h3>
                    <p class="text-sm font-semibold text-royal mt-1">{{ $months }}</p>
                    <p class="text-base text-ink/80 mt-4 max-w-[15rem]">{{ $d }}</p>
                </div>
            </article>
        @endforeach
    </div>

    <div class="max-md:hidden mt-10 grid md:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($seasons as [$months, $name, $d, $bg, $bd])
            <article class="{{ $bg }} {{ $bd }} season-card relative isolate p-6 min-h-48 border-t-4">
                @include('partials.season-fx', ['season' => $name])
                <div class="relative">
                    <h3 class="font-display text-2xl">{{ $name }}</h3>
                    <p class="text-sm font-semibold text-royal mt-1">{{ $months }}</p>
                    <p class="text-sm text-ink/80 mt-3 max-w-[16rem]">{{ $d }}</p>
                </div>
            </article>
        @endforeach
    </div>
</section>

@include('partials.entry')

{{-- How planning works --}}
<section class="px-5 sm:px-8 pt-12 sm:pt-24 pb-12 sm:pb-24 text-center">
    <h2 class="font-display text-[1.75rem] sm:text-5xl text-royal">Considered in every detail.</h2>
    <p class="mt-4 text-ink/65 max-w-xl mx-auto">A good trip should feel effortless. This is how we get you there.</p>
    <div class="mt-10 grid md:grid-cols-3 gap-8 md:gap-10 text-left">
        @foreach (config('site.steps') as $i => [$t, $d])
            <div class="border-t border-ink/20 pt-5"><h3 class="font-display text-xl text-royal">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }} / {{ $t }}</h3><p class="mt-2 text-sm text-ink/70 max-w-xs">{{ $d }}</p></div>
        @endforeach
    </div>
</section>

{{-- Traveller club: three steps that rise like a trail --}}
<section class="bleed bg-ink text-paper overflow-hidden">
    <div class="mx-auto max-w-[1240px] px-5 sm:px-8 py-12 sm:py-24 grid lg:grid-cols-[1fr_1.1fr] gap-12 lg:gap-20 items-end">
        <div class="max-w-md">
            <h2 class="font-display text-[1.75rem] sm:text-5xl leading-tight text-balance">Every journey brings you closer.</h2>
            <p class="mt-5 text-paper/75">Join the Traveller Club. Completed trips are tracked, benefits unlock as you go, and rewards can be used on a future booking.</p>
            <p class="mt-8 text-sm text-paper/55 max-w-sm">Illustrative structure. Final percentages, expiry and eligibility are confirmed by {{ config('site.brand') }}.</p>
        </div>
        <ol class="grid grid-cols-3 items-end gap-2 sm:gap-3" aria-label="Traveller Club levels">
            @foreach ([['03', '5%', 'off a future booking', 'h-44 sm:h-56'], ['06', '10%', 'off a future booking', 'h-60 sm:h-80'], ['10', 'VIP', 'club status', 'h-76 sm:h-[26rem]']] as [$n, $perk, $note, $h])
                <li class="{{ $h }} flex flex-col justify-between p-4 sm:p-6 bg-paper/10 border-t-2 border-star">
                    <p class="text-[11px] uppercase tracking-[.16em] text-paper/70">{{ (int) $n }} trips</p>
                    <div>
                        <p class="font-display text-[2rem] sm:text-6xl leading-none">{{ $perk }}</p>
                        <p class="mt-2 text-xs sm:text-sm text-paper/70">{{ $note }}</p>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
</section>

{{-- Reviews --}}
@php $reviews = config('site.reviews'); @endphp
<section class="px-5 sm:px-8 pt-12 sm:pt-20" x-data="{ r: 0, n: {{ count($reviews) }}, t: null,
        go(k) { this.r = (k + this.n) % this.n; this.run(); },
        run() {} }">
    <div class="bg-mist grid lg:grid-cols-[1fr_2fr] gap-6 lg:gap-12 p-5 sm:p-8 items-center">
        <div>
            <h2 class="font-display text-2xl sm:text-3xl text-balance">Words from travellers</h2>
            <div class="mt-5 flex items-center gap-3">
                <button type="button" @click="go(r - 1)" aria-label="Previous review" class="grid place-items-center size-10 border border-royal/40 text-royal hover:bg-royal hover:text-white transition-colors"><x-glyph name="left" class="size-4"/></button>
                <button type="button" @click="go(r + 1)" aria-label="Next review" class="grid place-items-center size-10 border border-royal/40 text-royal hover:bg-royal hover:text-white transition-colors"><x-glyph name="right" class="size-4"/></button>
                <span class="text-sm text-ink/55 tabular-nums" x-text="(r + 1) + ' / ' + n"></span>
            </div>
        </div>
        <div class="grid">
            @foreach ($reviews as $k => [$who, $from, $text, $trip])
                <figure class="col-start-1 row-start-1 transition-all duration-700 ease-out"
                        :class="r === {{ $k }} ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-2 pointer-events-none'" :aria-hidden="r !== {{ $k }}">
                    <blockquote class="font-display text-xl sm:text-2xl leading-snug text-balance">“{{ $text }}”</blockquote>
                    <figcaption class="mt-5 flex items-center gap-3">
                        <span class="grid place-items-center size-10 rounded-full bg-royal text-white font-bold text-sm">{{ mb_substr($who, 0, 1) }}</span>
                        <span class="text-sm"><b class="block">{{ $who }}</b><span class="text-ink/65">{{ $from }} · {{ $trip }}</span></span>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>


{{-- Blog --}}
@php $posts = \App\Support\ContentRepository::posts()->values()->all(); $lead = $posts[0] ?? null; $rest = array_slice($posts, 1, 2); @endphp
@if ($lead)
<section class="px-5 sm:px-8 pt-12 sm:pt-24">
    <div class="flex items-end justify-between gap-4 mb-8">
        <h2 class="font-display text-[1.75rem] sm:text-5xl text-royal">From the blog</h2>
        <a href="{{ route('blog') }}" class="btn btn-line-dark !py-3">All posts</a>
    </div>
    <div class="max-lg:-mx-5 max-lg:sm:-mx-8 max-lg:px-5 max-lg:sm:px-8 max-lg:flex max-lg:overflow-x-auto max-lg:snap-x max-lg:snap-mandatory max-lg:scroll-px-5 max-lg:pb-2 max-lg:[scrollbar-width:none] max-lg:[&::-webkit-scrollbar]:hidden lg:grid lg:grid-cols-[1.4fr_1fr] gap-4">
        <a href="{{ route('post', $lead['slug']) }}" class="group relative isolate block min-h-[26rem] max-lg:w-[82%] max-sm:w-[84%] max-lg:shrink-0 max-lg:snap-start overflow-hidden bg-ink">
            <img src="{{ $lead['img_url'] }}" @dims($lead['img_url']) alt="{{ $lead['img_alt'] ?? '' }}" loading="lazy" class="absolute inset-0 -z-10 size-full object-cover group-hover:scale-105 transition duration-700">
            <span class="absolute inset-0 -z-10 bg-gradient-to-t from-ink/85 via-ink/20 to-transparent"></span>
            <span class="absolute inset-x-0 bottom-0 p-7 text-paper">
                <span class="block font-display text-2xl sm:text-3xl max-w-md text-balance">{{ $lead['title'] }}</span>
                <span class="block mt-2 text-paper/80 max-w-md">{{ $lead['excerpt'] }}</span>
            </span>
        </a>
        <div class="max-lg:contents grid gap-4 lg:grid-rows-2">
            @foreach ($rest as $p)
                <a href="{{ route('post', $p['slug']) }}" class="group relative isolate block min-h-[14rem] max-lg:min-h-[26rem] max-lg:w-[82%] max-sm:w-[84%] max-lg:shrink-0 max-lg:snap-start overflow-hidden bg-ink">
                    <img src="{{ $p['img_url'] }}" @dims($p['img_url']) alt="{{ $p['img_alt'] ?? '' }}" loading="lazy" class="absolute inset-0 -z-10 size-full object-cover group-hover:scale-105 transition duration-700">
                    <span class="absolute inset-0 -z-10 bg-gradient-to-t from-ink/85 via-ink/20 to-transparent"></span>
                    <span class="absolute inset-x-0 bottom-0 p-6 text-paper">
                        <span class="block font-display text-xl sm:text-2xl text-balance">{{ $p['title'] }}</span>
                        <span class="block mt-1.5 text-sm text-paper/80">{{ $p['excerpt'] }}</span>
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- FAQ: iOS-style inset grouped list on small screens, mist panel on desktop --}}
<section class="px-5 sm:px-8 mt-12 sm:mt-24 max-md:pb-5 md:mx-8 md:px-10 md:py-14 md:bg-mist grid lg:grid-cols-[1fr_1.4fr] gap-6 md:gap-10 lg:gap-16" x-data="{ o: -1 }">
    <div>
        <h2 class="font-display text-[1.75rem] sm:text-4xl text-balance">Questions, answered</h2>
        <p class="mt-3 md:mt-4 text-ink/70 max-w-sm">Everything first-time visitors ask about permits, timing and payment.</p>
        <div class="mt-6 md:mt-8 flex gap-2 sm:gap-3">
            <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener" class="btn btn-solid max-sm:flex-1">Ask us on WhatsApp <x-glyph name="arrow" class="size-4 max-sm:hidden"/></a>
            <a href="{{ route('faq') }}" class="btn btn-line-dark max-sm:flex-1">See all FAQs</a>
        </div>
    </div>
    </div>
    <div class="max-md:bg-white max-md:rounded-[1rem] max-md:border max-md:border-ink/10 max-md:overflow-hidden md:divide-y md:divide-ink/10 md:border-y md:border-ink/10">
        @foreach (\App\Support\ContentRepository::faqItems()->where('home', true)->values() as $k => $faq)
            @php [$q, $a] = [$faq['q'], $faq['a']]; @endphp
            <div class="max-md:border-t max-md:border-ink/10 max-md:first:border-0 max-md:mx-0">
                <button type="button" @click="o = o === {{ $k }} ? -1 : {{ $k }}" :aria-expanded="o === {{ $k }}" class="w-full flex items-center justify-between gap-4 text-left max-md:px-4 max-md:py-4 md:py-5 font-medium md:font-semibold active:bg-mist md:active:bg-transparent hover:text-royal transition-colors">
                    <span class="text-[17px] md:text-base leading-snug">{{ $q }}</span>
                    <x-glyph name="right" class="md:hidden size-5 shrink-0 text-ink/35 transition-transform duration-300" ::class="o === {{ $k }} && 'rotate-90 !text-royal'"/>
                    <span class="max-md:hidden shrink-0 text-2xl leading-none font-normal text-royal transition-transform duration-300" :class="o === {{ $k }} && 'rotate-45'" aria-hidden="true">+</span>
                </button>
                <div class="grid transition-all duration-300 ease-out" :class="o === {{ $k }} ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
                    <p class="overflow-hidden text-ink/70 max-w-[62ch] md:pr-10"><span class="block max-md:px-4 max-md:pb-4 md:pb-6 max-md:text-[15px]">{{ $a }}</span></p>
                </div>
            </div>
        @endforeach
    </div>
</section>

{{-- Closing call --}}
<section class="bleed bg-royal text-paper text-center -mb-12 sm:-mb-24">
    <div class="mx-auto max-w-[1240px] px-5 sm:px-8 py-12 sm:py-24">
        <h2 class="font-display text-[1.75rem] sm:text-5xl text-balance max-w-3xl mx-auto leading-tight">Your Sikkim story starts with a conversation.</h2>
        <p class="mt-5 text-paper/80 max-w-lg mx-auto">Tell us when you plan to visit, who is travelling and what you would love to experience. We will send a tailored itinerary within a day.</p>
        <button type="button" @click="pick('')" class="btn btn-light mt-9">Start an enquiry</button>
    </div>
</section>
@endsection

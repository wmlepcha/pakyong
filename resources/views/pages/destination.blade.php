@extends('layouts.app')
@php
    $wa = preg_replace('/\D/', '', config('site.phone'));
    $price = collect(config('site.destinations'))->firstWhere(0, $d['name'])[3] ?? null;
    $others = collect(config('destinations'))->except($slug);
    $monthShort = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $seasonMonths = [[2, 3, 4], [5, 6, 7, 8], [9, 10], [11, 0, 1]];
    $levels = ['peak' => 'bg-royal text-white', 'good' => 'bg-royal/30 text-ink', 'wet' => 'bg-sky-200 text-ink', 'cold' => 'bg-slate-300 text-ink'];
    $tints = ['bg-rose-100', 'bg-emerald-100', 'bg-amber-100', 'bg-sky-200', 'bg-violet-100', 'bg-orange-100', 'bg-teal-100', 'bg-indigo-100'];

    // Best months, e.g. "Apr–May, Oct–Nov", from the months marked peak.
    $runs = [];
    foreach ($d['calendar'] as $i => $level) {
        if ($level !== 'peak') { continue; }
        if ($runs && end($runs)[1] === $i - 1) { $runs[array_key_last($runs)][1] = $i; } else { $runs[] = [$i, $i]; }
    }
    $best = implode(', ', array_map(fn ($r) => $r[0] === $r[1] ? $monthShort[$r[0]] : $monthShort[$r[0]].'–'.$monthShort[$r[1]], $runs));

    $facts = [['Best time', $best], ['Plan', $d['days']], ['High point', $d['high']], ['Base', $d['base']]];
    $toc = ['overview' => 'Overview', 'best-time' => 'Best time to visit', 'places' => 'Places to visit', 'pack' => 'What to pack', 'getting-there' => 'Getting there', 'permits-stay' => 'Permits and stay', 'itinerary' => 'Suggested plan', 'tips' => 'Tips', 'faq' => 'FAQ'];
    $h2 = 'font-display font-bold text-2xl sm:text-4xl text-balance';
    $h3 = 'font-display font-bold text-xl';
    $body = 'text-ink/75 leading-relaxed';
    $pill = 'rounded-full px-1 py-2 sm:px-4 text-xs sm:text-sm font-semibold whitespace-nowrap text-center transition-colors flex-1 min-w-0 sm:flex-none';
    $card = 'bg-white border border-ink/5 rounded-3xl';

    // Photos of individual places (Wikimedia Commons, credited at the bottom of the page). Only this region's own photos are ever used.
    $photos = config('destination_photos.'.$slug, []);
    $photoUrl = fn ($i) => isset($photos[$i]) ? '/images/'.$photos[$i]['file'] : null;
    $pool = [];
    foreach ($d['places'] as $i => $pl) {
        if ($url = $photoUrl($i)) { $pool[] = ['img' => $url, 'name' => $pl[0], 'type' => $pl[1]]; }
    }
    if (count($pool) < 5) { array_unshift($pool, ['img' => '/images/'.$d['img'], 'name' => $d['name'], 'type' => 'Base: '.$d['base']]); }
    $tileClasses = ['col-span-2 h-44 sm:col-span-1 sm:row-span-2 sm:h-auto', 'h-24 sm:h-auto', 'h-24 sm:h-auto', 'h-24 sm:h-auto', 'h-24 sm:h-auto'];
@endphp
@section('title', $d['name'].' travel guide – '.config('site.brand'))
@section('description', $d['tagline'].' When to visit, temperature, places to see and what to pack for '.$d['name'].'.')
@push('head')
<script type="application/ld+json">{!! json_encode([
    '@context' => 'https://schema.org', '@type' => 'TouristDestination',
    'name' => $d['name'], 'description' => $d['tagline'].' '.$d['about'][0],
    'image' => url('/images/'.$d['img']), 'touristType' => $d['good_for'],
    'containedInPlace' => ['@type' => 'AdministrativeArea', 'name' => 'Sikkim, India'],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush
@section('content')

{{-- Hero: a mosaic of photos that change, then the essentials --}}
<section class="px-5 sm:px-8 pt-3 sm:pt-6">
    <a href="{{ route('destinations') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-ink/70 hover:text-royal"><x-icon name="left" class="size-4"/> All destinations</a>
    <div class="mt-4 lg:mt-6 flex flex-col gap-6 lg:gap-10">
        <div x-data='mosaic(@json($pool, JSON_HEX_APOS | JSON_HEX_QUOT))' class="order-first lg:order-last grid grid-cols-2 gap-2 sm:grid-cols-[1.5fr_1.2fr_1fr] sm:grid-rows-2 sm:gap-3 sm:h-[22rem] lg:h-[30rem]">
            @foreach ($tileClasses as $t => $cls)
                @php $first = $pool[$t % count($pool)]; @endphp
                <div class="relative overflow-hidden rounded-2xl sm:rounded-3xl bg-mist {{ $cls }}">
                    @foreach (['a', 'b'] as $L)
                        {{-- Each layer carries its own photo and its own name, so they fade together --}}
                        <div class="absolute inset-0 transition-opacity duration-[1400ms]" :class="tiles[{{ $t }}].front === '{{ $L }}' ? 'opacity-100' : 'opacity-0'">
                            <img src="{{ $first['img'] }}" :src="tiles[{{ $t }}].{{ $L }}.img" alt="" @if ($t === 0 && $L === 'a') fetchpriority="high" @endif class="absolute inset-0 size-full object-cover">
                            <span class="absolute inset-x-0 bottom-0 flex items-end gap-2 px-3 pb-2.5 pt-8 sm:px-4 sm:pb-4 text-white bg-gradient-to-t from-ink/80 to-transparent">
                                <x-icon name="pin" class="size-4 shrink-0 mb-0.5"/>
                                <span class="min-w-0">
                                    <span class="block font-semibold text-xs sm:text-sm leading-tight truncate" x-text="tiles[{{ $t }}].{{ $L }}.name">{{ $first['name'] }}</span>
                                    <span class="block text-[10px] uppercase tracking-wider text-white/75 truncate" x-text="tiles[{{ $t }}].{{ $L }}.type">{{ $first['type'] }}</span>
                                </span>
                            </span>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <div class="lg:grid lg:grid-cols-[1.1fr_1fr] lg:gap-12 lg:items-end">
            <div>
                <h1 class="font-display font-bold text-[2rem] leading-[1.1] sm:text-5xl lg:text-6xl text-balance">{{ $d['name'] }}</h1>
                <p class="mt-3 text-base sm:text-lg text-ink/70 max-w-xl text-pretty">{{ $d['tagline'] }}</p>
                <ul class="mt-4 flex flex-wrap gap-2" aria-label="Good for">
                    @foreach ($d['good_for'] as $g)<li class="rounded-full bg-mist px-3.5 py-1.5 text-xs sm:text-sm font-semibold text-royal">{{ $g }}</li>@endforeach
                </ul>
                <div class="mt-6 grid grid-cols-2 gap-2.5 sm:flex sm:gap-3">
                    <button type="button" @click="pick('{{ $d['name'] }}')" class="inline-flex items-center justify-center rounded-full bg-royal text-white text-sm sm:text-base font-semibold px-3 py-3.5 sm:px-8 sm:py-4 whitespace-nowrap hover:bg-ink transition-colors">Plan this trip</button>
                    <a href="https://wa.me/{{ $wa }}?text={{ rawurlencode('Hi, I have a question about '.$d['name']) }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-1.5 sm:gap-3 rounded-full bg-mist text-ink text-sm sm:text-base font-semibold px-3 py-3.5 sm:pl-7 sm:pr-6 sm:py-4 whitespace-nowrap hover:bg-royal/10 transition-colors">Ask on WhatsApp <x-icon name="arrow" class="size-4"/></a>
                </div>
            </div>
            <dl class="mt-7 lg:mt-0 grid grid-cols-2 gap-3">
                @foreach ($facts as $i => [$k, $v])
                    <div class="{{ $tints[$i] }} rounded-2xl p-4"><dt class="text-xs text-ink/60">{{ $k }}</dt><dd class="mt-1 font-semibold leading-snug">{{ $v }}</dd></div>
                @endforeach
            </dl>
        </div>
    </div>
</section>

<div x-data="{ s: [3, 3, 0, 0, 0, 1, 1, 1, 1, 2, 2, 3][new Date().getMonth()], idx: @json($seasonMonths), active: 'overview', faq: -1 }"
     x-init="const io = new IntersectionObserver(es => es.forEach(e => { if (e.isIntersecting) active = e.target.id }), { rootMargin: '-15% 0px -75% 0px' });
             $root.querySelectorAll('[data-spy]').forEach(el => io.observe(el));
             $watch('active', () => { const c = $refs.chips, el = c.querySelector('[aria-current]'); if (el && c.scrollWidth > c.clientWidth) c.scrollTo({ left: el.offsetLeft - 24, behavior: 'smooth' }) })">

<div class="px-5 sm:px-8 pt-8 grid grid-cols-[minmax(0,1fr)] lg:grid-cols-[14rem_minmax(0,1fr)] gap-x-14 gap-y-6">
    {{-- Contents: pinned chips on phones and tablets, side list on desktop --}}
    <nav aria-label="On this page" class="min-w-0 sticky top-20 lg:top-28 z-30 self-start -mx-5 sm:-mx-8 px-5 sm:px-8 py-3 bg-paper/95 backdrop-blur lg:m-0 lg:p-0 lg:bg-transparent lg:backdrop-blur-none">
        <p class="hidden lg:block text-xs font-semibold text-ink/55 mb-3 px-3">On this page</p>
        <ul x-ref="chips" class="flex lg:flex-col gap-1 overflow-x-auto lg:overflow-visible [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
            @foreach ($toc as $id => $label)
                <li class="shrink-0"><a href="#{{ $id }}" :aria-current="active === '{{ $id }}' ? 'true' : null"
                       :class="active === '{{ $id }}' ? 'bg-ink text-white lg:bg-mist lg:text-royal font-semibold' : 'bg-mist lg:bg-transparent text-ink/75 lg:text-ink/70 hover:text-ink lg:hover:bg-mist/60'"
                       class="block rounded-full lg:rounded-xl px-4 py-2 lg:px-3 text-sm whitespace-nowrap transition-colors">{{ $label }}</a></li>
            @endforeach
        </ul>
    </nav>

    <div class="min-w-0 space-y-14 sm:space-y-24 pt-2 sm:pt-4 pb-4">

        {{-- Overview --}}
        <section id="overview" data-spy class="scroll-mt-40 lg:scroll-mt-28">
            <h2 class="{{ $h2 }}">Overview</h2>
            <p class="mt-5 font-display text-xl sm:text-2xl leading-snug max-w-3xl text-balance">{{ $d['about'][0] }}</p>
            <p class="mt-4 max-w-3xl {{ $body }}">{{ $d['about'][1] }}</p>
        </section>

        {{-- Best time: season picker drives the calendar and the panel --}}
        <section id="best-time" data-spy class="scroll-mt-40 lg:scroll-mt-28">
            <h2 class="{{ $h2 }}">Best time to visit</h2>
            <div role="tablist" aria-label="Season" class="mt-5 sm:mt-6 flex flex-wrap gap-1.5 sm:gap-2">
                @foreach ($d['seasons'] as $k => $se)
                    <button role="tab" type="button" @click="s = {{ $k }}" :aria-selected="s === {{ $k }}" class="{{ $pill }}" :class="s === {{ $k }} ? 'bg-ink text-white' : 'bg-mist text-ink/75 hover:text-ink'">{{ $se[0] }}</button>
                @endforeach
            </div>
            <div class="mt-5 grid grid-cols-6 sm:grid-cols-12 gap-1.5" aria-hidden="true">
                @foreach ($monthShort as $i => $m)
                    <span class="grid place-items-center h-12 sm:h-14 rounded-xl text-sm font-semibold transition-all {{ $levels[$d['calendar'][$i]] }}"
                          :class="idx[s].includes({{ $i }}) ? 'ring-2 ring-ink ring-offset-2 ring-offset-paper' : 'opacity-40'">{{ $m }}</span>
                @endforeach
            </div>
            <ul class="mt-4 flex flex-wrap gap-x-6 gap-y-2 text-xs text-ink/65">
                <li class="flex items-center gap-2"><span class="size-3 rounded bg-royal"></span>Peak views and weather</li>
                <li class="flex items-center gap-2"><span class="size-3 rounded bg-royal/30"></span>Good</li>
                <li class="flex items-center gap-2"><span class="size-3 rounded bg-sky-200"></span>Rain and landslide risk</li>
                <li class="flex items-center gap-2"><span class="size-3 rounded bg-slate-300"></span>Cold, snow in the high areas</li>
            </ul>
            <div class="mt-6 {{ $card }} p-5 sm:p-8" role="tabpanel">
                @foreach ($d['seasons'] as $k => [$name, $months, $temp, $mood, $text])
                    <div x-show="s === {{ $k }}" @if ($k) x-cloak @endif class="grid sm:grid-cols-[13rem_1fr] gap-5 sm:gap-8">
                        <div>
                            <p class="text-sm text-ink/60">{{ $name }} · {{ $months }}</p>
                            <p class="mt-1 font-display font-bold text-4xl sm:text-5xl">{{ $temp }}</p>
                            <p class="mt-1 text-xs text-ink/55">Typical day and night range</p>
                        </div>
                        <div>
                            <h3 class="{{ $h3 }} text-royal">{{ $mood }}</h3>
                            <p class="mt-2 {{ $body }}">{{ $text }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <p class="mt-4 text-sm text-ink/60">Temperatures are typical ranges for {{ $d['base'] }}. High passes and lakes are colder, and conditions change from year to year.</p>
        </section>

        {{-- Places: photo cards you can page through --}}
        <section id="places" data-spy class="scroll-mt-40 lg:scroll-mt-28"
                 x-data="{ start: true, end: false,
                           move(d) { const t = $refs.track; const c = t.firstElementChild; t.scrollBy({ left: d * (c.offsetWidth + parseFloat(getComputedStyle(t).columnGap)), behavior: 'smooth' }); },
                           sync() { const t = $refs.track; this.start = t.scrollLeft < 8; this.end = t.scrollLeft + t.clientWidth >= t.scrollWidth - 8; } }" x-init="sync()">
            <div class="flex items-end justify-between gap-6">
                <h2 class="{{ $h2 }}">Places to visit</h2>
                <div class="flex gap-2 shrink-0">
                    <button type="button" @click="move(-1)" :disabled="start" aria-label="Previous places" class="grid place-items-center size-11 sm:size-12 rounded-full border border-ink/15 bg-white hover:bg-ink hover:text-white hover:border-ink transition-colors disabled:opacity-30 disabled:pointer-events-none"><x-icon name="left"/></button>
                    <button type="button" @click="move(1)" :disabled="end" aria-label="Next places" class="grid place-items-center size-11 sm:size-12 rounded-full border border-ink/15 bg-white hover:bg-ink hover:text-white hover:border-ink transition-colors disabled:opacity-30 disabled:pointer-events-none"><x-icon name="right"/></button>
                </div>
            </div>
            <div x-ref="track" @scroll.passive="sync()" role="group" aria-label="Places to visit in {{ $d['name'] }}"
                 class="mt-6 -mx-5 px-5 sm:-mx-8 sm:px-8 lg:mx-0 lg:px-0 flex gap-4 overflow-x-auto snap-x snap-mandatory scroll-px-5 sm:scroll-px-8 lg:scroll-px-0 pb-2 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                @foreach ($d['places'] as $i => [$name, $type, $desc, $meta])
                    @php $img = $photoUrl($i); @endphp
                    <article class="group relative snap-start shrink-0 w-[76%] sm:w-[46%] lg:w-[calc(50%-0.5rem)] xl:w-[calc(33.333%-0.7rem)] aspect-[3/4] rounded-3xl overflow-hidden text-white {{ $img ? 'bg-mist' : 'bg-gradient-to-br from-royal to-ink' }}">
                        @if ($img)
                            <img src="{{ $img }}" alt="{{ $name }}" loading="lazy" class="absolute inset-0 size-full object-cover lg:group-hover:scale-105 transition duration-700">
                        @else
                            <span class="absolute inset-0 grid place-items-center font-display font-bold text-8xl text-white/15" aria-hidden="true">{{ mb_substr($name, 0, 1) }}</span>
                        @endif
                        <span class="absolute inset-0 bg-gradient-to-t from-ink/90 via-ink/35 to-transparent"></span>
                        <span class="absolute left-4 top-4 rounded-full bg-white/90 text-ink px-3 py-1.5 text-[11px] font-semibold">{{ $type }}</span>
                        <div class="absolute inset-x-0 bottom-0 p-5">
                            <h3 class="font-display font-bold text-xl sm:text-2xl leading-snug">{{ $name }}</h3>
                            <p class="mt-1 flex items-center gap-1.5 text-xs font-semibold text-white/85"><x-icon name="pin" class="size-3.5 shrink-0"/>{{ $meta }}</p>
                            <p class="mt-2 text-sm text-white/80 leading-snug line-clamp-4">{{ $desc }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        {{-- What to pack --}}
        <section id="pack" data-spy class="scroll-mt-40 lg:scroll-mt-28">
            <h2 class="{{ $h2 }}">What to pack</h2>
            <div role="tablist" aria-label="Season" class="mt-5 sm:mt-6 flex flex-wrap gap-1.5 sm:gap-2">
                @foreach ($d['seasons'] as $k => $se)
                    <button role="tab" type="button" @click="s = {{ $k }}" :aria-selected="s === {{ $k }}" class="{{ $pill }}" :class="s === {{ $k }} ? 'bg-ink text-white' : 'bg-mist text-ink/75 hover:text-ink'">{{ $se[0] }}</button>
                @endforeach
            </div>
            <div class="mt-6 grid md:grid-cols-2 gap-4">
                <div class="{{ $card }} p-5 sm:p-6">
                    <h3 class="{{ $h3 }}">What to wear in <span x-text="['{{ implode("','", array_column($d['seasons'], 0)) }}'][s].toLowerCase()"></span></h3>
                    @foreach ($d['seasons'] as $k => $se)
                        <ul x-show="s === {{ $k }}" @if ($k) x-cloak @endif class="mt-4 space-y-3 text-sm {{ $body }}">
                            @foreach ($se[5] as $item)<li class="flex gap-3"><span class="mt-2.5 h-px w-4 bg-royal shrink-0"></span>{{ $item }}</li>@endforeach
                        </ul>
                    @endforeach
                </div>
                <div class="bg-mist rounded-3xl p-5 sm:p-6">
                    <h3 class="{{ $h3 }}">Always bring</h3>
                    <ul class="mt-4 space-y-3 text-sm {{ $body }}">
                        @foreach ($d['pack_always'] as $item)<li class="flex gap-3"><span class="mt-2.5 h-px w-4 bg-royal shrink-0"></span>{{ $item }}</li>@endforeach
                    </ul>
                </div>
            </div>
            <p class="mt-4 text-sm text-ink/60">Layers work better than one heavy coat, because mornings, noon and evenings can feel very different.</p>
        </section>

        {{-- Getting there --}}
        <section id="getting-there" data-spy class="scroll-mt-40 lg:scroll-mt-28">
            <h2 class="{{ $h2 }}">Getting there</h2>
            <dl class="mt-5 sm:mt-6 divide-y divide-ink/10 max-sm:rounded-2xl max-sm:bg-white max-sm:border max-sm:border-ink/5 max-sm:px-4 sm:border-y sm:border-ink/10">
                @foreach ($d['getting'] as [$route, $detail, $time])
                    <div class="py-4 sm:py-6 grid lg:grid-cols-[14rem_1fr_9.5rem] gap-2 lg:gap-8 items-start">
                        <dt class="{{ $h3 }}">{{ $route }}</dt>
                        <dd class="{{ $body }}">{{ $detail }}</dd>
                        <dd class="lg:text-right"><span class="inline-block rounded-full bg-mist px-3 py-1.5 text-xs font-semibold text-royal">{{ $time }}</span></dd>
                    </div>
                @endforeach
            </dl>
        </section>

        {{-- Permits and stay --}}
        <section id="permits-stay" data-spy class="scroll-mt-40 lg:scroll-mt-28">
            <h2 class="{{ $h2 }}">Permits and where to stay</h2>
            <div class="mt-6 grid sm:grid-cols-2 gap-4">
                <div class="bg-royal text-white rounded-3xl p-5 sm:p-6 flex flex-col">
                    <h3 class="{{ $h3 }}">Permits</h3>
                    <p class="mt-3 text-sm text-white/85 leading-relaxed">{{ $d['permits'] }}</p>
                    <a href="{{ route('guide') }}#entry" class="mt-5 inline-flex items-center gap-2 self-start rounded-full bg-white text-ink text-sm font-semibold pl-5 pr-4 py-3 hover:bg-mist transition-colors">Entry rules <x-icon name="arrow" class="size-4"/></a>
                </div>
                <div class="{{ $card }} p-5 sm:p-6">
                    <h3 class="{{ $h3 }}">Where to stay</h3>
                    <p class="mt-3 text-sm {{ $body }}">{{ $d['stay'] }}</p>
                </div>
            </div>
        </section>

        {{-- Suggested plan --}}
        <section id="itinerary" data-spy class="scroll-mt-40 lg:scroll-mt-28">
            <h2 class="{{ $h2 }}">Suggested {{ count($d['itinerary']) }}-day plan</h2>
            <ol class="mt-6 ml-2 border-l border-ink/15 space-y-5">
                @foreach ($d['itinerary'] as $i => $day)
                    <li class="relative pl-7">
                        <span class="absolute -left-[5px] top-1.5 size-2.5 rounded-full bg-royal ring-4 ring-paper"></span>
                        <p class="text-sm font-bold text-royal">Day {{ $i + 1 }}</p>
                        <p class="mt-1 {{ $body }} max-w-2xl">{{ $day }}</p>
                    </li>
                @endforeach
            </ol>
            <div class="mt-6 flex flex-wrap items-center justify-between gap-4">
                <p class="text-sm text-ink/60 max-w-xl">A starting point. We plan around your dates, pace and budget.</p>
                <button type="button" @click="pick('{{ $d['name'] }}')" class="inline-flex items-center gap-3 rounded-full bg-ink text-white font-semibold pl-6 pr-5 py-3.5 hover:bg-royal transition-colors">Plan this trip <x-icon name="arrow" class="size-4"/></button>
            </div>
        </section>

        {{-- Tips --}}
        <section id="tips" data-spy class="scroll-mt-40 lg:scroll-mt-28">
            <h2 class="{{ $h2 }}">Tips from our team</h2>
            <ul class="mt-6 bg-mist rounded-3xl p-5 sm:p-8 grid sm:grid-cols-2 gap-x-10 gap-y-4">
                @foreach ($d['tips'] as $tip)<li class="flex gap-3 text-sm {{ $body }}"><span class="mt-2.5 h-px w-4 bg-royal shrink-0"></span>{{ $tip }}</li>@endforeach
            </ul>
        </section>

        {{-- FAQ --}}
        <section id="faq" data-spy class="scroll-mt-40 lg:scroll-mt-28">
            <h2 class="{{ $h2 }}">Questions about {{ $d['short'] }} Sikkim</h2>
            <div class="mt-6 max-w-3xl rounded-2xl bg-white border border-ink/5 divide-y divide-ink/10 overflow-hidden">
                @foreach ($d['faqs'] as $k => [$q, $a])
                    <div>
                        <h3>
                            <button type="button" @click="faq = faq === {{ $k }} ? -1 : {{ $k }}" :aria-expanded="faq === {{ $k }}" class="w-full flex items-center justify-between gap-4 text-left px-4 sm:px-6 py-4 sm:py-5 font-semibold">
                                {{ $q }}
                                <span class="grid place-items-center size-8 shrink-0 rounded-full transition-all" :class="faq === {{ $k }} ? 'bg-royal text-white rotate-45' : 'bg-mist text-royal'" aria-hidden="true">+</span>
                            </button>
                        </h3>
                        <div x-show="faq === {{ $k }}" x-cloak class="px-4 sm:px-6 pb-5"><p class="{{ $body }}">{{ $a }}</p></div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</div>
</div>

@if ($photos)
<section class="px-5 sm:px-8 pt-12">
    <details class="max-w-3xl text-xs text-ink/55">
        <summary class="cursor-pointer font-semibold">Photo credits</summary>
        <p class="mt-3 leading-relaxed">Photos from Wikimedia Commons:
            @foreach ($photos as $i => $ph)
                <a href="{{ $ph['page'] }}" target="_blank" rel="noopener" class="underline underline-offset-2">{{ $d['places'][$i][0] }}</a> by {{ $ph['author'] }} (<a href="{{ $ph['licenseUrl'] }}" target="_blank" rel="noopener" class="underline underline-offset-2">{{ $ph['license'] }}</a>)@if (! $loop->last); @else. @endif
            @endforeach
        </p>
    </details>
</section>
@endif

{{-- Other destinations --}}
<section class="pt-16 sm:pt-24">
    <div class="flex items-center justify-between gap-4 px-5 sm:px-8 mb-5 sm:mb-8">
        <h2 class="font-display font-bold text-2xl sm:text-4xl">Explore more of Sikkim</h2>
        <a href="{{ route('destinations') }}" class="shrink-0 whitespace-nowrap text-sm font-semibold text-royal">View all</a>
    </div>
    <div class="flex gap-4 overflow-x-auto snap-x snap-mandatory scroll-px-5 px-5 sm:scroll-px-8 sm:px-8 pb-2 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden lg:grid lg:grid-cols-3 lg:overflow-visible">
        @foreach ($others as $key => $o)
            <a href="{{ route('destination', $key) }}" class="group snap-start shrink-0 w-[68%] sm:w-[38%] lg:w-auto relative block aspect-[4/5] rounded-3xl overflow-hidden bg-mist">
                <img src="/images/{{ $o['img'] }}" alt="" loading="lazy" class="absolute inset-0 size-full object-cover lg:group-hover:scale-105 transition duration-700">
                <span class="absolute inset-0 bg-gradient-to-t from-ink/90 via-ink/30 to-transparent"></span>
                <span class="absolute inset-x-0 bottom-0 p-5 text-white">
                    <span class="block font-display font-bold text-xl">{{ $o['name'] }}</span>
                    <span class="block mt-1 text-sm text-white/80">{{ $o['tagline'] }}</span>
                </span>
            </a>
        @endforeach
    </div>
</section>

@include('partials.cta')
@endsection

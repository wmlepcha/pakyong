@extends('layouts.app')
@section('title', 'Travel Guide - '.config('site.brand'))
@section('description', 'A practical Sikkim travel guide: entry rules and permits, getting there, regions, food, culture and safety tips for first-time visitors.')
@section('content')
@php
    $g = config('guide');
    $toc = [
        'overview' => 'Overview', 'best-time' => 'Best time to visit', 'getting-there' => 'Getting there',
        'getting-around' => 'Getting around', 'regions' => 'Regions and places', 'itineraries' => 'Sample itineraries',
        'altitude' => 'Altitude and health', 'packing' => 'What to pack', 'food-culture' => 'Food and culture',
        'money' => 'Money and connectivity', 'responsible' => 'Responsible travel', 'entry' => 'Permits and entry',
    ];
    $h2 = 'font-display font-bold text-2xl sm:text-4xl text-balance';
    $h3 = 'font-display font-bold text-xl';
    $body = 'text-ink/75 leading-relaxed';
    $pill = 'rounded-full px-4 py-2 text-sm font-semibold whitespace-nowrap transition-colors';
    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $levels = ['peak' => 'bg-royal text-white', 'good' => 'bg-royal/30 text-ink', 'wet' => 'bg-sky-200 text-ink', 'cold' => 'bg-slate-300 text-ink'];
@endphp

<section class="px-5 sm:px-8 pt-4 sm:pt-10 pb-6">
    <h1 class="font-display font-bold text-[2rem] leading-[1.1] sm:text-6xl text-balance">Sikkim travel guide</h1>
    <p class="mt-2 sm:mt-5 text-base sm:text-lg text-ink/70 max-w-3xl">{{ $g['intro'] }}</p>
    <dl class="mt-6 sm:mt-10 grid grid-cols-2 gap-3 md:grid-cols-4 md:gap-px md:bg-ink/10 md:rounded-3xl md:overflow-hidden md:border md:border-ink/10">
        @php $tints = ['bg-rose-100', 'bg-emerald-100', 'bg-amber-100', 'bg-sky-200', 'bg-violet-100', 'bg-orange-100', 'bg-teal-100', 'bg-indigo-100']; @endphp
        @foreach ($g['facts'] as $i => [$k, $v])
            <div class="{{ $tints[$i % count($tints)] }} md:bg-white rounded-2xl md:rounded-none p-4 md:p-5"><dt class="text-xs text-ink/60">{{ $k }}</dt><dd class="mt-1 font-semibold">{{ $v }}</dd></div>
        @endforeach
    </dl>
</section>

<div x-data="{ active: 'overview' }"
     x-init="const io = new IntersectionObserver(es => es.forEach(e => { if (e.isIntersecting) active = e.target.id }), { rootMargin: '-15% 0px -75% 0px' });
             $root.querySelectorAll('[data-spy]').forEach(el => io.observe(el));
             $watch('active', () => { const c = $refs.chips, el = c.querySelector('[aria-current]'); if (el && c.scrollWidth > c.clientWidth) c.scrollTo({ left: el.offsetLeft - 24, behavior: 'smooth' }) })">

<div class="px-5 sm:px-8 pt-6 grid grid-cols-[minmax(0,1fr)] lg:grid-cols-[14rem_minmax(0,1fr)] gap-x-14 gap-y-6">
    {{-- Contents: sticky chip bar on mobile, sticky list on desktop, follows the reader --}}
    <nav aria-label="On this page" class="min-w-0 sticky top-20 lg:top-28 z-30 self-start -mx-5 sm:-mx-8 px-5 sm:px-8 py-3 bg-paper/95 backdrop-blur lg:m-0 lg:p-0 lg:bg-transparent lg:backdrop-blur-none">
        <p class="hidden lg:block text-xs font-semibold text-ink/55 mb-3 px-3">On this page</p>
        <ul x-ref="chips" class="flex lg:flex-col gap-1 overflow-x-auto lg:overflow-visible [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
            @foreach ($toc as $id => $label)
                <li class="shrink-0"><a href="#{{ $id }}" :aria-current="active === '{{ $id }}' ? 'true' : null"
                       :class="active === '{{ $id }}' ? 'bg-ink text-white lg:bg-mist lg:text-royal font-semibold' : 'bg-mist lg:bg-transparent text-ink/75 lg:text-ink/70 hover:text-ink lg:hover:bg-mist/60'"
                       class="block rounded-full lg:rounded-xl px-4 py-2 lg:px-3 lg:py-2 text-sm whitespace-nowrap transition-colors">{{ $label }}</a></li>
            @endforeach
        </ul>
    </nav>

    <div class="space-y-14 sm:space-y-24 min-w-0 pt-2 sm:pt-4 pb-4">

        {{-- Overview --}}
        <section id="overview" data-spy class="scroll-mt-40 lg:scroll-mt-28">
            <h2 class="{{ $h2 }}">Overview</h2>
            <p class="mt-5 sm:mt-6 font-display text-xl sm:text-2xl leading-snug max-w-3xl text-balance">{{ $g['overview'][0] }}</p>
            <div class="mt-6 grid md:grid-cols-2 gap-x-10 gap-y-4 max-w-4xl">
                <p class="{{ $body }}">{{ $g['overview'][1] }}</p>
                <p class="{{ $body }}">{{ $g['overview'][2] }}</p>
            </div>
            <div class="mt-8 flex flex-wrap gap-2">
                <span class="text-sm text-ink/60 self-center mr-1">Jump to a region:</span>
                @foreach (['East', 'North', 'West', 'South'] as $k => $r)
                    <a href="#regions" @click="$dispatch('region', {{ $k }})" class="rounded-full border border-ink/15 bg-white px-4 py-2 text-sm font-semibold hover:bg-ink hover:text-white hover:border-ink transition-colors">{{ $r }} Sikkim</a>
                @endforeach
            </div>
        </section>

        {{-- Best time: season picker drives the month calendar --}}
        <section id="best-time" data-spy class="scroll-mt-40 lg:scroll-mt-28" x-data='{ s: 0, idx: @json(array_column($g['seasons'], 4)) }'>
            <h2 class="{{ $h2 }}">Best time to visit</h2>
            <div role="tablist" aria-label="Season" class="mt-5 sm:mt-6 flex flex-wrap gap-1.5 sm:gap-2">
                @foreach ($g['seasons'] as $k => $se)
                    <button role="tab" type="button" @click="s = {{ $k }}" :aria-selected="s === {{ $k }}" class="{{ $pill }} flex-1 min-w-0 sm:flex-none px-1 text-xs sm:px-4 sm:text-sm text-center" :class="s === {{ $k }} ? 'bg-ink text-white' : 'bg-mist text-ink/75 hover:text-ink'">{{ $se[1] }}</button>
                @endforeach
            </div>
            <div class="mt-6 grid grid-cols-6 sm:grid-cols-12 gap-1.5" aria-hidden="true">
                @foreach ($months as $i => $m)
                    <span class="grid place-items-center h-14 rounded-xl text-sm font-semibold transition-all {{ $levels[$g['calendar'][$i]] }}"
                          :class="idx[s].includes({{ $i }}) ? 'ring-2 ring-ink ring-offset-2 ring-offset-paper' : 'opacity-40'">{{ $m }}</span>
                @endforeach
            </div>
            <ul class="mt-4 flex flex-wrap gap-x-6 gap-y-2 text-xs text-ink/65">
                <li class="flex items-center gap-2"><span class="size-3 rounded bg-royal"></span>Peak views and weather</li>
                <li class="flex items-center gap-2"><span class="size-3 rounded bg-royal/30"></span>Good</li>
                <li class="flex items-center gap-2"><span class="size-3 rounded bg-sky-200"></span>Rain and landslide risk</li>
                <li class="flex items-center gap-2"><span class="size-3 rounded bg-slate-300"></span>Cold, snow in the north</li>
            </ul>
            <div class="mt-6 bg-white border border-ink/5 rounded-3xl p-5 sm:p-8" role="tabpanel">
                @foreach ($g['seasons'] as $k => [$mo, $name, $text, $tag])
                    <div x-show="s === {{ $k }}" @if ($k) x-cloak @endif>
                        <div class="flex flex-wrap items-baseline justify-between gap-x-4">
                            <h3 class="font-display font-bold text-2xl">{{ $name }} <span class="text-ink/50 font-normal text-lg">· {{ $mo }}</span></h3>
                            <p class="text-sm font-semibold text-royal">{{ $tag }}</p>
                        </div>
                        <p class="mt-3 {{ $body }} max-w-2xl">{{ $text }}</p>
                    </div>
                @endforeach
            </div>
            <p class="mt-4 text-sm text-ink/60">{{ $g['seasons_note'] }}</p>
        </section>

        {{-- Getting there --}}
        <section id="getting-there" data-spy class="scroll-mt-40 lg:scroll-mt-28">
            <h2 class="{{ $h2 }}">Getting there</h2>
            <dl class="mt-5 sm:mt-6 divide-y divide-ink/10 max-sm:rounded-2xl max-sm:bg-white max-sm:border max-sm:border-ink/5 max-sm:px-4 sm:border-y sm:border-ink/10">
                @foreach ($g['getting_there'] as [$t, $d, $meta])
                    <div class="py-4 sm:py-6 grid md:grid-cols-[13rem_1fr_9.5rem] gap-2 md:gap-8 items-start">
                        <dt class="{{ $h3 }}">{{ $t }}</dt>
                        <dd class="{{ $body }}">{{ $d }}</dd>
                        <dd class="md:text-right"><span class="inline-block rounded-full bg-mist px-3 py-1.5 text-xs font-semibold text-royal">{{ $meta }}</span></dd>
                    </div>
                @endforeach
            </dl>
        </section>

        {{-- Getting around: drive times as bars --}}
        <section id="getting-around" data-spy class="scroll-mt-40 lg:scroll-mt-28">
            <h2 class="{{ $h2 }}">Getting around</h2>
            <div class="mt-6 grid lg:grid-cols-[1fr_1fr] gap-10">
                <div class="space-y-4">@foreach ($g['getting_around'] as $i => $p)@if ($i !== 1)<p class="{{ $body }}">{{ $p }}</p>@endif @endforeach</div>
                <figure class="bg-white border border-ink/5 rounded-3xl p-5 sm:p-8">
                    <figcaption class="font-semibold">Drive time from Gangtok</figcaption>
                    <ul class="mt-5 space-y-4">
                        @foreach ($g['drive'] as [$place, $label, $h])
                            <li class="grid grid-cols-[6.5rem_1fr_4.5rem] items-center gap-3 text-sm">
                                <span>{{ $place }}</span>
                                <span class="h-2.5 rounded-full bg-mist"><span class="block h-full rounded-full bg-royal" style="width: {{ round($h / 6 * 100) }}%"></span></span>
                                <span class="text-right font-semibold tabular-nums">{{ $label }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <p class="mt-5 text-xs text-ink/55">Approximate. Allow extra time in the monsoon.</p>
                </figure>
            </div>
        </section>

        {{-- Regions: one at a time --}}
        <section id="regions" data-spy class="scroll-mt-40 lg:scroll-mt-28" x-data="{ r: 0 }" @region.window="r = $event.detail">
            <h2 class="{{ $h2 }}">Regions and places</h2>
            <div role="tablist" aria-label="Region" class="mt-6 flex gap-2 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden pb-1">
                @foreach ($g['regions'] as $k => $rg)
                    <button role="tab" type="button" @click="r = {{ $k }}" :aria-selected="r === {{ $k }}" class="{{ $pill }}" :class="r === {{ $k }} ? 'bg-ink text-white' : 'bg-mist text-ink/75 hover:text-ink'">{{ $rg['name'] }}</button>
                @endforeach
            </div>
            @foreach ($g['regions'] as $k => $rg)
                <article x-show="r === {{ $k }}" @if ($k) x-cloak @endif role="tabpanel" class="mt-6 grid md:grid-cols-[1.05fr_1fr] gap-8 items-start">
                    <img src="/images/{{ $rg['img'] }}" @dims('/images/'.$rg['img']) alt="{{ $rg['name'] }}" loading="lazy" class="w-full aspect-[4/3] md:aspect-[4/5] rounded-3xl object-cover">
                    <div>
                        <h3 class="font-display font-bold text-3xl">{{ $rg['name'] }}</h3>
                        <dl class="mt-5 grid grid-cols-3 divide-x divide-ink/10 border-y border-ink/10 text-sm">
                            <div class="py-3 pr-3"><dt class="text-ink/55 text-xs">Base</dt><dd class="font-semibold mt-1">{{ $rg['base'] }}</dd></div>
                            <div class="py-3 px-3"><dt class="text-ink/55 text-xs">Plan</dt><dd class="font-semibold mt-1">{{ $rg['days'] }}</dd></div>
                            <div class="py-3 pl-3"><dt class="text-ink/55 text-xs">High point</dt><dd class="font-semibold mt-1">{{ $rg['high'] }}</dd></div>
                        </dl>
                        <p class="mt-5 {{ $body }}">{{ $rg['about'] }}</p>
                        <a href="{{ route('destination', \Illuminate\Support\Str::slug($rg['name'])) }}" class="mt-5 inline-flex items-center gap-2 rounded-full bg-ink text-white text-sm font-semibold pl-5 pr-4 py-3 hover:bg-royal transition-colors">Explore {{ \Illuminate\Support\Str::before($rg['name'], ' ') }} Sikkim <x-icon name="arrow" class="size-4"/></a>
                        <ul class="mt-5 space-y-2.5 text-sm {{ $body }}">
                            @foreach ($rg['highlights'] as $pt)<li class="flex gap-3"><span class="mt-2.5 h-px w-4 bg-royal shrink-0"></span>{{ $pt }}</li>@endforeach
                        </ul>
                    </div>
                </article>
            @endforeach
        </section>

        {{-- Itineraries --}}
        <section id="itineraries" data-spy class="scroll-mt-40 lg:scroll-mt-28" x-data="{ open: 0 }">
            <h2 class="{{ $h2 }}">Sample itineraries</h2>
            <div class="mt-6 space-y-3">
                @foreach ($g['itineraries'] as $k => $it)
                    <div class="bg-white border border-ink/5 rounded-2xl">
                        <button type="button" @click="open = open === {{ $k }} ? -1 : {{ $k }}" :aria-expanded="open === {{ $k }}" class="w-full flex items-center justify-between gap-4 text-left px-6 py-5">
                            <span><span class="block font-display font-bold text-xl">{{ $it['name'] }}</span><span class="block text-sm text-ink/60 mt-1">{{ $it['length'] }} · {{ $it['summary'] }}</span></span>
                            <span class="grid place-items-center size-8 shrink-0 rounded-full transition-all" :class="open === {{ $k }} ? 'bg-royal text-white rotate-45' : 'bg-mist text-royal'">+</span>
                        </button>
                        <div x-show="open === {{ $k }}" @if ($k) x-cloak @endif class="px-6 pb-7">
                            <ol class="ml-2 border-l border-ink/15 pt-1 space-y-5">
                                @foreach ($it['days'] as $i => $day)
                                    <li class="relative pl-7">
                                        <span class="absolute -left-[5px] top-1.5 size-2.5 rounded-full bg-royal ring-4 ring-white"></span>
                                        <p class="text-sm font-bold text-royal">{{ ($it['unit'] ?? 'Day').' '.($i + 1) }}</p>
                                        <p class="mt-1 text-sm {{ $body }}">{{ $day }}</p>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-5 flex flex-wrap items-center justify-between gap-4">
                <p class="text-sm text-ink/60 max-w-xl">{{ $g['itineraries_note'] }}</p>
                <button type="button" @click="pick('')" class="inline-flex items-center gap-3 rounded-full bg-ink text-white font-semibold pl-6 pr-5 py-3.5 hover:bg-royal transition-colors">Plan my trip <x-icon name="arrow" class="size-4"/></button>
            </div>
        </section>

        {{-- Altitude --}}
        <section id="altitude" data-spy class="scroll-mt-40 lg:scroll-mt-28">
            <h2 class="{{ $h2 }}">Altitude and health</h2>
            <div class="mt-6 grid lg:grid-cols-[1.1fr_1fr] gap-10">
                <figure class="bg-white border border-ink/5 rounded-3xl p-5 sm:p-8">
                    <figcaption class="font-semibold">How high each place sits</figcaption>
                    <ul class="mt-5">
                        @foreach ($g['altitudes'] as [$place, $label, $m])
                            <li class="grid grid-cols-[9.5rem_1fr_4.5rem] items-center gap-3 py-1.5 text-sm">
                                <span>{{ $place }}</span>
                                <span class="relative block h-6">
                                    <span class="absolute inset-y-0 left-[46%] border-l border-dashed border-ink/30"></span>
                                    <span class="block h-full rounded-full bg-royal" style="width: {{ max(3, round($m / 5430 * 100)) }}%; opacity: {{ round(0.4 + 0.6 * $m / 5430, 2) }}"></span>
                                </span>
                                <span class="text-right text-xs font-semibold tabular-nums">{{ number_format($m) }} m</span>
                            </li>
                        @endforeach
                    </ul>
                    <p class="mt-4 text-xs text-ink/55">The dashed line marks about 2,500 m (8,200 ft), where altitude sickness risk starts to rise.</p>
                </figure>
                <div>
                    <h3 class="{{ $h3 }}">Stay well at height</h3>
                    <ul class="mt-4 space-y-3">
                        @foreach ($g['health'] as $pt)<li class="flex gap-3 text-sm {{ $body }}"><span class="mt-2.5 h-px w-4 bg-royal shrink-0"></span>{{ $pt }}</li>@endforeach
                    </ul>
                </div>
            </div>
        </section>

        {{-- Packing checklist --}}
        <section id="packing" data-spy class="scroll-mt-40 lg:scroll-mt-28"
                 x-data='{ s: 0, done: [], always: @json($g["packing_always"]), seasonal: @json(array_column($g["packing"], 1)),
                           get items() { return [...this.always, ...this.seasonal[this.s]] },
                           get packed() { return this.items.filter(i => this.done.includes(i)).length },
                           toggle(i) { this.done = this.done.includes(i) ? this.done.filter(x => x !== i) : [...this.done, i] } }'>
            <h2 class="{{ $h2 }}">What to pack</h2>
            <div class="mt-6 flex flex-wrap items-center justify-between gap-4">
                <div role="tablist" aria-label="Season" class="flex flex-wrap gap-2">
                    @foreach ($g['packing'] as $k => $pk)
                        <button role="tab" type="button" @click="s = {{ $k }}" :aria-selected="s === {{ $k }}" class="{{ $pill }}" :class="s === {{ $k }} ? 'bg-ink text-white' : 'bg-mist text-ink/75 hover:text-ink'">{{ $pk[0] }}</button>
                    @endforeach
                </div>
                <p class="text-sm text-ink/65 tabular-nums"><b x-text="packed"></b> of <span x-text="items.length"></span> packed</p>
            </div>
            <div class="mt-3 h-1.5 rounded-full bg-mist"><div class="h-full rounded-full bg-royal transition-all duration-500" :style="`width:${items.length ? packed / items.length * 100 : 0}%`"></div></div>
            <div class="mt-6 grid md:grid-cols-2 gap-x-10 gap-y-8">
                <div>
                    <h3 class="font-semibold text-sm text-ink/60">Always</h3>
                    <ul class="mt-3 space-y-2">
                        <template x-for="i in always" :key="i">
                            <li><button type="button" @click="toggle(i)" :aria-pressed="done.includes(i)" class="w-full flex items-center gap-3 text-left rounded-xl px-3 py-2.5 hover:bg-mist/70 transition-colors">
                                <span class="grid place-items-center size-5 shrink-0 rounded-md border transition-colors" :class="done.includes(i) ? 'bg-royal border-royal text-white' : 'border-ink/25'"><svg x-show="done.includes(i)" viewBox="0 0 16 16" class="size-3.5" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m3.5 8.5 3 3 6-7"/></svg></span>
                                <span class="text-sm" :class="done.includes(i) ? 'text-ink/45 line-through' : ''" x-text="i"></span>
                            </button></li>
                        </template>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-sm text-ink/60">For this season</h3>
                    <ul class="mt-3 space-y-2">
                        <template x-for="i in seasonal[s]" :key="i">
                            <li><button type="button" @click="toggle(i)" :aria-pressed="done.includes(i)" class="w-full flex items-center gap-3 text-left rounded-xl px-3 py-2.5 hover:bg-mist/70 transition-colors">
                                <span class="grid place-items-center size-5 shrink-0 rounded-md border transition-colors" :class="done.includes(i) ? 'bg-royal border-royal text-white' : 'border-ink/25'"><svg x-show="done.includes(i)" viewBox="0 0 16 16" class="size-3.5" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m3.5 8.5 3 3 6-7"/></svg></span>
                                <span class="text-sm" :class="done.includes(i) ? 'text-ink/45 line-through' : ''" x-text="i"></span>
                            </button></li>
                        </template>
                    </ul>
                </div>
            </div>
        </section>

        {{-- Food and culture --}}
        <section id="food-culture" data-spy class="scroll-mt-40 lg:scroll-mt-28">
            <h2 class="{{ $h2 }}">Food and culture</h2>
            <h3 class="{{ $h3 }} mt-8">What to eat</h3>
            {{-- Phones: swipeable dish cards. Add public/images/food/<dish-slug>.jpg (or .webp/.png) to show a photo. --}}
            @php
                $tints = ['bg-rose-100', 'bg-amber-100', 'bg-emerald-100', 'bg-sky-200', 'bg-orange-100', 'bg-violet-100'];
                $dishPhoto = function ($title) {
                    $slug = \Illuminate\Support\Str::slug($title);
                    foreach (['jpg', 'jpeg', 'webp', 'png'] as $ext) {
                        if (file_exists(public_path("images/food/{$slug}.{$ext}"))) { return "/images/food/{$slug}.{$ext}"; }
                    }
                    return null;
                };
            @endphp
            <div class="lg:hidden -mx-5 sm:-mx-8 mt-4 flex gap-4 overflow-x-auto snap-x snap-mandatory scroll-px-5 sm:scroll-px-8 px-5 sm:px-8 pb-2 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                @foreach ($g['food'] as $i => [$t, $d])
                    @php $photo = $dishPhoto($t); @endphp
                    <article class="snap-start shrink-0 w-[68%] sm:w-[38%] rounded-3xl bg-white border border-ink/5 overflow-hidden">
                        @if ($photo)
                            <img src="{{ $photo }}" @dims($photo) alt="{{ $t }}" loading="lazy" class="w-full aspect-[4/3] object-cover">
                        @else
                            <div class="{{ $tints[$i % count($tints)] }} aspect-[4/3] grid place-items-center" aria-hidden="true"><span class="font-display font-bold text-7xl text-ink/20">{{ mb_substr($t, 0, 1) }}</span></div>
                        @endif
                        <div class="p-4">
                            <h4 class="font-display font-bold text-lg leading-snug">{{ $t }}</h4>
                            <p class="mt-1 text-sm {{ $body }}">{{ $d }}</p>
                        </div>
                    </article>
                @endforeach
            </div>

            <p class="lg:hidden mt-1 text-[11px] leading-relaxed text-ink/50">Photos via Wikimedia Commons:
                @foreach ($g['food_credits'] as $slug => [$dish, $author, $lic, $licUrl, $page])
                    <a href="{{ $page }}" target="_blank" rel="noopener" class="underline underline-offset-2">{{ $dish }}</a> by {{ $author }} (<a href="{{ $licUrl }}" target="_blank" rel="noopener" class="underline underline-offset-2">{{ $lic }}</a>)@if (! $loop->last); @else. @endif
                @endforeach
            </p>

            {{-- Tablet and desktop --}}
            <dl class="hidden lg:grid mt-4 lg:grid-cols-3 gap-x-8 gap-y-6">
                @foreach ($g['food'] as [$t, $d])
                    <div class="border-t border-ink/15 pt-4"><dt class="font-display font-bold text-lg">{{ $t }}</dt><dd class="mt-1 text-sm {{ $body }}">{{ $d }}</dd></div>
                @endforeach
            </dl>
            <p class="mt-4 text-sm text-ink/60">{{ $g['food_note'] }}</p>
            <h3 class="{{ $h3 }} mt-12">Culture and etiquette</h3>
            <div class="mt-4 grid md:grid-cols-3 gap-4">
                @foreach ($g['culture'] as [$t, $d])
                    <div class="bg-mist rounded-3xl p-6"><h4 class="font-display font-bold text-lg">{{ $t }}</h4><p class="mt-2 text-sm {{ $body }}">{{ $d }}</p></div>
                @endforeach
            </div>
        </section>

        {{-- Money and connectivity --}}
        <section id="money" data-spy class="scroll-mt-40 lg:scroll-mt-28">
            <h2 class="{{ $h2 }}">Money and connectivity</h2>
            <ul class="sm:hidden mt-5 rounded-2xl bg-white border border-ink/5 divide-y divide-ink/10">
                @foreach ($g['coverage'] as [$area, $atm, $sig])
                    <li class="px-4 py-3.5">
                        <p class="font-semibold">{{ $area }}</p>
                        <dl class="mt-2 grid grid-cols-2 gap-3 text-sm">
                            <div><dt class="text-xs text-ink/55">ATMs</dt><dd class="text-ink/80">{{ $atm }}</dd></div>
                            <div><dt class="text-xs text-ink/55">Mobile signal</dt><dd class="text-ink/80">{{ $sig }}</dd></div>
                        </dl>
                    </li>
                @endforeach
            </ul>
            <div class="hidden sm:block mt-6 overflow-x-auto rounded-3xl border border-ink/10 bg-white">
                <table class="w-full text-left text-sm min-w-[32rem]">
                    <caption class="sr-only">ATM and mobile signal availability by area</caption>
                    <thead><tr class="bg-mist text-ink/70"><th scope="col" class="px-6 py-3 font-semibold">Area</th><th scope="col" class="px-6 py-3 font-semibold">ATMs</th><th scope="col" class="px-6 py-3 font-semibold">Mobile signal</th></tr></thead>
                    <tbody class="divide-y divide-ink/10">
                        @foreach ($g['coverage'] as [$area, $atm, $sig])
                            <tr><th scope="row" class="px-6 py-4 font-semibold">{{ $area }}</th><td class="px-6 py-4 text-ink/75">{{ $atm }}</td><td class="px-6 py-4 text-ink/75">{{ $sig }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <dl class="mt-8 grid md:grid-cols-3 gap-8">
                @foreach ($g['money'] as [$t, $d])<div><dt class="{{ $h3 }}">{{ $t }}</dt><dd class="mt-2 text-sm {{ $body }}">{{ $d }}</dd></div>@endforeach
            </dl>
        </section>

        {{-- Responsible travel --}}
        <section id="responsible" data-spy class="scroll-mt-40 lg:scroll-mt-28">
            <h2 class="{{ $h2 }}">Responsible travel</h2>
            <ul class="mt-6 grid sm:grid-cols-2 gap-x-10 gap-y-4 bg-mist rounded-3xl p-5 sm:p-8">
                @foreach ($g['responsible'] as $pt)<li class="flex gap-3 text-sm {{ $body }}"><span class="mt-2.5 h-px w-4 bg-royal shrink-0"></span>{{ $pt }}</li>@endforeach
            </ul>
        </section>
    </div>
</div>

@include('partials.entry')
</div>
@include('partials.cta')
@endsection

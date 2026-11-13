@extends('layouts.app')
@section('content')
@php
    $slides = config('site.slides');
    $wa = preg_replace('/\D/', '', config('site.phone'));
    $field = 'flex items-center gap-3 px-4 py-3 md:border-l first:border-0 border-ink/10';
    $icon = 'grid place-items-center size-10 shrink-0 rounded-full bg-mist text-royal';
@endphp

{{-- Hero --}}
<section class="hidden md:grid px-5 sm:px-8 pt-4 pb-10 lg:grid-cols-[1fr_1.05fr] gap-10 items-stretch">
    <div class="flex flex-col py-4 lg:py-10">
        <h1 class="font-display font-bold text-5xl sm:text-6xl xl:text-7xl leading-[1.05] text-balance mt-4">Find Your Perfect Escape in Sikkim.</h1>
        <p class="mt-6 text-lg text-ink/70 max-w-md">Monasteries, mountain passes and misty tea gardens. Custom tours planned by locals who call these hills home.</p>
        <div class="mt-8 flex flex-wrap items-center gap-3">
            <a href="{{ route('destinations') }}" class="inline-flex items-center gap-3 rounded-full bg-royal text-white font-semibold pl-7 pr-6 py-4 hover:bg-ink transition-colors">Explore destinations <x-icon name="arrow" class="size-4"/></a>
            <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener" class="inline-flex items-center gap-3 rounded-full px-3 py-2 font-semibold hover:text-royal">
                <span class="grid place-items-center size-11 rounded-full border border-ink/15 bg-white text-royal"><x-icon name="headset" class="size-5"/></span>Talk to a local</a>
        </div>
        <ul class="mt-auto pt-12 grid sm:grid-cols-3 gap-5">
            @foreach ([['shield', 'Permits handled', 'Nathula and North Sikkim sorted for you.'], ['calendar', 'Flexible plans', 'Itineraries built around your dates.'], ['headset', '24/7 support', 'A real person on WhatsApp.']] as [$i, $t, $d])
                <li class="flex gap-3">
                    <span class="{{ $icon }}"><x-icon :name="$i" class="size-5"/></span>
                    <div><b class="text-sm">{{ $t }}</b><p class="text-xs text-ink/60 mt-1">{{ $d }}</p></div>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Auto-changing slider --}}
    <div class="relative order-first lg:order-none min-h-[20rem] sm:min-h-[26rem] lg:min-h-[34rem]" x-data="{ i: 0, n: {{ count($slides) }}, t: null,
            go(k) { this.i = (k + this.n) % this.n; this.run(); },
            run() { clearInterval(this.t); this.t = setInterval(() => this.i = (this.i + 1) % this.n, 4500); } }" x-init="run()">
        <div class="absolute inset-0 rounded-[2rem] overflow-hidden bg-mist">
            @foreach ($slides as $k => [$img, $title])
                <img src="/images/{{ $img }}" alt="{{ $title }}" @if ($k) loading="lazy" @else fetchpriority="high" @endif
                     class="absolute inset-0 size-full object-cover transition-opacity duration-1000" :class="i === {{ $k }} ? 'opacity-100' : 'opacity-0'">
            @endforeach
            <div class="absolute right-5 top-1/2 -translate-y-1/2 flex gap-2">
                <button @click="go(i - 1)" aria-label="Previous photo" class="grid place-items-center size-11 rounded-full bg-white/95 text-ink shadow hover:bg-white"><x-icon name="left"/></button>
                <button @click="go(i + 1)" aria-label="Next photo" class="grid place-items-center size-11 rounded-full bg-white/95 text-ink shadow hover:bg-white"><x-icon name="right"/></button>
            </div>
        </div>
        <div class="absolute left-5 right-5 sm:right-auto bottom-5 sm:w-80 bg-white/95 backdrop-blur rounded-2xl shadow-lg p-5">
            <div class="flex items-start gap-2 text-royal"><x-icon name="pin" class="size-5 mt-0.5 shrink-0"/>
                <div class="text-ink">
                    @foreach ($slides as $k => [$img, $title, $sub])
                        <div x-show="i === {{ $k }}" x-transition.opacity @if ($k) x-cloak @endif><b class="font-display text-lg">{{ $title }}</b><p class="text-sm text-ink/65">{{ $sub }}</p></div>
                    @endforeach
                </div>
            </div>
            <div class="mt-4 flex gap-1.5">
                @foreach ($slides as $k => $s)
                    <button @click="go({{ $k }})" aria-label="Photo {{ $k + 1 }}" class="h-1.5 rounded-full bg-royal transition-all" :class="i === {{ $k }} ? 'w-6' : 'w-1.5 opacity-30'"></button>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Search bar --}}
<section class="hidden md:block px-5 sm:px-8">
    <div class="bg-white rounded-3xl shadow-[0_10px_40px_-20px_rgba(11,27,63,.35)] border border-ink/5 p-3 grid md:grid-cols-[1fr_1fr_1fr_auto] items-center gap-2">
        <label class="{{ $field }}"><span class="{{ $icon }}"><x-icon name="pin"/></span>
            <span class="min-w-0 flex-1"><span class="block text-xs text-ink/55">Where to?</span>
                <select x-model="f.dest" class="w-full bg-transparent font-semibold focus:outline-none">
                    <option value="">Anywhere in Sikkim</option>
                    @foreach (config('site.destinations') as $d)<option>{{ $d[0] }}</option>@endforeach
                </select></span></label>
        <div class="relative" x-data="{ pop: false }" @click.outside="pop = false" @keydown.escape="pop = false" @picked="pop = false">
            <button type="button" @click="pop = !pop" :aria-expanded="pop" class="{{ $field }} w-full text-left"><span class="{{ $icon }}"><x-icon name="calendar"/></span>
                <span class="min-w-0 flex-1"><span class="block text-xs text-ink/55">Travel date</span>
                    <span class="block font-semibold" :class="f.date ? '' : 'text-ink/50'" x-text="f.date ? fmtDate(f.date) : 'Add date'"></span></span></button>
            <div x-show="pop" x-cloak x-transition.opacity class="absolute z-30 left-0 top-full mt-3 w-80 bg-white rounded-2xl border border-ink/10 shadow-[0_20px_50px_-20px_rgba(11,27,63,.4)] p-4">
                <x-calendar />
            </div>
        </div>
        <label class="{{ $field }}"><span class="{{ $icon }}"><x-icon name="users"/></span>
            <span class="min-w-0 flex-1"><span class="block text-xs text-ink/55">Travellers</span>
                <input type="number" inputmode="numeric" min="1" max="50" x-model="f.people" @change="f.people = Guard.people(f.people)" class="w-full bg-transparent font-semibold focus:outline-none"></span></label>
        <button @click="f.pkg = ''; step = f.dest ? 2 : 1; open = true" class="rounded-2xl bg-ink text-white font-semibold px-9 py-4 hover:bg-royal transition-colors">Plan my trip</button>
    </div>
</section>

{{-- ============ Phone app layout ============ --}}
<section class="md:hidden px-5 sm:px-8 pt-2 sm:grid sm:grid-cols-[1fr_1.1fr] sm:gap-6 sm:items-center">
    <div>
    <p class="font-display font-bold text-[2.25rem] sm:text-5xl leading-none sm:leading-[1.05]">Explore Sikkim</p>
    <p class="mt-2 text-ink/60">Trips planned by locals in Gangtok</p>

    <button type="button" @click="pick('')" class="mt-5 w-full flex items-center gap-3 rounded-2xl bg-mist px-4 py-3.5 text-left">
        <x-icon name="search" class="size-5 text-ink/50"/><span class="text-ink/55">Where do you want to go?</span>
    </button>

    {{-- Tablets: quick actions live here, beside the photo --}}
    <div class="hidden sm:grid grid-cols-2 gap-3 mt-5">
        @foreach ([['plane', 'Plan a trip', null, null], ['chat', 'WhatsApp', 'https://wa.me/'.$wa, '_blank'], ['book', 'Travel guide', route('guide'), null], ['shield', 'Permits', route('guide').'#entry', null]] as [$ic, $label, $href, $target])
            @if ($href)<a href="{{ $href }}" @if ($target) target="{{ $target }}" rel="noopener" @endif class="flex items-center gap-3 rounded-2xl bg-white border border-ink/5 p-3.5 shadow-sm">
            @else<button type="button" @click="pick('')" class="flex items-center gap-3 rounded-2xl bg-white border border-ink/5 p-3.5 shadow-sm text-left">@endif
                <span class="grid place-items-center size-10 shrink-0 rounded-xl bg-mist text-royal"><x-icon :name="$ic" class="size-5"/></span>
                <span class="font-semibold text-sm">{{ $label }}</span>
            @if ($href)</a>@else</button>@endif
        @endforeach
    </div>
    </div>

    <div class="relative mt-5 sm:mt-0 aspect-[5/6] sm:aspect-square rounded-[2rem] overflow-hidden bg-mist" x-data="{ i: 0, n: {{ count($slides) }}, t: null, tx: 0,
            go(k) { this.i = (k + this.n) % this.n; this.run(); },
            run() { clearInterval(this.t); this.t = setInterval(() => this.i = (this.i + 1) % this.n, 4500); },
            start(e) { this.tx = e.touches[0].clientX; },
            end(e) { const d = e.changedTouches[0].clientX - this.tx; if (Math.abs(d) > 40) this.go(this.i + (d < 0 ? 1 : -1)); } }"
         x-init="run()" @touchstart.passive="start($event)" @touchend.passive="end($event)">
        @foreach ($slides as $k => [$img, $title])
            <img src="/images/{{ $img }}" alt="{{ $title }}" @if ($k) loading="lazy" @else fetchpriority="high" @endif
                 class="absolute inset-0 size-full object-cover transition-opacity duration-700" :class="i === {{ $k }} ? 'opacity-100' : 'opacity-0'">
        @endforeach
        <span class="absolute inset-0 bg-gradient-to-t from-ink/90 via-ink/30 to-transparent"></span>
        <div class="absolute inset-x-0 bottom-0 p-5 text-white">
            <div class="min-h-[4.25rem]">
                @foreach ($slides as $k => [$img, $title, $sub])
                    <div x-show="i === {{ $k }}" x-transition.opacity @if ($k) x-cloak @endif><p class="font-display font-bold text-2xl">{{ $title }}</p><p class="text-sm text-white/80 mt-1">{{ $sub }}</p></div>
                @endforeach
            </div>
            <div class="mt-4 flex items-center justify-between gap-4">
                <button type="button" @click="pick('')" class="rounded-full bg-white text-ink font-semibold px-5 py-3">Plan this trip</button>
                <div class="flex gap-1.5">
                    @foreach ($slides as $k => $sl)
                        <button type="button" @click="go({{ $k }})" aria-label="Photo {{ $k + 1 }}" class="h-1.5 rounded-full bg-white transition-all" :class="i === {{ $k }} ? 'w-5' : 'w-1.5 opacity-50'"></button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="md:hidden pt-7" aria-label="Regions">
    <div class="flex gap-4 overflow-x-auto snap-x scroll-px-5 px-5 pb-1 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden sm:grid sm:grid-cols-4 sm:gap-3 sm:overflow-visible sm:px-8 sm:pb-0">
        @foreach (config('site.destinations') as [$name, $places, $img])
            <a href="{{ route('destination', \Illuminate\Support\Str::slug($name)) }}" class="snap-start shrink-0 block w-[4.75rem] text-center sm:relative sm:w-auto sm:aspect-[5/4] sm:overflow-hidden sm:rounded-2xl sm:text-left">
                <span class="block size-[4.75rem] rounded-full p-[3px] ring-2 ring-royal sm:size-full sm:rounded-none sm:p-0 sm:ring-0"><img src="/images/{{ $img }}" alt="" loading="lazy" class="size-full rounded-full object-cover sm:rounded-none"></span>
                <span class="mt-2 block text-xs font-semibold sm:absolute sm:inset-x-0 sm:bottom-0 sm:mt-0 sm:px-4 sm:pb-3 sm:pt-10 sm:bg-gradient-to-t sm:from-ink/85 sm:to-transparent sm:text-white sm:text-base sm:font-display sm:font-bold">{{ \Illuminate\Support\Str::before($name, ' ') }}</span>
            </a>
        @endforeach
    </div>
</section>

<section class="sm:hidden px-5 pt-8" aria-label="Quick actions">
    <div class="grid grid-cols-2 gap-3">
        @foreach ([['plane', 'Plan a trip', null, null], ['chat', 'WhatsApp', 'https://wa.me/'.$wa, '_blank'], ['book', 'Travel guide', route('guide'), null], ['shield', 'Permits', route('guide').'#entry', null]] as [$ic, $label, $href, $target])
            @if ($href)<a href="{{ $href }}" @if ($target) target="{{ $target }}" rel="noopener" @endif class="flex items-center gap-3 rounded-2xl bg-white border border-ink/5 p-3.5 shadow-sm">
            @else<button type="button" @click="pick('')" class="flex items-center gap-3 rounded-2xl bg-white border border-ink/5 p-3.5 shadow-sm text-left">@endif
                <span class="grid place-items-center size-10 shrink-0 rounded-xl bg-mist text-royal"><x-icon :name="$ic" class="size-5"/></span>
                <span class="font-semibold text-sm">{{ $label }}</span>
            @if ($href)</a>@else</button>@endif
        @endforeach
    </div>
</section>
{{-- ============ /Phone app layout ============ --}}

{{-- Stats --}}
<section class="px-5 sm:px-8 mt-5">
    <dl class="bg-royal text-white rounded-3xl grid grid-cols-3 divide-x divide-white/20">
        @foreach ([['500+', 'Happy travellers'], ['120+', 'Trips planned'], ['15 yrs', 'Local knowledge']] as [$n, $l])
            <div class="px-2 py-5 sm:px-8 sm:py-8 text-center">
                <dt class="font-display font-bold text-2xl sm:text-5xl lg:text-6xl">{{ $n }}</dt>
                <dd class="mt-1 sm:mt-2 text-xs sm:text-base text-white/80">{{ $l }}</dd>
            </div>
        @endforeach
    </dl>
</section>

{{-- Destinations --}}
<section class="px-5 sm:px-8 pt-16">
    <div class="flex items-center justify-between gap-4 mb-5 sm:mb-8">
        <h2 class="font-display font-bold text-2xl sm:text-4xl">Popular Destinations</h2>
        <a href="{{ route('destinations') }}" class="shrink-0 whitespace-nowrap inline-flex items-center gap-2 rounded-full bg-mist px-4 sm:px-5 py-3 text-sm font-semibold hover:bg-royal hover:text-white transition-colors max-md:bg-transparent max-md:px-0 max-md:text-royal max-md:hover:bg-transparent max-md:hover:text-royal">View all <x-icon name="arrow" class="size-4"/></a>
    </div>
    @include('partials.destinations', ['carousel' => true])
</section>

{{-- Banner --}}
<section class="px-5 sm:px-8 mt-12">
    <div class="bg-royal text-white rounded-3xl p-5 sm:p-10 grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 items-center">
        <div class="flex gap-5 items-center min-w-0">
            <span class="hidden sm:grid place-items-center size-20 shrink-0 rounded-full border border-white/30"><x-icon name="plane" class="size-9"/></span>
            <div>
                <h2 class="font-display font-bold text-2xl sm:text-3xl text-balance">Let's plan your Sikkim trip together</h2>
                <p class="mt-2 text-white/80">Leave your number and we'll send a tailored itinerary within a day.</p>
            </div>
        </div>
        <form @submit.prevent="pick('')" class="min-w-0 flex flex-col sm:flex-row gap-2 sm:bg-white/10 sm:rounded-full sm:p-1.5">
            <label class="sr-only" for="banner-phone">Phone or WhatsApp number</label>
            <input id="banner-phone" type="tel" inputmode="tel" maxlength="20" x-model="f.phone" @input="f.phone = Guard.phone($event.target.value)" placeholder="Your phone / WhatsApp number" autocomplete="tel" class="min-w-0 w-full sm:flex-1 rounded-full bg-white/10 sm:bg-transparent px-5 py-3.5 sm:py-0 placeholder:text-white/70 focus:outline-none">
            <button class="inline-flex items-center justify-center gap-2 rounded-full bg-white text-ink font-semibold pl-6 pr-5 py-3.5 hover:bg-mist">Get itinerary <x-icon name="arrow" class="size-4"/></button>
        </form>
    </div>
</section>

{{-- Packages --}}
<section class="px-5 sm:px-8 pt-14 sm:pt-20" x-data="{ start: true, end: false,
        move(d) { const t = this.$refs.track; const c = t.firstElementChild; t.scrollBy({ left: d * (c.offsetWidth + parseFloat(getComputedStyle(t).columnGap)), behavior: 'smooth' }); },
        sync() { const t = this.$refs.track; this.start = t.scrollLeft < 8; this.end = t.scrollLeft + t.clientWidth >= t.scrollWidth - 8; } }" x-init="sync()">
    <div class="flex items-end justify-between gap-6">
        <h2 class="font-display font-bold text-3xl sm:text-4xl max-w-2xl text-balance">Handpicked trips, ready to customise</h2>
        <div class="flex gap-2 shrink-0">
            <button type="button" @click="move(-1)" :disabled="start" aria-label="Previous trips" class="grid place-items-center size-12 rounded-full border border-ink/15 bg-white hover:bg-ink hover:text-white hover:border-ink transition-colors disabled:opacity-30 disabled:pointer-events-none"><x-icon name="left"/></button>
            <button type="button" @click="move(1)" :disabled="end" aria-label="Next trips" class="grid place-items-center size-12 rounded-full border border-ink/15 bg-white hover:bg-ink hover:text-white hover:border-ink transition-colors disabled:opacity-30 disabled:pointer-events-none"><x-icon name="right"/></button>
        </div>
    </div>
    <div x-ref="track" @scroll.passive="sync()" class="mt-8 flex gap-6 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-2 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
        @foreach (config('site.packages') as [$name, $dur, $img, $price, $points])
            <article class="snap-start shrink-0 w-[85%] sm:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)] bg-white rounded-3xl overflow-hidden border border-ink/5 flex flex-col">
                <div class="relative">
                    <img src="/images/{{ $img }}" alt="{{ $name }}" loading="lazy" class="h-56 w-full object-cover">
                    <span class="absolute top-4 left-4 bg-white/95 text-xs font-bold rounded-full px-3 py-1.5">{{ $dur }}</span>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <h3 class="font-display font-bold text-xl">{{ $name }}</h3>
                    <ul class="mt-3 space-y-1.5 text-sm text-ink/70">
                        @foreach ($points as $pt)<li class="flex items-center gap-3"><span class="h-px w-4 bg-royal shrink-0"></span>{{ $pt }}</li>@endforeach
                    </ul>
                    <div class="mt-auto pt-6 flex items-center justify-between">
                        <p class="text-sm text-ink/60">from <b class="font-display text-xl text-ink">{{ $price }}</b></p>
                        <button @click="pick('{{ $name }}', true)" class="rounded-full bg-ink text-white text-sm font-semibold px-5 py-2.5 hover:bg-royal transition-colors">Enquire</button>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</section>

{{-- Experiences --}}
@php $exp = config('site.experiences'); @endphp
{{-- Phones: swipeable experience cards --}}
<section class="md:hidden pt-14" aria-label="Experiences">
    <div class="px-5 sm:px-8">
        <h2 class="font-display font-bold text-2xl">More than sightseeing</h2>
        <p class="mt-1 text-sm text-ink/60">Add something unforgettable to any itinerary.</p>
    </div>
    <div class="mt-5 flex gap-4 overflow-x-auto snap-x snap-mandatory scroll-px-5 px-5 sm:scroll-px-8 sm:px-8 pb-2 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
        @foreach ($exp as [$t, $d, $img])
            <article class="relative snap-start shrink-0 w-[78%] sm:w-[42%] aspect-[3/4] rounded-3xl overflow-hidden text-white bg-mist">
                <img src="/images/{{ $img }}" alt="" loading="lazy" class="absolute inset-0 size-full object-cover">
                <span class="absolute inset-0 bg-gradient-to-t from-ink/90 via-ink/30 to-transparent"></span>
                <div class="absolute inset-x-0 bottom-0 p-5">
                    <h3 class="font-display font-bold text-2xl">{{ $t }}</h3>
                    <p class="mt-1 text-sm text-white/85">{{ $d }}</p>
                    <button type="button" @click="pick('')" class="mt-4 inline-flex items-center gap-2 rounded-full bg-white text-ink text-sm font-semibold pl-4 pr-3.5 py-2.5">Add to my trip <x-icon name="arrow" class="size-4"/></button>
                </div>
            </article>
        @endforeach
    </div>
</section>

<section class="hidden md:block px-5 sm:px-8 pt-16 sm:pt-24" x-data="{ a: 0 }">
    <div class="grid lg:grid-cols-[1fr_1fr] gap-10 lg:gap-16 items-center">
        <div class="relative aspect-[4/4.4] rounded-[2rem] overflow-hidden bg-mist order-2 lg:order-1">
            @foreach ($exp as $k => [$t, $d, $img])
                <img src="/images/{{ $img }}" alt="{{ $t }}" loading="lazy"
                     class="absolute inset-0 size-full object-cover transition-all duration-700 ease-out"
                     :class="a === {{ $k }} ? 'opacity-100 scale-100' : 'opacity-0 scale-105'">
            @endforeach
            <div class="absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-ink/60 to-transparent"></div>
            <p class="absolute left-6 bottom-5 font-display text-2xl text-white" x-text="['{{ implode("','", array_column($exp, 0)) }}'][a]"></p>
        </div>
        <div class="order-1 lg:order-2">
            <h2 class="font-display font-bold text-3xl sm:text-5xl text-balance leading-tight">More than sightseeing</h2>
            <p class="mt-4 text-ink/70 max-w-sm">Add something unforgettable to any itinerary.</p>
            <ul class="mt-8 border-t border-ink/10">
                @foreach ($exp as $k => [$t, $d])
                    <li class="border-b border-ink/10">
                        <button type="button" @mouseenter="a = {{ $k }}" @focus="a = {{ $k }}" @click="a = {{ $k }}"
                                class="w-full text-left py-5 flex items-start justify-between gap-4 group" :aria-expanded="a === {{ $k }}">
                            <span>
                                <span class="block font-display text-2xl transition-colors" :class="a === {{ $k }} ? 'text-royal' : 'text-ink/55 group-hover:text-ink'">{{ $t }}</span>
                                <span class="grid transition-all duration-500 ease-out" :class="a === {{ $k }} ? 'grid-rows-[1fr] opacity-100 mt-2' : 'grid-rows-[0fr] opacity-0'">
                                    <span class="overflow-hidden text-ink/70">{{ $d }}</span>
                                </span>
                            </span>
                            <span class="mt-1 grid place-items-center size-9 shrink-0 rounded-full border transition-colors"
                                  :class="a === {{ $k }} ? 'bg-royal border-royal text-white' : 'border-ink/15 text-ink/40'"><x-icon name="arrow" class="size-4"/></span>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

{{-- When to go: each card has a quiet weather scene that explains the season --}}
<section class="pt-14 sm:pt-20" x-data="{ off: false }" x-init="new IntersectionObserver(([e]) => off = !e.isIntersecting).observe($el)" :class="off ? 'season-paused' : ''">
    <h2 class="px-5 sm:px-8 font-display font-bold text-2xl sm:text-4xl">When to go</h2>
    <div class="mt-5 sm:mt-8 flex gap-4 overflow-x-auto snap-x snap-mandatory scroll-px-5 px-5 pb-2 sm:px-8 sm:grid sm:grid-cols-2 lg:grid-cols-4 sm:overflow-visible [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
        @foreach (config('site.seasons') as [$months, $name, $d, $bg])
            <article class="{{ $bg }} relative snap-start shrink-0 w-[78%] sm:w-auto rounded-3xl p-5 sm:p-6 min-h-52 overflow-hidden isolate">
                @include('partials.season-scene', ['season' => strtolower($name)])
                <div class="relative">
                    <p class="text-xs font-bold uppercase tracking-widest text-ink/60">{{ $months }}</p>
                    <h3 class="font-display font-bold text-2xl mt-2">{{ $name }}</h3>
                    <p class="text-sm text-ink/80 mt-2 max-w-[16rem]">{{ $d }}</p>
                </div>
            </article>
        @endforeach
    </div>
</section>

@include('partials.entry')

{{-- Why us --}}
<section class="mx-5 sm:mx-8 mt-20 bg-mist rounded-[2rem] px-5 sm:px-10 py-10 sm:py-14">
    <h2 class="font-display font-bold text-3xl sm:text-4xl max-w-xl text-balance">Why travel with us?</h2>
    <dl class="mt-10 grid sm:grid-cols-2 gap-x-16 gap-y-8">
        @foreach (config('site.why') as [$t, $d])
            <div class="border-t border-ink/20 pt-5"><dt class="font-display font-bold text-xl">{{ $t }}</dt><dd class="text-ink/75 mt-2 max-w-md">{{ $d }}</dd></div>
        @endforeach
    </dl>
</section>

{{-- Steps --}}
<section class="px-5 sm:px-8 pt-14 sm:pt-20">
    <h2 class="font-display font-bold text-3xl sm:text-4xl text-center">Plan a trip in three steps</h2>
    <div class="mt-10 grid md:grid-cols-3 gap-8">
        @foreach (config('site.steps') as $i => [$t, $d])
            <div class="text-center px-4">
                <span class="mx-auto grid place-items-center size-14 rounded-full bg-royal text-white font-display font-bold text-xl">{{ $i + 1 }}</span>
                <h3 class="font-display font-bold text-xl mt-4">{{ $t }}</h3>
                <p class="text-ink/70 mt-2">{{ $d }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- Reviews --}}
@php $reviews = config('site.reviews'); @endphp
<section class="px-5 sm:px-8 pt-14 sm:pt-20" x-data="{ r: 0, n: {{ count($reviews) }}, t: null,
        go(k) { this.r = (k + this.n) % this.n; this.run(); },
        run() { clearInterval(this.t); this.t = setInterval(() => this.r = (this.r + 1) % this.n, 7000); } }" x-init="run()">
    <div class="rounded-[2rem] bg-mist grid lg:grid-cols-[1fr_2fr] gap-6 lg:gap-12 p-5 sm:p-8 items-center">
        <div>
            <h2 class="font-display font-bold text-2xl sm:text-3xl text-balance">Words from travellers</h2>
            <div class="mt-5 flex items-center gap-3">
                <button type="button" @click="go(r - 1)" aria-label="Previous review" class="grid place-items-center size-10 rounded-full border border-ink/15 bg-white hover:bg-ink hover:text-white hover:border-ink transition-colors"><x-icon name="left" class="size-4"/></button>
                <button type="button" @click="go(r + 1)" aria-label="Next review" class="grid place-items-center size-10 rounded-full border border-ink/15 bg-white hover:bg-ink hover:text-white hover:border-ink transition-colors"><x-icon name="right" class="size-4"/></button>
                <span class="text-sm text-ink/55 tabular-nums" x-text="(r + 1) + ' / ' + n"></span>
            </div>
        </div>
        <div class="grid bg-white rounded-3xl p-5 sm:p-8">
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
@php $posts = config('blog.posts'); $lead = $posts[0]; $rest = array_slice($posts, 1, 2); @endphp
<section class="px-5 sm:px-8 pt-16 sm:pt-24">
    <div class="flex items-center justify-between gap-4 mb-8">
        <h2 class="font-display font-bold text-3xl sm:text-4xl">From the blog</h2>
        <a href="{{ route('blog') }}" class="shrink-0 whitespace-nowrap inline-flex items-center gap-2 rounded-full bg-mist px-4 sm:px-5 py-3 text-sm font-semibold hover:bg-royal hover:text-white transition-colors">All posts <x-icon name="arrow" class="size-4"/></a>
    </div>
    <div class="grid lg:grid-cols-[1.4fr_1fr] gap-6">
        <a href="{{ route('post', $lead['slug']) }}" class="group relative block min-h-[26rem] rounded-3xl overflow-hidden">
            <img src="/images/{{ $lead['img'] }}" alt="" loading="lazy" class="absolute inset-0 size-full object-cover group-hover:scale-105 transition duration-700">
            <span class="absolute inset-0 bg-gradient-to-t from-ink/80 via-ink/20 to-transparent"></span>
            <span class="absolute inset-x-0 bottom-0 p-7 text-white">
                <span class="block font-display font-bold text-2xl sm:text-3xl max-w-md text-balance">{{ $lead['title'] }}</span>
                <span class="block mt-2 text-white/80 max-w-md">{{ $lead['excerpt'] }}</span>
                <span class="mt-4 inline-flex items-center gap-2 text-sm font-semibold">Read more <x-icon name="arrow" class="size-4 group-hover:translate-x-1 transition-transform"/></span>
            </span>
        </a>
        <div class="grid gap-6">
            @foreach ($rest as $p)
                <a href="{{ route('post', $p['slug']) }}" class="group flex flex-col sm:flex-row lg:flex-col xl:flex-row gap-5 bg-white rounded-3xl border border-ink/5 p-3 hover:shadow-lg transition">
                    <img src="/images/{{ $p['img'] }}" alt="" loading="lazy" class="sm:w-44 lg:w-full xl:w-44 h-40 sm:h-auto lg:h-40 xl:h-auto rounded-2xl object-cover shrink-0">
                    <span class="flex flex-col justify-center p-2">
                        <span class="font-display font-bold text-xl group-hover:text-royal transition-colors">{{ $p['title'] }}</span>
                        <span class="mt-2 text-sm text-ink/65">{{ $p['excerpt'] }}</span>
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="mx-5 sm:mx-8 my-16 sm:my-24 bg-mist rounded-[2rem] px-5 sm:px-10 py-10 sm:py-14 grid lg:grid-cols-[1fr_1.4fr] gap-10 lg:gap-16" x-data="{ o: 0 }">
    <div>
        <h2 class="font-display font-bold text-3xl sm:text-4xl text-balance">Questions, answered</h2>
        <p class="mt-4 text-ink/70 max-w-sm">Everything first-time visitors ask about permits, timing and payment.</p>
        <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener" class="mt-8 inline-flex items-center gap-3 rounded-full bg-ink text-white font-semibold pl-6 pr-5 py-3.5 hover:bg-royal transition-colors">Ask us on WhatsApp <x-icon name="arrow" class="size-4"/></a>
        <p class="mt-6"><a href="{{ route('faq') }}" class="text-sm font-semibold text-royal">See all FAQs →</a></p>
    </div>
    <div class="space-y-3">
        @foreach (collect(config('faq.items'))->where('home', true)->values() as $k => $faq)
            @php [$q, $a] = [$faq['q'], $faq['a']]; @endphp
            <div class="bg-white rounded-2xl border border-ink/5">
                <button type="button" @click="o = o === {{ $k }} ? -1 : {{ $k }}" :aria-expanded="o === {{ $k }}" class="w-full flex items-center justify-between gap-4 text-left px-6 py-5 font-semibold">
                    {{ $q }}
                    <span class="grid place-items-center size-8 shrink-0 rounded-full transition-all" :class="o === {{ $k }} ? 'bg-royal text-white rotate-45' : 'bg-mist text-royal'">+</span>
                </button>
                <div class="grid transition-all duration-300 ease-out" :class="o === {{ $k }} ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
                    <p class="overflow-hidden px-6 text-ink/70"><span class="block pb-5">{{ $a }}</span></p>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection

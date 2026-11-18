@php
    $brand = config('site.brand');
    $phone = config('site.phone');
    $wa = preg_replace('/\D/', '', $phone);
@endphp
<!DOCTYPE html>
<html lang="en-IN">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#475332">
    <link rel="icon" href="/favicon.ico" sizes="48x48">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16.png">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    <title>@yield('title', $brand.' - Sikkim Tour Packages from Gangtok')</title>
    <meta name="description" content="@yield('description', 'Custom Sikkim tour packages from Gangtok to Pelling, Lachung and Gurudongmar, with permits and stays arranged by a local team.')">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ $brand }}">
    <meta property="og:locale" content="en_IN">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('title', $brand.' - Sikkim Tour Packages from Gangtok')">
    <meta property="og:description" content="@yield('description', 'Custom Sikkim tour packages from Gangtok to Pelling, Lachung and Gurudongmar, with permits and stays arranged by a local team.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', url('/images/all-sikkim.webp'))">
    <meta name="twitter:card" content="summary_large_image">
    <script type="application/ld+json">{!! json_encode([
        '@@context' => 'https://schema.org', '@@type' => ['Organization', 'TravelAgency'],
        'name' => $brand, 'legalName' => config('site.legal_name'), 'url' => url('/'), 'telephone' => $phone, 'email' => config('site.email'),
        'identifier' => config('site.udyam'),
        'address' => ['@@type' => 'PostalAddress', 'streetAddress' => 'Bering, Kerabari', 'addressLocality' => 'Pakyong', 'addressRegion' => 'Sikkim', 'postalCode' => '737106', 'addressCountry' => 'IN'],
        'logo' => url('/apple-touch-icon.png'), 'image' => url('/images/all-sikkim.webp'),
        'areaServed' => 'Sikkim, India',
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    <script type="application/ld+json">{!! json_encode([
        '@@context' => 'https://schema.org', '@@type' => 'WebSite',
        'name' => $brand, 'url' => url('/'), 'inLanguage' => 'en',
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600&family=Noto+Serif:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">
    @stack('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
</head>
<body class="bg-paper text-ink font-sans antialiased" data-wa="{{ $wa }}" data-dest="{{ json_encode(\App\Support\ContentRepository::destinations()->pluck('name')->push('Not sure yet')->values()) }}" data-regions="{{ json_encode(\App\Support\ContentRepository::destinations()->map(fn ($d) => ['name' => $d['name'], 'places' => $d['places_line'] ?: $d['tagline'], 'img' => $d['img_url']])->values()) }}" x-data="trip()" @keydown.escape.window="close()" x-effect="document.documentElement.style.overflow = open ? 'hidden' : ''">

{{-- Announcement bar + header --}}
<div class="bg-royal text-paper text-center text-[10px] sm:text-[11px] tracking-[.2em] uppercase py-2.5 px-4">Locally rooted · Thoughtfully planned · Made for the mountains</div>
<header class="sticky top-0 z-40 bg-paper border-b border-ink/10 pt-[env(safe-area-inset-top)]">
    <span id="scroll-progress" aria-hidden="true" class="absolute inset-x-0 bottom-0 h-0.5 bg-star" style="transform: scaleX(0); transform-origin: left"></span>
    <div class="mx-auto max-w-[1240px] px-5 sm:px-8 h-[72px] flex items-center justify-between gap-4">
        <a href="{{ route('home') }}" class="flex items-center min-h-11" aria-label="{{ $brand }}, home">
            <img src="/images/brand/himalio-logo-green-600.webp" srcset="/images/brand/himalio-logo-green-600.webp 1x, /images/brand/himalio-logo-green-1200.webp 2x" alt="{{ $brand }}" width="600" height="232" class="h-11 md:h-12 w-auto">
        </a>
        <nav class="hidden md:flex gap-8 text-[11px] font-medium uppercase tracking-[.14em]" aria-label="Main">
            @foreach (config('site.nav') as $label => $r)
                <a href="{{ route($r) }}" class="py-2 border-b {{ request()->routeIs($r) || ($r === 'blog' && request()->routeIs('post')) || ($r === 'destinations' && request()->routeIs('destination')) ? 'text-royal border-royal' : 'border-transparent text-ink/75 hover:text-royal' }}">{{ $label }}</a>
            @endforeach
        </nav>
        <div class="flex items-center gap-1 sm:gap-2">
            <a href="{{ route('faq') }}" aria-label="FAQ" class="md:hidden grid place-items-center size-11 text-royal"><x-glyph name="help" class="size-6"/></a>
            <a href="https://wa.me/{{ $wa }}?text=Hi%2C%20I%27d%20like%20to%20plan%20a%20Sikkim%20trip" target="_blank" rel="noopener" aria-label="Chat on WhatsApp"
               class="grid place-items-center size-11 md:size-10 text-royal hover:text-ink transition-colors">
                <svg viewBox="0 0 24 24" class="size-6 md:size-5 fill-current" aria-hidden="true"><path d="M12 2a10 10 0 0 0-8.6 15L2 22l5.1-1.3A10 10 0 1 0 12 2Zm5.8 14.2c-.2.7-1.4 1.3-2 1.3-.5.1-1.2.1-1.9-.1-.4-.1-1-.3-1.7-.6-3-1.3-5-4.3-5.1-4.5-.1-.2-1.2-1.6-1.2-3s.8-2.1 1-2.4c.3-.3.6-.3.8-.3h.6c.2 0 .4 0 .6.5l.9 2.1c.1.2.1.4 0 .5l-.4.6-.4.4c-.1.2-.3.3-.1.6.2.3.8 1.3 1.7 2.1 1.2 1 2.2 1.4 2.5 1.5.3.1.5.1.7-.1l.9-1.1c.2-.3.4-.2.6-.1l2 1c.3.1.5.2.5.3.1.2.1.8-.1 1.5Z"/></svg>
            </a>
            <button type="button" @click="pick('')" class="btn btn-solid !px-4 !py-2.5 max-md:min-h-11 max-md:!rounded-[999px] max-md:!normal-case max-md:!tracking-normal max-md:!text-sm md:!px-5 md:!py-3"><span class="md:hidden">Plan trip</span><span class="max-md:hidden">Plan your journey</span></button>
        </div>
    </div>
</header>

<main class="mx-auto max-w-[1240px] pb-12 sm:pb-24">@yield('content')</main>

<footer class="bg-ink text-paper">
<div class="mx-auto max-w-[1240px] px-5 sm:px-8 pt-12 md:pt-14 pb-32 md:pb-14">
    <div class="grid md:grid-cols-[1.4fr_1fr_1fr] gap-8 md:gap-10">
        <div>
            <a href="{{ route('home') }}" class="inline-block py-1" aria-label="{{ $brand }}, home"><img src="/images/brand/himalio-logo-white-600.webp" srcset="/images/brand/himalio-logo-white-600.webp 1x, /images/brand/himalio-logo-white-1200.webp 2x" alt="{{ $brand }}" width="600" height="232" loading="lazy" class="h-16 w-auto"></a>
            <p class="mt-3 md:mt-4 text-paper/70 max-w-xs">Thoughtful journeys through Sikkim and the Eastern Himalayas, planned by locals in Sikkim.</p>
            <p class="mt-4 text-sm text-paper/55 max-w-xs">{{ config('site.legal_name') }}<br>{{ implode(', ', config('site.address')) }}<br>Udyam Registration No. {{ config('site.udyam') }}</p>
        </div>
        <nav aria-label="Footer" class="md:grid md:gap-3 md:content-start text-paper/80">
            <p class="kicker text-paper/50 mb-3 md:mb-1">Explore</p>
            <div class="grid grid-cols-2 gap-px max-md:bg-paper/10 max-md:border max-md:border-paper/10 max-md:rounded-[0.75rem] max-md:overflow-hidden md:contents">
                @foreach (config('site.nav') as $label => $r)<a href="{{ route($r) }}" class="max-md:last:odd:col-span-2 max-md:bg-ink max-md:px-4 max-md:py-3.5 max-md:text-[15px] max-md:active:bg-paper/10 hover:text-white">{{ $label }}</a>@endforeach
            </div>
        </nav>
        <div class="md:grid md:gap-3 md:content-start text-paper/80">
            <p class="kicker text-paper/50 mb-3 md:mb-1">Contact</p>
            <div class="grid grid-cols-2 gap-2 md:contents">
                <a href="tel:+{{ $wa }}" class="max-md:flex max-md:items-center max-md:justify-center max-md:gap-2 max-md:border max-md:border-paper/25 max-md:rounded-[0.75rem] max-md:py-3.5 max-md:text-[15px] hover:text-white"><x-glyph name="phone" class="size-5 md:hidden"/><span class="max-md:hidden">{{ $phone }}</span><span class="md:hidden">Call</span></a>
                <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener" class="max-md:flex max-md:items-center max-md:justify-center max-md:gap-2 max-md:border max-md:border-paper/25 max-md:rounded-[0.75rem] max-md:py-3.5 max-md:text-[15px] hover:text-white"><x-glyph name="chat" class="size-5 md:hidden"/>Chat on WhatsApp</a>
            </div>
            <p class="md:hidden mt-3 text-sm text-paper/60">{{ $phone }}</p>
            <a href="https://indianfrro.gov.in/efrro/" target="_blank" rel="noopener" class="max-md:mt-1 max-md:inline-block max-md:py-3 max-md:text-sm max-md:underline max-md:underline-offset-4 max-md:text-paper/70 hover:text-white">FRRO registration for foreign nationals</a>
        </div>
    </div>
    <div class="mt-10 md:mt-12 pt-6 border-t border-paper/15 flex flex-wrap items-center justify-between gap-x-8 gap-y-3 text-sm text-paper/65 max-md:text-[13px]">
        <p class="flex gap-6 max-md:order-1"><a href="{{ route('terms') }}" class="hover:text-white">Terms and conditions</a><a href="{{ route('privacy') }}" class="hover:text-white">Privacy policy</a></p>
        <p class="max-md:order-2 basis-full md:basis-auto md:order-first">© {{ date('Y') }} {{ $brand }}. All rights reserved.</p>
        <p class="max-md:order-3 basis-full sm:basis-auto">Site developed and maintained from Sikkim by <a href="https://dhungkartechnology.in/" target="_blank" rel="noopener" class="underline underline-offset-2 hover:text-white">Dhungkar Technology</a></p>
    </div>
</div>
</footer>

{{-- Mobile bottom navigation: floating iOS-style bar, the current page expands into a labelled pill --}}
<nav aria-label="Primary" class="tabbar md:hidden fixed inset-x-4 sm:inset-x-auto sm:left-1/2 sm:-translate-x-1/2 sm:w-[30rem] bottom-[max(1rem,env(safe-area-inset-bottom))] z-40 rounded-[1.75rem] border border-ink/10 shadow-lg px-2 py-2 flex items-center justify-between">
    @foreach ([['home', 'Home', 'home'], ['destinations', 'Destinations', 'pin'], ['guide', 'Guide', 'book'], ['blog', 'Blog', 'newspaper'], ['contact', 'Contact', 'phone']] as [$r, $label, $icon])
        @php $on = request()->routeIs($r) || ($r === 'blog' && request()->routeIs('post')) || ($r === 'destinations' && request()->routeIs('destination')); @endphp
        <a href="{{ route($r) }}" @if ($on) aria-current="page" @endif aria-label="{{ $label }}"
           class="flex items-center gap-2 h-12 rounded-[999px] transition-colors {{ $on ? 'bg-royal text-white pl-4 pr-5' : 'text-ink/70 px-3.5 hover:bg-mist' }}">
            <x-glyph :name="$icon" class="size-5 shrink-0"/>@if ($on)<span class="text-sm font-semibold">{{ $label }}</span>@endif
        </a>
    @endforeach
</nav>

{{-- Trip planner modal: experience cards, a four-step "Build your trip" section with review and edit, then contact details --}}
<div x-show="open" x-cloak x-transition.opacity.duration.250ms class="glass-scrim fixed inset-x-0 top-[var(--vvt,0px)] h-[var(--vvh,100dvh)] z-50 flex items-end md:items-center justify-center md:p-6" @click.self="close()">
    <div x-ref="panel" x-show="open" x-transition:enter="transition duration-500 ease-[cubic-bezier(.32,.72,0,1)]" x-transition:enter-start="translate-y-full md:translate-y-4 md:opacity-0" x-transition:enter-end="translate-y-0"
         x-transition:leave="transition duration-200 ease-in" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full md:opacity-0"
         :style="dy ? `transform: translateY(${dy}px); transition: none` : ''"
         class="bg-paper w-full max-w-4xl h-[94%] md:h-auto md:max-h-[90%] flex flex-col shadow-[0_30px_80px_-20px_rgba(20,28,12,.5)]" role="dialog" aria-modal="true" aria-labelledby="planner-title">
        <div class="md:hidden px-5 pt-3 pb-1 touch-none shrink-0" @touchstart.passive="ty = $event.touches[0].clientY" @touchmove.passive="dy = Math.max(0, $event.touches[0].clientY - ty)" @touchend="dy > 110 ? close() : dy = 0; ty = null">
            <span class="block mx-auto h-1 w-10 bg-ink/20"></span>
        </div>
        <form novalidate @submit.prevent="send()" class="flex flex-col min-h-0 flex-1">
            <div x-ref="body" class="overflow-y-auto overscroll-contain flex-1 min-h-0 pb-10" @focusin="if ($event.target.matches('input:not([type=radio]):not([type=checkbox]), textarea')) setTimeout(() => $event.target.scrollIntoView({ block: 'center', behavior: 'smooth' }), 350)">
                <div class="px-5 sm:px-10 pt-4 md:pt-10 flex items-start justify-between gap-6">
                    <div>
                        <h3 id="planner-title" class="font-display text-2xl sm:text-4xl text-royal">Plan your journey</h3>
                        <p class="mt-2 text-ink/65 max-w-md max-lg:hidden">Choose how you want to travel and tell us the basics. We reply with a tailored quote within a day.</p>
                        <p x-show="f.pkg" x-text="'Package: ' + f.pkg" class="mt-3 inline-block bg-mist px-3 py-1.5 text-sm font-medium text-royal"></p>
                    </div>
                    <button type="button" @click="close()" class="grid place-items-center size-10 -mr-2 text-2xl leading-none text-ink/70 hover:text-ink" aria-label="Close">×</button>
                </div>
                {{-- Small screens: the whole planner is one six-step flow --}}
                <div class="lg:hidden px-5 sm:px-10 mt-4" x-show="!wide">
                    <div class="flex items-baseline justify-between text-xs text-ink/60"><span x-text="'Step ' + mnum + ' of 6'"></span><span x-text="mlabels[mnum - 1]"></span></div>
                    <div class="mt-2 grid grid-cols-6 gap-1" aria-hidden="true"><template x-for="n in 6"><span class="h-1 transition-colors" :class="n <= mnum ? 'bg-royal' : 'bg-ink/15'"></span></template></div>
                </div>

                {{-- Experience --}}
                <fieldset class="px-5 sm:px-10 mt-8" x-show="wide || mexp">
                    <legend class="font-display text-2xl lg:text-xl">Choose your experience</legend>
                    <div class="mt-4 grid md:grid-cols-3 gap-3">
                        <template x-for="t in tiers" :key="t.name">
                            <label class="block cursor-pointer">
                                <input type="radio" name="tier" :value="t.name" x-model="f.tier" class="peer sr-only">
                                <span class="block h-full border border-ink/20 bg-white p-4 sm:p-5 transition-colors hover:border-royal peer-checked:border-royal peer-checked:bg-mist peer-checked:shadow-[inset_0_0_0_1px_var(--color-royal)] peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-star">
                                    <span class="flex items-baseline justify-between gap-3"><span class="font-display text-xl" x-text="t.name"></span><span class="text-[11px] uppercase tracking-[.14em] text-ink/60" x-text="t.tag"></span></span>
                                    <span class="mt-1 block text-sm text-ink/65" x-text="t.line"></span>
                                    <ul x-show="wide || f.tier === t.name" class="mt-3 space-y-1 text-sm text-ink/75"><template x-for="i in t.items" :key="i"><li class="flex gap-2"><span class="mt-2 h-px w-3 bg-royal shrink-0"></span><span x-text="i"></span></li></template></ul>
                                </span>
                            </label>
                        </template>
                    </div>
                    <p class="mt-3 text-xs text-ink/60">Inclusions are confirmed for each itinerary. Meals, permits and activities depend on route availability and package terms.</p>
                </fieldset>

                {{-- Build your trip: four steps, then a saved summary --}}
                <section x-ref="build" x-show="wide || !mexp" class="mx-5 sm:mx-10 mt-8 lg:mt-10 lg:border lg:border-ink/15 lg:bg-white scroll-mt-4" aria-labelledby="build-title">
                    <div class="max-lg:hidden px-5 sm:px-7 pt-5 pb-4 border-b border-ink/10">
                        <div class="flex items-baseline justify-between gap-4">
                            <h4 id="build-title" class="font-display text-xl" x-text="review ? 'Your trip' : 'Build your trip'"></h4>
                            <p class="text-xs text-ink/60" x-text="review ? 'Saved' : 'Step ' + step + ' of 4'"></p>
                        </div>
                        <div class="mt-3 grid grid-cols-4 gap-1.5" aria-hidden="true"><template x-for="n in 4"><span class="h-1 transition-colors" :class="review || n <= step ? 'bg-royal' : 'bg-ink/15'"></span></template></div>
                    </div>

                    <div class="lg:px-7 lg:py-6">
                        <h4 x-show="!review" class="lg:hidden font-display text-2xl mb-1" x-text="titles[step - 1]"></h4>
                        <h4 x-show="review" x-cloak class="lg:hidden font-display text-2xl mb-1">Review your trip</h4>
                        {{-- 1. Destinations --}}
                        <fieldset x-show="!review && step === 1">
                            <legend class="font-medium max-lg:sr-only">Where would you like to go?</legend>
                            <p class="mt-1 text-sm text-ink/65">Choose every region you want to see. You can pick more than one.</p>
                            <div class="mt-4" x-data="{ more: false, start: true, end: true,
                                    sync() { const t = this.$refs.track; this.more = t.scrollWidth > t.clientWidth + 4; this.start = t.scrollLeft < 4; this.end = t.scrollLeft + t.clientWidth >= t.scrollWidth - 4; },
                                    move(d) { const t = this.$refs.track; t.scrollBy({ left: d * t.clientWidth * .8, behavior: 'smooth' }); } }"
                                 x-init="$nextTick(() => sync())" @resize.window.debounce="sync()">
                                <div x-show="more" x-cloak class="mb-3 flex justify-end gap-2">
                                    <button type="button" @click="move(-1)" :disabled="start" aria-label="Previous regions" class="grid place-items-center size-10 border border-royal/40 text-royal hover:bg-royal hover:text-white transition-colors disabled:opacity-30 disabled:pointer-events-none"><x-glyph name="left"/></button>
                                    <button type="button" @click="move(1)" :disabled="end" aria-label="Next regions" class="grid place-items-center size-10 border border-royal/40 text-royal hover:bg-royal hover:text-white transition-colors disabled:opacity-30 disabled:pointer-events-none"><x-glyph name="right"/></button>
                                </div>
                                <div x-ref="track" @scroll.passive="sync()" class="flex gap-3 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-1 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                                    <template x-for="r in regions" :key="r.name">
                                        <label class="block cursor-pointer snap-start shrink-0 w-[62%] sm:w-[calc(33.333%-.5rem)] md:w-[calc(25%-.5625rem)]">
                                            <input type="checkbox" :value="r.name" :checked="f.dests.includes(r.name)" @change="toggleDest(r.name)" class="peer sr-only">
                                            <span class="relative block border border-ink/20 bg-white transition-colors hover:border-royal peer-checked:border-royal peer-checked:shadow-[inset_0_0_0_1px_var(--color-royal)] peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-star peer-checked:[&_.tick]:opacity-100">
                                                <span class="block aspect-[4/3] overflow-hidden bg-mist"><img :src="r.img" alt="" loading="lazy" class="size-full object-cover"></span>
                                                <span class="tick absolute top-2 right-2 grid place-items-center size-6 bg-royal text-white opacity-0 transition-opacity"><x-glyph name="check" class="size-4"/></span>
                                                <span class="block px-3 py-2.5"><span class="block font-display text-base" x-text="r.name"></span><span class="block mt-0.5 text-xs text-ink/60 leading-snug" x-text="r.places"></span></span>
                                            </span>
                                        </label>
                                    </template>
                                </div>
                            </div>
                            <label class="mt-3 flex items-center gap-3 border border-ink/20 bg-white px-4 py-3 cursor-pointer text-sm font-medium has-[:checked]:border-royal has-[:checked]:bg-mist">
                                <input type="checkbox" :checked="f.dests.includes('Not sure yet')" @change="toggleDest('Not sure yet')" class="size-4 accent-[#44532e]"> Not sure yet, suggest a route for me
                            </label>
                        </fieldset>

                        {{-- 2. Traveller and season --}}
                        <div x-show="!review && step === 2" x-cloak class="grid lg:grid-cols-2 gap-x-8 gap-y-8 text-sm">
                            <x-radio-cards label="Traveller category" name="who" model="f.who" :options="[['Sikkim resident', 'Travelling from within Sikkim.'], ['Indian visitor', 'An Inner Line Permit may be needed for protected areas.'], ['Foreign national', 'Register through the FRRO portal before you travel.']]"/>
                            <x-radio-cards label="Travel season" name="season" model="f.season" :options="[['Peak season', 'High demand dates and holidays. Book early.'], ['Shoulder season', 'Balanced demand and flexible itineraries.'], ['Off-season', 'Quieter periods, subject to route availability.'], ['Not sure yet', 'We will suggest the best time to go.']]"/>
                        </div>

                        {{-- 3. Dates and group --}}
                        <fieldset x-show="!review && step === 3" x-cloak class="grid md:grid-cols-[minmax(0,22rem)_1fr] gap-x-10 gap-y-7 text-sm font-medium items-start">
                            {{-- Live window: first and sticky on small screens, beside the calendar from desktop up --}}
                            <div class="max-md:sticky max-md:top-0 max-md:z-10 max-md:shadow-[0_8px_16px_-12px_rgba(45,58,34,.5)] md:col-start-2 md:row-start-1 bg-mist border-t-2 border-star px-5 py-3.5 md:py-5" aria-live="polite">
                                <p class="kicker text-ink/60">Your trip window</p>
                                <template x-if="f.date"><p class="mt-1.5 md:mt-2 font-display text-2xl md:text-3xl text-royal leading-tight" x-text="endDate ? fmtShort(f.date) + ' to ' + fmtShort(endDate) : 'From ' + fmtShort(f.date)"></p></template>
                                <template x-if="!f.date"><p class="mt-1.5 font-display text-lg md:text-xl text-ink/60 leading-snug">Pick a start date below.</p></template>
                                <p class="mt-1 text-sm font-normal text-ink/65" x-text="(f.days ? f.days + ' days, ' + (f.days - 1) + ' nights' : 'Choose trip length') + (f.people ? ', ' + f.people + (f.people == 1 ? ' traveller' : ' travellers') : '')"></p>
                            </div>
                            <div class="md:col-start-1 md:row-start-1 md:row-span-3"><x-date-picker label="Tentative start date" model="f.date" range="f.days" error="!!errs.date"/></div>
                            <fieldset class="md:col-start-2 md:row-start-2">
                                <legend>How many days?</legend>
                                <div class="mt-2 grid grid-cols-4 gap-2">
                                    <template x-for="n in Guard.DAYS" :key="n">
                                        <label class="block cursor-pointer">
                                            <input type="radio" name="days" :value="n" x-model.number="f.days" class="peer sr-only">
                                            <span class="grid place-items-center h-12 border border-ink/25 bg-white text-base transition-colors hover:border-royal peer-checked:bg-royal peer-checked:border-royal peer-checked:text-white peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-star" x-text="n"></span>
                                        </label>
                                    </template>
                                </div>
                            </fieldset>
                            <div class="md:col-start-2 md:row-start-3">
                                <p id="people-label">Number of travellers</p>
                                <div class="mt-2 inline-flex items-stretch border border-ink/30 bg-white" role="group" aria-labelledby="people-label">
                                    <button type="button" @click="bump(-1)" :disabled="f.people <= 1" aria-label="One fewer traveller" class="grid place-items-center size-12 text-xl text-royal hover:bg-mist disabled:opacity-30 disabled:hover:bg-transparent">−</button>
                                    <input type="number" inputmode="numeric" min="1" max="50" x-model="f.people" @change="f.people = Guard.people(f.people)" aria-label="Number of travellers" class="w-16 text-center text-lg font-display border-x border-ink/15 bg-transparent [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none focus:outline-none focus-visible:bg-mist">
                                    <button type="button" @click="bump(1)" :disabled="f.people >= 50" aria-label="One more traveller" class="grid place-items-center size-12 text-xl text-royal hover:bg-mist disabled:opacity-30 disabled:hover:bg-transparent">+</button>
                                </div>
                            </div>
                        </fieldset>

                        {{-- 4. Budget and stay --}}
                        <fieldset x-show="!review && step === 4" x-cloak class="grid sm:grid-cols-2 gap-x-4 gap-y-6 text-sm font-medium">
                            <label>Approx. budget per person (₹)
                                <input type="text" inputmode="numeric" enterkeyhint="done" autocomplete="off" x-model="f.budget" @input="f.budget = Guard.budget($event.target.value)" maxlength="7" placeholder="e.g. 12000" :aria-invalid="!!errs.budget" :class="errs.budget && 'border-red-700'" class="field placeholder:text-ink/50"></label>
                            <x-select label="Stay preference" model="f.stay" options="Guard.STAY"/>
                        </fieldset>

                        {{-- Saved summary --}}
                        <dl x-show="review" x-cloak class="lg:-my-4 max-lg:mt-3 max-lg:bg-white max-lg:border max-lg:border-ink/10 max-lg:rounded-[0.75rem] max-lg:overflow-hidden">
                            <template x-for="row in summary" :key="row.step">
                                <div class="grid grid-cols-[1fr_auto] items-baseline gap-x-4 gap-y-0.5 max-lg:px-4 max-lg:py-3 max-lg:border-t max-lg:border-ink/10 max-lg:first:border-0 lg:py-4 lg:border-b lg:border-ink/10 lg:last:border-0">
                                    <dt class="kicker !text-[10px] lg:!text-[11px] text-ink/55" x-text="row.label"></dt>
                                    <button type="button" @click="edit(row.step)" class="text-sm font-semibold text-royal underline underline-offset-4 decoration-royal/40 hover:decoration-royal row-span-2 self-start" :aria-label="'Edit ' + row.label">Edit</button>
                                    <dd class="col-start-1 max-lg:text-[15px] max-lg:font-medium lg:font-display lg:text-lg leading-snug" x-text="row.value"></dd>
                                </div>
                            </template>
                        </dl>

                        <p x-show="buildErr" x-text="buildErr" class="mt-4 text-sm font-medium text-red-700" role="alert"></p>
                    </div>

                    <div x-show="!review" class="max-lg:hidden px-5 sm:px-7 py-4 border-t border-ink/10 flex justify-between gap-3">
                        <button type="button" @click="back()" x-show="step > 1 || editing" class="btn btn-line-dark">Back</button>
                        <button type="button" @click="next()" class="btn btn-solid ml-auto" x-text="editing ? 'Save changes' : (step < 4 ? 'Next' : 'Save')"></button>
                    </div>
                </section>

                {{-- Contact details --}}
                <fieldset class="px-5 sm:px-10 mt-8 lg:mt-10" x-show="wide || (!mexp && review)">
                    <legend class="font-display text-2xl lg:text-xl">Your details</legend>
                    <div class="mt-4 grid sm:grid-cols-2 gap-x-4 gap-y-5 text-sm font-medium">
                        <label>Name
                            <input x-model="f.name" placeholder="Your full name" enterkeyhint="next" autocapitalize="words" autocorrect="off" spellcheck="false" @input="f.name = Guard.name($event.target.value)" @blur="errs.name = f.name ? Guard.vName(f.name) : ''" maxlength="60" autocomplete="name" :aria-invalid="!!errs.name" :class="errs.name && 'border-red-700'" class="field placeholder:text-ink/65"></label>
                        <label>Phone / WhatsApp
                            <input x-model="f.phone" placeholder="e.g. +91 98765 43210" enterkeyhint="send" autocorrect="off" spellcheck="false" type="tel" inputmode="tel" @input="f.phone = Guard.phone($event.target.value)" @blur="errs.phone = f.phone ? Guard.vPhone(f.phone) : ''" maxlength="20" autocomplete="tel" :aria-invalid="!!errs.phone" :class="errs.phone && 'border-red-700'" class="field placeholder:text-ink/65"></label>
                    </div>
                </fieldset>
            </div>

            <div class="shrink-0 bg-paper border-t border-ink/15 px-5 sm:px-10 py-4 pb-[calc(1rem+env(safe-area-inset-bottom))] flex flex-wrap items-center justify-between gap-x-6 gap-y-3">
                <p class="text-sm text-ink/65 max-w-sm" :class="err && '!text-red-700 font-medium'" :role="err ? 'alert' : null" x-show="wide || err || review || hint" x-text="err || (!wide && hint) || 'No payment now. This is an enquiry, not a booking.'"></p>
                {{-- Desktop --}}
                <div class="flex gap-3" x-show="wide">
                    <button type="button" @click="close()" class="btn btn-line-dark">Cancel</button>
                    <button type="submit" class="btn btn-solid">Send on WhatsApp</button>
                </div>
                {{-- Small screens: one wizard bar --}}
                <div class="flex gap-2 w-full" x-show="!wide" x-cloak>
                    <button type="button" x-show="mnum > 1" @click="mback()" class="btn btn-line-dark flex-1">Back</button>
                    <button type="button" x-show="mnum < 6" @click="mnext()" :disabled="!ready" class="btn btn-solid flex-1" x-text="mexp ? 'Next' : (editing ? 'Save changes' : (step < 4 ? 'Next' : 'Save'))"></button>
                    <button type="submit" x-show="mnum === 6" :disabled="!ready" class="btn btn-solid flex-1">Send on WhatsApp</button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>

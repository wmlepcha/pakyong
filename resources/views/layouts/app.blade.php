@php
    $brand = config('site.brand');
    $phone = config('site.phone');
    $wa = preg_replace('/\D/', '', $phone);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#fbfcff">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <title>@yield('title', $brand.' – Sikkim Tour Packages from Gangtok')</title>
    <meta name="description" content="@yield('description', 'Custom Sikkim tour packages: Gangtok, Pelling, Lachung, Gurudongmar and more, planned by local experts.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    @stack('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
</head>
<body class="bg-paper text-ink font-sans antialiased" x-data="trip()" @keydown.escape.window="close()" x-effect="document.documentElement.style.overflow = open ? 'hidden' : ''">

{{-- Header --}}
<header class="sticky top-0 z-40 bg-paper/90 backdrop-blur pt-[env(safe-area-inset-top)]">
    <span id="scroll-progress" aria-hidden="true" class="absolute inset-x-0 bottom-0 h-0.5 bg-royal" style="transform: scaleX(0); transform-origin: left"></span>
    <div class="mx-auto max-w-[1240px] px-5 sm:px-8 h-20 flex items-center justify-between gap-3">
        <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-2.5 font-bold tracking-wide uppercase text-ink text-sm sm:text-base whitespace-nowrap">
            <span class="grid place-items-center size-9 rounded-full bg-royal text-white"><x-icon name="mountain" class="size-5"/></span>@php [$b1, $b2] = array_pad(explode(' ', $brand, 2), 2, ''); @endphp<span>{{ $b1 }}<span class="hidden min-[400px]:inline"> {{ $b2 }}</span></span>
        </a>
        <nav class="hidden md:flex gap-9 text-sm font-medium" aria-label="Main">
            @foreach (config('site.nav') as $label => $r)
                <a href="{{ route($r) }}" class="py-2 border-b-2 {{ request()->routeIs($r) || ($r === 'blog' && request()->routeIs('post')) || ($r === 'destinations' && request()->routeIs('destination')) ? 'text-royal border-royal' : 'border-transparent hover:text-royal' }}">{{ $label }}</a>
            @endforeach
        </nav>
        <div class="flex items-center gap-2">
            <a href="{{ route('faq') }}" aria-label="FAQ" class="md:hidden grid place-items-center size-10 text-ink"><x-icon name="help" class="size-6"/></a>
            <a href="https://wa.me/{{ $wa }}?text=Hi%2C%20I%27d%20like%20to%20plan%20a%20Sikkim%20trip" target="_blank" rel="noopener" aria-label="Chat on WhatsApp"
               class="grid lg:flex place-items-center lg:gap-2 size-10 lg:size-auto lg:px-3 lg:py-2.5 rounded-full text-ink font-semibold lg:hover:bg-mist transition">
                <svg viewBox="0 0 24 24" class="size-6 fill-current" aria-hidden="true"><path d="M12 2a10 10 0 0 0-8.6 15L2 22l5.1-1.3A10 10 0 1 0 12 2Zm5.8 14.2c-.2.7-1.4 1.3-2 1.3-.5.1-1.2.1-1.9-.1-.4-.1-1-.3-1.7-.6-3-1.3-5-4.3-5.1-4.5-.1-.2-1.2-1.6-1.2-3s.8-2.1 1-2.4c.3-.3.6-.3.8-.3h.6c.2 0 .4 0 .6.5l.9 2.1c.1.2.1.4 0 .5l-.4.6-.4.4c-.1.2-.3.3-.1.6.2.3.8 1.3 1.7 2.1 1.2 1 2.2 1.4 2.5 1.5.3.1.5.1.7-.1l.9-1.1c.2-.3.4-.2.6-.1l2 1c.3.1.5.2.5.3.1.2.1.8-.1 1.5Z"/></svg>
                <span class="hidden lg:inline text-sm">{{ $phone }}</span>
            </a>
            <button type="button" @click="pick('')" class="flex items-center gap-2 rounded-full bg-ink text-white text-sm font-semibold px-4 sm:pl-5 sm:pr-4 h-10 sm:h-auto sm:py-3 hover:bg-royal transition-colors whitespace-nowrap">
                <span class="sm:hidden">Plan trip</span><span class="hidden sm:inline">Plan my trip</span><x-icon name="arrow" class="hidden sm:block size-4"/>
            </button>
        </div>
    </div>
</header>

<main class="mx-auto max-w-[1240px]">@yield('content')</main>

<footer class="mt-16 sm:mt-24 bg-ink text-white">
<div class="mx-auto max-w-[1240px] px-5 sm:px-8 pt-14 pb-32 md:pb-20">
    <div class="grid md:grid-cols-[1.4fr_1fr_1fr] gap-10">
        <div>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 font-bold tracking-wide uppercase">
                <span class="grid place-items-center size-9 rounded-full bg-white text-royal"><x-icon name="mountain" class="size-5"/></span>{{ $brand }}
            </a>
            <p class="mt-4 text-white/70 max-w-xs">Custom Sikkim tour packages from Gangtok, planned by locals.</p>
        </div>
        <nav aria-label="Footer" class="grid gap-3 content-start text-white/80">
            @foreach (config('site.nav') as $label => $r)<a href="{{ route($r) }}" class="hover:text-white">{{ $label }}</a>@endforeach
        </nav>
        <div class="grid gap-3 content-start text-white/80">
            <a href="tel:+{{ $wa }}" class="hover:text-white">{{ $phone }}</a>
            <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener" class="hover:text-white">Chat on WhatsApp</a>
            <a href="https://indianfrro.gov.in/efrro/" target="_blank" rel="noopener" class="hover:text-white">FRRO registration for foreign nationals</a>
        </div>
    </div>
    <div class="mt-12 pt-6 border-t border-white/15 flex flex-wrap items-center justify-between gap-x-8 gap-y-3 text-sm text-white/65">
        <p>© {{ date('Y') }} {{ $brand }}. All rights reserved.</p>
        <p class="flex gap-6"><a href="{{ route('terms') }}" class="hover:text-white">Terms and conditions</a><a href="{{ route('privacy') }}" class="hover:text-white">Privacy policy</a></p>
        <p class="basis-full sm:basis-auto">Site developed and maintained from Sikkim by <a href="https://dhungkartechnology.in/" target="_blank" rel="noopener" class="underline underline-offset-2 hover:text-white">Dhungkar Technology</a></p>
    </div>
</div>
</footer>

{{-- Mobile bottom navigation --}}
<nav aria-label="Primary" class="md:hidden fixed inset-x-4 sm:inset-x-auto sm:left-1/2 sm:-translate-x-1/2 sm:w-[30rem] bottom-[max(1rem,env(safe-area-inset-bottom))] z-40 rounded-[1.75rem] bg-white/95 backdrop-blur border border-ink/10 shadow-[0_12px_40px_-12px_rgba(11,27,63,.35)] px-2 py-2 flex items-center justify-between">
    @foreach ([['home', 'Home', 'home'], ['destinations', 'Destinations', 'pin'], ['guide', 'Guide', 'book'], ['blog', 'Blog', 'newspaper'], ['contact', 'Contact', 'phone']] as [$r, $label, $icon])
        @php $on = request()->routeIs($r) || ($r === 'blog' && request()->routeIs('post')) || ($r === 'destinations' && request()->routeIs('destination')); @endphp
        <a href="{{ route($r) }}" @if ($on) aria-current="page" @endif aria-label="{{ $label }}"
           class="flex items-center gap-2 h-12 rounded-full transition-colors {{ $on ? 'bg-ink text-white pl-4 pr-5' : 'text-ink/70 px-3.5 hover:bg-mist' }}">
            <x-icon :name="$icon" class="size-5 shrink-0"/>@if ($on)<span class="text-sm font-semibold">{{ $label }}</span>@endif
        </a>
    @endforeach
</nav>

{{-- Multi-step enquiry modal --}}
<div x-show="open" x-cloak x-transition.opacity.duration.250ms class="fixed inset-0 z-50 flex items-end md:items-center justify-center md:p-4 bg-ink/50" @click.self="close()">
    <div x-show="open" x-transition:enter="transition duration-500 ease-[cubic-bezier(.32,.72,0,1)]" x-transition:enter-start="translate-y-full md:translate-y-3 md:opacity-0" x-transition:enter-end="translate-y-0"
         x-transition:leave="transition duration-200 ease-in" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full md:opacity-0"
         :style="dy ? `transform: translateY(${dy}px); transition: none` : ''"
         class="bg-white w-full max-w-lg rounded-t-[2rem] md:rounded-3xl p-5 pt-3 md:pt-8 pb-[calc(1.25rem+env(safe-area-inset-bottom))] sm:px-8 max-h-[92dvh] overflow-y-auto overscroll-contain" role="dialog" aria-modal="true" aria-label="Plan my trip">
        <div class="md:hidden -mx-5 px-5 pb-3 touch-none" @touchstart.passive="ty = $event.touches[0].clientY" @touchmove.passive="dy = Math.max(0, $event.touches[0].clientY - ty)" @touchend="dy > 110 ? close() : dy = 0; ty = null">
            <span class="block mx-auto h-1.5 w-10 rounded-full bg-ink/15"></span>
        </div>
        <div class="flex justify-between items-start">
            <div>
                <p class="text-royal text-xs font-semibold uppercase tracking-widest" x-text="'Step ' + step + ' of 3'"></p>
                <h3 class="font-display font-bold text-2xl mt-1" x-text="['Where to?', 'When & who?', 'Your details'][step - 1]"></h3>
                <p x-show="f.pkg" x-text="'Package: ' + f.pkg" class="mt-1 text-sm text-ink/70"></p>
            </div>
            <button type="button" @click="close()" class="text-2xl leading-none p-1" aria-label="Close">×</button>
        </div>
        <div class="h-1.5 bg-mist rounded-full mt-4"><div class="h-full bg-royal rounded-full transition-all" :style="`width:${step * 33.4}%`"></div></div>

        <form class="mt-6 space-y-4" novalidate @submit.prevent="next()">
            <div x-show="step === 1" class="space-y-3">
                <template x-for="d in ['East Sikkim', 'North Sikkim', 'West Sikkim', 'South Sikkim', 'Not sure yet']">
                    <label class="flex items-center gap-3 border rounded-xl px-4 py-3 cursor-pointer" :class="f.dest === d ? 'border-royal bg-royal/5' : 'border-ink/15'">
                        <input type="radio" name="dest" :value="d" x-model="f.dest" class="accent-[#0b3d9e]"> <span x-text="d"></span>
                    </label>
                </template>
            </div>
            <div x-show="step === 2" class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <p class="text-sm font-medium mb-2">Travel date <span class="text-ink/60 font-normal" x-show="f.date" x-text="'· ' + fmtDate(f.date)"></span></p>
                    <x-calendar class="rounded-2xl border border-ink/10 p-4" />
                </div>
                <label class="text-sm font-medium">Days
                    <select x-model="f.days" class="mt-1 w-full rounded-xl border border-ink/15 px-4 py-3">
                        @foreach ([3,4,5,6,7,8,10] as $n)<option value="{{ $n }}">{{ $n }} days</option>@endforeach
                    </select></label>
                <label class="text-sm font-medium">Travellers
                    <input type="number" inputmode="numeric" min="1" max="50" x-model="f.people" @change="f.people = Guard.people(f.people)" class="mt-1 w-full rounded-xl border border-ink/15 px-4 py-3"></label>
            </div>
            <div x-show="step === 3" class="space-y-4">
                <label class="block text-sm font-medium">Name
                    <input x-model="f.name" @input="f.name = Guard.name($event.target.value)" @blur="errs.name = f.name ? Guard.vName(f.name) : ''" maxlength="60" autocomplete="name" :aria-invalid="!!errs.name" :class="errs.name ? 'border-red-500' : 'border-ink/15'" class="mt-1 w-full rounded-xl border px-4 py-3"></label>
                <label class="block text-sm font-medium">Phone / WhatsApp
                    <input x-model="f.phone" type="tel" inputmode="tel" @input="f.phone = Guard.phone($event.target.value)" @blur="errs.phone = f.phone ? Guard.vPhone(f.phone) : ''" maxlength="20" autocomplete="tel" :aria-invalid="!!errs.phone" :class="errs.phone ? 'border-red-500' : 'border-ink/15'" class="mt-1 w-full rounded-xl border px-4 py-3"></label>
            </div>
            <p x-show="err" x-text="err" class="text-sm text-red-700" role="alert"></p>
            <div class="flex justify-between pt-2">
                <button type="button" @click="step--; err = ''" x-show="step > 1" class="font-semibold px-5 py-3">Back</button>
                <button type="submit" class="ml-auto rounded-full bg-ink text-white font-semibold px-7 py-3" x-text="step < 3 ? 'Next' : 'Send on WhatsApp'"></button>
            </div>
        </form>
    </div>
</div>

<script>
    // No backend yet: the final step opens WhatsApp with the enquiry prefilled.
    function calendar() {
        return {
            view: new Date(),
            get title() { return this.view.toLocaleDateString('en-IN', { month: 'long', year: 'numeric' }); },
            get cells() {
                const y = this.view.getFullYear(), m = this.view.getMonth();
                const lead = new Date(y, m, 1).getDay(), n = new Date(y, m + 1, 0).getDate();
                return [...Array(lead).fill(null), ...Array.from({ length: n }, (_, i) => new Date(y, m, i + 1))];
            },
            get canPrev() { const t = new Date(); return this.view > new Date(t.getFullYear(), t.getMonth(), 1); },
            iso(d) { return `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`; },
            past(d) { const t = new Date(); t.setHours(0, 0, 0, 0); return d < t; },
            isToday(d) { return this.iso(d) === this.iso(new Date()); },
            shift(n) { this.view = new Date(this.view.getFullYear(), this.view.getMonth() + n, 1); },
        };
    }
    // Input hygiene for every form. Forms hand off to WhatsApp, so this is client-side only.
    // If a server endpoint is ever added, repeat these rules there: never trust the browser.
    const Guard = (() => {
        const INVISIBLE = /[\u200B-\u200F\u202A-\u202E\u2060-\u206F\uFEFF]/g;      // zero-width and bidi tricks
        const CONTROL = /[\u0000-\u0008\u000B\u000C\u000E-\u001F\u007F-\u009F]/g; // control chars (keeps tab and newline)
        const base = s => String(s ?? '').normalize('NFKC').replace(INVISIBLE, '').replace(CONTROL, '');
        const squash = (s, n) => s.replace(new RegExp('(.)\\1{' + n + ',}', 'gsu'), (m, c) => c.repeat(n));
        const DEST = ['East Sikkim', 'North Sikkim', 'West Sikkim', 'South Sikkim', 'Not sure yet'];
        const DAYS = [3, 4, 5, 6, 7, 8, 10];
        return {
            DEST, DAYS,
            name: s => squash(base(s).replace(/<[^>]*>?/g, '').replace(/[^\p{L}\p{M}\s.'’-]/gu, '').replace(/\s+/g, ' ').replace(/([.'’-])\1+/gu, '$1').replace(/^\s+/, ''), 3).slice(0, 60),
            phone: s => base(s).replace(/[^\d+\s()-]/g, '').replace(/^\s+/, '').replace(/(?!^)\+/g, '').replace(/\s{2,}/g, ' ').slice(0, 20),
            text: (s, max = 500) => squash(base(s).replace(/<[^>]*>?/g, '').replace(/[<>]/g, '').replace(/\r\n?/g, '\n').replace(/[ \t]{2,}/g, ' ').replace(/\n{3,}/g, '\n\n'), 5).slice(0, max),
            line: (s, max = 60) => squash(base(s).replace(/<[^>]*>?/g, '').replace(/[<>]/g, '').replace(/\s+/g, ' ').replace(/^\s+/, ''), 5).slice(0, max),
            people: n => Math.min(50, Math.max(1, parseInt(n, 10) || 1)),
            days: n => DAYS.includes(+n) ? +n : 5,
            vName: s => { const v = s.trim(); return v.length < 2 ? 'Please enter your name.' : (/\p{L}{2}/u.test(v) ? '' : 'Your name should contain letters.'); },
            vPhone: s => { const d = s.replace(/\D/g, ''); return d.length >= 10 && d.length <= 15 ? '' : 'Enter a valid phone number (10 to 15 digits).'; },
            vMsg: s => { const v = s.trim(); return v.length < 10 ? 'Please write a little more (at least 10 characters).' : ((v.match(/\p{L}/gu) || []).length < 5 ? 'Please write your message in words.' : ''); },
            vDate: s => {
                if (!/^\d{4}-\d{2}-\d{2}$/.test(s || '')) return 'Please pick a travel date.';
                const d = new Date(s + 'T00:00'), today = new Date(); today.setHours(0, 0, 0, 0);
                const limit = new Date(today); limit.setFullYear(limit.getFullYear() + 3);
                return isNaN(d) || d < today || d > limit ? 'Please pick a date within the next 3 years.' : '';
            },
        };
    })();

    function trip() {
        return {
            open: false, step: 1, err: '', errs: {}, busy: false, dy: 0, ty: null,
            f: { dest: '', pkg: '', date: '', days: 5, people: 2, name: '', phone: '' },
            // Region card: destination known, so skip to step 2. Package: ask the region at step 1.
            pick(name, isPackage = false) {
                this.f.pkg = isPackage ? Guard.line(name, 60) : '';
                this.f.dest = isPackage || !Guard.DEST.includes(name) ? '' : name;
                this.step = !isPackage && this.f.dest ? 2 : 1;
                this.err = ''; this.errs = {};
                this.open = true;
            },
            fmtDate(v) { return v ? new Date(v + 'T00:00').toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' }) : ''; },
            close() { this.open = false; this.dy = 0; this.step = 1; this.err = ''; this.errs = {}; },
            next() {
                const f = this.f;
                this.errs = {};
                if (this.step === 1 && !Guard.DEST.includes(f.dest)) return this.err = 'Please choose a destination.';
                if (this.step === 2) {
                    f.people = Guard.people(f.people); f.days = Guard.days(f.days);
                    const e = Guard.vDate(f.date);
                    if (e) return this.err = e;
                }
                if (this.step === 3) {
                    f.name = Guard.name(f.name).trim(); f.phone = Guard.phone(f.phone).trim();
                    this.errs = { name: Guard.vName(f.name), phone: Guard.vPhone(f.phone) };
                    if (this.errs.name || this.errs.phone) return this.err = this.errs.name || this.errs.phone;
                }
                this.err = '';
                if (this.step < 3) return this.step++;
                if (this.busy) return;                                  // stop double-taps opening many tabs
                this.busy = true; setTimeout(() => this.busy = false, 3000);
                const pkg = f.pkg ? ` (${f.pkg} package)` : '';
                const msg = `Hi, I'm ${f.name} (${f.phone}). I'd like a trip to ${f.dest}${pkg} on ${f.date} for ${f.days} days, ${f.people} traveller(s).`;
                window.open('https://wa.me/{{ $wa }}?text=' + encodeURIComponent(msg), '_blank');
                this.close();
            },
        };
    }

    // Shared by both contact forms (desktop and phone).
    function contactForm(wa, phoneShown) {
        return {
            name: '', phone: '', msg: '', errs: {}, busy: false, toast: '',
            say(t) { this.toast = t; setTimeout(() => this.toast = '', 2000); },
            check() {
                this.name = Guard.name(this.name).trim(); this.phone = Guard.phone(this.phone).trim(); this.msg = Guard.text(this.msg, 500).trim();
                this.errs = { name: Guard.vName(this.name), phone: Guard.vPhone(this.phone), msg: Guard.vMsg(this.msg) };
                return !Object.values(this.errs).some(Boolean);
            },
            send() {
                if (this.busy || !this.check()) return;
                this.busy = true; setTimeout(() => this.busy = false, 3000);
                this.say('Opening WhatsApp…');
                window.open('https://wa.me/' + wa + '?text=' + encodeURIComponent(`Hi, I'm ${this.name} (${this.phone}). ${this.msg}`), '_blank');
            },
            copy() {
                const fallback = () => { const el = document.createElement('textarea'); el.value = phoneShown; el.style.position = 'fixed'; el.style.opacity = '0'; document.body.appendChild(el); el.select(); const ok = document.execCommand('copy'); el.remove(); this.say(ok ? 'Number copied' : 'Could not copy'); };
                if (navigator.clipboard && window.isSecureContext) { navigator.clipboard.writeText(phoneShown).then(() => this.say('Number copied'), fallback); } else { fallback(); }
            },
        };
    }

    // Hero photo mosaic: five tiles, one swaps to a new photo every few seconds with a slow crossfade.
    function mosaic(pool) {
        const n = 5;
        const still = matchMedia('(prefers-reduced-motion: reduce)').matches;
        const layer = i => ({ a: pool[i % pool.length], b: pool[i % pool.length], front: 'a' });
        return {
            tiles: Array.from({ length: n }, (_, i) => layer(i)),
            cursor: n % pool.length, turn: 0,
            init() { if (!still && pool.length > n) setInterval(() => this.swap(), 3400); },
            swap() {
                if (document.hidden) return;
                const shown = this.tiles.map(t => t[t.front].img);
                let next = null;
                for (let k = 0; k < pool.length; k++) {
                    const cand = pool[(this.cursor + k) % pool.length];
                    if (!shown.includes(cand.img)) { next = cand; this.cursor = (this.cursor + k + 1) % pool.length; break; }
                }
                if (!next) return;
                const tile = this.tiles[this.turn]; this.turn = (this.turn + 1) % n;
                const pre = new Image();
                pre.onload = () => { const back = tile.front === 'a' ? 'b' : 'a'; tile[back] = next; tile.front = back; };
                pre.src = next.img;
            },
        };
    }

    // Scroll motion. Elements get a gentle fade and rise as they enter the viewport.
    // Added by script only (nothing is hidden without JS), skipped for reduced motion,
    // and the classes are removed afterwards so hover and press effects are untouched.
    (() => {
        const header = document.querySelector('header');
        const bar = document.getElementById('scroll-progress');
        const onScroll = () => {
            const max = document.documentElement.scrollHeight - innerHeight;
            if (bar) bar.style.transform = 'scaleX(' + (max > 0 ? Math.min(1, scrollY / max) : 0) + ')';
            if (header) header.dataset.scrolled = scrollY > 8;
        };
        addEventListener('scroll', onScroll, { passive: true }); onScroll();

        const main = document.querySelector('main');
        if (!main || !('IntersectionObserver' in window) || matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        const skip = el => /^(A|BUTTON|SCRIPT|STYLE|TEMPLATE|NAV|FORM)$/.test(el.tagName) || el.hasAttribute('x-show') || el.hasAttribute('x-cloak') || ['sticky', 'fixed'].includes(getComputedStyle(el).position);
        const targets = new Map(); // element -> stagger index
        main.querySelectorAll('section').forEach(sec => [...sec.children].forEach(c => { if (!skip(c)) targets.set(c, 0); }));
        main.querySelectorAll('section [class*="grid"]').forEach(g => {
            if (getComputedStyle(g).display !== 'grid') return;
            const items = [...g.children].filter(c => !skip(c));
            if (items.length < 2 || items.length > 12) return;
            targets.delete(g);
            items.forEach((c, i) => targets.set(c, i));
        });

        let observing = false;
        const settle = el => { el.classList.remove('reveal', 'is-in'); el.removeAttribute('data-reveal'); el.style.removeProperty('--d'); };
        const io = new IntersectionObserver(entries => entries.forEach(e => {
            observing = true;
            if (!e.isIntersecting) return;
            const el = e.target; io.unobserve(el);
            el.classList.add('is-in');
            setTimeout(() => settle(el), 1700);
        }), { threshold: 0, rootMargin: '0px 0px -8% 0px' });

        targets.forEach((i, el) => {
            el.classList.add('reveal');
            if (el.tagName === 'ARTICLE' || (el.querySelector('img') && /rounded-(3xl|\[2rem\])/.test(el.className))) el.dataset.reveal = 'scale';
            if (i) el.style.setProperty('--d', Math.min(i, 5) * 80 + 'ms');
            io.observe(el);
        });

        // Safety net: if observation never starts, or an element in view is still hidden, show everything.
        setTimeout(() => {
            if (!observing) { document.querySelectorAll('.reveal').forEach(settle); return; }
            document.querySelectorAll('.reveal:not(.is-in)').forEach(el => {
                const r = el.getBoundingClientRect();
                if (r.top < innerHeight && r.bottom > 0) el.classList.add('is-in');
            });
        }, 2500);
    })();
    </script>
</body>
</html>

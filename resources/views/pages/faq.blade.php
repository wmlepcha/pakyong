@extends('layouts.app')
@section('title', 'FAQ – '.config('site.brand'))
@php
    $cats = config('faq.categories');
    $items = collect(config('faq.items'))->values();
    $phone = config('site.phone');
    $wa = preg_replace('/\D/', '', $phone);
    $jsItems = $items->map(fn ($i) => ['cat' => $i['cat'], 't' => mb_strtolower($i['q'].' '.$i['a'])])->all();
@endphp
@push('head')
<script type="application/ld+json">{!! json_encode([
    '@context' => 'https://schema.org', '@type' => 'FAQPage',
    'mainEntity' => $items->map(fn ($i) => ['@type' => 'Question', 'name' => $i['q'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $i['a']]])->all(),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush
@section('content')
<section class="px-5 sm:px-8 pt-4 sm:pt-10 pb-16 sm:pb-24"
         x-data='{ q: "", cat: "All", open: [], items: @json($jsItems, JSON_HEX_APOS | JSON_HEX_QUOT),
                   show(i) { const it = this.items[i]; return (this.cat === "All" || this.cat === it.cat) && (!this.q.trim() || it.t.includes(this.q.trim().toLowerCase())) },
                   has(c) { return this.items.some((it, i) => it.cat === c && this.show(i)) },
                   get count() { return this.items.filter((_, i) => this.show(i)).length },
                   toggle(i) { this.open = this.open.includes(i) ? this.open.filter(x => x !== i) : [...this.open, i] } }'>
    <h1 class="font-display font-bold text-[2rem] leading-[1.1] sm:text-6xl text-balance max-w-3xl">Frequently asked questions</h1>
    <p class="mt-2 sm:mt-5 text-base sm:text-lg text-ink/70 max-w-2xl">Permits, planning, payment and what to expect on the road. Can't find your answer? Message us on WhatsApp.</p>

    <div class="mt-10 relative max-w-xl">
        <label for="faq-search" class="sr-only">Search questions</label>
        <x-icon name="search" class="size-5 absolute left-5 top-1/2 -translate-y-1/2 text-ink/45 pointer-events-none"/>
        <input id="faq-search" type="search" maxlength="60" x-model="q" @input="q = Guard.line($event.target.value, 60)" placeholder="Search, for example “permit” or “winter”" autocomplete="off"
               class="w-full rounded-full bg-white border border-ink/10 pr-5 py-4 pl-14 focus:outline-none focus:ring-2 focus:ring-royal/40">
    </div>

    <div class="mt-10 grid grid-cols-[minmax(0,1fr)] lg:grid-cols-[14rem_minmax(0,1fr)] gap-x-14 gap-y-6">
        <nav aria-label="Question categories" class="min-w-0 self-start lg:sticky lg:top-28">
            <div role="tablist" class="flex lg:flex-col gap-2 lg:gap-1 overflow-x-auto lg:overflow-visible [scrollbar-width:none] [&::-webkit-scrollbar]:hidden pb-1">
                @foreach (array_merge(['All'], $cats) as $c)
                    <button role="tab" type="button" @click="cat = '{{ $c }}'" :aria-selected="cat === '{{ $c }}'"
                            class="shrink-0 text-left rounded-full lg:rounded-xl px-4 py-2 lg:px-3 text-sm font-semibold whitespace-nowrap transition-colors"
                            :class="cat === '{{ $c }}' ? 'bg-ink text-white' : 'bg-mist lg:bg-transparent text-ink/75 hover:text-ink lg:hover:bg-mist/70'">{{ $c }}</button>
                @endforeach
            </div>
            <p class="hidden lg:block mt-6 px-3 text-sm text-ink/55" aria-live="polite"><span x-text="count"></span> <span x-text="count === 1 ? 'question' : 'questions'"></span></p>
        </nav>

        <div class="min-w-0 max-w-3xl">
            @foreach ($cats as $c)
                <section x-show="has('{{ $c }}')" class="{{ $loop->first ? '' : 'mt-14' }}" @if (! $loop->first) x-cloak @endif>
                    <h2 class="font-display font-bold text-2xl sm:text-3xl">{{ $c }}</h2>
                    <div class="mt-5 space-y-3 max-sm:space-y-0 max-sm:rounded-2xl max-sm:overflow-hidden max-sm:border max-sm:border-ink/5 max-sm:bg-white max-sm:divide-y max-sm:divide-ink/10">
                        @foreach ($items as $i => $it)
                            @if ($it['cat'] === $c)
                                <div x-show="show({{ $i }})" class="bg-white border border-ink/5 rounded-2xl max-sm:rounded-none max-sm:border-0">
                                    <h3>
                                        <button type="button" @click="toggle({{ $i }})" :aria-expanded="open.includes({{ $i }})" aria-controls="faq-{{ $i }}"
                                                class="w-full flex items-center justify-between gap-4 text-left px-4 sm:px-6 py-4 sm:py-5 font-semibold">
                                            {{ $it['q'] }}
                                            <span class="grid place-items-center size-8 shrink-0 rounded-full transition-all" :class="open.includes({{ $i }}) ? 'bg-royal text-white rotate-45' : 'bg-mist text-royal'" aria-hidden="true">+</span>
                                        </button>
                                    </h3>
                                    <div id="faq-{{ $i }}" class="grid transition-all duration-300 ease-out" :class="open.includes({{ $i }}) ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
                                        <div class="overflow-hidden px-4 sm:px-6">
                                            <p class="text-ink/75 leading-relaxed">{{ $it['a'] }}</p>
                                            @isset($it['link'])<a href="{{ $it['link'][1] }}" @if (str_starts_with($it['link'][1], 'http')) target="_blank" rel="noopener" @endif class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-royal">{{ $it['link'][0] }} <x-icon name="arrow" class="size-4"/></a>@endisset
                                            <div class="pb-5"></div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </section>
            @endforeach

            <div x-show="count === 0" x-cloak class="rounded-3xl bg-mist p-8 text-center">
                <p class="font-display font-bold text-xl">No questions match that</p>
                <p class="mt-2 text-ink/70">Try a different word, or ask us directly.</p>
                <button type="button" @click="q = ''; cat = 'All'" class="mt-4 text-sm font-semibold text-royal">Clear search</button>
            </div>

            <aside class="mt-16 rounded-3xl bg-royal text-white p-5 sm:p-10">
                <h2 class="font-display font-bold text-2xl sm:text-3xl text-balance">Still have a question?</h2>
                <p class="mt-2 text-white/80 max-w-lg">Message us on WhatsApp and a local team member will reply, or send your dates and we'll plan the trip with you.</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener" class="inline-flex items-center gap-3 rounded-full bg-white text-ink font-semibold pl-6 pr-5 py-3.5 hover:bg-mist transition-colors">Chat on WhatsApp <x-icon name="arrow" class="size-4"/></a>
                    <button type="button" @click="pick('')" class="rounded-full border border-white/40 font-semibold px-6 py-3.5 hover:bg-white/10 transition-colors">Plan my trip</button>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection

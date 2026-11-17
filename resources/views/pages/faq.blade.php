@extends('layouts.app')
@section('title', 'Sikkim travel FAQ: permits, best time, payment - '.config('site.brand'))
@section('description', 'Answers on Sikkim permits, the best time to go, payment, altitude and what to expect on the road, from a local tour team.')
@php
    $cats = config('faq.categories');
    $items = collect(config('faq.items'))->values();
    $phone = config('site.phone');
    $wa = preg_replace('/\D/', '', $phone);
    $jsItems = $items->map(fn ($i) => ['cat' => $i['cat'], 't' => mb_strtolower($i['q'].' '.$i['a'])])->all();
@endphp
@push('head')
<script type="application/ld+json">{!! json_encode([
    '@@context' => 'https://schema.org', '@@type' => 'FAQPage',
    'mainEntity' => $items->map(fn ($i) => ['@@type' => 'Question', 'name' => $i['q'], 'acceptedAnswer' => ['@@type' => 'Answer', 'text' => $i['a']]])->all(),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush
@section('content')
<section class="px-5 sm:px-8 pt-4 sm:pt-10 pb-12 sm:pb-24"
         x-data='{ q: "", cat: "All", open: [], items: @json($jsItems, JSON_HEX_APOS | JSON_HEX_QUOT),
                   show(i) { const it = this.items[i]; return (this.cat === "All" || this.cat === it.cat) && (!this.q.trim() || it.t.includes(this.q.trim().toLowerCase())) },
                   has(c) { return this.items.some((it, i) => it.cat === c && this.show(i)) },
                   get count() { return this.items.filter((_, i) => this.show(i)).length },
                   toggle(i) { this.open = this.open.includes(i) ? this.open.filter(x => x !== i) : [...this.open, i] } }'>
    <h1 class="font-display ios-title sm:text-6xl text-balance max-w-3xl">Frequently asked questions</h1>
    <p class="mt-2 sm:mt-5 text-base sm:text-lg text-ink/70 max-w-2xl">Permits, planning, payment and what to expect on the road. Can't find your answer? Message us on WhatsApp.</p>

    <div class="mt-5 sm:mt-10 relative max-w-xl">
        <label for="faq-search" class="sr-only">Search questions</label>
        <x-icon name="search" class="size-5 absolute left-4 top-1/2 -translate-y-1/2 text-ink/50 pointer-events-none"/>
        <input id="faq-search" type="search" maxlength="60" x-model="q" @input="q = Guard.line($event.target.value, 60)" placeholder="Search, for example “permit” or “winter”" autocomplete="off"
               class="field r-ios lg:rounded-full pl-12 lg:pl-14 pr-4 placeholder:text-ink/60">
    </div>

    <div class="mt-3 lg:mt-10 grid grid-cols-[minmax(0,1fr)] lg:grid-cols-[14rem_minmax(0,1fr)] gap-x-14 gap-y-4 lg:gap-y-6">
        <nav aria-label="Question categories" class="ios-bar max-lg:sticky max-lg:z-30 max-lg:-mx-5 max-lg:sm:-mx-8 max-lg:px-5 max-lg:sm:px-8 max-lg:py-2 min-w-0 self-start lg:sticky lg:top-28">
            <div role="tablist" class="flex lg:flex-col gap-2 lg:gap-1 overflow-x-auto lg:overflow-visible [scrollbar-width:none] [&::-webkit-scrollbar]:hidden pb-1">
                @foreach (array_merge(['All'], $cats) as $c)
                    <button role="tab" type="button" @click="cat = '{{ $c }}'" :aria-selected="cat === '{{ $c }}'"
                            class="chip shrink-0 text-left rounded-full lg:rounded-xl px-4 py-2 lg:px-3 text-sm font-semibold whitespace-nowrap transition-colors"
                            :class="cat === '{{ $c }}' ? 'bg-ink text-white' : 'bg-mist lg:bg-transparent text-ink/75 hover:text-ink lg:hover:bg-mist/70'">{{ $c }}</button>
                @endforeach
            </div>
            <p class="hidden lg:block mt-6 px-3 text-sm text-ink/55" aria-live="polite"><span x-text="count"></span> <span x-text="count === 1 ? 'question' : 'questions'"></span></p>
        </nav>

        <div class="min-w-0 max-w-3xl">
            @foreach ($cats as $c)
                <section x-show="has('{{ $c }}')" class="{{ $loop->first ? '' : 'mt-8 lg:mt-14' }}" @if (! $loop->first) x-cloak @endif>
                    <h2 class="font-display text-[1.375rem] sm:text-3xl">{{ $c }}</h2>
                    <div class="mt-3 lg:mt-4 ios-group divide-y divide-ink/10 border-y border-ink/10">
                        @foreach ($items as $i => $it)
                            @if ($it['cat'] === $c)
                                <div x-show="show({{ $i }})" class="group">
                                    <h3>
                                        <button type="button" @click="toggle({{ $i }})" :aria-expanded="open.includes({{ $i }})" aria-controls="faq-{{ $i }}"
                                                class="w-full flex items-center justify-between gap-4 text-left py-4 px-4 lg:px-0 lg:py-5 font-semibold text-[15px] lg:text-base hover:text-royal transition-colors">
                                            <span>{{ $it['q'] }}</span>
                                            <x-icon name="right" class="lg:hidden size-5 shrink-0 text-ink/35 transition-transform duration-300" ::class="open.includes({{ $i }}) && 'rotate-90 !text-royal'"/>
                                            <span class="max-lg:hidden shrink-0 text-2xl leading-none font-normal text-royal transition-transform duration-300" :class="open.includes({{ $i }}) && 'rotate-45'" aria-hidden="true">+</span>
                                        </button>
                                    </h3>
                                    <div id="faq-{{ $i }}" class="grid transition-all duration-300 ease-out" :class="open.includes({{ $i }}) ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
                                        <div class="overflow-hidden">
                                            <p class="text-ink/75 text-[15px] lg:text-base leading-relaxed max-w-[62ch] px-4 lg:px-0 lg:pr-10">{{ $it['a'] }}</p>
                                            @isset($it['link'])<a href="{{ $it['link'][1] }}" @if (str_starts_with($it['link'][1], 'http')) target="_blank" rel="noopener" @endif class="mt-1 ml-4 lg:ml-0 inline-flex items-center gap-2 min-h-11 text-sm font-semibold text-royal">{{ $it['link'][0] }} <x-icon name="arrow" class="size-4"/></a>@endisset
                                            <div class="pb-4 lg:pb-6"></div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </section>
            @endforeach

            <div x-show="count === 0" x-cloak class="r-ios-lg bg-mist p-6 sm:p-8 text-center">
                <p class="font-display text-lg sm:text-xl">No questions match that</p>
                <p class="mt-2 text-ink/70">Try a different word, or ask us directly.</p>
                <button type="button" @click="q = ''; cat = 'All'" class="mt-4 text-sm font-semibold text-royal">Clear search</button>
            </div>

            <aside class="mt-10 lg:mt-16 r-ios-lg bg-royal text-white p-5 sm:p-10">
                <h2 class="font-display text-[1.375rem] sm:text-3xl text-balance">Still have a question?</h2>
                <p class="mt-2 text-white/80 max-w-lg">Message us on WhatsApp and a local team member will reply, or send your dates and we'll plan the trip with you.</p>
                <div class="mt-5 sm:mt-6 flex gap-2 sm:gap-3">
                    <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener" class="btn btn-light max-sm:flex-1">Chat on WhatsApp <x-icon name="arrow" class="size-4 max-sm:hidden"/></a>
                    <button type="button" @click="pick('')" class="btn btn-line max-sm:flex-1">Plan my trip</button>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection

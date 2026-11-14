@extends('layouts.app')
@php
    $d = config('legal.'.$doc);
    $other = $doc === 'terms' ? ['privacy', 'Privacy policy'] : ['terms', 'Terms and conditions'];
    $t = fn ($s) => str_replace([':brand', ':phone'], [config('site.brand'), config('site.phone')], $s);
    $count = count($d['sections']);
@endphp
@section('title', $d['title'].' - '.config('site.brand'))
@section('content')
<section class="px-5 sm:px-8 pt-4 sm:pt-10 pb-16 sm:pb-24">
    <h1 class="font-display font-bold text-[2rem] leading-[1.1] sm:text-6xl text-balance">{{ $d['title'] }}</h1>
    <p class="mt-2 sm:mt-4 text-sm text-ink/60">Last updated {{ config('legal.updated') }}</p>
    <p class="mt-5 text-base sm:text-lg text-ink/75 max-w-3xl leading-relaxed">{{ $t($d['intro']) }}</p>

    <div class="mt-8 rounded-3xl bg-mist p-5 sm:p-8 max-w-3xl">
        <h2 class="font-display font-bold text-xl">In short</h2>
        <ul class="mt-3 space-y-2.5">
            @foreach ($d['summary'] as $pt)
                <li class="flex gap-3 text-sm sm:text-base text-ink/80"><span class="mt-2.5 h-px w-4 bg-royal shrink-0"></span>{{ $pt }}</li>
            @endforeach
        </ul>
        <p class="mt-4 text-xs text-ink/55">This summary is a convenience. The full text below applies.</p>
    </div>

    <div class="mt-10 grid lg:grid-cols-[15rem_minmax(0,1fr)] gap-x-14 gap-y-6"
         x-data="{ open: [], total: {{ $count }},
                   toggle(i) { this.open = this.open.includes(i) ? this.open.filter(x => x !== i) : [...this.open, i]; },
                   all() { this.open = this.open.length === this.total ? [] : [...Array(this.total).keys()]; },
                   go() { const m = location.hash.match(/^#s(\d+)$/); if (!m) return; const i = +m[1] - 1; if (!this.open.includes(i)) this.open = [...this.open, i]; this.$nextTick(() => document.getElementById('s' + m[1])?.scrollIntoView()); } }"
         x-init="go()" @hashchange.window="go()">

        {{-- Desktop: contents list --}}
        <nav aria-label="On this page" class="hidden lg:block min-w-0 sticky top-28 self-start">
            <p class="text-xs font-semibold text-ink/55 mb-3 px-3">On this page</p>
            <ol class="space-y-0.5 text-sm">
                @foreach ($d['sections'] as $i => [$h])<li><a href="#s{{ $i + 1 }}" class="block rounded-xl px-3 py-1.5 text-ink/70 hover:text-royal hover:bg-mist/60">{{ $i + 1 }}. {{ $h }}</a></li>@endforeach
            </ol>
        </nav>

        <div class="min-w-0 max-w-3xl">
            {{-- Phones and tablets: tap a row to read it --}}
            <div class="lg:hidden flex items-center justify-between px-1 pb-3">
                <p class="text-xs font-semibold text-ink/55">{{ $count }} sections</p>
                <button type="button" @click="all()" class="text-sm font-semibold text-royal" x-text="open.length === total ? 'Collapse all' : 'Expand all'"></button>
            </div>

            <div class="max-lg:rounded-2xl max-lg:bg-white max-lg:border max-lg:border-ink/5 max-lg:divide-y max-lg:divide-ink/10 max-lg:overflow-hidden lg:space-y-10">
                @foreach ($d['sections'] as $i => [$h, $blocks])
                    <section id="s{{ $i + 1 }}" class="scroll-mt-24 lg:scroll-mt-28">
                        <h2 class="hidden lg:block font-display font-bold text-2xl text-balance">{{ $i + 1 }}. {{ $h }}</h2>
                        <h2 class="lg:hidden">
                            <button type="button" @click="toggle({{ $i }})" :aria-expanded="open.includes({{ $i }})" aria-controls="legal-{{ $i }}" class="w-full flex items-center justify-between gap-4 text-left px-4 py-4">
                                <span class="font-display font-bold text-lg leading-snug">{{ $i + 1 }}. {{ $h }}</span>
                                <span class="grid place-items-center size-8 shrink-0 rounded-full transition-all" :class="open.includes({{ $i }}) ? 'bg-royal text-white rotate-45' : 'bg-mist text-royal'" aria-hidden="true">+</span>
                            </button>
                        </h2>
                        <div id="legal-{{ $i }}" :class="open.includes({{ $i }}) ? '' : 'max-lg:hidden'" class="lg:mt-3 space-y-4 text-ink/80 leading-relaxed max-lg:px-4 max-lg:pb-5">
                            @foreach ($blocks as $b)
                                @if (is_string($b))
                                    <p>{{ $t($b) }}</p>
                                @elseif (isset($b['list']))
                                    <ul class="space-y-2.5">
                                        @foreach ($b['list'] as $li)<li class="flex gap-3"><span class="mt-3 h-px w-4 bg-royal shrink-0"></span><span>{{ $t($li) }}</span></li>@endforeach
                                    </ul>
                                @elseif (isset($b['table']))
                                    <div class="overflow-x-auto rounded-2xl border border-ink/10 bg-white">
                                        <table class="w-full text-left text-sm min-w-[16rem]">
                                            <thead><tr class="bg-mist text-ink/70">@foreach ($b['table'][0] as $th)<th scope="col" class="px-4 py-3 font-semibold">{{ $th }}</th>@endforeach</tr></thead>
                                            <tbody class="divide-y divide-ink/10">
                                                @foreach ($b['table'][1] as $row)<tr>@foreach ($row as $k => $td)<td class="px-4 py-3 {{ $k === 0 ? 'font-semibold' : '' }}">{{ $td }}</td>@endforeach</tr>@endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </section>
                @endforeach
            </div>

            <p class="mt-8 lg:pt-6 lg:border-t border-ink/10 text-sm text-ink/70">See also our <a href="{{ route($other[0]) }}" class="font-semibold text-royal underline underline-offset-2">{{ $other[1] }}</a>.</p>
        </div>
    </div>
</section>
@endsection

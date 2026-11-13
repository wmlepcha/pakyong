{{-- Decorative weather layer for a season card. $season: spring | monsoon | autumn | winter --}}
@php
    $n = ['spring' => 11, 'monsoon' => 16, 'autumn' => 8, 'winter' => 18][$season];
@endphp
<div class="season-scene absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
    @if ($season === 'monsoon')
        <span class="season-fx -top-8 -left-4 w-40 h-16 rounded-full bg-slate-500/25 blur-xl" style="animation: cloud-drift 9s ease-in-out infinite"></span>
        <span class="season-fx -top-10 right-0 w-36 h-14 rounded-full bg-slate-500/20 blur-xl" style="animation: cloud-drift 12s -4s ease-in-out infinite"></span>
    @elseif ($season === 'autumn')
        <span class="season-fx -top-12 -right-12 size-44 rounded-full" style="background: radial-gradient(circle, rgba(245,158,11,.5), rgba(245,158,11,0) 66%); animation: sun-pulse 7s ease-in-out infinite"></span>
    @endif

    @for ($i = 0; $i < $n; $i++)
        @php
            $x = ($i * 37 + 11) % 96;
            $d = -(($i * 29) % 14);
            $sw = (($i % 3) - 1) * 26 + 14;
        @endphp
        @if ($season === 'spring')
            @php $sz = 7 + ($i * 5) % 6; @endphp
            <span class="season-p bg-rose-400/60" style="--x: {{ $x }}; --k: petal-fall; --t: {{ 9 + ($i * 7) % 6 }}s; --d: {{ $d }}s; --sw: {{ $sw }}px; width: {{ $sz }}px; height: {{ $sz + 4 }}px; border-radius: 65% 35% 65% 35%"></span>
        @elseif ($season === 'monsoon')
            <span class="season-p bg-sky-700/40" style="--x: {{ $x }}; --k: rain-fall; --t: {{ number_format(1.1 + (($i * 3) % 7) / 10, 1) }}s; --d: {{ number_format(-(($i * 7) % 18) / 10, 1) }}s; width: 1.5px; height: {{ 12 + ($i * 5) % 8 }}px; border-radius: 2px"></span>
        @elseif ($season === 'autumn')
            @php $sz = 9 + ($i * 3) % 5; @endphp
            <span class="season-p {{ $i % 2 ? 'bg-orange-500/70' : 'bg-amber-600/65' }}" style="--x: {{ $x }}; --k: leaf-fall; --t: {{ 11 + ($i * 5) % 6 }}s; --d: {{ $d }}s; --sw: {{ $sw }}px; width: {{ $sz }}px; height: {{ $sz }}px; border-radius: 0 100% 0 100%"></span>
        @else
            @php $sz = 3 + ($i * 7) % 4; @endphp
            <span class="season-p rounded-full bg-white/90" style="--x: {{ $x }}; --k: snow-fall; --t: {{ 8 + ($i * 5) % 7 }}s; --d: {{ $d }}s; --sw: {{ $sw }}px; width: {{ $sz }}px; height: {{ $sz }}px"></span>
        @endif
    @endfor
</div>

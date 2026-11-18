@php
    $e = $getRecord();
    $places = collect($e->destinations ?? [])->implode(', ') ?: 'Not chosen';
    $prefs = array_filter(['Experience' => $e->tier, 'Traveller' => $e->traveller, 'Season' => $e->season, 'Stay' => $e->stay]);
@endphp
@include('filament.partials-summary-styles')
<style>
    .rs-places { margin: .2rem 0 0; font-family: var(--font-serif); font-size: 1.6rem; line-height: 1.25; color: var(--himalio-ink); }
    .rs-stats { position: relative; display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin: 1.25rem -2rem 0; padding: .9rem 2rem; background: rgb(255 255 255 / .75); border-top: 1px solid rgb(45 58 34 / .1); }
    .rs-stats .rs-date { font-size: 1.4rem; }
    .rs-chips { position: relative; display: flex; flex-wrap: wrap; gap: .5rem; padding: .85rem 2rem; background: #fff; border-top: 1px solid rgb(45 58 34 / .1); }
    .rs-chip { padding: .3rem .7rem; font-size: 12px; background: var(--himalio-cream); border: 1px solid rgb(45 58 34 / .15); color: var(--himalio-ink); }
    .rs-chip span { margin-right: .35rem; font-size: 10px; letter-spacing: .12em; text-transform: uppercase; color: rgb(45 58 34 / .55); }
    @media (max-width: 640px) { .rs-stats { grid-template-columns: 1fr 1fr; margin: 1rem -1rem 0; padding: .75rem 1rem; } .rs-chips { padding: .75rem 1rem; } .rs-places { font-size: 1.25rem; } }
</style>
<div class="rs">
    <div class="rs-body" style="padding-top: 1.5rem">
        <p class="rs-label">Trip to</p>
        <p class="rs-places">{{ $places }}</p>
        @if ($e->package)<p class="rs-sub" style="margin-top: .25rem">Package: {{ $e->package }}</p>@endif
        <div class="rs-stats">
            <div><p class="rs-label">Start date</p><p class="rs-date">{{ $e->start_date?->format('j M Y') ?? '-' }}</p></div>
            <div><p class="rs-label">Days</p><p class="rs-date">{{ $e->days ?? '-' }}</p></div>
            <div><p class="rs-label">Travellers</p><p class="rs-date">{{ $e->people ?? '-' }}</p></div>
            <div><p class="rs-label">Budget per person</p><p class="rs-date">{{ $e->budget ? '₹'.number_format($e->budget) : '-' }}</p></div>
        </div>
    </div>
    @if ($prefs)
        <div class="rs-chips">
            @foreach ($prefs as $label => $value)<p class="rs-chip" style="margin: 0"><span>{{ $label }}</span>{{ $value }}</p>@endforeach
        </div>
    @endif
    <div class="rs-who">
        <div><p class="rs-label">Name</p><strong>{{ $e->name }}</strong></div>
        <div><p class="rs-label">Phone</p><strong>{{ $e->phone }}</strong></div>
        <div><p class="rs-label">Received</p><strong>{{ $e->created_at->format('j M Y, g:i a') }}</strong></div>
    </div>
</div>

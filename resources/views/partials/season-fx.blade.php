{{-- Ambient weather for a season card: petals, rain, leaves or snow. Pure CSS, paused until the card is active or hovered. --}}
@php
    $kind = ['spring' => 'petal', 'monsoon' => 'rain', 'autumn' => 'leaf', 'winter' => 'snow'][strtolower($season)] ?? 'snow';
    $count = $kind === 'rain' ? 40 : 16;
@endphp
<div class="fx fx-{{ $kind }}" aria-hidden="true">
    @for ($i = 0; $i < $count; $i++)
        <span style="--x: {{ ($i * 37 + 11) % 100 }}%; --d: -{{ (($i * 53) % 90) / 10 }}s; --t: {{ $kind === 'rain' ? 0.6 + ($i % 4) * .15 : 6 + ($i * 7) % 6 }}s; --z: {{ 3 + ($i * 5) % 5 }}px; --dx: {{ (($i % 5) - 2) * 14 }}px; --r: {{ 90 + ($i * 41) % 270 }}deg"></span>
    @endfor
</div>

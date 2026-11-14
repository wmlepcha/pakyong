@php $carousel = $carousel ?? false; $dests = config('site.destinations'); @endphp

{{-- Phones: app-style image cards --}}
<div class="md:hidden {{ $carousel ? '-mx-5 sm:-mx-8 flex gap-4 overflow-x-auto snap-x snap-mandatory scroll-px-5 sm:scroll-px-8 px-5 sm:px-8 pb-2 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden' : 'grid sm:grid-cols-2 gap-4' }}">
    @foreach ($dests as [$name, $places, $img, $price])
        <a href="{{ route('destination', \Illuminate\Support\Str::slug($name)) }}" class="relative block text-left rounded-3xl overflow-hidden {{ $carousel ? 'snap-start shrink-0 w-[72%] sm:w-[44%] aspect-[3/4] sm:aspect-[4/5]' : 'aspect-[4/3]' }}">
            <img src="/images/{{ $img }}" @dims('/images/'.$img) alt="{{ $name }}" loading="lazy" class="absolute inset-0 size-full object-cover">
            <span class="absolute inset-0 bg-gradient-to-t from-ink/90 via-ink/30 to-transparent"></span>
            <span class="absolute inset-x-0 bottom-0 p-5 text-white">
                <span class="block font-display font-bold text-2xl">{{ $name }}</span>
                <span class="block text-sm text-white/80 mt-1">{{ $places }}</span>
                <span class="mt-3 inline-block rounded-full bg-white text-ink px-3 py-1.5 text-xs font-semibold">from {{ $price }}</span>
            </span>
        </a>
    @endforeach
</div>

{{-- Tablet and desktop --}}
<div class="hidden md:grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
    @foreach ($dests as [$name, $places, $img, $price])
        <a href="{{ route('destination', \Illuminate\Support\Str::slug($name)) }}" class="group block text-left bg-white rounded-3xl p-2 border border-ink/5 hover:shadow-lg transition">
            <span class="block overflow-hidden rounded-2xl"><img src="/images/{{ $img }}" @dims('/images/'.$img) alt="{{ $name }}" loading="lazy" class="h-48 w-full object-cover group-hover:scale-105 transition duration-500"></span>
            <span class="block px-3 pt-4 pb-3">
                <span class="block font-display font-bold text-lg">{{ $name }}</span>
                <span class="block text-sm text-ink/60 mt-1">{{ $places }}</span>
                <span class="block mt-3 text-sm"><span class="text-ink/60">from</span> <b>{{ $price }}</b></span>
            </span>
        </a>
    @endforeach
</div>

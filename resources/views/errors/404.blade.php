@extends('layouts.app')
@section('title', 'Page not found - '.config('site.brand'))
@section('description', 'This page could not be found.')
@push('head')
<meta name="robots" content="noindex">
@vite('resources/js/errors.js')
@endpush
@section('content')
<section data-lost class="relative isolate overflow-hidden min-h-[72vh] grid place-items-center px-5 sm:px-8 py-20 text-center">
    {{-- Prayer flags on a string --}}
    <div class="absolute inset-x-0 top-0 -z-10" aria-hidden="true">
        <div class="h-px bg-ink/30 mt-6"></div>
        <div class="flex justify-around -mt-px px-2">
            @foreach (['bg-royal', 'bg-star', 'bg-mist', 'bg-ink', 'bg-royal', 'bg-star', 'bg-mist', 'bg-ink', 'bg-royal', 'bg-star'] as $c)
                <span data-flag class="{{ $c }} block w-5 sm:w-7 h-7 sm:h-9 origin-top [clip-path:polygon(0_0,100%_0,100%_82%,50%_100%,0_82%)]"></span>
            @endforeach
        </div>
    </div>
    {{-- Clouds --}}
    <div class="absolute inset-0 -z-20 overflow-hidden" aria-hidden="true">
        <span data-cloud class="absolute top-[22%] left-0 block w-56 h-14 rounded-[999px] bg-mist"></span>
        <span data-cloud class="absolute top-[58%] left-0 block w-72 h-16 rounded-[999px] bg-mist/80"></span>
        <span data-cloud class="absolute top-[40%] left-0 block w-40 h-10 rounded-[999px] bg-mist/70"></span>
    </div>

    <div class="max-w-2xl">
        <p class="sr-only">Error 404</p>
        <div class="flex items-center justify-center gap-1 sm:gap-3 font-display text-royal leading-none text-[6.5rem] sm:text-[11rem]" aria-hidden="true">
            <span data-digit class="block">4</span>
            <span data-rock class="grid place-items-center size-[5.5rem] sm:size-[9.25rem] rounded-[999px] bg-royal text-paper text-[4.5rem] sm:text-[7.5rem] cursor-grab select-none">0</span>
            <span data-digit class="block">4</span>
        </div>
        <h1 data-line class="mt-8 font-display text-[1.75rem] sm:text-5xl text-ink text-balance leading-tight">You have wandered off the trail.</h1>
        <p data-line class="mt-4 text-ink/70 text-base sm:text-lg max-w-lg mx-auto">Even our drivers do not know this road. The page you wanted has moved, or it never existed. The nearest tea stop is back at base camp.</p>
        <div data-cta class="mt-9 flex flex-wrap justify-center gap-2 sm:gap-3">
            <a href="{{ route('home') }}" class="btn btn-solid">Back to base camp</a>
            <a href="{{ route('destinations') }}" class="btn btn-line-dark">Browse destinations</a>
            <button type="button" @click="pick('')" class="btn btn-line-dark">Plan a trip</button>
        </div>
    </div>
</section>
@endsection

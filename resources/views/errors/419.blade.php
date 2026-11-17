@extends('layouts.app')
@section('title', 'Page expired - '.config('site.brand'))
@push('head')
<meta name="robots" content="noindex">
@endpush
@section('content')
<section class="px-5 sm:px-8 py-24 text-center">
    <p class="kicker text-ink/60">Error 419</p>
    <h1 class="mt-4 font-display text-[1.75rem] sm:text-5xl text-royal">This page timed out.</h1>
    <p class="mt-4 text-ink/70 max-w-md mx-auto">Please go back, refresh the page and try again.</p>
    <a href="{{ route('home') }}" class="btn btn-solid mt-8">Back to base camp</a>
</section>
@endsection

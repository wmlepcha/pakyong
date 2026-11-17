@extends('layouts.app')
@section('title', 'Not allowed - '.config('site.brand'))
@push('head')
<meta name="robots" content="noindex">
@endpush
@section('content')
<section class="px-5 sm:px-8 py-24 text-center">
    <p class="kicker text-ink/60">Error 403</p>
    <h1 class="mt-4 font-display text-[1.75rem] sm:text-5xl text-royal">This path is closed.</h1>
    <p class="mt-4 text-ink/70 max-w-md mx-auto">You do not have permission to open this page.</p>
    <a href="{{ route('home') }}" class="btn btn-solid mt-8">Back to base camp</a>
</section>
@endsection

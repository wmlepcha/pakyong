<section class="px-5 sm:px-8 mt-10 sm:mt-24 lg:mx-8 lg:px-10 lg:py-14 lg:bg-mist">
    <h2 class="font-display text-[1.5rem] sm:text-4xl max-w-xl text-balance">Why travel with us?</h2>
    <dl class="mt-4 lg:mt-10 grid lg:grid-cols-2 lg:gap-x-16 lg:gap-y-8 ios-group">
        @foreach (config('site.why') as [$t, $d])
            <div class="ios-row lg:border-t lg:border-ink/20 lg:pt-5"><dt class="font-display text-lg lg:text-xl">{{ $t }}</dt><dd class="text-ink/70 text-[15px] lg:text-base mt-1 lg:mt-2 max-w-md">{{ $d }}</dd></div>
        @endforeach
    </dl>
</section>

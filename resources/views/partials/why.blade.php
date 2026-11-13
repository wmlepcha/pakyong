<section class="mx-5 sm:mx-8 mt-16 sm:mt-24 bg-mist rounded-[2rem] px-5 sm:px-10 py-10 sm:py-14">
    <h2 class="font-display font-bold text-3xl sm:text-4xl max-w-xl text-balance">Why travel with us?</h2>
    <dl class="mt-8 sm:mt-10 grid sm:grid-cols-2 gap-x-16 gap-y-8">
        @foreach (config('site.why') as [$t, $d])
            <div class="border-t border-ink/20 pt-5"><dt class="font-display font-bold text-xl">{{ $t }}</dt><dd class="text-ink/75 mt-2 max-w-md">{{ $d }}</dd></div>
        @endforeach
    </dl>
</section>

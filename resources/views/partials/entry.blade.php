{{-- Sikkim entry protocol: segmented control by traveller type, one permit-style panel. iOS-style grouped layout on small screens. --}}
<section id="entry" data-spy class="px-5 sm:px-8 pt-12 sm:pt-24 scroll-mt-24" x-data="{ who: 'indian' }">
    <div class="md:border md:border-ink/10 md:bg-white overflow-hidden">
        <div class="md:p-10 flex flex-wrap items-end justify-between gap-6">
            <div class="max-w-xl">
                <h2 class="font-display text-[1.75rem] sm:text-4xl text-balance">Sikkim entry protocol</h2>
                <p class="mt-3 text-ink/70">Permits and registration depend on where you are from and where you are going. We confirm the current rules and handle the paperwork before you travel.</p>
            </div>
            {{-- Segmented control with a sliding thumb --}}
            <div role="tablist" aria-label="Traveller type" class="relative grid grid-cols-2 w-full md:w-96 p-1 bg-mist max-md:rounded-[0.75rem] text-sm font-semibold">
                <span class="absolute inset-y-1 left-1 w-[calc(50%-0.25rem)] bg-white shadow-[0_1px_3px_rgba(45,58,34,.25)] max-md:rounded-[0.55rem] transition-transform duration-300 ease-[cubic-bezier(.32,.72,0,1)]" :class="who === 'foreign' && 'translate-x-full'" aria-hidden="true"></span>
                <button role="tab" type="button" @click="who = 'indian'" :aria-selected="who === 'indian'" class="relative py-3 transition-colors" :class="who === 'indian' ? 'text-ink' : 'text-ink/60'">Indian nationals</button>
                <button role="tab" type="button" @click="who = 'foreign'" :aria-selected="who === 'foreign'" class="relative py-3 transition-colors" :class="who === 'foreign' ? 'text-ink' : 'text-ink/60'">Foreign nationals</button>
            </div>
        </div>

        {{-- Permit-style panel: stub on the left, details on the right, dashed tear line between on desktop --}}
        <div class="mt-6 md:mt-0 grid md:grid-cols-[18rem_1fr] md:border-t md:border-dashed md:border-ink/20">
            <div class="bg-royal text-white max-md:rounded-[1rem] px-5 py-5 md:p-10 flex max-md:items-end justify-between md:flex-col md:justify-between gap-4 md:gap-6 md:border-r md:border-dashed md:border-white/40">
                <p class="text-sm text-white/75" x-text="who === 'indian' ? 'For general areas' : 'Register in advance'"></p>
                <p class="font-display text-4xl md:text-5xl leading-none" x-text="who === 'indian' ? 'No permit' : '15 days'"></p>
            </div>
            <div class="pt-6 md:p-10 flex flex-col gap-6" role="tabpanel">
                <div x-show="who === 'indian'">
                    <h3 class="font-display text-2xl">Indian nationals</h3>
                    <p class="mt-3 text-ink/75 max-w-xl">No permit is needed for the general, unrestricted parts of the state. An Inner Line Permit is required for protected places in the north and east, which we arrange for you.</p>
                    <button type="button" @click="pick('')" class="btn btn-solid mt-6 max-sm:w-full">Plan my trip</button>
                </div>
                <div x-show="who === 'foreign'" x-cloak>
                    <h3 class="font-display text-2xl">Foreign nationals</h3>
                    <p class="mt-3 text-ink/75 max-w-xl">Foreign nationals are required to register through the FRRO portal at least 15 days in advance.</p>
                    <a href="https://indianfrro.gov.in/efrro/" target="_blank" rel="noopener" class="btn btn-ext mt-6 max-sm:w-full">Register on FRRO <x-glyph name="external" class="size-4"/></a>
                </div>
            </div>
        </div>

        {{-- Permit types: an inset grouped list on phones, three tiles from tablet up --}}
        <div class="mt-8 md:mt-0 md:border-t md:border-ink/10 md:bg-mist/60 md:p-10">
            <h3 class="font-display text-xl">Restricted and protected area permits</h3>
            <dl class="mt-4 md:mt-5 grid sm:grid-cols-3 sm:gap-4 max-sm:bg-white max-sm:rounded-[1rem] max-sm:border max-sm:border-ink/10 max-sm:divide-y max-sm:divide-ink/10">
                @foreach ([['PAP', 'Protected Area Permit'], ['RAP', 'Restricted Area Permit'], ['ILP', 'Inner Line Permit']] as [$abbr, $name])
                    <div class="flex items-center gap-4 bg-white px-5 py-3.5 sm:py-4">
                        <dt class="font-display text-2xl text-royal w-14 shrink-0">{{ $abbr }}</dt>
                        <dd class="text-sm text-ink/75">{{ $name }}</dd>
                    </div>
                @endforeach
            </dl>
            <p class="mt-5 text-sm text-ink/70 max-w-3xl">Permit rules vary by destination and traveller type, and each applies in different areas. We confirm the current requirements and handle the paperwork before you travel.</p>
        </div>
    </div>
</section>

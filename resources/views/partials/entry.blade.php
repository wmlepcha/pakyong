{{-- Sikkim entry protocol: toggle by traveller type, one permit-style panel --}}
<section id="entry" data-spy class="px-5 sm:px-8 pt-16 sm:pt-24 scroll-mt-24" x-data="{ who: 'indian' }">
    <div class="rounded-[2rem] border border-ink/10 bg-white overflow-hidden">
        <div class="p-5 sm:p-10 flex flex-wrap items-end justify-between gap-6">
            <div class="max-w-xl">
                <h2 class="font-display font-bold text-3xl sm:text-4xl text-balance">Sikkim entry protocol</h2>
                <p class="mt-3 text-ink/70">Permits and registration depend on where you are from and where you are going. We confirm the current rules and handle the paperwork before you travel.</p>
            </div>
            <div role="tablist" aria-label="Traveller type" class="inline-flex rounded-full bg-mist p-1.5 text-sm font-semibold">
                <button role="tab" type="button" @click="who = 'indian'" :aria-selected="who === 'indian'" class="rounded-full px-5 py-2.5 transition-colors" :class="who === 'indian' ? 'bg-ink text-white' : 'text-ink/70 hover:text-ink'">Indian nationals</button>
                <button role="tab" type="button" @click="who = 'foreign'" :aria-selected="who === 'foreign'" class="rounded-full px-5 py-2.5 transition-colors" :class="who === 'foreign' ? 'bg-ink text-white' : 'text-ink/70 hover:text-ink'">Foreign nationals</button>
            </div>
        </div>

        {{-- Permit-style panel: stub on the left, details on the right, dashed tear line between --}}
        <div class="grid md:grid-cols-[18rem_1fr] border-t border-dashed border-ink/20">
            <div class="bg-royal text-white p-5 sm:p-10 flex flex-col justify-between gap-6 md:border-r border-dashed border-white/40">
                <p class="text-sm text-white/70" x-text="who === 'indian' ? 'For general areas' : 'Register in advance'"></p>
                <p class="font-display font-bold text-5xl leading-none" x-text="who === 'indian' ? 'No permit' : '15 days'"></p>
            </div>
            <div class="p-5 sm:p-10 flex flex-col gap-6" role="tabpanel">
                <div x-show="who === 'indian'">
                    <h3 class="font-display font-bold text-2xl">Indian nationals</h3>
                    <p class="mt-3 text-ink/75 max-w-xl">No permit is needed for the general, unrestricted parts of the state. An Inner Line Permit is required for protected places in the north and east, which we arrange for you.</p>
                    <button type="button" @click="pick('')" class="mt-6 inline-flex items-center gap-3 rounded-full bg-ink text-white font-semibold pl-6 pr-5 py-3.5 hover:bg-royal transition-colors">Plan my trip <x-icon name="arrow" class="size-4"/></button>
                </div>
                <div x-show="who === 'foreign'" x-cloak>
                    <h3 class="font-display font-bold text-2xl">Foreign nationals</h3>
                    <p class="mt-3 text-ink/75 max-w-xl">Foreign nationals are required to register through the FRRO portal at least 15 days in advance.</p>
                    <a href="https://indianfrro.gov.in/efrro/" target="_blank" rel="noopener" class="mt-6 inline-flex items-center gap-3 rounded-full bg-ink text-white font-semibold pl-6 pr-5 py-3.5 hover:bg-royal transition-colors">Register on FRRO <x-icon name="arrow" class="size-4"/></a>
                </div>
            </div>
        </div>

        {{-- Permit types --}}
        <div class="border-t border-ink/10 bg-mist/60 p-5 sm:p-10">
            <h3 class="font-display font-bold text-xl">Restricted and protected area permits</h3>
            <dl class="mt-5 grid sm:grid-cols-3 gap-4">
                @foreach ([['PAP', 'Protected Area Permit'], ['RAP', 'Restricted Area Permit'], ['ILP', 'Inner Line Permit']] as [$abbr, $name])
                    <div class="flex items-center gap-4 bg-white rounded-2xl px-5 py-4">
                        <dt class="font-display font-bold text-2xl text-royal">{{ $abbr }}</dt>
                        <dd class="text-sm text-ink/75">{{ $name }}</dd>
                    </div>
                @endforeach
            </dl>
            <p class="mt-5 text-ink/70 max-w-3xl">Permit rules vary by destination and traveller type, and each applies in different areas. We confirm the current requirements and handle the paperwork before you travel.</p>
        </div>
    </div>
</section>

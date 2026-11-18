    {{-- Route card: pickup, drop, car, date and district, read from the ride form's state (r) --}}
    <div {{ $attributes->class(['relative overflow-hidden bg-mist border border-ink/15']) }} aria-label="Your ride so far">
    {{ $slot }}
        <div class="absolute inset-0 opacity-70 pointer-events-none" aria-hidden="true" style="background-image: linear-gradient(rgb(45 58 34 / .07) 1px, transparent 1px), linear-gradient(90deg, rgb(45 58 34 / .07) 1px, transparent 1px); background-size: 28px 28px"></div>
        <div class="relative px-4 sm:px-8 pt-3 sm:pt-6">
            <div class="relative h-[4.25rem] sm:h-24" aria-hidden="true">
            {{-- Curved road: a dashed arch from the pickup pin to the drop pin, with the car on top --}}
            <span class="absolute inset-x-[14px] top-3 bottom-[14px] border-t-[3px] border-dashed border-star/80 [border-radius:50%_50%_0_0/100%_100%_0_0]"></span>
            <span class="absolute left-1/2 top-3 -translate-x-1/2 -translate-y-1/2 grid place-items-center size-9 bg-ink text-white rounded-[999px] shadow-[0_2px_8px_rgb(45_58_34/.3)]"><x-glyph name="car" class="size-5"/></span>
            <span class="absolute left-1/2 top-[34px] -translate-x-1/2 whitespace-nowrap text-[10px] font-semibold leading-none" :class="r.f.car ? 'text-royal' : 'text-ink/50'" x-text="r.f.car || 'Choose a car'"></span>
            <span class="absolute left-0 bottom-0 grid place-items-center size-7 rounded-[999px] bg-star shadow-[0_2px_6px_rgb(45_58_34/.25)]"><span class="size-2.5 rounded-[999px] bg-white"></span></span>
            <span class="absolute right-0 bottom-0 grid place-items-center size-7 bg-ink rounded-[999px_999px_999px_0] -rotate-45 shadow-[0_2px_6px_rgb(45_58_34/.3)]"><span class="size-2.5 rounded-[999px] bg-white rotate-45"></span></span>
        </div>
        <div class="mt-3 grid grid-cols-2 items-start gap-x-3">
            <div class="min-w-0">
                <p class="kicker !text-[9px] text-ink/60">Pickup</p>
                <p class="font-display text-[13px] sm:text-sm leading-snug line-clamp-2" :class="r.f.pickup ? 'text-ink' : 'text-ink/45'" x-text="r.f.pickup || 'Pickup location'"></p>
                <p class="text-[11px] text-ink/60 truncate" x-show="r.f.district" x-text="r.f.district + ' district'"></p>
            </div>
            <div class="min-w-0 text-right">
                <p class="kicker !text-[9px] text-ink/60">Drop</p>
                <p class="font-display text-[13px] sm:text-sm leading-snug line-clamp-2" :class="r.f.drop ? 'text-ink' : 'text-ink/45'" x-text="r.f.drop || 'Drop location'"></p>
            </div>
        </div>
        <dl class="mt-2 sm:mt-5 -mx-4 sm:-mx-8 grid grid-cols-2 items-end gap-x-4 border-t border-ink/10 bg-white/70 px-4 sm:px-8 py-2 sm:py-3">
                <div class="min-w-0">
                    <dt class="kicker !text-[9px] text-ink/55">Date</dt>
                    <dd class="mt-0.5 font-display text-base sm:text-2xl leading-tight" :class="r.f.date ? 'text-royal' : 'text-ink/35'" x-text="r.f.date ? new Date(r.f.date + 'T00:00').toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' }) : 'Pick a date'"></dd>
                </div>
                <div class="min-w-0 text-right">
                    <dt class="kicker !text-[9px] text-ink/55">Picked up from</dt>
                    <dd class="mt-0.5 text-[13px] sm:text-sm font-semibold truncate" :class="r.f.district ? 'text-ink' : 'text-ink/35'" x-text="r.f.district || 'District'"></dd>
                </div>
            </dl>
        </div>
    </div>

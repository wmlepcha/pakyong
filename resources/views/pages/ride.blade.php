@extends('layouts.app')
@section('title', 'Book a ride in Sikkim, Darjeeling and Kalimpong - '.config('site.brand'))
@section('description', 'Book a 4 seater or 7 seater car for airport, station and hotel pickups across Sikkim, Darjeeling and Kalimpong. Tell us the route and we confirm on WhatsApp.')
@section('content')
<section class="px-5 sm:px-8 pt-4 sm:pt-10 pb-6" x-data="{ r: ride() }">
    <h1 class="font-display ios-title sm:text-6xl text-balance max-w-3xl">Book a ride</h1>
    <p class="mt-2 sm:mt-5 text-base sm:text-lg text-ink/70 max-w-2xl">Airport, station or hotel pickups across Sikkim, Darjeeling and Kalimpong. Tell us the route and we confirm your ride on WhatsApp.</p>

    <div id="ride-top" class="mt-6 sm:mt-10 max-w-2xl scroll-mt-24 ios-group lg:border lg:border-ink/15 lg:bg-white">
        {{-- Done --}}
        <div x-show="r.done" x-cloak class="p-6 sm:p-10 text-center">
            <p class="font-display text-2xl sm:text-3xl text-royal">Your ride request is on its way.</p>
            <p class="mt-3 text-ink/70">WhatsApp has opened with your details. Press send there and we will confirm the ride with you.</p>
            <button type="button" @click="Object.assign(r, { done: false, review: false, step: 1, f: { pickup: '', drop: '', district: '', date: '', car: '', name: '', phone: '' } })" class="btn btn-line-dark mt-6">Book another ride</button>
        </div>

        <form x-show="!r.done" novalidate @submit.prevent="r.send()">
            <div class="px-5 sm:px-8 pt-5 pb-4 border-b border-ink/10">
                <div class="flex items-baseline justify-between gap-4 text-xs text-ink/60">
                    <span x-text="r.review ? 'Review and send' : 'Step ' + r.step + ' of 4'"></span>
                    <span x-text="r.review ? '' : r.titles[r.step - 1]"></span>
                </div>
                <div class="mt-3 grid grid-cols-4 gap-1.5" aria-hidden="true"><template x-for="n in 4"><span class="h-1 transition-colors" :class="r.review || n <= r.step ? 'bg-royal' : 'bg-ink/15'"></span></template></div>
            </div>

            <div class="px-5 sm:px-8 py-6 sm:py-8">
                {{-- 1. Route --}}
                <fieldset x-show="!r.review && r.step === 1" class="grid gap-5 text-sm font-medium">
                    <legend class="font-display text-2xl text-royal mb-1">Where to?</legend>
                    <label>Pickup location
                        <input x-model="r.f.pickup" maxlength="120" autocomplete="off" enterkeyhint="next" placeholder="e.g. Bagdogra Airport" class="field placeholder:text-ink/65"></label>
                    <label>Drop location
                        <input x-model="r.f.drop" maxlength="120" autocomplete="off" enterkeyhint="next" placeholder="e.g. MG Marg, Gangtok" class="field placeholder:text-ink/65"></label>
                    <x-select label="Pickup district" model="r.f.district" options="Guard.DISTRICTS"/>
                </fieldset>

                {{-- 2. Date --}}
                <fieldset x-show="!r.review && r.step === 2" x-cloak class="grid gap-3 text-sm font-medium">
                    <legend class="font-display text-2xl text-royal mb-1">When?</legend>
                    <x-date-picker label="Pickup date" model="r.f.date" :years="1"/>
                </fieldset>

                {{-- 3. Car --}}
                <div x-show="!r.review && r.step === 3" x-cloak class="text-sm">
                    <h2 class="font-display text-2xl text-royal mb-3">Which car?</h2>
                    <x-radio-cards label="Car type" name="car" model="r.f.car" :options="[['4 seater', 'Up to 4 passengers, with room for luggage.'], ['7 seater', 'Up to 7 passengers, good for families and groups.']]"/>
                </div>

                {{-- 4. Details --}}
                <fieldset x-show="!r.review && r.step === 4" x-cloak class="grid gap-5 text-sm font-medium">
                    <legend class="font-display text-2xl text-royal mb-1">Your details</legend>
                    <label>Full name
                        <input x-model="r.f.name" @input="r.f.name = Guard.name($event.target.value)" maxlength="60" autocomplete="name" autocapitalize="words" autocorrect="off" spellcheck="false" enterkeyhint="next" placeholder="Your full name" class="field placeholder:text-ink/65"></label>
                    <label>WhatsApp number
                        <input x-model="r.f.phone" @input="r.f.phone = Guard.phone($event.target.value)" type="tel" inputmode="tel" maxlength="20" autocomplete="tel" autocorrect="off" spellcheck="false" enterkeyhint="send" placeholder="e.g. +91 98765 43210" class="field placeholder:text-ink/65"></label>
                </fieldset>

                {{-- Review --}}
                <div x-show="r.review" x-cloak>
                    <h2 class="font-display text-2xl text-royal">Check your ride</h2>
                    <dl class="mt-4 border-t border-ink/15">
                        <template x-for="row in r.summary" :key="row.label">
                            <div class="grid grid-cols-[1fr_auto] items-baseline gap-x-4 gap-y-0.5 py-3 border-b border-ink/15">
                                <dt class="kicker !text-[10px] text-ink/55" x-text="row.label"></dt>
                                <button type="button" @click="r.edit(row.step)" class="text-sm font-semibold text-royal underline underline-offset-4 decoration-royal/40 hover:decoration-royal row-span-2 self-start" :aria-label="'Edit ' + row.label">Edit</button>
                                <dd class="col-start-1 text-[15px] font-medium leading-snug" x-text="row.value"></dd>
                            </div>
                        </template>
                    </dl>
                </div>
            </div>

            <div class="px-5 sm:px-8 py-4 border-t border-ink/10 flex flex-wrap items-center justify-between gap-x-6 gap-y-3">
                <p class="text-sm" :class="r.err ? 'text-red-700 font-medium' : 'text-ink/65'" :role="r.err ? 'alert' : null" x-text="r.err || r.hint || (r.review ? 'No payment now. We confirm the ride on WhatsApp.' : '')"></p>
                <div class="flex gap-2 max-sm:w-full ml-auto">
                    <button type="button" x-show="r.step > 1 || r.editing || r.review" @click="r.back()" class="btn btn-line-dark max-sm:flex-1">Back</button>
                    <button type="submit" :disabled="!r.review && !r.ready" class="btn btn-solid max-sm:flex-1" x-text="r.review ? 'Send on WhatsApp' : (r.editing ? 'Save changes' : (r.step < 4 ? 'Next' : 'Review'))"></button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

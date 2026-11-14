@extends('layouts.app')
@php
    $phone = config('site.phone');
    $wa = preg_replace('/\D/', '', $phone);
    $field = 'mt-2 w-full rounded-2xl border border-ink/15 bg-white px-5 py-3.5 focus:outline-none focus:ring-2 focus:ring-royal/40';
    $methods = [
        ['headset', 'Call us', $phone, 'tel:+'.$wa, null],
        ['chat', 'WhatsApp', 'Chat with a local team member', 'https://wa.me/'.$wa, '_blank'],
        ['pin', 'Visit us', 'Gangtok, Sikkim', null, null],
    ];
@endphp
@section('title', 'Contact - '.config('site.brand'))
@section('description', 'Message or call the Pakyong Tours team in Gangtok to plan your Sikkim trip. Share your dates and we reply with an itinerary within a day.')
@section('content')
<section class="px-5 sm:px-8 pt-4 sm:pt-10">
    <h1 class="font-display font-bold text-[2rem] leading-[1.1] sm:text-6xl text-balance max-w-3xl">Let's plan your Sikkim trip</h1>
    <p class="mt-2 sm:mt-5 text-base sm:text-lg text-ink/70 max-w-2xl">Call, message us on WhatsApp or send a note. A local team member will reply, usually within a day.</p>

    <div class="hidden md:grid mt-12 lg:grid-cols-[1fr_1.15fr] gap-8 lg:gap-12 items-start">
        {{-- Ways to reach us --}}
        <div>
        <ul class="max-sm:overflow-hidden max-sm:rounded-3xl max-sm:bg-white max-sm:border max-sm:border-ink/5 max-sm:divide-y max-sm:divide-ink/10 sm:space-y-4">
            @foreach ($methods as [$icon, $title, $detail, $href, $target])
                <li>
                    @if ($href)<a href="{{ $href }}" @if ($target) target="{{ $target }}" rel="noopener" @endif class="group flex items-center gap-4 sm:gap-5 bg-white sm:border border-ink/5 sm:rounded-3xl max-sm:rounded-none p-4 sm:p-6 hover:shadow-lg transition-shadow">
                    @else<div class="flex items-center gap-4 sm:gap-5 bg-white sm:border border-ink/5 sm:rounded-3xl p-4 sm:p-6">@endif
                        <span class="grid place-items-center size-14 shrink-0 rounded-2xl bg-mist text-royal"><x-icon :name="$icon" class="size-6"/></span>
                        <span class="min-w-0 flex-1"><span class="block font-display font-bold text-xl">{{ $title }}</span><span class="block text-ink/70 mt-0.5">{{ $detail }}</span></span>
                        @if ($href)<x-icon name="right" class="size-5 text-ink/35 group-hover:text-royal group-hover:translate-x-1 transition"/>@endif
                    @if ($href)</a>@else</div>@endif
                </li>
            @endforeach
        </ul>
<div class="rounded-3xl bg-mist p-5 sm:p-7 mt-4 sm:mt-4">
                <p class="font-display font-bold text-xl">Planning a full trip?</p>
                <p class="mt-1 text-ink/70">Share your dates and group size and we'll send a tailored itinerary.</p>
                <button type="button" @click="pick('')" class="mt-4 inline-flex items-center gap-3 rounded-full bg-ink text-white font-semibold pl-6 pr-5 py-3.5 hover:bg-royal transition-colors">Plan my trip <x-icon name="arrow" class="size-4"/></button>
            </div>
        </div>

        {{-- Message form: opens WhatsApp with the note prefilled (no backend yet) --}}
        <form class="bg-white border border-ink/5 rounded-[2rem] p-5 sm:p-10" novalidate
              x-data="contactForm('{{ $wa }}', '{{ $phone }}')" @submit.prevent="send()">
            <h2 class="font-display font-bold text-2xl sm:text-3xl">Send us a message</h2>
            <div class="mt-6 grid sm:grid-cols-2 gap-5">
                <div>
                    <label for="d-name" class="text-sm font-semibold">Name</label>
                    <input id="d-name" x-model="name" @input="name = Guard.name($event.target.value); errs.name = ''" @blur="errs.name = name ? Guard.vName(name) : ''" maxlength="60" autocomplete="name" :aria-invalid="!!errs.name" aria-describedby="d-name-err"
                           :class="errs.name ? 'border-red-500' : 'border-ink/15'" class="mt-2 w-full rounded-2xl border bg-white px-5 py-3.5 focus:outline-none focus:ring-2 focus:ring-royal/40">
                    <p id="d-name-err" x-show="errs.name" x-text="errs.name" class="mt-1.5 text-sm text-red-700" role="alert"></p>
                </div>
                <div>
                    <label for="d-phone" class="text-sm font-semibold">Phone or WhatsApp</label>
                    <input id="d-phone" x-model="phone" type="tel" inputmode="tel" @input="phone = Guard.phone($event.target.value); errs.phone = ''" @blur="errs.phone = phone ? Guard.vPhone(phone) : ''" maxlength="20" autocomplete="tel" :aria-invalid="!!errs.phone" aria-describedby="d-phone-err"
                           :class="errs.phone ? 'border-red-500' : 'border-ink/15'" class="mt-2 w-full rounded-2xl border bg-white px-5 py-3.5 focus:outline-none focus:ring-2 focus:ring-royal/40">
                    <p id="d-phone-err" x-show="errs.phone" x-text="errs.phone" class="mt-1.5 text-sm text-red-700" role="alert"></p>
                </div>
                <div class="sm:col-span-2">
                    <div class="flex items-baseline justify-between"><label for="d-msg" class="text-sm font-semibold">Message</label><span class="text-xs text-ink/50 tabular-nums" x-text="msg.length + '/500'"></span></div>
                    <textarea id="d-msg" x-model="msg" @input="msg = Guard.text($event.target.value, 500); errs.msg = ''" @blur="errs.msg = msg ? Guard.vMsg(msg) : ''" rows="5" maxlength="500" placeholder="Where would you like to go, and when?" :aria-invalid="!!errs.msg" aria-describedby="d-msg-err"
                              :class="errs.msg ? 'border-red-500' : 'border-ink/15'" class="mt-2 w-full rounded-2xl border bg-white px-5 py-3.5 focus:outline-none focus:ring-2 focus:ring-royal/40 resize-y"></textarea>
                    <p id="d-msg-err" x-show="errs.msg" x-text="errs.msg" class="mt-1.5 text-sm text-red-700" role="alert"></p>
                </div>
            </div>
            <div class="mt-6 flex flex-wrap items-center gap-4">
                <button type="submit" class="inline-flex items-center gap-3 rounded-full bg-royal text-white font-semibold pl-7 pr-6 py-4 hover:bg-ink transition-colors">Send on WhatsApp <x-icon name="arrow" class="size-4"/></button>
                <p class="text-sm text-ink/60">Opens WhatsApp with your message ready to send.</p>
            </div>
        </form>
    </div>
</section>

{{-- ============ Phone app layout ============ --}}
@php
    $maps = 'https://www.google.com/maps/search/?api=1&query='.urlencode('Dhungkar Technology Gangtok'); // placeholder: point at the real office
@endphp
<section class="md:hidden px-5 sm:px-8 pt-5 pb-8" x-data="contactForm('{{ $wa }}', '{{ $phone }}')">

    {{-- Quick actions --}}
    <div class="grid grid-cols-3 gap-3">
        @foreach ([['headset', 'Call', 'tel:+'.$wa, null], ['chat', 'WhatsApp', 'https://wa.me/'.$wa, '_blank'], ['navigation', 'Directions', $maps, '_blank']] as [$ic, $label, $href, $target])
            <a href="{{ $href }}" @if ($target) target="{{ $target }}" rel="noopener" @endif class="flex flex-col items-center gap-2 rounded-2xl bg-white border border-ink/5 shadow-sm py-4">
                <span class="grid place-items-center size-11 rounded-full bg-mist text-royal"><x-icon :name="$ic" class="size-5"/></span>
                <span class="text-xs font-semibold">{{ $label }}</span>
            </a>
        @endforeach
    </div>

    {{-- Details --}}
    <ul class="mt-5 rounded-2xl bg-white border border-ink/5 divide-y divide-ink/10 overflow-hidden">
        <li class="flex items-center">
            <a href="tel:+{{ $wa }}" class="flex-1 min-w-0 px-4 py-3.5"><span class="block text-xs font-semibold text-royal">Phone</span><span class="block text-base mt-0.5">{{ $phone }}</span></a>
            <button type="button" @click="copy()" aria-label="Copy phone number" class="grid place-items-center size-12 mr-1 text-ink/50"><x-icon name="copy" class="size-5"/></button>
        </li>
        <li class="px-4 py-3.5"><span class="block text-xs font-semibold text-royal">Location</span><span class="block text-base mt-0.5">Gangtok, Sikkim</span></li>
        <li class="px-4 py-3.5"><span class="block text-xs font-semibold text-royal">We reply</span><span class="block text-base mt-0.5">Usually within a day</span></li>
    </ul>

    {{-- Message form (opens WhatsApp with the note prefilled) --}}
    <form class="mt-8" novalidate @submit.prevent="send()">
        <h2 class="font-display font-bold text-xl px-1">Send a message</h2>
        <div class="mt-3 rounded-2xl bg-white border border-ink/5 divide-y divide-ink/10 overflow-hidden">
            <label class="flex items-center gap-3 px-4 py-3.5"><span class="w-16 shrink-0 text-sm font-semibold">Name</span><input x-model="name" @input="name = Guard.name($event.target.value); errs.name = ''" @blur="errs.name = name ? Guard.vName(name) : ''" maxlength="60" autocomplete="name" enterkeyhint="next" placeholder="Your name" :aria-invalid="!!errs.name" class="flex-1 min-w-0 bg-transparent text-base placeholder:text-ink/35 focus:outline-none"></label>
            <p x-show="errs.name" x-text="errs.name" class="px-4 py-2 text-sm text-red-700 bg-red-50" role="alert"></p>
            <label class="flex items-center gap-3 px-4 py-3.5"><span class="w-16 shrink-0 text-sm font-semibold">Phone</span><input x-model="phone" type="tel" inputmode="tel" @input="phone = Guard.phone($event.target.value); errs.phone = ''" @blur="errs.phone = phone ? Guard.vPhone(phone) : ''" maxlength="20" autocomplete="tel" enterkeyhint="next" placeholder="WhatsApp number" :aria-invalid="!!errs.phone" class="flex-1 min-w-0 bg-transparent text-base placeholder:text-ink/35 focus:outline-none"></label>
            <p x-show="errs.phone" x-text="errs.phone" class="px-4 py-2 text-sm text-red-700 bg-red-50" role="alert"></p>
            <label class="block px-4 py-3.5"><span class="flex items-baseline justify-between"><span class="text-sm font-semibold">Message</span><span class="text-xs text-ink/50 tabular-nums" x-text="msg.length + '/500'"></span></span><textarea x-model="msg" @input="msg = Guard.text($event.target.value, 500); errs.msg = ''" @blur="errs.msg = msg ? Guard.vMsg(msg) : ''" rows="4" maxlength="500" placeholder="Where would you like to go, and when?" :aria-invalid="!!errs.msg" class="mt-2 w-full bg-transparent text-base placeholder:text-ink/35 focus:outline-none resize-none"></textarea></label>
            <p x-show="errs.msg" x-text="errs.msg" class="px-4 py-2 text-sm text-red-700 bg-red-50" role="alert"></p>
        </div>
        <button type="submit" class="mt-4 w-full rounded-full bg-royal text-white font-semibold py-4">Send on WhatsApp</button>
        <p class="mt-2 text-center text-xs text-ink/55">Opens WhatsApp with your message ready to send.</p>
    </form>

    <div class="mt-8 rounded-3xl bg-mist p-5">
        <p class="font-display font-bold text-lg">Planning a full trip?</p>
        <p class="mt-1 text-sm text-ink/70">Share your dates and group size for a tailored itinerary.</p>
        <button type="button" @click="pick('')" class="mt-4 w-full rounded-full bg-ink text-white font-semibold py-3.5">Plan my trip</button>
    </div>

    {{-- Map --}}
    <div class="mt-8 relative h-64 rounded-3xl overflow-hidden border border-ink/10 bg-mist">
        <iframe title="Map showing our location in Gangtok, Sikkim" class="size-full border-0"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3544.876996725831!2d88.60240979999999!3d27.3170379!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39e6bab528afa049%3A0xdde6213f5d58dd3f!2sDhungkar%20Technology!5e0!3m2!1sen!2sin!4v1794501988859!5m2!1sen!2sin"
                allowfullscreen loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
        <a href="{{ $maps }}" target="_blank" rel="noopener" class="absolute left-3 top-3 inline-flex items-center gap-2 rounded-full bg-white shadow px-4 py-2 text-sm font-semibold"><x-icon name="navigation" class="size-4 text-royal"/>Directions</a>
    </div>

    {{-- Toast --}}
    <div x-show="toast" x-cloak x-transition.opacity class="fixed left-1/2 -translate-x-1/2 bottom-28 z-50 rounded-full bg-ink text-white text-sm font-semibold px-5 py-3 shadow-lg" role="status" x-text="toast"></div>
</section>

{{-- Map: placeholder location, replace the embed src with the real office --}}
<section class="hidden md:block px-5 sm:px-8 pt-16 pb-24">
    <div class="overflow-hidden rounded-[2rem] border border-ink/10 bg-mist h-[22rem] sm:h-[28rem]">
        <iframe title="Map showing our location in Gangtok, Sikkim" class="size-full border-0"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3544.876996725831!2d88.60240979999999!3d27.3170379!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39e6bab528afa049%3A0xdde6213f5d58dd3f!2sDhungkar%20Technology!5e0!3m2!1sen!2sin!4v1794501988859!5m2!1sen!2sin"
                allowfullscreen loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
    </div>
</section>
@endsection

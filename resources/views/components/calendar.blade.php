{{-- Month grid bound to the parent's f.date (YYYY-MM-DD). Emits "picked" on selection. --}}
<div x-data="calendar()" x-init="view = f.date ? new Date(f.date + 'T00:00') : new Date(); view = new Date(view.getFullYear(), view.getMonth(), 1)" {{ $attributes }}>
    <div class="flex items-center justify-between mb-3">
        <button type="button" @click="shift(-1)" :disabled="!canPrev" aria-label="Previous month"
                class="grid place-items-center size-9 rounded-full hover:bg-mist disabled:opacity-25 disabled:hover:bg-transparent"><x-icon name="left" class="size-4"/></button>
        <p class="font-display font-bold text-lg" x-text="title"></p>
        <button type="button" @click="shift(1)" aria-label="Next month" class="grid place-items-center size-9 rounded-full hover:bg-mist"><x-icon name="right" class="size-4"/></button>
    </div>
    <div class="grid grid-cols-7 text-center text-xs font-semibold text-ink/50 mb-1">
        @foreach (['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'] as $d)<span class="py-1">{{ $d }}</span>@endforeach
    </div>
    <div class="grid grid-cols-7 gap-y-1 text-sm">
        <template x-for="(d, i) in cells" :key="i">
            <div class="grid place-items-center">
                <template x-if="d">
                    <button type="button" :disabled="past(d)" @click="f.date = iso(d); $dispatch('picked')"
                            :aria-label="d.toDateString()" :aria-pressed="f.date === iso(d)"
                            class="size-10 rounded-full font-medium transition-colors disabled:text-ink/25 disabled:cursor-not-allowed"
                            :class="f.date === iso(d) ? 'bg-royal text-white' : (isToday(d) ? 'ring-1 ring-royal/50 hover:bg-mist' : 'hover:bg-mist')"
                            x-text="d.getDate()"></button>
                </template>
            </div>
        </template>
    </div>
</div>

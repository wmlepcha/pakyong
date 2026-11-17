{{-- Month-grid date picker bound to a parent Alpine value (YYYY-MM-DD). Replaces the browser's unstyled native calendar. --}}
@props(['label', 'model', 'error' => 'false', 'range' => '0', 'years' => 3])
<div x-id="['dp']"
     x-data="{ view: new Date(),
        get title() { return this.view.toLocaleDateString('en-IN', { month: 'long', year: 'numeric' }); },
        get cells() {
            const y = this.view.getFullYear(), m = this.view.getMonth();
            const lead = new Date(y, m, 1).getDay(), n = new Date(y, m + 1, 0).getDate();
            return [...Array(lead).fill(null), ...Array.from({ length: n }, (_, i) => new Date(y, m, i + 1))];
        },
        get canPrev() { const t = new Date(); return this.view > new Date(t.getFullYear(), t.getMonth(), 1); },
        get canNext() { const t = new Date(); return this.view < new Date(t.getFullYear() + {{ $years }}, t.getMonth(), 1); },
        iso(d) { return `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`; },
        off(d) { const t = new Date(); t.setHours(0, 0, 0, 0); const l = new Date(t); l.setFullYear(l.getFullYear() + {{ $years }}); return d < t || d > l; },
        inRange(d) { const n = +({{ $range }}); if (!{{ $model }} || !n) return false; const a = new Date({{ $model }} + 'T00:00'), b = new Date(a); b.setDate(b.getDate() + n - 1); return d > a && d <= b; },
        isToday(d) { return this.iso(d) === this.iso(new Date()); },
        shift(n) { this.view = new Date(this.view.getFullYear(), this.view.getMonth() + n, 1); },
        init() { if ({{ $model }}) { const v = new Date({{ $model }} + 'T00:00'); this.view = new Date(v.getFullYear(), v.getMonth(), 1); } else this.view = new Date(this.view.getFullYear(), this.view.getMonth(), 1); },
        pick(d) { {{ $model }} = this.iso(d); } }">
    <span :id="$id('dp')" class="block">{{ $label }}</span>
    <div role="group" :aria-labelledby="$id('dp')" class="mt-1.5 border p-4 sm:p-5 bg-white" :class="{{ $error }} ? 'border-red-700' : 'border-ink/30'">
        <div class="flex items-center justify-between mb-3">
            <button type="button" @click="shift(-1)" :disabled="!canPrev" aria-label="Previous month" class="grid place-items-center size-10 text-royal hover:bg-mist disabled:opacity-25 disabled:hover:bg-transparent"><x-glyph name="left" class="size-4"/></button>
            <p class="font-display text-lg" x-text="title" aria-live="polite"></p>
            <button type="button" @click="shift(1)" :disabled="!canNext" aria-label="Next month" class="grid place-items-center size-10 text-royal hover:bg-mist disabled:opacity-25 disabled:hover:bg-transparent"><x-glyph name="right" class="size-4"/></button>
        </div>
        <div class="grid grid-cols-7 text-center text-xs font-semibold text-ink/60 mb-1">
            @foreach (['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'] as $d)<span class="py-1">{{ $d }}</span>@endforeach
        </div>
        <div class="grid grid-cols-7 gap-y-1 text-sm">
            <template x-for="(d, i) in cells" :key="i">
                <div class="grid place-items-center">
                    <template x-if="d">
                        <button type="button" :disabled="off(d)" @click="pick(d)" :aria-label="d.toDateString()" :aria-pressed="{{ $model }} === iso(d)"
                                class="size-10 font-medium transition-colors disabled:text-ink/25 disabled:cursor-not-allowed"
                                :class="{{ $model }} === iso(d) ? 'bg-royal text-white' : (inRange(d) ? 'bg-[#dfe4c6] text-ink' : (isToday(d) ? 'border border-royal/50 hover:bg-mist' : 'hover:bg-mist disabled:hover:bg-transparent'))"
                                x-text="d.getDate()"></button>
                    </template>
                </div>
            </template>
        </div>
        <p class="mt-4 pt-3 border-t border-ink/10 text-sm" aria-live="polite"><span class="text-ink/60 font-normal">Selected:</span> <span class="font-semibold" x-text="{{ $model }} ? fmtDate({{ $model }}) : 'No date chosen yet'"></span></p>
    </div>
</div>

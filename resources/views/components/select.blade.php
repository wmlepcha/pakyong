{{-- Custom listbox that replaces the native select, whose popup the browser draws and we cannot style. --}}
@props(['label', 'model', 'options', 'suffix' => '', 'error' => 'false'])
<div x-id="['sel']" x-data="{ o: false, hi: 0, list: {{ $options }},
        pickAt(i) { {{ $model }} = this.list[i]; this.o = false; this.$refs.btn.focus(); },
        openList() { this.hi = Math.max(0, this.list.indexOf({{ $model }})); this.o = true; this.$nextTick(() => this.$refs.box.children[this.hi]?.scrollIntoView({ block: 'nearest' })); },
        step(d) { if (!this.o) return this.openList(); this.hi = (this.hi + d + this.list.length) % this.list.length; this.$refs.box.children[this.hi]?.scrollIntoView({ block: 'nearest' }); } }"
     class="relative" @click.outside="o = false" @keydown.escape.stop="o = false">
    <span :id="$id('sel')" class="block">{{ $label }}</span>
    <button type="button" x-ref="btn" class="field flex items-center justify-between gap-3 text-left" :class="[o && '!border-royal', {{ $error }} && '!border-red-700']"
            aria-haspopup="listbox" :aria-expanded="o" :aria-labelledby="$id('sel')"
            @click="o ? o = false : openList()"
            @keydown.arrow-down.prevent="step(1)" @keydown.arrow-up.prevent="step(-1)"
            @keydown.enter="o && ($event.preventDefault(), pickAt(hi))" @keydown.tab="o = false">
        <span class="truncate" :class="!{{ $model }} && 'text-ink/50 font-normal'" x-text="{{ $model }} ? {{ $model }} + '{{ $suffix }}' : 'Select'"></span>
        <x-glyph name="down" class="size-4 shrink-0 text-royal transition-transform duration-200" ::class="o && 'rotate-180'"/>
    </button>
    <ul x-ref="box" x-show="o" x-cloak x-transition:enter="transition duration-150 ease-out" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:leave="transition duration-100" x-transition:leave-end="opacity-0"
        role="listbox" :aria-labelledby="$id('sel')" class="absolute z-20 left-0 right-0 mt-1.5 max-h-64 overflow-y-auto overscroll-contain bg-white border border-royal py-1 shadow-[0_18px_40px_-16px_rgba(45,58,34,.45)]">
        <template x-for="(opt, i) in list" :key="opt">
            <li role="option" :aria-selected="opt == {{ $model }}" @click="pickAt(i)" @mousemove="hi = i"
                class="flex items-center justify-between gap-3 px-4 py-3 text-base font-normal cursor-pointer" :class="[hi === i && 'bg-mist', opt == {{ $model }} && '!font-semibold text-royal']">
                <span x-text="opt + '{{ $suffix }}'"></span>
                <x-glyph name="check" class="size-4 text-royal" x-show="opt == {{ $model }}"/>
            </li>
        </template>
    </ul>
    {{ $slot }}
</div>

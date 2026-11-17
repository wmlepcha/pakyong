{{-- Radio list: one tappable row per option with a title, a short description and a round radio on the right. --}}
@props(['label', 'model', 'name', 'options'])
<fieldset>
    <legend class="font-medium">{{ $label }}</legend>
    <div class="mt-2.5 grid gap-2.5">
        @foreach ($options as [$value, $note])
            <label class="block cursor-pointer">
                <input type="radio" name="{{ $name }}" value="{{ $value }}" x-model="{{ $model }}" class="peer sr-only">
                <span class="flex items-center justify-between gap-4 border border-ink/20 bg-white px-4 py-3.5 transition-colors hover:border-royal peer-checked:border-royal peer-checked:bg-mist peer-checked:shadow-[inset_0_0_0_1px_var(--color-royal)] peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-star peer-checked:[&_.dot]:border-royal peer-checked:[&_.dot>span]:scale-100">
                    <span>
                        <span class="block text-base font-semibold">{{ $value }}</span>
                        <span class="mt-0.5 block text-sm font-normal text-ink/60">{{ $note }}</span>
                    </span>
                    <span class="dot grid place-items-center size-5 shrink-0 rounded-[999px] border-2 border-ink/30 transition-colors"><span class="size-2.5 rounded-[999px] bg-royal scale-0 transition-transform"></span></span>
                </span>
            </label>
        @endforeach
    </div>
</fieldset>

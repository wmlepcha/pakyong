<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6">
        {{ $this->form }}

        <x-filament::button type="submit">Save images</x-filament::button>
    </form>

    <p class="text-sm text-gray-500">
        The four destination tiles and every other picture are edited under Destinations, Home page trips and Experiences.
    </p>
</x-filament-panels::page>

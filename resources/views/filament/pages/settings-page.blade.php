<x-filament::page class="">
    <form wire:submit.prevent="submit">
        {{ $this->form }}

        <div class="mt-10">
            <br><br>
            <x-filament::button type="submit">
                 Save Setting
            </x-filament::button>
        </div>
    </form>
</x-filament::page>

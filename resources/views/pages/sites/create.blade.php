<?php

use Illuminate\Support\Arr;

use function Laravel\Folio\middleware;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

middleware(['auth']);

state(['domain' => '']);

rules(['domain' => 'required|url']);

$createSite = function () {
    $this->validate();

    $user = auth()->user();

    $parsed = parse_url($this->domain);

    $site = $user->sites()->create([
        'scheme' => Arr::get($parsed, 'scheme'),
        'domain' => Arr::get($parsed, 'host'),
    ]);

    return redirect()->route('dashboard');
}

?>


<x-layouts.proto>
    <div class="p-6">
        <h1 class="text-xl font-medium">Crear sitio</h1>

        @volt('create.site')
            <form wire:submit="createSite" class="space-y-2 mt-5">
                <input wire:model="domain" name="domain" type="text" class="block">
                @error('domain')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
                <button class="border px-3 py-1 border-gray-500">Crear</button>
            </form>
        @endvolt
    </div>
</x-layouts.proto>

<?php

use App\Enums\EndpointFrequency;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\Enum;
use Illuminate\View\View;

use function Laravel\Folio\middleware;
use function Laravel\Folio\render;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use function Livewire\Volt\with;

middleware(['auth', 'verified']);

state([
    'site' => fn () => $site,
    'location' => '',
    'frequency' => EndpointFrequency::FIVE_MINUTES->value,
]);

rules([
    'location' => ['required'],
    'frequency' => ['required', new Enum(EndpointFrequency::class)],
]);

with(fn () => ['endpointFrequencies' => EndpointFrequency::cases()]);

$createEndpoint = function () {
    $this->validate();

    $this->authorize('storeEndpoint', $this->site);

    $parsed = parse_url($this->site->url() . '/' . $this->location);

    $this->location = '/' . trim(trim(Arr::get($parsed, 'path'), '/') . '?' . Arr::get($parsed, 'query'), '?');

    $this->site->endpoints()->create([
        'location' => $this->location,
        'frequency' => $this->frequency,
        'next_check' => now()->addSeconds($this->frequency),
    ]);

    return to_route('sites.show', ['site' => $this->site]);
};

?>

<x-layouts.proto>
    <div class="p-6">
        <h1 class="text-xl font-medium">Crear endpoint</h1>

        @volt('create.endpoint')
            <form wire:submit="createEndpoint" class="space-y-2 mt-5">
                <input wire:model="location" name="location" type="text" class="block" placeholder="/precios">
                @error('location')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
                <select wire:model="frequency" name="frequency" class="block">
                    @foreach($endpointFrequencies as $endpointFrequency)
                        <option value="{{ $endpointFrequency->value }}">{{ $endpointFrequency->label() }}</option>
                    @endforeach
                </select>
                @error('frequency')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
                <button class="border px-3 py-1 border-gray-500">Crear</button>
            </form>
        @endvolt
    </div>
</x-layouts.proto>

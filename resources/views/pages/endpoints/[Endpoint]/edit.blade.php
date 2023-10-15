<?php

use App\Enums\EndpointFrequency;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\Enum;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use function Livewire\Volt\with;

middleware(['auth', 'verified']);

name('endpoint.edit');

state([
    'endpoint' => fn () => $endpoint,
    'location' => fn () => $this->endpoint->location,
    'frequency' => fn () => $this->endpoint->frequency,
]);

rules([
    'location' => ['required'],
    'frequency' => ['required', new Enum(EndpointFrequency::class)],
]);

with(fn () => ['endpointFrequencies' => EndpointFrequency::cases()]);

$updateEndpoint = function () {
    $this->validate();

    $this->authorize('update', $this->endpoint);

    $parsed = parse_url($this->endpoint->site->url() . '/' . $this->location);

    $this->location = '/' . trim(trim(Arr::get($parsed, 'path'), '/') . '?' . Arr::get($parsed, 'query'), '?');

    $this->endpoint->update([
        'location' => $this->location,
        'frequency' => $this->frequency,
    ]);

    return to_route('sites.show', ['site' => $this->endpoint->site]);
};

?>

<x-layouts.app>
    <x-slot name="title">
        <div class="flex items-center">
            <span class="text-palette-800 w-full text-lg font-medium lowercase">
                Editar endpoint
            </span>
        </div>
    </x-slot>
    <div class="p-6">
        @volt('edit.endpoint')
            <form wire:submit="updateEndpoint" class="space-y-2 mt-5">
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
                <button class="border px-3 py-1 border-gray-500">Guardar</button>
            </form>
        @endvolt
    </div>
</x-layouts.app>

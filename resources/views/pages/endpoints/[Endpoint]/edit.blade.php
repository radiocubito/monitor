<?php

use App\Enums\EndpointFrequency;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\Enum;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use function Livewire\Volt\with;

middleware(['auth', 'verified', 'can:update,endpoint']);

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

    session()->flash('flash.toast', 'Endpoint guardado');
    session()->flash('flash.toastType', 'success');

    $this->redirect(route('endpoint.edit', ['endpoint' => $this->endpoint]), navigate: true);
};

?>

<x-layouts.site :site="$endpoint->site">
    <x-slot name="title">
        <div class="flex items-center">
            <span class="text-gray-800 w-full text-lg font-medium lowercase">
                Editar endpoint
            </span>
        </div>
    </x-slot>
    <div class="mx-auto max-w-xl space-y-9 px-5 pt-5">
        @volt('edit.endpoint')
            <section>
                <header>
                    <h1 class="text-lg font-medium text-gray-800">
                        Editar endpoint
                    </h1>

                    <div class="mt-1 text-sm text-gray-500">
                        Actualiza la información del endpoint
                    </div>
                </header>

                <form wire:submit="updateEndpoint" class="mt-6 space-y-6">
                    <div>
                        <x-text-input wire:model="location" id="location" class="block mt-1 w-full" type="text" name="location" placeholder="p. ej. /precios" />
                        <x-input-error :messages="$errors->get('location')" class="mt-3" />
                    </div>

                    <div>
                        <x-select-input wire:model="frequency" id="frequency" class="block mt-1 w-full" type="text" name="frequency">
                            @foreach($endpointFrequencies as $endpointFrequency)
                                <option value="{{ $endpointFrequency->value }}">{{ $endpointFrequency->label() }}</option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('frequency')" class="mt-3" />
                    </div>

                    <div>
                        <x-primary-button>Guardar</x-primary-button>
                    </div>
                </form>
            </section>
        @endvolt
    </div>
</x-layouts.site>

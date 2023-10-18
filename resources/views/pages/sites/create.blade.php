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

    session()->flash('flash.toast', 'Nuevo sitio creado');
    session()->flash('flash.toastType', 'success');

    $this->redirect(route('dashboard'), navigate: true);
}

?>


<x-layouts.app>
    <x-slot name="title">
        <div class="flex items-center">
            <span class="text-gray-800 w-full text-lg font-medium lowercase">
                sitios
            </span>
        </div>
    </x-slot>
    <div class="mx-auto max-w-xl space-y-9 px-5 pt-5">
        @volt('create.site')
            <div>
                <h1 class="text-lg font-medium text-gray-800">
                    Crear Sitio Web
                </h1>
                <div class="mt-1.5 text-sm text-gray-500">
                    Agrega un nuevo sitio web a tu cuenta
                </div>
                <form wire:submit="createSite" class="mt-3">
                    <div>
                        <x-text-input wire:model="domain" id="domain" class="block mt-1 w-full" type="text" name="domain" placeholder="p. ej. https://radiocubito.com" />
                        <x-input-error :messages="$errors->get('domain')" class="mt-3" />
                    </div>

                    <div class="mt-4">
                        <x-primary-button>Crear</x-primary-button>
                    </div>
                </form>
            </div>
        @endvolt
    </div>
</x-layouts.app>

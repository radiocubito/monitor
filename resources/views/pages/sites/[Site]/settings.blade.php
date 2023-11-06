<?php

use App\Enums\EndpointFrequency;
use App\Models\Endpoint;
use App\Models\Site;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\View\View;
use Spatie\ValidationRules\Rules\Delimited;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Livewire\Volt\state;

middleware(['auth', 'verified', 'can:update,site']);

name('sites.settings');

state([
    'site' => fn () => $site,
    'emails' => fn () => $this->site->notification_emails,
    'password' => ''
]);

$updateEmails = function (Site $site) {
    $validated = $this->validate([
        'emails' => [new Delimited('email')],
    ]);

    $this->authorize('update', $this->site);

    $site->update([
        'notification_emails' => $this->emails,
    ]);

    $this->dispatch('toast', message: 'Emails guardados', data: [ 'position' => 'bottom-right', 'type' => 'success' ]);
};

$deleteSite = function (Site $site) {
    $this->validate([
        'password' => ['required', 'string', Rule::in([$this->site->domain])],
    ]);

    $this->authorize('delete', $this->site);

    $this->site->delete();

    session()->flash('flash.toast', 'Sitio eliminado');
    session()->flash('flash.toastType', 'success');

    $this->redirect(route('dashboard'), navigate: true);
};

$deleteEndpoint = function (Endpoint $endpoint) {
    $this->authorize('delete', $endpoint);

    $endpoint->delete();

    session()->flash('flash.toast', 'Endpoint eliminado');
    session()->flash('flash.toastType', 'success');

    $this->redirect(route('sites.settings', ['site' => $this->site->id]), navigate: true);
};

?>

<x-layouts.site :site="$site">
    <x-slot name="title">
        <div class="flex items-center">
            <span class="text-gray-800 w-full text-lg font-medium lowercase">
                Configuración
            </span>
        </div>
    </x-slot>

    <div class="mx-auto max-w-xl space-y-9 px-5 pt-5">
        @volt('sites.settings')
            <div class="space-y-9">
                <section>
                    <header>
                        <h1 class="text-lg font-medium text-gray-800">
                            Emails para notificaciones
                        </h1>
                        <div class="mt-1 text-sm text-gray-500">
                            Agrega una lista de emails que recibirán notificaciones. Cada email debe estar separado por una coma.
                        </div>
                    </header>
                    <form wire:submit="updateEmails({{ $site->id }})" class="mt-6 space-y-6">
                        <div>
                            <x-text-input wire:model="emails" id="emails" class="block mt-1 w-full" type="text" name="emails" placeholder="p. ej. oliver@radiocubito.com, oliver@google.com" />
                            <x-input-error :messages="$errors->get('emails')" class="mt-3" />
                        </div>
                        <div>
                            <x-primary-button>Guardar</x-primary-button>
                        </div>
                    </form>
                </section>

                @if ($site->endpoints()->count() > 0)
                    <section class="space-y-6">
                        <header>
                            <h2 class="text-lg font-medium text-gray-800">
                                Endpoints del sitio
                            </h2>
                        </header>
                        <div class="rounded-md border flex flex-col divide-y-[0.5px]">
                            @foreach($site->endpoints as $endpoint)
                                <div class="p-4 flex gap-4">
                                    <div class="text-gray-600 text-sm font-medium truncate flex-1">
                                        {{ $endpoint->location }}
                                    </div>
                                    <div class="flex items-center space-x-3.5">
                                        <a href="{{ route('endpoint.edit', ['endpoint' => $endpoint->id]) }}" class="text-gray-400 hover:text-indigo-500 transition">
                                            <svg class="h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M3.49951 3.5L7.49997 7.50046M13.999 19L18.999 14V10.3695C18.999 8.46035 18.999 7.50578 18.6533 6.72913C18.3485 6.04444 17.8574 5.45915 17.2361 5.03999C16.5314 4.56453 15.5913 4.39864 13.7112 4.06686L6.50089 2.79445C4.98642 2.52719 4.22919 2.39356 3.68376 2.62504C3.20654 2.82758 2.8266 3.20751 2.62407 3.68474C2.39258 4.23017 2.52621 4.9874 2.79347 6.50187L4.06589 13.7122C4.39767 15.5923 4.56355 16.5323 5.03901 17.2371C5.45818 17.8584 6.04346 18.3494 6.72815 18.6542C7.50481 19 8.45937 19 10.3685 19H13.999ZM13 11C13 12.1046 12.1046 13 11 13C9.89543 13 9 12.1046 9 11C9 9.89543 9.89543 9 11 9C12.1046 9 13 9.89543 13 11ZM12.999 20L19.499 13.5C20.0513 12.9477 20.9467 12.9477 21.499 13.5V13.5C22.0513 14.0523 22.0513 14.9477 21.499 15.5L14.999 22C14.4467 22.5523 13.5513 22.5523 12.999 22V22C12.4467 21.4477 12.4467 20.5523 12.999 20Z"/>
                                            </svg>
                                        </a>
                                        <button wire:click="deleteEndpoint({{ $endpoint->id }})" class="text-gray-400 hover:text-indigo-500 transition">
                                            <svg class="h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5l.64 10.97c.12 2.12.18 3.18.63 3.98 .39.7 1 1.27 1.73 1.63 .82.4 1.89.4 4.01.4h1.93c2.12 0 3.18 0 4.01-.41 .73-.36 1.33-.93 1.73-1.64 .45-.81.51-1.87.63-3.99l.64-10.98m-16 0h-2m2 0h16m0 0h2m-6 0l-.46-1.36c-.2-.6-.3-.89-.48-1.11 -.17-.2-.37-.35-.61-.44 -.27-.11-.58-.11-1.2-.11h-2.55c-.63 0-.94 0-1.2.1 -.24.09-.45.24-.61.43 -.19.21-.29.51-.48 1.1L7.9 4.92m2 5v7m4-7v4"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                <section class="space-y-6">
                    <header>
                        <h2 class="text-lg font-medium text-gray-800">
                            Zona peligrosa
                        </h2>
                    </header>
                    <x-danger-button
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-site-deletion')"
                    >Eliminar sitio</x-danger-button>
                    <x-modal name="confirm-site-deletion" :show="$errors->isNotEmpty()" focusable>
                        <form wire:submit="deleteSite" class="p-6">
                            <h2 class="text-lg font-medium text-gray-900">
                                Eliminar Sitio
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Para confirmar, introduce lo siguiente <span class="font-mono text-red-500">{{ $site->domain }}</span>.
                            </p>
                            <div class="mt-6">
                                <x-input-label for="password" value="Contraseña" class="sr-only" />
                                <x-text-input
                                    wire:model="password"
                                    id="confirm-password"
                                    name="password"
                                    type="text"
                                    class="mt-1 block w-3/4"
                                />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div class="mt-6 flex justify-end">
                                <x-secondary-button x-on:click="$dispatch('close')">
                                    Cancelar
                                </x-secondary-button>
                                <x-danger-button class="ml-3">
                                    Eliminar cuenta
                                </x-danger-button>
                            </div>
                        </form>
                    </x-modal>
                </section>
            </div>
        @endvolt
    </div>
</x-layouts.site>

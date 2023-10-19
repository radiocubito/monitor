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
                                Endpoints
                            </h2>
                        </header>
                        <div class="rounded-xl border flex flex-col divide-y-[0.5px]">
                            @foreach($site->endpoints as $endpoint)
                                <div class="p-4 flex gap-4">
                                    <div class="text-gray-600 text-sm font-medium truncate flex-1">
                                        {{ $endpoint->location }}
                                    </div>
                                    <div class="flex items-center space-x-3.5">
                                        <a href="{{ route('endpoint.edit', ['endpoint' => $endpoint->id]) }}" class="text-gray-400 hover:text-indigo-500 transition">
                                            <svg class="h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.16 8v0c1.7 0 2.56 0 3.24.25 1.07.4 1.92 1.25 2.33 2.33 .25.68.25 1.53.25 3.24v1.76c0 2.24 0 3.36-.44 4.21 -.39.75-1 1.36-1.75 1.74 -.86.43-1.98.43-4.22.43H13.8c-1.71 0-2.57 0-3.25-.26 -1.08-.41-1.93-1.26-2.34-2.34 -.26-.69-.26-1.54-.26-3.25v0m.4-.17h1.2c2.24 0 3.36 0 4.21-.44 .75-.39 1.36-1 1.74-1.75 .43-.86.43-1.98.43-4.22v-1.2c0-2.25 0-3.37-.44-4.22 -.39-.76-1-1.37-1.75-1.75 -.86-.44-1.98-.44-4.22-.44h-1.2c-2.25 0-3.37 0-4.22.43 -.76.38-1.37.99-1.75 1.74 -.44.85-.44 1.97-.44 4.21v1.2c0 2.24 0 3.36.43 4.21 .38.75.99 1.36 1.74 1.74 .85.43 1.97.43 4.21.43Z"></path>
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

<?php

use App\Enums\EndpointFrequency;
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

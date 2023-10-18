<?php

use App\Enums\EndpointFrequency;
use App\Models\Site;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
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
        @volt('emails')
            <div>
                <h1 class="text-lg font-medium text-gray-800">
                    Emails para notificaciones
                </h1>
                <div class="mt-1.5 text-sm text-gray-500">
                    Agrega una lista de emails que recibirán notificaciones. Cada email debe estar separado por una coma.
                </div>
                <form wire:submit="updateEmails({{ $site->id }})" class="mt-3">
                    <div>
                        <x-text-input wire:model="emails" id="emails" class="block mt-1 w-full" type="text" name="emails" placeholder="p. ej. oliver@radiocubito.com, oliver@google.com" />
                        <x-input-error :messages="$errors->get('emails')" class="mt-3" />
                    </div>

                    <div class="mt-4">
                        <x-primary-button>Guardar</x-primary-button>
                    </div>
                </form>
            </div>
        @endvolt
    </div>
</x-layouts.site>

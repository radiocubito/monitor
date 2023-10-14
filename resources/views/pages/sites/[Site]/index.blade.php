<?php

use App\Models\Endpoint;
use App\Models\Site;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Spatie\ValidationRules\Rules\Delimited;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Livewire\Volt\state;

middleware(['auth', 'verified']);

name('sites.show');

$getEndpoints = function ($site) {
    return $this->endpoints = $site->endpoints;
};

state([
    'site' => fn () => $site,
    'endpoints' => $getEndpoints,
    'emails' => fn () => $this->site->notification_emails,
]);

$delete = function (Endpoint $endpoint) {
    $this->authorize('delete', $endpoint);

    $endpoint->delete();

    $this->getEndpoints($this->site);
};

$updateEmails = function (Site $site) {
    // dd('jhsdf');
    // $this->authorize('delete', $endpoint);

    $validated = $this->validate([
        'emails' => [new Delimited('email')],
    ]);

    $site->update([
        'notification_emails' => $this->emails,
    ]);
};

?>

<x-layouts.proto>
    <div class="p-6 space-y-5">
        <div>
            <h1 class="font-medium text-lg">{{ $site->domain }}</h1>
            <a href="/sites/{{ $site->id }}/endpoints/create" class="underline">Crear endpoint</a>
        </div>

        @volt('endpoint-list')
            <table class="border-collapse table-auto w-full">
                <thead>
                    <tr>
                        <th class="text-left">Ubicación</th>
                        <th class="text-left">Frecuencia</th>
                        <th class="text-left">Revisado por última vez</th>
                        <th class="text-left">Último estado</th>
                        <th class="text-left">Uptime</th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($endpoints as $endpoint)
                        <tr wire:key="{{ $endpoint->id }}">
                            <td>
                                <a href="{{ route('endpoints.show', ['endpoint' => $endpoint]) }}">{{ $endpoint->location }}</a>
                            </td>
                            <td>{{ $endpoint->frequency_label }}</td>
                            <td>
                                @if($endpoint->check)
                                    {{ $endpoint->check->created_at->toDateTimeString() }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($endpoint->check)
                                    <span @class([
                                        'text-green-600' => $endpoint->check->isSuccessful(),
                                        'text-red-600' => ! $endpoint->check->isSuccessful(),
                                    ])>
                                        {{ $endpoint->check->response_code }} {{ $endpoint->check->statusText() }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($endpoint->uptimePercentage() !== null)
                                    {{ $endpoint->uptimePercentage() }}%
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('endpoint.edit', ['endpoint' => $endpoint]) }}">Editar</a>
                            </td>
                            <td>
                                <button type="button" wire:click="delete({{ $endpoint->id }})">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endvolt

        @volt('emails')
            <form wire:submit="updateEmails({{ $site->id }})" class="space-y-2 mt-5">
                <h2>Emails para notificaciones:</h2>
                <input wire:model="emails" name="emails" type="text" class="block">
                @error('emails')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
                <button class="border px-3 py-1 border-gray-500">Guardar</button>
            </form>
        @endvolt
    </div>
</x-layouts>

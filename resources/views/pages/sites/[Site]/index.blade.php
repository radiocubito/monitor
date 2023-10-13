<?php

use App\Models\Endpoint;
use Illuminate\Http\Response;
use Illuminate\View\View;

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
]);

$delete = function (Endpoint $endpoint) {
    $this->authorize('delete', $endpoint);

    $endpoint->delete();

    $this->getEndpoints($this->site);
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
                            <td>{{ $endpoint->location }}</td>
                            <td>{{ $endpoint->frequency_label }}</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
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
    </div>
</x-layouts>

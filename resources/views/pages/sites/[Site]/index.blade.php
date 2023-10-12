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
            <div class="space-y-1">
                @foreach($endpoints as $endpoint)
                    <div class="block" wire:key="{{ $endpoint->id }}">
                        {{ $endpoint->location }}, {{ $endpoint->frequency_label }},
                        <button type="button" wire:click="delete({{ $endpoint->id }})">
                            eliminar
                        </button>
                    </div>
                @endforeach
            </div>
        @endvolt
    </div>
</x-layouts>

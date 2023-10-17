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

?>

<x-layouts.site :site="$site" class="bg-gray-50">
    <x-slot name="title">
        <div class="flex items-center">
            <span class="text-gray-800 w-full text-lg font-medium lowercase">
                Endpoints
            </span>
        </div>
    </x-slot>

    <div class="p-6 space-y-5">
        @volt('endpoint-list')
            <div>
                @if($endpoints->count() > 0)
                    <div class="mx-auto flex w-full flex-col space-y-2.5 px-4 pt-4 lg:max-w-3xl">
                        <div class="bg-white shadow overflow-hidden sm:rounded-xl p-4">
                            <div class="grid grid-cols-5 gap-x-5">
                                <div class="truncate col-span-2">
                                    <span class="text-gray-900 truncate font-medium">Endpoint</span>
                                </div>
                                <div>
                                    <span class="text-gray-800 text-sm font-medium">Última revisión</span>
                                </div>
                                <div>
                                    <span class="text-gray-800 text-sm font-medium">Último estado</span>
                                </div>
                                <div>
                                    <span class="text-gray-800 text-sm font-medium">Disponibilidad</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white shadow overflow-hidden sm:rounded-xl divide-y-[0.5px]">
                            @foreach($endpoints as $endpoint)
                                <x-link to="{{ route('endpoints.show', ['endpoint' => $endpoint]) }}" class="grid grid-cols-5 gap-x-5 p-4 hover:bg-gray-50" wire:key="{{ $endpoint->id }}">
                                    <div class="col-span-2 ">
                                        <div class="text-gray-800 text-sm font-medium truncate">{{ $endpoint->location }}</div>
                                        <div class="text-gray-600 text-sm">{{ $endpoint->frequency_label }}</div>
                                    </div>
                                    <div class="text-gray-600 text-sm flex items-center">
                                        @if($endpoint->check)
                                            {{ $endpoint->check->created_at->toDateTimeString() }}
                                        @else
                                            -
                                        @endif
                                    </div>
                                    <div class="text-gray-600 text-sm flex items-center">
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
                                    </div>
                                    <div class="text-gray-600 text-sm flex items-center">
                                        @if ($endpoint->uptimePercentage() !== null)
                                            {{ $endpoint->uptimePercentage() }}%
                                        @else
                                            -
                                        @endif
                                    </div>
                                </x-link>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endvolt
    </div>
</x-layouts.site>

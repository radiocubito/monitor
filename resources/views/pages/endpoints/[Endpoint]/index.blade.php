<?php

use App\Models\Endpoint;
use Illuminate\View\View;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Laravel\Folio\render;
use function Livewire\Volt\state;

middleware(['auth', 'verified', 'can:view,endpoint']);

name('endpoints.show');

$getChecks = function ($endpoint) {
    return $this->checks = $endpoint->checks()->latest()->limit(100)->get();
};

state([
    'endpoint' => fn () => $endpoint,
    'checks' => $getChecks,
]);

?>

<x-layouts.site :site="$endpoint->site" class="bg-gray-50">
    <x-slot name="title">
        <div class="flex items-center">
            <span class="text-gray-800 w-full text-lg font-medium lowercase">
                {{ $endpoint->location }}
            </span>
        </div>
    </x-slot>

    @volt('check-list')
        <div>
            @if ($checks->count() > 0)
                <div class="space-y-5">
                    <div class="mx-auto flex w-full flex-col space-y-2.5 px-4 pt-4 lg:max-w-3xl">
                        <div class="bg-white shadow overflow-hidden rounded-xl p-4">
                            <div class="grid grid-cols-3 gap-x-3">
                                <div class="col-span-2">
                                    <span class="text-gray-800 text-sm font-medium">Revisado en</span>
                                </div>
                                <div>
                                    <span class="text-gray-800 text-sm font-medium">Código de respuesta</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white shadow overflow-hidden rounded-xl divide-y-[0.5px]">
                            @foreach($checks as $check)
                                <div class="grid grid-cols-3 gap-x-5 p-4" wire:key="{{ $endpoint->id }}">
                                    <div class="col-span-2">
                                        <div class="text-gray-800 text-sm font-medium truncate">{{ $check->created_at->toDateTimeString() }}</div>
                                    </div>
                                    <div class="text-gray-600 text-sm">
                                        <span @class([
                                            'text-green-600' => $check->isSuccessful(),
                                            'text-red-600' => ! $check->isSuccessful(),
                                        ])>
                                            {{ $check->response_code }} {{ $check->statusText() }}
                                        </span>
                                    </div>
                                    @if ($check->response_body)
                                        <textarea rows="10" class="hidden">{{ $check->response_body }}</textarea>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endvolt
</x-layouts.site>

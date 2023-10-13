<?php

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Livewire\Volt\state;

middleware(['auth', 'verified']);

name('endpoints.show');

$getChecks = function ($endpoint) {
    return $this->checks = $endpoint->checks;
};

state([
    'endpoint' => fn () => $endpoint,
    'checks' => $getChecks,
]);

?>

<x-layouts.proto>
    <div class="p-6 space-y-5">
        <div>
            <h1 class="font-medium text-lg">{{ $endpoint->url() }}</h1>
        </div>

        @volt('check-list')
            <table class="border-collapse table-auto w-full">
                <thead>
                    <tr>
                        <th class="text-left">Revisado en</th>
                        <th class="text-left">Código de respuesta</th>
                        <th class="text-left">Cuerpo de respuesta</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($checks as $check)
                        <tr wire:key="{{ $check->id }}">
                            <td>
                                {{ $check->created_at->toDateTimeString() }}
                            </td>
                            <td>
                                <span @class([
                                    'text-green-600' => $endpoint->check->isSuccessful(),
                                    'text-red-600' => ! $endpoint->check->isSuccessful(),
                                ])>
                                    {{ $check->response_code }} {{ $check->statusText() }}
                                </span>
                            </td>
                            <td>
                                @if ($check->response_body)
                                    <pre>{{ $check->response_body }}</pre>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endvolt
    </div>
</x-layouts>

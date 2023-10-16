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

<x-layouts.app>
    <x-slot name="title">
        <div class="flex items-center">
            <span class="text-gray-800 w-full text-lg font-medium lowercase">
                Endpoints
            </span>
        </div>
    </x-slot>

    <x-slot name="secondaryColumn">
        <div class="h-16 flex items-center justify-between">
            <span class="text-gray-800 w-full text-lg font-medium lowercase">
                {{ $site->domain }}
            </span>
            <a href="#" class="flex h-[22px] items-center text-gray-600 hover:text-indigo-500">
                <svg class="h-full" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <g stroke-linecap="round" stroke-width="2" stroke="currentColor" fill="none" stroke-linejoin="round"><path d="M12 4c-.7 0-1.39-.27-1.82-.82l-.46-.59C9.1 1.79 8 1.58 7.13 2.08l-1.31.75c-.87.5-1.23 1.56-.86 2.48l.27.68c.26.64.14 1.37-.21 1.97v0c-.35.6-.93 1.07-1.62 1.16l-.74.09c-1 .13-1.73.98-1.73 1.98v1.5c0 1 .73 1.84 1.72 1.98l.73.09c.69.09 1.26.56 1.61 1.16v0c.34.6.46 1.32.2 1.97l-.28.68c-.38.92-.02 1.98.85 2.48l1.3.75c.86.5 1.96.28 2.58-.51l.45-.59c.42-.56 1.11-.82 1.81-.82v0 0c.69 0 1.38.26 1.81.81l.45.58c.61.79 1.71 1 2.58.5l1.3-.76c.86-.51 1.22-1.57.85-2.49l-.28-.69c-.27-.65-.15-1.38.2-1.98v0c.34-.61.92-1.08 1.61-1.17l.73-.1c.99-.14 1.72-.99 1.72-1.99v-1.51c0-1.01-.74-1.85-1.73-1.99l-.74-.1c-.7-.1-1.27-.57-1.62-1.17v0c-.35-.61-.47-1.33-.21-1.98l.27-.69c.37-.93.01-1.99-.86-2.49l-1.31-.76c-.87-.51-1.97-.29-2.59.5l-.46.58c-.43.55-1.12.81-1.82.81v0 0Z"></path><path d="M15 12c0 1.65-1.35 3-3 3 -1.66 0-3-1.35-3-3 0-1.66 1.34-3 3-3 1.65 0 3 1.34 3 3Z"></path></g>
                </svg>
            </a>
        </div>
        <ul role="list" class="flex flex-1 flex-col gap-y-4">
            <li>
                <ul role="list" class="-mx-2 space-y-1">
                    <li>
                        <a href="#" class="bg-gray-50 text-indigo-500 flex items-center gap-x-2.5 rounded-xl px-2.5 py-2.5" x-state:on="Current" x-state:off="Default" x-state-description="Current: &quot;bg-gray-50 text-indigo-600&quot;, Default: &quot;text-gray-700 hover:text-indigo-600 hover:bg-gray-50&quot;">
                            <svg class="h-[1.25rem] w-[1.25rem]" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.5 3h.5v0c1.77 0 3.32 1.18 3.78 2.89l1.24 4.56c.14.51.21.77.26 1.02 .37 1.65.39 3.37.05 5.04 -.06.25-.12.51-.25 1.03v0c-.16.61-.24.92-.34 1.19 -.66 1.75-2.25 3-4.12 3.21 -.29.03-.61.03-1.24.03H8.52c-.64 0-.96 0-1.24-.04 -1.87-.22-3.46-1.46-4.12-3.22 -.1-.27-.18-.58-.34-1.2v0c-.13-.52-.2-.78-.25-1.04 -.34-1.67-.33-3.39.05-5.05 .05-.26.12-.52.26-1.03l1.24-4.57c.46-1.71 2.01-2.9 3.78-2.9v0h.5m-6 11h2.78c.62 0 .93 0 1.22.08 .25.07.48.2.68.36 .22.18.4.44.75.97l.1.15c.34.52.52.78.75.97 .2.16.43.29.68.36 .28.08.59.08 1.22.08h2.57c.62 0 .93 0 1.22-.09 .25-.08.48-.21.68-.37 .22-.19.4-.45.75-.98l.1-.15c.34-.53.52-.79.75-.98 .2-.17.43-.3.68-.37 .28-.09.59-.09 1.22-.09h2.78m-9.5-3l3-3m-3 3l-3-3m2.99 3v-9"></path>
                            </svg>
                            <span class="align-middle font-mono text-sm">endpoints</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-600 hover:text-indigo-500 flex items-center gap-x-2.5 rounded-xl px-2.5 py-2.5" x-state:on="Current" x-state:off="Default" x-state-description="Current: &quot;bg-gray-50 text-indigo-600&quot;, Default: &quot;text-gray-700 hover:text-indigo-600 hover:bg-gray-50&quot;">
                            <svg class="h-[1.25rem] w-[1.25rem]" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.36 2H4.62c-.91 0-1.64.73-1.64 1.63 0 2.11 1.01 4.09 2.73 5.32l1.92 1.37h0c.64.45.96.68 1.22.95 .53.55.89 1.26 1.04 2.02 .06.36.06.76.06 1.55v5.13c0 1.1.89 2 2 2 1.1 0 2-.9 2-2v-5.14c0-.79 0-1.19.06-1.56 .14-.77.5-1.47 1.04-2.03 .25-.28.58-.5 1.22-.96l1.92-1.38c1.71-1.23 2.73-3.21 2.73-5.33 0-.91-.74-1.64-1.64-1.64Z"></path>
                            </svg>
                            <span class="align-middle font-mono text-sm">charts</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <div class="text-gray-700 flex items-center justify-between">
                    <div class="text-base font-medium">
                        endpoints
                    </div>
                    <a href="/sites/{{ $site->id }}/endpoints/create" class="flex items-center hover:text-indigo-500">
                        <svg class="h-[22px] w-[22px] p-px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h7m7 0h-7m0 0V5m0 7v7"></path>
                        </svg>
                    </a>
                </div>
                @volt('sidebar-endpoint-list')
                    <ul role="list" class="-mx-2 space-y-1 mt-2">
                        @foreach($endpoints as $endpoint)
                            <li wire:key="{{ $endpoint->id }}">
                                <a href="{{ route('endpoints.show', ['endpoint' => $endpoint]) }}" class="text-gray-600 flex items-center gap-x-2.5 rounded-xl px-2.5 py-2.5" x-state:on="Current" x-state:off="Default" x-state-description="Current: &quot;bg-gray-50 text-indigo-600&quot;, Default: &quot;text-gray-700 hover:text-indigo-600 hover:bg-gray-50&quot;">
                                    <svg class="h-[1.25rem] w-[1.25rem] text-gray-600" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 3L8 21m8-18l-.67 6m-.34 3l-1 9M9.49 8.99h11.5m-18 0h3m-4 5.99h18"></path>
                                    </svg>
                                    <span class="align-middle font-mono text-sm">
                                        {{ $endpoint->location }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endvolt
            </li>
        </ul>
    </x-slot>

    <div class="p-6 space-y-5 bg-gray-50 h-full">
        @volt('endpoint-list')
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

                <div class="bg-white shadow overflow-hidden sm:rounded-xl">
                    @foreach($endpoints as $endpoint)
                        <a href="{{ route('endpoints.show', ['endpoint' => $endpoint]) }}" class="grid grid-cols-5 gap-x-5 p-4" wire:key="{{ $endpoint->id }}">
                            <div class="col-span-2 ">
                                <div class="text-gray-800 text-sm font-medium truncate">{{ $endpoint->location }}</div>
                                <div class="text-gray-600 text-sm">{{ $endpoint->frequency_label }}</div>
                            </div>
                            <div class="text-gray-600 text-sm">
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
                        </a>
                    @endforeach
                </div>
            </div>
        @endvolt

        @volt('emails')
            <form wire:submit="updateEmails({{ $site->id }})" class="space-y-2 mt-5 hidden">
                <h2>Emails para notificaciones:</h2>
                <input wire:model="emails" name="emails" type="text" class="block">
                @error('emails')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
                <button class="border px-3 py-1 border-gray-500">Guardar</button>
            </form>
        @endvolt
    </div>
</x-layouts.app>

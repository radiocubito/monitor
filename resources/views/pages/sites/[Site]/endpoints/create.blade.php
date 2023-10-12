<?php

use App\Enums\EndpointFrecuency;
use Illuminate\Http\Response;
use Illuminate\View\View;

use function Laravel\Folio\middleware;
use function Laravel\Folio\render;
use function Livewire\Volt\with;

middleware(['auth', 'verified']);

with(fn () => ['endpointFrecuencies' => EndpointFrecuency::cases()]);

?>

<x-layouts.proto>
    <div class="p-6">
        <h1 class="text-xl font-medium">Crear endpoint</h1>

        @volt('create.endpoint')
            <form wire:submit="createEndpoint" class="space-y-2 mt-5">
                <input wire:model="location" name="location" type="text" class="block" placeholder="/precios">
                @error('location')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
                <select name="frecuency" class="block">
                    @foreach($endpointFrecuencies as $endpointFrecuency)
                        <option value="{{ $endpointFrecuency->value }}">{{ $endpointFrecuency->label() }}</option>
                    @endforeach
                </select>
                @error('location')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
                <button class="border px-3 py-1 border-gray-500">Crear</button>
            </form>
        @endvolt
    </div>
</x-layouts.proto>

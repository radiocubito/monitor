<?php

use Illuminate\Http\Response;
use Illuminate\View\View;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Laravel\Folio\render;

middleware(['auth', 'verified']);

name('sites.show');

?>

<x-layouts.proto>
    <div class="p-6 space-y-5">
        <div>
            <h1 class="font-medium text-lg">{{ $site->domain }}</h1>
            <a href="/sites/{{ $site->id }}/endpoints/create" class="underline">Crear endpoint</a>
        </div>

        <div class="space-y-1">
            @foreach($site->endpoints as $endpoint)
                <span class="block">
                    {{ $endpoint->location }}, {{ $endpoint->frequency }}
                </span>
            @endforeach
        </div>
    </div>
</x-layouts>

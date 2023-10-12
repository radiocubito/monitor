<?php

use App\Models\Site;
use Illuminate\Http\Response;
use Illuminate\View\View;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Laravel\Folio\render;

middleware(['auth', 'verified']);

name('dashboard');

render(function(Response $response, View $view) {
    $view->with([
        'site' => Site::find(1),
        'sites' => Site::all(),
    ]);
});

?>

<x-layouts.proto>
    <div class="p-6 space-y-6">
        <div>
            <a href="/sites/create" class="underline">Crear sitio</a>
        </div>
        <div class="space-y-1">
            @foreach($sites as $site)
                <a href="/sites/{{ $site->id }}" class="block underline">
                    {{ $site->domain }}
                </a>
            @endforeach
        </div>
        <div>
            {{ $site->domain }}
        </div>
    </div>
</x-layouts.proto>

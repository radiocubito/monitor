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
    <div class="p-6">
        <div>
            <select name="site">
                @foreach($sites as $site)
                    <option value="{{ $site->id }}">
                        {{ $site->domain }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <a href="/sites/create" class="underline">Crear sitio</a>
        </div>
        <div>
            {{ $site->domain }}
        </div>
    </div>
</x-layouts.proto>

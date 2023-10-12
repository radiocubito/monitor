<?php

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

middleware(['auth', 'verified']);

name('sites.show');

?>

<x-layouts.proto>
    <div class="p-6">
        <h1 class="font-medium text-lg">{{ $site->domain }}</h1>
        <a href="/sites/{{ $site->id }}/endpoints/create" class="underline">Crear endpoint</a>
    </div>
</x-layouts>

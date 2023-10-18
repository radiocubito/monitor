<?php

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

middleware(['auth']);

name('profile');

?>

<x-layouts.settings>
    <x-slot name="title">
        <div class="flex items-center">
            <span class="text-gray-800 w-full text-lg font-medium lowercase">
                Perfil
            </span>
        </div>
    </x-slot>

    <div class="space-y-5">
        <div class="mx-auto max-w-xl space-y-9 px-5 pt-5">
            <div class="max-w-xl">
                <livewire:profile.update-profile-information-form />
            </div>

            <div class="max-w-xl">
                <livewire:profile.update-password-form />
            </div>

            <div class="max-w-xl">
                <livewire:profile.delete-user-form />
            </div>
        </div>
    </div>
</x-layouts.settings>

<?php

$logout = function () {
    auth()->guard('web')->logout();

    session()->invalidate();
    session()->regenerateToken();

    $this->redirect('/', navigate: true);
};

?>


<x-layouts.app>
    <x-slot name="title">
        <div class="flex items-center">
            <span class="text-gray-800 w-full text-lg font-medium lowercase">
                {{ __('Profile') }}
            </span>
        </div>
    </x-slot>

    <x-slot name="secondaryColumn">
        <div class="h-16 flex items-center justify-between">
            <span class="text-gray-800 w-full text-lg font-medium lowercase">
                Configuración
            </span>
        </div>
        <ul role="list" class="flex flex-1 flex-col gap-y-4">
            <li>
                <ul role="list" class="-mx-2 space-y-1">
                    <li>
                        <a href="#" class="bg-gray-50 text-indigo-500 flex items-center gap-x-2.5 rounded-xl px-2.5 py-2.5" x-state:on="Current" x-state:off="Default" x-state-description="Current: &quot;bg-gray-50 text-indigo-600&quot;, Default: &quot;text-gray-700 hover:text-indigo-600 hover:bg-gray-50&quot;">
                            <span class="align-middle font-mono text-sm">perfil</span>
                        </a>
                    </li>
                    @volt('logout')
                        <li>
                            <button wire:click="logout" class="text-gray-600 hover:text-indigo-500 flex items-center gap-x-2.5 rounded-xl px-2.5 py-2.5" x-state:on="Current" x-state:off="Default" x-state-description="Current: &quot;bg-gray-50 text-indigo-600&quot;, Default: &quot;text-gray-700 hover:text-indigo-600 hover:bg-gray-50&quot;">
                                <span class="align-middle font-mono text-sm">cerrar sesión</span>
                            </button>
                        </li>
                    @endvolt
                </ul>
            </li>
        </ul>
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
</x-layouts.app>

@props(['site'])

<x-layouts.app {{ $attributes->merge(['class']) }}>
    <x-slot name="title">
        {{ $title }}
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
                        <x-nav-link href="{{ route('profile') }}" class="flex" :active="request()->routeIs('profile')">
                            <span>perfil</span>
                        </x-nav-link>
                    </li>
                    <li>
                        <livewire:logout-button />
                    </li>
                </ul>
            </li>
        </ul>
    </x-slot>

    <x-slot name="responsiveSecondaryColumn">
        <div class="h-16 flex items-center justify-between">
            <span class="text-gray-800 w-full text-lg font-medium lowercase">
                Configuración
            </span>
        </div>
        <ul role="list" class="flex flex-1 flex-col gap-y-4">
            <li>
                <ul role="list" class="-mx-2 space-y-1">
                    <li>
                        <x-nav-link href="{{ route('profile') }}" class="flex" :active="request()->routeIs('profile')">
                            <span>perfil</span>
                        </x-nav-link>
                    </li>
                    <li>
                        <livewire:logout-button />
                    </li>
                </ul>
            </li>
        </ul>
    </x-slot>

    {{ $slot }}
</x-layouts.app>

@props(['site'])

<x-layouts.app>
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <x-slot name="secondaryColumn">
        <div class="h-16 flex items-center justify-between">
            <span class="text-gray-800 w-full text-lg font-medium lowercase">
                {{ $site->domain }}
            </span>
            <a
                href="/sites/{{ $site->id }}/settings"
                @class([
                    'flex h-[22px] items-center hover:text-indigo-500',
                    'text-gray-600' => ! request()->routeIs('sites.settings'),
                    'text-indigo-500' => request()->routeIs('sites.settings'),
                ])
            >
                <svg class="h-full" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <g stroke-linecap="round" stroke-width="2" stroke="currentColor" fill="none" stroke-linejoin="round"><path d="M12 4c-.7 0-1.39-.27-1.82-.82l-.46-.59C9.1 1.79 8 1.58 7.13 2.08l-1.31.75c-.87.5-1.23 1.56-.86 2.48l.27.68c.26.64.14 1.37-.21 1.97v0c-.35.6-.93 1.07-1.62 1.16l-.74.09c-1 .13-1.73.98-1.73 1.98v1.5c0 1 .73 1.84 1.72 1.98l.73.09c.69.09 1.26.56 1.61 1.16v0c.34.6.46 1.32.2 1.97l-.28.68c-.38.92-.02 1.98.85 2.48l1.3.75c.86.5 1.96.28 2.58-.51l.45-.59c.42-.56 1.11-.82 1.81-.82v0 0c.69 0 1.38.26 1.81.81l.45.58c.61.79 1.71 1 2.58.5l1.3-.76c.86-.51 1.22-1.57.85-2.49l-.28-.69c-.27-.65-.15-1.38.2-1.98v0c.34-.61.92-1.08 1.61-1.17l.73-.1c.99-.14 1.72-.99 1.72-1.99v-1.51c0-1.01-.74-1.85-1.73-1.99l-.74-.1c-.7-.1-1.27-.57-1.62-1.17v0c-.35-.61-.47-1.33-.21-1.98l.27-.69c.37-.93.01-1.99-.86-2.49l-1.31-.76c-.87-.51-1.97-.29-2.59.5l-.46.58c-.43.55-1.12.81-1.82.81v0 0Z"></path><path d="M15 12c0 1.65-1.35 3-3 3 -1.66 0-3-1.35-3-3 0-1.66 1.34-3 3-3 1.65 0 3 1.34 3 3Z"></path></g>
                </svg>
            </a>
        </div>
        <ul role="list" class="flex flex-1 flex-col gap-y-4">
            <li>
                <ul role="list" class="-mx-2 space-y-1">
                    <li>
                        <x-nav-link href="{{ route('sites.show', ['site' => $site->id]) }}" class="flex items-center gap-x-2.5" :active="request()->routeIs('sites.show')" wire:navigate>
                            <x-icons.endpoint class="h-[1.25rem] w-[1.25rem]" />
                            <span>endpoints</span>
                        </x-nav-link>
                    </li>
                </ul>
            </li>
            <li>
                <div class="text-gray-700 flex items-center justify-between">
                    <div class="text-base font-medium">
                        endpoints
                    </div>
                    <a href="/sites/{{ $site->id }}/create-endpoint" class="flex items-center hover:text-indigo-500">
                        <svg class="h-[22px] w-[22px] p-px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h7m7 0h-7m0 0V5m0 7v7"></path>
                        </svg>
                    </a>
                </div>
                <ul role="list" class="-mx-2 space-y-1 mt-2">
                    @foreach($site->endpoints as $endpoint)
                        <li wire:key="{{ $endpoint->id }}">
                            <x-nav-link href="{{ route('endpoints.show', ['endpoint' => $endpoint]) }}" class="flex items-center gap-x-2.5" :active="request()->is('endpoints/' . $endpoint->id)" wire:navigate>
                                <svg class="h-[1.25rem] w-[1.25rem]" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 3L8 21m8-18l-.67 6m-.34 3l-1 9M9.49 8.99h11.5m-18 0h3m-4 5.99h18"></path>
                                </svg>
                                <span>{{ $endpoint->location }}</span>
                            </x-nav-link>
                        </li>
                    @endforeach
                </ul>
            </li>
        </ul>
    </x-slot>

    {{ $slot }}
</x-layouts.app>

<nav class="flex flex-1 flex-col">
    <ul role="list" class="flex flex-1 flex-col gap-y-7">
        <li>
            <ul role="list" class="space-y-1">
                <li>
                    <x-link
                        to="{{ route('dashboard') }}"
                        @class([
                            'flex h-10 w-10 items-center justify-center rounded-full',
                            'text-indigo-500 ring-indigo-300 ring' => request()->routeIs('dashboard'),
                            'text-gray-600 hover:text-indigo-500' => ! request()->routeIs('dashboard'),
                        ])
                    >
                        <svg class="h-6 w-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 17v-5.16c0-1.42 0-2.12-.18-2.77 -.16-.58-.43-1.13-.78-1.61 -.4-.55-.95-.99-2.06-1.88l-2-1.6c-1.79-1.43-2.68-2.15-3.67-2.42 -.88-.25-1.8-.25-2.67 0 -.99.27-1.89.98-3.67 2.41l-2 1.6c-1.11.88-1.66 1.32-2.06 1.87 -.36.48-.62 1.02-.78 1.6 -.18.65-.18 1.35-.18 2.76v5.15c0 2.76 2.23 5 5 5 1.1 0 2-.9 2-2v-4.01c0-1.66 1.34-3 3-3 1.65 0 3 1.34 3 3v4c0 1.1.89 2 2 2 2.76 0 5-2.24 5-5Z"></path>
                        </svg>
                    </x-link>
                </li>
            </ul>
        </li>
        <li>
            <ul role="list" class="space-y-4">
                @foreach(auth()->user()->sites as $site)
                    <li>
                        <x-link
                            to="/sites/{{ $site->id }}"
                            @class([
                                'flex h-10 w-10 items-center justify-center rounded-full',
                                'text-indigo-500 ring-indigo-300 ring' => $currentSiteId === $site->id,
                                'text-gray-600 hover:text-indigo-500' =>  $currentSiteId !== $site->id,
                            ])
                        >
                            <span class="inline-block w-full text-center align-middle font-mono">{{ $site->shortLabel() }}</span>
                        </x-link>
                    </li>
                @endforeach
                <li>
                    <x-link to="/sites/create" class="flex h-10 w-10 items-center justify-center text-gray-600 hover:text-indigo-500 rounded-full">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h7m7 0h-7m0 0V5m0 7v7"></path>
                        </svg>
                    </x-link>
                </li>
            </ul>
        </li>
        <li class="mt-auto">
            <x-link to="/profile" class="flex h-10 w-10 items-center justify-center text-gray-600">
                <svg class="h-6 w-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <g stroke-linecap="round" stroke-width="2" stroke="currentColor" fill="none" stroke-linejoin="round"><path d="M4 18.8C4 16.149 6.14 14 8.8 14h6.4c2.65 0 4.8 2.14 4.8 4.8v0c0 1.76-1.44 3.2-3.2 3.2H7.2C5.43 22 4 20.56 4 18.8v0Z"></path><path d="M16 6c0 2.2-1.8 4-4 4 -2.21 0-4-1.8-4-4 0-2.21 1.79-4 4-4 2.2 0 4 1.79 4 4Z"></path></g>
                </svg>
            </x-link>
        </li>
    </ul>
</nav>

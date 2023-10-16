<x-layouts.html>
    <div class="bg-white h-full">
        <div class="h-full" x-data="{ open: false }" @keydown.window.escape="open = false">
            <div x-show="open" class="relative z-50 lg:hidden" x-description="Off-canvas menu for mobile, show/hide based on off-canvas menu state." x-ref="dialog" aria-modal="true">
                <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/80" x-description="Off-canvas menu backdrop, show/hide based on off-canvas menu state."></div>
                <div class="fixed inset-0 flex">
                    <div x-show="open" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" x-description="Off-canvas menu, show/hide based on off-canvas menu state." class="relative mr-16 flex w-full max-w-xs flex-1" @click.away="open = false">
                        <div x-show="open" x-transition:enter="ease-in-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-description="Close button, show/hide based on off-canvas menu state." class="absolute left-full top-0 flex w-16 justify-center pt-5">
                            <button type="button" class="-m-2.5 p-2.5" @click="open = false">
                                <span class="sr-only">Close sidebar</span>
                                <svg class="h-6 w-6 text-white" fill="none" viewbox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <!-- Sidebar component, swap this element with another sidebar if you like -->
                        <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4">
                            <nav class="flex flex-1 flex-col">
                                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                                    <li>
                                        <ul role="list" class="-mx-2 space-y-1">
                                            <li>
                                                <a href="#" class="bg-gray-50 text-indigo-600 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold" x-state:on="Current" x-state:off="Default" x-state-description="Current: &quot;bg-gray-50 text-indigo-600&quot;, Default: &quot;text-gray-700 hover:text-indigo-600 hover:bg-gray-50&quot;">
                                                    <svg class="h-6 w-6 shrink-0 text-indigo-600" fill="none" viewbox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path>
                                                    </svg>
                                                    Dashboard
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="mt-auto">
                                        <a href="#" class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50 hover:text-indigo-600">
                                            <svg class="h-6 w-6 shrink-0 text-gray-400 group-hover:text-indigo-600" fill="none" viewbox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            Settings
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Static sidebar for desktop -->
            <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:flex-row">
                <div class="flex grow flex-col lg:w-20 gap-y-5 overflow-y-auto border-r-[0.5px] border-gray-200 bg-white px-5 pb-5 pt-3">
                    <nav class="flex flex-1 flex-col">
                        <ul role="list" class="flex flex-1 flex-col gap-y-7">
                            <li>
                                <ul role="list" class="space-y-1">
                                    <li>
                                        <a
                                            href="{{ route('dashboard') }}"
                                            @class([
                                                'flex h-10 w-10 items-center justify-center rounded-full',
                                                'text-indigo-500 ring-indigo-300 ring' => request()->routeIs('dashboard'),
                                                'text-gray-600 hover:text-indigo-500' => ! request()->routeIs('dashboard'),
                                            ])
                                        >
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 17v-5.16c0-1.42 0-2.12-.18-2.77 -.16-.58-.43-1.13-.78-1.61 -.4-.55-.95-.99-2.06-1.88l-2-1.6c-1.79-1.43-2.68-2.15-3.67-2.42 -.88-.25-1.8-.25-2.67 0 -.99.27-1.89.98-3.67 2.41l-2 1.6c-1.11.88-1.66 1.32-2.06 1.87 -.36.48-.62 1.02-.78 1.6 -.18.65-.18 1.35-.18 2.76v5.15c0 2.76 2.23 5 5 5 1.1 0 2-.9 2-2v-4.01c0-1.66 1.34-3 3-3 1.65 0 3 1.34 3 3v4c0 1.1.89 2 2 2 2.76 0 5-2.24 5-5Z"></path>
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <ul role="list" class="space-y-4">
                                    @foreach(auth()->user()->sites as $site)
                                        <li>
                                            <a href="/sites/{{ $site->id }}" class="flex h-10 w-10 items-center justify-center text-gray-600 hover:text-indigo-500 rounded-full">
                                                <span class="inline-block w-full text-center align-middle font-mono">{{ $site->shortLabel() }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                    <li>
                                        <a href="/sites/create" class="flex h-10 w-10 items-center justify-center text-gray-600 hover:text-indigo-500 rounded-full" x-state:on="Current" x-state:off="Default" x-state-description="Current: &quot;bg-gray-50 text-indigo-600&quot;, Default: &quot;text-gray-700 hover:text-indigo-600 hover:bg-gray-50&quot;">
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h7m7 0h-7m0 0V5m0 7v7"></path>
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="mt-auto">
                                <a href="/profile" class="flex h-10 w-10 items-center justify-center text-gray-600">
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <g stroke-linecap="round" stroke-width="2" stroke="currentColor" fill="none" stroke-linejoin="round"><path d="M4 18.8C4 16.149 6.14 14 8.8 14h6.4c2.65 0 4.8 2.14 4.8 4.8v0c0 1.76-1.44 3.2-3.2 3.2H7.2C5.43 22 4 20.56 4 18.8v0Z"></path><path d="M16 6c0 2.2-1.8 4-4 4 -2.21 0-4-1.8-4-4 0-2.21 1.79-4 4-4 2.2 0 4 1.79 4 4Z"></path></g>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                @isset($secondaryColumn)
                    <div class="flex grow flex-col lg:w-[220px] overflow-y-auto border-r-[0.5px] border-gray-200 bg-white px-4 pb-5">
                        {{ $secondaryColumn }}
                    </div>
                @endisset
            </div>
            <div @class([
                    'h-full',
                    'lg:pl-[300px]' => isset($secondaryColumn),
                    'lg:pl-20' => ! isset($secondaryColumn),
                ])
            >
                <div class="sticky top-0 z-40 flex h-14 md:h-16 shrink-0 items-center gap-x-4 border-b-[0.5px] border-gray-200 bg-white px-4 sm:gap-x-6">
                    <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" @click="open = true">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="h-6 w-6" fill="none" viewbox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                        </svg>
                    </button>
                    <!-- Separator -->
                    <div class="h-6 w-px bg-gray-200 lg:hidden" aria-hidden="true"></div>
                    <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                        {{ $title }}
                    </div>
                </div>
                <main class="h-full">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>
    <x-toast-notification />
</x-layouts.html>

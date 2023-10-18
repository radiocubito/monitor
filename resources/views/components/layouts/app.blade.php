@props(['currentSiteId' => null])

<x-layouts.html {{ $attributes->merge(['class']) }}>
    <div x-data="{ open: false }" @keydown.window.escape="open = false">
        <div x-show="open" class="relative z-50 lg:hidden" aria-modal="true" style="display: none;">
            <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/80"></div>
            <div class="fixed inset-0 flex">
                <div
                    x-show="open"
                    @click.away="open = false"
                    @class([
                        'relative mr-16 flex w-full flex-1',
                        'max-w-xs' => isset($secondaryColumn),
                        "max-w-[5rem]" => !isset($secondaryColumn),
                    ])
                    x-transition:enter="transition ease-in-out duration-300 transform"
                    x-transition:enter-start="-translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in-out duration-300 transform"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="-translate-x-full"
                >
                    <div x-show="open" x-transition:enter="ease-in-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute left-full top-0 flex w-16 justify-center pt-5">
                        <button type="button" class="-m-2.5 p-2.5" @click="open = false">
                            <span class="sr-only">Cerrar sidebar</span>
                            <svg class="h-6 w-6 text-white" fill="none" viewbox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <!-- Sidebar component -->
                    <div class="flex flex-col gap-y-5 overflow-y-auto bg-white px-5 pb-5 pt-3">
                        <x-navigation :currentSiteId="$currentSiteId" />
                    </div>
                    @isset($secondaryColumn)
                        <div class="flex grow flex-col gap-y-5 overflow-y-auto border-l-[0.5px] border-gray-200 bg-white px-4 pb-5">
                            {{ $secondaryColumn }}
                        </div>
                    @endisset
                </div>
            </div>
        </div>
        <!-- Static sidebar for desktop -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:flex-row">
            <!-- Sidebar component -->
            <div class="flex grow flex-col lg:w-20 gap-y-5 overflow-y-auto border-r-[0.5px] border-gray-200 bg-white px-5 pb-5 pt-3">
                <x-navigation :currentSiteId="$currentSiteId" />
            </div>
            @isset($secondaryColumn)
                <div class="flex grow flex-col lg:w-[220px] overflow-y-auto border-r-[0.5px] border-gray-200 bg-white px-4 pb-5">
                    {{ $secondaryColumn }}
                </div>
            @endisset
        </div>
        <div @class([
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
            <main>
                {{ $slot }}
            </main>
        </div>
    </div>
    <x-toast />
</x-layouts.html>

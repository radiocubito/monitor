<?php

use App\Models\Site;
use Illuminate\Http\Response;
use Illuminate\View\View;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Laravel\Folio\render;
use function Livewire\Volt\state;

middleware(['auth', 'verified']);

name('dashboard');

$getSites = function () {
    return $this->sites = auth()->user()->sites;
};

state([
    'sites' => $getSites,
]);

?>

<x-layouts.app class="bg-gray-50">
    <x-slot name="title">
        <div class="flex items-center">
            <span class="text-gray-800 w-full text-lg font-medium lowercase">
                radiocúbito monitor
            </span>
        </div>
    </x-slot>

    @volt
        <div>
            @if ($sites->count() > 0)
                <div class="space-y-5">
                    <div class="mx-auto flex w-full flex-col space-y-2.5 px-4 pt-4 lg:max-w-3xl">
                        <div class="bg-white shadow overflow-hidden sm:rounded-xl p-4">
                            <div class="grid grid-cols-5 gap-x-5">
                                <div class="truncate col-span-2">
                                    <span class="text-gray-900 truncate font-medium">Todos los Sitios</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white shadow overflow-hidden sm:rounded-xl divide-y-[0.5px]">
                            @foreach($sites as $site)
                                <x-link to="{{ route('sites.show', ['site' => $site]) }}" class="grid gap-x-5 p-4 hover:bg-gray-50" wire:key="{{ $site->id }}">
                                    <div>
                                        <div class="text-gray-800 text-sm font-medium truncate">{{ $site->domain }}</div>
                                    </div>
                                </x-link>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="flex h-[calc(100vh-64px)] flex-col items-center justify-center text-center">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-gray-800 h-14">
                        <path opacity="0.12" d="M21.5148 15.9403L21.9999 14H18.7126C18.0864 14 17.7734 14 17.4892 14.0863C17.2376 14.1627 17.0036 14.288 16.8004 14.4549C16.571 14.6435 16.3974 14.904 16.05 15.425L16.05 15.425L15.95 15.575L15.95 15.575C15.6026 16.096 15.429 16.3565 15.1996 16.5451C14.9964 16.712 14.7624 16.8373 14.5108 16.9137C14.2266 17 13.9136 17 13.2874 17H10.7126C10.0864 17 9.77338 17 9.4892 16.9137C9.23762 16.8373 9.00357 16.712 8.80045 16.5451C8.57101 16.3565 8.39735 16.096 8.05003 15.575L8.05003 15.575L7.94997 15.425C7.60265 14.904 7.42899 14.6435 7.19955 14.4549C6.99643 14.288 6.76238 14.1627 6.5108 14.0863C6.22662 14 5.91355 14 5.28741 14H1.99988L2.48495 15.9403C3.02661 18.1069 3.29745 19.1903 3.90143 19.9969C4.43433 20.7086 5.14737 21.2653 5.96706 21.6097C6.89608 22 8.01275 22 10.2461 22H13.7537C15.987 22 17.1037 22 18.0327 21.6097C18.8524 21.2653 19.5654 20.7086 20.0983 19.9969C20.7023 19.1903 20.9731 18.107 21.5148 15.9403L21.5148 15.9403Z" fill="currentColor"></path>
                        <path d="M2.49994 14H5.2872C5.91334 14 6.22641 14 6.51059 14.0863C6.76217 14.1627 6.99622 14.2879 7.19934 14.4549C7.42878 14.6434 7.60244 14.9039 7.94976 15.4249L8.04981 15.575C8.39713 16.096 8.5708 16.3565 8.80024 16.545C9.00336 16.712 9.2374 16.8373 9.48898 16.9137C9.77316 17 10.0862 17 10.7124 17H13.2872C13.9133 17 14.2264 17 14.5106 16.9137C14.7622 16.8373 14.9962 16.712 15.1993 16.545C15.4288 16.3565 15.6024 16.096 15.9498 15.575L16.0498 15.4249C16.3971 14.9039 16.5708 14.6434 16.8002 14.4549C17.0034 14.2879 17.2374 14.1627 17.489 14.0863C17.7732 14 18.0862 14 18.7124 14H21.4999M3.48499 8.05958L2.86895 10.5236C2.72842 11.0857 2.65815 11.3668 2.6021 11.647C2.29151 13.2003 2.2915 14.7996 2.60208 16.3529C2.65812 16.6332 2.72838 16.9142 2.86891 17.4763V17.4763C3.0438 18.1759 3.13124 18.5256 3.24908 18.826C3.91509 20.5237 5.45256 21.7241 7.26107 21.9585C7.58105 22 7.94159 22 8.66268 22H15.3368C16.058 22 16.4186 22 16.7386 21.9585C18.5471 21.7241 20.0845 20.5237 20.7505 18.8261C20.8684 18.5257 20.9558 18.1759 21.1308 17.4762V17.4762C21.2713 16.9141 21.3416 16.633 21.3976 16.3527C21.7081 14.7996 21.7082 13.2003 21.3976 11.6472C21.3416 11.3669 21.2713 11.0858 21.1308 10.5237L20.5148 8.05976C19.9732 5.89307 19.7024 4.80973 19.0984 4.0031C18.5655 3.2914 17.8525 2.73467 17.0328 2.39028C16.1037 1.99995 14.987 1.99995 12.7537 1.99995H11.2461C9.01279 1.99995 7.89613 1.99995 6.96712 2.39026C6.14743 2.73464 5.4344 3.29135 4.9015 4.00303C4.29751 4.80963 4.02667 5.89295 3.48499 8.05958Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                    </svg>
                    <div class="mt-4 max-w-[260px] space-y-2">
                        <div class="text-base font-medium leading-6 text-gray-900 md:text-base">
                            Aún no tienes sitios
                        </div>
                        <div class="break-words text-sm font-normal leading-5 text-gray-700">
                            Mantén todo organizado con un espacio separado para cada uno de tus sitios web.
                        </div>
                        <div class="pt-4">
                            <x-link to="/sites/create" class="bg-gray-900 text-white hover:bg-gray-700 inline-flex items-center rounded-md border border-transparent px-4 py-2 text-sm font-medium focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="-ml-1 mr-2 h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Crear Sitio Web
                            </x-link>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endvolt
</x-layouts.app>

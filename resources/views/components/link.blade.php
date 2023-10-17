@props(['to'])

<a
    {{ $attributes->except('wire:navigate')->except('href') }}
    wire:navigate
    href="{{ $to ?? $attributes->get('href') }}"
>
{{ $slot }}
</a>

@props(['active'])

@php
$classes = ($active ?? false)
            ? 'bg-gray-50 text-indigo-500 align-middle font-mono text-sm rounded-xl px-2.5 py-2.5 transition duration-150 ease-in-out'
            : 'text-gray-600 hover:text-indigo-500 align-middle font-mono text-sm rounded-xl px-2.5 py-2.5 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

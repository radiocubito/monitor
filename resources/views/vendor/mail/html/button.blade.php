@props([
    'url',
    'color' => 'primary',
    'align' => 'center',
])
<a href="{{ $url }}" target="_blank" rel="noopener">{{ $slot }} →</a>

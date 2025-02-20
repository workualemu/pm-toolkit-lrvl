@props([
    'type' => 'button',
    'color' => 'info', // Default color
    'text' => 'Info', // Default text
])

<button type="{{ $type }}"
    {{ $attributes->merge(['class' => "btn border border-{$color} font-medium text-{$color} hover:bg-{$color} hover:text-white focus:bg-{$color} focus:text-white active:bg-{$color}/90"]) }}>
    {{ $slot ?? $text }}
</button>
@props([
    'type' => 'button',
    'color' => 'info', // Default color
    'text' => 'Info', // Default text
])

<button type="{{ $type }}"
    {{ $attributes->merge(['class' => "btn font-medium text-{$color} hover:bg-{$color}/20 focus:bg-{$color}/20 active:bg-{$color}/25"]) }}>
    {{ $slot ?? $text }}
</button>
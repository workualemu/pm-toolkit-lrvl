@props([
    'label' => 'Color',
    'name' => 'color',
    'model' => null,
    'selectedColor' => 'blue'
])

@php
    // Tailwind-Safe Colors for `text-{color}-700` and `bg-{color}-500`
    $tailwindColors = [
        'red' => '#EF4444', 'orange' => '#F97316', 'amber' => '#F59E0B', 'yellow' => '#EAB308', 'lime' => '#84CC16',
        'green' => '#22C55E', 'emerald' => '#10B981', 'teal' => '#14B8A6', 'cyan' => '#06B6D4', 'sky' => '#0EA5E9',
        'blue' => '#3B82F6', 'indigo' => '#6366F1', 'violet' => '#8B5CF6', 'purple' => '#A855F7', 'fuchsia' => '#D946EF',
        'pink' => '#EC4899', 'rose' => '#F43F5E', 'gray' => '#6B7280', 'slate' => '#64748B'
    ];
@endphp

<label class="block"
    x-data="{
        color: @entangle($model).defer, 
        colors: @js($tailwindColors)
    }"
    x-init="color = color || '{{ $selectedColor }}';"
>
    <span>{{ __($label) }}</span>

    <div class="relative mt-1.5 w-full">
        <!-- Tailwind Color Picker -->
        <select id="{{ $name }}" name="{{ $name }}" 
            x-model="color"
            {{ $model ? "wire:model.defer=$model" : '' }}
            class="form-select w-full rounded-lg border border-gray-300 bg-transparent p-2 cursor-pointer">
            
            @foreach ($tailwindColors as $color => $hex)
                <option value="{{ $color }}" style="background-color: {{ $hex }}; color: white;">
                    {{ ucfirst($color) }}
                </option>
            @endforeach
        </select>

    </div>
</label>

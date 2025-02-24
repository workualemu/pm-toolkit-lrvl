@props([
    'label' => 'Select Option', 
    'model', 
    'options' => [], 
    'valueField' => 'id', 
    'nameField' => 'name', 
    'selected' => [],
    'defaultText' => 'Select an option',
    'multiple' => false // New prop to toggle multi-select
])

<div>
<label class="block">
    <span>
        {{ $label }}
        @if($attributes->has('required')) 
            <span class="text-red-500">*</span>
        @endif
    </span>

    <select 
        x-init="$el._x_tom = new Tom($el)" 
        class="mt-1.5 w-full" 
        placeholder="{{ $defaultText }}"
        wire:model.defer="{{ $model }}" 
        autocomplete="off"
        {{ $attributes }} 
        @if($multiple) multiple @endif
    >

        @unless($multiple)
            <option value="">{{ $defaultText }}</option>
        @endunless

        @foreach($options as $option)
            <option value="{{ $option[$valueField] }}" 
                {{ is_array($selected) && in_array($option[$valueField], $selected) ? 'selected' : '' }}>
                {{ $option[$nameField] }}
            </option>
        @endforeach
    </select>
</label>
</div>

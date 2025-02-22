@props([
    'label' => 'Select Option', 
    'model', 
    'options' => [], 
    'valueField' => 'id', 
    'nameField' => 'name', 
    'selected' => '',
    'defaultText' => 'Select an option'
])

<label class="block">
    <span>
        {{ $label }}
        @if($attributes->has('required')) 
            <span class="text-red-500">*</span>
        @endif
    </span>
    
    <select x-init="$el._x_tom = new Tom($el)" 
            class="mt-1.5 w-full" 
            placeholder="{{ $defaultText }}"
            wire:model.defer="{{ $model }}" 
            autocomplete="off"
            {{ $attributes }}>

        <option value="">{{ $defaultText }}</option>

        @foreach($options as $option)
            <option value="{{ $option[$valueField] }}" 
                    {{ isset($selected) && $selected == $option[$valueField] ? 'selected' : '' }}>
                {{ $option[$nameField] }}
            </option>
        @endforeach
    </select>
</label>

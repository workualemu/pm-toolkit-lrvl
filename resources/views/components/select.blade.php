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

<div x-data="{ open: false }" class="relative">
    <label class="block">
        <span>
            {{ $label }}
            @if($attributes->has('required')) 
                <span class="text-red-500">*</span>
            @endif
        </span>

        <div class="relative">
            <!-- Select Trigger -->
            <select 
                x-init="$el._x_tom = new Tom($el)" 
                @focus="open = true" 
                @blur="setTimeout(() => open = false, 200)" 
                class="mt-1.5 w-full bg-white border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500"
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

            <!-- Floating Dropdown -->
            <div 
                x-show="open" 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute left-0 top-full mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg z-50"
                style="max-height: 200px; overflow-y: auto;"
            >
                @foreach($options as $option)
                    <div class="px-4 py-2 cursor-pointer hover:bg-gray-100"
                        @click="$dispatch('input', '{{ $option[$valueField] }}'); open = false;">
                        {{ $option[$nameField] }}
                    </div>
                @endforeach
            </div>
        </div>
    </label>
</div>

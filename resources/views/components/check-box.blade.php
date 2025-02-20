@props([
    'model' => null, // Wire model binding
    'label' => 'Checkbox', // Default label text
    'id' => 'checkbox', // Unique ID for the input
])

<div class="flex items-center space-x-2">
    <input 
        @if($model) wire:model.defer="{{ $model }}" @endif
        id="{{ $id }}"
        type="checkbox"
        class="form-switch h-5 w-10 rounded-lg bg-slate-300 before:rounded-md before:bg-slate-50 
               checked:!bg-info checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 
               dark:checked:before:bg-white"
    />
    <label for="{{ $id }}" class="text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ __($label) }}
    </label>
</div>

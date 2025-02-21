@props([
    'label' => '',
    'name' => '',
    'type' => 'text',
    'model' => null,
    'placeholder' => '',
    'required' => false, // Required validation
])

<label class="block">
    @if($label)
        <span class="text-gray-700 dark:text-gray-200">
            {{ __($label) }}
            @if($required)
                <span class="text-red-600">*</span> {{-- Red * for required fields --}}
            @endif
        </span>
    @endif

    <input id="{{ $name }}" name="{{ $name }}"
        {{ $model ? 'wire:model.lazy='.$model : '' }} {{-- Validate only on blur or submit --}}
        type="{{ $type }}"
        placeholder="{{ $placeholder }}"
        wire:blur="{{ $model }}" {{-- Triggers Livewire validation on blur --}}
        @if($required) required @endif
        {{ $attributes->merge(['class' => "form-input mt-1.5 h-9 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"]) }}
    >

    @if($model)
        @error($model)
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    @endif
</label>

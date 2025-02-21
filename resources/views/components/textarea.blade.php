@props([
    'label' => '',
    'name' => '',
    'model' => null,
    'placeholder' => '',
    'rows' => 2, // Default to 2 rows
    'required' => false, // Required validation
])

<label class="block">
    @if ($label)
        <span class="text-gray-700 dark:text-gray-200">
            {{ __($label) }}
            @if($required !== false) {{-- Ensures required="true" or just required works --}}
                <span class="text-red-600">*</span> {{-- Red * for required fields --}}
            @endif
        </span>
    @endif

    <textarea id="{{ $name }}" name="{{ $name }}"
        {{ $model ? 'wire:model.lazy='.$model : '' }} {{-- Validate only on blur or submit --}}
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        wire:blur="{{ $model }}" {{-- Triggers validation on blur --}}
        @if($required !== false) required @endif {{-- Ensures required works when passed --}}
        {{ $attributes->merge(['class' => "form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"]) }}
    ></textarea>

    @if($model)
        @error($model)
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    @endif
</label>

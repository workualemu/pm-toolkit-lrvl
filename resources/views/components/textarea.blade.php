@props([
    'label' => '',
    'name' => '',
    'model' => null,
    'placeholder' => '',
    'rows' => 2, // Default to 2 rows
])

<label class="block">
    @if ($label)
        <span>{{ __($label) }}</span>
    @endif

    <textarea id="{{ $name }}" name="{{ $name }}"
        {{ $model ? 'wire:model='.$model : '' }}
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => "form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"]) }}>
    </textarea>
</label>
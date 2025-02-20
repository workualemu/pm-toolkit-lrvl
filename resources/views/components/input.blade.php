@props([
    'label' => '',
    'name' => '',
    'type' => 'text',
    'model' => null,
    'placeholder' => '',
])

<label class="block">
    @if($label)
        <span>{{ __($label) }}</span>
    @endif

    <input id="{{ $name }}" name="{{ $name }}"
        {{ $model ? 'wire:model='.$model : '' }}
        type="{{ $type }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => "form-input mt-1.5 h-9 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"]) }}>
</label>
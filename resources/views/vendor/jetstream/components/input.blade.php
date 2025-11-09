@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary dark:bg-navy-800 dark:border-navy-500 dark:text-navy-50']) !!}>

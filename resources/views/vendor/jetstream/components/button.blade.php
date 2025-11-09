<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-focus focus:bg-primary-focus focus:outline-none disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>

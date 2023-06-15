<div x-data="{ show: {{ $show }}}" x-show="show" @click.away="show = false">
    <div>
        {{ $slot }}
    </div>
</div>
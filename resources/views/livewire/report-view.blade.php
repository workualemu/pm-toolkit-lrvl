<div class="w-full sm:gap-5 lg:gap-6">
    <div
        class="flex items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5"
    >
        <div class="flex justify-center space-x-2">
            <button wire:click="download()" icon="download-xls"
                class="border-b border-dotted border-current pb-0.5 font-medium text-primary outline-none transition-colors duration-300 hover:text-primary/70 focus:text-primary/70 dark:text-accent-light dark:hover:text-accent-light/70 dark:focus:text-accent-light/70"
            >
                Excel
            </button>
        </div>
    </div>
    @livewire('ag-grid', ['data'=>$results])
</div>
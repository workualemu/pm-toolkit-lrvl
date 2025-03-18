<div>
    @if($show)
        <div class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white dark:bg-navy-700 rounded-lg shadow-lg p-6 w-11/12 md:w-1/2 lg:w-1/3">
                <h2 class="text-xl font-bold text-slate-600 dark:text-navy-100 mb-4">Privacy Notice</h2>
                <p class="text-slate-600 dark:text-navy-100 mb-4">
                   privacy notice content
                </p>
                <button wire:click="toggle" class="btn bg-primary text-white hover:bg-primary-focus focus:bg-primary-focus dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus">Close</button>
            </div>
        </div>
    @endif
</div>
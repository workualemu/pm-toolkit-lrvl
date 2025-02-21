<div x-data="{ show: false, success: null, message: '' }"
     @status-message.window="
        success = $event.detail.success;
        message = $event.detail.message;
        show = true;
        setTimeout(() => show = false, 5000);
     "
     class="fixed top-5 right-5 z-50 max-w-sm p-4 rounded-lg shadow-lg transition-transform transform-gpu duration-300 ease-in-out"
     :class="success ? 'bg-green-100 border border-green-400 text-green-800' : 'bg-red-100 border border-red-400 text-red-800'"
     x-show="show"
>
    <div class="flex items-center">
        {{-- Icon --}}
        <svg class="w-6 h-6 flex-shrink-0 mr-3" 
             fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path x-show="success" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
            <path x-show="!success" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
        </svg>

        {{-- Message --}}
        <div class="flex-1 text-sm font-normal">
            <strong class="font-semibold" x-text="success ? 'Success!' : 'Error!'"></strong>
            <p x-text="message"></p>
        </div>

        {{-- Close Button --}}
        <button @click="show = false" class="ml-4 text-gray-500 hover:text-gray-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>

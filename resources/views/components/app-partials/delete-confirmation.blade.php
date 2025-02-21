<!-- Delete Confirmation Modal -->
<div x-data="Alpine.store('confirmModal')" x-show="open"
     class="fixed inset-0 flex items-center justify-center bg-gray-100 z-[99]"
     style="background: rgba(28, 11, 11, 0.15);">
    <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full z-[100] relative border-l-4"
         :class="{
            'border-red-600': color === 'red',
            'border-sky-600': color === 'sky',
            'border-green-600': color === 'green',
            'border-orange-600': color === 'orange'
         }">
        
        <!-- Title with Dynamic Color -->
        <div class="flex items-center space-x-3">
            <h2 class="text-lg font-semibold"
                :class="{
                    'text-red-600': color === 'red',
                    'text-sky-600': color === 'sky',
                    'text-green-600': color === 'green',
                    'text-orange-600': color === 'orange'
                }"
                x-text="title"></h2>
        </div>

        <!-- Warning Message -->
        <p class="text-gray-600 mt-2" x-text="message"></p>

        <!-- Buttons -->
        <div class="mt-4 flex justify-end space-x-3">
            <button @click="onCancel"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition duration-200">
                {{ __('Cancel') }}
            </button>
            <button @click="onOk"
                    class="px-4 py-2 rounded-lg text-white transition duration-300 shadow-md hover:shadow-lg active:scale-95"
                    :class="{
                        'bg-red-600 hover:bg-red-700': color === 'red',
                        'bg-sky-600 hover:bg-sky-700': color === 'sky',
                        'bg-green-600 hover:bg-green-700': color === 'green',
                        'bg-orange-600 hover:bg-orange-700': color === 'orange'
                    }">
                <span x-text="okText"></span>
            </button>
        </div>
    </div>
</div>

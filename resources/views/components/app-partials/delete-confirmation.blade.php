<!-- Delete Confirmation Modal -->
<div x-data="Alpine.store('confirmModal')" x-show="open"
     class="fixed inset-0 flex items-center justify-center bg-gray-100 z-[99]"
     style="background: rgba(28, 11, 11, 0.15);">
    <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full z-[100] relative border-l-4 border-red-600">
        
        <!-- Correct Danger Icon & Title -->
        <div class="flex items-center space-x-3">
            <h2 class="text-lg font-semibold text-red-600" x-text="title"></h2>
        </div>

        <!-- Warning Message -->
        <p class="text-gray-600 mt-2" x-text="message"></p>

        <!-- Buttons -->
        <div class="mt-4 flex justify-end space-x-3">
            <button @click="onCancel"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                {{ __('Cancel') }}
            </button>
            <button @click="onOk"
                    class="px-4 py-2 rounded-lg text-white bg-red-600 hover:bg-red-700">
                <span x-text="okText"></span>
            </button>
        </div>
    </div>
</div>

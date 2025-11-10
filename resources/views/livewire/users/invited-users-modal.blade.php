<div x-data="{showModal: @entangle('showModal')}">
    <div class="flex flex-col items-center justify-center h-screen bg-slate-200"
            x-on:drop="isDroppingFile = false"
            x-on:drop.prevent="handleFileDrop($event)"
            x-on:dragover.prevent="isDroppingFile = true"
            x-on:dragleave.prevent="isDroppingFile = false"
        >
        <div x-show="showModal" @click.away="showModal = false">
            <div class="fixed inset-0 z-[100] bg-slate-900/60 transition-opacity duration-200" @click="showModal = false"
                x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"> 
            </div>
            <div class="fixed  z-[101] h-full left-1/3 top-2">
                <div class="flex w-full flex-col bg-white dark:bg-navy-700">
                    <x-dialog-header title="{{ __('User invitation') }}" />
                    <div class="is-scrollbar-hidden flex grow flex-col space-y-4 overflow-y-auto p-4">
                        <x-input label="{{ __('Email address') }}" name="email" model="email" type="email" placeholder="Enter email" required />
                        <x-select 
                            label="Role"
                            model="role"
                            :options="$roles"
                            valueField="name"
                            nameField="name"
                            selected="{{ $selectedRole ?? '' }}"
                        />
                        <label class="block">
                            <div>
                                <script>
                                    function copyToClipboard(textToCopy) {
                                        if (navigator.clipboard && window.isSecureContext) {
                                            return navigator.clipboard.writeText(textToCopy);
                                        } else {
                                            let textArea = document.createElement("textarea");
                                            textArea.value = textToCopy;
                                            textArea.style.position = "fixed";
                                            textArea.style.left = "-999999px";
                                            textArea.style.top = "-999999px";
                                            document.body.appendChild(textArea);
                                            textArea.focus();
                                            textArea.select();
                                            document.execCommand('copy')
                                            return new Promise((res, rej) => {
                                                document.execCommand('copy') ? res() : rej();
                                                textArea.remove();
                                            });
                                        }
                                    }
                                </script>
                                <div class="flex items-center mt-4" x-data="{copied: false, initialized: false}">
                                    <input type="text" id="invite_link" readonly class="w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md" value="{{$invitation->link}}">
                                    <button class="hidden sm:flex sm:items-center sm:justify-center relative w-9 h-9 rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500 text-gray-400 hover:text-gray-600 group ml-1.5" :style="copied ? 'color:#06B6D4' : ''" @click="copyToClipboard(document.getElementById('invite_link').value).then(()=>{copied=true;copyTimeout=setTimeout(()=>{copied=false},1500)})" style="">
                                        <div x-show="copied" style="display:none" class="absolute inset-x-0 bottom-full mb-2.5 flex justify-center" x-transition:enter="transform ease-out duration-200 transition origin-bottom" x-transition:enter-start="scale-95 translate-y-0.5 opacity-0" x-transition:enter-end="scale-100 translate-y-0 opacity-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                        <div class="bg-gray-900 text-white rounded-md text-xs leading-4 tracking-wide font-semibold uppercase py-1 px-3 filter drop-shadow-md">
                                            <svg width="16" height="6" viewBox="0 0 16 6" class="text-gray-900 absolute top-full left-1/2 -mt-px -ml-2">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15 0H1V1.00366V1.00366V1.00371H1.01672C2.72058 1.0147 4.24225 2.74704 5.42685 4.72928C6.42941 6.40691 9.57154 6.4069 10.5741 4.72926C11.7587 2.74703 13.2803 1.0147 14.9841 1.00371H15V0Z" fill="currentColor"></path>
                                            </svg>
                                            {{ __('Copied!') }}
                                        </div>
                                        </div>
                                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" class="stroke-current transform group-hover:rotate-[-4deg] transition" :style="copied ? '--tw-rotate:-8deg;' : ''" style="">
                                            <path d="M12.9975 10.7499L11.7475 10.7499C10.6429 10.7499 9.74747 11.6453 9.74747 12.7499L9.74747 21.2499C9.74747 22.3544 10.6429 23.2499 11.7475 23.2499L20.2475 23.2499C21.352 23.2499 22.2475 22.3544 22.2475 21.2499L22.2475 12.7499C22.2475 11.6453 21.352 10.7499 20.2475 10.7499L18.9975 10.7499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M17.9975 12.2499L13.9975 12.2499C13.4452 12.2499 12.9975 11.8022 12.9975 11.2499L12.9975 9.74988C12.9975 9.19759 13.4452 8.74988 13.9975 8.74988L17.9975 8.74988C18.5498 8.74988 18.9975 9.19759 18.9975 9.74988L18.9975 11.2499C18.9975 11.8022 18.5498 12.2499 17.9975 12.2499Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M13.7475 16.2499L18.2475 16.2499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M13.7475 19.2499L18.2475 19.2499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <g :class="[copied ? '' : 'opacity-0', initialized ? 'transition-opacity' : '']" class="opacity-0 transition-opacity">
                                                <path d="M15.9975 5.99988L15.9975 3.99988" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M19.9975 5.99988L20.9975 4.99988" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M11.9975 5.99988L10.9975 4.99988" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </g>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="py-4"></div>
                    <div class="items-center border-t border-slate-150 py-3  dark:border-navy-600">
                        <div class="px-2 flex items-center justify-between dark:border-navy-600">
                            <x-button color="error" @click="showModal=false">{{ __('Close') }}</x-button>
                            <x-button color="info" wire:click="resendEmail()">{{ __('Resend email') }}</x-button>
                            <x-button color="info" wire:click="submit()">{{ __('Invite') }}</x-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
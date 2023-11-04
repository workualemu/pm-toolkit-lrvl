<div 
    x-data="appPriority()"  
    x-init="[initColor()]"
    >
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
                    <div class="flex h-14 items-center justify-between bg-slate-150 p-4 dark:bg-navy-800">
                        <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                            priority
                        </h3>
                    </div>

                    <div class="mt-3 grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                        <div class="col-span-12 sm:col-span-6 lg:col-span-8">
                            <div class="is-scrollbar-hidden flex grow flex-col space-y-4 overflow-y-auto p-4">
                                <label class="block">
                                    <span>Priority</span>
                                    <input id="value" wire:model.defer="priority.value"
                                        class="form-input mt-1.5 h-9 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Enter report title" type="text" />
                                </label>
                                <label class="block">
                                    <span>Description</span>
                                    <input id="description" wire:model.defer="priority.description"
                                        class="form-input mt-1.5 h-9 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Enter report rescription" type="text" />
                                </label>

                                <label class="block">
                                    <span>Color</span>
                                    <div>
                                        <div class="flex flex-row relative">
                                            <input id="color-picker" class="border border-gray-400 p-2 rounded-lg" x-model="currentColor">
                                            <div @click="isOpen = !isOpen" class="cursor-pointer rounded-full ml-3 my-auto h-10 w-10 flex" :class="`bg-${currentColor}-600`" >
                                                <svg xmlns="http://www.w3.org/2000/svg" :class="`${iconColor}`" class="h-6 w-6 mx-auto my-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                                </svg>
                                            </div>
                                            <div class="hidden bg-blue-100 bg-blue-200 bg-blue-300 bg-blue-400 bg-blue-500 bg-blue-600 bg-blue-700 bg-blue-800 bg-blue-900 
                                            bg-gray-100 bg-gray-200 bg-gray-300 bg-gray-400 bg-gray-500 bg-gray-600 bg-gray-700 bg-gray-800 bg-gray-900
                                            bg-green-100 bg-green-200 bg-green-300 bg-green-400 bg-green-500 bg-green-600 bg-green-700 bg-green-800 bg-green-900  
                                            bg-red-100 bg-red-200 bg-red-300 bg-red-400 bg-red-500 bg-red-600 bg-red-700 bg-red-800 bg-red-900
                                            bg-indigo-100 bg-indigo-200 bg-indigo-300 bg-indigo-400 bg-indigo-500 bg-indigo-600 bg-indigo-700 bg-indigo-800 bg-indigo-900 
                                            bg-teal-100 bg-teal-200 bg-teal-300 bg-teal-400 bg-teal-500 bg-teal-600 bg-teal-700 bg-teal-800 bg-teal-900
                                            bg-purple-100 bg-purple-200 bg-purple-300 bg-purple-400 bg-purple-500 bg-purple-600 bg-purple-700 bg-purple-800 bg-purple-900 
                                            bg-pink-100 bg-pink-200 bg-pink-300 bg-pink-400 bg-pink-500 bg-pink-600 bg-pink-700 bg-pink-800 bg-pink-900
                                            bg-yellow-100 bg-yellow-200 bg-yellow-300 bg-yellow-400 bg-yellow-500 bg-yellow-600 bg-yellow-700 bg-yellow-800 bg-yellow-900
                                            "> </div>
                                            <div x-show="isOpen" @click.away="isOpen = false" x-transition:enter="transition ease-out duration-100 transform"
                                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-75 transform" x-transition:leave-start="opacity-100 scale-100"
                                                x-transition:leave-end="opacity-0 scale-95" class="border border-gray-300 origin-top-right absolute right-0 top-full mt-2 rounded-md shadow-lg">
                                                <div class="rounded-md bg-white shadow-xs p-2">
                                                <div class="flex">
                                                    <template x-for="color in colors">
                                                    <div class="">
                                                        <div @click="selectColor(color)" class="cursor-pointer w-6 h-6 rounded-full mx-1 my-1" :class="`bg-${color}-600`"></div>
                                                    </div>
                                                    </template>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex items-center justify-between border-t border-slate-150 py-3 px-4 dark:border-navy-600">
                        <div class="flex space-x-1">
                            <button
                                class="btn h-8 w-8 rounded-full p-0 text-error hover:bg-error/20 focus:bg-error/20 active:bg-error/25">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                        <button wire:click="store()"
                            class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            Save
                        </button>
                        <button @click="showModal=false"
                            class="btn min-w-[7rem] bg-error font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
  function appPriority() {
      return {
        showModal: @entangle('showModal'), 
        colors: ['gray', 'red', 'pink', 'purple', 'indigo', 'blue', 'yellow', 'teal', 'green'],
        currentColor: @entangle('currentColor'),
        iconColor: '',
        isOpen: false,
        initColor () {
          this.setIconBlack()
        },
        setIconWhite () {
          this.iconColor = 'text-white'
        },
        setIconBlack () {
          this.iconColor = 'text-black'
        },
        selectColor (color) {
          this.currentColor = color
          this.setIconWhite()
        }
      }
  }
</script>

</div>
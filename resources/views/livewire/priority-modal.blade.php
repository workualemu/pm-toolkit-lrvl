<div x-data="{ showModal: @entangle('showModal')}">
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
                                    <div x-data="app(), { colorSelected: @entangle('colorSelected')}" x-cloak>
                                        <div class="max-w-sm mx-auto py-2">
                                            
                                                <div class="flex items-center">
                                                    <div>
                                                        <input id="colorSelected" type="text" placeholder="Pick a color"
                                                            class="border border-transparent shadow px-4 py-2 leading-normal text-gray-700 bg-white rounded-md focus:outline-none focus:shadow-outline"
                                                            x-model="colorSelected">
                                                    </div>
                                                    <div class="relative ml-3">
                                                        <button type="button" @click="isOpen = !isOpen" 
                                                            class="w-10 h-10 rounded-full focus:outline-none focus:shadow-outline inline-flex p-2 shadow"
                                                            :style="`background: ${colorSelected}; color: white`"
                                                        >
                                                            <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" d="M15.584 10.001L13.998 8.417 5.903 16.512 5.374 18.626 7.488 18.097z"/><path d="M4.03,15.758l-1,4c-0.086,0.341,0.015,0.701,0.263,0.949C3.482,20.896,3.738,21,4,21c0.081,0,0.162-0.01,0.242-0.03l4-1 c0.176-0.044,0.337-0.135,0.465-0.263l8.292-8.292l1.294,1.292l1.414-1.414l-1.294-1.292L21,7.414 c0.378-0.378,0.586-0.88,0.586-1.414S21.378,4.964,21,4.586L19.414,3c-0.756-0.756-2.072-0.756-2.828,0l-2.589,2.589l-1.298-1.296 l-1.414,1.414l1.298,1.296l-8.29,8.29C4.165,15.421,4.074,15.582,4.03,15.758z M5.903,16.512l8.095-8.095l1.586,1.584 l-8.096,8.096l-2.114,0.529L5.903,16.512z"/></svg>
                                                        </button>

                                                        <div x-show="isOpen" @click.away="isOpen = false" x-transition:enter="transition ease-out duration-100 transform"
                                                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                                            x-transition:leave="transition ease-in duration-75 transform"
                                                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                                            class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg">
                                                            <div class="rounded-md z-[101] bg-white shadow-xs px-4 py-3">
                                                                <div class="flex flex-wrap -mx-2">
                                                                <template x-for="(color, index) in colors" :key="index">
                                                                    <div 
                                                                        class="px-2"
                                                                    >
                                                                        <template x-if="colorSelected === color">	
                                                                            <div
                                                                                class="w-8 h-8 inline-flex rounded-full cursor-pointer border-4 border-white"
                                                                                :style="`background: ${color}; box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.2);`"
                                                                            ></div>
                                                                        </template>
                                                                        
                                                                        <template x-if="colorSelected != color">
                                                                            <div
                                                                                @click="colorSelected = color"
                                                                                @keydown.enter="colorSelected = color"
                                                                                role="checkbox"
                                                                                tabindex="0"
                                                                                :aria-checked="colorSelected"	
                                                                                class="w-8 h-8 inline-flex rounded-full cursor-pointer border-4 border-white focus:outline-none focus:shadow-outline"
                                                                                :style="`background: ${color};`"
                                                                            ></div>
                                                                        </template>
                                                                    </div>
                                                                </template>
                                                            </div>
                                                            </div>
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
</div>


<script>
		function app() {
			return {
				isOpen: false,
				colors: ['#2196F3', '#009688', '#9C27B0', '#FFEB3B', '#afbbc9', '#4CAF50', '#2d3748', '#f56565', '#ed64a6'],
				colorSelected: '#2196F3'
			}
		}
	</script>
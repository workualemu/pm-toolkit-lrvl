<div>
  <!-- Main Content Wrapper -->
  <main class="main-content todo-app w-full px-[2 * var(--margin-x)] pb-6">
    <!--header, title search, and filter block -->
    @livewire('partials.tasks.header', ['filterParams' => $filterParams])
    <!-- Tab def -->
    <div x-data="{ activeTab: 'tabList' }" class="tabs w-full flex flex-col">
      <div class="is-scrollbar-hidden overflow-x-auto">
        <div class="border-b-2 border-slate-150 px-2 dark:border-navy-500 flex justify-between">
          <div class="tabs-list -mb-0.5 flex">
            <button @click="activeTab = 'tabList'"
                :class="activeTab === 'tabList' ?
                    'border-primary dark:border-accent text-primary dark:text-accent-light' :
                    'border-transparent hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
                class="btn shrink-0 space-x-2 rounded-none border-b-2 px-3 py-2 font-medium">
                <svg class="h-4.5 w-4.5" stroke="currentColor" viewBox="0 0 24 24"
                      stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M7 6H21M7 12H21M7 18H21" stroke-linecap="round"
                          stroke-linejoin="round" />
                      <path d="M3 6H4M3 12H4M3 18H4" stroke-linecap="round"
                          stroke-linejoin="round" />
                  </svg>
                <span>{{ __('List') }}</span>
            </button>
            <button @click="activeTab = 'tabTable'"
                :class="activeTab === 'tabTable' ?
                    'border-primary dark:border-accent text-primary dark:text-accent-light' :
                    'border-transparent hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
                class="btn shrink-0 space-x-2 rounded-none border-b-2 px-3 py-2 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                    class="h-4.5 w-4.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
                </svg>
                <span>{{ __('Table') }}</span>
            </button>
          </div>

          @if($user->hasRole('admin') || $user->can('create phase'))
          <span>
            <div class="mt-2 px-4 ml-auto">
              <button 
              wire:click="addNewPhase()"
                  class="btn w-full space-x-2 border border-slate-200 py-2 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-500 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                  </svg>
                  <span> {{ __('New phase') }} </span>
              </button>
            </div>
          </span>
          @endif

        </div>
      </div>
      <div class="tab-content pt-4">
        <div x-show="activeTab === 'tabList'"
            wire:ignore
            x-transition:enter="transition-all duration-500 easy-in-out"
            x-transition:enter-start="opacity-0 [transform:translate3d(1rem,0,0)]"
            x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]">
            @livewire('partials.tasks.task-list', ['filterParams' => $filterParams])
        </div>

        <div x-show="activeTab === 'tabTable'"
          x-transition:enter="transition-all duration-500 easy-in-out"
          x-transition:enter-start="opacity-0 [transform:translate3d(1rem,0,0)]"
          x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]"
          class="w-full" >
          @livewire('partials.tasks.task-table', ['filterParams' => $filterParams])
        </div>
      </div>
    </div>
  </main>
</div>

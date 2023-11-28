<x-app-layout title="Todo Application" is-sidebar-open="true" is-header-blur="true" has-min-sidebar="true">
  <!-- Sidebar -->
  <div class="sidebar print:hidden">
      <!-- Main Sidebar -->
      <x-app-partials.main-sidebar></x-app-partials.main-sidebar>
      <livewire:task-right-popup />
      <!-- Sidebar Panel -->
      <div class="sidebar-panel">
          <div class="flex h-full grow flex-col bg-white pl-[var(--main-sidebar-width)] dark:bg-navy-750">
              <!-- Sidebar Panel Header -->
              <div class="flex h-18 w-full items-center justify-between pl-4 pr-1">
                  <div class="flex items-center">
                      <div class="avatar mr-3 hidden h-9 w-9 lg:flex">
                          <div class="is-initial rounded-full bg-info/10 text-info">
                              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                  xmlns="http://www.w3.org/2000/svg">
                                  <path d="M3 13.2L7.23529 18L17.8235 6" stroke-width="2" stroke-linecap="round"
                                      stroke-linejoin="round" />
                              </svg>
                          </div>
                      </div>
                      <div  class="flex block">
                        <p class="text-xl font-medium text-slate-800 dark:text-navy-50">
                          <span>Tasks</span>
                          
                        </p>
                      </div>
                  </div>
                  <button @click="$store.global.isSidebarExpanded = false"
                      class="btn h-7 w-7 rounded-full p-0 text-primary hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:text-accent-light/80 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 xl:hidden">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                          stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                      </svg>
                  </button>
                  
              </div>
              <!-- Sidebar Panel Body -->
              @livewire('tasks-side-bar')
          </div>
      </div>

      <!-- Minimized Sidebar Panel -->
      @livewire('tasks-side-bar-min')

  </div>

  <!-- Mobile Searchbar -->
  <x-app-partials.mobile-searchbar></x-app-partials.mobile-searchbar>

  <!-- Right Sidebar -->
  <x-app-partials.right-sidebar></x-app-partials.right-sidebar>

  <!-- Main Content Wrapper -->
  @livewire('tasks', ['project' => $project])
  <div class="fixed right-3 bottom-3 rounded-full bg-white dark:bg-navy-700">
      <button
          class="btn h-14 w-14 rounded-full bg-info p-0 font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90 sm:hidden">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
          </svg>
      </button>
  </div>

</x-app-layout>

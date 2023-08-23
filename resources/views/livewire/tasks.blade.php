<div>
  <!-- Main Content Wrapper -->
  <main class="main-content todo-app w-full px-[var(--margin-x)] pb-8">
    <p class="mt-1 text-xs text-info">
      <span>{{ $project->title }}</span>
    </p>
    <div class="py-5" x-data="{ isSearchbarActive: false }"
      x-effect="$store.breakpoints.smAndUp && (isSearchbarActive = false)">
      <div x-show="!isSearchbarActive" class="flex items-center justify-between">
        <div>
          <div class="flex space-x-2">
            <p class="text-xl font-medium text-slate-800 dark:text-navy-50">
              My tasks
            </p>
          </div>
          <p class="mt-1 text-xs">Tasks assigned to me</p>
        </div>
        <div class="flex items-center space-x-2">
          <label class="relative hidden sm:flex">
            <input
              class="form-input peer h-9 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
              placeholder="Search todos..." type="text" />
            <span
              class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 transition-colors duration-200"
                fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M3.316 13.781l.73-.171-.73.171zm0-5.457l.73.171-.73-.171zm15.473 0l.73-.171-.73.171zm0 5.457l.73.171-.73-.171zm-5.008 5.008l-.171-.73.171.73zm-5.457 0l-.171.73.171-.73zm0-15.473l-.171-.73.171.73zm5.457 0l.171-.73-.171.73zM20.47 21.53a.75.75 0 101.06-1.06l-1.06 1.06zM4.046 13.61a11.198 11.198 0 010-5.115l-1.46-.342a12.698 12.698 0 000 5.8l1.46-.343zm14.013-5.115a11.196 11.196 0 010 5.115l1.46.342a12.698 12.698 0 000-5.8l-1.46.343zm-4.45 9.564a11.196 11.196 0 01-5.114 0l-.342 1.46c1.907.448 3.892.448 5.8 0l-.343-1.46zM8.496 4.046a11.198 11.198 0 015.115 0l.342-1.46a12.698 12.698 0 00-5.8 0l.343 1.46zm0 14.013a5.97 5.97 0 01-4.45-4.45l-1.46.343a7.47 7.47 0 005.568 5.568l.342-1.46zm5.457 1.46a7.47 7.47 0 005.568-5.567l-1.46-.342a5.97 5.97 0 01-4.45 4.45l.342 1.46zM13.61 4.046a5.97 5.97 0 014.45 4.45l1.46-.343a7.47 7.47 0 00-5.568-5.567l-.342 1.46zm-5.457-1.46a7.47 7.47 0 00-5.567 5.567l1.46.342a5.97 5.97 0 014.45-4.45l-.343-1.46zm8.652 15.28l3.665 3.664 1.06-1.06-3.665-3.665-1.06 1.06z" />
              </svg>
          </span>
          </label>
          <div class="flex">
            <button @click="isSearchbarActive = true" x-tooltip="'Search'"
                class="btn h-9 w-9 p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 sm:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
            <button x-tooltip="'Filter'"
                class="btn h-9 w-9 p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                </svg>
            </button>
            <button x-tooltip="'Sort'"
              class="btn h-9 w-9 p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <div x-show="isSearchbarActive">
        <div class="flex space-x-2">
            <label class="relative flex w-full">
                <input
                    class="form-input peer h-9 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Search todos..." type="text" />
                <span
                    class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 transition-colors duration-200"
                        fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M3.316 13.781l.73-.171-.73.171zm0-5.457l.73.171-.73-.171zm15.473 0l.73-.171-.73.171zm0 5.457l.73.171-.73-.171zm-5.008 5.008l-.171-.73.171.73zm-5.457 0l-.171.73.171-.73zm0-15.473l-.171-.73.171.73zm5.457 0l.171-.73-.171.73zM20.47 21.53a.75.75 0 101.06-1.06l-1.06 1.06zM4.046 13.61a11.198 11.198 0 010-5.115l-1.46-.342a12.698 12.698 0 000 5.8l1.46-.343zm14.013-5.115a11.196 11.196 0 010 5.115l1.46.342a12.698 12.698 0 000-5.8l-1.46.343zm-4.45 9.564a11.196 11.196 0 01-5.114 0l-.342 1.46c1.907.448 3.892.448 5.8 0l-.343-1.46zM8.496 4.046a11.198 11.198 0 015.115 0l.342-1.46a12.698 12.698 0 00-5.8 0l.343 1.46zm0 14.013a5.97 5.97 0 01-4.45-4.45l-1.46.343a7.47 7.47 0 005.568 5.568l.342-1.46zm5.457 1.46a7.47 7.47 0 005.568-5.567l-1.46-.342a5.97 5.97 0 01-4.45 4.45l.342 1.46zM13.61 4.046a5.97 5.97 0 014.45 4.45l1.46-.343a7.47 7.47 0 00-5.568-5.567l-.342 1.46zm-5.457-1.46a7.47 7.47 0 00-5.567 5.567l1.46.342a5.97 5.97 0 014.45-4.45l-.343-1.46zm8.652 15.28l3.665 3.664 1.06-1.06-3.665-3.665-1.06 1.06z" />
                    </svg>
                </span>
            </label>
            <button @click="isSearchbarActive = false" x-tooltip="'Search'"
                class="btn h-9 w-9 shrink-0 p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 sm:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
      </div>
    </div>

    <!-- Tab def -->
    <div x-data="{ activeTab: 'tabList' }" class="tabs flex flex-col">
      <div class="is-scrollbar-hidden overflow-x-auto">
        <div class="border-b-2 border-slate-150 dark:border-navy-500">
          <div class="tabs-list -mb-0.5 flex">
            <button @click="activeTab = 'tabList'"
                :class="activeTab === 'tabList' ?
                    'border-primary dark:border-accent text-primary dark:text-accent-light' :
                    'border-transparent hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
                class="btn shrink-0 space-x-2 rounded-none border-b-2 px-3 py-2 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>List</span>
            </button>
            <button @click="activeTab = 'tabTable'"
                :class="activeTab === 'tabTable' ?
                    'border-primary dark:border-accent text-primary dark:text-accent-light' :
                    'border-transparent hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
                class="btn shrink-0 space-x-2 rounded-none border-b-2 px-3 py-2 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Table</span>
            </button>
            <button @click="activeTab = 'tabTree'"
                :class="activeTab === 'tabTree' ?
                    'border-primary dark:border-accent text-primary dark:text-accent-light' :
                    'border-transparent hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
                class="btn shrink-0 space-x-2 rounded-none border-b-2 px-3 py-2 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Tree view</span>
            </button>
          </div>
        </div>
      </div>
      <div class="tab-content pt-4">
        <div x-show="activeTab === 'tabList'"
            x-transition:enter="transition-all duration-500 easy-in-out"
            x-transition:enter-start="opacity-0 [transform:translate3d(1rem,0,0)]"
            x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]">
            <div>

              <div class="card px-4 pt-2 pb-4">
                <div x-init="Sortable.create($el, {
                  animation: 200,
                  easing: 'cubic-bezier(0, 0, 0.2, 1)',
                  direction: 'vertical',
                  delay: 150,
                  delayOnTouchOnly: true,
                })">
                 
                  @forelse($tasks as $task)
                    @livewire('task', ['task' => $task], key(crc32($task)))
                  @empty
                    <div>
                      <div colspan="6" class="text-center px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-400">
                          {{ __('There are no records to display') }}
                      </div>
                    </div>
                  @endforelse
                </div>
              </div>
            </div>
          </div>

          <div x-show="activeTab === 'tabTable'"
              x-transition:enter="transition-all duration-500 easy-in-out"
              x-transition:enter-start="opacity-0 [transform:translate3d(1rem,0,0)]"
              x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]">
              <div>
                <div x-data="{isFilterExpanded:false}">
                  <div class="flex items-center justify-between">
                    <h2
                      class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100"
                    >
                      Tasks
                    </h2>
                    <div class="flex">
                      <div class="flex items-center" x-data="{isInputActive:false}">
                        <label class="block">
                          <input
                            x-effect="isInputActive === true && $nextTick(() => { $el.focus()});"
                            :class="isInputActive ? 'w-32 lg:w-48' : 'w-0'"
                            class="form-input bg-transparent px-1 text-right transition-all duration-100 placeholder:text-slate-500 dark:placeholder:text-navy-200"
                            placeholder="Search here..."
                            type="text"
                          />
                        </label>
                        <button
                          @click="isInputActive = !isInputActive"
                          class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25"
                        >
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4.5 w-4.5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.5"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            />
                          </svg>
                        </button>
                      </div>

                      <button
                        @click="isFilterExpanded = !isFilterExpanded"
                        class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          class="h-4.5 w-4.5"
                          fill="none"
                          viewBox="0 0 24 24"
                        >
                          <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-width="2"
                            d="M18 11.5H6M21 4H3m6 15h6"
                          />
                        </svg>
                      </button>
                    </div>
                  </div>
                  <div x-show="isFilterExpanded" x-collapse>
                    <div class="max-w-2xl py-3">
                      <div
                        class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:gap-6"
                      >
                        <label class="block">
                          <span>Title:</span>
                          <div class="relative mt-1.5 flex">
                            <input
                              class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                              placeholder="Enter task title"
                              type="text"
                            />
                            <span
                              class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent"
                            >
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4.5 w-4.5 transition-colors duration-200"
                                fill="none"
                                viewBox="0 0 24 24"
                              >
                                <path
                                  stroke="currentColor"
                                  stroke-width="1.5"
                                  d="M5 19.111c0-2.413 1.697-4.468 4.004-4.848l.208-.035a17.134 17.134 0 015.576 0l.208.035c2.307.38 4.004 2.435 4.004 4.848C19 20.154 18.181 21 17.172 21H6.828C5.818 21 5 20.154 5 19.111zM16.083 6.938c0 2.174-1.828 3.937-4.083 3.937S7.917 9.112 7.917 6.937C7.917 4.764 9.745 3 12 3s4.083 1.763 4.083 3.938z"
                                />
                              </svg>
                            </span>
                          </div>
                        </label>
                        <label class="block">
                          <span>Phase:</span>
                          <div class="relative mt-1.5 flex">
                            <input
                              class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                              placeholder="Enter phase title"
                              type="text"
                            />
                            <span
                              class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent"
                            >
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4.5 w-4.5 transition-colors duration-200"
                                fill="none"
                                viewBox="0 0 24 24"
                              >
                                <path
                                  stroke="currentColor"
                                  stroke-width="1.5"
                                  d="M3.082 13.944c-.529-.95-.793-1.425-.793-1.944 0-.519.264-.994.793-1.944L4.43 7.63l1.426-2.381c.559-.933.838-1.4 1.287-1.66.45-.259.993-.267 2.08-.285L12 3.26l2.775.044c1.088.018 1.631.026 2.08.286.45.26.73.726 1.288 1.659L19.57 7.63l1.35 2.426c.528.95.792 1.425.792 1.944 0 .519-.264.994-.793 1.944L19.57 16.37l-1.426 2.381c-.559.933-.838 1.4-1.287 1.66-.45.259-.993.267-2.08.285L12 20.74l-2.775-.044c-1.088-.018-1.631-.026-2.08-.286-.45-.26-.73-.726-1.288-1.659L4.43 16.37l-1.35-2.426z"
                                />
                                <circle
                                  cx="12"
                                  cy="12"
                                  r="3"
                                  stroke="currentColor"
                                  stroke-width="1.5"
                                />
                              </svg>
                            </span>
                          </div>
                        </label>
                        <label class="block">
                          <span>From:</span>
                          <div class="relative mt-1.5 flex">
                            <input
                            x-init="$el._x_flatpickr = flatpickr($el)"
                              class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                              placeholder="Choose start date..."
                              type="text"
                            />
                            <span
                              class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent"
                            >
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 transition-colors duration-200"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.5"
                              >
                                <path
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                />
                              </svg>
                            </span>
                          </div>
                        </label>
                        <label class="block">
                          <span>To:</span>
                          <div class="relative mt-1.5 flex">
                            <input
                            x-init="$el._x_flatpickr = flatpickr($el)"
                              class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                              placeholder="Choose end date..."
                              type="text"
                            />
                            <div
                              class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent"
                            >
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 transition-colors duration-200"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.5"
                              >
                                <path
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                />
                              </svg>
                            </div>
                          </div>
                        </label>
                        <div class="sm:col-span-2">
                          <span>Project Status:</span>
                          <div
                            class="mt-2 grid grid-cols-1 gap-4 sm:grid-cols-4 sm:gap-5 lg:gap-6"
                          >
                            <label class="inline-flex items-center space-x-2">
                              <input
                                class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-secondary checked:bg-secondary hover:border-secondary focus:border-secondary dark:border-navy-400 dark:checked:border-secondary-light dark:checked:bg-secondary-light dark:hover:border-secondary-light dark:focus:border-secondary-light"
                                type="checkbox"
                              />
                              <span>Upcoming</span>
                            </label>
                            <label class="inline-flex items-center space-x-2">
                              <input
                                class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                type="checkbox"
                              />
                              <span>In Progress</span>
                            </label>
                            <label class="inline-flex items-center space-x-2">
                              <input
                                checked
                                class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:!border-success checked:bg-success hover:!border-success focus:!border-success dark:border-navy-400"
                                type="checkbox"
                              />
                              <span>Complete</span>
                            </label>
                            <label class="inline-flex items-center space-x-2">
                              <input
                                checked
                                class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:!border-error checked:bg-error hover:!border-error focus:!border-error dark:border-navy-400"
                                type="checkbox"
                              />
                              <span>Cancelled</span>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="mt-4 space-x-1 text-right">
                        <button
                          @click="isFilterExpanded = ! isFilterExpanded"
                          class="btn font-medium text-slate-700 hover:bg-slate-300/20 active:bg-slate-300/25 dark:text-navy-100 dark:hover:bg-navy-300/20 dark:active:bg-navy-300/25"
                        >
                          Cancel
                        </button>

                        <button
                          @click="isFilterExpanded = ! isFilterExpanded"
                          class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90"
                        >
                          Apply
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="card mt-3">
                    <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                      <table class="is-hoverable w-full text-left">
                        <thead>
                          <tr>
                            <th
                              class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                            >
                              #
                            </th>
                            <th
                              class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                            >
                              Title
                            </th>

                            <th
                              class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                            >
                              Progress
                            </th>
                            <th
                              class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                            >
                              Status
                            </th>
                            <th
                              class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                            >
                              Due date
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($tasks as $index=>$task)
                          <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500"
                          >
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$index + 1}}</td>
                            <td
                              class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5"
                            >
                              {{$task->title}}
                            </td>

                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                              <div  style="width: 100px"
                                x-tooltip.primary="'{{$task->progress * 100}}% Completed'"
                                class="progress h-2 {{$task->color}} dark:bg-navy-500"
                              >
                                <div style="width: {{$task->progress * 100}}px"
                                  class="rounded-full bg-primary dark:bg-accent"
                                ></div>
                              </div>
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                              <div
                                class="badge space-x-2.5 px-0 text-primary dark:text-accent-light"
                              >
                                <div class="h-2 w-2 rounded-full bg-current"></div>
                                <span>{{$task->taskStatus->value}}</span>
                              </div>
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                              {{$task->planned_end_date}}
                            </td>
                          </tr>
                        @endforeach
                        </tbody>
                      </table>
                    </div>
                    

                    <div
                      class="flex flex-col justify-between space-y-4 px-4 py-4 sm:flex-row sm:items-center sm:space-y-0 sm:px-5"
                    >
                      <div class="text-xs+">1 - 3 of 3 entries</div>
                      <ol class="pagination space-x-1.5">
                        <li>
                          <a
                            href="#"
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-150 text-slate-500 transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:bg-navy-500 dark:text-navy-200 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90"
                          >
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                              stroke-width="2"
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 19l-7-7 7-7"
                              />
                            </svg>
                          </a>
                        </li>
                        <li>
                          <a
                            href="#"
                            class="flex h-8 min-w-[2rem] items-center justify-center rounded-full bg-primary px-3 leading-tight text-white transition-colors hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90"
                            >1</a
                          >
                        </li>
                        <li>
                          <a
                            href="#"
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-150 text-slate-500 transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:bg-navy-500 dark:text-navy-200 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90"
                          >
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                              />
                            </svg>
                          </a>
                        </li>
                      </ol>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

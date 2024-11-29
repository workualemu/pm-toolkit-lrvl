<div>
  <!-- Main Content Wrapper -->
  <main class="main-content todo-app w-full px-[2 * var(--margin-x)] pb-6">
    <!--header, title search, and filter block -->
    @livewire('partials.tasks.header', ['filterParams' => $filterParams])
    <!-- Tab def -->
    <div x-data="{ activeTab: 'tabList' }" class="tabs w-full flex flex-col">
      <div class="is-scrollbar-hidden overflow-x-auto">
        <div class="border-b-2 border-slate-150 px-2 dark:border-navy-500">
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
                <span>List</span>
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
                <span>Table</span>
            </button>
          </div>
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
          <div class="w-full">
            <div class="card px-4 pt-2 pb-4">
              <div class="w-full">
                <table class="is-hoverable text-left w-full table-fixed" >
                  <thead>
                    <tr>
                      <th
                        class="w-6/12 bg-slate-200 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                      >
                        Title
                      </th>

                      <th
                        class="w-2/12 whitespace-nowrap bg-slate-200 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                      >
                        Progress
                      </th>
                      <th
                        class="w-2/12 whitespace-nowrap bg-slate-200 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                      >
                        Status
                      </th>
                      <th
                        class="w-2/12 whitespace-nowrap bg-slate-200 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                      >
                        Due date
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($tasks as $index=>$task)
                      <tr class="h-1 w-full bg-blue-100 border-y border-transparent border-b-slate-200 dark:border-b-navy-500"
                      >
                        <td
                          class="font-medium text-slate-700 dark:text-navy-100"
                        >
                          {{$task->title}}
                        </td>

                        <td class="whitespace-nowrap sm:px-5">
                          <div  style="width: 100px"
                            x-tooltip.primary="'{{$task->progress}}% Completed'"
                            class="progress h-2 {{$task->color}} dark:bg-navy-500"
                          >
                            <div style="width: {{$task->progress}}px"
                              class="rounded-full bg-primary dark:bg-accent"
                            ></div>
                          </div>
                        </td>
                        <td class="whitespace-nowrap sm:px-5">
                          <div
                            class="badge space-x-2.5 px-0 text-{{$task->taskStatus->color}}-700 dark:text-accent-light"
                          >
                            <span>{{$task->taskStatus->value}}</span>
                          </div>
                        </td>
                        <td class="whitespace-nowrap sm:px-5">
                          {{date('d-M-Y', strtotime($task->planned_end_date))}}
                        </td>
                      </tr>
                    @foreach ($task->children as  $c_index=>$child)
                          <tr style="margin-left: 20px;" class="h-1 bg-blue-50 border-y border-transparent border-b-slate-200 dark:border-b-navy-500"
                          >
                            <td
                              class="font-inter text-slate-700 dark:text-navy-100 px-5"
                            >
                              {{$child->title}}
                            </td>

                            <td class="whitespace-nowrap sm:px-5">
                              <div  style="width: 100px"
                                x-tooltip.primary="'{{$child->progress}}% Completed'"
                                class="progress h-2 {{$child->color}} dark:bg-navy-500"
                              >
                                <div style="width: {{$child->progress}}px"
                                  class="rounded-full bg-primary dark:bg-accent"
                                ></div>
                              </div>
                            </td>
                            <td class="whitespace-nowrap sm:px-5">
                              <div
                                class="badge font-inter space-x-2.5 px-0 text-{{$child->taskStatus->color}}-700 dark:text-accent-light"
                              >
                                <span>{{$child->taskStatus->value}}</span>
                              </div>
                            </td>
                            <td class="whitespace-nowrap font-inter sm:px-5">
                              {{date('d-M-Y', strtotime($child->planned_end_date))}}
                            </td>
                          </tr>
                        @foreach ($child->children as  $g_index=>$gchild)
                            <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500"
                            >
                              <td
                                class="font-mono text-slate-700 dark:text-navy-100 px-10"
                              >
                                {{$gchild->title}}
                              </td>

                              <td class="whitespace-nowrap sm:px-5">
                                <div  style="width: 100px"
                                  x-tooltip.primary="'{{$gchild->progress}}% Completed'"
                                  class="progress h-2 {{$gchild->color}} dark:bg-navy-500"
                                >
                                  <div style="width: {{$gchild->progress}}px"
                                    class="rounded-full bg-primary dark:bg-accent"
                                  ></div>
                                </div>
                              </td>
                              <td class="whitespace-nowrap sm:px-5">
                                <div
                                  class="badge font-mono space-x-2.5 px-0 text-{{$gchild->taskStatus->color}}-700 dark:text-accent-light"
                                >
                                  <span>{{$gchild->taskStatus->value}}</span>
                                </div>
                              </td>
                              <td class="font-mono whitespace-nowrap sm:px-5">
                                {{date('d-M-Y', strtotime($gchild->planned_end_date))}}
                              </td>
                            </tr>
                        @endforeach
                    @endforeach
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

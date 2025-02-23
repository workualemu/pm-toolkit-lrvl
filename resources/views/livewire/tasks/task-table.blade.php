<div class="w-full">
    <div class="card px-4 pt-2 pb-4">
        <div class="w-full">
            <table class="is-hoverable text-left w-full table-fixed">
                <thead>
                    <tr>
                        <th class="w-6/12 bg-slate-200 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            {{ __('Title') }}
                        </th>
                        <th class="w-2/12 whitespace-nowrap bg-slate-200 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        {{ __('Progress') }}
                        </th>
                        <th class="w-2/12 whitespace-nowrap bg-slate-200 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        {{ __('Status') }}
                        </th>
                        <th class="w-2/12 whitespace-nowrap bg-slate-200 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        {{ __('Due date') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $index => $task)
                        @if($task->level == 0)
                            <tr class="h-1 w-full bg-blue-100 border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                        @elseif($task->level == 1)
                            <tr class="h-1 bg-blue-50 border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                        @else
                            <tr class="px-4 border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                        @endif
                            <td class="pl-2 {{$task->level == 1 ? 'pl-6' : ''}} {{$task->level == 2 ? 'pl-12' : ''}} font-medium text-slate-700 dark:text-navy-100">
                                {{$task->title}}
                            </td>
                            <td class="whitespace-nowrap sm:px-5">
                                <div style="width: 100px" x-tooltip.primary="'{{$task->progress}}% Completed'" class="progress h-2 {{$task->color}} dark:bg-navy-500">
                                    <div style="width: {{$task->progress}}px" class="rounded-full bg-primary dark:bg-accent"></div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap sm:px-5">
                                <div class="badge space-x-2.5 px-0 text-{{$task->taskStatus?->color}}-700 dark:text-accent-light">
                                    <span>{{$task->taskStatus?->value}}</span>
                                </div>
                            </td>
                            <td class="whitespace-nowrap sm:px-5">
                                {{date('d-M-Y', strtotime($task->end_date))}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

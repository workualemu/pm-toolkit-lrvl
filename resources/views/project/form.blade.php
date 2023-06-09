<div class="shadow sm:rounded-md sm:overflow-hidden">

    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

        <div class="relative">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-start">
                <span class="pr-3 bg-white text-sm uppercase tracking-wide text-gray-500">{{ __('Project') }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 pl-3 md:pl-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="relative">
                    <input type="text" id="title" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="title" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Title</label>
                    <x-input-error for="title" class="mt-2" />
                </div>

            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="relative">
                    <input type="date" id="start_date" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="start_date" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Start date</label>
                    <x-input-error for="start_date" class="mt-2" />
                </div>
                <div class="relative">
                    <input type="date" id="end_date" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="end_date" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">End date</label>
                    <x-input-error for="end_date" class="mt-2" />
                </div>
            </div>

            <div class="relative">
                <input type="text" id="description" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                <label for="description" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">{{ __('Description') }}</label>
                <x-input-error for="description" class="mt-2" />
            </div>

        </div>

        <div class="relative mt-4">
            

            <div class="relative flex justify-start">
                <span class="pr-3 bg-white text-sm uppercase tracking-wide text-gray-500">{{ __('Description') }} </span>
            </div>

            <x-label for="description" value="{{ __('Project Description') }} *" />
                    <x-input id="description" name="description" type="text" class="mt-1 block w-full" value="{{old('description', $project->description ?? null)}}" />
                    <x-input-error for="description" class="mt-2" />
            </div>

            <x-label for="status" value="{{ __('Status') }} *" />
                    <x-input id="status" name="status" type="text" class="mt-1 block w-full" value="{{old('status', $project->status ?? null)}}" />
                    <x-input-error for="status" class="mt-2" />
            </div>

            <x-label for="user_id" value="{{ __('User ID') }} *" />
                    <x-input id="user_id" name="user_id" type="text" class="mt-1 block w-full" value="{{old('user_id', $project->user_id ?? null)}}" />
                    <x-input-error for="user_id" class="mt-2" />
            </div>

        <div class="pl-3 md:pl-6 space-y-6">
           
        </div>
    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <x-secondary-button class="mr-2"><a href="{{ route('index') }}">{{ __('Cancel') }}</a></x-secondary-button>
        <x-button>
            {{ __('Submit') }}
        </x-button>
    </div>
</div>

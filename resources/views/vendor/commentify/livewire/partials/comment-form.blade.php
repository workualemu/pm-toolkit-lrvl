<form class="mb-6" wire:submit.prevent="{{$method}}">
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                 role="alert">
                <span class="font-medium">Success!</span> {{session('message')}}
            </div>
        </div>
    @endif
    @csrf
    <div
        class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <label for="{{$inputId}}" class="sr-only">{{$inputLabel}}</label>
        <textarea id="{{$inputId}}" rows="6"
                  class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none
                              dark:text-white dark:placeholder-gray-400 dark:bg-gray-800 @error($state.'.body')
                              border-red-500 @enderror"
                  placeholder="Write a comment..."
                  wire:model.defer="{{$state}}.body"
                  oninput="detectAtSymbol()"
        ></textarea>
        @if(!empty($users) && $users->count() > 0)
            @include('commentify::livewire.partials.dropdowns.users')
        @endif
        @error($state.'.body')
        <p class="mt-2 text-sm text-red-600">
            {{$message}}
        </p>
        @enderror
    </div>

    <button
        wire:loading.attr="disabled"
        type="submit"
        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 rounded-md shadow-sm transition disabled:opacity-60 disabled:cursor-not-allowed dark:bg-indigo-700 dark:hover:bg-indigo-800 dark:focus:ring-indigo-600">
        <span wire:loading wire:target="{{$method}}" class="flex items-center">
            @include('commentify::livewire.partials.loader')
        </span>
        <span wire:loading.remove wire:target="{{$method}}">{{$button ?? 'Post comment'}}</span>
    </button>

</form>

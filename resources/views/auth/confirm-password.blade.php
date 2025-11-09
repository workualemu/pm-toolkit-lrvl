<x-base-layout title="Confirm Password">
    <div class="min-h-screen flex items-center justify-center bg-slate-100 dark:bg-navy-800 px-4 py-12">
        <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-xl dark:bg-navy-700">
            <div class="flex flex-col items-center">
                <img class="h-16 w-16" src="{{ asset('images/app-logo.png') }}" alt="logo" />
                <h1 class="mt-4 text-2xl font-semibold text-slate-700 dark:text-navy-50">
                    {{ __('Confirm your password') }}
                </h1>
                <p class="mt-2 text-sm text-slate-500 dark:text-navy-200 text-center">
                    {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                </p>
            </div>

            @if ($errors->any())
                <div class="mt-4 rounded-lg border border-error/50 bg-error/10 px-3 py-2 text-sm text-error">
                    <ul class="space-y-1 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="mt-6 space-y-4" method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <label class="block">
                    <span class="text-xs+ font-medium text-slate-600 dark:text-navy-200">{{ __('Password') }}</span>
                    <input id="password"
                        class="form-input mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-primary focus:ring-primary dark:border-navy-500 dark:bg-transparent dark:text-navy-50"
                        type="password" name="password" required autocomplete="current-password" autofocus />
                </label>

                <button type="submit"
                    class="btn h-11 w-full rounded-full bg-primary text-base font-semibold text-white hover:bg-primary-focus dark:bg-accent">
                    {{ __('Confirm') }}
                </button>
            </form>
        </div>
    </div>
</x-base-layout>

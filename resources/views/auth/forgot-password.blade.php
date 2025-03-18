<x-base-layout title="Forgot password?">
<div class="fixed top-0 hidden p-6 lg:block lg:px-12">
        <a href="#" class="flex items-center space-x-2">
            <img class="h-12 w-12" src="{{ asset('images/uneca_main_logo.png') }}" alt="logo" />
            <p class="text-xl font-semibold uppercase text-slate-700 dark:text-navy-100">
                {{ config('app.name') }}
            </p>
        </a>
    </div>
    <div class="hidden w-full place-items-center lg:grid">
        <div class="w-full max-w-lg p-6">
            <img class="w-full" 
                src="{{ asset('images/illustrations/dashboard-check.svg') }}" alt="image" />
        </div>
    </div>
    <main class="flex w-full flex-col items-center bg-white dark:bg-navy-700 lg:max-w-md">
        <div class="flex w-full max-w-sm grow flex-col justify-center p-5">
            @if (session('status'))
                <div class="text-center">
                    <img class="mx-auto h-16 w-16 lg:hidden" src="{{ asset('images/app-logo.svg') }}" alt="logo" />
                    <div class="mt-4">
                        <p class="text-slate-600 dark:text-navy-300">
                            {{ session('status') }}
                        </p>
                    </div>
                </div>
            @else
                <div class="text-center">
                    <img class="mx-auto h-16 w-16 lg:hidden" src="{{ asset('images/app-logo.svg') }}" alt="logo" />
                    <div class="mt-4">
                        <h2 class="text-2xl font-semibold text-slate-600 dark:text-navy-100">
                            {{ __('Forgot password?') }}
                        </h2>
                        <p class="text-slate-600 dark:text-navy-300">
                            {{ __('Please enter your email address and click on the "Send Password Reset Link" button.  An email will be sent to you to reset your password') }}
                        </p>
                    </div>
                </div>
                <div class="py-8"></div>
                <form method="POST" action="{{ route('password.email') }}">
                    @method('POST') @csrf
                    <div>
                        <label class="relative flex">
                            <input id="email" type="email"
                                class="form-input peer w-full rounded-lg bg-slate-150 px-3 py-2 pl-9 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                placeholder="Email" type="text" name="email"/>
                            <span
                                class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                        </label>
                        @error('email')
                            <span class="text-tiny+ text-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit"
                        class="btn mt-10 h-10 w-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        {{ __('Send Password Reset Link') }}
                    </button>
                </form>
            @endif
        </div>
        <div class="my-5 flex justify-center text-xs text-slate-400 dark:text-navy-300">
            <a href="#">Privacy Notice</a>
            <div class="mx-3 my-1 w-px bg-slate-200 dark:bg-navy-500"></div>
            <a href="#">Term of service</a>
        </div>
    </main>
    
</x-base-layout>

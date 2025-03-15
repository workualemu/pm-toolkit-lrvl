<x-base-layout title="Login">
    <div class="fixed top-0 hidden p-6 lg:block lg:px-12">
        <a href="#" class="flex items-center space-x-2">
            <img class="h-12 w-12" src="{{ asset('images/uneca_main_logo.png') }}" alt="logo" />
            <p class="text-xl font-semibold uppercase text-slate-700 dark:text-navy-100">
                {{ config('app.name') }}
            </p>
        </a>
    </div>
    <div class="w-full lg:grid lg:grid-cols-2 lg:min-h-screen">
        <div class="hidden lg:flex flex-col items-center justify-center p-6">
            <img class="w-full max-w-lg mb-4 mt-4" src="{{ asset('images/illustrations/dashboard-check.svg') }}" alt="image" />
            <div class="text-center px-4">
                <h2 class="text-2xl font-bold text-slate-600 dark:text-navy-100 mb-2">About the Census Project Management System</h2>
                <p class="text-lg text-slate-600 dark:text-navy-100 mx-auto" style="max-width: 600px;">
                    The Census Project Management System simplifies the collection and management of census data with a user-friendly interface for accurate data entry and analysis, supporting collaboration and efficient project management.
                </p>
            </div>
        </div>
        <main class="flex flex-col items-center justify-center w-full bg-white dark:bg-navy-700 p-4 lg:p-8">
            <div class="lg:hidden mb-6 flex justify-center">
                <img class="h-20 w-20" src="{{ asset('images/uneca_main_logo.png') }}" alt="logo" />
            </div>
            <div class="flex w-full max-w-md grow flex-col justify-center p-4 sm:p-6 lg:p-8">
                <div class="text-center">
                    <div class="mt-4">
                        <h2 class="text-3xl sm:text-4xl font-bold text-slate-600 dark:text-navy-100">
                            {{ __('Welcome Back!') }}
                        </h2>
                        <p class="text-base sm:text-lg text-slate-600 dark:text-navy-300">
                            {{ __('Please sign in to continue') }}
                        </p>
                    </div>
                </div>
                @if(session('error'))
                    <div class="bg-red-500 text-white p-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif
                <form class="mt-8" action="{{ route('login') }}" method="post">
                    @method('POST') @csrf
                    <div class="mb-6">
                        <label class="block text-slate-600 dark:text-navy-300 mb-2" for="email">Email</label>
                        <div class="relative flex">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <input
                                id="email"
                                class="form-input peer pl-10 w-full rounded-lg bg-slate-150 px-4 py-3 sm:px-3 sm:py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                placeholder="Email" type="text" name="email"
                                value="{{ old('email') ?? '' }}" />
                        </div>
                        @error('email')
                            <span class="text-tiny+ text-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="block text-slate-600 dark:text-navy-300 mb-2" for="password">Password</label>
                        <div class="relative flex">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </span>
                            <input
                                id="password"
                                class="form-input peer pl-10 w-full rounded-lg bg-slate-150 px-4 py-3 sm:px-3 sm:py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                placeholder="Password" type="password" name="password"
                                value="{{ old('password') ?? '' }}" />
                        </div>
                        @error('password')
                            <span class="text-tiny+ text-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6 flex items-center justify-between space-x-2">
                        <label class="inline-flex items-center space-x-2">
                            <input
                                class="form-checkbox is-outline h-5 w-5 rounded border-slate-400/70 bg-slate-100 before:bg-primary checked:border-primary hover:border-primary focus:border-primary dark:border-navy-500 dark:bg-navy-900 dark:before:bg-accent dark:checked:border-accent dark:hover:border-accent dark:focus:border-accent"
                                type="checkbox" />
                            <span class="line-clamp-1">Remember me</span>
                        </label>
                        <a href="{{ route('password.request') }}"
                            class="text-sm text-slate-400 transition-colors line-clamp-1 hover:text-slate-800 focus:text-slate-800 dark:text-navy-300 dark:hover:text-navy-100 dark:focus:text-navy-100">Forgot
                            Password?</a>
                    </div>
                    <button type="submit"
                        class="btn mt-8 h-12 w-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        Sign In
                    </button>
                </form>
            </div>
            <div class="hidden lg:flex my-5 justify-center text-sm text-slate-400 dark:text-navy-300">
                <span>&copy; 2025 UNECA. All rights reserved.</span>
                <div class="mx-3 my-1 w-px bg-slate-200 dark:bg-navy-500"></div>
                <a href="#">Privacy Notice</a>
                <div class="mx-3 my-1 w-px bg-slate-200 dark:bg-navy-500"></div>
                <a href="#">Term of service</a>
            </div>
        </main>
    </div>
    
</x-base-layout>
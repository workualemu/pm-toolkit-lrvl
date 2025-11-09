<x-base-layout title="Two-Factor Challenge">
    <div class="fixed top-0 p-6 lg:block lg:px-12">
        <a href="#" class="flex items-center space-x-2">
            <img class="h-12 w-12" src="{{ asset('images/app-logo.png') }}" alt="logo" />
            <p class="text-xl font-semibold uppercase text-slate-700 dark:text-navy-100">
                {{ config('app.name') }}
            </p>
        </a>
    </div>
    <div class="grid min-h-screen w-full place-items-center bg-white px-4 py-16 dark:bg-navy-700">
        <div class="w-full max-w-md rounded-2xl border border-slate-200 bg-white p-6 shadow-xl dark:border-navy-600 dark:bg-navy-800">
            @php
                $twoFactorMethod = optional($user)->two_factor_method;
            @endphp
            <div class="text-center">
                <h1 class="text-2xl font-semibold text-slate-700 dark:text-navy-50">Two-Factor Authentication</h1>
                <p class="mt-2 text-sm text-slate-500 dark:text-navy-200">
                    Enter the 6-digit code from your authenticator app @if($twoFactorMethod === 'sms') or the SMS code you received @endif to continue.
                </p>
            </div>

            @if ($errors->any())
                <div class="mt-4 rounded-xl border border-error/40 bg-error/10 px-3 py-2 text-sm text-error">
                    <ul class="list-disc space-y-1 pl-4 text-left">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="mt-6 space-y-4" method="POST" action="{{ route('two-factor.store') }}">
                @csrf
                <label class="block">
                    <span class="text-xs+ font-medium text-slate-600 dark:text-navy-200">Authentication code</span>
                    <input
                        autofocus
                        class="form-input mt-1 w-full rounded-lg border border-slate-300 px-4 py-3 text-center text-lg tracking-[0.4em] placeholder:text-slate-400 focus:border-primary dark:border-navy-500 dark:bg-transparent dark:text-navy-50"
                        name="code"
                        inputmode="numeric"
                        autocomplete="one-time-code"
                        placeholder="123456"
                        value="{{ old('code') }}"
                    />
                </label>

                <div class="text-center text-xs uppercase tracking-wide text-slate-400 dark:text-navy-300">or</div>

                <label class="block">
                    <span class="text-xs+ font-medium text-slate-600 dark:text-navy-200">Recovery code</span>
                    <input
                        class="form-input mt-1 w-full rounded-lg border border-slate-300 px-4 py-3 uppercase placeholder:text-slate-400 focus:border-primary dark:border-navy-500 dark:bg-transparent dark:text-navy-50"
                        name="recovery_code"
                        placeholder="XXXX-XXXX"
                        value="{{ old('recovery_code') }}"
                    />
                    <p class="mt-1 text-xs text-slate-400 dark:text-navy-200">Use when you don’t have access to your authenticator.</p>
                </label>

                <button type="submit" class="btn h-11 w-full rounded-full bg-primary text-base font-semibold text-white hover:bg-primary-focus dark:bg-accent">
                    Verify &amp; Continue
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="mt-4 text-center">
                @csrf
                <button type="submit" class="text-xs font-medium text-slate-500 underline hover:text-primary dark:text-navy-200">
                    Cancel and return to login
                </button>
            </form>
        </div>
    </div>
</x-base-layout>

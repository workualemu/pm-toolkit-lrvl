<x-base-layout title="Verify Email">
    <div class="min-h-screen flex items-center justify-center bg-slate-100 dark:bg-navy-800 px-4 py-12">
        <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-xl dark:bg-navy-700">
            <div class="flex flex-col items-center">
                <img class="h-16 w-16" src="{{ asset('images/app-logo.png') }}" alt="logo" />
                <h1 class="mt-4 text-2xl font-semibold text-slate-700 dark:text-navy-50">
                    {{ __('Verify your email address') }}
                </h1>
                <p class="mt-2 text-sm text-slate-500 dark:text-navy-200 text-center">
                    {{ __('Thanks for signing up! Before getting started, please verify your email address by clicking the link we just sent you. Didn’t receive the email? We can send another.') }}
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mt-4 rounded-lg border border-success/40 bg-success/10 px-3 py-2 text-sm text-success">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="mt-6 flex flex-col gap-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="btn h-11 w-full rounded-full bg-primary text-base font-semibold text-white hover:bg-primary-focus dark:bg-accent">
                        {{ __('Resend Verification Email') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full rounded-full border border-slate-300 px-4 py-2 text-sm font-medium text-slate-600 hover:border-error hover:text-error dark:border-navy-500 dark:text-navy-100">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-base-layout>

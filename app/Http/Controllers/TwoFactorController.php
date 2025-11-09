<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
    public function show(Request $request)
    {
        if (! $request->session()->has(AuthController::TWO_FACTOR_SESSION_KEY)) {
            return redirect()->route('login');
        }

        $userId = $request->session()->get(AuthController::TWO_FACTOR_SESSION_KEY);
        $user = User::find($userId);

        if (! $user) {
            $this->forgetTwoFactorSession($request);
            return redirect()->route('login');
        }

        return view('auth.two-factor-challenge', compact('user'));
    }

    public function store(Request $request)
    {
        if (! $request->session()->has(AuthController::TWO_FACTOR_SESSION_KEY)) {
            return redirect()->route('login');
        }

        $request->validate([
            'code' => ['nullable', 'string'],
            'recovery_code' => ['nullable', 'string'],
        ]);

        if (! $request->filled('code') && ! $request->filled('recovery_code')) {
            return back()->withErrors(['code' => 'Please enter an authenticator code or a recovery code.']);
        }

        $userId = $request->session()->get(AuthController::TWO_FACTOR_SESSION_KEY);
        $remember = $request->session()->get(AuthController::TWO_FACTOR_REMEMBER_KEY, false);
        $user = User::find($userId);

        if (! $user || ! $user->two_factor_secret) {
            $this->forgetTwoFactorSession($request);
            return redirect()->route('login')->withErrors(['email' => 'Two-factor authentication is not configured for this account.']);
        }

        $authenticated = false;
        $remainingCodes = $user->two_factor_recovery_codes ?? [];

        if ($request->filled('recovery_code')) {
            $inputCode = strtoupper(str_replace([' ', '-'], '', $request->input('recovery_code')));
            $match = collect($remainingCodes)->first(function ($code) use ($inputCode) {
                $normalized = strtoupper(str_replace([' ', '-'], '', $code));
                return hash_equals($normalized, $inputCode);
            });

            if ($match) {
                $authenticated = true;
                $remainingCodes = collect($remainingCodes)
                    ->reject(fn ($code) => $code === $match)
                    ->values()
                    ->toArray();
            }
        }

        if (! $authenticated && $request->filled('code')) {
            $google2fa = new Google2FA();
            $input = preg_replace('/\s+/', '', $request->input('code'));
            $authenticated = $google2fa->verifyKey($user->two_factor_secret, $input, 2);
        }

        if (! $authenticated) {
            return back()->withErrors(['code' => 'The provided authentication code is invalid.'])->withInput($request->only('recovery_code'));
        }

        $user->forceFill([
            'two_factor_recovery_codes' => $remainingCodes,
            'last_login_at' => now(),
        ])->save();

        Auth::login($user, $remember);
        $this->forgetTwoFactorSession($request);

        return redirect()->intended(route('index'));
    }

    protected function forgetTwoFactorSession(Request $request): void
    {
        $request->session()->forget([
            AuthController::TWO_FACTOR_SESSION_KEY,
            AuthController::TWO_FACTOR_REMEMBER_KEY,
        ]);
    }
}

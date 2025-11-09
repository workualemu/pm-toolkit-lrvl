<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\TwoFactorSecretManager;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function __construct(private TwoFactorSecretManager $twoFactorSecretManager)
    {
    }

    public function show()
    {
        /** @var User $user */
        $user = Auth::user();

        $preview = session('two_factor_preview');
        $displaySecret = $preview['secret'] ?? null;
        $qrCodeDataUri = isset($preview['otpauth'])
            ? $this->makeQrCodeDataUri($preview['otpauth'])
            : null;

        return view('pages/set-profile', compact('user', 'qrCodeDataUri', 'displaySecret'));
    }

    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'display_name' => ['nullable', 'string', 'max:255'],
            'full_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone_number' => ['nullable', 'string', 'max:50'],
        ]);

        $user->fill($validated);
        $user->name = $validated['display_name'] ?? $user->name;

        $user->save();

        return back()->with('status', 'profile-updated');
    }

    public function updateAvatar(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($request->boolean('remove_avatar')) {
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $user->forceFill(['profile_photo_path' => null])->save();

            return back()->with('status', 'avatar-removed');
        }

        $request->validate([
            'profile_photo' => ['required', 'image', 'max:2048'],
        ]);

        $path = $request->file('profile_photo')->store('avatars', 'public');

        if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        $user->forceFill(['profile_photo_path' => $path])->save();

        return back()->with('status', 'avatar-updated');
    }

    public function enableTwoFactor(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'method' => ['required', Rule::in(['authenticator', 'sms'])],
            'sms_phone' => ['nullable', 'string', 'max:50', 'required_if:method,sms'],
        ]);

        if ($validated['method'] === 'sms' && $validated['sms_phone']) {
            $user->phone_number = $validated['sms_phone'];
        }

        $plainCodes = $this->generateRecoveryCodes();
        $secret = $validated['method'] === 'authenticator'
            ? $this->twoFactorSecretManager->createTrialSecret($user)
            : null;

        $user->two_factor_enabled = true;
        $user->two_factor_method = $validated['method'];
        $user->two_factor_secret = $secret['secret'] ?? null;
        $user->two_factor_recovery_codes = $this->hashRecoveryCodes($plainCodes);
        $user->save();

        if ($secret) {
            session()->flash('two_factor_preview', $secret);
        }
        session()->flash('recovery_codes_plain', $plainCodes);

        return back()->with('status', 'two-factor-enabled');
    }

    public function disableTwoFactor()
    {
        /** @var User $user */
        $user = Auth::user();

        $user->forceFill([
            'two_factor_enabled' => false,
            'two_factor_method' => null,
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
        ])->save();

        session()->forget('two_factor_preview');

        return back()->with('status', 'two-factor-disabled');
    }

    public function updatePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if (! Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Your current password is incorrect.']);
        }

        $user->forceFill([
            'password' => Hash::make($validated['password']),
        ])->save();

        return back()->with('status', 'password-updated');
    }

    public function regenerateRecoveryCodes()
    {
        /** @var User $user */
        $user = Auth::user();

        if (! $user->two_factor_enabled) {
            return back()->with('error', 'two-factor-not-enabled');
        }

        $plainCodes = $this->generateRecoveryCodes();
        $user->two_factor_recovery_codes = $this->hashRecoveryCodes($plainCodes);
        $user->save();

        session()->flash('recovery_codes_plain', $plainCodes);

        return back()->with('status', 'two-factor-recovery-codes-regenerated');
    }

    protected function generateRecoveryCodes(): array
    {
        return collect(range(1, 8))->map(function () {
            return strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4));
        })->toArray();
    }

    protected function makeQrCodeDataUri(?string $otpauthUrl): ?string
    {
        if (! $otpauthUrl) {
            return null;
        }

        $renderer = new ImageRenderer(
            new RendererStyle(240),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        $svg = $writer->writeString($otpauthUrl);

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    protected function hashRecoveryCodes(array $codes): array
    {
        return collect($codes)->map(function ($code) {
            return Hash::make($this->normalizeRecoveryCode($code));
        })->all();
    }

    protected function normalizeRecoveryCode(string $code): string
    {
        return strtoupper(str_replace([' ', '-'], '', $code));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        /** @var User $user */
        $user = Auth::user();
        $otpauthUrl = $user->two_factor_secret ? $this->makeOtpAuthUrl($user) : null;
        $qrCodeDataUri = $this->makeQrCodeDataUri($otpauthUrl);

        return view('pages/set-profile', compact('user', 'otpauthUrl', 'qrCodeDataUri'));
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

        $user->two_factor_enabled = true;
        $user->two_factor_method = $validated['method'];
        $user->two_factor_secret = $this->generateSecret();
        $user->two_factor_recovery_codes = $this->generateRecoveryCodes();
        $user->save();

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

        return back()->with('status', 'two-factor-disabled');
    }

    public function regenerateRecoveryCodes()
    {
        /** @var User $user */
        $user = Auth::user();

        if (! $user->two_factor_enabled) {
            return back()->with('error', 'two-factor-not-enabled');
        }

        $user->two_factor_recovery_codes = $this->generateRecoveryCodes();
        $user->save();

        return back()->with('status', 'two-factor-recovery-codes-regenerated');
    }

    protected function generateRecoveryCodes(): array
    {
        return collect(range(1, 8))->map(function () {
            return strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4));
        })->toArray();
    }

    protected function generateSecret(int $length = 32): string
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secret = '';

        for ($i = 0; $i < $length; $i++) {
            $secret .= $alphabet[random_int(0, strlen($alphabet) - 1)];
        }

        return $secret;
    }

    protected function makeOtpAuthUrl(User $user): string
    {
        $issuer = urlencode(config('app.name', 'Laravel'));
        $label = urlencode($user->email);

        return "otpauth://totp/{$issuer}:{$label}?secret={$user->two_factor_secret}&issuer={$issuer}";
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
}

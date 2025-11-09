<?php

namespace App\Services;

use App\Models\User;

class TwoFactorSecretManager
{
    public function createTrialSecret(User $user): array
    {
        $secret = $this->generateSecret();

        return [
            'secret' => $secret,
            'otpauth' => $this->makeOtpAuthUrl($user->email, $secret),
        ];
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

    protected function makeOtpAuthUrl(string $email, string $secret): string
    {
        $issuer = urlencode(config('app.name', 'Laravel'));
        $label = urlencode($email);

        return "otpauth://totp/{$issuer}:{$label}?secret={$secret}&issuer={$issuer}";
    }
}

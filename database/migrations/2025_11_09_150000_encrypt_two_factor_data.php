<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')
            ->select('id', 'two_factor_secret', 'two_factor_recovery_codes')
            ->where(function ($query) {
                $query->whereNotNull('two_factor_secret')
                    ->orWhereNotNull('two_factor_recovery_codes');
            })
            ->orderBy('id')
            ->chunkById(100, function ($users) {
                foreach ($users as $user) {
                    $updates = [];

                    if (! empty($user->two_factor_secret) && ! $this->isEncrypted($user->two_factor_secret)) {
                        $updates['two_factor_secret'] = Crypt::encryptString($user->two_factor_secret);
                    }

                    if (! empty($user->two_factor_recovery_codes) && ! $this->isEncrypted($user->two_factor_recovery_codes)) {
                        $decoded = json_decode($user->two_factor_recovery_codes, true);
                        if (! is_array($decoded)) {
                            $decoded = [];
                        }

                        $hashed = collect($decoded)->map(function ($code) {
                            return Hash::make($this->normalizeRecoveryCode($code));
                        })->all();

                        $updates['two_factor_recovery_codes'] = Crypt::encryptString(json_encode($hashed));
                    }

                    if (! empty($updates)) {
                        DB::table('users')->where('id', $user->id)->update($updates);
                    }
                }
            });
    }

    public function down(): void
    {
        // no-op
    }

    protected function isEncrypted(string $value): bool
    {
        try {
            Crypt::decryptString($value);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function normalizeRecoveryCode(string $code): string
    {
        return strtoupper(str_replace([' ', '-'], '', $code));
    }
};

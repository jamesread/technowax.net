<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LegacyPassword
{
    public function verifyAndRehash(User $user, string $plain): bool
    {
        if (Hash::check($plain, $user->password)) {
            return true;
        }

        if ($this->isLegacyHash($user->getRawOriginal('password')) && hash_equals($user->getRawOriginal('password'), sha1($plain))) {
            $user->forceFill(['password' => $plain])->save();

            return true;
        }

        return false;
    }

    private function isLegacyHash(string $hash): bool
    {
        return strlen($hash) === 40 && ctype_xdigit($hash);
    }
}

<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        if (! config('technowax.enable_registration')) {
            throw ValidationException::withMessages([
                'email' => 'Registration is disabled.',
            ]);
        }

        Validator::make($input, [
            'username' => ['required', 'string', 'max:32', 'alpha_dash', Rule::unique(User::class)],
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique(User::class)],
            'password' => $this->passwordRules(),
        ])->validate();

        $defaultGroup = Group::query()->firstOrCreate(['id' => 1], ['title' => 'Users']);

        return User::create([
            'name' => $input['username'],
            'username' => $input['username'],
            'email' => $input['email'] ?? null,
            'password' => $input['password'],
            'group_id' => $defaultGroup->id,
            'registered_at' => now(),
        ]);
    }
}

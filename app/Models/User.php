<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\Contracts\PasskeyUser;
use Laravel\Fortify\PasskeyAuthenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;

#[Fillable(['name', 'username', 'email', 'password', 'group_id', 'last_login', 'registered_at'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable implements PasskeyUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, PasskeyAuthenticatable, TwoFactorAuthenticatable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
            'last_login' => 'datetime',
            'registered_at' => 'datetime',
        ];
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'privileges_u', 'user_id', 'permission_id');
    }

    public function hasPrivilege(string $key): bool
    {
        if ($this->privilegeKeys()->contains($key)) {
            return true;
        }

        return false;
    }

    /**
     * @return Collection<int, string>
     */
    public function privilegeKeys(): Collection
    {
        $userKeys = $this->permissions()->pluck('key');

        if ($this->group_id === null) {
            return $userKeys;
        }

        $groupKeys = DB::table('privileges_g')
            ->join('permissions', 'permissions.id', '=', 'privileges_g.permission_id')
            ->where('privileges_g.group_id', $this->group_id)
            ->pluck('permissions.key');

        return $userKeys->merge($groupKeys)->unique()->values();
    }

    /**
     * @return Collection<int, array{key: string, description: string|null}>
     */
    public function privilegeDetails(): Collection
    {
        $keys = $this->privilegeKeys();

        return Permission::query()
            ->whereIn('key', $keys)
            ->get(['key', 'description'])
            ->map(fn (Permission $permission) => [
                'key' => $permission->key,
                'description' => $permission->description,
            ]);
    }
}

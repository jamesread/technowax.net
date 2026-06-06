<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'key',
        'description',
    ];

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'privileges_g', 'permission_id', 'group_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'privileges_u', 'permission_id', 'user_id');
    }
}

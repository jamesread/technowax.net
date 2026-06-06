<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DynDnsUpdate extends Model
{
    public $timestamps = false;

    protected $table = 'dyndns';

    protected $fillable = [
        'timestamp',
        'ip_address',
        'ident',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'timestamp' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

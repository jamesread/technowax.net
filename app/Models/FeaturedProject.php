<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturedProject extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'slug',
        'name',
        'description',
        'homepage_url',
        'github_url',
        'docs_url',
        'sort_order',
        'imported_at',
    ];

    protected function casts(): array
    {
        return [
            'imported_at' => 'datetime',
        ];
    }
}

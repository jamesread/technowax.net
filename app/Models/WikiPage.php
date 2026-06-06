<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WikiPage extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'alt_title',
        'content',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = [
        'short_url',
        'long_url',
        'ip',
        'user_id',
        'clicks',
        'custom',
        'enabled',
    ];
}

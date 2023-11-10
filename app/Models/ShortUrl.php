<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShortUrl extends Model {
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'long_url',
        'short_url',
        'ip',
    ];
}

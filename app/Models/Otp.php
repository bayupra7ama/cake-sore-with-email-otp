<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Otp extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'expired_at',
        'is_used'
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'is_used' => 'boolean',
    ];
}

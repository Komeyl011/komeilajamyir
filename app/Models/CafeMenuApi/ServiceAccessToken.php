<?php

namespace App\Models\CafeMenuApi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class ServiceAccessToken extends ApiModel
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'token',
        'abilites',
        'last_used_at',
        'expires_at',
    ];
}

<?php

namespace App\Models\CafeMenuApi;

class Notification extends ApiModel
{
    protected $fillable = [
        'user_id',
        'message',
    ];
}

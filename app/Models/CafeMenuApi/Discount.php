<?php

namespace App\Models\CafeMenuApi;

class Discount extends ApiModel
{
    protected $fillable = [
        'code',
        'type',
        'start_date',
        'end_date',
        'max_usage',
    ];
}

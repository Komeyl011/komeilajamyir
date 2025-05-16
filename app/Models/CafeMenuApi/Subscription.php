<?php

namespace App\Models\CafeMenuApi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class Subscription extends ApiModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'start_date',
        'end_date',
        'status',
    ];
}

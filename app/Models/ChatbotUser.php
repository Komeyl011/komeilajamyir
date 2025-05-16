<?php

namespace App\Models;

use App\Enum\YesNo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotUser extends Model
{
    use HasFactory;

    protected $primaryKey = 'chat_id';
    protected $fillable = [
        'chat_id',
        'username',
        'is_bot',
        'is_premium',
        'has_subscription',
        'balance',
        'remaining_requests_count',
    ];

    protected $casts = [
        'is_bot' => YesNo::class,
        'is_premium' => YesNo::class,
        'has_subscription' => YesNo::class,
    ];
}

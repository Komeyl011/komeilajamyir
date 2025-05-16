<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatHistory extends Model
{
    use HasFactory;

    protected $table = 'chat_history';

    protected $fillable = [
        'user_id',
        'content',
        'role',
    ];

    public function user_history()
    {
        $this->belongsTo(ChatbotUser::class, 'user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotsTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'bot_name', 'table_name',
    ];
}

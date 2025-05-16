<?php

namespace App\Models;

use App\Enum\FdTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FdTopic extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'type'];

    protected $casts = [
        'type' => FdTypes::class,
    ];
}

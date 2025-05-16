<?php

namespace App\Models;

use App\Enum\Priority;
use App\Enum\YesNo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactForm extends Model
{
    use HasFactory;

    protected $table = 'contact_form';

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'priority',
        'answered',
    ];

    protected $casts = [
        'answered' => YesNo::class,
        'priority' => Priority::class,
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $table = 'portfolio';
    protected $fillable = ['thumbnail', 'title', 'description', 'slug'];

    public function getTitleTranslatedAttribute()
    {
        return json_decode($this->attributes['title'])->{app()->currentLocale()};
    }

    public function getDescriptionTranslatedAttribute()
    {
        return json_decode($this->attributes['description'])->{app()->currentLocale()};
    }
}

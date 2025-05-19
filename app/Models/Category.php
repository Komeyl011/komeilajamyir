<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = ['name', 'slug'];

    public function getNameTranslatedAttribute()
    {
        return json_decode($this->attributes['name'])->{app()->currentLocale()};
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}

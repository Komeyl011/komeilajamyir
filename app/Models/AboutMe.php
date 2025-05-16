<?php

namespace App\Models;

use App\Enum\YesNo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutMe extends Model
{
    use HasFactory;

    protected $table = 'about_me';
    protected $fillable = [
        'image',
        'description',
        'active',
    ];
    protected $casts = [
        'active' => YesNo::class,
    ];

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->active) {
                static::where('active', '=', true)
                    ->where('id', '!=', $model->id)
                    ->update(['active' => false]);
            }
        });

        static::updating(function ($model) {
            if ($model->active) {
                static::where('active', '=', true)
                    ->where('id', '!=', $model->id)
                    ->update(['active' => false]);
            }
        });
    }

    public function getDescriptionTranslatedAttribute()
    {
        return json_decode($this->attributes['description'])->{app()->currentLocale()};
    }
}

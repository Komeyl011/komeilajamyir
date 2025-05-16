<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = ['job_title', 'company', 'from', 'to', 'description'];

    public function getJobTitleTranslatedAttribute()
    {
        return json_decode($this->attributes['job_title'])->{app()->currentLocale()};
    }

    public function getCompanyTranslatedAttribute()
    {
        return json_decode($this->attributes['company'])->{app()->currentLocale()};
    }

    public function getDescriptionTranslatedAttribute()
    {
        return json_decode($this->attributes['description'])->{app()->currentLocale()};
    }
}

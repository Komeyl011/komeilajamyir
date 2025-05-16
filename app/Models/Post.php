<?php

namespace App\Models;

use App\Enum\PublishStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'category_id',
        'title',
        'seo_title',
        'image',
        'slug',
        'meta_description',
        'meta_keywords',
        'status',
    ];

    protected $casts = [
        'status' => PublishStatus::class,
    ];

    public function getTitleTranslatedAttribute()
    {
        return json_decode($this->attributes['title'])->{app()->currentLocale()};
    }

    public function getSeoTitleTranslatedAttribute()
    {
        return json_decode($this->attributes['seo_title'])->{app()->currentLocale()};
    }

    public function getMetaDescriptionTranslatedAttribute()
    {
        return json_decode($this->attributes['meta_description'])->{app()->currentLocale()};
    }

    public function getMetaKeywordsTranslatedAttribute()
    {
        return json_decode($this->attributes['meta_keywords'])->{app()->currentLocale()};
    }

    public function translations()
    {
        return $this->hasMany(PostTranslation::class, 'post_id');
    }

    public function getTranslation()
    {
        return $this->translations()->where('locale', '=', app()->currentLocale());
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}

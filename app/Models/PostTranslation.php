<?php

namespace App\Models;

use App\Events\PostTranslationUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PostTranslation extends Model
{
    use HasFactory;

    protected $table = 'posts_translations';
    public $timestamps = false;
    protected $fillable = ['post_id', 'locale', 'excerpt', 'body'];

    protected $dispatchesEvents = [
        'updated' => PostTranslationUpdated::class,
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function getReadTimeAttribute()
    {
        $reading_speed = 100;
        $type = $this->post()->first()->category()->first();

        if ($this->locale == 'fa') {
            $reading_speed = $type == 'Technical'
                ? 100
                : 170;
        } elseif ($this->locale == 'en') {
            $reading_speed = $type == 'Technical'
                ? 125
                : 225;
        }

        return (int) ceil(
            (Str::wordCount($this->excerpt . $this->body) / $reading_speed)
        );
    }
}

<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\PostTranslation;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ShowPost extends Component
{
    public $slug;
    public $translations;

    #[Layout('components.layouts.blog')]
    public function render()
    {
        return view('blog.show', [
            'post' => $post = Post::query()->where('slug', '=', $this->slug)->first(),
            'post_translation' => $post->getTranslation()->first(),
        ]);
    }
}

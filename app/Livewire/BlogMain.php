<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class BlogMain extends Component
{
    use WithPagination;

    public $categories;
    public $filter = '';
    public $search = '';

    public function mount()
    {
        $this->categories = Category::all();
    }

    #[Layout('components.layouts.blog')]
    public function render()
    {
        $posts = $this->getPosts();

        return view('blog.main', [
            'posts' => $posts,
        ]);
    }

    private function getPosts(): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        if (empty($this->search)) {
            $posts = empty($this->filter)
                ? Post::query()->where('status', '=', 'PUBLISHED')->cursorPaginate(10)
                : Post::query()->where('status', '=', 'PUBLISHED')->where('category_id', '=' , $this->changeFilter())->cursorPaginate(10);
        } elseif (empty($this->filter)) {
            $posts = Post::query()->where('status', '=', 'PUBLISHED')->get(['id', 'title']);
            $titles = [];
            foreach ($posts as $post) {
                $titles[$post->id] = json_decode($post->title)->{app()->currentLocale()};
            }
            $ids = $this->searchTitles($this->searchPosts(), $titles);

            $posts = Post::query()->whereIn('id', array_keys($ids))->cursorPaginate(10);
        } else {
            $posts = Post::query()->where('status', '=', 'PUBLISHED')->where('category_id', '=' , $this->changeFilter())->get(['id', 'title']);
            $titles = [];
            foreach ($posts as $post) {
                $titles[$post->id] = json_decode($post->title)->{app()->currentLocale()};
            }
            $ids = $this->searchTitles($this->searchPosts(), $titles);

            $posts = Post::query()->whereIn('id', array_keys($ids))->cursorPaginate(10);
        }

        return $posts;
    }

    public function changeFilter()
    {
        if (empty($this->filter)) {
            return $this->filter;
        } else {
            $category_id = Category::query()->where('slug', '=', $this->filter)->first('id');
            return $category_id->id;
        }
    }

    public function searchPosts() : string
    {
        return trim($this->search);
    }

    public function searchTitles($needle, $haystack) : array
    {
        $matches = [];

        foreach ($haystack as $key => $item) {
            if (str_contains(strtolower($item), strtolower($needle))) {
                $matches[$key] = $item;
            }
        }

        return $matches;
    }
}

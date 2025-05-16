<?php

namespace App\Livewire;

use App\Models\AboutMe;
use App\Models\ChatbotUser;
use App\Models\ContactInfo;
use App\Models\Experience;
use App\Models\Portfolio;
use App\Models\Post;
use App\Models\Skill;
use Livewire\Component;

class Main extends Component
{
    public $about;
    public $experiences;
    public $skills;
    public $portfolio;
    public $blog_posts;
    public $contact_info;

    public function mount()
    {
        $this->about = AboutMe::query()->where('active', '=', true)->first();
        $this->experiences = Experience::all();
        $this->skills = Skill::all();
        $this->portfolio = Portfolio::all();
        $this->blog_posts = Post::query()->where('status', '=', 'PUBLISHED')->limit(3)->get();
        $this->contact_info = ContactInfo::all();
    }

    public function render()
    {
        return view('main');
    }
}

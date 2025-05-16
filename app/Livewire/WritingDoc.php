<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class WritingDoc extends Component
{
    #[Layout("components.layouts.blog")]
    public function render()
    {
        return view('wr.show_doc');
    }
}

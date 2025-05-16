<?php

namespace App\Livewire;

use App\Models\FdTopic;
use App\Models\User;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\PersonalAccessToken;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class FreeDiscussion extends Component
{
    use WithPagination;

    public bool $show_table = false;
    
    #[Rule('required')]
    public string $token;
    
    public array $allowed_types = [
        'GAME' => 'Game',
        'DISCUSSION' => 'Discussion',
        'MIXED' => 'Game + Discussion',
    ];
    
    public string $name;
    public string $description;
    public string $type = "GAME";

    public function mount()
    {
        // dd(session()->all());
        if (session('utk') !== null && PersonalAccessToken::findToken(session('utk'))) {
            $this->show_table = true;
        }
    }

    public function auth()
    {
        // $user = User::find(1);
        // $token = $user->createToken('MyApp', ['*'], now()->addYear())->plainTextToken;
        // dd($token);
        $is_token_valid = PersonalAccessToken::findToken($this->token);
        if ($is_token_valid && (!session('utk') || session('utk') !== null)) {
            session()->put("utk", $this->token);
            $this->show_table = true;
        }
    }

    public function add()
    {
        $this->validate(
            [
                'name' => 'required|max:255',
                'description' => 'required',
                'type'=> 'required',
            ]
        );
        // dd($this->only(['name', 'description', 'type']));
        FdTopic::create($this->only(['name', 'description', 'type']));

        session()->flash('success', 'Topic added successfully!');

        // Reset fields
        $this->reset(['name', 'description', 'type']);

        // Reset TinyMCE content
        $this->dispatch('tinymce:reinit');
    }

    public function delete(int $id)
    {
        FdTopic::where('id', $id)->delete();
        
        session()->flash('del_success', 'Topic deleted successfully!');

        $this->dispatch('tinymce:reinit');
    }

    #[Layout("components.layouts.blog")]
    public function render()
    {
        return view('fd.main', [
            'topics' => FdTopic::latest()->paginate(5),
        ]);
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;

class CreatePost extends Component
{

    public $todos = [];

    public $todo = '';

    public function render()
    {
        return view('livewire.create-post');
    }

    public function add()
    {
        $this->todos[] = $this->todo;

        $this->todo = '';
        // $this->reset('todo');
    }
}

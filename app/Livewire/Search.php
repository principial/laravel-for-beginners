<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class Search extends Component
{
    public $searchTerm = '';
    public $results;
    public function render()
    {
        if (strlen($this->searchTerm) == '') {
            $this->results = [];
        } else {
            $this->results = Post::search($this->searchTerm)->get();
        }
        return view('livewire.search');
    }
}

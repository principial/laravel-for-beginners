<?php

namespace App\Livewire;

use Livewire\Component;

class Editpost extends Component
{
    public $post;
    public $title;
    public $body;

    public function mount()
    {
        $this->title = $this->post->title;
        $this->body = $this->post->body;
    }

    public function save()
    {
        $incomingFields = $this->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $this->authorize('update', $this->post);
        $this->post->update($incomingFields);

        session()->flash('success', 'Post successfully updated.');
        return $this->redirect("/post/{$this->post->id}/edit", navigate: true);
    }

    public function render()
    {
        return view('livewire.editpost');
    }
}

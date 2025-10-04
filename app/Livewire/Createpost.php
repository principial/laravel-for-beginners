<?php

namespace App\Livewire;

use App\Mail\NewPostEmail;
use App\Models\Post;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Createpost extends Component
{

    public $title;
    public $body;

    public function create()
    {
        if (!auth()->check()) {
            abort(403, 'You must be logged in to create posts');
        }

        $incomingFields = $this->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        $newPost = Post::create($incomingFields);

        Mail::to(auth()->user()->email)->send(new NewPostEmail(['name' => auth()->user()->username, 'title' => $newPost->title]));

//        dispatch(new SendNewPostEmail(['sendTo' => auth()->user()->email]));

        session()->flash('success', 'New post successfully created.');

        return $this->redirect("/post/{$newPost->id}", navigate:true);
    }

    public function render()
    {
        return view('livewire.createpost');
    }
}

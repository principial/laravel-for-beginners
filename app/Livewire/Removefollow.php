<?php

namespace App\Livewire;

use App\Models\Follow;
use App\Models\User;
use Livewire\Component;

class Removefollow extends Component
{
    public $username;

    public function save()
    {
        if (!auth()->check()) {
            abort(403, 'You must be logged in to follow users');
        }

        $user = User::where('username', $this->username)->first();

        Follow::where([['user_id', '=', auth()->user()->id], ['followed_user_id', $user->id]])->delete();

        session()->flash('success', 'User successfully unfollowed.');
        return $this->redirect("/profile/" . $user->username, navigate: true);
    }
    public function render()
    {
        return view('livewire.removefollow');
    }
}

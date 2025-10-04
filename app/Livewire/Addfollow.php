<?php

namespace App\Livewire;

use App\Models\Follow;
use App\Models\User;
use Livewire\Component;

class Addfollow extends Component
{
    public $username;

    public function save()
    {
        if (!auth()->check()) {
            abort(403, 'You must be logged in to follow users');
        }

        $user = User::where('username', $this->username)->first();

        // You can't follow yourself
        if ($user->id == auth()->user()->id) {
            return back()->with('failure', 'You can\'t follow yourself.');
        }

        // You can't follow someone you already follow'
        $existCheck = Follow::where([['user_id', '=', auth()->user()->id], ['followed_user_id', $user->id]])->count();

        if ($existCheck) {
            return back()->with('failure', 'You are already following this user.');
        }

        $newFollow = new Follow();
        $newFollow->user_id = auth()->user()->id;
        $newFollow->followed_user_id = $user->id;
        $newFollow->save();

        session()->flash('success', 'User successfully followed.');
        return $this->redirect("/profile/" . $user->username, navigate: true);
    }

    public function render()
    {
        return view('livewire.addfollow');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function createFollow(User $user)
    {
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

        // Back with message
        return back()->with('success', 'User successfully followed.');
    }

    public function removeFollow()
    {

    }
}

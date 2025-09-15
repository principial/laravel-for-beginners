<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class UserController extends Controller
{
    public function showAvatarForm()
    {
        return view('avatar-form');
    }

    public function storeAvatar(Request $request)
    {
        $incomingFields = $request->validate([
            'avatar' => 'required|image|max:1000'
        ]);

        $user = auth()->user();
        $filename = 'avatar-' . $user->id . '-' . uniqid() . '.jpg';

        $manager = new ImageManager(new Driver());
        $image = $manager->read($request->file('avatar'));
        $imageData = $image->cover(120, 120)->toJpeg();
        Storage::disk('public')->put("avatars/{$filename}", $imageData);

        $oldAvatar = $user->avatar;

        $user->avatar = $filename;
        $user->save();

        if ($oldAvatar != "default-avatar.jpg") {
            Storage::disk('public')->delete(str_replace("/storage/", "", $oldAvatar));
        }

        return back()->with('success', 'Avatar successfully updated.');
    }

    public function profile(User $user)
    {
        return view('profile-posts', ['avatar' => $user->avatar, 'user' => $user, 'username' => $user->username, 'posts' => $user->posts()->latest()->get(), 'postsCount' => $user->posts()->count()]);
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('success', 'You are now logged out.');
    }

    public function showCorrectHomepage()
    {
        if (auth()->check()) {
            return view('homepage-feed');
        } else {
            return view('homepage');
        }
    }

    public function login(Request $request)
    {
        $incomingFields = $request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required'
        ]);

        if (auth()->attempt(['username' => $incomingFields['loginusername'], 'password' => $incomingFields['loginpassword']])) {
            $request->session()->regenerate();
            return redirect('/')->with('success', 'You have successfully logged in.');
        } else {
            return redirect('/')->with('failure', 'Invalid login.');
        }
    }

    public function register(Request $request)
    {
        $incomingFields = $request->validate([
            'username' => ['required', 'min:3', 'max:20', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'confirmed']
        ]);

        $incomingFields['password'] = bcrypt($incomingFields['password']);

        $user = User::create($incomingFields);
        auth()->login($user);
        return redirect('/')->with('success', 'Thank you for creating an account.');
    }
}

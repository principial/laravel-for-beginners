<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Component;
use Livewire\WithFileUploads;

class Avatarupload extends Component
{
    use WithFileUploads;

    public $avatar;

    public function save()
    {
        if (!auth()->check()) {
            abort(403, 'You must be logged in to follow users');
        }

        $user = auth()->user();
        $filename = 'avatar-' . $user->id . '-' . uniqid() . '.jpg';

        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->avatar);
        $imageData = $image->cover(120, 120)->toJpeg();
        Storage::disk('public')->put("avatars/{$filename}", $imageData);

        $oldAvatar = $user->avatar;

        $user->avatar = $filename;
        $user->save();

        if ($oldAvatar != "default-avatar.jpg") {
            Storage::disk('public')->delete(str_replace("/storage/", "", $oldAvatar));
        }

        session()->flash('success', 'Avatar successfully updated.');
        return $this->redirect('/manage-avatar', navigate: true);
    }
    public function render()
    {
        return view('livewire.avatarupload');
    }
}

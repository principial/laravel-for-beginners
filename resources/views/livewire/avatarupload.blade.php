<form wire:submit="save" action="/manage-avatar" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="avatar">Upload New Avatar (JPEG, PNG, GIF | Max: 1MB)</label>
        <input wire:loading.attr="disabled" wire:target="avatar" wire:model="avatar" type="file" class="form-control-file" id="avatar" name="avatar" required>
        @error('avatar')
        <p class="alert small alert-danger shadow-sm">{{ $message }}</p>
        @enderror
    </div>
    <button wire:loading.attr="disabled" wire:target="avatar" type="submit" class="btn btn-primary">Upload</button>
</form>

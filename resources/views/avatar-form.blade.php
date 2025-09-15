<x-layout>
        <div class="container py-md-5 container--narrow">
            <h2>Manage Avatar</h2>
            <form action="/manage-avatar" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="avatar">Upload New Avatar (JPEG, PNG, GIF | Max: 1MB)</label>
                    <input type="file" class="form-control-file" id="avatar" name="avatar" required>
                    @error('avatar')
                        <p class="alert small alert-danger shadow-sm">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
</x-layout>

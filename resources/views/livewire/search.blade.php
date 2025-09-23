<div>
    <input type="text" wire:model.live="searchTerm">
    @if (count($results) > 0)
        <ul>
            @foreach ($results as $post)
                <li><a href="/post/{{$post->id}}">{{$post->title}}</a></li>
            @endforeach
        </ul>
    @else
        <p>No results found.</p>
    @endif
</div>

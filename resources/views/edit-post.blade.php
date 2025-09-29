<x-layout doctitle="Edit Post: {{$post->title}}">
  <div class="container py-md-5 container--narrow">
      <p><small><strong><a wire:navigate href="/post/{{$post->id}}">&laquo; Back to post permalink</a></strong></small></p>
      <livewire:editpost :post="$post" />
    </div>
</x-layout>

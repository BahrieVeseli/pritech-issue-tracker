@forelse ($comments as $comment)
    @include('comments.partials.item', ['comment' => $comment])
@empty
    <p class="text-sm text-slate-500">No comments yet.</p>
@endforelse

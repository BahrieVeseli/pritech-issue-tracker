<div class="mb-3 rounded border bg-slate-50 p-3">
    <div class="flex items-center justify-between">
        <strong>{{ $comment->author_name }}</strong>
        <span class="text-xs text-slate-500">{{ $comment->created_at->format('Y-m-d H:i') }}</span>
    </div>
    <p class="mt-2 text-sm">{{ $comment->body }}</p>
</div>

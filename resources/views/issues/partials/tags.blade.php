<div class="space-y-4">
    <div class="flex flex-wrap gap-2">
        @forelse ($issue->tags as $tag)
            <span class="inline-flex items-center gap-2 rounded bg-slate-100 px-3 py-1 text-sm">
                {{ $tag->name }}
                <button
                    type="button"
                    class="text-red-600"
                    data-ajax-toggle
                    data-method="DELETE"
                    data-url="{{ route('issues.tags.destroy', [$issue, $tag]) }}"
                    data-target="#issue-tags"
                >x</button>
            </span>
        @empty
            <p class="text-sm text-slate-500">No tags attached.</p>
        @endforelse
    </div>

    @php $availableTags = $tags->whereNotIn('id', $issue->tags->pluck('id')); @endphp
    @if ($availableTags->isNotEmpty())
        <div class="flex flex-col gap-2 sm:flex-row sm:items-stretch">
            <select class="h-12 min-w-0 flex-1 rounded border px-3" id="tag-attach-select">
                @foreach ($availableTags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
            <button
                type="button"
                class="h-12 rounded bg-blue-600 px-4 text-white"
                data-ajax-toggle
                data-method="POST"
                data-url="{{ route('issues.tags.store', [$issue, $availableTags->first()]) }}"
                data-target="#issue-tags"
                onclick="if (!document.getElementById('tag-attach-select').value) return false; this.dataset.url = '/issues/{{ $issue->id }}/tags/' + document.getElementById('tag-attach-select').value"
            >Attach tag</button>
        </div>
    @else
        <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500">
            All available tags are already attached.
        </div>
    @endif
</div>

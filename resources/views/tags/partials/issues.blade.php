<div class="space-y-6">
    <div class="space-y-3">
        @forelse ($tag->issues as $issue)
            <div class="flex flex-col gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="font-semibold text-slate-900">{{ $issue->title }}</p>
                    <p class="text-sm text-slate-500">{{ $issue->project?->name }}</p>
                </div>
                <button
                    type="button"
                    class="rounded border border-red-200 bg-white px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                    data-ajax-toggle
                    data-method="DELETE"
                    data-url="{{ route('tags.issues.destroy', [$tag, $issue]) }}"
                    data-target="#tag-detail-content"
                >
                    Detach
                </button>
            </div>
        @empty
            <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-6 text-sm text-slate-500">
                No issues attached yet.
            </div>
        @endforelse
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-4">
        <label class="mb-2 block text-sm font-medium text-slate-700">Attach this tag to an issue</label>
        @if ($availableIssues->isNotEmpty())
            <div class="flex flex-col gap-3 sm:flex-row sm:items-stretch">
                <select id="tag-issue-attach-select" class="h-12 min-w-0 flex-1 rounded border px-3">
                    @foreach ($availableIssues as $issue)
                        <option value="{{ $issue->id }}">
                            {{ $issue->title }} ({{ $issue->project?->name }})
                        </option>
                    @endforeach
                </select>
                <button
                    type="button"
                    class="h-12 rounded bg-blue-600 px-4 text-white"
                    data-ajax-toggle
                    data-method="POST"
                    data-url="{{ route('tags.issues.store', [$tag, '__ISSUE__']) }}"
                    data-target="#tag-detail-content"
                    onclick="const select = document.getElementById('tag-issue-attach-select'); if (!select?.value) return false; this.dataset.url = '/tags/{{ $tag->id }}/issues/' + select.value"
                >
                    Attach issue
                </button>
            </div>
        @else
            <p class="text-sm text-slate-500">All issues are already attached to this tag.</p>
        @endif
    </div>
</div>

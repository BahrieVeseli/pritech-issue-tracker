<div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <a href="{{ route('tags.index') }}" class="text-sm text-slate-500 hover:text-blue-600">← Back to tags</a>
            <div class="mt-2 flex flex-wrap items-center gap-3">
                <h1 class="text-3xl font-semibold">{{ $tag->name }}</h1>
                <span class="rounded-full px-2.5 py-1 text-xs font-semibold text-slate-700 bg-slate-100">
                    {{ $tag->issues->count() }} attached
                </span>
            </div>
            <p class="mt-2 text-sm text-slate-500">Tag detail and issue associations</p>
        </div>
        <span class="rounded-full px-3 py-1 text-xs font-semibold text-white" style="background-color: {{ $tag->color ?? '#64748b' }}">
            {{ $tag->color ?? 'no color' }}
        </span>
    </div>

    <div>
        <div class="mb-5">
            <h2 class="text-2xl font-semibold">Attached issues</h2>
            <p class="mt-1 text-sm text-slate-500">Detach issues from this tag or attach it to another issue.</p>
        </div>

        <div id="tag-issues-manager">
            @include('tags.partials.issues', ['tag' => $tag, 'availableIssues' => $availableIssues])
        </div>
    </div>
</div>

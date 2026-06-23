<div class="space-y-3">
    <div>
        <h3 class="text-sm font-semibold text-slate-500">Issue</h3>
        <p class="text-base font-medium text-slate-900">{{ $issue->title }}</p>
        <p class="text-xs text-slate-500">{{ $issue->project?->name }}</p>
    </div>
    @include('issues.partials.tags', ['issue' => $issue, 'tags' => $tags])
</div>

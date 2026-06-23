@php($issue = $issue ?? null)
<form method="POST" action="{{ $action }}" class="space-y-4">
    @csrf
    @isset($method)
        @method($method)
    @endisset

    <div>
        <label class="mb-1 block text-sm font-medium">Project</label>
        <select name="project_id" class="w-full rounded border px-3 py-2">
            @foreach ($projects as $project)
                <option value="{{ $project->id }}" @selected(old('project_id', $issue?->project_id) == $project->id)>{{ $project->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium">Title</label>
        <input name="title" value="{{ old('title', $issue?->title) }}" class="w-full rounded border px-3 py-2">
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium">Description</label>
        <textarea name="description" rows="4" class="w-full rounded border px-3 py-2">{{ old('description', $issue?->description) }}</textarea>
    </div>

    <div class="grid gap-4 md:grid-cols-3">
        <div>
            <label class="mb-1 block text-sm font-medium">Status</label>
            <select name="status" class="w-full rounded border px-3 py-2">
                @foreach (['open', 'in_progress', 'closed'] as $status)
                    <option value="{{ $status }}" @selected(old('status', $issue?->status ?? 'open') === $status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Priority</label>
            <select name="priority" class="w-full rounded border px-3 py-2">
                @foreach (['low', 'medium', 'high'] as $priority)
                    <option value="{{ $priority }}" @selected(old('priority', $issue?->priority ?? 'medium') === $priority)>{{ $priority }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Due date</label>
            <input type="date" name="due_date" value="{{ old('due_date', optional($issue?->due_date)->format('Y-m-d')) }}" class="w-full rounded border px-3 py-2">
        </div>
    </div>

    <div>
        <p class="mb-2 text-sm font-medium">Tags</p>
        <div class="grid gap-2 md:grid-cols-3">
            @foreach ($tags as $tag)
                <label class="flex items-center gap-2 rounded border px-3 py-2">
                    <input type="checkbox" name="tag_ids[]" value="{{ $tag->id }}" @checked(collect(old('tag_ids', $issue?->tags?->pluck('id')->all() ?? []))->contains($tag->id))>
                    <span>{{ $tag->name }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div>
        <p class="mb-2 text-sm font-medium">Members</p>
        <div class="grid gap-2 md:grid-cols-3">
            @foreach ($members as $member)
                <label class="flex items-center gap-2 rounded border px-3 py-2">
                    <input type="checkbox" name="member_ids[]" value="{{ $member->id }}" @checked(collect(old('member_ids', $issue?->members?->pluck('id')->all() ?? []))->contains($member->id))>
                    <span>{{ $member->name }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <button class="rounded bg-blue-600 px-4 py-2 text-white">Save issue</button>
</form>

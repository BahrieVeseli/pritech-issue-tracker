@php($project = $project ?? null)
<form method="POST" action="{{ $action }}" class="space-y-4">
    @csrf
    @isset($method)
        @method($method)
    @endisset

    <div>
        <label class="mb-1 block text-sm font-medium">Name</label>
        <input name="name" value="{{ old('name', $project?->name) }}" class="w-full rounded border px-3 py-2">
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium">Description</label>
        <textarea name="description" class="w-full rounded border px-3 py-2" rows="4">{{ old('description', $project?->description) }}</textarea>
    </div>

    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="mb-1 block text-sm font-medium">Start date</label>
            <input type="date" name="start_date" value="{{ old('start_date', optional($project?->start_date)->format('Y-m-d')) }}" class="w-full rounded border px-3 py-2">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Deadline</label>
            <input type="date" name="deadline" value="{{ old('deadline', optional($project?->deadline)->format('Y-m-d')) }}" class="w-full rounded border px-3 py-2">
        </div>
    </div>

    <button class="rounded bg-blue-600 px-4 py-2 text-white">Save project</button>
</form>

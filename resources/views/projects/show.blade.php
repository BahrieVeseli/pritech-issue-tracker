@extends('layouts.app')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-semibold">{{ $project->name }}</h1>
        <p class="mt-2 text-slate-600">{{ $project->description }}</p>
    </div>
    @can('update', $project)
        <div class="flex gap-2">
            <a href="{{ route('projects.edit', $project) }}" class="rounded border px-4 py-2">Edit</a>
            <form method="POST" action="{{ route('projects.destroy', $project) }}" data-confirm-delete data-delete-message="Delete this project? This action cannot be undone.">
                @csrf
                @method('DELETE')
                <button class="rounded bg-red-600 px-4 py-2 text-white">Delete</button>
            </form>
        </div>
    @endcan
</div>

<div class="mb-6 rounded bg-white p-4 shadow">
    <div class="grid gap-4 md:grid-cols-3">
        <div><span class="font-medium">Start:</span> {{ optional($project->start_date)->format('Y-m-d') ?? '—' }}</div>
        <div><span class="font-medium">Deadline:</span> {{ optional($project->deadline)->format('Y-m-d') ?? '—' }}</div>
        <div><span class="font-medium">Owner:</span> {{ $project->owner?->name ?? '—' }}</div>
    </div>
</div>

<div class="mb-4 flex items-center justify-between">
    <h2 class="text-xl font-semibold">Issues</h2>
    <a href="{{ route('issues.create', ['project_id' => $project->id]) }}" class="rounded bg-blue-600 px-4 py-2 text-white">New issue</a>
</div>

@include('issues.partials.table', ['issues' => $issues])

<div class="mt-4">{{ $issues->links() }}</div>
@endsection

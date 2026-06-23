@extends('layouts.app')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-semibold">Projects</h1>
        <p class="mt-1 text-sm text-slate-500">Manage timelines, ownership, and related issues.</p>
    </div>
    <a href="{{ route('projects.create') }}" class="rounded bg-blue-600 px-4 py-2 text-white">New project</a>
</div>

<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <table class="min-w-full text-left text-sm">
        <thead class="bg-slate-100">
            <tr>
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Owner</th>
                <th class="px-4 py-3">Issues</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($projects as $project)
                <tr class="border-t">
                    <td class="px-4 py-3 font-medium">{{ $project->name }}</td>
                    <td class="px-4 py-3">{{ $project->owner?->name ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $project->issues_count }}</td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('projects.show', $project) }}" class="text-blue-600">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-slate-500">No projects yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $projects->links() }}</div>
@endsection

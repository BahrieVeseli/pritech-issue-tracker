@extends('layouts.app')

@section('content')
<div class="mb-6 flex items-start justify-between gap-4">
    <div>
        <h1 class="text-3xl font-semibold">{{ $issue->title }}</h1>
        <p class="mt-2 text-slate-600">{{ $issue->description }}</p>
        <p class="mt-3 text-sm text-slate-500">Project: <a class="text-blue-600" href="{{ route('projects.show', $issue->project) }}">{{ $issue->project->name }}</a></p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('issues.edit', $issue) }}" class="rounded border px-4 py-2">Edit</a>
        <form method="POST" action="{{ route('issues.destroy', $issue) }}" data-confirm-delete data-delete-message="Delete this issue? This action cannot be undone.">
            @csrf
            @method('DELETE')
            <button class="rounded bg-red-600 px-4 py-2 text-white">Delete</button>
        </form>
    </div>
</div>

<div class="grid gap-6 lg:grid-cols-2">
    <div class="rounded bg-white p-4 shadow">
        <h2 class="mb-3 text-xl font-semibold">Tags</h2>
        <div id="issue-tags">
            @include('issues.partials.tags', ['issue' => $issue, 'tags' => $tags])
        </div>
    </div>

    <div class="rounded bg-white p-4 shadow">
        <h2 class="mb-3 text-xl font-semibold">Members</h2>
        <div id="issue-members">
            @include('issues.partials.members', ['issue' => $issue, 'members' => $members])
        </div>
    </div>
</div>

<div class="mt-6 rounded bg-white p-4 shadow"
     data-comments-url="{{ route('issues.comments.index', $issue) }}"
     data-comment-store-url="{{ route('issues.comments.store', $issue) }}">
    <h2 class="mb-3 text-xl font-semibold">Comments</h2>
    <div data-comment-errors class="mb-3"></div>
    <form data-comment-form class="space-y-3">
        @csrf
        <input name="author_name" value="{{ auth()->user()->name }}" placeholder="Your name" class="w-full rounded border px-3 py-2">
        <input name="body" placeholder="Write a comment..." class="w-full rounded border px-3 py-2">
        <button class="rounded bg-blue-600 px-4 py-2 text-white">Add comment</button>
    </form>

    <div class="mt-6" data-comments-list></div>
    <button type="button" hidden data-comments-load-more class="mt-4 rounded border px-4 py-2">Load more</button>
</div>
@endsection

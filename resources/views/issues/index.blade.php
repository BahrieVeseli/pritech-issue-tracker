@extends('layouts.app')

@section('content')
<div data-issue-search-url="{{ route('issues.search') }}">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Issues</h1>
        <a href="{{ route('issues.create') }}" class="rounded bg-blue-600 px-4 py-2 text-white">New issue</a>
    </div>

    <form
        method="GET"
        action="{{ route('issues.index') }}"
        class="mb-6 grid gap-4 rounded bg-white p-4 shadow md:grid-cols-4"
        data-issue-filter-form
    >
        <input
            id="issue-search"
            name="search"
            type="text"
            value="{{ request('search') }}"
            placeholder="Search issues..."
            class="rounded border px-3 py-2"
        >
        <select id="issue-status" name="status" class="rounded border px-3 py-2">
            <option value="">All statuses</option>
            @foreach (['open', 'in_progress', 'closed'] as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
            @endforeach
        </select>
        <select id="issue-priority" name="priority" class="rounded border px-3 py-2">
            <option value="">All priorities</option>
            @foreach (['low', 'medium', 'high'] as $priority)
                <option value="{{ $priority }}" @selected(request('priority') === $priority)>{{ $priority }}</option>
            @endforeach
        </select>
        <select id="issue-tag" name="tag" class="rounded border px-3 py-2">
            <option value="">All tags</option>
            @foreach ($tags as $tag)
                <option value="{{ $tag->id }}" @selected(request('tag') == $tag->id)>{{ $tag->name }}</option>
            @endforeach
        </select>
    </form>

    <div data-issues-results>
        @include('issues.partials.results', ['issues' => $issues])
    </div>
</div>
@endsection

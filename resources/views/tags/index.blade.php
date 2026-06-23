@extends('layouts.app')

@section('content')
<div class="grid gap-6 lg:grid-cols-3">
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h1 class="mb-6 text-2xl font-semibold">Tags</h1>

        <div class="space-y-6">
            <section>
                <h2 class="mb-4 text-lg font-semibold">Create tag</h2>
                <form method="POST" action="{{ route('tags.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="mb-1 block text-sm font-medium">Name</label>
                        <input name="name" value="{{ old('name') }}" class="w-full rounded border px-3 py-2">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium">Color</label>
                        <input name="color" value="{{ old('color') }}" class="w-full rounded border px-3 py-2">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium">Attach to issue (optional)</label>
                        <select name="issue_id" class="w-full rounded border px-3 py-2">
                            <option value="">No issue selected</option>
                            @foreach ($issues as $issue)
                                <option value="{{ $issue->id }}" @selected((string) old('issue_id', request('issue_id')) === (string) $issue->id)>
                                    {{ $issue->title }} ({{ $issue->project?->name }})
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-slate-500">Leave this empty if you only want to create the tag.</p>
                    </div>
                    <button class="rounded bg-blue-600 px-4 py-2 text-white">Save tag</button>
                </form>
            </section>
        </div>
    </div>

    <div class="lg:col-span-2 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-slate-100">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Color</th>
                    <th class="px-4 py-3">Issues</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tags as $tag)
                    <tr class="border-t">
                        <td class="px-4 py-3 font-medium">
                            <a href="{{ route('tags.show', $tag) }}" class="hover:text-blue-600">{{ $tag->name }}</a>
                        </td>
                        <td class="px-4 py-3">{{ $tag->color ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $tag->issues_count }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('tags.show', $tag) }}" class="text-blue-600 hover:underline">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-slate-500">No tags yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">{{ $tags->links() }}</div>
@endsection

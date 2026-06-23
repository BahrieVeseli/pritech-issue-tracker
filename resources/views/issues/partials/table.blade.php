<div class="overflow-hidden rounded bg-white shadow">
    <table class="min-w-full text-left text-sm">
        <thead class="bg-slate-100">
            <tr>
                <th class="px-4 py-3">Title</th>
                <th class="px-4 py-3">Project</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Priority</th>
                <th class="px-4 py-3">Tags</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($issues as $issue)
                <tr class="border-t">
                    <td class="px-4 py-3 font-medium">{{ $issue->title }}</td>
                    <td class="px-4 py-3">{{ $issue->project?->name }}</td>
                    <td class="px-4 py-3">{{ $issue->status }}</td>
                    <td class="px-4 py-3">{{ $issue->priority }}</td>
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-2">
                            @foreach ($issue->tags as $tag)
                                <span class="rounded bg-slate-100 px-2 py-1 text-xs">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('issues.show', $issue) }}" class="text-blue-600">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-slate-500">No issues found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

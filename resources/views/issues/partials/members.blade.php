<div class="space-y-4">
    <div class="flex flex-wrap gap-2">
        @forelse ($issue->members as $member)
            <span class="inline-flex items-center gap-2 rounded bg-slate-100 px-3 py-1 text-sm">
                {{ $member->name }}
                @can('update', $issue->project)
                    <button
                        type="button"
                        class="text-red-600"
                        data-ajax-toggle
                        data-method="DELETE"
                        data-url="{{ route('issues.members.destroy', [$issue, $member]) }}"
                        data-target="#issue-members"
                    >x</button>
                @endcan
            </span>
        @empty
            <p class="text-sm text-slate-500">No members assigned.</p>
        @endforelse
    </div>

    @can('update', $issue->project)
        @php $availableMembers = $members->whereNotIn('id', $issue->members->pluck('id')); @endphp
        @if ($availableMembers->isNotEmpty())
            <div class="flex flex-col gap-2 sm:flex-row sm:items-stretch">
                <select class="h-12 min-w-0 flex-1 rounded border px-3" id="member-attach-select">
                    @foreach ($availableMembers as $member)
                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                    @endforeach
                </select>
                <button
                    type="button"
                    class="h-12 rounded bg-blue-600 px-4 text-white"
                    data-ajax-toggle
                    data-method="POST"
                    data-url="{{ route('issues.members.store', [$issue, $availableMembers->first()]) }}"
                    data-target="#issue-members"
                    onclick="if (!document.getElementById('member-attach-select').value) return false; this.dataset.url = '/issues/{{ $issue->id }}/members/' + document.getElementById('member-attach-select').value"
                >Attach member</button>
            </div>
        @else
            <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500">
                All available members are already assigned.
            </div>
        @endif
    @else
        <p class="text-sm text-slate-500">Only the project owner can manage members.</p>
    @endcan
</div>

<div class="space-y-4">
    @include('issues.partials.table', ['issues' => $issues])
    <div>{{ $issues->links() }}</div>
</div>

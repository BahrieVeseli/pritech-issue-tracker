@extends('layouts.app')

@section('content')
<div id="tag-detail-content">
    @include('tags.partials.detail', [
        'tag' => $tag,
        'availableIssues' => $availableIssues,
    ])
</div>
@endsection

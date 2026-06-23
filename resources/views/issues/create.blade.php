@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-4xl rounded bg-white p-6 shadow">
    <h1 class="mb-6 text-2xl font-semibold">Create issue</h1>
    @include('issues.form', ['action' => route('issues.store')])
</div>
@endsection

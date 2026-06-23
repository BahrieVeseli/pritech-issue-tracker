@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl rounded bg-white p-6 shadow">
    <h1 class="mb-6 text-2xl font-semibold">Create project</h1>
    @include('projects.form', ['action' => route('projects.store')])
</div>
@endsection

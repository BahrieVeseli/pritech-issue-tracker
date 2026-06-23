@extends('auth.layout')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-semibold">Create account</h1>
        <p class="mt-2 text-sm text-slate-500">Register to start tracking projects, issues, and tags.</p>
    </div>

    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4" autocomplete="off">
        @csrf
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Username</label>
            <input name="name" value="{{ old('name') }}" required autocomplete="name" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-600">
        </div>
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Email</label>
            <input name="email" value="{{ old('email') }}" type="email" required autocomplete="username" autocapitalize="off" spellcheck="false" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-600">
        </div>
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Password</label>
            <input name="password" type="password" required autocomplete="new-password" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-600">
        </div>
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Confirm password</label>
            <input name="password_confirmation" type="password" required autocomplete="new-password" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-600">
        </div>
        <button class="w-full rounded-xl bg-blue-600 px-4 py-3 font-medium text-white transition hover:bg-blue-700">Register</button>
    </form>

    <p class="text-center text-sm text-slate-500">
        Already have an account?
        <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:underline">Login</a>
    </p>
</div>
@endsection

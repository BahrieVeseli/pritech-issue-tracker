@extends('auth.layout')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-semibold">Welcome back</h1>
        <p class="mt-2 text-sm text-slate-500">Sign in to continue managing projects and issues.</p>
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

    <form method="POST" action="{{ route('login') }}" class="space-y-4" autocomplete="off">
        @csrf
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Email</label>
            <input name="identifier" value="{{ old('identifier') }}" type="email" required autofocus autocomplete="off" autocapitalize="off" spellcheck="false" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-600">
        </div>
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Password</label>
            <input name="password" type="password" required autocomplete="off" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-600">
        </div>
        <button class="w-full rounded-xl bg-blue-600 px-4 py-3 font-medium text-white transition hover:bg-blue-700">Login</button>
    </form>

    <p class="text-center text-sm text-slate-500">
        Don’t have an account?
        <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:underline">Register</a>
    </p>
    <p class="text-center text-xs text-slate-400">Use the email and password you created during registration.</p>
</div>
@endsection

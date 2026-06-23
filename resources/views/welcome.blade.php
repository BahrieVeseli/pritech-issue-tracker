<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Issue Tracker') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="mx-auto flex min-h-screen max-w-4xl items-center px-4 py-10">
        <div class="grid w-full gap-6 rounded-3xl border border-slate-200 bg-white p-8 shadow-sm md:grid-cols-[1.15fr_0.85fr]">
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-slate-500">PRITECH</p>
                <h1 class="mt-4 text-4xl font-bold">Mini Issue Tracker</h1>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('projects.index') }}" class="rounded-xl bg-blue-600 px-5 py-3 font-medium text-white">Open app</a>
                    <a href="{{ route('login') }}" class="rounded-xl border border-slate-300 px-5 py-3 font-medium">Login</a>
                    <a href="{{ route('register') }}" class="rounded-xl border border-slate-300 px-5 py-3 font-medium">Register</a>
                </div>
            </div>
            <div class="rounded-2xl bg-slate-50 p-6">
                <h2 class="text-lg font-semibold">Welcome</h2>
            </div>
        </div>
    </div>
</body>
</html>

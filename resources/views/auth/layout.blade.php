<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Issue Tracker') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="min-h-screen">
        <div class="grid min-h-screen w-full lg:grid-cols-[1.15fr_0.85fr]">
            <div class="flex items-center bg-gradient-to-br from-slate-800 via-slate-700 to-blue-800 px-6 py-10 text-white sm:px-10 lg:px-16">
                <div class="max-w-2xl">
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-300">PRITECH</p>
                    <h1 class="mt-4 text-4xl font-bold leading-tight sm:text-5xl">Mini Issue Tracker</h1>
                    <div class="mt-8 flex flex-wrap gap-3 text-sm">
                        <span class="rounded-full border border-white/15 bg-white/10 px-3 py-1">Projects</span>
                        <span class="rounded-full border border-white/15 bg-white/10 px-3 py-1">Issues</span>
                        <span class="rounded-full border border-white/15 bg-white/10 px-3 py-1">Tags</span>
                        <span class="rounded-full border border-white/15 bg-white/10 px-3 py-1">Comments</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center bg-white px-6 py-10 sm:px-10 lg:px-16">
                <div class="w-full">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>
</html>

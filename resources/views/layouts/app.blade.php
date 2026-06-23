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
        <header class="border-b border-slate-200 bg-white/95 backdrop-blur">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4">
                <div class="flex flex-col">
                    <div class="font-semibold text-lg">PRITECH Issue Tracker</div>
                    @auth
                        <div class="text-xs text-slate-500">Logged in as <span class="font-medium text-slate-700">{{ auth()->user()->name }}</span></div>
                    @endauth
                </div>
                <nav class="flex items-center gap-4 text-sm">
                    <a href="{{ route('projects.index') }}" class="rounded px-3 py-2 hover:bg-slate-100 hover:text-blue-600">Projects</a>
                    <a href="{{ route('issues.index') }}" class="rounded px-3 py-2 hover:bg-slate-100 hover:text-blue-600">Issues</a>
                    <a href="{{ route('tags.index') }}" class="rounded px-3 py-2 hover:bg-slate-100 hover:text-blue-600">Tags</a>
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="rounded bg-slate-900 px-4 py-2 text-white transition hover:bg-slate-700">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="rounded px-3 py-2 hover:bg-slate-100 hover:text-blue-600">Login</a>
                        <a href="{{ route('register') }}" class="rounded px-3 py-2 hover:bg-slate-100 hover:text-blue-600">Register</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-8">
            @include('partials.flash')
            @yield('content')
        </main>
    </div>

    <div
        id="delete-confirm-modal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/15 px-4"
        aria-hidden="true"
    >
        <div class="w-full max-w-md rounded-xl border border-slate-200 bg-white px-5 py-8 shadow-[0_18px_50px_rgba(15,23,42,0.16)] sm:px-8 sm:py-9">
            <div class="flex flex-col items-center text-center">
                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-amber-100 text-amber-600">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 9v4"></path>
                        <path d="M12 17h.01"></path>
                        <path d="M10.29 4.86 2.82 18a2 2 0 0 0 1.73 3h14.9a2 2 0 0 0 1.73-3L13.71 4.86a2 2 0 0 0-3.42 0Z"></path>
                    </svg>
                </div>

                <p class="mt-6 text-xs font-semibold uppercase tracking-[0.45em] text-slate-400">PRITECH</p>
                <p class="mt-3 text-2xl font-semibold tracking-tight text-slate-900 sm:text-3xl" data-delete-modal-title>
                    Delete item?
                </p>
                <p class="mt-4 max-w-sm text-sm leading-7 text-slate-600" data-delete-modal-message>
                    Are you sure you want to delete this item?
                </p>

                <div class="mt-8 flex items-center justify-center gap-3">
                    <button
                        type="button"
                        class="inline-flex min-w-[112px] items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                        data-delete-modal-cancel
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="inline-flex min-w-[112px] items-center justify-center rounded-lg bg-blue-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-blue-700"
                        data-delete-modal-confirm
                    >
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

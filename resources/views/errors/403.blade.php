<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Unauthorized</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="flex min-h-screen items-center justify-center px-4 py-10">
        <div class="w-full max-w-[560px] rounded-[28px] border border-slate-200 bg-white px-6 py-10 text-center shadow-[0_18px_50px_rgba(15,23,42,0.14)]">
            <div class="flex justify-center">
                <div class="flex h-20 w-20 items-center justify-center rounded-full bg-amber-100 text-amber-600">
                    <svg viewBox="0 0 24 24" class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 9v4"></path>
                        <path d="M12 17h.01"></path>
                        <path d="M10.29 4.86 2.82 18a2 2 0 0 0 1.73 3h14.9a2 2 0 0 0 1.73-3L13.71 4.86a2 2 0 0 0-3.42 0Z"></path>
                    </svg>
                </div>
            </div>

            <p class="mt-8 text-sm font-semibold uppercase tracking-[0.45em] text-slate-400">PRITECH</p>
            <h1 class="mt-4 text-4xl font-semibold tracking-tight text-slate-900">Unauthorized</h1>
            <p class="mt-5 text-base leading-8 text-slate-600">
                You do not have permission to perform this action.
            </p>

            <div class="mt-10">
                <button
                    type="button"
                    onclick="history.back()"
                    class="inline-flex min-w-[160px] items-center justify-center rounded-2xl bg-blue-600 px-8 py-3.5 text-base font-medium text-white transition hover:bg-blue-700"
                >
                    OK
                </button>
            </div>
        </div>
    </div>
</body>
</html>

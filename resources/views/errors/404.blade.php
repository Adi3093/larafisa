<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <div class="flex flex-col items-center justify-center min-h-[75vh] text-center px-4">

        <div class="text-indigo-300 mb-6 animate-pulse">
            <svg class="size-32 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>

        <h1 class="text-5xl font-extrabold text-gray-900 mb-3 tracking-tight">404</h1>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Halaman Tidak Ditemukan</h2>

        <p class="text-gray-500 mb-8 max-w-md mx-auto">
            Fitur sedang bermasalah atau masih dalam tahap pengembangan. Silakan gunakan menu di samping untuk
            melanjutkan pekerjaan Anda.
        </p>

        <button onclick="window.history.back()"
            class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-indigo-700 transition shadow-sm flex items-center gap-2">
            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Halaman Sebelumnya
        </button>

    </div>
</body>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Akun - Fisa Hotel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 font-sans antialiased text-gray-900 flex min-h-screen">

    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12">
        <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl lg:shadow-none lg:p-0 lg:bg-transparent">
            <div class="mb-8 text-center lg:text-left">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang Kembali</h2>
                <p class="text-gray-500 text-sm">Silakan masuk untuk mengelola reservasi kamar Anda.</p>
            </div>
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                    <ul class="list-disc pl-5 text-sm text-red-700 font-medium">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="login" class="block text-sm font-bold text-gray-700 mb-1">Username atau Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input id="login" type="text" name="login" value="{{ old('login') }}" required
                            autofocus placeholder="Ketik username atau email..."
                            class="pl-10 w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition shadow-sm text-sm">
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label for="password" class="block text-sm font-bold text-gray-700">Password</label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input id="password" type="password" name="password" required placeholder="••••••••"
                            class="pl-10 w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition shadow-sm text-sm">
                    </div>
                </div>
                <button type="submit"
                    class="w-full bg-amber-600 text-white font-bold rounded-xl py-3.5 hover:bg-amber-700 focus:ring-4 focus:ring-indigo-200 transition shadow-lg transform hover:-translate-y-0.5 mt-2">
                    Masuk Sekarang
                </button>
            </form>

            <div class="mt-8 text-center text-sm text-gray-600">
                Belum memiliki akun tamu?
                <a href="{{ route('register') }}"
                    class="font-bold text-amber-600 hover:text-amber-800 hover:underline transition">Daftar di
                    sini</a>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ url('/') }}"
                    class="text-xs text-gray-400 hover:text-gray-600 flex items-center justify-center gap-1">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <div class="hidden lg:block lg:w-1/2 bg-amber-900 relative">
        <div class="absolute inset-0 bg-amber-100 z-10">

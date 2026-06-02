<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Tamu - Fisa Hotel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 font-sans antialiased text-gray-900 flex min-h-screen">

    <div class="hidden lg:block lg:w-1/2 bg-indigo-900 relative">
        <div class="absolute inset-0 bg-indigo-600 z-10"></div>
        <img src="https://images.unsplash.com/photo-1542314831-c6a4d14d8373?q=80&w=2070&auto=format&fit=crop"
            alt="Hotel Lobby" class="absolute inset-0 w-full h-full object-cover z-0">

        <div class="absolute inset-0 z-20 flex flex-col justify-center px-16 text-white">
            <h1 class="text-5xl font-black mb-4">FISA HOTEL</h1>
            <p class="text-xl font-medium text-indigo-100 max-w-md">Bergabunglah bersama kami dan nikmati kemudahan
                reservasi kamar impian Anda secara online, kapan saja dan di mana saja.</p>
        </div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12">
        <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl lg:shadow-none lg:p-0 lg:bg-transparent">

            <div class="mb-8 text-center lg:text-left">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Daftar Akun Tamu</h2>
                <p class="text-gray-500 text-sm">Lengkapi data diri Anda untuk melanjutkan proses reservasi.</p>
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

            <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required
                            autofocus placeholder="Contoh: Budi Santoso"
                            class="pl-10 w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm text-sm">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            placeholder="budi@example.com"
                            class="pl-10 w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm text-sm">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-1">Password Baru</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input id="password" type="password" name="password" required placeholder="Minimal 8 karakter"
                            class="pl-10 w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm text-sm">
                    </div>
                    <p class="text-xs text-gray-500 mt-2">*Gunakan kombinasi huruf dan angka agar lebih aman.</p>
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 text-white font-bold rounded-xl py-3.5 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 transition shadow-lg transform hover:-translate-y-0.5 mt-4">
                    Buat Akun Sekarang
                </button>
            </form>

            <div class="mt-8 text-center text-sm text-gray-600">
                Sudah memiliki akun?
                <a href="{{ route('login') }}"
                    class="font-bold text-indigo-600 hover:text-indigo-800 hover:underline transition">Masuk di sini</a>
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
</body>

</html>

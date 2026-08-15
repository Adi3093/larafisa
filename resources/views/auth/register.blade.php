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
        <div class="absolute inset-0 bg-amber-100 border-t border-amber-200 z-10"></div>
        <div class="absolute inset-0 z-20 flex flex-col justify-center px-16 text-white">
            <h1 class="text-5xl font-black text-amber-950 mb-4">FISA HOTEL</h1>
            <p class="text-xl font-medium text-amber-950 max-w-md">Bergabunglah bersama kami dan nikmati kemudahan
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
                            class="pl-10 w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition shadow-sm text-sm">
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
                            class="pl-10 w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition shadow-sm text-sm">
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
                            class="pl-10 pr-10 w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition shadow-sm text-sm">
                        <button type="button" onclick="togglePassword('password', 'eye-icon-1')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-amber-600 transition">
                            <svg id="eye-icon-1" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-1">Konfirmasi
                        Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            placeholder="Ulangi password Anda"
                            class="pl-10 pr-10 w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition shadow-sm text-sm">

                        <button type="button" onclick="togglePassword('password_confirmation', 'eye-icon-2')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-amber-600 transition">
                            <svg id="eye-icon-2" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-amber-600 text-white font-bold rounded-xl py-3.5 hover:bg-amber-700 focus:ring-4 focus:ring-indigo-200 transition shadow-lg transform hover:-translate-y-0.5 mt-4">
                    Buat Akun Sekarang
                </button>
            </form>

            <div class="mt-8 text-center text-sm text-gray-600">
                Sudah memiliki akun?
                <a href="{{ route('login') }}"
                    class="font-bold text-amber-600 hover:text-amber-800 hover:underline transition">Masuk di sini</a>
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

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === "password") {
                input.type = "text";
                icon.innerHTML =
                    `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />`;
            } else {
                input.type = "password";
                icon.innerHTML =
                    `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        }
    </script>
</body>

</html>

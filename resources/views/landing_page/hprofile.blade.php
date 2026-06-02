<x-lplayout>

    <div class="absolute top-0 left-0 w-full h-64 bg-indigo-600 z-0 hidden lg:block">
    </div>
    <div class="absolute top-0 left-0 w-full h-48 bg-indigo-600 z-0 lg:hidden"></div>

    <div class="relative z-10 min-h-screen pt-4 pb-24 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">

        <div class="mb-6 mt-2 lg:mt-8">
            <h1 class="text-white text-3xl font-bold tracking-tight">
                @auth
                    Hi, {{ explode(' ', trim(auth()->user()->name))[0] }}
                @else
                    Hi, sobat Fisa
                @endauth
            </h1>
        </div>

        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 p-6 lg:p-8 mb-8">
            @auth
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 mb-2 text-center sm:text-left">
                    <div class="relative shrink-0">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=E0E7FF&color=4338CA&size=120"
                            alt="Foto Profil"
                            class="w-24 h-24 lg:w-28 lg:h-28 rounded-full border-4 border-indigo-50 object-cover shadow-md">
                        <div
                            class="absolute bottom-1 right-1 bg-blue-500 border-2 border-white rounded-full p-1.5 shadow-sm">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 mt-2 lg:mt-4">
                        <h2 class="text-2xl lg:text-3xl font-extrabold text-gray-900 tracking-tight">
                            {{ auth()->user()->name }}</h2>
                        <p class="text-base text-gray-500 font-medium mt-1">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                @if (auth()->user()->role === 'admin')
                    <div class="mt-6 pt-6 border-t border-gray-100 max-w-sm mx-auto sm:mx-0 sm:max-w-none">
                        <a href="{{ route('dashboard') }}"
                            class="block w-full text-center bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold py-3.5 rounded-2xl border border-indigo-100 transition shadow-sm">
                            💻 Masuk Panel Admin Utama
                        </a>
                    </div>
                @endif
            @else
                <div class="flex flex-col sm:flex-row gap-5 items-center sm:items-start mb-8 text-center sm:text-left">
                    <div class="bg-blue-50 p-4 rounded-2xl shrink-0">
                        <span class="text-3xl">🎁</span>
                    </div>
                    <div class="mt-2 sm:mt-1">
                        <h2 class="text-xl lg:text-2xl font-extrabold text-gray-900 leading-tight">Ada banyak keuntungan
                            buatmu!</h2>
                        <p class="text-sm lg:text-base text-gray-500 mt-2 leading-relaxed max-w-xl">Log in atau daftar
                            sekarang untuk menikmati kemudahan reservasi, penawaran khusus, dan melacak riwayat pesanan
                            kamar Anda.</p>
                    </div>
                </div>

                <div class="max-w-md mx-auto sm:mx-0">
                    <a href="{{ route('login') }}"
                        class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold text-lg py-4 rounded-2xl shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5">
                        Log in atau daftar
                    </a>
                </div>
            @endauth
        </div>

        <h3 class="font-bold text-gray-900 mb-4 px-2 text-xl tracking-tight mt-10">Akun & Pengaturan</h3>
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-8">

            @auth
                <a href="#"
                    class="flex items-center justify-between p-5 lg:p-6 border-b border-gray-50 hover:bg-gray-50 transition">
                    <div class="flex items-center gap-5">
                        <div class="bg-indigo-50 p-3 rounded-xl shrink-0">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-base font-bold text-gray-700">Edit Profil</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            @endauth

            <a href="#"
                class="flex items-center justify-between p-5 lg:p-6 hover:bg-gray-50 transition {{ Auth::check() ? 'border-b border-gray-50' : '' }}">
                <div class="flex items-center gap-5">
                    <div class="bg-gray-100 p-3 rounded-xl shrink-0">
                        <svg class="w-6 h-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <span class="text-base font-bold text-gray-700">Pengaturan</span>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>

            @auth
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-between p-5 lg:p-6 hover:bg-red-50 transition text-left group">
                        <div class="flex items-center gap-5">
                            <div class="bg-red-50 group-hover:bg-red-100 p-3 rounded-xl transition shrink-0">
                                <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                            </div>
                            <span class="text-base font-bold text-red-600">Keluar Akun</span>
                        </div>
                    </button>
                </form>
            @endauth

        </div>
    </div>
</x-lplayout>

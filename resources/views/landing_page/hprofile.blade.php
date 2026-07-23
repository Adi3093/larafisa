<x-lplayout>
    <div class="absolute top-0 left-0 w-full h-80 bg-amber-600 z-0 hidden lg:block"></div>
    <div class="absolute top-0 left-0 w-full h-64 bg-amber-600 z-0 lg:hidden"></div>

    <div class="relative z-10 min-h-screen pt-24 lg:pt-32 pb-24 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        @if (session('success'))
            <div
                class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-sm font-bold">{{ session('success') }}</span>
            </div>
        @endif

        <!-- LAYOUT PROFIL ATAS (SESUAI MOCKUP) -->
        <div class="bg-white rounded-3xl shadow-xl shadow-amber-900/10 p-6 lg:p-8 mb-8 border border-amber-100">
            @auth
                <!-- Foto di kiri, Teks di Kanan, Rata Tengah Vertikal -->
                <div class="flex flex-col md:flex-row items-center justify-start gap-6 md:gap-8">
                    <div class="relative shrink-0">
                        @if (auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Foto Profil"
                                class="w-28 h-28 lg:w-32 lg:h-32 rounded-full border-4 border-white object-cover shadow-lg">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=FDE68A&color=92400E&size=120"
                                alt="Foto Profil"
                                class="w-28 h-28 lg:w-32 lg:h-32 rounded-full border-4 border-white object-cover shadow-lg">
                        @endif
                    </div>
                    <div class="text-center md:text-left">
                        <h2 class="text-2xl lg:text-3xl font-extrabold text-amber-950 tracking-tight">
                            {{ auth()->user()->name }}</h2>
                        <p class="text-sm lg:text-base text-amber-800/70 font-bold mt-1.5">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'resepsionis')
                    <div class="mt-8 pt-6 border-t border-amber-100 w-full">
                        <a href="{{ route('dashboard') }}"
                            class="block w-full text-center bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold py-3.5 rounded-2xl border border-amber-200 transition shadow-sm">💻
                            Masuk Panel Admin/Resepsionis</a>
                    </div>
                @endif
            @endauth
        </div>

        <div
            class="bg-white rounded-3xl shadow-sm border border-amber-200 overflow-hidden mb-8 p-3 sm:p-5 flex flex-col gap-3">
            @auth
                <!-- MENU 1: EDIT PROFILE -->
                <a href="{{ route('profil.tamu.edit') }}"
                    class="flex items-center justify-between p-4 rounded-2xl border border-amber-100 hover:border-amber-400 hover:bg-amber-50/50 transition-all duration-300 group shadow-sm">
                    <div class="flex items-center gap-4">
                        <div
                            class="p-2 border border-gray-200 rounded-full group-hover:-translate-y-1 transition-transform duration-300 bg-white">
                            <svg class="w-6 h-6 text-gray-700 group-hover:text-amber-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <span class="text-base font-bold text-amber-950">Edit Profile</span>
                    </div>
                </a>

                <!-- MENU 2: UBAH PASSWORD -->
                <a href="{{ route('profil.tamu.password') }}"
                    class="flex items-center justify-between p-4 rounded-2xl border border-amber-100 hover:border-amber-400 hover:bg-amber-50/50 transition-all duration-300 group shadow-sm">
                    <div class="flex items-center gap-4">
                        <div
                            class="p-2 border border-gray-200 rounded-full group-hover:rotate-12 transition-transform duration-300 bg-white">
                            <svg class="w-6 h-6 text-gray-700 group-hover:text-amber-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <span class="text-base font-bold text-amber-950">Ubah Password</span>
                    </div>
                </a>

                <!-- MENU 3: LOG OUT -->
                <form method="POST" action="{{ route('logout') }}" class="m-0"
                    data-confirm="Yakin mau keluar?|Sesi login Anda akan diakhiri dan harus masuk kembali."
                    data-theme="danger" data-btn="Ya, Keluar Akun">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-between p-4 rounded-2xl border border-amber-100 hover:border-red-400 hover:bg-red-50/50 transition-all duration-300 group shadow-sm text-left">
                        <div class="flex items-center gap-4">
                            <div
                                class="p-2 border border-gray-200 rounded-full group-hover:translate-x-1 transition-transform duration-300 bg-white">
                                <svg class="w-6 h-6 text-gray-700 group-hover:text-red-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                            </div>
                            <span class="text-base font-bold text-amber-950 group-hover:text-red-600 transition-colors">Log
                                out</span>
                        </div>
                    </button>
                </form>
            @endauth
        </div>
    </div>
</x-lplayout>

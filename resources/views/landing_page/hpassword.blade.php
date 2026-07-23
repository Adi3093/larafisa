<x-lplayout>
    <div class="absolute top-0 left-0 w-full h-64 bg-amber-600 z-0"></div>

    <div class="relative z-10 min-h-screen pt-24 lg:pt-32 pb-24 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('profil.tamu') }}"
                class="bg-white/20 hover:bg-white/40 text-white p-2.5 rounded-xl backdrop-blur-sm transition border border-white/30">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-white text-2xl font-bold tracking-tight">Ubah Password</h1>
        </div>

        <div class="bg-white rounded-3xl shadow-xl shadow-amber-900/10 p-6 sm:p-10 border border-amber-100"
            x-data="{ showPass1: false, showPass2: false }">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 text-red-700 rounded-r-lg">
                    <ul class="list-disc pl-5 text-sm font-medium space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- MENGARAH KE RUTE YANG BARU DIBUAT DI WEB.PHP -->
            <form action="{{ route('profil.tamu.update_password') }}" method="POST">
                @csrf @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                    <div>
                        <label class="block text-sm font-bold text-amber-950 mb-2">Password Baru</label>
                        <div class="relative">
                            <input :type="showPass1 ? 'text' : 'password'" name="password" required
                                class="w-full border border-gray-300 rounded-xl shadow-sm focus:border-amber-500 focus:ring-amber-500 p-4 pr-12 bg-white text-gray-900 transition font-medium">
                            <button type="button" @click="showPass1 = !showPass1"
                                class="absolute inset-y-0 right-0 px-4 flex items-center text-gray-500 hover:text-amber-600 focus:outline-none">
                                <svg x-show="!showPass1" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                <svg x-show="showPass1" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.29 3.29m0 0a9.953 9.953 0 015.71-1.581c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-amber-950 mb-2">Konfirmasi Password</label>
                        <div class="relative">
                            <input :type="showPass2 ? 'text' : 'password'" name="password_confirmation" required
                                class="w-full border border-gray-300 rounded-xl shadow-sm focus:border-amber-500 focus:ring-amber-500 p-4 pr-12 bg-white text-gray-900 transition font-medium">
                            <button type="button" @click="showPass2 = !showPass2"
                                class="absolute inset-y-0 right-0 px-4 flex items-center text-gray-500 hover:text-amber-600 focus:outline-none">
                                <svg x-show="!showPass2" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                <svg x-show="showPass2" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.29 3.29m0 0a9.953 9.953 0 015.71-1.581c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 sm:justify-end border-t border-gray-100 pt-6">
                    <a href="{{ route('profil.tamu') }}"
                        class="w-full sm:w-auto px-8 py-3.5 rounded-xl border border-gray-300 bg-white text-gray-800 font-bold hover:bg-gray-50 transition text-center shadow-sm">Batal</a>
                    <button type="submit"
                        class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-amber-600 text-white font-bold hover:bg-amber-700 transition shadow-md shadow-amber-600/30">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</x-lplayout>

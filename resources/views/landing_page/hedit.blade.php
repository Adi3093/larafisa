<x-lplayout>
    <div class="absolute top-0 left-0 w-full h-64 bg-amber-600 z-0"></div>

    <div class="relative z-10 min-h-screen pt-24 lg:pt-32 pb-24 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('profil.tamu') }}"
                class="bg-white/20 hover:bg-white/40 text-white p-2.5 rounded-xl backdrop-blur-sm transition border border-white/30">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-white text-2xl font-bold tracking-tight">Edit Profil Saya</h1>
        </div>

        <div class="bg-white rounded-3xl shadow-xl shadow-amber-900/10 p-6 sm:p-10 border border-amber-100">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 text-red-700 rounded-r-lg">
                    <ul class="list-disc pl-5 text-sm font-medium space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profil.tamu.update') }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="flex flex-col items-center mb-10 border-b border-amber-100 pb-8">
                    <div class="relative group cursor-pointer mb-4">
                        @if ($user->avatar)
                            <img id="preview_img" src="{{ asset('storage/' . $user->avatar) }}" alt="Foto"
                                class="w-32 h-32 rounded-full border-4 border-amber-100 object-cover shadow-md">
                        @else
                            <img id="preview_img"
                                src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=FDE68A&color=92400E&size=128"
                                alt="Foto Default"
                                class="w-32 h-32 rounded-full border-4 border-amber-100 object-cover shadow-md">
                        @endif
                        <label for="avatar"
                            class="absolute inset-0 bg-black/40 rounded-full flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 cursor-pointer">
                            <svg class="w-8 h-8 text-white mb-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-white text-xs font-bold">Ubah Foto</span>
                        </label>
                        <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden"
                            onchange="previewImage(event)">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-bold text-amber-950 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full border border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3 bg-amber-50/30 text-amber-950 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-amber-950 mb-2">Nomor KTP (NIK)</label>
                        <input type="text" name="no_ktp" value="{{ old('no_ktp', $user->no_ktp) }}" maxlength="16"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Masukan no KTP"
                            class="w-full border border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3 bg-amber-50/30 text-amber-950 transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-bold text-amber-950 mb-2">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full border border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3 bg-amber-50/30 text-amber-950 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-amber-950 mb-2">Username Akses</label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" required
                            class="w-full border border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3 bg-amber-50/30 text-amber-950 transition">
                    </div>
                </div>

                <div class="bg-amber-50 rounded-2xl p-5 border border-amber-100 mb-8 mt-8">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                        <h3 class="font-bold text-amber-950">Ganti Kata Sandi</h3>
                    </div>
                    <label class="block text-sm font-bold text-amber-950 mb-2">Password Baru</label>
                    <input type="password" name="password"
                        placeholder="Biarkan kosong jika tidak ingin mengubah password"
                        class="w-full border border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3 bg-white text-amber-950 transition">
                    <p class="text-xs text-amber-800/60 font-medium mt-2">Sandi lama Anda akan
                        otomatis terganti.</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 sm:justify-end border-t border-amber-100 pt-6">
                    <a href="{{ route('profil.tamu') }}"
                        class="w-full sm:w-auto px-6 py-3 rounded-xl border border-amber-200 bg-white text-amber-900 font-bold hover:bg-amber-50 transition text-center shadow-sm">Batal</a>
                    <button type="submit"
                        class="w-full sm:w-auto px-8 py-3 rounded-xl bg-amber-600 text-white font-bold hover:bg-amber-700 transition shadow-md shadow-amber-600/30 transform hover:-translate-y-0.5">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview_img').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-lplayout>

<x-dblayout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-amber-950 tracking-tight">Pengaturan Sistem</h1>
        <p class="text-sm text-amber-900/70 mt-1">Kelola data personal akun dan preferensi sistem administrator.</p>
    </div>

    @if (session('success'))
        <div
            class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm">
            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm">
            <div class="flex items-center gap-2 font-bold mb-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Terjadi Kesalahan:
            </div>
            <ul class="list-disc list-inside text-sm ml-7">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex items-end pl-0 sm:pl-2 flex-wrap gap-y-2">
        <button type="button" onclick="switchTab('profil')" id="tab-btn-profil"
            class="px-5 sm:px-6 py-3 bg-white border border-amber-200 border-b-white rounded-t-xl font-bold text-amber-700 text-xs sm:text-sm relative z-10 -mb-[1px] shadow-sm shadow-white transition">
            Profil Saya
        </button>
        <button type="button" onclick="switchTab('umum')" id="tab-btn-umum"
            class="px-5 sm:px-6 py-2.5 bg-amber-50 border border-amber-200 rounded-t-xl font-bold text-amber-800/60 hover:text-amber-700 hover:bg-amber-100 text-xs sm:text-sm transition relative z-0 ml-1">
            Pengaturan Umum
        </button>
        <button type="button" onclick="switchTab('jadwal')" id="tab-btn-jadwal"
            class="px-5 sm:px-6 py-2.5 bg-amber-50 border border-amber-200 rounded-t-xl font-bold text-amber-800/60 hover:text-amber-700 hover:bg-amber-100 text-xs sm:text-sm transition relative z-0 ml-1">
            Penjadwalan
        </button>
    </div>

    <div
        class="bg-white border border-amber-200 rounded-b-2xl rounded-tr-2xl rounded-tl-none shadow-sm p-6 lg:p-8 mb-6 relative z-0">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            <form id="section-profil" action="{{ route('settings.profil.update') }}" method="POST"
                enctype="multipart/form-data" class="lg:col-span-2 block">
                @csrf @method('PUT')
                <h3 class="text-xl font-bold text-amber-950 mb-6 border-b border-amber-100 pb-3">Informasi Pribadi</h3>

                <div class="mb-8 flex flex-col items-center" onmouseover="showTooltip('avatar')"
                    onfocusin="showTooltip('avatar')">
                    <label
                        class="block text-xs font-bold text-amber-800/70 uppercase tracking-wider mb-3 text-center">Foto
                        Profil</label>
                    <div class="relative group cursor-pointer inline-block"
                        onclick="document.getElementById('avatar_input').click()">
                        @if (Auth::user()->avatar)
                            <img id="avatar_preview" src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                alt="Foto Profil"
                                class="w-24 h-24 rounded-full object-cover border-4 border-amber-50 group-hover:border-amber-300 transition shadow-sm">
                        @else
                            <div id="avatar_preview_alt"
                                class="w-24 h-24 rounded-full bg-amber-100 border-4 border-white flex items-center justify-center text-amber-600 font-bold text-3xl group-hover:border-amber-300 transition shadow-sm">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                        <div
                            class="absolute inset-0 bg-black/50 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                            <span
                                class="text-white text-[10px] font-bold text-center px-2 leading-tight">Ubah<br>Foto</span>
                        </div>
                    </div>
                    <input type="file" id="avatar_input" name="avatar" class="hidden"
                        accept="image/jpeg, image/png, image/jpg" onchange="previewImage(event)">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-xs font-bold text-amber-800/70 uppercase tracking-wider mb-2">Nama
                            Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                            onfocus="showTooltip('nama')"
                            class="w-full border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-amber-200 p-2.5 text-sm bg-white text-amber-950 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-amber-800/70 uppercase tracking-wider mb-2">Username
                            Akses</label>
                        <input type="text" name="username" value="{{ old('username', Auth::user()->username) }}"
                            onfocus="showTooltip('username')"
                            class="w-full border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-amber-200 p-2.5 text-sm bg-white text-amber-950 transition">
                    </div>
                </div>

                <div class="mb-8 pb-8 border-b border-amber-100">
                    <label class="block text-xs font-bold text-amber-800/70 uppercase tracking-wider mb-2">Alamat Email
                        Aktif</label>
                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                        onfocus="showTooltip('email')"
                        class="w-full border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-amber-200 p-2.5 text-sm bg-white text-amber-950 transition">
                </div>

                <h3 class="text-xl font-bold text-amber-950 mb-6 border-b border-amber-100 pb-3">Perbarui Keamanan Sandi
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-xs font-bold text-amber-800/70 uppercase tracking-wider mb-2">Sandi
                            Baru</label>
                        <div class="relative">
                            <input type="password" name="password" id="pass1" onfocus="showTooltip('password')"
                                placeholder="Abaikan jika tak diubah"
                                class="w-full border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-amber-200 p-2.5 text-sm bg-white text-amber-950 transition pr-10">
                            <button type="button" onclick="peekPassword('pass1')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-amber-600 hover:text-amber-800 focus:outline-none">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-bold text-amber-800/70 uppercase tracking-wider mb-2">Konfirmasi
                            Sandi Baru</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="pass2"
                                onfocus="showTooltip('password')" placeholder="Ketik ulang sandi baru"
                                class="w-full border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-amber-200 p-2.5 text-sm bg-white text-amber-950 transition pr-10">
                            <button type="button" onclick="peekPassword('pass2')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-amber-600 hover:text-amber-800 focus:outline-none">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end pt-5 border-t border-amber-100">
                    <button type="submit"
                        class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2.5 px-8 rounded-xl transition shadow-md shadow-amber-600/30">Simpan
                        Perubahan</button>
                </div>
            </form>

            <div id="section-umum" class="lg:col-span-2 hidden">
                <h3 class="text-xl font-bold text-amber-950 mb-6 border-b border-amber-100 pb-3">Pengaturan Notifikasi
                    Sistem</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between bg-amber-50/50 p-4 rounded-xl border border-amber-100 hover:shadow-sm transition"
                        onmouseover="showTooltip('notif_online')">
                        <div class="flex-1 pr-4">
                            <h4 class="font-bold text-gray-900 text-sm">Notifikasi Reservasi Online Masuk</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Memunculkan pop-up saat ada pesanan masuk.</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button onclick="showGlobalToast('reservasi')"
                                class="text-[10px] bg-white border border-amber-200 text-amber-700 px-3 py-1.5 rounded-lg font-bold hover:bg-amber-100 transition shadow-sm">Test</button>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="toggle_notif_reservasi" class="sr-only peer"
                                    onchange="saveClientSettings('notif_reservasi', this.checked)">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600">
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-between bg-amber-50/50 p-4 rounded-xl border border-amber-100 hover:shadow-sm transition"
                        onmouseover="showTooltip('notif_checkin')">
                        <div class="flex-1 pr-4">
                            <h4 class="font-bold text-gray-900 text-sm">Pengingat Waktu Check-In</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Pengingat saat waktu Check-In tamu tiba.</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button onclick="showGlobalToast('checkin')"
                                class="text-[10px] bg-white border border-amber-200 text-amber-700 px-3 py-1.5 rounded-lg font-bold hover:bg-amber-100 transition shadow-sm">Test</button>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="toggle_notif_checkin" class="sr-only peer"
                                    onchange="saveClientSettings('notif_checkin', this.checked)">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600">
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-between bg-amber-50/50 p-4 rounded-xl border border-amber-100 hover:shadow-sm transition"
                        onmouseover="showTooltip('notif_checkout')">
                        <div class="flex-1 pr-4">
                            <h4 class="font-bold text-gray-900 text-sm">Pengingat Batas Waktu Check-Out</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Peringatan jika tamu melewati batas waktu inap.</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button onclick="showGlobalToast('checkout')"
                                class="text-[10px] bg-white border border-amber-200 text-amber-700 px-3 py-1.5 rounded-lg font-bold hover:bg-amber-100 transition shadow-sm">Test</button>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="toggle_notif_checkout" class="sr-only peer"
                                    onchange="saveClientSettings('notif_checkout', this.checked)">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <h3
                    class="text-xl font-bold text-amber-950 mb-6 mt-10 border-b border-amber-100 pb-3 flex items-center gap-2">
                    <svg class="w-6 h-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Preferensi Tampilan (Aksesibilitas)
                </h3>

                <div class="space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between bg-amber-50/50 p-4 rounded-xl border border-amber-100 hover:shadow-sm transition gap-4"
                        onmouseover="showTooltip('pref_font')">
                        <div class="flex-1 pr-4">
                            <h4 class="font-bold text-gray-900 text-sm">Ukuran Teks Sistem</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Geser untuk memperbesar/mengecilkan teks.</p>
                        </div>
                        <div class="w-full sm:w-1/3 flex items-center gap-3">
                            <span class="text-xs font-bold text-gray-400">A</span>
                            <input type="range" id="slider_fontsize" min="80" max="130" value="100"
                                step="5" oninput="changeFontSize(this.value)"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-amber-600">
                            <span class="text-lg font-bold text-gray-700">A</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between bg-amber-50/50 p-4 rounded-xl border border-amber-100 hover:shadow-sm transition"
                        onmouseover="showTooltip('pref_dark')">
                        <div class="flex-1 pr-4">
                            <h4 class="font-bold text-gray-900 text-sm">Mode Gelap (Dark Mode)</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Mengubah layar menjadi redup anti silau.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="toggle_darkmode" class="sr-only peer"
                                onchange="toggleDarkMode(this.checked)">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600">
                            </div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between bg-amber-50/50 p-4 rounded-xl border border-amber-100 hover:shadow-sm transition"
                        onmouseover="showTooltip('pref_contrast')">
                        <div class="flex-1 pr-4">
                            <h4 class="font-bold text-gray-900 text-sm">Teks Kontras Tinggi</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Memaksa seluruh teks menjadi Hitam Pekat.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="toggle_contrast" class="sr-only peer"
                                onchange="toggleHighContrast(this.checked)">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600">
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div id="section-jadwal" class="lg:col-span-2 hidden">
                <h3 class="text-xl font-bold text-amber-950 mb-6 border-b border-amber-100 pb-3">Penjadwalan
                    Maintenance</h3>

                @php
                    $masterMode = Cache::get('maintenance_mode') === 'true';
                    $mainOnline = Cache::get('main_online') === 'true';
                    $mainWalkin = Cache::get('main_walkin') === 'true';

                    $jadwalMode = Cache::get('jadwal_maintenance') === 'true';
                    $autoMode = Cache::get('auto_maintenance') === 'true';
                    $checkOnline = Cache::get('check_jadwal_online') === 'true';
                    $checkWalkin = Cache::get('check_jadwal_walkin') === 'true';
                @endphp

                <div class="bg-gray-50/50 rounded-2xl border border-gray-200 p-5 mb-6"
                    onmouseover="showTooltip('jadwal_master')">
                    <div class="flex items-center justify-between mb-4 border-b border-gray-200 pb-4">
                        <div>
                            <h4 class="font-black text-gray-900 text-lg">Maintenance Mode</h4>
                            <p class="text-xs text-gray-500 mt-1">Nonaktifkan fitur reservasi secara instan.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="toggle_maintenance_mode" class="sr-only peer"
                                onchange="toggleMaintenanceOptions(this.checked)" {{ $masterMode ? 'checked' : '' }}>
                            <div
                                class="w-14 h-7 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-red-500">
                            </div>
                        </label>
                    </div>

                    <div id="instant_maintenance_div"
                        class="grid grid-cols-1 sm:grid-cols-2 gap-4 transition-all {{ $masterMode ? '' : 'hidden' }}">
                        <div class="flex items-center justify-between bg-white p-4 rounded-xl border border-gray-200 shadow-sm"
                            onmouseover="showTooltip('jadwal_instan_online')">
                            <span class="font-bold text-gray-700 text-sm">Reservasi Online</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="toggle_main_online" class="sr-only peer"
                                    onchange="updateServerMaintenance()" {{ $mainOnline ? 'checked' : '' }}>
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600">
                                </div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between bg-white p-4 rounded-xl border border-gray-200 shadow-sm"
                            onmouseover="showTooltip('jadwal_instan_walkin')">
                            <span class="font-bold text-gray-700 text-sm">Reservasi Walk-in</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="toggle_main_walkin" class="sr-only peer"
                                    onchange="updateServerMaintenance()" {{ $mainWalkin ? 'checked' : '' }}>
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50/50 rounded-2xl border border-gray-200 p-5"
                    onmouseover="showTooltip('jadwal_otomatis')">
                    <div class="flex items-center justify-between mb-4 border-b border-gray-200 pb-4">
                        <div>
                            <h4 class="font-black text-gray-900 text-lg">Jadwalkan Maintenance</h4>
                            <p class="text-xs text-gray-500 mt-1">Sistem akan otomatis mati pada tanggal terpilih.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="toggle_jadwal_maintenance" class="sr-only peer"
                                onchange="toggleJadwalOptions(this.checked)" {{ $jadwalMode ? 'checked' : '' }}>
                            <div
                                class="w-14 h-7 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-amber-500">
                            </div>
                        </label>
                    </div>

                    <div id="scheduled_maintenance_div" class="transition-all {{ $jadwalMode ? '' : 'hidden' }}">
                        <div
                            class="flex items-center justify-between bg-white p-4 rounded-xl border border-gray-200 shadow-sm mb-4">
                            <span class="font-bold text-gray-700 text-sm">Aktifkan otomatis</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="toggle_auto_maintenance" class="sr-only peer"
                                    onchange="updateServerMaintenance()" {{ $autoMode ? 'checked' : '' }}>
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-500">
                                </div>
                            </label>
                        </div>

                        <div class="flex gap-6 mb-6 px-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" id="check_jadwal_online"
                                    class="w-5 h-5 text-amber-600 rounded border-gray-300 focus:ring-amber-500"
                                    onchange="updateServerMaintenance()" {{ $checkOnline ? 'checked' : '' }}>
                                <span class="text-sm font-bold text-gray-700">Reservasi Online</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" id="check_jadwal_walkin"
                                    class="w-5 h-5 text-amber-600 rounded border-gray-300 focus:ring-amber-500"
                                    onchange="updateServerMaintenance()" {{ $checkWalkin ? 'checked' : '' }}>
                                <span class="text-sm font-bold text-gray-700">Reservasi Walk-in</span>
                            </label>
                        </div>

                        <div class="bg-white border border-gray-200 p-2 rounded-xl shadow-sm mb-6"
                            onmouseover="showTooltip('jadwal_kalender')">
                            <div id="maintenance_calendar" class="text-xs"></div>
                        </div>

                        <div class="flex justify-center gap-3">
                            <button type="button"
                                onclick="updateServerMaintenance(); alert('Jadwal Maintenance Berhasil Disimpan ke Server!');"
                                class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-3 rounded-xl font-bold transition shadow-md w-full sm:w-auto">
                                Simpan Jadwal
                            </button>
                            <button type="button" onclick="resetMaintenanceDates()"
                                class="bg-white border border-red-200 text-red-600 hover:bg-red-50 px-8 py-3 rounded-xl font-bold transition w-full sm:w-auto">
                                Batalkan Jadwal
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 sticky top-24 pt-6 lg:pt-0">
                <div class="bg-amber-50/50 rounded-2xl border border-amber-200 p-6 shadow-inner transition-all duration-300"
                    id="tooltip-box">
                    <div class="flex items-center gap-3 mb-4 border-b border-amber-200 pb-3">
                        <span id="tooltip-icon" class="text-3xl">💡</span>
                        <h3 id="tooltip-title" class="text-lg font-bold text-amber-950">Panduan Pengisian</h3>
                    </div>
                    <div id="tooltip-content" class="text-sm text-amber-900/80 leading-relaxed font-medium">
                        Silakan klik pada kolom atau arahkan kursor Anda ke area pengaturan untuk melihat instruksinya
                        di sini.
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>

    <script>
        let selectedMaintenanceDates = [];
        let calendarInstance = null;

        document.addEventListener('DOMContentLoaded', () => {
            // Membaca Toggles Notifikasi Local Storage
            ['notif_reservasi', 'notif_checkin', 'notif_checkout'].forEach(setting => {
                const isChecked = localStorage.getItem(setting) === 'true';
                if (document.getElementById('toggle_' + setting)) document.getElementById('toggle_' +
                    setting).checked = isChecked;
            });

            // Membaca Style Slider
            const savedFontSize = localStorage.getItem('pref_fontsize');
            if (savedFontSize) document.getElementById('slider_fontsize').value = savedFontSize;

            // Membaca Style Toggles
            document.getElementById('toggle_darkmode').checked = localStorage.getItem('pref_darkmode') === 'true';
            document.getElementById('toggle_contrast').checked = localStorage.getItem('pref_contrast') === 'true';

            // Membaca Kalender Maintenance dari Server Laravel
            const savedDates = {!! Cache::get('jadwal_tersimpan') ? Cache::get('jadwal_tersimpan') : '[]' !!};
            if (savedDates.length > 0) {
                selectedMaintenanceDates = savedDates;
            }
        });

        // 1. FUNGSI PREFERENSI TAMPILAN
        function changeFontSize(val) {
            document.documentElement.style.fontSize = val + '%';
            localStorage.setItem('pref_fontsize', val);
        }

        function toggleDarkMode(isDark) {
            if (isDark) document.documentElement.classList.add('dark-mode-active');
            else {
                document.documentElement.classList.remove('dark-mode-active');
                document.body.classList.remove('dark-mode-active');
            }
            localStorage.setItem('pref_darkmode', isDark);
        }

        function toggleHighContrast(isHigh) {
            if (isHigh) document.documentElement.classList.add('high-contrast-active');
            else {
                document.documentElement.classList.remove('high-contrast-active');
                document.body.classList.remove('high-contrast-active');
            }
            localStorage.setItem('pref_contrast', isHigh);
        }

        function saveClientSettings(key, value) {
            localStorage.setItem(key, value);
        }

        // 2. FUNGSI FOTO DAN PASSWORD
        function peekPassword(inputId) {
            let input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
                setTimeout(() => {
                    input.type = "password";
                }, 3000);
            } else {
                input.type = "password";
            }
        }

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('avatar_preview');
                const altOutput = document.getElementById('avatar_preview_alt');
                if (output) {
                    output.src = reader.result;
                } else if (altOutput) {
                    altOutput.outerHTML =
                        `<img id="avatar_preview" src="${reader.result}" class="w-24 h-24 rounded-full object-cover border-4 border-amber-50 group-hover:border-amber-300 transition shadow-sm">`;
                }
            };
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }

        // 3. FUNGSI TAB
        function switchTab(tabName) {
            const btnProfil = document.getElementById('tab-btn-profil');
            const btnUmum = document.getElementById('tab-btn-umum');
            const btnJadwal = document.getElementById('tab-btn-jadwal');

            const secProfil = document.getElementById('section-profil');
            const secUmum = document.getElementById('section-umum');
            const secJadwal = document.getElementById('section-jadwal');

            secProfil.classList.add('hidden');
            secUmum.classList.add('hidden');
            secJadwal.classList.add('hidden');
            const inactiveStyle =
                "px-5 sm:px-6 py-2.5 bg-amber-50 border border-amber-200 rounded-t-xl font-bold text-amber-800/60 hover:text-amber-700 hover:bg-amber-100 text-xs sm:text-sm transition relative z-0 ml-1";
            btnProfil.className = inactiveStyle;
            btnUmum.className = inactiveStyle;
            btnJadwal.className = inactiveStyle;
            const activeStyle =
                "px-5 sm:px-6 py-3 bg-white border border-amber-200 border-b-white rounded-t-xl font-bold text-amber-700 text-xs sm:text-sm relative z-10 -mb-[1px] shadow-sm shadow-white transition";

            if (tabName === 'profil') {
                secProfil.classList.remove('hidden');
                btnProfil.className = activeStyle;
                showTooltip('default');
            } else if (tabName === 'umum') {
                secUmum.classList.remove('hidden');
                btnUmum.className = activeStyle;
                showTooltip('umum_intro');
            } else {
                secJadwal.classList.remove('hidden');
                btnJadwal.className = activeStyle;
                showTooltip('jadwal_intro');
                if (document.getElementById('toggle_jadwal_maintenance').checked) {
                    setTimeout(() => initCalendar(), 100);
                }
            }
        }

        // 4. FUNGSI TOOLTIP SEMUA KASUS
        function showTooltip(type) {
            let title = '';
            let content = '';
            let icon = '';
            switch (type) {
                case 'avatar':
                    title = 'Aturan Foto Profil';
                    icon = '📸';
                    content =
                        `<ul class="list-disc pl-5 space-y-1.5"><li>Format yang didukung: <span class="font-bold">JPG, JPEG, PNG</span>.</li><li>Batas ukuran maksimal: <span class="font-bold text-red-600">5 MB (5120 KB)</span>.</li><li>Sangat direkomendasikan menggunakan foto rasio 1:1 (persegi).</li></ul>`;
                    break;
                case 'nama':
                    title = 'Nama Lengkap';
                    icon = '👤';
                    content = 'Sangat disarankan untuk menggunakan nama asli sesuai identitas Anda.';
                    break;
                case 'username':
                    title = 'Username Akses';
                    icon = '🔑';
                    content =
                        '<span class="font-bold text-amber-950">Syarat:</span> Harus Unik, maksimal 20 karakter, dan tidak boleh mengandung spasi.';
                    break;
                case 'email':
                    title = 'Alamat Email';
                    icon = '📧';
                    content =
                        'Email ini berfungsi untuk sistem pemulihan (*recovery*) jika sewaktu-waktu Anda lupa kata sandi.';
                    break;
                case 'password':
                    title = 'Keamanan Kata Sandi';
                    icon = '🛡️';
                    content =
                        `Demi keamanan, perhatikan saran berikut:<ul class="list-disc pl-5 mt-2 space-y-1.5"><li>Minimal <span class="font-bold">8 Karakter</span>.</li><li>Gunakan kombinasi <strong>Huruf Kapital</strong>, huruf kecil, dan <strong>Angka</strong>.</li><li>Wajib diisi pada kedua kolom untuk mencegah salah ketik.</li></ul>`;
                    break;
                case 'umum_intro':
                    title = 'Pengaturan Umum';
                    icon = '⚙️';
                    content = 'Pengaturan di tab ini akan tersimpan otomatis secara lokal (Browser Cache).';
                    break;
                case 'notif_online':
                    title = 'Notifikasi Reservasi';
                    icon = '🛎️';
                    content = 'Memunculkan Pop-Up (*Toast*) setiap kali ada tamu memesan.';
                    break;
                case 'notif_checkin':
                    title = 'Notifikasi Check-In';
                    icon = '🔑';
                    content = 'Pengingat otomatis 30 menit sebelum jadwal tamu.';
                    break;
                case 'notif_checkout':
                    title = 'Notifikasi Check-Out';
                    icon = '⏰';
                    content = 'Peringatan tamu Overstay.';
                    break;
                case 'pref_font':
                    title = 'Ukuran Teks Sistem';
                    icon = 'Aa';
                    content = 'Geser *slider* ke kanan/kiri untuk mengubah ukuran.';
                    break;
                case 'pref_dark':
                    title = 'Mode Gelap (Dark Mode)';
                    icon = '🌙';
                    content = 'Meredupkan layar (Filter Invert) agar tidak silau.';
                    break;
                case 'pref_contrast':
                    title = 'Teks Kontras Tinggi';
                    icon = '👁️';
                    content = 'Memaksa seluruh teks abu-abu menjadi Hitam Pekat.';
                    break;
                case 'jadwal_intro':
                    title = 'Penjadwalan';
                    icon = '📅';
                    content =
                        'Pusat kontrol untuk mematikan layanan reservasi sementara atau mengatur jadwal perbaikan server (Maintenance).';
                    break;
                case 'jadwal_master':
                    title = 'Maintenance Instan';
                    icon = '🔴';
                    content = 'Matikan layanan Booking/Reservasi secara seketika (*Real-time*).';
                    break;
                case 'jadwal_instan_online':
                    title = 'Matikan Reservasi Online';
                    icon = '🌐';
                    content = 'Tamu di Landing Page tidak akan bisa melakukan klik tombol "Buat Reservasi".';
                    break;
                case 'jadwal_instan_walkin':
                    title = 'Matikan Walk-in';
                    icon = '🚶';
                    content = 'Menonaktifkan tombol modal +Check In Baru di menu Manajemen Reservasi staf resepsionis.';
                    break;
                case 'jadwal_otomatis':
                    title = 'Mode Terjadwal';
                    icon = '⏱️';
                    content =
                        'Bagus untuk pemeliharaan rutin. Sistem akan otomatis mematikan layanan pada tanggal-tanggal yang Anda tandai di kalender.';
                    break;
                case 'jadwal_kalender':
                    title = 'Seleksi Tanggal';
                    icon = '🖱️';
                    content = 'Klik pada angka tanggal di kalender. Jangan lupa klik <b>Simpan Jadwal</b> setelah memilih.';
                    break;
                default:
                    title = 'Panduan Pengisian';
                    icon = '💡';
                    content =
                        'Silakan klik kolom atau arahkan kursor Anda ke area pengaturan untuk melihat detail instruksi.';
                    break;
            }
            const box = document.getElementById('tooltip-box');
            box.style.opacity = 0;
            setTimeout(() => {
                document.getElementById('tooltip-title').innerText = title;
                document.getElementById('tooltip-content').innerHTML = content;
                document.getElementById('tooltip-icon').innerText = icon;
                box.style.opacity = 1;
            }, 150);
        }

        // 5. FUNGSI TEST NOTIFIKASI

        // 6. FUNGSI MAINTENANCE AJAX (SERVER) & KALENDER
        function toggleMaintenanceOptions(isChecked) {
            const div = document.getElementById('instant_maintenance_div');
            if (isChecked) div.classList.remove('hidden');
            else div.classList.add('hidden');
            updateServerMaintenance();
        }

        function toggleJadwalOptions(isChecked) {
            const div = document.getElementById('scheduled_maintenance_div');
            if (isChecked) {
                div.classList.remove('hidden');
                setTimeout(() => {
                    initCalendar();
                }, 100);
            } else {
                div.classList.add('hidden');
            }
            updateServerMaintenance();
        }

        function updateServerMaintenance() {
            fetch('{{ route('settings.maintenance') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    maintenance_mode: document.getElementById('toggle_maintenance_mode').checked,
                    main_online: document.getElementById('toggle_main_online').checked,
                    main_walkin: document.getElementById('toggle_main_walkin').checked,
                    jadwal_maintenance: document.getElementById('toggle_jadwal_maintenance').checked,
                    auto_maintenance: document.getElementById('toggle_auto_maintenance').checked,
                    check_jadwal_online: document.getElementById('check_jadwal_online').checked,
                    check_jadwal_walkin: document.getElementById('check_jadwal_walkin').checked,
                    jadwal_tersimpan: JSON.stringify(selectedMaintenanceDates)
                })
            });
        }

        function initCalendar() {
            if (calendarInstance) return;
            const calEl = document.getElementById('maintenance_calendar');
            calendarInstance = new FullCalendar.Calendar(calEl, {
                initialView: 'dayGridMonth',
                height: 350,
                locale: 'id',
                headerToolbar: {
                    left: 'prev',
                    center: 'title',
                    right: 'next'
                },
                dayCellDidMount: function(info) {
                    if (selectedMaintenanceDates.includes(info.dateStr)) info.el.style.backgroundColor =
                        '#ef4444';
                },
                dateClick: function(info) {
                    const idx = selectedMaintenanceDates.indexOf(info.dateStr);
                    if (idx > -1) {
                        selectedMaintenanceDates.splice(idx, 1);
                        info.dayEl.style.backgroundColor = '';
                    } else {
                        selectedMaintenanceDates.push(info.dateStr);
                        info.dayEl.style.backgroundColor = '#ef4444';
                    }
                }
            });
            calendarInstance.render();
        }

        function resetMaintenanceDates() {
            if (confirm("Yakin ingin membatalkan/mereset seluruh jadwal maintenance?")) {
                selectedMaintenanceDates = [];
                updateServerMaintenance();
                if (calendarInstance) {
                    calendarInstance.destroy();
                    calendarInstance = null;
                    initCalendar();
                }
                alert('Jadwal berhasil dibatalkan.');
            }
        }
    </script>
    <style>
        .toast-slide-in {
            animation: slideInRight 0.4s ease-out forwards;
        }

        .toast-fade-out {
            animation: fadeOut 0.4s ease-out forwards;
        }

        /* Tampilan Angka Kalender */
        .fc .fc-daygrid-day-number {
            cursor: pointer;
            color: #1f2937;
            font-weight: bold;
        }

        .fc .fc-daygrid-day:hover {
            background-color: #fef3c7;
            cursor: pointer;
        }
    </style>
</x-dblayout>

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

    <div id="toast-container" class="fixed top-20 right-5 z-[9999] flex flex-col gap-3 pointer-events-none"></div>

    <div class="flex items-end pl-0 sm:pl-2">
        <button type="button" onclick="switchTab('profil')" id="tab-btn-profil"
            class="px-6 py-3 bg-white border border-amber-200 border-b-white rounded-t-xl font-bold text-amber-700 text-sm relative z-10 -mb-[1px] shadow-sm shadow-white transition">
            Profil Saya
        </button>
        <button type="button" onclick="switchTab('umum')" id="tab-btn-umum"
            class="px-6 py-2.5 bg-amber-50 border border-amber-200 rounded-t-xl font-bold text-amber-800/60 hover:text-amber-700 hover:bg-amber-100 text-sm transition relative z-0 ml-1">
            Pengaturan Umum
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
                            <span class="text-white text-[10px] font-bold text-center px-2 leading-tight">Ubah<br>Foto
                                Profil</span>
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
                            <p class="text-xs text-gray-500 mt-0.5">Memunculkan notifikasi saat ada tamu yang memesan
                                kamar via Landing Page.</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button onclick="testNotification('reservasi')"
                                class="text-[10px] bg-white border border-amber-200 text-amber-700 px-3 py-1.5 rounded-lg font-bold hover:bg-amber-100 transition shadow-sm">Test</button>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="toggle_notif_reservasi" class="sr-only peer"
                                    onchange="saveSettings('notif_reservasi', this.checked)">
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
                            <p class="text-xs text-gray-500 mt-0.5">Mengingatkan Anda saat waktu Check-In tamu yang
                                terkonfirmasi telah tiba.</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button onclick="testNotification('checkin')"
                                class="text-[10px] bg-white border border-amber-200 text-amber-700 px-3 py-1.5 rounded-lg font-bold hover:bg-amber-100 transition shadow-sm">Test</button>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="toggle_notif_checkin" class="sr-only peer"
                                    onchange="saveSettings('notif_checkin', this.checked)">
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
                            <p class="text-xs text-gray-500 mt-0.5">Memunculkan peringatan jika ada tamu yang sudah
                                melewati batas waktu menginap.</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button onclick="testNotification('checkout')"
                                class="text-[10px] bg-white border border-amber-200 text-amber-700 px-3 py-1.5 rounded-lg font-bold hover:bg-amber-100 transition shadow-sm">Test</button>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="toggle_notif_checkout" class="sr-only peer"
                                    onchange="saveSettings('notif_checkout', this.checked)">
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
                            <p class="text-xs text-gray-500 mt-0.5">Geser untuk memperbesar atau mengecilkan teks pada
                                dashboard.</p>
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
                            <p class="text-xs text-gray-500 mt-0.5">Membalikkan warna antarmuka agar tidak menyilaukan
                                mata di malam hari.</p>
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
                            <p class="text-xs text-gray-500 mt-0.5">Mengubah seluruh warna teks abu-abu/samar menjadi
                                hitam pekat (Solid Black).</p>
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

            <div class="lg:col-span-1 sticky top-24 pt-6 lg:pt-0">
                <div class="bg-amber-50/50 rounded-2xl border border-amber-200 p-6 shadow-inner transition-all duration-300"
                    id="tooltip-box">
                    <div class="flex items-center gap-3 mb-4 border-b border-amber-200 pb-3">
                        <span id="tooltip-icon" class="text-3xl">💡</span>
                        <h3 id="tooltip-title" class="text-lg font-bold text-amber-950">Panduan Pengisian</h3>
                    </div>
                    <div id="tooltip-content" class="text-sm text-amber-900/80 leading-relaxed font-medium">
                        Silakan klik pada salah satu kolom formulir atau arahkan kursor Anda ke area pengaturan untuk
                        melihat detail instruksinya di sini.
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        /* Animasi Pop Up Notifikasi */
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
                transform: translateY(-10px);
            }
        }

        .toast-slide-in {
            animation: slideInRight 0.4s ease-out forwards;
        }

        .toast-fade-out {
            animation: fadeOut 0.4s ease-out forwards;
        }

        /* Trik Dark Mode (Invert Colors) */
        html.dark-mode-active {
            filter: invert(0.9) hue-rotate(180deg);
            background: #fff;
        }

        /* Kembalikan warna asli untuk foto/gambar agar tidak jadi X-Ray */
        html.dark-mode-active img,
        html.dark-mode-active video,
        html.dark-mode-active iframe {
            filter: invert(1) hue-rotate(180deg);
        }

        /* Trik High Contrast (Hitam Pekat) */
        body.high-contrast-active * {
            color: #000 !important;
            border-color: #000 !important;
        }

        body.high-contrast-active .bg-amber-600,
        body.high-contrast-active .bg-emerald-600,
        body.high-contrast-active .bg-indigo-600,
        body.high-contrast-active .bg-rose-600 {
            background-color: #000 !important;
            color: #fff !important;
        }
    </style>

    <script>
        // --- 1. MEMUAT PREFERENSI SAAT HALAMAN DIBUKA ---
        document.addEventListener('DOMContentLoaded', () => {
            // Load Toggle Notifikasi
            const settings = ['notif_reservasi', 'notif_checkin', 'notif_checkout'];
            settings.forEach(setting => {
                const isChecked = localStorage.getItem(setting) === 'true';
                if (document.getElementById('toggle_' + setting)) {
                    document.getElementById('toggle_' + setting).checked = isChecked;
                }
            });

            // Load Font Size
            const savedFontSize = localStorage.getItem('pref_fontsize');
            if (savedFontSize) {
                document.getElementById('slider_fontsize').value = savedFontSize;
                document.documentElement.style.fontSize = savedFontSize + '%';
            }

            // Load Dark Mode
            const isDark = localStorage.getItem('pref_darkmode') === 'true';
            document.getElementById('toggle_darkmode').checked = isDark;
            if (isDark) document.documentElement.classList.add('dark-mode-active');

            // Load High Contrast
            const isContrast = localStorage.getItem('pref_contrast') === 'true';
            document.getElementById('toggle_contrast').checked = isContrast;
            if (isContrast) document.body.classList.add('high-contrast-active');
        });

        // --- 2. FUNGSI PREFERENSI TAMPILAN ---
        function changeFontSize(val) {
            document.documentElement.style.fontSize = val + '%';
            localStorage.setItem('pref_fontsize', val);
        }

        function toggleDarkMode(isDark) {
            if (isDark) {
                document.documentElement.classList.add('dark-mode-active');
            } else {
                // Sapu bersih class dari html dan body agar tidak ada bug visual yang tertinggal
                document.documentElement.classList.remove('dark-mode-active');
                document.body.classList.remove('dark-mode-active');
            }
            localStorage.setItem('pref_darkmode', isDark);
        }

        function toggleHighContrast(isHigh) {
            if (isHigh) {
                document.documentElement.classList.add('high-contrast-active');
            } else {
                // Sapu bersih class dari html dan body agar tidak ada bug visual yang tertinggal
                document.documentElement.classList.remove('high-contrast-active');
                document.body.classList.remove('high-contrast-active');
            }
            localStorage.setItem('pref_contrast', isHigh);
        }

        function saveSettings(key, value) {
            localStorage.setItem(key, value);
        }

        // --- 3. FUNGSI PINDAH TABS (PROFIL & UMUM) ---
        function switchTab(tabName) {
            const btnProfil = document.getElementById('tab-btn-profil');
            const btnUmum = document.getElementById('tab-btn-umum');
            const secProfil = document.getElementById('section-profil');
            const secUmum = document.getElementById('section-umum');

            if (tabName === 'profil') {
                secProfil.classList.remove('hidden');
                secUmum.classList.add('hidden');
                btnProfil.className =
                    "px-6 py-3 bg-white border border-amber-200 border-b-white rounded-t-xl font-bold text-amber-700 text-sm relative z-10 -mb-[1px] shadow-sm shadow-white transition";
                btnUmum.className =
                    "px-6 py-2.5 bg-amber-50 border border-amber-200 rounded-t-xl font-bold text-amber-800/60 hover:text-amber-700 hover:bg-amber-100 text-sm transition relative z-0 ml-1";
                showTooltip('default');
            } else {
                secProfil.classList.add('hidden');
                secUmum.classList.remove('hidden');
                btnUmum.className =
                    "px-6 py-3 bg-white border border-amber-200 border-b-white rounded-t-xl font-bold text-amber-700 text-sm relative z-10 -mb-[1px] shadow-sm shadow-white transition ml-1";
                btnProfil.className =
                    "px-6 py-2.5 bg-amber-50 border border-amber-200 rounded-t-xl font-bold text-amber-800/60 hover:text-amber-700 hover:bg-amber-100 text-sm transition relative z-0";
                showTooltip('umum_intro');
            }
        }

        // --- 4. POPUP NOTIFIKASI TESTER ---
        function testNotification(type) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');

            let icon = '';
            let title = '';
            let desc = '';
            let bgColor = '';
            let textColor = '';
            if (type === 'reservasi') {
                icon = '🛎️';
                title = 'Reservasi Online Baru!';
                desc = 'Ada pesanan kamar baru dari Bpk. Budi via Website.';
                bgColor = 'bg-blue-50';
                textColor = 'text-blue-900';
            } else if (type === 'checkin') {
                icon = '🔑';
                title = 'Waktu Check-In Tiba';
                desc = 'Tamu Kamar 201 sudah dijadwalkan untuk masuk (14:00 WIB).';
                bgColor = 'bg-emerald-50';
                textColor = 'text-emerald-900';
            } else if (type === 'checkout') {
                icon = '⏰';
                title = 'Peringatan Check-Out';
                desc = 'Tamu Kamar 104 telah melewati batas waktu Check-Out (12:00 WIB).';
                bgColor = 'bg-rose-50';
                textColor = 'text-rose-900';
            }

            toast.className =
                `flex items-start gap-3 p-4 w-72 md:w-80 rounded-2xl shadow-xl border border-gray-200 pointer-events-auto toast-slide-in ${bgColor}`;
            toast.innerHTML =
                `<div class="text-2xl">${icon}</div><div class="flex-1"><h4 class="text-sm font-black ${textColor}">${title}</h4><p class="text-xs text-gray-600 mt-1 leading-relaxed">${desc}</p></div>`;

            container.appendChild(toast);
            setTimeout(() => {
                toast.classList.replace('toast-slide-in', 'toast-fade-out');
                setTimeout(() => toast.remove(), 400);
            }, 4000);
        }

        // --- 5. TOOLTIP DINAMIS KANAN ---
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
                    content =
                        'Nama ini akan ditampilkan pada antarmuka dashboard dan struk cetak kasir. Sangat disarankan untuk menggunakan nama asli sesuai identitas Anda.';
                    break;
                case 'username':
                    title = 'Username Akses';
                    icon = '🔑';
                    content =
                        'Digunakan sebagai identitas rahasia saat Log In ke dalam sistem (sebagai pengganti Email). <br><br><span class="font-bold text-amber-950">Syarat:</span> Harus Unik, maksimal 20 karakter, dan tidak boleh mengandung spasi.';
                    break;
                case 'email':
                    title = 'Alamat Email';
                    icon = '📧';
                    content =
                        'Pastikan menggunakan email aktif instansi/pribadi. Email ini berfungsi untuk sistem pemulihan (*recovery*) jika sewaktu-waktu Anda lupa kata sandi.';
                    break;
                case 'password':
                    title = 'Keamanan Kata Sandi';
                    icon = '🛡️';
                    content =
                        `Demi keamanan data hotel, perhatikan saran berikut:<ul class="list-disc pl-5 mt-2 space-y-1.5"><li>Minimal <span class="font-bold">8 Karakter</span>.</li><li>Gunakan kombinasi <strong>Huruf Kapital</strong>, huruf kecil, dan <strong>Angka</strong>.</li><li>Wajib diisi pada kedua kolom untuk mencegah salah ketik.</li></ul>`;
                    break;
                case 'umum_intro':
                    title = 'Pengaturan Umum';
                    icon = '⚙️';
                    content =
                        'Pengaturan di tab ini akan tersimpan otomatis secara lokal pada komputer/browser Anda (menggunakan LocalStorage) agar tidak merusak tampilan kasir di komputer staf yang lain.';
                    break;
                case 'notif_online':
                    title = 'Notifikasi Reservasi';
                    icon = '🛎️';
                    content =
                        'Memunculkan jendela Pop-Up (*Toast*) setiap kali ada tamu yang melakukan pemesanan via situs web, meskipun Anda sedang membuka menu lain.';
                    break;
                case 'notif_checkin':
                    title = 'Notifikasi Check-In';
                    icon = '🔑';
                    content =
                        'Pengingat otomatis yang akan melayang 30 menit sebelum jadwal kedatangan tamu (*Arrival Time*).';
                    break;
                case 'notif_checkout':
                    title = 'Notifikasi Check-Out';
                    icon = '⏰';
                    content =
                        'Sistem akan memunculkan peringatan jika ada tamu yang sudah melewati batas waktu menginap dan belum mengembalikan kunci.';
                    break;
                case 'pref_font':
                    title = 'Ukuran Teks Sistem';
                    icon = 'Aa';
                    content =
                        'Geser *slider* ke kanan untuk memperbesar huruf, atau ke kiri untuk mengecilkan. Sangat berguna jika layar monitor kasir terlalu jauh dari jangkauan mata.';
                    break;
                case 'pref_dark':
                    title = 'Mode Gelap (Dark Mode)';
                    icon = '🌙';
                    content =
                        'Menggunakan teknologi Filter Invert untuk membalikkan warna cahaya latar menjadi gelap. Berguna untuk staf yang berjaga pada *Shift Malam*.';
                    break;
                case 'pref_contrast':
                    title = 'Teks Kontras Tinggi';
                    icon = '👁️';
                    content =
                        'Akan memaksa seluruh teks berwarna abu-abu/samar dan seluruh garis *border* menjadi **Hitam Pekat (Solid Black)** agar sangat mudah terbaca.';
                    break;
                default:
                    title = 'Panduan Pengisian';
                    icon = '💡';
                    content =
                        'Silakan klik pada salah satu kolom formulir atau arahkan kursor Anda ke area pengaturan untuk melihat detail instruksinya di sini.';
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

        // --- 6. FUNGSI FOTO & PASSWORD ---
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
    </script>
</x-dblayout>

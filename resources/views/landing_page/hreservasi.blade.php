<x-lplayout>
    <div class="absolute top-0 left-0 w-full h-80 bg-amber-600 z-0"></div>

    <div class="relative z-10 min-h-screen pt-24 lg:pt-32 pb-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

        <div class="mb-8">
            <h1 class="text-white text-3xl font-extrabold tracking-tight">Formulir Reservasi Online</h1>
            <p class="text-amber-100 mt-1">Lengkapi data di bawah ini untuk mengamankan pesanan kamar Anda.</p>
        </div>

        @if (session('success'))
            <div
                class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm font-bold">
                ✅ {{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm font-bold">⚠️
                {{ session('error') }}</div>
        @endif

        <div class="flex flex-col lg:flex-row gap-8 items-start" x-data="{ qrisGenerated: false, showQrisLoading: false }">

            <!-- BAGIAN KIRI: FORMULIR -->
            <div class="flex-1 w-full bg-white rounded-3xl shadow-xl border border-amber-100 p-6 sm:p-8">

                @if (!$isLoggedIn)
                    <div class="text-center py-16">
                        <span class="text-6xl block mb-6">🔐</span>
                        <h3 class="text-2xl font-black text-amber-950 mb-2">Login Diperlukan</h3>
                        <p class="text-base text-gray-500 max-w-md mx-auto leading-relaxed mb-8">
                            Untuk melanjutkan proses pemesanan kamar hotel, silakan masuk ke dalam akun Anda atau
                            daftarkan diri terlebih dahulu jika belum memiliki akun.
                        </p>
                        <div class="flex flex-col sm:flex-row justify-center gap-3">
                            <a href="{{ route('login') }}"
                                class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-md shadow-amber-600/30">Log
                                In Sekarang</a>
                            <a href="{{ route('register') }}"
                                class="bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold py-3 px-8 rounded-xl border border-amber-200 transition">Daftar
                                Akun Baru</a>
                        </div>
                    </div>
                @else
                    <form action="{{ route('reservasi.tamu.store') }}" method="POST" id="formReservasi">
                        @csrf

                        <!-- 1. PILIH KAMAR & ANGGOTA -->
                        <div class="border border-amber-200 rounded-2xl p-5 mb-6">
                            <h3 class="font-bold text-amber-950 mb-4 border-b border-amber-100 pb-2 text-lg">1. Pilih
                                Kamar</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-2">Jumlah Anggota (Maks: 4
                                        Orang)</label>
                                    <div
                                        class="flex items-center border border-amber-300 rounded-xl overflow-hidden bg-white shadow-sm w-full sm:w-3/4">
                                        <button type="button" onclick="adjustAnggota(-1)"
                                            class="px-4 py-2.5 font-bold text-gray-600 hover:bg-amber-50 text-lg leading-none transition">&minus;</button>
                                        <input type="number" name="jumlah_anggota" id="jumlah_anggota" value="1"
                                            min="1" max="4" readonly
                                            class="w-full text-center bg-transparent border-none text-base font-bold text-amber-950 p-0 focus:ring-0">
                                        <button type="button" onclick="adjustAnggota(1)"
                                            class="px-4 py-2.5 font-bold text-gray-600 hover:bg-amber-50 text-lg leading-none transition">&plus;</button>
                                    </div>
                                    <p class="text-[10px] text-gray-400 mt-1">*Jika membawa lebih dari 2 orang, sistem
                                        akan otomatis mencocokkan kamar berkapasitas 2 orang.</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-2">Pilih Kelas Kamar</label>
                                    <select name="kelas_kamar_id" id="kelas_kamar_id" onchange="updatePreviewKamar()"
                                        required
                                        class="w-full border border-amber-300 rounded-xl p-3 bg-white text-amber-950 shadow-sm focus:ring-amber-500 font-bold">
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach ($kelasKamars as $kelas)
                                            <option value="{{ $kelas->id }}" data-harga="{{ $kelas->harga }}"
                                                data-kapasitas="{{ $kelas->kapasitas ?? 1 }}"
                                                data-fasilitas="{{ json_encode($kelas->fasilitas) }}"
                                                data-thumb="{{ asset('storage/' . $kelas->thumbnail) }}"
                                                data-foto1="{{ $kelas->foto_1 ? asset('storage/' . $kelas->foto_1) : '' }}"
                                                data-foto2="{{ $kelas->foto_2 ? asset('storage/' . $kelas->foto_2) : '' }}"
                                                data-foto3="{{ $kelas->foto_3 ? asset('storage/' . $kelas->foto_3) : '' }}"
                                                {{ $kelasId == $kelas->id ? 'selected' : '' }}>
                                                {{ $kelas->nama_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- 2. DURASI MENGINAP -->
                        <div class="border border-amber-200 rounded-2xl p-5 mb-6">
                            <h3 class="font-bold text-amber-950 mb-4 border-b border-amber-100 pb-2 text-lg">2. Durasi
                                Menginap</h3>
                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-700 mb-2">Sesuaikan Dengan</label>
                                <select id="shortcut_durasi" onchange="updateCheckOutShortcut(this)"
                                    class="w-full sm:w-1/2 border border-gray-300 rounded-xl p-2.5 bg-gray-50 text-gray-900 shadow-sm focus:ring-amber-500 text-sm font-medium">
                                    <option value="1">1 Malam dari sekarang</option>
                                    <option value="2">2 Malam dari sekarang</option>
                                    <option value="3">3 Malam dari sekarang</option>
                                    <option value="7">1 Minggu dari sekarang</option>
                                    <option value="custom" selected>Atur Manual di bawah</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Check-in</label>
                                    <input type="datetime-local" name="check_in" id="check_in"
                                        value="{{ $checkin }}" onchange="resetShortcut(); hitungTotal()" required
                                        class="w-full border border-gray-300 rounded-xl p-3 shadow-sm focus:ring-amber-500 font-medium">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Check-out</label>
                                    <input type="datetime-local" name="check_out" id="check_out"
                                        value="{{ $checkout }}" onchange="resetShortcut(); hitungTotal()" required
                                        class="w-full border border-gray-300 rounded-xl p-3 shadow-sm focus:ring-amber-500 font-medium">
                                </div>
                            </div>
                        </div>

                        <!-- 3. IDENTITAS PEMESAN -->
                        <div class="border border-amber-200 rounded-2xl p-5 mb-6">
                            <h3 class="font-bold text-amber-950 mb-4 border-b border-amber-100 pb-2 text-lg">3.
                                Identitas Pemesan Utama</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">No. KTP (NIK)</label>
                                    <input type="text" name="no_ktp" value="{{ $user->no_ktp ?? '' }}" required
                                        maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        class="w-full border border-gray-300 rounded-xl p-3 text-gray-900 shadow-sm focus:ring-amber-500 focus:border-amber-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">No. HP / WhatsApp</label>
                                    <input type="text" name="no_hp" required maxlength="15"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        placeholder="Cth: 0812345678"
                                        class="w-full border border-gray-300 rounded-xl p-3 text-gray-900 shadow-sm focus:ring-amber-500 focus:border-amber-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-5">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap Sesuai
                                        KTP</label>
                                    <input type="text" name="nama_tamu" value="{{ $user->name ?? '' }}" required
                                        placeholder="Nama Anda..."
                                        class="w-full border border-gray-300 rounded-xl p-3 text-gray-900 shadow-sm focus:ring-amber-500 focus:border-amber-500">
                                </div>
                            </div>
                        </div>

                        <!-- 4. LAYANAN EKSTRA -->
                        <div class="border border-amber-200 rounded-2xl p-5 mb-6">
                            <h3 class="font-bold text-amber-950 mb-4 border-b border-amber-100 pb-2 text-lg">4. Layanan
                                Ekstra</h3>
                            <div class="space-y-3 mb-4">
                                <div
                                    class="flex items-center justify-between p-3 border border-gray-200 rounded-xl bg-white shadow-sm">
                                    <p class="text-sm font-bold text-gray-800">Ekstra Bed (+Rp 100k)</p>
                                    <div class="flex items-center border border-gray-300 rounded-lg bg-gray-50">
                                        <button type="button" onclick="adjustEkstra('extra_bed', -1)"
                                            class="px-3 py-1 font-bold text-gray-600 hover:bg-gray-200 transition">&minus;</button>
                                        <input type="number" name="extra_bed" id="extra_bed" value="0"
                                            readonly
                                            class="w-10 text-center bg-transparent border-none text-sm font-bold p-0 focus:ring-0">
                                        <button type="button" onclick="adjustEkstra('extra_bed', 1)"
                                            class="px-3 py-1 font-bold text-gray-600 hover:bg-gray-200 transition">&plus;</button>
                                    </div>
                                </div>
                                <div
                                    class="flex items-center justify-between p-3 border border-gray-200 rounded-xl bg-white shadow-sm">
                                    <p class="text-sm font-bold text-gray-800">Extra Selimut (+Rp 25k)</p>
                                    <div class="flex items-center border border-gray-300 rounded-lg bg-gray-50">
                                        <button type="button" onclick="adjustEkstra('extra_selimut', -1)"
                                            class="px-3 py-1 font-bold text-gray-600 hover:bg-gray-200 transition">&minus;</button>
                                        <input type="number" name="extra_selimut" id="extra_selimut" value="0"
                                            readonly
                                            class="w-10 text-center bg-transparent border-none text-sm font-bold p-0 focus:ring-0">
                                        <button type="button" onclick="adjustEkstra('extra_selimut', 1)"
                                            class="px-3 py-1 font-bold text-gray-600 hover:bg-gray-200 transition">&plus;</button>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-2">Pesan Tambahan
                                    (Opsional)</label>
                                <textarea name="pesan_tambahan" rows="3" placeholder="Tuliskan permintaan khusus atau catatan Anda disini..."
                                    class="w-full border border-gray-300 rounded-xl p-3 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm resize-none"></textarea>
                            </div>
                        </div>

                        <!-- 5. PEMBAYARAN -->
                        <div class="border border-amber-200 rounded-2xl p-5 mb-8">
                            <h3 class="font-bold text-amber-950 mb-4 border-b border-amber-100 pb-2 text-lg">5.
                                Pembayaran</h3>
                            <div class="mb-5">
                                <label class="block text-xs font-bold text-gray-700 mb-2">Metode Pembayaran</label>
                                <select name="metode_pembayaran" id="metode_pembayaran"
                                    onchange="toggleMetode(); qrisGenerated = false" required
                                    class="w-full sm:w-1/2 border border-gray-300 rounded-xl p-3 bg-white text-gray-900 shadow-sm focus:ring-amber-500 font-bold">
                                    <option value="Bayar di tempat">Bayar di Tempat</option>
                                    <option value="QRIS">Transfer QRIS</option>
                                </select>
                            </div>

                            <!-- AREA REDESIGN GENERATE QRIS -->
                            <div id="qrisBox" class="hidden grid-cols-1 gap-4">
                                <div
                                    class="border border-amber-200 bg-amber-50/50 rounded-xl p-6 text-center flex flex-col items-center justify-center min-h-[180px]">

                                    <!-- Keadaan 1: Sebelum Klik Generate -->
                                    <div x-show="!qrisGenerated && !showQrisLoading" class="space-y-4">
                                        <p class="text-sm font-bold text-amber-900">Pembayaran aman dengan Kode QRIS
                                            Otomatis</p>
                                        <button type="button"
                                            @click="showQrisLoading = true; setTimeout(() => { showQrisLoading = false; qrisGenerated = true; }, 1200)"
                                            class="bg-amber-600 hover:bg-amber-700 text-white text-xs font-black px-5 py-2.5 rounded-lg shadow transition">
                                            Generate QR Code
                                        </button>
                                    </div>

                                    <!-- Keadaan 2: Efek Loading Memuat Kode -->
                                    <div x-show="showQrisLoading" x-cloak class="flex flex-col items-center gap-2">
                                        <div
                                            class="w-6 h-6 border-2 border-amber-600 border-t-transparent rounded-full animate-spin">
                                        </div>
                                        <p class="text-xs text-amber-800 font-bold">Menghubungkan ke secure server...
                                        </p>
                                    </div>

                                    <!-- Keadaan 3: Sesudah Klik Generate (Keterangan Pengembangan API) -->
                                    <div x-show="qrisGenerated && !showQrisLoading" x-cloak
                                        class="space-y-2 max-w-md animate-fade-in">
                                        <div
                                            class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 text-xl mx-auto mb-1">
                                            🛠️</div>
                                        <h4 class="text-base font-black text-amber-950">API Payment Gateway Terdeteksi
                                        </h4>
                                        <p class="text-xs text-amber-900/80 font-semibold leading-relaxed">
                                            Modul QRIS saat ini berada di lingkungan Sandbox (Pengembangan Skripsi).
                                            <br>
                                            <span class="text-orange-700 font-black">Status: Berhasil Menghubungkan
                                                Handler Endpoint.</span>
                                        </p>
                                        <p class="text-[10px] text-gray-400 italic">Sistem siap diintegrasikan dengan
                                            Payment Gateway Midtrans / Xendit.</p>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- TOTAL & SUBMIT -->
                        <div
                            class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-amber-200">
                            <div class="w-full sm:w-auto text-center sm:text-left">
                                <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Pembayaran
                                </p>
                                <h2 class="text-3xl font-black text-amber-600" id="totalDisplay">Rp 0</h2>
                                <p class="text-xs font-bold text-gray-400 mt-1" id="durasiDisplay">0 Malam Menginap
                                </p>
                            </div>

                            @if ($isMaintenance)
                                <button type="button" disabled
                                    class="w-full sm:w-auto bg-gray-400 text-white font-bold text-lg py-4 px-10 rounded-xl cursor-not-allowed">Sistem
                                    Sedang Perbaikan</button>
                            @else
                                <button type="submit" id="btnSubmit"
                                    class="w-full sm:w-auto bg-amber-600 hover:bg-amber-700 text-white font-bold text-lg py-4 px-10 rounded-xl transition shadow-lg shadow-amber-600/30">
                                    Reservasi Sekarang
                                </button>
                            @endif
                        </div>
                    </form>
                @endif
            </div>

            <!-- BAGIAN KANAN: PREVIEW KAMAR -->
            <div class="w-full lg:w-[350px] shrink-0 lg:sticky lg:top-24">
                <div class="bg-white rounded-3xl shadow-xl border border-amber-100 p-6">
                    @if ($isMaintenance)
                        <div
                            class="mb-4 bg-red-50 border border-red-200 rounded-2xl p-4 shadow-sm text-center animate-pulse">
                            <span class="text-3xl block mb-2">🚧</span>
                            <h4 class="font-bold text-red-800 text-sm">Dalam Perbaikan</h4>
                            <p class="text-xs text-red-600 mt-1 leading-relaxed">Fitur pemesanan sedang dinonaktifkan
                                sementara.</p>
                        </div>
                    @endif

                    <div id="placeholderPreview" class="text-center py-16">
                        <span class="text-5xl block mb-4 opacity-50">🛏️</span>
                        <p class="text-sm text-gray-400 font-medium px-4">Pilih kelas kamar dan jumlah anggota untuk
                            melihat preview informasi.</p>
                    </div>

                    <div id="contentPreview" class="hidden">
                        <!-- Thumbnail Area -->
                        <img id="prevImg" src=""
                            class="w-full h-48 object-cover rounded-2xl mb-3 bg-gray-100 border border-gray-200 shadow-sm transition-all duration-300">
                        <div id="prevThumbnails" class="grid grid-cols-3 gap-2 mb-5"></div>

                        <!-- Class Info -->
                        <p class="text-[10px] font-bold text-amber-600 uppercase tracking-wider mb-1">Tipe Kamar</p>
                        <h4 id="prevNama"
                            class="text-2xl font-black text-gray-900 leading-tight mb-4 border-b border-gray-100 pb-3">
                        </h4>

                        <!-- Facilities Grid -->
                        <div class="mb-5">
                            <p class="text-xs font-bold text-gray-700 mb-2">Fasilitas Kamar:</p>
                            <ul id="prevFasilitas"
                                class="grid grid-cols-2 gap-y-2 gap-x-2 text-xs font-medium text-gray-600"></ul>
                        </div>

                        <!-- Room Availability Status Box -->
                        <div id="boxKamarKosong"
                            class="w-full py-3 rounded-xl border border-emerald-300 bg-emerald-50 text-center shadow-sm">
                            <p class="text-sm font-black text-emerald-700" id="sisaKamarCount">Memuat ketersediaan...
                            </p>
                        </div>

                        <!-- NOTIFIKASI PINTAR REKOMENDASI EXTRA BED (Dinamis via JS) -->
                        <div id="boxRekomendasiBed"
                            class="hidden mt-3 p-3.5 rounded-xl border border-orange-200 bg-orange-50 text-left shadow-sm animate-fade-in">
                            <div class="flex gap-2">
                                <span class="text-base">💡</span>
                                <div>
                                    <h5 class="text-xs font-black text-orange-950">Rekomendasi Kenyamanan</h5>
                                    <p class="text-[10.5px] text-orange-900/90 font-medium mt-0.5 leading-relaxed">Anda
                                        membawa <span id="txtJumlahAnggota" class="font-bold text-orange-700"></span>
                                        anggota. Agar tidur lebih nyaman di kamar berkapasitas 2 orang ini, disarankan
                                        menambah layanan <span class="font-bold underline">Extra Bed</span> di panel
                                        sebelah kiri.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        const kelasData = @json($kelasKamars);
        let currentHarga = 0;

        document.addEventListener('DOMContentLoaded', () => {
            filterKelasByAnggota();
            if (document.getElementById('kelas_kamar_id').value !== "") updatePreviewKamar();
        });

        // 1. Logika Jumlah Anggota (Dibatasi Maksimal 4)
        function adjustAnggota(val) {
            let input = document.getElementById('jumlah_anggota');
            let current = parseInt(input.value) || 1;
            let target = current + val;

            if (target >= 1 && target <= 4) { // Batasi 1 s.d 4 orang saja
                input.value = target;
                filterKelasByAnggota();
            }
        }

        function filterKelasByAnggota() {
            let jumlahTamu = parseInt(document.getElementById('jumlah_anggota').value) || 1;
            let selectKelas = document.getElementById('kelas_kamar_id');

            // Aturan Baru: Jika tamu >= 3, filter agar hanya menampilkan kamar berkapasitas 2 orang
            let targetKapasitasYgDicari = (jumlahTamu >= 3) ? 2 : jumlahTamu;

            Array.from(selectKelas.options).forEach(opt => {
                if (opt.value === "") return;
                let kapasitas = parseInt(opt.getAttribute('data-kapasitas')) || 1;

                // Menyaring agar tipe kamar yang kapasitasnya lebih kecil dari target disembunyikan
                if (kapasitas < targetKapasitasYgDicari) {
                    opt.style.display = 'none';
                    opt.disabled = true;
                    if (opt.selected) selectKelas.value = "";
                } else {
                    opt.style.display = 'block';
                    opt.disabled = false;
                }
            });
            updatePreviewKamar();
        }

        // 2. Logika Shortcut Durasi Waktu
        function updateCheckOutShortcut(selectObj) {
            let val = selectObj.value;
            if (val === 'custom') return;

            let checkInInput = document.getElementById('check_in').value;
            let cin = new Date(checkInInput);

            if (!isNaN(cin)) {
                let days = parseInt(val);
                cin.setDate(cin.getDate() + days);
                cin.setMinutes(cin.getMinutes() - cin.getTimezoneOffset());
                document.getElementById('check_out').value = cin.toISOString().slice(0, 16);

                hitungTotal();
                updatePreviewKamar();
            }
        }

        function resetShortcut() {
            document.getElementById('shortcut_durasi').value = 'custom';
        }

        // 3. Logika Metode Pembayaran
        function toggleMetode() {
            let metode = document.getElementById('metode_pembayaran').value;
            let box = document.getElementById('qrisBox');
            if (metode === 'QRIS') {
                box.classList.remove('hidden');
                box.classList.add('grid');
            } else {
                box.classList.add('hidden');
                box.classList.remove('grid');
            }
        }

        // 4. Hitungan Harga
        function adjustEkstra(id, val) {
            let input = document.getElementById(id);
            let current = parseInt(input.value) || 0;
            if (current + val >= 0) {
                input.value = current + val;
                hitungTotal();
            }
        }

        function hitungTotal() {
            let checkIn = new Date(document.getElementById('check_in').value);
            let checkOut = new Date(document.getElementById('check_out').value);
            let diffDays = 1;

            if (!isNaN(checkIn) && !isNaN(checkOut)) {
                let diffTime = checkOut - checkIn;
                diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                if (diffDays <= 0) diffDays = 1;
            }

            let qtyBed = parseInt(document.getElementById('extra_bed').value) || 0;
            let qtySelimut = parseInt(document.getElementById('extra_selimut').value) || 0;
            let totalBiaya = (currentHarga * diffDays) + (qtyBed * 100000) + (qtySelimut * 25000);

            document.getElementById('durasiDisplay').innerText = diffDays + ' Malam Menginap';
            document.getElementById('totalDisplay').innerText = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(totalBiaya);
        }

        // 5. Logika Panel Kanan (Preview Visual & Smart Recommendation)
        async function updatePreviewKamar() {
            const select = document.getElementById('kelas_kamar_id');
            const kelasId = select.value;
            const placeholder = document.getElementById('placeholderPreview');
            const content = document.getElementById('contentPreview');
            const btnSubmit = document.getElementById('btnSubmit');

            if (!kelasId) {
                currentHarga = 0;
                placeholder.classList.remove('hidden');
                content.classList.add('hidden');
                if (btnSubmit) {
                    btnSubmit.disabled = true;
                    btnSubmit.classList.add('opacity-50', 'cursor-not-allowed');
                }
                hitungTotal();
                return;
            }

            const option = select.options[select.selectedIndex];
            currentHarga = parseInt(option.getAttribute('data-harga')) || 0;
            document.getElementById('prevNama').innerText = option.text.split(' (')[0];

            const mainImgUrl = option.getAttribute('data-thumb');
            document.getElementById('prevImg').src = mainImgUrl;
            const arrayFoto = [...new Set([mainImgUrl, option.getAttribute('data-foto1'), option.getAttribute(
                'data-foto2'), option.getAttribute('data-foto3')].filter(f => f))];

            let galeriHTML = '';
            arrayFoto.forEach(url => {
                galeriHTML +=
                    `<div class="h-14 sm:h-16 rounded-xl overflow-hidden shadow-sm border border-gray-200 hover:border-amber-500 cursor-pointer transition" onclick="document.getElementById('prevImg').src='${url}'"><img src="${url}" class="w-full h-full object-cover"></div>`;
            });
            document.getElementById('prevThumbnails').innerHTML = galeriHTML;

            let fasText = option.getAttribute('data-fasilitas');
            let fasHtml = '';
            try {
                let parsed = JSON.parse(fasText);
                if (Array.isArray(parsed)) {
                    parsed.forEach(f => {
                        fasHtml +=
                            `<li class="flex items-center gap-1.5"><span class="text-amber-500">✔</span> ${f}</li>`;
                    });
                }
            } catch (e) {}
            document.getElementById('prevFasilitas').innerHTML = fasHtml;

            // LOGIKA DINAMIS NOTIFIKASI PINTAR EXTRA BED
            let jlhAnggota = parseInt(document.getElementById('jumlah_anggota').value) || 1;
            let boxBed = document.getElementById('boxRekomendasiBed');
            if (jlhAnggota >= 3) {
                document.getElementById('txtJumlahAnggota').innerText = jlhAnggota;
                boxBed.classList.remove('hidden');
            } else {
                boxBed.classList.add('hidden');
            }

            placeholder.classList.add('hidden');
            content.classList.remove('hidden');
            hitungTotal();

            // Cek Kamar Kosong Ke API Server
            const checkIn = document.getElementById('check_in').value;
            const checkOut = document.getElementById('check_out').value;
            const boxKosong = document.getElementById('boxKamarKosong');
            const countText = document.getElementById('sisaKamarCount');

            countText.innerText = "Mengecek ketersediaan...";
            boxKosong.className = "w-full py-3 rounded-xl border border-amber-300 bg-amber-50 text-center shadow-sm";

            try {
                let response = await fetch(
                    `/api/kamar-tersedia?kelas_id=${kelasId}&check_in=${checkIn}&check_out=${checkOut}`);
                let kamars = await response.json();

                if (kamars.length > 0) {
                    countText.innerText = `🔥 Tersisa ${kamars.length} Kamar Kosong!`;
                    boxKosong.className =
                        "w-full py-3 rounded-xl border border-emerald-300 bg-emerald-50 text-center shadow-sm text-emerald-700";
                    if (btnSubmit) {
                        btnSubmit.disabled = false;
                        btnSubmit.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                } else {
                    countText.innerText = "❌ Penuh di Tanggal Ini";
                    boxKosong.className =
                        "w-full py-3 rounded-xl border border-red-300 bg-red-50 text-center shadow-sm text-red-700 animate-pulse";
                    if (btnSubmit) {
                        btnSubmit.disabled = true;
                        btnSubmit.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                }
            } catch (error) {
                countText.innerText = "Gagal memuat info ketersediaan.";
                if (btnSubmit) {
                    btnSubmit.disabled = false;
                    btnSubmit.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
        }

        document.getElementById('formReservasi').addEventListener('submit', function(e) {
            if (!document.getElementById('kelas_kamar_id').value) {
                e.preventDefault();
                alert('Silakan pilih kelas kamar yang tersedia terlebih dahulu.');
            }
        });
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</x-lplayout>

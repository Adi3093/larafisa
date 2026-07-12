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

            <div class="flex-1 w-full bg-white rounded-3xl shadow-xl border border-amber-100 p-6 sm:p-8">
                @if (!$isLoggedIn)
                    <div class="text-center py-16">
                        <span class="text-6xl block mb-6">🔐</span>
                        <h3 class="text-2xl font-black text-amber-950 mb-2">Login Diperlukan</h3>
                        <p class="text-base text-gray-500 max-w-md mx-auto leading-relaxed mb-8">Untuk melanjutkan
                            proses pemesanan kamar hotel, silakan masuk ke dalam akun Anda.</p>
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
                                    <option value="custom" selected>Atur Manual di bawah</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div><label class="block text-xs font-bold text-gray-700 mb-1">Check-in</label><input
                                        type="datetime-local" name="check_in" id="check_in"
                                        value="{{ $checkin }}" onchange="resetShortcut(); hitungTotal()" required
                                        class="w-full border border-gray-300 rounded-xl p-3 shadow-sm focus:ring-amber-500">
                                </div>
                                <div><label class="block text-xs font-bold text-gray-700 mb-1">Check-out</label><input
                                        type="datetime-local" name="check_out" id="check_out"
                                        value="{{ $checkout }}" onchange="resetShortcut(); hitungTotal()" required
                                        class="w-full border border-gray-300 rounded-xl p-3 shadow-sm focus:ring-amber-500">
                                </div>
                            </div>
                        </div>

                        <div class="border border-amber-200 rounded-2xl p-5 mb-6">
                            <h3 class="font-bold text-amber-950 mb-4 border-b border-amber-100 pb-2 text-lg">3.
                                Identitas Pemesan</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-4">
                                <div><label class="block text-xs font-bold text-gray-700 mb-1">No. KTP
                                        (NIK)</label><input type="text" name="no_ktp"
                                        value="{{ $user->no_ktp ?? '' }}" required maxlength="16"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        class="w-full border border-gray-300 rounded-xl p-3 shadow-sm"></div>
                                <div><label class="block text-xs font-bold text-gray-700 mb-1">No. HP /
                                        WhatsApp</label><input type="text" name="no_hp" required maxlength="15"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        class="w-full border border-gray-300 rounded-xl p-3 shadow-sm"></div>
                            </div>
                            <div><label class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap</label><input
                                    type="text" name="nama_tamu" value="{{ $user->name ?? '' }}" required
                                    class="w-full border border-gray-300 rounded-xl p-3 shadow-sm"></div>
                        </div>

                        <div class="border border-amber-200 rounded-2xl p-5 mb-6">
                            <h3 class="font-bold text-amber-950 mb-4 border-b border-amber-100 pb-2 text-lg">4. Layanan
                                Ekstra</h3>
                            <div class="space-y-3 mb-4">
                                <div
                                    class="flex items-center justify-between p-3 border border-gray-200 rounded-xl bg-white shadow-sm">
                                    <p class="text-sm font-bold text-gray-800">Ekstra Bed (+Rp 100k)</p>
                                    <div class="flex items-center border border-gray-300 rounded-lg bg-gray-50"><button
                                            type="button" onclick="adjustEkstra('extra_bed', -1)"
                                            class="px-3 py-1 font-bold text-gray-600 hover:bg-gray-200">&minus;</button><input
                                            type="number" name="extra_bed" id="extra_bed" value="0" readonly
                                            class="w-10 text-center bg-transparent border-none text-sm font-bold p-0 focus:ring-0"><button
                                            type="button" onclick="adjustEkstra('extra_bed', 1)"
                                            class="px-3 py-1 font-bold text-gray-600 hover:bg-gray-200">&plus;</button>
                                    </div>
                                </div>
                                <div
                                    class="flex items-center justify-between p-3 border border-gray-200 rounded-xl bg-white shadow-sm">
                                    <p class="text-sm font-bold text-gray-800">Extra Selimut (+Rp 25k)</p>
                                    <div class="flex items-center border border-gray-300 rounded-lg bg-gray-50"><button
                                            type="button" onclick="adjustEkstra('extra_selimut', -1)"
                                            class="px-3 py-1 font-bold text-gray-600 hover:bg-gray-200">&minus;</button><input
                                            type="number" name="extra_selimut" id="extra_selimut" value="0"
                                            readonly
                                            class="w-10 text-center bg-transparent border-none text-sm font-bold p-0 focus:ring-0"><button
                                            type="button" onclick="adjustEkstra('extra_selimut', 1)"
                                            class="px-3 py-1 font-bold text-gray-600 hover:bg-gray-200">&plus;</button>
                                    </div>
                                </div>
                            </div>
                            <textarea name="pesan_tambahan" rows="3" placeholder="Pesan tambahan..."
                                class="w-full border border-gray-300 rounded-xl p-3 text-sm resize-none"></textarea>
                        </div>

                        <div class="border border-amber-200 rounded-2xl p-5 mb-8">
                            <h3 class="font-bold text-amber-950 mb-4 border-b border-amber-100 pb-2 text-lg">5.
                                Pembayaran</h3>
                            <div class="mb-5">
                                <select name="metode_pembayaran" id="metode_pembayaran" onchange="toggleMetode()"
                                    required
                                    class="w-full sm:w-1/2 border border-gray-300 rounded-xl p-3 bg-white font-bold">
                                    <option value="Bayar di tempat">Bayar di Tempat</option>
                                    <option value="QRIS">Transfer QRIS</option>
                                </select>
                            </div>
                            <div id="qrisBox" class="hidden grid-cols-1 gap-4">
                                <div class="border border-amber-200 bg-amber-50/50 rounded-xl p-6 text-center">
                                    <p class="text-sm font-bold text-amber-900">Pembayaran aman dengan Kode QRIS
                                        Otomatis</p>
                                    <p class="text-xs text-amber-700 mt-2">Kode QR akan otomatis muncul di halaman
                                        Riwayat setelah Anda melakukan reservasi.</p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-amber-200">
                            <div class="text-center sm:text-left">
                                <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Pembayaran
                                </p>
                                <h2 class="text-3xl font-black text-amber-600" id="totalDisplay">Rp 0</h2>
                                <p class="text-xs font-bold text-gray-400 mt-1" id="durasiDisplay">0 Malam Menginap
                                </p>
                            </div>
                            <button type="submit" id="btnSubmit"
                                class="w-full sm:w-auto bg-amber-600 hover:bg-amber-700 text-white font-bold text-lg py-4 px-10 rounded-xl transition shadow-lg shadow-amber-600/30">Reservasi
                                Sekarang</button>
                        </div>
                    </form>
                @endif
            </div>

            <div class="w-full lg:w-[350px] shrink-0 lg:sticky lg:top-24">
                <div class="bg-white rounded-3xl shadow-xl border border-amber-100 p-6">
                    <div id="placeholderPreview" class="text-center py-16">
                        <span class="text-5xl block mb-4 opacity-50">🛏️</span>
                        <p class="text-sm text-gray-400 font-medium px-4">Pilih kelas kamar dan jumlah anggota untuk
                            melihat preview informasi.</p>
                    </div>
                    <div id="contentPreview" class="hidden">
                        <img id="prevImg" src=""
                            class="w-full h-48 object-cover rounded-2xl mb-3 bg-gray-100 border border-gray-200 shadow-sm">
                        <div id="prevThumbnails" class="grid grid-cols-3 gap-2 mb-5"></div>
                        <p class="text-[10px] font-bold text-amber-600 uppercase tracking-wider mb-1">Tipe Kamar</p>
                        <h4 id="prevNama"
                            class="text-2xl font-black text-gray-900 leading-tight mb-4 border-b border-gray-100 pb-3">
                        </h4>
                        <div class="mb-5">
                            <ul id="prevFasilitas"
                                class="grid grid-cols-2 gap-y-2 gap-x-2 text-xs font-medium text-gray-600"></ul>
                        </div>
                        <div id="boxKamarKosong"
                            class="w-full py-3 rounded-xl border border-emerald-300 bg-emerald-50 text-center shadow-sm">
                            <p class="text-sm font-black text-emerald-700" id="sisaKamarCount">Memuat ketersediaan...
                            </p>
                        </div>
                        <div id="boxRekomendasiBed"
                            class="hidden mt-3 p-3.5 rounded-xl border border-orange-200 bg-orange-50 text-left shadow-sm">
                            <div class="flex gap-2"><span class="text-base">💡</span>
                                <p class="text-[10.5px] text-orange-900/90 font-medium leading-relaxed">Anda membawa
                                    <span id="txtJumlahAnggota" class="font-bold text-orange-700"></span> anggota.
                                    Disarankan menambah layanan Extra Bed.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mengirim data kelas dari Blade ke file JavaScript eksternal via window object
        window.kelasData = @json($kelasKamars);
    </script>
    <script src="{{ asset('js/landingpage/hreservasi.js') }}?v={{ time() }}"></script>
</x-lplayout>

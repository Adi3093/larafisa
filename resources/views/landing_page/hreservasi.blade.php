<x-lplayout>
    <!-- PEMANGGILAN CSS EKSTERNAL -->
    <link rel="stylesheet" href="{{ asset('css/landingpage/hreservasi.css') }}?v={{ time() }}">

    <div class="absolute top-0 left-0 w-full h-80 bg-amber-600 z-0"></div>

    <div class="relative z-10 min-h-screen pt-24 lg:pt-32 pb-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

        <div class="mb-8">
            <h1 class="text-white text-3xl font-extrabold tracking-tight">Formulir Reservasi Online</h1>
            <p class="text-amber-100 mt-1">Lengkapi data di bawah ini untuk mengamankan pesanan kamar Anda.</p>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm font-bold">✅ {{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm font-bold">⚠️ {{ session('error') }}</div>
        @endif

        <div class="flex flex-col lg:flex-row gap-8 items-start">

            {{-- Side Content --}}
            <div class="flex-1 w-full bg-white rounded-3xl shadow-xl border border-amber-100 p-6 sm:p-8">
                @if (!$isLoggedIn)
                    <div class="text-center py-16">
                        <span class="text-6xl block mb-6">🔐</span>
                        <h3 class="text-2xl font-black text-amber-950 mb-2">Login Diperlukan</h3>
                        <p class="text-base text-gray-500 max-w-md mx-auto leading-relaxed mb-8">Untuk melanjutkan proses pemesanan kamar hotel, silakan masuk ke dalam akun Anda.</p>
                        <div class="flex flex-col sm:flex-row justify-center gap-3">
                            <a href="{{ route('login') }}" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-md shadow-amber-600/30">Log In Sekarang</a>
                            <a href="{{ route('register') }}" class="bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold py-3 px-8 rounded-xl border border-amber-200 transition">Daftar Akun Baru</a>
                        </div>
                    </div>
                @else
                    <form action="{{ route('reservasi.tamu.store') }}" method="POST" id="formReservasi"
                        data-confirm="Konfirmasi Pesanan?|Pastikan data pemesan dan jadwal check-in Anda sudah benar sebelum melanjutkan."
                        data-theme="amber" data-btn="Ya, Buat Reservasi">
                        @csrf

                        {{-- Pilih Kamar --}}
                        <div class="border border-amber-200 rounded-2xl p-5 mb-6">
                            <h3 class="font-bold text-amber-950 mb-5 text-lg">Pilih Kamar</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-2">Jumlah Penginap</label>
                                    <div class="relative w-full sm:w-1/2 md:w-3/4">
                                        <div id="anggota_wrapper" class="flex items-center justify-between border border-amber-300 rounded-xl bg-white shadow-sm w-full transition-colors overflow-hidden">
                                            <input type="number" name="jumlah_anggota" id="jumlah_anggota" value="1" min="1" readonly class="w-full text-center bg-transparent border-none text-sm font-bold text-amber-950 p-2.5 focus:ring-0">
                                            <div class="flex border-l border-gray-200">
                                                <button type="button" onclick="adjustAnggota(-1)" class="px-3 py-2.5 font-bold text-gray-600 hover:bg-amber-50 transition">&lt;</button>
                                                <button type="button" onclick="adjustAnggota(1)" class="px-3 py-2.5 font-bold text-gray-600 hover:bg-amber-50 border-l border-gray-200 transition">&gt;</button>
                                            </div>
                                        </div>
                                        <div id="kapasitas_warning" onclick="alert('Jumlah penginap melebihi kapasitas standar kamar. Anda disarankan menambah layanan ekstra bed atau memesan 2 kamar.')" class="hidden absolute -right-2 -top-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-black shadow-md cursor-pointer hover:scale-110 transition animate-bounce">!</div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-2">Kelas Kamar</label>
                                    <div class="flex gap-2">
                                        <select name="kelas_kamar_id" id="kelas_kamar_id" onchange="updateUIKamar()" required class="flex-1 border border-amber-300 rounded-xl p-2.5 bg-white text-amber-950 shadow-sm focus:ring-amber-500 font-bold text-sm w-full">
                                            <option value="">-- Pilih Kelas --</option>
                                            @foreach ($kelasKamars as $kelas)
                                                <option value="{{ $kelas->id }}" data-harga="{{ $kelas->harga }}" data-kapasitas="{{ $kelas->kapasitas ?? 2 }}" data-fasilitas="{{ json_encode($kelas->fasilitas) }}" data-thumb="{{ asset('storage/' . $kelas->thumbnail) }}" data-foto1="{{ $kelas->foto_1 ? asset('storage/' . $kelas->foto_1) : '' }}" data-foto2="{{ $kelas->foto_2 ? asset('storage/' . $kelas->foto_2) : '' }}" data-foto3="{{ $kelas->foto_3 ? asset('storage/' . $kelas->foto_3) : '' }}" {{ $kelasId == $kelas->id ? 'selected' : '' }}>
                                                    {{ $kelas->nama_kelas }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="button" id="btnLihatKamar" onclick="document.getElementById('mobilePreviewModal').classList.remove('hidden')" class="hidden lg:hidden bg-amber-50 text-amber-700 font-bold px-4 py-2.5 rounded-xl border border-amber-300 text-xs whitespace-nowrap shadow-sm hover:bg-amber-100 transition">Lihat Kamar</button>
                                    </div>
                                </div>
                            </div>
                            {{-- Layanan Ekstra --}}
                            <div class="mb-5">
                                <label class="block text-xs font-bold text-gray-700 mb-2">Layanan Ekstra</label>
                                <div class="flex items-center justify-between border border-amber-300 rounded-xl bg-white shadow-sm w-full overflow-hidden transition-colors">
                                    <div class="flex flex-col sm:flex-row sm:items-center px-4 py-2 flex-1">
                                        <span class="text-sm font-bold text-gray-800">Ekstra Bed <span class="text-xs font-medium text-gray-500 block sm:inline sm:ml-1">(Termasuk Selimut & Bantal)</span></span>
                                        <span class="text-xs font-bold text-amber-600 mt-1 sm:mt-0 sm:ml-auto block sm:inline">Rp 50.000</span>
                                    </div>
                                    <div class="flex border-l border-gray-200">
                                        <input type="hidden" name="extra_selimut" id="extra_selimut" value="0"> 
                                        <input type="number" name="extra_bed" id="extra_bed" value="0" readonly class="w-12 text-center bg-transparent border-none text-sm font-bold text-amber-950 p-2.5 focus:ring-0">
                                        <div class="flex flex-col sm:flex-row border-l border-gray-200">
                                            <button type="button" onclick="adjustEkstra('extra_bed', -1)" class="px-3 py-2.5 font-bold text-gray-600 hover:bg-amber-50 transition h-full">&lt;</button>
                                            <button type="button" onclick="adjustEkstra('extra_bed', 1)" class="px-3 py-2.5 font-bold text-gray-600 hover:bg-amber-50 border-t sm:border-t-0 sm:border-l border-gray-200 transition h-full">&gt;</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="block text-xs font-bold text-gray-700 mb-2">Pesanan Tambahan</label>
                                <textarea name="pesan_tambahan" rows="3" placeholder="Contoh: Tolong siapkan kamar di lantai bawah..." class="w-full border border-gray-300 rounded-xl p-3 text-sm resize-none bg-white text-gray-900 focus:ring-amber-500 shadow-sm"></textarea>
                            </div>

                            <div class="pt-4 border-t border-amber-100 flex items-center gap-3">
                                <span class="text-sm font-bold text-gray-500">Total Biaya:</span>
                                <span class="text-2xl font-black text-amber-600" id="totalDisplayAtas">Rp 0</span>
                            </div>
                        </div>

                        {{-- Durasi Menginap --}}
                        <div class="border border-amber-200 rounded-2xl p-5 mb-6">
                            <h3 class="font-bold text-amber-950 mb-4 text-lg">Durasi Menginap</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal Check-in</label>
                                    <div class="flex items-center border border-gray-300 rounded-xl bg-white shadow-sm overflow-hidden focus-within:ring-2 focus-within:ring-amber-500 transition-all">
                                        <input type="datetime-local" name="check_in" id="check_in" value="{{ $checkin }}" onchange="syncMinCheckout(); hitungTotal();" required class="flex-1 border-none bg-transparent p-2.5 text-sm shadow-none focus:ring-0 font-bold text-amber-900 w-full cursor-pointer">
                                        <div class="flex border-l border-gray-200">
                                            <button type="button" onclick="adjustDate('check_in', -1)" class="px-3 py-2.5 text-gray-600 hover:bg-amber-50 font-bold transition">&lt;</button>
                                            <button type="button" onclick="adjustDate('check_in', 1)" class="px-3 py-2.5 text-gray-600 hover:bg-amber-50 font-bold border-l border-gray-200 transition">&gt;</button>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal Check-out (Default: 11:00)</label>
                                    <div class="flex items-center border border-gray-300 rounded-xl bg-white shadow-sm overflow-hidden focus-within:ring-2 focus-within:ring-amber-500 transition-all">
                                        <input type="datetime-local" name="check_out" id="check_out" value="{{ $checkout }}" onchange="syncMinCheckout(); hitungTotal();" required class="flex-1 border-none bg-transparent p-2.5 text-sm shadow-none focus:ring-0 font-bold text-amber-900 w-full cursor-pointer">
                                        <div class="flex border-l border-gray-200">
                                            <button type="button" onclick="adjustDate('check_out', -1)" class="px-3 py-2.5 text-gray-600 hover:bg-amber-50 font-bold transition">&lt;</button>
                                            <button type="button" onclick="adjustDate('check_out', 1)" class="px-3 py-2.5 text-gray-600 hover:bg-amber-50 font-bold border-l border-gray-200 transition">&gt;</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Identitas Tamu --}}
                        @php
                            $hasCompleteIdentity = !empty($user->no_ktp) && !empty($user->no_hp);
                        @endphp

                        @if ($hasCompleteIdentity)
                            <input type="hidden" name="no_ktp" value="{{ $user->no_ktp }}">
                            <input type="hidden" name="no_hp" value="{{ $user->no_hp }}">
                        @else
                            <div class="border border-amber-200 rounded-2xl p-5 mb-6">
                                <h3 class="font-bold text-amber-950 mb-4 text-lg">Identitas Pemesan</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    <div><label class="block text-xs font-bold text-gray-700 mb-1">No. KTP (NIK)</label><input type="text" name="no_ktp" value="{{ $user->no_ktp ?? '' }}" required maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="16 digit NIK..." class="w-full border border-gray-300 bg-white text-gray-900 rounded-xl p-3 shadow-sm text-sm"></div>
                                    <div><label class="block text-xs font-bold text-gray-700 mb-1">No. HP / WhatsApp</label><input type="text" name="no_hp" value="{{ $user->no_hp ?? '' }}" required maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="08..." class="w-full border border-gray-300 bg-white text-gray-900 rounded-xl p-3 shadow-sm text-sm"></div>
                                </div>
                            </div>
                        @endif

                        <!-- SECTION 4: METODE PEMBAYARAN -->
                        <div class="border border-amber-200 rounded-2xl p-5 mb-8">
                            <h3 class="font-bold text-amber-950 mb-4 text-lg">Metode Pembayaran</h3>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-2">Pilih metode Pembayaran</label>
                                <select name="metode_pembayaran" required class="w-full sm:w-1/2 border border-amber-300 rounded-xl p-3 bg-white text-amber-950 shadow-sm focus:ring-amber-500 font-bold text-sm transition-colors">
                                    <option value="Bayar di tempat">Bayar di Tempat</option>
                                    <option value="QRIS">Transfer / QRIS</option>
                                </select>
                            </div>
                        </div>

                        <!-- SUBMIT BUTTON -->
                        <div class="flex justify-end">
                            <button type="submit" id="btnSubmit" class="w-full sm:w-auto bg-amber-600 hover:bg-amber-700 text-white font-bold text-base py-4 px-12 rounded-xl transition shadow-lg shadow-amber-600/30">Simpan Reservasi</button>
                        </div>
                    </form>
                @endif
            </div>

            <!-- BAGIAN KANAN: PREVIEW KAMAR DESKTOP -->
            <div class="hidden lg:block w-[350px] shrink-0 sticky top-24">
                <div class="bg-white rounded-3xl shadow-xl border border-amber-100 p-6">
                    <div id="placeholderPreview" class="text-center py-16">
                        <span class="text-5xl block mb-4 opacity-50">🛏️</span>
                        <p class="text-sm text-gray-400 font-medium px-4">Pilih kelas kamar untuk melihat preview.</p>
                    </div>
                    <div id="contentPreview" class="hidden">
                        <img id="prevImg" src="" class="w-full h-48 object-cover rounded-2xl mb-3 bg-gray-100 border border-gray-200 shadow-sm">
                        <div id="prevThumbnails" class="grid grid-cols-3 gap-2 mb-5"></div>
                        
                        <div class="flex justify-between items-end mb-4 border-b border-gray-100 pb-3">
                            <h4 id="prevNama" class="text-xl font-black text-gray-900 leading-tight"></h4>
                            <!-- Pill "Jumlah Kamar / Kapasitas" -->
                            <span id="prevKapasitas" class="text-[10px] font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded-lg border border-gray-200 whitespace-nowrap"></span>
                        </div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Fasilitas :</p>
                        <div class="mb-5">
                            <ul id="prevFasilitas" class="grid grid-cols-2 gap-y-2 gap-x-2 text-xs font-medium text-gray-600"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL POPUP PREVIEW KAMAR MOBILE -->
    <div id="mobilePreviewModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/70 backdrop-blur-sm" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4 text-center">
            <div class="relative w-full max-w-sm bg-white rounded-3xl shadow-2xl border border-gray-200 text-left overflow-hidden transform transition-all">
                <div class="absolute top-3 right-3 bg-black/40 rounded-full text-white p-1 cursor-pointer hover:bg-black/60 transition z-10" onclick="document.getElementById('mobilePreviewModal').classList.add('hidden')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <div class="p-5">
                    <img id="mobImg" src="" class="w-full h-48 object-cover rounded-2xl mb-3 bg-gray-100 border border-gray-200 shadow-sm">
                    <div id="mobThumbnails" class="grid grid-cols-3 gap-2 mb-5"></div>
                    
                    <div class="flex justify-between items-end mb-4 border-b border-gray-100 pb-3">
                        <h4 id="mobNama" class="text-xl font-black text-gray-900 leading-tight"></h4>
                        <span id="mobKapasitas" class="text-[10px] font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded-lg border border-gray-200 whitespace-nowrap"></span>
                    </div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Fasilitas :</p>
                    <ul id="mobFasilitas" class="grid grid-cols-2 gap-y-2 gap-x-2 text-xs font-medium text-gray-600"></ul>
                </div>
            </div>
        </div>
    </div>

    <!-- PEMANGGILAN SCRIPT EKSTERNAL JS -->
    <script src="{{ asset('js/landingpage/hreservasi.js') }}?v={{ time() }}"></script>
</x-lplayout>
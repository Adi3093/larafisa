<x-lplayout>
    <div class="absolute top-0 left-0 w-full h-80 bg-amber-600 z-0"></div>

    <div class="relative z-10 min-h-screen pt-24 lg:pt-32 pb-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

        <div class="mb-8">
            <h1 class="text-white text-3xl font-extrabold tracking-tight">Reservasi Online</h1>
            <p class="text-amber-100 mt-1">Lengkapi data di bawah ini untuk mengamankan kamar Anda.</p>
        </div>

        @if (session('success'))
            <div
                class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm font-bold">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm font-bold">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-8 items-start">

            <div class="flex-1 w-full bg-white rounded-3xl shadow-xl border border-amber-100 p-6 sm:p-8">
                <form action="{{ route('reservasi.tamu.store') }}" method="POST" id="formReservasi">
                    @csrf

                    <div class="bg-amber-50 p-5 rounded-2xl border border-amber-200 mb-8">
                        <h3 class="font-bold text-amber-950 mb-4 border-b border-amber-200 pb-2">1. Pilih Kamar</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-amber-900 mb-1">Kelas Kamar</label>
                                <select name="kelas_kamar_id" id="kelas_kamar_id" onchange="updatePreviewKamar()"
                                    required
                                    class="w-full border border-amber-300 rounded-xl p-3 bg-white text-amber-950 shadow-sm focus:ring-amber-500">
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach ($kelasKamars as $kelas)
                                        <option value="{{ $kelas->id }}" data-harga="{{ $kelas->harga }}"
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
                            <div>
                                <label class="block text-xs font-bold text-amber-900 mb-1">Pilih Ruangan</label>
                                <select name="kamar_id" id="kamar_id" required
                                    class="w-full border border-amber-300 rounded-xl p-3 bg-white text-amber-950 shadow-sm focus:ring-amber-500">
                                    <option value="">-- Pilih Kelas Dahulu --</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <h3 class="font-bold text-amber-950 mb-4 border-b border-gray-100 pb-2">2. Identitas Pemesan</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">No. KTP (NIK)</label>
                            <input type="text" name="no_ktp" value="{{ $user->no_ktp }}" required maxlength="16"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="w-full border border-gray-300 rounded-xl p-3 bg-white text-gray-900 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            <p class="text-[10px] text-amber-600 mt-1">*Sesuai profil akun Anda (Bisa diedit)</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Alamat Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" required
                                class="w-full border border-gray-300 rounded-xl p-3 bg-white text-gray-900 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Nomor WhatsApp Aktif</label>
                            <input type="text" name="no_hp" required maxlength="15"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Cth: 0812345678"
                                class="w-full border border-gray-300 rounded-xl p-3 text-gray-900 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Umur Pemesan Utama</label>
                            <input type="number" name="umur" id="umur" required min="1"
                                placeholder="Usia Anda saat ini..."
                                class="w-full border border-gray-300 rounded-xl p-3 text-gray-900 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        </div>
                    </div>

                    <div class="mb-8 p-5 border border-gray-200 rounded-2xl bg-gray-50/50">
                        <label class="block text-xs font-bold text-gray-700 mb-3">Daftar Nama Tamu yang Menginap</label>
                        <div id="containerNamaTamu" class="space-y-3">
                            <input type="text" name="nama_tamu[]" value="{{ $user->name }}" required
                                placeholder="Nama Lengkap Pemesan 1"
                                class="w-full border border-gray-300 rounded-xl p-3 text-gray-900 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        </div>
                        <button type="button" onclick="tambahNamaTamu()"
                            class="mt-4 text-xs font-bold text-amber-600 hover:text-amber-800 transition">+ Tambah
                            Anggota Lainnya</button>
                    </div>

                    <h3 class="font-bold text-amber-950 mb-4 border-b border-gray-100 pb-2">3. Waktu & Tambahan</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Check-In</label>
                            <input type="datetime-local" name="check_in" id="check_in" value="{{ $checkin }}"
                                onchange="hitungTotal()" required
                                class="w-full border border-gray-300 rounded-xl p-3 shadow-sm focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Check-Out</label>
                            <input type="datetime-local" name="check_out" id="check_out" value="{{ $checkout }}"
                                onchange="hitungTotal()" required
                                class="w-full border border-gray-300 rounded-xl p-3 shadow-sm focus:ring-amber-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                        <div
                            class="flex items-center justify-between p-3 border border-gray-200 rounded-xl bg-white shadow-sm">
                            <div>
                                <p class="text-sm font-bold text-gray-800">Extra Bed</p>
                                <p class="text-xs text-gray-400 mt-0.5">+Rp 100.000 / unit</p>
                            </div>
                            <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden bg-gray-50">
                                <button type="button" onclick="adjustQty('extra_bed', -1)"
                                    class="px-3 py-1 font-bold text-gray-600 hover:bg-gray-200">−</button>
                                <input type="number" name="extra_bed" id="extra_bed" value="0" readonly
                                    class="w-10 text-center bg-transparent border-none text-sm font-bold p-0 focus:ring-0">
                                <button type="button" onclick="adjustQty('extra_bed', 1)"
                                    class="px-3 py-1 font-bold text-gray-600 hover:bg-gray-200">&plus;</button>
                            </div>
                        </div>
                        <div
                            class="flex items-center justify-between p-3 border border-gray-200 rounded-xl bg-white shadow-sm">
                            <div>
                                <p class="text-sm font-bold text-gray-800">Extra Selimut</p>
                                <p class="text-xs text-gray-400 mt-0.5">+Rp 25.000 / unit</p>
                            </div>
                            <div
                                class="flex items-center border border-gray-300 rounded-lg overflow-hidden bg-gray-50">
                                <button type="button" onclick="adjustQty('extra_selimut', -1)"
                                    class="px-3 py-1 font-bold text-gray-600 hover:bg-gray-200">−</button>
                                <input type="number" name="extra_selimut" id="extra_selimut" value="0"
                                    readonly
                                    class="w-10 text-center bg-transparent border-none text-sm font-bold p-0 focus:ring-0">
                                <button type="button" onclick="adjustQty('extra_selimut', 1)"
                                    class="px-3 py-1 font-bold text-gray-600 hover:bg-gray-200">&plus;</button>
                            </div>
                        </div>
                    </div>

                    <h3 class="font-bold text-amber-950 mb-4 border-b border-gray-100 pb-2">4. Metode Pembayaran</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                        <div>
                            <select name="metode_pembayaran" id="metode_pembayaran" onchange="toggleSubMetode()"
                                required
                                class="w-full border border-gray-300 rounded-xl p-3 bg-white text-gray-900 shadow-sm focus:ring-amber-500">
                                <option value="">-- Pilih Metode --</option>
                                <option value="Bayar di tempat">Bayar di Tempat (Resepsionis)</option>
                                <option value="Transfer">Transfer Online</option>
                            </select>
                        </div>
                        <div id="subMetodeDiv" class="hidden">
                            <select name="detail_pembayaran" id="detail_pembayaran"
                                class="w-full border border-gray-300 rounded-xl p-3 bg-blue-50 text-blue-900 shadow-sm focus:ring-blue-500">
                                <option value="Transfer Bank">Transfer Bank</option>
                                <option value="Q-RIS">Scan Q-RIS</option>
                            </select>
                        </div>
                    </div>

                    <div
                        class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8 pt-6 border-t border-amber-200">
                        <div>
                            <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Pembayaran</p>
                            <h2 class="text-3xl font-black text-amber-600" id="totalDisplay">Rp 0</h2>
                            <p class="text-xs font-bold text-gray-400 mt-1" id="durasiDisplay">0 Malam</p>
                        </div>
                        <button type="button" onclick="validasiDanSubmit()"
                            class="w-full sm:w-auto bg-amber-600 hover:bg-amber-700 text-white font-bold text-lg py-4 px-10 rounded-2xl transition shadow-lg shadow-amber-600/30 transform hover:-translate-y-1">
                            Buat Reservasi
                        </button>
                    </div>
                </form>
            </div>

            <div class="w-full lg:w-80 shrink-0 sticky top-24">
                <div class="bg-white rounded-3xl shadow-xl border border-amber-100 p-6">
                    <h3 class="font-bold text-amber-950 mb-4 text-lg border-b border-amber-100 pb-2">Kamar Pilihan Anda
                    </h3>

                    <div id="placeholderPreview" class="text-center py-8">
                        <svg class="w-16 h-16 text-gray-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        <p class="text-sm text-gray-400 font-medium">Silakan pilih kelas kamar terlebih dahulu untuk
                            melihat detail.</p>
                    </div>

                    <div id="contentPreview" class="hidden">

                        <img id="prevImg" src=""
                            class="w-full h-44 object-cover rounded-2xl mb-3 bg-gray-100 shadow-sm border border-gray-200 transition-all duration-300">

                        <div id="prevThumbnails" class="grid grid-cols-3 gap-2 mb-4">
                        </div>

                        <h4 id="prevNama" class="text-xl font-black text-gray-900 mb-3"></h4>
                        <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 mb-4">
                            <p class="text-xs font-bold text-amber-800 mb-2 uppercase">Fasilitas:</p>
                            <p id="prevFasilitas" class="text-sm font-medium text-amber-950 leading-relaxed"></p>
                        </div>
                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 flex gap-3 items-start">
                            <svg class="w-6 h-6 text-blue-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-[11px] font-medium text-blue-900 leading-tight">Pilih opsi ruangan
                                <strong>"Acak / Random"</strong> jika Anda ingin kami yang mencarikan kamar kosong
                                terbaik untuk kelas ini.
                            </p>
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
            if (document.getElementById('kelas_kamar_id').value !== "") {
                updatePreviewKamar();
            }
        });

        async function updatePreviewKamar() {
            const select = document.getElementById('kelas_kamar_id');
            const kelasId = select.value;
            const kamarSelect = document.getElementById('kamar_id');

            const placeholder = document.getElementById('placeholderPreview');
            const content = document.getElementById('contentPreview');

            if (!kelasId) {
                kamarSelect.innerHTML = '<option value="">-- Pilih Kelas Dahulu --</option>';
                currentHarga = 0;
                placeholder.classList.remove('hidden');
                content.classList.add('hidden');
                hitungTotal();
                return;
            }
            const option = select.options[select.selectedIndex];
            currentHarga = parseInt(option.getAttribute('data-harga')) || 0;
            document.getElementById('prevNama').innerText = option.text;

            const mainImgUrl = option.getAttribute('data-thumb');
            document.getElementById('prevImg').src = mainImgUrl;
            const foto1 = option.getAttribute('data-foto1');
            const foto2 = option.getAttribute('data-foto2');
            const foto3 = option.getAttribute('data-foto3');
            let arrayFoto = [mainImgUrl, foto1, foto2, foto3].filter(foto => foto && foto !== '');
            arrayFoto = [...new Set(arrayFoto)];

            let galeriHTML = '';
            arrayFoto.forEach(fotoUrl => {
                galeriHTML += `
                    <div class="h-12 sm:h-16 rounded-xl overflow-hidden shadow-sm border-2 border-transparent hover:border-amber-400 cursor-pointer transition" onclick="document.getElementById('prevImg').src='${fotoUrl}'">
                        <img src="${fotoUrl}" class="w-full h-full object-cover">
                    </div>
                `;
            });
            document.getElementById('prevThumbnails').innerHTML = galeriHTML;


            let fasString = option.getAttribute('data-fasilitas');
            let fasText = fasString;
            try {
                let parsed = JSON.parse(fasString);
                if (Array.isArray(parsed)) fasText = parsed.join(', ');
            } catch (e) {}
            document.getElementById('prevFasilitas').innerText = fasText;

            placeholder.classList.add('hidden');
            content.classList.remove('hidden');
            const checkIn = document.getElementById('check_in').value;
            const checkOut = document.getElementById('check_out').value;

            kamarSelect.innerHTML = '<option value="">Sedang memuat ruangan...</option>';
            try {
                let response = await fetch(
                    `/api/kamar-tersedia?kelas_id=${kelasId}&check_in=${checkIn}&check_out=${checkOut}`);
                let kamars = await response.json();

                kamarSelect.innerHTML =
                    '<option value="random" class="font-bold text-amber-600">🎲 Pilih Acak / Random</option>';

                if (kamars.length > 0) {
                    kamars.forEach(kmr => {
                        let opt = document.createElement('option');
                        opt.value = kmr.id;
                        opt.text = 'Ruangan ' + kmr.nomor_ruangan;
                        kamarSelect.appendChild(opt);
                    });
                }
            } catch (error) {
                kamarSelect.innerHTML = '<option value="random">🎲 Pilih Acak / Random</option>';
            }
            hitungTotal();
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

        function adjustQty(id, val) {
            let input = document.getElementById(id);
            let current = parseInt(input.value) || 0;
            if (current + val >= 0) {
                input.value = current + val;
                hitungTotal();
            }
        }

        function toggleSubMetode() {
            let val = document.getElementById('metode_pembayaran').value;
            let sub = document.getElementById('subMetodeDiv');
            if (val === 'Transfer') {
                sub.classList.remove('hidden');
            } else {
                sub.classList.add('hidden');
            }
        }

        function tambahNamaTamu() {
            let container = document.getElementById('containerNamaTamu');
            let divWrapper = document.createElement('div');
            divWrapper.className = 'flex items-center gap-2 mt-2';
            let input = document.createElement('input');
            input.type = 'text';
            input.name = 'nama_tamu[]';
            input.placeholder = 'Nama Anggota Tambahan';
            input.className =
                'flex-1 border border-gray-300 rounded-xl p-3 text-gray-900 shadow-sm focus:border-amber-500 focus:ring-amber-500';
            let btnRemove = document.createElement('button');
            btnRemove.type = 'button';
            btnRemove.innerHTML = 'Hapus';
            btnRemove.className =
                'bg-red-50 hover:bg-red-100 text-red-600 px-4 py-3 rounded-xl font-bold text-xs transition border border-red-200';
            btnRemove.onclick = function() {
                container.removeChild(divWrapper);
            };

            divWrapper.appendChild(input);
            divWrapper.appendChild(btnRemove);
            container.appendChild(divWrapper);
        }

        function validasiDanSubmit() {
            let umur = parseInt(document.getElementById('umur').value) || 0;
            if (umur < 17) {
                alert('Maaf, Anda harus berusia minimal 17 tahun untuk melakukan reservasi hotel.');
                return;
            }
            if (!document.getElementById('kelas_kamar_id').value) {
                alert('Silakan pilih kelas kamar terlebih dahulu.');
                return;
            }
            document.getElementById('formReservasi').submit();
        }
    </script>
</x-lplayout>

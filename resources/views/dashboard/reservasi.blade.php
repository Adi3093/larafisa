<x-dblayout>
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-900">Reservasi Kamar</h1>
            <button onclick="document.getElementById('modalAddReservasi').classList.remove('hidden')"
                class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-indigo-700 transition shadow-sm flex items-center gap-2">
                + Check-In Baru (Walk-In)
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Kamar Siap (Ready)</p>
                    <p class="text-3xl font-black text-green-600 mt-1">{{ $cards['Tersedia'] }} <span
                            class="text-sm font-normal text-gray-400">Unit</span></p>
                </div>
                <div class="bg-green-50 p-3 rounded-lg text-green-600">
                    <svg class="size-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Kamar Terpakai (In Use)</p>
                    <p class="text-3xl font-black text-blue-600 mt-1">{{ $cards['Terpakai'] }} <span
                            class="text-sm font-normal text-gray-400">Unit</span></p>
                </div>
                <div class="bg-blue-50 p-3 rounded-lg text-blue-600">
                    <svg class="size-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Dalam Perawatan (Maintenance)
                    </p>
                    <p class="text-3xl font-black text-red-600 mt-1">{{ $cards['Maintenance'] }} <span
                            class="text-sm font-normal text-gray-400">Unit</span></p>
                </div>
                <div class="bg-red-50 p-3 rounded-lg text-red-600">
                    <svg class="size-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 text-green-700 rounded-r-lg shadow-sm">
                {{ session('success') }}</div>
        @endif

        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm mb-6">
            <form method="GET" action="{{ route('reservasi') }}"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">
                <div class="lg:col-span-2">
                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Cari Tamu / No. Tiket</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Ketik nama tamu atau nomor..."
                        class="w-full border-gray-300 rounded-lg shadow-sm text-sm p-2 border focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Filter Kelas</label>
                    <select name="filter_kelas"
                        class="w-full border-gray-300 rounded-lg shadow-sm text-sm p-2 border bg-white focus:ring-indigo-500">
                        <option value="">Semua Kelas</option>
                        @foreach ($semuaKelas as $kelas)
                            <option value="{{ $kelas->id }}"
                                {{ request('filter_kelas') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">No. Ruangan</label>
                    <input type="text" name="filter_nomor" value="{{ request('filter_nomor') }}"
                        placeholder="Cth: 101"
                        class="w-full border-gray-300 rounded-lg shadow-sm text-sm p-2 border focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Tgl Check-In</label>
                    <input type="date" name="filter_checkin" value="{{ request('filter_checkin') }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm text-sm p-2 border focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Tgl Check-Out</label>
                    <input type="date" name="filter_checkout" value="{{ request('filter_checkout') }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm text-sm p-2 border focus:ring-indigo-500">
                </div>
                <div class="lg:col-span-6 flex justify-between items-center border-t pt-3 mt-1">
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <span>Tampilkan Baris:</span>
                        <select name="per_page" onchange="this.form.submit()"
                            class="border border-gray-300 rounded p-1 text-xs bg-white">
                            @foreach ([5, 10, 15, 20] as $size)
                                <option value="{{ $size }}"
                                    {{ request('per_page') == $size ? 'selected' : '' }}>{{ $size }} Data
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        @if (request()->hasAny(['search', 'filter_kelas', 'filter_nomor', 'filter_checkin', 'filter_checkout']))
                            <a href="{{ route('reservasi') }}"
                                class="rounded-lg bg-red-50 text-red-600 px-4 py-2 text-sm font-medium border border-red-100 hover:bg-red-100 transition">Reset
                                Filter</a>
                        @endif
                        <button type="submit"
                            class="rounded-lg bg-indigo-600 text-white px-5 py-2 text-sm font-bold hover:bg-indigo-700 transition shadow-sm">Terapkan
                            Pencarian</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden mb-4">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 bg-white text-sm text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 font-medium text-gray-900">No. Reservasi</th>
                            <th class="px-4 py-3 font-medium text-gray-900">Nama Tamu & Kontak</th>
                            <th class="px-4 py-3 font-medium text-gray-900">Ruangan & Ekstra</th>
                            <th class="px-4 py-3 font-medium text-gray-900">Durasi Menginap</th>
                            <th class="px-4 py-3 font-medium text-gray-900 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($reservasis as $res)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 font-mono font-bold text-gray-700">{{ $res->no_reservasi }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-bold text-gray-900">{{ $res->nama_tamu }}</div>
                                    <div class="text-gray-500 text-xs">NIK: {{ $res->no_ktp }}</div>
                                    <div class="text-gray-500 text-xs">{{ $res->no_hp }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-black text-indigo-600 text-base">Kamar
                                        #{{ $res->kamar->nomor_ruangan }}</div>
                                    <div class="text-gray-500 text-xs font-medium mb-1">
                                        {{ $res->kamar->kelasKamar->nama_kelas }}</div>

                                    @if ($res->ekstra && count($res->ekstra) > 0)
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @foreach ($res->ekstra as $eks)
                                                <span
                                                    class="inline-flex items-center rounded bg-yellow-50 px-1.5 py-0.5 text-[10px] font-medium text-yellow-800 border border-yellow-200">
                                                    + {{ $eks }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    <div class="text-xs font-semibold"><span class="text-green-600">In :</span>
                                        {{ \Carbon\Carbon::parse($res->check_in)->translatedFormat('d M Y') }}</div>
                                    <div class="text-xs font-semibold"><span class="text-red-600">Out:</span>
                                        {{ \Carbon\Carbon::parse($res->check_out)->translatedFormat('d M Y') }}</div>
                                </td>
                                <td class="px-4 py-3 text-center space-x-1 whitespace-nowrap">
                                    <button
                                        onclick="openEditReservasi({{ $res->id }}, '{{ $res->nama_tamu }}', '{{ $res->no_hp }}', {{ $res->kamar->kelas_kamar_id }}, {{ $res->kamar_id }}, '{{ $res->check_in }}', '{{ $res->check_out }}', {{ json_encode($res->ekstra ?? []) }})"
                                        class="rounded bg-indigo-50 px-3 py-1.5 text-xs font-medium text-indigo-700 hover:bg-indigo-100">Kelola</button>

                                    <form action="{{ route('reservasi.destroy', $res->id) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Batalkan reservasi ini secara paksa?');">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="rounded bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-12 text-center text-gray-500">Tidak ada data
                                    reservasi walk-in yang cocok atau ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">{{ $reservasis->links() }}</div>
    </div>

    <div id="modalAddReservasi" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b font-bold text-lg text-gray-900">Registrasi Kamar Walk-In
                </div>
                <form method="POST" action="{{ route('reservasi.store') }}" class="p-6 space-y-4">
                    @csrf
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap Tamu</label><input
                            type="text" name="nama_tamu" required class="w-full border rounded p-2 text-sm"></div>

                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Nomor KTP (NIK)</label><input
                            type="number" name="no_ktp" required class="w-full border rounded p-2 text-sm"></div>

                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP/WhatsApp</label><input
                            type="text" name="no_hp" required class="w-full border rounded p-2 text-sm"></div>

                    <div class="grid grid-cols-2 gap-3 p-3 bg-indigo-50 rounded-lg border border-indigo-100">
                        <div>
                            <label class="block text-sm font-bold text-indigo-900 mb-1">1. Pilih Tipe Kelas</label>
                            <select id="add_kelas_select"
                                onchange="filterRuangan('add_kelas_select', 'add_ruangan_select')"
                                class="w-full border-gray-300 rounded p-2 text-sm bg-white focus:border-indigo-500">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($semuaKelas as $kelas)
                                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-indigo-900 mb-1">2. Pilih No. Ruangan</label>
                            <select id="add_ruangan_select" name="kamar_id" required
                                class="w-full border-gray-300 rounded p-2 text-sm bg-white focus:border-indigo-500">
                                <option value="">-- Menunggu Kelas --</option>
                                @foreach ($kamarTersedia as $kmr)
                                    <option value="{{ $kmr->id }}" data-kelas="{{ $kmr->kelas_kamar_id }}"
                                        style="display:none;">#{{ $kmr->nomor_ruangan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Permintaan Ekstra
                            (Opsional)</label>
                        <div class="grid grid-cols-2 gap-2 bg-gray-50 p-3 rounded border">
                            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="ekstra[]"
                                    value="Extra Bed" class="rounded text-indigo-600"> Extra Bed</label>
                            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="ekstra[]"
                                    value="Extra Selimut" class="rounded text-indigo-600"> Extra Selimut</label>
                            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="ekstra[]"
                                    value="Extra Bantal" class="rounded text-indigo-600"> Extra Bantal</label>
                            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="ekstra[]"
                                    value="Sarapan Tambahan" class="rounded text-indigo-600"> Sarapan Tambahan</label>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Check-In</label><input
                                type="date" name="check_in" value="{{ date('Y-m-d') }}" required
                                class="w-full border rounded p-2 text-sm"></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                                Check-Out</label><input type="date" name="check_out" required
                                class="w-full border rounded p-2 text-sm"></div>
                    </div>

                    <div class="flex justify-end gap-2 border-t pt-4 mt-6">
                        <button type="button"
                            onclick="document.getElementById('modalAddReservasi').classList.add('hidden')"
                            class="px-4 py-2 border rounded bg-white text-gray-700 hover:bg-gray-50 text-sm">Batal</button>
                        <button type="submit"
                            class="px-5 py-2 rounded bg-indigo-600 text-white font-bold hover:bg-indigo-700 text-sm">Kunci
                            Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modalEditReservasi" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden relative">
                <div
                    class="bg-gray-50 px-6 py-4 border-b font-bold text-lg text-gray-900 flex justify-between items-center">
                    <span>Kelola Reservasi</span>

                    <form id="formCheckout" method="POST" action="">
                        @csrf
                        <button type="submit"
                            onclick="return confirm('Tamu akan di-Checkout HARI INI dan kamar akan dikosongkan. Lanjutkan?')"
                            class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-xs font-bold hover:bg-red-200 border border-red-200 flex items-center gap-1 shadow-sm">
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Check-Out Sekarang
                        </button>
                    </form>
                </div>

                <form id="formEditReservasi" method="POST" action="" class="p-6 space-y-4">
                    @csrf @method('PUT')
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap Tamu</label><input
                            type="text" id="edit_nama_tamu" name="nama_tamu" required
                            class="w-full border rounded p-2 text-sm"></div>

                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Nomor KTP (NIK)</label><input
                            type="number" id="edit_no_ktp" name="no_ktp" required
                            class="w-full border rounded p-2 text-sm"></div>

                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP/WhatsApp</label><input
                            type="text" id="edit_no_hp" name="no_hp" required
                            class="w-full border rounded p-2 text-sm"></div>

                    <div class="grid grid-cols-2 gap-3 p-3 bg-yellow-50 rounded-lg border border-yellow-100">
                        <div class="col-span-2 text-xs font-bold text-yellow-800 mb-1">Pindah Kamar (Opsional)</div>
                        <div>
                            <select id="edit_kelas_select"
                                onchange="filterRuangan('edit_kelas_select', 'edit_kamar_id')"
                                class="w-full border-gray-300 rounded p-2 text-sm bg-white focus:border-yellow-500">
                                <option value="">-- Ubah Kelas --</option>
                                @foreach ($semuaKelas as $kelas)
                                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <select id="edit_kamar_id" name="kamar_id" required
                                class="w-full border-gray-300 rounded p-2 text-sm bg-white focus:border-yellow-500">
                                @foreach ($semuaKamar as $kmr)
                                    <option value="{{ $kmr->id }}" data-kelas="{{ $kmr->kelas_kamar_id }}">
                                        #{{ $kmr->nomor_ruangan }} ({{ $kmr->status }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Permintaan Ekstra</label>
                        <div class="grid grid-cols-2 gap-2 bg-gray-50 p-3 rounded border">
                            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="ekstra[]"
                                    value="Extra Bed" class="edit-ekstra-cb rounded text-indigo-600"> Extra
                                Bed</label>
                            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="ekstra[]"
                                    value="Extra Selimut" class="edit-ekstra-cb rounded text-indigo-600"> Extra
                                Selimut</label>
                            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="ekstra[]"
                                    value="Extra Bantal" class="edit-ekstra-cb rounded text-indigo-600"> Extra
                                Bantal</label>
                            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="ekstra[]"
                                    value="Sarapan Tambahan" class="edit-ekstra-cb rounded text-indigo-600"> Sarapan
                                Tambahan</label>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Check-In</label><input
                                type="date" id="edit_check_in" name="check_in" required
                                class="w-full border rounded p-2 text-sm"></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                                Check-Out</label><input type="date" id="edit_check_out" name="check_out" required
                                class="w-full border rounded p-2 text-sm"></div>
                    </div>

                    <div class="flex justify-end gap-2 border-t pt-4 mt-6">
                        <button type="button"
                            onclick="document.getElementById('modalEditReservasi').classList.add('hidden')"
                            class="px-4 py-2 border rounded bg-white text-gray-700 hover:bg-gray-50 text-sm">Batal</button>
                        <button type="submit"
                            class="px-5 py-2 rounded bg-indigo-600 text-white font-bold hover:bg-indigo-700 text-sm">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk menyaring Dropdown Ruangan berdasarkan Kelas yang dipilih
        function filterRuangan(kelasSelectId, ruanganSelectId) {
            let kelasId = document.getElementById(kelasSelectId).value;
            let ruanganSelect = document.getElementById(ruanganSelectId);
            let options = ruanganSelect.querySelectorAll('option');

            // Reset value saat kelas diganti
            ruanganSelect.value = "";

            options.forEach(opt => {
                // Tampilkan hanya ruangan yang memiliki data-kelas sama dengan yang dipilih
                if (opt.getAttribute('data-kelas') === kelasId) {
                    opt.style.display = 'block';
                } else if (opt.value === "") { // Tampilkan opsi default (kosong)
                    opt.style.display = 'block';
                    opt.innerText = kelasId === "" ? "-- Menunggu Kelas --" : "-- Pilih Ruangan --";
                } else {
                    opt.style.display = 'none';
                }
            });
        }

        // Fungsi membuka modal edit
        function openEditReservasi(id, nama, noHp, kelasId, kamarId, checkIn, checkOut, ekstraArr) {
            // Set URL aksi untuk Update Data
            document.getElementById('formEditReservasi').action = '/reservasi/' + id;
            // Set URL aksi untuk tombol Check-Out Mendadak
            document.getElementById('formCheckout').action = '/reservasi/' + id + '/checkout';

            // Isi form dasar
            document.getElementById('edit_nama_tamu').value = nama;
            document.getElementById('edit_no_hp').value = noHp;
            document.getElementById('edit_check_in').value = checkIn;
            document.getElementById('edit_check_out').value = checkOut;

            // Atur Dropdown Kelas dan pancing filter ruangannya
            document.getElementById('edit_kelas_select').value = kelasId;
            filterRuangan('edit_kelas_select', 'edit_kamar_id');
            // Set Dropdown Ruangan ke ruangan tamu saat ini
            document.getElementById('edit_kamar_id').value = kamarId;

            // Atur checkbox ekstra fasilitas
            let checkboxes = document.querySelectorAll('.edit-ekstra-cb');
            checkboxes.forEach(cb => cb.checked = false); // Bersihkan dulu
            checkboxes.forEach(cb => {
                if (ekstraArr && ekstraArr.includes(cb.value)) {
                    cb.checked = true;
                }
            });

            document.getElementById('modalEditReservasi').classList.remove('hidden');
        }
    </script>
</x-dblayout>

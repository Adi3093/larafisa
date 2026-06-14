<x-dblayout>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Pusat Data Reservasi</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola data reservasi walk-in, persetujuan online, dan pelacakan
                riwayat.</p>
        </div>

        @if ($tab === 'aktif')
            <button onclick="openWalkInModal()"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-sm flex items-center gap-2 whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                + Check-In Baru (Walk-In)
            </button>
        @endif
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="bg-emerald-100 p-3 rounded-xl">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Kamar Tersedia</p>
                <h3 class="text-2xl font-black text-gray-900">{{ $kamarTersedia }}</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="bg-blue-100 p-3 rounded-xl">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Kamar Terpakai</p>
                <h3 class="text-2xl font-black text-gray-900">{{ $kamarTerpakai }}</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="bg-rose-100 p-3 rounded-xl">
                <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Dalam Perbaikan</p>
                <h3 class="text-2xl font-black text-gray-900">{{ $kamarPerbaikan }}</h3>
            </div>
        </div>
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
    @if (session('error'))
        <div
            class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm">
            <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8">
            <a href="{{ route('reservasi', ['tab' => 'aktif']) }}"
                class="{{ $tab === 'aktif' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition">
                Reservasi Aktif & Permintaan Online
            </a>
            <a href="{{ route('reservasi', ['tab' => 'riwayat']) }}"
                class="{{ $tab === 'riwayat' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition">
                Arsip & Riwayat Reservasi
            </a>
        </nav>
    </div>

    <div class="bg-white p-5 lg:p-6 rounded-2xl border border-gray-100 shadow-sm mb-6">
        <form method="GET" action="{{ route('reservasi') }}"
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end w-full">
            <input type="hidden" name="tab" value="{{ $tab }}">

            <div class="col-span-1 sm:col-span-2 lg:col-span-1">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Cari Tamu / No.
                    Tiket</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Nama / Kode Reservasi..."
                        class="pl-10 w-full border border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 py-2.5 text-sm transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Filter Kelas
                    Kamar</label>
                <select name="filter_kelas"
                    class="w-full border border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 py-2.5 text-sm bg-white transition">
                    <option value="semua">Semua Kelas</option>
                    @foreach ($kelasKamars as $kelas)
                        <option value="{{ $kelas->id }}"
                            {{ request('filter_kelas') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Urutan
                    Tampilan</label>
                <select name="sorting"
                    class="w-full border border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 py-2.5 text-sm bg-white transition">
                    <option value="">Default (Terbaru)</option>
                    <option value="waktu_terdekat" {{ request('sorting') == 'waktu_terdekat' ? 'selected' : '' }}>
                        Waktu Reservasi Terdekat</option>
                    <option value="waktu_terlama" {{ request('sorting') == 'waktu_terlama' ? 'selected' : '' }}>Waktu
                        Reservasi Terlama</option>
                    <option value="harga_tertinggi" {{ request('sorting') == 'harga_tertinggi' ? 'selected' : '' }}>
                        Harga Tertinggi</option>
                    <option value="harga_terendah" {{ request('sorting') == 'harga_terendah' ? 'selected' : '' }}>
                        Harga Terendah</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Jadwal
                    Mendatang</label>
                <select name="filter_mingguan"
                    class="w-full border border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 py-2.5 text-sm bg-white transition">
                    <option value="">Semua Jadwal</option>
                    <option value="1" {{ request('filter_mingguan') == '1' ? 'selected' : '' }}>Mulai Menginap
                        (H-7)</option>
                </select>
            </div>

            <div class="flex gap-2 w-full">
                <button type="submit"
                    class="flex-1 bg-indigo-600 text-white py-2.5 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-sm text-center">
                    Filter
                </button>
                <a href="{{ route('reservasi', ['tab' => $tab]) }}"
                    class="bg-white text-gray-600 px-3 py-2.5 rounded-xl text-sm font-bold hover:bg-gray-50 transition border border-gray-200 text-center shadow-sm">
                    Reset
                </a>
            </div>
        </form>

        @if ($tab === 'riwayat')
            <div class="flex justify-end gap-2 mt-4 pt-4 border-t border-gray-100">
                <a href="{{ route('reservasi.pdf') }}"
                    class="bg-red-50 text-red-700 border border-red-200 px-4 py-2 rounded-xl text-sm font-bold hover:bg-red-100 transition flex items-center gap-1.5 shadow-sm">
                    📄 Export PDF
                </a>
                <a href="{{ route('reservasi.csv') }}"
                    class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-4 py-2 rounded-xl text-sm font-bold hover:bg-emerald-100 transition flex items-center gap-1.5 shadow-sm">
                    📊 Export CSV
                </a>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50/50 border-b border-gray-100 text-gray-500 font-medium">
                    <tr>
                        <th class="px-6 py-4 whitespace-nowrap">No. Reservasi</th>
                        <th class="px-6 py-4 whitespace-nowrap">Nama Tamu & Kontak</th>
                        <th class="px-6 py-4 whitespace-nowrap">Ruangan & Kelas</th>
                        <th class="px-6 py-4 whitespace-nowrap">Durasi Menginap</th>
                        <th class="px-6 py-4 whitespace-nowrap">Status</th>
                        <th class="px-6 py-4 whitespace-nowrap text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($reservasis as $res)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 font-bold text-indigo-600">
                                #{{ $res->no_reservasi }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $res->nama_tamu }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">{{ $res->no_hp }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">Kamar {{ $res->kamar?->nomor_ruangan ?? '-' }}
                                </div>
                                <div class="text-xs text-gray-500 mt-0.5">
                                    {{ $res->kamar?->kelasKamar?->nama_kelas ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900 text-xs">
                                    <span class="text-emerald-600 font-extrabold">In:</span>
                                    {{ \Carbon\Carbon::parse($res->check_in)->translatedFormat('d M Y - H:i') }} WIB
                                </div>
                                <div class="text-xs text-gray-600 font-bold mt-1">
                                    <span class="text-red-500 font-extrabold">Out:</span>
                                    {{ \Carbon\Carbon::parse($res->check_out)->translatedFormat('d M Y - H:i') }} WIB
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $badgeColor = match ($res->status_reservasi) {
                                        'Menunggu Konfirmasi' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'Terkonfirmasi' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'Check-In' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'Selesai' => 'bg-gray-100 text-gray-700 border-gray-300',
                                        'Batal', 'Dibatalkan' => 'bg-red-50 text-red-700 border-red-200',
                                        default => 'bg-gray-50 text-gray-700',
                                    };
                                @endphp
                                <span
                                    class="inline-flex items-center justify-center rounded-lg {{ $badgeColor }} border px-2.5 py-1 text-xs font-bold uppercase tracking-wider">
                                    {{ $res->status_reservasi }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    @if ($res->status_reservasi === 'Menunggu Konfirmasi')
                                        <form method="POST" action="{{ route('reservasi.konfirmasi', $res->id) }}"
                                            class="m-0">
                                            @csrf
                                            <button type="submit"
                                                class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition shadow-sm">
                                                Terima
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('reservasi.batal', $res->id) }}"
                                            class="m-0">
                                            @csrf
                                            <button type="submit"
                                                onclick="return confirm('Batalkan pesanan online ini?')"
                                                class="bg-white border border-red-200 text-red-600 hover:bg-red-50 px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                                Tolak
                                            </button>
                                        </form>
                                    @elseif($res->status_reservasi === 'Terkonfirmasi' || $res->status_reservasi === 'Check-In')
                                        <a href="{{ route('checkinout') }}"
                                            class="text-xs font-bold text-indigo-600 hover:underline flex items-center gap-1">
                                            Buka Meja Resepsionis &rarr;
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 font-medium italic">Arsip Terkunci</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                    <p class="font-medium text-gray-900">Tidak ada data reservasi</p>
                                    <p class="text-sm mt-1">Belum ada aktivitas reservasi yang tercatat pada kategori
                                        ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mb-8">
        {{ $reservasis->links() }}
    </div>

    <div id="walkInModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/60 backdrop-blur-sm"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-indigo-600 px-6 py-4 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white">Check-In Baru (Walk-In)</h3>
                    <button onclick="closeWalkInModal()" class="text-indigo-100 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="bg-white px-6 pb-4 pt-5">
                    <form id="walkInForm" method="POST" action="{{ route('reservasi.store') }}">
                        @csrf
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Nama Tamu</label>
                                <input type="text" name="nama_tamu" required
                                    class="w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-2.5 text-sm transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">No. Handphone</label>
                                <input type="text" name="no_hp" required maxlength="15"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    placeholder="Contoh: 081234567890"
                                    class="w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-2.5 text-sm transition">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-bold text-gray-700 mb-1">Nomor KTP (NIK)</label>
                            <input type="text" name="no_ktp" required maxlength="16"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                placeholder="Masukkan 16 digit NIK..."
                                class="w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-2.5 text-sm transition">
                            <p class="text-[10px] text-gray-400 mt-1">*Hanya menerima angka, maksimal 16 digit.</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Waktu Check-In</label>
                                <input type="datetime-local" name="check_in" id="check_in"
                                    value="{{ date('Y-m-d\TH:i') }}" onchange="filterKamarDanHitung()" required
                                    class="w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-2.5 text-sm transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Waktu Check-Out</label>
                                <input type="datetime-local" name="check_out" id="check_out"
                                    value="{{ date('Y-m-d\TH:i', strtotime('+1 day')) }}"
                                    onchange="filterKamarDanHitung()" required
                                    class="w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-2.5 text-sm transition">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4 bg-gray-50 p-3 rounded-xl border border-gray-100">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Pilih Tipe Kelas</label>
                                <select name="kelas_kamar_id" id="kelas_kamar_id" onchange="filterKamarDanHitung()"
                                    required
                                    class="w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-2.5 text-sm bg-white transition">
                                    <option value="" data-harga="0">-- Pilih Kelas --</option>
                                    @foreach ($kelasKamars as $kelas)
                                        <option value="{{ $kelas->id }}" data-harga="{{ $kelas->harga }}">
                                            {{ $kelas->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Pilih Ruangan Kamar</label>
                                <select name="kamar_id" id="kamar_id" required
                                    class="w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-2.5 text-sm bg-white transition">
                                    <option value="">-- Pilih Kamar --</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-bold text-gray-700 mb-2">Layanan Tambahan (Add-on)</label>
                            <div class="space-y-2.5">
                                <div
                                    class="flex items-center justify-between p-3 border border-gray-200 rounded-xl bg-white hover:bg-gray-50/50 transition shadow-sm">
                                    <div>
                                        <p class="text-sm font-bold text-gray-800">Extra Bed</p>
                                        <p class="text-xs text-gray-400 mt-0.5">+Rp 100.000 / unit</p>
                                    </div>
                                    <div
                                        class="flex items-center border border-gray-300 rounded-lg overflow-hidden bg-gray-50 shadow-inner">
                                        <button type="button" onclick="adjustQty('extra_bed_qty', -1)"
                                            class="px-3 py-1.5 font-bold text-gray-600 hover:bg-gray-200 transition text-sm">&minus;</button>
                                        <input type="number" name="ekstra[Extra Bed]" id="extra_bed_qty"
                                            value="0" min="0" readonly
                                            class="w-12 text-center bg-transparent border-none text-sm font-bold text-gray-800 p-0 focus:ring-0">
                                        <button type="button" onclick="adjustQty('extra_bed_qty', 1)"
                                            class="px-3 py-1.5 font-bold text-gray-600 hover:bg-gray-200 transition text-sm">&plus;</button>
                                    </div>
                                </div>

                                <div
                                    class="flex items-center justify-between p-3 border border-gray-200 rounded-xl bg-white hover:bg-gray-50/50 transition shadow-sm">
                                    <div>
                                        <p class="text-sm font-bold text-gray-800">Extra Selimut</p>
                                        <p class="text-xs text-gray-400 mt-0.5">+Rp 25.000 / unit</p>
                                    </div>
                                    <div
                                        class="flex items-center border border-gray-300 rounded-lg overflow-hidden bg-gray-50 shadow-inner">
                                        <button type="button" onclick="adjustQty('extra_selimut_qty', -1)"
                                            class="px-3 py-1.5 font-bold text-gray-600 hover:bg-gray-200 transition text-sm">&minus;</button>
                                        <input type="number" name="ekstra[Extra Selimut]" id="extra_selimut_qty"
                                            value="0" min="0" readonly
                                            class="w-12 text-center bg-transparent border-none text-sm font-bold text-gray-800 p-0 focus:ring-0">
                                        <button type="button" onclick="adjustQty('extra_selimut_qty', 1)"
                                            class="px-3 py-1.5 font-bold text-gray-600 hover:bg-gray-200 transition text-sm">&plus;</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-indigo-50 p-4 rounded-xl border border-indigo-100 flex justify-between items-center mt-3 shadow-inner">
                            <div>
                                <p class="text-xs font-bold text-indigo-800 uppercase tracking-wider">Total Biaya Kamar
                                </p>
                                <p class="text-xs text-indigo-600 mt-0.5" id="rincian_hari">1 Malam</p>
                            </div>
                            <div class="text-2xl font-black text-indigo-700" id="total_biaya_display">
                                Rp 0
                            </div>
                        </div>
                    </form>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse border-t border-gray-100">
                    <button type="submit" form="walkInForm"
                        class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-indigo-700 ml-3 transition w-full sm:w-auto">
                        Simpan & Check-In
                    </button>
                    <button type="button" onclick="closeWalkInModal()"
                        class="rounded-xl bg-white px-5 py-2.5 text-sm font-bold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 mt-3 sm:mt-0 w-full sm:w-auto transition">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openWalkInModal() {
            document.getElementById('walkInModal').classList.remove('hidden');
            try {
                filterKamarDanHitung();
            } catch (e) {
                console.error(e);
            }
        }

        function closeWalkInModal() {
            document.getElementById('walkInModal').classList.add('hidden');
            document.getElementById('walkInForm').reset();
            document.getElementById('extra_bed_qty').value = 0;
            document.getElementById('extra_selimut_qty').value = 0;
            document.getElementById('total_biaya_display').innerText = 'Rp 0';
            document.getElementById('rincian_hari').innerText = '1 Malam';
            document.getElementById('kamar_id').innerHTML = '<option value="">-- Pilih Kamar --</option>';
        }

        function adjustQty(inputId, change) {
            let inputField = document.getElementById(inputId);
            let currentVal = parseInt(inputField.value) || 0;
            let newVal = currentVal + change;

            if (newVal >= 0) {
                inputField.value = newVal;
                filterKamarDanHitung();
            }
        }

        async function filterKamarDanHitung() {
            try {
                let kelasId = document.getElementById('kelas_kamar_id').value;
                let checkInInput = document.getElementById('check_in').value;
                let checkOutInput = document.getElementById('check_out').value;
                let kamarSelect = document.getElementById('kamar_id');

                // Kalkulasi Durasi Hari
                let diffDays = 1;
                if (checkInInput && checkOutInput) {
                    let checkIn = new Date(checkInInput);
                    let checkOut = new Date(checkOutInput);
                    let diffTime = checkOut - checkIn;
                    diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    if (diffDays <= 0 || isNaN(diffDays)) diffDays = 1;
                }
                document.getElementById('rincian_hari').innerText = diffDays + ' Malam';

                // Kalkulasi Biaya
                let selectKelas = document.getElementById('kelas_kamar_id');
                let hargaPerMalam = 0;
                if (selectKelas && selectKelas.selectedIndex > 0) {
                    hargaPerMalam = parseInt(selectKelas.options[selectKelas.selectedIndex].getAttribute(
                        'data-harga')) || 0;
                }
                let totalBiayaKamar = hargaPerMalam * diffDays;
                let qtyBed = parseInt(document.getElementById('extra_bed_qty').value) || 0;
                let qtySelimut = parseInt(document.getElementById('extra_selimut_qty').value) || 0;
                let totalAddOn = (qtyBed * 100000) + (qtySelimut * 25000);

                document.getElementById('total_biaya_display').innerText = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(totalBiayaKamar + totalAddOn);

                // REQUEST AJAX UNTUK MENDAPATKAN KAMAR YANG BENAR-BENAR KOSONG
                let selectedKamarValueBefore = kamarSelect.value;
                kamarSelect.innerHTML = '<option value="">-- Sedang memuat kamar... --</option>';

                if (kelasId && checkInInput && checkOutInput) {
                    let response = await fetch(
                        `/api/kamar-tersedia?kelas_id=${kelasId}&check_in=${checkInInput}&check_out=${checkOutInput}`
                        );
                    let kamars = await response.json();

                    kamarSelect.innerHTML = '<option value="">-- Pilih Kamar --</option>';

                    if (kamars.length === 0) {
                        kamarSelect.innerHTML =
                        '<option value="" disabled>-- Kamar Penuh di Waktu Tersebut --</option>';
                    } else {
                        kamars.forEach(kmr => {
                            let option = document.createElement('option');
                            option.value = kmr.id;
                            option.text = 'Kamar ' + kmr.nomor_ruangan;
                            if (kmr.id == selectedKamarValueBefore) option.selected = true;
                            kamarSelect.appendChild(option);
                        });
                    }
                } else {
                    kamarSelect.innerHTML = '<option value="">-- Pilih Kelas & Tanggal Dahulu --</option>';
                }

            } catch (error) {
                console.error("Kesalahan sistem kalkulator:", error);
            }
        }
    </script>
</x-dblayout>

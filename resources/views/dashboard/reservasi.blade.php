<x-dblayout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-amber-950 tracking-tight">Data Reservasi</h1>
        <p class="text-sm text-amber-900/70 mt-1">Kelola data reservasi walk-in, persetujuan online, dan pelacakan
            riwayat.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-5 rounded-2xl border border-amber-100 shadow-sm flex items-center gap-4">
            <div class="bg-emerald-100 p-3 rounded-xl text-emerald-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 32 32">
                    <path fill="currentColor"
                        d="M6 6C4.355 6 3 7.355 3 9v6.78c-.61.552-1 1.342-1 2.22v9h5v-2h18v2h5v-9c0-.878-.39-1.668-1-2.22V9c0-1.645-1.355-3-3-3H6zm0 2h20c.555 0 1 .445 1 1v6h-2v-1c0-1.645-1.355-3-3-3h-4c-.767 0-1.467.3-2 .78a2.985 2.985 0 0 0-2-.78h-4c-1.645 0-3 1.355-3 3v1H5V9c0-.555.445-1 1-1zm4 5h4c.555 0 1 .445 1 1v1H9v-1c0-.555.445-1 1-1zm8 0h4c.555 0 1 .445 1 1v1h-6v-1c0-.555.445-1 1-1zM5 17h22c.555 0 1 .445 1 1v7h-1v-2H5v2H4v-7c0-.555.445-1 1-1z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-amber-800/70 uppercase tracking-wider">Kamar Tersedia</p>
                <h3 class="text-2xl font-black text-amber-950">{{ $kamarTersedia }}</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-amber-100 shadow-sm flex items-center gap-4">
            <div class="bg-blue-100 p-3 rounded-xl text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M13.1 23q-2.1 0-3.937-.8t-3.2-2.163Q4.6 18.675 3.8 16.837T3 12.9q0-3.65 2.325-6.438T11.25 3q-.45 2.475.275 4.838t2.5 4.137q1.775 1.775 4.138 2.5T23 14.75q-.65 3.6-3.45 5.925T13.1 23Z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-amber-800/70 uppercase tracking-wider">Kamar Dipakai</p>
                <h3 class="text-2xl font-black text-amber-950">{{ $kamarTerpakai }}</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-amber-100 shadow-sm flex items-center gap-4">
            <div class="bg-rose-100 p-3 rounded-xl text-rose-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 512 512">
                    <path fill="currentColor"
                        d="M503.58 126.2a16.85 16.85 0 0 0-27.07-4.55l-51.15 51.15a11.15 11.15 0 0 1-15.66 0l-22.48-22.48a11.17 11.17 0 0 1 0-15.67l50.88-50.89a16.85 16.85 0 0 0-5.27-27.4c-39.71-17-89.08-7.45-120 23.29c-26.81 26.61-34.83 68-22 113.7a11 11 0 0 1-3.16 11.1L114.77 365.1a56.76 56.76 0 1 0 80.14 80.18L357 272.08a11 11 0 0 1 10.9-3.17c45 12 86 4 112.43-22c15.2-15 25.81-36.17 29.89-59.71c3.83-22.2 1.41-44.44-6.64-61Z" />
                    <path fill="currentColor"
                        d="M437.33 378.41c-13.94-11.59-43.72-38.4-74.07-66.22l-66.07 70.61c28.24 30 53.8 57.85 65 70.88l.07.08A30 30 0 0 0 383.72 464h1.1a30.11 30.11 0 0 0 21-8.62l.07-.07l33.43-33.37a29.46 29.46 0 0 0-2-43.53ZM118.54 214.55a20.48 20.48 0 0 0-3-10.76a2.76 2.76 0 0 1 2.62-4.22h.06c.84.09 5.33.74 11.7 4.61c4.73 2.87 18.23 12.08 41.73 35.54a34.23 34.23 0 0 0 7.22 22.12l66.23-61.55a33.73 33.73 0 0 0-21.6-9.2a2.65 2.65 0 0 1-.21-.26l-.65-.69l-24.54-33.84a28.45 28.45 0 0 1-4-26.11a35.23 35.23 0 0 1 11.78-16.35c5.69-4.41 18.53-9.72 29.44-10.62a52.92 52.92 0 0 1 15.19.94a65.57 65.57 0 0 1 7.06 2.13a15.46 15.46 0 0 0 2.15.63a16 16 0 0 0 16.38-25.06c-.26-.35-1.32-1.79-2.89-3.73a91.85 91.85 0 0 0-9.6-10.36c-8.15-7.36-29.27-19.77-57-19.77a123.13 123.13 0 0 0-46.3 9c-38.37 15.45-63.47 36.58-75.01 47.79l-.09.09A222.14 222.14 0 0 0 63.7 129.5a27 27 0 0 0-4.7 11.77a7.33 7.33 0 0 1-7.71 6.17H50.2a20.65 20.65 0 0 0-14.59 5.9L6.16 182.05l-.32.32a20.89 20.89 0 0 0-.24 28.72c.19.2.37.39.57.58L53.67 258a21 21 0 0 0 14.65 6a20.65 20.65 0 0 0 14.59-5.9l29.46-28.79a20.51 20.51 0 0 0 6.17-14.76Z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-amber-800/70 uppercase tracking-wider">Dalam Perbaikan</p>
                <h3 class="text-2xl font-black text-amber-950">{{ $kamarPerbaikan }}</h3>
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

    <div class="flex gap-2 sm:gap-4 mb-4">
        <a href="{{ route('reservasi', ['tab' => 'aktif']) }}"
            class="px-5 py-2.5 rounded-t-xl text-sm font-bold border-t border-l border-r transition {{ $tab === 'aktif' ? 'bg-amber-600 text-white border-amber-600 shadow-sm' : 'bg-white text-amber-900/60 border-amber-200 hover:bg-amber-50' }}">
            Reservasi Aktif
        </a>
        <a href="{{ route('reservasi', ['tab' => 'riwayat']) }}"
            class="px-5 py-2.5 rounded-t-xl text-sm font-bold border-t border-l border-r transition {{ $tab === 'riwayat' ? 'bg-amber-600 text-white border-amber-600 shadow-sm' : 'bg-white text-amber-900/60 border-amber-200 hover:bg-amber-50' }}">
            Riwayat Reservasi
        </a>
    </div>

    <div class="bg-white p-5 lg:p-6 rounded-b-2xl rounded-tr-2xl border border-amber-200 shadow-sm mb-6 -mt-4">
        <div
            class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-amber-100 pb-5">
            @if ($tab === 'aktif')
                <button onclick="openWalkInModal()"
                    class="w-full sm:w-auto bg-amber-600 hover:bg-amber-700 text-white px-5 py-3 rounded-xl text-sm font-bold transition shadow-md shadow-amber-600/20 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Reservasi Baru
                </button>
            @else
                <div class="flex gap-2 w-full sm:w-auto">
                    <a href="{{ route('reservasi.pdf') }}"
                        class="flex-1 sm:flex-none justify-center bg-red-50 text-red-700 border border-red-200 px-4 py-3 rounded-xl text-sm font-bold hover:bg-red-100 transition flex items-center gap-1.5 shadow-sm">📄
                        Export PDF</a>
                    <a href="{{ route('reservasi.csv') }}"
                        class="flex-1 sm:flex-none justify-center bg-emerald-50 text-emerald-700 border border-emerald-200 px-4 py-3 rounded-xl text-sm font-bold hover:bg-emerald-100 transition flex items-center gap-1.5 shadow-sm">📊
                        Export CSV</a>
                </div>
            @endif
        </div>

        <form method="GET" action="{{ route('reservasi') }}"
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end w-full mb-6 pb-6 border-b border-amber-50">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <div class="col-span-1 sm:col-span-2 lg:col-span-1">
                <label class="block text-xs font-bold text-amber-800/70 uppercase tracking-wider mb-2">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Nama / No. Tiket..."
                        class="pl-9 w-full border border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 py-2.5 text-sm transition text-amber-950">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-amber-800/70 uppercase tracking-wider mb-2">Filter
                    Kelas</label>
                <select name="filter_kelas"
                    class="w-full border border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 py-2.5 text-sm bg-white transition text-amber-950">
                    <option value="semua">Semua Kelas</option>
                    @foreach ($kelasKamars as $kelas)
                        <option value="{{ $kelas->id }}"
                            {{ request('filter_kelas') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-amber-800/70 uppercase tracking-wider mb-2">Urutan
                    (A/Z)</label>
                <select name="sorting"
                    class="w-full border border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 py-2.5 text-sm bg-white transition text-amber-950">
                    <option value="">Default (Terbaru)</option>
                    <option value="waktu_terdekat" {{ request('sorting') == 'waktu_terdekat' ? 'selected' : '' }}>Waktu
                        In Terdekat</option>
                    <option value="waktu_terlama" {{ request('sorting') == 'waktu_terlama' ? 'selected' : '' }}>Waktu
                        In Terlama</option>
                    <option value="harga_tertinggi" {{ request('sorting') == 'harga_tertinggi' ? 'selected' : '' }}>
                        Harga Tertinggi</option>
                    <option value="harga_terendah" {{ request('sorting') == 'harga_terendah' ? 'selected' : '' }}>
                        Harga Terendah</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-amber-800/70 uppercase tracking-wider mb-2">Jadwal
                    Mendatang</label>
                <select name="filter_mingguan"
                    class="w-full border border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 py-2.5 text-sm bg-white transition text-amber-950">
                    <option value="">Semua Jadwal</option>
                    <option value="1" {{ request('filter_mingguan') == '1' ? 'selected' : '' }}>H-7 Inap</option>
                </select>
            </div>

            <div class="flex gap-2 w-full">
                <button type="submit"
                    class="flex-1 bg-amber-600 text-white py-2.5 rounded-xl text-sm font-bold hover:bg-amber-700 transition shadow-sm text-center">Filter</button>
                <a href="{{ route('reservasi', ['tab' => $tab]) }}"
                    class="bg-white text-amber-700 px-3 py-2.5 rounded-xl text-sm font-bold hover:bg-amber-50 transition border border-amber-200 text-center shadow-sm">Reset</a>
            </div>
        </form>

        <div class="border border-amber-100 rounded-xl overflow-hidden mb-6 shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead
                        class="bg-amber-50/50 border-b border-amber-100 text-amber-900 font-bold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="px-6 py-4 whitespace-nowrap">No. Reservasi</th>
                            <th class="px-6 py-4 whitespace-nowrap">Nama Tamu & Kontak</th>
                            <th class="px-6 py-4 whitespace-nowrap">Ruangan & Kelas</th>
                            <th class="px-6 py-4 whitespace-nowrap">Durasi Menginap</th>
                            <th class="px-6 py-4 whitespace-nowrap">Status</th>
                            <th class="px-6 py-4 whitespace-nowrap text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-50 text-amber-950">
                        @forelse($reservasis as $res)
                            <tr class="hover:bg-amber-50/30 transition">
                                <td class="px-6 py-4 font-bold text-amber-600">#{{ $res->no_reservasi }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-amber-950">{{ $res->nama_tamu }}</div>
                                    <div class="text-xs text-amber-900/60 mt-0.5">{{ $res->no_hp }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-amber-950">Kamar
                                        {{ $res->kamar?->nomor_ruangan ?? '-' }}</div>
                                    <div class="text-xs text-amber-900/60 mt-0.5">
                                        {{ $res->kamar?->kelasKamar?->nama_kelas ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-amber-950 text-xs">
                                        <span class="text-emerald-600 font-extrabold">In:</span>
                                        {{ \Carbon\Carbon::parse($res->check_in)->translatedFormat('d M Y - H:i') }}
                                        WIB
                                    </div>
                                    <div class="text-xs text-amber-800/80 font-bold mt-1">
                                        <span class="text-red-500 font-extrabold">Out:</span>
                                        {{ \Carbon\Carbon::parse($res->check_out)->translatedFormat('d M Y - H:i') }}
                                        WIB
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $badgeColor = match ($res->status_reservasi) {
                                            'Menunggu Konfirmasi' => 'bg-orange-50 text-orange-700 border-orange-200',
                                            'Terkonfirmasi' => 'bg-blue-50 text-blue-700 border-blue-200',
                                            'Check-In' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'Selesai' => 'bg-gray-100 text-gray-700 border-gray-300',
                                            'Batal', 'Dibatalkan' => 'bg-red-50 text-red-700 border-red-200',
                                            default => 'bg-gray-50 text-gray-700',
                                        };
                                    @endphp
                                    <span
                                        class="inline-flex items-center justify-center rounded-lg {{ $badgeColor }} border px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider">
                                        {{ $res->status_reservasi }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        @if ($res->status_reservasi === 'Menunggu Konfirmasi')
                                            @php
                                                $ekstra = is_array($res->ekstra)
                                                    ? $res->ekstra
                                                    : json_decode($res->ekstra, true) ?? [];
                                                $metode = $ekstra['Metode Pembayaran'] ?? 'Bayar di tempat';
                                                $pesanTamu = $ekstra['Pesan Tambahan'] ?? '-';
                                                $kelasName = $res->kamar?->kelasKamar?->nama_kelas ?? '-';
                                                $ruangName = $res->kamar?->nomor_ruangan ?? '-';
                                                $totalBayar = $ekstra['Total Bayar'] ?? 0;

                                                $pembayaran = $res->pembayaran;
                                                $noInvoice = $pembayaran ? $pembayaran->invoice : '-';
                                                $statusBayar = $pembayaran ? $pembayaran->status : '-';
                                                $qrImage = $pembayaran ? $pembayaran->qr_image : '';
                                            @endphp
                                            <button
                                                onclick='bukaModalKonfirmasi({{ $res->id }}, @json($res->no_reservasi), @json($res->nama_tamu), @json($res->no_hp), @json($kelasName), @json($ruangName), @json($metode), @json($pesanTamu), @json($res->check_in), @json($res->check_out), @json($ekstra), @json($noInvoice), @json($statusBayar), @json($qrImage), @json($totalBayar))'
                                                class="bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 px-4 py-2 rounded-lg text-xs font-bold transition shadow-sm flex items-center gap-1">
                                                Buka
                                            </button>
                                        @elseif($res->status_reservasi === 'Terkonfirmasi' || $res->status_reservasi === 'Check-In')
                                            <a href="{{ route('checkinout') }}"
                                                class="text-xs font-bold text-amber-600 hover:underline flex items-center gap-1">Buka
                                                Resepsionis &rarr;</a>
                                        @else
                                            <span class="text-[10px] text-amber-900/40 font-medium italic">Arsip
                                                Terkunci</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-amber-900/40">
                                        <svg class="w-12 h-12 mb-3 text-amber-200" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                            </path>
                                        </svg>
                                        <p class="font-medium text-amber-950">Tidak ada data reservasi ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div>
            {{ $reservasis->links() }}
        </div>
    </div>

    <div id="walkInModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/60 backdrop-blur-sm"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 w-full max-w-5xl border border-amber-100">
                <div class="bg-amber-600 px-6 py-4 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white">Tambah Reservasi Baru (Walk-In)</h3>
                    <button onclick="closeWalkInModal()" class="text-amber-100 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="bg-white p-6">
                    <form id="walkInForm" method="POST" action="{{ route('reservasi.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                            <div class="lg:col-span-2 flex flex-col h-full justify-between">
                                <div class="space-y-5">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div><label class="block text-xs font-bold text-amber-950 mb-1">Nama
                                                Tamu</label><input type="text" name="nama_tamu" required
                                                class="w-full border border-amber-200 rounded-lg shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 p-2.5 text-sm transition">
                                        </div>
                                        <div><label class="block text-xs font-bold text-amber-950 mb-1">No.
                                                Handphone</label><input type="text" name="no_hp" required
                                                maxlength="15"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                placeholder="Contoh: 081234567890"
                                                class="w-full border border-amber-200 rounded-lg shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 p-2.5 text-sm transition">
                                        </div>
                                    </div>
                                    <div><label class="block text-xs font-bold text-amber-950 mb-1">Nomor KTP
                                            (NIK)</label><input type="text" name="no_ktp" required maxlength="16"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            placeholder="Masukkan 16 digit NIK..."
                                            class="w-full border border-amber-200 rounded-lg shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 p-2.5 text-sm transition">
                                    </div>

                                    <div class="border border-amber-200 rounded-xl p-5 space-y-4">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-bold text-amber-950 mb-1">Kelas
                                                    Kamar</label>
                                                <select name="kelas_kamar_id" id="kelas_kamar_id"
                                                    onchange="filterKamarDanHitung()" required
                                                    class="w-full border border-amber-200 rounded-lg shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 p-2.5 text-sm bg-white transition">
                                                    <option value="" data-harga="0">-- Pilih Kelas --</option>
                                                    @foreach ($kelasKamars as $kelas)
                                                        <option value="{{ $kelas->id }}"
                                                            data-harga="{{ $kelas->harga }}">{{ $kelas->nama_kelas }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-amber-950 mb-1">No.
                                                    Ruangan</label>
                                                <select name="kamar_id" id="kamar_id" required
                                                    class="w-full border border-amber-200 rounded-lg shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 p-2.5 text-sm bg-white transition">
                                                    <option value="">-- Pilih Kamar --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div><label class="block text-xs font-bold text-amber-950 mb-1">Tanggal
                                                    Check-In</label><input type="datetime-local" name="check_in"
                                                    id="check_in" value="{{ date('Y-m-d\TH:i') }}"
                                                    onchange="filterKamarDanHitung()" required
                                                    class="w-full border border-amber-200 rounded-lg shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 p-2.5 text-sm transition">
                                            </div>
                                            <div><label class="block text-xs font-bold text-amber-950 mb-1">Tanggal
                                                    Check-Out</label><input type="datetime-local" name="check_out"
                                                    id="check_out"
                                                    value="{{ date('Y-m-d\TH:i', strtotime('+1 day')) }}"
                                                    onchange="filterKamarDanHitung()" required
                                                    class="w-full border border-amber-200 rounded-lg shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 p-2.5 text-sm transition">
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-amber-950 mb-2">Layanan
                                            Ekstra</label>
                                        <div class="space-y-3">
                                            <div
                                                class="flex items-center justify-between p-3 border border-amber-200 rounded-xl bg-white shadow-sm">
                                                <span class="text-sm font-bold text-amber-950">Ekstra Bed</span>
                                                <div
                                                    class="flex items-center border border-amber-200 rounded-lg overflow-hidden bg-gray-50">
                                                    <button type="button" onclick="adjustQty('extra_bed_qty', -1)"
                                                        class="px-3 py-1 font-bold text-gray-600 hover:bg-gray-200 transition text-lg leading-none">&minus;</button>
                                                    <input type="number" name="ekstra[Extra Bed]" id="extra_bed_qty"
                                                        value="0" min="0" readonly
                                                        class="w-10 text-center bg-transparent border-none text-sm font-bold text-gray-800 p-0 focus:ring-0">
                                                    <button type="button" onclick="adjustQty('extra_bed_qty', 1)"
                                                        class="px-3 py-1 font-bold text-gray-600 hover:bg-gray-200 transition text-lg leading-none">&plus;</button>
                                                </div>
                                            </div>
                                            <div
                                                class="flex items-center justify-between p-3 border border-amber-200 rounded-xl bg-white shadow-sm">
                                                <span class="text-sm font-bold text-amber-950">Ekstra Selimut</span>
                                                <div
                                                    class="flex items-center border border-amber-200 rounded-lg overflow-hidden bg-gray-50">
                                                    <button type="button"
                                                        onclick="adjustQty('extra_selimut_qty', -1)"
                                                        class="px-3 py-1 font-bold text-gray-600 hover:bg-gray-200 transition text-lg leading-none">&minus;</button>
                                                    <input type="number" name="ekstra[Extra Selimut]"
                                                        id="extra_selimut_qty" value="0" min="0" readonly
                                                        class="w-10 text-center bg-transparent border-none text-sm font-bold text-gray-800 p-0 focus:ring-0">
                                                    <button type="button" onclick="adjustQty('extra_selimut_qty', 1)"
                                                        class="px-3 py-1 font-bold text-gray-600 hover:bg-gray-200 transition text-lg leading-none">&plus;</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-6 flex flex-col md:flex-row items-center justify-between gap-4">
                                    <div class="w-full md:w-auto text-left">
                                        <p class="text-xs font-bold text-amber-800 uppercase tracking-wider">Total
                                            Biaya (<span id="rincian_hari">1 Malam</span>)</p>
                                        <div class="text-3xl font-black text-amber-600 leading-none mt-1"
                                            id="total_biaya_display">Rp 0</div>
                                    </div>
                                    <div class="flex gap-2 w-full md:w-auto">
                                        <button type="button" onclick="closeWalkInModal()"
                                            class="flex-1 md:flex-none rounded-xl bg-white px-5 py-2.5 text-sm font-bold text-gray-700 shadow-sm border border-gray-200 hover:bg-gray-50 transition">Batal</button>
                                        <button type="submit" name="action_type" value="simpan_checkin"
                                            class="flex-1 md:flex-none rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-emerald-700 transition"
                                            onclick="return confirm('Apakah Anda yakin tamu akan langsung Check-In sekarang?')">Simpan
                                            & Check-in</button>
                                        <button type="submit" name="action_type" value="simpan"
                                            class="flex-1 md:flex-none rounded-xl bg-amber-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-amber-700 transition">Simpan</button>
                                    </div>
                                </div>
                            </div>

                            <div class="lg:col-span-1">
                                <div
                                    class="bg-amber-50/20 rounded-2xl border border-amber-200 p-5 shadow-sm min-h-full">
                                    <div id="walkin_placeholder" class="text-center py-10">
                                        <svg class="w-16 h-16 text-amber-200 mx-auto mb-3" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2-2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                        <p class="text-sm text-amber-900/40 font-medium">Pilih kelas kamar untuk
                                            melihat preview.</p>
                                    </div>
                                    <div id="walkin_content" class="hidden">
                                        <img id="wi_img_main" src=""
                                            class="w-full h-44 object-cover rounded-xl mb-3 shadow-sm border border-amber-200 bg-white transition-all duration-300">
                                        <div id="wi_thumbnails" class="grid grid-cols-3 gap-2 mb-5"></div>
                                        <h4 id="wi_nama_kelas" class="text-xl font-black text-amber-950 mb-1"></h4>
                                        <p class="text-sm font-bold text-amber-600 mb-6" id="wi_harga"></p>
                                        <div class="border-t border-amber-200 pt-4">
                                            <p class="text-xs font-bold text-amber-800 uppercase tracking-wider mb-3">
                                                Fasilitas Kamar</p>
                                            <ul id="wi_fasilitas" class="grid grid-cols-2 gap-y-3 gap-x-2"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="modalKonfirmasi" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/60 backdrop-blur-sm"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl border border-amber-100">
                <div class="bg-amber-600 px-6 py-4 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white">Tinjau Bukti Reservasi</h3>
                    <button onclick="document.getElementById('modalKonfirmasi').classList.add('hidden')"
                        class="text-amber-100 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form id="formTerimaModal" method="POST" action="">
                    @csrf
                    <div class="flex flex-col md:flex-row p-6 gap-6">
                        <div class="w-full md:w-1/2 space-y-4">
                            <div class="border-b border-gray-200 pb-3">
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">ID Reservasi
                                </p>
                                <h4 class="text-base font-black text-amber-700" id="m_no_res"></h4>
                            </div>
                            <div class="border-b border-gray-200 pb-3">
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Nama Pemesan
                                </p>
                                <h4 class="text-base font-bold text-amber-950" id="m_nama"></h4>
                                <p class="text-sm font-medium text-gray-600 mt-1" id="m_nohp"></p>
                            </div>
                            <div class="border-b border-gray-200 pb-3">
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Kelas Kamar
                                </p>
                                <h4 class="text-sm font-bold text-amber-950 mb-3"><span id="m_kelas"></span> (<span
                                        id="m_ruangan"></span>)</h4>
                                <div class="grid grid-cols-2 gap-3 mb-2">
                                    <div>
                                        <p class="text-[10px] text-gray-500 font-bold uppercase mb-1">Check-in</p>
                                        <div class="border border-gray-200 rounded p-2 text-xs font-bold text-center"
                                            id="m_cin"></div>
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-gray-500 font-bold uppercase mb-1">Check-out</p>
                                        <div class="border border-gray-200 rounded p-2 text-xs font-bold text-center"
                                            id="m_cout"></div>
                                    </div>
                                </div>
                                <p class="text-xs font-medium text-gray-600" id="m_durasi"></p>
                            </div>
                            <div class="border-b border-gray-200 pb-3">
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-2">Layanan Extra
                                    :</p>
                                <ul class="text-sm text-amber-950 font-medium space-y-1" id="m_extra"></ul>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-2">Pesan Dari
                                    Tamu :</p>
                                <div class="border border-amber-200 rounded-lg p-3 text-sm text-gray-600 bg-amber-50/50 min-h-[80px]"
                                    id="m_pesan"></div>
                            </div>
                        </div>

                        <div class="w-full md:w-1/2 md:border-l md:border-gray-200 md:pl-6 flex flex-col">
                            <div class="border border-gray-300 rounded-xl bg-gray-50 flex items-center justify-center min-h-[200px] p-4 mb-4"
                                id="m_qris_box"></div>
                            <div class="space-y-4 flex-grow">
                                <div>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Nomor
                                        Pembayaran :</p>
                                    <h4 class="text-sm font-bold text-amber-950" id="m_invoice"></h4>
                                </div>
                                <div class="border-b border-gray-200 pb-4">
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Status :
                                    </p><span
                                        class="inline-block px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wider"
                                        id="m_status_badge"></span>
                                </div>
                                <div>
                                    <p class="text-xs text-amber-800 font-bold uppercase tracking-wider mb-2">Rincian
                                        Pembayaran :</p>
                                    <ul class="text-sm text-gray-600 font-medium space-y-1 mb-4" id="m_rincian_list">
                                    </ul>
                                    <h3 class="text-lg font-black text-amber-600" id="m_total_bayar"></h3>
                                </div>
                                <div class="pt-4 border-t border-gray-200 mt-auto">
                                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-1">Metode
                                        Pembayaran Tamu:</p>
                                    <div id="m_detail_display"
                                        class="w-full border border-amber-200 rounded-lg p-2.5 text-sm bg-gray-50 font-bold text-amber-950 shadow-sm cursor-not-allowed">
                                    </div>
                                    <input type="hidden" name="detail_pembayaran" id="m_detail_input">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 flex gap-3 border-t border-gray-100">
                        <button type="button"
                            onclick="document.getElementById('modalKonfirmasi').classList.add('hidden')"
                            class="px-5 py-3 text-sm font-bold text-gray-600 hover:bg-gray-200 rounded-xl transition">Batal</button>
                        <div class="flex-1 flex gap-2 justify-end">
                            <button type="submit"
                                class="rounded-xl bg-emerald-600 px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-emerald-700 transition">Konfirmasi
                                Reservasi</button>
                        </div>
                    </div>
                </form>
                <form id="formTolakModal" method="POST" action="" class="hidden">@csrf</form>
            </div>
        </div>
    </div>

    <script>
        window.kelasDataWalkin = @json($kelasKamars);
    </script>
    <script src="{{ asset('js/dashboard/reservasi.js') }}?v={{ time() }}"></script>
</x-dblayout>

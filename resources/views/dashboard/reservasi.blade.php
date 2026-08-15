<x-dblayout>
    <!-- PEMANGGILAN CSS CHROME TAB -->
    <link rel="stylesheet" href="{{ asset('css/reservasi.css') }}?v={{ time() }}">
    
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
        input[type="datetime-local"]::-webkit-calendar-picker-indicator { cursor: pointer; opacity: 0.6; transition: 0.2s; }
        input[type="datetime-local"]::-webkit-calendar-picker-indicator:hover { opacity: 1; }
    </style>

    <div class="mb-6 relative z-10">
        <h1 class="text-2xl font-bold text-amber-950 tracking-tight">Data Reservasi</h1>
        <p class="text-sm text-amber-900/70 mt-1">Kelola data reservasi walk-in, persetujuan online, dan pelacakan riwayat.</p>
    </div>

    <!-- MODULE: STATISTIK CARD -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6 relative z-10">
        <div class="bg-white p-5 rounded-2xl border border-amber-200 shadow-sm flex items-center gap-4">
            <div class="bg-emerald-100 p-3 rounded-xl text-emerald-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 32 32"><path fill="currentColor" d="M6 6C4.355 6 3 7.355 3 9v6.78c-.61.552-1 1.342-1 2.22v9h5v-2h18v2h5v-9c0-.878-.39-1.668-1-2.22V9c0-1.645-1.355-3-3-3H6zm0 2h20c.555 0 1 .445 1 1v6h-2v-1c0-1.645-1.355-3-3-3h-4c-.767 0-1.467.3-2 .78a2.985 2.985 0 0 0-2-.78h-4c-1.645 0-3 1.355-3 3v1H5V9c0-.555.445-1 1-1zm4 5h4c.555 0 1 .445 1 1v1H9v-1c0-.555.445-1 1-1zm8 0h4c.555 0 1 .445 1 1v1h-6v-1c0-.555.445-1 1-1zM5 17h22c.555 0 1 .445 1 1v7h-1v-2H5v2H4v-7c0-.555.445-1 1-1z" /></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-amber-800/70 uppercase tracking-wider">Kamar Tersedia</p>
                <h3 class="text-2xl font-black text-amber-950">{{ $kamarTersedia }}</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-amber-200 shadow-sm flex items-center gap-4">
            <div class="bg-blue-100 p-3 rounded-xl text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24"><path fill="currentColor" d="M13.1 23q-2.1 0-3.937-.8t-3.2-2.163Q4.6 18.675 3.8 16.837T3 12.9q0-3.65 2.325-6.438T11.25 3q-.45 2.475.275 4.838t2.5 4.137q1.775 1.775 4.138 2.5T23 14.75q-.65 3.6-3.45 5.925T13.1 23Z" /></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-amber-800/70 uppercase tracking-wider">Kamar Dipakai</p>
                <h3 class="text-2xl font-black text-amber-950">{{ $kamarTerpakai }}</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-amber-200 shadow-sm flex items-center gap-4">
            <div class="bg-rose-100 p-3 rounded-xl text-rose-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 512 512"><path fill="currentColor" d="M503.58 126.2a16.85 16.85 0 0 0-27.07-4.55l-51.15 51.15a11.15 11.15 0 0 1-15.66 0l-22.48-22.48a11.17 11.17 0 0 1 0-15.67l50.88-50.89a16.85 16.85 0 0 0-5.27-27.4c-39.71-17-89.08-7.45-120 23.29c-26.81 26.61-34.83 68-22 113.7a11 11 0 0 1-3.16 11.1L114.77 365.1a56.76 56.76 0 1 0 80.14 80.18L357 272.08a11 11 0 0 1 10.9-3.17c45 12 86 4 112.43-22c15.2-15 25.81-36.17 29.89-59.71c3.83-22.2 1.41-44.44-6.64-61Z" /><path fill="currentColor" d="M437.33 378.41c-13.94-11.59-43.72-38.4-74.07-66.22l-66.07 70.61c28.24 30 53.8 57.85 65 70.88l.07.08A30 30 0 0 0 383.72 464h1.1a30.11 30.11 0 0 0 21-8.62l.07-.07l33.43-33.37a29.46 29.46 0 0 0-2-43.53ZM118.54 214.55a20.48 20.48 0 0 0-3-10.76a2.76 2.76 0 0 1 2.62-4.22h.06c.84.09 5.33.74 11.7 4.61c4.73 2.87 18.23 12.08 41.73 35.54a34.23 34.23 0 0 0 7.22 22.12l66.23-61.55a33.73 33.73 0 0 0-21.6-9.2a2.65 2.65 0 0 1-.21-.26l-.65-.69l-24.54-33.84a28.45 28.45 0 0 1-4-26.11a35.23 35.23 0 0 1 11.78-16.35c5.69-4.41 18.53-9.72 29.44-10.62a52.92 52.92 0 0 1 15.19.94a65.57 65.57 0 0 1 7.06 2.13a15.46 15.46 0 0 0 2.15.63a16 16 0 0 0 16.38-25.06c-.26-.35-1.32-1.79-2.89-3.73a91.85 91.85 0 0 0-9.6-10.36c-8.15-7.36-29.27-19.77-57-19.77a123.13 123.13 0 0 0-46.3 9c-38.37 15.45-63.47 36.58-75.01 47.79l-.09.09A222.14 222.14 0 0 0 63.7 129.5a27 27 0 0 0-4.7 11.77a7.33 7.33 0 0 1-7.71 6.17H50.2a20.65 20.65 0 0 0-14.59 5.9L6.16 182.05l-.32.32a20.89 20.89 0 0 0-.24 28.72c.19.2.37.39.57.58L53.67 258a21 21 0 0 0 14.65 6a20.65 20.65 0 0 0 14.59-5.9l29.46-28.79a20.51 20.51 0 0 0 6.17-14.76Z" /></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-amber-800/70 uppercase tracking-wider">Dalam Perbaikan</p>
                <h3 class="text-2xl font-black text-amber-950">{{ $kamarPerbaikan }}</h3>
            </div>
        </div>
    </div>

    <!-- MODULE: ALERTS -->
    @if (session('success'))
        <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl shadow-sm">
            <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-sm font-bold">{{ session('success') }}</p>
        </div>
    @endif
    @if (session('error'))
        <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm">
            <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-sm font-bold">{{ session('error') }}</p>
        </div>
    @endif

    <!-- MODULE: NAVIGASI TAB (WARNA AMBER) -->
    <div class="relative z-10 flex flex-wrap gap-y-2 ml-[30px] mb-[0]">
        @if(in_array($role, ['admin', 'resepsionis']))
            <a href="{{ route('reservasi', ['tab' => 'aktif']) }}" 
               class="transition {{ $tab === 'aktif' ? 'chrome-tab-active px-5 sm:px-6 py-3 bg-white border border-amber-200 border-b-white rounded-t-xl font-bold text-amber-700 text-xs sm:text-sm relative -mb-[1px]' : 'px-4 sm:px-5 py-1.5 bg-amber-50/70 border border-amber-200/70 rounded-xl font-bold text-amber-800/50 hover:text-amber-700 hover:bg-amber-100 text-xs sm:text-sm relative z-0 ml-1 mb-[4px] shadow-inner' }}">
               Reservasi Aktif
            </a>
        @endif
        
        @if(in_array($role, ['admin', 'owner']))
            <a href="{{ route('reservasi', ['tab' => 'riwayat']) }}" 
               class="transition {{ $tab === 'riwayat' ? 'chrome-tab-active px-5 sm:px-6 py-3 bg-white border border-amber-200 border-b-white rounded-t-xl font-bold text-amber-700 text-xs sm:text-sm relative -mb-[1px]' : 'px-4 sm:px-5 py-1.5 bg-amber-50/70 border border-amber-200/70 rounded-xl font-bold text-amber-800/50 hover:text-amber-700 hover:bg-amber-100 text-xs sm:text-sm relative z-0 ml-1 mb-[4px] shadow-inner' }}">
               Riwayat Reservasi
            </a>
        @endif
    </div>

    <!-- MODULE: KONTEN UTAMA TABLE -->
    <div class="relative z-0 bg-white p-5 lg:p-6 rounded-2xl border border-amber-200 shadow-sm mb-6 -mt-[1px]">
        
        <!-- HEADER AKSI -->
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-amber-100 pb-5">
            @if ($tab === 'aktif' && in_array($role, ['admin', 'resepsionis']))
                <button type="button" onclick="openWalkInModal()" class="cursor-pointer relative z-50 w-full sm:w-auto bg-amber-600 hover:bg-amber-700 text-white px-5 py-3 rounded-xl text-sm font-bold transition shadow-sm flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Tambah Reservasi Baru
                </button>
            @elseif ($tab === 'riwayat' && in_array($role, ['admin', 'owner']))
                <div class="flex gap-2 w-full sm:w-auto">
                    <a href="{{ route('reservasi.pdf') }}" class="flex-1 sm:flex-none justify-center bg-rose-50 text-rose-700 border border-rose-200 px-4 py-3 rounded-xl text-sm font-bold hover:bg-rose-100 transition flex items-center gap-1.5 shadow-sm">📄 Export PDF</a>
                    <a href="{{ route('reservasi.csv') }}" class="flex-1 sm:flex-none justify-center bg-emerald-50 text-emerald-700 border border-emerald-200 px-4 py-3 rounded-xl text-sm font-bold hover:bg-emerald-100 transition flex items-center gap-1.5 shadow-sm">📊 Export CSV</a>
                </div>
            @endif
        </div>

        <!-- FORM PENCARIAN (Tema Amber) -->
        <form method="GET" action="{{ route('reservasi') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end w-full mb-6 pb-6 border-b border-amber-100">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <div class="col-span-1 sm:col-span-2 lg:col-span-1">
                <label class="block text-[10px] font-bold text-amber-800/70 uppercase tracking-wider mb-2">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama / No. Tiket..." class="pl-9 w-full border border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 py-2.5 text-sm transition text-amber-950">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-amber-800/70 uppercase tracking-wider mb-2">Filter Kelas</label>
                <select name="filter_kelas" class="w-full border border-amber-200 rounded-xl shadow-sm focus:border-amber-500 py-2.5 text-sm bg-white transition text-amber-950">
                    <option value="semua">Semua Kelas</option>
                    @foreach ($kelasKamars as $kelas)
                        <option value="{{ $kelas->id }}" {{ request('filter_kelas') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-amber-800/70 uppercase tracking-wider mb-2">Urutan</label>
                <select name="sorting" class="w-full border border-amber-200 rounded-xl shadow-sm focus:border-amber-500 py-2.5 text-sm bg-white transition text-amber-950">
                    <option value="">Default (Terbaru)</option>
                    <option value="waktu_terdekat" {{ request('sorting') == 'waktu_terdekat' ? 'selected' : '' }}>Waktu In Terdekat</option>
                    <option value="waktu_terlama" {{ request('sorting') == 'waktu_terlama' ? 'selected' : '' }}>Waktu In Terlama</option>
                    <option value="harga_tertinggi" {{ request('sorting') == 'harga_tertinggi' ? 'selected' : '' }}>Harga Tertinggi</option>
                    <option value="harga_terendah" {{ request('sorting') == 'harga_terendah' ? 'selected' : '' }}>Harga Terendah</option>
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-amber-800/70 uppercase tracking-wider mb-2">Jadwal Mendatang</label>
                <select name="filter_mingguan" class="w-full border border-amber-200 rounded-xl shadow-sm focus:border-amber-500 py-2.5 text-sm bg-white transition text-amber-950">
                    <option value="">Semua Jadwal</option>
                    <option value="1" {{ request('filter_mingguan') == '1' ? 'selected' : '' }}>H-7 Inap</option>
                </select>
            </div>

            <div class="flex gap-2 w-full relative z-50">
                <button type="submit" class="cursor-pointer flex-1 bg-amber-600 text-white py-2.5 rounded-xl text-sm font-bold hover:bg-amber-700 transition shadow-sm text-center">Filter</button>
                <a href="{{ route('reservasi', ['tab' => $tab]) }}" class="bg-white text-amber-700 px-3 py-2.5 rounded-xl text-sm font-bold hover:bg-amber-50 transition border border-amber-200 text-center shadow-sm">Reset</a>
            </div>
        </form>

        <!-- TABLE HASIL PENCARIAN -->
        <div class="border border-amber-200 rounded-xl overflow-hidden mb-6 shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-amber-50/50 border-b border-amber-200 text-amber-950 font-bold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="px-6 py-4 whitespace-nowrap">No. Reservasi</th>
                            <th class="px-6 py-4 whitespace-nowrap">Nama Tamu & Kontak</th>
                            <th class="px-6 py-4 whitespace-nowrap">Ruangan & Kelas</th>
                            <th class="px-6 py-4 whitespace-nowrap">Waktu Menginap</th>
                            <th class="px-6 py-4 whitespace-nowrap">Status</th>
                            
                            @if(in_array($role, ['admin', 'resepsionis']))
                            <th class="px-6 py-4 whitespace-nowrap text-right">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-50 text-amber-950">
                        @forelse($reservasis as $res)
                            <tr class="hover:bg-amber-50/30 transition">
                                <td class="px-6 py-4 font-bold text-amber-600">#{{ $res->no_reservasi }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-amber-950">{{ $res->nama_tamu }}</div>
                                    <div class="text-xs text-amber-800/70 mt-0.5">{{ $res->no_hp }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-amber-950">Kamar {{ $res->kamar?->nomor_ruangan ?? '-' }}</div>
                                    <div class="text-xs text-amber-800/70 mt-0.5">{{ $res->kamar?->kelasKamar?->nama_kelas ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-amber-950 text-xs">
                                        <span class="text-emerald-600 font-extrabold">In:</span> {{ \Carbon\Carbon::parse($res->check_in)->translatedFormat('d M Y - H:i') }} WIB
                                    </div>
                                    <div class="text-xs text-amber-800/70 font-bold mt-1">
                                        <span class="text-red-500 font-extrabold">Out:</span> {{ \Carbon\Carbon::parse($res->check_out)->translatedFormat('d M Y - H:i') }} WIB
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $badgeColor = match ($res->status_reservasi) {
                                            'Menunggu Konfirmasi' => 'bg-orange-50 text-orange-600 border-orange-200',
                                            'Terkonfirmasi' => 'bg-blue-50 text-blue-700 border-blue-200',
                                            'Check-In' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'Selesai' => 'bg-gray-100 text-gray-700 border-gray-300',
                                            'Batal', 'Dibatalkan' => 'bg-red-50 text-red-700 border-red-200',
                                            default => 'bg-gray-50 text-gray-700',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center justify-center rounded-lg {{ $badgeColor }} border px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider">
                                        {{ $res->status_reservasi }}
                                    </span>
                                </td>
                                
                                @if(in_array($role, ['admin', 'resepsionis']))
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2 relative z-50">
                                        @php
                                            $ekstra = is_array($res->ekstra) ? $res->ekstra : json_decode($res->ekstra, true) ?? [];
                                            $metode = $ekstra['Metode Pembayaran'] ?? 'Tunai';
                                            $pembayaran = $res->pembayaran;
                                            $qrImage = $pembayaran ? $pembayaran->qr_image : null;
                                            $statusBayar = $pembayaran ? $pembayaran->status : 'pending';
                                        @endphp

                                        @if ($res->status_reservasi === 'Menunggu Konfirmasi')
                                            
                                            <!-- TOMBOL BUKA SELALU MUNCUL UNTUK MENGECEK DETAIL -->
                                            <button type="button" onclick='bukaWalkInEdit(@json($res))' class="cursor-pointer bg-orange-50 text-orange-600 hover:bg-orange-100 border border-orange-200 px-4 py-2 rounded-lg text-xs font-bold transition shadow-sm">Buka</button>

                                            @if($statusBayar === 'berhasil')
                                                <!-- TOMBOL CEPAT KONFIRMASI -->
                                                <form id="formKonf-{{ $res->id }}" action="{{ route('reservasi.konfirmasi', $res->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="button" onclick="showMyConfirm('Setujui Reservasi?', 'Status pesanan tamu ini akan diubah menjadi Terkonfirmasi dan diteruskan ke panel Check-In.', 'emerald', 'Ya, Konfirmasi', 'formKonf-{{ $res->id }}')" class="cursor-pointer bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 px-4 py-2 rounded-lg text-xs font-bold transition shadow-sm">Konfirmasi</button>
                                                </form>
                                            @elseif(empty($qrImage))
                                                <!-- TOMBOL CEPAT HAPUS (Khusus Jika QRIS belum digenerate / Metode Tunai) -->
                                                <form id="formBatal-{{ $res->id }}" action="{{ route('reservasi.batal', $res->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="button" onclick="showMyConfirm('Batalkan Reservasi?', 'Data pesanan ini akan dibatalkan dan dipindahkan ke riwayat arsip.', 'danger', 'Ya, Hapus', 'formBatal-{{ $res->id }}')" class="cursor-pointer bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 px-4 py-2 rounded-lg text-xs font-bold transition shadow-sm">Hapus</button>
                                                </form>
                                            @endif
                                            
                                        @elseif($res->status_reservasi === 'Terkonfirmasi' || $res->status_reservasi === 'Check-In')
                                            <a href="{{ route('checkinout') }}" class="bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 px-4 py-2 rounded-lg text-xs font-bold transition shadow-sm flex items-center gap-1">Teruskan &rarr;</a>
                                        @else
                                            <span class="text-[10px] text-amber-800/50 font-medium italic">Arsip Terkunci</span>
                                        @endif
                                    </div>
                                </td>
                                @endif
                            </tr>
                        @empty
                            <tr><td colspan="{{ in_array($role, ['admin', 'resepsionis']) ? '6' : '5' }}" class="px-6 py-12 text-center text-amber-800/50 font-medium">Tidak ada data reservasi ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- MODULE: PAGINATION (TEMA AMBER) -->
        <div class="mt-4 flex flex-col sm:flex-row justify-between items-center gap-4 bg-amber-50 p-4 rounded-2xl border border-amber-200 shadow-sm">
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-amber-800 uppercase tracking-wider">Navigasi:</span>
            </div>
            <div class="w-full sm:w-auto overflow-x-auto">
                {{ $reservasis->links() }}
            </div>
        </div>
    </div>

    <!-- MODULE: MODAL 1: PANEL RESERVASI BARU (HANYA UNTUK ADMIN/RESEPSIONIS) -->
    @if(in_array($role, ['admin', 'resepsionis']))
    <div id="walkInModal" class="fixed inset-0 z-[60] hidden pointer-events-none flex items-center justify-center bg-gray-900/60 backdrop-blur-sm p-4">
        <div class="bg-amber-50/50 rounded-2xl shadow-2xl w-full max-w-5xl flex flex-col overflow-hidden max-h-[95vh] pointer-events-auto border border-amber-200">
            <div class="bg-amber-600 px-6 py-4 flex justify-between items-center shrink-0">
                <h3 class="text-xl font-extrabold text-white" id="modalWalkinTitle">Reservasi Baru</h3>
                <button type="button" onclick="closeWalkInModal()" class="text-white/80 hover:text-white transition font-black text-2xl leading-none cursor-pointer">&times;</button>
            </div>
            
            <div class="p-6 overflow-y-auto flex-grow bg-white">
                <form id="walkInForm" method="POST" action="{{ route('reservasi.store') }}" class="h-full">
                    @csrf
                    <!-- TAMBAHKAN INPUT HIDDEN INI AGAR FUNGSI SHOWMYCONFIRM BISA MENYISIPKAN ACTION_TYPE -->
                    <input type="hidden" id="co_action_type" name="action_type" value="simpan">
                    <input type="hidden" id="edit_reservasi_id"> 

                    <div class="grid grid-cols-1 lg:grid-cols-[1.2fr_1fr] gap-6 items-stretch h-full">
                        
                        <!-- BAGIAN KIRI: FORM -->
                        <div class="flex flex-col gap-4">
                            <!-- Box Pilih Kamar -->
                            <div class="bg-white rounded-xl border border-amber-200 p-4 shadow-sm flex flex-col">
                                <h4 class="font-bold text-amber-950 mb-3">Pilih Kamar</h4>
                                <div class="grid grid-cols-2 gap-3 mb-3">
                                    <div>
                                        <label class="block text-[11px] text-amber-800/70 mb-1">Pilih Kelas</label>
                                        <select name="kelas_kamar_id" id="kelas_kamar_id" onchange="filterKamarDanHitung()" required class="w-full border border-amber-200 rounded-lg p-2 text-xs font-bold text-amber-950 bg-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                                            <option value="" data-harga="0">Kelas Kamar</option>
                                            @foreach ($kelasKamars as $kelas)
                                                <option value="{{ $kelas->id }}" data-harga="{{ $kelas->harga }}">{{ $kelas->nama_kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[11px] text-amber-800/70 mb-1">Pilih Kamar</label>
                                        <select name="kamar_id" id="kamar_id" required class="w-full border border-amber-200 rounded-lg p-2 text-xs font-bold text-amber-950 bg-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                                            <option value="">Memuat...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3 mb-3">
                                    <div>
                                        <label class="block text-[11px] text-amber-800/70 mb-1">Check-in</label>
                                        <div class="flex border border-amber-200 rounded-lg overflow-hidden focus-within:ring-1 focus-within:border-amber-500">
                                            <input type="datetime-local" name="check_in" id="check_in" value="{{ date('Y-m-d\TH:i') }}" onchange="syncMinCheckout(); filterKamarDanHitung();" required class="flex-1 border-none p-2 text-xs font-bold text-amber-950 focus:ring-0 cursor-pointer">
                                            <button type="button" onclick="adjustDate('check_in', -1)" class="px-2 bg-amber-50 hover:bg-amber-100 border-l border-r border-amber-200 text-amber-700 font-bold transition">&lt;</button>
                                            <button type="button" onclick="adjustDate('check_in', 1)" class="px-2 bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold transition">&gt;</button>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[11px] text-amber-800/70 mb-1">Check-out (Batas: 11.00)</label>
                                        <div class="flex border border-amber-200 rounded-lg overflow-hidden focus-within:ring-1 focus-within:border-amber-500">
                                            <input type="datetime-local" name="check_out" id="check_out" value="{{ \Carbon\Carbon::now()->addDays(1)->setTime(11, 0)->format('Y-m-d\TH:i') }}" onchange="syncMinCheckout(); filterKamarDanHitung();" required class="flex-1 border-none p-2 text-xs font-bold text-amber-950 focus:ring-0 cursor-pointer">
                                            <button type="button" onclick="adjustDate('check_out', -1)" class="px-2 bg-amber-50 hover:bg-amber-100 border-l border-r border-amber-200 text-amber-700 font-bold transition">&lt;</button>
                                            <button type="button" onclick="adjustDate('check_out', 1)" class="px-2 bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold transition">&gt;</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <label class="block text-[11px] text-amber-800/70 mb-1">Layanan Ekstra</label>
                                    <div class="flex items-center justify-between border border-amber-200 rounded-lg bg-white overflow-hidden">
                                        <span class="text-xs px-3 font-medium text-amber-900">Ekstra Bed</span>
                                        <div class="flex items-center">
                                            <span class="text-xs text-amber-800/70 mr-2">Rp. 50.000</span>
                                            <div class="flex border-l border-amber-200">
                                                <button type="button" onclick="adjustQty('extra_bed_qty', -1)" class="px-2.5 bg-amber-50 hover:bg-amber-100 border-r border-amber-200 text-amber-700 font-bold">&lt;</button>
                                                <input type="number" name="extra_bed" id="extra_bed_qty" value="0" readonly class="w-8 text-center border-none p-1.5 text-xs font-bold text-amber-950 focus:ring-0">
                                                <button type="button" onclick="adjustQty('extra_bed_qty', 1)" class="px-2.5 bg-amber-50 hover:bg-amber-100 border-l border-amber-200 text-amber-700 font-bold">&gt;</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- DIVIDER & TOTAL BIAYA -->
                                <div class="border-t border-dashed border-amber-200 mt-4 pt-3 flex justify-between items-end">
                                    <div>
                                        <p class="text-[10px] font-bold text-amber-800/70 uppercase tracking-wider mb-0.5">Total Biaya</p>
                                        <p class="text-[10px] font-medium text-amber-700/50" id="wi_durasi_malam">1 Malam</p>
                                    </div>
                                    <p class="text-xl font-black text-amber-600" id="wi_total_biaya_kiri">Rp 0</p>
                                </div>
                            </div>

                            <!-- Box Identitas Tamu -->
                            <div class="bg-white rounded-xl border border-amber-200 p-4 shadow-sm">
                                <h4 class="font-bold text-amber-950 mb-3">Identitas Tamu</h4>
                                <div class="grid grid-cols-2 gap-3 mb-2">
                                    <div>
                                        <label class="block text-[11px] text-amber-800/70 mb-1">Nama</label>
                                        <input type="text" name="nama_tamu" id="nama_tamu" required class="w-full border border-amber-200 rounded-lg p-2 text-xs font-bold text-amber-950 focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] text-amber-800/70 mb-1">No. HP</label>
                                        <input type="text" name="no_hp" id="no_hp" required class="w-full border border-amber-200 rounded-lg p-2 text-xs font-bold text-amber-950 focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[11px] text-amber-800/70 mb-1">No. KTP</label>
                                    <input type="text" name="no_ktp" id="no_ktp" class="w-full border border-amber-200 rounded-lg p-2 text-xs font-bold text-amber-950 focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                                </div>
                            </div>

                            <!-- Box Metode Pembayaran -->
                            <div class="bg-white rounded-xl border border-amber-200 p-4 shadow-sm mb-4">
                                <h4 class="font-bold text-amber-950 mb-2">Metode Pembayaran</h4>
                                <label class="block text-[11px] text-amber-800/70 mb-1">Pilih Metode Pembayaran</label>
                                <div class="flex gap-2">
                                    <select name="metode_pembayaran" id="metode_pembayaran" onchange="toggleSimpanBtn()" class="flex-1 border border-amber-200 rounded-lg p-2 text-xs font-bold text-amber-950 focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                                        <option value="Tunai">Tunai</option>
                                        <option value="QRIS">QRIS</option>
                                    </select>
                                    <button type="button" id="btnBukaPembayaran" onclick="generateAndOpenPayment()" class="hidden bg-white border border-amber-200 text-amber-700 px-4 rounded-lg text-xs font-bold hover:bg-amber-50 transition shadow-sm cursor-pointer">Buka Pembayaran</button>
                                </div>
                            </div>
                        </div>

                        <!-- BAGIAN KANAN: PREVIEW KAMAR -->
                        <div class="flex flex-col h-full gap-4">
                            <div class="bg-white rounded-xl border border-amber-200 p-4 shadow-sm flex flex-col flex-grow">
                                <div id="wi_img_container" class="w-full h-[180px] border border-amber-200 rounded-xl mb-3 flex items-center justify-center bg-amber-50 overflow-hidden">
                                    <span id="wi_placeholder_txt" class="text-xs text-amber-700/50">Thumbnail</span>
                                    <img id="wi_img_main" src="" class="hidden w-full h-full object-cover">
                                </div>
                                <div id="wi_thumbnails" class="grid grid-cols-3 gap-2 mb-4">
                                    <div class="h-12 border border-amber-200 rounded-lg bg-amber-50 flex items-center justify-center text-[10px] text-amber-700/50">Foto 1</div>
                                    <div class="h-12 border border-amber-200 rounded-lg bg-amber-50 flex items-center justify-center text-[10px] text-amber-700/50">Foto 2</div>
                                    <div class="h-12 border border-amber-200 rounded-lg bg-amber-50 flex items-center justify-center text-[10px] text-amber-700/50">Foto 3</div>
                                </div>
                                
                                <div class="flex justify-between items-center mb-1">
                                    <h4 id="wi_nama_kelas" class="font-extrabold text-amber-950 text-lg">Nama Kelas Kamar</h4>
                                    <span id="wi_kapasitas" class="text-[10px] border border-amber-200 px-2 py-0.5 rounded bg-amber-50 font-bold text-amber-800">2 org</span>
                                </div>
                                <p class="text-sm font-bold text-amber-600 mb-3 border-b border-amber-100 pb-2"><span id="wi_harga">Rp 000.000</span> <span class="font-medium text-[10px] text-amber-800/50">/ Malam</span></p>
                                
                                <p class="text-[11px] text-amber-800/70 mb-1">Fasilitas Kamar</p>
                                <ul id="wi_fasilitas" class="grid grid-cols-2 gap-x-2 gap-y-1.5 text-[11px] font-medium text-amber-950 flex-grow content-start">
                                    <li class="text-amber-700/50 italic">Pilih kamar...</li>
                                </ul>
                            </div>

                            <!-- Tombol Aksi Bawah -->
                            <div class="flex flex-col gap-2 shrink-0">
                                <button type="button" id="btnSimpanSaja" class="w-full cursor-pointer border border-amber-300 bg-white hover:bg-amber-50 text-amber-900 font-bold shadow-sm py-2.5 rounded-lg text-sm transition">Simpan</button>
                                <button type="button" id="btnSimpanCheckin" class="w-full cursor-pointer border border-amber-600 bg-white text-amber-600 hover:bg-amber-600 hover:text-white font-bold shadow-sm py-2.5 rounded-lg text-sm transition">Simpan dan Check-in</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODULE: MODAL 2: PANEL PEMBAYARAN QRIS -->
    <div id="paymentModal" class="fixed inset-0 z-[70] hidden pointer-events-none flex items-center justify-center bg-gray-900/60 backdrop-blur-sm p-4">
        <div class="bg-[#fefce8] rounded-2xl shadow-2xl w-full max-w-4xl flex flex-col overflow-hidden pointer-events-auto border border-amber-200">
            <div class="bg-amber-600 px-6 py-4 flex justify-between items-center border-b border-amber-200">
                <h3 class="text-xl font-extrabold text-white">Detail Pembayaran</h3>
                <button type="button" onclick="window.location.reload()" class="text-amber-100 hover:text-red-300 transition font-bold text-2xl leading-none cursor-pointer">&times;</button>
            </div>

            <div class="p-6 bg-white">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 h-full">
                    
                    <div class="bg-white rounded-2xl border border-amber-200 p-5 flex flex-col shadow-sm">
                        <h4 class="text-xs text-amber-800/70 border-b border-amber-100 pb-2 mb-3">Identitas Tamu</h4>
                        <div class="grid grid-cols-[80px_1fr] gap-y-2 text-[11px] text-amber-950 mb-6">
                            <span>Nama :</span> <span id="pay_nama" class="font-bold"></span>
                            <span>No.HP :</span> <span id="pay_hp" class="font-bold"></span>
                        </div>

                        <h4 class="text-xs text-amber-800/70 border-b border-amber-100 pb-2 mb-3">Rincian Pembayaran</h4>
                        <div class="text-[11px] text-amber-950 space-y-2 mb-6 flex-grow">
                            <p>Kelas Kamar :</p>
                            <p class="pl-4 font-bold" id="pay_kelas"></p>
                            <p class="mt-2">Layanan Ekstra :</p>
                            <p class="pl-4 font-bold" id="pay_bed"></p>
                            <p class="mt-4">Status Pembayaran : <span id="pay_status" class="font-bold text-amber-600 uppercase ml-1">PENDING</span></p>
                            <p>No Pembayaran : <span id="pay_invoice" class="font-bold ml-1"></span></p>
                        </div>

                        <div class="border-t border-amber-200 pt-4">
                            <h3 class="text-xl font-black text-amber-950" id="pay_total">Total : Rp 0</h3>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 h-full">
                        <div class="bg-amber-50/50 rounded-2xl border border-amber-200 p-5 flex-grow flex flex-col items-center justify-center relative shadow-sm">
                            <span class="absolute top-4 text-xs text-amber-800/50">QRIS Code</span>
                            <div id="pay_timer_container" class="absolute top-10 left-0 right-0 flex justify-center hidden z-10">
                                <div class="bg-white border border-red-300 text-red-600 text-lg font-black px-4 py-1 rounded-xl shadow-sm tracking-widest animate-pulse" id="pay_timer">Menghitung...</div>
                            </div>
                            <div id="pay_qris_box" class="w-full h-full min-h-[250px] flex flex-col items-center justify-center mt-6">
                                <!-- QR Image Injected Here -->
                            </div>
                        </div>
                        <button type="button" id="btnDownloadQr" class="w-full cursor-pointer bg-amber-600 hover:bg-amber-700 text-white shadow-sm py-3 rounded-xl text-xs font-bold transition">Download Kode QRIS</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- MODULE: MODAL KONFIRMASI LOKAL -->
    <div id="localConfirmModal" class="fixed inset-0 z-[999999] hidden pointer-events-none items-center justify-center bg-gray-900/60 backdrop-blur-sm transition-opacity duration-300 opacity-0">
        <div id="localConfirmContent" class="relative p-4 w-full max-w-md transform scale-95 transition-transform duration-300 pointer-events-auto">
            <div class="relative bg-white border border-amber-200 rounded-3xl shadow-2xl p-6 md:p-8 text-center overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-amber-50 rounded-bl-full -z-10"></div>
                <button type="button" onclick="closeLocalConfirm()" class="absolute top-4 right-4 text-amber-400 bg-transparent hover:bg-amber-100 hover:text-amber-900 rounded-xl text-sm w-8 h-8 ms-auto inline-flex justify-center items-center transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/></svg>
                </button>
                <div class="relative w-20 h-20 mx-auto mb-5 flex items-center justify-center">
                    <div id="localIconContainer" class="w-16 h-16 rounded-full flex items-center justify-center border-4 border-white shadow-sm ring-2">
                        <svg id="localIconSvg" class="w-10 h-10" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </div>
                </div>
                <h3 id="localConfirmTitle" class="mb-2 text-xl font-bold text-amber-950"></h3>
                <p id="localConfirmMessage" class="mb-6 text-sm text-amber-800/70 font-medium"></p>
                <div class="flex justify-center gap-3">
                    <button type="button" onclick="closeLocalConfirm()" class="cursor-pointer text-amber-900 bg-white border border-amber-300 hover:bg-amber-50 font-bold rounded-xl text-sm px-5 py-2.5 transition">Batal</button>
                    <button type="button" id="localConfirmBtn" class="cursor-pointer text-white font-bold rounded-xl text-sm px-5 py-2.5 transition"></button>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.kelasDataWalkin = @json($kelasKamars);
        window.LaravelCSRFToken = '{{ csrf_token() }}';
    </script>
    <script src="{{ asset('js/dashboard/reservasi.js') }}?v={{ time() }}"></script>
</x-dblayout>
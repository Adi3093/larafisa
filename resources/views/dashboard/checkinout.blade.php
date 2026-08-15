<x-dblayout>
    <link rel="stylesheet" href="{{ asset('css/checkinout.css') }}?v={{ time() }}">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Check-in / Check-Out</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola kedatangan tamu dan proses pembayaran akhir.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-5 rounded-2xl border border-amber-200 shadow-sm flex items-center gap-4">
            <div class="bg-emerald-100 p-3 rounded-xl text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Kamar Tersedia</p>
                <h3 class="text-2xl font-black text-gray-900">{{ $kamarTersedia }}</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-amber-200 shadow-sm flex items-center gap-4">
            <div class="bg-blue-100 p-3 rounded-xl text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Kamar Terpakai</p>
                <h3 class="text-2xl font-black text-gray-900">{{ $kamarTerpakai }}</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-amber-200 shadow-sm flex items-center gap-4">
            <div class="bg-rose-100 p-3 rounded-xl text-rose-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Dalam Perbaikan</p>
                <h3 class="text-2xl font-black text-gray-900">{{ $kamarPerbaikan }}</h3>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div
            class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl shadow-sm">
            <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm font-bold">{{ session('success') }}</p>
        </div>
    @endif
    @if (session('error'))
        <div
            class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm">
            <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm font-bold">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Filter dan Search -->
    <div class="bg-white p-5 rounded-2xl border border-amber-200 shadow-sm mb-6">
        <form method="GET" action="{{ route('checkinout') }}" id="filterForm" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari Nama / No. Reservasi..."
                    class="pl-9 w-full border border-amber-200 rounded-xl shadow-sm focus:border-[#E97609] focus:ring-1 focus:ring-[#E97609] py-2.5 text-sm text-gray-900 transition font-medium">
            </div>
            <div class="w-full md:w-48">
                <select name="filter_kelas"
                    class="w-full border border-amber-200 rounded-xl shadow-sm focus:border-[#E97609] focus:ring-1 focus:ring-[#E97609] py-2.5 text-sm bg-white text-gray-900 transition font-medium">
                    <option value=""> Kelas Kamar </option>
                    @foreach ($kelasKamars as $kelas)
                        <option value="{{ $kelas->id }}"
                            {{ request('filter_kelas') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-48">
                <select name="filter_kamar"
                    class="w-full border border-amber-200 rounded-xl shadow-sm focus:border-[#E97609] focus:ring-1 focus:ring-[#E97609] py-2.5 text-sm bg-white text-gray-900 transition font-medium">
                    <option value=""> No. kamar </option>
                    @foreach ($kamars as $kmr)
                        <option value="{{ $kmr->id }}"
                            {{ request('filter_kamar') == $kmr->id ? 'selected' : '' }}>Kamar
                            {{ $kmr->nomor_ruangan }}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
            <div class="flex gap-2">
                <button type="submit"
                    class="bg-[#E97609] text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-[#c96307] transition shadow-sm">Cari</button>
                <a href="{{ route('checkinout') }}"
                    class="bg-white text-gray-700 px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-gray-50 transition border border-amber-200 shadow-sm flex items-center justify-center">Reset</a>
            </div>
        </form>
    </div>

    <!-- check-in/out card -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-6">
        @forelse($reservasis as $res)
            @php
                $checkInDate = \Carbon\Carbon::parse($res->check_in);
                $checkOutDate = \Carbon\Carbon::parse($res->check_out);
                $inStart = $checkInDate->copy()->startOfDay();
                $outStart = $checkOutDate->copy()->startOfDay();
                $diffDays = max(1, (int) $inStart->diffInDays($outStart));

                $hargaKamar = $res->kamar->kelasKamar->harga ?? 0;
                $ekstra = is_array($res->ekstra) ? $res->ekstra : json_decode($res->ekstra, true) ?? [];

                $qtyBed = $ekstra['Extra Bed'] ?? 0;
                $pesanTamu = $ekstra['Pesan'] ?? '-';

                $kamarName = 'Kamar ' . ($res->kamar->nomor_ruangan ?? '?');
                $kelasName = $res->kamar->kelasKamar->nama_kelas ?? '-';

                $cardBorder =
                    $res->status_reservasi === 'Terkonfirmasi'
                        ? 'border-orange-300 shadow-orange-100'
                        : 'border-emerald-300 shadow-emerald-100';
                $headerBg = $res->status_reservasi === 'Terkonfirmasi' ? 'bg-orange-50' : 'bg-emerald-50';
            @endphp

            <div
                class="bg-white rounded-2xl border {{ $cardBorder }} shadow-md flex flex-col overflow-hidden transition-transform hover:-translate-y-1">
                <div class="{{ $headerBg }} px-5 py-4 border-b border-gray-100 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-black text-gray-900 leading-none">{{ $kamarName }}</h2>
                        <p class="text-xs font-bold text-gray-500 mt-1">{{ $kelasName }}</p>
                    </div>
                    @if ($res->status_reservasi === 'Terkonfirmasi')
                        <span
                            class="inline-flex items-center gap-1 rounded-lg bg-orange-100 px-2 py-1 text-[10px] font-bold text-orange-800 border border-orange-200 uppercase">
                            <span class="h-1.5 w-1.5 rounded-full bg-orange-500"></span> Menunggu
                        </span>
                    @else
                        <span
                            class="inline-flex items-center gap-1 rounded-lg bg-emerald-100 px-2 py-1 text-[10px] font-bold text-emerald-800 border border-emerald-200 uppercase">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Menginap
                        </span>
                    @endif
                </div>

                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div class="space-y-3 mb-4">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Nama Tamu</p>
                            <p class="font-bold text-gray-900 text-sm truncate">{{ $res->nama_tamu }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tgl Check-In
                                </p>
                                <p class="font-bold text-gray-800 text-xs">
                                    {{ $checkInDate->translatedFormat('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tgl Check-Out
                                </p>
                                <p class="font-bold text-gray-800 text-xs">
                                    {{ $checkOutDate->translatedFormat('d M Y') }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Fasilitas Ekstra
                            </p>
                            <p class="font-bold text-gray-700 text-xs">
                                @if ($qtyBed == 0)
                                    <span class="italic text-gray-400 font-medium">Tidak ada tambahan</span>
                                @else
                                    {{ $qtyBed > 0 ? $qtyBed . 'x Extra Bed' : '' }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-3 flex justify-between items-end">
                        <p class="text-xs font-bold text-gray-500 uppercase">Estimasi Biaya:</p>
                        <p class="text-lg font-black text-[#E97609]">Rp
                            {{ number_format($hargaKamar * $diffDays + $qtyBed * 50000, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="p-4 bg-gray-50 border-t border-gray-100 flex gap-2">
                    @if ($res->status_reservasi === 'Terkonfirmasi')
                        <button type="button"
                            class="flex-1 bg-white border border-gray-300 text-gray-700 px-3 py-2.5 rounded-xl text-xs font-bold hover:bg-gray-100 transition text-center shadow-sm"
                            onclick="showMyConfirm('Belum Check-In', 'Silakan Proses Check-In terlebih dahulu untuk mengelola pembayaran.', 'amber', 'OK, Mengerti', null, null)">Detail</button>

                        <form id="formCheckin-{{ $res->id }}" method="POST"
                            action="{{ route('checkinout.checkin', $res->id) }}" class="flex-1 m-0">
                            @csrf
                            <button type="button"
                                onclick="showMyConfirm('Proses Check-In?', 'Serahkan kunci dan proses Check-In tamu ini.', 'emerald', 'Ya, Check-In', 'formCheckin-{{ $res->id }}', null)"
                                class="w-full bg-[#E97609] hover:bg-[#c96307] text-white px-3 py-2.5 rounded-xl text-xs font-bold transition shadow-sm text-center">Check-In</button>
                        </form>
                    @elseif($res->status_reservasi === 'Check-In')
                        @php
                            $pembayaranAwal = $res->pembayaran;
                            $totalSudahDibayar = $pembayaranAwal ? $pembayaranAwal->total : 0;
                            $invoiceAwal = $pembayaranAwal ? $pembayaranAwal->invoice : 'Belum Tersedia';

                            $pembayaranTambahan = \App\Models\Pembayaran::where('reservasi_id', $res->id)
                                ->where('invoice', 'like', 'ADD-%')
                                ->latest()
                                ->first();
                            $invAdd = $pembayaranTambahan ? $pembayaranTambahan->invoice : '';
                            $qrAdd = $pembayaranTambahan ? $pembayaranTambahan->qr_image : '';
                            $statusAdd = $pembayaranTambahan ? $pembayaranTambahan->status : '';
                            $totalAdd = $pembayaranTambahan ? (int) $pembayaranTambahan->total : 0;
                        @endphp

                        <button type="button"
                            class="flex-1 bg-white border border-orange-200 text-[#E97609] px-3 py-2.5 rounded-xl text-xs font-bold hover:bg-orange-50 transition text-center shadow-sm"
                            onclick="bukaModalCheckout('{{ $res->id }}', '{{ $res->no_reservasi }}', '{{ addslashes($res->nama_tamu) }}', '{{ $res->no_hp }}', '{{ $kelasName }}', '{{ $kamarName }}', {{ $qtyBed }}, '{{ $res->check_in }}', '{{ $checkOutDate->format('Y-m-d\TH:i') }}', {{ $hargaKamar }}, {{ $totalSudahDibayar }}, '{{ $invoiceAwal }}', '{{ addslashes($pesanTamu) }}', '{{ $invAdd }}', '{{ $qrAdd }}', '{{ $statusAdd }}', {{ $totalAdd }})">Detail
                            Biaya</button>

                        <button type="button"
                            class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-2.5 rounded-xl text-xs font-bold transition shadow-sm text-center"
                            onclick="bukaModalCheckout('{{ $res->id }}', '{{ $res->no_reservasi }}', '{{ addslashes($res->nama_tamu) }}', '{{ $res->no_hp }}', '{{ $kelasName }}', '{{ $kamarName }}', {{ $qtyBed }}, '{{ $res->check_in }}', '{{ $checkOutDate->format('Y-m-d\TH:i') }}', {{ $hargaKamar }}, {{ $totalSudahDibayar }}, '{{ $invoiceAwal }}', '{{ addslashes($pesanTamu) }}', '{{ $invAdd }}', '{{ $qrAdd }}', '{{ $statusAdd }}', {{ $totalAdd }})">Check-Out</button>
                    @endif
                </div>
            </div>
        @empty
            <div
                class="col-span-1 md:col-span-2 xl:col-span-3 py-16 text-center bg-white rounded-2xl border border-gray-100">
                <div class="flex flex-col items-center justify-center text-gray-500">
                    <div class="bg-gray-50 p-4 rounded-full mb-4"><svg class="w-12 h-12 text-gray-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4">
                            </path>
                        </svg></div>
                    <p class="font-bold text-gray-900 text-lg">Meja Resepsionis Kosong</p>
                </div>
            </div>
        @endforelse
    </div>

    @if ($reservasis->total() > 0)
        <div
            class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-2">
                <label class="text-sm font-bold text-gray-600">Tampilkan:</label>
                <form method="GET" action="{{ route('checkinout') }}" id="formPerPage">
                    @if (request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    @if (request('filter_kelas'))
                        <input type="hidden" name="filter_kelas" value="{{ request('filter_kelas') }}">
                    @endif
                    @if (request('filter_kamar'))
                        <input type="hidden" name="filter_kamar" value="{{ request('filter_kamar') }}">
                    @endif
                    <select name="per_page" onchange="document.getElementById('formPerPage').submit()"
                        class="border border-gray-200 rounded-lg text-sm bg-gray-50 focus:ring-[#E97609] focus:border-[#E97609] font-bold text-gray-700 py-1.5 px-3">
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 Baris</option>
                        <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15 Baris</option>
                        <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20 Baris</option>
                    </select>
                </form>
            </div>
            <div class="w-full sm:w-auto overflow-x-auto">{{ $reservasis->links() }}</div>
        </div>
    @endif

    <!-- check-out -->
    <div id="modalCheckout"
        class="fixed inset-0 z-[999] hidden flex items-center justify-center bg-gray-900/60 backdrop-blur-sm p-4">
        <div class="bg-[#f0f4f8] rounded-2xl shadow-2xl w-full max-w-4xl flex flex-col overflow-hidden max-h-[95vh]">

            <div class="bg-[#E97609] px-6 py-4 flex justify-between items-center shrink-0">
                <h3 class="text-xl font-extrabold text-white">Tinjauan Biaya dan Check-out</h3>
                <button type="button" onclick="document.getElementById('modalCheckout').classList.add('hidden')"
                    class="text-white/80 hover:text-white transition font-black text-2xl leading-none">&times;</button>
            </div>

            <div class="p-6 overflow-y-auto flex-grow">
                <form id="formCheckoutModal" method="POST" action="">
                    @csrf
                    <input type="hidden" id="co_action_type" name="action_type" value="">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-stretch h-full">
                        <!-- Detail PEsanan -->
                        <div class="bg-white rounded-xl border border-gray-300 p-5 shadow-sm flex flex-col h-full">
                            <div class="flex justify-between items-end border-b border-gray-200 pb-2 mb-3">
                                <h4 class="text-lg font-bold text-gray-900">Detail Tamu</h4>
                                <span class="text-[10px] font-bold text-gray-500" id="co_no_res"></span>
                            </div>
                            <div class="space-y-1 mb-5">
                                <p class="text-sm font-bold text-gray-900" id="co_nama"></p>
                                <p class="text-xs font-bold text-gray-500" id="co_kontak"></p>
                            </div>

                            <div class="border-b border-gray-200 pb-2 mb-3">
                                <h4 class="text-lg font-bold text-gray-900">Detail Pesanan</h4>
                            </div>
                            <p class="text-sm font-bold text-[#E97609] mb-4" id="co_kelas_kamar"></p>

                            <div class="mb-4">
                                <div
                                    class="flex items-center justify-between border border-gray-300 rounded-lg bg-white overflow-hidden shadow-sm">
                                    <span class="text-xs px-3 font-medium text-gray-700">Fasilitas Ekstra (Extra
                                        Bed)</span>
                                    <div class="flex items-center">
                                        <div class="flex border-l border-gray-300">
                                            <button type="button" onclick="adjustQtyCheckout('co_bed_qty', -1)"
                                                class="px-3 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold transition">&minus;</button>
                                            <input type="number" name="extra_bed_qty" id="co_bed_qty"
                                                min="0" readonly
                                                class="w-10 text-center border-none bg-white p-1.5 text-xs font-bold text-gray-900 focus:ring-0">
                                            <button type="button" onclick="adjustQtyCheckout('co_bed_qty', 1)"
                                                class="px-3 py-1.5 bg-gray-50 hover:bg-gray-100 border-l border-gray-300 text-gray-600 font-bold transition">&plus;</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3 mb-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Tgl
                                        Check-in</label>
                                    <input type="text" id="co_tanggal_checkin" disabled
                                        class="w-full border border-gray-300 bg-gray-100 rounded-lg p-2.5 text-xs font-bold text-gray-500 cursor-not-allowed">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Tgl
                                        Check-out</label>
                                    <div
                                        class="flex border border-gray-300 rounded-lg overflow-hidden focus-within:ring-1 focus-within:border-[#E97609] shadow-sm">
                                        <input type="datetime-local" name="tanggal_checkout" id="co_tanggal_checkout"
                                            onchange="hitungTotalCheckoutLive()" required
                                            class="flex-1 border-none p-2.5 text-[11px] font-bold text-gray-800 bg-white focus:ring-0 cursor-pointer">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Pesan dari
                                    Tamu</label>
                                <textarea id="co_pesan" disabled rows="2"
                                    class="w-full border border-gray-300 bg-gray-50 rounded-lg p-2 text-xs font-medium text-gray-600 resize-none cursor-not-allowed shadow-sm"></textarea>
                            </div>

                            <div class="mt-auto pt-4 border-t border-gray-200">
                                <div class="flex justify-between items-end mb-1">
                                    <span class="text-sm font-bold text-gray-700">Total Biaya sudah dibayar :</span>
                                    <span class="text-xl font-black text-gray-900" id="co_total_awal">Rp 0</span>
                                </div>
                                <div class="flex justify-between items-center text-[10px] font-bold text-gray-400">
                                    <span>No Pembayaran:</span>
                                    <span id="co_invoice_awal">INV-XXXX</span>
                                </div>
                            </div>
                        </div>

                        <!-- pembayaran tambahan -->
                        <div class="bg-white rounded-xl border border-gray-300 p-5 shadow-sm flex flex-col h-full">
                            <div class="border-b border-gray-200 pb-2 flex justify-between items-end mb-4">
                                <h4 class="text-lg font-bold text-gray-900">Detail Pembayaran Tambahan</h4>
                                <span id="co_status_tambahan"
                                    class="text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded bg-gray-100 text-gray-500 border border-gray-200">Tidak
                                    Ada</span>
                            </div>

                            <div class="space-y-1 mb-4 text-xs font-medium text-gray-600 flex-grow"
                                id="co_rincian_tambahan"></div>

                            <div class="flex justify-between items-end border-b border-gray-200 pb-3 mb-4">
                                <span class="text-sm font-bold text-gray-700">Total Biaya Tambahan :</span>
                                <span class="text-2xl font-black text-red-600" id="co_total_tambahan">Rp 0</span>
                            </div>

                            <div id="box_aksi_tambahan" class="hidden flex-col">
                                <div class="mb-3">
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Pilih
                                        Metode Pembayaran Tambahan</label>
                                    <select id="co_metode_tambahan" onchange="toggleQrisTambahan()"
                                        class="w-full border border-gray-300 rounded-lg p-2.5 text-sm font-bold text-gray-800 shadow-sm focus:border-[#E97609] focus:ring-1 focus:ring-[#E97609]">
                                        <option value="Tunai">Tunai / Cash</option>
                                        <option value="QRIS">QRIS</option>
                                    </select>
                                </div>

                                <div id="area_qris_tambahan" class="hidden flex-col justify-end space-y-3">
                                    <button type="button" id="btnGenTambahan" onclick="generateQrisTambahan()"
                                        class="w-full bg-white border-2 border-[#E97609] text-[#E97609] hover:bg-orange-50 font-bold py-2.5 rounded-lg text-sm transition">Generate
                                        QRIS Tambahan</button>
                                    <div
                                        class="border border-gray-300 bg-gray-50 rounded-xl min-h-[160px] flex items-center justify-center p-3 shadow-sm">
                                        <div id="qris_container_tambahan" class="text-center w-full"><span
                                                class="text-xl text-gray-300 font-black tracking-widest uppercase">QRIS
                                                CODE</span></div>
                                    </div>
                                    <p class="text-center text-[10px] font-bold text-gray-500"
                                        id="txt_invoice_tambahan"></p>
                                </div>

                                <div id="area_tunai_tambahan"
                                    class="flex-col items-center justify-center border border-gray-300 bg-gray-50 rounded-xl mt-2 p-6 flex shadow-sm">
                                    <span class="text-4xl mb-2">💵</span>
                                    <p class="text-sm font-bold text-gray-700">Bayar Tambahan via Tunai</p>
                                </div>
                            </div>

                            <div id="box_tidak_ada_tambahan"
                                class="flex flex-col items-center justify-center border-2 border-dashed border-emerald-200 bg-emerald-50 rounded-xl mt-2 p-8 shadow-sm">
                                <span class="text-4xl mb-2">✅</span>
                                <p class="text-base font-bold text-emerald-700">Tidak ada tagihan ekstra.</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row justify-between items-center border-t border-gray-200 gap-4 mt-6 rounded-b-2xl">
                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <input type="checkbox" id="print_struk" name="print_struk" value="1" checked
                                class="w-5 h-5 text-[#E97609] rounded border-gray-300 focus:ring-[#E97609] cursor-pointer">
                            <label for="print_struk" class="text-sm font-bold text-gray-800 cursor-pointer">Cetak
                                Struk Pembayaran</label>
                        </div>

                        <div class="flex gap-2 w-full sm:w-auto">
                            <button type="button"
                                onclick="showMyConfirm('Simpan Perubahan?', 'Perubahan data biaya dan jadwal akan disimpan ke sistem.', 'amber', 'Ya, Simpan', 'formCheckoutModal', 'simpan')"
                                class="flex-1 sm:flex-none rounded-xl bg-white px-6 py-3 text-sm font-bold text-gray-700 shadow-sm border border-gray-300 hover:bg-gray-100 transition">Simpan
                                Perubahan</button>

                            <button type="button"
                                onclick="showMyConfirm('Selesaikan Reservasi?', 'Proses Check-out tamu akan dilakukan dan struk final akan dicetak.', 'emerald', 'Ya, Check-Out', 'formCheckoutModal', 'checkout')"
                                class="flex-1 sm:flex-none rounded-xl bg-emerald-600 px-6 py-3 text-sm font-bold text-white shadow-sm hover:bg-emerald-700 transition">Check-Out</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Konfirmasi -->
    <div id="localConfirmModal"
        class="fixed inset-0 z-[999999] hidden pointer-events-none items-center justify-center bg-gray-900/60 backdrop-blur-sm transition-opacity duration-300 opacity-0">
        <div id="localConfirmContent"
            class="relative p-4 w-full max-w-md transform scale-95 transition-transform duration-300 pointer-events-auto">
            <div
                class="relative bg-white border border-gray-200 rounded-3xl shadow-2xl p-6 md:p-8 text-center overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gray-50 rounded-bl-full -z-10"></div>
                <button type="button" onclick="closeLocalConfirm()"
                    class="absolute top-4 right-4 text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-xl text-sm w-8 h-8 ms-auto inline-flex justify-center items-center transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18 17.94 6M18 18 6.06 6" />
                    </svg>
                </button>
                <div class="relative w-20 h-20 mx-auto mb-5 flex items-center justify-center">
                    <div id="localIconContainer"
                        class="w-16 h-16 rounded-full flex items-center justify-center border-4 border-white shadow-sm ring-2">
                        <svg id="localIconSvg" class="w-10 h-10" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>
                <h3 id="localConfirmTitle" class="mb-2 text-xl font-bold text-gray-900"></h3>
                <p id="localConfirmMessage" class="mb-6 text-sm text-gray-500 font-medium"></p>
                <div class="flex justify-center gap-3">
                    <button type="button" onclick="closeLocalConfirm()"
                        class="cursor-pointer text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 font-bold rounded-xl text-sm px-5 py-2.5 transition">Batal</button>
                    <button type="button" id="localConfirmBtn"
                        class="cursor-pointer text-white font-bold rounded-xl text-sm px-5 py-2.5 transition"></button>
                </div>
            </div>
        </div>
    </div>

    @if(session('print_struk_id'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.open("{{ route('checkinout.print', session('print_struk_id')) }}", "_blank", "width=400,height=600,toolbar=no,scrollbars=no,resizable=no");
        });
    </script>
    @endif

    <script>
        window.kelasDataWalkin = @json($kelasKamars);
        window.LaravelCSRFToken = '{{ csrf_token() }}';
    </script>
    <script src="{{ asset('js/dashboard/checkinout.js') }}?v={{ time() }}"></script>
</x-dblayout>
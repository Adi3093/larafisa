<x-dblayout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-amber-950 tracking-tight">Check-in / Check-Out</h1>
        <p class="text-sm text-amber-900/70 mt-1">Kelola kedatangan tamu dan proses pembayaran akhir.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-5 rounded-2xl border border-amber-100 shadow-sm flex items-center gap-4">
            <div class="bg-emerald-100 p-3 rounded-xl text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-amber-800/70 uppercase tracking-wider">Kamar Tersedia</p>
                <h3 class="text-2xl font-black text-amber-950">{{ $kamarTersedia }}</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-amber-100 shadow-sm flex items-center gap-4">
            <div class="bg-blue-100 p-3 rounded-xl text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-amber-800/70 uppercase tracking-wider">Kamar Terpakai</p>
                <h3 class="text-2xl font-black text-amber-950">{{ $kamarTerpakai }}</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-amber-100 shadow-sm flex items-center gap-4">
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

    <div class="bg-white p-5 rounded-2xl border border-amber-200 shadow-sm mb-6">
        <form method="GET" action="{{ route('checkinout') }}" id="filterForm" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari Nama / No. Reservasi..."
                    class="pl-9 w-full border border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 py-2.5 text-sm text-amber-950 transition">
            </div>
            <div class="w-full md:w-48">
                <select name="filter_kelas"
                    class="w-full border border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 py-2.5 text-sm bg-white text-amber-950 transition">
                    <option value="">-- Kelas Kamar --</option>
                    @foreach ($kelasKamars as $kelas)
                        <option value="{{ $kelas->id }}"
                            {{ request('filter_kelas') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-48">
                <select name="filter_kamar"
                    class="w-full border border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 py-2.5 text-sm bg-white text-amber-950 transition">
                    <option value="">-- No. Ruangan --</option>
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
                    class="bg-amber-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-amber-700 transition shadow-sm">Cari</button>
                <a href="{{ route('checkinout') }}"
                    class="bg-white text-amber-700 px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-amber-50 transition border border-amber-200 shadow-sm flex items-center justify-center">Reset</a>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-6">
        @forelse($reservasis as $res)
            @php
                $checkInDate = \Carbon\Carbon::parse($res->check_in);
                $checkOutDate = \Carbon\Carbon::parse($res->check_out);
                $diffDays = max(1, $checkInDate->diffInDays($checkOutDate));

                $hargaKamar = $res->kamar->kelasKamar->harga ?? 0;
                $ekstra = is_array($res->ekstra) ? $res->ekstra : json_decode($res->ekstra, true) ?? [];
                $qtyBed = $ekstra['Extra Bed'] ?? 0;
                $qtySelimut = $ekstra['Extra Selimut'] ?? 0;
                $metode = $ekstra['Metode Pembayaran'] ?? 'Bayar di tempat';
                $detail = $ekstra['Detail Pembayaran'] ?? '-';

                $kamarName = 'Kamar ' . ($res->kamar->nomor_ruangan ?? '?');
                $kelasName = $res->kamar->kelasKamar->nama_kelas ?? '-';

                $cardBorder =
                    $res->status_reservasi === 'Terkonfirmasi'
                        ? 'border-amber-300 shadow-amber-100'
                        : 'border-emerald-300 shadow-emerald-100';
                $headerBg = $res->status_reservasi === 'Terkonfirmasi' ? 'bg-amber-50' : 'bg-emerald-50';
            @endphp

            <div
                class="bg-white rounded-2xl border {{ $cardBorder }} shadow-md flex flex-col overflow-hidden transition-transform hover:-translate-y-1">
                <div class="{{ $headerBg }} px-5 py-4 border-b border-gray-100 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-black text-gray-900 leading-none">{{ $kamarName }}</h2>
                        <p class="text-xs font-bold text-gray-600 mt-1">{{ $kelasName }}</p>
                    </div>
                    @if ($res->status_reservasi === 'Terkonfirmasi')
                        <span
                            class="inline-flex items-center gap-1 rounded-lg bg-amber-100 px-2 py-1 text-[10px] font-bold text-amber-800 border border-amber-200 uppercase">
                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Menunggu
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
                            <p class="font-medium text-gray-700 text-xs">
                                @if ($qtyBed == 0 && $qtySelimut == 0)
                                    <span class="italic text-gray-400">Tidak ada tambahan</span>
                                @else
                                    {{ $qtyBed > 0 ? $qtyBed . 'x Extra Bed, ' : '' }}
                                    {{ $qtySelimut > 0 ? $qtySelimut . 'x Extra Selimut' : '' }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-3 flex justify-between items-end">
                        <p class="text-xs font-bold text-gray-500 uppercase">Estimasi Biaya:</p>
                        <p class="text-lg font-black text-amber-700">Rp
                            {{ number_format($hargaKamar * $diffDays + $qtyBed * 100000 + $qtySelimut * 25000, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="p-4 bg-gray-50 border-t border-gray-100 flex gap-2">
                    @if ($res->status_reservasi === 'Terkonfirmasi')
                        <button type="button"
                            class="flex-1 bg-white border border-gray-300 text-gray-700 px-3 py-2.5 rounded-xl text-xs font-bold hover:bg-gray-100 transition text-center"
                            onclick="alert('Silakan Proses Check-In terlebih dahulu untuk mengelola pembayaran.')">Detail</button>
                        <form method="POST" action="{{ route('checkinout.checkin', $res->id) }}"
                            class="flex-1 m-0">
                            @csrf
                            <button type="submit"
                                onclick="return confirm('Serahkan kunci dan proses Check-In tamu ini?')"
                                class="w-full bg-amber-600 hover:bg-amber-700 text-white px-3 py-2.5 rounded-xl text-xs font-bold transition shadow-sm shadow-amber-600/20 text-center">Check-In</button>
                        </form>
                    @elseif($res->status_reservasi === 'Check-In')
                        @php
                            $pembayaranAwal = $res->pembayaran;
                            $totalSudahDibayar = $pembayaranAwal ? $pembayaranAwal->total : 0;
                            $invoiceAwal = $pembayaranAwal ? $pembayaranAwal->invoice : 'Belum Tersedia';

                            // CARI PEMBAYARAN TAMBAHAN (ADD-)
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
                            class="flex-1 bg-white border border-amber-200 text-amber-700 px-3 py-2.5 rounded-xl text-xs font-bold hover:bg-amber-50 transition text-center shadow-sm"
                            onclick="bukaModalCheckout('{{ $res->id }}', '{{ $res->no_reservasi }}', '{{ $res->nama_tamu }}', '{{ $res->no_hp }}', '{{ $kelasName }}', '{{ $kamarName }}', {{ $qtyBed }}, {{ $qtySelimut }}, '{{ $metode }}', '{{ $detail }}', '{{ $res->check_in }}', '{{ $checkOutDate->format('Y-m-d\TH:i') }}', {{ $hargaKamar }}, {{ $totalSudahDibayar }}, '{{ $invoiceAwal }}', '{{ $pesanTamu ?? '-' }}', '{{ $invAdd }}', '{{ $qrAdd }}', '{{ $statusAdd }}', {{ $totalAdd }})">
                            Detail Biaya
                        </button>
                        <button type="button"
                            class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-2.5 rounded-xl text-xs font-bold transition shadow-sm shadow-emerald-600/20 text-center"
                            onclick="bukaModalCheckout('{{ $res->id }}', '{{ $res->no_reservasi }}', '{{ $res->nama_tamu }}', '{{ $res->no_hp }}', '{{ $kelasName }}', '{{ $kamarName }}', {{ $qtyBed }}, {{ $qtySelimut }}, '{{ $metode }}', '{{ $detail }}', '{{ $res->check_in }}', '{{ $checkOutDate->format('Y-m-d\TH:i') }}', {{ $hargaKamar }}, {{ $totalSudahDibayar }}, '{{ $invoiceAwal }}', '{{ $pesanTamu ?? '-' }}', '{{ $invAdd }}', '{{ $qrAdd }}', '{{ $statusAdd }}', {{ $totalAdd }})">
                            Check-Out
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div
                class="col-span-1 md:col-span-2 xl:col-span-3 py-16 text-center bg-white rounded-2xl border border-gray-100">
                <div class="flex flex-col items-center justify-center text-gray-500">
                    <div class="bg-gray-50 p-4 rounded-full mb-4"><svg class="w-12 h-12 text-amber-300"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                        class="border border-gray-200 rounded-lg text-sm bg-gray-50 focus:ring-amber-500 focus:border-amber-500 font-bold text-amber-700 py-1.5 px-3">
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 Baris</option>
                        <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15 Baris</option>
                        <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20 Baris</option>
                    </select>
                </form>
            </div>
            <div class="w-full sm:w-auto overflow-x-auto">{{ $reservasis->links() }}</div>
        </div>
    @endif

    <div id="modalCheckout" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/60 backdrop-blur-sm"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl border border-amber-100">
                <div class="bg-amber-600 px-6 py-4 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white">Tinjauan Biaya dan Check-out</h3>
                    <button type="button" onclick="document.getElementById('modalCheckout').classList.add('hidden')"
                        class="text-amber-200 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form id="formCheckoutModal" method="POST" action="">
                    @csrf
                    <div class="flex flex-col md:flex-row p-6 gap-6">

                        <div class="w-full md:w-1/2 space-y-4">

                            <div class="flex justify-between items-end border-b border-gray-200 pb-2">
                                <h4 class="text-lg font-bold text-amber-950">Detail Tamu</h4>
                                <span class="text-xs font-bold text-gray-500" id="co_no_res"></span>
                            </div>
                            <div class="space-y-1">
                                <p class="text-sm font-bold text-gray-900" id="co_nama"></p>
                                <p class="text-sm font-medium text-gray-600" id="co_kontak"></p>
                            </div>

                            <div class="border-b border-gray-200 pb-2 mt-4">
                                <h4 class="text-lg font-bold text-amber-950">Detail Pesanan</h4>
                            </div>
                            <p class="text-sm font-bold text-amber-800" id="co_kelas_kamar"></p>

                            <div class="space-y-3">
                                <div
                                    class="flex items-center justify-between p-2 border border-gray-300 rounded-lg bg-white shadow-sm">
                                    <span class="text-xs font-bold text-gray-700">Fasilitas Ekstra (Extra Bed)</span>
                                    <div
                                        class="flex items-center border border-gray-200 rounded overflow-hidden bg-gray-50">
                                        <button type="button" onclick="adjustQty('co_bed_qty', -1)"
                                            class="px-3 py-1 font-bold text-gray-600 hover:bg-gray-200 leading-none">&minus;</button>
                                        <input type="number" name="extra_bed_qty" id="co_bed_qty" min="0"
                                            readonly
                                            class="w-10 text-center bg-transparent border-none text-sm font-bold p-0 focus:ring-0">
                                        <button type="button" onclick="adjustQty('co_bed_qty', 1)"
                                            class="px-3 py-1 font-bold text-gray-600 hover:bg-gray-200 leading-none">&plus;</button>
                                    </div>
                                </div>
                                <div
                                    class="flex items-center justify-between p-2 border border-gray-300 rounded-lg bg-white shadow-sm">
                                    <span class="text-xs font-bold text-gray-700">Fasilitas Ekstra (Extra
                                        Selimut)</span>
                                    <div
                                        class="flex items-center border border-gray-200 rounded overflow-hidden bg-gray-50">
                                        <button type="button" onclick="adjustQty('co_selimut_qty', -1)"
                                            class="px-3 py-1 font-bold text-gray-600 hover:bg-gray-200 leading-none">&minus;</button>
                                        <input type="number" name="extra_selimut_qty" id="co_selimut_qty"
                                            min="0" readonly
                                            class="w-10 text-center bg-transparent border-none text-sm font-bold p-0 focus:ring-0">
                                        <button type="button" onclick="adjustQty('co_selimut_qty', 1)"
                                            class="px-3 py-1 font-bold text-gray-600 hover:bg-gray-200 leading-none">&plus;</button>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3 mt-3">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Tgl
                                        Check-in</label>
                                    <input type="text" id="co_tanggal_checkin" disabled
                                        class="w-full border border-gray-300 bg-gray-100 rounded-lg p-2 text-xs font-bold text-gray-600 cursor-not-allowed">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Tgl
                                        Check-out</label>
                                    <input type="datetime-local" name="tanggal_checkout" id="co_tanggal_checkout"
                                        onchange="hitungTotalCheckoutLive()" required
                                        class="w-full border border-amber-300 rounded-lg p-2 text-xs font-bold text-gray-900 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1 mt-3">Pesan dari
                                    Tamu</label>
                                <textarea id="co_pesan" disabled rows="2"
                                    class="w-full border border-gray-300 bg-gray-50 rounded-lg p-2 text-xs text-gray-700 resize-none cursor-not-allowed"></textarea>
                            </div>

                            <div class="mt-4 pt-3 border-t border-gray-200">
                                <div class="flex justify-between items-end mb-1">
                                    <span class="text-sm font-bold text-gray-700">Total Biaya sudah dibayar :</span>
                                    <span class="text-lg font-black text-gray-900" id="co_total_awal">Rp 0</span>
                                </div>
                                <div class="flex justify-between items-center text-[10px] font-bold text-gray-500">
                                    <span>No Pembayaran sudah dibayar:</span>
                                    <span id="co_invoice_awal">INV-XXXX</span>
                                </div>
                            </div>
                        </div>

                        <div class="w-full md:w-1/2 md:border-l md:border-gray-200 md:pl-6 flex flex-col">

                            <div class="border-b border-gray-200 pb-2 flex justify-between items-end">
                                <h4 class="text-lg font-bold text-amber-950">Detail Pembayaran Tambahan</h4>
                                <span id="co_status_tambahan"
                                    class="text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded bg-gray-100 text-gray-500 border border-gray-200">Tidak
                                    Ada</span>
                            </div>

                            <div class="space-y-1 mt-3 mb-4 text-xs font-medium text-gray-600"
                                id="co_rincian_tambahan">
                            </div>

                            <div class="flex justify-between items-end border-b border-gray-200 pb-3 mb-4">
                                <span class="text-sm font-bold text-gray-700">Total Biaya Tambahan :</span>
                                <span class="text-xl font-black text-red-600" id="co_total_tambahan">Rp 0</span>
                            </div>

                            <div id="box_aksi_tambahan" class="hidden flex-col flex-grow">
                                <div class="mb-3">
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Pilih
                                        Metode Pembayaran Tambahan</label>
                                    <select id="co_metode_tambahan" onchange="toggleQrisTambahan()"
                                        class="w-full border border-amber-300 rounded-lg p-2 text-sm font-bold text-gray-900 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                        <option value="Tunai">Tunai / Cash</option>
                                        <option value="QRIS">QRIS</option>
                                    </select>
                                </div>

                                <div id="area_qris_tambahan" class="hidden flex-col flex-grow justify-end space-y-3">
                                    <button type="button" id="btnGenTambahan" onclick="generateQrisTambahan()"
                                        class="w-full bg-white border-2 border-amber-500 text-amber-600 hover:bg-amber-50 font-bold py-2.5 rounded-lg text-sm transition">
                                        Generate QRIS Tambahan
                                    </button>
                                    <div
                                        class="border border-gray-300 bg-gray-50 rounded-xl flex-grow min-h-[180px] flex items-center justify-center p-3">
                                        <div id="qris_container_tambahan" class="text-center w-full">
                                            <span
                                                class="text-xl text-gray-300 font-black tracking-widest uppercase">QRIS
                                                CODE</span>
                                        </div>
                                    </div>
                                    <p class="text-center text-[10px] font-bold text-gray-500"
                                        id="txt_invoice_tambahan"></p>
                                </div>

                                <div id="area_tunai_tambahan"
                                    class="flex-col flex-grow items-center justify-center border border-gray-300 bg-gray-50 rounded-xl mt-2 flex">
                                    <span class="text-3xl mb-1">💵</span>
                                    <p class="text-xs font-bold text-gray-700">Bayar Tambahan via Tunai</p>
                                </div>
                            </div>

                            <div id="box_tidak_ada_tambahan"
                                class="flex flex-col flex-grow items-center justify-center border-2 border-dashed border-emerald-200 bg-emerald-50 rounded-xl mt-4">
                                <span class="text-3xl mb-1">✅</span>
                                <p class="text-sm font-bold text-emerald-700">Tidak ada tagihan ekstra.</p>
                            </div>

                        </div>
                    </div>

                    <div
                        class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row justify-between items-center border-t border-gray-100 gap-4">
                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <input type="checkbox" id="print_struk" name="print_struk" value="1" checked
                                class="w-5 h-5 text-amber-600 rounded border-gray-300 focus:ring-amber-500 cursor-pointer">
                            <label for="print_struk" class="text-sm font-bold text-gray-800 cursor-pointer">Cetak
                                Struk Pembayaran</label>
                        </div>
                        <div class="flex gap-2 w-full sm:w-auto">
                            <button type="submit" name="action_type" value="simpan"
                                class="flex-1 sm:flex-none rounded-xl bg-white px-5 py-2.5 text-sm font-bold text-gray-700 shadow-sm border border-gray-300 hover:bg-gray-100 transition">
                                Simpan Perubahan
                            </button>
                            <button type="submit" name="action_type" value="checkout"
                                onclick="return confirm('Selesaikan reservasi dan cetak struk final?')"
                                class="flex-1 sm:flex-none rounded-xl bg-amber-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-amber-700 transition">
                                Check-Out
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Deklarasi Cache
        let cacheResId = 0;
        let cacheHargaKamar = 0;
        let cacheCheckIn = '';
        let cacheTotalAwal = 0;
        let currentTotalTambahan = 0;
        let intervalTambahan = null;

        // Cache khusus untuk pembayaran tambahan (ADD-)
        let cacheInvAdd = '';
        let cacheQrAdd = '';
        let cacheStatusAdd = '';
        let cacheTotalAdd = 0;

        function bukaModalCheckout(id, no_res, nama, hp, kelas, ruangan, qtyBed, qtySelimut, metode, detail, checkIn,
            checkOut, hargaKamar, totalSudahDibayar, invoiceAwal, pesanTamu, invAdd, qrAdd, statusAdd, totalAdd) {

            cacheResId = id;
            cacheHargaKamar = parseInt(hargaKamar);
            cacheCheckIn = checkIn;
            cacheTotalAwal = parseInt(totalSudahDibayar);

            // Simpan data tambahan ke memori
            cacheInvAdd = invAdd;
            cacheQrAdd = qrAdd;
            cacheStatusAdd = statusAdd;
            cacheTotalAdd = parseInt(totalAdd);

            document.getElementById('co_no_res').innerText = '#' + no_res;
            document.getElementById('co_nama').innerText = nama;
            document.getElementById('co_kontak').innerText = 'No. HP: ' + hp;
            document.getElementById('co_kelas_kamar').innerText = ruangan + ' (' + kelas + ')';

            document.getElementById('co_bed_qty').value = qtyBed;
            document.getElementById('co_selimut_qty').value = qtySelimut;

            document.getElementById('co_tanggal_checkin').value = new Date(checkIn).toLocaleString('id-ID', {
                day: 'numeric',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('co_tanggal_checkout').value = checkOut;
            document.getElementById('co_pesan').value = pesanTamu;

            document.getElementById('co_total_awal').innerText = formatRp(cacheTotalAwal);
            document.getElementById('co_invoice_awal').innerText = invoiceAwal;

            document.getElementById('formCheckoutModal').action = `/checkinout/${id}/checkout`;

            if (intervalTambahan) clearInterval(intervalTambahan);

            // Panggil fungsi perhitungan (fungsi ini juga akan menampilkan QR otomatis jika ada)
            hitungTotalCheckoutLive();

            document.getElementById('modalCheckout').classList.remove('hidden');
        }

        function adjustQty(inputId, change) {
            let field = document.getElementById(inputId);
            let val = parseInt(field.value) || 0;
            if (val + change >= 0) {
                field.value = val + change;
                hitungTotalCheckoutLive();
            }
        }

        function toggleQrisTambahan() {
            let metode = document.getElementById('co_metode_tambahan').value;
            if (metode === 'QRIS') {
                document.getElementById('area_qris_tambahan').classList.remove('hidden');
                document.getElementById('area_qris_tambahan').classList.add('flex');
                document.getElementById('area_tunai_tambahan').classList.add('hidden');
                document.getElementById('area_tunai_tambahan').classList.remove('flex');
            } else {
                document.getElementById('area_qris_tambahan').classList.add('hidden');
                document.getElementById('area_qris_tambahan').classList.remove('flex');
                document.getElementById('area_tunai_tambahan').classList.remove('hidden');
                document.getElementById('area_tunai_tambahan').classList.add('flex');
            }
        }

        function formatRp(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
        }

        function hitungTotalCheckoutLive() {
            let cin = new Date(cacheCheckIn);
            let cout = new Date(document.getElementById('co_tanggal_checkout').value);
            let diffDays = 1;

            if (!isNaN(cin) && !isNaN(cout)) {
                diffDays = Math.ceil((cout - cin) / (1000 * 60 * 60 * 24));
                if (diffDays <= 0) diffDays = 1;
            }

            let qtyBed = parseInt(document.getElementById('co_bed_qty').value) || 0;
            let qtySelimut = parseInt(document.getElementById('co_selimut_qty').value) || 0;

            let totalBaru = (cacheHargaKamar * diffDays) + (qtyBed * 100000) + (qtySelimut * 25000);
            currentTotalTambahan = totalBaru - cacheTotalAwal;

            let listHTML = `<p>Waktu Inap Final: ${diffDays} Malam</p>`;
            if (qtyBed > 0) listHTML += `<p>Extra Bed: ${qtyBed}x</p>`;
            if (qtySelimut > 0) listHTML += `<p>Extra Selimut: ${qtySelimut}x</p>`;
            document.getElementById('co_rincian_tambahan').innerHTML = listHTML;

            let boxAksi = document.getElementById('box_aksi_tambahan');
            let boxKosong = document.getElementById('box_tidak_ada_tambahan');
            let statusTambahan = document.getElementById('co_status_tambahan');

            if (currentTotalTambahan > 0) {
                document.getElementById('co_total_tambahan').innerText = formatRp(currentTotalTambahan);
                boxAksi.classList.remove('hidden');
                boxAksi.classList.add('flex');
                boxKosong.classList.add('hidden');
                boxKosong.classList.remove('flex');

                // LOGIKA CERDAS: JIKA ADA QRIS SEBELUMNYA YG NOMINALNYA COCOK, TAMPILKAN OTOMATIS!
                if (cacheInvAdd !== '' && cacheTotalAdd === currentTotalTambahan) {
                    let selectMetode = document.getElementById('co_metode_tambahan');
                    selectMetode.value = 'QRIS';
                    selectMetode.disabled = true; // Kunci agar resepsionis tidak mengubah ke tunai
                    toggleQrisTambahan();

                    document.getElementById('btnGenTambahan').classList.add('hidden');
                    document.getElementById('txt_invoice_tambahan').innerText = "No. Pembayaran: " + cacheInvAdd;

                    if (cacheStatusAdd === 'berhasil') {
                        document.getElementById('qris_container_tambahan').innerHTML =
                            `<div class="text-center w-full animate-fade-in"><div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-2 shadow-sm border-4 border-white ring-2 ring-green-100"><svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24"><path fill="currentColor" d="M10.5 15.25A.74.74 0 0 1 10 15l-3-3a.75.75 0 0 1 1-1l2.47 2.47L19 5a.75.75 0 0 1 1 1l-9 9a.74.74 0 0 1-.5.25Z"/><path fill="currentColor" d="M12 21a9 9 0 0 1-7.87-4.66a8.67 8.67 0 0 1-1.07-3.41a9 9 0 0 1 4.6-8.81a8.67 8.67 0 0 1 3.41-1.07a8.86 8.86 0 0 1 3.55.34a.75.75 0 1 1-.43 1.43a7.62 7.62 0 0 0-3-.28a7.43 7.43 0 0 0-2.84.89a7.5 7.5 0 0 0-2.2 1.84a7.42 7.42 0 0 0-1.64 5.51a7.43 7.43 0 0 0 .89 2.84a7.5 7.5 0 0 0 1.84 2.2a7.42 7.42 0 0 0 5.51 1.64a7.43 7.43 0 0 0 2.84-.89a7.5 7.5 0 0 0 2.2-1.84a7.42 7.42 0 0 0 1.64-5.51a.75.75 0 1 1 1.57-.15a9 9 0 0 1-4.61 8.81A8.67 8.67 0 0 1 12.93 21H12Z"/></svg></div><h4 class="font-black text-green-700 text-base">Lunas!</h4></div>`;
                        statusTambahan.innerText = "Lunas via QRIS";
                        statusTambahan.className =
                            "text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded bg-green-100 text-green-700 border border-green-200";
                    } else {
                        let qrUrl =
                            `https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=${encodeURIComponent(cacheQrAdd)}`;
                        document.getElementById('qris_container_tambahan').innerHTML =
                            `<div class="animate-fade-in w-full flex justify-center"><img src="${qrUrl}" alt="QR Tambahan" class="w-40 h-40 block mx-auto object-contain mix-blend-multiply"></div>`;
                        statusTambahan.innerText = "Belum Dibayar";
                        statusTambahan.className =
                            "text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded bg-orange-100 text-orange-700 border border-orange-200";
                        cekStatusTambahan(cacheInvAdd);
                    }
                } else {
                    // Jika belum pernah di-generate ATAU nominalnya berubah dari yang sebelumnya
                    document.getElementById('co_metode_tambahan').disabled = false;
                    document.getElementById('btnGenTambahan').classList.remove('hidden');
                    document.getElementById('qris_container_tambahan').innerHTML =
                        '<span class="text-xl text-gray-300 font-black tracking-widest uppercase">QRIS CODE</span>';
                    document.getElementById('txt_invoice_tambahan').innerText = '';

                    statusTambahan.innerText = "Belum Dibayar";
                    statusTambahan.className =
                        "text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded bg-orange-100 text-orange-700 border border-orange-200";
                }

            } else {
                currentTotalTambahan = 0;
                document.getElementById('co_total_tambahan').innerText = "Rp 0";
                boxAksi.classList.add('hidden');
                boxAksi.classList.remove('flex');
                boxKosong.classList.remove('hidden');
                boxKosong.classList.add('flex');
                statusTambahan.innerText = "Lunas";
                statusTambahan.className =
                    "text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded bg-green-100 text-green-700 border border-green-200";
            }
        }

        async function generateQrisTambahan() {
            if (currentTotalTambahan <= 0) return;

            let btn = document.getElementById('btnGenTambahan');
            let container = document.getElementById('qris_container_tambahan');
            let txtInv = document.getElementById('txt_invoice_tambahan');

            btn.innerText = "Memproses...";
            btn.disabled = true;

            try {
                // Tembak API via POST
                let response = await fetch(`/checkinout/${cacheResId}/generate-qris-tambahan`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        total_tambahan: currentTotalTambahan
                    })
                });

                let data = await response.json();

                if (data.success) {
                    btn.classList.add('hidden');
                    // 1. Perbesar resolusi gambar dari API menjadi 250x250
                    let qrUrl =
                        `https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=${encodeURIComponent(data.qr_image)}`;

                    // 2. Tambahkan mx-auto, block, dan perbesar ukuran class Tailwind (w-48 h-48)
                    container.innerHTML = `
                        <div class="animate-fade-in w-full flex justify-center">
                            <img src="${qrUrl}" alt="QR Tambahan" class="w-48 h-48 block mx-auto object-contain mix-blend-multiply">
                        </div>
                    `;
                    txtInv.innerText = "No. Pembayaran: " + data.invoice;

                    // Mulai Auto-Check Status
                    cekStatusTambahan(data.invoice);
                } else {
                    alert(data.message);
                    btn.innerText = "Generate QRIS Tambahan";
                    btn.disabled = false;
                }
            } catch (e) {
                alert('Gagal menghubungi server.');
                btn.innerText = "Generate QRIS Tambahan";
                btn.disabled = false;
            }
        }

        function cekStatusTambahan(invoice) {
            if (intervalTambahan) clearInterval(intervalTambahan);

            intervalTambahan = setInterval(async () => {
                try {
                    let res = await fetch(`/payment/check/${invoice}`);
                    let data = await res.json();

                    if (data.status === "berhasil") {
                        clearInterval(intervalTambahan);
                        document.getElementById('qris_container_tambahan').innerHTML = `
                            <div class="text-center">
                                <span class="text-4xl">✅</span>
                                <p class="text-sm font-bold text-green-700 mt-2">Lunas!</p>
                            </div>
                        `;
                        let badge = document.getElementById('co_status_tambahan');
                        badge.innerText = "Lunas via QRIS";
                        badge.className =
                            "text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded bg-green-100 text-green-700 border border-green-200";
                    }
                } catch (e) {}
            }, 5000);
        }
    </script>
</x-dblayout>

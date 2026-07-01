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
                            {{ request('filter_kelas') == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
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
                            {{ request('filter_kamar') == $kmr->id ? 'selected' : '' }}>
                            Kamar {{ $kmr->nomor_ruangan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">

            <div class="flex gap-2">
                <button type="submit"
                    class="bg-amber-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-amber-700 transition shadow-sm">
                    Cari
                </button>
                <a href="{{ route('checkinout') }}"
                    class="bg-white text-amber-700 px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-amber-50 transition border border-amber-200 shadow-sm flex items-center justify-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-6">
        @forelse($reservasis as $res)
            @php
                // Hitung Kalkulasi Harga untuk di dalam Card
                $checkInDate = \Carbon\Carbon::parse($res->check_in);
                $checkOutDate = \Carbon\Carbon::parse($res->check_out);
                $diffDays = $checkInDate->diffInDays($checkOutDate);
                if ($diffDays == 0) {
                    $diffDays = 1;
                }

                $hargaKamar = $res->kamar->kelasKamar->harga ?? 0;
                $totalKamar = $hargaKamar * $diffDays;

                $ekstra = is_array($res->ekstra) ? $res->ekstra : json_decode($res->ekstra, true);
                $qtyBed = $ekstra['Extra Bed'] ?? 0;
                $qtySelimut = $ekstra['Extra Selimut'] ?? 0;
                $metode = $ekstra['Metode Pembayaran'] ?? 'Bayar di tempat';
                $detail = $ekstra['Detail Pembayaran'] ?? '-';

                $totalBed = $qtyBed * 100000;
                $totalSelimut = $qtySelimut * 25000;
                $totalBiaya = $totalKamar + $totalBed + $totalSelimut;

                $kamarName = 'Kamar ' . ($res->kamar->nomor_ruangan ?? '?');
                $kelasName = $res->kamar->kelasKamar->nama_kelas ?? '-';

                // Tentukan border dan warna berdasarkan status
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
                        <p class="text-xs font-bold text-gray-500 uppercase">Total Biaya:</p>
                        <p class="text-lg font-black text-amber-700">Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="p-4 bg-gray-50 border-t border-gray-100 flex gap-2">

                    @if ($res->status_reservasi === 'Terkonfirmasi')
                        <button type="button"
                            class="flex-1 bg-white border border-gray-300 text-gray-700 px-3 py-2.5 rounded-xl text-xs font-bold hover:bg-gray-100 transition text-center"
                            onclick="alert('Silakan Proses Check-In terlebih dahulu untuk mengelola pembayaran.')">
                            Detail
                        </button>
                        <form method="POST" action="{{ route('checkinout.checkin', $res->id) }}"
                            class="flex-1 m-0">
                            @csrf
                            <button type="submit"
                                onclick="return confirm('Serahkan kunci dan proses Check-In tamu ini?')"
                                class="w-full bg-amber-600 hover:bg-amber-700 text-white px-3 py-2.5 rounded-xl text-xs font-bold transition shadow-sm shadow-amber-600/20 text-center">
                                Check-In
                            </button>
                        </form>
                    @elseif($res->status_reservasi === 'Check-In')
                        <button type="button"
                            class="flex-1 bg-white border border-gray-300 text-gray-700 px-3 py-2.5 rounded-xl text-xs font-bold hover:bg-gray-100 transition text-center"
                            onclick="bukaModalCheckout('{{ $res->id }}', '{{ $res->no_reservasi }}', '{{ $res->nama_tamu }}', '{{ $res->no_hp }}', '{{ $kelasName }}', '{{ $kamarName }}', {{ $qtyBed }}, {{ $qtySelimut }}, '{{ $metode }}', '{{ $detail }}', {{ $totalBiaya }})">
                            Detail Biaya
                        </button>
                        <button type="button"
                            onclick="bukaModalCheckout('{{ $res->id }}', '{{ $res->no_reservasi }}', '{{ $res->nama_tamu }}', '{{ $res->no_hp }}', '{{ $kelasName }}', '{{ $kamarName }}', {{ $qtyBed }}, {{ $qtySelimut }}, '{{ $metode }}', '{{ $detail }}', {{ $totalBiaya }})"
                            class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-2.5 rounded-xl text-xs font-bold transition shadow-sm shadow-emerald-600/20 text-center">
                            Check-Out
                        </button>
                    @endif
                </div>

            </div>
        @empty
            <div
                class="col-span-1 md:col-span-2 xl:col-span-3 py-16 text-center bg-white rounded-2xl border border-gray-100">
                <div class="flex flex-col items-center justify-center text-gray-500">
                    <div class="bg-gray-50 p-4 rounded-full mb-4">
                        <svg class="w-12 h-12 text-amber-300" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4">
                            </path>
                        </svg>
                    </div>
                    <p class="font-bold text-gray-900 text-lg">Meja Resepsionis Kosong</p>
                    <p class="text-sm mt-1 max-w-sm">Saat ini tidak ada tamu yang sedang mengantre atau tidak ada data
                        yang cocok dengan filter Anda.</p>
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

            <div class="w-full sm:w-auto overflow-x-auto">
                {{ $reservasis->links() }}
            </div>
        </div>
    @endif

    <div id="modalCheckout" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/60 backdrop-blur-sm"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-amber-100">

                <div class="bg-amber-600 px-6 py-4 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white">Tinjau Pembayaran & Check-Out</h3>
                    <button onclick="document.getElementById('modalCheckout').classList.add('hidden')"
                        class="text-amber-200 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form id="formCheckoutModal" method="POST" action="">
                    @csrf
                    <div class="p-6 pb-2">

                        <div class="flex justify-between items-start border-b border-gray-100 pb-4 mb-4">
                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Data Tamu</p>
                                <h4 class="text-lg font-black text-amber-950 leading-none" id="co_nama"></h4>
                                <p class="text-sm text-gray-500 mt-1" id="co_kontak"></p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">ID Reservasi
                                </p>
                                <h4 class="text-sm font-bold text-amber-600" id="co_no_res"></h4>
                            </div>
                        </div>

                        <div class="mb-5">
                            <h4 class="text-base font-bold text-gray-900 mb-2" id="co_kelas_kamar"></h4>
                            <div id="co_addon_container" class="flex flex-wrap gap-2 mt-2"></div>
                        </div>

                        <div class="bg-amber-50/50 p-4 rounded-xl border border-amber-200 mb-4">
                            <div class="flex justify-between items-center border-b border-amber-200 pb-3 mb-3">
                                <p class="text-xs font-bold text-amber-800 uppercase tracking-wider">Total Tagihan
                                    Final</p>
                                <h2 class="text-2xl font-black text-amber-700" id="co_total">Rp 0</h2>
                            </div>

                            <div class="grid grid-cols-2 gap-4 items-center">
                                <div>
                                    <p class="text-[10px] font-bold text-amber-800 uppercase tracking-wider mb-1">
                                        Status Metode</p>
                                    <p class="text-sm font-bold text-gray-900" id="co_metode"></p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-amber-800 uppercase tracking-wider mb-1">Ubah
                                        Pembayaran</p>
                                    <select name="detail_pembayaran" id="co_detail_pembayaran"
                                        class="w-full border border-amber-200 rounded-lg p-2 text-sm bg-white font-bold text-amber-950 shadow-sm focus:ring-amber-500 focus:border-amber-500">
                                        <option value="Cash/Tunai">Cash / Tunai</option>
                                        <option value="Transfer Bank">Transfer Bank</option>
                                        <option value="Q-RIS">Q-RIS</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 bg-gray-50 p-3 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-100 transition"
                            onclick="document.getElementById('print_struk').click()">
                            <input type="checkbox" id="print_struk" name="print_struk" value="1" checked
                                class="w-5 h-5 text-amber-600 rounded border-gray-300 focus:ring-amber-500 cursor-pointer">
                            <div>
                                <p class="text-sm font-bold text-gray-800 leading-none">Cetak Struk Pembayaran</p>
                                <p class="text-[11px] text-gray-500 mt-1">Struk akan otomatis dicetak menggunakan
                                    pengaturan printer bawaan kasir.</p>
                            </div>
                        </div>

                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex gap-3 border-t border-gray-100 mt-4">
                        <button type="submit"
                            onclick="return confirm('Apakah pembayaran sudah lunas dan kunci sudah dikembalikan?')"
                            class="flex-1 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-emerald-700 transition flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Selesaikan & Check-Out
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function bukaModalCheckout(id, no_res, nama, hp, kelas, ruangan, qtyBed, qtySelimut, metode, detail, total) {
            document.getElementById('co_no_res').innerText = '#' + no_res;
            document.getElementById('co_nama').innerText = nama;
            document.getElementById('co_kontak').innerText = hp;
            document.getElementById('co_kelas_kamar').innerText = ruangan + ' (' + kelas + ')';
            document.getElementById('co_metode').innerText = metode;
            document.getElementById('co_total').innerText = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(total);

            let detailSelect = document.getElementById('co_detail_pembayaran');
            let lowerDetail = detail.toLowerCase();
            if (detail === '-' || lowerDetail.includes('bayar') || lowerDetail.includes('cash') || lowerDetail.includes(
                    'tunai')) {
                detailSelect.value = 'Cash/Tunai';
            } else if (lowerDetail.includes('q-ris') || lowerDetail.includes('qris')) {
                detailSelect.value = 'Q-RIS';
            } else {
                detailSelect.value = 'Transfer Bank';
            }

            let addonContainer = document.getElementById('co_addon_container');
            addonContainer.innerHTML = '';
            if (qtyBed > 0) {
                addonContainer.innerHTML +=
                    `<span class="bg-white text-amber-700 text-[10px] font-bold px-2 py-1 rounded border border-amber-200 shadow-sm">+ ${qtyBed} Extra Bed</span>`;
            }
            if (qtySelimut > 0) {
                addonContainer.innerHTML +=
                    `<span class="bg-white text-amber-700 text-[10px] font-bold px-2 py-1 rounded border border-amber-200 shadow-sm">+ ${qtySelimut} Extra Selimut</span>`;
            }
            if (qtyBed == 0 && qtySelimut == 0) {
                addonContainer.innerHTML = `<span class="text-xs italic text-gray-400">Tidak ada layanan ekstra</span>`;
            }

            document.getElementById('formCheckoutModal').action = `/checkinout/${id}/checkout`;
            document.getElementById('modalCheckout').classList.remove('hidden');
        }
    </script>
</x-dblayout>

<x-dblayout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-amber-950 tracking-tight">Laporan Pendapatan</h1>
        <p class="text-sm text-amber-900/70 mt-1">Rekapan analitik dan histori transaksi keuangan hotel.</p>
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

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 rounded-2xl border border-amber-200 shadow-sm flex flex-col justify-center">
            <p class="text-xs font-bold text-amber-800/70 uppercase tracking-wider mb-2">Total Tamu
                ({{ $teksPeriode }})</p>
            <div class="flex items-center gap-3">
                <div class="p-3 bg-amber-100 text-amber-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-3xl font-black text-amber-950">{{ number_format($totalTamu, 0, ',', '.') }} <span
                        class="text-lg text-amber-700/50 font-bold">Kunjungan</span></h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-emerald-200 shadow-sm flex flex-col justify-center">
            <p class="text-xs font-bold text-emerald-800/70 uppercase tracking-wider mb-2">Persentase
                ({{ $teksPeriode }})</p>
            <div class="flex items-center gap-3">
                <div class="p-3 bg-emerald-100 text-emerald-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <h3 class="text-3xl font-black text-emerald-900">{{ $persentaseKunjungan }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-blue-200 shadow-sm flex flex-col justify-center">
            <p class="text-xs font-bold text-blue-800/70 uppercase tracking-wider mb-2">Total Pendapatan
                ({{ $teksPeriode }})</p>
            <div class="flex items-center gap-3">
                <div class="p-3 bg-blue-100 text-blue-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-3xl font-black text-blue-900">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white p-5 rounded-2xl border border-amber-200 shadow-sm mb-6 print:hidden">
        <form method="GET" action="{{ route('pendapatan') }}" id="formPendapatan">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 border-b border-amber-100 pb-4">
                <div class="md:col-span-1">
                    <select name="periode" id="filterPeriode"
                        class="w-full border border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 p-2.5 text-sm bg-amber-50 text-amber-950 font-bold transition">
                        <option value="mingguan" {{ $periode == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                        <option value="bulanan" {{ $periode == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                    </select>
                </div>
                <div class="md:col-span-3 flex flex-wrap gap-3 justify-start md:justify-end">
                    <a href="{{ route('pendapatan.export', array_merge(['format' => 'pdf'], request()->query())) }}"
                        class="flex items-center gap-2 px-5 py-2.5 bg-rose-600 text-white border border-rose-700 rounded-xl font-bold text-sm hover:bg-rose-700 transition shadow-sm">
                        Export PDF
                    </a>
                    <a href="{{ route('pendapatan.export', array_merge(['format' => 'csv'], request()->query())) }}"
                        class="flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white border border-emerald-700 rounded-xl font-bold text-sm hover:bg-emerald-700 transition shadow-sm">
                        Export CSV
                    </a>

                    <form id="formPrintLaporan" action="{{ route('pendapatan.export', array_merge(['format' => 'print'], request()->query())) }}" method="GET" target="_blank" class="inline">
                        <button type="button" onclick="openCustomConfirm('Cetak Laporan?', 'Apakah Anda ingin mencetak dokumen laporan pendapatan ini sekarang?', 'amber', 'Ya, Cetak', 'formPrintLaporan')"
                            class="flex items-center gap-2 px-6 py-2.5 bg-gray-800 text-white rounded-xl font-bold text-sm hover:bg-gray-900 transition shadow-md cursor-pointer">
                            Print Laporan
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div class="md:col-span-1">
                    <label class="block text-xs font-bold text-amber-800/70 uppercase tracking-wider mb-2">Search
                        Reservasi</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Nama / No. Reservasi..."
                        class="w-full border border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 p-2.5 text-sm text-amber-950 transition">
                </div>
                <div class="md:col-span-1">
                    <label class="block text-xs font-bold text-amber-800/70 uppercase tracking-wider mb-2">Filter
                        Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                        class="w-full border border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 p-2.5 text-sm text-amber-950 transition">
                </div>
                <div class="md:col-span-1">
                    <label class="block text-xs font-bold text-amber-800/70 uppercase tracking-wider mb-2">Filter
                        Tanggal Berakhir</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                        class="w-full border border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 p-2.5 text-sm text-amber-950 transition">
                </div>
                <div class="md:col-span-1 flex gap-2">
                    <button type="submit"
                        class="flex-1 bg-amber-600 text-white p-2.5 rounded-xl text-sm font-bold hover:bg-amber-700 transition shadow-sm">Terapkan</button>
                    <a href="{{ route('pendapatan') }}"
                        class="flex-1 bg-white text-amber-700 border border-amber-200 p-2.5 rounded-xl text-sm font-bold hover:bg-amber-50 text-center transition shadow-sm">Reset</a>
                </div>
            </div>

            <input type="hidden" name="per_page" value="{{ $perPage }}">
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-amber-200 shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead
                    class="bg-amber-50/50 border-b border-amber-200 text-amber-950 font-bold uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="px-5 py-4 whitespace-nowrap">Reservasi</th>
                        <th class="px-5 py-4 whitespace-nowrap">Data Tamu</th>
                        <th class="px-5 py-4 whitespace-nowrap">Tipe Kamar & Durasi</th>
                        <th class="px-5 py-4 whitespace-nowrap text-right">Biaya Kamar</th>
                        <th class="px-5 py-4 whitespace-nowrap text-right">Biaya Ekstra</th>
                        <th class="px-5 py-4 whitespace-nowrap text-right">Total Biaya</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-50 text-gray-800">
                    @forelse($reservasis as $res)
                        @php
                            $in = \Carbon\Carbon::parse($res->check_in)->startOfDay();
                            $out = \Carbon\Carbon::parse($res->check_out)->startOfDay();
                            $diffDays = max(1, (int) $in->diffInDays($out));

                            // Hitungan Uang
                            $hargaKamar = $res->kamar->kelasKamar->harga ?? 0;
                            $kamarTotal = $hargaKamar * $diffDays;

                            $ekstra = is_array($res->ekstra) ? $res->ekstra : json_decode($res->ekstra, true) ?? [];
                            $ekstraTotal = ($ekstra['Extra Bed'] ?? 0) * 50000;

                            $totalBaris = $kamarTotal + $ekstraTotal;

                            // Tarik database pembayaran
                            $pembayaranUtama = \App\Models\Pembayaran::where('reservasi_id', $res->id)
                                ->where('invoice', 'not like', 'ADD-%')
                                ->first();

                            $pembayaranTambahan = \App\Models\Pembayaran::where('reservasi_id', $res->id)
                                ->where('invoice', 'like', 'ADD-%')
                                ->latest()
                                ->first();

                            // Metode Kamar
                            if ($pembayaranUtama) {
                                $metodeKamar = 'QRIS: ' . $pembayaranUtama->invoice;
                            } else {
                                $metodeKamar = 'TUNAI / CASH';
                            }

                            // Metode Ekstra
                            $metodeEkstra = '-';
                            if ($ekstraTotal > 0) {
                                if ($pembayaranTambahan) {
                                    $metodeEkstra = 'QRIS: ' . $pembayaranTambahan->invoice;
                                } else {
                                    $metodeEkstra = 'TUNAI / CASH';
                                }
                            }

                            $tglSelesai = \Carbon\Carbon::parse($res->updated_at);
                        @endphp
                        <tr class="hover:bg-amber-50/30 transition">
                            <td class="px-5 py-4">
                                <div class="font-bold text-amber-600">#{{ $res->no_reservasi }}</div>
                                <div class="text-xs font-semibold text-gray-500 mt-0.5">
                                    {{ $tglSelesai->translatedFormat('d M Y') }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-bold text-gray-900">{{ $res->nama_tamu }}</div>
                                <div class="text-[11px] font-medium text-gray-500 mt-0.5">NIK:
                                    {{ $res->no_ktp ?? '-' }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-bold text-gray-800 text-xs">
                                    {{ $res->kamar->kelasKamar->nama_kelas ?? 'Kamar Dihapus' }}</div>
                                <div class="text-[11px] text-gray-500 mt-0.5">{{ $diffDays }} Malam</div>
                            </td>
                            <td class="px-5 py-4 text-right align-top">
                                <div class="font-bold text-gray-800 text-sm">Rp
                                    {{ number_format($kamarTotal, 0, ',', '.') }}</div>
                                <div class="text-[9px] font-bold text-emerald-600 uppercase tracking-wider mt-1">
                                    {{ $metodeKamar }}</div>
                            </td>
                            <td class="px-5 py-4 text-right align-top">
                                @if ($ekstraTotal > 0)
                                    <div class="font-bold text-gray-800 text-sm">Rp
                                        {{ number_format($ekstraTotal, 0, ',', '.') }}</div>
                                    <div class="text-[9px] font-bold text-amber-600 uppercase tracking-wider mt-1">
                                        {{ $metodeEkstra }}</div>
                                @else
                                    <div class="font-bold text-gray-300">-</div>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right align-top bg-amber-50/30">
                                <div class="font-black text-blue-700 text-base">Rp
                                    {{ number_format($totalBaris, 0, ',', '.') }}</div>
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
                                    <p class="font-medium text-amber-950">Tidak ada riwayat pendapatan pada periode
                                        ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($reservasis->total() > 0)
        <div
            class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white p-4 rounded-2xl border border-amber-200 shadow-sm print:hidden">
            <div class="flex items-center gap-2">
                <form method="GET" action="{{ route('pendapatan') }}" id="formPerPage">
                    @if (request('periode'))
                        <input type="hidden" name="periode" value="{{ request('periode') }}">
                    @endif
                    @if (request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    @if (request('start_date'))
                        <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                    @endif
                    @if (request('end_date'))
                        <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                    @endif

                    <select name="per_page" id="filterPerPage"
                        class="border border-amber-200 rounded-lg text-sm bg-amber-50 focus:ring-amber-500 focus:border-amber-500 font-bold text-amber-800 py-2 px-3 shadow-sm">
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

    <script src="{{ asset('js/dashboard/pendapatan.js') }}?v={{ time() }}"></script>
</x-dblayout>
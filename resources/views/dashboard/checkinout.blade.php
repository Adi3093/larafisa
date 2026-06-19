<x-dblayout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Check-in/Check-Out</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola proses serah terima kunci untuk tamu yang akan Check-In dan
            Check-Out hari ini.</p>
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

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6">
        <div class="p-5 lg:p-6 border-b border-gray-100 bg-white flex justify-between items-center">
            <h3 class="font-bold text-gray-800 text-lg flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                    </path>
                </svg>
                Antrean Tamu Aktif
            </h3>

            <span
                class="bg-indigo-50 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full border border-indigo-100">
                Total: {{ $reservasis->total() }} Antrean
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50/50 border-b border-gray-100 text-gray-500 font-medium">
                    <tr>
                        <th class="px-6 py-4 whitespace-nowrap">No. Reservasi</th>
                        <th class="px-6 py-4 whitespace-nowrap">Tamu & Kontak</th>
                        <th class="px-6 py-4 whitespace-nowrap">Kamar Terpesan</th>
                        <th class="px-6 py-4 whitespace-nowrap">Jadwal In - Out</th>
                        <th class="px-6 py-4 whitespace-nowrap">Status Saat Ini</th>
                        <th class="px-6 py-4 whitespace-nowrap text-right">Tindakan Cepat</th>
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
                                <div class="font-bold text-gray-900 text-base">
                                    {{ $res->kamar?->nomor_ruangan ? 'Kamar ' . $res->kamar->nomor_ruangan : 'Belum Set Kamar' }}
                                </div>
                                <div class="text-xs text-gray-500 mt-0.5">
                                    {{ $res->kamar?->kelasKamar?->nama_kelas ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-xs">
                                <div class="font-bold text-gray-900">
                                    <span class="text-emerald-600 font-extrabold">In:</span>
                                    {{ \Carbon\Carbon::parse($res->check_in)->translatedFormat('d M Y - H:i') }} WIB
                                </div>
                                <div class="font-bold text-gray-900 mt-1.5">
                                    <span class="text-rose-600 font-extrabold">Out:</span>
                                    {{ \Carbon\Carbon::parse($res->check_out)->translatedFormat('d M Y - H:i') }} WIB
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($res->status_reservasi === 'Terkonfirmasi')
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-700 border border-blue-200 uppercase tracking-wider">
                                        <span class="h-2 w-2 rounded-full bg-blue-500"></span> Siap Masuk
                                    </span>
                                @elseif($res->status_reservasi === 'Check-In')
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700 border border-emerald-200 uppercase tracking-wider">
                                        <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span> Menginap
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if ($res->status_reservasi === 'Terkonfirmasi')
                                    <form method="POST" action="{{ route('checkinout.checkin', $res->id) }}"
                                        class="m-0 inline-block">
                                        @csrf
                                        <button type="submit"
                                            onclick="return confirm('Serahkan kunci dan proses Check-In tamu ini?')"
                                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-sm flex items-center gap-1.5 w-full sm:w-auto justify-center">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                                </path>
                                            </svg>
                                            Proses Check-In
                                        </button>
                                    </form>
                                @elseif($res->status_reservasi === 'Check-In')
                                    @php
                                        // Kalkulasi Biaya JSON untuk dilempar ke Javascript Modal
                                        $checkInDate = \Carbon\Carbon::parse($res->check_in);
                                        $checkOutDate = \Carbon\Carbon::parse($res->check_out);
                                        $diffDays = $checkInDate->diffInDays($checkOutDate);
                                        if ($diffDays == 0) {
                                            $diffDays = 1;
                                        }

                                        $hargaKamar = $res->kamar->kelasKamar->harga ?? 0;
                                        $totalKamar = $hargaKamar * $diffDays;

                                        $ekstra = is_array($res->ekstra)
                                            ? $res->ekstra
                                            : json_decode($res->ekstra, true);
                                        $qtyBed = $ekstra['Extra Bed'] ?? 0;
                                        $qtySelimut = $ekstra['Extra Selimut'] ?? 0;
                                        $metode = $ekstra['Metode Pembayaran'] ?? 'Bayar di tempat';
                                        $detail = $ekstra['Detail Pembayaran'] ?? '-';

                                        $totalBed = $qtyBed * 100000;
                                        $totalSelimut = $qtySelimut * 25000;
                                        $totalBiaya = $totalKamar + $totalBed + $totalSelimut;

                                        $kamarName = 'Kamar ' . ($res->kamar->nomor_ruangan ?? '-');
                                        $kelasName = $res->kamar->kelasKamar->nama_kelas ?? '-';
                                    @endphp

                                    <button type="button"
                                        onclick="bukaModalCheckout('{{ $res->id }}', '{{ $res->no_reservasi }}', '{{ $res->nama_tamu }}', '{{ $res->no_hp }}', '{{ $kelasName }}', '{{ $kamarName }}', {{ $qtyBed }}, {{ $qtySelimut }}, '{{ $metode }}', '{{ $detail }}', {{ $totalBiaya }})"
                                        class="bg-rose-50 text-rose-600 hover:bg-rose-100 border border-rose-200 px-4 py-2 rounded-xl text-xs font-bold transition shadow-sm flex items-center gap-1.5 w-full sm:w-auto justify-center">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        Buka (Check-Out)
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <div class="bg-gray-50 p-4 rounded-full mb-4">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4">
                                            </path>
                                        </svg>
                                    </div>
                                    <p class="font-bold text-gray-900 text-lg">Meja Resepsionis Kosong</p>
                                    <p class="text-sm mt-1 max-w-sm">Saat ini tidak ada tamu yang mengantre untuk
                                        Check-In maupun yang sedang dalam masa menginap.</p>
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

    <div id="modalCheckout" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/60 backdrop-blur-sm"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                <div class="bg-rose-600 px-6 py-4 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white">Tinjau Pembayaran & Check-Out</h3>
                    <button onclick="document.getElementById('modalCheckout').classList.add('hidden')"
                        class="text-rose-200 hover:text-white transition">
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
                                <h4 class="text-lg font-black text-gray-900 leading-none" id="co_nama"></h4>
                                <p class="text-sm text-gray-500 mt-1" id="co_kontak"></p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">ID Reservasi
                                </p>
                                <h4 class="text-sm font-bold text-indigo-600" id="co_no_res"></h4>
                            </div>
                        </div>

                        <div class="mb-5">
                            <h4 class="text-base font-bold text-gray-900 mb-2" id="co_kelas_kamar"></h4>

                            <div id="co_addon_container" class="flex flex-wrap gap-2 mt-2">
                            </div>
                        </div>

                        <div class="bg-rose-50 p-4 rounded-xl border border-rose-100 mb-4">
                            <div class="flex justify-between items-center border-b border-rose-200 pb-3 mb-3">
                                <p class="text-xs font-bold text-rose-800 uppercase tracking-wider">Total Tagihan Final
                                </p>
                                <h2 class="text-2xl font-black text-rose-700" id="co_total">Rp 0</h2>
                            </div>

                            <div class="grid grid-cols-2 gap-4 items-center">
                                <div>
                                    <p class="text-[10px] font-bold text-rose-800 uppercase tracking-wider mb-1">Status
                                        Metode</p>
                                    <p class="text-sm font-bold text-gray-900" id="co_metode"></p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-rose-800 uppercase tracking-wider mb-1">Ubah
                                        Pembayaran Kasir</p>
                                    <select name="detail_pembayaran" id="co_detail_pembayaran"
                                        class="w-full border border-rose-200 rounded-lg p-2 text-sm bg-white font-bold text-gray-900 shadow-sm focus:ring-rose-500 focus:border-rose-500">
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
                                class="w-5 h-5 text-rose-600 rounded border-gray-300 focus:ring-rose-500 cursor-pointer">
                            <div>
                                <p class="text-sm font-bold text-gray-800 leading-none">Cetak Struk Pembayaran
                                    (Thermal)</p>
                                <p class="text-[11px] text-gray-500 mt-1">Struk akan otomatis dicetak menggunakan
                                    pengaturan printer bawaan kasir.</p>
                            </div>
                        </div>

                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex gap-3 border-t border-gray-100 mt-4">
                        <button type="submit"
                            onclick="return confirm('Apakah pembayaran sudah lunas dan kunci sudah dikembalikan?')"
                            class="flex-1 rounded-xl bg-rose-600 px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-rose-700 transition flex items-center justify-center gap-2">
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

            // Format Rupiah
            document.getElementById('co_total').innerText = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(total);

            // Set Dropdown Pembayaran Kasir Default
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

            // Atur Label Layanan Tambahan Ekstra
            let addonContainer = document.getElementById('co_addon_container');
            addonContainer.innerHTML = ''; // bersihkan

            if (qtyBed > 0) {
                addonContainer.innerHTML +=
                    `<span class="bg-gray-100 text-gray-700 text-[10px] font-bold px-2 py-1 rounded border border-gray-200">+ ${qtyBed} Extra Bed</span>`;
            }
            if (qtySelimut > 0) {
                addonContainer.innerHTML +=
                    `<span class="bg-gray-100 text-gray-700 text-[10px] font-bold px-2 py-1 rounded border border-gray-200">+ ${qtySelimut} Extra Selimut</span>`;
            }
            if (qtyBed == 0 && qtySelimut == 0) {
                addonContainer.innerHTML = `<span class="text-xs italic text-gray-400">Tidak ada layanan ekstra</span>`;
            }

            // Set Form Action
            document.getElementById('formCheckoutModal').action = `/checkinout/${id}/checkout`;

            // Tampilkan Modal
            document.getElementById('modalCheckout').classList.remove('hidden');
        }
    </script>
</x-dblayout>

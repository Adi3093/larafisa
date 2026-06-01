<x-dblayout>
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-900">Laporan Riwayat Reservasi</h1>
        </div>

        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm mb-6">
            <form method="GET" action="{{ route('riwayat') }}"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">

                <div class="lg:col-span-2">
                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Cari Tamu / NIK / Tiket</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Ketik kata kunci..."
                        class="w-full border-gray-300 rounded-lg shadow-sm text-sm p-2 border focus:ring-indigo-500">
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

                <div class="lg:col-span-5 flex flex-wrap justify-between items-center border-t pt-4 mt-2 gap-4">
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <span>Baris:</span>
                        <select name="per_page" onchange="this.form.submit()"
                            class="border border-gray-300 rounded p-1 text-xs bg-white">
                            @foreach ([5, 10, 15, 20] as $size)
                                <option value="{{ $size }}"
                                    {{ request('per_page') == $size ? 'selected' : '' }}>{{ $size }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        @if (request()->hasAny(['search', 'filter_nomor', 'filter_checkin', 'filter_checkout']))
                            <a href="{{ route('riwayat') }}"
                                class="rounded-lg bg-gray-100 text-gray-600 px-4 py-2 text-sm font-medium hover:bg-gray-200 transition">Reset</a>
                        @endif

                        <button type="submit"
                            class="rounded-lg bg-indigo-600 text-white px-5 py-2 text-sm font-bold hover:bg-indigo-700 transition shadow-sm">Terapkan
                            Filter</button>

                        <button type="submit" formaction="{{ route('riwayat.csv') }}"
                            class="rounded-lg bg-emerald-600 text-white px-4 py-2 text-sm font-bold hover:bg-emerald-700 transition flex items-center gap-1 shadow-sm">
                            Unduh CSV
                        </button>

                        <button type="submit" formaction="{{ route('riwayat.pdf') }}"
                            class="rounded-lg bg-red-600 text-white px-4 py-2 text-sm font-bold hover:bg-red-700 transition flex items-center gap-1 shadow-sm">
                            Cetak PDF
                        </button>
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
                            <th class="px-4 py-3 font-medium text-gray-900">Data Tamu</th>
                            <th class="px-4 py-3 font-medium text-gray-900">Detail Kamar</th>
                            <th class="px-4 py-3 font-medium text-gray-900">Tgl. Masuk / Keluar</th>
                            <th class="px-4 py-3 font-medium text-gray-900">Status Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($riwayats as $log)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-mono font-bold text-gray-500">{{ $log->no_reservasi }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-bold text-gray-900">{{ $log->nama_tamu }}</div>
                                    <div class="text-xs text-gray-500">NIK: {{ $log->no_ktp }}</div>
                                    <div class="text-xs text-gray-500">WA: {{ $log->no_hp }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-black text-gray-700">Kamar #{{ $log->kamar->nomor_ruangan }}</div>
                                    <div class="text-xs text-gray-500">{{ $log->kamar->kelasKamar->nama_kelas }}</div>
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    <div class="text-xs"><span class="font-bold text-gray-800">In:</span>
                                        {{ \Carbon\Carbon::parse($log->check_in)->format('d M Y') }}</div>
                                    <div class="text-xs"><span class="font-bold text-gray-800">Out:</span>
                                        {{ \Carbon\Carbon::parse($log->check_out)->format('d M Y') }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($log->status_reservasi == 'Selesai')
                                        <span
                                            class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-bold text-green-700 ring-1 ring-inset ring-green-600/20">Selesai
                                            (Check-Out)
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-bold text-red-700 ring-1 ring-inset ring-red-600/10">Dibatalkan</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-12 text-center text-gray-500">Belum ada riwayat
                                    reservasi yang tersimpan sesuai filter tersebut.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">{{ $riwayats->links() }}</div>
    </div>
</x-dblayout>

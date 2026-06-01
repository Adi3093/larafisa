<x-dblayout>
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-900">Jadwal Reservasi (Online)</h1>
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

        <div class="bg-indigo-900 p-5 rounded-xl shadow-lg mb-6 text-white">
            <h2 class="font-bold text-lg mb-3 flex items-center gap-2">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
                Penerimaan Tamu Online
            </h2>
            <form method="GET" action="{{ route('ongoing') }}"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">
                <div class="lg:col-span-2 relative">
                    <input type="text" name="search" value="{{ request('search') }}" autofocus
                        placeholder="Scan Barcode / Ketik No Reservasi..."
                        class="w-full text-gray-900 rounded-lg shadow-sm text-sm p-3 border-2 border-indigo-300 focus:ring-indigo-500 font-mono font-bold">
                </div>

                <div>
                    <select name="filter_kelas"
                        class="w-full text-gray-900 rounded-lg shadow-sm text-sm p-3 border bg-white">
                        <option value="">Semua Kelas</option>
                        @foreach ($semuaKelas as $kelas)
                            <option value="{{ $kelas->id }}"
                                {{ request('filter_kelas') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <input type="text" name="filter_nomor" value="{{ request('filter_nomor') }}"
                        placeholder="No Ruang..." class="w-full text-gray-900 rounded-lg shadow-sm text-sm p-3 border">
                </div>
                <div>
                    <input type="date" name="filter_checkin" value="{{ request('filter_checkin') }}"
                        class="w-full text-gray-900 rounded-lg shadow-sm text-sm p-3 border" title="Tanggal Check-In">
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                        class="w-full bg-emerald-500 text-white px-4 py-3 rounded-lg text-sm font-bold hover:bg-emerald-600 transition shadow-sm">Cari
                        / Scan</button>
                    @if (request()->hasAny(['search', 'filter_kelas', 'filter_nomor', 'filter_checkin']))
                        <a href="{{ route('ongoing') }}"
                            class="flex items-center justify-center bg-gray-600 text-white px-4 py-3 rounded-lg text-sm font-bold hover:bg-gray-500 transition">Reset</a>
                    @endif
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
                            <th class="px-4 py-3 font-medium text-gray-900">Alokasi Kamar</th>
                            <th class="px-4 py-3 font-medium text-gray-900">Jadwal Menginap</th>
                            <th class="px-4 py-3 font-medium text-gray-900 text-center">Aksi Resepsionis</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($ongoing as $res)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3">
                                    <div class="font-mono font-bold text-lg text-indigo-600">{{ $res->no_reservasi }}
                                    </div>
                                    <span
                                        class="inline-block mt-1 px-2 py-0.5 bg-yellow-100 text-yellow-800 text-xs font-bold rounded">Menunggu
                                        Kedatangan</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-bold text-gray-900">{{ $res->nama_tamu }}</div>
                                    <div class="text-gray-500 text-xs">NIK: {{ $res->no_ktp }}</div>
                                    <div class="text-gray-500 text-xs">WA: {{ $res->no_hp }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-black text-gray-700 text-base">Kamar
                                        #{{ $res->kamar->nomor_ruangan }}</div>
                                    <div class="text-gray-500 text-xs font-medium mb-1">
                                        {{ $res->kamar->kelasKamar->nama_kelas }}</div>
                                    @if ($res->ekstra && count($res->ekstra) > 0)
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @foreach ($res->ekstra as $eks)
                                                <span
                                                    class="inline-flex items-center rounded bg-gray-100 px-1.5 py-0.5 text-[10px] font-medium text-gray-600 border border-gray-200">+
                                                    {{ $eks }}</span>
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
                                <td class="px-4 py-3 text-center space-y-2">
                                    <form action="{{ route('ongoing.konfirmasi', $res->id) }}" method="POST"
                                        onsubmit="return confirm('Tamu sudah berada di resepsionis dan siap Check-In?');">
                                        @csrf
                                        <button type="submit"
                                            class="w-full rounded-lg bg-indigo-600 px-3 py-2 text-xs font-bold text-white hover:bg-indigo-700 shadow-sm flex justify-center items-center gap-1">
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Konfirmasi Kedatangan
                                        </button>
                                    </form>

                                    <form action="{{ route('ongoing.batal', $res->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin membatalkan pesanan online ini?');">
                                        @csrf
                                        <button type="submit"
                                            class="w-full rounded-lg bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100 border border-red-100">Batalkan
                                            Pesanan</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-16 text-center text-gray-500 font-medium">Belum ada
                                    reservasi online yang masuk saat ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">{{ $ongoing->appends(request()->query())->links() }}</div>
    </div>
</x-dblayout>

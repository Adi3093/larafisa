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
                                    <form method="POST" action="{{ route('checkinout.checkout', $res->id) }}"
                                        class="m-0 inline-block">
                                        @csrf
                                        <button type="submit"
                                            onclick="return confirm('Selesaikan masa inap dan proses Check-Out tamu ini?')"
                                            class="bg-rose-500 hover:bg-rose-600 text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-sm flex items-center gap-1.5 w-full sm:w-auto justify-center">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                                </path>
                                            </svg>
                                            Proses Check-Out
                                        </button>
                                    </form>
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
</x-dblayout>

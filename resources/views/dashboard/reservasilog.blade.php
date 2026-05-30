<x-dblayout>
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-900">Log Riwayat Reservasi</h1>
        </div>

        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm mb-6">
            <form method="GET" action="{{ route('riwayat') }}" class="flex flex-col sm:flex-row gap-3 items-center">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama atau no. tiket..."
                    class="border-gray-300 rounded-lg shadow-sm text-sm p-2.5 border w-full sm:w-64">
                <button type="submit"
                    class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-indigo-700 w-full sm:w-auto">Cari
                    Riwayat</button>
                @if (request('search'))
                    <a href="{{ route('riwayat') }}" class="text-red-600 text-sm font-bold hover:underline">Reset</a>
                @endif
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
                                    <div class="text-xs text-gray-500">KTP: {{ $log->no_ktp }}</div>
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
                                            (Check-Out)</span>
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-bold text-red-700 ring-1 ring-inset ring-red-600/10">Dibatalkan</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-12 text-center text-gray-500">Belum ada riwayat
                                    reservasi yang tersimpan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">{{ $riwayats->links() }}</div>
    </div>
</x-dblayout>

<x-lplayout>
    <div class="absolute top-0 left-0 w-full h-64 bg-amber-600 z-0"></div>

    <div class="relative z-10 min-h-screen pt-24 lg:pt-32 pb-24 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">

        <!-- Header Title -->
        <div class="mb-8">
            <h1 class="text-white text-3xl font-extrabold tracking-tight">Riwayat & Status Perjalanan</h1>
            <p class="text-amber-100 mt-1">Pantau perkembangan reservasi kamar Anda secara real-time.</p>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div
                class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm font-bold">
                ✅ {{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm font-bold">⚠️
                {{ session('error') }}</div>
        @endif

        <!-- Logika Progress Bar -->
        @php
            $currentStep = 1;
            if ($isLoggedIn && $pesananAktif) {
                $status = $pesananAktif->status_reservasi;
                $metadataekstra = $pesananAktif->ekstra ?? [];
                $metodeBayar = $metadataekstra['Metode Pembayaran'] ?? 'Bayar di tempat';
                if ($status === 'Menunggu Konfirmasi') {
                    $currentStep = $metodeBayar === 'Transfer' ? 3 : 2;
                } elseif ($status === 'Terkonfirmasi') {
                    $currentStep = 3;
                } elseif ($status === 'Check-In') {
                    $currentStep = 4;
                } elseif ($status === 'Selesai') {
                    $currentStep = 5;
                }
            }
        @endphp

        <!-- Tampilan Progress Bar -->
        <div class="bg-white rounded-3xl shadow-xl border border-amber-100 p-6 sm:px-10 pt-12 mb-8 overflow-hidden">
            <h2 class="sr-only">Steps</h2>
            <div class="relative flex items-center justify-between w-full">
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1.5 bg-gray-100 rounded-lg z-0"></div>
                <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1.5 bg-amber-500 rounded-lg z-0 transition-all duration-700 ease-in-out"
                    style="width: {{ (($currentStep - 1) / 4) * 100 }}%"></div>

                <!-- Step 1 -->
                <div class="relative z-10 flex justify-center items-center">
                    <span
                        class="absolute -top-8 sm:-start-2 text-[10px] sm:text-xs font-bold {{ $currentStep >= 1 ? 'text-amber-600' : 'text-gray-400' }} whitespace-nowrap">Reservasi</span>
                    <div
                        class="size-7 sm:size-8 rounded-full flex items-center justify-center font-bold text-xs sm:text-sm ring-4 ring-white {{ $currentStep >= 1 ? 'bg-amber-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                        @if ($currentStep > 1)
                            <svg class="size-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        @else
                            1
                        @endif
                    </div>
                </div>
                <!-- Step 2 -->
                <div class="relative z-10 flex justify-center items-center">
                    <span
                        class="absolute -top-8 left-1/2 -translate-x-1/2 text-[10px] sm:text-xs font-bold {{ $currentStep >= 2 ? 'text-amber-600' : 'text-gray-400' }} whitespace-nowrap">Pembayaran</span>
                    <div
                        class="size-7 sm:size-8 rounded-full flex items-center justify-center font-bold text-xs sm:text-sm ring-4 ring-white {{ $currentStep >= 2 ? 'bg-amber-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                        @if ($currentStep > 2)
                            <svg class="size-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        @else
                            2
                        @endif
                    </div>
                </div>
                <!-- Step 3 -->
                <div class="relative z-10 flex justify-center items-center">
                    <span
                        class="absolute -top-8 left-1/2 -translate-x-1/2 text-[10px] sm:text-xs font-bold {{ $currentStep >= 3 ? 'text-amber-600' : 'text-gray-400' }} whitespace-nowrap">Konfirmasi</span>
                    <div
                        class="size-7 sm:size-8 rounded-full flex items-center justify-center font-bold text-xs sm:text-sm ring-4 ring-white {{ $currentStep >= 3 ? 'bg-amber-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                        @if ($currentStep > 3)
                            <svg class="size-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        @else
                            3
                        @endif
                    </div>
                </div>
                <!-- Step 4 -->
                <div class="relative z-10 flex justify-center items-center">
                    <span
                        class="absolute -top-8 left-1/2 -translate-x-1/2 text-[10px] sm:text-xs font-bold {{ $currentStep >= 4 ? 'text-amber-600' : 'text-gray-400' }} whitespace-nowrap">Check-In</span>
                    <div
                        class="size-7 sm:size-8 rounded-full flex items-center justify-center font-bold text-xs sm:text-sm ring-4 ring-white {{ $currentStep >= 4 ? 'bg-amber-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                        @if ($currentStep > 4)
                            <svg class="size-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        @else
                            4
                        @endif
                    </div>
                </div>
                <!-- Step 5 -->
                <div class="relative z-10 flex justify-center items-center">
                    <span
                        class="absolute -top-8 right-0 sm:auto sm:-end-2 text-[10px] sm:text-xs font-bold {{ $currentStep >= 5 ? 'text-amber-600' : 'text-gray-400' }} whitespace-nowrap">Check-Out</span>
                    <div
                        class="size-7 sm:size-8 rounded-full flex items-center justify-center font-bold text-xs sm:text-sm ring-4 ring-white {{ $currentStep >= 5 ? 'bg-amber-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                        @if ($currentStep > 5)
                            <svg class="size-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        @else
                            5
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Pesanan Aktif -->
        <h2 class="font-bold text-amber-950 text-xl mb-4 px-1">Pesanan Aktif Saat Ini</h2>
        <div class="bg-white rounded-3xl shadow-md border border-amber-100 p-6 sm:p-8 mb-10">
            @if (!$isLoggedIn)
                <div class="text-center py-6">
                    <span class="text-5xl block mb-4">🔒</span>
                    <h3 class="text-lg font-extrabold text-amber-950">Akses Riwayat Terkunci</h3>
                    <div class="mt-6 flex justify-center gap-3">
                        <a href="{{ route('login') }}"
                            class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition">Log
                            In</a>
                        <a href="{{ route('register') }}"
                            class="bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold py-2.5 px-6 rounded-xl text-sm border border-amber-200 transition">Daftar
                            Akun</a>
                    </div>
                </div>
            @elseif (!$pesananAktif)
                <div class="text-center py-8">
                    <span class="text-5xl block mb-4">📭</span>
                    <h3 class="text-lg font-extrabold text-amber-950">Tidak Ada Pesanan yang Berjalan</h3>
                    <div class="mt-6">
                        <a href="{{ route('reservasi.tamu') }}"
                            class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-8 rounded-xl text-sm transition shadow-md shadow-amber-600/20">Mulai
                            Booking Kamar</a>
                    </div>
                </div>
            @else
                <div class="flex flex-col md:flex-row gap-6 items-start">
                    <img src="{{ asset('storage/' . $pesananAktif->kamar?->kelasKamar?->thumbnail) }}"
                        class="w-full md:w-56 h-36 object-cover rounded-2xl border border-gray-100 shadow-sm bg-gray-50">
                    <div class="flex-1 w-full">
                        <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                            <h3 class="text-xl font-black text-gray-900">#{{ $pesananAktif->no_reservasi }}</h3>
                            <span
                                class="inline-block bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-lg border border-amber-200 uppercase tracking-wide">
                                {{ $pesananAktif->status_reservasi }}
                            </span>
                        </div>
                        <h4 class="text-lg font-bold text-amber-900">
                            {{ $pesananAktif->kamar?->kelasKamar?->nama_kelas ?? 'Tipe Kamar' }}</h4>
                        <p class="text-xs font-bold text-gray-500 mt-1">Nama Tamu: <span
                                class="text-gray-900 font-medium">{{ $pesananAktif->nama_tamu }}</span></p>

                        <div
                            class="grid grid-cols-2 gap-2 mt-4 max-w-md bg-amber-50/50 p-3 rounded-xl border border-amber-100">
                            <div>
                                <span class="block text-[10px] uppercase font-bold text-gray-400">Jadwal
                                    Check-In:</span>
                                <span
                                    class="text-xs font-bold text-gray-800">{{ \Carbon\Carbon::parse($pesananAktif->check_in)->translatedFormat('d M Y - H:i') }}
                                    WIB</span>
                            </div>
                            <div>
                                <span class="block text-[10px] uppercase font-bold text-gray-400">Jadwal
                                    Check-Out:</span>
                                <span
                                    class="text-xs font-bold text-gray-800">{{ \Carbon\Carbon::parse($pesananAktif->check_out)->translatedFormat('d M Y - H:i') }}
                                    WIB</span>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-wrap gap-2 border-t border-gray-100 pt-4">
                            <button onclick="document.getElementById('modalDetail').classList.remove('hidden')"
                                class="bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold py-2.5 px-4 rounded-xl shadow transition flex items-center gap-2">
                                <span>🔍</span> Detail & Pembayaran
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Arsip Riwayat -->
        <h2 class="font-bold text-amber-950 text-xl mb-4 px-1">Arsip Riwayat Reservasi</h2>
        <div class="bg-white rounded-3xl shadow-sm border border-amber-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead
                        class="bg-gray-50 text-gray-500 font-bold uppercase text-[11px] tracking-wider border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4">Kode Tiket</th>
                            <th class="px-6 py-4">Tipe Kamar</th>
                            <th class="px-6 py-4">Waktu Menginap</th>
                            <th class="px-6 py-4 text-center">Status Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @forelse($arsipReservasi as $history)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4 font-bold text-indigo-600">#{{ $history->no_reservasi }}</td>
                                <td class="px-6 py-4 font-bold text-gray-900">
                                    {{ $history->kamar?->kelasKamar?->nama_kelas ?? 'Kamar' }}</td>
                                <td class="px-6 py-4 text-xs font-medium">
                                    <div>In:
                                        {{ \Carbon\Carbon::parse($history->check_in)->translatedFormat('d M Y - H:i') }}
                                    </div>
                                    <div class="text-gray-400 mt-0.5">Out:
                                        {{ \Carbon\Carbon::parse($history->check_out)->translatedFormat('d M Y - H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php $color = $history->status_reservasi === 'Selesai' ? 'bg-gray-100 text-gray-700 border-gray-200' : 'bg-red-50 text-red-700 border-red-100'; @endphp
                                    <span
                                        class="inline-block px-2.5 py-1 text-[10px] font-bold rounded-lg {{ $color }} border uppercase tracking-wider">{{ $history->status_reservasi }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-400 font-medium italic">
                                    Tidak ada catatan arsip riwayat masa lalu.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Detail Pembayaran -->
    @if ($isLoggedIn && $pesananAktif)
        <div id="modalDetail" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/60 backdrop-blur-sm"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                        <h3 class="text-xl font-bold text-gray-900">Detail dan Reservasi Tamu</h3>
                        <button onclick="handleCloseModal()" class="text-gray-400 hover:text-red-500 transition">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="flex flex-col md:flex-row p-6 gap-8 bg-white">
                        <div class="w-full md:w-1/2 space-y-5">
                            <div>
                                <div class="flex justify-between items-end border-b border-gray-300 pb-2 mb-3">
                                    <h4 class="text-lg font-bold text-gray-800">Informasi Tamu</h4>
                                    <span class="text-xs font-bold text-gray-500">Code Reservasi: <span
                                            class="text-amber-600">#{{ $pesananAktif->no_reservasi }}</span></span>
                                </div>
                                <div class="space-y-1 text-sm text-gray-700 font-medium">
                                    <p>Nama : {{ $pesananAktif->nama_tamu }}</p>
                                    <p>No.HP : {{ $pesananAktif->no_hp }}</p>
                                    <p>Jumlah Tamu : {{ $pesananAktif->ekstra['Jumlah Anggota'] ?? 1 }} Orang</p>
                                </div>
                            </div>
                            <div>
                                <div class="border-b border-gray-300 pb-2 mb-3">
                                    <h4 class="text-lg font-bold text-gray-800">Informasi Pesanan</h4>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mb-3">
                                    <div>
                                        <span class="text-xs font-bold text-gray-500 mb-1 block">Check-In</span>
                                        <div
                                            class="border border-gray-300 rounded-lg p-2.5 text-center text-sm font-bold text-gray-800">
                                            {{ \Carbon\Carbon::parse($pesananAktif->check_in)->translatedFormat('d M Y') }}
                                        </div>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-gray-500 mb-1 block">Check-Out</span>
                                        <div
                                            class="border border-gray-300 rounded-lg p-2.5 text-center text-sm font-bold text-gray-800">
                                            {{ \Carbon\Carbon::parse($pesananAktif->check_out)->translatedFormat('d M Y') }}
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm font-medium text-gray-700">Kelas Kamar : <span
                                        class="font-bold">{{ $pesananAktif->kamar?->kelasKamar?->nama_kelas ?? '-' }}</span>
                                </p>
                            </div>
                            <div>
                                <div class="border-b border-gray-300 pb-2 mb-3">
                                    <h4 class="text-lg font-bold text-gray-800">Layanan Extra</h4>
                                </div>
                                <div class="space-y-1 text-sm text-gray-700 font-medium">
                                    <p>Extra Bed x{{ $pesananAktif->ekstra['Extra Bed'] ?? 0 }}</p>
                                    <p>Extra Selimut x{{ $pesananAktif->ekstra['Extra Selimut'] ?? 0 }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Area Pembayaran Sisi Kanan -->
                        <div class="w-full md:w-1/2 md:border-l md:border-gray-300 md:pl-8 flex flex-col h-full">
                            <div class="border-b border-gray-300 pb-2 mb-4">
                                <h4 class="text-xl font-bold text-gray-800">Detail Pembayaran</h4>
                            </div>

                            <div class="space-y-2 text-sm text-gray-700 font-medium mb-6">
                                <div class="flex justify-between"><span>Kelas
                                        Kamar</span><span>{{ $pesananAktif->kamar?->kelasKamar?->nama_kelas ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between"><span>Tanggal
                                        Check-in</span><span>{{ \Carbon\Carbon::parse($pesananAktif->check_in)->translatedFormat('d M Y') }}</span>
                                </div>
                                <div
                                    class="flex justify-between font-bold text-amber-600 pt-2 border-t border-gray-100">
                                    <span>Status Pembayaran</span>
                                    <span
                                        id="statusPaymentDisplay">{{ $pembayaranAktif->status ?? 'Menunggu' }}</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                @if (isset($pembayaranAktif))
                                    <p class="text-xs text-gray-500 font-bold mb-1">Code Pembayaran: <span
                                            class="text-amber-600">#{{ $pembayaranAktif->invoice }}</span></p>
                                @endif
                                <h3 class="text-lg font-black text-gray-900 border-b border-gray-200 pb-4">Total
                                    Pembayaran : Rp.
                                    {{ number_format($pesananAktif->ekstra['Total Bayar'] ?? 0, 0, ',', '.') }}</h3>
                            </div>

                            @if (isset($pesananAktif->ekstra['Metode Pembayaran']) && $pesananAktif->ekstra['Metode Pembayaran'] === 'QRIS')
                                <div class="flex flex-col flex-grow justify-end space-y-4">
                                    <div
                                        class="border-2 border-gray-300 rounded-2xl flex-grow min-h-[220px] flex items-center justify-center bg-gray-50 p-4">
                                        <div id="qrisContainer"
                                            class="text-center w-full flex flex-col items-center justify-center">
                                            @if (isset($pembayaranAktif) && $pembayaranAktif->status === 'berhasil')
                                                <div class="text-center w-full animate-fade-in">
                                                    <div
                                                        class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm border-4 border-white ring-2 ring-green-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10"
                                                            viewBox="0 0 24 24">
                                                            <path fill="currentColor"
                                                                d="M10.5 15.25A.74.74 0 0 1 10 15l-3-3a.75.75 0 0 1 1-1l2.47 2.47L19 5a.75.75 0 0 1 1 1l-9 9a.74.74 0 0 1-.5.25Z" />
                                                            <path fill="currentColor"
                                                                d="M12 21a9 9 0 0 1-7.87-4.66a8.67 8.67 0 0 1-1.07-3.41a9 9 0 0 1 4.6-8.81a8.67 8.67 0 0 1 3.41-1.07a8.86 8.86 0 0 1 3.55.34a.75.75 0 1 1-.43 1.43a7.62 7.62 0 0 0-3-.28a7.43 7.43 0 0 0-2.84.89a7.5 7.5 0 0 0-2.2 1.84a7.42 7.42 0 0 0-1.64 5.51a7.43 7.43 0 0 0 .89 2.84a7.5 7.5 0 0 0 1.84 2.2a7.42 7.42 0 0 0 5.51 1.64a7.43 7.43 0 0 0 2.84-.89a7.5 7.5 0 0 0 2.2-1.84a7.42 7.42 0 0 0 1.64-5.51a.75.75 0 1 1 1.57-.15a9 9 0 0 1-4.61 8.81A8.67 8.67 0 0 1 12.93 21H12Z" />
                                                        </svg>
                                                    </div>
                                                    <h4 class="font-black text-green-700 text-xl">Pembayaran Berhasil!
                                                    </h4>
                                                </div>
                                            @elseif (isset($pembayaranAktif) && $pembayaranAktif->qr_image)
                                                @php $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=' . urlencode($pembayaranAktif->qr_image); @endphp
                                                <div class="animate-fade-in flex flex-col items-center w-full">
                                                    <div class="mb-3 text-center w-full">
                                                        <p
                                                            class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-1">
                                                            Status Batas Waktu:</p>
                                                        <div id="qrisTimer"
                                                            class="text-sm font-bold border rounded-lg py-1 px-3 inline-block">
                                                            Menghitung Waktu...</div>
                                                    </div>
                                                    <img src="{{ $qrUrl }}" alt="QRIS"
                                                        class="w-44 h-44 object-contain shadow-sm border border-gray-200 rounded-xl bg-white p-2 mx-auto">
                                                    <button type="button"
                                                        onclick="downloadQR('{{ $qrUrl }}', '{{ $pembayaranAktif->invoice }}')"
                                                        class="mt-4 w-full bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-300 font-bold py-2 px-4 rounded-xl text-xs transition shadow-sm flex items-center justify-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                                                            </path>
                                                        </svg>
                                                        Download Gambar QRIS
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div
                                    class="border-2 border-gray-300 rounded-2xl flex-grow min-h-[200px] flex flex-col items-center justify-center bg-gray-50 p-4">
                                    <span class="text-4xl mb-2">🏨</span>
                                    <h4 class="font-bold text-gray-800 text-lg">Bayar di Tempat</h4>
                                    <p class="text-sm text-gray-500 mt-1 text-center">Silakan lakukan pelunasan di meja
                                        resepsionis.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <link rel="stylesheet" href="{{ asset('css/landingpage/hriwayat.css') }}?v={{ time() }}">
        <script src="{{ asset('js/landingpage/hriwayat.js') }}?v={{ time() }}"></script>
        @if (isset($pembayaranAktif) && $pembayaranAktif->status === 'pending' && $pembayaranAktif->qr_image)
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    startPaymentCheck("{{ $pembayaranAktif->invoice }}");
                    startCountdown("{{ $pembayaranAktif->expired_at }}");
                });
            </script>
        @endif
    @endif
</x-lplayout>

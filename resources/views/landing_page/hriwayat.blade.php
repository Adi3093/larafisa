<x-lplayout>
    <div class="absolute top-0 left-0 w-full h-64 bg-amber-600 z-0"></div>

    <div class="relative z-10 min-h-screen pt-24 lg:pt-32 pb-24 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">

        <div class="mb-8">
            <h1 class="text-white text-3xl font-extrabold tracking-tight">Riwayat & Status Perjalanan</h1>
            <p class="text-amber-100 mt-1">Pantau perkembangan reservasi kamar Anda secara real-time.</p>
        </div>

        @php
            // Menentukan Tahap Progression Bar Berdasarkan Status Riil Database
            $currentStep = 1; // Default: Reservasi
            if ($isLoggedIn && $pesananAktif) {
                $status = $pesananAktif->status_reservasi;
                $metadataekstra = $pesananAktif->ekstra ?? [];
                $metodeBayar = $metadataekstra['Metode Pembayaran'] ?? 'Bayar di tempat';

                if ($status === 'Menunggu Konfirmasi') {
                    // Jika memilih transfer, stand-by di menu Pembayaran, jika tidak langsung ke Konfirmasi
                    $currentStep = $metodeBayar === 'Transfer' ? 2 : 3;
                } elseif ($status === 'Terkonfirmasi') {
                    $currentStep = 3; // Konfirmasi Berhasil, tinggal nunggu jadwal datang
                } elseif ($status === 'Check-In') {
                    $currentStep = 4; // Tamu sedang di dalam kamar
                } elseif ($status === 'Selesai') {
                    $currentStep = 5; // Sudah Check-Out
                }
            }
        @endphp

        <!-- PROGRESSION STEP BAR (DIJAMIN RATA TENGAH PRESISI) -->
        <div class="bg-white rounded-3xl shadow-xl border border-amber-100 p-6 sm:px-10 pt-12 mb-8 overflow-hidden">
            <h2 class="sr-only">Steps</h2>

            <div class="relative flex items-center justify-between w-full">

                <!-- Garis Background Abu-abu -->
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1.5 bg-gray-100 rounded-lg z-0"></div>

                <!-- Garis Progress Emas Dinamis -->
                <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1.5 bg-amber-500 rounded-lg z-0 transition-all duration-700 ease-in-out"
                    style="width: {{ (($currentStep - 1) / 4) * 100 }}%"></div>

                <!-- Step 1: Reservasi -->
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

                <!-- Step 2: Pembayaran -->
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

                <!-- Step 3: Konfirmasi -->
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

                <!-- Step 4: Check-In -->
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

                <!-- Step 5: Check-Out -->
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

        <!-- CARD PESANAN AKTIF -->
        <h2 class="font-bold text-amber-950 text-xl mb-4 px-1">Pesanan Aktif Saat Ini</h2>

        <div class="bg-white rounded-3xl shadow-md border border-amber-100 p-6 sm:p-8 mb-10">
            <!-- KONDISI 1: JIKA BELUM LOGIN -->
            @if (!$isLoggedIn)
                <div class="text-center py-6">
                    <span class="text-5xl block mb-4">🔒</span>
                    <h3 class="text-lg font-extrabold text-amber-950">Akses Riwayat Terkunci</h3>
                    <p class="text-sm text-gray-500 max-w-sm mx-auto mt-2 leading-relaxed">Silakan masuk ke dalam akun
                        Anda atau daftarkan diri terlebih dahulu untuk melihat perkembangan riwayat reservasi.</p>
                    <div class="mt-6 flex justify-center gap-3">
                        <a href="{{ route('login') }}"
                            class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition">Log
                            In</a>
                        <a href="{{ route('register') }}"
                            class="bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold py-2.5 px-6 rounded-xl text-sm border border-amber-200 transition">Daftar
                            Akun</a>
                    </div>
                </div>

                <!-- KONDISI 2: JIKA SUDAH LOGIN TAPI BELUM PUNYA PESANAN -->
            @elseif (!$pesananAktif)
                <div class="text-center py-8">
                    <span class="text-5xl block mb-4">📭</span>
                    <h3 class="text-lg font-extrabold text-amber-950">Tidak Ada Pesanan yang Berjalan</h3>
                    <p class="text-sm text-gray-500 max-w-md mx-auto mt-2 leading-relaxed">Lakukan reservasi sekarang
                        dan pilih tipe kamar impian Anda untuk menikmati pelayanan terbaik dari kami.</p>
                    <div class="mt-6">
                        <a href="{{ route('reservasi.tamu') }}"
                            class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-8 rounded-xl text-sm transition shadow-md shadow-amber-600/20">Mulai
                            Booking Kamar</a>
                    </div>
                </div>

                <!-- KONDISI 3: JIKA MEMILIKI PESANAN AKTIF -->
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

                        <!-- Tombol Aksi Kendala -->
                        <div class="mt-6 flex flex-wrap gap-2 border-t border-gray-100 pt-4">
                            <button
                                onclick="alert('Fitur ubah jadwal sedang dalam pengembangan. Silakan hubungi Resepsionis melalui WhatsApp.');"
                                class="bg-gray-50 hover:bg-gray-100 text-gray-700 text-xs font-bold py-2.5 px-4 rounded-xl border border-gray-200 transition">
                                🔄 Ubah Jadwal Menginap
                            </button>

                            @if ($pesananAktif->status_reservasi === 'Menunggu Konfirmasi')
                                <form action="{{ route('reservasi.tamu.batal', $pesananAktif->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin membatalkan permohonan reservasi ini?')">
                                    @csrf @method('PUT')
                                    <button type="submit"
                                        class="bg-red-50 hover:bg-red-100 text-red-600 text-xs font-bold py-2.5 px-4 rounded-xl border border-red-200 transition">
                                        ❌ Batalkan Reservasi
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- TABEL ARSIP RIWAYAT MASA LALU -->
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
                                    @php
                                        $color =
                                            $history->status_reservasi === 'Selesai'
                                                ? 'bg-gray-100 text-gray-700'
                                                : 'bg-red-50 text-red-700 border-red-100';
                                    @endphp
                                    <span
                                        class="inline-block px-2.5 py-1 text-[10px] font-bold rounded-lg {{ $color }} border uppercase tracking-wider">
                                        {{ $history->status_reservasi }}
                                    </span>
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
</x-lplayout>

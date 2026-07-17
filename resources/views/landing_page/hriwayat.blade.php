<x-lplayout>
    <style>
        [x-cloak] {
            display: none !important;
        }

        .tab-scroll::-webkit-scrollbar {
            height: 4px;
        }

        .tab-scroll::-webkit-scrollbar-thumb {
            background-color: #fcd34d;
            border-radius: 10px;
        }
    </style>

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
                ✅ {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm font-bold">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        @if (!$isLoggedIn)
            <div class="bg-white rounded-3xl shadow-xl border border-amber-100 p-10 text-center">
                <div
                    class="w-20 h-20 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm ring-4 ring-amber-50">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-extrabold text-amber-950">Akses Riwayat Terkunci</h3>
                <p class="text-gray-500 mt-2">Silakan masuk ke akun Anda untuk melihat detail perjalanan dan tagihan.
                </p>
                <div class="mt-8 flex justify-center gap-3">
                    <a href="{{ route('login') }}"
                        class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-md shadow-amber-600/20">Log
                        In</a>
                    <a href="{{ route('register') }}"
                        class="bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold py-3 px-8 rounded-xl border border-amber-200 transition">Daftar
                        Akun</a>
                </div>
            </div>
        @else
            <!-- Logika Penentuan Tab Aktif -->
            @php
                $activeTab = 'riwayat';
                $showActiveCardInTab = '';

                // Jika tamu sedang menekan pagination, paksa tab tetap di 'riwayat'
                if (request()->has('page') || request()->has('per_page')) {
                    $activeTab = 'riwayat';
                } elseif ($pesananAktif) {
                    $status = $pesananAktif->status_reservasi;
                    $metode = $pesananAktif->ekstra['Metode Pembayaran'] ?? '';
                    $paymentStatus = $pembayaranAktif->status ?? '';

                    if ($status === 'Menunggu Konfirmasi') {
                        if ($metode === 'QRIS' && $paymentStatus === 'pending') {
                            $showActiveCardInTab = 'pembayaran';
                        } else {
                            $showActiveCardInTab = 'konfirmasi';
                        }
                    } elseif ($status === 'Terkonfirmasi') {
                        $showActiveCardInTab = 'checkin';
                    } elseif ($status === 'Check-In') {
                        $showActiveCardInTab = 'checkout';
                    }
                    $activeTab = $showActiveCardInTab;
                }
            @endphp

            <!-- Pembungkus Utama Tab Alpine.js -->
            <div x-data="{ tab: '{{ $activeTab }}' }"
                class="bg-white rounded-3xl shadow-2xl shadow-amber-900/10 border-2 border-amber-200 overflow-hidden">

                <!-- Navigasi Tab (Warna Diperhalus - Soft Amber) -->
                <div class="flex overflow-x-auto tab-scroll bg-white border-b-2 border-amber-200">
                    <button @click="tab = 'pembayaran'"
                        :class="tab === 'pembayaran' ? 'bg-amber-100 text-amber-800 shadow-inner' :
                            'text-gray-500 hover:bg-amber-50 hover:text-amber-700'"
                        class="flex-1 min-w-[110px] py-4 transition-all duration-300 flex flex-col items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        <span class="text-xs font-bold">Pembayaran</span>
                    </button>
                    <button @click="tab = 'konfirmasi'"
                        :class="tab === 'konfirmasi' ? 'bg-amber-100 text-amber-800 shadow-inner' :
                            'text-gray-500 hover:bg-amber-50 hover:text-amber-700'"
                        class="flex-1 min-w-[110px] py-4 transition-all duration-300 flex flex-col items-center gap-2 border-l border-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-xs font-bold">Konfirmasi</span>
                    </button>
                    <button @click="tab = 'checkin'"
                        :class="tab === 'checkin' ? 'bg-amber-100 text-amber-800 shadow-inner' :
                            'text-gray-500 hover:bg-amber-50 hover:text-amber-700'"
                        class="flex-1 min-w-[110px] py-4 transition-all duration-300 flex flex-col items-center gap-2 border-l border-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        <span class="text-xs font-bold">Check-in</span>
                    </button>
                    <button @click="tab = 'checkout'"
                        :class="tab === 'checkout' ? 'bg-amber-100 text-amber-800 shadow-inner' :
                            'text-gray-500 hover:bg-amber-50 hover:text-amber-700'"
                        class="flex-1 min-w-[110px] py-4 transition-all duration-300 flex flex-col items-center gap-2 border-l border-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="text-xs font-bold">Check-out</span>
                    </button>
                    <button @click="tab = 'riwayat'"
                        :class="tab === 'riwayat' ? 'bg-amber-100 text-amber-800 shadow-inner' :
                            'text-gray-500 hover:bg-amber-50 hover:text-amber-700'"
                        class="flex-1 min-w-[110px] py-4 transition-all duration-300 flex flex-col items-center gap-2 border-l border-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-xs font-bold">Riwayat</span>
                    </button>
                </div>

                <!-- Konten Tab -->
                <div class="p-6 sm:p-8 min-h-[400px]">

                    <!-- Komponen Reusable Card untuk Pesanan Aktif -->
                    @php
                        $renderActiveCard = function () use ($pesananAktif) {
                            if (!$pesananAktif) {
                                return '';
                            }
                            $ekstra = is_array($pesananAktif->ekstra)
                                ? $pesananAktif->ekstra
                                : json_decode($pesananAktif->ekstra, true) ?? [];
                            $bed = $ekstra['Extra Bed'] ?? 0;
                            $selimut = $ekstra['Extra Selimut'] ?? 0;
                            $fotoKamar = $pesananAktif->kamar?->kelasKamar?->thumbnail
                                ? asset('storage/' . $pesananAktif->kamar->kelasKamar->thumbnail)
                                : asset('storage/landingpage/room-placeholder.jpg');

                            return '
                            <div class="bg-white border-2 border-amber-200 rounded-3xl p-4 sm:p-5 flex flex-col md:flex-row gap-6 items-center md:items-stretch mb-4 hover:shadow-xl hover:border-amber-400 transition-all duration-300">
                                <div class="w-full md:w-56 h-56 rounded-2xl overflow-hidden flex-shrink-0 flex items-center justify-center bg-gray-50 relative shadow-inner">
                                    <img src="' .
                                $fotoKamar .
                                '" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 w-full flex flex-col h-full justify-between py-2">
                                    <div>
                                        <div class="flex justify-between items-start mb-1">
                                            <div>
                                                <h3 class="text-xl font-black text-amber-950">' .
                                ($pesananAktif->kamar?->kelasKamar?->nama_kelas ?? 'Tipe Kamar') .
                                '</h3>
                                                <p class="text-xs text-amber-600 font-bold mb-4">#' .
                                $pesananAktif->no_reservasi .
                                '</p>
                                            </div>
                                        </div>

                                        <div class="flex text-sm text-gray-700 mb-5">
                                            <div class="w-32 font-bold text-amber-800/70 uppercase tracking-wider text-[10px]">Layanan Extra :</div>
                                            <div class="flex-1 font-medium space-y-1 text-xs">
                                                ' .
                                ($bed > 0 ? "<p class='text-amber-900'>Extra Bed (x$bed)</p>" : '') .
                                '
                                                ' .
                                ($selimut > 0 ? "<p class='text-amber-900'>Extra Selimut (x$selimut)</p>" : '') .
                                '
                                                ' .
                                ($bed == 0 && $selimut == 0
                                    ? '<p class="text-gray-400 italic">Tidak ada tambahan</p>'
                                    : '') .
                                '
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4 max-w-sm mb-6">
                                            <div>
                                                <span class="block text-[10px] font-bold text-amber-800/70 uppercase tracking-wider mb-1">Check-in :</span>
                                                <span class="text-xs font-black text-amber-950">' .
                                \Carbon\Carbon::parse($pesananAktif->check_in)->format('d-m-Y H:i') .
                                '</span>
                                            </div>
                                            <div>
                                                <span class="block text-[10px] font-bold text-amber-800/70 uppercase tracking-wider mb-1">Check-out :</span>
                                                <span class="text-xs font-black text-amber-950">' .
                                \Carbon\Carbon::parse($pesananAktif->check_out)->format('d-m-Y H:i') .
                                '</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <!-- Tombol Detail Reservasi -->
                                        <button onclick="document.getElementById(\'modalDetail-' .
                                $pesananAktif->id .
                                '\').classList.remove(\'hidden\')" class="w-full sm:w-auto px-8 py-2.5 bg-transparent border-2 border-amber-500 rounded-xl text-sm font-bold text-amber-600 hover:bg-amber-600 hover:text-white focus:bg-amber-600 focus:text-white transition-all duration-300">Detail Reservasi</button>
                                    </div>
                                </div>
                            </div>';
                        };
                    @endphp

                    <!-- 1. TAB PEMBAYARAN -->
                    <div x-show="tab === 'pembayaran'" x-cloak class="animate-fade-in">
                        @if ($showActiveCardInTab === 'pembayaran')
                            {!! $renderActiveCard() !!}
                        @else
                            <div class="text-center py-16">
                                <div
                                    class="w-20 h-20 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-extrabold text-amber-950">Tidak Ada Tagihan</h3>
                                <p class="text-gray-500 text-sm mt-2">Semua tagihan Anda sudah dibayar atau tidak ada
                                    pesanan tertunda.</p>
                            </div>
                        @endif
                    </div>

                    <!-- 2. TAB KONFIRMASI -->
                    <div x-show="tab === 'konfirmasi'" x-cloak class="animate-fade-in">
                        @if ($showActiveCardInTab === 'konfirmasi')
                            {!! $renderActiveCard() !!}
                        @else
                            <div class="text-center py-16">
                                <div
                                    class="w-20 h-20 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-extrabold text-amber-950">Tidak Ada Antrean Konfirmasi</h3>
                                <p class="text-gray-500 text-sm mt-2">Tidak ada reservasi Anda yang sedang menunggu
                                    respon resepsionis.</p>
                            </div>
                        @endif
                    </div>

                    <!-- 3. TAB CHECK-IN -->
                    <div x-show="tab === 'checkin'" x-cloak class="animate-fade-in">
                        @if ($showActiveCardInTab === 'checkin')
                            {!! $renderActiveCard() !!}
                        @else
                            <div class="text-center py-16">
                                <div
                                    class="w-20 h-20 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-extrabold text-amber-950">Belum Ada Jadwal Check-In</h3>
                                <p class="text-gray-500 text-sm mt-2">Anda tidak memiliki jadwal kedatangan dalam waktu
                                    dekat.</p>
                            </div>
                        @endif
                    </div>

                    <!-- 4. TAB CHECK-OUT -->
                    <div x-show="tab === 'checkout'" x-cloak class="animate-fade-in">
                        @if ($showActiveCardInTab === 'checkout')
                            {!! $renderActiveCard() !!}
                        @else
                            <div class="text-center py-16">
                                <div
                                    class="w-20 h-20 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-extrabold text-amber-950">Tidak Sedang Menginap</h3>
                                <p class="text-gray-500 text-sm mt-2">Anda tidak sedang menginap di kamar hotel manapun
                                    saat ini.</p>
                            </div>
                        @endif
                    </div>

                    <!-- 5. TAB RIWAYAT -->
                    <div x-show="tab === 'riwayat'" x-cloak class="animate-fade-in space-y-4">
                        @forelse($arsipReservasi as $history)
                            @php
                                $ekstraHist = is_array($history->ekstra)
                                    ? $history->ekstra
                                    : json_decode($history->ekstra, true) ?? [];
                                $bedHist = $ekstraHist['Extra Bed'] ?? 0;
                                $selimutHist = $ekstraHist['Extra Selimut'] ?? 0;
                                $fotoHist = $history->kamar?->kelasKamar?->thumbnail
                                    ? asset('storage/' . $history->kamar->kelasKamar->thumbnail)
                                    : asset('storage/landingpage/room-placeholder.jpg');
                                $pillClass =
                                    $history->status_reservasi === 'Selesai'
                                        ? 'border-emerald-500 text-emerald-600'
                                        : 'border-red-500 text-red-600';
                            @endphp
                            <div
                                class="bg-white border-2 border-amber-200 rounded-3xl p-4 sm:p-5 flex flex-col md:flex-row gap-6 items-center md:items-stretch hover:shadow-xl hover:border-amber-400 transition-all duration-300">
                                <div
                                    class="w-full md:w-56 h-56 rounded-2xl overflow-hidden flex-shrink-0 flex items-center justify-center bg-gray-50 relative shadow-inner">
                                    <img src="{{ $fotoHist }}" class="w-full h-full object-cover grayscale-[20%]">
                                </div>
                                <div class="flex-1 w-full flex flex-col h-full justify-between py-2">
                                    <div>
                                        <div class="flex justify-between items-start mb-1 gap-2">
                                            <div>
                                                <h3 class="text-xl font-black text-amber-950">
                                                    {{ $history->kamar?->kelasKamar?->nama_kelas ?? 'Tipe Kamar' }}</h3>
                                                <p class="text-xs text-amber-600 font-bold mb-4">
                                                    #{{ $history->no_reservasi }}</p>
                                            </div>
                                            <!-- Pill Status -->
                                            <span
                                                class="px-4 py-1.5 rounded-full border-2 text-[10px] font-black uppercase tracking-wider {{ $pillClass }} whitespace-nowrap bg-white">
                                                {{ $history->status_reservasi }}
                                            </span>
                                        </div>

                                        <div class="flex text-sm text-gray-700 mb-5">
                                            <div
                                                class="w-32 font-bold text-amber-800/70 uppercase tracking-wider text-[10px]">
                                                Layanan Extra :</div>
                                            <div class="flex-1 font-medium space-y-1 text-xs">
                                                @if ($bedHist > 0)
                                                    <p class="text-amber-900">Extra Bed (x{{ $bedHist }})</p>
                                                @endif
                                                @if ($selimutHist > 0)
                                                    <p class="text-amber-900">Extra Selimut (x{{ $selimutHist }})</p>
                                                @endif
                                                @if ($bedHist == 0 && $selimutHist == 0)
                                                    <p class="text-gray-400 italic">Tidak ada tambahan</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4 max-w-sm mb-6">
                                            <div>
                                                <span
                                                    class="block text-[10px] font-bold text-amber-800/70 uppercase tracking-wider mb-1">Check-in
                                                    :</span>
                                                <span
                                                    class="text-xs font-black text-amber-950">{{ \Carbon\Carbon::parse($history->check_in)->format('d-m-Y H:i') }}</span>
                                            </div>
                                            <div>
                                                <span
                                                    class="block text-[10px] font-bold text-amber-800/70 uppercase tracking-wider mb-1">Check-out
                                                    :</span>
                                                <span
                                                    class="text-xs font-black text-amber-950">{{ \Carbon\Carbon::parse($history->check_out)->format('d-m-Y H:i') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <!-- Tombol Detail Reservasi -->
                                        <button
                                            onclick="document.getElementById('modalDetail-{{ $history->id }}').classList.remove('hidden')"
                                            class="w-full sm:w-auto px-8 py-2.5 bg-amber-600 rounded-xl text-sm font-bold text-white hover:bg-amber-700 hover:text-white focus:bg-amber-600 focus:text-white transition-all duration-300">Detail
                                            Reservasi</button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div
                                class="text-center py-16 border-2 border-dashed border-amber-200 bg-amber-50/50 rounded-3xl">
                                <div
                                    class="w-20 h-20 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-extrabold text-amber-950">Belum Ada Riwayat</h3>
                                <p class="text-gray-500 text-sm mt-2">Anda belum memiliki catatan pemesanan kamar di
                                    masa lalu.</p>
                            </div>
                        @endforelse

                        <!-- PAGINATION KONTROL -->
                        @if ($arsipReservasi->total() > 0)
                            <div
                                class="mt-8 flex flex-col sm:flex-row justify-between items-center gap-4 bg-amber-50 p-4 rounded-2xl border border-amber-200 shadow-sm">
                                <div class="flex items-center gap-2">
                                    <form method="GET" action="{{ route('riwayat.tamu') }}"
                                        id="formPerPageRiwayat">
                                        <select name="per_page"
                                            onchange="document.getElementById('formPerPageRiwayat').submit()"
                                            class="border border-amber-300 rounded-xl text-sm bg-white focus:ring-amber-500 focus:border-amber-500 font-bold text-amber-800 py-2 px-4 shadow-sm cursor-pointer hover:bg-amber-50 transition">
                                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 Baris
                                            </option>
                                            <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15 Baris
                                            </option>
                                            <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20 Baris
                                            </option>
                                        </select>
                                    </form>
                                </div>
                                <div class="w-full sm:w-auto overflow-x-auto">
                                    {{ $arsipReservasi->links() }}
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

            <!-- KUMPULAN MODAL DETAIL RESERVASI -->
            @php
                $allReservations = collect();
                if ($pesananAktif) {
                    $allReservations->push($pesananAktif);
                }
                foreach ($arsipReservasi as $arsip) {
                    $allReservations->push($arsip);
                }
            @endphp

            @foreach ($allReservations as $res)
                @php
                    $isPesananAktif = $pesananAktif && $pesananAktif->id === $res->id;
                    $ekstra = is_array($res->ekstra) ? $res->ekstra : json_decode($res->ekstra, true) ?? [];
                @endphp
                <div id="modalDetail-{{ $res->id }}"
                    class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/60 backdrop-blur-sm"
                    aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                        <div
                            class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl border border-gray-200">

                            <div
                                class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                                <h3 class="text-xl font-bold text-gray-900">Detail dan Reservasi Tamu</h3>
                                <button
                                    onclick="document.getElementById('modalDetail-{{ $res->id }}').classList.add('hidden')"
                                    class="text-gray-400 hover:text-red-500 transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        stroke="currentColor">
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
                                                    class="text-amber-600">#{{ $res->no_reservasi }}</span></span>
                                        </div>
                                        <div class="space-y-1 text-sm text-gray-700 font-medium">
                                            <p>Nama : {{ $res->nama_tamu }}</p>
                                            <p>No.HP : {{ $res->no_hp }}</p>
                                            <p>Jumlah Tamu : {{ $ekstra['Jumlah Anggota'] ?? 1 }} Orang</p>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="border-b border-gray-300 pb-2 mb-3">
                                            <h4 class="text-lg font-bold text-gray-800">Informasi Pesanan</h4>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4 mb-3">
                                            <div>
                                                <span
                                                    class="text-xs font-bold text-gray-500 mb-1 block">Check-In</span>
                                                <div
                                                    class="border border-gray-300 rounded-lg p-2.5 text-center text-sm font-bold text-gray-800">
                                                    {{ \Carbon\Carbon::parse($res->check_in)->translatedFormat('d M Y') }}
                                                </div>
                                            </div>
                                            <div>
                                                <span
                                                    class="text-xs font-bold text-gray-500 mb-1 block">Check-Out</span>
                                                <div
                                                    class="border border-gray-300 rounded-lg p-2.5 text-center text-sm font-bold text-gray-800">
                                                    {{ \Carbon\Carbon::parse($res->check_out)->translatedFormat('d M Y') }}
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-sm font-medium text-gray-700">Kelas Kamar : <span
                                                class="font-bold">{{ $res->kamar?->kelasKamar?->nama_kelas ?? '-' }}</span>
                                        </p>
                                    </div>
                                    <div>
                                        <div class="border-b border-gray-300 pb-2 mb-3">
                                            <h4 class="text-lg font-bold text-gray-800">Layanan Extra</h4>
                                        </div>
                                        <div class="space-y-1 text-sm text-gray-700 font-medium">
                                            <p>Extra Bed x{{ $ekstra['Extra Bed'] ?? 0 }}</p>
                                            <p>Extra Selimut x{{ $ekstra['Extra Selimut'] ?? 0 }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Area Pembayaran Sisi Kanan -->
                                <div
                                    class="w-full md:w-1/2 md:border-l md:border-gray-300 md:pl-8 flex flex-col h-full">
                                    <div class="border-b border-gray-300 pb-2 mb-4">
                                        <h4 class="text-xl font-bold text-gray-800">Detail Pembayaran</h4>
                                    </div>

                                    <div class="space-y-2 text-sm text-gray-700 font-medium mb-6">
                                        <div class="flex justify-between">
                                            <span>Kelas Kamar</span>
                                            <span>{{ $res->kamar?->kelasKamar?->nama_kelas ?? '-' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Tanggal Check-in</span>
                                            <span>{{ \Carbon\Carbon::parse($res->check_in)->translatedFormat('d M Y') }}</span>
                                        </div>
                                        <div
                                            class="flex justify-between font-bold text-amber-600 pt-2 border-t border-gray-100">
                                            <span>Status Reservasi</span>
                                            <span>
                                                @if ($isPesananAktif)
                                                    {{ $pembayaranAktif->status ?? $res->status_reservasi }}
                                                @else
                                                    {{ $res->status_reservasi }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        @if ($isPesananAktif && isset($pembayaranAktif))
                                            <p class="text-xs text-gray-500 font-bold mb-1">Code Pembayaran: <span
                                                    class="text-amber-600">#{{ $pembayaranAktif->invoice }}</span></p>
                                        @endif
                                        <h3 class="text-lg font-black text-gray-900 border-b border-gray-200 pb-4">
                                            Total Pembayaran : Rp.
                                            {{ number_format($ekstra['Total Bayar'] ?? 0, 0, ',', '.') }}</h3>
                                    </div>

                                    <!-- QRIS Box Khusus Pesanan Aktif -->
                                    @if ($isPesananAktif && isset($ekstra['Metode Pembayaran']) && $ekstra['Metode Pembayaran'] === 'QRIS')
                                        <div class="flex flex-col flex-grow justify-end space-y-4">
                                            <div
                                                class="border-2 border-gray-300 rounded-2xl flex-grow min-h-[220px] flex items-center justify-center bg-gray-50 p-4">
                                                <div id="qrisContainer"
                                                    class="text-center w-full flex flex-col items-center justify-center">
                                                    @if (isset($pembayaranAktif) && $pembayaranAktif->status === 'berhasil')
                                                        <div class="text-center w-full animate-fade-in">
                                                            <div
                                                                class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm border-4 border-white ring-2 ring-green-100">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="w-10 h-10" viewBox="0 0 24 24">
                                                                    <path fill="currentColor"
                                                                        d="M10.5 15.25A.74.74 0 0 1 10 15l-3-3a.75.75 0 0 1 1-1l2.47 2.47L19 5a.75.75 0 0 1 1 1l-9 9a.74.74 0 0 1-.5.25Z" />
                                                                    <path fill="currentColor"
                                                                        d="M12 21a9 9 0 0 1-7.87-4.66a8.67 8.67 0 0 1-1.07-3.41a9 9 0 0 1 4.6-8.81a8.67 8.67 0 0 1 3.41-1.07a8.86 8.86 0 0 1 3.55.34a.75.75 0 1 1-.43 1.43a7.62 7.62 0 0 0-3-.28a7.43 7.43 0 0 0-2.84.89a7.5 7.5 0 0 0-2.2 1.84a7.42 7.42 0 0 0-1.64 5.51a7.43 7.43 0 0 0 .89 2.84a7.5 7.5 0 0 0 1.84 2.2a7.42 7.42 0 0 0 5.51 1.64a7.43 7.43 0 0 0 2.84-.89a7.5 7.5 0 0 0 2.2-1.84a7.42 7.42 0 0 0 1.64-5.51a.75.75 0 1 1 1.57-.15a9 9 0 0 1-4.61 8.81A8.67 8.67 0 0 1 12.93 21H12Z" />
                                                                </svg>
                                                            </div>
                                                            <h4 class="font-black text-green-700 text-xl">Pembayaran
                                                                Berhasil!</h4>
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
                                                                <svg class="w-4 h-4" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
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
                                        <!-- Jika Bayar Tunai / Reservasi Sudah Masuk Arsip -->
                                        <div
                                            class="border-2 border-gray-300 rounded-2xl flex-grow min-h-[200px] flex flex-col items-center justify-center bg-gray-50 p-4">
                                            <span
                                                class="text-4xl mb-2">{{ in_array($res->status_reservasi, ['Selesai', 'Batal', 'Dibatalkan']) ? '🧾' : '🏨' }}</span>
                                            <h4 class="font-bold text-gray-800 text-lg">
                                                {{ in_array($res->status_reservasi, ['Selesai', 'Batal', 'Dibatalkan']) ? 'Struk Terkunci' : 'Bayar di Tempat' }}
                                            </h4>
                                            <p class="text-sm text-gray-500 mt-1 text-center">
                                                {{ in_array($res->status_reservasi, ['Selesai', 'Batal', 'Dibatalkan']) ? 'Reservasi ini telah masuk ke dalam arsip historis.' : 'Silakan lakukan pelunasan di meja resepsionis.' }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        @endif

        <link rel="stylesheet" href="{{ asset('css/landingpage/hriwayat.css') }}?v={{ time() }}">
        <script src="{{ asset('js/landingpage/hriwayat.js') }}?v={{ time() }}"></script>

        <!-- Timer Trigger untuk Pesanan Aktif QRIS -->
        @if ($isLoggedIn && isset($pembayaranAktif) && $pembayaranAktif->status === 'pending' && $pembayaranAktif->qr_image)
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    startPaymentCheck("{{ $pembayaranAktif->invoice }}");
                    startCountdown("{{ $pembayaranAktif->expired_at }}");
                });
            </script>
        @endif

    </div>
</x-lplayout>

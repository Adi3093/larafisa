<x-lplayout>
    <div class="absolute top-0 left-0 w-full h-64 bg-amber-600 z-0"></div>

    <div class="relative z-10 min-h-screen pt-24 lg:pt-32 pb-24 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">

        <div class="mb-8">
            <h1 class="text-white text-3xl font-extrabold tracking-tight">Riwayat & Status Perjalanan</h1>
            <p class="text-amber-100 mt-1">Pantau perkembangan reservasi kamar Anda secara real-time.</p>
        </div>

        @if (session('success'))
            <div
                class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm font-bold">
                ✅ {{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm font-bold">⚠️
                {{ session('error') }}</div>
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
            @php
                // LOGIKA PENGELOMPOKAN MULTI-RESERVASI KE DALAM TAB
                $tabPembayaran = collect();
                $tabKonfirmasi = collect();
                $tabCheckin = collect();
                $tabCheckout = collect();

                foreach ($pesananAktifs as $pesanan) {
                    $status = $pesanan->status_reservasi;
                    $ekstra = is_array($pesanan->ekstra) ? $pesanan->ekstra : json_decode($pesanan->ekstra, true) ?? [];
                    $metode = $ekstra['Metode Pembayaran'] ?? '';
                    $pembayaran = $pembayaranAktifs[$pesanan->id] ?? null;
                    $payStatus = $pembayaran->status ?? '';

                    if ($status === 'Menunggu Konfirmasi') {
                        if ($metode === 'QRIS' && $payStatus === 'pending') {
                            $tabPembayaran->push($pesanan);
                        } else {
                            $tabKonfirmasi->push($pesanan);
                        }
                    } elseif ($status === 'Terkonfirmasi') {
                        $tabCheckin->push($pesanan);
                    } elseif ($status === 'Check-In') {
                        $tabCheckout->push($pesanan);
                    }
                }

                $activeTab = 'riwayat';
                if (!request()->has('page') && !request()->has('per_page')) {
                    if ($tabPembayaran->isNotEmpty()) {
                        $activeTab = 'pembayaran';
                    } elseif ($tabKonfirmasi->isNotEmpty()) {
                        $activeTab = 'konfirmasi';
                    } elseif ($tabCheckin->isNotEmpty()) {
                        $activeTab = 'checkin';
                    } elseif ($tabCheckout->isNotEmpty()) {
                        $activeTab = 'checkout';
                    }
                }
            @endphp

            <div x-data="{ tab: '{{ $activeTab }}' }"
                class="bg-white rounded-3xl shadow-2xl shadow-amber-900/10 border-2 border-amber-200 overflow-hidden">

                <div class="flex w-full bg-white border-b-2 border-amber-200 justify-between">
                    <button @click="tab = 'pembayaran'"
                        :class="tab === 'pembayaran' ? 'bg-amber-100 text-amber-800 shadow-inner' :
                            'text-gray-500 hover:bg-amber-50 hover:text-amber-700'"
                        class="flex-1 py-3 sm:py-4 transition-all duration-300 flex flex-col items-center gap-1 sm:gap-2">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        <span
                            class="text-[9px] sm:text-xs font-bold truncate w-full text-center px-0.5">Pembayaran</span>
                    </button>
                    <button @click="tab = 'konfirmasi'"
                        :class="tab === 'konfirmasi' ? 'bg-amber-100 text-amber-800 shadow-inner' :
                            'text-gray-500 hover:bg-amber-50 hover:text-amber-700'"
                        class="flex-1 py-3 sm:py-4 transition-all duration-300 flex flex-col items-center gap-1 sm:gap-2 border-l border-gray-100">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span
                            class="text-[9px] sm:text-xs font-bold truncate w-full text-center px-0.5">Konfirmasi</span>
                    </button>
                    <button @click="tab = 'checkin'"
                        :class="tab === 'checkin' ? 'bg-amber-100 text-amber-800 shadow-inner' :
                            'text-gray-500 hover:bg-amber-50 hover:text-amber-700'"
                        class="flex-1 py-3 sm:py-4 transition-all duration-300 flex flex-col items-center gap-1 sm:gap-2 border-l border-gray-100">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        <span class="text-[9px] sm:text-xs font-bold truncate w-full text-center px-0.5">Check-in</span>
                    </button>
                    <button @click="tab = 'checkout'"
                        :class="tab === 'checkout' ? 'bg-amber-100 text-amber-800 shadow-inner' :
                            'text-gray-500 hover:bg-amber-50 hover:text-amber-700'"
                        class="flex-1 py-3 sm:py-4 transition-all duration-300 flex flex-col items-center gap-1 sm:gap-2 border-l border-gray-100">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span
                            class="text-[9px] sm:text-xs font-bold truncate w-full text-center px-0.5">Check-out</span>
                    </button>
                    <button @click="tab = 'riwayat'"
                        :class="tab === 'riwayat' ? 'bg-amber-100 text-amber-800 shadow-inner' :
                            'text-gray-500 hover:bg-amber-50 hover:text-amber-700'"
                        class="flex-1 py-3 sm:py-4 transition-all duration-300 flex flex-col items-center gap-1 sm:gap-2 border-l border-gray-100">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-[9px] sm:text-xs font-bold truncate w-full text-center px-0.5">Riwayat</span>
                    </button>
                </div>

                <div class="p-4 sm:p-8 min-h-[400px]">

                    @php
                        $renderActiveCard = function ($pesananData) {
                            if (!$pesananData) {
                                return '';
                            }
                            $ekstra = is_array($pesananData->ekstra)
                                ? $pesananData->ekstra
                                : json_decode($pesananData->ekstra, true) ?? [];
                            $bed = $ekstra['Extra Bed'] ?? 0;
                            $selimut = $ekstra['Extra Selimut'] ?? 0;
                            $fotoKamar = $pesananData->kamar?->kelasKamar?->thumbnail
                                ? asset('storage/' . $pesananData->kamar->kelasKamar->thumbnail)
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
                                ($pesananData->kamar?->kelasKamar?->nama_kelas ?? 'Tipe Kamar') .
                                '</h3>
                                                <p class="text-xs text-amber-600 font-bold mb-4">#' .
                                $pesananData->no_reservasi .
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
                                \Carbon\Carbon::parse($pesananData->check_in)->format('d-m-Y H:i') .
                                '</span>
                                            </div>
                                            <div>
                                                <span class="block text-[10px] font-bold text-amber-800/70 uppercase tracking-wider mb-1">Check-out :</span>
                                                <span class="text-xs font-black text-amber-950">' .
                                \Carbon\Carbon::parse($pesananData->check_out)->format('d-m-Y H:i') .
                                '</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button onclick="document.getElementById(\'modalDetail-' .
                                $pesananData->id .
                                '\').classList.remove(\'hidden\')" class="w-full sm:w-auto px-8 py-2.5 bg-amber-600 rounded-xl text-sm font-bold text-white hover:bg-amber-700 focus:bg-amber-600 transition transform hover:-translate-y-0.5 duration-300 shadow-sm border-none">Detail Reservasi</button>
                                    </div>
                                </div>
                            </div>';
                        };
                    @endphp

                    <div x-show="tab === 'pembayaran'" x-cloak class="animate-fade-in space-y-4">
                        @if ($tabPembayaran->isNotEmpty())
                            @foreach ($tabPembayaran as $pesan)
                                {!! $renderActiveCard($pesan) !!}
                            @endforeach
                        @else
                            <div class="text-center py-16">
                                <div
                                    class="w-20 h-20 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg></div>
                                <h3 class="text-lg font-extrabold text-amber-950">Tidak Ada Tagihan</h3>
                                <p class="text-gray-500 text-sm mt-2">Semua tagihan Anda sudah dibayar atau tidak ada
                                    pesanan tertunda.</p>
                            </div>
                        @endif
                    </div>
                    <div x-show="tab === 'konfirmasi'" x-cloak class="animate-fade-in space-y-4">
                        @if ($tabKonfirmasi->isNotEmpty())
                            @foreach ($tabKonfirmasi as $pesan)
                                {!! $renderActiveCard($pesan) !!}
                            @endforeach
                        @else
                            <div class="text-center py-16">
                                <div
                                    class="w-20 h-20 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg></div>
                                <h3 class="text-lg font-extrabold text-amber-950">Tidak Ada Antrean Konfirmasi</h3>
                                <p class="text-gray-500 text-sm mt-2">Tidak ada reservasi Anda yang sedang menunggu
                                    respon resepsionis.</p>
                            </div>
                        @endif
                    </div>
                    <div x-show="tab === 'checkin'" x-cloak class="animate-fade-in space-y-4">
                        @if ($tabCheckin->isNotEmpty())
                            @foreach ($tabCheckin as $pesan)
                                {!! $renderActiveCard($pesan) !!}
                            @endforeach
                        @else
                            <div class="text-center py-16">
                                <div
                                    class="w-20 h-20 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg></div>
                                <h3 class="text-lg font-extrabold text-amber-950">Belum Ada Jadwal Check-In</h3>
                                <p class="text-gray-500 text-sm mt-2">Anda tidak memiliki jadwal kedatangan dalam waktu
                                    dekat.</p>
                            </div>
                        @endif
                    </div>
                    <div x-show="tab === 'checkout'" x-cloak class="animate-fade-in space-y-4">
                        @if ($tabCheckout->isNotEmpty())
                            @foreach ($tabCheckout as $pesan)
                                {!! $renderActiveCard($pesan) !!}
                            @endforeach
                        @else
                            <div class="text-center py-16">
                                <div
                                    class="w-20 h-20 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg></div>
                                <h3 class="text-lg font-extrabold text-amber-950">Tidak Sedang Menginap</h3>
                                <p class="text-gray-500 text-sm mt-2">Anda tidak sedang menginap di kamar hotel manapun
                                    saat ini.</p>
                            </div>
                        @endif
                    </div>

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
                                        <button
                                            onclick="document.getElementById('modalDetail-{{ $history->id }}').classList.remove('hidden')"
                                            class="w-full sm:w-auto px-8 py-2.5 bg-amber-600 rounded-xl text-sm font-bold text-white hover:bg-amber-700 focus:bg-amber-600 transition transform hover:-translate-y-0.5 duration-300 shadow-sm border-none">Detail
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
        @endif

    </div>

    @if ($isLoggedIn)
        @php
            $allReservations = collect();
            foreach ($pesananAktifs as $pa) {
                $allReservations->push($pa);
            }
            foreach ($arsipReservasi as $arsip) {
                $allReservations->push($arsip);
            }
        @endphp

        @foreach ($allReservations as $res)
            @php
                $isPesananAktif = $pesananAktifs->contains('id', $res->id);
                $pembayaranAktif = $isPesananAktif ? $pembayaranAktifs[$res->id] ?? null : null;
                $ekstra = is_array($res->ekstra) ? $res->ekstra : json_decode($res->ekstra, true) ?? [];
            @endphp

            <div id="modalDetail-{{ $res->id }}"
                class="fixed inset-0 z-[99999] hidden overflow-y-auto bg-gray-900/60 backdrop-blur-sm"
                aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">

                    <div
                        class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl shadow-amber-900/20 transition-all sm:my-8 w-full sm:max-w-4xl border-2 border-amber-200">

                        <div
                            class="px-6 py-4 border-b-2 border-amber-200 flex justify-between items-center bg-amber-50">
                            <h3 class="text-xl font-black text-amber-950">
                                <span id="headerTitleMobile-{{ $res->id }}" class="md:hidden">Detail dan
                                    Reservasi Tamu</span>
                                <span class="hidden md:block">Detail dan Reservasi Tamu</span>
                            </h3>

                            <div class="flex items-center gap-4">
                                <button type="button" id="backBtn-{{ $res->id }}"
                                    onclick="closeMobileWizard('{{ $res->id }}')"
                                    class="hidden text-amber-600 hover:text-amber-900 transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                </button>
                                <button type="button"
                                    onclick="document.getElementById('modalDetail-{{ $res->id }}').classList.add('hidden'); closeMobileWizard('{{ $res->id }}');"
                                    class="text-amber-500 hover:text-red-500 transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row bg-white">
                            <div id="infoPanel-{{ $res->id }}" class="w-full md:w-1/2 p-6 space-y-6 block">
                                <div>
                                    <div class="flex justify-between items-end border-b-2 border-amber-100 pb-2 mb-3">
                                        <h4 class="text-lg font-black text-amber-900">Informasi Tamu</h4>
                                        <span class="text-[10px] font-bold text-amber-600/70 uppercase">Code: <span
                                                class="text-amber-600">#{{ $res->no_reservasi }}</span></span>
                                    </div>
                                    <div class="space-y-1 text-sm text-amber-950 font-medium">
                                        <p><span class="text-amber-700">Nama :</span> {{ $res->nama_tamu }}</p>
                                        <p><span class="text-amber-700">No.HP :</span> {{ $res->no_hp }}</p>
                                        <p><span class="text-amber-700">Tamu :</span>
                                            {{ $ekstra['Jumlah Anggota'] ?? 1 }} Orang</p>
                                    </div>
                                </div>
                                <div>
                                    <div class="border-b-2 border-amber-100 pb-2 mb-3">
                                        <h4 class="text-lg font-black text-amber-900">Informasi Pesanan</h4>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div>
                                            <span
                                                class="text-[10px] font-bold text-amber-700 uppercase tracking-wider mb-1 block">Check-In:</span>
                                            <div
                                                class="border border-amber-200 bg-amber-50 rounded-lg p-2.5 text-center text-sm font-black text-amber-950 shadow-inner">
                                                {{ \Carbon\Carbon::parse($res->check_in)->translatedFormat('d M Y') }}
                                            </div>
                                        </div>
                                        <div>
                                            <span
                                                class="text-[10px] font-bold text-amber-700 uppercase tracking-wider mb-1 block">Check-Out:</span>
                                            <div
                                                class="border border-amber-200 bg-amber-50 rounded-lg p-2.5 text-center text-sm font-black text-amber-950 shadow-inner">
                                                {{ \Carbon\Carbon::parse($res->check_out)->translatedFormat('d M Y') }}
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-sm font-medium text-amber-700 mt-4">Kelas Kamar : <span
                                            class="font-bold text-amber-950">{{ $res->kamar?->kelasKamar?->nama_kelas ?? '-' }}</span>
                                    </p>
                                </div>
                                <div>
                                    <div class="border-b-2 border-amber-100 pb-2 mb-3">
                                        <h4 class="text-lg font-black text-amber-900">Layanan Ekstra</h4>
                                    </div>
                                    <div class="space-y-1 text-sm text-amber-950 font-medium mb-6">
                                        <p>Extra Bed <span
                                                class="text-amber-600 font-black">x{{ $ekstra['Extra Bed'] ?? 0 }}</span>
                                        </p>
                                        <p>Extra Selimut <span
                                                class="text-amber-600 font-black">x{{ $ekstra['Extra Selimut'] ?? 0 }}</span>
                                        </p>
                                    </div>

                                    <button type="button" onclick="openMobileWizard('{{ $res->id }}')"
                                        class="w-full md:hidden py-3 bg-amber-50 border border-amber-300 text-amber-800 font-bold rounded-xl shadow-sm hover:bg-amber-100 transition">
                                        Lihat Pembayaran
                                    </button>
                                </div>
                            </div>

                            <div id="paymentPanel-{{ $res->id }}"
                                class="w-full md:w-1/2 md:border-l-2 md:border-amber-100 p-6 flex-col h-full bg-gradient-to-b from-amber-50/50 to-white hidden md:flex">

                                <div class="border-b-2 border-amber-100 pb-2 mb-4 hidden md:block">
                                    <h4 class="text-xl font-black text-amber-900">Detail Pembayaran</h4>
                                </div>

                                <div class="space-y-2 text-sm text-amber-950 font-medium mb-6">
                                    <div class="flex justify-between">
                                        <span class="text-amber-700">Kelas Kamar</span>
                                        <span>{{ $res->kamar?->kelasKamar?->nama_kelas ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-amber-700">Tanggal Check-in</span>
                                        <span>{{ \Carbon\Carbon::parse($res->check_in)->translatedFormat('d M Y') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-amber-700">Tanggal Check-out</span>
                                        <span>{{ \Carbon\Carbon::parse($res->check_out)->translatedFormat('d M Y') }}</span>
                                    </div>

                                    @if (($ekstra['Extra Bed'] ?? 0) > 0)
                                        <div class="flex justify-between">
                                            <span class="text-amber-700">Layanan Extra (Bed)</span>
                                            <span class="text-amber-600 font-black">x{{ $ekstra['Extra Bed'] }}</span>
                                        </div>
                                    @endif
                                    @if (($ekstra['Extra Selimut'] ?? 0) > 0)
                                        <div class="flex justify-between">
                                            <span class="text-amber-700">Layanan Extra (Selimut)</span>
                                            <span
                                                class="text-amber-600 font-black">x{{ $ekstra['Extra Selimut'] }}</span>
                                        </div>
                                    @endif

                                    <div
                                        class="flex justify-between font-bold text-amber-600 pt-3 mt-3 border-t-2 border-amber-100">
                                        <span>Status Pembayaran</span>
                                        <span id="statusPaymentDisplay-{{ $res->id }}"
                                            class="uppercase tracking-wider">
                                            @if ($isPesananAktif)
                                                {{ $pembayaranAktif->status ?? $res->status_reservasi }}
                                            @else
                                                {{ $res->status_reservasi }}
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    @if ($isPesananAktif && isset($pembayaranAktif))
                                        <p class="text-[10px] text-amber-600 font-bold mb-1 uppercase tracking-wider">
                                            Nomor Pembayaran: <br><span
                                                class="text-amber-900">#{{ $pembayaranAktif->invoice }}</span></p>
                                    @endif
                                    <h3 class="text-lg font-black text-amber-950 border-b-2 border-amber-200 pb-4">
                                        Total Bayar : Rp. {{ number_format($ekstra['Total Bayar'] ?? 0, 0, ',', '.') }}
                                    </h3>
                                </div>

                                @if ($isPesananAktif && isset($ekstra['Metode Pembayaran']) && $ekstra['Metode Pembayaran'] === 'QRIS')
                                    <div class="flex flex-col flex-grow justify-end space-y-4">
                                        <div
                                            class="border-2 border-amber-200 rounded-2xl flex-grow min-h-[220px] flex items-center justify-center bg-white shadow-inner p-4">
                                            <div id="qrisContainer-{{ $res->id }}"
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
                                                        <h4 class="font-black text-green-700 text-xl">Pembayaran Lunas!
                                                        </h4>
                                                    </div>
                                                @elseif (isset($pembayaranAktif) && $pembayaranAktif->qr_image)
                                                    @php
                                                        $qrUrl =
                                                            'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=' .
                                                            urlencode($pembayaranAktif->qr_image);
                                                    @endphp
                                                    <div class="animate-fade-in flex flex-col items-center w-full">
                                                        <div class="mb-3 text-center w-full">
                                                            <p
                                                                class="text-[10px] text-amber-700 font-bold uppercase tracking-wider mb-1">
                                                                Status Batas Waktu:</p>
                                                            <div id="qrisTimer-{{ $res->id }}"
                                                                class="text-sm font-bold border border-amber-300 bg-amber-50 rounded-lg py-1 px-3 inline-block">
                                                                Menghitung Waktu...</div>
                                                        </div>
                                                        <img src="{{ $qrUrl }}" alt="QRIS"
                                                            class="w-44 h-44 object-contain shadow-sm border border-amber-200 rounded-xl bg-white p-2 mx-auto">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        @if (isset($pembayaranAktif) && $pembayaranAktif->qr_image && $pembayaranAktif->status !== 'berhasil')
                                            <button type="button"
                                                onclick="forceDownloadQR(this, '{!! $qrUrl !!}', '{{ $pembayaranAktif->invoice }}')"
                                                class="qris-download-btn-{{ $res->id }} mt-2 w-full bg-amber-100 hover:bg-amber-200 text-amber-900 border border-amber-400 font-bold py-3 px-4 rounded-xl text-sm transition shadow-sm flex items-center justify-center gap-2 text-center cursor-pointer relative z-50">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                                                    </path>
                                                </svg>
                                                <span class="btn-text">Download Kode QR</span>
                                            </button>
                                        @endif
                                    </div>
                                @else
                                    <div
                                        class="border-2 border-dashed border-amber-300 rounded-2xl flex-grow min-h-[200px] flex flex-col items-center justify-center bg-amber-50/50 p-4">
                                        <span
                                            class="text-4xl mb-2">{{ in_array($res->status_reservasi, ['Selesai', 'Batal', 'Dibatalkan']) ? '🧾' : '🏨' }}</span>
                                        <h4 class="font-bold text-amber-950 text-lg">
                                            {{ in_array($res->status_reservasi, ['Selesai', 'Batal', 'Dibatalkan']) ? 'Struk Terkunci' : 'Bayar di Tempat' }}
                                        </h4>
                                        <p class="text-sm text-amber-700/80 mt-1 text-center font-medium">
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

    @if ($isLoggedIn)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @foreach ($pembayaranAktifs as $pembayaranAktif)
                    @if ($pembayaranAktif->status === 'pending' && $pembayaranAktif->qr_image)
                        startPaymentCheck("{{ $pembayaranAktif->invoice }}", "{{ $pembayaranAktif->reservasi_id }}");
                        startCountdown("{{ $pembayaranAktif->expired_at }}", "{{ $pembayaranAktif->reservasi_id }}");
                    @endif
                @endforeach
            });
        </script>
    @endif

</x-lplayout>

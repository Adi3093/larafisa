<x-lplayout>
    <div class="absolute top-0 left-0 w-full h-64 bg-amber-600 z-0"></div>

    <div class="relative z-10 min-h-screen pt-24 lg:pt-32 pb-24 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">

        <div class="mb-8">
            <h1 class="text-white text-3xl font-extrabold tracking-tight">Riwayat & Reservasi Aktif</h1>
            <p class="text-amber-100 mt-1">Pantau perkembangan reservasi kamar Anda secara real-time.</p>
        </div>

        @if (session('success'))
            <div
                class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm font-bold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div
                class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm font-bold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        @if (!$isLoggedIn)
            <div class="bg-white rounded-3xl shadow-xl border border-amber-100 p-10 text-center">
                <div class="text-center py-16">
                        <span class="text-6xl block mb-6">🔐</span>
                        <h3 class="text-2xl font-black text-amber-950 mb-2">Login Diperlukan</h3>
                        <p class="text-base text-gray-500 max-w-md mx-auto leading-relaxed mb-8">Untuk melanjutkan
                            proses pemesanan kamar hotel, silakan masuk ke dalam akun Anda.</p>
                        <div class="flex flex-col sm:flex-row justify-center gap-3">
                            <a href="{{ route('login') }}"
                                class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-md shadow-amber-600/30">Log
                                In Sekarang</a>
                            <a href="{{ route('register') }}"
                                class="bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold py-3 px-8 rounded-xl border border-amber-200 transition">Daftar
                                Akun Baru</a>
                        </div>
                    </div>
            </div>
        @else
            @php
                $tabPembayaran = collect();
                $tabKonfirmasi = collect();
                $tabCheckin = collect();
                $tabCheckout = collect();

                $waktuSekarang = \Carbon\Carbon::now('Asia/Jakarta');

                foreach ($pesananAktifs as $pesanan) {
                    $status = $pesanan->status_reservasi;

                    if (in_array($status, ['Menunggu Konfirmasi', 'Terlewat'])) {
                        $tabPembayaran->push($pesanan);
                    } elseif ($status === 'Terkonfirmasi') {
                        $tabKonfirmasi->push($pesanan);
                    } elseif ($status === 'Check-In') {
                        $waktuCheckout = \Carbon\Carbon::parse($pesanan->check_out, 'Asia/Jakarta');
                        if ($waktuSekarang->greaterThanOrEqualTo($waktuCheckout)) {
                            $tabCheckout->push($pesanan);
                        } else {
                            $tabCheckin->push($pesanan);
                        }
                    }
                }

                $activeTab = 'riwayat';
                if (!request()->has('page') && !request()->has('per_page')) {
                    if ($pesananAktifs->isNotEmpty()) {
                        $firstPesanan = $pesananAktifs->first();
                        $s = $firstPesanan->status_reservasi;

                        if (in_array($s, ['Menunggu Konfirmasi', 'Terlewat'])) {
                            $activeTab = 'pembayaran';
                        } elseif ($s === 'Terkonfirmasi') {
                            $activeTab = 'konfirmasi';
                        } elseif ($s === 'Check-In') {
                            $waktuCheckoutFirst = \Carbon\Carbon::parse($firstPesanan->check_out, 'Asia/Jakarta');
                            if ($waktuSekarang->greaterThanOrEqualTo($waktuCheckoutFirst)) {
                                $activeTab = 'checkout';
                            } else {
                                $activeTab = 'checkin';
                            }
                        }
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
                                d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3" />
                        </svg>
                        <span class="text-[9px] sm:text-xs font-bold truncate w-full text-center px-0.5">Check-in</span>
                    </button>
                    <button @click="tab = 'checkout'"
                        :class="tab === 'checkout' ? 'bg-amber-100 text-amber-800 shadow-inner' :
                            'text-gray-500 hover:bg-amber-50 hover:text-amber-700'"
                        class="flex-1 py-3 sm:py-4 transition-all duration-300 flex flex-col items-center gap-1 sm:gap-2 border-l border-gray-100">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9" />
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

                <div class="p-4 sm:p-8 min-h-[400px] overflow-hidden">
                    @php
                        $renderActiveCard = function ($pesananData) use ($pembayaranAktifs) {
                            if (!$pesananData) {
                                return '';
                            }
                            
                            $fotoKamar = $pesananData->kamar?->kelasKamar?->thumbnail
                                ? asset('storage/' . $pesananData->kamar->kelasKamar->thumbnail)
                                : asset('storage/landingpage/room-placeholder.jpg');

                            $pembayaranItem = $pembayaranAktifs[$pesananData->id] ?? null;
                            $sudahGenerateQris = $pembayaranItem && !empty($pembayaranItem->qr_image);
                            $bisaDihapus =
                                !$sudahGenerateQris &&
                                in_array($pesananData->status_reservasi, ['Menunggu Konfirmasi', 'Terlewat']);

                            $pillClass = match ($pesananData->status_reservasi) {
                                'Batal', 'Dibatalkan' => 'text-red-700 border-red-500 bg-red-50',
                                'Terlewat' => 'text-amber-700 border-amber-500 bg-amber-50',
                                default => 'text-emerald-700 border-emerald-500 bg-emerald-50',
                            };

                            $deleteFormHtml = '';
                            $deleteBtnDesktop = ''; 
                            
                            if ($bisaDihapus) {
                                $deleteFormHtml = '
                                <div class="absolute inset-0 bg-red-500 flex items-center justify-end px-6 rounded-2xl sm:rounded-3xl z-0">
                                    <span class="text-white font-bold flex flex-col items-center text-xs">
                                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Hapus
                                    </span>
                                </div>
                                <form id="form-hapus-' . $pesananData->id . '" action="' . route('reservasi.tamu.batal', $pesananData->id) . '" method="POST" class="hidden">
                                    ' . csrf_field() . method_field('PUT') . '
                                </form>';
                                
                                $deleteBtnDesktop = '
                                <button type="button" onclick="event.stopPropagation(); triggerDeleteMobile(\'' . $pesananData->id . '\')" class="hidden sm:flex absolute top-3 right-3 w-8 h-8 items-center justify-center bg-red-50 text-red-500 border border-red-200 rounded-full hover:bg-red-500 hover:text-white transition-colors z-20 shadow-sm" title="Batalkan Reservasi">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>';
                            }

                            return '
                            <div class="relative overflow-hidden rounded-2xl sm:rounded-3xl mb-4 group swipe-container bg-red-50" data-id="' . $pesananData->id . '" data-can-delete="' . ($bisaDihapus ? 'true' : 'false') . '">
                                ' . $deleteFormHtml . '
                                
                                <div class="swipe-element relative z-10 bg-white border sm:border-2 border-amber-200 rounded-2xl sm:rounded-3xl p-3 sm:p-5 flex flex-row gap-3 sm:gap-6 items-stretch transition-transform duration-300 ease-out cursor-pointer hover:border-amber-400 hover:shadow-lg shadow-sm"
                                    onclick="if(!this.classList.contains(\'swiping\')) document.getElementById(\'modalDetail-' . $pesananData->id . '\').classList.remove(\'hidden\')">
                                    
                                    ' . $deleteBtnDesktop . '
                                    
                                    <div class="w-24 sm:w-40 rounded-xl overflow-hidden flex-shrink-0 relative shadow-inner bg-gray-50">
                                        <img src="' . $fotoKamar . '" class="absolute inset-0 w-full h-full object-cover ' . ($pesananData->status_reservasi == 'Selesai' || $pesananData->status_reservasi == 'Batal' || $pesananData->status_reservasi == 'Dibatalkan' ? 'grayscale-[20%]' : '') . '">
                                    </div>
                                    
                                    <div class="flex-1 min-w-0 flex flex-col justify-center py-1">
                                        <div class="mb-3 pr-6">
                                            <h3 class="text-sm sm:text-xl font-black text-amber-950 leading-tight line-clamp-2 mb-1">' . ($pesananData->kamar?->kelasKamar?->nama_kelas ?? 'Tipe Kamar') . '</h3>
                                            
                                            <span id="card-badge-' . $pesananData->id . '" class="inline-block border px-2 py-0.5 rounded text-[8px] sm:text-[10px] font-black uppercase tracking-wider transition-colors duration-300 ' . $pillClass . '">' . $pesananData->status_reservasi . '</span>
                                        </div>
                                        
                                        <div class="space-y-1 sm:space-y-2 mt-auto">
                                            <div class="flex items-center gap-2">
                                                <span class="text-[9px] sm:text-xs font-bold text-gray-500 uppercase tracking-wider w-[55px] sm:w-20 shrink-0">Check-in</span>
                                                <span class="text-[10px] sm:text-sm font-black text-amber-950 whitespace-nowrap">' . \Carbon\Carbon::parse($pesananData->check_in)->format('d M Y, H:i') . '</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-[9px] sm:text-xs font-bold text-gray-500 uppercase tracking-wider w-[55px] sm:w-20 shrink-0">Check-out</span>
                                                <span class="text-[10px] sm:text-sm font-black text-amber-950 whitespace-nowrap">' . \Carbon\Carbon::parse($pesananData->check_out)->format('d M Y, H:i') . '</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        };
                    @endphp

                    <div x-show="tab === 'pembayaran'" x-cloak class="animate-fade-in space-y-2 sm:space-y-4">
                        @forelse($tabPembayaran as $pesan)
                            {!! $renderActiveCard($pesan) !!}
                        @empty
                            <div class="text-center py-16">
                                <div
                                    class="w-20 h-20 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-extrabold text-amber-950">Belum Ada Tagihan</h3>
                                <p class="text-gray-500 text-sm mt-2">Semua tagihan Anda sudah dibayar atau tidak ada
                                    pesanan tertunda.</p>
                            </div>
                        @endforelse
                    </div>
                    
                    <div x-show="tab === 'konfirmasi'" x-cloak class="animate-fade-in space-y-2 sm:space-y-4">
                        @forelse($tabKonfirmasi as $pesan)
                            {!! $renderActiveCard($pesan) !!}
                        @empty
                            <div class="text-center py-16">
                                <div
                                    class="w-20 h-20 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg></div>
                                <h3 class="text-lg font-extrabold text-amber-950">Tidak Ada Antrean Konfirmasi</h3>
                            </div>
                        @endforelse
                    </div>

                    <div x-show="tab === 'checkin'" x-cloak class="animate-fade-in space-y-2 sm:space-y-4">
                        @forelse($tabCheckin as $pesan)
                            {!! $renderActiveCard($pesan) !!}
                        @empty
                            <div class="text-center py-16">
                                <div
                                    class="w-20 h-20 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3" />
                                    </svg></div>
                                <h3 class="text-lg font-extrabold text-amber-950">Belum Ada Jadwal Check-In</h3>
                            </div>
                        @endforelse
                    </div>

                    <div x-show="tab === 'checkout'" x-cloak class="animate-fade-in space-y-2 sm:space-y-4">
                        @forelse($tabCheckout as $pesan)
                            {!! $renderActiveCard($pesan) !!}
                        @empty
                            <div class="text-center py-16">
                                <div
                                    class="w-20 h-20 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9" />
                                    </svg></div>
                                <h3 class="text-lg font-extrabold text-amber-950">Belum Waktunya Check-Out</h3>
                            </div>
                        @endforelse
                    </div>

                    <div x-show="tab === 'riwayat'" x-cloak class="animate-fade-in space-y-2 sm:space-y-4">
                        @forelse($arsipReservasi as $history)
                            {!! $renderActiveCard($history) !!}
                        @empty
                            <div
                                class="text-center py-16 border-2 border-dashed border-amber-200 bg-amber-50/50 rounded-3xl">
                                <div
                                    class="w-20 h-20 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg></div>
                                <h3 class="text-lg font-extrabold text-amber-950">Belum Ada Riwayat</h3>
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
                $isQrisRequested = isset($pembayaranAktif) && $pembayaranAktif->qr_image;
                
                $metode = $ekstra['Metode Pembayaran'] ?? 'Bayar di Tempat';
                $invoiceNo = '-';
                if ($metode === 'QRIS') {
                    if (isset($pembayaranAktif) && !empty($pembayaranAktif->invoice)) {
                        $invoiceNo = '#' . $pembayaranAktif->invoice;
                    } elseif (isset($res->pembayaran) && !empty($res->pembayaran->invoice)) {
                        $invoiceNo = '#' . $res->pembayaran->invoice;
                    }
                }
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
                                    class="hidden text-amber-600 hover:text-amber-900 transition"><svg class="w-6 h-6"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg></button>
                                <button type="button"
                                    onclick="document.getElementById('modalDetail-{{ $res->id }}').classList.add('hidden'); closeMobileWizard('{{ $res->id }}');"
                                    class="text-amber-500 hover:text-red-500 transition"><svg class="w-6 h-6"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg></button>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row bg-white">
                            <div id="infoPanel-{{ $res->id }}" class="w-full md:w-1/2 p-6 block">
                                <div class="mb-6">
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

                                @if (in_array($res->status_reservasi, ['Menunggu Konfirmasi', 'Terlewat']))
                                    <div id="formReschedule-{{ $res->id }}" class="mb-6"
                                        data-checkin-time="{{ \Carbon\Carbon::parse($res->check_in)->toIso8601String() }}"
                                        data-status="{{ $res->status_reservasi }}" data-id="{{ $res->id }}"
                                        data-qris-generated="{{ $isQrisRequested ? 'true' : 'false' }}">
                                        <div class="border-b-2 border-amber-100 pb-2 mb-4">
                                            <h4 class="text-lg font-black text-amber-900">Ubah Jadwal Menginap</h4>
                                        </div>

                                        @if ($isQrisRequested)
                                            <div
                                                class="p-3 bg-red-50 border border-red-200 text-red-700 text-xs font-bold rounded-xl text-center shadow-inner mb-4">
                                                🔒 Jadwal telah terkunci karena QRIS pembayaran sudah diminta.
                                            </div>
                                        @else
                                            <div id="warningTerlewat-{{ $res->id }}"
                                                class="{{ $res->status_reservasi === 'Terlewat' ? 'block' : 'hidden' }} mb-4 p-3 bg-red-50 border border-red-300 text-red-700 text-xs font-bold rounded-xl shadow-sm">
                                                ⚠️ Waktu Check-in terlewat! Segera sesuaikan waktu check-in Anda minimal
                                                pada jam saat ini.
                                            </div>

                                            <form id="formRescheduleEl-{{ $res->id }}"
                                                action="{{ route('reservasi.tamu.update', $res->id) }}"
                                                method="POST" class="space-y-4"
                                                data-confirm="Simpan Perubahan Jadwal?|Apakah Anda yakin ingin menyimpan perubahan jadwal ini?"
                                                data-theme="amber" data-btn="Ya, Simpan">
                                                @csrf
                                                @method('PUT')
                                                <div>
                                                    <label
                                                        class="text-[10px] font-bold text-amber-700 uppercase tracking-wider mb-1 block">CHECK-IN:</label>
                                                    <div class="flex items-center gap-2">
                                                        <input type="datetime-local" id="checkin-{{ $res->id }}"
                                                            name="check_in"
                                                            min="{{ \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d\TH:i') }}"
                                                            value="{{ \Carbon\Carbon::parse($res->check_in)->format('Y-m-d\TH:i') }}"
                                                            class="flex-1 text-sm border-amber-300 font-medium rounded-lg focus:ring-amber-600 focus:border-amber-600 shadow-sm px-3 py-2"
                                                            required>
                                                        <button type="button"
                                                            onclick="adjustDateRiwayat('checkin-{{ $res->id }}', -1)"
                                                            class="px-3 py-2 bg-white border border-amber-300 rounded-lg text-amber-700 hover:bg-amber-50 font-bold shadow-sm">&lt;</button>
                                                        <button type="button"
                                                            onclick="adjustDateRiwayat('checkin-{{ $res->id }}', 1)"
                                                            class="px-3 py-2 bg-white border border-amber-300 rounded-lg text-amber-700 hover:bg-amber-50 font-bold shadow-sm">&gt;</button>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label
                                                        class="text-[10px] font-bold text-amber-700 uppercase tracking-wider mb-1 block">CHECK
                                                        OUT:</label>
                                                    <div class="flex items-center gap-2">
                                                        <input type="datetime-local"
                                                            id="checkout-{{ $res->id }}" name="check_out"
                                                            value="{{ \Carbon\Carbon::parse($res->check_out)->format('Y-m-d\TH:i') }}"
                                                            class="flex-1 text-sm border-amber-300 font-medium rounded-lg focus:ring-amber-600 focus:border-amber-600 shadow-sm px-3 py-2"
                                                            required>
                                                        <button type="button"
                                                            onclick="adjustDateRiwayat('checkout-{{ $res->id }}', -1)"
                                                            class="px-3 py-2 bg-white border border-amber-300 rounded-lg text-amber-700 hover:bg-amber-50 font-bold shadow-sm">&lt;</button>
                                                        <button type="button"
                                                            onclick="adjustDateRiwayat('checkout-{{ $res->id }}', 1)"
                                                            class="px-3 py-2 bg-white border border-amber-300 rounded-lg text-amber-700 hover:bg-amber-50 font-bold shadow-sm">&gt;</button>
                                                    </div>
                                                </div>
                                                <button type="button"
                                                    onclick="validateRescheduleTime('{{ $res->id }}')"
                                                    class="w-full py-3 bg-amber-100 hover:bg-amber-200 text-amber-900 border border-amber-300 font-bold rounded-xl text-sm transition shadow-sm border-none mt-2">
                                                    Simpan Perubahan Jadwal
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endif

                                <div class="mb-6">
                                    <p class="text-sm font-medium text-amber-700">Kelas Kamar : <span
                                            class="font-bold text-amber-950">{{ $res->kamar?->kelasKamar?->nama_kelas ?? '-' }}</span>
                                    </p>
                                </div>

                                <div>
                                    <div class="border-b-2 border-amber-100 pb-2 mb-3">
                                        <h4 class="text-lg font-black text-amber-900">Layanan Ekstra</h4>
                                    </div>
                                    <div class="space-y-1 text-sm text-amber-950 font-medium">
                                        <p>Extra Bed <span
                                                class="text-amber-600 font-black">x{{ $ekstra['Extra Bed'] ?? 0 }}</span>
                                        </p>
                                        <p>Extra Selimut <span
                                                class="text-amber-600 font-black">x{{ $ekstra['Extra Selimut'] ?? 0 }}</span>
                                        </p>
                                    </div>
                                </div>

                                <button type="button" onclick="openMobileWizard('{{ $res->id }}')"
                                    class="w-full md:hidden py-3 bg-amber-50 border border-amber-300 text-amber-800 font-bold rounded-xl shadow-sm hover:bg-amber-100 transition mt-6 border-none">
                                    Lihat Pembayaran
                                </button>
                            </div>

                            <div id="paymentPanel-{{ $res->id }}"
                                class="w-full md:w-1/2 md:border-l-2 md:border-amber-100 p-6 flex-col h-full bg-gradient-to-b from-amber-50/50 to-white hidden md:flex">
                                <div class="border-b-2 border-amber-100 pb-2 mb-4 hidden md:block">
                                    <h4 class="text-xl font-black text-amber-900">Detail Pembayaran</h4>
                                </div>

                                <div class="space-y-2 text-sm text-amber-950 font-medium mb-6">
                                    <div class="flex justify-between">
                                        <span class="text-amber-700">Kelas Kamar</span>
                                        <span class="text-right">{{ $res->kamar?->kelasKamar?->nama_kelas ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-amber-700">Tanggal Check-in</span>
                                        <span class="text-right">{{ \Carbon\Carbon::parse($res->check_in)->translatedFormat('d M Y') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-amber-700">Tanggal Check-out</span>
                                        <span class="text-right">{{ \Carbon\Carbon::parse($res->check_out)->translatedFormat('d M Y') }}</span>
                                    </div>
                                    
                                    <div class="flex justify-between pt-3 mt-3 border-t-2 border-amber-100">
                                        <span class="text-amber-700">Metode Pembayaran</span>
                                        <span class="text-right uppercase">{{ $metode }}</span>
                                    </div>

                                    <div class="flex justify-between font-bold text-amber-600">
                                        <span>Status Pembayaran</span>
                                        <span id="statusPaymentDisplay-{{ $res->id }}"
                                            class="uppercase tracking-wider text-right {{ $res->status_reservasi === 'Terlewat' ? 'text-red-600 font-bold animate-pulse' : '' }}">
                                            {{ $res->status_reservasi === 'Terlewat' ? 'TERLEWAT' : ($isPesananAktif ? $pembayaranAktif->status ?? $res->status_reservasi : $res->status_reservasi) }}
                                        </span>
                                    </div>
                                    
                                    <div class="flex justify-between">
                                        <span class="text-amber-700">Kode Pembayaran</span>
                                        <span class="text-right font-bold text-amber-900">{{ $invoiceNo }}</span>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <h3 class="text-lg font-black text-amber-950 border-b-2 border-amber-200 pb-4">
                                        Total Bayar : Rp. {{ number_format($ekstra['Total Bayar'] ?? 0, 0, ',', '.') }}
                                    </h3>
                                </div>

                                @if ($isPesananAktif && isset($ekstra['Metode Pembayaran']) && $ekstra['Metode Pembayaran'] === 'QRIS')
                                    <div class="flex flex-col flex-grow justify-end space-y-4">
                                        <div
                                            class="border-2 border-amber-200 rounded-2xl flex-grow min-h-[220px] flex items-center justify-center bg-white shadow-sm p-6 flex-col text-center">

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
                                                @elseif ($isQrisRequested)
                                                    @php $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=' . urlencode($pembayaranAktif->qr_image); @endphp
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
                                                @else
                                                    <div id="qrisPlaceholder-{{ $res->id }}"
                                                        class="flex flex-col items-center w-full {{ $res->status_reservasi === 'Terlewat' ? 'hidden' : 'flex' }}">
                                                        <div
                                                            class="w-16 h-16 mb-4 text-amber-500 bg-amber-50 rounded-xl p-3 border border-amber-200">
                                                            <svg fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24" stroke-width="2"
                                                                class="w-full h-full">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                        <p
                                                            class="text-[11px] font-bold text-amber-900 mb-5 leading-relaxed">
                                                            Klik tombol di bawah ini untuk memunculkan <br>kode QRIS dan
                                                            mengunci jadwal reservasi.
                                                        </p>
                                                        <button type="button" id="btnGenQris-{{ $res->id }}"
                                                            onclick="triggerQrisConfirm('{{ $res->id }}', '{{ route('guest.generate.qris', $res->id) }}')"
                                                            class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition transform hover:-translate-y-0.5 border-none text-sm w-full">
                                                            Generate QRIS
                                                        </button>
                                                    </div>

                                                    <div id="boxQrisTerlewat-{{ $res->id }}"
                                                        class="flex-col items-center w-full {{ $res->status_reservasi === 'Terlewat' ? 'flex' : 'hidden' }}">
                                                        <div
                                                            class="w-16 h-16 mb-4 mx-auto text-red-500 bg-red-50 rounded-xl p-3 border border-red-200">
                                                            <svg fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24" stroke-width="2"
                                                                class="w-full h-full">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                        <p
                                                            class="text-[11px] font-bold text-red-700 mb-2 leading-relaxed">
                                                            Waktu Check-in Anda sudah terlewat! <br> Silakan Ubah Jadwal
                                                            Anda (Reschedule) terlebih dahulu di kotak sebelah kiri.
                                                        </p>
                                                    </div>

                                                    <div id="qrisActive-{{ $res->id }}" class="hidden w-full">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div id="qrisDownloadContainer-{{ $res->id }}"
                                            class="{{ $isQrisRequested && $pembayaranAktif->status !== 'berhasil' ? 'block' : 'hidden' }}">
                                            @if ($isQrisRequested && $pembayaranAktif->status !== 'berhasil')
                                                <button type="button"
                                                    onclick="forceDownloadQR(this, '{!! $qrUrl !!}', '{{ $pembayaranAktif->invoice }}')"
                                                    class="qris-download-btn-{{ $res->id }} mt-2 w-full bg-amber-100 hover:bg-amber-200 text-amber-900 border border-amber-400 font-bold py-3 px-4 rounded-xl text-sm transition shadow-sm flex items-center justify-center gap-2 text-center cursor-pointer relative z-50 border-none">
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

    <link rel="stylesheet" href="{{ asset('css/hriwayat.css') }}?v={{ time() }}">
    <script src="{{ asset('js/landingpage/hriwayat.js') }}?v={{ time() }}"></script>

    @if ($isLoggedIn)
        <script>
            window.initialReservations = @json($pesananAktifs->pluck('status_reservasi', 'id'));

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
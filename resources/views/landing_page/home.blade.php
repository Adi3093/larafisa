<x-lplayout>
    <section class="relative bg-amber-50 pt-32 pb-48 lg:pt-40 lg:pb-56 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('storage/landingpage/herobg.png') }}" alt="Hotel View"
                class="w-full h-full object-cover object-center" />
            <div class="absolute inset-0 bg-gradient-to-r from-amber-50/95 via-amber-50/70 to-transparent"></div>
        </div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-left flex flex-col justify-between h-full">
            <div>
                <h1 class="text-4xl font-extrabold tracking-tight text-amber-950 sm:text-5xl lg:text-6xl max-w-2xl">
                    Pengalaman Menginap <br>
                    <span class="text-amber-600">Tak Terlupakan</span>
                </h1>
                <p class="mt-4 text-sm sm:text-lg text-amber-900/80 font-medium max-w-xl leading-relaxed">
                    Pilih kamar impian Anda dan nikmati fasilitas yang dirancang khusus untuk kenyamanan Anda dan
                    keluarga.
                </p>
            </div>

            <!-- FIX: KOTAK FASILITAS DIPERKECIL DI MOBILE (w-[105px]) AGAR TIDAK KRAM -->
            <div class="mt-10 lg:mt-16 w-full">
                <div
                    class="flex overflow-x-auto gap-3 sm:gap-6 pb-4 snap-x snap-mandatory [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                    <div
                        class="flex-none w-[105px] sm:w-44 lg:w-48 snap-center bg-white/60 backdrop-blur-md p-3 sm:p-4 rounded-2xl border border-white text-center hover:bg-white/80 transition shadow-sm">
                        <div
                            class="w-10 h-10 sm:w-14 sm:h-14 mx-auto bg-amber-600 text-white rounded-full flex items-center justify-center mb-2 sm:mb-3 shadow-md shadow-amber-600/20">
                            <svg class="w-5 h-5 sm:w-7 sm:h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0">
                                </path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-amber-950 text-[11px] sm:text-sm leading-tight">Wifi Area</h3>
                    </div>
                    <div
                        class="flex-none w-[105px] sm:w-44 lg:w-48 snap-center bg-white/60 backdrop-blur-md p-3 sm:p-4 rounded-2xl border border-white text-center hover:bg-white/80 transition shadow-sm">
                        <div
                            class="w-10 h-10 sm:w-14 sm:h-14 mx-auto bg-amber-600 text-white rounded-full flex items-center justify-center mb-2 sm:mb-3 shadow-md shadow-amber-600/20">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="w-5 h-5 sm:w-7 sm:h-7">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M9 17V7h4a3 3 0 0 1 0 6H9" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-amber-950 text-[11px] sm:text-sm leading-tight">Free Parking</h3>
                    </div>
                    <div
                        class="flex-none w-[105px] sm:w-44 lg:w-48 snap-center bg-white/60 backdrop-blur-md p-3 sm:p-4 rounded-2xl border border-white text-center hover:bg-white/80 transition shadow-sm">
                        <div
                            class="w-10 h-10 sm:w-14 sm:h-14 mx-auto bg-amber-600 text-white rounded-full flex items-center justify-center mb-2 sm:mb-3 shadow-md shadow-amber-600/20">
                            <svg class="w-5 h-5 sm:w-7 sm:h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-amber-950 text-[11px] sm:text-sm leading-tight">Keamanan 24 Jam</h3>
                    </div>
                    <div
                        class="flex-none w-[105px] sm:w-44 lg:w-48 snap-center bg-white/60 backdrop-blur-md p-3 sm:p-4 rounded-2xl border border-white text-center hover:bg-white/80 transition shadow-sm">
                        <div
                            class="w-10 h-10 sm:w-14 sm:h-14 mx-auto bg-amber-600 text-white rounded-full flex items-center justify-center mb-2 sm:mb-3 shadow-md shadow-amber-600/20">
                            <svg class="w-5 h-5 sm:w-7 sm:h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-amber-950 text-[11px] sm:text-sm leading-tight">Pelayanan 24 Jam</h3>
                    </div>
                    <div
                        class="flex-none w-[105px] sm:w-44 lg:w-48 snap-center bg-white/60 backdrop-blur-md p-3 sm:p-4 rounded-2xl border border-white text-center hover:bg-white/80 transition shadow-sm">
                        <div
                            class="w-10 h-10 sm:w-14 sm:h-14 mx-auto bg-amber-600 text-white rounded-full flex items-center justify-center mb-2 sm:mb-3 shadow-md shadow-amber-600/20">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="w-5 h-5 sm:w-7 sm:h-7">
                                <path d="m16 2-2.3 2.3a3 3 0 0 0 0 4.2l1.8 1.8a3 3 0 0 0 4.2 0L22 8" />
                                <path d="M15 15 3.3 3.3a4.2 4.2 0 0 0 0 6l7.3 7.3c.7.7 2 .7 2.8 0L15 15Zm0 0 7 7" />
                                <path d="m2.1 21.8 6.4-6.3" />
                                <path d="m19 5-7 7" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-amber-950 text-[11px] sm:text-sm leading-tight">Free Sarapan</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FIX: PENAMBAHAN MIN-W-0 PADA INPUT AGAR TIDAK MELUBER & MERUSAK GRID DESKTOP -->
    <div
        class="relative z-40 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 lg:-mt-24 mb-10 lg:mb-16 transition-all duration-300">
        <div
            class="bg-white/95 backdrop-blur-md rounded-2xl shadow-xl shadow-amber-900/5 border border-amber-100 p-4 sm:p-8">
            <form id="formFilterKamar" method="GET" action="{{ url('/') }}#kamar"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-5 items-end">

                <div class="w-full">
                    <label class="block text-xs sm:text-sm font-bold text-amber-950 mb-1 sm:mb-2">Check-in (WIB)</label>
                    <div
                        class="flex border border-amber-200 rounded-lg overflow-hidden shadow-sm bg-amber-50/50 focus-within:ring-1 focus-within:border-amber-500 transition">
                        <input type="datetime-local" id="filter_checkin" name="filter_checkin"
                            value="{{ request('filter_checkin', date('Y-m-d\TH:i')) }}"
                            class="flex-1 min-w-0 border-none p-2 sm:p-2.5 text-[12px] sm:text-sm bg-transparent text-amber-950 focus:ring-0 cursor-pointer"
                            required onchange="syncMinCheckoutHome()">
                        <button type="button" onclick="adjustDateHome('filter_checkin', -1)"
                            class="px-2.5 sm:px-3 bg-white border-l border-r border-amber-200 hover:bg-amber-100 text-amber-700 font-black transition">&lt;</button>
                        <button type="button" onclick="adjustDateHome('filter_checkin', 1)"
                            class="px-2.5 sm:px-3 bg-white hover:bg-amber-100 text-amber-700 font-black transition">&gt;</button>
                    </div>
                </div>

                <div class="w-full">
                    <label class="block text-xs sm:text-sm font-bold text-amber-950 mb-1 sm:mb-2">Check-out</label>
                    <div
                        class="flex border border-amber-200 rounded-lg overflow-hidden shadow-sm bg-amber-50/50 focus-within:ring-1 focus-within:border-amber-500 transition">
                        <input type="datetime-local" id="filter_checkout" name="filter_checkout"
                            value="{{ request('filter_checkout', date('Y-m-d\T11:00', strtotime('+1 day'))) }}"
                            class="flex-1 min-w-0 border-none p-2 sm:p-2.5 text-[12px] sm:text-sm bg-transparent text-amber-950 focus:ring-0 cursor-pointer"
                            required onchange="syncMinCheckoutHome()">
                        <button type="button" onclick="adjustDateHome('filter_checkout', -1)"
                            class="px-2.5 sm:px-3 bg-white border-l border-r border-amber-200 hover:bg-amber-100 text-amber-700 font-black transition">&lt;</button>
                        <button type="button" onclick="adjustDateHome('filter_checkout', 1)"
                            class="px-2.5 sm:px-3 bg-white hover:bg-amber-100 text-amber-700 font-black transition">&gt;</button>
                    </div>
                </div>

                <div class="w-full">
                    <label class="block text-xs sm:text-sm font-bold text-amber-950 mb-1 sm:mb-2">Jumlah
                        Penginap</label>
                    <div
                        class="flex border border-amber-200 rounded-lg overflow-hidden shadow-sm bg-amber-50/50 transition">
                        <input type="text" id="display_penginap" value="{{ request('filter_tamu', 1) }} Orang"
                            readonly
                            class="flex-1 min-w-0 border-none text-center p-2 sm:p-2.5 text-[12px] sm:text-sm font-bold text-amber-950 bg-transparent focus:ring-0 cursor-default">
                        <input type="hidden" id="filter_tamu" name="filter_tamu"
                            value="{{ request('filter_tamu', 1) }}">
                        <button type="button" onclick="adjustPenginap(-1)"
                            class="px-3 sm:px-4 bg-white border-l border-amber-200 hover:bg-amber-100 text-amber-700 font-black transition">&lt;</button>
                        <button type="button" onclick="adjustPenginap(1)"
                            class="px-3 sm:px-4 bg-white border-l border-amber-200 hover:bg-amber-100 text-amber-700 font-black transition">&gt;</button>
                    </div>
                </div>

                <div class="w-full mt-2 lg:mt-0">
                    <button type="submit"
                        class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 sm:py-3 rounded-lg transition shadow-md shadow-amber-600/30 text-sm sm:text-base border-none">
                        Cek Kamar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="kamar" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-10 scroll-mt-32">
        <div class="text-center mb-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-amber-950 mb-3">Katalog Tipe Kamar</h2>
            <div class="w-16 h-1 bg-amber-500 mx-auto rounded"></div>

            @if (request()->has('filter_checkin'))
                <div id="indikator-pencarian" class="mt-4">
                    <p
                        class="text-sm text-amber-700 font-medium bg-amber-50 inline-block px-4 py-1.5 rounded-full border border-amber-200">
                        Kamar tersedia:
                        <strong>{{ \Carbon\Carbon::parse(request('filter_checkin'))->translatedFormat('d M Y - H:i') }}
                            WIB</strong> s/d
                        <strong>{{ \Carbon\Carbon::parse(request('filter_checkout'))->translatedFormat('d M Y - H:i') }}
                            WIB</strong>
                    </p>
                    <button onclick="resetFilter()"
                        class="block mx-auto mt-2 text-xs text-amber-600 font-bold hover:underline cursor-pointer">
                        Reset Pencarian
                    </button>
                </div>
            @endif
        </div>

        @php
            $checkinReq = request('filter_checkin', date('Y-m-d\TH:i'));
            $checkoutReq = request('filter_checkout', date('Y-m-d\T11:00', strtotime('+1 day')));
            $tamuReq = (int) request('filter_tamu', 1);
            $checkinDate = \Carbon\Carbon::parse($checkinReq);
            $checkoutDate = \Carbon\Carbon::parse($checkoutReq);
            $filteredKelas = collect();

            foreach ($kelasKamars as $kelas) {
                $fasilitasArray = is_array($kelas->fasilitas)
                    ? $kelas->fasilitas
                    : json_decode($kelas->fasilitas, true) ?? [];
                $teksPencarian = strtolower($kelas->nama_kelas . ' ' . implode(' ', $fasilitasArray));
                $isSingle = preg_match('/single/i', $teksPencarian);
                $isDouble = preg_match('/(double|twin|queen|king|besar)/i', $teksPencarian);

                if (request()->has('filter_checkin')) {
                    if ($tamuReq == 1) {
                        if (!$isSingle) {
                            continue;
                        }
                    } else {
                        if (!$isSingle && !$isDouble) {
                            continue;
                        }
                    }
                }

                $totalKamarFisik = $kelas->kamars()->where('status', '!=', 'Maintenance')->count();
                $terpakai = \App\Models\Reservasi::whereIn('status_reservasi', ['Terkonfirmasi', 'Check-In'])
                    ->whereHas('kamar', function ($q) use ($kelas) {
                        $q->where('kelas_kamar_id', $kelas->id);
                    })
                    ->where('check_in', '<', $checkoutDate)
                    ->where('check_out', '>', $checkinDate)
                    ->distinct('kamar_id')
                    ->count('kamar_id');

                $sisa = max(0, $totalKamarFisik - $terpakai);
                if ($sisa > 0) {
                    $kelas->sisa_kamar_riil = $sisa;
                    $filteredKelas->push($kelas);
                }
            }
        @endphp

        @if (request()->has('filter_checkin') && $tamuReq >= 3 && !$filteredKelas->isEmpty())
            <div
                class="max-w-3xl mx-auto bg-blue-50 border border-blue-200 text-blue-800 p-5 rounded-xl mb-6 flex items-start gap-4 shadow-sm mt-6">
                <svg class="w-8 h-8 text-blue-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-left">
                    <h4 class="font-bold text-blue-900">Rekomendasi Pemesanan ({{ $tamuReq }} Penginap)</h4>
                    <p class="text-sm mt-1 leading-relaxed">Berdasarkan jumlah orang yang Anda pilih, kami menyarankan
                        Anda untuk menambahkan <strong>Layanan Extra Bed</strong> di Menu Reservasi nanti, atau memesan
                        <strong>2 kamar terpisah</strong> agar istirahat keluarga Anda tetap nyaman maksimal.
                    </p>
                </div>
            </div>
        @endif

        <div id="katalog-asli">
            @if ($filteredKelas->isEmpty())
                <div
                    class="text-center text-amber-800 py-12 bg-white rounded-2xl border border-amber-100 shadow-sm mt-4">
                    <p>Maaf, tidak ada tipe kelas kamar yang tersedia pada rentang waktu tersebut.</p>
                    <button onclick="resetFilter()" class="mt-4 text-amber-600 font-bold hover:underline">Reset
                        Pencarian</button>
                </div>
            @else
                <div
                    class="flex overflow-x-auto gap-4 sm:gap-6 pb-8 pt-4 snap-x snap-mandatory [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                    @foreach ($filteredKelas as $kelas)
                        <div
                            class="kamar-card w-[85vw] sm:w-[320px] lg:w-[360px] flex-none snap-center bg-white rounded-2xl shadow-md shadow-stone-200/50 border border-stone-100 overflow-hidden hover:shadow-xl hover:shadow-amber-900/10 transition duration-300 flex flex-col">
                            <div class="relative h-48 sm:h-56 overflow-hidden bg-amber-100">
                                <img src="{{ asset('storage/' . $kelas->thumbnail) }}" alt="{{ $kelas->nama_kelas }}"
                                    class="w-full h-full object-cover hover:scale-105 transition duration-500">
                            </div>
                            <div class="p-5 flex flex-col flex-grow">
                                <h3 class="text-xl sm:text-2xl font-black text-amber-950 mb-1">
                                    {{ $kelas->nama_kelas }}</h3>
                                <div class="text-xs text-amber-800/70 mb-1 mt-auto pt-3">Mulai dari</div>
                                <div class="text-xl sm:text-2xl font-black text-amber-600 mb-4">Rp
                                    {{ number_format($kelas->harga, 0, ',', '.') }}<span
                                        class="text-xs font-normal text-amber-800/70">/malam</span></div>

                                <button
                                    onclick="bukaDetailKelas('{{ $kelas->id }}', '{{ $kelas->nama_kelas }}', '{{ number_format($kelas->harga, 0, ',', '.') }}', {{ json_encode($kelas->fasilitas) }}, '{{ asset('storage/' . $kelas->thumbnail) }}', '{{ $kelas->foto_1 ? asset('storage/' . $kelas->foto_1) : '' }}', '{{ $kelas->foto_2 ? asset('storage/' . $kelas->foto_2) : '' }}', '{{ $kelas->foto_3 ? asset('storage/' . $kelas->foto_3) : '' }}', {{ $kelas->sisa_kamar_riil }})"
                                    class="w-full bg-amber-600 hover:bg-amber-700 hover:text-white text-white font-bold py-2.5 rounded-xl transition transform hover:-translate-y-0.5 border-none duration-200 text-sm">
                                    Detail & Pesan
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- GALERI BENTO GRID -->
    <section class="bg-white py-10 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-2xl sm:text-3xl font-bold text-amber-950 mb-3">Galeri Hotel</h2>
                <div class="w-16 h-1 bg-amber-500 mx-auto rounded"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 sm:gap-6">
                <!-- Baris 1: Kiri Kecil (5/12), Kanan Lebar (7/12) -->
                <div
                    class="md:col-span-5 h-[220px] sm:h-[300px] rounded-3xl overflow-hidden shadow-sm border border-amber-200 group relative">
                    <img src="{{ asset('storage/landingpage/koridor.png') }}" alt="Galeri Fisa"
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition duration-300">
                    </div>
                </div>
                <div
                    class="md:col-span-7 h-[220px] sm:h-[300px] rounded-3xl overflow-hidden shadow-sm border border-amber-200 group relative">
                    <img src="{{ asset('storage/landingpage/lobbylt2.jpg') }}" alt="Galeri Fisa"
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition duration-300">
                    </div>
                </div>

                <!-- Baris 2: Kiri Lebar (7/12), Kanan Kecil (5/12) -->
                <div
                    class="md:col-span-7 h-[220px] sm:h-[300px] rounded-3xl overflow-hidden shadow-sm border border-amber-200 group relative">
                    <img src="{{ asset('storage/landingpage/backhotel.jpg') }}" alt="Galeri Fisa"
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition duration-300">
                    </div>
                </div>
                <div
                    class="md:col-span-5 h-[220px] sm:h-[300px] rounded-3xl overflow-hidden shadow-sm border border-amber-200 group relative">
                    <img src="{{ asset('storage/landingpage/lobbylt1.jpg') }}" alt="Galeri Fisa"
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition duration-300">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-amber-100/50 py-16 border-t border-amber-200/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-center">
                <div class="lg:col-span-1 text-amber-950">
                    <h2 class="text-3xl font-bold mb-4">Lokasi Kami</h2>
                    <div class="w-16 h-1 bg-amber-500 rounded mb-6"></div>
                    <p class="text-amber-900/80 mb-6 leading-relaxed text-sm sm:text-base font-medium">
                        Hotel FISA menawarkan akses mudah ke berbagai destinasi wisata, pusat perbelanjaan, dan kawasan
                        kuliner.
                    </p>
                    <div class="flex items-start gap-3 mb-8 bg-white p-4 rounded-xl border border-amber-200 shadow-sm">
                        <svg class="w-6 h-6 text-amber-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-amber-950 text-sm font-bold leading-relaxed">Lingkar Selatan Km.02 Negaradaha
                            no.39 Bumiayu</span>
                    </div>
                    <a href="https://maps.app.goo.gl/fGibk3T3x4sENjta7" target="_blank"
                        class="inline-flex items-center justify-center bg-amber-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-amber-700 transition w-full sm:w-auto shadow-md shadow-amber-600/20">
                        Buka di Google Maps →
                    </a>
                </div>
                <div
                    class="lg:col-span-2 rounded-2xl overflow-hidden shadow-xl h-[300px] sm:h-[400px] lg:h-[450px] border border-amber-200">
                    <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0"
                        marginwidth="0"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2852.992346342969!2d109.02251207094082!3d-7.263819854039304!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f8f38880a00b7%3A0x9c295af614499311!2sHotel%20Fisa!5e0!3m2!1sid!2sid!4v1780671646505!5m2!1sid!2sid"
                        class="grayscale hover:grayscale-0 transition duration-500"></iframe>
                </div>
            </div>
        </div>
    </section>

    <div id="modalDetail" class="fixed inset-0 z-50 hidden bg-amber-950/80 backdrop-blur-sm overflow-y-auto pb-20"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div
                class="relative bg-white rounded-3xl shadow-2xl max-w-4xl w-full overflow-hidden transform transition-all">

                <button onclick="tutupDetailKelas()"
                    class="absolute top-4 right-4 z-10 bg-white/80 backdrop-blur text-amber-950 hover:bg-white p-2 rounded-full shadow transition border border-amber-200">
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="grid grid-cols-1 lg:grid-cols-2 h-full">
                    <div class="bg-amber-50/50 p-6 flex flex-col gap-4 border-r border-amber-100">
                        <div
                            class="w-full h-56 sm:h-80 rounded-2xl overflow-hidden shadow-sm bg-white border border-amber-200 relative">
                            <div id="modal_ketersediaan" class="absolute top-4 right-4 z-10"></div>
                            <img id="modal_foto_utama" src="" class="w-full h-full object-cover">
                        </div>
                        <div class="grid grid-cols-3 gap-4" id="galeri_tambahan"></div>
                    </div>

                    <div class="p-6 sm:p-10 flex flex-col justify-between">
                        <div>
                            <div
                                class="inline-block bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full mb-3 uppercase tracking-wider border border-amber-200">
                                Katalog Tipe Kamar</div>
                            <h3 id="modal_nama_kelas" class="text-2xl sm:text-3xl font-black text-amber-950 mb-2">
                            </h3>
                            <div class="text-xl sm:text-2xl font-bold text-amber-600 mb-8">Rp <span
                                    id="modal_harga"></span><span
                                    class="text-sm sm:text-base font-normal text-amber-800/70"> /malam</span></div>

                            <h4
                                class="font-bold text-amber-950 mb-4 flex items-center gap-2 text-sm sm:text-base border-b border-amber-100 pb-2">
                                <svg class="size-5 text-amber-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg> Fasilitas Ruangan:
                            </h4>
                            <ul id="modal_fasilitas"
                                class="grid grid-cols-2 gap-y-3 gap-x-4 text-amber-900/80 text-xs sm:text-sm mb-8 font-medium">
                            </ul>
                        </div>

                        <button id="modal_btn_pesan" onclick="lanjutReservasi()"
                            class="w-full bg-amber-600 text-white font-bold text-base sm:text-lg py-3 sm:py-4 rounded-xl shadow-lg shadow-amber-600/30 hover:bg-amber-700 transition transform hover:-translate-y-0.5 border-none">
                            Pesan Tipe Kamar Ini
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/landingpage/home.js') }}?v={{ time() }}"></script>
</x-lplayout>

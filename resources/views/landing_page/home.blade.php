<x-lplayout>
    <!-- HERO SECTION (SANGAT TERANG & HANGAT) -->
    <section class="relative bg-amber-50 pt-32 pb-48 lg:pt-40 lg:pb-56 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('storage/landingpage/herobg.png') }}" alt="Hotel View"
                class="w-full h-full object-cover object-center" />
            <!-- OVERLAY CERAH: Warna krem tebal di kiri (untuk teks) lalu memudar total ke kanan agar foto gedung terlihat 100% -->
            <div class="absolute inset-0 bg-gradient-to-r from-amber-50/95 via-amber-50/70 to-transparent"></div>
        </div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-left flex flex-col justify-between h-full">
            <div>
                <!-- Teks sekarang berwarna cokelat gelap (amber-950) agar kontras di latar yang terang -->
                <h1 class="text-4xl font-extrabold tracking-tight text-amber-950 sm:text-5xl lg:text-6xl max-w-2xl">
                    Pengalaman Menginap <br>
                    <span class="text-amber-600">Tak Terlupakan</span>
                </h1>
                <p class="mt-4 text-sm sm:text-lg text-amber-900/80 font-medium max-w-xl leading-relaxed">
                    Pilih kamar impian Anda dan nikmati fasilitas yang dirancang khusus untuk kenyamanan Anda dan
                    keluarga.
                </p>
            </div>

            <!-- Card Fasilitas di Hero (Kaca Terang) -->
            <div class="mt-10 lg:mt-16 w-full">
                <div
                    class="flex overflow-x-auto gap-3 sm:gap-4 pb-4 snap-x snap-mandatory [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                    <!-- Masing-masing card menggunakan kaca putih tembus pandang -->
                    <div
                        class="flex-none w-32 sm:w-40 snap-center bg-white/60 backdrop-blur-md p-4 rounded-2xl border border-white text-center hover:bg-white/80 transition shadow-sm">
                        <div
                            class="w-10 h-10 sm:w-12 sm:h-12 mx-auto bg-amber-600 text-white rounded-full flex items-center justify-center mb-3 shadow-md shadow-amber-600/20">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0">
                                </path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-amber-950 text-xs sm:text-sm">Wifi Area</h3>
                    </div>
                    <div
                        class="flex-none w-32 sm:w-40 snap-center bg-white/60 backdrop-blur-md p-4 rounded-2xl border border-white text-center hover:bg-white/80 transition shadow-sm">
                        <div
                            class="w-10 h-10 sm:w-12 sm:h-12 mx-auto bg-amber-600 text-white rounded-full flex items-center justify-center mb-3 shadow-md shadow-amber-600/20">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4">
                                </path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-amber-950 text-xs sm:text-sm">Free Parking</h3>
                    </div>
                    <div
                        class="flex-none w-32 sm:w-40 snap-center bg-white/60 backdrop-blur-md p-4 rounded-2xl border border-white text-center hover:bg-white/80 transition shadow-sm">
                        <div
                            class="w-10 h-10 sm:w-12 sm:h-12 mx-auto bg-amber-600 text-white rounded-full flex items-center justify-center mb-3 shadow-md shadow-amber-600/20">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-amber-950 text-xs sm:text-sm">Keamanan 24 Jam</h3>
                    </div>
                    <div
                        class="flex-none w-32 sm:w-40 snap-center bg-white/60 backdrop-blur-md p-4 rounded-2xl border border-white text-center hover:bg-white/80 transition shadow-sm">
                        <div
                            class="w-10 h-10 sm:w-12 sm:h-12 mx-auto bg-amber-600 text-white rounded-full flex items-center justify-center mb-3 shadow-md shadow-amber-600/20">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-amber-950 text-xs sm:text-sm">Pelayanan 24 Jam</h3>
                    </div>
                    <div
                        class="flex-none w-32 sm:w-40 snap-center bg-white/60 backdrop-blur-md p-4 rounded-2xl border border-white text-center hover:bg-white/80 transition shadow-sm">
                        <div
                            class="w-10 h-10 sm:w-12 sm:h-12 mx-auto bg-amber-600 text-white rounded-full flex items-center justify-center mb-3 shadow-md shadow-amber-600/20">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-amber-950 text-xs sm:text-sm">Free Sarapan</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FORM CEK KETERSEDIAAN KAMAR (Putih Bersih) -->
    <div
        class="sticky top-4 sm:top-6 z-40 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 lg:-mt-24 mb-10 lg:mb-16 transition-all duration-300">
        <div
            class="bg-white/95 backdrop-blur-md rounded-2xl shadow-xl shadow-amber-900/5 border border-amber-100 p-5 sm:p-8">
            <form id="formFilterKamar" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-bold text-amber-950 mb-2">Tanggal Menginap</label>
                    <div class="flex gap-2">
                        <div class="w-full">
                            <span class="text-[10px] sm:text-xs text-amber-800/60 block mb-1">Check-in</span>
                            <input type="date" id="filter_checkin" value="{{ date('Y-m-d') }}"
                                class="w-full border border-amber-200 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500 p-2 sm:p-2.5 text-sm bg-amber-50/50 text-amber-950">
                        </div>
                        <div class="w-full">
                            <span class="text-[10px] sm:text-xs text-amber-800/60 block mb-1">Check-out</span>
                            <input type="date" id="filter_checkout" value="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                class="w-full border border-amber-200 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500 p-2 sm:p-2.5 text-sm bg-amber-50/50 text-amber-950">
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-amber-950 mb-2">Pilih Tipe Kelas</label>
                    <select id="filter_kelas"
                        class="w-full border border-amber-200 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500 p-2 sm:p-2.5 text-sm bg-amber-50/50 text-amber-950">
                        <option value="semua">Semua Tipe Kelas</option>
                        @foreach ($kelasKamars as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="button" onclick="terapkanFilter()"
                        class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 sm:py-2.5 px-4 rounded-lg transition shadow-md shadow-amber-600/30 text-sm sm:text-base border-none">
                        Cari Kamar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- KATALOG KAMAR -->
    <div id="kamar" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-10">
        <div class="text-center mb-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-amber-950 mb-3">Katalog Tipe Kamar</h2>
            <div class="w-16 h-1 bg-amber-500 mx-auto rounded"></div>
        </div>

        @if ($kelasKamars->isEmpty())
            <div class="text-center text-amber-800 py-12 bg-white rounded-2xl border border-amber-100 shadow-sm">
                <p>Katalog kamar sedang diperbarui. Silakan hubungi resepsionis.</p>
            </div>
        @else
            <div
                class="flex overflow-x-auto gap-4 sm:gap-6 pb-8 pt-4 snap-x snap-mandatory [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                @foreach ($kelasKamars as $kelas)
                    <div class="kamar-card w-[85vw] sm:w-[320px] lg:w-[360px] flex-none snap-center bg-white rounded-2xl shadow-sm border border-amber-100 overflow-hidden hover:shadow-xl hover:shadow-amber-900/10 transition duration-300 flex flex-col"
                        data-id-kelas="{{ $kelas->id }}">
                        <div class="relative h-48 sm:h-56 overflow-hidden bg-amber-100">
                            <img src="{{ asset('storage/' . $kelas->thumbnail) }}" alt="{{ $kelas->nama_kelas }}"
                                class="w-full h-full object-cover hover:scale-105 transition duration-500">
                        </div>

                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="text-xl sm:text-2xl font-black text-amber-950 mb-1">{{ $kelas->nama_kelas }}
                            </h3>

                            <div class="text-xs text-amber-800/70 mb-1 mt-auto pt-3">Mulai dari</div>
                            <div class="text-xl sm:text-2xl font-black text-amber-600 mb-4">Rp
                                {{ number_format($kelas->harga, 0, ',', '.') }}<span
                                    class="text-xs font-normal text-amber-800/70">/malam</span>
                            </div>

                            <button
                                onclick="bukaDetailKelas('{{ $kelas->nama_kelas }}', '{{ number_format($kelas->harga, 0, ',', '.') }}', {{ json_encode($kelas->fasilitas) }}, '{{ asset('storage/' . $kelas->thumbnail) }}', '{{ $kelas->foto_1 ? asset('storage/' . $kelas->foto_1) : '' }}', '{{ $kelas->foto_2 ? asset('storage/' . $kelas->foto_2) : '' }}', '{{ $kelas->foto_3 ? asset('storage/' . $kelas->foto_3) : '' }}')"
                                class="w-full bg-amber-50 hover:bg-amber-600 hover:text-white text-amber-700 font-bold border border-amber-200 py-2.5 rounded-xl transition duration-200 text-sm">
                                Detail & Pesan
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="pesan-kosong"
                class="hidden text-center text-amber-800 py-12 bg-white rounded-2xl border border-amber-100 shadow-sm mt-4">
                <p>Maaf, tipe kelas yang Anda cari saat ini sedang tidak tersedia.</p>
                <button onclick="resetFilter()" class="mt-4 text-amber-600 font-bold hover:underline">Lihat Semua
                    Kamar</button>
            </div>
        @endif
    </div>

    <!-- LOKASI & REKREASI TERDEKAT -->
    <section class="bg-white py-10 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-2xl sm:text-3xl font-bold text-amber-950 mb-3">Jelajahi Sekitar Kami</h2>
                <div class="w-16 h-1 bg-amber-500 mx-auto rounded"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                <!-- Kolom Kota Terdekat -->
                <div class="overflow-hidden">
                    <h3
                        class="flex items-center gap-2 font-bold text-lg text-amber-900 mb-4 pb-2 border-b border-amber-100">
                        <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        Kota Terdekat
                    </h3>
                    <div
                        class="flex overflow-x-auto gap-4 pb-6 pt-1 snap-x snap-mandatory [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                        <div
                            class="flex-none w-[80vw] sm:w-[280px] snap-center flex items-center gap-4 bg-amber-50/50 p-3 rounded-2xl border border-amber-100 shadow-sm hover:shadow-md hover:border-amber-300 transition group">
                            <img src="https://images.unsplash.com/photo-1518398046578-8cca57782e17?w=150&q=80"
                                alt="Bumiayu"
                                class="w-16 h-16 sm:w-20 sm:h-20 shrink-0 rounded-xl object-cover group-hover:scale-105 transition border border-amber-200">
                            <div class="min-w-0">
                                <strong class="block text-sm sm:text-base text-amber-950 truncate">Pusat
                                    Bumiayu</strong>
                                <span class="block text-xs sm:text-sm text-amber-800/70 mt-0.5 truncate">Jarak: 4
                                    KM</span>
                                <span class="block text-xs font-bold text-amber-600 mt-1 truncate">± 10 Menit</span>
                            </div>
                        </div>
                        <div
                            class="flex-none w-[80vw] sm:w-[280px] snap-center flex items-center gap-4 bg-amber-50/50 p-3 rounded-2xl border border-amber-100 shadow-sm hover:shadow-md hover:border-amber-300 transition group">
                            <img src="https://images.unsplash.com/photo-1555899434-94d1368aa7af?w=150&q=80"
                                alt="Purwokerto"
                                class="w-16 h-16 sm:w-20 sm:h-20 shrink-0 rounded-xl object-cover group-hover:scale-105 transition border border-amber-200">
                            <div class="min-w-0">
                                <strong class="block text-sm sm:text-base text-amber-950 truncate">Purwokerto</strong>
                                <span class="block text-xs sm:text-sm text-amber-800/70 mt-0.5 truncate">Jarak: 55
                                    KM</span>
                                <span class="block text-xs font-bold text-amber-600 mt-1 truncate">± 1.5 Jam</span>
                            </div>
                        </div>
                        <div
                            class="flex-none w-[80vw] sm:w-[280px] snap-center flex items-center gap-4 bg-amber-50/50 p-3 rounded-2xl border border-amber-100 shadow-sm hover:shadow-md hover:border-amber-300 transition group">
                            <img src="https://images.unsplash.com/photo-1577717903315-1691ae25ab3f?w=150&q=80"
                                alt="Tegal"
                                class="w-16 h-16 sm:w-20 sm:h-20 shrink-0 rounded-xl object-cover group-hover:scale-105 transition border border-amber-200">
                            <div class="min-w-0">
                                <strong class="block text-sm sm:text-base text-amber-950 truncate">Tegal</strong>
                                <span class="block text-xs sm:text-sm text-amber-800/70 mt-0.5 truncate">Jarak: 70
                                    KM</span>
                                <span class="block text-xs font-bold text-amber-600 mt-1 truncate">± 2 Jam</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Tempat Rekreasi -->
                <div class="overflow-hidden">
                    <h3
                        class="flex items-center gap-2 font-bold text-lg text-amber-900 mb-4 pb-2 border-b border-amber-100">
                        <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9">
                            </path>
                        </svg>
                        Tempat Rekreasi Terdekat
                    </h3>
                    <div
                        class="flex overflow-x-auto gap-4 pb-6 pt-1 snap-x snap-mandatory [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                        <div
                            class="flex-none w-[80vw] sm:w-[280px] snap-center flex items-center gap-4 bg-amber-50/50 p-3 rounded-2xl border border-amber-100 shadow-sm hover:shadow-md hover:border-amber-300 transition group">
                            <img src="https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?w=150&q=80"
                                alt="Waterpark"
                                class="w-16 h-16 sm:w-20 sm:h-20 shrink-0 rounded-xl object-cover group-hover:scale-105 transition border border-amber-200">
                            <div class="min-w-0">
                                <strong class="block text-sm sm:text-base text-amber-950 truncate">Sahabat Alam
                                    Waterpark</strong>
                                <span class="block text-xs sm:text-sm text-amber-800/70 mt-0.5 truncate">Jarak: 200
                                    Meter</span>
                                <span class="block text-xs font-bold text-amber-600 mt-1 truncate">± 2 Menit
                                    (Jalan)</span>
                            </div>
                        </div>
                        <div
                            class="flex-none w-[80vw] sm:w-[280px] snap-center flex items-center gap-4 bg-amber-50/50 p-3 rounded-2xl border border-amber-100 shadow-sm hover:shadow-md hover:border-amber-300 transition group">
                            <img src="https://images.unsplash.com/photo-1542281286-9e0a16bb7366?w=150&q=80"
                                alt="Guci"
                                class="w-16 h-16 sm:w-20 sm:h-20 shrink-0 rounded-xl object-cover group-hover:scale-105 transition border border-amber-200">
                            <div class="min-w-0">
                                <strong class="block text-sm sm:text-base text-amber-950 truncate">Wisata Guci,
                                    Tegal</strong>
                                <span class="block text-xs sm:text-sm text-amber-800/70 mt-0.5 truncate">Jarak: 30
                                    KM</span>
                                <span class="block text-xs font-bold text-amber-600 mt-1 truncate">± 1 Jam</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MAPS LOKASI HOTEL -->
    <section class="bg-amber-100/50 py-16 border-t border-amber-200/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-center">
                <div class="lg:col-span-1 text-amber-950">
                    <h2 class="text-3xl font-bold mb-4">Lokasi Kami</h2>
                    <div class="w-16 h-1 bg-amber-500 rounded mb-6"></div>
                    <p class="text-amber-900/80 mb-6 leading-relaxed text-sm sm:text-base font-medium">
                        Terletak strategis di pusat kota, Hotel FISA menawarkan akses mudah ke berbagai destinasi
                        wisata, pusat perbelanjaan, dan kawasan kuliner.
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
                        <span class="text-amber-950 text-sm font-bold leading-relaxed">Jl. Raya Pusat Kota No.
                            123<br>Bumiayu, Brebes</span>
                    </div>
                    <a href="https://maps.google.com/?q=-7.2551372,109.0007407" target="_blank"
                        class="inline-flex items-center justify-center bg-amber-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-amber-700 transition w-full sm:w-auto shadow-md shadow-amber-600/20">
                        Buka di Google Maps →
                    </a>
                </div>
                <div
                    class="lg:col-span-2 rounded-2xl overflow-hidden shadow-xl h-[300px] sm:h-[400px] lg:h-[450px] border border-amber-200">
                    <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0"
                        marginwidth="0"
                        src="https://maps.google.com/maps?q=-7.2551372,109.0007407&hl=es;z=14&output=embed"
                        class="grayscale hover:grayscale-0 transition duration-500">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- MODAL DETAIL KAMAR -->
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
                            class="w-full h-56 sm:h-80 rounded-2xl overflow-hidden shadow-sm bg-white border border-amber-200">
                            <img id="modal_foto_utama" src="" class="w-full h-full object-cover">
                        </div>
                        <div class="grid grid-cols-3 gap-4" id="galeri_tambahan"></div>
                    </div>

                    <div class="p-6 sm:p-10 flex flex-col justify-between">
                        <div>
                            <div
                                class="inline-block bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full mb-3 uppercase tracking-wider border border-amber-200">
                                Katalog Tipe Kamar
                            </div>
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
                                </svg>
                                Fasilitas Ruangan:
                            </h4>
                            <ul id="modal_fasilitas"
                                class="grid grid-cols-2 gap-y-3 gap-x-4 text-amber-900/80 text-xs sm:text-sm mb-8 font-medium">
                            </ul>
                        </div>

                        <button
                            onclick="alert('Pemesanan online sedang dalam tahap pengembangan. Silakan hubungi resepsionis kami.')"
                            class="w-full bg-amber-600 text-white font-bold text-base sm:text-lg py-3 sm:py-4 rounded-xl shadow-lg shadow-amber-600/30 hover:bg-amber-700 transition transform hover:-translate-y-0.5 border-none">
                            Pesan Tipe Kamar Ini
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT FILTER & MODAL -->
    <script>
        function bukaDetailKelas(namaKelas, harga, fasilitas, thumb, f1, f2, f3) {
            document.getElementById('modal_nama_kelas').innerText = namaKelas;
            document.getElementById('modal_harga').innerText = harga;
            document.getElementById('modal_foto_utama').src = thumb;

            let galeriHTML = '';
            let arrayFoto = [thumb, f1, f2, f3].filter(foto => foto !== '');

            arrayFoto.forEach(fotoUrl => {
                galeriHTML += `
                    <div class="h-16 sm:h-24 rounded-xl overflow-hidden shadow-sm border-2 border-transparent hover:border-amber-400 cursor-pointer transition" onclick="document.getElementById('modal_foto_utama').src='${fotoUrl}'">
                        <img src="${fotoUrl}" class="w-full h-full object-cover">
                    </div>
                `;
            });
            document.getElementById('galeri_tambahan').innerHTML = galeriHTML;

            let fasHTML = '';
            fasilitas.forEach(item => {
                fasHTML +=
                    `<li class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-amber-500 shrink-0"></span>${item}</li>`;
            });
            document.getElementById('modal_fasilitas').innerHTML = fasHTML;

            document.body.classList.add('overflow-hidden');
            document.getElementById('modalDetail').classList.remove('hidden');
        }

        function tutupDetailKelas() {
            document.body.classList.remove('overflow-hidden');
            document.getElementById('modalDetail').classList.add('hidden');
        }

        function terapkanFilter() {
            const checkin = document.getElementById('filter_checkin').value;
            const checkout = document.getElementById('filter_checkout').value;
            const kelasIdDipilih = document.getElementById('filter_kelas').value;

            if (!checkin || !checkout) {
                alert("Silakan lengkapi tanggal Check-in dan Check-out.");
                return;
            }

            const semuaCard = document.querySelectorAll('.kamar-card');
            let adaYangTampil = false;

            semuaCard.forEach(card => {
                if (kelasIdDipilih === 'semua' || card.getAttribute('data-id-kelas') === kelasIdDipilih) {
                    card.classList.remove('hidden');
                    adaYangTampil = true;
                } else {
                    card.classList.add('hidden');
                }
            });

            const pesanKosong = document.getElementById('pesan-kosong');
            if (pesanKosong) {
                if (!adaYangTampil) {
                    pesanKosong.classList.remove('hidden');
                } else {
                    pesanKosong.classList.add('hidden');
                }
            }

            const elemenKamar = document.getElementById('kamar');
            const yOffset = -50;
            const y = elemenKamar.getBoundingClientRect().top + window.pageYOffset + yOffset;
            window.scrollTo({
                top: y,
                behavior: 'smooth'
            });
        }

        function resetFilter() {
            document.getElementById('filter_kelas').value = 'semua';
            terapkanFilter();
        }
    </script>
</x-lplayout>

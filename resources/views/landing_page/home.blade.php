<x-lplayout>
    <section class="bg-white lg:grid lg:h-screen lg:place-content-center">
        <div class="mx-auto w-screen max-w-7xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8 lg:py-32">
            <div class="mx-auto max-w-prose text-center">
                <h1 class="text-4xl font-bold text-gray-900 sm:text-5xl">
                    HOTEL
                    <strong class="text-indigo-600"> FISA </strong>
                </h1>
                <p class="mt-4 text-base text-pretty text-gray-700 sm:text-lg/relaxed">
                    Pengalaman Menginap Tak Terlupakan, Pilih kamar impian Anda dan nikmati fasilitas yang
                    dirancang khusus untuk kenyamanan Anda dan keluarga.
                </p>
                <div class="mt-4 flex justify-center gap-4 sm:mt-6">
                    <a class="inline-block rounded border border-indigo-600 bg-indigo-600 px-5 py-3 font-medium text-white shadow-sm transition-colors hover:bg-indigo-700"
                        href="#kamar">
                        Cek Kamar
                    </a>
                    <a class="inline-block rounded border border-gray-200 px-5 py-3 font-medium text-gray-700 shadow-sm transition-colors hover:bg-gray-50 hover:text-gray-900"
                        href="#">
                        Pesan Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>
    {{-- Kamar dan Fasilitas --}}
    <div id="kamar" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Pilihan Kamar Kami</h2>
            <div class="w-24 h-1 bg-indigo-600 mx-auto rounded"></div>
        </div>

        @if ($kategoriKamar->isEmpty())
            <div class="text-center text-gray-500 py-12 bg-white rounded-2xl shadow-sm border border-gray-100">
                <p>Kamar belum tersedia. Silakan hubungi resepsionis.</p>
            </div>
        @else
            @foreach ($kategoriKamar as $kelas => $kamars)
                <div class="mb-16">
                    <div class="flex items-center gap-4 mb-6">
                        <h3 class="text-2xl font-bold text-indigo-900">{{ $kelas }}</h3>
                        <span
                            class="bg-indigo-100 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full">{{ $kamars->count() }}
                            Ruangan Tersedia</span>
                        <div class="flex-grow h-px bg-gray-200"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach ($kamars as $kamar)
                            <div
                                class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition duration-300 group">
                                <div class="relative h-48 overflow-hidden bg-gray-200">
                                    <img src="{{ asset('storage/' . $kamar->thumbnail) }}"
                                        alt="Kamar {{ $kamar->nomor_ruangan }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                    <div
                                        class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-lg shadow-sm font-bold text-gray-900 text-sm">
                                        #{{ $kamar->nomor_ruangan }}
                                    </div>
                                </div>

                                <div class="p-5">
                                    <div class="text-sm text-gray-500 mb-1">Mulai dari</div>
                                    <div class="text-xl font-black text-indigo-600 mb-4">Rp
                                        {{ number_format($kamar->harga, 0, ',', '.') }}<span
                                            class="text-sm font-normal text-gray-500">/malam</span></div>

                                    <button
                                        onclick="bukaDetailKamar('{{ $kamar->kelas_kamar }}', '{{ $kamar->nomor_ruangan }}', '{{ number_format($kamar->harga, 0, ',', '.') }}', {{ json_encode($kamar->fasilitas) }}, '{{ asset('storage/' . $kamar->thumbnail) }}', '{{ $kamar->foto_1 ? asset('storage/' . $kamar->foto_1) : '' }}', '{{ $kamar->foto_2 ? asset('storage/' . $kamar->foto_2) : '' }}', '{{ $kamar->foto_3 ? asset('storage/' . $kamar->foto_3) : '' }}')"
                                        class="w-full bg-gray-50 hover:bg-indigo-600 hover:text-white text-indigo-600 font-semibold border border-indigo-100 py-2.5 rounded-xl transition duration-200">
                                        Lihat Detail Kamar
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <div id="modalDetail" class="fixed inset-0 z-50 hidden bg-gray-900/80 backdrop-blur-sm overflow-y-auto"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div
                class="relative bg-white rounded-3xl shadow-2xl max-w-4xl w-full overflow-hidden transform transition-all">

                <button onclick="tutupDetailKamar()"
                    class="absolute top-4 right-4 z-10 bg-white/50 backdrop-blur text-gray-900 hover:bg-white p-2 rounded-full shadow transition">
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="grid grid-cols-1 lg:grid-cols-2 h-full">

                    <div class="bg-gray-100 p-6 flex flex-col gap-4">
                        <div class="w-full h-64 sm:h-80 rounded-2xl overflow-hidden shadow-sm bg-white">
                            <img id="modal_foto_utama" src="" class="w-full h-full object-cover">
                        </div>

                        <div class="grid grid-cols-3 gap-4" id="galeri_tambahan">
                        </div>
                    </div>

                    <div class="p-8 sm:p-10 flex flex-col justify-between">
                        <div>
                            <div class="inline-block bg-indigo-100 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full mb-3 uppercase tracking-wider"
                                id="modal_kelas"></div>
                            <h3 class="text-3xl font-black text-gray-900 mb-2">Kamar <span id="modal_nomor"></span></h3>
                            <div class="text-2xl font-bold text-indigo-600 mb-8">Rp <span id="modal_harga"></span><span
                                    class="text-base font-medium text-gray-500"> /malam</span></div>

                            <h4 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="size-5 text-indigo-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Fasilitas Ruangan Ini:
                            </h4>
                            <ul id="modal_fasilitas"
                                class="grid grid-cols-2 gap-y-3 gap-x-4 text-gray-600 text-sm mb-8">
                            </ul>
                        </div>

                        <button
                            onclick="alert('Fitur Reservasi Online sedang dalam tahap pengembangan! Nantikan segera.')"
                            class="w-full bg-indigo-600 text-white font-bold text-lg py-4 rounded-xl shadow-lg hover:bg-indigo-700 hover:shadow-indigo-500/30 transition transform hover:-translate-y-0.5">
                            Pesan Kamar Ini Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function bukaDetailKamar(kelas, nomor, harga, fasilitas, thumb, f1, f2, f3) {
            // Isi teks informasi
            document.getElementById('modal_kelas').innerText = kelas;
            document.getElementById('modal_nomor').innerText = nomor;
            document.getElementById('modal_harga').innerText = harga;

            // Atur Foto Utama
            document.getElementById('modal_foto_utama').src = thumb;

            // Atur Galeri Foto Tambahan
            let galeriHTML = '';
            let arrayFoto = [thumb, f1, f2, f3].filter(foto => foto !== ''); // Hanya ambil foto yang tidak kosong

            arrayFoto.forEach(fotoUrl => {
                // Fungsi onclick untuk menukar foto utama dengan foto yang diklik
                galeriHTML += `
                    <div class="h-20 sm:h-24 rounded-xl overflow-hidden shadow-sm border-2 border-transparent hover:border-indigo-500 cursor-pointer transition" onclick="document.getElementById('modal_foto_utama').src='${fotoUrl}'">
                        <img src="${fotoUrl}" class="w-full h-full object-cover">
                    </div>
                `;
            });
            document.getElementById('galeri_tambahan').innerHTML = galeriHTML;

            // Atur Daftar Fasilitas
            let fasHTML = '';
            fasilitas.forEach(item => {
                fasHTML += `<li class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
                                ${item}
                            </li>`;
            });
            document.getElementById('modal_fasilitas').innerHTML = fasHTML;

            // Tampilkan Modal
            document.body.classList.add('overflow-hidden'); // Cegah scroll latar belakang
            document.getElementById('modalDetail').classList.remove('hidden');
        }

        function tutupDetailKamar() {
            document.body.classList.remove('overflow-hidden');
            document.getElementById('modalDetail').classList.add('hidden');
        }
    </script>
</x-lplayout>

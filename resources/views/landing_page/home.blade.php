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
                    <a class="inline-block rounded-lg border border-indigo-600 bg-indigo-600 px-5 py-3 font-medium text-white shadow-sm transition-colors hover:bg-indigo-700"
                        href="#kamar">
                        Cek Kamar
                    </a>
                    <a class="inline-block rounded-lg border border-gray-200 px-5 py-3 font-medium text-gray-700 shadow-sm transition-colors hover:bg-gray-50 hover:text-gray-900"
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
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Pilihan Tipe Kamar Kami</h2>
            <div class="w-24 h-1 bg-indigo-600 mx-auto rounded"></div>
        </div>

        @if ($kelasKamars->isEmpty())
            <div class="text-center text-gray-500 py-12 bg-white rounded-2xl shadow-sm border border-gray-100">
                <p>Katalog kamar sedang diperbarui. Silakan hubungi resepsionis.</p>
            </div>
        @else
            <div
                class="flex overflow-x-auto gap-6 pb-8 pt-4 snap-x snap-mandatory [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                @foreach ($kelasKamars as $kelas)
                    <div
                        class="w-[85vw] sm:w-[350px] lg:w-[380px] flex-none snap-start bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition duration-300 flex flex-col">
                        <div class="relative h-56 overflow-hidden bg-gray-200">
                            <img src="{{ asset('storage/' . $kelas->thumbnail) }}" alt="{{ $kelas->nama_kelas }}"
                                class="w-full h-full object-cover hover:scale-105 transition duration-500">
                        </div>

                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-2xl font-black text-gray-900 mb-2">{{ $kelas->nama_kelas }}</h3>

                            <div class="text-sm text-gray-500 mb-1 mt-auto pt-4">Mulai dari</div>
                            <div class="text-2xl font-black text-indigo-600 mb-5">Rp
                                {{ number_format($kelas->harga, 0, ',', '.') }}<span
                                    class="text-sm font-normal text-gray-500">/malam</span></div>

                            <button
                                onclick="bukaDetailKelas('{{ $kelas->nama_kelas }}', '{{ number_format($kelas->harga, 0, ',', '.') }}', {{ json_encode($kelas->fasilitas) }}, '{{ asset('storage/' . $kelas->thumbnail) }}', '{{ $kelas->foto_1 ? asset('storage/' . $kelas->foto_1) : '' }}', '{{ $kelas->foto_2 ? asset('storage/' . $kelas->foto_2) : '' }}', '{{ $kelas->foto_3 ? asset('storage/' . $kelas->foto_3) : '' }}')"
                                class="w-full bg-gray-50 hover:bg-indigo-600 hover:text-white text-indigo-600 font-semibold border border-indigo-100 py-3 rounded-xl transition duration-200">
                                Lihat Detail & Fasilitas
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div id="modalDetail" class="fixed inset-0 z-50 hidden bg-gray-900/80 backdrop-blur-sm overflow-y-auto"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div
                class="relative bg-white rounded-3xl shadow-2xl max-w-4xl w-full overflow-hidden transform transition-all">

                <button onclick="tutupDetailKelas()"
                    class="absolute top-4 right-4 z-10 bg-white/50 backdrop-blur text-gray-900 hover:bg-white p-2 rounded-full shadow transition">
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="grid grid-cols-1 lg:grid-cols-2 h-full">

                    <div class="bg-gray-100 p-6 flex flex-col gap-4">
                        <div
                            class="w-full h-64 sm:h-80 rounded-2xl overflow-hidden shadow-sm bg-white border border-gray-200">
                            <img id="modal_foto_utama" src="" class="w-full h-full object-cover">
                        </div>
                        <div class="grid grid-cols-3 gap-4" id="galeri_tambahan">
                        </div>
                    </div>

                    <div class="p-8 sm:p-10 flex flex-col justify-between">
                        <div>
                            <div
                                class="inline-block bg-indigo-100 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full mb-3 uppercase tracking-wider">
                                Katalog Tipe Kamar</div>
                            <h3 id="modal_nama_kelas" class="text-3xl font-black text-gray-900 mb-2"></h3>
                            <div class="text-2xl font-bold text-indigo-600 mb-8">Rp <span id="modal_harga"></span><span
                                    class="text-base font-medium text-gray-500"> /malam</span></div>

                            <h4 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="size-5 text-indigo-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Fasilitas Ruangan:
                            </h4>
                            <ul id="modal_fasilitas"
                                class="grid grid-cols-2 gap-y-3 gap-x-4 text-gray-600 text-sm mb-8">
                            </ul>
                        </div>

                        <button
                            onclick="alert('Fitur Reservasi Online sedang dikembangkan. Nanti sistem akan otomatis mencarikan ruangan yang kosong untuk tipe kamar ini.')"
                            class="w-full bg-indigo-600 text-white font-bold text-lg py-4 rounded-xl shadow-lg hover:bg-indigo-700 hover:shadow-indigo-500/30 transition transform hover:-translate-y-0.5">
                            Pesan Tipe Kamar Ini
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function bukaDetailKelas(namaKelas, harga, fasilitas, thumb, f1, f2, f3) {
            document.getElementById('modal_nama_kelas').innerText = namaKelas;
            document.getElementById('modal_harga').innerText = harga;

            document.getElementById('modal_foto_utama').src = thumb;

            let galeriHTML = '';
            let arrayFoto = [thumb, f1, f2, f3].filter(foto => foto !== '');

            arrayFoto.forEach(fotoUrl => {
                galeriHTML += `
                    <div class="h-20 sm:h-24 rounded-xl overflow-hidden shadow-sm border-2 border-transparent hover:border-indigo-500 cursor-pointer transition" onclick="document.getElementById('modal_foto_utama').src='${fotoUrl}'">
                        <img src="${fotoUrl}" class="w-full h-full object-cover">
                    </div>
                `;
            });
            document.getElementById('galeri_tambahan').innerHTML = galeriHTML;

            let fasHTML = '';
            fasilitas.forEach(item => {
                fasHTML += `<li class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
                                ${item}
                            </li>`;
            });
            document.getElementById('modal_fasilitas').innerHTML = fasHTML;

            document.body.classList.add('overflow-hidden');
            document.getElementById('modalDetail').classList.remove('hidden');
        }

        function tutupDetailKelas() {
            document.body.classList.remove('overflow-hidden');
            document.getElementById('modalDetail').classList.add('hidden');
        }
    </script>
</x-lplayout>

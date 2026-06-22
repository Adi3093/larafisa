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
                ✅ {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm font-bold">
                ⚠️ {{ session('error') }}
            </div>
        @endif

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

        <div class="bg-white rounded-3xl shadow-xl border border-amber-100 p-6 sm:px-10 pt-12 mb-8 overflow-hidden">
            <h2 class="sr-only">Steps</h2>

            <div class="relative flex items-center justify-between w-full">
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1.5 bg-gray-100 rounded-lg z-0"></div>
                <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1.5 bg-amber-500 rounded-lg z-0 transition-all duration-700 ease-in-out"
                    style="width: {{ (($currentStep - 1) / 4) * 100 }}%"></div>

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

        <h2 class="font-bold text-amber-950 text-xl mb-4 px-1">Pesanan Aktif Saat Ini</h2>

        <div class="bg-white rounded-3xl shadow-md border border-amber-100 p-6 sm:p-8 mb-10">
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
                            @php
                                $f_in = \Carbon\Carbon::parse($pesananAktif->check_in)->format('Y-m-d\TH:i');
                                $f_out = \Carbon\Carbon::parse($pesananAktif->check_out)->format('Y-m-d\TH:i');
                                $kId = $pesananAktif->kamar_id;
                                $klId = $pesananAktif->kamar?->kelas_kamar_id;
                                $metodeBayarGuest = $pesananAktif->ekstra['Metode Pembayaran'] ?? 'Bayar di tempat';
                            @endphp

                            @if (in_array($pesananAktif->status_reservasi, ['Menunggu Konfirmasi', 'Terkonfirmasi']))
                                <button
                                    onclick="bukaModalUbahJadwal('{{ $pesananAktif->id }}', '{{ $metodeBayarGuest }}', '{{ $f_in }}', '{{ $f_out }}', '{{ $klId }}', '{{ $kId }}')"
                                    class="bg-gray-50 hover:bg-gray-100 text-gray-700 text-xs font-bold py-2.5 px-4 rounded-xl border border-gray-200 transition">
                                    🔄 Ubah Jadwal Menginap
                                </button>
                            @endif

                            @if ($pesananAktif->status_reservasi === 'Menunggu Konfirmasi')
                                <form action="{{ route('reservasi.tamu.batal', $pesananAktif->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin membatalkan permohonan reservasi ini secara permanen?')">
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
                                                ? 'bg-gray-100 text-gray-700 border-gray-200'
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

    <div id="modalUbahJadwal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/60 backdrop-blur-sm"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md">

                <div class="bg-amber-600 px-6 py-4 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white">Ubah Jadwal & Kamar</h3>
                    <button onclick="document.getElementById('modalUbahJadwal').classList.add('hidden')"
                        class="text-amber-100 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="bg-white px-6 pb-4 pt-5">

                    <div id="lockWarning"
                        class="hidden mb-4 bg-blue-50 border border-blue-200 text-blue-800 p-3 rounded-xl flex items-start gap-3 shadow-sm text-left">
                        <svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                        <div>
                            <p class="text-[11px] leading-relaxed">Anda menggunakan metode pembayaran Transfer/QRIS.
                                <strong>Perubahan Kelas dan Ruangan telah dikunci</strong> demi penyesuaian dana. Anda
                                hanya diizinkan untuk memajukan/mengundurkan jadwal tanggal inap.
                            </p>
                        </div>
                    </div>

                    <form id="formUbahJadwal" method="POST" action="">
                        @csrf @method('PUT')

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Check-In Baru</label>
                                <input type="datetime-local" name="check_in" id="edit_check_in"
                                    onchange="fetchKamarEdit()" required
                                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm transition focus:ring-amber-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Check-Out Baru</label>
                                <input type="datetime-local" name="check_out" id="edit_check_out"
                                    onchange="fetchKamarEdit()" required
                                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm transition focus:ring-amber-500">
                            </div>
                        </div>

                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4 bg-gray-50 p-3 rounded-xl border border-gray-100">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Kelas Kamar</label>
                                <select id="edit_kelas_kamar_id" name="kelas_kamar_id" onchange="fetchKamarEdit()"
                                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm bg-white disabled:bg-gray-200">
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach ($kelasKamars as $kelas)
                                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Ruangan Fisik</label>
                                <select id="edit_kamar_id" name="kamar_id" required
                                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm bg-white disabled:bg-gray-200">
                                    <option value="">-- Memuat Data --</option>
                                </select>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse border-t border-gray-100">
                    <button type="submit" form="formUbahJadwal"
                        class="rounded-xl bg-amber-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-amber-700 ml-3 transition w-full sm:w-auto">
                        Terapkan Perubahan
                    </button>
                    <button type="button"
                        onclick="document.getElementById('modalUbahJadwal').classList.add('hidden')"
                        class="rounded-xl bg-white px-5 py-2.5 text-sm font-bold text-gray-900 shadow-sm border border-gray-300 hover:bg-gray-50 transition w-full sm:w-auto mt-3 sm:mt-0">
                        Batal
                    </button>
                </div>

            </div>
        </div>
    </div>

    <script>
        let currentKamarId = null;

        function bukaModalUbahJadwal(idRes, metode, checkIn, checkOut, kelasId, kamarId) {
            document.getElementById('formUbahJadwal').action = `/reservasi-online/${idRes}/update`;
            document.getElementById('edit_check_in').value = checkIn;
            document.getElementById('edit_check_out').value = checkOut;
            let kelasEl = document.getElementById('edit_kelas_kamar_id');
            let kamarEl = document.getElementById('edit_kamar_id');

            kelasEl.value = kelasId;
            currentKamarId = kamarId;
            if (metode === 'Transfer' || metode === 'Q-RIS') {
                kelasEl.disabled = true;
                kamarEl.disabled = true;
                document.getElementById('lockWarning').classList.remove('hidden');
            } else {
                kelasEl.disabled = false;
                kamarEl.disabled = false;
                document.getElementById('lockWarning').classList.add('hidden');
            }

            fetchKamarEdit();
            document.getElementById('modalUbahJadwal').classList.remove('hidden');
        }

        async function fetchKamarEdit() {
            const kelasId = document.getElementById('edit_kelas_kamar_id').value;
            const checkIn = document.getElementById('edit_check_in').value;
            const checkOut = document.getElementById('edit_check_out').value;
            const kamarSelect = document.getElementById('edit_kamar_id');

            if (!kelasId || !checkIn || !checkOut) return;

            kamarSelect.innerHTML = '<option value="">Sedang memuat ruangan...</option>';
            try {
                let response = await fetch(
                    `/api/kamar-tersedia?kelas_id=${kelasId}&check_in=${checkIn}&check_out=${checkOut}`);
                let kamars = await response.json();

                kamarSelect.innerHTML = '<option value="">-- Pilih Kamar --</option>';
                kamars.forEach(kmr => {
                    let opt = document.createElement('option');
                    opt.value = kmr.id;
                    opt.text = 'Kamar ' + kmr.nomor_ruangan;
                    if (kmr.id == currentKamarId) opt.selected = true;
                    kamarSelect.appendChild(opt);
                });
                if (kamarSelect.selectedIndex === 0 && currentKamarId !== null) {
                    kamarSelect.innerHTML +=
                        `<option value="" disabled class="text-red-500">Ruangan lama Anda (#${currentKamarId}) penuh di jadwal ini</option>`;
                }

            } catch (error) {
                kamarSelect.innerHTML = '<option value="">Gagal memuat sistem kamar</option>';
            }
        }
    </script>
</x-lplayout>

<x-dblayout>
    <div class="max-w-7xl mx-auto" x-data="{ tab: '{{ $activeTab }}' }">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-amber-950 tracking-tight">Manajemen Kamar & Ruangan</h1>
            <p class="text-sm text-amber-900/70 mt-1">Kelola katalog kelas dan fisik ruangan kamar.</p>
        </div>

        @if (session('success'))
            <div
                class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm">
                <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm">
                <div class="flex items-center gap-2 font-bold mb-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Terjadi Kesalahan:
                </div>
                <ul class="list-disc list-inside text-sm ml-7">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex items-end pl-0 sm:pl-2 flex-wrap gap-y-2 relative z-10">
            <button @click="tab = 'kelas'"
                :class="tab === 'kelas' ?
                    'px-5 sm:px-6 py-3 bg-white border border-amber-200 border-b-white rounded-t-xl font-bold text-amber-700 text-xs sm:text-sm relative z-10 -mb-[1px] shadow-sm shadow-white transition' :
                    'px-5 sm:px-6 py-2.5 bg-amber-50 border border-amber-200 rounded-t-xl font-bold text-amber-800/60 hover:text-amber-700 hover:bg-amber-100 text-xs sm:text-sm transition relative z-0 ml-1'">
                Katalog Kelas Kamar
            </button>
            <button @click="tab = 'ruangan'"
                :class="tab === 'ruangan' ?
                    'px-5 sm:px-6 py-3 bg-white border border-amber-200 border-b-white rounded-t-xl font-bold text-amber-700 text-xs sm:text-sm relative z-10 -mb-[1px] shadow-sm shadow-white transition ml-1' :
                    'px-5 sm:px-6 py-2.5 bg-amber-50 border border-amber-200 rounded-t-xl font-bold text-amber-800/60 hover:text-amber-700 hover:bg-amber-100 text-xs sm:text-sm transition relative z-0 ml-1'">
                Daftar Fisik Ruangan
            </button>
        </div>

        <div
            class="bg-white border border-amber-200 rounded-b-2xl rounded-tr-2xl rounded-tl-none shadow-sm p-5 lg:p-6 mb-6 relative z-0 -mt-[1px]">

            <div x-show="tab === 'kelas'" x-cloak>
                <div class="mb-6 flex flex-col lg:flex-row justify-between gap-4 border-b border-amber-100 pb-5">
                    <form method="GET" action="{{ route('kamar') }}" class="flex flex-wrap gap-2 w-full lg:w-auto">
                        <input type="hidden" name="tab" value="kelas">
                        <input type="text" name="kelas_search" value="{{ request('kelas_search') }}"
                            placeholder="Cari nama kelas..."
                            class="border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 py-2.5 px-3 text-sm border w-full sm:w-48 transition text-amber-950">
                        <select name="kelas_harga"
                            class="border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 py-2.5 px-3 text-sm border bg-white transition text-amber-950">
                            <option value="">Urutkan Harga...</option>
                            <option value="murah" {{ request('kelas_harga') == 'murah' ? 'selected' : '' }}>Termurah -
                                Termahal</option>
                            <option value="mahal" {{ request('kelas_harga') == 'mahal' ? 'selected' : '' }}>Termahal -
                                Termurah</option>
                        </select>
                        <select name="kelas_per_page"
                            class="border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 py-2.5 px-3 text-sm border bg-white transition text-amber-950">
                            <option value="5" {{ request('kelas_per_page') == 5 ? 'selected' : '' }}>5 Baris
                            </option>
                            <option value="10" {{ request('kelas_per_page') == 10 ? 'selected' : '' }}>10 Baris
                            </option>
                            <option value="15" {{ request('kelas_per_page') == 15 ? 'selected' : '' }}>15 Baris
                            </option>
                            <option value="20" {{ request('kelas_per_page') == 20 ? 'selected' : '' }}>20 Baris
                            </option>
                        </select>
                        <button type="submit"
                            class="bg-amber-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-amber-700 transition shadow-sm text-center">Cari</button>
                        @if (request('kelas_search') || request('kelas_harga'))
                            <a href="{{ route('kamar', ['tab' => 'kelas']) }}"
                                class="bg-white text-amber-700 px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-amber-50 transition border border-amber-200 shadow-sm flex items-center justify-center">Reset</a>
                        @endif
                    </form>

                    <button onclick="document.getElementById('modalKelas').classList.remove('hidden')"
                        class="bg-amber-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-amber-700 transition shadow-sm shadow-amber-600/20 whitespace-nowrap flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Tambah Kelas
                    </button>
                </div>

                <div class="bg-white shadow-sm rounded-xl border border-amber-100 overflow-hidden mb-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y-2 divide-amber-50 bg-white text-sm text-left">
                            <thead
                                class="bg-amber-50/50 border-b border-amber-100 text-amber-900 font-bold uppercase tracking-wider text-[11px]">
                                <tr>
                                    <th class="px-6 py-4">Thumbnail</th>
                                    <th class="px-6 py-4">Nama Kelas</th>
                                    <th class="px-6 py-4">Harga / Malam</th>
                                    <th class="px-6 py-4 text-center">Kapasitas</th>
                                    <th class="px-6 py-4 text-center">Total Ruangan</th>
                                    <th class="px-6 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-amber-50 text-amber-950">
                                @forelse($kelasKamars as $kelas)
                                    <tr class="hover:bg-amber-50/30 transition">
                                        <td class="px-6 py-4">
                                            <img src="{{ asset('storage/' . $kelas->thumbnail) }}"
                                                class="h-12 w-20 object-cover rounded-lg border border-amber-200 shadow-sm">
                                        </td>
                                        <td class="px-6 py-4 font-bold text-amber-700">{{ $kelas->nama_kelas }}</td>
                                        <td class="px-6 py-4 font-black text-emerald-600">Rp
                                            {{ number_format($kelas->harga, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-center font-bold text-gray-700">
                                            {{ $kelas->kapasitas ?? 1 }} Orang</td>
                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="bg-amber-100 text-amber-800 px-3 py-1 rounded-lg font-bold text-xs border border-amber-200">{{ $kelas->kamars_count }}
                                                Kamar</span>
                                        </td>
                                        <td class="px-6 py-4 text-right space-x-2">
                                            <button
                                                onclick="openEditKelas({{ $kelas->id }}, '{{ $kelas->nama_kelas }}', {{ $kelas->harga }}, {{ $kelas->kapasitas ?? 1 }}, {{ json_encode($kelas->fasilitas) }}, '{{ $kelas->thumbnail }}', '{{ $kelas->foto_1 }}', '{{ $kelas->foto_2 }}', '{{ $kelas->foto_3 }}')"
                                                class="rounded-lg bg-amber-50 border border-amber-200 px-4 py-2 text-xs font-bold text-amber-700 hover:bg-amber-100 transition shadow-sm">Edit</button>

                                            <form action="{{ route('kelas.destroy', $kelas->id) }}" method="POST"
                                                class="inline-block"
                                                onsubmit="return confirm('Hapus Kelas ini akan MENGHAPUS SEMUA RUANGAN di dalamnya. Lanjutkan?');">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="rounded-lg bg-white border border-red-200 px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-50 transition shadow-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-amber-900/40 font-medium">
                                            Katalog kelas kamar tidak ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-4">{{ $kelasKamars->appends(['tab' => 'kelas'])->links() }}</div>
            </div>

            <div x-show="tab === 'ruangan'" x-cloak>
                <div
                    class="mb-6 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 border-b border-amber-100 pb-5">
                    <form method="GET" action="{{ route('kamar') }}"
                        class="flex flex-wrap gap-2 w-full xl:w-auto">
                        <input type="hidden" name="tab" value="ruangan">
                        <input type="text" name="ruangan_search" value="{{ request('ruangan_search') }}"
                            placeholder="Cari No. Ruangan..."
                            class="border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 py-2.5 px-3 text-sm border w-full sm:w-40 transition text-amber-950">
                        <select name="ruangan_kelas"
                            class="border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 py-2.5 px-3 text-sm border bg-white max-w-xs transition text-amber-950">
                            <option value="">Semua Tipe Kelas</option>
                            @foreach ($semuaKelas as $kelas)
                                <option value="{{ $kelas->id }}"
                                    {{ request('ruangan_kelas') == $kelas->id ? 'selected' : '' }}>
                                    {{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                        <select name="ruangan_status"
                            class="border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 py-2.5 px-3 text-sm border bg-white transition text-amber-950">
                            <option value="">Semua Status</option>
                            <option value="Tersedia" {{ request('ruangan_status') == 'Tersedia' ? 'selected' : '' }}>
                                Tersedia</option>
                            <option value="Terpakai" {{ request('ruangan_status') == 'Terpakai' ? 'selected' : '' }}>
                                Terpakai</option>
                            <option value="Dibooking"
                                {{ request('ruangan_status') == 'Dibooking' ? 'selected' : '' }}>Dibooking</option>
                            <option value="Maintenance"
                                {{ request('ruangan_status') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                        <select name="ruangan_per_page"
                            class="border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 py-2.5 px-3 text-sm border bg-white transition text-amber-950">
                            <option value="5" {{ request('ruangan_per_page') == 5 ? 'selected' : '' }}>5 Baris
                            </option>
                            <option value="10" {{ request('ruangan_per_page') == 10 ? 'selected' : '' }}>10 Baris
                            </option>
                            <option value="15" {{ request('ruangan_per_page') == 15 ? 'selected' : '' }}>15 Baris
                            </option>
                            <option value="20" {{ request('ruangan_per_page') == 20 ? 'selected' : '' }}>20 Baris
                            </option>
                        </select>
                        <button type="submit"
                            class="bg-amber-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-amber-700 transition shadow-sm text-center">Cari</button>
                        @if (request('ruangan_search') || request('ruangan_kelas') || request('ruangan_status'))
                            <a href="{{ route('kamar', ['tab' => 'ruangan']) }}"
                                class="bg-white text-amber-700 px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-amber-50 transition border border-amber-200 shadow-sm flex items-center justify-center">Reset</a>
                        @endif
                    </form>

                    @if ($semuaKelas->isEmpty())
                        <p class="text-sm text-red-600 font-bold whitespace-nowrap self-center">* Buat Kelas Kamar
                            dulu.</p>
                    @else
                        <button onclick="document.getElementById('modalRuanganAdd').classList.remove('hidden')"
                            class="bg-amber-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-amber-700 transition shadow-sm shadow-amber-600/20 whitespace-nowrap flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Ruangan
                        </button>
                    @endif
                </div>

                <div class="bg-white shadow-sm rounded-xl border border-amber-100 overflow-hidden mb-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y-2 divide-amber-50 bg-white text-sm text-left">
                            <thead
                                class="bg-amber-50/50 border-b border-amber-100 text-amber-900 font-bold uppercase tracking-wider text-[11px]">
                                <tr>
                                    <th class="px-6 py-4">Nomor Ruangan</th>
                                    <th class="px-6 py-4">Tipe Kelas</th>
                                    <th class="px-6 py-4">Status Saat Ini</th>
                                    <th class="px-6 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-amber-50 text-amber-950">
                                @forelse($kamars as $kamar)
                                    <tr class="hover:bg-amber-50/30 transition">
                                        <td class="px-6 py-4 font-black text-amber-950 text-lg">
                                            #{{ $kamar->nomor_ruangan }}</td>
                                        <td class="px-6 py-4 text-amber-700 font-bold">
                                            {{ $kamar->kelasKamar->nama_kelas }}</td>
                                        <td class="px-6 py-4">
                                            @php
                                                $color = match ($kamar->status) {
                                                    'Tersedia' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                    'Terpakai' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                    'Dibooking' => 'bg-orange-50 text-orange-700 border-orange-200',
                                                    'Maintenance' => 'bg-red-50 text-red-700 border-red-200',
                                                };
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold border {{ $color }}">
                                                {{ $kamar->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right space-x-2">
                                            <button
                                                onclick="openEditRuangan({{ $kamar->id }}, {{ $kamar->kelas_kamar_id }}, '{{ $kamar->nomor_ruangan }}', '{{ $kamar->status }}')"
                                                class="rounded-lg bg-amber-50 border border-amber-200 px-4 py-2 text-xs font-bold text-amber-700 hover:bg-amber-100 transition shadow-sm">Edit</button>
                                            <form action="{{ route('kamar.destroy', $kamar->id) }}" method="POST"
                                                class="inline-block" onsubmit="return confirm('Hapus ruangan ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="rounded-lg bg-white border border-red-200 px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-50 transition shadow-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="px-6 py-12 text-center text-amber-900/40 font-medium">Ruangan fisik
                                            tidak ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-4">{{ $kamars->appends(['tab' => 'ruangan'])->links() }}</div>
            </div>
        </div>
    </div>

    <div id="modalKelas" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden border border-amber-100">
                <div class="bg-amber-600 px-6 py-4 flex justify-between items-center text-white">
                    <h3 class="font-bold text-lg">Tambah Kelas Kamar (Katalog)</h3>
                    <button type="button" onclick="document.getElementById('modalKelas').classList.add('hidden')"
                        class="text-amber-100 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('kelas.store') }}" enctype="multipart/form-data"
                    class="p-6">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-amber-950 mb-1">Kapasitas (Orang)</label>
                            <input type="number" name="kapasitas" required min="1" value="2"
                                class="w-full border border-amber-200 rounded-lg p-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 shadow-sm transition">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-amber-950 mb-1">Harga / Malam</label>
                            <input type="number" name="harga" required min="0"
                                class="w-full border border-amber-200 rounded-lg p-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 shadow-sm transition">
                        </div>
                        <div class="sm:col-span-3">
                            <label class="block text-xs font-bold text-amber-950 mb-1">Nama Kelas</label>
                            <input type="text" name="nama_kelas" placeholder="Cth: Superior Double Bed" required
                                class="w-full border border-amber-200 rounded-lg p-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 shadow-sm transition">
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block text-xs font-bold text-amber-950 mb-2">Fasilitas Tersedia</label>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach (['AC', 'TV', 'Kipas Angin', 'Single Bed', 'Double Bed', 'Sarapan'] as $fas)
                                <label
                                    class="flex items-center gap-2 text-sm font-medium text-amber-900 cursor-pointer">
                                    <input type="checkbox" name="fasilitas[]" value="{{ $fas }}"
                                        class="w-4 h-4 rounded border-amber-300 text-amber-600 focus:ring-amber-500">
                                    <span>{{ $fas }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-6 bg-amber-50/50 p-4 rounded-xl border border-amber-100 shadow-inner">
                        <label class="block text-xs font-bold text-amber-950 mb-1">Upload 3 Foto Kamar (Drag &
                            Drop)</label>
                        <p class="text-[10px] font-bold text-amber-600 mb-3">*Foto 1 akan otomatis menjadi foto utama
                            (Thumbnail).</p>

                        <div class="grid grid-cols-3 gap-3">
                            <div
                                class="relative border-2 border-dashed border-amber-300 rounded-xl p-3 text-center hover:bg-amber-50 hover:border-amber-500 transition group h-28 flex items-center justify-center overflow-hidden bg-white">
                                <input type="file" name="foto_1" accept="image/*"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                    onchange="previewDragDrop(this, 'prev_add_1', 'text_add_1')">
                                <img id="prev_add_1" src=""
                                    class="hidden absolute inset-0 w-full h-full object-cover">
                                <div id="text_add_1" class="pointer-events-none flex flex-col items-center">
                                    <svg class="w-6 h-6 text-amber-400 group-hover:text-amber-500 mb-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    <span class="text-[10px] text-amber-700 font-bold">Foto 1 (Utama)</span>
                                </div>
                            </div>
                            <div
                                class="relative border-2 border-dashed border-amber-300 rounded-xl p-3 text-center hover:bg-amber-50 hover:border-amber-500 transition group h-28 flex items-center justify-center overflow-hidden bg-white">
                                <input type="file" name="foto_2" accept="image/*"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                    onchange="previewDragDrop(this, 'prev_add_2', 'text_add_2')">
                                <img id="prev_add_2" src=""
                                    class="hidden absolute inset-0 w-full h-full object-cover">
                                <div id="text_add_2" class="pointer-events-none flex flex-col items-center">
                                    <svg class="w-6 h-6 text-amber-400 group-hover:text-amber-500 mb-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    <span class="text-[10px] text-amber-700 font-bold">Foto 2</span>
                                </div>
                            </div>
                            <div
                                class="relative border-2 border-dashed border-amber-300 rounded-xl p-3 text-center hover:bg-amber-50 hover:border-amber-500 transition group h-28 flex items-center justify-center overflow-hidden bg-white">
                                <input type="file" name="foto_3" accept="image/*"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                    onchange="previewDragDrop(this, 'prev_add_3', 'text_add_3')">
                                <img id="prev_add_3" src=""
                                    class="hidden absolute inset-0 w-full h-full object-cover">
                                <div id="text_add_3" class="pointer-events-none flex flex-col items-center">
                                    <svg class="w-6 h-6 text-amber-400 group-hover:text-amber-500 mb-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    <span class="text-[10px] text-amber-700 font-bold">Foto 3</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 border-t border-amber-100 pt-5">
                        <button type="button" onclick="document.getElementById('modalKelas').classList.add('hidden')"
                            class="px-5 py-2.5 rounded-xl bg-white border border-gray-200 text-gray-700 font-bold hover:bg-gray-50 transition shadow-sm">Batal</button>
                        <button type="submit"
                            class="px-5 py-2.5 rounded-xl bg-amber-600 text-white font-bold hover:bg-amber-700 transition shadow-sm shadow-amber-600/30">Simpan
                            Kelas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modalKelasEdit" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden border border-amber-100">
                <div class="bg-amber-600 px-6 py-4 flex justify-between items-center text-white">
                    <h3 class="font-bold text-lg">Edit Kelas Kamar (Katalog)</h3>
                    <button type="button" onclick="document.getElementById('modalKelasEdit').classList.add('hidden')"
                        class="text-amber-100 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form id="formEditKelas" method="POST" action="" enctype="multipart/form-data"
                    class="p-6">
                    @csrf @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-amber-950 mb-1">Kapasitas (Orang)</label>
                            <input type="number" id="edit_kapasitas" name="kapasitas" required min="1"
                                class="w-full border border-amber-200 rounded-lg p-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 shadow-sm transition">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-amber-950 mb-1">Harga / Malam</label>
                            <input type="number" id="edit_harga_kelas" name="harga" required min="0"
                                class="w-full border border-amber-200 rounded-lg p-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 shadow-sm transition">
                        </div>
                        <div class="sm:col-span-3">
                            <label class="block text-xs font-bold text-amber-950 mb-1">Nama Kelas</label>
                            <input type="text" id="edit_nama_kelas" name="nama_kelas" required
                                class="w-full border border-amber-200 rounded-lg p-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 shadow-sm transition">
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block text-xs font-bold text-amber-950 mb-2">Fasilitas Tersedia</label>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach (['AC', 'TV', 'Kipas Angin', 'Single Bed', 'Double Bed', 'Sarapan'] as $fas)
                                <label
                                    class="flex items-center gap-2 text-sm font-medium text-amber-900 cursor-pointer">
                                    <input type="checkbox" name="fasilitas[]" value="{{ $fas }}"
                                        class="edit-fas-cb w-4 h-4 rounded border-amber-300 text-amber-600 focus:ring-amber-500">
                                    <span>{{ $fas }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-6 bg-amber-50/50 p-4 rounded-xl border border-amber-100 shadow-inner">
                        <label class="block text-xs font-bold text-amber-950 mb-2">Ubah Foto (Drag & Drop) & Pilih
                            Thumbnail</label>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach (['foto_1', 'foto_2', 'foto_3'] as $fotoField)
                                <div
                                    class="bg-white border-2 border-dashed border-amber-300 rounded-xl p-2 hover:border-amber-500 transition relative group h-32 flex flex-col justify-between overflow-hidden shadow-sm">
                                    <input type="file" name="{{ $fotoField }}" accept="image/*"
                                        class="absolute inset-0 w-full h-16 opacity-0 cursor-pointer z-10"
                                        onchange="previewDragDrop(this, 'prev_{{ $fotoField }}', 'text_{{ $fotoField }}')">

                                    <div
                                        class="h-20 w-full relative flex items-center justify-center bg-gray-50 rounded-lg mb-2 overflow-hidden border border-gray-100">
                                        <img id="prev_{{ $fotoField }}" src=""
                                            class="absolute inset-0 w-full h-full object-cover hidden z-0">
                                        <div id="text_{{ $fotoField }}"
                                            class="z-0 pointer-events-none flex flex-col items-center">
                                            <svg class="w-5 h-5 text-amber-400 group-hover:text-amber-500"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12">
                                                </path>
                                            </svg>
                                            <span class="text-[9px] text-amber-700 font-bold">Ubah Foto</span>
                                        </div>
                                    </div>

                                    <label
                                        class="flex items-center justify-center gap-1 cursor-pointer bg-amber-50 rounded-md py-1 z-20 relative border border-amber-200 hover:bg-amber-100 transition">
                                        <input type="radio" id="radio_{{ $fotoField }}"
                                            name="thumbnail_selection" value="{{ $fotoField }}"
                                            class="text-amber-600 w-3 h-3 focus:ring-amber-500 border-amber-300">
                                        <span class="text-[9px] font-bold text-amber-900 leading-none mt-0.5">Jadikan
                                            Utama</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 border-t border-amber-100 pt-5">
                        <button type="button"
                            onclick="document.getElementById('modalKelasEdit').classList.add('hidden')"
                            class="px-5 py-2.5 rounded-xl bg-white border border-gray-200 text-gray-700 font-bold hover:bg-gray-50 transition shadow-sm">Batal</button>
                        <button type="submit"
                            class="px-5 py-2.5 rounded-xl bg-amber-600 text-white font-bold hover:bg-amber-700 transition shadow-sm shadow-amber-600/30">Update
                            Kelas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modalRuanganAdd" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden border border-amber-100">
                <div class="bg-amber-600 px-6 py-4 flex justify-between items-center text-white">
                    <h3 class="font-bold text-lg">Tambah Ruangan Fisik</h3>
                    <button type="button"
                        onclick="document.getElementById('modalRuanganAdd').classList.add('hidden')"
                        class="text-amber-100 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('kamar.store') }}" class="p-6">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-amber-950 mb-1">Pilih Kelas Kamar</label>
                        <select name="kelas_kamar_id" required
                            class="w-full border border-amber-200 rounded-lg shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 p-2.5 text-sm bg-white transition">
                            @foreach ($semuaKelas as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-6">
                        <label class="block text-xs font-bold text-amber-950 mb-1">Nomor Ruangan (Cth: 101,
                            VIP-01)</label>
                        <input type="text" name="nomor_ruangan" required
                            class="w-full border border-amber-200 rounded-lg shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 p-2.5 text-sm transition">
                    </div>
                    <input type="hidden" name="status" value="Tersedia">
                    <div class="flex justify-end gap-3 border-t border-amber-100 pt-5">
                        <button type="button"
                            onclick="document.getElementById('modalRuanganAdd').classList.add('hidden')"
                            class="px-5 py-2.5 rounded-xl bg-white border border-gray-200 text-gray-700 font-bold hover:bg-gray-50 transition shadow-sm">Batal</button>
                        <button type="submit"
                            class="px-5 py-2.5 rounded-xl bg-amber-600 text-white font-bold hover:bg-amber-700 transition shadow-sm shadow-amber-600/30">Simpan
                            Ruangan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modalRuanganEdit" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden border border-amber-100">
                <div class="bg-amber-600 px-6 py-4 flex justify-between items-center text-white">
                    <h3 class="font-bold text-lg">Update Ruangan <span id="editRuangTitle"
                            class="text-amber-200 underline"></span></h3>
                    <button type="button"
                        onclick="document.getElementById('modalRuanganEdit').classList.add('hidden')"
                        class="text-amber-100 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form id="formEditRuang" method="POST" action="" class="p-6">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-amber-950 mb-1">Ubah Kelas Kamar</label>
                        <select id="edit_kelas_kamar_id" name="kelas_kamar_id" required
                            class="w-full border border-amber-200 rounded-lg shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 p-2.5 text-sm bg-white transition">
                            @foreach ($semuaKelas as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-amber-950 mb-1">Nomor Ruangan</label>
                        <input type="text" id="edit_nomor_ruangan" name="nomor_ruangan" required
                            class="w-full border border-amber-200 rounded-lg shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 p-2.5 text-sm transition">
                    </div>
                    <div class="mb-6">
                        <label class="block text-xs font-bold text-amber-950 mb-1">Status Saat Ini</label>
                        <select id="edit_status" name="status" required
                            class="w-full border border-amber-200 rounded-lg shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 p-2.5 text-sm bg-white transition">
                            <option value="Tersedia">Tersedia (Ready)</option>
                            <option value="Terpakai">Terpakai (In Use)</option>
                            <option value="Dibooking">Dibooking (Booked)</option>
                            <option value="Maintenance">Maintenance</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-3 border-t border-amber-100 pt-5">
                        <button type="button"
                            onclick="document.getElementById('modalRuanganEdit').classList.add('hidden')"
                            class="px-5 py-2.5 rounded-xl bg-white border border-gray-200 text-gray-700 font-bold hover:bg-gray-50 transition shadow-sm">Batal</button>
                        <button type="submit"
                            class="px-5 py-2.5 rounded-xl bg-amber-600 text-white font-bold hover:bg-amber-700 transition shadow-sm shadow-amber-600/30">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        // FUNGSI PREVIEW GAMBAR DRAG & DROP
        function previewDragDrop(input, imgId, textId) {
            const img = document.getElementById(imgId);
            const text = document.getElementById(textId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                    if (text) text.classList.add('hidden'); // Sembunyikan icon/text upload
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // FUNGSI BUKA MODAL EDIT KELAS (Disesuaikan dengan parameter kapasitas)
        function openEditKelas(id, nama, harga, kapasitas, fasilitas, thumb, foto1, foto2, foto3) {
            document.getElementById('formEditKelas').action = '/kelas-kamar/' + id;
            document.getElementById('edit_nama_kelas').value = nama;
            document.getElementById('edit_harga_kelas').value = harga;
            document.getElementById('edit_kapasitas').value = kapasitas;

            // Load Preview Gambar (Panggil dari Database)
            const setPreview = (id, val) => {
                const img = document.getElementById('prev_' + id);
                const txt = document.getElementById('text_' + id);
                if (img) {
                    if (val) {
                        img.src = '/storage/' + val;
                        img.classList.remove('hidden');
                        if (txt) txt.classList.add('hidden');
                    } else {
                        img.src = '';
                        img.classList.add('hidden');
                        if (txt) txt.classList.remove('hidden');
                    }
                }
            };

            setPreview('foto_1', foto1);
            setPreview('foto_2', foto2);
            setPreview('foto_3', foto3);

            // Radio Button Thumbnail Auto-Select
            let radios = document.getElementsByName('thumbnail_selection');
            radios.forEach(r => r.checked = false);
            if (thumb === foto1 && foto1) document.getElementById('radio_foto_1').checked = true;
            else if (thumb === foto2 && foto2) document.getElementById('radio_foto_2').checked = true;
            else if (thumb === foto3 && foto3) document.getElementById('radio_foto_3').checked = true;
            else if (radios[0]) radios[0].checked = true; // Default to photo 1

            // Centang Fasilitas Otomatis
            let checkboxes = document.querySelectorAll('.edit-fas-cb');
            checkboxes.forEach(cb => cb.checked = false);

            let fasArr = fasilitas;
            if (typeof fasArr === 'string') {
                try {
                    fasArr = JSON.parse(fasArr);
                } catch (e) {
                    fasArr = [];
                }
            }
            if (Array.isArray(fasArr)) {
                checkboxes.forEach(cb => {
                    if (fasArr.includes(cb.value)) cb.checked = true;
                });
            }

            document.getElementById('modalKelasEdit').classList.remove('hidden');
        }

        function openEditRuangan(id, kelasId, nomor, status) {
            document.getElementById('formEditRuang').action = '/kamar/' + id;
            document.getElementById('editRuangTitle').innerText = "#" + nomor;
            document.getElementById('edit_kelas_kamar_id').value = kelasId;
            document.getElementById('edit_nomor_ruangan').value = nomor;
            document.getElementById('edit_status').value = status;
            document.getElementById('modalRuanganEdit').classList.remove('hidden');
        }
    </script>
</x-dblayout>

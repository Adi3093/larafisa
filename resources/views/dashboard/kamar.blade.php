<x-dblayout>
    <div class="max-w-7xl mx-auto" x-data="{ tab: '{{ $activeTab }}' }">

        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Kamar & Ruangan</h1>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 text-green-700 rounded-r-lg">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 text-red-700 rounded-r-lg">
                <ul class="list-disc pl-5 text-sm font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="border-b border-gray-200 mb-6 flex space-x-8">
            <button @click="tab = 'kelas'"
                :class="{ 'border-indigo-500 text-indigo-600': tab === 'kelas', 'border-transparent text-gray-500 hover:text-gray-700': tab !== 'kelas' }"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition">
                Katalog Kelas Kamar
            </button>
            <button @click="tab = 'ruangan'"
                :class="{ 'border-indigo-500 text-indigo-600': tab === 'ruangan', 'border-transparent text-gray-500 hover:text-gray-700': tab !== 'ruangan' }"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition">
                Daftar Fisik Ruangan
            </button>
        </div>

        <div x-show="tab === 'kelas'" x-cloak>

            <div class="mb-4 flex flex-col lg:flex-row justify-between gap-4">
                <form method="GET" action="{{ route('kamar') }}" class="flex flex-wrap gap-2 w-full lg:w-auto">
                    <input type="hidden" name="tab" value="kelas">

                    <input type="text" name="kelas_search" value="{{ request('kelas_search') }}"
                        placeholder="Cari nama kelas..."
                        class="border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 text-sm border w-full sm:w-48">

                    <select name="kelas_harga"
                        class="border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 text-sm border bg-white">
                        <option value="">Urutkan Harga...</option>
                        <option value="murah" {{ request('kelas_harga') == 'murah' ? 'selected' : '' }}>Termurah -
                            Termahal</option>
                        <option value="mahal" {{ request('kelas_harga') == 'mahal' ? 'selected' : '' }}>Termahal -
                            Termurah</option>
                    </select>

                    <select name="kelas_per_page"
                        class="border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 text-sm border bg-white">
                        <option value="5" {{ request('kelas_per_page') == 5 ? 'selected' : '' }}>5 Baris</option>
                        <option value="10" {{ request('kelas_per_page') == 10 ? 'selected' : '' }}>10 Baris</option>
                        <option value="15" {{ request('kelas_per_page') == 15 ? 'selected' : '' }}>15 Baris</option>
                        <option value="20" {{ request('kelas_per_page') == 20 ? 'selected' : '' }}>20 Baris
                        </option>
                    </select>

                    <button type="submit"
                        class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 border border-gray-200">Cari</button>

                    @if (request('kelas_search') || request('kelas_harga'))
                        <a href="{{ route('kamar', ['tab' => 'kelas']) }}"
                            class="bg-red-50 text-red-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-100 flex items-center border border-red-200">Reset</a>
                    @endif
                </form>

                <button onclick="document.getElementById('modalKelas').classList.remove('hidden')"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 transition whitespace-nowrap">
                    + Tambah Kelas
                </button>
            </div>

            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden mb-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 font-medium text-gray-900">Thumbnail</th>
                                <th class="px-4 py-3 font-medium text-gray-900">Nama Kelas</th>
                                <th class="px-4 py-3 font-medium text-gray-900">Harga / Malam</th>
                                <th class="px-4 py-3 font-medium text-gray-900">Total Ruangan</th>
                                <th class="px-4 py-3 font-medium text-gray-900 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($kelasKamars as $kelas)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <img src="{{ asset('storage/' . $kelas->thumbnail) }}"
                                            class="h-12 w-20 object-cover rounded border border-gray-200">
                                    </td>
                                    <td class="px-4 py-3 font-bold text-indigo-600">{{ $kelas->nama_kelas }}</td>
                                    <td class="px-4 py-3 font-semibold text-gray-700">Rp
                                        {{ number_format($kelas->harga, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3"><span
                                            class="bg-gray-100 text-gray-700 px-2 py-1 rounded font-bold">{{ $kelas->kamars_count }}
                                            Kamar</span></td>
                                    <td class="px-4 py-3 text-center space-x-2">
                                        <button
                                            onclick="openEditKelas({{ $kelas->id }}, '{{ $kelas->nama_kelas }}', {{ $kelas->harga }}, {{ json_encode($kelas->fasilitas) }}, '{{ $kelas->thumbnail }}', '{{ $kelas->foto_1 }}', '{{ $kelas->foto_2 }}', '{{ $kelas->foto_3 }}')"
                                            class="rounded bg-indigo-50 px-3 py-1.5 text-xs font-medium text-indigo-700 hover:bg-indigo-100">Edit</button>

                                        <form action="{{ route('kelas.destroy', $kelas->id) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Hapus Kelas ini akan MENGHAPUS SEMUA RUANGAN di dalamnya. Lanjutkan?');">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="rounded bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-500">Katalog kelas kamar
                                        tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-4">
                {{ $kelasKamars->appends(['tab' => 'kelas'])->links() }}
            </div>
        </div>

        <div x-show="tab === 'ruangan'" x-cloak>

            <div class="mb-4 flex flex-col xl:flex-row justify-between gap-4">
                <form method="GET" action="{{ route('kamar') }}" class="flex flex-wrap gap-2 w-full xl:w-auto">
                    <input type="hidden" name="tab" value="ruangan">

                    <input type="text" name="ruangan_search" value="{{ request('ruangan_search') }}"
                        placeholder="Cari No. Ruangan..."
                        class="border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 text-sm border w-full sm:w-40">

                    <select name="ruangan_kelas"
                        class="border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 text-sm border bg-white max-w-xs">
                        <option value="">Semua Tipe Kelas</option>
                        @foreach ($semuaKelas as $kelas)
                            <option value="{{ $kelas->id }}"
                                {{ request('ruangan_kelas') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>

                    <select name="ruangan_status"
                        class="border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 text-sm border bg-white">
                        <option value="">Semua Status</option>
                        <option value="Tersedia" {{ request('ruangan_status') == 'Tersedia' ? 'selected' : '' }}>
                            Tersedia</option>
                        <option value="Terpakai" {{ request('ruangan_status') == 'Terpakai' ? 'selected' : '' }}>
                            Terpakai</option>
                        <option value="Dibooking" {{ request('ruangan_status') == 'Dibooking' ? 'selected' : '' }}>
                            Dibooking</option>
                        <option value="Maintenance" {{ request('ruangan_status') == 'Maintenance' ? 'selected' : '' }}>
                            Maintenance</option>
                    </select>

                    <select name="ruangan_per_page"
                        class="border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 text-sm border bg-white">
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
                        class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 border border-gray-200">Cari</button>

                    @if (request('ruangan_search') || request('ruangan_kelas') || request('ruangan_status'))
                        <a href="{{ route('kamar', ['tab' => 'ruangan']) }}"
                            class="bg-red-50 text-red-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-100 flex items-center border border-red-200">Reset</a>
                    @endif
                </form>

                @if ($semuaKelas->isEmpty())
                    <p class="text-sm text-red-600 font-medium whitespace-nowrap self-center">* Buat Kelas Kamar dulu.
                    </p>
                @else
                    <button onclick="document.getElementById('modalRuanganAdd').classList.remove('hidden')"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 transition whitespace-nowrap">
                        + Tambah Ruangan
                    </button>
                @endif
            </div>

            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden mb-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 font-medium text-gray-900">Nomor Ruangan</th>
                                <th class="px-4 py-3 font-medium text-gray-900">Tipe Kelas</th>
                                <th class="px-4 py-3 font-medium text-gray-900">Status Saat Ini</th>
                                <th class="px-4 py-3 font-medium text-gray-900 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($kamars as $kamar)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 font-bold text-gray-900 text-lg">#{{ $kamar->nomor_ruangan }}
                                    </td>
                                    <td class="px-4 py-3 text-indigo-600 font-medium">
                                        {{ $kamar->kelasKamar->nama_kelas }}</td>
                                    <td class="px-4 py-3">
                                        @php
                                            $color = match ($kamar->status) {
                                                'Tersedia' => 'bg-green-100 text-green-700',
                                                'Terpakai' => 'bg-blue-100 text-blue-700',
                                                'Dibooking' => 'bg-yellow-100 text-yellow-700',
                                                'Maintenance' => 'bg-red-100 text-red-700',
                                            };
                                        @endphp
                                        <span
                                            class="inline-block px-3 py-1 rounded-full text-xs font-bold {{ $color }}">
                                            {{ $kamar->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center space-x-2">
                                        <button
                                            onclick="openEditRuangan({{ $kamar->id }}, {{ $kamar->kelas_kamar_id }}, '{{ $kamar->nomor_ruangan }}', '{{ $kamar->status }}')"
                                            class="rounded bg-indigo-50 px-3 py-1.5 text-xs font-medium text-indigo-700 hover:bg-indigo-100">Edit</button>
                                        <form action="{{ route('kamar.destroy', $kamar->id) }}" method="POST"
                                            class="inline-block" onsubmit="return confirm('Hapus ruangan ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="rounded bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">Ruangan fisik tidak
                                        ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-4">
                {{ $kamars->appends(['tab' => 'ruangan'])->links() }}
            </div>
        </div>
    </div>

    <div id="modalKelas" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b font-bold text-lg">Tambah Kelas Kamar (Katalog)</div>
                <form method="POST" action="{{ route('kelas.store') }}" enctype="multipart/form-data"
                    class="p-6">
                    @csrf
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div><label class="block text-sm font-medium mb-1">Nama Kelas</label><input type="text"
                                name="nama_kelas" required class="w-full border rounded p-2"></div>
                        <div><label class="block text-sm font-medium mb-1">Harga / Malam</label><input type="number"
                                name="harga" required class="w-full border rounded p-2"></div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Fasilitas Tersedia</label>
                        <div class="grid grid-cols-3 gap-2">
                            @foreach (['AC', 'TV', 'Kipas Angin', 'Single Bed', 'Double Bed', 'Sarapan'] as $fas)
                                <label class="flex items-center gap-2 text-sm"><input type="checkbox"
                                        name="fasilitas[]" value="{{ $fas }}"
                                        class="rounded text-indigo-600">{{ $fas }}</label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-4 bg-gray-50 p-3 rounded border">
                        <label class="block text-sm font-bold text-gray-900 mb-2">Upload 3 Foto Kamar</label>
                        <div class="grid grid-cols-3 gap-2">
                            <div><label class="block text-xs font-medium mb-1">Foto 1</label><input type="file"
                                    name="foto_1" accept="image/*" class="text-xs w-full"></div>
                            <div><label class="block text-xs font-medium mb-1">Foto 2</label><input type="file"
                                    name="foto_2" accept="image/*" class="text-xs w-full"></div>
                            <div><label class="block text-xs font-medium mb-1">Foto 3</label><input type="file"
                                    name="foto_3" accept="image/*" class="text-xs w-full"></div>
                        </div>
                        <p class="text-[11px] text-gray-500 mt-2">*Foto 1 akan otomatis menjadi foto utama (Thumbnail).
                        </p>
                    </div>

                    <div class="flex justify-end gap-2 border-t pt-4">
                        <button type="button" onclick="document.getElementById('modalKelas').classList.add('hidden')"
                            class="px-4 py-2 border rounded bg-white text-gray-700 hover:bg-gray-50">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 rounded bg-indigo-600 text-white font-bold hover:bg-indigo-700">Simpan
                            Kelas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modalRuanganAdd" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b font-bold text-lg">Tambah Ruangan Fisik</div>
                <form method="POST" action="{{ route('kamar.store') }}" class="p-6">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Pilih Kelas Kamar</label>
                        <select name="kelas_kamar_id" required class="w-full border rounded p-2 bg-white">
                            @foreach ($semuaKelas as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Nomor Ruangan (Cth: 101, VIP-01)</label>
                        <input type="text" name="nomor_ruangan" required class="w-full border rounded p-2">
                    </div>
                    <input type="hidden" name="status" value="Tersedia">
                    <div class="flex justify-end gap-2 border-t pt-4">
                        <button type="button"
                            onclick="document.getElementById('modalRuanganAdd').classList.add('hidden')"
                            class="px-4 py-2 border rounded bg-white text-gray-700 hover:bg-gray-50">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 rounded bg-indigo-600 text-white font-bold hover:bg-indigo-700">Simpan
                            Ruangan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modalRuanganEdit" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b font-bold text-lg">Update Ruangan <span id="editRuangTitle"
                        class="text-indigo-600"></span></div>
                <form id="formEditRuang" method="POST" action="" class="p-6">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Ubah Kelas Kamar</label>
                        <select id="edit_kelas_kamar_id" name="kelas_kamar_id" required
                            class="w-full border rounded p-2 bg-white">
                            @foreach ($semuaKelas as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Nomor Ruangan</label>
                        <input type="text" id="edit_nomor_ruangan" name="nomor_ruangan" required
                            class="w-full border rounded p-2">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Status Saat Ini</label>
                        <select id="edit_status" name="status" required class="w-full border rounded p-2 bg-white">
                            <option value="Tersedia">Tersedia (Ready)</option>
                            <option value="Terpakai">Terpakai (In Use)</option>
                            <option value="Dibooking">Dibooking (Booked)</option>
                            <option value="Maintenance">Maintenance</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-2 border-t pt-4">
                        <button type="button"
                            onclick="document.getElementById('modalRuanganEdit').classList.add('hidden')"
                            class="px-4 py-2 border rounded bg-white text-gray-700 hover:bg-gray-50">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 rounded bg-indigo-600 text-white font-bold hover:bg-indigo-700">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modalKelasEdit" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b font-bold text-lg">Edit Kelas Kamar (Katalog)</div>
                <form id="formEditKelas" method="POST" action="" enctype="multipart/form-data"
                    class="p-6">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div><label class="block text-sm font-medium mb-1">Nama Kelas</label><input type="text"
                                id="edit_nama_kelas" name="nama_kelas" required class="w-full border rounded p-2">
                        </div>
                        <div><label class="block text-sm font-medium mb-1">Harga / Malam</label><input type="number"
                                id="edit_harga_kelas" name="harga" required class="w-full border rounded p-2">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Fasilitas Tersedia</label>
                        <div class="grid grid-cols-3 gap-2">
                            @foreach (['AC', 'TV', 'Kipas Angin', 'Single Bed', 'Double Bed', 'Sarapan'] as $fas)
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="checkbox" name="fasilitas[]" value="{{ $fas }}"
                                        class="edit-fas-cb rounded text-indigo-600">{{ $fas }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-4 bg-gray-50 p-3 rounded border">
                        <label class="block text-sm font-bold text-gray-900 mb-2">Pilih Foto Utama & Ubah Foto</label>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach (['foto_1', 'foto_2', 'foto_3'] as $fotoField)
                                <label class="block cursor-pointer">
                                    <div class="border-2 rounded-lg p-2 hover:border-indigo-500 bg-white">
                                        <img id="prev_{{ $fotoField }}" src=""
                                            class="h-24 w-full object-cover rounded mb-2 bg-gray-100 hidden">

                                        <div class="flex items-center gap-2 mb-2 pb-2 border-b border-gray-100">
                                            <input type="radio" id="radio_{{ $fotoField }}"
                                                name="thumbnail_selection" value="{{ $fotoField }}"
                                                class="text-indigo-600 w-4 h-4 cursor-pointer">
                                            <span class="text-xs font-bold text-gray-700">Jadikan Thumbnail</span>
                                        </div>

                                        <span class="text-[10px] text-gray-500 mb-1 block">Ganti
                                            {{ str_replace('_', ' ', $fotoField) }}:</span>
                                        <input type="file" name="{{ $fotoField }}" accept="image/*"
                                            class="text-xs w-full">
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 border-t pt-4">
                        <button type="button"
                            onclick="document.getElementById('modalKelasEdit').classList.add('hidden')"
                            class="px-4 py-2 border rounded bg-white text-gray-700 hover:bg-gray-50">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 rounded bg-indigo-600 text-white font-bold hover:bg-indigo-700">Update
                            Kelas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        function openEditKelas(id, nama, harga, fasilitas, thumb, foto1, foto2, foto3) {
            document.getElementById('formEditKelas').action = '/kelas-kamar/' + id;
            document.getElementById('edit_nama_kelas').value = nama;
            document.getElementById('edit_harga_kelas').value = harga;

            // Load Preview Gambar
            const setPreview = (id, val) => {
                const img = document.getElementById('prev_' + id);
                if (img) {
                    if (val) {
                        img.src = '/storage/' + val;
                        img.classList.remove('hidden');
                    } else {
                        img.src = '';
                        img.classList.add('hidden'); // Sembunyikan ikon gambar rusak jika kosong
                    }
                }
            };

            setPreview('foto_1', foto1);
            setPreview('foto_2', foto2);
            setPreview('foto_3', foto3);

            // Set radio button aktif berdasarkan data thumbnail di database
            let radios = document.getElementsByName('thumbnail_selection');
            radios.forEach(r => r.checked = false); // Reset pilihan

            if (thumb === foto1 && foto1) document.getElementById('radio_foto_1').checked = true;
            else if (thumb === foto2 && foto2) document.getElementById('radio_foto_2').checked = true;
            else if (thumb === foto3 && foto3) document.getElementById('radio_foto_3').checked = true;
            else if (radios[0]) radios[0].checked = true; // Fallback jika tidak ada yang cocok, pilih foto 1

            // Bersihkan centang fasilitas lama
            let checkboxes = document.querySelectorAll('.edit-fas-cb');
            checkboxes.forEach(cb => cb.checked = false);

            // Centang otomatis berdasarkan data array fasilitas di database
            if (Array.isArray(fasilitas)) {
                checkboxes.forEach(cb => {
                    if (fasilitas.includes(cb.value)) {
                        cb.checked = true;
                    }
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

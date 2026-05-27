<x-dblayout>
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-900">Kelola Data Kamar</h1>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 text-green-700 rounded-r-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 text-red-700 rounded-r-lg shadow-sm text-sm">
                <p class="font-bold mb-1">Gagal menyimpan data:</p>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-4 flex flex-col sm:flex-row justify-between gap-4">
            <form method="GET" action="{{ route('kamar') }}" class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nomor atau kelas..."
                    class="border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 text-sm border w-full sm:w-64">

                <select name="per_page" onchange="this.form.submit()"
                    class="border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 text-sm border bg-white">
                    <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>Tampil 5 Baris</option>
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>Tampil 10 Baris</option>
                    <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>Tampil 15 Baris</option>
                    <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>Tampil 20 Baris</option>
                </select>

                <button type="submit"
                    class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 border border-gray-200">Cari</button>

                @if ($search)
                    <a href="{{ route('kamar') }}"
                        class="bg-red-50 text-red-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-100 flex items-center justify-center border border-red-200">Reset</a>
                @endif
            </form>

            <button onclick="openAddModal()"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 transition shadow-sm whitespace-nowrap">
                + Tambah Kamar
            </button>
        </div>

        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden mb-4">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                    <thead class="bg-gray-50 text-left">
                        <tr>
                            <th class="whitespace-nowrap px-4 py-3 font-medium text-gray-900">Thumbnail</th>
                            <th class="whitespace-nowrap px-4 py-3 font-medium text-gray-900">Ruangan & Kelas</th>
                            <th class="whitespace-nowrap px-4 py-3 font-medium text-gray-900">Harga / Malam</th>
                            <th class="whitespace-nowrap px-4 py-3 font-medium text-gray-900">Fasilitas</th>
                            <th class="whitespace-nowrap px-4 py-3 font-medium text-gray-900 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($kamars as $kamar)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="whitespace-nowrap px-4 py-3">
                                    <img src="{{ asset('storage/' . $kamar->thumbnail) }}" alt="Thumbnail"
                                        class="h-16 w-24 object-cover rounded-md border border-gray-200">
                                </td>

                                <td class="whitespace-nowrap px-4 py-3">
                                    <div class="font-bold text-indigo-600 text-lg">Kamar {{ $kamar->nomor_ruangan }}
                                    </div>
                                    <div class="text-gray-500 font-medium">{{ $kamar->kelas_kamar }}</div>
                                </td>

                                <td class="whitespace-nowrap px-4 py-3 font-semibold text-gray-700">
                                    Rp {{ number_format($kamar->harga, 0, ',', '.') }}
                                </td>

                                <td class="px-4 py-3 max-w-xs">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($kamar->fasilitas as $fasilitas)
                                            <span
                                                class="inline-flex items-center justify-center rounded-full bg-blue-50 px-2.5 py-0.5 text-blue-700 text-xs border border-blue-200">
                                                {{ $fasilitas }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-4 py-3 text-center space-x-2">
                                    <button
                                        onclick="openEditModal({{ $kamar->id }}, '{{ $kamar->kelas_kamar }}', '{{ $kamar->nomor_ruangan }}', {{ $kamar->harga }}, {{ json_encode($kamar->fasilitas) }})"
                                        class="inline-block rounded bg-indigo-50 px-3 py-1.5 text-xs font-medium text-indigo-700 hover:bg-indigo-100">
                                        Edit
                                    </button>

                                    <form action="{{ route('kamar.destroy', $kamar->id) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('PERINGATAN: Apakah Anda yakin ingin menghapus kamar nomor {{ $kamar->nomor_ruangan }} secara permanen? Data dan foto tidak dapat dikembalikan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-block rounded bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-12 text-center text-gray-500">
                                    Belum ada data kamar yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $kamars->links() }}
        </div>
    </div>

    <div id="addModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/60 backdrop-blur-sm"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4 text-left sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-3xl">
                <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                    <h3 class="text-xl font-bold text-gray-900">Tambah Data Kamar Baru</h3>
                </div>
                <form id="addForm" method="POST" action="{{ route('kamar.store') }}" enctype="multipart/form-data"
                    class="px-6 py-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="space-y-4">
                            <h4 class="font-semibold text-gray-700 border-b pb-2">Informasi Dasar</h4>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas Kamar</label>
                                <input type="text" name="kelas_kamar" list="kelas_options" required
                                    placeholder="Contoh: Deluxe Room"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Ruangan</label>
                                <input type="text" name="nomor_ruangan" required placeholder="Contoh: 101, 102A"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Harga per Malam (Rp)</label>
                                <input type="number" name="harga" required min="0"
                                    placeholder="Contoh: 500000"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border text-sm">
                            </div>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-700 border-b pb-2 mb-4">Fasilitas Kamar</h4>
                            <div class="grid grid-cols-2 gap-3">
                                <label
                                    class="flex items-center gap-2 cursor-pointer bg-gray-50 p-2 rounded border border-gray-200 hover:bg-indigo-50 transition"><input
                                        type="checkbox" name="fasilitas[]" value="TV"
                                        class="size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"><span
                                        class="text-sm font-medium text-gray-700">Televisi (TV)</span></label>
                                <label
                                    class="flex items-center gap-2 cursor-pointer bg-gray-50 p-2 rounded border border-gray-200 hover:bg-indigo-50 transition"><input
                                        type="checkbox" name="fasilitas[]" value="AC"
                                        class="size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"><span
                                        class="text-sm font-medium text-gray-700">AC</span></label>
                                <label
                                    class="flex items-center gap-2 cursor-pointer bg-gray-50 p-2 rounded border border-gray-200 hover:bg-indigo-50 transition"><input
                                        type="checkbox" name="fasilitas[]" value="Kipas Angin"
                                        class="size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"><span
                                        class="text-sm font-medium text-gray-700">Kipas Angin</span></label>
                                <label
                                    class="flex items-center gap-2 cursor-pointer bg-gray-50 p-2 rounded border border-gray-200 hover:bg-indigo-50 transition"><input
                                        type="checkbox" name="fasilitas[]" value="Single Bed"
                                        class="size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"><span
                                        class="text-sm font-medium text-gray-700">Single Bed</span></label>
                                <label
                                    class="flex items-center gap-2 cursor-pointer bg-gray-50 p-2 rounded border border-gray-200 hover:bg-indigo-50 transition"><input
                                        type="checkbox" name="fasilitas[]" value="Double Bed"
                                        class="size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"><span
                                        class="text-sm font-medium text-gray-700">Double Bed</span></label>
                                <label
                                    class="flex items-center gap-2 cursor-pointer bg-gray-50 p-2 rounded border border-gray-200 hover:bg-indigo-50 transition"><input
                                        type="checkbox" name="fasilitas[]" value="Sarapan Pagi"
                                        class="size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"><span
                                        class="text-sm font-medium text-gray-700">Sarapan Pagi</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <h4 class="font-semibold text-gray-700 border-b pb-2 mb-4">Galeri Foto Ruangan</h4>
                        <div class="mb-4 bg-indigo-50 p-4 rounded-lg border border-indigo-100">
                            <label class="block text-sm font-bold text-indigo-900 mb-1">Foto Utama (Thumbnail) <span
                                    class="text-red-500">*</span></label>
                            <input type="file" name="thumbnail" accept="image/*" required
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-50 p-3 rounded border border-gray-200"><label
                                    class="block text-xs font-medium text-gray-700 mb-1">Tambahan 1</label><input
                                    type="file" name="foto_1" accept="image/*"
                                    class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:bg-gray-200 file:text-gray-700 cursor-pointer">
                            </div>
                            <div class="bg-gray-50 p-3 rounded border border-gray-200"><label
                                    class="block text-xs font-medium text-gray-700 mb-1">Tambahan 2</label><input
                                    type="file" name="foto_2" accept="image/*"
                                    class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:bg-gray-200 file:text-gray-700 cursor-pointer">
                            </div>
                            <div class="bg-gray-50 p-3 rounded border border-gray-200"><label
                                    class="block text-xs font-medium text-gray-700 mb-1">Tambahan 3</label><input
                                    type="file" name="foto_3" accept="image/*"
                                    class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:bg-gray-200 file:text-gray-700 cursor-pointer">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse border-t border-gray-100">
                    <button type="submit" form="addForm"
                        class="ml-3 inline-flex justify-center rounded-lg bg-indigo-600 px-6 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-indigo-700 transition">Simpan</button>
                    <button type="button" onclick="closeAddModal()"
                        class="inline-flex justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/60 backdrop-blur-sm"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4 text-left sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-3xl">
                <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                    <h3 class="text-xl font-bold text-gray-900">Edit Data Kamar <span id="edit_title_nomor"
                            class="text-indigo-600"></span></h3>
                </div>

                <form id="editForm" method="POST" action="" enctype="multipart/form-data" class="px-6 py-6">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="space-y-4">
                            <h4 class="font-semibold text-gray-700 border-b pb-2">Informasi Dasar</h4>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas Kamar</label>
                                <input type="text" id="edit_kelas_kamar" name="kelas_kamar" list="kelas_options"
                                    required
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Ruangan</label>
                                <input type="text" id="edit_nomor_ruangan" name="nomor_ruangan" required
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Harga per Malam
                                    (Rp)</label>
                                <input type="number" id="edit_harga" name="harga" required min="0"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border text-sm">
                            </div>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-700 border-b pb-2 mb-4">Fasilitas Kamar</h4>
                            <div class="grid grid-cols-2 gap-3" id="edit_fasilitas_container">
                                <label
                                    class="flex items-center gap-2 cursor-pointer bg-gray-50 p-2 rounded border border-gray-200"><input
                                        type="checkbox" name="fasilitas[]" value="TV"
                                        class="edit-cb size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"><span
                                        class="text-sm font-medium text-gray-700">Televisi (TV)</span></label>
                                <label
                                    class="flex items-center gap-2 cursor-pointer bg-gray-50 p-2 rounded border border-gray-200"><input
                                        type="checkbox" name="fasilitas[]" value="AC"
                                        class="edit-cb size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"><span
                                        class="text-sm font-medium text-gray-700">AC</span></label>
                                <label
                                    class="flex items-center gap-2 cursor-pointer bg-gray-50 p-2 rounded border border-gray-200"><input
                                        type="checkbox" name="fasilitas[]" value="Kipas Angin"
                                        class="edit-cb size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"><span
                                        class="text-sm font-medium text-gray-700">Kipas Angin</span></label>
                                <label
                                    class="flex items-center gap-2 cursor-pointer bg-gray-50 p-2 rounded border border-gray-200"><input
                                        type="checkbox" name="fasilitas[]" value="Single Bed"
                                        class="edit-cb size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"><span
                                        class="text-sm font-medium text-gray-700">Single Bed</span></label>
                                <label
                                    class="flex items-center gap-2 cursor-pointer bg-gray-50 p-2 rounded border border-gray-200"><input
                                        type="checkbox" name="fasilitas[]" value="Double Bed"
                                        class="edit-cb size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"><span
                                        class="text-sm font-medium text-gray-700">Double Bed</span></label>
                                <label
                                    class="flex items-center gap-2 cursor-pointer bg-gray-50 p-2 rounded border border-gray-200"><input
                                        type="checkbox" name="fasilitas[]" value="Sarapan Pagi"
                                        class="edit-cb size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"><span
                                        class="text-sm font-medium text-gray-700">Sarapan Pagi</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <h4 class="font-semibold text-gray-700 border-b pb-2 mb-4">Ganti Foto Ruangan</h4>
                        <p class="text-xs text-red-500 mb-4">*Abaikan bagian ini jika Anda tidak ingin mengganti foto
                            yang sudah ada.</p>

                        <div class="mb-4 bg-indigo-50 p-4 rounded-lg border border-indigo-100">
                            <label class="block text-sm font-bold text-indigo-900 mb-1">Ganti Foto Utama
                                (Thumbnail)</label>
                            <input type="file" name="thumbnail" accept="image/*"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-50 p-3 rounded border border-gray-200"><label
                                    class="block text-xs font-medium text-gray-700 mb-1">Ganti Tambahan 1</label><input
                                    type="file" name="foto_1" accept="image/*"
                                    class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:bg-gray-200 file:text-gray-700 cursor-pointer">
                            </div>
                            <div class="bg-gray-50 p-3 rounded border border-gray-200"><label
                                    class="block text-xs font-medium text-gray-700 mb-1">Ganti Tambahan 2</label><input
                                    type="file" name="foto_2" accept="image/*"
                                    class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:bg-gray-200 file:text-gray-700 cursor-pointer">
                            </div>
                            <div class="bg-gray-50 p-3 rounded border border-gray-200"><label
                                    class="block text-xs font-medium text-gray-700 mb-1">Ganti Tambahan 3</label><input
                                    type="file" name="foto_3" accept="image/*"
                                    class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:bg-gray-200 file:text-gray-700 cursor-pointer">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse border-t border-gray-100">
                    <button type="submit" form="editForm"
                        class="ml-3 inline-flex justify-center rounded-lg bg-indigo-600 px-6 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-indigo-700 transition">Update
                        Kamar</button>
                    <button type="button" onclick="closeEditModal()"
                        class="inline-flex justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <datalist id="kelas_options">
        <option value="Standard Room"></option>
        <option value="Superior Room"></option>
        <option value="Deluxe Room"></option>
        <option value="Suite Room"></option>
        <option value="Presidential Suite"></option>
    </datalist>

    <script>
        // Modal Tambah
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addForm').reset();
        }

        // Modal Edit (dengan logika Auto-Check JSON Fasilitas)
        function openEditModal(id, kelas, nomor, harga, fasilitas) {
            document.getElementById('editForm').action = '/kamar/' + id;
            document.getElementById('edit_title_nomor').innerText = "#" + nomor;

            // Isi form dasar
            document.getElementById('edit_kelas_kamar').value = kelas;
            document.getElementById('edit_nomor_ruangan').value = nomor;
            document.getElementById('edit_harga').value = harga;

            // Reset semua centangan checkbox sebelum dicentang ulang
            let checkboxes = document.querySelectorAll('.edit-cb');
            checkboxes.forEach(cb => cb.checked = false);

            // Centang otomatis berdasarkan data array fasilitas yang dibawa dari database
            checkboxes.forEach(cb => {
                if (fasilitas.includes(cb.value)) {
                    cb.checked = true;
                }
            });

            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editForm').reset();
        }
    </script>
</x-dblayout>

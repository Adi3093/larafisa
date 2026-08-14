<x-dblayout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-amber-950 tracking-tight">Kelola Akun Sistem</h1>
        <p class="text-sm text-amber-900/70 mt-1">Mengelola hak akses, pembaruan kata sandi, dan data pengunjung.</p>
    </div>

    <!-- MODULE: Flash Messages -->
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
        <div
            class="mb-6 flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm">
            <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <ul class="list-disc pl-4 text-sm font-medium space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- MODULE: Folder Tabs Navigation -->
    <div class="flex items-end pl-0 sm:pl-2 flex-wrap gap-y-2 relative z-10">
        <a href="{{ route('akun', ['tab' => 'admin']) }}"
            class="{{ $tab === 'admin' ? 'px-5 sm:px-6 py-3 bg-white border border-amber-200 border-b-white rounded-t-xl font-bold text-amber-700 text-xs sm:text-sm relative z-10 -mb-[1px] shadow-sm shadow-white transition' : 'px-5 sm:px-6 py-2.5 bg-amber-50 border border-amber-200 rounded-t-xl font-bold text-amber-800/60 hover:text-amber-700 hover:bg-amber-100 text-xs sm:text-sm transition relative z-0 ml-1' }}">
            Akun Staf & Owner
        </a>
        <a href="{{ route('akun', ['tab' => 'tamu']) }}"
            class="{{ $tab === 'tamu' ? 'px-5 sm:px-6 py-3 bg-white border border-amber-200 border-b-white rounded-t-xl font-bold text-amber-700 text-xs sm:text-sm relative z-10 -mb-[1px] shadow-sm shadow-white transition ml-1' : 'px-5 sm:px-6 py-2.5 bg-amber-50 border border-amber-200 rounded-t-xl font-bold text-amber-800/60 hover:text-amber-700 hover:bg-amber-100 text-xs sm:text-sm transition relative z-0 ml-1' }}">
            Daftar Akun Tamu
        </a>
    </div>

    <!-- MODULE: Folder Body Content -->
    <div
        class="bg-white border border-amber-200 rounded-b-2xl rounded-tr-2xl rounded-tl-none shadow-sm p-5 lg:p-6 mb-6 relative z-0 -mt-[1px]">

        <!-- Search & Filters (Menyatu dalam Folder) -->
        <form method="GET" action="{{ route('akun') }}" id="formSearch"
            class="flex flex-col lg:flex-row items-end gap-4 w-full border-b border-amber-100 pb-6 mb-6">
            <input type="hidden" name="tab" value="{{ $tab }}">

            <div class="flex-1 w-full">
                <label class="block text-xs font-bold text-amber-800/70 uppercase tracking-wider mb-2">Cari
                    Pengguna</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                        placeholder="Ketik nama, email, atau username..."
                        class="pl-10 w-full border border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 py-2.5 text-sm transition text-amber-950">
                </div>
            </div>

            <div class="w-full lg:w-48">
                <label class="block text-xs font-bold text-amber-800/70 uppercase tracking-wider mb-2">Tampilkan
                    Baris</label>
                <select name="per_page" id="perPageSelect"
                    class="w-full border border-amber-200 rounded-xl shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 py-2.5 px-3 text-sm transition bg-white text-amber-950">
                    <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5 Baris</option>
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 Baris</option>
                    <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15 Baris</option>
                    <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20 Baris</option>
                </select>
            </div>

            <div class="flex gap-3 w-full lg:w-auto">
                <button type="submit"
                    class="bg-amber-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-amber-700 transition shadow-sm w-full lg:w-auto whitespace-nowrap">
                    Terapkan Pencarian
                </button>
                @if ($search)
                    <a href="{{ route('akun', ['tab' => $tab]) }}"
                        class="bg-white text-amber-700 px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-amber-50 transition text-center border border-amber-200 shadow-sm shrink-0">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        <!-- Header Tabel -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-4 bg-white">
            <h3 class="font-bold text-amber-950 text-lg">Daftar {{ $tab === 'tamu' ? 'Akun Tamu' : 'Akun Staf' }}</h3>

            <button onclick="openAddModal()"
                class="bg-amber-600 hover:bg-amber-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-sm flex items-center justify-center gap-2 whitespace-nowrap w-full sm:w-auto shadow-amber-600/20">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Akun {{ $tab === 'tamu' ? 'Tamu' : 'Staf' }}
            </button>
        </div>

        <!-- Tabel Data -->
        <div class="border border-amber-100 rounded-xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead
                        class="bg-amber-50/50 border-b border-amber-100 text-amber-900 font-bold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="px-6 py-4 whitespace-nowrap">Nama & Kontak</th>
                            <th class="px-6 py-4 whitespace-nowrap">Username</th>
                            <th class="px-6 py-4 whitespace-nowrap">Role</th>
                            <th class="px-6 py-4 whitespace-nowrap">Status</th>
                            <th class="px-6 py-4 whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-50 text-amber-950">
                        @forelse($users as $user)
                            <tr class="hover:bg-amber-50/30 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($user->avatar)
                                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar"
                                                class="w-10 h-10 rounded-full border border-amber-200 object-cover shadow-sm">
                                        @else
                                            <div
                                                class="w-10 h-10 rounded-full bg-amber-100 border border-amber-200 flex items-center justify-center text-amber-600 font-bold text-lg shadow-sm">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif

                                        <div>
                                            <div class="font-bold text-amber-950">{{ $user->name }}</div>
                                            <div class="text-xs text-amber-800/60 mt-0.5">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-bold text-amber-700">
                                    {{ $user->username }}
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center justify-center rounded-lg {{ match($user->role) { 'tamu' => 'bg-orange-50 text-orange-700 border-orange-200', 'owner' => 'bg-emerald-50 text-emerald-700 border-emerald-200', default => 'bg-blue-50 text-blue-700 border-blue-200' } }} border px-3 py-1 text-[10px] font-bold uppercase tracking-wider">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($user->last_seen && \Carbon\Carbon::parse($user->last_seen)->diffInMinutes(now()) < 5)
                                        <span
                                            class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600">
                                            <span class="relative flex h-2 w-2">
                                                <span
                                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                <span
                                                    class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                            </span>
                                            Online
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-400">
                                            <span class="h-2 w-2 rounded-full bg-gray-300"></span>
                                            Offline
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if (Auth::id() === $user->id)
                                        <a href="{{ route('settings.profil') }}"
                                            class="inline-flex items-center gap-1.5 rounded-lg bg-amber-50 px-3 py-2 text-xs font-bold text-amber-700 border border-amber-200 hover:bg-amber-100 transition">
                                            Edit Profil Saya
                                        </a>
                                    @else
                                        <button
                                            onclick="openEditModal({{ $user->id }}, '{{ $user->username }}', '{{ $user->name }}')"
                                            class="inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-2 text-xs font-bold text-amber-700 border border-amber-200 hover:bg-amber-50 transition shadow-sm">
                                            <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                            Edit
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-amber-900/40">
                                        <svg class="w-12 h-12 mb-3 text-amber-200" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                        <p class="font-medium text-amber-950">Tidak ada data akun</p>
                                        <p class="text-sm mt-1">Kami tidak dapat menemukan pengguna yang cocok di
                                            kategori ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>

    <!-- MODULE: Modal Tambah Akun -->
    <div id="addModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/60 backdrop-blur-sm"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 w-full max-w-lg border border-amber-100">
                <div class="bg-amber-600 px-6 py-4 flex justify-between items-center text-white">
                    <h3 class="font-bold text-lg">Tambah Akun Baru</h3>
                    <button type="button" onclick="closeAddModal()"
                        class="text-amber-100 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="bg-white p-6">
                    <form id="addForm" method="POST" action="{{ route('akun.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-amber-950 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" required
                                class="w-full border border-amber-200 rounded-lg shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 p-2.5 text-sm transition">
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-bold text-amber-950 mb-1">Username</label>
                                <input type="text" name="username" required
                                    class="w-full border border-amber-200 rounded-lg shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 p-2.5 text-sm transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-amber-950 mb-1">Email Aktif</label>
                                <input type="email" name="email" required
                                    class="w-full border border-amber-200 rounded-lg shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 p-2.5 text-sm transition">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-amber-950 mb-1">Role / Hak Akses</label>
                            <select name="role" required
                                class="w-full border border-amber-200 rounded-lg shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 p-2.5 text-sm bg-white transition">
                                <option value="admin" {{ $tab === 'admin' ? 'selected' : '' }}>Administrator</option>
                                <option value="resepsionis">Staf Resepsionis</option>
                                <!-- PENAMBAHAN: Opsi Role Owner -->
                                <option value="owner">Pemilik (Owner)</option>
                                <option value="tamu" {{ $tab === 'tamu' ? 'selected' : '' }}>Tamu Pengunjung
                                </option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="block text-xs font-bold text-amber-950 mb-1">Kata Sandi Akses</label>
                            <input type="password" name="password" required
                                class="w-full border border-amber-200 rounded-lg shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 p-2.5 text-sm transition">
                            <p class="text-[10px] font-bold text-amber-600 mt-1.5">*Minimal 8 karakter (Sertakan huruf
                                dan angka).</p>
                        </div>
                    </form>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 border-t border-amber-100">
                    <button type="button" onclick="closeAddModal()"
                        class="px-5 py-2.5 rounded-xl bg-white border border-gray-200 text-gray-700 font-bold hover:bg-gray-50 transition shadow-sm">Batal</button>
                    <button type="submit" form="addForm"
                        class="px-5 py-2.5 rounded-xl bg-amber-600 text-white font-bold hover:bg-amber-700 transition shadow-sm shadow-amber-600/30">Simpan
                        Akun</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODULE: Modal Edit Akun -->
    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/60 backdrop-blur-sm"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 w-full max-w-lg border border-amber-100">
                <div class="bg-amber-600 px-6 py-4 flex justify-between items-center text-white">
                    <h3 class="font-bold text-lg">Edit <span id="modal-user-name"
                            class="text-amber-200 underline"></span></h3>
                    <button type="button" onclick="closeEditModal()"
                        class="text-amber-100 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="bg-white p-6">
                    <form id="editForm" method="POST" action="">
                        @csrf @method('PUT')
                        <input type="hidden" name="tab" value="{{ $tab }}">

                        <div class="mb-5">
                            <label class="block text-xs font-bold text-amber-950 mb-1">Username Akses</label>
                            <input type="text" id="modal-username" name="username" required
                                class="w-full border border-amber-200 rounded-lg shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 p-2.5 text-sm transition">
                        </div>

                        <div class="mb-2 p-4 border border-red-200 bg-red-50 rounded-xl">
                            <label class="block text-xs font-bold text-red-900 mb-1 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                Reset Kata Sandi Pengguna
                            </label>
                            <input type="password" name="password" placeholder="••••••••"
                                class="w-full border border-red-200 rounded-lg shadow-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 p-2.5 text-sm transition bg-white text-red-900">
                            <p class="text-[10px] font-bold text-red-600 mt-1.5">*Biarkan kolom ini kosong jika Anda
                                tidak ingin mengubah/mereset kata sandi pengguna ini.</p>
                        </div>
                    </form>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 border-t border-amber-100">
                    <button type="button" onclick="closeEditModal()"
                        class="px-5 py-2.5 rounded-xl bg-white border border-gray-200 text-gray-700 font-bold hover:bg-gray-50 transition shadow-sm">Batal</button>
                    <button type="submit" form="editForm"
                        class="px-5 py-2.5 rounded-xl bg-amber-600 text-white font-bold hover:bg-amber-700 transition shadow-sm shadow-amber-600/30">Simpan
                        Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODULE: Pemanggilan File Eksternal JS -->
    <script src="{{ asset('js/dashboard/akun.js') }}?v={{ time() }}"></script>
</x-dblayout>
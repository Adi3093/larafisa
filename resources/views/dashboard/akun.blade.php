<x-dblayout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Kelola Akun Sistem</h1>
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

    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8">
            <a href="{{ route('akun', ['tab' => 'admin']) }}"
                class="{{ $tab === 'admin' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition">
                Akun Admin & Resepsionis
            </a>
            <a href="{{ route('akun', ['tab' => 'tamu']) }}"
                class="{{ $tab === 'tamu' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition">
                Daftar Akun Tamu
            </a>
        </nav>
    </div>

    <div class="bg-white p-5 lg:p-6 rounded-2xl border border-gray-100 shadow-sm mb-6">
        <form method="GET" action="{{ route('akun') }}" class="flex flex-col lg:flex-row items-end gap-4 w-full">
            <input type="hidden" name="tab" value="{{ $tab }}">

            <div class="flex-1 w-full">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Cari Pengguna</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                        placeholder="Ketik nama, email, atau username..."
                        class="pl-10 w-full border border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 py-2.5 text-sm transition">
                </div>
            </div>

            <div class="w-full lg:w-48">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tampilkan
                    Baris</label>
                <select name="per_page" onchange="this.form.submit()"
                    class="w-full border border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 py-2.5 px-3 text-sm transition bg-white">
                    <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5 Baris</option>
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 Baris</option>
                    <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15 Baris</option>
                    <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20 Baris</option>
                </select>
            </div>

            <div class="flex gap-3 w-full lg:w-auto">
                <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-sm w-full lg:w-auto whitespace-nowrap">
                    Terapkan Pencarian
                </button>
                @if ($search)
                    <a href="{{ route('akun', ['tab' => $tab]) }}"
                        class="bg-white text-gray-600 px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-gray-50 transition text-center border border-gray-200 shadow-sm shrink-0">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6">

        <div
            class="flex flex-col sm:flex-row justify-between items-center gap-4 p-5 lg:p-6 border-b border-gray-100 bg-white">
            <h3 class="font-bold text-gray-800 text-lg">Daftar {{ $tab === 'tamu' ? 'Akun Tamu' : 'Akun Staf' }}</h3>

            <button onclick="openAddModal()"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-sm flex items-center justify-center gap-2 whitespace-nowrap w-full sm:w-auto">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Akun {{ $tab === 'tamu' ? 'Tamu' : 'Staf' }}
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50/50 border-b border-gray-100 text-gray-500 font-medium">
                    <tr>
                        <th class="px-6 py-4 whitespace-nowrap">Nama & Kontak</th>
                        <th class="px-6 py-4 whitespace-nowrap">Username</th>
                        <th class="px-6 py-4 whitespace-nowrap">Role</th>
                        <th class="px-6 py-4 whitespace-nowrap">Status Aktivitas</th>
                        <th class="px-6 py-4 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if ($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar"
                                            class="w-10 h-10 rounded-full border border-gray-200 object-cover shadow-sm">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=F3F4F6&color=4F46E5&size=40"
                                            alt="Avatar"
                                            class="w-10 h-10 rounded-full border border-gray-200 object-cover shadow-sm">
                                    @endif

                                    <div>
                                        <div class="font-bold text-gray-900">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium">
                                {{ $user->username }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center justify-center rounded-lg {{ $user->role === 'tamu' ? 'bg-orange-50 text-orange-700 border-orange-200' : 'bg-indigo-50 text-indigo-700 border-indigo-200' }} border px-3 py-1 text-xs font-bold uppercase tracking-wider">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($user->last_seen && \Carbon\Carbon::parse($user->last_seen)->diffInMinutes(now()) < 5)
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600">
                                        <span class="relative flex h-2.5 w-2.5">
                                            <span
                                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                            <span
                                                class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                                        </span>
                                        Online
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-400">
                                        <span class="h-2.5 w-2.5 rounded-full bg-gray-300"></span>
                                        Offline
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if (Auth::id() === $user->id)
                                    <a href="{{ route('settings.profil') }}"
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-50 px-3 py-2 text-xs font-bold text-indigo-700 hover:bg-indigo-100 transition">
                                        Edit Profil Saya
                                    </a>
                                @else
                                    <button
                                        onclick="openEditModal({{ $user->id }}, '{{ $user->username }}', '{{ $user->name }}')"
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-2 text-xs font-bold text-gray-700 border border-gray-200 hover:bg-gray-50 transition shadow-sm">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24"
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
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    <p class="font-medium text-gray-900">Tidak ada data akun</p>
                                    <p class="text-sm mt-1">Kami tidak dapat menemukan pengguna yang cocok di kategori
                                        ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mb-8">
        {{ $users->links() }}
    </div>

    <div id="addModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/60 backdrop-blur-sm"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-xl font-bold text-gray-900">Tambah Akun Baru</h3>
                        <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-500">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form id="addForm" method="POST" action="{{ route('akun.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Nama Lengkap</label>
                            <input type="text" name="name" required
                                class="w-full border border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-2.5 transition">
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5">Username</label>
                                <input type="text" name="username" required
                                    class="w-full border border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-2.5 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5">Email</label>
                                <input type="email" name="email" required
                                    class="w-full border border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-2.5 transition">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Role / Akses</label>
                            <select name="role" required
                                class="w-full border border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-2.5 bg-white transition">
                                <option value="admin" {{ $tab === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="resepsionis">Resepsionis</option>
                                <option value="tamu" {{ $tab === 'tamu' ? 'selected' : '' }}>Tamu Pengunjung
                                </option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Kata Sandi</label>
                            <input type="password" name="password" required
                                class="w-full border border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-2.5 transition">
                            <p class="text-xs text-gray-500 mt-1.5">*Minimal 8 karakter.</p>
                        </div>
                    </form>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-100">
                    <button type="submit" form="addForm"
                        class="inline-flex w-full justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-indigo-700 sm:ml-3 sm:w-auto transition">
                        Simpan Akun
                    </button>
                    <button type="button" onclick="closeAddModal()"
                        class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-bold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/60 backdrop-blur-sm"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-xl font-bold text-gray-900">Edit <span id="modal-user-name"
                                class="text-indigo-600"></span></h3>
                        <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form id="editForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="tab" value="{{ $tab }}">

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Username Baru</label>
                            <input type="text" id="modal-username" name="username" required
                                class="w-full border border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-2.5 transition">
                        </div>
                        <div class="mb-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Reset Kata Sandi</label>
                            <input type="password" name="password" placeholder="••••••••"
                                class="w-full border border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-2.5 transition">
                            <p class="text-xs text-gray-500 mt-1.5">*Biarkan kosong jika tidak ingin mengubah sandi.
                            </p>
                        </div>
                    </form>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-100">
                    <button type="submit" form="editForm"
                        class="inline-flex w-full justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-indigo-700 sm:ml-3 sm:w-auto transition">
                        Simpan Perubahan
                    </button>
                    <button type="button" onclick="closeEditModal()"
                        class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-bold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addForm').reset();
        }

        function openEditModal(userId, currentUsername, name) {
            document.getElementById('editForm').action = '/akun/' + userId;
            document.getElementById('modal-username').value = currentUsername;
            document.getElementById('modal-user-name').innerText = name;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editForm').reset();
        }
    </script>
</x-dblayout>

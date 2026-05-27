<x-dblayout>
    <div class="max-w-6xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Kelola Akun Sistem</h1>

        @if (session('success'))
            <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 text-green-700 rounded-r-lg">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 text-red-700 rounded-r-lg text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8">
                <a href="#"
                    class="border-indigo-500 text-indigo-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Akun Admin & Resepsionis
                </a>
                <a href="#"
                    class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Akun Tamu
                </a>
            </nav>
        </div>

        <div class="mb-4 flex flex-col sm:flex-row justify-between gap-4">
            <form method="GET" action="{{ route('akun') }}" class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">

                <select name="per_page" onchange="this.form.submit()"
                    class="border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 text-sm border bg-white">
                    <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                    <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                </select>
                <input type="text" name="search" value="{{ $search ?? '' }}"
                    placeholder="Cari nama, email, username..."
                    class="border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 text-sm border w-full sm:w-64">


                <button type="submit"
                    class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 border border-gray-200">
                    Cari
                </button>

                @if ($search)
                    <a href="{{ route('akun') }}"
                        class="bg-red-50 text-red-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-100 flex items-center justify-center border border-red-200">
                        Reset
                    </a>
                @endif
            </form>

            <button onclick="openAddModal()"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 transition shadow-sm whitespace-nowrap">
                + Tambah Akun
            </button>
        </div>

        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden mb-4">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                    <thead class="bg-gray-50 text-left">
                        <tr>
                            <th class="whitespace-nowrap px-4 py-3 font-medium text-gray-900">Nama / Email</th>
                            <th class="whitespace-nowrap px-4 py-3 font-medium text-gray-900">Username</th>
                            <th class="whitespace-nowrap px-4 py-3 font-medium text-gray-900">Role</th>
                            <th class="whitespace-nowrap px-4 py-3 font-medium text-gray-900">Status</th>
                            <th class="whitespace-nowrap px-4 py-3 font-medium text-gray-900">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($admins as $admin)
                            <tr>
                                <td class="whitespace-nowrap px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $admin->name }}</div>
                                    <div class="text-gray-500 text-xs">{{ $admin->email }}</div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-gray-700">{{ $admin->username }}</td>
                                <td class="whitespace-nowrap px-4 py-3">
                                    <span
                                        class="inline-flex items-center justify-center rounded-full bg-blue-100 px-2.5 py-0.5 text-blue-700 text-xs font-semibold">
                                        {{ ucfirst($admin->role) }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3">
                                    @if ($admin->last_seen && \Carbon\Carbon::parse($admin->last_seen)->diffInMinutes(now()) < 5)
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-green-600">
                                            <span class="h-1.5 w-1.5 rounded-full bg-green-600"></span> Online
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-600">
                                            <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span> Offline
                                        </span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-4 py-3">
                                    @if (Auth::id() === $admin->id)
                                        <a href="{{ route('settings.profil') }}"
                                            class="inline-block rounded bg-indigo-50 px-3 py-1.5 text-xs font-medium text-indigo-700 hover:bg-indigo-100">
                                            Edit Profil Saya
                                        </a>
                                    @else
                                        <button
                                            onclick="openEditModal({{ $admin->id }}, '{{ $admin->username }}', '{{ $admin->name }}')"
                                            class="inline-block rounded bg-gray-50 px-3 py-1.5 text-xs font-medium text-gray-700 border border-gray-200 hover:bg-gray-100">
                                            Edit Kredensial
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500">Tidak ada data akun yang
                                    ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $admins->links() }}
        </div>
    </div>

    <div id="addModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/50 backdrop-blur-sm"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-bold leading-6 text-gray-900 mb-4">Tambah Akun Baru</h3>

                    <form id="addForm" method="POST" action="{{ route('akun.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                <input type="text" name="username" required
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" required
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Role Jabatan</label>
                            <select name="role" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border bg-white">
                                <option value="admin">Admin</option>
                                <option value="resepsionis">Resepsionis</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                            <input type="password" name="password" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
                            <p class="text-xs text-gray-500 mt-1">*Minimal 8 karakter.</p>
                        </div>
                    </form>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="submit" form="addForm"
                        class="inline-flex w-full justify-center rounded-lg bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 sm:ml-3 sm:w-auto">
                        Simpan Akun
                    </button>
                    <button type="button" onclick="closeAddModal()"
                        class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/50 backdrop-blur-sm"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-bold leading-6 text-gray-900 mb-4">Edit Kredensial: <span
                            id="modal-user-name" class="text-indigo-600"></span></h3>
                    <form id="editForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Username Baru</label>
                            <input type="text" id="modal-username" name="username" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
                        </div>
                        <div class="mb-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Reset Kata Sandi</label>
                            <input type="password" name="password" placeholder="••••••••"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
                            <p class="text-xs text-gray-500 mt-1">*Kosongkan jika Anda tidak ingin mereset kata sandi
                                staf ini.</p>
                        </div>
                    </form>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="submit" form="editForm"
                        class="inline-flex w-full justify-center rounded-lg bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 sm:ml-3 sm:w-auto">
                        Simpan Perubahan
                    </button>
                    <button type="button" onclick="closeEditModal()"
                        class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal Tambah
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addForm').reset();
        }

        // Modal Edit
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

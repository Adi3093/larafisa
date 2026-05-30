<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">
    <div class="flex min-h-screen">
        <div class="flex h-screen w-64 flex-col justify-between border-e border-gray-200 bg-white sticky top-0">
            <div class="px-4 py-6">
                <span class="grid h-10 w-32 place-content-center rounded-lg bg-gray-100 text-xs text-gray-600">
                    Logo
                </span>
                <ul class="mt-6 space-y-1">
                    <li>
                        <a href="dashboard"
                            class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->is('dashboard') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="reservasi"
                            class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->is('reservasi') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                            Reservasi
                        </a>
                    </li>
                    <li>
                        <a href="jadwal"
                            class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->is('reservasilog') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                            Jadwal Reservasi
                        </a>
                    <li>
                        <a href="reservasilog"
                            class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->is('reservasilog') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                            Riwayat Reservasi
                        </a>
                    </li>
                    <li>
                        <a href="dtamu"
                            class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->is('dtamu') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                            Daftar Tamu
                        </a>
                    </li>
                    <li>
                        <a href="kamar"
                            class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->is('kamar') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                            Kelola Kamar
                        </a>
                    </li>
                    <li>
                        <a href="pendapatan"
                            class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->is('pendapatan') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                            Laporan Pendapatan
                        </a>
                    </li>
                    <li>
                        <details class="group [&amp;&_summary::-webkit-details-marker]:hidden"
                            {{ request()->is('settings*') || request()->is('akun*') ? 'open' : '' }}>
                            <summary
                                class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                <span class="text-sm font-medium"> Panel Kontrol </span>
                                <span class="shrink-0 transition duration-300 group-open:-rotate-180">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </summary>
                            <ul class="mt-2 space-y-1 px-4">
                                <li>
                                    <a href="{{ route('settings') }}"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('settings') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                                        Pengaturan
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('akun') }}"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('akun') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                                        Kelola Akun
                                    </a>
                                </li>
                                <li>
                                    <a href="/"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->is('landing_page') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                                        Lihat Landing Page
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin keluar dari sistem? Semua pekerjaan yang belum disimpan mungkin hilang.');">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-left rounded-lg px-4 py-2 text-sm font-medium {{ request()->is('logout') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </details>
                    </li>
                </ul>
            </div>
            <div class="sticky inset-x-0 bottom-0 border-t border-gray-100">
                <a href="{{ route('settings.profil') }}"
                    class="flex items-center gap-2 bg-white p-4 hover:bg-gray-50 transition">

                    @if (Auth::user()->avatar)
                        <img alt="Foto Profil" src="{{ asset('storage/' . Auth::user()->avatar) }}"
                            class="size-10 rounded-full object-cover border border-gray-200">
                    @else
                        <div
                            class="size-10 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0 text-indigo-600 font-bold text-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif

                    <div class="overflow-hidden">
                        <p class="text-xs truncate">
                            <strong class="block font-medium text-gray-900">{{ Auth::user()->name }}</strong>
                            <span class="text-gray-500">{{ Auth::user()->email }}</span>
                        </p>
                    </div>

                </a>
            </div>
        </div>
        <main class="flex-1 p-8">
            {{ $slot }}
        </main>
    </div>
</body>

</html>

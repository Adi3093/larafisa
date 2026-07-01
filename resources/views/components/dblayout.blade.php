<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Fisa Hotel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

    <style>
        /* Dark Mode */
        .dark-mode-active {
            filter: invert(0.9) hue-rotate(180deg);
            background: #fff;
        }

        .dark-mode-active img,
        .dark-mode-active video,
        .dark-mode-active iframe {
            filter: invert(1) hue-rotate(180deg);
        }

        /* High Contrast */
        .high-contrast-active * {
            color: #000 !important;
            border-color: #000 !important;
        }

        .high-contrast-active .bg-amber-600,
        .high-contrast-active .bg-emerald-600,
        .high-contrast-active .bg-indigo-600,
        .high-contrast-active .bg-rose-600 {
            background-color: #000 !important;
            color: #fff !important;
        }
    </style>

    <script>
        (function() {
            const savedFontSize = localStorage.getItem('pref_fontsize');
            if (savedFontSize) document.documentElement.style.fontSize = savedFontSize + '%';

            if (localStorage.getItem('pref_darkmode') === 'true') {
                document.documentElement.classList.add('dark-mode-active');
            }

            if (localStorage.getItem('pref_contrast') === 'true') {
                document.documentElement.classList.add('high-contrast-active');
            }
        })();
    </script>
</head>

<body class="bg-gray-50 antialiased">

    <div id="toast-container" class="fixed top-20 right-5 z-[9999] flex flex-col gap-3 pointer-events-none"></div>

    <nav class="fixed top-0 z-50 w-full bg-white border-b border-amber-200 shadow-sm">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">

                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-amber-200">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>
                    <a href="{{ url('/') }}" class="flex ms-2 md:me-24 items-center gap-2">
                        <img src="{{ asset('storage/landingpage/logofisa.png') }}" class="h-8 w-auto" alt="Fisa Logo"
                            style="filter: sepia(100%) hue-rotate(10deg) saturate(200%) brightness(50%);" />
                        <span
                            class="self-center text-xl font-extrabold sm:text-2xl whitespace-nowrap text-amber-950">FISA
                            HOTEL</span>
                    </a>
                </div>

                <div class="flex items-center">
                    <div class="flex items-center ms-3">
                        <div>
                            <button type="button"
                                class="flex text-sm bg-amber-50 rounded-full focus:ring-4 focus:ring-amber-300 border border-amber-200"
                                aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Open user menu</span>
                                @if (Auth::user()?->avatar)
                                    <img class="w-9 h-9 rounded-full object-cover"
                                        src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="user photo">
                                @else
                                    <div
                                        class="w-9 h-9 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 font-bold text-sm">
                                        {{ substr(Auth::user()?->name, 0, 1) }}
                                    </div>
                                @endif
                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-amber-100 rounded shadow-lg border border-amber-50"
                            id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-900 font-bold" role="none">
                                    {{ Auth::user()?->name }}
                                </p>
                                <p class="text-sm font-medium text-gray-500 truncate" role="none">
                                    {{ Auth::user()?->email }}
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <a href="{{ route('settings.profil') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600"
                                        role="menuitem">Profil Saya</a>
                                </li>
                                <li>
                                    <a href="{{ route('akun') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600"
                                        role="menuitem">Kelola Akun Sistem</a>
                                </li>
                                <li class="border-t border-gray-100 mt-1">
                                    <form action="{{ route('logout') }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin keluar dari dashboard?');">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-red-600 font-bold hover:bg-red-50"
                                            role="menuitem">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </nav>

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-amber-200 sm:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
            <ul class="space-y-2 font-medium">

                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center p-2 rounded-lg group transition {{ request()->is('dashboard') ? 'bg-amber-50 text-amber-700 font-bold border border-amber-200' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        <svg class="w-5 h-5 transition duration-75 {{ request()->is('dashboard') ? 'text-amber-700' : 'text-gray-400 group-hover:text-amber-600' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 22 21">
                            <path
                                d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path
                                d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="ms-3">Dashboard Utama</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('reservasi') }}"
                        class="flex items-center p-2 rounded-lg group transition {{ request()->is('reservasi*') ? 'bg-amber-50 text-amber-700 font-bold border border-amber-200' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        <svg class="w-5 h-5 transition duration-75 {{ request()->is('reservasi*') ? 'text-amber-700' : 'text-gray-400 group-hover:text-amber-600' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M5 5a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h2a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1zm10 6.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Data Reservasi</span>
                        @php
                            $pendingReq = \App\Models\Reservasi::where(
                                'status_reservasi',
                                'Menunggu Konfirmasi',
                            )->count();
                        @endphp
                        @if ($pendingReq > 0)
                            <span
                                class="inline-flex items-center justify-center w-5 h-5 ms-3 text-xs font-medium text-white bg-red-500 rounded-full animate-pulse">{{ $pendingReq }}</span>
                        @endif
                    </a>
                </li>

                <li>
                    <a href="{{ route('checkinout') }}"
                        class="flex items-center p-2 rounded-lg group transition {{ request()->is('checkinout') ? 'bg-amber-50 text-amber-700 font-bold border border-amber-200' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        <svg class="w-5 h-5 transition duration-75 {{ request()->is('dtamu') ? 'text-amber-700' : 'text-gray-400 group-hover:text-amber-600' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 18">
                            <path
                                d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Check-In / Out</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('kamar') }}"
                        class="flex items-center p-2 rounded-lg group transition {{ request()->is('kamar') ? 'bg-amber-50 text-amber-700 font-bold border border-amber-200' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        <svg class="w-5 h-5 transition duration-75 {{ request()->is('kamar') ? 'text-amber-700' : 'text-gray-400 group-hover:text-amber-600' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M3 6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6zm3 4a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm4 0h8v-2h-8v2zm0 4h8v-2h-8v2zm-4 4h12v-2H6v2z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Kelola Kamar</span>
                    </a>
                </li>

                <li>
                    <a href="/pendapatan"
                        class="flex items-center p-2 rounded-lg group transition {{ request()->is('pendapatan') ? 'bg-amber-50 text-amber-700 font-bold border border-amber-200' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        <svg class="w-5 h-5 transition duration-75 {{ request()->is('pendapatan') ? 'text-amber-700' : 'text-gray-400 group-hover:text-amber-600' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M12 2a1 1 0 0 1 1 1v1h2a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-4v2h3a4 4 0 0 1 4 4v3a4 4 0 0 1-4 4h-2v1a1 1 0 1 1-2 0v-1H9a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h4v-2H10a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4h2V3a1 1 0 0 1 1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Pendapatan</span>
                    </a>
                </li>
            </ul>

            <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-amber-100">

                <li>
                    <button type="button"
                        class="flex items-center w-full p-2 text-base text-gray-600 transition duration-75 rounded-lg group hover:bg-amber-50 hover:text-amber-700"
                        aria-controls="dropdown-pengaturan" data-collapse-toggle="dropdown-pengaturan"
                        {{ request()->is('settings*') || request()->is('akun*') ? 'aria-expanded=true' : '' }}>
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-400 transition duration-75 group-hover:text-amber-600"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M19.985 11.082l-2.073-.615a7.994 7.994 0 0 0-1.12-2.708l1.106-1.854a1.002 1.002 0 0 0-.25-1.258l-1.414-1.414a1 1 0 0 0-1.258-.25l-1.854 1.106a7.994 7.994 0 0 0-2.708-1.12l-.615-2.073a1 1 0 0 0-.961-.716h-2a1 1 0 0 0-.961.716l-.615 2.073a7.994 7.994 0 0 0-2.708 1.12l-1.854-1.106a1 1 0 0 0-1.258.25l-1.414 1.414a1.002 1.002 0 0 0-.25 1.258l1.106 1.854a7.994 7.994 0 0 0-1.12 2.708l-2.073.615A1 1 0 0 0 2 12.04v2a1 1 0 0 0 .716.961l2.073.615a7.994 7.994 0 0 0 1.12 2.708l-1.106 1.854a1.002 1.002 0 0 0 .25 1.258l1.414 1.414a1 1 0 0 0 1.258.25l1.854-1.106a7.994 7.994 0 0 0 2.708 1.12l.615 2.073a1 1 0 0 0 .961.716h2a1 1 0 0 0 .961-.716l.615-2.073a7.994 7.994 0 0 0 2.708-1.12l1.854 1.106a1 1 0 0 0 1.258-.25l1.414-1.414a1.002 1.002 0 0 0 .25-1.258l-1.106-1.854a7.994 7.994 0 0 0 1.12-2.708l2.073-.615A1 1 0 0 0 22 14.04v-2a1 1 0 0 0-.716-.961c-.431-.128-.865-.252-1.299-.397zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8z" />
                        </svg>
                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Pengaturan</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <ul id="dropdown-pengaturan"
                        class="{{ request()->is('settings*') || request()->is('akun*') ? '' : 'hidden' }} py-2 space-y-2">
                        <li>
                            <a href="{{ route('settings') }}"
                                class="flex items-center w-full p-2 text-gray-600 transition duration-75 rounded-lg pl-11 hover:bg-amber-50 hover:text-amber-700 {{ request()->routeIs('settings') ? 'font-bold text-amber-700 bg-amber-50/50' : '' }}">Sistem</a>
                        </li>
                        <li>
                            <a href="{{ route('akun') }}"
                                class="flex items-center w-full p-2 text-gray-600 transition duration-75 rounded-lg pl-11 hover:bg-amber-50 hover:text-amber-700 {{ request()->routeIs('akun') ? 'font-bold text-amber-700 bg-amber-50/50' : '' }}">Kelola
                                Akun</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{ url('/') }}" target="_blank"
                        class="flex items-center p-2 text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 group transition">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-400 transition duration-75 group-hover:text-indigo-600"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Lihat Web Tamu</span>
                    </a>
                </li>

            </ul>
        </div>
    </aside>

    <div class="p-4 sm:ml-64 mt-14">
        <div class="p-4 sm:p-6 lg:p-8">
            {{ $slot }}
        </div>
    </div>
    <style>
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
                transform: translateY(-10px);
            }
        }

        .toast-slide-in {
            animation: slideInRight 0.4s ease-out forwards;
        }

        .toast-fade-out {
            animation: fadeOut 0.4s ease-out forwards;
        }
    </style>

    <script>
        // Fungsi Memunculkan Notifikasi Secara Visual
        function showGlobalToast(type, customName = '') {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            let icon = '',
                title = '',
                desc = '',
                bgColor = '',
                textColor = '';

            if (type === 'reservasi') {
                icon = '🛎️';
                title = 'Reservasi Online Baru!';
                desc = customName ? `Ada pesanan kamar baru dari <b>${customName}</b> via Website.` :
                    'Ada pesanan kamar baru via Website.';
                bgColor = 'bg-blue-50';
                textColor = 'text-blue-900';
            } else if (type === 'checkin') {
                icon = '🔑';
                title = 'Waktu Check-In Tiba';
                desc = 'Ada jadwal kedatangan tamu hari ini.';
                bgColor = 'bg-emerald-50';
                textColor = 'text-emerald-900';
            } else if (type === 'checkout') {
                icon = '⏰';
                title = 'Peringatan Check-Out';
                desc = 'Ada tamu yang telah melewati batas waktu inap.';
                bgColor = 'bg-rose-50';
                textColor = 'text-rose-900';
            }

            toast.className =
                `flex items-start gap-3 p-4 w-72 md:w-80 rounded-2xl shadow-xl border border-gray-200 pointer-events-auto toast-slide-in ${bgColor}`;
            toast.innerHTML =
                `<div class="text-2xl">${icon}</div><div class="flex-1"><h4 class="text-sm font-black ${textColor}">${title}</h4><p class="text-xs text-gray-600 mt-1 leading-relaxed">${desc}</p></div>`;

            container.appendChild(toast);
            setTimeout(() => {
                toast.classList.replace('toast-slide-in', 'toast-fade-out');
                setTimeout(() => toast.remove(), 400);
            }, 4000);
        }

        // AJAX POLLING: Mengecek database ke server setiap 10 detik
        setInterval(async () => {
            // Hanya bekerja jika Admin menyalakan sakelar Notifikasi Reservasi di Pengaturan
            if (localStorage.getItem('notif_reservasi') === 'true') {
                try {
                    // TAMBAHAN: Memberikan identitas AJAX agar Laravel tidak menyimpannya saat sesi habis
                    let response = await fetch('/api/cek-notifikasi', {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    // Jika sesi login habis (401 Unauthorized), hentikan proses pengecekan diam-diam
                    if (response.status === 401 || response.status === 419) {
                        return;
                    }

                    let data = await response.json();

                    if (data.latest_id > 0) {
                        // Ambil ID terakhir yang pernah dinotifikasi dari penyimpanan browser
                        let lastSavedId = localStorage.getItem('last_notified_res_id') || 0;

                        // Jika ada ID baru yang lebih besar dari ID yang terakhir disimpan
                        if (data.latest_id > parseInt(lastSavedId)) {
                            showGlobalToast('reservasi', data.nama_tamu);

                            // Perbarui ID terakhir agar notifikasi tidak muncul berulang-ulang
                            localStorage.setItem('last_notified_res_id', data.latest_id);
                        }
                    }
                } catch (error) {
                    console.error("Gagal mendeteksi reservasi baru:", error);
                }
            }
        }, 10000); // 10000 milidetik = 10 detik
    </script>

</body>

</html>

<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fisa Hotel</title>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-amber-50/50 antialiased pb-20 lg:pb-0 relative">

    @php
        $isProfile = request()->is('*profil*');
        $isReservasi = request()->is('*reservasi*');
        $isRiwayat = request()->is('*riwayat*');
        $isNotif = request()->is('*pusat-notifikasi*');

        $isSolidBg = $isProfile || $isReservasi || $isRiwayat || $isNotif;

        $navBgClass = $isSolidBg
            ? 'bg-amber-600 border-none'
            : 'bg-white/80 backdrop-blur-md border-b border-amber-200/60 shadow-sm';

        $textColor = $isSolidBg ? 'text-white' : 'text-amber-950';
        $hoverColor = $isSolidBg ? 'hover:text-amber-100' : 'hover:text-amber-600';
    @endphp

    <header class="absolute top-0 left-0 right-0 w-full z-[999] {{ $navBgClass }} transition-colors duration-300">
        <nav aria-label="Global" class="mx-auto flex max-w-7xl items-center justify-between p-4 lg:p-5 lg:px-8">
            <div class="flex lg:flex-1">
                <a href="{{ url('/') }}" class="-m-1.5 p-1.5 flex items-center gap-2">
                    <span class="sr-only">Fisa Hotel</span>
                    @if ($isSolidBg)
                        <img src="{{ asset('storage/landingpage/logofisa.png') }}" alt="Logo"
                            class="h-8 w-auto brightness-0 invert" />
                    @else
                        <img src="{{ asset('storage/landingpage/logofisa.png') }}" alt="Logo" class="h-8 w-auto"
                            style="filter: sepia(100%) hue-rotate(10deg) saturate(200%) brightness(50%);" />
                    @endif
                    <span class="font-extrabold text-2xl tracking-tight {{ $textColor }} hidden sm:block">FISA
                        HOTEL</span>
                </a>
            </div>

            <el-popover-group class="hidden lg:flex lg:gap-x-12">
                <a href="{{ url('/') }}"
                    class="text-sm font-semibold {{ request()->is('/') ? ($isSolidBg ? 'text-white border-b-2 border-white pb-1' : 'text-amber-700 border-b-2 border-amber-600 pb-1') : $textColor }} tracking-wide transition-all">Beranda</a>
                <a href="{{ route('reservasi.tamu') }}"
                    class="text-sm font-semibold {{ $isReservasi ? 'text-white border-b-2 border-white pb-1' : $textColor }} {{ $hoverColor }} tracking-wide transition-all">Reservasi</a>
                <a href="{{ route('riwayat.tamu') }}"
                    class="text-sm font-semibold {{ $isRiwayat ? 'text-white border-b-2 border-white pb-1' : $textColor }} {{ $hoverColor }} tracking-wide transition-all">Riwayat</a>
                <a href="{{ route('profil.tamu') }}"
                    class="text-sm font-semibold {{ $isProfile ? 'text-white border-b-2 border-white pb-1' : $textColor }} {{ $hoverColor }} tracking-wide transition-all">Profil</a>
            </el-popover-group>

            <div class="flex lg:flex-1 justify-end items-center">
                @auth
                    <div class="flex items-center gap-3 sm:gap-4">

                        @if (!$isProfile)
                            <div class="hidden sm:flex items-center gap-3">
                                <span
                                    class="text-sm font-bold {{ $textColor }}">{{ explode(' ', trim(auth()->user()->name))[0] }}</span>
                                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=FDE68A&color=92400E&size=40' }}"
                                    alt="Avatar"
                                    class="size-9 rounded-full object-cover border-2 {{ $isSolidBg ? 'border-white/50' : 'border-amber-300' }} shadow-sm">
                            </div>
                            <div class="sm:hidden block">
                                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=FDE68A&color=92400E&size=40' }}"
                                    alt="Avatar"
                                    class="size-8 rounded-full object-cover shadow-sm border {{ $isSolidBg ? 'border-white/50' : 'border-amber-200' }}">
                            </div>
                        @endif

                        <div class="relative" x-data="{
                            openNotif: false,
                            unreadCount: {{ auth()->user()->unreadNotifications->count() }},
                            notifications: [],
                            async fetchNotif() {
                                try {
                                    let response = await fetch('/api/notifikasi-terbaru');
                                    let data = await response.json();
                                    this.unreadCount = data.unreadCount;
                                    this.notifications = data.notifications;
                                } catch (e) {
                                    console.error('Gagal mengambil data notifikasi:', e);
                                }
                            }
                        }" x-init="fetchNotif();
                        setInterval(() => fetchNotif(), 10000)"
                            @click.outside="openNotif = false">

                            <button @click="openNotif = !openNotif"
                                class="relative p-1.5 rounded-full transition focus:outline-none {{ $isSolidBg ? 'hover:bg-white/20' : 'hover:bg-black/10' }}">
                                <svg class="w-6 h-6 {{ $textColor }} transition-colors" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>

                                <template x-if="unreadCount > 0">
                                    <span x-text="unreadCount > 99 ? '99+' : unreadCount"
                                        class="absolute top-0 right-0 inline-flex items-center justify-center w-4 h-4 text-[9px] font-bold text-white bg-red-500 border-2 border-white rounded-full translate-x-1 -translate-y-1">
                                    </span>
                                </template>
                            </button>

                            <div x-show="openNotif" x-transition.opacity x-cloak
                                class="absolute right-0 mt-4 w-[300px] sm:w-[380px] bg-white rounded-2xl shadow-2xl border border-amber-100 overflow-hidden z-50 origin-top-right">
                                <div
                                    class="bg-amber-50 px-5 py-4 border-b border-amber-100 flex justify-between items-center">
                                    <h3 class="font-bold text-amber-950 text-sm">Notifikasi Terbaru</h3>
                                    <span x-text="unreadCount + ' Baru'"
                                        class="text-[10px] font-bold bg-amber-200 text-amber-800 px-2.5 py-1 rounded-full"></span>
                                </div>

                                <div class="max-h-[350px] overflow-y-auto">
                                    <template x-for="notif in notifications" :key="notif.id">
                                        <a :href="'/pusat-notifikasi?id=' + notif.id"
                                            class="block px-5 py-4 border-b border-gray-50 hover:bg-amber-50/50 transition">
                                            <p class="text-sm font-bold text-gray-900 mb-1" x-text="notif.title"></p>
                                            <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed"
                                                x-text="notif.message"></p>
                                            <p class="text-[10px] font-bold text-amber-600 mt-2" x-text="notif.time"></p>
                                        </a>
                                    </template>

                                    <template x-if="notifications.length === 0">
                                        <div class="px-5 py-10 text-center">
                                            <span class="text-4xl opacity-30 block mb-3">📭</span>
                                            <p class="text-sm font-medium text-gray-400">Belum ada notifikasi baru.</p>
                                        </div>
                                    </template>
                                </div>

                                <div class="bg-gray-50 p-3 border-t border-gray-100 text-center">
                                    <a href="{{ route('notif.tamu') }}"
                                        class="text-sm font-bold text-amber-600 hover:text-amber-700 hover:underline">
                                        Lihat Semua Notifikasi &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                @else
                    @if (!$isProfile)
                        <a href="{{ route('login') }}"
                            class="text-sm font-bold {{ $isSolidBg ? 'bg-white text-amber-700 hover:bg-amber-50' : 'bg-amber-600 text-white hover:bg-amber-700' }} px-5 py-2.5 rounded-lg transition shadow-md shadow-amber-600/20">
                            Masuk
                        </a>
                    @endif
                @endauth
            </div>
        </nav>
    </header>

    <main>
        {{ $slot }}
    </main>

    <div
        class="fixed bottom-0 left-0 right-0 z-[9999] w-full bg-white border-t border-amber-100 lg:hidden shadow-[0_-5px_15px_-3px_rgba(0,0,0,0.05)]">
        <div class="grid h-16 max-w-lg grid-cols-4 mx-auto font-medium">
            <a href="{{ url('/') }}"
                class="inline-flex flex-col items-center justify-center px-5 group hover:bg-amber-50/50">
                <svg class="w-6 h-6 mb-1 {{ request()->is('/') ? 'text-amber-600' : 'text-amber-900/40 group-hover:text-amber-600' }}"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path clip-rule="evenodd" fill-rule="evenodd"
                        d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z">
                    </path>
                </svg>
                <span
                    class="text-[10px] {{ request()->is('/') ? 'text-amber-600 font-bold' : 'text-amber-900/50 group-hover:text-amber-600' }}">Beranda</span>
            </a>

            <a href="{{ route('reservasi.tamu') }}"
                class="inline-flex flex-col items-center justify-center px-5 hover:bg-amber-50/50 group">
                <svg class="w-6 h-6 mb-1 {{ $isReservasi ? 'text-amber-600' : 'text-amber-900/40 group-hover:text-amber-600' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                <span
                    class="text-[10px] {{ $isReservasi ? 'font-bold text-amber-600' : 'text-amber-900/50 group-hover:text-amber-600' }}">Reservasi</span>
            </a>

            <a href="{{ route('riwayat.tamu') }}"
                class="inline-flex flex-col items-center justify-center px-5 hover:bg-amber-50/50 group">
                <svg class="w-6 h-6 mb-1 {{ $isRiwayat ? 'text-amber-600' : 'text-amber-900/40 group-hover:text-amber-600' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                    </path>
                </svg>
                <span
                    class="text-[10px] {{ $isRiwayat ? 'font-bold text-amber-600' : 'text-amber-900/50 group-hover:text-amber-600' }}">Riwayat</span>
            </a>

            <a href="{{ route('profil.tamu') }}"
                class="inline-flex flex-col items-center justify-center px-5 hover:bg-amber-50/50 group">
                <svg class="w-6 h-6 mb-1 {{ $isProfile ? 'text-amber-600' : 'text-amber-900/40 group-hover:text-amber-600' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span
                    class="text-[10px] {{ $isProfile ? 'font-bold text-amber-600' : 'text-amber-900/50 group-hover:text-amber-600' }}">Profil</span>
            </a>
        </div>
    </div>

    <x-confirm />

    <script>
        document.addEventListener('submit', function(e) {
            const form = e.target;
            if (form.hasAttribute('data-confirm')) {
                e.preventDefault();
                const dataRaw = form.getAttribute('data-confirm').split('|');

                if (!form.id) form.id = 'auto-id-' + Math.random().toString(36).substring(2, 9);

                window.dispatchEvent(new CustomEvent('open-confirm', {
                    detail: {
                        title: dataRaw[0],
                        message: dataRaw[1],
                        confirmText: form.getAttribute('data-btn') || 'Ya, Lanjutkan',
                        target: form.id,
                        theme: form.getAttribute('data-theme') || 'amber'
                    }
                }));
            }
        });
    </script>
</body>

</html>

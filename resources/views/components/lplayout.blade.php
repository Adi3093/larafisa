<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fisa Hotel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-amber-50/50 antialiased pb-20 lg:pb-0 relative">

    @php
        $isProfile = request()->routeIs('profil.tamu*');
        $isReservasi = request()->routeIs('reservasi.tamu*');
        $isRiwayat = request()->routeIs('riwayat.tamu*');
        $isSolidBg = $isProfile || $isReservasi || $isRiwayat;
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
                @if (!$isSolidBg)
                    @auth
                        <div class="hidden sm:flex items-center gap-3">
                            <span
                                class="text-sm font-bold text-amber-950">{{ explode(' ', trim(auth()->user()->name))[0] }}</span>
                            <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=FDE68A&color=92400E&size=40' }}"
                                alt="Avatar" class="size-9 rounded-full object-cover border-2 border-amber-300 shadow-sm">
                        </div>
                        <div class="sm:hidden block">
                            <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=FDE68A&color=92400E&size=40' }}"
                                alt="Avatar" class="size-8 rounded-full object-cover shadow-sm border border-amber-200">
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm font-bold bg-amber-600 text-white px-5 py-2.5 rounded-lg hover:bg-amber-700 transition shadow-md shadow-amber-600/20">
                            Masuk
                        </a>
                    @endauth
                @endif
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
</body>

</html>

<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fisa Hotel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 relative">

    @php
        $isProfile = request()->routeIs('profil.tamu');
        $navBgClass = $isProfile ? 'bg-indigo-600 border-none' : 'bg-white shadow-sm';
        $textColor = $isProfile ? 'text-white' : 'text-gray-900';
        $hoverColor = $isProfile ? 'hover:text-blue-100' : 'hover:text-indigo-600';
    @endphp

    <header class="{{ $navBgClass }} relative z-20 transition-colors duration-300">
        <nav aria-label="Global" class="mx-auto flex max-w-7xl items-center justify-between p-4 lg:p-6 lg:px-8">
            <div class="flex lg:flex-1">
                <a href="{{ url('/') }}" class="-m-1.5 p-1.5 flex items-center gap-2">
                    <span class="sr-only">Fisa Hotel</span>
                    @if ($isProfile)
                        <svg class="h-8 w-auto text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                        </svg>
                    @else
                        <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600"
                            alt="Logo" class="h-8 w-auto" />
                    @endif
                    <span class="font-bold text-xl tracking-tight {{ $textColor }} hidden sm:block">FISA</span>
                </a>
            </div>

            <el-popover-group class="hidden lg:flex lg:gap-x-12">
                <a href="{{ url('/') }}"
                    class="text-sm font-semibold {{ request()->is('/') ? ($isProfile ? 'text-white' : 'text-indigo-600') : $textColor }} {{ $hoverColor }}">Beranda</a>
                <a href="#" class="text-sm font-semibold {{ $textColor }} {{ $hoverColor }}">Reservasi</a>
                <a href="#" class="text-sm font-semibold {{ $textColor }} {{ $hoverColor }}">Riwayat</a>
                <a href="{{ route('profil.tamu') }}"
                    class="text-sm font-semibold {{ $isProfile ? 'text-white border-b-2 border-white pb-1' : $textColor }} {{ $hoverColor }}">Profil</a>
            </el-popover-group>

            <div class="flex lg:flex-1 justify-end items-center">
                @if ($isProfile)
                @else
                    @auth
                        <div class="hidden sm:flex items-center gap-3">
                            <span
                                class="text-sm font-bold text-gray-700">{{ explode(' ', trim(auth()->user()->name))[0] }}</span>
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=E0E7FF&color=4338CA&size=40"
                                alt="Avatar" class="size-9 rounded-full object-cover border-2 border-white shadow-sm">
                        </div>

                        <div class="sm:hidden block">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=E0E7FF&color=4338CA&size=40"
                                alt="Avatar" class="size-8 rounded object-cover shadow-sm">
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm font-bold bg-indigo-600 text-white px-5 py-2.5 rounded-lg hover:bg-indigo-700 transition shadow-md shadow-indigo-200">
                            Masuk
                        </a>
                    @endauth
                @endif
            </div>
        </nav>
    </header>

    {{ $slot }}

    <div class="h-20 lg:hidden"></div>

    <div
        class="fixed bottom-0 left-0 z-50 w-full h-16 bg-white border-t border-gray-200 lg:hidden shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] pb-safe">
        <div class="grid h-full max-w-lg grid-cols-4 mx-auto font-medium">

            <a href="{{ url('/') }}"
                class="inline-flex flex-col items-center justify-center px-5 group hover:bg-gray-50">
                <svg class="w-6 h-6 mb-1 {{ request()->is('/') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }}"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path clip-rule="evenodd" fill-rule="evenodd"
                        d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z">
                    </path>
                </svg>
                <span
                    class="text-[10px] {{ request()->is('/') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }}">Beranda</span>
            </a>

            <a href="#" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group">
                <svg class="w-6 h-6 mb-1 text-gray-500 group-hover:text-indigo-600" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                <span class="text-[10px] text-gray-500 group-hover:text-indigo-600">Booking</span>
            </a>

            <a href="#" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group">
                <svg class="w-6 h-6 mb-1 text-gray-500 group-hover:text-indigo-600" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                    </path>
                </svg>
                <span class="text-[10px] text-gray-500 group-hover:text-indigo-600">Riwayat</span>
            </a>

            <a href="{{ route('profil.tamu') }}"
                class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group">
                <svg class="w-6 h-6 mb-1 {{ request()->routeIs('profil.tamu') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span
                    class="text-[10px] {{ request()->routeIs('profil.tamu') ? 'font-bold text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }}">Profil</span>
            </a>

        </div>
    </div>

</body>

</html>

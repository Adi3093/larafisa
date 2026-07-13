<x-lplayout>
    <div class="absolute top-0 left-0 w-full h-64 bg-amber-600 z-0"></div>

    <div class="relative z-10 min-h-screen pt-24 lg:pt-32 pb-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

        <div class="mb-8">
            <a href="javascript:history.back()"
                class="inline-flex items-center gap-2 text-amber-100 hover:text-white font-bold text-sm mb-4 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
            <h1 class="text-white text-3xl font-extrabold tracking-tight block">Pusat Notifikasi</h1>
            <p class="text-amber-100 mt-1">Pemberitahuan resmi mengenai reservasi dan akun Anda.</p>
        </div>

        @if (session('success'))
            <div
                class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm font-bold animate-fade-in">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div
            class="bg-white rounded-3xl shadow-xl border border-amber-100 overflow-hidden flex h-[600px] sm:h-[700px] relative w-full">

            <div id="panel-kiri" class="w-full lg:w-1/3 border-r border-amber-100 flex flex-col h-full bg-gray-50/30">
                <div class="p-4 border-b border-amber-100 bg-white flex justify-between items-center">
                    <h3 class="font-bold text-amber-950">Kotak Masuk</h3>
                    <span
                        class="text-xs font-bold bg-amber-100 text-amber-800 px-2 py-1 rounded-lg">{{ auth()->user()->unreadNotifications->count() }}
                        Baru</span>
                </div>

                <div class="flex-1 overflow-y-auto p-2 space-y-1" id="notif-list">
                    @forelse($notifications as $notif)
                        @php $isUnread = $notif->unread(); @endphp
                        <button onclick="bacaNotif('{{ $notif->id }}', this)"
                            class="w-full text-left p-3 rounded-xl transition border {{ $isUnread ? 'bg-white border-amber-200 shadow-sm' : 'bg-transparent border-transparent hover:bg-gray-100' }} notif-item"
                            data-id="{{ $notif->id }}">
                            <div class="flex justify-between items-start mb-1">
                                <h4
                                    class="text-sm font-bold {{ $isUnread ? 'text-amber-900' : 'text-gray-700' }} truncate pr-2">
                                    {{ $notif->data['title'] ?? 'Pemberitahuan' }}
                                </h4>
                                @if ($isUnread)
                                    <span class="w-2 h-2 rounded-full bg-amber-500 shrink-0 mt-1"></span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 line-clamp-1">{{ $notif->data['message'] ?? '' }}</p>
                            <p class="text-[10px] font-bold text-gray-400 mt-2">
                                {{ $notif->created_at->diffForHumans() }}</p>
                        </button>
                    @empty
                        <div class="text-center py-10 opacity-50">
                            <span class="text-4xl">📭</span>
                            <p class="text-sm font-bold text-gray-500 mt-2">Kotak masuk kosong</p>
                        </div>
                    @endforelse
                </div>

                <div class="p-4 border-t border-amber-100 bg-white flex flex-col gap-2">
                    <form action="{{ route('notif.tamu.readAll') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit"
                            class="w-full bg-amber-50 text-amber-700 text-xs font-bold py-2.5 rounded-lg hover:bg-amber-100 transition border border-amber-200">Tandai
                            Semua Dibaca</button>
                    </form>

                    <div class="grid grid-cols-2 gap-2">
                        <form action="{{ route('notif.tamu.deleteRead') }}" method="POST" class="w-full"
                            onsubmit="return confirm('Hapus semua pesan yang sudah dibaca?');">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="w-full bg-orange-50 text-orange-700 text-[10px] sm:text-xs font-bold py-2.5 rounded-lg hover:bg-orange-100 transition border border-orange-200">Hapus
                                Terbaca</button>
                        </form>
                        <form action="{{ route('notif.tamu.deleteAll') }}" method="POST" class="w-full"
                            onsubmit="return confirm('Hapus SEMUA pesan secara permanen?');">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="w-full bg-red-50 text-red-700 text-[10px] sm:text-xs font-bold py-2.5 rounded-lg hover:bg-red-100 transition border border-red-200">Hapus
                                Semua</button>
                        </form>
                    </div>
                </div>
            </div>

            <div id="panel-kanan"
                class="w-full lg:w-2/3 h-full bg-white hidden lg:flex flex-col relative overflow-y-auto">

                <div
                    class="lg:hidden flex items-center p-4 border-b border-gray-100 bg-amber-50 sticky top-0 z-20 shadow-sm">
                    <button onclick="kembaliKeDaftar()"
                        class="flex items-center gap-2 text-amber-700 font-bold text-sm hover:text-amber-800 transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali ke Kotak Masuk
                    </button>
                </div>

                <div id="read-empty"
                    class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 {{ $activeNotifId ? 'hidden' : '' }}">
                    <div class="w-24 h-24 bg-amber-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-400">Pilih pesan untuk dibaca</h3>
                    <p class="text-sm text-gray-400 mt-2">Detail pemberitahuan akan muncul di panel ini.</p>
                </div>

                <div id="read-loading" class="absolute inset-0 flex items-center justify-center bg-white z-10 hidden">
                    <p class="text-sm font-bold text-amber-600 animate-pulse">Memuat pesan...</p>
                </div>

                <div id="read-content" class="p-5 sm:p-8 hidden">
                    <div class="mb-6 sm:mb-8 border-b border-gray-100 pb-6">
                        <span id="c-type"
                            class="inline-block px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider mb-3">INFO</span>
                        <h2 id="c-title" class="text-xl sm:text-2xl font-black text-amber-950 leading-tight"></h2>
                        <p id="c-date" class="text-xs font-bold text-gray-400 mt-3 flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span></span>
                        </p>
                    </div>

                    <div id="c-message" class="text-sm text-gray-700 leading-relaxed font-medium whitespace-pre-wrap">
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }
    </style>

    <script>
        window.LaravelCSRFToken = '{{ csrf_token() }}';
        window.activeNotifId = '{{ $activeNotifId }}';
    </script>
    <script src="{{ asset('js/landingpage/hnotif.js') }}?v={{ time() }}"></script>
</x-lplayout>

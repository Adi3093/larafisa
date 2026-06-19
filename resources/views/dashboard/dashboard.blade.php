<x-dblayout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Dashboard Resepsionis</h1>
        <p class="text-sm text-gray-500 mt-1">Ringkasan okupansi kamar dan jadwal kedatangan tamu hotel FISA.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-6">

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="bg-emerald-100 p-3 rounded-xl hidden sm:block"><span class="text-xl">🛏️</span></div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Kamar Tersedia</p>
                        <h3 class="text-2xl font-black text-gray-900">{{ $kamarTersedia }}</h3>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="bg-blue-100 p-3 rounded-xl hidden sm:block"><span class="text-xl">🚪</span></div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Kamar Dipakai</p>
                        <h3 class="text-2xl font-black text-gray-900">{{ $kamarTerpakai }}</h3>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="bg-rose-100 p-3 rounded-xl hidden sm:block"><span class="text-xl">🛠️</span></div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Dlm Perbaikan</p>
                        <h3 class="text-2xl font-black text-gray-900">{{ $kamarPerbaikan }}</h3>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="bg-amber-100 p-3 rounded-xl hidden sm:block"><span class="text-xl">👥</span></div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah Tamu</p>
                        <h3 class="text-2xl font-black text-gray-900">{{ $jumlahTamu }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 rounded-t-2xl">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Jadwal Mendatang (7 Hari Kedepan)
                    </h3>
                </div>
                <div class="p-5 space-y-4">
                    @forelse ($listJadwalMendatang as $jadwal)
                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 border border-gray-200 rounded-xl hover:shadow-md transition bg-white gap-4">
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $jadwal->nama_tamu }} <span
                                        class="text-xs text-indigo-600 ml-2">#{{ $jadwal->no_reservasi }}</span></h4>
                                <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                    <span class="text-emerald-500 font-bold">IN:</span>
                                    {{ \Carbon\Carbon::parse($jadwal->check_in)->translatedFormat('d M Y, H:i') }} WIB
                                    <span class="mx-1">|</span>
                                    Kamar: <span
                                        class="font-bold text-gray-700">{{ $jadwal->kamar?->nomor_ruangan ?? 'Belum Set' }}</span>
                                </p>
                            </div>
                            <form action="{{ route('reservasi') }}" method="GET" class="w-full sm:w-auto m-0">
                                <input type="hidden" name="search" value="{{ $jadwal->no_reservasi }}">
                                <button type="submit"
                                    class="w-full sm:w-auto bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white border border-indigo-200 px-4 py-2 rounded-lg text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-sm">
                                    Buka Detail &rarr;
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <span class="text-4xl block mb-2 opacity-50">📅</span>
                            <p class="text-sm font-medium text-gray-400">Tidak ada jadwal reservasi kedatangan dalam 7
                                hari ke depan.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sticky top-6">
                <div id="calendar" class="text-sm"></div>
                <p class="text-[10px] text-gray-400 mt-4 text-center">*Tanggal kuning menandakan ada tamu yang akan
                    Check-In.</p>
            </div>
        </div>

    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil array JSON tanggal (Misal: ["2026-06-18", "2026-06-24"])
            const markedDates = @json($jadwalReservasi);

            // Ubah format string tanggal menjadi Object Event kalender
            const calendarEvents = markedDates.map(date => {
                return {
                    title: 'Ada Jadwal',
                    start: date,
                    display: 'background', // Membuat kotak tanggalnya full warna
                    backgroundColor: '#d97706' // Warna Amber 600
                };
            });

            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                height: 400,
                headerToolbar: {
                    left: 'prev',
                    center: 'title',
                    right: 'next'
                },
                events: calendarEvents,
                dateClick: function(info) {
                    // Ketika tanggal diklik, lemparkan ke halaman reservasi dengan filter pencarian tanggal
                    window.location.href = `/reservasi?search=${info.dateStr}`;
                }
            });

            calendar.render();
        });
    </script>

    <style>
        .fc .fc-toolbar-title {
            font-size: 1.1rem;
            font-weight: bold;
            color: #1f2937;
        }

        .fc .fc-col-header-cell-cushion {
            color: #6b7280;
            font-weight: 600;
            padding: 4px;
        }

        .fc .fc-daygrid-day-number {
            color: #4b5563;
            font-weight: bold;
        }

        .fc .fc-button-primary {
            background-color: #f3f4f6;
            border-color: #e5e7eb;
            color: #4b5563;
        }

        .fc .fc-button-primary:hover {
            background-color: #e5e7eb;
            border-color: #d1d5db;
            color: #1f2937;
        }

        .fc .fc-button-primary:not(:disabled):active {
            background-color: #d1d5db;
        }
    </style>
</x-dblayout>

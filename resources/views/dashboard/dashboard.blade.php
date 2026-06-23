<x-dblayout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Dashboard</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="bg-emerald-100 p-3 rounded-xl hidden sm:block text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 32 32">
                            <path fill="currentColor"
                                d="M6 6C4.355 6 3 7.355 3 9v6.78c-.61.552-1 1.342-1 2.22v9h5v-2h18v2h5v-9c0-.878-.39-1.668-1-2.22V9c0-1.645-1.355-3-3-3H6zm0 2h20c.555 0 1 .445 1 1v6h-2v-1c0-1.645-1.355-3-3-3h-4c-.767 0-1.467.3-2 .78a2.985 2.985 0 0 0-2-.78h-4c-1.645 0-3 1.355-3 3v1H5V9c0-.555.445-1 1-1zm4 5h4c.555 0 1 .445 1 1v1H9v-1c0-.555.445-1 1-1zm8 0h4c.555 0 1 .445 1 1v1h-6v-1c0-.555.445-1 1-1zM5 17h22c.555 0 1 .445 1 1v7h-1v-2H5v2H4v-7c0-.555.445-1 1-1z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Kamar Tersedia</p>
                        <h3 class="text-2xl font-black text-gray-900">{{ $kamarTersedia }}</h3>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="bg-blue-100 p-3 rounded-xl hidden sm:block text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M13.1 23q-2.1 0-3.937-.8t-3.2-2.163Q4.6 18.675 3.8 16.837T3 12.9q0-3.65 2.325-6.438T11.25 3q-.45 2.475.275 4.838t2.5 4.137q1.775 1.775 4.138 2.5T23 14.75q-.65 3.6-3.45 5.925T13.1 23Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Kamar Dipakai</p>
                        <h3 class="text-2xl font-black text-gray-900">{{ $kamarTerpakai }}</h3>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="bg-rose-100 p-3 rounded-xl hidden sm:block text-rose-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 512 512">
                            <path fill="currentColor"
                                d="M503.58 126.2a16.85 16.85 0 0 0-27.07-4.55l-51.15 51.15a11.15 11.15 0 0 1-15.66 0l-22.48-22.48a11.17 11.17 0 0 1 0-15.67l50.88-50.89a16.85 16.85 0 0 0-5.27-27.4c-39.71-17-89.08-7.45-120 23.29c-26.81 26.61-34.83 68-22 113.7a11 11 0 0 1-3.16 11.1L114.77 365.1a56.76 56.76 0 1 0 80.14 80.18L357 272.08a11 11 0 0 1 10.9-3.17c45 12 86 4 112.43-22c15.2-15 25.81-36.17 29.89-59.71c3.83-22.2 1.41-44.44-6.64-61Z" />
                            <path fill="currentColor"
                                d="M437.33 378.41c-13.94-11.59-43.72-38.4-74.07-66.22l-66.07 70.61c28.24 30 53.8 57.85 65 70.88l.07.08A30 30 0 0 0 383.72 464h1.1a30.11 30.11 0 0 0 21-8.62l.07-.07l33.43-33.37a29.46 29.46 0 0 0-2-43.53ZM118.54 214.55a20.48 20.48 0 0 0-3-10.76a2.76 2.76 0 0 1 2.62-4.22h.06c.84.09 5.33.74 11.7 4.61c4.73 2.87 18.23 12.08 41.73 35.54a34.23 34.23 0 0 0 7.22 22.12l66.23-61.55a33.73 33.73 0 0 0-21.6-9.2a2.65 2.65 0 0 1-.21-.26l-.65-.69l-24.54-33.84a28.45 28.45 0 0 1-4-26.11a35.23 35.23 0 0 1 11.78-16.35c5.69-4.41 18.53-9.72 29.44-10.62a52.92 52.92 0 0 1 15.19.94a65.57 65.57 0 0 1 7.06 2.13a15.46 15.46 0 0 0 2.15.63a16 16 0 0 0 16.38-25.06c-.26-.35-1.32-1.79-2.89-3.73a91.85 91.85 0 0 0-9.6-10.36c-8.15-7.36-29.27-19.77-57-19.77a123.13 123.13 0 0 0-46.3 9c-38.37 15.45-63.47 36.58-75.01 47.79l-.09.09A222.14 222.14 0 0 0 63.7 129.5a27 27 0 0 0-4.7 11.77a7.33 7.33 0 0 1-7.71 6.17H50.2a20.65 20.65 0 0 0-14.59 5.9L6.16 182.05l-.32.32a20.89 20.89 0 0 0-.24 28.72c.19.2.37.39.57.58L53.67 258a21 21 0 0 0 14.65 6a20.65 20.65 0 0 0 14.59-5.9l29.46-28.79a20.51 20.51 0 0 0 6.17-14.76Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Dalam Perbaikan</p>
                        <h3 class="text-2xl font-black text-gray-900">{{ $kamarPerbaikan }}</h3>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="bg-amber-100 p-3 rounded-xl hidden sm:block text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 1024 1024">
                            <path fill="currentColor"
                                d="M746 835.28L544.529 723.678c74.88-58.912 95.216-174.688 95.216-239.601v-135.12c0-89.472-118.88-189.12-238.288-189.12c-119.376 0-241.408 99.664-241.408 189.12v135.12c0 59.024 24.975 178.433 100.624 239.089L54 835.278S0 859.342 0 889.342v81.088c0 29.84 24.223 54.064 54 54.064h692c29.807 0 54.031-24.224 54.031-54.064v-81.087c0-31.808-54.032-54.064-54.032-54.064zm-9.967 125.215H64.002V903.28c4.592-3.343 11.008-7.216 16.064-9.536c1.503-.688 3.007-1.408 4.431-2.224l206.688-112.096c18.848-10.224 31.344-29.184 33.248-50.528s-7.008-42.256-23.712-55.664c-53.664-43.024-76.656-138.32-76.656-189.152V348.96c0-45.968 86.656-125.12 177.408-125.12c92.432 0 174.288 78.065 174.288 125.12v135.12c0 50.128-15.568 145.84-70.784 189.28a64.098 64.098 0 0 0-24.224 55.664a64.104 64.104 0 0 0 33.12 50.849l201.472 111.6c1.777.975 4.033 2.031 5.905 2.848c4.72 2 10.527 5.343 14.783 8.288v57.887zM969.97 675.936L765.505 564.335c74.88-58.912 98.224-174.688 98.224-239.601v-135.12c0-89.472-121.872-190.128-241.28-190.128c-77.6 0-156.943 42.192-203.12 96.225c26.337 1.631 55.377 1.664 80.465 9.664c33.711-26.256 76.368-41.872 122.656-41.872c92.431 0 177.278 79.055 177.278 126.128v135.12c0 50.127-18.56 145.84-73.775 189.28a64.098 64.098 0 0 0-24.224 55.664a64.104 64.104 0 0 0 33.12 50.848l204.465 111.6c1.776.976 4.032 2.032 5.904 2.848c4.72 2 10.527 5.344 14.783 8.288v56.912H830.817c19.504 14.72 25.408 35.776 32.977 64h106.192c29.807 0 54.03-24.224 54.03-54.064V730.03c-.015-31.84-54.047-54.096-54.047-54.096z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah Tamu</p>
                        <h3 class="text-2xl font-black text-gray-900">{{ $jumlahTamu }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 rounded-t-2xl">
                    <h3 id="jadwal-title" class="font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Jadwal Hari Ini ({{ \Carbon\Carbon::today()->translatedFormat('d F Y') }})
                    </h3>
                    <button id="btn-reset-jadwal" onclick="window.location.reload()"
                        class="hidden text-xs text-indigo-600 font-bold hover:underline transition">
                        &larr; Kembali ke Hari Ini
                    </button>
                </div>

                <div id="list-jadwal-container" class="p-5 space-y-4">
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
                            <p class="text-sm font-medium text-gray-400">Tidak ada jadwal reservasi kedatangan untuk
                                hari ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sticky top-6">
                <div id="calendar" class="text-sm"></div>
                <p class="text-[10px] text-gray-400 mt-4 text-center">*Tanggal emas menandakan ada tamu yang akan
                    Check-In.</p>
            </div>
        </div>

    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const markedDates = @json($jadwalReservasi);

            const calendarEvents = markedDates.map(date => {
                return {
                    title: 'Jadwal',
                    start: date,
                    display: 'background',
                    backgroundColor: '#d97706'
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

                dateClick: async function(info) {
                    const clickedDate = info.dateStr;

                    const dateObj = new Date(clickedDate);
                    const formattedTitle = dateObj.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });

                    document.getElementById('jadwal-title').innerHTML = `
                        <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Jadwal: ${formattedTitle}
                    `;
                    document.getElementById('btn-reset-jadwal').classList.remove('hidden');

                    let container = document.getElementById('list-jadwal-container');
                    container.innerHTML =
                        '<div class="text-center py-8"><p class="text-sm font-bold text-gray-500 animate-pulse">Memuat daftar reservasi...</p></div>';

                    try {
                        let res = await fetch(`/api/jadwal-harian?tanggal=${clickedDate}`);
                        let data = await res.json();

                        container.innerHTML = '';
                        if (data.length === 0) {
                            container.innerHTML = `
                                <div class="text-center py-8">
                                    <span class="text-4xl block mb-2 opacity-50">🏖️</span>
                                    <p class="text-sm font-medium text-gray-400">Kalender kosong. Tidak ada jadwal reservasi kedatangan pada tanggal ini.</p>
                                </div>
                            `;
                        } else {
                            data.forEach(j => {
                                container.innerHTML += `
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 border border-gray-200 rounded-xl hover:shadow-md transition bg-white gap-4 animate-fade-in">
                                        <div>
                                            <h4 class="font-bold text-gray-900">${j.nama_tamu} <span class="text-xs text-indigo-600 ml-2">#${j.no_reservasi}</span></h4>
                                            <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                                <span class="text-emerald-500 font-bold">IN:</span> ${j.waktu_in} 
                                                <span class="mx-1">|</span> 
                                                Kamar: <span class="font-bold text-gray-700">${j.kamar}</span>
                                            </p>
                                        </div>
                                        <form action="/reservasi" method="GET" class="w-full sm:w-auto m-0">
                                            <input type="hidden" name="search" value="${j.no_reservasi}">
                                            <button type="submit" class="w-full sm:w-auto bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white border border-indigo-200 px-4 py-2 rounded-lg text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-sm">
                                                Buka Detail &rarr;
                                            </button>
                                        </form>
                                    </div>
                                `;
                            });
                        }
                    } catch (e) {
                        container.innerHTML =
                            '<p class="text-center text-red-500 py-8 font-bold">Terjadi kesalahan pada server saat memuat jadwal.</p>';
                    }
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
            cursor: pointer;
        }

        .fc .fc-daygrid-day:hover {
            background-color: #f9fafb;
            cursor: pointer;
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

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }
    </style>
</x-dblayout>

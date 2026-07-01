<x-dblayout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-amber-950 tracking-tight">Dashboard Utama</h1>
        <p class="text-sm text-amber-900/70 mt-1">Ringkasan performa sistem dan jadwal Fisa Hotel hari ini.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div
            class="bg-white p-5 rounded-2xl border border-amber-100 shadow-sm flex items-center gap-4 hover:shadow-md transition">
            <div class="bg-emerald-100 p-3 rounded-xl hidden sm:block text-emerald-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 32 32">
                    <path fill="currentColor"
                        d="M6 6C4.355 6 3 7.355 3 9v6.78c-.61.552-1 1.342-1 2.22v9h5v-2h18v2h5v-9c0-.878-.39-1.668-1-2.22V9c0-1.645-1.355-3-3-3H6zm0 2h20c.555 0 1 .445 1 1v6h-2v-1c0-1.645-1.355-3-3-3h-4c-.767 0-1.467.3-2 .78a2.985 2.985 0 0 0-2-.78h-4c-1.645 0-3 1.355-3 3v1H5V9c0-.555.445-1 1-1zm4 5h4c.555 0 1 .445 1 1v1H9v-1c0-.555.445-1 1-1zm8 0h4c.555 0 1 .445 1 1v1h-6v-1c0-.555.445-1 1-1zM5 17h22c.555 0 1 .445 1 1v7h-1v-2H5v2H4v-7c0-.555.445-1 1-1z" />
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-amber-800/70 uppercase tracking-wider">Kamar Tersedia</p>
                <h3 class="text-2xl font-black text-amber-950">{{ $kamarTersedia }}</h3>
            </div>
        </div>
        <div
            class="bg-white p-5 rounded-2xl border border-amber-100 shadow-sm flex items-center gap-4 hover:shadow-md transition">
            <div class="bg-blue-100 p-3 rounded-xl hidden sm:block text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M13.1 23q-2.1 0-3.937-.8t-3.2-2.163Q4.6 18.675 3.8 16.837T3 12.9q0-3.65 2.325-6.438T11.25 3q-.45 2.475.275 4.838t2.5 4.137q1.775 1.775 4.138 2.5T23 14.75q-.65 3.6-3.45 5.925T13.1 23Z" />
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-amber-800/70 uppercase tracking-wider">Kamar Terpakai</p>
                <h3 class="text-2xl font-black text-amber-950">{{ $kamarTerpakai }}</h3>
            </div>
        </div>
        <div
            class="bg-white p-5 rounded-2xl border border-amber-100 shadow-sm flex items-center gap-4 hover:shadow-md transition">
            <div class="bg-rose-100 p-3 rounded-xl hidden sm:block text-rose-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 512 512">
                    <path fill="currentColor"
                        d="M503.58 126.2a16.85 16.85 0 0 0-27.07-4.55l-51.15 51.15a11.15 11.15 0 0 1-15.66 0l-22.48-22.48a11.17 11.17 0 0 1 0-15.67l50.88-50.89a16.85 16.85 0 0 0-5.27-27.4c-39.71-17-89.08-7.45-120 23.29c-26.81 26.61-34.83 68-22 113.7a11 11 0 0 1-3.16 11.1L114.77 365.1a56.76 56.76 0 1 0 80.14 80.18L357 272.08a11 11 0 0 1 10.9-3.17c45 12 86 4 112.43-22c15.2-15 25.81-36.17 29.89-59.71c3.83-22.2 1.41-44.44-6.64-61Z" />
                    <path fill="currentColor"
                        d="M437.33 378.41c-13.94-11.59-43.72-38.4-74.07-66.22l-66.07 70.61c28.24 30 53.8 57.85 65 70.88l.07.08A30 30 0 0 0 383.72 464h1.1a30.11 30.11 0 0 0 21-8.62l.07-.07l33.43-33.37a29.46 29.46 0 0 0-2-43.53ZM118.54 214.55a20.48 20.48 0 0 0-3-10.76a2.76 2.76 0 0 1 2.62-4.22h.06c.84.09 5.33.74 11.7 4.61c4.73 2.87 18.23 12.08 41.73 35.54a34.23 34.23 0 0 0 7.22 22.12l66.23-61.55a33.73 33.73 0 0 0-21.6-9.2a2.65 2.65 0 0 1-.21-.26l-.65-.69l-24.54-33.84a28.45 28.45 0 0 1-4-26.11a35.23 35.23 0 0 1 11.78-16.35c5.69-4.41 18.53-9.72 29.44-10.62a52.92 52.92 0 0 1 15.19.94a65.57 65.57 0 0 1 7.06 2.13a15.46 15.46 0 0 0 2.15.63a16 16 0 0 0 16.38-25.06c-.26-.35-1.32-1.79-2.89-3.73a91.85 91.85 0 0 0-9.6-10.36c-8.15-7.36-29.27-19.77-57-19.77a123.13 123.13 0 0 0-46.3 9c-38.37 15.45-63.47 36.58-75.01 47.79l-.09.09A222.14 222.14 0 0 0 63.7 129.5a27 27 0 0 0-4.7 11.77a7.33 7.33 0 0 1-7.71 6.17H50.2a20.65 20.65 0 0 0-14.59 5.9L6.16 182.05l-.32.32a20.89 20.89 0 0 0-.24 28.72c.19.2.37.39.57.58L53.67 258a21 21 0 0 0 14.65 6a20.65 20.65 0 0 0 14.59-5.9l29.46-28.79a20.51 20.51 0 0 0 6.17-14.76Z" />
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-amber-800/70 uppercase tracking-wider">Kamar Perbaikan</p>
                <h3 class="text-2xl font-black text-amber-950">{{ $kamarPerbaikan }}</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6" x-data="chartManager()">

        <div class="lg:col-span-2 space-y-6">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-amber-200 shadow-sm flex flex-col justify-center">
                    <div class="flex justify-between items-center mb-1">
                        <p class="text-[10px] font-bold text-amber-800/70 uppercase tracking-wider"
                            x-text="`Total Tamu (${viewMode})`"></p>
                    </div>
                    <h3 class="text-3xl font-black text-amber-950"
                        x-text="viewMode === 'Mingguan' ? {{ $tamuMinggu }} : {{ $tamuBulan }}"></h3>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-amber-200 shadow-sm flex flex-col justify-center">
                    <div class="flex justify-between items-center mb-1">
                        <p class="text-[10px] font-bold text-amber-800/70 uppercase tracking-wider"
                            x-text="`Total Pendapatan (${viewMode})`"></p>
                    </div>
                    <h3 class="text-3xl font-black text-emerald-600"
                        x-text="formatRupiah(viewMode === 'Mingguan' ? {{ $pendapatanMinggu }} : {{ $pendapatanBulan }})">
                    </h3>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-amber-200 shadow-sm">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
                    <h3 class="font-bold text-amber-950 text-lg">Grafik Data Analitik</h3>
                    <div class="flex gap-2">
                        <select x-model="dataType" @change="updateChart()"
                            class="border-amber-200 rounded-lg text-xs font-bold text-amber-900 bg-amber-50 focus:ring-amber-500 py-2 px-3 shadow-sm">
                            <option value="pendapatan">Pendapatan (Rp)</option>
                            <option value="tamu">Jumlah Kunjungan</option>
                        </select>
                        <select x-model="viewMode" @change="updateChart()"
                            class="border-amber-200 rounded-lg text-xs font-bold text-amber-900 bg-amber-50 focus:ring-amber-500 py-2 px-3 shadow-sm">
                            <option value="Mingguan">Mingguan</option>
                            <option value="Bulanan">Bulanan</option>
                        </select>
                    </div>
                </div>
                <div class="relative h-64 w-full">
                    <canvas id="mainChart"></canvas>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-amber-200 shadow-sm p-4 sticky top-6">
                <div id="calendar" class="text-sm"></div>
                <div class="mt-4 flex items-center justify-center gap-2 border-t border-amber-100 pt-3">
                    <span class="w-3 h-3 rounded-full bg-amber-500 shadow-sm"></span>
                    <p class="text-[10px] font-bold text-amber-800">Menandakan Ada Kedatangan Tamu</p>
                </div>
            </div>
        </div>

    </div>

    <div class="bg-white rounded-2xl border border-amber-200 shadow-sm">
        <div class="p-5 border-b border-amber-100 flex justify-between items-center bg-amber-50/50 rounded-t-2xl">
            <h3 id="jadwal-title" class="font-bold text-amber-950 flex items-center gap-2 text-lg">
                <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Jadwal Kedatangan Hari Ini
                <span
                    class="text-sm font-medium text-amber-700">({{ \Carbon\Carbon::today()->translatedFormat('d M Y') }})</span>
            </h3>
            <button id="btn-reset-jadwal" onclick="window.location.reload()"
                class="hidden text-xs bg-white border border-amber-200 text-amber-700 px-3 py-1.5 rounded-lg font-bold hover:bg-amber-100 transition shadow-sm">
                &larr; Reset ke Hari Ini
            </button>
        </div>

        <div id="list-jadwal-container" class="p-5 grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse ($listJadwalMendatang as $jadwal)
                <div
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 border border-amber-200 rounded-xl hover:shadow-md hover:border-amber-400 transition bg-white gap-4">
                    <div>
                        <h4 class="font-bold text-amber-950 text-base">{{ $jadwal->nama_tamu }} <span
                                class="text-xs text-amber-500 font-black ml-2 bg-amber-50 px-2 py-0.5 rounded">#{{ $jadwal->no_reservasi }}</span>
                        </h4>
                        <p class="text-xs text-amber-900 mt-1 flex items-center gap-1.5">
                            <span
                                class="bg-emerald-100 text-emerald-700 px-1.5 py-0.5 rounded text-[10px] font-black">IN</span>
                            <span
                                class="font-bold">{{ \Carbon\Carbon::parse($jadwal->check_in)->translatedFormat('d M, H:i') }}
                                WIB</span>
                            <span class="mx-1 text-gray-300">|</span>
                            Ruang: <span
                                class="font-bold text-amber-700">{{ $jadwal->kamar?->nomor_ruangan ?? 'Belum Set' }}</span>
                        </p>
                    </div>
                    <form action="{{ route('reservasi') }}" method="GET" class="w-full sm:w-auto m-0">
                        <input type="hidden" name="search" value="{{ $jadwal->no_reservasi }}">
                        <button type="submit"
                            class="w-full sm:w-auto bg-amber-50 text-amber-700 hover:bg-amber-600 hover:text-white border border-amber-200 px-4 py-2 rounded-lg text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-sm">
                            Buka Tiket &rarr;
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 text-center py-12">
                    <span class="text-5xl block mb-3 opacity-30">📅</span>
                    <p class="text-sm font-bold text-amber-900/50">Belum ada jadwal reservasi kedatangan untuk tanggal
                        ini.</p>
                </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        const chartDataRaw = @json($chartData);
        let myChart = null;

        function chartManager() {
            return {
                viewMode: 'Mingguan', // 'Mingguan' atau 'Bulanan'
                dataType: 'pendapatan', // 'pendapatan' atau 'tamu'

                formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(number);
                },

                init() {
                    this.renderChart();
                },

                updateChart() {
                    if (myChart) {
                        myChart.destroy();
                    }
                    this.renderChart();
                },

                renderChart() {
                    const ctx = document.getElementById('mainChart').getContext('2d');

                    let isUang = this.dataType === 'pendapatan';
                    let isBulan = this.viewMode === 'Bulanan';

                    let labels = isBulan ? chartDataRaw.labels_bulan : chartDataRaw.labels_minggu;
                    let dataPoints = [];

                    if (isBulan) dataPoints = isUang ? chartDataRaw.data_uang_bulan : chartDataRaw.data_tamu_bulan;
                    else dataPoints = isUang ? chartDataRaw.data_uang_minggu : chartDataRaw.data_tamu_minggu;

                    let bgColor = isUang ? 'rgba(217, 119, 6, 0.8)' : 'rgba(5, 150, 105, 0.8)';
                    let hoverBgColor = isUang ? 'rgba(217, 119, 6, 1)' : 'rgba(5, 150, 105, 1)';
                    let yAxisPrefix = isUang ? 'Rp ' : '';

                    myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: isUang ? 'Total Pendapatan' : 'Jumlah Tamu',
                                data: dataPoints,
                                backgroundColor: bgColor,
                                hoverBackgroundColor: hoverBgColor,
                                borderRadius: 6,
                                barPercentage: 0.6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let val = context.raw;
                                            if (isUang) {
                                                return ' Rp ' + new Intl.NumberFormat('id-ID').format(val);
                                            }
                                            return ' ' + val + ' Orang';
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            if (isUang) {
                                                if (value >= 1000000) return 'Rp ' + (value / 1000000) + ' Jt';
                                                return 'Rp ' + (value / 1000) + ' K';
                                            }
                                            return value;
                                        }
                                    },
                                    grid: {
                                        borderDash: [4, 4],
                                        color: '#f3f4f6'
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                }
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const markedDates = @json($jadwalReservasi);
            const calendarEvents = markedDates.map(date => {
                return {
                    title: 'Jadwal',
                    start: date,
                    display: 'background',
                    backgroundColor: '#f59e0b'
                };
            });

            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                height: 380,
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
                        <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Jadwal Kedatangan: <span class="text-sm font-medium text-amber-700 ml-1">(${formattedTitle})</span>
                    `;
                    document.getElementById('btn-reset-jadwal').classList.remove('hidden');

                    let container = document.getElementById('list-jadwal-container');
                    container.innerHTML =
                        '<div class="col-span-1 md:col-span-2 text-center py-8"><p class="text-sm font-bold text-amber-700 animate-pulse">Memuat daftar tiket reservasi...</p></div>';

                    try {
                        let res = await fetch(`/api/jadwal-harian?tanggal=${clickedDate}`);
                        let data = await res.json();

                        container.innerHTML = '';
                        if (data.length === 0) {
                            container.innerHTML = `
                                <div class="col-span-1 md:col-span-2 text-center py-12">
                                    <span class="text-5xl block mb-3 opacity-30">🏖️</span>
                                    <p class="text-sm font-bold text-amber-900/50">Kalender kosong. Tidak ada jadwal kedatangan pada tanggal ini.</p>
                                </div>
                            `;
                        } else {
                            data.forEach(j => {
                                container.innerHTML += `
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 border border-amber-200 rounded-xl hover:shadow-md hover:border-amber-400 transition bg-white gap-4 animate-fade-in">
                                        <div>
                                            <h4 class="font-bold text-amber-950 text-base">${j.nama_tamu} <span class="text-xs text-amber-500 font-black ml-2 bg-amber-50 px-2 py-0.5 rounded">#${j.no_reservasi}</span></h4>
                                            <p class="text-xs text-amber-900 mt-1 flex items-center gap-1.5">
                                                <span class="bg-emerald-100 text-emerald-700 px-1.5 py-0.5 rounded text-[10px] font-black">IN</span>
                                                <span class="font-bold">${j.waktu_in}</span>
                                                <span class="mx-1 text-gray-300">|</span>
                                                Ruang: <span class="font-bold text-amber-700">${j.kamar}</span>
                                            </p>
                                        </div>
                                        <form action="/reservasi" method="GET" class="w-full sm:w-auto m-0">
                                            <input type="hidden" name="search" value="${j.no_reservasi}">
                                            <button type="submit" class="w-full sm:w-auto bg-amber-50 text-amber-700 hover:bg-amber-600 hover:text-white border border-amber-200 px-4 py-2 rounded-lg text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-sm">
                                                Buka Tiket &rarr;
                                            </button>
                                        </form>
                                    </div>
                                `;
                            });
                        }
                    } catch (e) {
                        container.innerHTML =
                            '<div class="col-span-1 md:col-span-2 text-center py-8"><p class="text-red-500 font-bold">Terjadi kesalahan pada server saat memuat jadwal.</p></div>';
                    }
                }
            });

            calendar.render();
        });
    </script>
    {{-- Kalender --}}
    <style>
        .fc .fc-toolbar-title {
            font-size: 1.1rem;
            font-weight: 900;
            color: #451a03;
            /* amber-950 */
        }

        .fc .fc-col-header-cell-cushion {
            color: #92400e;
            font-weight: 700;
            padding: 4px;
        }

        .fc .fc-daygrid-day-number {
            color: #78350f;
            font-weight: bold;
            cursor: pointer;
        }

        .fc .fc-daygrid-day:hover {
            background-color: #fffbeb;
            cursor: pointer;
        }

        .fc .fc-button-primary {
            background-color: #fffbeb;
            border-color: #fde68a;
            color: #92400e;
            font-weight: bold;
            text-transform: capitalize;
        }

        .fc .fc-button-primary:hover {
            background-color: #fef3c7;
            border-color: #fcd34d;
            color: #78350f;
        }

        .fc .fc-button-primary:not(:disabled):active {
            background-color: #fde68a;
            border-color: #fbbf24;
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

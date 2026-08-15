let myChart = null;
function chartManager() {
    return {
        viewMode: 'Mingguan', 
        dataType: 'pendapatan', 

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
            const rawData = window.chartDataRaw;

            let isUang = this.dataType === 'pendapatan';
            let isBulan = this.viewMode === 'Bulanan';
            let labels = isBulan ? rawData.labels_bulan : rawData.labels_minggu;
            let dataPoints = [];
            if (isBulan) dataPoints = isUang ? rawData.data_uang_bulan : rawData.data_tamu_bulan;
            else dataPoints = isUang ? rawData.data_uang_minggu : rawData.data_tamu_minggu;

            let bgColor = isUang ? 'rgba(217, 119, 6, 0.8)' : 'rgba(5, 150, 105, 0.8)';
            let hoverBgColor = isUang ? 'rgba(217, 119, 6, 1)' : 'rgba(5, 150, 105, 1)';

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
                        legend: { display: false },
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
                            grid: { borderDash: [4, 4], color: '#f3f4f6' }
                        },
                        x: { grid: { display: false } }
                    }
                }
            });
        }
    }
}
window.chartManager = chartManager;


// KAlender
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    const markedDates = window.markedDates || [];
    const calendarEvents = markedDates.map(date => {
        return {
            title: 'Jadwal',
            start: date,
            display: 'background',
            backgroundColor: '#f59e0b'
        };
    });

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
                day: 'numeric', month: 'long', year: 'numeric'
            });

            document.getElementById('jadwal-title').innerHTML = `
                <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Jadwal Kedatangan: <span class="text-sm font-medium text-amber-700 ml-1">(${formattedTitle})</span>
            `;
            document.getElementById('btn-reset-jadwal').classList.remove('hidden');

            let container = document.getElementById('list-jadwal-container');
            container.innerHTML = '<div class="col-span-1 md:col-span-2 text-center py-8"><p class="text-sm font-bold text-amber-700 animate-pulse">Memuat daftar tiket reservasi...</p></div>';

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
                container.innerHTML = '<div class="col-span-1 md:col-span-2 text-center py-8"><p class="text-red-500 font-bold">Terjadi kesalahan pada server saat memuat jadwal.</p></div>';
            }
        }
    });

    calendar.render();
});
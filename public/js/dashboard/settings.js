// ==========================================
// MODULE 1: GLOBAL STATE VARIABLES
// Variabel global untuk menyimpan state Kalender Maintenance
// ==========================================
let selectedMaintenanceDates = [];
let calendarInstance = null;

// ==========================================
// MODULE 2: INITIALIZATION ON LOAD
// Fungsi yang dijalankan saat halaman pertama kali dimuat
// ==========================================
document.addEventListener('DOMContentLoaded', () => {
    // 1. Membaca status Toggles Notifikasi Local Storage
    ['notif_reservasi', 'notif_checkin', 'notif_checkout'].forEach(setting => {
        // SET DEFAULT JADI TRUE JIKA BELUM PERNAH DIATUR
        if (localStorage.getItem(setting) === null) {
            localStorage.setItem(setting, 'true');
        }
        
        const isChecked = localStorage.getItem(setting) === 'true';
        const toggleEl = document.getElementById('toggle_' + setting);
        if (toggleEl) toggleEl.checked = isChecked;
    });

    // 2. Membaca Style Slider (Font Size)
    const savedFontSize = localStorage.getItem('pref_fontsize');
    if (savedFontSize) {
        let slider = document.getElementById('slider_fontsize');
        if (slider) slider.value = savedFontSize;
    }

    // 3. Membaca Status Tema dari Local Storage
    let toggleDark = document.getElementById('toggle_darkmode');
    let toggleContrast = document.getElementById('toggle_contrast');
    if (toggleDark) toggleDark.checked = localStorage.getItem('pref_darkmode') === 'true';
    if (toggleContrast) toggleContrast.checked = localStorage.getItem('pref_contrast') === 'true';

    // 4. Membaca Kalender Maintenance dari Server (via Global Window)
    if (window.savedMaintenanceDates && window.savedMaintenanceDates.length > 0) {
        selectedMaintenanceDates = window.savedMaintenanceDates;
    }
});

// ==========================================
// MODULE 3: PREFERENSI TAMPILAN SISTEM
// Fungsi untuk memanipulasi DOM berdasarkan Accessibility Settings
// ==========================================
function changeFontSize(val) {
    document.documentElement.style.fontSize = val + '%';
    localStorage.setItem('pref_fontsize', val);
}

function toggleDarkMode(isDark) {
    if (isDark) {
        document.documentElement.classList.add('dark-mode-active');
    } else {
        document.documentElement.classList.remove('dark-mode-active');
        document.body.classList.remove('dark-mode-active');
    }
    localStorage.setItem('pref_darkmode', isDark);
}

function toggleHighContrast(isHigh) {
    if (isHigh) {
        document.documentElement.classList.add('high-contrast-active');
    } else {
        document.documentElement.classList.remove('high-contrast-active');
        document.body.classList.remove('high-contrast-active');
    }
    localStorage.setItem('pref_contrast', isHigh);
}

function saveClientSettings(key, value) {
    localStorage.setItem(key, value);
}

// ==========================================
// MODULE 4: FOTO PROFIL DAN PASSWORD
// Fungsi interaktif pada form Profil (Mata intip & Preview Foto)
// ==========================================
function peekPassword(inputId) {
    let input = document.getElementById(inputId);
    if (input.type === "password") {
        input.type = "text";
        setTimeout(() => {
            input.type = "password";
        }, 3000); // Otomatis disembunyikan kembali setelah 3 detik
    } else {
        input.type = "password";
    }
}

function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const output = document.getElementById('avatar_preview');
        const altOutput = document.getElementById('avatar_preview_alt');
        
        if (output) {
            output.src = reader.result;
        } else if (altOutput) {
            // Ubah div bulatan inisial nama menjadi tag Image
            altOutput.outerHTML = `<img id="avatar_preview" src="${reader.result}" class="w-24 h-24 rounded-full object-cover border-4 border-amber-50 group-hover:border-amber-300 transition shadow-sm">`;
        }
    };
    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    }
}

// ==========================================
// MODULE 5: PENGATURAN TAB KONTEN
// Logika untuk berpindah antar tab (Profil, Umum, Jadwal)
// ==========================================
function switchTab(tabName) {
    const btnProfil = document.getElementById('tab-btn-profil');
    const btnUmum = document.getElementById('tab-btn-umum');
    const btnJadwal = document.getElementById('tab-btn-jadwal');

    const secProfil = document.getElementById('section-profil');
    const secUmum = document.getElementById('section-umum');
    const secJadwal = document.getElementById('section-jadwal');

    // Sembunyikan semua section yang ada
    if (secProfil) secProfil.classList.add('hidden');
    if (secUmum) secUmum.classList.add('hidden');
    if (secJadwal) secJadwal.classList.add('hidden');

    // PERUBAHAN: Kelas style untuk Tab yang TIDAK AKTIF (Memipih dengan padding y 1.5)
    const inactiveStyle = "px-4 sm:px-5 py-1.5 bg-amber-50/70 border border-amber-200/70 rounded-xl font-bold text-amber-800/50 hover:text-amber-700 hover:bg-amber-100 text-xs sm:text-sm transition relative z-0 ml-1 mb-[4px] shadow-inner";
    
    if (btnProfil) btnProfil.className = inactiveStyle;
    if (btnUmum) btnUmum.className = inactiveStyle;
    if (btnJadwal) btnJadwal.className = inactiveStyle;

    // PERUBAHAN: Kelas style untuk Tab yang AKTIF (Ada class chrome-tab-active)
    const activeStyle = "chrome-tab-active px-5 sm:px-6 py-3 bg-white border border-amber-200 border-b-white rounded-t-xl font-bold text-amber-700 text-xs sm:text-sm relative z-10 -mb-[1px] shadow-sm shadow-white transition";

    // Tampilkan section yang dipilih
    if (tabName === 'profil' && secProfil) {
        secProfil.classList.remove('hidden');
        btnProfil.className = activeStyle;
        showTooltip('default');
    } else if (tabName === 'umum' && secUmum) {
        secUmum.classList.remove('hidden');
        btnUmum.className = activeStyle;
        showTooltip('umum_intro');
    } else if (tabName === 'jadwal' && secJadwal) {
        secJadwal.classList.remove('hidden');
        btnJadwal.className = activeStyle;
        showTooltip('jadwal_intro');
        
        const toggleJadwal = document.getElementById('toggle_jadwal_maintenance');
        if (toggleJadwal && toggleJadwal.checked) {
            setTimeout(() => initCalendar(), 100);
        }
    }
}

// ==========================================
// MODULE 6: TOOLTIP PANDUAN INTERAKTIF
// Menampilkan box panduan di sebelah kanan layar
// ==========================================
function showTooltip(type) {
    let title = '';
    let content = '';
    let icon = '';

    switch (type) {
        case 'avatar':
            title = 'Aturan Foto Profil'; icon = '📸';
            content = `<ul class="list-disc pl-5 space-y-1.5"><li>Format yang didukung: <span class="font-bold">JPG, JPEG, PNG</span>.</li><li>Batas ukuran maksimal: <span class="font-bold text-red-600">5 MB (5120 KB)</span>.</li><li>Sangat direkomendasikan menggunakan foto rasio 1:1 (persegi).</li></ul>`;
            break;
        case 'nama':
            title = 'Nama Lengkap'; icon = '👤';
            content = 'Sangat disarankan untuk menggunakan nama asli sesuai identitas Anda.'; break;
        case 'username':
            title = 'Username Akses'; icon = '🔑';
            content = '<span class="font-bold text-amber-950">Syarat:</span> Harus Unik, maksimal 20 karakter, dan tidak boleh mengandung spasi.'; break;
        case 'email':
            title = 'Alamat Email'; icon = '📧';
            content = 'Email ini berfungsi untuk sistem pemulihan (*recovery*) jika sewaktu-waktu Anda lupa kata sandi.'; break;
        case 'password':
            title = 'Keamanan Kata Sandi'; icon = '🛡️';
            content = `Demi keamanan, perhatikan saran berikut:<ul class="list-disc pl-5 mt-2 space-y-1.5"><li>Minimal <span class="font-bold">8 Karakter</span>.</li><li>Gunakan kombinasi <strong>Huruf Kapital</strong>, huruf kecil, dan <strong>Angka</strong>.</li><li>Wajib diisi pada kedua kolom untuk mencegah salah ketik.</li></ul>`; break;
        case 'umum_intro':
            title = 'Pengaturan Umum'; icon = '⚙️';
            content = 'Pengaturan di tab ini akan tersimpan otomatis secara lokal (Browser Cache).'; break;
        case 'notif_online':
            title = 'Notifikasi Reservasi'; icon = '🛎️';
            content = 'Memunculkan Pop-Up (*Toast*) setiap kali ada tamu memesan.'; break;
        case 'notif_checkin':
            title = 'Notifikasi Check-In'; icon = '🔑';
            content = 'Pengingat otomatis 30 menit sebelum jadwal tamu.'; break;
        case 'notif_checkout':
            title = 'Notifikasi Check-Out'; icon = '⏰';
            content = 'Peringatan tamu Overstay.'; break;
        case 'pref_font':
            title = 'Ukuran Teks Sistem'; icon = 'Aa';
            content = 'Geser *slider* ke kanan/kiri untuk mengubah ukuran.'; break;
        case 'pref_dark':
            title = 'Mode Gelap (Dark Mode)'; icon = '🌙';
            content = 'Meredupkan layar (Filter Invert) agar tidak silau.'; break;
        case 'pref_contrast':
            title = 'Teks Kontras Tinggi'; icon = '👁️';
            content = 'Memaksa seluruh teks abu-abu menjadi Hitam Pekat.'; break;
        case 'jadwal_intro':
            title = 'Penjadwalan'; icon = '📅';
            content = 'Pusat kontrol untuk mematikan layanan reservasi sementara atau mengatur jadwal perbaikan server (Maintenance).'; break;
        case 'jadwal_master':
            title = 'Maintenance Instan'; icon = '🔴';
            content = 'Matikan layanan Booking/Reservasi secara seketika (*Real-time*).'; break;
        case 'jadwal_instan_online':
            title = 'Matikan Reservasi Online'; icon = '🌐';
            content = 'Tamu di Landing Page tidak akan bisa melakukan klik tombol "Buat Reservasi".'; break;
        case 'jadwal_instan_walkin':
            title = 'Matikan Walk-in'; icon = '🚶';
            content = 'Menonaktifkan tombol modal +Check In Baru di menu Manajemen Reservasi staf resepsionis.'; break;
        case 'jadwal_otomatis':
            title = 'Mode Terjadwal'; icon = '⏱️';
            content = 'Bagus untuk pemeliharaan rutin. Sistem akan otomatis mematikan layanan pada tanggal-tanggal yang Anda tandai di kalender.'; break;
        case 'jadwal_kalender':
            title = 'Seleksi Tanggal'; icon = '🖱️';
            content = 'Klik pada angka tanggal di kalender. Jangan lupa klik <b>Simpan Jadwal</b> setelah memilih.'; break;
        default:
            title = 'Panduan Pengisian'; icon = '💡';
            content = 'Silakan klik kolom atau arahkan kursor Anda ke area pengaturan untuk melihat detail instruksi.'; break;
    }

    const box = document.getElementById('tooltip-box');
    if(box) {
        box.style.opacity = 0;
        setTimeout(() => {
            document.getElementById('tooltip-title').innerText = title;
            document.getElementById('tooltip-content').innerHTML = content;
            document.getElementById('tooltip-icon').innerText = icon;
            box.style.opacity = 1;
        }, 150);
    }
}

// ==========================================
// MODULE 7: MAINTENANCE SERVER & KALENDER (HANYA ADMIN)
// Logika AJAX untuk mengirim jadwal maintenance ke server
// ==========================================
function toggleMaintenanceOptions(isChecked) {
    const div = document.getElementById('instant_maintenance_div');
    if(div) {
        if (isChecked) div.classList.remove('hidden');
        else div.classList.add('hidden');
        updateServerMaintenance();
    }
}

function toggleJadwalOptions(isChecked) {
    const div = document.getElementById('scheduled_maintenance_div');
    if(div) {
        if (isChecked) {
            div.classList.remove('hidden');
            setTimeout(() => {
                initCalendar();
            }, 100);
        } else {
            div.classList.add('hidden');
        }
        updateServerMaintenance();
    }
}

function updateServerMaintenance() {
    // Validasi apakah tombol toggle ada di halaman (Hanya Admin yang punya)
    const toggleMaster = document.getElementById('toggle_maintenance_mode');
    if(!toggleMaster) return; 

    fetch(window.maintenanceRouteUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': window.LaravelCSRFToken
        },
        body: JSON.stringify({
            maintenance_mode: toggleMaster.checked,
            main_online: document.getElementById('toggle_main_online').checked,
            main_walkin: document.getElementById('toggle_main_walkin').checked,
            jadwal_maintenance: document.getElementById('toggle_jadwal_maintenance').checked,
            auto_maintenance: document.getElementById('toggle_auto_maintenance').checked,
            check_jadwal_online: document.getElementById('check_jadwal_online').checked,
            check_jadwal_walkin: document.getElementById('check_jadwal_walkin').checked,
            jadwal_tersimpan: JSON.stringify(selectedMaintenanceDates)
        })
    });
}

function initCalendar() {
    if (calendarInstance) return;
    const calEl = document.getElementById('maintenance_calendar');
    if (!calEl) return;

    calendarInstance = new FullCalendar.Calendar(calEl, {
        initialView: 'dayGridMonth',
        height: 350,
        locale: 'id',
        headerToolbar: {
            left: 'prev',
            center: 'title',
            right: 'next'
        },
        dayCellDidMount: function(info) {
            // Tandai tanggal merah jika tersimpan di memori
            if (selectedMaintenanceDates.includes(info.dateStr)) {
                info.el.style.backgroundColor = '#ef4444'; // Red
            }
        },
        dateClick: function(info) {
            const idx = selectedMaintenanceDates.indexOf(info.dateStr);
            if (idx > -1) {
                // Hapus jika sudah diklik
                selectedMaintenanceDates.splice(idx, 1);
                info.dayEl.style.backgroundColor = '';
            } else {
                // Tambah jika belum diklik
                selectedMaintenanceDates.push(info.dateStr);
                info.dayEl.style.backgroundColor = '#ef4444';
            }
        }
    });
    calendarInstance.render();
}

function resetMaintenanceDates() {
    if (confirm("Yakin ingin membatalkan/mereset seluruh jadwal maintenance?")) {
        selectedMaintenanceDates = [];
        updateServerMaintenance();
        if (calendarInstance) {
            calendarInstance.destroy();
            calendarInstance = null;
            initCalendar();
        }
        alert('Jadwal berhasil dibatalkan.');
    }
}

// ==========================================
// MODULE 8: EXPORT TO GLOBAL WINDOW
// Mengekspos fungsi agar bisa dipanggil dari HTML tag
// ==========================================
window.changeFontSize = changeFontSize;
window.toggleDarkMode = toggleDarkMode;
window.toggleHighContrast = toggleHighContrast;
window.saveClientSettings = saveClientSettings;
window.peekPassword = peekPassword;
window.previewImage = previewImage;
window.switchTab = switchTab;
window.showTooltip = showTooltip;
window.toggleMaintenanceOptions = toggleMaintenanceOptions;
window.toggleJadwalOptions = toggleJadwalOptions;
window.updateServerMaintenance = updateServerMaintenance;
window.resetMaintenanceDates = resetMaintenanceDates;
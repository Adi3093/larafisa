document.addEventListener('DOMContentLoaded', () => {
    // Membuka notifikasi otomatis jika di-redirect dari bel Navbar
    if (window.activeNotifId) {
        let targetBtn = document.querySelector(`.notif-item[data-id="${window.activeNotifId}"]`);
        if (targetBtn) bacaNotif(window.activeNotifId, targetBtn);
    }
});

async function bacaNotif(id, element) {
    const emptyState = document.getElementById('read-empty');
    const loadingState = document.getElementById('read-loading');
    const contentState = document.getElementById('read-content');
    
    // Panel untuk mode mobile
    const panelKiri = document.getElementById('panel-kiri');
    const panelKanan = document.getElementById('panel-kanan');

    // Reset warna aktif di Daftar Panel Kiri
    document.querySelectorAll('.notif-item').forEach(el => {
        el.classList.remove('bg-white', 'border-amber-200', 'shadow-sm');
        el.classList.add('bg-transparent', 'border-transparent');
    });
    element.classList.remove('bg-transparent', 'border-transparent');
    element.classList.add('bg-white', 'border-amber-200', 'shadow-sm');
    
    // Hilangkan titik merah 'unread' secara lokal
    let unreadDot = element.querySelector('.bg-amber-500');
    let titleText = element.querySelector('h4');
    if(unreadDot) unreadDot.remove();
    if(titleText) {
        titleText.classList.remove('text-amber-900');
        titleText.classList.add('text-gray-700');
    }

    // LOGIKA MOBILE: Sembunyikan daftar (kiri), tampilkan isi pesan (kanan)
    if (window.innerWidth < 1024) {
        panelKiri.classList.add('hidden');
        panelKanan.classList.remove('hidden');
        panelKanan.classList.add('flex');
    }

    // Menampilkan state loading
    emptyState.classList.add('hidden');
    contentState.classList.add('hidden');
    loadingState.classList.remove('hidden');

    try {
        let response = await fetch(`/pusat-notifikasi/${id}`);
        let data = await response.json();

        // Inject Data Text
        document.getElementById('c-title').innerText = data.title;
        document.getElementById('c-date').querySelector('span').innerText = data.created_at;
        document.getElementById('c-message').innerText = data.message;

        // Inject Styling Tipe Pesan
        let badge = document.getElementById('c-type');
        if (data.type === 'success') {
            badge.className = "inline-block px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider mb-3 bg-emerald-100 text-emerald-700";
            badge.innerText = "BERHASIL";
        } else if (data.type === 'warning') {
            badge.className = "inline-block px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider mb-3 bg-red-100 text-red-700";
            badge.innerText = "PERINGATAN";
        } else {
            badge.className = "inline-block px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider mb-3 bg-blue-100 text-blue-700";
            badge.innerText = "INFORMASI";
        }

        // Sembunyikan loading, tampilkan konten sesungguhnya
        loadingState.classList.add('hidden');
        contentState.classList.remove('hidden');

    } catch (e) {
        loadingState.classList.add('hidden');
        emptyState.classList.remove('hidden');
        emptyState.querySelector('h3').innerText = "Gagal memuat pesan";
        emptyState.querySelector('p').innerText = "Terjadi gangguan jaringan, silakan coba lagi.";
    }
}

// Fungsi tombol kembali khusus untuk pengguna Smartphone (Mobile)
function kembaliKeDaftar() {
    const panelKiri = document.getElementById('panel-kiri');
    const panelKanan = document.getElementById('panel-kanan');
    
    // Sembunyikan isi pesan (kanan), tampilkan kembali kotak masuk (kiri)
    panelKanan.classList.add('hidden');
    panelKanan.classList.remove('flex');
    panelKiri.classList.remove('hidden');
}

// Export ke window agar bisa dipanggil dari HTML
window.bacaNotif = bacaNotif;
window.kembaliKeDaftar = kembaliKeDaftar;
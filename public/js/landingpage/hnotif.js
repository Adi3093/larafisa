document.addEventListener('DOMContentLoaded', () => {
    if (window.activeNotifId) {
        let targetBtn = document.querySelector(`.notif-item[data-id="${window.activeNotifId}"]`);
        if (targetBtn) bacaNotif(window.activeNotifId, targetBtn);
    }
});

async function bacaNotif(id, element) {
    const emptyState = document.getElementById('read-empty');
    const loadingState = document.getElementById('read-loading');
    const contentState = document.getElementById('read-content');
    const panelKiri = document.getElementById('panel-kiri');
    const panelKanan = document.getElementById('panel-kanan');
    document.querySelectorAll('.notif-item').forEach(el => {
        el.classList.remove('bg-white', 'border-amber-200', 'shadow-sm');
        el.classList.add('bg-transparent', 'border-transparent');
    });
    element.classList.remove('bg-transparent', 'border-transparent');
    element.classList.add('bg-white', 'border-amber-200', 'shadow-sm');
    let unreadDot = element.querySelector('.bg-amber-500');
    let titleText = element.querySelector('h4');
    if(unreadDot) unreadDot.remove();
    if(titleText) {
        titleText.classList.remove('text-amber-900');
        titleText.classList.add('text-gray-700');
    }

    // Sembunyikan panel kiri jika mobile view
    if (window.innerWidth < 1024) {
        panelKiri.classList.add('hidden');
        panelKanan.classList.remove('hidden');
        panelKanan.classList.add('flex');
    }
    emptyState.classList.add('hidden');
    contentState.classList.add('hidden');
    loadingState.classList.remove('hidden');

    try {
        let response = await fetch(`/pusat-notifikasi/${id}`);
        let data = await response.json();
        document.getElementById('c-title').innerText = data.title;
        document.getElementById('c-date').querySelector('span').innerText = data.created_at;
        document.getElementById('c-message').innerText = data.message;
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
        loadingState.classList.add('hidden');
        contentState.classList.remove('hidden');

    } catch (e) {
        loadingState.classList.add('hidden');
        emptyState.classList.remove('hidden');
        emptyState.querySelector('h3').innerText = "Gagal memuat pesan";
        emptyState.querySelector('p').innerText = "Terjadi gangguan jaringan, silakan coba lagi.";
    }
}

function kembaliKeDaftar() {
    const panelKiri = document.getElementById('panel-kiri');
    const panelKanan = document.getElementById('panel-kanan');
    
    // Sembunyikan isi pesan (kanan), tampilkan kembali kotak masuk (kiri)
    panelKanan.classList.add('hidden');
    panelKanan.classList.remove('flex');
    panelKiri.classList.remove('hidden');
}

window.bacaNotif = bacaNotif;
window.kembaliKeDaftar = kembaliKeDaftar;
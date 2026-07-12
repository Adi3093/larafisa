
// MODULE 1: GLOBAL STATE VARIABLES
let currentHarga = 0;

// MODULE 2: INITIALIZATION ON LOAD
document.addEventListener('DOMContentLoaded', () => {
    if(document.getElementById('jumlah_anggota')) {
        filterKelasByAnggota();
    }
    if (document.getElementById('kelas_kamar_id') && document.getElementById('kelas_kamar_id').value !== "") {
        updatePreviewKamar();
    }
});

// MODULE 3: GUEST MANAGEMENT (MAX 4)
function adjustAnggota(val) {
    let input = document.getElementById('jumlah_anggota');
    let current = parseInt(input.value) || 1;
    let target = current + val;
    if (target >= 1 && target <= 4) { 
        input.value = target;
        filterKelasByAnggota();
    }
}

function filterKelasByAnggota() {
    let jumlahTamu = parseInt(document.getElementById('jumlah_anggota').value) || 1;
    let selectKelas = document.getElementById('kelas_kamar_id');
    let targetKapasitasYgDicari = (jumlahTamu >= 3) ? 2 : jumlahTamu;

    Array.from(selectKelas.options).forEach(opt => {
        if (opt.value === "") return;
        let kapasitas = parseInt(opt.getAttribute('data-kapasitas')) || 1;
        if (kapasitas < targetKapasitasYgDicari) {
            opt.style.display = 'none';
            opt.disabled = true;
            if (opt.selected) selectKelas.value = "";
        } else {
            opt.style.display = 'block';
            opt.disabled = false;
        }
    });
    updatePreviewKamar();
}

// MODULE 4: JADWAL & SHORTCUT DURASI
function updateCheckOutShortcut(selectObj) {
    let val = selectObj.value;
    if (val === 'custom') return;
    let checkInInput = document.getElementById('check_in').value;
    let cin = new Date(checkInInput);
    if (!isNaN(cin)) {
        let days = parseInt(val);
        cin.setDate(cin.getDate() + days);
        cin.setMinutes(cin.getMinutes() - cin.getTimezoneOffset());
        document.getElementById('check_out').value = cin.toISOString().slice(0, 16);
        hitungTotal();
        updatePreviewKamar();
    }
}

function resetShortcut() { 
    document.getElementById('shortcut_durasi').value = 'custom'; 
}

// MODULE 5: METODE BAYAR & HITUNG HARGA
function toggleMetode() {
    let metode = document.getElementById('metode_pembayaran').value;
    let box = document.getElementById('qrisBox');
    if (metode === 'QRIS') { box.classList.remove('hidden'); box.classList.add('grid'); } 
    else { box.classList.add('hidden'); box.classList.remove('grid'); }
}

function adjustEkstra(id, val) {
    let input = document.getElementById(id);
    let current = parseInt(input.value) || 0;
    if (current + val >= 0) { input.value = current + val; hitungTotal(); }
}

function hitungTotal() {
    let checkIn = new Date(document.getElementById('check_in').value);
    let checkOut = new Date(document.getElementById('check_out').value);
    let diffDays = 1;
    if (!isNaN(checkIn) && !isNaN(checkOut)) {
        diffDays = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
        if (diffDays <= 0) diffDays = 1;
    }
    let qtyBed = parseInt(document.getElementById('extra_bed').value) || 0;
    let qtySelimut = parseInt(document.getElementById('extra_selimut').value) || 0;
    let totalBiaya = (currentHarga * diffDays) + (qtyBed * 100000) + (qtySelimut * 25000);

    document.getElementById('durasiDisplay').innerText = diffDays + ' Malam Menginap';
    document.getElementById('totalDisplay').innerText = new Intl.NumberFormat('id-ID', {
        style: 'currency', currency: 'IDR', minimumFractionDigits: 0
    }).format(totalBiaya);
}

// MODULE 6: LIVE PREVIEW & API CHECK KOSONG
async function updatePreviewKamar() {
    const select = document.getElementById('kelas_kamar_id');
    const kelasId = select.value;
    const placeholder = document.getElementById('placeholderPreview');
    const content = document.getElementById('contentPreview');
    const btnSubmit = document.getElementById('btnSubmit');

    if (!kelasId) {
        currentHarga = 0;
        placeholder.classList.remove('hidden'); content.classList.add('hidden');
        if (btnSubmit) { btnSubmit.disabled = true; btnSubmit.classList.add('opacity-50', 'cursor-not-allowed'); }
        hitungTotal(); return;
    }

    const option = select.options[select.selectedIndex];
    currentHarga = parseInt(option.getAttribute('data-harga')) || 0;
    document.getElementById('prevNama').innerText = option.text.split(' (')[0];
    const mainImgUrl = option.getAttribute('data-thumb');
    document.getElementById('prevImg').src = mainImgUrl;
    
    const arrayFoto = [...new Set([mainImgUrl, option.getAttribute('data-foto1'), option.getAttribute('data-foto2'), option.getAttribute('data-foto3')].filter(f => f))];
    let galeriHTML = '';
    arrayFoto.forEach(url => { galeriHTML += `<div class="h-14 sm:h-16 rounded-xl overflow-hidden shadow-sm border border-gray-200 hover:border-amber-500 cursor-pointer transition" onclick="document.getElementById('prevImg').src='${url}'"><img src="${url}" class="w-full h-full object-cover"></div>`; });
    document.getElementById('prevThumbnails').innerHTML = galeriHTML;

    let fasText = option.getAttribute('data-fasilitas');
    let fasHtml = '';
    try { let parsed = JSON.parse(fasText); if (Array.isArray(parsed)) { parsed.forEach(f => { fasHtml += `<li class="flex items-center gap-1.5"><span class="text-amber-500">✔</span> ${f}</li>`; }); } } catch (e) {}
    document.getElementById('prevFasilitas').innerHTML = fasHtml;

    let jlhAnggota = parseInt(document.getElementById('jumlah_anggota').value) || 1;
    let boxBed = document.getElementById('boxRekomendasiBed');
    if (jlhAnggota >= 3) { document.getElementById('txtJumlahAnggota').innerText = jlhAnggota; boxBed.classList.remove('hidden'); } 
    else { boxBed.classList.add('hidden'); }

    placeholder.classList.add('hidden'); content.classList.remove('hidden'); hitungTotal();

    const boxKosong = document.getElementById('boxKamarKosong');
    const countText = document.getElementById('sisaKamarCount');
    countText.innerText = "Mengecek ketersediaan...";
    boxKosong.className = "w-full py-3 rounded-xl border border-amber-300 bg-amber-50 text-center shadow-sm";

    try {
        let response = await fetch(`/api/kamar-tersedia?kelas_id=${kelasId}&check_in=${document.getElementById('check_in').value}&check_out=${document.getElementById('check_out').value}`);
        let kamars = await response.json();
        if (kamars.length > 0) {
            countText.innerText = `🔥 Tersisa ${kamars.length} Kamar Kosong!`;
            boxKosong.className = "w-full py-3 rounded-xl border border-emerald-300 bg-emerald-50 text-center shadow-sm text-emerald-700";
            if (btnSubmit) { btnSubmit.disabled = false; btnSubmit.classList.remove('opacity-50', 'cursor-not-allowed'); }
        } else {
            countText.innerText = "❌ Penuh di Tanggal Ini";
            boxKosong.className = "w-full py-3 rounded-xl border border-red-300 bg-red-50 text-center shadow-sm text-red-700 animate-pulse";
            if (btnSubmit) { btnSubmit.disabled = true; btnSubmit.classList.add('opacity-50', 'cursor-not-allowed'); }
        }
    } catch (error) {
        countText.innerText = "Gagal memuat info ketersediaan.";
    }
}

// MODULE 7: EXPORT FUNCTIONS TO GLOBAL WINDOW
// Menghubungkan fungsi internal file JS agar bisa dibaca oleh atribut onclick/onchange HTML di file Blade
window.adjustAnggota = adjustAnggota;
window.updateCheckOutShortcut = updateCheckOutShortcut;
window.resetShortcut = resetShortcut;
window.toggleMetode = toggleMetode;
window.adjustEkstra = adjustEkstra;
window.hitungTotal = hitungTotal;
window.updatePreviewKamar = updatePreviewKamar;
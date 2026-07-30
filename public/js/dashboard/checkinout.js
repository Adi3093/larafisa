// ==========================================
// MODULE 1: GLOBAL STATE & CACHE VARIABLES
// ==========================================
let cacheResId = 0;
let cacheHargaKamar = 0;
let cacheCheckIn = '';
let cacheTotalAwal = 0;
let currentTotalTambahan = 0;
let intervalTambahan = null;

let cacheInvAdd = '';
let cacheQrAdd = '';
let cacheStatusAdd = '';
let cacheTotalAdd = 0;

// ==========================================
// MODULE 2: INJECTION DATA KE DALAM MODAL 
// ==========================================
function bukaModalCheckout(id, no_res, nama, hp, kelas, ruangan, qtyBed, checkIn, checkOut, hargaKamar, totalSudahDibayar, invoiceAwal, pesanTamu, invAdd, qrAdd, statusAdd, totalAdd) {

    cacheResId = id;
    cacheHargaKamar = parseInt(hargaKamar) || 0;
    cacheCheckIn = checkIn;
    cacheTotalAwal = parseInt(totalSudahDibayar) || 0;
    cacheInvAdd = invAdd;
    cacheQrAdd = qrAdd;
    cacheStatusAdd = statusAdd;
    cacheTotalAdd = parseInt(totalAdd) || 0;

    document.getElementById('co_no_res').innerText = '#' + no_res;
    document.getElementById('co_nama').innerText = nama;
    document.getElementById('co_kontak').innerText = 'No. HP: ' + hp;
    document.getElementById('co_kelas_kamar').innerText = ruangan + ' (' + kelas + ')';

    document.getElementById('co_bed_qty').value = qtyBed;

    let dateIn = new Date(checkIn);
    let options = { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' };
    
    document.getElementById('co_tanggal_checkin').value = dateIn.toLocaleDateString('id-ID', options);
    
    let safeCheckOut = checkOut ? String(checkOut) : "";
    document.getElementById('co_tanggal_checkout').value = safeCheckOut.slice(0, 16); 
    
    document.getElementById('co_pesan').value = (pesanTamu && pesanTamu !== '-' && pesanTamu !== '') ? pesanTamu : 'Tidak ada pesan khusus dari tamu.';

    document.getElementById('co_total_awal').innerText = formatRp(cacheTotalAwal);
    document.getElementById('co_invoice_awal').innerText = invoiceAwal;
    document.getElementById('formCheckoutModal').action = `/checkinout/${id}/checkout`;

    if (intervalTambahan) clearInterval(intervalTambahan);

    document.getElementById('box_aksi_tambahan').classList.add('hidden');
    document.getElementById('box_tidak_ada_tambahan').classList.remove('hidden');
    document.getElementById('box_tidak_ada_tambahan').classList.add('flex');
    document.getElementById('co_status_tambahan').innerText = 'LUNAS';
    document.getElementById('co_status_tambahan').className = 'text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded bg-emerald-100 text-emerald-600 border border-emerald-200';
    document.getElementById('co_rincian_tambahan').innerHTML = '';
    document.getElementById('co_total_tambahan').innerText = 'Rp 0';

    hitungTotalCheckoutLive();
    document.getElementById('modalCheckout').classList.remove('hidden');
}


// ==========================================
// MODULE 3: KALKULATOR HARGA TAMBAHAN
// ==========================================
function adjustQtyCheckout(inputId, change) {
    let field = document.getElementById(inputId);
    if (!field) return;
    let val = parseInt(field.value) || 0;
    if (val + change >= 0) {
        field.value = val + change;
        hitungTotalCheckoutLive(); 
    }
}

function formatRp(angka) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency', currency: 'IDR', minimumFractionDigits: 0
    }).format(angka);
}

function hitungTotalCheckoutLive() {
    let cin = new Date(cacheCheckIn);
    let cout = new Date(document.getElementById('co_tanggal_checkout').value);
    let diffDays = 1;

    if (!isNaN(cin) && !isNaN(cout)) {
        cin.setHours(0,0,0,0);
        cout.setHours(0,0,0,0);
        diffDays = Math.ceil((cout - cin) / (1000 * 60 * 60 * 24));
        if (diffDays <= 0) diffDays = 1;
    }

    let qtyBed = parseInt(document.getElementById('co_bed_qty').value) || 0;
    let totalBaru = (cacheHargaKamar * diffDays) + (qtyBed * 50000);
    
    currentTotalTambahan = totalBaru - cacheTotalAwal;

    let listHTML = `<p class="flex justify-between border-b border-gray-200 pb-1 mb-1 border-dashed text-gray-700"><span>Waktu Inap Final (${diffDays} Malam)</span> <span class="font-bold">Rp ${(cacheHargaKamar * diffDays).toLocaleString('id-ID')}</span></p>`;
    
    if (qtyBed > 0) {
        listHTML += `<p class="flex justify-between border-b border-gray-200 pb-1 text-gray-700"><span>Extra Bed x${qtyBed}</span> <span class="font-bold">Rp ${(qtyBed * 50000).toLocaleString('id-ID')}</span></p>`;
    }
    document.getElementById('co_rincian_tambahan').innerHTML = listHTML;

    let boxAksi = document.getElementById('box_aksi_tambahan');
    let boxKosong = document.getElementById('box_tidak_ada_tambahan');
    let statusTambahan = document.getElementById('co_status_tambahan');

    if (currentTotalTambahan > 0) {
        document.getElementById('co_total_tambahan').innerText = formatRp(currentTotalTambahan);
        boxAksi.classList.remove('hidden'); boxAksi.classList.add('flex');
        boxKosong.classList.add('hidden'); boxKosong.classList.remove('flex');

        if (cacheInvAdd !== '' && cacheTotalAdd === currentTotalTambahan) {
            let selectMetode = document.getElementById('co_metode_tambahan');
            selectMetode.value = 'QRIS';
            selectMetode.disabled = true; 
            toggleQrisTambahan();

            document.getElementById('btnGenTambahan').classList.add('hidden');
            document.getElementById('txt_invoice_tambahan').innerText = "No. Pembayaran: " + cacheInvAdd;

            if (cacheStatusAdd === 'berhasil') {
                document.getElementById('qris_container_tambahan').innerHTML = `<div class="text-center w-full animate-fade-in"><div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-2 shadow-sm border-4 border-white ring-2 ring-green-100"><svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24"><path fill="currentColor" d="M10.5 15.25A.74.74 0 0 1 10 15l-3-3a.75.75 0 0 1 1-1l2.47 2.47L19 5a.75.75 0 0 1 1 1l-9 9a.74.74 0 0 1-.5.25Z"/><path fill="currentColor" d="M12 21a9 9 0 0 1-7.87-4.66a8.67 8.67 0 0 1-1.07-3.41a9 9 0 0 1 4.6-8.81a8.67 8.67 0 0 1 3.41-1.07a8.86 8.86 0 0 1 3.55.34a.75.75 0 1 1-.43 1.43a7.62 7.62 0 0 0-3-.28a7.43 7.43 0 0 0-2.84.89a7.5 7.5 0 0 0-2.2 1.84a7.42 7.42 0 0 0-1.64 5.51a7.43 7.43 0 0 0 .89 2.84a7.5 7.5 0 0 0 1.84 2.2a7.42 7.42 0 0 0 5.51 1.64a7.43 7.43 0 0 0 2.84-.89a7.5 7.5 0 0 0 2.2-1.84a7.42 7.42 0 0 0 1.64-5.51a.75.75 0 1 1 1.57-.15a9 9 0 0 1-4.61 8.81A8.67 8.67 0 0 1 12.93 21H12Z"/></svg></div><h4 class="font-black text-green-700 text-base">Lunas!</h4></div>`;
                statusTambahan.innerText = "Lunas via QRIS";
                statusTambahan.className = "text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded bg-green-100 text-green-700 border border-green-200";
            } else {
                let qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=${encodeURIComponent(cacheQrAdd)}`;
                document.getElementById('qris_container_tambahan').innerHTML = `<div class="animate-fade-in w-full flex justify-center"><img src="${qrUrl}" alt="QR Tambahan" class="w-40 h-40 block mx-auto object-contain mix-blend-multiply"></div>`;
                statusTambahan.innerText = "Belum Dibayar";
                statusTambahan.className = "text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded bg-orange-100 text-[#E97609] border border-orange-200";
                
                cekStatusTambahan(cacheInvAdd);
            }
        } else {
            document.getElementById('co_metode_tambahan').disabled = false;
            document.getElementById('btnGenTambahan').classList.remove('hidden');
            document.getElementById('qris_container_tambahan').innerHTML = '<span class="text-xl text-gray-300 font-black tracking-widest uppercase">QRIS CODE</span>';
            document.getElementById('txt_invoice_tambahan').innerText = '';

            statusTambahan.innerText = "Belum Dibayar";
            statusTambahan.className = "text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded bg-orange-100 text-[#E97609] border border-orange-200";
        }

    } else {
        currentTotalTambahan = 0;
        document.getElementById('co_total_tambahan').innerText = "Rp 0";
        boxAksi.classList.add('hidden'); boxAksi.classList.remove('flex');
        boxKosong.classList.remove('hidden'); boxKosong.classList.add('flex');
        statusTambahan.innerText = "Lunas";
        statusTambahan.className = "text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded bg-green-100 text-green-700 border border-green-200";
    }
}


// ==========================================
// MODULE 4: GENERATOR & CHECKER QRIS TAMBAHAN
// ==========================================
function toggleQrisTambahan() {
    let metode = document.getElementById('co_metode_tambahan').value;
    if (metode === 'QRIS') {
        document.getElementById('area_qris_tambahan').classList.remove('hidden');
        document.getElementById('area_qris_tambahan').classList.add('flex');
        document.getElementById('area_tunai_tambahan').classList.add('hidden');
        document.getElementById('area_tunai_tambahan').classList.remove('flex');
    } else {
        document.getElementById('area_qris_tambahan').classList.add('hidden');
        document.getElementById('area_qris_tambahan').classList.remove('flex');
        document.getElementById('area_tunai_tambahan').classList.remove('hidden');
        document.getElementById('area_tunai_tambahan').classList.add('flex');
    }
}

async function generateQrisTambahan() {
    if (currentTotalTambahan <= 0) return;

    let btn = document.getElementById('btnGenTambahan');
    let container = document.getElementById('qris_container_tambahan');
    let txtInv = document.getElementById('txt_invoice_tambahan');

    btn.innerText = "Memproses...";
    btn.disabled = true;

    try {
        let fd = new FormData();
        fd.append('_token', window.LaravelCSRFToken);
        fd.append('total_tambahan', currentTotalTambahan);

        let response = await fetch(`/checkinout/${cacheResId}/generate-qris-tambahan`, {
            method: 'POST',
            body: fd
        });

        let data = await response.json();

        if (data.success) {
            btn.classList.add('hidden');
            let qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=${encodeURIComponent(data.qr_image)}`;

            container.innerHTML = `
                <div class="animate-fade-in w-full flex justify-center">
                    <img src="${qrUrl}" alt="QR Tambahan" class="w-48 h-48 block mx-auto object-contain mix-blend-multiply border border-gray-200 shadow-sm rounded-lg p-1 bg-white">
                </div>
            `;
            txtInv.innerText = "No. Pembayaran: " + data.invoice;
            cekStatusTambahan(data.invoice);
        } else {
            alert(data.message);
            btn.innerText = "Generate QRIS Tambahan";
            btn.disabled = false;
        }
    } catch (e) {
        alert('Gagal menghubungi server.');
        btn.innerText = "Generate QRIS Tambahan";
        btn.disabled = false;
    }
}

function cekStatusTambahan(invoice) {
    if (intervalTambahan) clearInterval(intervalTambahan);

    intervalTambahan = setInterval(async () => {
        try {
            let res = await fetch(`/payment/check/${invoice}`);
            let data = await res.json();

            if (data.status === "berhasil") {
                clearInterval(intervalTambahan);
                document.getElementById('qris_container_tambahan').innerHTML = `
                    <div class="text-center animate-fade-in">
                        <span class="text-5xl block mb-2">✅</span>
                        <p class="text-base font-black text-emerald-700">Lunas!</p>
                    </div>
                `;
                let badge = document.getElementById('co_status_tambahan');
                badge.innerText = "Lunas via QRIS";
                badge.className = "text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded bg-emerald-100 text-emerald-700 border border-emerald-200";
            } else if (data.status === "gagal") {
                clearInterval(intervalTambahan);
                document.getElementById('qris_container_tambahan').innerHTML = `
                    <div class="text-center animate-fade-in">
                        <span class="text-5xl block mb-2">❌</span>
                        <p class="text-base font-black text-red-600">Dibatalkan</p>
                    </div>
                `;
            }
        } catch (e) {}
    }, 5000);
}

// ==========================================
// MODULE 5: LOGIKA MODAL KONFIRMASI LOKAL
// ==========================================
let formToSubmitLocal = null;
let actionValLocal = null;

function showMyConfirm(title, message, theme, btnText, formId, actionVal = null) {
    formToSubmitLocal = formId ? document.getElementById(formId) : null;
    actionValLocal = actionVal;

    if (formToSubmitLocal && typeof formToSubmitLocal.checkValidity === 'function') {
        if (!formToSubmitLocal.checkValidity()) {
            formToSubmitLocal.reportValidity();
            return;
        }
    }

    document.getElementById('localConfirmTitle').innerText = title;
    document.getElementById('localConfirmMessage').innerText = message;

    let btn = document.getElementById('localConfirmBtn');
    btn.innerText = btnText;
    btn.disabled = false;

    let iconContainer = document.getElementById('localIconContainer');
    let iconSvg = document.getElementById('localIconSvg');

    if (theme === 'emerald') {
        btn.className = 'text-white font-bold rounded-xl text-sm px-5 py-2.5 transition bg-emerald-600 hover:bg-emerald-700 cursor-pointer';
        iconContainer.className = 'w-16 h-16 rounded-full flex items-center justify-center border-4 border-white shadow-sm ring-2 bg-emerald-50 ring-emerald-100 mx-auto mb-4';
        iconSvg.className = 'w-10 h-10 text-emerald-500';
        iconSvg.innerHTML = '<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>';
    } else {
        btn.className = 'text-white font-bold rounded-xl text-sm px-5 py-2.5 transition bg-[#E97609] hover:bg-[#c96307] cursor-pointer';
        iconContainer.className = 'w-16 h-16 rounded-full flex items-center justify-center border-4 border-white shadow-sm ring-2 bg-orange-50 ring-orange-100 mx-auto mb-4';
        iconSvg.className = 'w-10 h-10 text-[#E97609]';
        iconSvg.innerHTML = '<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>';
    }

    let modal = document.getElementById('localConfirmModal');
    let content = document.getElementById('localConfirmContent');

    modal.classList.remove('hidden');
    modal.classList.remove('pointer-events-none');
    modal.classList.add('flex');
    setTimeout(() => {
        modal.classList.remove('opacity-0');
        modal.classList.add('opacity-100');
        content.classList.remove('scale-95');
        content.classList.add('scale-100');
    }, 10);
}

function closeLocalConfirm() {
    let modal = document.getElementById('localConfirmModal');
    let content = document.getElementById('localConfirmContent');

    modal.classList.remove('opacity-100');
    modal.classList.add('opacity-0');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modal.classList.add('pointer-events-none');
    }, 300);
}

document.addEventListener('DOMContentLoaded', () => {
    let confirmBtn = document.getElementById('localConfirmBtn');
    if (confirmBtn) {
        confirmBtn.addEventListener('click', function() {
            if (!formToSubmitLocal) { closeLocalConfirm(); return; }

            this.innerText = 'Memproses...';
            this.disabled = true;

            let iconContainer = document.getElementById('localIconContainer');
            iconContainer.className = 'w-16 h-16 rounded-full flex items-center justify-center border-4 border-white shadow-sm ring-2 bg-green-100 ring-green-100 mx-auto mb-4 animate-pulse';
            document.getElementById('localIconSvg').innerHTML = '<path fill="currentColor" class="text-green-600" d="M10.5 15.25A.74.74 0 0 1 10 15l-3-3a.75.75 0 0 1 1-1l2.47 2.47L19 5a.75.75 0 0 1 1-1l-9 9a.74.74 0 0 1-.5.25Z" /><path fill="currentColor" class="text-green-600" d="M12 21a9 9 0 0 1-7.87-4.66a8.67 8.67 0 0 1-1.07-3.41a9 9 0 0 1 4.6-8.81a8.67 8.67 0 0 1 3.41-1.07a8.86 8.86 0 0 1 3.55.34a.75.75 0 1 1-.43 1.43a7.62 7.62 0 0 0-3-.28a7.43 7.43 0 0 0-2.84.89a7.5 7.5 0 0 0-2.2 1.84a7.42 7.42 0 0 0-1.64 5.51a7.43 7.43 0 0 0 .89 2.84a7.5 7.5 0 0 0 1.84 2.2a7.42 7.42 0 0 0 5.51 1.64a7.43 7.43 0 0 0 2.84-.89a7.5 7.5 0 0 0 2.2-1.84a7.42 7.42 0 0 0 1.64-5.51a.75.75 0 1 1 1.57-.15a9 9 0 0 1-4.61 8.81A8.67 8.67 0 0 1 12.93 21H12Z" />';

            setTimeout(() => {
                if (actionValLocal) {
                    let hiddenInput = document.getElementById('co_action_type');
                    if (hiddenInput) { hiddenInput.value = actionValLocal; }
                }
                formToSubmitLocal.submit();
            }, 600); 
        });
    }
});

// ==========================================
// MODULE 6: EXPORT KE GLOBAL WINDOW
// ==========================================
window.bukaModalCheckout = bukaModalCheckout;
window.adjustQtyCheckout = adjustQtyCheckout;
window.toggleQrisTambahan = toggleQrisTambahan;
window.hitungTotalCheckoutLive = hitungTotalCheckoutLive;
window.generateQrisTambahan = generateQrisTambahan;
window.showMyConfirm = showMyConfirm;
window.closeLocalConfirm = closeLocalConfirm;
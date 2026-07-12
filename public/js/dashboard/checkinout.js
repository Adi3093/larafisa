// ==========================================
// MODULE 1: GLOBAL STATE & CACHE VARIABLES
// ==========================================
let cacheResId = 0;
let cacheHargaKamar = 0;
let cacheCheckIn = '';
let cacheTotalAwal = 0;
let currentTotalTambahan = 0;
let intervalTambahan = null;

// Cache khusus untuk pembayaran tambahan (ADD-)
let cacheInvAdd = '';
let cacheQrAdd = '';
let cacheStatusAdd = '';
let cacheTotalAdd = 0;


// ==========================================
// MODULE 2: INJECTION DATA KE DALAM MODAL 
// ==========================================
function bukaModalCheckout(id, no_res, nama, hp, kelas, ruangan, qtyBed, qtySelimut, metode, detail, checkIn, checkOut, hargaKamar, totalSudahDibayar, invoiceAwal, pesanTamu, invAdd, qrAdd, statusAdd, totalAdd) {

    // 1. Simpan variabel penting ke memory
    cacheResId = id;
    cacheHargaKamar = parseInt(hargaKamar);
    cacheCheckIn = checkIn;
    cacheTotalAwal = parseInt(totalSudahDibayar);
    cacheInvAdd = invAdd;
    cacheQrAdd = qrAdd;
    cacheStatusAdd = statusAdd;
    cacheTotalAdd = parseInt(totalAdd);

    // 2. Isi Teks Panel Kiri
    document.getElementById('co_no_res').innerText = '#' + no_res;
    document.getElementById('co_nama').innerText = nama;
    document.getElementById('co_kontak').innerText = 'No. HP: ' + hp;
    document.getElementById('co_kelas_kamar').innerText = ruangan + ' (' + kelas + ')';

    document.getElementById('co_bed_qty').value = qtyBed;
    document.getElementById('co_selimut_qty').value = qtySelimut;

    document.getElementById('co_tanggal_checkin').value = new Date(checkIn).toLocaleString('id-ID', {
        day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'
    });
    document.getElementById('co_tanggal_checkout').value = checkOut;
    document.getElementById('co_pesan').value = pesanTamu;

    document.getElementById('co_total_awal').innerText = formatRp(cacheTotalAwal);
    document.getElementById('co_invoice_awal').innerText = invoiceAwal;

    document.getElementById('formCheckoutModal').action = `/checkinout/${id}/checkout`;

    // Reset Interval Engine QRIS Tambahan
    if (intervalTambahan) clearInterval(intervalTambahan);

    // 3. Panggil Kalkulator & Tampilkan Modal
    hitungTotalCheckoutLive();
    document.getElementById('modalCheckout').classList.remove('hidden');
}


// ==========================================
// MODULE 3: KALKULATOR HARGA TAMBAHAN
// ==========================================
function adjustQtyCheckout(inputId, change) {
    let field = document.getElementById(inputId);
    let val = parseInt(field.value) || 0;
    if (val + change >= 0) {
        field.value = val + change;
        hitungTotalCheckoutLive(); // Evaluasi ulang jika ada perubahan
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

    // Menghitung Durasi Menginap Terbaru
    if (!isNaN(cin) && !isNaN(cout)) {
        diffDays = Math.ceil((cout - cin) / (1000 * 60 * 60 * 24));
        if (diffDays <= 0) diffDays = 1;
    }

    let qtyBed = parseInt(document.getElementById('co_bed_qty').value) || 0;
    let qtySelimut = parseInt(document.getElementById('co_selimut_qty').value) || 0;

    let totalBaru = (cacheHargaKamar * diffDays) + (qtyBed * 100000) + (qtySelimut * 25000);
    
    // Perbedaan Harga (Biaya Tambahan)
    currentTotalTambahan = totalBaru - cacheTotalAwal;

    // Membangun Teks Rincian Baru
    let listHTML = `<p>Waktu Inap Final: ${diffDays} Malam</p>`;
    if (qtyBed > 0) listHTML += `<p>Extra Bed: ${qtyBed}x</p>`;
    if (qtySelimut > 0) listHTML += `<p>Extra Selimut: ${qtySelimut}x</p>`;
    document.getElementById('co_rincian_tambahan').innerHTML = listHTML;

    // Elemen Panel Kanan (Aksi Tambahan)
    let boxAksi = document.getElementById('box_aksi_tambahan');
    let boxKosong = document.getElementById('box_tidak_ada_tambahan');
    let statusTambahan = document.getElementById('co_status_tambahan');

    if (currentTotalTambahan > 0) {
        // JIKA ADA BIAYA TAMBAHAN
        document.getElementById('co_total_tambahan').innerText = formatRp(currentTotalTambahan);
        boxAksi.classList.remove('hidden'); boxAksi.classList.add('flex');
        boxKosong.classList.add('hidden'); boxKosong.classList.remove('flex');

        // LOGIKA CERDAS: JIKA SUDAH PERNAH DI GENERATE QRIS DAN NOMINALNYA SAMA (MENCEGAH SPAM GENERATE)
        if (cacheInvAdd !== '' && cacheTotalAdd === currentTotalTambahan) {
            let selectMetode = document.getElementById('co_metode_tambahan');
            selectMetode.value = 'QRIS';
            selectMetode.disabled = true; // Kunci dari kasir
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
                statusTambahan.className = "text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded bg-orange-100 text-orange-700 border border-orange-200";
                
                cekStatusTambahan(cacheInvAdd);
            }
        } else {
            // BELUM ADA QRIS, ATAU NOMINAL TAMBAHANNYA BERUBAH (Misal nambah extra bed lagi saat di meja kasir)
            document.getElementById('co_metode_tambahan').disabled = false;
            document.getElementById('btnGenTambahan').classList.remove('hidden');
            document.getElementById('qris_container_tambahan').innerHTML = '<span class="text-xl text-gray-300 font-black tracking-widest uppercase">QRIS CODE</span>';
            document.getElementById('txt_invoice_tambahan').innerText = '';

            statusTambahan.innerText = "Belum Dibayar";
            statusTambahan.className = "text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded bg-orange-100 text-orange-700 border border-orange-200";
        }

    } else {
        // JIKA TIDAK ADA BIAYA TAMBAHAN (AMAN)
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
        let response = await fetch(`/checkinout/${cacheResId}/generate-qris-tambahan`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                // Mengambil CSRF dari Global Window yang dikirimkan file Blade
                'X-CSRF-TOKEN': window.LaravelCSRFToken 
            },
            body: JSON.stringify({ total_tambahan: currentTotalTambahan })
        });

        let data = await response.json();

        if (data.success) {
            btn.classList.add('hidden');
            let qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=${encodeURIComponent(data.qr_image)}`;

            container.innerHTML = `
                <div class="animate-fade-in w-full flex justify-center">
                    <img src="${qrUrl}" alt="QR Tambahan" class="w-48 h-48 block mx-auto object-contain mix-blend-multiply">
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
                        <span class="text-4xl">✅</span>
                        <p class="text-sm font-bold text-green-700 mt-2">Lunas!</p>
                    </div>
                `;
                let badge = document.getElementById('co_status_tambahan');
                badge.innerText = "Lunas via QRIS";
                badge.className = "text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded bg-green-100 text-green-700 border border-green-200";
            }
        } catch (e) {}
    }, 5000);
}


// ==========================================
// MODULE 5: EXPORT KE GLOBAL WINDOW
// ==========================================
// Mengaitkan fungsi ke file HTML Blade
window.bukaModalCheckout = bukaModalCheckout;
window.adjustQtyCheckout = adjustQtyCheckout;
window.toggleQrisTambahan = toggleQrisTambahan;
window.hitungTotalCheckoutLive = hitungTotalCheckoutLive;
window.generateQrisTambahan = generateQrisTambahan;
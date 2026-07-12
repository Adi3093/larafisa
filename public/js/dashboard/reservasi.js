// ==========================================
// MODULE 1: FUNGSI MANAJEMEN MODAL KONFIRMASI ONLINE
// ==========================================

function submitTolakReservasi() {
    if (confirm('Tolak dan batalkan reservasi tamu ini?')) {
        document.getElementById('formTolakModal').submit();
    }
}

function bukaModalKonfirmasi(id, no_res, nama, no_hp, kelas, ruangan, metode, pesanTamu, checkIn, checkOut, ekstraArr, noInvoice, statusBayar, qrImage, totalBayar) {
    // 1. Tulis Data Pribadi Pemesan
    document.getElementById('m_no_res').innerText = '#' + no_res;
    document.getElementById('m_nama').innerText = nama;
    document.getElementById('m_nohp').innerText = 'No. HP : ' + no_hp;
    document.getElementById('m_kelas').innerText = kelas;
    document.getElementById('m_ruangan').innerText = ruangan;

    // 2. Formatting Tanggal dan Durasi
    let cin = new Date(checkIn);
    let cout = new Date(checkOut);
    let options = { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' };
    
    document.getElementById('m_cin').innerText = cin.toLocaleDateString('id-ID', options);
    document.getElementById('m_cout').innerText = cout.toLocaleDateString('id-ID', options);

    let diffDays = Math.ceil((cout - cin) / (1000 * 60 * 60 * 24));
    document.getElementById('m_durasi').innerText = `Durasi : ${diffDays > 0 ? diffDays : 1} malam`;

    // 3. Rincian Ekstra & Catatan
    let exBed = ekstraArr['Extra Bed'] ?? 0;
    let exSelimut = ekstraArr['Extra Selimut'] ?? 0;
    document.getElementById('m_extra').innerHTML = `
        <li>Extra Bed x${exBed}</li>
        <li>Extra Selimut x${exSelimut}</li>
    `;
    document.getElementById('m_pesan').innerText = (pesanTamu && pesanTamu !== '-' && pesanTamu !== '') ? pesanTamu : 'Tidak ada pesan khusus dari tamu.';

    // 4. Pembayaran (Invoice & Status)
    document.getElementById('m_invoice').innerText = noInvoice !== '-' ? noInvoice : 'Belum Tersedia';
    let badgeEl = document.getElementById('m_status_badge');
    
    if (statusBayar === 'berhasil') {
        badgeEl.className = "inline-block px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wider bg-green-100 text-green-700 border border-green-200";
        badgeEl.innerText = "Berhasil Lunas";
    } else if (statusBayar === 'pending') {
        badgeEl.className = "inline-block px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wider bg-orange-100 text-orange-700 border border-orange-200";
        badgeEl.innerText = "Pending / Menunggu";
    } else {
        badgeEl.className = "inline-block px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wider bg-gray-100 text-gray-700 border border-gray-200";
        badgeEl.innerText = "Bayar di Tempat";
    }

    // 5. Susunan Rincian Bayar
    document.getElementById('m_rincian_list').innerHTML = `
        <li class="flex justify-between border-b border-dashed border-gray-200 pb-1 mb-1">
            <span>${kelas} (${ruangan})</span>
        </li>
        ${exBed > 0 ? `<li class="flex justify-between border-b border-dashed border-gray-200 pb-1 mb-1"><span>Extra Bed x${exBed}</span></li>` : ''}
        ${exSelimut > 0 ? `<li class="flex justify-between border-b border-dashed border-gray-200 pb-1 mb-1"><span>Extra Selimut x${exSelimut}</span></li>` : ''}
    `;

    let formattedTotal = new Intl.NumberFormat('id-ID', {
        style: 'currency', currency: 'IDR', minimumFractionDigits: 0
    }).format(totalBayar);
    document.getElementById('m_total_bayar').innerText = `Total : ${formattedTotal}`;

    // 6. Tampilan QRIS Scanner
    let qrisBox = document.getElementById('m_qris_box');
    if (statusBayar === 'berhasil') {
        qrisBox.innerHTML = `
            <div class="text-center">
                <svg class="w-16 h-16 text-green-500 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="font-bold text-green-700 text-sm">Pembayaran QRIS Dikonfirmasi Sistem</p>
            </div>`;
    } else if (metode === 'QRIS' && qrImage) {
        let qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(qrImage)}`;
        qrisBox.innerHTML = `
            <div class="text-center">
                <img src="${qrUrl}" alt="QRIS Tamu" class="w-32 h-32 mx-auto mix-blend-multiply">
                <p class="text-xs text-gray-500 font-bold mt-2 uppercase tracking-wider">Menunggu Scan Tamu</p>
            </div>`;
    } else {
        qrisBox.innerHTML = `<span class="text-gray-400 font-medium italic text-sm">Metode: ${metode}</span>`;
    }

    // 7. Pengkondisian Auto-Select Pembayaran
    let detailInput = document.getElementById('m_detail_input');
    let detailDisplay = document.getElementById('m_detail_display');
    if (metode === 'QRIS') {
        detailInput.value = 'Q-RIS';
        detailDisplay.innerHTML = '🟣 Q-RIS (Dikonfirmasi Otomatis)';
    } else if (metode === 'Transfer') {
        detailInput.value = 'Transfer Bank';
        detailDisplay.innerHTML = '🏦 Transfer Bank Manual';
    } else {
        detailInput.value = 'Cash/Tunai';
        detailDisplay.innerHTML = '💵 Bayar di Tempat (Cash/Tunai)';
    }

    document.getElementById('formTerimaModal').action = `/reservasi/${id}/konfirmasi`;
    document.getElementById('modalKonfirmasi').classList.remove('hidden');
}


// ==========================================
// MODULE 2: FUNGSI MANAJEMEN MODAL WALK-IN
// ==========================================
function openWalkInModal() {
    document.getElementById('walkInModal').classList.remove('hidden');
    try {
        filterKamarDanHitung();
    } catch (e) {
        console.error("Gagal melakukan filter default:", e);
    }
}

function closeWalkInModal() {
    document.getElementById('walkInModal').classList.add('hidden');
    document.getElementById('walkInForm').reset();
    document.getElementById('extra_bed_qty').value = 0;
    document.getElementById('extra_selimut_qty').value = 0;
    document.getElementById('total_biaya_display').innerText = 'Rp 0';
    document.getElementById('rincian_hari').innerText = '1 Malam';
    document.getElementById('kamar_id').innerHTML = '<option value="">-- Pilih Kamar --</option>';
    document.getElementById('walkin_placeholder').classList.remove('hidden');
    document.getElementById('walkin_content').classList.add('hidden');
}

function adjustQty(inputId, change) {
    let inputField = document.getElementById(inputId);
    let currentVal = parseInt(inputField.value) || 0;
    let newVal = currentVal + change;
    if (newVal >= 0) {
        inputField.value = newVal;
        filterKamarDanHitung();
    }
}


// ==========================================
// MODULE 3: ENGINE KALKULATOR HARGA & FETCH KAMAR
// ==========================================
async function filterKamarDanHitung() {
    try {
        let kelasId = document.getElementById('kelas_kamar_id').value;
        let checkInInput = document.getElementById('check_in').value;
        let checkOutInput = document.getElementById('check_out').value;
        let kamarSelect = document.getElementById('kamar_id');

        const placeholder = document.getElementById('walkin_placeholder');
        const content = document.getElementById('walkin_content');

        // 1. Tampilkan Visual Kelas Kamar Terpilih
        if (kelasId) {
            placeholder.classList.add('hidden');
            content.classList.remove('hidden');

            let dataKelas = window.kelasDataWalkin.find(k => k.id == kelasId);
            if (dataKelas) {
                document.getElementById('wi_nama_kelas').innerText = dataKelas.nama_kelas;
                document.getElementById('wi_harga').innerText = new Intl.NumberFormat('id-ID', {
                    style: 'currency', currency: 'IDR', minimumFractionDigits: 0
                }).format(dataKelas.harga) + ' / Malam';

                let mainImgUrl = dataKelas.thumbnail ? '/storage/' + dataKelas.thumbnail : '';
                document.getElementById('wi_img_main').src = mainImgUrl;

                let thumbsHtml = '';
                let images = [dataKelas.thumbnail, dataKelas.foto_1, dataKelas.foto_2, dataKelas.foto_3].filter(Boolean);
                let uniqueImages = [...new Set(images)]; // Buang duplikasi jika ada

                uniqueImages.forEach(img => {
                    let fullUrl = '/storage/' + img;
                    thumbsHtml += `<div class="h-16 rounded-xl overflow-hidden shadow-sm border-2 border-transparent hover:border-amber-400 cursor-pointer transition" onclick="document.getElementById('wi_img_main').src='${fullUrl}'"><img src="${fullUrl}" class="w-full h-full object-cover"></div>`;
                });
                document.getElementById('wi_thumbnails').innerHTML = thumbsHtml;

                let fasArr = dataKelas.fasilitas;
                if (typeof fasArr === 'string') {
                    try { fasArr = JSON.parse(fasArr); } catch (e) { fasArr = []; }
                }

                let fasHtml = '';
                if (Array.isArray(fasArr)) {
                    fasArr.forEach(f => {
                        fasHtml += `<li class="flex items-center gap-1.5 text-xs font-semibold text-amber-950"><svg class="w-3.5 h-3.5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>${f}</li>`;
                    });
                }
                document.getElementById('wi_fasilitas').innerHTML = fasHtml;
            }
        } else {
            placeholder.classList.remove('hidden');
            content.classList.add('hidden');
        }

        // 2. Hitung Durasi Malam
        let diffDays = 1;
        if (checkInInput && checkOutInput) {
            let checkIn = new Date(checkInInput);
            let checkOut = new Date(checkOutInput);
            let diffTime = checkOut - checkIn;
            diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            if (diffDays <= 0 || isNaN(diffDays)) diffDays = 1;
        }
        document.getElementById('rincian_hari').innerText = diffDays + ' Malam';

        // 3. Kalkulasi Grand Total
        let selectKelas = document.getElementById('kelas_kamar_id');
        let hargaPerMalam = 0;
        if (selectKelas && selectKelas.selectedIndex > 0) {
            hargaPerMalam = parseInt(selectKelas.options[selectKelas.selectedIndex].getAttribute('data-harga')) || 0;
        }
        let totalBiayaKamar = hargaPerMalam * diffDays;
        let qtyBed = parseInt(document.getElementById('extra_bed_qty').value) || 0;
        let qtySelimut = parseInt(document.getElementById('extra_selimut_qty').value) || 0;
        let totalAddOn = (qtyBed * 100000) + (qtySelimut * 25000);

        document.getElementById('total_biaya_display').innerText = new Intl.NumberFormat('id-ID', {
            style: 'currency', currency: 'IDR', minimumFractionDigits: 0
        }).format(totalBiayaKamar + totalAddOn);

        // 4. Fetching Data Kamar Yang Tersedia di Database
        let selectedKamarValueBefore = kamarSelect.value;
        kamarSelect.innerHTML = '<option value="">-- Sedang memuat kamar... --</option>';

        if (kelasId && checkInInput && checkOutInput) {
            let response = await fetch(`/api/kamar-tersedia?kelas_id=${kelasId}&check_in=${checkInInput}&check_out=${checkOutInput}`);
            let kamars = await response.json();

            kamarSelect.innerHTML = '<option value="">-- Pilih Kamar --</option>';
            if (kamars.length === 0) {
                kamarSelect.innerHTML = '<option value="" disabled>-- Kamar Penuh di Waktu Tersebut --</option>';
            } else {
                kamars.forEach(kmr => {
                    let option = document.createElement('option');
                    option.value = kmr.id;
                    option.text = 'Kamar ' + kmr.nomor_ruangan;
                    if (kmr.id == selectedKamarValueBefore) option.selected = true; // Pertahankan pilihan sebelumnya
                    kamarSelect.appendChild(option);
                });
            }
        } else {
            kamarSelect.innerHTML = '<option value="">-- Pilih Kelas & Tanggal Dahulu --</option>';
        }
    } catch (error) {
        console.error("Kesalahan sistem kalkulator:", error);
    }
}


// ==========================================
// MODULE 4: EXPORT FUNCTIONS TO GLOBAL WINDOW
// ==========================================
window.submitTolakReservasi = submitTolakReservasi;
window.bukaModalKonfirmasi = bukaModalKonfirmasi;
window.openWalkInModal = openWalkInModal;
window.closeWalkInModal = closeWalkInModal;
window.adjustQty = adjustQty;
window.filterKamarDanHitung = filterKamarDanHitung;
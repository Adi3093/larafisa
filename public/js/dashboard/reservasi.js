// ==========================================
// MODULE 1: MANAJEMEN MODAL WALK-IN (RESERVASI BARU / VIEW)
// ==========================================
function openWalkInModal() {
    document.getElementById("walkInForm").reset();
    document.getElementById("edit_reservasi_id").value = "";
    document.getElementById("modalWalkinTitle").innerText = "Reservasi Baru";

    document.getElementById("metode_pembayaran").value = "Tunai";
    toggleSimpanBtn();

    document.getElementById("wi_img_main").classList.add("hidden");
    document.getElementById("wi_placeholder_txt").classList.remove("hidden");

    let now = new Date();
    let tomorrow11 = new Date();
    tomorrow11.setDate(tomorrow11.getDate() + 1);
    tomorrow11.setHours(11, 0, 0, 0);

    document.getElementById("check_in").value = formatDateTimeLocal(now);
    document.getElementById("check_out").value = formatDateTimeLocal(tomorrow11);

    let modal = document.getElementById("walkInModal");
    modal.classList.remove("hidden");
    modal.classList.remove("pointer-events-none");
    
    filterKamarDanHitung();
}

function closeWalkInModal() {
    let modal = document.getElementById("walkInModal");
    modal.classList.add("hidden");
    modal.classList.add("pointer-events-none");
}

function bukaWalkInEdit(dataRes) {
    document.getElementById("walkInForm").reset();
    document.getElementById("modalWalkinTitle").innerText = "Tinjau Reservasi";

    document.getElementById("edit_reservasi_id").value = dataRes.id;
    if(document.getElementById("nama_tamu")) document.getElementById("nama_tamu").value = dataRes.nama_tamu;
    if(document.getElementById("no_hp")) document.getElementById("no_hp").value = dataRes.no_hp;
    if(document.getElementById("no_ktp")) document.getElementById("no_ktp").value = dataRes.no_ktp === "-" ? "" : dataRes.no_ktp;

    let eks = typeof dataRes.ekstra === "string" ? JSON.parse(dataRes.ekstra) : dataRes.ekstra;
    if(document.getElementById("extra_bed_qty")) document.getElementById("extra_bed_qty").value = eks["Extra Bed"] || 0;
    if(document.getElementById("metode_pembayaran")) document.getElementById("metode_pembayaran").value = eks["Metode Pembayaran"] || "Tunai";

    if(document.getElementById("check_in")) document.getElementById("check_in").value = dataRes.check_in.slice(0, 16);
    if(document.getElementById("check_out")) document.getElementById("check_out").value = dataRes.check_out.slice(0, 16);

    let kelasSelect = document.getElementById("kelas_kamar_id");
    if (kelasSelect) kelasSelect.value = dataRes.kamar.kelas_kamar_id;

    filterKamarDanHitung().then(() => {
        let kamarSelect = document.getElementById("kamar_id");
        if(kamarSelect) {
            let exist = Array.from(kamarSelect.options).some((opt) => opt.value == dataRes.kamar_id);
            if (!exist) {
                let opt = document.createElement("option");
                opt.value = dataRes.kamar_id;
                opt.text = "Kamar " + dataRes.kamar.nomor_ruangan;
                kamarSelect.appendChild(opt);
            }
            kamarSelect.value = dataRes.kamar_id;
        }
    });

    toggleSimpanBtn();
    
    let modal = document.getElementById("walkInModal");
    modal.classList.remove("hidden");
    modal.classList.remove("pointer-events-none");
}

function toggleSimpanBtn() {
    let metodeEl = document.getElementById("metode_pembayaran");
    let metode = metodeEl ? metodeEl.value : "Tunai";
    
    let btnSaja = document.getElementById("btnSimpanSaja");
    let btnCheckin = document.getElementById("btnSimpanCheckin");
    let btnBukaQR = document.getElementById("btnBukaPembayaran");
    let editId = document.getElementById("edit_reservasi_id").value;

    if (metode === "QRIS") {
        if(btnCheckin) btnCheckin.classList.add("hidden");

        if (editId !== "") {
            if(btnSaja) btnSaja.classList.add("hidden");
            if(btnBukaQR) btnBukaQR.classList.remove("hidden");
        } else {
            if(btnSaja) btnSaja.classList.remove("hidden");
            if(btnBukaQR) btnBukaQR.classList.add("hidden");
        }
    } else {
        if(btnCheckin) btnCheckin.classList.remove("hidden");
        if(btnSaja) btnSaja.classList.remove("hidden");
        if(btnBukaQR) btnBukaQR.classList.add("hidden");
    }

    let isEdit = editId !== "";
    if(document.getElementById("nama_tamu")) document.getElementById("nama_tamu").readOnly = isEdit;
    if(document.getElementById("no_hp")) document.getElementById("no_hp").readOnly = isEdit;
    if(document.getElementById("no_ktp")) document.getElementById("no_ktp").readOnly = isEdit;
    if(document.getElementById("kelas_kamar_id")) document.getElementById("kelas_kamar_id").disabled = isEdit;
    if(document.getElementById("kamar_id")) document.getElementById("kamar_id").disabled = isEdit;
    if(document.getElementById("check_in")) document.getElementById("check_in").readOnly = isEdit;
    if(document.getElementById("check_out")) document.getElementById("check_out").readOnly = isEdit;
    if(document.getElementById("metode_pembayaran")) document.getElementById("metode_pembayaran").disabled = isEdit;
}

// ==========================================
// MODULE 2: DATE & TIME MANAGEMENT
// ==========================================
function formatDateTimeLocal(dateObj) {
    let year = dateObj.getFullYear();
    let month = String(dateObj.getMonth() + 1).padStart(2, "0");
    let day = String(dateObj.getDate()).padStart(2, "0");
    let hours = String(dateObj.getHours()).padStart(2, "0");
    let minutes = String(dateObj.getMinutes()).padStart(2, "0");
    return `${year}-${month}-${day}T${hours}:${minutes}`;
}

function adjustDate(inputId, daysToAdd) {
    let editId = document.getElementById("edit_reservasi_id").value;
    if (editId !== "") return; 

    let input = document.getElementById(inputId);
    if (!input || !input.value) return;

    let dateObj = new Date(input.value);
    dateObj.setDate(dateObj.getDate() + daysToAdd);
    input.value = formatDateTimeLocal(dateObj);

    syncMinCheckout();
    filterKamarDanHitung();
}

function syncMinCheckout() {
    let inInput = document.getElementById("check_in");
    let outInput = document.getElementById("check_out");

    if (!inInput || !outInput || !inInput.value || !outInput.value) return;
    
    let editId = document.getElementById("edit_reservasi_id").value;
    if (editId !== "") return; 

    let inDate = new Date(inInput.value);
    let outDate = new Date(outInput.value);

    if (outDate <= inDate) {
        let newOut = new Date(inDate);
        newOut.setDate(newOut.getDate() + 1);
        newOut.setHours(11, 0, 0, 0);
        outInput.value = formatDateTimeLocal(newOut);
    }
}

// ==========================================
// MODULE 3: ENGINE KALKULATOR HARGA & PREVIEW
// ==========================================
function adjustQty(inputId, change) {
    let editId = document.getElementById("edit_reservasi_id").value;
    if (editId !== "") return; 

    let inputField = document.getElementById(inputId);
    if (!inputField) return;
    
    let currentVal = parseInt(inputField.value) || 0;
    let newVal = currentVal + change;
    if (newVal >= 0) {
        inputField.value = newVal;
        filterKamarDanHitung();
    }
}

async function filterKamarDanHitung() {
    let kelasSelect = document.getElementById("kelas_kamar_id");
    let checkInInput = document.getElementById("check_in");
    let checkOutInput = document.getElementById("check_out");
    let kamarSelect = document.getElementById("kamar_id");

    let kelasId = kelasSelect ? kelasSelect.value : null;
    let checkInVal = checkInInput ? checkInInput.value : null;
    let checkOutVal = checkOutInput ? checkOutInput.value : null;

    if (kelasId) {
        let dataKelas = window.kelasDataWalkin.find((k) => k.id == kelasId);
        if (dataKelas) {
            if(document.getElementById("wi_nama_kelas")) document.getElementById("wi_nama_kelas").innerText = dataKelas.nama_kelas;
            if(document.getElementById("wi_harga")) document.getElementById("wi_harga").innerText = "Rp " + parseInt(dataKelas.harga).toLocaleString("id-ID");
            if(document.getElementById("wi_kapasitas")) document.getElementById("wi_kapasitas").innerText = (dataKelas.kapasitas || 2) + " org";

            let mainImgUrl = dataKelas.thumbnail ? "/storage/" + dataKelas.thumbnail : "";
            if (mainImgUrl) {
                if(document.getElementById("wi_img_main")) {
                    document.getElementById("wi_img_main").src = mainImgUrl;
                    document.getElementById("wi_img_main").classList.remove("hidden");
                }
                if(document.getElementById("wi_placeholder_txt")) document.getElementById("wi_placeholder_txt").classList.add("hidden");
            }

            let images = [dataKelas.foto_1, dataKelas.foto_2, dataKelas.foto_3];
            let thumbsHtml = '';
            for(let i = 0; i < 3; i++) {
                if(images[i]) {
                    let fullUrl = '/storage/' + images[i];
                    thumbsHtml += `<div class="h-12 border border-gray-300 rounded-lg bg-gray-50 overflow-hidden cursor-pointer hover:border-[#E97609] transition" onclick="document.getElementById('wi_img_main').src='${fullUrl}'"><img src="${fullUrl}" class="w-full h-full object-cover"></div>`;
                } else {
                    thumbsHtml += `<div class="h-12 border border-gray-300 rounded-lg bg-gray-50 flex items-center justify-center text-[10px] text-gray-400">Foto ${i+1}</div>`;
                }
            }
            if(document.getElementById("wi_thumbnails")) document.getElementById("wi_thumbnails").innerHTML = thumbsHtml;

            let fasArr = typeof dataKelas.fasilitas === "string" ? JSON.parse(dataKelas.fasilitas) : dataKelas.fasilitas;
            let fasHtml = "";
            if (Array.isArray(fasArr)) {
                fasArr.forEach((f) => {
                    fasHtml += `<li class="flex items-center gap-1.5"><span class="text-[#E97609] font-bold">✔</span> ${f}</li>`;
                });
            }
            if(document.getElementById("wi_fasilitas")) document.getElementById("wi_fasilitas").innerHTML = fasHtml;
        }
    } else {
        if(document.getElementById("wi_nama_kelas")) document.getElementById("wi_nama_kelas").innerText = "-";
        if(document.getElementById("wi_harga")) document.getElementById("wi_harga").innerText = "Rp 0";
        if(document.getElementById("wi_kapasitas")) document.getElementById("wi_kapasitas").innerText = "- org";
        if(document.getElementById("wi_fasilitas")) document.getElementById("wi_fasilitas").innerHTML = '<li class="text-gray-400 italic">Pilih kamar...</li>';
        if(document.getElementById("wi_img_main")) document.getElementById("wi_img_main").classList.add("hidden");
        if(document.getElementById("wi_placeholder_txt")) document.getElementById("wi_placeholder_txt").classList.remove("hidden");
        
        let resetThumbsHtml = `
            <div class="h-12 border border-gray-300 rounded-lg bg-gray-50 flex items-center justify-center text-[10px] text-gray-400">Foto 1</div>
            <div class="h-12 border border-gray-300 rounded-lg bg-gray-50 flex items-center justify-center text-[10px] text-gray-400">Foto 2</div>
            <div class="h-12 border border-gray-300 rounded-lg bg-gray-50 flex items-center justify-center text-[10px] text-gray-400">Foto 3</div>
        `;
        if(document.getElementById("wi_thumbnails")) document.getElementById("wi_thumbnails").innerHTML = resetThumbsHtml;
    }

    let diffDays = 1;
    if (checkInVal && checkOutVal) {
        let cin = new Date(checkInVal);
        cin.setHours(0, 0, 0, 0);
        let cout = new Date(checkOutVal);
        cout.setHours(0, 0, 0, 0);
        diffDays = Math.max(1, Math.ceil((cout - cin) / (1000 * 60 * 60 * 24)));
    }

    let hargaPerMalam = kelasSelect && kelasSelect.selectedIndex > 0 ? parseInt(kelasSelect.options[kelasSelect.selectedIndex].getAttribute("data-harga")) : 0;
    let qtyBed = document.getElementById("extra_bed_qty") ? (parseInt(document.getElementById("extra_bed_qty").value) || 0) : 0;

    let totalBiayaKamar = hargaPerMalam * diffDays;
    let totalAddOn = qtyBed * 50000;
    
    if (document.getElementById("wi_durasi_malam")) document.getElementById("wi_durasi_malam").innerText = diffDays + " Malam";
    if (document.getElementById("wi_total_biaya_kiri")) document.getElementById("wi_total_biaya_kiri").innerText = "Rp " + (totalBiayaKamar + totalAddOn).toLocaleString("id-ID");

    if (document.getElementById("edit_reservasi_id") && document.getElementById("edit_reservasi_id").value === "" && kamarSelect) {
        kamarSelect.innerHTML = '<option value="">Memuat...</option>';
        if (kelasId && checkInVal && checkOutVal) {
            let res = await fetch(`/api/kamar-tersedia?kelas_id=${kelasId}&check_in=${checkInVal}&check_out=${checkOutVal}`);
            let kamars = await res.json();
            kamarSelect.innerHTML = kamars.length ? "" : '<option value="" disabled>Penuh</option>';
            kamars.forEach((kmr) => {
                kamarSelect.innerHTML += `<option value="${kmr.id}">Kamar ${kmr.nomor_ruangan}</option>`;
            });
        }
    }
}

// ==========================================
// MODULE 4: PAYMENT PANEL QRIS (AJAX & TIMER)
// ==========================================
let qrisTimerInterval;
let paymentCheckerInterval;

async function generateAndOpenPayment() {
    let resId = document.getElementById("edit_reservasi_id").value;
    if (!resId) return;

    let btnBukaQR = document.getElementById("btnBukaPembayaran");
    if (btnBukaQR) {
        btnBukaQR.innerText = "Memuat API...";
        btnBukaQR.disabled = true;
    }

    try {
        let response = await fetch(`/reservasi/${resId}/generate-qris`);
        let data = await response.json();

        if (data.success) {
            closeWalkInModal();
            populatePaymentPanel(data);
        } else {
            alert("Gagal membuat kode QRIS.");
        }
    } catch (e) {
        alert("Server Error.");
    } finally {
        if (btnBukaQR) {
            btnBukaQR.innerText = "Buka Pembayaran";
            btnBukaQR.disabled = false;
        }
    }
}

function generateAndOpenPaymentRow(resId) {
    document.getElementById("edit_reservasi_id").value = resId;
    generateAndOpenPayment();
}

function populatePaymentPanel(dataQR) {
    let resData = dataQR.reservasi;

    if (!resData) {
        alert("Gagal memuat detail reservasi dari server.");
        return;
    }

    let eks = typeof resData.ekstra === "string" ? JSON.parse(resData.ekstra) : resData.ekstra;
    let exBed = eks["Extra Bed"] || 0;

    document.getElementById("pay_nama").innerText = resData.nama_tamu;
    document.getElementById("pay_hp").innerText = resData.no_hp;
    
    let namaKelas = resData.kamar && resData.kamar.kelas_kamar ? resData.kamar.kelas_kamar.nama_kelas : "-";
    let noKamar = resData.kamar ? resData.kamar.nomor_ruangan : "-";
    let hargaPerMalam = resData.kamar && resData.kamar.kelas_kamar ? resData.kamar.kelas_kamar.harga : 0;

    document.getElementById("pay_kelas").innerText = `${namaKelas} (No. ${noKamar})`;
    document.getElementById("pay_bed").innerText = exBed > 0 ? `Ekstra Bed (x${exBed})` : "-";
    document.getElementById("pay_invoice").innerText = "#" + dataQR.invoice;

    let cin = new Date(resData.check_in); cin.setHours(0, 0, 0, 0);
    let cout = new Date(resData.check_out); cout.setHours(0, 0, 0, 0);
    let diffDays = Math.max(1, Math.ceil((cout - cin) / (1000 * 60 * 60 * 24)));
    
    let totalBiaya = (hargaPerMalam * diffDays) + (exBed * 50000);

    document.getElementById("pay_total").innerText = "Total : Rp " + totalBiaya.toLocaleString("id-ID");

    let qrisBox = document.getElementById("pay_qris_box");
    let qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=${encodeURIComponent(dataQR.qr_image)}`;

    if (dataQR.status === "berhasil") {
        renderSuccessQR(qrisBox);
    } else {
        qrisBox.innerHTML = `<img src="${qrUrl}" alt="QRIS" class="w-56 h-56 object-contain shadow-sm bg-white p-2 rounded-xl border border-gray-200">`;
        document.getElementById("pay_timer_container").classList.remove("hidden");
        startQrisCountdown(dataQR.expired_at, dataQR.invoice);
    }

    let modal = document.getElementById("paymentModal");
    modal.classList.remove("hidden");
    modal.classList.remove("pointer-events-none"); 

    document.getElementById("btnDownloadQr").onclick = () => downloadQrImage(qrUrl, dataQR.invoice);
}

function startQrisCountdown(expiredAtStr, invoice) {
    if (qrisTimerInterval) clearInterval(qrisTimerInterval);
    if (paymentCheckerInterval) clearInterval(paymentCheckerInterval);

    const safeDateStr = expiredAtStr.replace(" ", "T");
    const countDownDate = new Date(safeDateStr).getTime();
    const timerDisplay = document.getElementById("pay_timer");

    qrisTimerInterval = setInterval(function () {
        const now = new Date().getTime();
        const distance = countDownDate - now;

        if (distance >= 0) {
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            timerDisplay.innerHTML = (hours < 10 ? "0" + hours : hours) + ":" + (minutes < 10 ? "0" + minutes : minutes) + ":" + (seconds < 10 ? "0" + seconds : seconds);
        } else {
            clearInterval(qrisTimerInterval);
            clearInterval(paymentCheckerInterval);
            timerDisplay.innerHTML = "WAKTU HABIS";
            document.getElementById("pay_status").innerText = "KEDALUWARSA / GAGAL";
            document.getElementById("pay_status").className = "font-black text-red-600 uppercase ml-1";
            document.getElementById("pay_qris_box").innerHTML = `<span class="text-5xl">❌</span><p class="font-black text-red-600 mt-3 text-lg">QRIS Kedaluwarsa</p>`;
            
            // 🔥 INI DIA KUNCINYA: PAKSA BACKEND UNTUK MEMBATALKAN TAGIHAN DI PAKASIR SEKARANG JUGA!
            fetch(`/payment/check/${invoice}?timeout=1`);
        }
    }, 1000);

    paymentCheckerInterval = setInterval(async () => {
        try {
            const res = await fetch(`/payment/check/${invoice}`);
            const data = await res.json();
            if (data.status === "berhasil") {
                clearInterval(qrisTimerInterval);
                clearInterval(paymentCheckerInterval);
                document.getElementById("pay_timer_container").classList.add("hidden");
                document.getElementById("pay_status").innerText = "BERHASIL LUNAS";
                document.getElementById("pay_status").className = "font-black text-emerald-600 uppercase ml-1";
                renderSuccessQR(document.getElementById("pay_qris_box"));
            } else if (data.status === "gagal") {
                clearInterval(qrisTimerInterval);
                clearInterval(paymentCheckerInterval);
                timerDisplay.innerHTML = "WAKTU HABIS";
                document.getElementById("pay_status").innerText = "KEDALUWARSA / GAGAL";
                document.getElementById("pay_status").className = "font-black text-red-600 uppercase ml-1";
                document.getElementById("pay_qris_box").innerHTML = `<span class="text-5xl">❌</span><p class="font-black text-red-600 mt-3 text-lg">QRIS Kedaluwarsa</p>`;
            }
        } catch (e) {}
    }, 5000);
}

function renderSuccessQR(container) {
    container.innerHTML = `
        <div class="text-center w-full">
            <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" viewBox="0 0 24 24"><path fill="currentColor" d="M10.5 15.25A.74.74 0 0 1 10 15l-3-3a.75.75 0 0 1 1-1l2.47 2.47L19 5a.75.75 0 0 1 1-1l-9 9a.74.74 0 0 1-.5.25Z"/><path fill="currentColor" d="M12 21a9 9 0 0 1-7.87-4.66a8.67 8.67 0 0 1-1.07-3.41a9 9 0 0 1 4.6-8.81a8.67 8.67 0 0 1 3.41-1.07a8.86 8.86 0 0 1 3.55.34a.75.75 0 1 1-.43 1.43a7.62 7.62 0 0 0-3-.28a7.43 7.43 0 0 0-2.84.89a7.5 7.5 0 0 0-2.2 1.84a7.42 7.42 0 0 0-1.64 5.51a7.43 7.43 0 0 0 .89 2.84a7.5 7.5 0 0 0 1.84 2.2a7.42 7.42 0 0 0 5.51 1.64a7.43 7.43 0 0 0 2.84-.89a7.5 7.5 0 0 0 2.2-1.84a7.42 7.42 0 0 0 1.64-5.51a.75.75 0 1 1 1.57-.15a9 9 0 0 1-4.61 8.81A8.67 8.67 0 0 1 12.93 21H12Z"/></svg>
            </div>
            <h4 class="font-black text-emerald-700 text-xl">Pembayaran Lunas!</h4>
        </div>`;
    let btn = document.getElementById("btnDownloadQr");
    if(btn) btn.classList.add("hidden");
}

async function downloadQrImage(url, invoice) {
    let btn = document.getElementById("btnDownloadQr");
    btn.disabled = true;
    btn.innerText = "Mengunduh...";
    try {
        const response = await fetch(url.replace(/&amp;/g, "&"));
        const blob = await response.blob();
        const blobUrl = window.URL.createObjectURL(blob);
        const link = document.createElement("a");
        link.href = blobUrl;
        link.download = `QRIS-${invoice}.png`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        window.URL.revokeObjectURL(blobUrl);
    } catch (e) {
        alert("Gagal mengunduh.");
    } finally {
        btn.disabled = false;
        btn.innerText = "Download Kode QRIS";
    }
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

// Bind ke window
window.openWalkInModal = openWalkInModal;
window.closeWalkInModal = closeWalkInModal;
window.bukaWalkInEdit = bukaWalkInEdit;
window.adjustQty = adjustQty;
window.filterKamarDanHitung = filterKamarDanHitung;
window.toggleSimpanBtn = toggleSimpanBtn;
window.generateAndOpenPayment = generateAndOpenPayment;
window.generateAndOpenPaymentRow = generateAndOpenPaymentRow;
window.adjustDate = adjustDate;
window.syncMinCheckout = syncMinCheckout;
window.showMyConfirm = showMyConfirm;
window.closeLocalConfirm = closeLocalConfirm;
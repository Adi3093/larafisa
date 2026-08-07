// MODULE 1: GLOBAL STATE & CACHE VARIABLES
const paymentIntervals = {};
const timerIntervals = {};
const paymentExpiredFlags = {};

// MODULE 2: MODAL WINDOW CONTROL
function handleCloseModal() { window.location.reload(); }

function openMobileWizard(id) {
    let infoPanel = document.getElementById("infoPanel-" + id);
    let payPanel = document.getElementById("paymentPanel-" + id);
    infoPanel.classList.remove("block"); infoPanel.classList.add("hidden", "md:block");
    payPanel.classList.remove("hidden"); payPanel.classList.add("flex");
    document.getElementById("headerTitleMobile-" + id).innerText = "Detail Pembayaran";
    document.getElementById("backBtn-" + id).classList.remove("hidden");
}

function closeMobileWizard(id) {
    let infoPanel = document.getElementById("infoPanel-" + id);
    let payPanel = document.getElementById("paymentPanel-" + id);
    infoPanel.classList.remove("hidden", "md:block"); infoPanel.classList.add("block");
    payPanel.classList.remove("flex"); payPanel.classList.add("hidden");
    document.getElementById("headerTitleMobile-" + id).innerText = "Detail dan Reservasi Tamu";
    document.getElementById("backBtn-" + id).classList.add("hidden");
}

// MODULE 3: GLOBAL TOAST / ALERT MENGGUNAKAN STANDAR APLIKASI
function showAppToast(title, message, theme = 'amber', btnText = 'Ya, Lanjutkan', callback = null) {
    // Kita buat form temporary jika callback dipicu oleh event global x-confirm
    let tempFormId = 'temp-confirm-form-' + Math.random().toString(36).substring(2, 9);
    
    // Simpan callback ke dalam fungsi global sementara agar bisa dipanggil x-confirm jika diperlukan,
    // atau gunakan Event Listeners standar Laravel Anda:
    window.dispatchEvent(new CustomEvent('open-confirm', {
        detail: {
            title: title,
            message: message,
            confirmText: btnText,
            theme: theme,
            targetAction: callback
        }
    }));
}

// MODULE 4: FRONTEND VALIDATION (ANTI-MUNDUR DENGAN X-CONFIRM)
function validateRescheduleTime(resId) {
    const checkinInput = document.getElementById('checkin-' + resId);
    if (!checkinInput) return true;

    const selectedTime = new Date(checkinInput.value).getTime();
    const nowTime = new Date().getTime();

    // Validasi Waktu Mundur
    if (selectedTime < (nowTime - 60000)) {
        // Panggil event open-confirm untuk error/peringatan waktu mundur
        window.dispatchEvent(new CustomEvent('open-confirm', {
            detail: {
                title: "Waktu Tidak Valid",
                message: "Waktu check-in tidak valid! Anda tidak dapat memilih waktu di masa lalu.",
                confirmText: "Tutup",
                theme: "danger"
            }
        }));
        return false; 
    }
    
    // Jika lolos, munculkan modal konfirmasi ubah jadwal global
    const form = document.getElementById('formRescheduleEl-' + resId);
    
    // Kita intercept submit agar memunculkan komponen <x-confirm /> bawaan layout
    if (!window._rescheduleConfirmed) {
        window.dispatchEvent(new CustomEvent('open-confirm', {
            detail: {
                title: "Konfirmasi Perubahan Jadwal",
                message: "Apakah Anda yakin ingin mengubah jadwal menginap ini?",
                confirmText: "Ya, Ubah Jadwal",
                theme: "amber"
            }
        }));

        // Dengarkan event ketika user menekan tombol konfirmasi pada x-confirm global
        document.addEventListener('confirm-success-once', function handler() {
            document.removeEventListener('confirm-success-once', handler);
            window._rescheduleConfirmed = true;
            form.submit();
        }, { once: true });

        return false; // Tahan submit form dulu
    }

    return true; 
}

// MODULE 5: LAZY QRIS GENERATOR
function confirmGenerateQris(resId, url) {
    const btn = document.getElementById("btnGenQris-" + resId);
    if (btn && btn.disabled) {
        window.dispatchEvent(new CustomEvent('open-confirm', {
            detail: {
                title: "Akses Ditolak",
                message: "Anda tidak bisa membuat QRIS. Jadwal Anda sudah terlewat.",
                confirmText: "Tutup",
                theme: "danger"
            }
        }));
        return;
    }

    window.dispatchEvent(new CustomEvent('open-confirm', {
        detail: {
            title: "Peringatan Penting!",
            message: "Jadwal reservasi akan TERKUNCI PERMANEN dan tidak bisa diubah lagi jika Anda sudah melanjutkan ke halaman pembayaran QRIS.",
            confirmText: "Ya, Buat QRIS",
            theme: "amber"
        }
    }));

    document.addEventListener('confirm-success-once', function handler() {
        document.removeEventListener('confirm-success-once', handler);
        executeGenerateQris(resId, url);
    }, { once: true });
}

async function executeGenerateQris(resId, url) {
    const btn = document.getElementById("btnGenQris-" + resId);
    if (btn) { btn.innerHTML = "Memproses..."; btn.disabled = true; }

    try {
        const response = await fetch(url, { method: 'GET', headers: { 'Accept': 'application/json' } });
        const data = await response.json();
        if (data.success) {
            const qrisPlaceholder = document.getElementById('qrisPlaceholder-' + resId);
            if (qrisPlaceholder) { qrisPlaceholder.classList.add('hidden'); qrisPlaceholder.classList.remove('flex'); }

            const activeDiv = document.getElementById('qrisActive-' + resId);
            if (activeDiv) {
                activeDiv.classList.remove('hidden'); activeDiv.classList.add('flex', 'flex-col', 'items-center', 'justify-center');
                const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=${encodeURIComponent(data.qr_image)}`;
                activeDiv.innerHTML = `
                    <div class="animate-fade-in flex flex-col items-center w-full">
                        <div class="mb-3 text-center w-full">
                            <p class="text-[10px] text-amber-700 font-bold uppercase tracking-wider mb-1">Status Batas Waktu:</p>
                            <div id="qrisTimer-${resId}" class="text-sm font-bold border border-amber-300 bg-amber-50 rounded-lg py-1 px-3 inline-block">Menghitung Waktu...</div>
                        </div>
                        <img src="${qrUrl}" alt="QRIS" class="w-44 h-44 object-contain shadow-sm border border-amber-200 rounded-xl bg-white p-2 mx-auto">
                    </div>`;
                
                const downloadContainer = document.getElementById('qrisDownloadContainer-' + resId);
                if (downloadContainer) {
                    downloadContainer.classList.remove('hidden'); downloadContainer.classList.add('block');
                    downloadContainer.innerHTML = `<button type="button" onclick="forceDownloadQR(this, '${qrUrl}', '${data.invoice}')" class="qris-download-btn-${resId} mt-2 w-full bg-amber-100 hover:bg-amber-200 text-amber-900 border border-amber-400 font-bold py-3 px-4 rounded-xl text-sm transition shadow-sm flex items-center justify-center gap-2 text-center cursor-pointer relative z-50 border-none"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg><span class="btn-text">Download Kode QR</span></button>`;
                }
            }

            const formReschedule = document.getElementById('formReschedule-' + resId);
            if (formReschedule) {
                formReschedule.setAttribute('data-qris-generated', 'true');
                formReschedule.innerHTML = `
                <div class="border-b-2 border-amber-100 pb-2 mb-4"><h4 class="text-lg font-black text-amber-900">Ubah Jadwal Menginap</h4></div>
                <div class="p-3 bg-red-50 border border-red-200 text-red-700 text-xs font-bold rounded-xl text-center shadow-inner mb-4">🔒 Jadwal telah terkunci karena QRIS pembayaran sudah diminta.</div>`;
            }

            startPaymentCheck(data.invoice, resId);
            startCountdown(data.expired_at, resId);
        } else {
            window.dispatchEvent(new CustomEvent('open-confirm', {
                detail: { title: "Gagal", message: data.message || "Gagal memuat sistem Gateway.", confirmText: "Tutup", theme: "danger" }
            }));
            if (btn) { btn.innerHTML = "Generate QRIS"; btn.disabled = false; }
        }
    } catch (e) {
        window.dispatchEvent(new CustomEvent('open-confirm', {
            detail: { title: "Error", message: "Terjadi kesalahan koneksi server.", confirmText: "Tutup", theme: "danger" }
        }));
        if (btn) { btn.innerHTML = "Generate QRIS"; btn.disabled = false; }
    }
}

// MODULE 6: DATE ADJUSTER (< > BUTTONS)
function adjustDateRiwayat(inputId, daysToAdd) {
    let input = document.getElementById(inputId);
    if (!input || !input.value || input.disabled) return;
    let dateObj = new Date(input.value);
    dateObj.setDate(dateObj.getDate() + daysToAdd);
    let year = dateObj.getFullYear();
    let month = String(dateObj.getMonth() + 1).padStart(2, "0");
    let day = String(dateObj.getDate()).padStart(2, "0");
    let hours = String(dateObj.getHours()).padStart(2, "0");
    let minutes = String(dateObj.getMinutes()).padStart(2, "0");
    input.value = `${year}-${month}-${day}T${hours}:${minutes}`;
}

// MODULE 7: COUNTDOWN TIMER ENGINE
function startCountdown(expiredAtStr, resId) {
    if (timerIntervals[resId]) clearInterval(timerIntervals[resId]);
    const safeDateStr = expiredAtStr.replace(" ", "T");
    const countDownDate = new Date(safeDateStr).getTime();
    const timerDisplay = document.getElementById("qrisTimer-" + resId);

    if (!timerDisplay) return;

    timerIntervals[resId] = setInterval(function () {
        const now = new Date().getTime();
        const distance = countDownDate - now;

        if (distance >= 0) {
            timerDisplay.className = "text-xl font-black text-red-600 tracking-widest border border-red-200 bg-red-50 rounded-lg py-1 px-3 inline-block animate-pulse";
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            timerDisplay.innerHTML = (hours < 10 ? "0" + hours : hours) + ":" + (minutes < 10 ? "0" + minutes : minutes) + ":" + (seconds < 10 ? "0" + seconds : seconds);
        } else {
            clearInterval(timerIntervals[resId]);
            paymentExpiredFlags[resId] = true;
            timerDisplay.innerHTML = "❌ KEDALUWARSA";
            timerDisplay.className = "text-xs font-black text-gray-500 tracking-wider border border-gray-200 bg-gray-100 rounded-lg py-1 px-3 inline-block";

            const container = document.getElementById("qrisActive-" + resId);
            if (container) {
                container.innerHTML = `
                    <div class="text-center w-full animate-fade-in p-6 bg-red-50 rounded-2xl border border-red-200">
                        <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-3"><span class="text-2xl">❌</span></div>
                        <h4 class="font-black text-red-700 text-lg mb-1">Pembayaran Kedaluwarsa</h4>
                        <p class="text-xs text-red-600/80 font-medium">Waktu batas pembayaran telah terlampaui. Reservasi ini otomatis dibatalkan.</p>
                        <p class="text-[10px] text-gray-400 mt-3 italic">Silakan muat ulang halaman untuk memperbarui riwayat Anda.</p>
                    </div>`;
            }

            const displayStatus = document.getElementById("statusPaymentDisplay-" + resId);
            if (displayStatus) { displayStatus.innerText = "GAGAL / KEDALUWARSA"; displayStatus.className = "text-red-600 font-bold uppercase tracking-wider"; }
            const downloadBtns = document.querySelectorAll(".qris-download-btn-" + resId);
            downloadBtns.forEach((btn) => { btn.style.display = "none"; });
        }
    }, 1000);
}

// MODULE 8: REALTIME CHECK-IN STATUS CHECKER 
setInterval(() => {
    const now = new Date().getTime();
    document.querySelectorAll('[data-checkin-time]').forEach(el => {
        const checkinTime = new Date(el.dataset.checkinTime).getTime();
        const status = el.dataset.status;
        const resId = el.dataset.id;
        const isQrisGenerated = el.dataset.qrisGenerated === 'true';

        if (!isQrisGenerated && (status === 'Menunggu Konfirmasi' || status === 'Terlewat') && now >= checkinTime) {
            
            const warningEl = document.getElementById('warningTerlewat-' + resId);
            if (warningEl && warningEl.classList.contains('hidden')) {
                warningEl.classList.remove('hidden'); warningEl.classList.add('block');
                
                const statusDisplay = document.getElementById("statusPaymentDisplay-" + resId);
                if(statusDisplay) {
                    statusDisplay.innerText = "TERLEWAT";
                    statusDisplay.className = "text-red-600 font-bold uppercase tracking-wider animate-pulse";
                }
            }

            const qrisPlaceholder = document.getElementById('qrisPlaceholder-' + resId);
            const boxQrisTerlewat = document.getElementById('boxQrisTerlewat-' + resId);
            
            if(qrisPlaceholder && !qrisPlaceholder.classList.contains('hidden')) {
                qrisPlaceholder.classList.add('hidden');
                qrisPlaceholder.classList.remove('flex');
                if(boxQrisTerlewat) {
                    boxQrisTerlewat.classList.remove('hidden');
                    boxQrisTerlewat.classList.add('flex');
                }
            }
        }
    });
}, 1000);

// MODULE 9: REALTIME TRANSACTION CHECKER
function startPaymentCheck(invoice, resId) {
    if (paymentIntervals[resId]) clearInterval(paymentIntervals[resId]);
    const statusDisplay = document.getElementById("statusPaymentDisplay-" + resId);
    const container = document.getElementById("qrisActive-" + resId);

    paymentIntervals[resId] = setInterval(async () => {
        try {
            const res = await fetch(`/payment/check/${invoice}`);
            const data = await res.json();

            if (data.status === "berhasil") {
                clearInterval(paymentIntervals[resId]);
                if (timerIntervals[resId]) clearInterval(timerIntervals[resId]);

                if (statusDisplay) { statusDisplay.innerHTML = "BERHASIL (PAID)"; statusDisplay.className = "text-green-600 font-black uppercase tracking-wider"; }
                if (container) {
                    container.innerHTML = `
                        <div class="text-center w-full animate-fade-in">
                            <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm border-4 border-white ring-2 ring-green-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" viewBox="0 0 24 24"><path fill="currentColor" d="M10.5 15.25A.74.74 0 0 1 10 15l-3-3a.75.75 0 0 1 1-1l2.47 2.47L19 5a.75.75 0 0 1 1 1l-9 9a.74.74 0 0 1-.5.25Z"/><path fill="currentColor" d="M12 21a9 9 0 0 1-7.87-4.66a8.67 8.67 0 0 1-1.07-3.41a9 9 0 0 1 4.6-8.81a8.67 8.67 0 0 1 3.41-1.07a8.86 8.86 0 0 1 3.55.34a.75.75 0 1 1-.43 1.43a7.62 7.62 0 0 0-3-.28a7.43 7.43 0 0 0-2.84.89a7.5 7.5 0 0 0-2.2 1.84a7.42 7.42 0 0 0-1.64 5.51a7.43 7.43 0 0 0 .89 2.84a7.5 7.5 0 0 0 1.84 2.2a7.42 7.42 0 0 0 5.51 1.64a7.43 7.43 0 0 0 2.84-.89a7.5 7.5 0 0 0 2.2-1.84a7.42 7.42 0 0 0 1.64-5.51a.75.75 0 1 1 1.57-.15a9 9 0 0 1-4.61 8.81A8.67 8.67 0 0 1 12.93 21H12Z"/></svg>
                            </div>
                            <h4 class="font-black text-green-700 text-xl">Pembayaran Lunas!</h4>
                        </div>`;
                }
                const downloadBtns = document.querySelectorAll(".qris-download-btn-" + resId);
                downloadBtns.forEach((btn) => (btn.style.display = "none"));
            } else if (data.status === "gagal") { paymentExpiredFlags[resId] = true; }
        } catch (error) { }
    }, 5000);
}

// MODULE 10: QR CODE DOWNLOADER
async function forceDownloadQR(btn, imageUrl, invoiceNo) {
    if (btn.disabled) return;
    const textSpan = btn.querySelector(".btn-text");
    const originalHtml = textSpan.innerHTML;
    btn.disabled = true; btn.classList.add("opacity-75", "cursor-wait");

    let dotCount = 0;
    const animationInterval = setInterval(() => { dotCount = (dotCount + 1) % 4; textSpan.innerHTML = `Mendownload${".".repeat(dotCount)}`; }, 400);

    try {
        const cleanUrl = imageUrl.replace(/&amp;/g, "&");
        const response = await fetch(cleanUrl);
        const blob = await response.blob();
        const blobUrl = window.URL.createObjectURL(blob);
        const link = document.createElement("a"); link.style.display = "none"; link.href = blobUrl; link.download = `QRIS-${invoiceNo}.png`;
        document.body.appendChild(link); link.click();
        setTimeout(() => { document.body.removeChild(link); window.URL.revokeObjectURL(blobUrl); }, 100);
    } catch (e) { 
        window.dispatchEvent(new CustomEvent('open-confirm', {
            detail: { title: "Error", message: "Gagal mengunduh gambar QR.", confirmText: "Tutup", theme: "danger" }
        }));
    } finally {
        clearInterval(animationInterval); textSpan.innerHTML = originalHtml; btn.disabled = false; btn.classList.remove("opacity-75", "cursor-wait");
    }
}

// Tangkap sinyal klik "Ya, Lanjutkan" dari komponen global <x-confirm />
document.addEventListener('DOMContentLoaded', () => {
    // Kita buat event listener global untuk menangkap konfirmasi sukses dari x-confirm
    const observer = new MutationObserver(() => {
        // Cek jika tombol konfirmasi global di-klik, kita bisa tembak event custom
        const confirmBtn = document.querySelector('[x-show="isOpen"] button.bg-amber-600, [x-show="isOpen"] button.bg-red-600');
        if (confirmBtn && !confirmBtn.hasAttribute('data-listened')) {
            confirmBtn.setAttribute('data-listened', 'true');
            confirmBtn.addEventListener('click', () => {
                document.dispatchEvent(new CustomEvent('confirm-success-once'));
            });
        }
    });
    observer.observe(document.body, { childList: true, subtree: true });
});

window.handleCloseModal = handleCloseModal; 
window.startCountdown = startCountdown; 
window.startPaymentCheck = startPaymentCheck; 
window.openMobileWizard = openMobileWizard; 
window.closeMobileWizard = closeMobileWizard; 
window.forceDownloadQR = forceDownloadQR; 
window.confirmGenerateQris = confirmGenerateQris; 
window.executeGenerateQris = executeGenerateQris; 
window.adjustDateRiwayat = adjustDateRiwayat; 
window.validateRescheduleTime = validateRescheduleTime;
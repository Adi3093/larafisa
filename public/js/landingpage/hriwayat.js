// ==========================================
// MODULE 1: GLOBAL STATE & CACHE VARIABLES
// ==========================================
let paymentInterval = null;
let timerInterval = null;
let paymentIsExpired = false; 

// ==========================================
// MODULE 2: MODAL WINDOW CONTROL
// ==========================================
function handleCloseModal() {
    const modal = document.getElementById('modalDetail');
    if (paymentIsExpired) {
        modal.classList.add('hidden');
        window.location.reload(); 
    } else {
        modal.classList.add('hidden');
    }
}

// ==========================================
// MODULE 3: COUNTDOWN TIMER ENGINE
// ==========================================
function startCountdown(expiredAtStr) {
    if (timerInterval) clearInterval(timerInterval);
    const safeDateStr = expiredAtStr.replace(' ', 'T');
    const countDownDate = new Date(safeDateStr).getTime();
    const timerDisplay = document.getElementById("qrisTimer");

    if (!timerDisplay) return;

    timerInterval = setInterval(function() {
        const now = new Date().getTime();
        const distance = countDownDate - now;

        if (distance > 3600000) {
            timerDisplay.innerHTML = "⏳ Menunggu Jendela Pembayaran (Aktif H-1 Jam)";
            timerDisplay.className = "text-[11px] font-bold text-amber-800 border border-amber-200 bg-amber-50 rounded-lg py-1 px-3 inline-block";
        } else if (distance >= 0) {
            timerDisplay.className = "text-xl font-black text-red-600 tracking-widest border border-red-200 bg-red-50 rounded-lg py-1 px-3 inline-block animate-pulse";
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            timerDisplay.innerHTML = (hours < 10 ? "0" + hours : hours) + ":" + (minutes < 10 ? "0" + minutes : minutes) + ":" + (seconds < 10 ? "0" + seconds : seconds);
        } else {
            clearInterval(timerInterval);
            paymentIsExpired = true;
            timerDisplay.innerHTML = "❌ KEDALUWARSA / WAKTU HABIS";
            timerDisplay.className = "text-xs font-black text-gray-500 tracking-wider border border-gray-200 bg-gray-100 rounded-lg py-1 px-3 inline-block";

            const container = document.getElementById('qrisContainer');
            if (container) {
                container.innerHTML = `
                    <div class="text-center w-full animate-fade-in p-6 bg-red-50 rounded-2xl border border-red-200">
                        <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-3"><span class="text-2xl">❌</span></div>
                        <h4 class="font-black text-red-700 text-lg mb-1">Pembayaran Kedaluwarsa</h4>
                        <p class="text-xs text-red-600/80 font-medium">Waktu batas check-in telah terlampaui. Reservasi ini otomatis dibatalkan.</p>
                        <p class="text-[10px] text-gray-400 mt-3 italic">Silakan tutup menu ini untuk memperbarui riwayat Anda.</p>
                    </div>
                `;
            }

            const displayStatus = document.getElementById('statusPaymentDisplay');
            if (displayStatus) {
                displayStatus.innerText = "GAGAL / KEDALUWARSA";
                displayStatus.className = "text-red-600 font-bold uppercase";
            }
        }
    }, 1000);
}

// ==========================================
// MODULE 4: IMAGE DOWNLOAD RESEP SIONIS
// ==========================================
async function downloadQR(imageUrl, invoiceNo) {
    try {
        const response = await fetch(imageUrl);
        const blob = await response.blob();
        const blobUrl = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = blobUrl;
        link.download = `QRIS-${invoiceNo}.png`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        window.URL.revokeObjectURL(blobUrl);
    } catch (e) {
        alert('Gagal mengunduh gambar.');
    }
}

// ==========================================
// MODULE 5: REALTIME TRANSACTION CHECKER
// ==========================================
function startPaymentCheck(invoice) {
    if (paymentInterval) clearInterval(paymentInterval);
    const statusDisplay = document.getElementById('statusPaymentDisplay');
    const container = document.getElementById('qrisContainer');

    paymentInterval = setInterval(async () => {
        try {
            const res = await fetch(`/payment/check/${invoice}`);
            const data = await res.json();
            if (data.status === "berhasil") {
                clearInterval(paymentInterval);
                if (timerInterval) clearInterval(timerInterval);
                if (statusDisplay) {
                    statusDisplay.innerHTML = "BERHASIL (PAID)";
                    statusDisplay.className = "text-green-600 font-black uppercase";
                }
                if (container) {
                    container.innerHTML = `
                        <div class="text-center w-full animate-fade-in">
                            <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm border-4 border-white ring-2 ring-green-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" viewBox="0 0 24 24"><path fill="currentColor" d="M10.5 15.25A.74.74 0 0 1 10 15l-3-3a.75.75 0 0 1 1-1l2.47 2.47L19 5a.75.75 0 0 1 1 1l-9 9a.74.74 0 0 1-.5.25Z"/><path fill="currentColor" d="M12 21a9 9 0 0 1-7.87-4.66a8.67 8.67 0 0 1-1.07-3.41a9 9 0 0 1 4.6-8.81a8.67 8.67 0 0 1 3.41-1.07a8.86 8.86 0 0 1 3.55.34a.75.75 0 1 1-.43 1.43a7.62 7.62 0 0 0-3-.28a7.43 7.43 0 0 0-2.84.89a7.5 7.5 0 0 0-2.2 1.84a7.42 7.42 0 0 0-1.64 5.51a7.43 7.43 0 0 0 .89 2.84a7.5 7.5 0 0 0 1.84 2.2a7.42 7.42 0 0 0 5.51 1.64a7.43 7.43 0 0 0 2.84-.89a7.5 7.5 0 0 0 2.2-1.84a7.42 7.42 0 0 0 1.64-5.51a.75.75 0 1 1 1.57-.15a9 9 0 0 1-4.61 8.81A8.67 8.67 0 0 1 12.93 21H12Z"/></svg>
                            </div>
                            <h4 class="font-black text-green-700 text-xl">Pembayaran Lunas!</h4>
                        </div>
                    `;
                }
            } else if (data.status === "gagal") {
                paymentIsExpired = true;
            }
        } catch (error) {}
    }, 5000);
}

// EXPORT TO GLOBAL WINDOW
window.handleCloseModal = handleCloseModal;
window.startCountdown = startCountdown;
window.downloadQR = downloadQR;
window.startPaymentCheck = startPaymentCheck;
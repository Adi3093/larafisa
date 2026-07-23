// MODULE 1: GLOBAL STATE & CACHE VARIABLES
const paymentIntervals = {};
const timerIntervals = {};
const paymentExpiredFlags = {};

// MODULE 2: MODAL WINDOW CONTROL
function handleCloseModal() {
    window.location.reload();
}

// MODULE 3: WIZARD MOBILE TAB CONTROLLER
function openMobileWizard(id) {
    let infoPanel = document.getElementById("infoPanel-" + id);
    let payPanel = document.getElementById("paymentPanel-" + id);
    infoPanel.classList.remove("block");
    infoPanel.classList.add("hidden", "md:block");
    payPanel.classList.remove("hidden");
    payPanel.classList.add("flex");

    document.getElementById("headerTitleMobile-" + id).innerText =
        "Detail Pembayaran";
    document.getElementById("backBtn-" + id).classList.remove("hidden");
}

function closeMobileWizard(id) {
    let infoPanel = document.getElementById("infoPanel-" + id);
    let payPanel = document.getElementById("paymentPanel-" + id);

    // 1. Tampilkan kembali Info Panel di Layar HP
    infoPanel.classList.remove("hidden", "md:block");
    infoPanel.classList.add("block");

    // 2. Sembunyikan kembali Payment Panel di Layar HP
    payPanel.classList.remove("flex");
    payPanel.classList.add("hidden");

    // 3. Kembalikan Header
    document.getElementById("headerTitleMobile-" + id).innerText =
        "Detail dan Reservasi Tamu";
    document.getElementById("backBtn-" + id).classList.add("hidden");
}

// MODULE 4: COUNTDOWN TIMER ENGINE
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
            timerDisplay.className =
                "text-xl font-black text-red-600 tracking-widest border border-red-200 bg-red-50 rounded-lg py-1 px-3 inline-block animate-pulse";
            const hours = Math.floor(
                (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60),
            );
            const minutes = Math.floor(
                (distance % (1000 * 60 * 60)) / (1000 * 60),
            );
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            timerDisplay.innerHTML =
                (hours < 10 ? "0" + hours : hours) +
                ":" +
                (minutes < 10 ? "0" + minutes : minutes) +
                ":" +
                (seconds < 10 ? "0" + seconds : seconds);
        } else {
            clearInterval(timerIntervals[resId]);
            paymentExpiredFlags[resId] = true;
            timerDisplay.innerHTML = "❌ KEDALUWARSA / WAKTU HABIS";
            timerDisplay.className =
                "text-xs font-black text-gray-500 tracking-wider border border-gray-200 bg-gray-100 rounded-lg py-1 px-3 inline-block";

            const container = document.getElementById("qrisContainer-" + resId);
            if (container) {
                container.innerHTML = `
                    <div class="text-center w-full animate-fade-in p-6 bg-red-50 rounded-2xl border border-red-200">
                        <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-3"><span class="text-2xl">❌</span></div>
                        <h4 class="font-black text-red-700 text-lg mb-1">Pembayaran Kedaluwarsa</h4>
                        <p class="text-xs text-red-600/80 font-medium">Waktu batas pembayaran telah terlampaui. Reservasi ini otomatis dibatalkan.</p>
                        <p class="text-[10px] text-gray-400 mt-3 italic">Silakan muat ulang halaman untuk memperbarui riwayat Anda.</p>
                    </div>
                `;
            }

            const displayStatus = document.getElementById(
                "statusPaymentDisplay-" + resId,
            );
            if (displayStatus) {
                displayStatus.innerText = "GAGAL / KEDALUWARSA";
                displayStatus.className =
                    "text-red-600 font-bold uppercase tracking-wider";
            }

            // Menghilangkan tombol download saat kadaluarsa
            const downloadBtns = document.querySelectorAll(
                ".qris-download-btn-" + resId,
            );
            downloadBtns.forEach((btn) => {
                btn.style.display = "none";
            });
        }
    }, 1000);
}

// MODULE 5: REALTIME TRANSACTION CHECKER
function startPaymentCheck(invoice, resId) {
    if (paymentIntervals[resId]) clearInterval(paymentIntervals[resId]);
    const statusDisplay = document.getElementById(
        "statusPaymentDisplay-" + resId,
    );
    const container = document.getElementById("qrisContainer-" + resId);

    paymentIntervals[resId] = setInterval(async () => {
        try {
            const res = await fetch(`/payment/check/${invoice}`);
            const data = await res.json();

            if (data.status === "berhasil") {
                clearInterval(paymentIntervals[resId]);
                if (timerIntervals[resId]) clearInterval(timerIntervals[resId]);

                if (statusDisplay) {
                    statusDisplay.innerHTML = "BERHASIL (PAID)";
                    statusDisplay.className =
                        "text-green-600 font-black uppercase tracking-wider";
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

                // Menghilangkan tombol saat lunas
                const downloadBtns = document.querySelectorAll(
                    ".qris-download-btn-" + resId,
                );
                downloadBtns.forEach((btn) => (btn.style.display = "none"));
            } else if (data.status === "gagal") {
                paymentExpiredFlags[resId] = true;
            }
        } catch (error) {}
    }, 5000);
}

// MODULE 6: QR CODE DOWNLOADER (BYPASS CACHE)
async function forceDownloadQR(btn, imageUrl, invoiceNo) {
    if (btn.disabled) return;

    const textSpan = btn.querySelector(".btn-text");
    const originalHtml = textSpan.innerHTML;

    btn.disabled = true;
    btn.classList.add("opacity-75", "cursor-wait");

    // Mulai animasi titik-titik
    let dotCount = 0;
    const animationInterval = setInterval(() => {
        dotCount = (dotCount + 1) % 4;
        textSpan.innerHTML = `Mendownload${".".repeat(dotCount)}`;
    }, 400);

    try {
        const cleanUrl = imageUrl.replace(/&amp;/g, "&");
        const response = await fetch(cleanUrl);
        const blob = await response.blob();
        const blobUrl = window.URL.createObjectURL(blob);

        const link = document.createElement("a");
        link.style.display = "none";
        link.href = blobUrl;
        link.download = `QRIS-${invoiceNo}.png`;

        document.body.appendChild(link);
        link.click();

        setTimeout(() => {
            document.body.removeChild(link);
            window.URL.revokeObjectURL(blobUrl);
        }, 100);
    } catch (e) {
        alert("Gagal mengunduh gambar QR. Silakan cek koneksi internet Anda.");
    } finally {
        clearInterval(animationInterval);
        textSpan.innerHTML = originalHtml;
        btn.disabled = false;
        btn.classList.remove("opacity-75", "cursor-wait");
    }
}

// EXPORT TO GLOBAL WINDOW
window.handleCloseModal = handleCloseModal;
window.startCountdown = startCountdown;
window.startPaymentCheck = startPaymentCheck;
window.openMobileWizard = openMobileWizard;
window.closeMobileWizard = closeMobileWizard;
window.forceDownloadQR = forceDownloadQR;

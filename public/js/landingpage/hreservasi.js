// MODULE 1: GLOBAL STATE VARIABLES
let currentHarga = 0;

// MODULE 2: INITIALIZATION ON LOAD
document.addEventListener("DOMContentLoaded", () => {
    updateUIKamar();
    syncMinCheckout();
});

// MODULE 3: GUEST & CAPACITY MANAGEMENT
function adjustAnggota(val) {
    let input = document.getElementById("jumlah_anggota");
    let current = parseInt(input.value) || 1;
    let newVal = current + val;
    // Maksimal 10 orang menyesuaikan
    if (newVal >= 1 && newVal <= 10) {
        input.value = newVal;
        checkKapasitas();
    }
}

function checkKapasitas() {
    let tooltip = document.getElementById("kapasitas_tooltip");
    if (!tooltip) return;

    let anggota = parseInt(document.getElementById("jumlah_anggota").value) || 1;

    // HANYA MENGATUR TOOLTIP: Tampilkan tooltip otomatis jika anggota lebih dari 3 (mulai angka 4)
    if (anggota > 3) {
        showWarningTooltip();
    } else {
        hideWarningTooltip();
    }
    
    // Ikon (!) tidak diapa-apakan di sini karena sudah diset selalu muncul di HTML (class 'flex')
}

// LOGIKA TOGGLE TOOLTIP KLIK MANUAL
function toggleWarningTooltip(e) {
    if(e) e.stopPropagation();
    let tooltip = document.getElementById("kapasitas_tooltip");
    if (!tooltip) return;
    if (tooltip.classList.contains("opacity-0")) {
        showWarningTooltip();
    } else {
        hideWarningTooltip();
    }
}

function showWarningTooltip() {
    let tooltip = document.getElementById("kapasitas_tooltip");
    if (tooltip) {
        tooltip.classList.remove("opacity-0", "invisible");
        tooltip.classList.add("opacity-100", "visible");
    }
}

function hideWarningTooltip() {
    let tooltip = document.getElementById("kapasitas_tooltip");
    if (tooltip) {
        tooltip.classList.add("opacity-0", "invisible");
        tooltip.classList.remove("opacity-100", "visible");
    }
}

function toggleInfoTooltip(e) {
    if(e) e.stopPropagation();
    let tooltip = document.getElementById("info_tooltip");
    if (!tooltip) return;
    if (tooltip.classList.contains("opacity-0")) {
        tooltip.classList.remove("opacity-0", "invisible");
        tooltip.classList.add("opacity-100", "visible");
    } else {
        tooltip.classList.add("opacity-0", "invisible");
        tooltip.classList.remove("opacity-100", "visible");
    }
}

// Tutup Tooltip jika tamu nge-klik bagian kosong di luar Ikon
document.addEventListener('click', function(e) {
    let warnBtn = document.getElementById("kapasitas_warning");
    let warnTooltip = document.getElementById("kapasitas_tooltip");
    if (warnBtn && warnTooltip && !warnBtn.contains(e.target) && !warnTooltip.contains(e.target)) {
        hideWarningTooltip();
    }

    let infoTooltip = document.getElementById("info_tooltip");
    let infoBtn = document.getElementById("info_btn");
    if (infoBtn && infoTooltip && !infoBtn.contains(e.target) && !infoTooltip.contains(e.target)) {
        infoTooltip.classList.add("opacity-0", "invisible");
        infoTooltip.classList.remove("opacity-100", "visible");
    }
});

// MODULE 4: DATE & CALENDAR MANAGEMENT
function adjustDate(inputId, daysToAdd) {
    let input = document.getElementById(inputId);
    if (!input.value) return;

    let dateObj = new Date(input.value);
    dateObj.setDate(dateObj.getDate() + daysToAdd);

    let year = dateObj.getFullYear();
    let month = String(dateObj.getMonth() + 1).padStart(2, "0");
    let day = String(dateObj.getDate()).padStart(2, "0");
    let hours = String(dateObj.getHours()).padStart(2, "0");
    let minutes = String(dateObj.getMinutes()).padStart(2, "0");

    input.value = `${year}-${month}-${day}T${hours}:${minutes}`;

    syncMinCheckout();
    hitungTotal();
}

function syncMinCheckout() {
    let inInput = document.getElementById("check_in");
    let outInput = document.getElementById("check_out");

    if (!inInput.value || !outInput.value) return;

    let inDate = new Date(inInput.value);
    let outDate = new Date(outInput.value);

    // Jika Checkout mendahului/sama dengan Checkin, otomatis majukan + Set ke jam 11:00
    if (outDate <= inDate) {
        let newOut = new Date(inDate);
        newOut.setDate(newOut.getDate() + 1);
        newOut.setHours(11, 0, 0, 0);

        let year = newOut.getFullYear();
        let month = String(newOut.getMonth() + 1).padStart(2, "0");
        let day = String(newOut.getDate()).padStart(2, "0");
        let hours = String(newOut.getHours()).padStart(2, "0");
        let minutes = String(newOut.getMinutes()).padStart(2, "0");

        outInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
    }
}

// MODULE 5: EXTRA SERVICES & PRICING LOGIC
function adjustEkstra(id, val) {
    let input = document.getElementById(id);
    let current = parseInt(input.value) || 0;
    let newVal = current + val;
    if (newVal >= 0) {
        input.value = newVal;
        hitungTotal();
    }
}

function hitungTotal() {
    let select = document.getElementById("kelas_kamar_id");
    let inDate = new Date(document.getElementById("check_in").value);
    let outDate = new Date(document.getElementById("check_out").value);

    // Reset ke jam 00:00 untuk hitungan murni "hari kalender"
    inDate.setHours(0, 0, 0, 0);
    outDate.setHours(0, 0, 0, 0);

    let diffTime = outDate - inDate;
    let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    if (isNaN(diffDays) || diffDays < 1) diffDays = 1;

    let hargaKamar = 0;
    if (select.value !== "") {
        hargaKamar =
            parseInt(
                select.options[select.selectedIndex].getAttribute("data-harga"),
            ) || 0;
    }

    // Hanya Ekstra Bed saja dengan harga Rp 50.000
    let bed = parseInt(document.getElementById("extra_bed").value) || 0;
    let total = hargaKamar * diffDays + bed * 50000;

    document.getElementById("totalDisplayAtas").innerText =
        "Rp " + total.toLocaleString("id-ID");
}

// MODULE 6: UI UPDATE & LIVE PREVIEW KAMAR
function updateUIKamar() {
    let select = document.getElementById("kelas_kamar_id");
    let btnLihat = document.getElementById("btnLihatKamar");

    let placeholderDesk = document.getElementById("placeholderPreview");
    let contentDesk = document.getElementById("contentPreview");

    if (select.value === "") {
        btnLihat.classList.add("hidden");
        btnLihat.classList.remove("flex");
        contentDesk.classList.add("hidden");
        placeholderDesk.classList.remove("hidden");
    } else {
        btnLihat.classList.remove("hidden");
        btnLihat.classList.add("flex");
        placeholderDesk.classList.add("hidden");
        contentDesk.classList.remove("hidden");

        let option = select.options[select.selectedIndex];
        let nama = option.text;
        let thumb = option.getAttribute("data-thumb");
        let f1 = option.getAttribute("data-foto1");
        let f2 = option.getAttribute("data-foto2");
        let f3 = option.getAttribute("data-foto3");
        let kapasitas = option.getAttribute("data-kapasitas") || 2;
        let fasilitas = JSON.parse(
            option.getAttribute("data-fasilitas") || "[]",
        );

        document.getElementById("prevImg").src = thumb;
        document.getElementById("mobImg").src = thumb;

        let thumbHtml = "";
        if (f1)
            thumbHtml += `<img src="${f1}" class="w-full h-12 object-cover rounded-lg border cursor-pointer hover:opacity-80 transition" onclick="document.getElementById('prevImg').src='${f1}'; document.getElementById('mobImg').src='${f1}';">`;
        if (f2)
            thumbHtml += `<img src="${f2}" class="w-full h-12 object-cover rounded-lg border cursor-pointer hover:opacity-80 transition" onclick="document.getElementById('prevImg').src='${f2}'; document.getElementById('mobImg').src='${f2}';">`;
        if (f3)
            thumbHtml += `<img src="${f3}" class="w-full h-12 object-cover rounded-lg border cursor-pointer hover:opacity-80 transition" onclick="document.getElementById('prevImg').src='${f3}'; document.getElementById('mobImg').src='${f3}';">`;

        document.getElementById("prevThumbnails").innerHTML = thumbHtml;
        document.getElementById("mobThumbnails").innerHTML = thumbHtml;

        document.getElementById("prevNama").innerText = nama;
        document.getElementById("mobNama").innerText = nama;

        document.getElementById("prevKapasitas").innerText =
            "Max: " + kapasitas + " Org";
        document.getElementById("mobKapasitas").innerText =
            "Max: " + kapasitas + " Org";

        let fasHtml = "";
        fasilitas.forEach((f) => {
            fasHtml += `<li class="flex items-center gap-1.5"><span class="text-amber-500 text-[10px]">●</span> ${f}</li>`;
        });
        document.getElementById("prevFasilitas").innerHTML = fasHtml;
        document.getElementById("mobFasilitas").innerHTML = fasHtml;
    }

    checkKapasitas();
    hitungTotal();
}

// EXPORT TO GLOBAL WINDOW FOR BLADE
window.adjustAnggota = adjustAnggota;
window.checkKapasitas = checkKapasitas;
window.adjustDate = adjustDate;
window.syncMinCheckout = syncMinCheckout;
window.adjustEkstra = adjustEkstra;
window.hitungTotal = hitungTotal;
window.updateUIKamar = updateUIKamar;
window.toggleWarningTooltip = toggleWarningTooltip;
window.toggleInfoTooltip = toggleInfoTooltip;
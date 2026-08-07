// MODULE 1: GLOBAL STATE VARIABLES
let kelasIdAktif = null;

// MODULE 2: MODAL WINDOW CONTROL
function bukaDetailKelas(id, namaKelas, harga, fasilitas, thumb, f1, f2, f3, jumlahTersedia) {
    kelasIdAktif = id;

    document.getElementById('modal_nama_kelas').innerText = namaKelas;
    document.getElementById('modal_harga').innerText = harga;
    document.getElementById('modal_foto_utama').src = thumb;
    
    const ketersediaanElem = document.getElementById('modal_ketersediaan');
    const btnPesan = document.getElementById('modal_btn_pesan');

    if (jumlahTersedia > 0) {
        ketersediaanElem.innerHTML = `<span class="bg-green-500/90 text-white text-sm font-bold px-4 py-2 rounded-full shadow-sm backdrop-blur-sm border border-green-400">Tersedia ${jumlahTersedia} Ruangan</span>`;
        btnPesan.disabled = false;
        btnPesan.className = "w-full bg-amber-600 text-white font-bold text-base sm:text-lg py-3 sm:py-4 rounded-xl shadow-lg shadow-amber-600/30 hover:bg-amber-700 transition transform hover:-translate-y-0.5 border-none cursor-pointer";
        btnPesan.innerText = "Lanjut Reservasi";
    } else {
        ketersediaanElem.innerHTML = `<span class="bg-red-500/90 text-white text-sm font-bold px-4 py-2 rounded-full shadow-sm backdrop-blur-sm border border-red-400">Kamar Penuh</span>`;
        btnPesan.disabled = true;
        btnPesan.className = "w-full bg-gray-400 text-white font-bold text-base sm:text-lg py-3 sm:py-4 rounded-xl shadow-none cursor-not-allowed border-none";
        btnPesan.innerText = "Saat Ini Tidak Tersedia";
    }

    // 🚀 FIX: Menggunakan "Set" untuk secara otomatis membuang URL gambar yang terduplikat
    let galeriHTML = '';
    let arrayFoto = [...new Set([thumb, f1, f2, f3])].filter(foto => foto !== '');
    
    arrayFoto.forEach(fotoUrl => {
        galeriHTML += `
            <div class="h-16 sm:h-24 rounded-xl overflow-hidden shadow-sm border-2 border-transparent hover:border-amber-400 cursor-pointer transition" onclick="document.getElementById('modal_foto_utama').src='${fotoUrl}'">
                <img src="${fotoUrl}" class="w-full h-full object-cover">
            </div>
        `;
    });
    document.getElementById('galeri_tambahan').innerHTML = galeriHTML;

    let fasHTML = '';
    fasilitas.forEach(item => {
        fasHTML += `<li class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-amber-500 shrink-0"></span>${item}</li>`;
    });
    document.getElementById('modal_fasilitas').innerHTML = fasHTML;

    document.body.classList.add('overflow-hidden');
    document.getElementById('modalDetail').classList.remove('hidden');
}

function tutupDetailKelas() {
    document.body.classList.remove('overflow-hidden'); 
    document.getElementById('modalDetail').classList.add('hidden');
}

// MODULE 3: REDIRECTION & FILTERING
function lanjutReservasi() {
    let checkin = document.getElementById('filter_checkin').value;
    let checkout = document.getElementById('filter_checkout').value;
    
    window.location.href = `/reservasi-online?kelas_id=${kelasIdAktif}&filter_checkin=${checkin}&filter_checkout=${checkout}`;
}

function resetFilter() {
    window.location.href = window.location.origin + "/#kamar";
}


// MODULE 4: KONTROL UI TANGGAL DAN PENGINAP
function adjustDateHome(inputId, daysToAdd) {
    let input = document.getElementById(inputId);
    if (!input || !input.value) return;

    let dateObj = new Date(input.value);
    dateObj.setDate(dateObj.getDate() + daysToAdd);
    
    let year = dateObj.getFullYear();
    let month = String(dateObj.getMonth() + 1).padStart(2, "0");
    let day = String(dateObj.getDate()).padStart(2, "0");
    let hours = String(dateObj.getHours()).padStart(2, "0");
    let minutes = String(dateObj.getMinutes()).padStart(2, "0");
    
    input.value = `${year}-${month}-${day}T${hours}:${minutes}`;
    syncMinCheckoutHome();
}

function syncMinCheckoutHome() {
    let inInput = document.getElementById("filter_checkin");
    let outInput = document.getElementById("filter_checkout");
    if (!inInput || !outInput || !inInput.value || !outInput.value) return;

    let inDate = new Date(inInput.value);
    let outDate = new Date(outInput.value);

    if (outDate <= inDate) {
        let newOut = new Date(inDate);
        newOut.setDate(newOut.getDate() + 1);
        newOut.setHours(11, 0, 0, 0); // Kunci batasan ke jam 11 Siang
        
        let year = newOut.getFullYear();
        let month = String(newOut.getMonth() + 1).padStart(2, "0");
        let day = String(newOut.getDate()).padStart(2, "0");
        let hours = String(newOut.getHours()).padStart(2, "0");
        let minutes = String(newOut.getMinutes()).padStart(2, "0");
        
        outInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
    }
}

function adjustPenginap(change) {
    let hiddenInput = document.getElementById('filter_tamu');
    let displayInput = document.getElementById('display_penginap');
    let currentVal = parseInt(hiddenInput.value) || 1;
    let newVal = currentVal + change;
    
    // Batas Minimal 1 Orang, Maksimal 4 Orang
    if (newVal >= 1 && newVal <= 4) {
        hiddenInput.value = newVal;
        displayInput.value = newVal + " Orang";
    }
}


// MODULE 5: EXPORT TO GLOBAL WINDOW
window.bukaDetailKelas = bukaDetailKelas;
window.tutupDetailKelas = tutupDetailKelas;
window.lanjutReservasi = lanjutReservasi;
window.resetFilter = resetFilter;
window.adjustDateHome = adjustDateHome;
window.syncMinCheckoutHome = syncMinCheckoutHome;
window.adjustPenginap = adjustPenginap;
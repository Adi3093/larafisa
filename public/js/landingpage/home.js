
// MODULE 1: GLOBAL STATE VARIABLES
// Menyimpan ID kelas kamar yang sedang dilihat di modal
let kelasIdAktif = null;

// MODULE 2: MODAL WINDOW CONTROL
/**
 * Fungsi untuk membuka modal dan mengisi seluruh data secara dinamis
 */
function bukaDetailKelas(id, namaKelas, harga, fasilitas, thumb, f1, f2, f3, jumlahTersedia) {
    // 1. Simpan ID ke dalam state global
    kelasIdAktif = id;

    // 2. Tulis Data Teks Utama
    document.getElementById('modal_nama_kelas').innerText = namaKelas;
    document.getElementById('modal_harga').innerText = harga;
    document.getElementById('modal_foto_utama').src = thumb;
    
    // 3. Atur UI Ketersediaan (Badge & Tombol)
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

    // 4. Susun Galeri Foto Mini (Thumbnail)
    let galeriHTML = '';
    let arrayFoto = [thumb, f1, f2, f3].filter(foto => foto !== '');
    arrayFoto.forEach(fotoUrl => {
        galeriHTML += `
            <div class="h-16 sm:h-24 rounded-xl overflow-hidden shadow-sm border-2 border-transparent hover:border-amber-400 cursor-pointer transition" onclick="document.getElementById('modal_foto_utama').src='${fotoUrl}'">
                <img src="${fotoUrl}" class="w-full h-full object-cover">
            </div>
        `;
    });
    document.getElementById('galeri_tambahan').innerHTML = galeriHTML;

    // 5. Susun List Fasilitas
    let fasHTML = '';
    fasilitas.forEach(item => {
        fasHTML += `<li class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-amber-500 shrink-0"></span>${item}</li>`;
    });
    document.getElementById('modal_fasilitas').innerHTML = fasHTML;

    // 6. Tampilkan Modal
    document.body.classList.add('overflow-hidden'); // Kunci scroll halaman belakang
    document.getElementById('modalDetail').classList.remove('hidden');
}

/**
 * Fungsi untuk menutup modal
 */
function tutupDetailKelas() {
    document.body.classList.remove('overflow-hidden'); // Kembalikan scroll
    document.getElementById('modalDetail').classList.add('hidden');
}

// MODULE 3: REDIRECTION & FILTERING
/**
 * Fungsi untuk membawa tamu ke halaman form reservasi beserta parameternya
 */
function lanjutReservasi() {
    let checkin = document.getElementById('filter_checkin').value;
    let checkout = document.getElementById('filter_checkout').value;
    
    // Redirect langsung ke URL halaman form reservasi dengan Query String (URL Parameter)
    window.location.href = `/reservasi-online?kelas_id=${kelasIdAktif}&filter_checkin=${checkin}&filter_checkout=${checkout}`;
}

/**
 * Fungsi untuk menghapus query string filter di URL
 */
function resetFilter() {
    // URL dasar dari situs, diambil dari tag khusus atau menggunakan origin murni
    window.location.href = window.location.origin + "/#kamar";
}

// MODULE 4: EXPORT TO GLOBAL WINDOW
window.bukaDetailKelas = bukaDetailKelas;
window.tutupDetailKelas = tutupDetailKelas;
window.lanjutReservasi = lanjutReservasi;
window.resetFilter = resetFilter;
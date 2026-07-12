// ==========================================
// MODULE 1: PREVIEW GAMBAR DRAG & DROP
// ==========================================
/**
 * Fungsi untuk menampilkan preview gambar saat pengguna memilih file di form
 */
function previewDragDrop(input, imgId, textId) {
    const img = document.getElementById(imgId);
    const text = document.getElementById(textId);
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            img.classList.remove('hidden');
            if (text) text.classList.add('hidden'); // Sembunyikan instruksi drag & drop
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// ==========================================
// MODULE 2: MANAJEMEN MODAL KELAS KAMAR
// ==========================================
/**
 * Fungsi untuk membuka modal Edit Kelas dan mengisi form secara dinamis
 */
function openEditKelas(id, nama, harga, kapasitas, fasilitas, thumb, foto1, foto2, foto3) {
    // 1. Injeksi Form Action dan Data Utama
    document.getElementById('formEditKelas').action = '/kelas-kamar/' + id;
    document.getElementById('edit_nama_kelas').value = nama;
    document.getElementById('edit_harga_kelas').value = harga;
    document.getElementById('edit_kapasitas').value = kapasitas;

    // 2. Fungsi Pembantu untuk Load Preview Gambar dari Database
    const setPreview = (id, val) => {
        const img = document.getElementById('prev_' + id);
        const txt = document.getElementById('text_' + id);
        if (img) {
            if (val) {
                img.src = '/storage/' + val;
                img.classList.remove('hidden');
                if (txt) txt.classList.add('hidden');
            } else {
                img.src = '';
                img.classList.add('hidden');
                if (txt) txt.classList.remove('hidden');
            }
        }
    };

    setPreview('foto_1', foto1);
    setPreview('foto_2', foto2);
    setPreview('foto_3', foto3);

    // 3. Logika Seleksi Radio Button Thumbnail Secara Otomatis
    let radios = document.getElementsByName('thumbnail_selection');
    radios.forEach(r => r.checked = false);
    
    if (thumb === foto1 && foto1) {
        document.getElementById('radio_foto_1').checked = true;
    } else if (thumb === foto2 && foto2) {
        document.getElementById('radio_foto_2').checked = true;
    } else if (thumb === foto3 && foto3) {
        document.getElementById('radio_foto_3').checked = true;
    } else if (radios[0]) {
        radios[0].checked = true; // Fallback ke foto 1
    }

    // 4. Centang Fasilitas Otomatis Berdasarkan Array Database
    let checkboxes = document.querySelectorAll('.edit-fas-cb');
    checkboxes.forEach(cb => cb.checked = false);

    let fasArr = fasilitas;
    if (typeof fasArr === 'string') {
        try {
            fasArr = JSON.parse(fasArr);
        } catch (e) {
            fasArr = [];
        }
    }
    if (Array.isArray(fasArr)) {
        checkboxes.forEach(cb => {
            if (fasArr.includes(cb.value)) cb.checked = true;
        });
    }

    // 5. Tampilkan Modal ke Layar
    document.getElementById('modalKelasEdit').classList.remove('hidden');
}


// ==========================================
// MODULE 3: MANAJEMEN MODAL FISIK RUANGAN
// ==========================================
/**
 * Fungsi untuk membuka modal Edit Ruangan (Nomor & Status)
 */
function openEditRuangan(id, kelasId, nomor, status) {
    // Arahkan action URL ke Controller Update
    document.getElementById('formEditRuang').action = '/kamar/' + id;
    
    // Injeksi data ke dalam form input
    document.getElementById('editRuangTitle').innerText = "#" + nomor;
    document.getElementById('edit_kelas_kamar_id').value = kelasId;
    document.getElementById('edit_nomor_ruangan').value = nomor;
    document.getElementById('edit_status').value = status;
    
    // Tampilkan Modal ke Layar
    document.getElementById('modalRuanganEdit').classList.remove('hidden');
}

// ==========================================
// MODULE 4: EXPORT FUNCTIONS TO GLOBAL WINDOW
// ==========================================
// Daftarkan fungsi agar bisa dibaca dari attribute 'onclick' atau 'onchange' pada tag HTML Blade
window.previewDragDrop = previewDragDrop;
window.openEditKelas = openEditKelas;
window.openEditRuangan = openEditRuangan;
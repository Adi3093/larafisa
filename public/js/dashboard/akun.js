// ==========================================
// MODULE 1: MANAJEMEN MODAL TAMBAH AKUN
// ==========================================
/**
 * Membuka modal tambah pengguna
 */
function openAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
}

/**
 * Menutup modal tambah pengguna dan membersihkan form
 */
function closeAddModal() {
    document.getElementById('addModal').classList.add('hidden');
    document.getElementById('addForm').reset();
}


// ==========================================
// MODULE 2: MANAJEMEN MODAL EDIT AKUN
// ==========================================
/**
 * Membuka modal edit pengguna dan menyisipkan data ID dan Teks ke form
 */
function openEditModal(userId, currentUsername, name) {
    // Arahkan action URL form ke Route Update sesuai ID pengguna
    document.getElementById('editForm').action = '/akun/' + userId;
    
    // Injeksi teks dan value ke dalam modal
    document.getElementById('modal-username').value = currentUsername;
    document.getElementById('modal-user-name').innerText = name;
    
    // Tampilkan modal
    document.getElementById('editModal').classList.remove('hidden');
}

/**
 * Menutup modal edit pengguna dan membersihkan isi form (terutama sandi)
 */
function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editForm').reset();
}


// ==========================================
// MODULE 3: EVENT LISTENER DOM
// ==========================================
document.addEventListener('DOMContentLoaded', () => {
    
    // Auto-Submit Dropdown 'Tampilkan Baris'
    const perPageSelect = document.getElementById('perPageSelect');
    const formSearch = document.getElementById('formSearch');
    
    if (perPageSelect && formSearch) {
        perPageSelect.addEventListener('change', () => {
            formSearch.submit();
        });
    }

});

// ==========================================
// MODULE 4: EXPORT FUNCTIONS TO GLOBAL WINDOW
// ==========================================
// Daftarkan fungsi ke window agar dapat dipanggil dari atribut HTML onclick
window.openAddModal = openAddModal;
window.closeAddModal = closeAddModal;
window.openEditModal = openEditModal;
window.closeEditModal = closeEditModal;
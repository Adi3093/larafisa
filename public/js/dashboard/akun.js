
// Tambah Akun
function openAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
}

function closeAddModal() {
    document.getElementById('addModal').classList.add('hidden');
    document.getElementById('addForm').reset();
}


// Edit Akun
function openEditModal(userId, currentUsername, name) {
    document.getElementById('editForm').action = '/akun/' + userId;
    document.getElementById('modal-username').value = currentUsername;
    document.getElementById('modal-user-name').innerText = name;
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editForm').reset();
}

window.openAddModal = openAddModal;
window.closeAddModal = closeAddModal;
window.openEditModal = openEditModal;
window.closeEditModal = closeEditModal;
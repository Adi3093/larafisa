// ==========================================
// MODULE: EVENT LISTENER DOM
// ==========================================
// Menunggu hingga seluruh elemen HTML selesai dimuat oleh browser
document.addEventListener('DOMContentLoaded', () => {

    // 1. Aksi ketika Dropdown Periode (Mingguan/Bulanan) diubah
    const filterPeriode = document.getElementById('filterPeriode');
    const formPendapatan = document.getElementById('formPendapatan');
    
    if (filterPeriode && formPendapatan) {
        filterPeriode.addEventListener('change', () => {
            // Otomatis submit form filter
            formPendapatan.submit();
        });
    }

    // 2. Aksi ketika Dropdown Jumlah Baris Data (Pagination) diubah
    const filterPerPage = document.getElementById('filterPerPage');
    const formPerPage = document.getElementById('formPerPage');
    
    if (filterPerPage && formPerPage) {
        filterPerPage.addEventListener('change', () => {
            // Otomatis submit form pagination
            formPerPage.submit();
        });
    }

});
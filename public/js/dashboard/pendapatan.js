// DOM Listener
document.addEventListener('DOMContentLoaded', () => {
    const filterPeriode = document.getElementById('filterPeriode');
    const formPendapatan = document.getElementById('formPendapatan');
    
    if (filterPeriode && formPendapatan) {
        filterPeriode.addEventListener('change', () => {
            formPendapatan.submit();
        });
    }

    const filterPerPage = document.getElementById('filterPerPage');
    const formPerPage = document.getElementById('formPerPage');
    
    if (filterPerPage && formPerPage) {
        filterPerPage.addEventListener('change', () => {
            formPerPage.submit();
        });
    }

});
document.addEventListener('DOMContentLoaded', function () {
    // Konfirmasi pengembalian buku
    const returnForms = document.querySelectorAll(
        'form[action*="return.php"]'
    );

    returnForms.forEach(function (form) {
        form.addEventListener('submit', function (event) {
            const confirmed = confirm(
                'Apakah kamu yakin ingin mengembalikan buku ini?'
            );

            if (!confirmed) {
                event.preventDefault();
            }
        });
    });
});


/* =================================
   DIGBOOK - AUTHENTICATION SCRIPT
================================= */

document.addEventListener('DOMContentLoaded', function () {

    // Mengambil seluruh form pada halaman
    const authForms = document.querySelectorAll('.auth-content form');

    authForms.forEach(function (form) {

        form.addEventListener('submit', function (event) {

            const password = form.querySelector(
                'input[name="password"]'
            );

            const confirmPassword = form.querySelector(
                'input[name="confirm_password"]'
            );

            // Validasi panjang password
            if (password && password.value.length < 8) {

                event.preventDefault();

                alert('Password minimal harus 8 karakter.');

                password.focus();

                return;
            }

            // Validasi konfirmasi password pada halaman Register
            if (
                confirmPassword &&
                password.value !== confirmPassword.value
            ) {

                event.preventDefault();

                alert('Konfirmasi password tidak cocok.');

                confirmPassword.focus();

                return;
            }

        });

    });

});


// ========================================
// DIGBOOK - MAIN JAVASCRIPT
// ========================================

document.addEventListener('DOMContentLoaded', function () {

    // Mobile Navigation
    const menuToggle = document.getElementById('mobileMenuToggle');
    const navbarMenu = document.querySelector('.navbar-menu');
    const navbarActions = document.querySelector('.navbar-actions');

    if (menuToggle && navbarMenu && navbarActions) {

        menuToggle.addEventListener('click', function () {

            navbarMenu.classList.toggle('active');
            navbarActions.classList.toggle('active');

            const isExpanded =
                menuToggle.getAttribute('aria-expanded') === 'true';

            menuToggle.setAttribute(
                'aria-expanded',
                String(!isExpanded)
            );

            menuToggle.setAttribute(
                'aria-label',
                isExpanded ? 'Buka menu navigasi' : 'Tutup menu navigasi'
            );

        });

    }

    // Close Mobile Menu When Link Is Clicked
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(function (link) {

        link.addEventListener('click', function () {

            if (navbarMenu && navbarActions && menuToggle) {

                navbarMenu.classList.remove('active');
                navbarActions.classList.remove('active');

                menuToggle.setAttribute('aria-expanded', 'false');
                menuToggle.setAttribute(
                    'aria-label',
                    'Buka menu navigasi'
                );

            }

        });

    });

});


<?php
$isLoggedIn = isset($_SESSION['user']);
$userName = $isLoggedIn
    ? ($_SESSION['user']['name'] ?? 'Pengguna')
    : '';

$userRole = $isLoggedIn
    ? ($_SESSION['user']['role'] ?? 'member')
    : 'member';
?>

<header class="site-header">
    <nav class="navbar container">

        <!-- Logo -->
        <a href="/index.php" class="navbar-brand">
            <img
                src="/assets/images/logo.png"
                alt="Logo DigBook"
                class="navbar-logo"
            >
            <span>DigBook</span>
        </a>

        <!-- Menu Navigasi -->
        <ul class="navbar-menu">
            <li>
                <a href="/index.php" class="nav-link">Beranda</a>
            </li>

            <li>
                <a href="/index.php#catalog" class="nav-link">Katalog</a>
            </li>

            <li>
                <a href="/index.php#about" class="nav-link">Tentang</a>
            </li>
        </ul>

        <!-- Tombol Akun -->
        <div class="navbar-actions">

            <?php if ($isLoggedIn): ?>

                <span class="navbar-greeting">
                    Halo, <?= htmlspecialchars($userName) ?>
                </span>

                <?php if ($userRole === 'admin'): ?>
                    <a href="/admin/dashboard.php" class="btn-nav">
                        Dashboard
                    </a>
                <?php else: ?>
                    <a href="/member/dashboard.php" class="btn-nav">
                        Dashboard
                    </a>
                <?php endif; ?>

                <a href="/logout.php" class="btn-nav btn-nav-outline">
                    Keluar
                </a>

            <?php else: ?>

                <a href="/login.php" class="btn-nav btn-nav-outline">
                    Masuk
                </a>

                <a href="/register.php" class="btn-nav btn-nav-primary">
                    Daftar
                </a>

            <?php endif; ?>

        </div>

        <!-- Mobile Menu Button -->
        <button
            type="button"
            class="mobile-menu-toggle"
            id="mobileMenuToggle"
            aria-label="Buka menu navigasi"
            aria-expanded="false"
        >
            <span></span>
            <span></span>
            <span></span>
        </button>

    </nav>
</header>

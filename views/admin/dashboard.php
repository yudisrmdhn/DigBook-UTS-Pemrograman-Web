<?php
// Mengambil data user yang dikirim dari admin/dashboard.php
$viewUser = (isset($user) && is_array($user)) ? $user : [];
?>

<section class="welcome">

    <h2>
        Selamat Datang, <?= e($viewUser['name'] ?? 'Administrator') ?>!
    </h2>

    <p>
        Selamat datang di halaman Dashboard Administrator DigBook.
    </p>

</section>

<section class="profile-card">

    <h3>Informasi Admin</h3>

    <div class="profile-info">

        <p>
            <strong>ID:</strong>
            <?= e($viewUser['id'] ?? '-') ?>
        </p>

        <p>
            <strong>Nama:</strong>
            <?= e($viewUser['name'] ?? '-') ?>
        </p>

        <p>
            <strong>Email:</strong>
            <?= e($viewUser['email'] ?? '-') ?>
        </p>

        <p>
            <strong>Role:</strong>
            <?= e(ucfirst($viewUser['role'] ?? 'admin')) ?>
        </p>

    </div>

</section>

<section class="dashboard-grid">

    <div class="dashboard-card">

        <h3>Manajemen Buku</h3>

        <p>
            Kelola katalog buku digital yang tersedia
            di dalam sistem DigBook.
        </p>

        <a href="books.php">
            Kelola Buku
        </a>

    </div>

    <div class="dashboard-card">

        <h3>Manajemen Transaksi</h3>

        <p>
            Pantau transaksi peminjaman dan pengembalian
            buku oleh Member.
        </p>

        <a href="transactions.php">
            Lihat Transaksi
        </a>

    </div>

</section>

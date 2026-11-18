<?php
// File ini menerima variabel $user dari member/dashboard.php
?>

<section class="auth-container">

    <div class="auth-card">

        <div class="auth-header">
            <h1>DigBook</h1>
            <p>Digital Book Rental & Library Management System</p>
        </div>

        <div class="auth-content">

            <h2>Member Dashboard</h2>

            <p class="subtitle">
                Selamat datang, <?= e($user['name'] ?? 'Member') ?>!
                Selamat menikmati layanan perpustakaan digital DigBook.
            </p>

            <div class="profile-card">
                <h3>Informasi Member</h3>

                <div class="profile-info">
                    <p><strong>ID:</strong> <?= e($user['id'] ?? '-') ?></p>
                    <p><strong>Nama:</strong> <?= e($user['name'] ?? '-') ?></p>
                    <p><strong>Email:</strong> <?= e($user['email'] ?? '-') ?></p>
                    <p><strong>Role:</strong> <?= e(ucfirst($user['role'] ?? 'member')) ?></p>
                </div>
            </div>

            <div class="dashboard-actions">

                <a href="/catalog/index.php" class="btn-primary">
                    Jelajahi Katalog Buku
                </a>

                <a href="/member/history.php" class="dashboard-secondary">
                    Riwayat Peminjaman
                </a>

                <a href="/logout.php" class="dashboard-logout">
                    Logout
                </a>

            </div>

        </div>

    </div>

</section>

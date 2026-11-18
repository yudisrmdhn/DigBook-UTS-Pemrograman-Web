<?php
// File ini menerima variabel $error dan $success dari register.php
?>

<section class="auth-container">
    <div class="auth-card">

        <div class="auth-header">
            <h1>DigBook</h1>
            <p>Digital Book Rental & Library Management System</p>
        </div>

        <div class="auth-content">
            <h2>Create Account</h2>

            <p class="subtitle">
                Daftar untuk mulai menjelajahi dan meminjam koleksi buku digital DigBook.
            </p>

            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <?= e($error) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <?= e($success) ?>

                    <p>
                        <a href="/login.php">Login sekarang</a>
                    </p>
                </div>
            <?php endif; ?>

            <form method="POST" action="/register.php">

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Masukkan nama lengkap"
                        value="<?= e($_POST['name'] ?? '') ?>"
                        autocomplete="name"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Masukkan email"
                        value="<?= e($_POST['email'] ?? '') ?>"
                        autocomplete="email"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        minlength="8"
                        autocomplete="new-password"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="confirm_password">Konfirmasi Password</label>
                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        placeholder="Ulangi password"
                        minlength="8"
                        autocomplete="new-password"
                        required
                    >
                </div>

                <button type="submit" class="btn-primary">
                    Daftar Sekarang
                </button>

            </form>

            <p class="auth-footer">
                Sudah memiliki akun?
                <a href="/login.php">Login sekarang</a>
            </p>

            <a href="/index.php" class="back-link">
                Kembali ke Beranda
            </a>

        </div>

    </div>
</section>

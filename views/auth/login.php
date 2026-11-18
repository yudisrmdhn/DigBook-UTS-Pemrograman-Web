<?php
// File ini menerima variabel $error dari login.php
?>

<section class="auth-container">
    <div class="auth-card">

        <div class="auth-header">
            <h1>DigBook</h1>
            <p>Digital Book Rental & Library Management System</p>
        </div>

        <div class="auth-content">
            <h2>Welcome Back!</h2>

            <p class="subtitle">
                Silakan login untuk melanjutkan.
            </p>

            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <?= e($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="/login.php">
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
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <button type="submit" class="btn-primary">
                    Login
                </button>
            </form>

            <p class="auth-footer">
                Belum memiliki akun?
                <a href="/register.php">Daftar sekarang</a>
            </p>

            <a href="/index.php" class="back-link">
                Kembali ke Beranda
            </a>
        </div>

    </div>
</section>

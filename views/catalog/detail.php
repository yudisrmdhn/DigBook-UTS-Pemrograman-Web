
<?php if ($book !== null): ?>

<!-- Detail Buku -->
<section class="detail-section">
    <div class="container">

        <!-- Breadcrumb -->
        <div class="detail-breadcrumb">
            <a href="/index.php">Beranda</a>
            <span>/</span>
            <a href="/index.php#catalog">Katalog</a>
            <span>/</span>
            <span>Detail Buku</span>
        </div>

        <div class="detail-card">

            <!-- Cover Buku -->
            <div class="detail-cover">
                <img
                    src="/assets/images/books/<?= htmlspecialchars($book['image']) ?>"
                    alt="Cover <?= htmlspecialchars($book['title']) ?>"
                >
            </div>

            <!-- Informasi Buku -->
            <div class="detail-info">

                <span class="detail-category">
                    <?= htmlspecialchars($book['category']) ?>
                </span>

                <h1>
                    <?= htmlspecialchars($book['title']) ?>
                </h1>

                <p class="detail-author">
                    Penulis:
                    <strong>
                        <?= htmlspecialchars($book['author']) ?>
                    </strong>
                </p>

                <div class="detail-divider"></div>

                <h2>Deskripsi Buku</h2>

                <p class="detail-description">
                    <?= htmlspecialchars($book['description']) ?>
                </p>

                <div class="detail-actions">
                    <a href="/index.php#catalog" class="btn-back">
                        ← Kembali ke Katalog
                    </a>

                    <a href="/login.php" class="btn-borrow">
                        Pinjam Buku
                    </a>
                </div>

                <p class="detail-note">
                    Silakan masuk ke akun DigBook untuk melakukan
                    peminjaman buku digital.
                </p>

            </div>

        </div>

    </div>
</section>

<?php else: ?>

<!-- Buku Tidak Ditemukan -->
<section class="detail-section">
    <div class="container">

        <div class="detail-not-found">
            <h1>Buku Tidak Ditemukan</h1>

            <p>
                Maaf, buku yang kamu cari tidak tersedia
                atau mungkin sudah tidak ada dalam katalog.
            </p>

            <a href="/index.php#catalog" class="btn-primary">
                Kembali ke Katalog
            </a>
        </div>

    </div>
</section>

<?php endif; ?>


<?php
$books = [
    [
        'id' => 1,
        'title' => 'Pemrograman Web Modern',
        'category' => 'Programming',
        'author' => 'Tim DigBook',
        'image' => 'book-1.jpg',
        'description' => 'Mempelajari konsep, praktik, dan pengembangan aplikasi web modern.'
    ],
    [
        'id' => 2,
        'title' => 'Algoritma dan Struktur Data',
        'category' => 'Programming',
        'author' => 'Tim DigBook',
        'image' => 'book-2.jpg',
        'description' => 'Memahami algoritma, struktur data, dan penerapannya dalam pemrograman.'
    ],
    [
        'id' => 3,
        'title' => 'Basis Data',
        'category' => 'Database',
        'author' => 'Tim DigBook',
        'image' => 'book-3.jpg',
        'description' => 'Mengenal konsep basis data, SQL, relasi tabel, dan pengelolaan data.'
    ],
    [
        'id' => 4,
        'title' => 'Kecerdasan Buatan',
        'category' => 'Technology',
        'author' => 'Tim DigBook',
        'image' => 'book-4.jpg',
        'description' => 'Mengenal kecerdasan buatan dan penerapannya dalam kehidupan sehari-hari.'
    ],
    [
        'id' => 5,
        'title' => 'Data Science dan Analisis Data',
        'category' => 'Data Science',
        'author' => 'Tim DigBook',
        'image' => 'book-5.jpg',
        'description' => 'Mempelajari pengolahan data, analisis, dan dasar machine learning.'
    ],
    [
        'id' => 6,
        'title' => 'Jaringan Komputer',
        'category' => 'Technology',
        'author' => 'Tim DigBook',
        'image' => 'book-6.jpg',
        'description' => 'Memahami jaringan komputer, perangkat jaringan, dan komunikasi data.'
    ]
];
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container hero-content">

        <div class="hero-text">
            <span class="hero-label">DIGITAL BOOK LIBRARY</span>

            <h1>
                Temukan Dunia Baru
                Melalui <span>Buku Digital.</span>
            </h1>

            <p>
                Jelajahi berbagai koleksi e-book pilihan,
                perluas wawasan, dan nikmati pengalaman
                membaca yang lebih mudah bersama DigBook.
            </p>

            <a href="#catalog" class="btn-primary">
                Jelajahi Katalog
                <span aria-hidden="true">→</span>
            </a>

            <div class="hero-stat">
                <div>
                    <strong><?= count($books) ?>+</strong>
                    <span>Koleksi Buku</span>
                </div>

                <div>
                    <strong>Digital</strong>
                    <span>Akses Praktis</span>
                </div>
            </div>
        </div>

        <div class="hero-image">
            <img
                src="/assets/images/banner.jpg"
                alt="Banner Perpustakaan Digital DigBook"
            >
        </div>

    </div>
</section>

<!-- Catalog Section -->
<section class="catalog-section" id="catalog">
    <div class="container">

        <div class="section-heading">
            <div>
                <span class="section-label">KOLEKSI KAMI</span>
                <h2>Jelajahi Katalog Buku</h2>
                <p>
                    Temukan buku digital sesuai minat dan kebutuhanmu.
                </p>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="catalog-toolbar">

            <div class="search-box">
                <input
                    type="search"
                    id="bookSearch"
                    placeholder="Cari judul atau penulis buku..."
                    aria-label="Cari buku"
                >
                <span aria-hidden="true">⌕</span>
            </div>

            <div class="filter-box">
                <label for="categoryFilter">Kategori:</label>

                <select id="categoryFilter">
                    <option value="all">Semua Kategori</option>
                    <option value="Programming">Programming</option>
                    <option value="Database">Database</option>
                    <option value="Technology">Technology</option>
                    <option value="Data Science">Data Science</option>
                </select>
            </div>

        </div>

        <!-- Book List -->
        <div class="book-grid" id="bookGrid">

            <?php foreach ($books as $book): ?>

                <article
                    class="book-card"
                    data-title="<?= htmlspecialchars(strtolower($book['title'])) ?>"
                    data-author="<?= htmlspecialchars(strtolower($book['author'])) ?>"
                    data-category="<?= htmlspecialchars($book['category']) ?>"
                >

                    <div class="book-cover">
                        <img
                            src="/assets/images/books/<?= htmlspecialchars($book['image']) ?>"
                            alt="Cover <?= htmlspecialchars($book['title']) ?>"
                            loading="lazy"
                        >

                        <span class="book-category">
                            <?= htmlspecialchars($book['category']) ?>
                        </span>
                    </div>

                    <div class="book-info">

                        <h3>
                            <?= htmlspecialchars($book['title']) ?>
                        </h3>

                        <p class="book-author">
                            Oleh <?= htmlspecialchars($book['author']) ?>
                        </p>

                        <p class="book-description">
                            <?= htmlspecialchars($book['description']) ?>
                        </p>

                        <a
                            href="/detail.php?id=<?= (int) $book['id'] ?>"
                            class="btn-detail"
                        >
                            Lihat Detail
                            <span aria-hidden="true">→</span>
                        </a>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

        <p id="emptyMessage" class="empty-message" hidden>
            Buku yang kamu cari tidak ditemukan.
        </p>

    </div>
</section>

<!-- About Section -->
<section class="about-section">
    <div class="container about-content">

        <div class="about-text">
            <span class="section-label">TENTANG DIGBOOK</span>

            <h2>Membaca Lebih Mudah, Belajar Lebih Luas.</h2>

            <p>
                DigBook merupakan platform perpustakaan digital
                yang menyediakan katalog e-book untuk membantu
                pengguna menemukan dan meminjam buku secara praktis.
            </p>

            <p>
                Melalui DigBook, pengguna dapat menjelajahi koleksi,
                melihat informasi buku, serta mengakses layanan
                peminjaman digital.
            </p>
        </div>

    </div>
</section>

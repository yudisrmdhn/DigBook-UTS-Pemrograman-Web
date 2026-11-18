
<?php
session_start();

$pageTitle = 'Detail Buku - DigBook';
$pageDescription = 'Lihat informasi lengkap koleksi buku digital DigBook.';

// Data buku sementara, disamakan dengan katalog
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

// Ambil ID buku dari URL
$bookId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Cari buku berdasarkan ID
$book = null;

foreach ($books as $item) {
    if ($item['id'] === $bookId) {
        $book = $item;
        break;
    }
}

// Jika buku tidak ditemukan
if ($book === null) {
    http_response_code(404);
    $pageTitle = 'Buku Tidak Ditemukan - DigBook';
}

require_once __DIR__ . '/views/layouts/header.php';
require_once __DIR__ . '/views/layouts/navbar.php';
require_once __DIR__ . '/views/catalog/detail.php';
require_once __DIR__ . '/views/layouts/footer.php';

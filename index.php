<?php
session_start();

$pageTitle = 'DigBook - Perpustakaan Digital';
$pageDescription = 'Jelajahi koleksi buku digital dan nikmati layanan perpustakaan DigBook.';

require_once __DIR__ . '/views/layouts/header.php';
require_once __DIR__ . '/views/layouts/navbar.php';
require_once __DIR__ . '/views/catalog/index.php';
require_once __DIR__ . '/views/layouts/footer.php';

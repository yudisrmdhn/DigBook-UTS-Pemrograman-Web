<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/bootstrap.php';

use App\Controllers\AuthController;
use App\Controllers\BookController;

// Memastikan hanya Admin yang dapat mengakses
$auth = new AuthController();
$auth->requireRole('admin');

$bookController = new BookController();

// Membuat token keamanan form
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$message = '';
$messageType = '';

// Mengambil pesan setelah redirect
if (isset($_SESSION['flash_message'])) {
    $message = $_SESSION['flash_message'];
    $messageType = $_SESSION['flash_type'] ?? 'success';

    unset($_SESSION['flash_message'], $_SESSION['flash_type']);
}

// Memproses form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (
            !isset($_POST['csrf_token']) ||
            !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
        ) {
            throw new RuntimeException('Token keamanan tidak valid.');
        }

        $action = $_POST['action'] ?? '';

        if ($action === 'add') {
            $bookController->addBook($_POST);

            $_SESSION['flash_message'] = 'Buku berhasil ditambahkan.';
            $_SESSION['flash_type'] = 'success';
        } elseif ($action === 'update') {
            $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);

            if ($id === false || $id === null) {
                throw new RuntimeException('ID buku tidak valid.');
            }

            if (!$bookController->updateBook($id, $_POST)) {
                throw new RuntimeException('Buku tidak ditemukan.');
            }

            $_SESSION['flash_message'] = 'Data buku berhasil diperbarui.';
            $_SESSION['flash_type'] = 'success';
        } elseif ($action === 'delete') {
            $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);

            if ($id === false || $id === null) {
                throw new RuntimeException('ID buku tidak valid.');
            }

            if (!$bookController->deleteBook($id)) {
                throw new RuntimeException('Buku tidak ditemukan.');
            }

            $_SESSION['flash_message'] = 'Buku berhasil dihapus.';
            $_SESSION['flash_type'] = 'success';
        } else {
            throw new RuntimeException('Aksi tidak dikenal.');
        }

    } catch (Throwable $error) {
        $_SESSION['flash_message'] = $error->getMessage();
        $_SESSION['flash_type'] = 'error';
    }

    header('Location: ' . app_url('admin/books.php'));
    exit;
}

// Mengambil data untuk ditampilkan
$books = $bookController->getAllBooks();

// Mengambil buku yang sedang diedit
$editId = filter_input(INPUT_GET, 'edit', FILTER_VALIDATE_INT);
$editBook = $editId ? $bookController->getBookById($editId) : null;

// Data admin
$user = $auth->getCurrentUser();

// Menampilkan halaman
require_once __DIR__ . '/../views/admin/books.php';

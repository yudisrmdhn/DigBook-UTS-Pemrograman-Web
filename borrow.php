<?php

declare(strict_types=1);

require_once __DIR__ . '/config/bootstrap.php';

use App\Controllers\AuthController;
use App\Controllers\TransactionController;

$auth = new AuthController();
$auth->requireLogin();

$user = $auth->getCurrentUser();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . app_url('index.php'));
    exit;
}

try {
    // Memeriksa token jika token tersedia di session
    if (isset($_SESSION['csrf_token'])) {
        if (
            !isset($_POST['csrf_token']) ||
            !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
        ) {
            throw new RuntimeException('Token keamanan tidak valid.');
        }
    }

    if (($user['role'] ?? '') !== 'member') {
        throw new RuntimeException('Hanya member yang dapat meminjam buku.');
    }

    $bookId = filter_var(
        $_POST['book_id'] ?? null,
        FILTER_VALIDATE_INT
    );

    if ($bookId === false || $bookId === null || $bookId <= 0) {
        throw new RuntimeException('ID buku tidak valid.');
    }

    $controller = new TransactionController();

    $controller->borrowBook(
        $bookId,
        (string) $user['id']
    );

    $_SESSION['flash_message'] = 'Buku berhasil dipinjam.';
    $_SESSION['flash_type'] = 'success';

} catch (Throwable $error) {
    $_SESSION['flash_message'] = $error->getMessage();
    $_SESSION['flash_type'] = 'error';
}

header('Location: ' . app_url('member/history.php'));
exit;

<?php

declare(strict_types=1);

require_once __DIR__ . '/config/bootstrap.php';

use App\Controllers\AuthController;
use App\Controllers\TransactionController;

$auth = new AuthController();
$auth->requireLogin();

$user = $auth->getCurrentUser();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . app_url('member/history.php'));
    exit;
}

try {
    if (isset($_SESSION['csrf_token'])) {
        if (
            !isset($_POST['csrf_token']) ||
            !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
        ) {
            throw new RuntimeException('Token keamanan tidak valid.');
        }
    }

    if (($user['role'] ?? '') !== 'member') {
        throw new RuntimeException('Hanya member yang dapat mengembalikan buku.');
    }

    $transactionId = filter_var(
        $_POST['transaction_id'] ?? null,
        FILTER_VALIDATE_INT
    );

    if (
        $transactionId === false ||
        $transactionId === null ||
        $transactionId <= 0
    ) {
        throw new RuntimeException('ID transaksi tidak valid.');
    }

    $controller = new TransactionController();

    $controller->returnBook(
        $transactionId,
        (string) $user['id']
    );

    $_SESSION['flash_message'] = 'Buku berhasil dikembalikan.';
    $_SESSION['flash_type'] = 'success';

} catch (Throwable $error) {
    $_SESSION['flash_message'] = $error->getMessage();
    $_SESSION['flash_type'] = 'error';
}

header('Location: ' . app_url('member/history.php'));
exit;

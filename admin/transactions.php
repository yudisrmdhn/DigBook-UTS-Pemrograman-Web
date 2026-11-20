<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/bootstrap.php';

use App\Controllers\AuthController;
use App\Controllers\TransactionController;
use App\Services\JsonStorage;

$auth = new AuthController();
$auth->requireRole('admin');

$controller = new TransactionController();

$transactions = $controller->getAllTransactions();

$bookStorage = new JsonStorage('books.json');
$userStorage = new JsonStorage('users.json');

$books = $bookStorage->read();
$users = $userStorage->read();

$bookList = [];
foreach ($books as $book) {
    $bookList[(int) $book['id']] = $book;
}

$userList = [];
foreach ($users as $user) {
    $userList[(string) $user['id']] = $user;
}

$message = $_SESSION['flash_message'] ?? '';
$messageType = $_SESSION['flash_type'] ?? 'success';

unset($_SESSION['flash_message'], $_SESSION['flash_type']);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Transaksi - DigBook</title>

    <link rel="stylesheet" href="../assets/css/transaction.css">
</head>

<body>

<main class="transaction-container">

    <header class="transaction-header">
        <h1>Kelola Transaksi</h1>
        <p>Daftar peminjaman dan pengembalian buku DigBook</p>
    </header>

    <?php if ($message !== ''): ?>
        <div class="notice">
            <?= e((string) $message) ?>
        </div>
    <?php endif; ?>

    <section class="transaction-card">

        <h2>Daftar Transaksi</h2>

        <div class="table-wrapper">

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Member</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (empty($transactions)): ?>

                    <tr>
                        <td colspan="6" class="empty">
                            Belum ada transaksi.
                        </td>
                    </tr>

                <?php else: ?>

                    <?php foreach ($transactions as $index => $transaction): ?>

                        <?php
                        $bookId = (int) $transaction['book_id'];
                        $memberId = (string) $transaction['member_id'];

                        $bookName = $bookList[$bookId]['title'] ?? 'Buku tidak ditemukan';
                        $memberName = $userList[$memberId]['name'] ?? 'Member tidak ditemukan';

                        $status = $transaction['status'] ?? 'borrowed';
                        ?>

                        <tr>
                            <td><?= $index + 1 ?></td>

                            <td><?= e((string) $memberName) ?></td>

                            <td><?= e((string) $bookName) ?></td>

                            <td><?= e((string) $transaction['borrow_date']) ?></td>

                            <td>
                                <?= e((string) ($transaction['return_date'] ?? '-')) ?>
                            </td>

                            <td>
                                <span class="status <?= $status === 'returned' ? 'returned' : 'borrowed' ?>">
                                    <?= $status === 'returned' ? 'Dikembalikan' : 'Dipinjam' ?>
                                </span>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

                </tbody>
            </table>

        </div>

    </section>

    <a href="<?= e(app_url('admin/dashboard.php')) ?>" class="back-link">
        Kembali ke Dashboard
    </a>

</main>

</body>
</html>

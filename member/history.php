<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/bootstrap.php';

use App\Controllers\AuthController;
use App\Controllers\TransactionController;
use App\Services\JsonStorage;

$auth = new AuthController();
$auth->requireRole('member');

$user = $auth->getCurrentUser();

// Membuat token keamanan
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Mengambil pesan notifikasi
$message = $_SESSION['flash_message'] ?? '';
$messageType = $_SESSION['flash_type'] ?? 'success';

unset($_SESSION['flash_message'], $_SESSION['flash_type']);

// Mengambil transaksi milik member
$transactionController = new TransactionController();

$transactions = $transactionController->getTransactionsByMember(
    (string) $user['id']
);

// Mengambil data buku
$bookStorage = new JsonStorage('books.json');
$books = $bookStorage->read();

// Membuat daftar buku berdasarkan ID
$bookList = [];

foreach ($books as $book) {
    $bookList[(int) $book['id']] = $book;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Riwayat Peminjaman - DigBook</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 25px;
            font-family: Arial, sans-serif;
            background: #f4f6fb;
            color: #263238;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .header {
            background: #243b64;
            color: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .header h2 {
            margin-top: 0;
        }

        .card {
            background: white;
            padding: 22px;
            border-radius: 10px;
            box-shadow: 0 3px 12px #0000000d;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        th, td {
            padding: 14px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background: #eef2f8;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 5px;
            font-size: 12px;
        }

        .borrowed {
            background: #fff0c2;
            color: #8a6200;
        }

        .returned {
            background: #d9f5df;
            color: #18753b;
        }

        .btn {
            padding: 9px 13px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            background: #315da8;
        }

        .back {
            display: inline-block;
            margin-bottom: 18px;
            color: #315da8;
            text-decoration: none;
        }

        .message {
            padding: 13px;
            margin-bottom: 15px;
            border-radius: 6px;
        }

        .success {
            background: #d9f5df;
            color: #18753b;
        }

        .error {
            background: #ffe0e0;
            color: #a32626;
        }

        .empty {
            padding: 25px;
            text-align: center;
            color: #777;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <h2>Riwayat Peminjaman</h2>
        <p>Halo, <?= e((string) $user['name']) ?>!</p>
        <p>Lihat daftar buku yang pernah kamu pinjam.</p>
    </div>

    <a href="<?= e(app_url('member/dashboard.php')) ?>" class="back">
        &larr; Kembali ke Dashboard
    </a>

    <?php if ($message !== ''): ?>
        <div class="message <?= $messageType === 'error' ? 'error' : 'success' ?>">
            <?= e((string) $message) ?>
        </div>
    <?php endif; ?>

    <div class="card">

        <h3>Daftar Transaksi Buku</h3>

        <?php if (empty($transactions)): ?>

            <div class="empty">
                <p>Kamu belum memiliki riwayat peminjaman buku.</p>
            </div>

        <?php else: ?>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php foreach ($transactions as $index => $transaction): ?>

                    <?php
                    $bookId = (int) $transaction['book_id'];
                    $book = $bookList[$bookId] ?? null;

                    $title = $book['title'] ?? 'Buku tidak ditemukan';
                    $status = $transaction['status'] ?? 'borrowed';
                    ?>

                    <tr>
                        <td><?= $index + 1 ?></td>

                        <td><?= e((string) $title) ?></td>

                        <td>
                            <?= e((string) $transaction['borrow_date']) ?>
                        </td>

                        <td>
                            <?= e((string) ($transaction['return_date'] ?? '-')) ?>
                        </td>

                        <td>
                            <span class="status <?= $status === 'returned' ? 'returned' : 'borrowed' ?>">
                                <?= $status === 'returned' ? 'Dikembalikan' : 'Dipinjam' ?>
                            </span>
                        </td>

                        <td>
                            <?php if ($status === 'borrowed'): ?>

                                <form
                                    method="POST"
                                    action="<?= e(app_url('return.php')) ?>"
                                    onsubmit="return confirm('Yakin ingin mengembalikan buku ini?')"
                                >

                                    <input
                                        type="hidden"
                                        name="transaction_id"
                                        value="<?= (int) $transaction['id'] ?>"
                                    >

                                    <input
                                        type="hidden"
                                        name="csrf_token"
                                        value="<?= e($_SESSION['csrf_token']) ?>"
                                    >

                                    <button type="submit" class="btn">
                                        Kembalikan
                                    </button>

                                </form>

                            <?php else: ?>

                                <span>-</span>

                            <?php endif; ?>
                        </td>
                    </tr>

                <?php endforeach; ?>

                </tbody>
            </table>

        <?php endif; ?>

    </div>

</div>

</body>
</html>

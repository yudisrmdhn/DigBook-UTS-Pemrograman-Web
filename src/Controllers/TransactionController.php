<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Transaction;
use App\Services\JsonStorage;
use RuntimeException;

class TransactionController
{
    private JsonStorage $transactionStorage;
    private JsonStorage $bookStorage;

    public function __construct()
    {
        $this->transactionStorage = new JsonStorage('transactions.json');
        $this->bookStorage = new JsonStorage('books.json');
    }

    // Mengambil seluruh transaksi
    public function getAllTransactions(): array
    {
        return $this->transactionStorage->read();
    }

    // Mengambil transaksi berdasarkan ID
    public function getTransactionById(int $id): ?array
    {
        foreach ($this->getAllTransactions() as $transaction) {
            if ((int) $transaction['id'] === $id) {
                return $transaction;
            }
        }

        return null;
    }

    // Mengambil riwayat transaksi milik member
    public function getTransactionsByMember(string $memberId): array
    {
        $transactions = $this->getAllTransactions();

        return array_values(array_filter(
            $transactions,
            fn(array $transaction): bool =>
                (string) $transaction['member_id'] === $memberId
        ));
    }

    // Meminjam buku
    public function borrowBook(int $bookId, string $memberId): bool
    {
        $books = $this->bookStorage->read();
        $transactions = $this->transactionStorage->read();

        $bookIndex = null;

        foreach ($books as $index => $book) {
            if ((int) $book['id'] === $bookId) {
                $bookIndex = $index;
                break;
            }
        }

        if ($bookIndex === null) {
            throw new RuntimeException('Buku tidak ditemukan.');
        }

        if ((int) $books[$bookIndex]['stock'] <= 0) {
            throw new RuntimeException('Stok buku sedang habis.');
        }

        // Membuat ID transaksi otomatis
        $newId = 1;

        foreach ($transactions as $transaction) {
            $newId = max($newId, (int) $transaction['id'] + 1);
        }

        $transaction = new Transaction(
            $newId,
            $bookId,
            $memberId,
            date('Y-m-d')
        );

        // Mengurangi stok buku
        $books[$bookIndex]['stock']--;

        $transactions[] = $transaction->toArray();

        // Simpan perubahan stok
        if (!$this->bookStorage->write($books)) {
            throw new RuntimeException('Gagal memperbarui stok buku.');
        }

        // Simpan transaksi
        if (!$this->transactionStorage->write($transactions)) {
            // Mengembalikan stok jika penyimpanan transaksi gagal
            $books[$bookIndex]['stock']++;
            $this->bookStorage->write($books);

            throw new RuntimeException('Gagal menyimpan transaksi.');
        }

        return true;
    }

    // Mengembalikan buku
    public function returnBook(int $transactionId, string $memberId): bool
    {
        $transactions = $this->transactionStorage->read();
        $books = $this->bookStorage->read();

        $transactionIndex = null;

        foreach ($transactions as $index => $transaction) {
            if (
                (int) $transaction['id'] === $transactionId &&
                (string) $transaction['member_id'] === $memberId
            ) {
                $transactionIndex = $index;
                break;
            }
        }

        if ($transactionIndex === null) {
            throw new RuntimeException('Transaksi tidak ditemukan.');
        }

        if ($transactions[$transactionIndex]['status'] !== 'borrowed') {
            throw new RuntimeException('Buku sudah dikembalikan.');
        }

        $bookId = (int) $transactions[$transactionIndex]['book_id'];
        $bookIndex = null;

        foreach ($books as $index => $book) {
            if ((int) $book['id'] === $bookId) {
                $bookIndex = $index;
                break;
            }
        }

        if ($bookIndex === null) {
            throw new RuntimeException('Data buku tidak ditemukan.');
        }

        // Mengubah status transaksi
        $transactionObject = new Transaction(
            (int) $transactions[$transactionIndex]['id'],
            (int) $transactions[$transactionIndex]['book_id'],
            (string) $transactions[$transactionIndex]['member_id'],
            (string) $transactions[$transactionIndex]['borrow_date'],
            $transactions[$transactionIndex]['return_date'] ?? null,
            (string) $transactions[$transactionIndex]['status']
        );

        $transactionObject->returnBook();

        $transactions[$transactionIndex] = $transactionObject->toArray();

        // Menambah stok buku
        $books[$bookIndex]['stock']++;

        if (!$this->bookStorage->write($books)) {
            throw new RuntimeException('Gagal memperbarui stok buku.');
        }

        if (!$this->transactionStorage->write($transactions)) {
            // Kembalikan stok jika transaksi gagal disimpan
            $books[$bookIndex]['stock']--;
            $this->bookStorage->write($books);

            throw new RuntimeException('Gagal menyimpan pengembalian.');
        }

        return true;
    }
}

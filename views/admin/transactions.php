<section class="transaction-container">

    <div class="transaction-header">
        <h1>Kelola Transaksi</h1>
        <p>Daftar peminjaman dan pengembalian buku DigBook.</p>
    </div>

    <div class="transaction-card">
        <h2>Data Transaksi Member</h2>

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

                        $book = $bookList[$bookId] ?? null;
                        $member = $userList[$memberId] ?? null;

                        $status = $transaction['status'] ?? 'borrowed';
                        ?>

                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= e((string) ($member['name'] ?? 'Member tidak ditemukan')) ?></td>
                            <td><?= e((string) ($book['title'] ?? 'Buku tidak ditemukan')) ?></td>
                            <td><?= e((string) $transaction['borrow_date']) ?></td>
                            <td><?= e((string) ($transaction['return_date'] ?? '-')) ?></td>
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
    </div>

</section>

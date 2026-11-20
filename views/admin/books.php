<?php

$bookForm = (isset($editBook) && is_array($editBook))
    ? $editBook
    : [];

$editing = !empty($bookForm);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Buku - DigBook</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            margin: 0;
            padding: 30px;
            color: #252525;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            margin-bottom: 24px;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
        }

        h1, h2 {
            margin-top: 0;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        input, textarea {
            padding: 11px;
            border: 1px solid #ddd;
            border-radius: 7px;
            font-size: 14px;
        }

        textarea {
            resize: vertical;
        }

        button, .btn {
            display: inline-block;
            border: none;
            border-radius: 7px;
            padding: 10px 15px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .primary {
            background: #2563eb;
            color: white;
        }

        .secondary {
            background: #e5e7eb;
            color: #222;
        }

        .danger {
            background: #dc2626;
            color: white;
        }

        .success-message {
            background: #dcfce7;
            color: #166534;
            padding: 13px;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        .error-message {
            background: #fee2e2;
            color: #991b1b;
            padding: 13px;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th, td {
            padding: 13px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background: #f8fafc;
        }

        .actions {
            display: flex;
            gap: 7px;
            align-items: center;
        }

        .actions form {
            margin: 0;
        }

        @media (max-width: 650px) {
            body {
                padding: 15px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Manajemen Buku DigBook</h1>

    <p>
        Selamat datang,
        <strong><?= e((string) ($user['name'] ?? 'Admin')) ?></strong>.
    </p>

    <?php if ($message !== ''): ?>
        <div class="<?= $messageType === 'error'
            ? 'error-message'
            : 'success-message' ?>">
            <?= e($message) ?>
        </div>
    <?php endif; ?>

    <!-- Form Tambah dan Edit Buku -->
    <section class="card">

        <h2><?= $editing ? 'Edit Buku' : 'Tambah Buku Baru' ?></h2>

        <form method="POST" action="<?= e(app_url('admin/books.php')) ?>">

            <input
                type="hidden"
                name="csrf_token"
                value="<?= e($_SESSION['csrf_token']) ?>"
            >

            <input
                type="hidden"
                name="action"
                value="<?= $editing ? 'update' : 'add' ?>"
            >

            <?php if ($editing): ?>
                <input
                    type="hidden"
                    name="id"
                    value="<?= (int) $bookForm['id'] ?>"
                >
            <?php endif; ?>

            <div class="form-grid">

                <div class="form-group">
                    <label>Judul Buku</label>
                    <input
                        type="text"
                        name="title"
                        value="<?= e((string) ($bookForm['title'] ?? '')) ?>"
                        placeholder="Masukkan judul buku"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Penulis</label>
                    <input
                        type="text"
                        name="author"
                        value="<?= e((string) ($bookForm['author'] ?? '')) ?>"
                        placeholder="Nama penulis"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <input
                        type="text"
                        name="category"
                        value="<?= e((string) ($bookForm['category'] ?? '')) ?>"
                        placeholder="Contoh: Programming"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Stok Buku</label>
                    <input
                        type="number"
                        name="stock"
                        min="0"
                        value="<?= e((string) ($bookForm['stock'] ?? 0)) ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Nama File Gambar</label>
                    <input
                        type="text"
                        name="image"
                        value="<?= e((string) ($bookForm['image'] ?? '')) ?>"
                        placeholder="Contoh: book-1.jpg"
                    >
                </div>

                <div class="form-group">
                    <label>Deskripsi Buku</label>
                    <textarea
                        name="description"
                        rows="3"
                        placeholder="Deskripsi buku"
                    ><?= e((string) ($editBook['description'] ?? '')) ?></textarea>
                </div>

            </div>

            <br>

            <button type="submit" class="primary">
                <?= $editing ? 'Simpan Perubahan' : 'Tambah Buku' ?>
            </button>

            <?php if ($editing): ?>
                <a
                    href="<?= e(app_url('admin/books.php')) ?>"
                    class="btn secondary"
                >
                    Batal
                </a>
            <?php endif; ?>

        </form>

    </section>

    <!-- Tabel Daftar Buku -->
    <section class="card">

        <h2>Daftar Koleksi Buku</h2>

        <div class="table-wrapper">

            <table>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (empty($books)): ?>

                        <tr>
                            <td colspan="6">Belum ada data buku.</td>
                        </tr>

                    <?php else: ?>

                        <?php foreach ($books as $book): ?>

                            <tr>
                                <td><?= (int) $book['id'] ?></td>

                                <td>
                                    <?= e((string) $book['title']) ?>
                                </td>

                                <td>
                                    <?= e((string) $book['author']) ?>
                                </td>

                                <td>
                                    <?= e((string) $book['category']) ?>
                                </td>

                                <td><?= (int) $book['stock'] ?></td>

                                <td>
                                    <div class="actions">

                                        <a
                                            class="btn secondary"
                                            href="<?= e(app_url(
                                                'admin/books.php?edit=' . (int) $book['id']
                                            )) ?>"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="<?= e(app_url('admin/books.php')) ?>"
                                            onsubmit="return confirm('Yakin ingin menghapus buku ini?')"
                                        >
                                            <input
                                                type="hidden"
                                                name="csrf_token"
                                                value="<?= e($_SESSION['csrf_token']) ?>"
                                            >

                                            <input
                                                type="hidden"
                                                name="action"
                                                value="delete"
                                            >

                                            <input
                                                type="hidden"
                                                name="id"
                                                value="<?= (int) $book['id'] ?>"
                                            >

                                            <button type="submit" class="danger">
                                                Hapus
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </section>

    <a href="<?= e(app_url('admin/dashboard.php')) ?>" class="btn secondary">
        Kembali ke Dashboard
    </a>

</div>

</body>
</html>

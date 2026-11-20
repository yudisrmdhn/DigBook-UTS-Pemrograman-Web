<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\JsonStorage;
use InvalidArgumentException;

class BookController
{
    private JsonStorage $storage;

    public function __construct()
    {
        $this->storage = new JsonStorage('books.json');
    }

    // Mengambil seluruh data buku
    public function getAllBooks(): array
    {
        return $this->storage->read();
    }

    // Mencari buku berdasarkan ID
    public function getBookById(int $id): ?array
    {
        foreach ($this->getAllBooks() as $book) {
            if ((int) $book['id'] === $id) {
                return $book;
            }
        }

        return null;
    }

    // Menambahkan buku baru
    public function addBook(array $data): bool
    {
        $books = $this->getAllBooks();

        $title = trim($data['title'] ?? '');
        $author = trim($data['author'] ?? '');
        $category = trim($data['category'] ?? '');
        $description = trim($data['description'] ?? '');
        $image = trim($data['image'] ?? '');
        $stock = filter_var(
            $data['stock'] ?? null,
            FILTER_VALIDATE_INT
        );

        if ($title === '' || $author === '' || $category === '') {
            throw new InvalidArgumentException(
                'Judul, penulis, dan kategori wajib diisi.'
            );
        }

        if ($stock === false || $stock < 0) {
            throw new InvalidArgumentException(
                'Stok harus berupa angka minimal 0.'
            );
        }

        // Membuat ID otomatis
        $newId = 1;

        foreach ($books as $book) {
            $newId = max($newId, (int) $book['id'] + 1);
        }

        $newBook = [
            'id' => $newId,
            'title' => $title,
            'author' => $author,
            'category' => $category,
            'description' => $description,
            'image' => $image,
            'stock' => $stock
        ];

        $books[] = $newBook;

        return $this->storage->write($books);
    }

    // Mengubah data buku
    public function updateBook(int $id, array $data): bool
    {
        $books = $this->getAllBooks();
        $found = false;

        foreach ($books as &$book) {
            if ((int) $book['id'] !== $id) {
                continue;
            }

            $title = trim($data['title'] ?? $book['title']);
            $author = trim($data['author'] ?? $book['author']);
            $category = trim($data['category'] ?? $book['category']);

            $stock = filter_var(
                $data['stock'] ?? $book['stock'],
                FILTER_VALIDATE_INT
            );

            if ($title === '' || $author === '' || $category === '') {
                unset($book);

                throw new InvalidArgumentException(
                    'Judul, penulis, dan kategori wajib diisi.'
                );
            }

            if ($stock === false || $stock < 0) {
                unset($book);

                throw new InvalidArgumentException(
                    'Stok harus berupa angka minimal 0.'
                );
            }

            $book['title'] = $title;
            $book['author'] = $author;
            $book['category'] = $category;
            $book['description'] = trim(
                $data['description'] ?? $book['description'] ?? ''
            );
            $book['image'] = trim(
                $data['image'] ?? $book['image'] ?? ''
            );
            $book['stock'] = $stock;

            $found = true;
            break;
        }

        unset($book);

        if (!$found) {
            return false;
        }

        return $this->storage->write($books);
    }

    // Menghapus buku
    public function deleteBook(int $id): bool
    {
        $books = $this->getAllBooks();

        $filteredBooks = array_filter(
            $books,
            fn(array $book): bool => (int) $book['id'] !== $id
        );

        if (count($filteredBooks) === count($books)) {
            return false;
        }

        return $this->storage->write(
            array_values($filteredBooks)
        );
    }
}

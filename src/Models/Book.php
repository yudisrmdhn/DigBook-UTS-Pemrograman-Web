<?php

declare(strict_types=1);

namespace App\Models;

class Book
{
    private int $id;
    private string $title;
    private string $author;
    private string $category;
    private int $stock;

    public function __construct(
        int $id,
        string $title,
        string $author,
        string $category,
        int $stock
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->category = $category;
        $this->stock = $stock;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function reduceStock(): bool
    {
        if ($this->stock <= 0) {
            return false;
        }

        $this->stock--;
        return true;
    }

    public function increaseStock(): void
    {
        $this->stock++;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'category' => $this->category,
            'stock' => $this->stock
        ];
    }
}

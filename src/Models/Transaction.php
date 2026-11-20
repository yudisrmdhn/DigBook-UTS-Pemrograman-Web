<?php

declare(strict_types=1);

namespace App\Models;

class Transaction
{
    private int $id;
    private int $bookId;
    private string $memberId;
    private string $borrowDate;
    private ?string $returnDate;
    private string $status;

    public function __construct(
        int $id,
        int $bookId,
        string $memberId,
        string $borrowDate,
        ?string $returnDate = null,
        string $status = 'borrowed'
    ) {
        $this->id = $id;
        $this->bookId = $bookId;
        $this->memberId = $memberId;
        $this->borrowDate = $borrowDate;
        $this->returnDate = $returnDate;
        $this->status = $status;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBookId(): int
    {
        return $this->bookId;
    }

    public function getMemberId(): string
    {
        return $this->memberId;
    }

    public function getBorrowDate(): string
    {
        return $this->borrowDate;
    }

    public function getReturnDate(): ?string
    {
        return $this->returnDate;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function returnBook(): void
    {
        $this->returnDate = date('Y-m-d');
        $this->status = 'returned';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'book_id' => $this->bookId,
            'member_id' => $this->memberId,
            'borrow_date' => $this->borrowDate,
            'return_date' => $this->returnDate,
            'status' => $this->status
        ];
    }
}

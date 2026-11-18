<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Class Member
 *
 * Class Member mewarisi User.
 * Digunakan untuk pengguna biasa DigBook.
 */
class Member extends User
{
    public function __construct(
        string $id,
        string $name,
        string $email,
        string $passwordHash,
        ?string $createdAt = null
    ) {
        parent::__construct(
            $id,
            $name,
            $email,
            $passwordHash,
            $createdAt
        );
    }

    /**
     * Menentukan role sebagai Member.
     */
    public function getRole(): string
    {
        return 'member';
    }

    /**
     * Mendapatkan path dashboard Member.
     */
    public function getDashboardPath(): string
    {
        return 'member/dashboard.php';
    }
}
